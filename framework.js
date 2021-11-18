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
	fetch(component_id, init)
	{
		return new Promise(resolve =>
		{
			const url = VTL.server + 
				VTL.serverAPI.replace("*", component_id) +
				"?" + VTL.queryString;
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
	async get(component_id)
	{
		if(VTL.isLocal)
		{
			console.log("get", component_id, "(local)");
			let stub = document.getElementById(component_id + "_data#" +
				VTL.queryString);
			if(!stub)
				stub = document.getElementById(component_id + "_data");
			if(!stub)
				throw new Error("no "+ component_id + "_data @" +
					location.pathname);
			return stub.innerHTML;
		}
		else
		{
			console.log("get", component_id);
			const response = await VTL.fetch(component_id);
			return response.text();
		}
	}
	async getJSON(component_id)
	{
		return JSON.parse(await VTL.get(component_id));
	}
	async getXML(component_id)
	{
		return VTL.parseXML(await VTL.get(component_id));
	}
	async post(component_id, data)
	{
		console.log("post", component_id, data);
		if(VTL.isLocal) return null;
		const response = await VTL.fetch(component_id,
		{
			method: "POST",
			cache: "no-cache",
			body: data
		});
		return response.text();
	}
	createForm(component_id)
	{
		const component = new VTL.Component(component_id);
		return new Promise(resolve =>
		{
			if(!component.view)
				component.view = document.getElementById(component.id);
			if(component.view)
			{
				if(!VTL.isLocal && "FORM" == component.view.tagName)
					component.view.addEventListener("submit", async event =>
					{
						event.preventDefault();
						const error = document.getElementById("error");
						if(error) error.textContent = "";
						const data = new FormData(component.view);
						const href = await VTL.post(component.id, data);
						location.href = href;						
					});
				resolve(component);
			}
		});
	}
	createView(component_id, defaults)
	{
		VTL.defaults[component_id] = defaults;
		return VTL.createForm(component_id)
		.then(VTL.loadModel)
		.then(VTL.fileinput)
		.then(VTL.render);
	}
	initialPOST(component)
	{
		console.log("initial post", component.id);
		if(!VTL.isLocal)
			VTL.fetch(component.id,
			{
				method: "POST",
				cache: "no-cache"
			}).then(response => response.text());
		return component;
	}
	loadModel(component)
	{
		return new Promise(resolve =>
		{
			VTL.ready(async() =>
			{
				component.model = await VTL.getXML(component.id);
				resolve(component);
			});
		});
	}
	fileinput(component)
	{
		return new Promise(resolve =>
		{
			const input = document.getElementById(
				component.id + "_fileinput");
			if(input)
			{
				input.addEventListener("input", async event =>
				{
					console.log("get:", component.id, "(file)");
					event.preventDefault();
					try
					{
						const reader = new FileReader;
						reader.onload = event =>
						{
							component.model =
								VTL.parseXML(event.target.result);
							resolve(component);
						};
						reader.readAsText(input.files[0], "UTF-8");
					}
					catch(ex)
					{
						VTL.error("I/O error", ex.getMessage(), input.files[0]);
					}
				});
			}
			resolve(component);
		});
	}
	render(component)
	{
		const elementList = component.model.getElementsByTagName(component.id);
		let html = "";
		for(const element of elementList)
			html += VTL.renderElement(element);
		if("" == html)
		{
			const no_data_view = document.getElementById(
				"no_" + component.id + "_view");
			if(no_data_view) html = no_data_view.innerHTML;
		}
		component.view.innerHTML = html;
		const datalistCollection =
			component.model.getElementsByTagName("datalist");
		for(const datalist of datalistCollection)
		{
			const datalistId = datalist.getAttribute("id");
			if(datalistId)
			{
				const datalistOutput = document.getElementById(datalistId);
				if(datalistOutput)
					datalistOutput.innerHTML =
						VTL.stringifyInnerXML(datalist);
				else
					document.getElementsByTagName("body")[0]
						.insertAdjacentHTML("beforeEnd",
							VTL.stringifyXML(datalist));
			}
		}
		const btnCancelList = component.view.querySelectorAll(
			"#btn-cancel, .btn-cancel");
		for(let btnCancel of btnCancelList)
		{
			btnCancel.addEventListener("click", event =>
			{
				event.preventDefault();
				history.back();
			});
		}
		return component;
	}
	renderElement(element)
	{
		const view = document.getElementById(element.tagName + "_view");
		if(!view) return VTL.stringifyInnerXML(element);
		const variables = {};
		variables["content"] = VTL.stringifyInnerXML(element);
		if(VTL.defaults[element.tagName])
		for(const attribute in VTL.defaults[element.tagName])
			variables[attribute] = VTL.defaults[element.tagName][attribute];
		for(const attribute of element.parentElement.attributes)
			variables[attribute.name] = VTL.escapeHTML(attribute.value);
		for(const attribute of element.attributes)
			variables[attribute.name] = VTL.escapeHTML(attribute.value);
		for(const child of element.children)
		{
			if(variables[child.tagName])
				variables[child.tagName] += VTL.renderElement(child);
			else
				variables[child.tagName] = VTL.renderElement(child);
		}
		let html = view.innerHTML;
		html = html.replace(/\$([A-Za-z0-9_\-]+)/g,
			(str, varname) =>
				undefined !== variables[varname]?
					variables[varname]: "$" + varname);				
		html = html.replace(VTL.FALSE_HTML_ATTRIBUTES, "");
		return html;
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
VTL.Component = class
{
	constructor(id)
	{
		if(id instanceof VTL.Component) return id;
		if(null == id || "object" === typeof id) VTL.error("Logic error",
			"new VTL.Component(" + id + ")", location.href);
		this.id = String(id);
		this.model = null;
		this.view = null;
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
