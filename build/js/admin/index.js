!function(e){var t={};function n(r){if(t[r])return t[r].exports;var a=t[r]={i:r,l:!1,exports:{}};return e[r].call(a.exports,a,a.exports,n),a.l=!0,a.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var a in e)n.d(r,a,function(t){return e[t]}.bind(null,a));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=3)}([function(e,t){e.exports=window.wp.blockEditor},function(e,t){e.exports=window.wp.blocks},function(e,t){e.exports=window.wp.element},function(e,t,n){"use strict";n.r(t);var r=n(2),a=n(1),o=n(0);function c(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}var __=wp.i18n.__;function i(){return(i=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)Object.prototype.hasOwnProperty.call(n,r)&&(e[r]=n[r])}return e}).apply(this,arguments)}var s=wp.i18n.__;new function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),Object(a.registerBlockType)("planet4-gpch-plugin-blocks/bs-bingo",{apiVersion:2,title:"BS Bingo",icon:"lightbulb",category:"gpch",keywords:[__("bullshit","planet4-gpch-blocks"),__("bingo","planet4-gpch-blocks"),__("buzzword","planet4-gpch-blocks")],attributes:{bsTerms:{type:"array",default:[]}},edit:function(e){!function(e){if(null==e)throw new TypeError("Cannot destructure undefined")}(e.attributes);for(var t=e.setAttributes,n=Object(o.useBlockProps)(),a=[],i=function(n){var r=n;a.push(React.createElement(o.RichText,{tagName:"div",className:"box",value:e.attributes.bsTerms[n],onChange:function(n){var a,o,i,s;a=r,o=n,(s=e.attributes.bsTerms,i=function(e){if(Array.isArray(e))return c(e)}(s)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(s)||function(e,t){if(e){if("string"==typeof e)return c(e,void 0);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?c(e,void 0):void 0}}(s)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}())[a]=o,t({bsTerms:i})},keepPlaceholderOnFocus:!0,withoutInteractiveFormatting:!0,characterLimit:40,multiline:"false"}))},s=0;s<25;s++)i(s);return React.createElement(r.Fragment,null,React.createElement("div",n,React.createElement("div",{className:"grid"},a)))},save:function(e){for(var t=o.useBlockProps.save(),n=[],r=0;r<25;r++)n.push(React.createElement("div",{className:"box off","data-index":r},React.createElement("div",{className:"box-content"},e.attributes.bsTerms[r])));return React.createElement("div",t,React.createElement("canvas",{className:"fireworks"}),React.createElement("div",{className:"grid"},n),React.createElement("div",{className:"controls"},React.createElement("div",{className:"wp-block-buttons"},React.createElement("div",{className:"wp-block-button is-style-default"},React.createElement("button",{className:"wp-block-button__link bsbingo-reset"},"Reset"))),React.createElement("div",{className:"bingo-score"},"Score: ",React.createElement("span",{className:"number",id:"bs-bingo-score"},"0"))))}})},new function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),Object(a.registerBlockType)("planet4-gpch-plugin-blocks/p2p-share",{apiVersion:2,title:"P2P Share",icon:"share",category:"gpch",keywords:[s("P2P","planet4-gpch-blocks"),s("Share","planet4-gpch-blocks")],attributes:{content:{type:"array",source:"children",selector:"p"}},example:{attributes:{content:"Hello World"}},edit:function(e){var t=e.attributes.content,n=e.setAttributes,r=(e.className,Object(o.useBlockProps)());return React.createElement("div",r,React.createElement(o.RichText,i({},r,{tagName:"p",onChange:function(e){n({content:e})},value:t})))},save:function(){return null}})}}]);