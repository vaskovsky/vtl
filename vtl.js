/*! Copyright © 2021-2022 Alexey Vaskovsky. Released under the MIT license */
const VTL=new class{constructor(){window.fetch||this.error("Unsupported","Fetch API",navigator.userAgent),window.XMLSerializer||this.error("Unsupported","XMLSerializer",navigator.userAgent),window.DOMParser||this.error("Unsupported","DOMParser",navigator.userAgent),window.FileReader||this.error("Unsupported","FileReader",navigator.userAgent),this._parser=new DOMParser,this._serializer=new XMLSerializer,this.defaults={},this.serverAPI="*.php",this.server="",this.listeners=[];const e=document.getElementById("server");e&&(this.server=e.getAttribute("href"),this.server&&!/\/$/.test(this.server)&&(this.server+="/")),this.isLocal="file:"==location.protocol&&""==this.server,this.queryString=location.hash?location.hash.substring(1):"",this.ready(this.updateQueryString),console.log("server:",this.server||location.origin),console.log("query:",this.queryString)}ready(e){var t="loading"!==document.readyState;return e&&(window.addEventListener("hashchange",e),t?e(null):window.addEventListener("DOMContentLoaded",e)),t}updateQueryString(){VTL.queryString=location.hash?location.hash.substring(1):"";for(const e of document.querySelectorAll("#if-no-query-string, .if-no-query-string"))e.style.display=VTL.queryString?"none":"block"}fetch(e,t){return new Promise(r=>{const n=VTL.server+VTL.serverAPI.replace("*",e)+"?"+VTL.queryString;window.fetch(n,t).then(async e=>{var t;e.ok?r(e):401==e.status?(t=await e.text(),location.href=t+"#return="+encodeURIComponent(location.href)):(t=await e.text(),VTL.error("HTTP"+e.status,t,n))}).catch(e=>{VTL.error("fetch",e.message,n)})})}async get(t){if(VTL.isLocal){console.log("get",t,"(local)");let e=document.getElementById(t+"_data#"+VTL.queryString);if(e=e||document.getElementById(t+"_data"),!e)throw new Error("no "+t+"_data @"+location.pathname);return e.innerHTML}{console.log("get",t);const e=await VTL.fetch(t);return e.text()}}async getJSON(e){return JSON.parse(await VTL.get(e))}async getXML(e){return VTL.parseXML(await VTL.get(e))}async post(e,t){if(console.log("post",e,t),VTL.isLocal)return null;const r=await VTL.fetch(e,{method:"POST",cache:"no-cache",body:t});return r.text()}delete(e){const t=new FormData;return t.append("delete","on"),this.post(e,t)}on(e,t,r){this.listeners.push([e,t,r]);for(const n of document.querySelectorAll(t))n.addEventListener(e,r)}handleEvents(t){for(const a of this.listeners){var[e,r,n]=a;for(const s of t.view.querySelectorAll(r))s.addEventListener(e,n)}var o,i;for(o of t.view.querySelectorAll("#btn-cancel, .btn-cancel"))o.addEventListener("click",e=>{e.preventDefault(),history.back()});for(i of t.view.querySelectorAll("#btn-delete, .btn-delete"))i.addEventListener("click",async e=>{e.preventDefault(),(/(^|&)new=on(&|$)/.test(VTL.queryString)||confirm(VTL.getLocalizedMessage("Confirm deletion")))&&VTL.redirect(await VTL.delete(t.id))})}createForm(e){const r=new VTL.Component(e);return r.promise(e=>{r.view||(r.view=document.getElementById(r.id)),r.view&&(VTL.isLocal||"FORM"!=r.view.tagName||r.view.addEventListener("submit",async e=>{e.preventDefault();const t=document.getElementById("error");t&&(t.textContent="");e=new FormData(r.view);VTL.redirect(await VTL.post(r.id,e))}),e("create"))})}createView(e,t){return VTL.defaults[e]=t,VTL.createForm(e).then(VTL.loadModel).then(VTL.fileinput).then(VTL.render)}loadModel(t){return t.promise(e=>{VTL.ready(async()=>{t.model=await VTL.getXML(t.id),e()})})}fileinput(o){return o.promise(r=>{const n=document.getElementById(o.id+"_fileinput");n&&n.addEventListener("input",async e=>{e.preventDefault();try{const t=new FileReader;t.onload=e=>{o.model=VTL.parseXML(e.target.result),r("fileinput")},t.readAsText(n.files[0],"UTF-8")}catch(e){VTL.error("I/O error",e.getMessage(),n.files[0])}}),r()})}render(s){return s.promise(e=>{var t;let r="";for(const o of s.model.getElementsByTagName(s.id))r+=VTL.renderElement(o);""!=r||(t=document.getElementById("no_"+s.id+"_view"))&&(r=t.innerHTML),s.view.innerHTML=r;for(const i of s.model.getElementsByTagName("datalist")){var n=i.getAttribute("id");if(n){const a=document.getElementById(n);a?a.innerHTML=VTL.stringifyInnerXML(i):document.getElementsByTagName("body")[0].insertAdjacentHTML("beforeEnd",VTL.stringifyXML(i))}}VTL.handleEvents(s),e("render")})}renderElement(e){var t=document.getElementById(e.tagName+"_view");if(!t)return VTL.stringifyInnerXML(e);const r={};if(r.content=VTL.stringifyInnerXML(e),VTL.defaults[e.tagName])for(const o in VTL.defaults[e.tagName])r[o]=VTL.defaults[e.tagName][o];for(const i of e.parentElement.attributes)r[i.name]=VTL.escapeHTML(i.value);for(const a of e.attributes)r[a.name]=VTL.escapeHTML(a.value);for(const s of e.children)r[s.tagName]?r[s.tagName]+=VTL.renderElement(s):r[s.tagName]=VTL.renderElement(s);let n=t.innerHTML;return n=n.replace(/\$([A-Za-z0-9_\-]+)/g,(e,t)=>void 0!==r[t]?r[t]:"$"+t),n=n.replace(VTL.FALSE_HTML_ATTRIBUTES,""),n}escapeHTML(e){return e.replace(/["'&<>]/g,e=>"&#"+e.charCodeAt(0)+";")}parseXML(e){return this._parser.parseFromString(e,"application/xml")}stringifyXML(e){return this._serializer.serializeToString(e)}stringifyInnerXML(e){let t="";for(const r of e.childNodes)t+=this.stringifyXML(r);return t}error(e,t,r){r=e+`: ${t}
@`+r;const n=document.getElementById("error");console.error(r),n?n.textContent=t:alert(t)}initialPOST(t){return t.promise(e=>{VTL.isLocal||VTL.fetch(t.id,{method:"POST",cache:"no-cache"}).then(e=>e.text()),e("initial post")})}updateMathJax(t){return t.promise(e=>{"undefined"!=typeof MathJax&&(void 0===t?MathJax.typeset():(MathJax.typesetClear([t.view]),MathJax.typesetPromise([t.view]).then(()=>{e("updateMathJax")})))})}getLanguage(){let e=navigator.language||"";return e&&2<e.length&&(e=e.substring(0,2)),e.toUpperCase()}getLocalizedMessage(e){var t=VTL.getLanguage();return VTL.MESSAGES[t]&&VTL.MESSAGES[t][e]?VTL.MESSAGES[t][e]:e}redirect(e){"OK"==e||"BACK"==e?history.back():"RELOAD"==e?location.reload():location.href=e}};VTL.Component=class{constructor(e){if(e instanceof VTL.Component)return e;null!=e&&"object"!=typeof e||VTL.error("Logic error","new VTL.Component("+e+")",location.href),this.id=String(e),this.model=null,this.view=null}promise(e){return new VTL.Promise(this,e)}},VTL.Promise=class{constructor(e,t){this.component=e,this.executor=t;const r=this;this.resolve=function(e){e&&console.debug(e,r.component.id),r.next&&r.next.run()},setTimeout(()=>{r.previous||r.run()})}run(){try{this.executor(this.resolve)}catch(e){VTL.error("catch",e.message,location.href)}}then(e){const t=e(this.component);return t instanceof VTL.Promise?t.previous?(VTL.error("Logic error","VTL.Promise already has previous one",e.name,location.href),this):(t.previous=this).next?(VTL.error("Logic error","VTL.Promise already has next one",e.name,location.href),this):this.next=t:(VTL.error("Logic error","VTL.Promise expected to be returned from",e.name,location.href),this)}},VTL.on("click","#subquery, .subquery",function(e){e.preventDefault();let t=e.target.closest("a#subquery, a.subquery"),r=t.getAttribute("href");r?(VTL.queryString&&(0<=r.indexOf("#")?r=r.replace("#","#"+VTL.queryString+"&",r):r+="#"+VTL.queryString),console.log("go to",r),location.href=r):console.error("subquery has no href attribute @",e.target)}),VTL.on("click","#btn-back, .btn-back",e=>{e.preventDefault(),history.back()}),VTL.on("click","#btn-print, .btn-print",e=>{e.preventDefault(),window.print()}),VTL.on("click","#btn-reload, .btn-reload",e=>{e.preventDefault(),location.reload()}),VTL.FALSE_HTML_ATTRIBUTES=new RegExp("("+["allowfullscreen","allowpaymentrequest","async","autofocus","autoplay","checked","controls","default","defer","disabled","formnovalidate","hidden","ismap","itemscope","loop","multiple","muted","nomodule","novalidate","open","playsinline","readonly","required","reversed","selected","truespeed"].join("|")+')="(false|no|off|0)?"',"gi"),VTL.MESSAGES={RU:{"Confirm deletion":"Подтвердите удаление"}};
