/*! Copyright © 2015-2021 Alexey Vaskovsky. Released under the MIT license */
const VTL=new class{constructor(){window.fetch||this.error("Unsupported","Fetch API",navigator.userAgent),window.XMLSerializer||this.error("Unsupported","XMLSerializer",navigator.userAgent),window.DOMParser||this.error("Unsupported","DOMParser",navigator.userAgent),window.FileReader||this.error("Unsupported","FileReader",navigator.userAgent),this._parser=new DOMParser,this._serializer=new XMLSerializer,this.defaults={},this.serverAPI="*.php",this.server="",this.listeners=[];const e=document.getElementById("server");e&&(this.server=e.getAttribute("href"),this.server&&!/\/$/.test(this.server)&&(this.server+="/")),this.isLocal="file:"==location.protocol&&""==this.server,this.queryString=location.hash?location.hash.substring(1):"",this.ready(this.updateQueryString),console.log("server:",this.server||location.origin),console.log("query:",this.queryString)}ready(e){var t="loading"!==document.readyState;return e&&(window.addEventListener("hashchange",e),t?e(null):window.addEventListener("DOMContentLoaded",e)),t}updateQueryString(){VTL.queryString=location.hash?location.hash.substring(1):"";for(const e of document.querySelectorAll("#if-no-query-string, .if-no-query-string"))e.style.display=VTL.queryString?"none":"block"}fetch(e,t){return new Promise(r=>{const n=VTL.server+VTL.serverAPI.replace("*",e)+"?"+VTL.queryString;window.fetch(n,t).then(async e=>{var t;e.ok?r(e):401==e.status?(t=await e.text(),location.href=t+"#return="+encodeURIComponent(location.href)):(t=await e.text(),VTL.error("HTTP"+e.status,t,n))}).catch(e=>{VTL.error("fetch",e.message,n)})})}async get(t){if(VTL.isLocal){console.log("get",t,"(local)");let e=document.getElementById(t+"_data#"+VTL.queryString);if(e=e||document.getElementById(t+"_data"),!e)throw new Error("no "+t+"_data @"+location.pathname);return e.innerHTML}{console.log("get",t);const e=await VTL.fetch(t);return e.text()}}async getJSON(e){return JSON.parse(await VTL.get(e))}async getXML(e){return VTL.parseXML(await VTL.get(e))}async post(e,t){if(console.log("post",e,t),VTL.isLocal)return null;const r=await VTL.fetch(e,{method:"POST",cache:"no-cache",body:t});return r.text()}on(e,t,r){this.listeners.push([e,t,r]);for(const n of document.querySelectorAll(t))n.addEventListener(e,r)}handleEvents(e){for(const o of this.listeners){var[t,r,n]=o;for(const a of e.querySelectorAll(r))a.addEventListener(t,n)}}createForm(e){const r=new VTL.Component(e);return new Promise(e=>{r.view||(r.view=document.getElementById(r.id)),r.view&&(VTL.isLocal||"FORM"!=r.view.tagName||r.view.addEventListener("submit",async e=>{e.preventDefault();const t=document.getElementById("error");t&&(t.textContent="");e=new FormData(r.view),e=await VTL.post(r.id,e);location.href=e}),e(r))})}createView(e,t){return VTL.defaults[e]=t,VTL.createForm(e).then(VTL.loadModel).then(VTL.fileinput).then(VTL.render)}loadModel(t){return new Promise(e=>{VTL.ready(async()=>{t.model=await VTL.getXML(t.id),e(t)})})}fileinput(o){return new Promise(r=>{const n=document.getElementById(o.id+"_fileinput");n&&n.addEventListener("input",async e=>{console.log("get:",o.id,"(file)"),e.preventDefault();try{const t=new FileReader;t.onload=e=>{o.model=VTL.parseXML(e.target.result),r(o)},t.readAsText(n.files[0],"UTF-8")}catch(e){VTL.error("I/O error",e.getMessage(),n.files[0])}}),r(o)})}render(e){var t,r;let n="";for(const a of e.model.getElementsByTagName(e.id))n+=VTL.renderElement(a);""!=n||(t=document.getElementById("no_"+e.id+"_view"))&&(n=t.innerHTML),e.view.innerHTML=n;for(const i of e.model.getElementsByTagName("datalist")){var o=i.getAttribute("id");if(o){const s=document.getElementById(o);s?s.innerHTML=VTL.stringifyInnerXML(i):document.getElementsByTagName("body")[0].insertAdjacentHTML("beforeEnd",VTL.stringifyXML(i))}}VTL.handleEvents(e.view);for(r of e.view.querySelectorAll("#btn-cancel, .btn-cancel"))r.addEventListener("click",e=>{e.preventDefault(),history.back()});return e}renderElement(e){var t=document.getElementById(e.tagName+"_view");if(!t)return VTL.stringifyInnerXML(e);const r={};if(r.content=VTL.stringifyInnerXML(e),VTL.defaults[e.tagName])for(const o in VTL.defaults[e.tagName])r[o]=VTL.defaults[e.tagName][o];for(const a of e.parentElement.attributes)r[a.name]=VTL.escapeHTML(a.value);for(const i of e.attributes)r[i.name]=VTL.escapeHTML(i.value);for(const s of e.children)r[s.tagName]?r[s.tagName]+=VTL.renderElement(s):r[s.tagName]=VTL.renderElement(s);let n=t.innerHTML;return n=n.replace(/\$([A-Za-z0-9_\-]+)/g,(e,t)=>void 0!==r[t]?r[t]:"$"+t),n=n.replace(VTL.FALSE_HTML_ATTRIBUTES,""),n}escapeHTML(e){return e.replace(/["'&<>]/g,e=>"&#"+e.charCodeAt(0)+";")}parseXML(e){return this._parser.parseFromString(e,"application/xml")}stringifyXML(e){return this._serializer.serializeToString(e)}stringifyInnerXML(e){let t="";for(const r of e.childNodes)t+=this.stringifyXML(r);return t}error(e,t,r){r=`${e}: ${t}\n@${r}`;const n=document.getElementById("error");console.error(r),n?n.textContent=t:alert(t)}initialPOST(e){return console.log("initial post",e.id),VTL.isLocal||VTL.fetch(e.id,{method:"POST",cache:"no-cache"}).then(e=>e.text()),e}updateMathJax(e){if("undefined"!=typeof MathJax){if(void 0!==e)return MathJax.typesetClear([e.view]),MathJax.typesetPromise([e.view]);MathJax.typeset()}return e}};VTL.Component=class{constructor(e){if(e instanceof VTL.Component)return e;null!=e&&"object"!=typeof e||VTL.error("Logic error","new VTL.Component("+e+")",location.href),this.id=String(e),this.model=null,this.view=null}},VTL.FALSE_HTML_ATTRIBUTES=new RegExp("("+["allowfullscreen","allowpaymentrequest","async","autofocus","autoplay","checked","controls","default","defer","disabled","formnovalidate","hidden","ismap","itemscope","loop","multiple","muted","nomodule","novalidate","open","playsinline","readonly","required","reversed","selected","truespeed"].join("|")+')="(false|no|off|0)?"',"gi"),VTL.on("click","#btn-back, .btn-back",e=>{e.preventDefault(),history.back()}),VTL.on("click","#btn-print, .btn-print",e=>{e.preventDefault(),window.print()}),VTL.on("click","#btn-reload, .btn-reload",e=>{e.preventDefault(),location.reload()});
