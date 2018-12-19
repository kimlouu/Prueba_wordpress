!function(t){"use strict";var e=function(t){return t},n=function(e){return t.isArray(e)},r=function(t){return!n(t)&&t instanceof Object},i=function(e,n){return t.inArray(n,e)},u=function(t,e){for(var n in t)t.hasOwnProperty(n)&&e(t[n],n,t)},a=function(t){return t[t.length-1]},c=function(t,e,r){return n(t)?function(t,e){var n=[];return u(t,function(t,r,i){n.push(e(t,r,i))}),n}(t,e):function(t,e,n){var r={};return u(t,function(t,i,u){i=n?n(i,t):i,r[i]=e(t,i,u)}),r}(t,e,r)},o=function(t,e,n){return c(t,function(t,r){return t[e].apply(t,n||[])})};!function(t){var e=function(t,e){var n=function(t){var e={};return(t=t||{}).publish=function(t,n){u(e[t],function(t){t(n)})},t.subscribe=function(t,n){e[t]=e[t]||[],e[t].push(n)},t.unsubscribe=function(t){u(e,function(e){var n=i(e,t);-1!==n&&e.splice(n,1)})},t}(),r=t.$;return n.getType=function(){throw'implement me (return type. "text", "radio", etc.)'},n.$=function(t){return t?r.find(t):r},n.disable=function(){n.$().prop("disabled",!0),n.publish("isEnabled",!1)},n.enable=function(){n.$().prop("disabled",!1),n.publish("isEnabled",!0)},e.equalTo=function(t,e){return t===e},e.publishChange=function(){var t;return function(r,i){var u=n.get();e.equalTo(u,t)||n.publish("change",{e:r,domElement:i}),t=u}}(),n},c=function(t,n){var r=e(t,n);return r.get=function(){return r.$().val()},r.set=function(t){r.$().val(t)},r.clear=function(){r.set("")},n.buildSetter=function(t){return function(e){t.call(r,e)}},r},f=function(t,e){t=n(t)?t:[t],e=n(e)?e:[e];var r=!0;return t.length!==e.length?r=!1:u(t,function(t){(function(t,e){return-1!==i(t,e)})(e,t)||(r=!1)}),r},s=function(t){var e={},n=c(t,e);return n.getType=function(){return"text"},n.$().on("change keyup keydown",function(t){e.publishChange(t,this)}),n},p=function(o){var p={},l=o.$,h=o.constructorOverride||{button:function(t){var e={},n=c(t,e);return n.getType=function(){return"button"},n.$().on("change",function(t){e.publishChange(t,this)}),n},text:s,url:function(t){var e=s(t,{});return e.getType=function(){return"url"},e},email:function(t){var e=s(t,{});return e.getType=function(){return"email"},e},password:function(t){var e=s(t,{});return e.getType=function(){return"password"},e},range:function(t){var e={},n=c(t,e);return n.getType=function(){return"range"},n.$().change(function(t){e.publishChange(t,this)}),n},textarea:function(t){var e={},n=c(t,e);return n.getType=function(){return"textarea"},n.$().on("change keyup keydown",function(t){e.publishChange(t,this)}),n},select:function(t){var e={},n=c(t,e);return n.getType=function(){return"select"},n.$().change(function(t){e.publishChange(t,this)}),n},"select[multiple]":function(t){var e={},r=c(t,e);return r.getType=function(){return"select[multiple]"},r.get=function(){return r.$().val()||[]},r.set=function(t){r.$().val(""===t?[]:n(t)?t:[t])},e.equalTo=f,r.$().change(function(t){e.publishChange(t,this)}),r},radio:function(e){var n={},r=c(e,n);return r.getType=function(){return"radio"},r.get=function(){return r.$().filter(":checked").val()||null},r.set=function(e){e?r.$().filter('[value="'+e+'"]').prop("checked",!0):r.$().each(function(){t(this).prop("checked",!1)})},r.$().change(function(t){n.publishChange(t,this)}),r},checkbox:function(e){var r={},i=c(e,r);return i.getType=function(){return"checkbox"},i.get=function(){var e=[];return i.$().filter(":checked").each(function(){e.push(t(this).val())}),e},i.set=function(e){e=n(e)?e:[e],i.$().each(function(){t(this).prop("checked",!1)}),u(e,function(t){i.$().filter('[value="'+t+'"]').prop("checked",!0)})},r.equalTo=f,i.$().change(function(t){r.publishChange(t,this)}),i},file:function(n){var r={},i=e(n,r);return i.getType=function(){return"file"},i.get=function(){return a(i.$().val().split("\\"))},i.clear=function(){this.$().each(function(){t(this).wrap("<form>").closest("form").get(0).reset(),t(this).unwrap()})},i.$().change(function(t){r.publishChange(t,this)}),i},"file[multiple]":function(n){var r={},i=e(n,r);return i.getType=function(){return"file[multiple]"},i.get=function(){var t,e=i.$().get(0).files||[],n=[];for(t=0;t<(e.length||0);t+=1)n.push(e[t].name);return n},i.clear=function(){this.$().each(function(){t(this).wrap("<form>").closest("form").get(0).reset(),t(this).unwrap()})},i.$().change(function(t){r.publishChange(t,this)}),i},hidden:function(t){var e={},n=c(t,e);return n.getType=function(){return"hidden"},n.$().change(function(t){e.publishChange(t,this)}),n}},d=function(e,n){(r(n)?n:l.find(n)).each(function(){var n=t(this).attr("name");p[n]=h[e]({$:t(this)})})},v=function(e,n){var a=[],c=r(n)?n:l.find(n);r(n)?p[c.attr("name")]=h[e]({$:c}):(c.each(function(){-1===i(a,t(this).attr("name"))&&a.push(t(this).attr("name"))}),u(a,function(t){p[t]=h[e]({$:l.find('input[name="'+t+'"]')})}))};return l.is("input, select, textarea")?l.is('input[type="button"], button, input[type="submit"]')?d("button",l):l.is("textarea")?d("textarea",l):l.is('input[type="text"]')||l.is("input")&&!l.attr("type")?d("text",l):l.is('input[type="password"]')?d("password",l):l.is('input[type="email"]')?d("email",l):l.is('input[type="url"]')?d("url",l):l.is('input[type="range"]')?d("range",l):l.is("select")?l.is("[multiple]")?d("select[multiple]",l):d("select",l):l.is('input[type="file"]')?l.is("[multiple]")?d("file[multiple]",l):d("file",l):l.is('input[type="hidden"]')?d("hidden",l):l.is('input[type="radio"]')?v("radio",l):l.is('input[type="checkbox"]')?v("checkbox",l):d("text",l):(d("button",'input[type="button"], button, input[type="submit"]'),d("text",'input[type="text"]'),d("password",'input[type="password"]'),d("email",'input[type="email"]'),d("url",'input[type="url"]'),d("range",'input[type="range"]'),d("textarea","textarea"),d("select","select:not([multiple])"),d("select[multiple]","select[multiple]"),d("file",'input[type="file"]:not([multiple])'),d("file[multiple]",'input[type="file"][multiple]'),d("hidden",'input[type="hidden"]'),v("radio",'input[type="radio"]'),v("checkbox",'input[type="checkbox"]')),p};t.fn.inputVal=function(e){var n=t(this),r=p({$:n});return n.is("input, textarea, select")?void 0===e?r[n.attr("name")].get():(r[n.attr("name")].set(e),n):void 0===e?o(r,"get"):(u(e,function(t,e){r[e].set(t)}),n)},t.fn.inputOnChange=function(e){var n=t(this),r=p({$:n});return u(r,function(t){t.subscribe("change",function(t){e.call(t.domElement,t.e)})}),n},t.fn.inputDisable=function(){var e=t(this);return o(p({$:e}),"disable"),e},t.fn.inputEnable=function(){var e=t(this);return o(p({$:e}),"enable"),e},t.fn.inputClear=function(){var e=t(this);return o(p({$:e}),"clear"),e}}(jQuery),t.fn.repeaterVal=function(){var e=function(t){if(1===t.length&&(0===t[0].key.length||1===t[0].key.length&&!t[0].key[0]))return t[0].val;u(t,function(t){t.head=t.key.shift()});var n,r=function(){var e={};return u(t,function(t){e[t.head]||(e[t.head]=[]),e[t.head].push(t)}),e}();return/^[0-9]+$/.test(t[0].head)?(n=[],u(r,function(t){n.push(e(t))})):(n={},u(r,function(t,r){n[r]=e(t)})),n};return e(function(t){var e=[];return u(t,function(t,n){var r=[];"undefined"!==n&&(r.push(n.match(/^[^\[]*/)[0]),r=r.concat(c(n.match(/\[[^\]]*\]/g),function(t){return t.replace(/[\[\]]/g,"")})),e.push({val:t,key:r}))}),e}(t(this).inputVal()))},t.fn.repeater=function(r){r=r||{};var i;return t(this).each(function(){var o=t(this),f=r.show||function(){t(this).show()},s=r.hide||function(t){t()},p=o.find("[data-repeater-list]").first(),l=function(e,n){return e.filter(function(){return!n||0===t(this).closest(function(t,e){return c(t,function(t){return t[e]})}(n,"selector").join(",")).length})},h=function(){return l(p.find("[data-repeater-item]"),r.repeaters)},d=p.find("[data-repeater-item]").first().clone().hide(),v=l(l(t(this).find("[data-repeater-item]"),r.repeaters).first().find("[data-repeater-delete]"),r.repeaters);r.isFirstItemUndeletable&&v&&v.remove();var m=function(){var t=p.data("repeater-list");return r.$parent?r.$parent.data("item-name")+"["+t+"]":t},g=function(e){r.repeaters&&e.each(function(){var e=t(this);u(r.repeaters,function(t){e.find(t.selector).repeater(function(){var t={};return u(function(t){return Array.prototype.slice.call(t)}(arguments),function(e){u(e,function(e,n){t[n]=e})}),t}(t,{$parent:e}))})})},y=function(t,e,n){t&&u(t,function(t){n.call(e.find(t.selector)[0],t)})},b=function(e,n,r){e.each(function(e){var i=t(this);i.data("item-name",n+"["+e+"]"),l(i.find("[name]"),r).each(function(){var u=t(this),c=u.attr("name").match(/\[[^\]]+\]/g),o=c?a(c).replace(/\[|\]/g,""):u.attr("name"),f=n+"["+e+"]["+o+"]"+(u.is(":checkbox")||u.attr("multiple")?"[]":"");u.attr("name",f),y(r,i,function(r){var i=t(this);b(l(i.find("[data-repeater-item]"),r.repeaters||[]),n+"["+e+"]["+i.find("[data-repeater-list]").first().data("repeater-list")+"]",r.repeaters)})})}),p.find("input[name][checked]").removeAttr("checked").prop("checked",!0)};b(h(),m(),r.repeaters),g(h()),r.initEmpty&&h().remove(),r.ready&&r.ready(function(){b(h(),m(),r.repeaters)});var $=function(){var i=function(a,o,f){if(o||r.defaultValues){var s={};l(a.find("[name]"),f).each(function(){var e=t(this).attr("name").match(/\[([^\]]*)(\]|\]\[\])$/)[1];s[e]=t(this).attr("name")}),a.inputVal(c(function(t,e){var r;return n(t)?(r=[],u(t,function(t,n,i){e(t,n,i)&&r.push(t)})):(r={},u(t,function(t,n,i){e(t,n,i)&&(r[n]=t)})),r}(o||r.defaultValues,function(t,e){return s[e]}),e,function(t){return s[t]}))}y(f,a,function(e){var n=t(this);l(n.find("[data-repeater-item]"),e.repeaters).each(function(){var r=n.find("[data-repeater-list]").data("repeater-list");if(o&&o[r]){var a=t(this).clone();n.find("[data-repeater-item]").remove(),u(o[r],function(t){var r=a.clone();i(r,t,e.repeaters||[]),n.find("[data-repeater-list]").append(r)})}else i(t(this),e.defaultValues,e.repeaters||[])})})};return function(e,n){p.append(e),b(h(),m(),r.repeaters),e.find("[name]").each(function(){t(this).inputClear()}),i(e,n||r.defaultValues,r.repeaters)}}(),k=function(t){var e=d.clone();$(e,t),r.repeaters&&g(e),f.call(e.get(0))};i=function(t){h().remove(),u(t,k)},l(o.find("[data-repeater-create]"),r.repeaters).click(function(){k()}),p.on("click","[data-repeater-delete]",function(){var e=t(this).closest("[data-repeater-item]").get(0);s.call(e,function(){t(e).remove(),b(h(),m(),r.repeaters)})})}),this.setList=i,this}}(jQuery);