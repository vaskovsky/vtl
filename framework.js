/*! Copyright © 2021 Alexey Vaskovsky. Released under the MIT license */
const VTL = new class
{
	constructor()
	{
		if(!window.fetch)
			this.error("Unsupported", "Fetch API", navigator.userAgent);
		if(!window.XMLSerializer)
			this.error("Unsupported", "XMLSerializer", navigator.userAgent);
		if(!window.DOMParser)
			this.error("Unsupported", "DOMParser", navigator.userAgent);
		if(!window.FileReader)
			this.error("Unsupported", "FileReader", navigator.userAgent);
		this._parser = new DOMParser;
		this._serializer = new XMLSerializer;
		this._reader = new FileReader;
		this.defaults = {};
		this.serverAPI = "*.php";
		this.server = "";
		const serverLink = document.getElementById("server");
		if(serverLink)
		{
			this.server = serverLink.getAttribute("href");
			if(this.server && !/\/$/.test(this.server)) this.server += "/";
		}
		this.isLocal = "file:" == location.protocol && "" == this.server;
		this.queryString = location.hash? location.hash.substring(1): "";
		this.ready(this.updateQueryString);
		console.log("server:", this.server || location.origin);
		console.log("query:", this.queryString);
	}
	ready(eventListener)
	{
		const isReady = "loading" !== document.readyState;
		if(eventListener)
		{
			window.addEventListener("hashchange", eventListener);
			if(isReady)
				eventListener(null);
			else
				window.addEventListener("DOMContentLoaded", eventListener);
		}
		return isReady;
	}
	updateQueryString()
	{
		VTL.queryString = location.hash? location.hash.substring(1): "";
		const list = document.querySelectorAll(
			"#if-no-query-string, .if-no-query-string");
		for(const element of list)
			element.style.display = VTL.queryString?"none":"block";
	}
	setDefaults(entity, attributes)
	{
		this.defaults[entity] = attributes;
	}
	fetch(entity, init)
	{
		return new Promise(resolve =>
		{
			const url = this.server + this.serverAPI.replace("*", entity) +
				"?" + this.queryString;
			window.fetch(url, init)
			.then(async response =>
			{
				if(response.ok) resolve(response);
				else if(401 == response.status)
				{
					const href = await response.text();
					location.href = href +
						"#return=" + encodeURIComponent(location.href);
				}
				else
				{
					const message = await response.text();
					VTL.error("HTTP" + response.status, message, url);
				}
			})
			.catch(ex =>
			{
				VTL.error("fetch", ex.message, url);
			});
		});
	}
	async get(entity)
	{
		if(this.isLocal)
		{
			console.log("get", entity, "(local)");
			let stub = document.getElementById(entity + "_data#" +
				this.queryString);
			if(!stub)
				stub = document.getElementById(entity + "_data");
			if(!stub)
				throw new Error("no "+ entity + "_data @" +
					location.pathname);
			return stub.innerHTML;
		}
		else
		{
			console.log("get", entity);
			const response = await this.fetch(entity);
			return response.text();
		}
	}
	async getJSON(entity)
	{
		return JSON.parse(await this.get(entity));
	}
	async getXML(entity)
	{
		return this.parseXML(await this.get(entity));
	}
	async post(entity, data)
	{
		console.log("post", entity, data);
		if(this.isLocal) return null;
		const response = await this.fetch(entity,
		{
			method: "POST",
			cache: "no-cache",
			body: data
		});
		return response.text();
	}
	addSubmitListener(form, entity)
	{
		form.addEventListener("submit", async event =>
		{
			event.preventDefault();
			const error = document.getElementById("error");
			if(error) error.textContent = "";
			const data = new FormData(form);
			const href = await VTL.post(entity, data);
			location.href = href;						
		});
	}
	createForm(entity)
	{
		return new Promise(async resolve =>
		{
			const form = document.getElementById(entity);
			if(form)
			{
				if(!this.isLocal && "FORM" == form.tagName)
				{
					VTL.addSubmitListener(form, entity);
					resolve(await this.get(entity));
				}				
			}		
		});
	}
	createView(entity, defaults)
	{
		if(defaults) this.setDefaults(entity, defaults);
		return new Promise(async resolve =>
		{
			const output = document.getElementById(entity);
			if(output)
			{
				if(!this.isLocal && "FORM" == output.tagName)
					VTL.addSubmitListener(output, entity);
				const fileinput = document.getElementById(
					entity + "_fileinput");
				if(fileinput)
					fileinput.addEventListener("input", async event =>
					{
						console.log("get:", entity, "(file)");
						event.preventDefault();
						const data = await VTL.readFile(fileinput);
						if(data)
						{
							const dataXML = this.parseXML(data);
							output.innerHTML = VTL.renderView(entity, dataXML);
							VTL.updateDataList(dataXML);
							resolve(output);
						}
					});
				this.ready(async () => 
				{
					const xml = await VTL.getXML(entity);
					output.innerHTML = VTL.renderView(entity, xml);
					VTL.updateDataList(xml);
					const btnCancelList = document.querySelectorAll(
						"#btn-cancel, .btn-cancel");
					for(let btnCancel of btnCancelList)
					{
						btnCancel.addEventListener("click", event =>
						{
							event.preventDefault();
							history.back();
						});
					}
					resolve(output);
				});
			}
		});	
	}
	updateView(entity)
	{
		return new Promise(async resolve =>
		{
			const output = document.getElementById(entity);
			if(output)
			{
				const xml = await VTL.getXML(entity);
				output.innerHTML = VTL.renderView(entity, xml);
				VTL.updateDataList(xml);
				resolve(output);
			}			
		});
	}
	renderView(entity, dataXML)
	{
		const elementList = dataXML.getElementsByTagName(entity);
		let html = "";
		for(const element of elementList)
			html += VTL.renderElement(element);
		if("" == html)
		{
			const no_data_view = document.getElementById(
				"no_" + entity + "_view");
			if(no_data_view) html = no_data_view.innerHTML;
		}
		return html;
	}
	updateDataList(dataXML)
	{
		const datalistCollection = dataXML.getElementsByTagName("datalist");
		for(const datalist of datalistCollection)
		{
			const datalistId = datalist.getAttribute("id");
			if(datalistId)
			{
				const datalistOutput = document.getElementById(datalistId);
				if(datalistOutput)
					datalistOutput.innerHTML =
						this.stringifyInnerXML(datalist);
				else
					document.getElementsByTagName("body")[0]
						.insertAdjacentHTML("beforeEnd",
							this.stringifyXML(datalist));
			}
		}
	}
	renderElement(element)
	{
		const view = document.getElementById(element.tagName + "_view");
		if(!view) return this.stringifyInnerXML(element);
		const variables = {};
		variables["content"] = this.stringifyInnerXML(element);
		if(this.defaults[element.tagName])
		for(const attribute in this.defaults[element.tagName])
			variables[attribute] = this.defaults[element.tagName][attribute];
		for(const attribute of element.parentElement.attributes)
			variables[attribute.name] = this.escapeHTML(attribute.value);
		for(const attribute of element.attributes)
			variables[attribute.name] = this.escapeHTML(attribute.value);
		for(const child of element.children)
		{
			if(variables[child.tagName])
				variables[child.tagName] += this.renderElement(child);
			else
				variables[child.tagName] = this.renderElement(child);
		}
		let html = view.innerHTML;
		html = html.replace(/\$([A-Za-z0-9_\-]+)/g,
			(str, varname) =>
				undefined !== variables[varname]?
					variables[varname]: "$" + varname);				
		html = html.replace(VTL.FALSE_HTML_ATTRIBUTES, "");
		return html;
	}
	readFile(input)
	{
		return new Promise((resolve, reject) =>
		{
			try
			{
				this._reader.onload = event => {resolve(event.target.result)};
				this._reader.readAsText(input.files[0], "UTF-8");
			}
			catch(ex)
			{
				reject(ex);
			}
		});
	}
	escapeHTML(str)
	{
		return str.replace(/["'&<>]/g, ch => "&#" + ch.charCodeAt(0) + ";");
	}
	parseXML(xml)
	{
		return this._parser.parseFromString(xml, "application/xml");
	}
	stringifyXML(element)
	{
		return this._serializer.serializeToString(element);
	}
	stringifyInnerXML(element)
	{
		let xml = "";
		for(const child of element.childNodes)
			xml += this.stringifyXML(child);
		return xml;
	}
	error(type, message, at)
	{
		const text = `${type}: ${message}\n@${at}`;
		const error = document.getElementById("error");
		console.error(text);
		if(error) error.textContent = message;
		else alert(message);
	}
};
VTL.FALSE_HTML_ATTRIBUTES =new RegExp('('+
[
	"allowfullscreen",
	"allowpaymentrequest",
	"async",
	"autofocus",
	"autoplay",
	"checked",
	"controls",
	"default",
	"defer",
	"disabled",
	"formnovalidate",
	"hidden",
	"ismap",
	"itemscope",
	"loop",
	"multiple",
	"muted",
	"nomodule",
	"novalidate",
	"open",
	"playsinline",
	"readonly",
	"required",
	"reversed",
	"selected",
	"truespeed"
].join("|")+')="(false|no|off|0)?"', "gi");
//export {VTL, VTL as default};
