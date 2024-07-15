(()=>{"use strict";var n={update:null,begin:null,loopBegin:null,changeBegin:null,change:null,changeComplete:null,loopComplete:null,complete:null,loop:1,direction:"normal",autoplay:!0,timelineOffset:0},t={duration:1e3,delay:0,endDelay:0,easing:"easeOutElastic(1, .5)",round:0},e=["translateX","translateY","translateZ","rotate","rotateX","rotateY","rotateZ","scale","scaleX","scaleY","scaleZ","skew","skewX","skewY","perspective","matrix","matrix3d"],r={CSS:{},springs:{}};function a(n,t,e){return Math.min(Math.max(n,t),e)}function o(n,t){return n.indexOf(t)>-1}function i(n,t){return n.apply(null,t)}var u={arr:function(n){return Array.isArray(n)},obj:function(n){return o(Object.prototype.toString.call(n),"Object")},pth:function(n){return u.obj(n)&&n.hasOwnProperty("totalLength")},svg:function(n){return n instanceof SVGElement},inp:function(n){return n instanceof HTMLInputElement},dom:function(n){return n.nodeType||u.svg(n)},str:function(n){return"string"==typeof n},fnc:function(n){return"function"==typeof n},und:function(n){return void 0===n},nil:function(n){return u.und(n)||null===n},hex:function(n){return/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(n)},rgb:function(n){return/^rgb/.test(n)},hsl:function(n){return/^hsl/.test(n)},col:function(n){return u.hex(n)||u.rgb(n)||u.hsl(n)},key:function(e){return!n.hasOwnProperty(e)&&!t.hasOwnProperty(e)&&"targets"!==e&&"keyframes"!==e}};function s(n){var t=/\(([^)]+)\)/.exec(n);return t?t[1].split(",").map((function(n){return parseFloat(n)})):[]}function c(n,t){var e=s(n),o=a(u.und(e[0])?1:e[0],.1,100),i=a(u.und(e[1])?100:e[1],.1,100),c=a(u.und(e[2])?10:e[2],.1,100),l=a(u.und(e[3])?0:e[3],.1,100),f=Math.sqrt(i/o),d=c/(2*Math.sqrt(i*o)),h=d<1?f*Math.sqrt(1-d*d):0,p=d<1?(d*f-l)/h:-l+f;function g(n){var e=t?t*n/1e3:n;return e=d<1?Math.exp(-e*d*f)*(1*Math.cos(h*e)+p*Math.sin(h*e)):(1+p*e)*Math.exp(-e*f),0===n||1===n?n:1-e}return t?g:function(){var t=r.springs[n];if(t)return t;for(var e=1/6,a=0,o=0;;)if(1===g(a+=e)){if(++o>=16)break}else o=0;var i=a*e*1e3;return r.springs[n]=i,i}}function l(n){return void 0===n&&(n=10),function(t){return Math.ceil(a(t,1e-6,1)*n)*(1/n)}}var f,d,h=function(){var n=.1;function t(n,t){return 1-3*t+3*n}function e(n,t){return 3*t-6*n}function r(n){return 3*n}function a(n,a,o){return((t(a,o)*n+e(a,o))*n+r(a))*n}function o(n,a,o){return 3*t(a,o)*n*n+2*e(a,o)*n+r(a)}return function(t,e,r,i){if(0<=t&&t<=1&&0<=r&&r<=1){var u=new Float32Array(11);if(t!==e||r!==i)for(var s=0;s<11;++s)u[s]=a(s*n,t,r);return function(s){return t===e&&r===i||0===s||1===s?s:a(function(e){for(var i=0,s=1;10!==s&&u[s]<=e;++s)i+=n;--s;var c=i+(e-u[s])/(u[s+1]-u[s])*n,l=o(c,t,r);return l>=.001?function(n,t,e,r){for(var i=0;i<4;++i){var u=o(t,e,r);if(0===u)return t;t-=(a(t,e,r)-n)/u}return t}(e,c,t,r):0===l?c:function(n,t,e,r,o){var i,u,s=0;do{(i=a(u=t+(e-t)/2,r,o)-n)>0?e=u:t=u}while(Math.abs(i)>1e-7&&++s<10);return u}(e,i,i+n,t,r)}(s),e,i)}}}}(),p=(f={linear:function(){return function(n){return n}}},d={Sine:function(){return function(n){return 1-Math.cos(n*Math.PI/2)}},Expo:function(){return function(n){return n?Math.pow(2,10*n-10):0}},Circ:function(){return function(n){return 1-Math.sqrt(1-n*n)}},Back:function(){return function(n){return n*n*(3*n-2)}},Bounce:function(){return function(n){for(var t,e=4;n<((t=Math.pow(2,--e))-1)/11;);return 1/Math.pow(4,3-e)-7.5625*Math.pow((3*t-2)/22-n,2)}},Elastic:function(n,t){void 0===n&&(n=1),void 0===t&&(t=.5);var e=a(n,1,10),r=a(t,.1,2);return function(n){return 0===n||1===n?n:-e*Math.pow(2,10*(n-1))*Math.sin((n-1-r/(2*Math.PI)*Math.asin(1/e))*(2*Math.PI)/r)}}},["Quad","Cubic","Quart","Quint"].forEach((function(n,t){d[n]=function(){return function(n){return Math.pow(n,t+2)}}})),Object.keys(d).forEach((function(n){var t=d[n];f["easeIn"+n]=t,f["easeOut"+n]=function(n,e){return function(r){return 1-t(n,e)(1-r)}},f["easeInOut"+n]=function(n,e){return function(r){return r<.5?t(n,e)(2*r)/2:1-t(n,e)(-2*r+2)/2}},f["easeOutIn"+n]=function(n,e){return function(r){return r<.5?(1-t(n,e)(1-2*r))/2:(t(n,e)(2*r-1)+1)/2}}})),f);function g(n,t){if(u.fnc(n))return n;var e=n.split("(")[0],r=p[e],a=s(n);switch(e){case"spring":return c(n,t);case"cubicBezier":return i(h,a);case"steps":return i(l,a);default:return i(r,a)}}function m(n){try{return document.querySelectorAll(n)}catch(n){return}}function v(n,t){for(var e=n.length,r=arguments.length>=2?arguments[1]:void 0,a=[],o=0;o<e;o++)if(o in n){var i=n[o];t.call(r,i,o,n)&&a.push(i)}return a}function y(n){return n.reduce((function(n,t){return n.concat(u.arr(t)?y(t):t)}),[])}function b(n){return u.arr(n)?n:(u.str(n)&&(n=m(n)||n),n instanceof NodeList||n instanceof HTMLCollection?[].slice.call(n):[n])}function w(n,t){return n.some((function(n){return n===t}))}function x(n){var t={};for(var e in n)t[e]=n[e];return t}function M(n,t){var e=x(n);for(var r in n)e[r]=t.hasOwnProperty(r)?t[r]:n[r];return e}function k(n,t){var e=x(n);for(var r in t)e[r]=u.und(n[r])?t[r]:n[r];return e}function F(n){var t=/[+-]?\d*\.?\d+(?:\.\d+)?(?:[eE][+-]?\d+)?(%|px|pt|em|rem|in|cm|mm|ex|ch|pc|vw|vh|vmin|vmax|deg|rad|turn)?$/.exec(n);if(t)return t[1]}function L(n,t){return u.fnc(n)?n(t.target,t.id,t.total):n}function P(n,t){return n.getAttribute(t)}function C(n,t,e){if(w([e,"deg","rad","turn"],F(t)))return t;var a=r.CSS[t+e];if(!u.und(a))return a;var o=document.createElement(n.tagName),i=n.parentNode&&n.parentNode!==document?n.parentNode:document.body;i.appendChild(o),o.style.position="absolute",o.style.width=100+e;var s=100/o.offsetWidth;i.removeChild(o);var c=s*parseFloat(t);return r.CSS[t+e]=c,c}function I(n,t,e){if(t in n.style){var r=t.replace(/([a-z])([A-Z])/g,"$1-$2").toLowerCase(),a=n.style[t]||getComputedStyle(n).getPropertyValue(r)||"0";return e?C(n,a,e):a}}function E(n,t){return u.dom(n)&&!u.inp(n)&&(!u.nil(P(n,t))||u.svg(n)&&n[t])?"attribute":u.dom(n)&&w(e,t)?"transform":u.dom(n)&&"transform"!==t&&I(n,t)?"css":null!=n[t]?"object":void 0}function B(n){if(u.dom(n)){for(var t,e=n.style.transform||"",r=/(\w+)\(([^)]*)\)/g,a=new Map;t=r.exec(e);)a.set(t[1],t[2]);return a}}function O(n,t,e,r){switch(E(n,t)){case"transform":return function(n,t,e,r){var a=o(t,"scale")?1:0+function(n){return o(n,"translate")||"perspective"===n?"px":o(n,"rotate")||o(n,"skew")?"deg":void 0}(t),i=B(n).get(t)||a;return e&&(e.transforms.list.set(t,i),e.transforms.last=t),r?C(n,i,r):i}(n,t,r,e);case"css":return I(n,t,e);case"attribute":return P(n,t);default:return n[t]||0}}function D(n,t){var e=/^(\*=|\+=|-=)/.exec(n);if(!e)return n;var r=F(n)||0,a=parseFloat(t),o=parseFloat(n.replace(e[0],""));switch(e[0][0]){case"+":return a+o+r;case"-":return a-o+r;case"*":return a*o+r}}function N(n,t){if(u.col(n))return function(n){return u.rgb(n)?(e=/rgb\((\d+,\s*[\d]+,\s*[\d]+)\)/g.exec(t=n))?"rgba("+e[1]+",1)":t:u.hex(n)?function(n){var t=n.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,(function(n,t,e,r){return t+t+e+e+r+r})),e=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(t);return"rgba("+parseInt(e[1],16)+","+parseInt(e[2],16)+","+parseInt(e[3],16)+",1)"}(n):u.hsl(n)?function(n){var t,e,r,a=/hsl\((\d+),\s*([\d.]+)%,\s*([\d.]+)%\)/g.exec(n)||/hsla\((\d+),\s*([\d.]+)%,\s*([\d.]+)%,\s*([\d.]+)\)/g.exec(n),o=parseInt(a[1],10)/360,i=parseInt(a[2],10)/100,u=parseInt(a[3],10)/100,s=a[4]||1;function c(n,t,e){return e<0&&(e+=1),e>1&&(e-=1),e<1/6?n+6*(t-n)*e:e<.5?t:e<2/3?n+(t-n)*(2/3-e)*6:n}if(0==i)t=e=r=u;else{var l=u<.5?u*(1+i):u+i-u*i,f=2*u-l;t=c(f,l,o+1/3),e=c(f,l,o),r=c(f,l,o-1/3)}return"rgba("+255*t+","+255*e+","+255*r+","+s+")"}(n):void 0;var t,e}(n);if(/\s/g.test(n))return n;var e=F(n),r=e?n.substr(0,n.length-e.length):n;return t?r+t:r}function S(n,t){return Math.sqrt(Math.pow(t.x-n.x,2)+Math.pow(t.y-n.y,2))}function T(n){for(var t,e=n.points,r=0,a=0;a<e.numberOfItems;a++){var o=e.getItem(a);a>0&&(r+=S(t,o)),t=o}return r}function A(n){if(n.getTotalLength)return n.getTotalLength();switch(n.tagName.toLowerCase()){case"circle":return function(n){return 2*Math.PI*P(n,"r")}(n);case"rect":return function(n){return 2*P(n,"width")+2*P(n,"height")}(n);case"line":return function(n){return S({x:P(n,"x1"),y:P(n,"y1")},{x:P(n,"x2"),y:P(n,"y2")})}(n);case"polyline":return T(n);case"polygon":return function(n){var t=n.points;return T(n)+S(t.getItem(t.numberOfItems-1),t.getItem(0))}(n)}}function W(n,t){var e=t||{},r=e.el||function(n){for(var t=n.parentNode;u.svg(t)&&u.svg(t.parentNode);)t=t.parentNode;return t}(n),a=r.getBoundingClientRect(),o=P(r,"viewBox"),i=a.width,s=a.height,c=e.viewBox||(o?o.split(" "):[0,0,i,s]);return{el:r,viewBox:c,x:c[0]/1,y:c[1]/1,w:i,h:s,vW:c[2],vH:c[3]}}function q(n,t,e){function r(e){void 0===e&&(e=0);var r=t+e>=1?t+e:0;return n.el.getPointAtLength(r)}var a=W(n.el,n.svg),o=r(),i=r(-1),u=r(1),s=e?1:a.w/a.vW,c=e?1:a.h/a.vH;switch(n.property){case"x":return(o.x-a.x)*s;case"y":return(o.y-a.y)*c;case"angle":return 180*Math.atan2(u.y-i.y,u.x-i.x)/Math.PI}}function H(n,t){var e=/[+-]?\d*\.?\d+(?:\.\d+)?(?:[eE][+-]?\d+)?/g,r=N(u.pth(n)?n.totalLength:n,t)+"";return{original:r,numbers:r.match(e)?r.match(e).map(Number):[0],strings:u.str(n)||t?r.split(e):[]}}function j(n){return v(n?y(u.arr(n)?n.map(b):b(n)):[],(function(n,t,e){return e.indexOf(n)===t}))}function V(n){var t=j(n);return t.map((function(n,e){return{target:n,id:e,total:t.length,transforms:{list:B(n)}}}))}function z(n,t){var e=x(t);if(/^spring/.test(e.easing)&&(e.duration=c(e.easing)),u.arr(n)){var r=n.length;2!==r||u.obj(n[0])?u.fnc(t.duration)||(e.duration=t.duration/r):n={value:n}}var a=u.arr(n)?n:[n];return a.map((function(n,e){var r=u.obj(n)&&!u.pth(n)?n:{value:n};return u.und(r.delay)&&(r.delay=e?0:t.delay),u.und(r.endDelay)&&(r.endDelay=e===a.length-1?t.endDelay:0),r})).map((function(n){return k(n,e)}))}var $={css:function(n,t,e){return n.style[t]=e},attribute:function(n,t,e){return n.setAttribute(t,e)},object:function(n,t,e){return n[t]=e},transform:function(n,t,e,r,a){if(r.list.set(t,e),t===r.last||a){var o="";r.list.forEach((function(n,t){o+=t+"("+n+") "})),n.style.transform=o}}};function X(n,t){V(n).forEach((function(n){for(var e in t){var r=L(t[e],n),a=n.target,o=F(r),i=O(a,e,o,n),u=D(N(r,o||F(i)),i),s=E(a,e);$[s](a,e,u,n.transforms,!0)}}))}function Y(n,t){return v(y(n.map((function(n){return t.map((function(t){return function(n,t){var e=E(n.target,t.name);if(e){var r=function(n,t){var e;return n.tweens.map((function(r){var a=function(n,t){var e={};for(var r in n){var a=L(n[r],t);u.arr(a)&&1===(a=a.map((function(n){return L(n,t)}))).length&&(a=a[0]),e[r]=a}return e.duration=parseFloat(e.duration),e.delay=parseFloat(e.delay),e}(r,t),o=a.value,i=u.arr(o)?o[1]:o,s=F(i),c=O(t.target,n.name,s,t),l=e?e.to.original:c,f=u.arr(o)?o[0]:l,d=F(f)||F(c),h=s||d;return u.und(i)&&(i=l),a.from=H(f,h),a.to=H(D(i,f),h),a.start=e?e.end:0,a.end=a.start+a.delay+a.duration+a.endDelay,a.easing=g(a.easing,a.duration),a.isPath=u.pth(o),a.isPathTargetInsideSVG=a.isPath&&u.svg(t.target),a.isColor=u.col(a.from.original),a.isColor&&(a.round=1),e=a,a}))}(t,n),a=r[r.length-1];return{type:e,property:t.name,animatable:n,tweens:r,duration:a.end,delay:r[0].delay,endDelay:a.endDelay}}}(n,t)}))}))),(function(n){return!u.und(n)}))}function Z(n,t){var e=n.length,r=function(n){return n.timelineOffset?n.timelineOffset:0},a={};return a.duration=e?Math.max.apply(Math,n.map((function(n){return r(n)+n.duration}))):t.duration,a.delay=e?Math.min.apply(Math,n.map((function(n){return r(n)+n.delay}))):t.delay,a.endDelay=e?a.duration-Math.max.apply(Math,n.map((function(n){return r(n)+n.duration-n.endDelay}))):t.endDelay,a}var G=0,Q=[],R=function(){var n;function t(e){for(var r=Q.length,a=0;a<r;){var o=Q[a];o.paused?(Q.splice(a,1),r--):(o.tick(e),a++)}n=a>0?requestAnimationFrame(t):void 0}return"undefined"!=typeof document&&document.addEventListener("visibilitychange",(function(){J.suspendWhenDocumentHidden&&(_()?n=cancelAnimationFrame(n):(Q.forEach((function(n){return n._onDocumentVisibility()})),R()))})),function(){n||_()&&J.suspendWhenDocumentHidden||!(Q.length>0)||(n=requestAnimationFrame(t))}}();function _(){return!!document&&document.hidden}function J(e){void 0===e&&(e={});var r,o=0,i=0,s=0,c=0,l=null;function f(n){var t=window.Promise&&new Promise((function(n){return l=n}));return n.finished=t,t}var d=function(e){var r=M(n,e),a=M(t,e),o=function(n,t){var e=[],r=t.keyframes;for(var a in r&&(t=k(function(n){for(var t=v(y(n.map((function(n){return Object.keys(n)}))),(function(n){return u.key(n)})).reduce((function(n,t){return n.indexOf(t)<0&&n.push(t),n}),[]),e={},r=function(r){var a=t[r];e[a]=n.map((function(n){var t={};for(var e in n)u.key(e)?e==a&&(t.value=n[e]):t[e]=n[e];return t}))},a=0;a<t.length;a++)r(a);return e}(r),t)),t)u.key(a)&&e.push({name:a,tweens:z(t[a],n)});return e}(a,e),i=V(e.targets),s=Y(i,o),c=Z(s,a),l=G;return G++,k(r,{id:l,children:[],animatables:i,animations:s,duration:c.duration,delay:c.delay,endDelay:c.endDelay})}(e);function h(){var n=d.direction;"alternate"!==n&&(d.direction="normal"!==n?"normal":"reverse"),d.reversed=!d.reversed,r.forEach((function(n){return n.reversed=d.reversed}))}function p(n){return d.reversed?d.duration-n:n}function g(){o=0,i=p(d.currentTime)*(1/J.speed)}function m(n,t){t&&t.seek(n-t.timelineOffset)}function b(n){for(var t=0,e=d.animations,r=e.length;t<r;){var o=e[t],i=o.animatable,u=o.tweens,s=u.length-1,c=u[s];s&&(c=v(u,(function(t){return n<t.end}))[0]||c);for(var l=a(n-c.start-c.delay,0,c.duration)/c.duration,f=isNaN(l)?1:c.easing(l),h=c.to.strings,p=c.round,g=[],m=c.to.numbers.length,y=void 0,b=0;b<m;b++){var w=void 0,x=c.to.numbers[b],M=c.from.numbers[b]||0;w=c.isPath?q(c.value,f*x,c.isPathTargetInsideSVG):M+f*(x-M),p&&(c.isColor&&b>2||(w=Math.round(w*p)/p)),g.push(w)}var k=h.length;if(k){y=h[0];for(var F=0;F<k;F++){h[F];var L=h[F+1],P=g[F];isNaN(P)||(y+=L?P+L:P+" ")}}else y=g[0];$[o.type](i.target,o.property,y,i.transforms),o.currentValue=y,t++}}function w(n){d[n]&&!d.passThrough&&d[n](d)}function x(n){var t=d.duration,e=d.delay,u=t-d.endDelay,g=p(n);d.progress=a(g/t*100,0,100),d.reversePlayback=g<d.currentTime,r&&function(n){if(d.reversePlayback)for(var t=c;t--;)m(n,r[t]);else for(var e=0;e<c;e++)m(n,r[e])}(g),!d.began&&d.currentTime>0&&(d.began=!0,w("begin")),!d.loopBegan&&d.currentTime>0&&(d.loopBegan=!0,w("loopBegin")),g<=e&&0!==d.currentTime&&b(0),(g>=u&&d.currentTime!==t||!t)&&b(t),g>e&&g<u?(d.changeBegan||(d.changeBegan=!0,d.changeCompleted=!1,w("changeBegin")),w("change"),b(g)):d.changeBegan&&(d.changeCompleted=!0,d.changeBegan=!1,w("changeComplete")),d.currentTime=a(g,0,t),d.began&&w("update"),n>=t&&(i=0,d.remaining&&!0!==d.remaining&&d.remaining--,d.remaining?(o=s,w("loopComplete"),d.loopBegan=!1,"alternate"===d.direction&&h()):(d.paused=!0,d.completed||(d.completed=!0,w("loopComplete"),w("complete"),!d.passThrough&&"Promise"in window&&(l(),f(d)))))}return f(d),d.reset=function(){var n=d.direction;d.passThrough=!1,d.currentTime=0,d.progress=0,d.paused=!0,d.began=!1,d.loopBegan=!1,d.changeBegan=!1,d.completed=!1,d.changeCompleted=!1,d.reversePlayback=!1,d.reversed="reverse"===n,d.remaining=d.loop,r=d.children;for(var t=c=r.length;t--;)d.children[t].reset();(d.reversed&&!0!==d.loop||"alternate"===n&&1===d.loop)&&d.remaining++,b(d.reversed?d.duration:0)},d._onDocumentVisibility=g,d.set=function(n,t){return X(n,t),d},d.tick=function(n){s=n,o||(o=s),x((s+(i-o))*J.speed)},d.seek=function(n){x(p(n))},d.pause=function(){d.paused=!0,g()},d.play=function(){d.paused&&(d.completed&&d.reset(),d.paused=!1,Q.push(d),g(),R())},d.reverse=function(){h(),d.completed=!d.reversed,g()},d.restart=function(){d.reset(),d.play()},d.remove=function(n){U(j(n),d)},d.reset(),d.autoplay&&d.play(),d}function K(n,t){for(var e=t.length;e--;)w(n,t[e].animatable.target)&&t.splice(e,1)}function U(n,t){var e=t.animations,r=t.children;K(n,e);for(var a=r.length;a--;){var o=r[a],i=o.animations;K(n,i),i.length||o.children.length||r.splice(a,1)}e.length||r.length||t.pause()}J.version="3.2.1",J.speed=1,J.suspendWhenDocumentHidden=!0,J.running=Q,J.remove=function(n){for(var t=j(n),e=Q.length;e--;)U(t,Q[e])},J.get=O,J.set=X,J.convertPx=C,J.path=function(n,t){var e=u.str(n)?m(n)[0]:n,r=t||100;return function(n){return{property:n,el:e,svg:W(e),totalLength:A(e)*(r/100)}}},J.setDashoffset=function(n){var t=A(n);return n.setAttribute("stroke-dasharray",t),t},J.stagger=function(n,t){void 0===t&&(t={});var e=t.direction||"normal",r=t.easing?g(t.easing):null,a=t.grid,o=t.axis,i=t.from||0,s="first"===i,c="center"===i,l="last"===i,f=u.arr(n),d=f?parseFloat(n[0]):parseFloat(n),h=f?parseFloat(n[1]):0,p=F(f?n[1]:n)||0,m=t.start||0+(f?d:0),v=[],y=0;return function(n,t,u){if(s&&(i=0),c&&(i=(u-1)/2),l&&(i=u-1),!v.length){for(var g=0;g<u;g++){if(a){var b=c?(a[0]-1)/2:i%a[0],w=c?(a[1]-1)/2:Math.floor(i/a[0]),x=b-g%a[0],M=w-Math.floor(g/a[0]),k=Math.sqrt(x*x+M*M);"x"===o&&(k=-x),"y"===o&&(k=-M),v.push(k)}else v.push(Math.abs(i-g));y=Math.max.apply(Math,v)}r&&(v=v.map((function(n){return r(n/y)*y}))),"reverse"===e&&(v=v.map((function(n){return o?n<0?-1*n:-n:Math.abs(y-n)})))}return m+(f?(h-d)/y:d)*(Math.round(100*v[t])/100)+p}},J.timeline=function(n){void 0===n&&(n={});var e=J(n);return e.duration=0,e.add=function(r,a){var o=Q.indexOf(e),i=e.children;function s(n){n.passThrough=!0}o>-1&&Q.splice(o,1);for(var c=0;c<i.length;c++)s(i[c]);var l=k(r,M(t,n));l.targets=l.targets||n.targets;var f=e.duration;l.autoplay=!1,l.direction=e.direction,l.timelineOffset=u.und(a)?f:D(a,f),s(e),e.seek(l.timelineOffset);var d=J(l);s(d),i.push(d);var h=Z(i,n);return e.delay=h.delay,e.endDelay=h.endDelay,e.duration=h.duration,e.seek(0),e.reset(),e.autoplay&&e.play(),e},e},J.easing=g,J.penner=p,J.random=function(n,t){return Math.floor(Math.random()*(t-n+1))+n};const nn=J,tn=document.getElementsByClassName("box");let en=Array(25).fill(!1);const rn=document.querySelector(".fireworks");let an=0;const on=window.localStorage,un=function(){let n=on.getItem("bsbingo");if("string"==typeof n){n=n.split(",");for(let t=0;t<n.length;t++)n[t]="true"===n[t],!0===n[t]&&(tn[t].classList.add("on"),tn[t].classList.remove("off"));en=n,cn()}for(let n=0;n<tn.length;n++){tn[n].childNodes[0].style.fontSize="22px";let t=22;for(;tn[n].childNodes[0].offsetWidth>tn[n].offsetWidth||tn[n].childNodes[0].offsetHeight>tn[n].offsetHeight;){const e=window.getComputedStyle(tn[n].childNodes[0]).getPropertyValue("font-size");t=parseFloat(e),tn[n].childNodes[0].style.fontSize=t-1+"px"}}rn.style.display="none"};window.addEventListener("load",un),window.addEventListener("resize",un);const sn=function(){if(!this.classList.contains("won")){this.classList.toggle("off"),this.classList.toggle("on");const n=this.getAttribute("data-index");en[n]=this.classList.contains("on"),on.setItem("bsbingo",en),cn()}},cn=function(){let n=0;an=0;for(let t=0;t<5;t++){let e=!0;for(let n=0;n<5;n++)!1===en[5*t+n]?e=!1:an+=1;if(e){an+=10,n+=1;let e=!1;for(let n=0;n<5;n++)tn[5*t+n].classList.contains("won")||(e=!0),tn[5*t+n].classList.add("won");e&&ln(t)}}for(let n=0;n<5;n++){let t=!0;for(let e=0;e<5;e++)!1===en[5*e+n]&&(t=!1);if(t){an+=10;let t=!1;for(let e=0;e<5;e++)tn[5*e+n].classList.contains("won")||(t=!0),tn[5*e+n].classList.add("won");t&&fn(n)}}if(5===n){an+=100;const n=new Event("bsBingoWin",{bubbles:!0,cancelable:!0,composed:!1});document.querySelector(".wp-block-planet4-gpch-plugin-blocks-bs-bingo").dispatchEvent(n),rn.style.display="block",dn()}document.getElementById("bs-bingo-score").innerText=an};for(let n=0;n<tn.length;n++)tn[n].addEventListener("click",sn,!1);document.getElementsByClassName("bsbingo-reset")[0].addEventListener("click",(function(){for(let n=0;n<25;n++)tn[n].classList.remove("won"),tn[n].classList.remove("on"),tn[n].classList.add("off");en=Array(25).fill(!1),on.setItem("bsbingo",en)}),!1);const ln=function(n){const t=5*n,e=[];for(let n=t;n<t+5;n++)e.push(tn[n]);nn({targets:[e],keyframes:[{scale:1.1},{scale:1}],duration:200,delay:nn.stagger(70),loop:!1})},fn=function(n){const t=[];for(let e=n;e<25;e+=5)t.push(tn[e]);nn({targets:[t],keyframes:[{scale:1.1},{scale:1}],duration:200,delay:nn.stagger(70),loop:!1})},dn=function(){window.human=!1;const n=document.querySelector(".fireworks"),t=n.getContext("2d"),e=["#FF0000","#FF7F00","#FFFF00","#00FF00","#0000FF","#2E2B5F","#8B00FF"];function r(){n.width=2*window.innerWidth,n.height=2*window.innerHeight,n.style.height=n.offsetWidth+"px",n.getContext("2d").scale(2,2)}function a(r,a){const o={};return o.x=r,o.y=a,o.color=e[nn.random(0,e.length-1)],o.radius=nn.random(16,32),o.endPos=function(t){const e=nn.random(0,360)*Math.PI/180,r=nn.random(n.offsetWidth/6,n.offsetWidth/2),a=[-1,1][nn.random(0,1)]*r;return{x:t.x+a*Math.cos(e),y:t.y+a*Math.sin(e)}}(o),o.draw=function(){t.beginPath(),t.arc(o.x,o.y,o.radius,0,2*Math.PI,!0),t.fillStyle=o.color,t.fill()},o}function o(n){for(let t=0;t<n.animatables.length;t++)n.animatables[t].target.draw()}nn({duration:1/0,update(){t.clearRect(0,0,n.width,n.height)}});const i=window.innerWidth/2,u=window.innerHeight/2;let s=20;!function t(){window.human||(function(n,t){const e=[];for(let r=0;r<15;r++)e.push(a(n,t));nn.timeline().add({targets:e,x:n=>n.endPos.x,y:n=>n.endPos.y,radius:.1,duration:nn.random(1200,1800),easing:"easeOutExpo",update:o})}(nn.random(i-50,i+50),nn.random(u-50,u+50)),s--,s>0?nn({duration:200}).finished.then(t):n.style.display="none")}(),r(),window.addEventListener("resize",r,!1)}})();