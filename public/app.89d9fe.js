"use strict";(self.webpackChunksage=self.webpackChunksage||[]).push([[143],{329:function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.default=e=>{window.requestAnimationFrame((function t(){document.body?e():window.requestAnimationFrame(t)}))}},194:function(e,t,s){var i=this&&this.__importDefault||function(e){return e&&e.__esModule?e:{default:e}};Object.defineProperty(t,"__esModule",{value:!0}),t.domReady=void 0;const n=i(s(329));t.domReady=n.default},683:function(e,t,s){var i=s(194);function n(e,t,s){return t in e?Object.defineProperty(e,t,{value:s,enumerable:!0,configurable:!0,writable:!0}):e[t]=s,e}const r=(e,t)=>{e.push(t)},o=(e,t)=>{if(null===t)return[];if("string"==typeof t){const s=[];return e.forEach((e=>{e.id&&e.id===t||s.push(e)})),s}const s=[];return e.forEach((e=>{e.callback!==t&&s.push(e)})),s},l=function(e){for(var t=arguments.length,s=new Array(t>1?t-1:0),i=1;i<t;i++)s[i-1]=arguments[i];e?.length&&e.forEach((e=>{e.callback(...s)}))},a=function(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:500;e.style.transitionProperty="height, margin, padding",e.style.transitionDuration=t+"ms";const s=getComputedStyle(e);if("border-box"===s.boxSizing)e.style.height=e.offsetHeight+"px";else{const t=parseFloat(s.paddingTop),i=parseFloat(s.paddingBottom),n=parseFloat(s.borderTopWidth),r=parseFloat(s.borderBottomWidth);e.style.height=e.offsetHeight-t-i-n-r+"px"}e.offsetHeight,e.style.overflow="hidden",e.style.height=0,window.setTimeout((()=>{e.style.display="none",e.style.removeProperty("height"),e.style.removeProperty("overflow"),e.style.removeProperty("transition-duration"),e.style.removeProperty("transition-property")}),t)},c=function(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:500;e.style.removeProperty("display");let s=window.getComputedStyle(e).display;"none"===s&&(s="block"),e.style.display=s;let i=e.offsetHeight;e.style.overflow="hidden",e.style.height=0,e.offsetHeight,e.style.transitionProperty="height, margin, padding",e.style.transitionDuration=t+"ms",e.style.height=i+"px",window.setTimeout((()=>{e.style.removeProperty("height"),e.style.removeProperty("overflow"),e.style.removeProperty("transition-duration"),e.style.removeProperty("transition-property")}),t)};class h{constructor(){n(this,"service",void 0),n(this,"lastWidth",null),n(this,"tolerance",5),n(this,"callbacks",[]),this.getAndSetWidth(),this.setWatcher()}init(){}getWidth(){return window.innerWidth}getAndSetWidth(){this.lastWidth=this.getWidth()}setWatcher(){window.addEventListener("resize",(()=>{const e=this.getWidth();Math.abs(e-this.lastWidth)>this.tolerance&&(this.lastWidth=e,this.dispatchWidth(e))}))}dispatchWidth(e){l(this.callbacks,e)}on(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"";r(this.callbacks,{callback:e,id:t})}off(){let e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.callbacks=o(e)}}n(h,"name","resize"),n(h,"dependencies",[]);class d{constructor(){n(this,"service",void 0),n(this,"breakpoints",{sm:640,md:768,lg:1024,xl:1280,"2xl":1536}),n(this,"lastBreakpoint",null),n(this,"keys",[]),n(this,"callbacks",[])}init(){const e=this.service.getService(h.name);this.keys=Object.keys(this.breakpoints),this.lastBreakpoint=this.getBreakpoint(e.getWidth()),e.on((e=>{if(!this.callbacks.length)return;const t=this.getBreakpoint(e);t!==this.lastBreakpoint&&(this.lastBreakpoint=t,this.dispatchBreakpoint(t))}),"breakpoint-service")}getBreakpoint(e){for(let t=0;t<this.keys.length;t++){const s=this.keys[t];if(e<=this.breakpoints[s])return s}return this.keys.slice(-1)[0]}dispatchBreakpoint(e){l(this.callbacks,e,this.breakpoints[e])}on(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"";r(this.callbacks,{callback:e,id:t})}off(){let e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.callbacks=o(e)}}n(d,"name","breakpoint"),n(d,"dependencies",[h.name]);class p{constructor(){n(this,"service",void 0),n(this,"isMobile",!1),n(this,"selectors",{parent:"header.header",menu:"{parent} .menu",toggle:"{parent} .menu__toggle",toggleBtn:"{parent} .menu__toggle button",items:"{parent} .menu__items",itemsWrapper:"{parent} .menu__items-wrapper"}),n(this,"elements",{parent:null,menu:null,toggle:null,toggleBtn:null,items:null,itemsWrapper:null}),n(this,"desktopBreakpoints",["xl","2xl"])}init(){this.loadElements();const e=this.service.getService(d.name);this.checkMobileToggle(e.getBreakpoint(window.innerWidth)),e.on((e=>{this.checkMobileToggle(e)}),"menu-service"),this.elements.toggleBtn.addEventListener("click",(()=>function(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:500;return"none"===window.getComputedStyle(e).display?c(e,t):a(e,t)}(this.elements.itemsWrapper,350)))}prepareSelector(e){return e.replace("{parent}",this.selectors.parent)}loadElements(){Object.entries(this.selectors).forEach((e=>{let[t,s]=e;const i=this.prepareSelector(s);this.elements[t]=document.querySelector(i)}))}checkMobileToggle(e){const t=this.breakpointIsMobile(e);t!==this.isMobile&&(this.isMobile=t,t?this.goMobile():this.goDesktop())}breakpointIsMobile(e){return!this.desktopBreakpoints.includes(e)}goMobile(){this.elements.toggle.classList.remove("hidden"),a(this.elements.itemsWrapper,50)}goDesktop(){this.elements.toggle.classList.add("hidden");const e=this.elements.itemsWrapper;e.style.removeProperty("hidden"),e.style.removeProperty("height"),e.style.display="block"}}n(p,"name","menu"),n(p,"dependencies",[d.name]);class u{constructor(){n(this,"autoInit",[]),n(this,"instances",{}),this.autoInit.forEach((e=>{this.loadService(e)}))}loadService(e){const t=u.services[u.service[e]];if(!t)return console.warn("Unregistered service: ",servieName);const s=this.getClassDependencies(t);return s.length&&s.forEach((e=>{this.getService(e)})),this.getService(e)}getService(e){if(this.instances[e])return this.instances[e];const t=u.services[u.service[e]];return this.instances[e]=new t,this.instances[e].service=this,this.instances[e].init(),this.instances[e]}getClassDependencies(e){const t={[e.name]:!0},s={[e.name]:{}};return this.loadClassDependenciesRec(e,t,s[e.name]),this.treeMapToUniqueArray(s)}loadClassDependenciesRec(e,t,s){let i=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null;e.dependencies&&e.dependencies.forEach((n=>{const r=u.services[u.service[n]];s[n]={},!r.dependencies?.length||t[i]&&t[n]||(t[n]||(t[n]=!0),this.loadClassDependenciesRec(r,t,s[n],e.name))}))}treeMapToUniqueArray(e){const t=[],s=e=>{Object.entries(e).forEach((e=>{let[i,n]=e;t.push(i),Object.keys(n).length>0&&s(n)}))};s(e),t.reverse();const i={};return t.reduce(((e,t)=>(i[t]||(i[t]=!0,e.push(t)),e)),[])}}n(u,"service",{resize:"ResizeService",breakpoint:"BreakpointService",menu:"MenuService"}),n(u,"services",{ResizeService:h,BreakpointService:d,MenuService:p});const g=(e,t)=>{let s=null;return[function(){for(var i=arguments.length,n=new Array(i),r=0;r<i;r++)n[r]=arguments[r];clearTimeout(s),s=setTimeout((()=>e(...n)),t)},()=>clearTimeout(s)]};(0,i.domReady)((async e=>{e&&console.error(e);const t=new u;window.services=t,lozad(".lozad",{rootMargin:"10px 0px",threshold:.1,enableAutoReload:!0}).observe(),document.querySelector("body.home")&&(()=>{const e=document.querySelectorAll(".steps .step"),t=t=>{e.forEach(((e,s)=>{s===t?(e.classList.remove("border-t-neutral-200"),e.classList.add("border-t-primary")):(e.classList.add("border-t-neutral-200"),e.classList.remove("border-t-primary"))}))},[s,i]=g((()=>{t(0)}),500),[n,r]=g((e=>{t(e)}),350);e.forEach(((e,t)=>{e.addEventListener("mouseleave",(e=>{s(),r()})),e.addEventListener("mouseenter",(e=>{i(),n(t)}))}))})()}))},402:function(){}},function(e){var t=function(t){return e(e.s=t)};t(683),t(402)}]);