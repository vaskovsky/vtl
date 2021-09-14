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
		this.isLocal = "file:" == location.protocol;
		this.servicePrefix = "";
		this.serviceSuffix = ".php";
		this.defaults = {};
		this.queryString = location.hash? location.hash.substring(1): "";
		this.server = "";
		const serverLink = document.getElementById("server");
		if(serverLink)
		{
			this.server = serverLink.getAttribute("href");
			if(this.server && !/\/$/.test(this.server)) this.server += "/";
		}
		if(this.queryString)
			window.addEventListener("DOMContentLoaded", event =>
			{
				const list = document.querySelectorAll(
					"#if-no-query-string, .if-no-query-string");
				for(const element of list) element.style.display = "none";
			});
		console.log("server:", this.server || location.origin);
		console.log("query:", this.queryString);
	}
	setDefault(tagName, attributes)
	{
		this.defaults[tagName] = attributes;
	}
	getServiceURL(service)
	{
		return this.server + this.servicePrefix + service + this.serviceSuffix +
			"?" + this.queryString;
	}
	fetch(service, init)
	{
		return new Promise(resolve =>
		{
			const url = this.getServiceURL(service);
			window.fetch(url, init)
			.then(response =>
			{
				if(ok) resolve(response);
				else
				{
					const message = response.statusText || response.status;
					VTL.error("HTTP", message, url);
				}
			})
			.catch(ex =>
			{
				VTL.error("fetch", ex.message, url);
			});
		});
	}
	async get(service)
	{
		if(this.isLocal)
		{
			console.log("get:", service, "(local)");
			const stub = document.getElementById(service + "_data");
			if(stub) return stub.innerHTML;
			else throw new Error("no "+service + "_data @" + location.pathname);
		}
		else
		{
			console.log("get:", service);
			const response = await this.fetch(service);
			return response.text();
		}
	}
	async getJSON(service)
	{
		return JSON.parse(await this.get(service));
	}
	async getXML(service)
	{
		if("string" === typeof service)
		{
			const xml = await this.get(service);
			return this.parseXML(xml);
		}
		else if(service instanceof Element)
			return service;
		else throw new Error("getXML: invalid argument: " +
			typeof id + ": " + JSON.stringify(id));
	}
	async post(service, data)
	{
		console.log("post:", service, data);
		if(this.isLocal) return null;
		const response = await this.fetch(service,
		{
			method: "POST",
			cache: "no-cache",
			body: data
		});
		return response.text();
	}
	registerService(service)
	{
		return new Promise(async resolve =>
		{
			const form = document.getElementById(service);
			if(form)
			{
				if(!this.isLocal && "FORM" == form.tagName)
				{
					form.addEventListener("submit", async event =>
					{
						event.preventDefault();
						const data = new FormData(form);
						const href = await VTL.post(service, data);
						location.href = href;						
					});
				}
				const fileinput = document.getElementById(service+"_fileinput");
				if(fileinput)
					fileinput.addEventListener("input", async event =>
					{
						console.log("get:", service, "(file)");
						event.preventDefault();
						const data = await VTL.readFile(fileinput);
						if(data)
						{
							const dataXML = this.parseXML(data);
							VTL._renderForm(form, service, dataXML);
							resolve(form);
						}
					});
				const xml = await VTL.getXML(service);
				VTL._renderForm(form, service, xml);
				resolve(form);
			}
		});		
	}
	_renderForm(form, tagName, xml)
	{
		const elementList = xml.getElementsByTagName(tagName);
		let html = "";
		for(const element of elementList)
			html += VTL.renderElement(element);
		form.innerHTML = html;
		const datalistCollection = xml.getElementsByTagName("datalist");
		for(const datalist of datalistCollection)
		{
			datalistId = datalist.getAttribute("id");
			if(datalistId)
			{
				datalistOutput = document.getElementById(datalistId);
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
			variables[attribute.name] = attribute.value;
		for(const attribute of element.attributes)
			variables[attribute.name] = attribute.value;
		for(const child of element.children)
		{
			if(variables[child.tagName])
				variables[child.tagName] +=
					this.renderElement(child);
			else
				variables[child.tagName] =
					this.renderElement(child);
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
	parseXML(xml)
	{
		return this._parser.parseFromString(xml, "application/xml");
	}
	stringifyXML(dom)
	{
		return this._serializer.serializeToString(dom);
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
		console.error(text);
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
