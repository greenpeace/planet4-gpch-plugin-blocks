!function(e){var t={};function a(n){if(t[n])return t[n].exports;var r=t[n]={i:n,l:!1,exports:{}};return e[n].call(r.exports,r,r.exports,a),r.l=!0,r.exports}a.m=e,a.c=t,a.d=function(e,t,n){a.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},a.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.t=function(e,t){if(1&t&&(e=a(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(a.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)a.d(n,r,function(t){return e[t]}.bind(null,r));return n},a.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(t,"a",t),t},a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},a.p="",a(a.s=7)}([function(e,t){e.exports=window.wp.i18n},function(e,t){e.exports=window.wp.blockEditor},function(e,t){e.exports=window.wp.components},function(e,t){e.exports=window.wp.blocks},function(e,t){e.exports=window.wp.serverSideRender},function(e,t){e.exports=window.wp.element},function(e,t,a){var n;!function(){"use strict";var a={}.hasOwnProperty;function r(){for(var e=[],t=0;t<arguments.length;t++){var n=arguments[t];if(n){var l=typeof n;if("string"===l||"number"===l)e.push(n);else if(Array.isArray(n)){if(n.length){var c=r.apply(null,n);c&&e.push(c)}}else if("object"===l)if(n.toString===Object.prototype.toString)for(var o in n)a.call(n,o)&&n[o]&&e.push(o);else e.push(n.toString())}}return e.join(" ")}e.exports?(r.default=r,e.exports=r):void 0===(n=function(){return r}.apply(t,[]))||(e.exports=n)}()},function(e,t,a){"use strict";a.r(t);var n=a(5),r=a(3),l=a(1);function c(e,t){(null==t||t>e.length)&&(t=e.length);for(var a=0,n=new Array(t);a<t;a++)n[a]=e[a];return n}var __=wp.i18n.__,o=a(0),i=a(2),s=a(6),p=a.n(s);function u(e){return(u="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function m(){return(m=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var a=arguments[t];for(var n in a)Object.prototype.hasOwnProperty.call(a,n)&&(e[n]=a[n])}return e}).apply(this,arguments)}function h(e,t){for(var a=0;a<t.length;a++){var n=t[a];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function g(e,t){return(g=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function d(e,t){return!t||"object"!==u(t)&&"function"!=typeof t?f(e):t}function f(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}function b(e){return(b=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}var y,E=(y=l.RichText,function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&g(e,t)}(c,e);var t,a,n,r,l=(n=c,r=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){}))),!0}catch(e){return!1}}(),function(){var e,t=b(n);if(r){var a=b(this).constructor;e=Reflect.construct(t,arguments,a)}else e=t.apply(this,arguments);return d(this,e)});function c(e){var t;return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,c),(t=l.call(this,e)).state={charactersUsed:e.value?e.value.length:0},t.handleChange=t.handleChange.bind(f(t)),t.updateCharactersUsed=t.updateCharactersUsed.bind(f(t)),t}return t=c,(a=[{key:"updateCharactersUsed",value:function(e){this.setState((function(){return{charactersUsed:e.length}}))}},{key:"handleChange",value:function(e){this.props.onChange&&this.props.onChange(e),this.updateCharactersUsed(e)}},{key:"shouldShowWarning",value:function(){return this.props.characterLimit&&!this.exceededLimit()&&this.props.characterLimit-this.state.charactersUsed<this.warningThreshold()}},{key:"warningThreshold",value:function(){var e=this.props.characterLimit/10;return 5*Math.ceil(e/5)}},{key:"exceededLimit",value:function(){return this.props.characterLimit&&this.state.charactersUsed>this.props.characterLimit}},{key:"showCounter",value:function(){return!!this.props.characterLimit}},{key:"render",value:function(){var e=this.props,t=e.characterLimit,a=function(e,t){if(null==e)return{};var a,n,r=function(e,t){if(null==e)return{};var a,n,r={},l=Object.keys(e);for(n=0;n<l.length;n++)a=l[n],t.indexOf(a)>=0||(r[a]=e[a]);return r}(e,t);if(Object.getOwnPropertySymbols){var l=Object.getOwnPropertySymbols(e);for(n=0;n<l.length;n++)a=l[n],t.indexOf(a)>=0||Object.prototype.propertyIsEnumerable.call(e,a)&&(r[a]=e[a])}return r}(e,["characterLimit"]);return React.createElement("div",{className:"counted-field-wrapper"},React.createElement(y,m({onChange:this.handleChange},a)),this.showCounter()&&React.createElement("div",{className:p()("character-counter",{"character-limit-exceeded":this.exceededLimit(),"character-limit-warning":this.shouldShowWarning()})},React.createElement("span",null,this.state.charactersUsed),React.createElement("span",null,"/",t)))}}])&&h(t.prototype,a),c}(n.Component)),v=a(4),R=a.n(v);new function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),Object(r.registerBlockType)("planet4-gpch-plugin-blocks/bs-bingo",{apiVersion:2,title:"BS Bingo",icon:"lightbulb",category:"gpch",keywords:[__("bullshit","planet4-gpch-plugin-blocks"),__("bingo","planet4-gpch-plugin-blocks"),__("buzzword","planet4-gpch-plugin-blocks")],attributes:{bsTerms:{type:"array",default:[]}},edit:function(e){!function(e){if(null==e)throw new TypeError("Cannot destructure undefined")}(e.attributes);for(var t=e.setAttributes,a=Object(l.useBlockProps)(),r=[],o=function(a){var n=a;r.push(React.createElement(l.RichText,{tagName:"div",className:"box",value:e.attributes.bsTerms[a],onChange:function(a){var r,l,o,i;r=n,l=a,(i=e.attributes.bsTerms,o=function(e){if(Array.isArray(e))return c(e)}(i)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(i)||function(e,t){if(e){if("string"==typeof e)return c(e,void 0);var a=Object.prototype.toString.call(e).slice(8,-1);return"Object"===a&&e.constructor&&(a=e.constructor.name),"Map"===a||"Set"===a?Array.from(e):"Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)?c(e,void 0):void 0}}(i)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}())[r]=l,t({bsTerms:o})},keepPlaceholderOnFocus:!0,withoutInteractiveFormatting:!0,characterLimit:40,multiline:"false"}))},i=0;i<25;i++)o(i);return React.createElement(n.Fragment,null,React.createElement("div",a,React.createElement("div",{className:"grid"},r)))},save:function(e){for(var t=l.useBlockProps.save(),a=[],n=0;n<25;n++)a.push(React.createElement("div",{className:"box off","data-index":n},React.createElement("div",{className:"box-content"},e.attributes.bsTerms[n])));return React.createElement("div",t,React.createElement("canvas",{className:"fireworks"}),React.createElement("div",{className:"grid"},a),React.createElement("div",{className:"controls"},React.createElement("div",{className:"wp-block-buttons"},React.createElement("div",{className:"wp-block-button is-style-default"},React.createElement("button",{className:"wp-block-button__link bsbingo-reset"},"Reset"))),React.createElement("div",{className:"bingo-score"},"Score: ",React.createElement("span",{className:"number",id:"bs-bingo-score"},"0"))))}})},new function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),Object(r.registerBlockType)("planet4-gpch-plugin-blocks/p2p-share",{apiVersion:2,title:"P2P Share",icon:"share",category:"gpch",attributes:{step1Title:{type:"string",default:Object(o.__)("How many people can you motivate to also sign the petition?","planet4-gpch-plugin-blocks")},step2Title:{type:"string",default:Object(o.__)("How will you be able to reach your friends best?","planet4-gpch-plugin-blocks")},shareText:{type:"string",default:Object(o.__)("I just signed this petition, it's a very important topic. Click here to sign it also: ","planet4-gpch-plugin-blocks")},shareTextShort:{type:"string",default:Object(o.__)("I just signed this petition, it's a very important topic. Click here to sign it also: ","planet4-gpch-plugin-blocks")},shareLink:{type:"object"},utmMedium:{type:"string",default:"p2p"},utmCampaign:{type:"string"},whatsAppSmsCTA:{type:"string",default:Object(o.__)("Thank you for sharing on WhatsApp! Click this link, you will be able to edit the message before sending it: ","planet4-gpch-plugin-blocks")},telegramSmsCTA:{type:"string",default:Object(o.__)("Thank you for sharing on Telegram! Click this link, you will be able to edit the message before sending it: ","planet4-gpch-plugin-blocks")},threemaMessage:{type:"string",default:Object(o.__)("Thank you for sharing on Threema! Please copy the following message and send it to your friends.","planet4-gpch-plugin-blocks")},smsMessage:{type:"string",default:Object(o.__)("Thank you for sharing by SMS! Please copy the following message and send it to your friends.","planet4-gpch-plugin-blocks")},signalMessage:{type:"string",default:Object(o.__)("Thank you for sharing on Signal! Please copy the following message and send it to your friends.","planet4-gpch-plugin-blocks")},emailText:{type:"string",default:Object(o.__)("Hi, I just signed this petition. Can I ask you to sign it too? CTA_LINK","planet4-gpch-plugin-blocks")},emailSubject:{type:"string",default:Object(o.__)("Help by also signing this petition!","planet4-gpch-plugin-blocks")},bg_color:{type:"string",default:"#000000"},text_color:{type:"string",default:"#ffffff"}},edit:function(e){var t=e.attributes,a=e.isSelected,n=e.setAttributes,r={color:"#000",backgroundColor:"#dbebbe",margin:"1rem 0 .5rem 0",padding:".2em .5em",fontSize:"1rem"},c={margin:".5rem 0 .5rem 0",padding:"0 .5rem"},s={border:"solid 1px #666",marginBottom:".5em",margin:".5rem",padding:"0 .5rem"},p={fontStyle:"italic",margin:"1rem 0 .5rem 0",padding:"0 .5rem"},u=Object(l.useBlockProps)();return React.createElement("div",u,a?React.createElement("div",null,React.createElement(l.InspectorControls,{key:"setting"},React.createElement("div",{id:"gpch-blocks-p2p-controls"},React.createElement("fieldset",null,React.createElement("legend",{className:"blocks-base-control__label"},Object(o.__)("UTM Tags","planet4-gpch-plugin-blocks")),React.createElement(i.TextControl,{label:Object(o.__)("UTM Medium","planet4-gpch-plugin-blocks"),value:t.utmMedium,onChange:function(e){return n({utmMedium:e})}}),React.createElement(i.TextControl,{label:Object(o.__)("UTM Campaign","planet4-gpch-plugin-blocks"),value:t.utmCampaign,onChange:function(e){return n({utmCampaign:e})}}),React.createElement("p",null,React.createElement("i",null,Object(o.__)("utm_source will be added automatically depending on the channel.","planet4-gpch-plugin-blocks")))))),React.createElement("h3",{style:r},Object(o.__)("Step 1","planet4-gpch-plugin-blocks")),React.createElement(E,{style:c,tagName:"h4",value:t.step1Title,allowedFormats:[],onChange:function(e){return n({step1Title:e})}}),React.createElement("h3",{style:r},Object(o.__)("Step 2","planet4-gpch-plugin-blocks")),React.createElement(E,{style:c,tagName:"h4",value:t.step2Title,allowedFormats:[],onChange:function(e){return n({step2Title:e})}}),React.createElement("h3",{style:r},Object(o.__)("Share text/links","planet4-gpch-plugin-blocks")),React.createElement("p",{style:p},Object(o.__)("Share text for all channels. The link will be shortened and added to the end of the text:","planet4-gpch-plugin-blocks")),React.createElement(E,{value:t.shareText,placeholder:Object(o.__)("THE SHARE TEXT FOR ALL CHANNELS","planet4-gpch-plugin-blocks"),allowedFormats:[],onChange:function(e){return n({shareText:e})},style:s}),React.createElement("p",{style:p},Object(o.__)("Short version (max. 178 characters) of the share text when sent by SMS. The link will be shortened and added to the end of the text:","planet4-gpch-plugin-blocks")),React.createElement(E,{value:t.shareTextShort,placeholder:Object(o.__)("THE SHARE TEXT FOR ALL CHANNELS (when sent by SMS)","planet4-gpch-plugin-blocks"),allowedFormats:[],onChange:function(e){return n({shareTextShort:e})},style:s,characterLimit:178}),React.createElement("p",{style:p},Object(o.__)("Share link (unshortened and without UTM tags)","planet4-gpch-plugin-blocks")),React.createElement(l.__experimentalLinkControl,{value:t.shareLink,onChange:function(e){return n({shareLink:e})},settings:[],showSuggestions:!0,style:c}),React.createElement("h3",{style:r},"WhatsApp Share"),React.createElement("p",{style:p},Object(o.__)("WhatsApp SMS CTA (178 characters max, link to WhatsApp will be added at the end):","planet4-gpch-plugin-blocks")),React.createElement(E,{value:t.whatsAppSmsCTA,placeholder:Object(o.__)("THE TEXT TO SEND BY SMS","planet4-gpch-plugin-blocks"),allowedFormats:[],onChange:function(e){return n({whatsAppSmsCTA:e})},style:s,characterLimit:178}),React.createElement("h3",{style:r},"Email Share"),React.createElement("p",{style:p},Object(o.__)("Email Subject:","planet4-gpch-plugin-blocks")),React.createElement(E,{value:t.emailSubject,placeholder:Object(o.__)("EMAIL SUBJECT","planet4-gpch-plugin-blocks"),allowedFormats:[],onChange:function(e){return n({emailSubject:e})},style:s}),React.createElement("p",{style:p},Object(o.__)("Email Text. Put CTA_LINK anywhere you would like to put a shortened link.","planet4-gpch-plugin-blocks")),React.createElement(E,{value:t.emailText,placeholder:Object(o.__)("EMAIL TEXT","planet4-gpch-plugin-blocks"),allowedFormats:[],onChange:function(e){return n({emailText:e})},style:s}),React.createElement("h3",{style:r},"SMS Share"),React.createElement("p",{style:p},Object(o.__)("First SMS, share CTA (178 characters max):","planet4-gpch-plugin-blocks")),React.createElement(E,{value:t.smsMessage,placeholder:Object(o.__)("FOR EXAMPLE: Thank you for sharing with your friends. Please forward the following SMS text to them.","planet4-gpch-plugin-blocks"),allowedFormats:[],onChange:function(e){return n({smsMessage:e})},style:s,characterLimit:178}),React.createElement("p",{style:p},Object(o.__)("A second SMS is sent with the share text and link.","planet4-gpch-plugin-blocks")),React.createElement("h3",{style:r},"Signal Share"),React.createElement("p",{style:p},Object(o.__)("First SMS, share CTA (178 characters max):","planet4-gpch-plugin-blocks")),React.createElement(E,{value:t.signalMessage,placeholder:Object(o.__)("FOR EXAMPLE: Thank you for sharing with your friends. Please copy/paste the following text into Signal and send it to your friends.","planet4-gpch-plugin-blocks"),allowedFormats:[],onChange:function(e){return n({signalMessage:e})},style:s,characterLimit:178}),React.createElement("p",{style:p},Object(o.__)("A second SMS is sent with the share text and link.","planet4-gpch-plugin-blocks")),React.createElement("h3",{style:r},"Threema Share"),React.createElement("p",{style:p},Object(o.__)("First SMS, share CTA (178 characters max):","planet4-gpch-plugin-blocks")),React.createElement(E,{value:t.threemaMessage,placeholder:Object(o.__)("FOR EXAMPLE: Thank you for sharing with your friends. Please copy/paste the following text into Threema and send it to your friends.","planet4-gpch-plugin-blocks"),allowedFormats:[],onChange:function(e){return n({threemaMessage:e})},style:s,characterLimit:178}),React.createElement("p",{style:p},Object(o.__)("A second SMS is sent with the share text and link.","planet4-gpch-plugin-blocks")),React.createElement("h3",{style:r},"Telegram Share"),React.createElement("p",{style:p},Object(o.__)("Telegram SMS CTA (178 characters max, link to Telegram will be added at the end):","planet4-gpch-plugin-blocks")),React.createElement(E,{value:t.telegramSmsCTA,placeholder:Object(o.__)("THE TEXT TO SEND BY SMS","planet4-gpch-plugin-blocks"),allowedFormats:[],onChange:function(e){return n({telegramSmsCTA:e})},style:s,characterLimit:178})):React.createElement("div",{className:"wp-block-planet4-gpch-plugin-blocks-p2p-share"},React.createElement("form",{className:"p2p-share-form"},React.createElement("fieldset",{className:"p2p-share-step p2p-share-step-1"},React.createElement("legend",null,t.step1Title),React.createElement("ul",{className:"select"},React.createElement("li",null,React.createElement("input",{id:"n1",type:"radio",name:"number_of_people",value:"1-5",className:"autoforward","data-next-element":".p2p-share-step-2"}),React.createElement("label",{htmlFor:"n1"},React.createElement("img",{alt:"",className:"social-icon",src:"".concat(gpchBlocks.pluginUrl,"assets/img/icon/people-1.svg")})," ","1 - 5 People")),React.createElement("li",null,React.createElement("input",{id:"n6",type:"radio",name:"number_of_people",value:"6-10",className:"autoforward","data-next-element":".p2p-share-step-2"}),React.createElement("label",{htmlFor:"n6"},React.createElement("img",{alt:"",className:"social-icon",src:"".concat(gpchBlocks.pluginUrl,"assets/img/icon/people-2.svg")})," ","6 - 10 People")),React.createElement("li",null,React.createElement("input",{id:"n10",type:"radio",name:"number_of_people",value:"10-20",className:"autoforward","data-next-element":".p2p-share-step-2"}),React.createElement("label",{htmlFor:"n10"},React.createElement("img",{alt:"",className:"social-icon",src:"".concat(gpchBlocks.pluginUrl,"assets/img/icon/people-3.svg")})," ","10 - 20 People")),React.createElement("li",null,React.createElement("input",{id:"n20",type:"radio",name:"number_of_people",value:"20+",className:"autoforward","data-next-element":".p2p-share-step-2"}),React.createElement("label",{htmlFor:"n20"},React.createElement("img",{alt:"",className:"social-icon",src:"".concat(gpchBlocks.pluginUrl,"assets/img/icon/people-3.svg")}),React.createElement("img",{alt:"",className:"social-icon",src:"".concat(gpchBlocks.pluginUrl,"assets/img/icon/people-3.svg")})," ","20+ People")))))))}})},new function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),Object(r.registerBlockType)("planet4-gpch-plugin-blocks/form-entries",{apiVersion:2,title:"Form Entries",icon:"editor-ul",category:"gpch",attributes:{formId:{type:"integer"},fieldId:{type:"number"},numberOfEntries:{type:"integer",default:4},text:{type:"string",default:Object(o.__)("FIELD_VALUE has signed TIME_AGO.","planet4-gpch-plugin-blocks")}},edit:function(e){var t=e.attributes,a=e.isSelected,n=e.setAttributes,r=Object(l.useBlockProps)();return React.createElement("div",r,a?React.createElement("div",{style:{backgroundColor:"#dbebbe",padding:"1rem"}},React.createElement(R.a,{block:"planet4-gpch-plugin-blocks/form-entries",attributes:t}),React.createElement(i.__experimentalNumberControl,{label:"Form ID",description:"The ID of the form you want to pull entries from",isShiftStepEnabled:!0,onChange:function(e){return n({formId:parseInt(e)})},dragDirection:"n",dragThreshold:20,step:1,value:t.formId}),React.createElement(i.__experimentalNumberControl,{label:"Form Field ID",description:"The ID of the form field you want to display",isShiftStepEnabled:!0,onChange:function(e){return n({fieldId:parseFloat(e)})},dragDirection:"n",dragThreshold:20,step:.1,value:t.fieldId}),React.createElement(i.__experimentalNumberControl,{label:"Number of entries to show",isShiftStepEnabled:!0,onChange:function(e){return n({numberOfEntries:parseInt(e)})},dragDirection:"n",dragThreshold:20,step:1,value:t.numberOfEntries}),React.createElement("p",null,"The text to diplay for every line:",React.createElement("br",null),React.createElement("i",null,"You can use the placeholders FIELD_VALUE and TIME_AGO.")),React.createElement(l.RichText,{style:{border:"solid 1px #666",padding:"0 .5rem",backgroundColor:"#ffffff"},tagName:"p",value:t.text,allowedFormats:["core/bold"],onChange:function(e){return n({text:e})}})):React.createElement("div",{className:"wp-block-planet4-gpch-plugin-blocks-form-entries"},React.createElement(R.a,{block:"planet4-gpch-plugin-blocks/form-entries",attributes:t})))}})},new function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),Object(r.registerBlockType)("planet4-gpch-plugin-blocks/dreampeace-cover",{apiVersion:2,title:"Dreampeace Cover",icon:"align-wide",category:"gpch",attributes:{title:{type:"string"},text:{type:"string"},noYear:{type:"string"}},edit:function(e){var t=e.attributes,a=e.isSelected,n=e.setAttributes,r=Object(l.useBlockProps)(),c={border:"solid 1px #666",padding:"0 .5rem",backgroundColor:"#ffffff"};return React.createElement("div",r,a?React.createElement("div",null,React.createElement("div",{style:{backgroundColor:"#dbebbe",padding:"1rem"}},React.createElement("h3",{style:{marginTop:"0"}},"Dreampeace Cover"),React.createElement(l.RichText,{style:c,tagName:"h2",value:t.title,allowedFormats:[],placeholder:"Title",label:"Title",onChange:function(e){return n({title:e})}}),React.createElement(l.RichText,{style:c,tagName:"p",value:t.text,allowedFormats:["core/bold"],placeholder:"Text",onChange:function(e){return n({text:e})}}),React.createElement("p",null,"Text to show if no slide for that year exists:"),React.createElement(l.RichText,{style:c,tagName:"p",value:t.noYear,placeholder:"Error Text",onChange:function(e){return n({noYear:e})}}))):React.createElement("div",{className:"gpch-plugin-blocks-dreampeace-cover"},React.createElement(R.a,{block:"planet4-gpch-plugin-blocks/dreampeace-cover",attributes:t})))}})},new function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),Object(r.registerBlockType)("planet4-gpch-plugin-blocks/dreampeace-slide",{apiVersion:2,title:"Dreampeace Slide",icon:"slides",category:"gpch",attributes:{year:{type:"string"},media:{type:"object"},imagePosition:{type:"string",default:"center center"},text:{type:"string"},buttonText:{type:"string"},link:{type:"object"}},edit:function(e){var t=e.attributes,a=e.isSelected,n=e.setAttributes,r=Object(l.useBlockProps)();return React.createElement("div",r,a?React.createElement("div",{style:{backgroundColor:"#dbebbe",padding:"1rem"}},React.createElement("h3",{style:{marginTop:"0"}},"Dreampeace Slide"),React.createElement(i.TextControl,{label:"Year",value:t.year,onChange:function(e){return n({year:e})}}),React.createElement("label",{htmlFor:"media"},"Image"),React.createElement(l.MediaUploadCheck,null,React.createElement(l.MediaUpload,{onSelect:function(e){return n({media:e})},value:void 0!==t.media&&t.media.id,allowedTypes:["image"],render:function(e){var a=e.open;return React.createElement(i.Button,{className:void 0===t.media?"editor-post-featured-image__toggle":"editor-post-featured-image__preview",onClick:a},void 0===t.media&&"Choose an image",void 0!==t.media&&React.createElement("img",{alt:"",src:t.media.sizes.medium.url}))}})),void 0!==t.media&&React.createElement(l.MediaUploadCheck,null,React.createElement(l.MediaUpload,{title:"Replace image",value:t.media.id,onSelect:function(e){return n({media:e})},allowedTypes:["image"],render:function(e){var t=e.open;return React.createElement(i.Button,{onClick:t,isDefault:!0,isLarge:!0},"Replace image")}})),void 0!==t.media&&React.createElement(l.MediaUploadCheck,null,React.createElement(i.Button,{onClick:function(){t.media=void 0},isLink:!0,isDestructive:!0},"Remove image")),React.createElement(i.SelectControl,{label:"Image Position",value:t.imagePosition,options:[{label:"Top Left",value:"top left"},{label:"Top Center",value:"top center"},{label:"Top Right",value:"top right"},{label:"Center Left",value:"center left"},{label:"Center Center",value:"center center"},{label:"Center Right",value:"center right"},{label:"Bottom Left",value:"bottom left"},{label:"Bottom Center",value:"bottom center"},{label:"Bottom Right",value:"bottom right"}],onChange:function(e){return n({imagePosition:e})}}),React.createElement(i.TextControl,{label:"Text",value:t.text,onChange:function(e){return n({text:e})}}),React.createElement(i.TextControl,{label:"Button Text",value:t.buttonText,onChange:function(e){return n({buttonText:e})}}),React.createElement("label",{htmlFor:"link"},"Button Link"),React.createElement(l.__experimentalLinkControl,{value:t.link,onChange:function(e){return n({link:e})},settings:[],showSuggestions:!0})):React.createElement("div",{className:"gpch-plugin-blocks-dreampeace-slide"},React.createElement(R.a,{block:"planet4-gpch-plugin-blocks/dreampeace-slide",attributes:t})))}})}}]);