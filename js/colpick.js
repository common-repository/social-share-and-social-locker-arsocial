!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):t("object"==typeof exports?require("jquery"):jQuery)}(function(t){var e=function(){var e='<div class="colpick"><div class="colpick_color"><div class="colpick_color_overlay1"><div class="colpick_color_overlay2"><div class="colpick_selector_outer"><div class="colpick_selector_inner"></div></div></div></div></div><div class="colpick_hue"><div class="colpick_hue_arrs"><div class="colpick_hue_larr"></div><div class="colpick_hue_rarr"></div></div></div><div class="colpick_new_color"></div><div class="colpick_current_color"></div><div class="colpick_hex_field"><div class="colpick_field_letter">#</div><input type="text" maxlength="6" size="6" /></div><div class="colpick_rgb_r colpick_field"><div class="colpick_field_letter">R</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_rgb_g colpick_field"><div class="colpick_field_letter">G</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_rgb_b colpick_field"><div class="colpick_field_letter">B</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_hsb_h colpick_field"><div class="colpick_field_letter">H</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_hsb_s colpick_field"><div class="colpick_field_letter">S</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_hsb_b colpick_field"><div class="colpick_field_letter">B</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_submit"></div></div>',i={showEvent:"click",onShow:function(){},onBeforeShow:function(){},onHide:function(){},onChange:function(){},onSubmit:function(){},colorScheme:"light",color:"auto",livePreview:!0,flat:!1,layout:"full",submit:1,submitText:"OK",height:156,polyfill:!1,styles:!1},l=function(e,i){var o=c(e);t(i).data("colpick").fields.eq(1).val(o.r).end().eq(2).val(o.g).end().eq(3).val(o.b).end()},d=function(e,i){t(i).data("colpick").fields.eq(4).val(Math.round(e.h)).end().eq(5).val(Math.round(e.s)).end().eq(6).val(Math.round(e.b)).end()},n=function(e,i){t(i).data("colpick").fields.eq(0).val(r(e))},s=function(e,i){t(i).data("colpick").selector.css("backgroundColor","#"+r({h:e.h,s:100,b:100})),t(i).data("colpick").selectorIndic.css({left:parseInt(t(i).data("colpick").height*e.s/100,10),top:parseInt(t(i).data("colpick").height*(100-e.b)/100,10)})},p=function(e,i){t(i).data("colpick").hue.css("top",parseInt(t(i).data("colpick").height-t(i).data("colpick").height*e.h/360,10))},f=function(e,i){t(i).data("colpick").currentColor.css("backgroundColor","#"+r(e))},u=function(e,i){t(i).data("colpick").newColor.css("backgroundColor","#"+r(e))},h=function(){var e,i=t(this).parent().parent();this.parentNode.className.indexOf("_hex")>0?(i.data("colpick").color=e=o(P(this.value)),l(e,i.get(0)),d(e,i.get(0))):this.parentNode.className.indexOf("_hsb")>0?(i.data("colpick").color=e=E({h:parseInt(i.data("colpick").fields.eq(4).val(),10),s:parseInt(i.data("colpick").fields.eq(5).val(),10),b:parseInt(i.data("colpick").fields.eq(6).val(),10)}),l(e,i.get(0)),n(e,i.get(0))):(i.data("colpick").color=e=a(D({r:parseInt(i.data("colpick").fields.eq(1).val(),10),g:parseInt(i.data("colpick").fields.eq(2).val(),10),b:parseInt(i.data("colpick").fields.eq(3).val(),10)})),n(e,i.get(0)),d(e,i.get(0))),s(e,i.get(0)),p(e,i.get(0)),u(e,i.get(0)),i.data("colpick").onChange.apply(i.parent(),[e,r(e),c(e),i.data("colpick").el,0])},v=function(){t(this).parent().removeClass("colpick_focus")},g=function(){t(this).parent().parent().data("colpick").fields.parent().removeClass("colpick_focus"),t(this).parent().addClass("colpick_focus")},k=function(e){e.preventDefault?e.preventDefault():e.returnValue=!1;var i=t(this).parent().find("input").focus(),o={el:t(this).parent().addClass("colpick_slider"),max:this.parentNode.className.indexOf("_hsb_h")>0?360:this.parentNode.className.indexOf("_hsb")>0?100:255,y:e.pageY,field:i,val:parseInt(i.val(),10),preview:t(this).parent().parent().data("colpick").livePreview};t(document).mouseup(o,m),t(document).mousemove(o,_)},_=function(t){return t.data.field.val(Math.max(0,Math.min(t.data.max,parseInt(t.data.val-t.pageY+t.data.y,10)))),t.data.preview&&h.apply(t.data.field.get(0),[!0]),!1},m=function(e){return h.apply(e.data.field.get(0),[!0]),e.data.el.removeClass("colpick_slider").find("input").focus(),t(document).off("mouseup",m),t(document).off("mousemove",_),!1},b=function(e){e.preventDefault?e.preventDefault():e.returnValue=!1;var i={cal:t(this).parent(),y:t(this).offset().top};t(document).on("mouseup touchend",i,x),t(document).on("mousemove touchmove",i,y);var o="touchstart"==e.type?e.originalEvent.changedTouches[0].pageY:e.pageY;return h.apply(i.cal.data("colpick").fields.eq(4).val(parseInt(360*(i.cal.data("colpick").height-(o-i.y))/i.cal.data("colpick").height,10)).get(0),[i.cal.data("colpick").livePreview]),!1},y=function(t){var e="touchmove"==t.type?t.originalEvent.changedTouches[0].pageY:t.pageY;return h.apply(t.data.cal.data("colpick").fields.eq(4).val(parseInt(360*(t.data.cal.data("colpick").height-Math.max(0,Math.min(t.data.cal.data("colpick").height,e-t.data.y)))/t.data.cal.data("colpick").height,10)).get(0),[t.data.preview]),!1},x=function(e){return l(e.data.cal.data("colpick").color,e.data.cal.get(0)),n(e.data.cal.data("colpick").color,e.data.cal.get(0)),t(document).off("mouseup touchend",x),t(document).off("mousemove touchmove",y),!1},w=function(e){e.preventDefault?e.preventDefault():e.returnValue=!1;var i={cal:t(this).parent(),pos:t(this).offset()};i.preview=i.cal.data("colpick").livePreview,t(document).on("mouseup touchend",i,M),t(document).on("mousemove touchmove",i,I);var o,a;return"touchstart"==e.type?(o=e.originalEvent.changedTouches[0].pageX,a=e.originalEvent.changedTouches[0].pageY):(o=e.pageX,a=e.pageY),h.apply(i.cal.data("colpick").fields.eq(6).val(parseInt(100*(i.cal.data("colpick").height-(a-i.pos.top))/i.cal.data("colpick").height,10)).end().eq(5).val(parseInt(100*(o-i.pos.left)/i.cal.data("colpick").height,10)).get(0),[i.preview]),!1},I=function(t){var e,i;return"touchmove"==t.type?(e=t.originalEvent.changedTouches[0].pageX,i=t.originalEvent.changedTouches[0].pageY):(e=t.pageX,i=t.pageY),h.apply(t.data.cal.data("colpick").fields.eq(6).val(parseInt(100*(t.data.cal.data("colpick").height-Math.max(0,Math.min(t.data.cal.data("colpick").height,i-t.data.pos.top)))/t.data.cal.data("colpick").height,10)).end().eq(5).val(parseInt(100*Math.max(0,Math.min(t.data.cal.data("colpick").height,e-t.data.pos.left))/t.data.cal.data("colpick").height,10)).get(0),[t.data.preview]),!1},M=function(e){return l(e.data.cal.data("colpick").color,e.data.cal.get(0)),n(e.data.cal.data("colpick").color,e.data.cal.get(0)),t(document).off("mouseup touchend",M),t(document).off("mousemove touchmove",I),!1},C=function(){var e=t(this).parent(),i=e.data("colpick").color;e.data("colpick").origColor=i,f(i,e.get(0)),e.data("colpick").onSubmit(i,r(i),c(i),e.data("colpick").el)},q=function(e){e&&e.stopPropagation();var i=t("#"+t(this).data("colpickId"));e&&!i.data("colpick").polyfill&&e.preventDefault(),i.data("colpick").onBeforeShow.apply(this,[i.get(0)]);var o=t(this).offset(),a=o.top+this.offsetHeight,c=o.left,l=S(),r=i.width();c+r>l.l+l.w&&(c-=r),i.css({left:c+"px",top:a+"px"}),0!=i.data("colpick").onShow.apply(this,[i.get(0)])&&i.show(),t("html").mousedown({cal:i},T),i.mousedown(function(t){t.stopPropagation()})},T=function(e){var i=t("#"+t(this).data("colpickId"));e&&(i=e.data.cal),0!=i.data("colpick").onHide.apply(this,[i.get(0)])&&i.hide(),t("html").off("mousedown",T)},S=function(){var t="CSS1Compat"==document.compatMode;return{l:window.pageXOffset||(t?document.documentElement.scrollLeft:document.body.scrollLeft),w:window.innerWidth||(t?document.documentElement.clientWidth:document.body.clientWidth)}},E=function(t){return{h:Math.min(360,Math.max(0,t.h)),s:Math.min(100,Math.max(0,t.s)),b:Math.min(100,Math.max(0,t.b))}},D=function(t){return{r:Math.min(255,Math.max(0,t.r)),g:Math.min(255,Math.max(0,t.g)),b:Math.min(255,Math.max(0,t.b))}},P=function(t){var e=6-t.length;if(3==e){for(var i=[],o=0;e>o;o++)i.push(t[o]),i.push(t[o]);t=i.join("")}else if(e>0){for(var a=[],c=0;e>c;c++)a.push("0");a.push(t),t=a.join("")}return t},Y=function(){var e=t(this).parent(),i=e.data("colpick").origColor;e.data("colpick").color=i,l(i,e.get(0)),n(i,e.get(0)),d(i,e.get(0)),s(i,e.get(0)),p(i,e.get(0)),u(i,e.get(0))};return{init:function(c){if(c=t.extend({},i,c||{}),"auto"===c.color);else if("string"==typeof c.color)c.color=o(c.color);else if(void 0!=c.color.r&&void 0!=c.color.g&&void 0!=c.color.b)c.color=a(c.color);else{if(void 0==c.color.h||void 0==c.color.s||void 0==c.color.b)return this;c.color=E(c.color)}return this.each(function(){if(!t(this).data("colpickId")){var i=t.extend({},c);if("auto"===c.color&&(i.color=t(this).val()?o(t(this).val()):{h:0,s:0,b:0}),i.origColor=i.color,"function"==typeof c.polyfill&&(i.polyfill=c.polyfill(this)),i.polyfill&&t(this).is("input")&&"color"===this.type)return;var a="collorpicker_"+parseInt(1e3*Math.random());t(this).data("colpickId",a);var r=t(e).attr("id",a);r.addClass("colpick_"+i.layout+(i.submit?"":" colpick_"+i.layout+"_ns")),"light"!=i.colorScheme&&r.addClass("colpick_"+i.colorScheme),r.find("div.colpick_submit").html(i.submitText).click(C),i.fields=r.find("input").change(h).blur(v).focus(g),r.find("div.colpick_field_arrs").mousedown(k).end().find("div.colpick_current_color").click(Y),i.selector=r.find("div.colpick_color").on("mousedown touchstart",w),i.selectorIndic=i.selector.find("div.colpick_selector_outer"),i.el=this,i.hue=r.find("div.colpick_hue_arrs");var _=i.hue.parent(),m=navigator.userAgent.toLowerCase(),y="Microsoft Internet Explorer"===navigator.appName,x=y?parseFloat(m.match(/msie ([0-9]*[\.0-9]+)/)[1]):0,I=y&&10>x,M=["#ff0000","#ff0080","#ff00ff","#8000ff","#0000ff","#0080ff","#00ffff","#00ff80","#00ff00","#80ff00","#ffff00","#ff8000","#ff0000"];if(I){var T,S;for(T=0;11>=T;T++)S=t("<div></div>").attr("style","height:8.333333%; filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr="+M[T]+", endColorstr="+M[T+1]+'); -ms-filter: "progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='+M[T]+", endColorstr="+M[T+1]+')";'),_.append(S)}else{var E=M.join(",");_.attr("style","background:-webkit-linear-gradient(top,"+E+"); background: -o-linear-gradient(top,"+E+"); background: -ms-linear-gradient(top,"+E+"); background:-moz-linear-gradient(top,"+E+"); -webkit-linear-gradient(top,"+E+"); background:linear-gradient(to bottom,"+E+"); ")}r.find("div.colpick_hue").on("mousedown touchstart",b),i.newColor=r.find("div.colpick_new_color"),i.currentColor=r.find("div.colpick_current_color"),r.data("colpick",i),l(i.color,r.get(0)),d(i.color,r.get(0)),n(i.color,r.get(0)),p(i.color,r.get(0)),s(i.color,r.get(0)),f(i.color,r.get(0)),u(i.color,r.get(0)),i.flat?(r.appendTo(i.appendTo||this).show(),r.css(i.styles||{position:"relative",display:"block"})):(r.appendTo(i.appendTo||document.body),t(this).on(i.showEvent,q),r.css(i.styles||{position:"absolute"}))}})},showPicker:function(){return this.each(function(){t(this).data("colpickId")&&q.apply(this)})},hidePicker:function(){return this.each(function(){t(this).data("colpickId")&&T.apply(this)})},setColor:function(e,i){if(i="undefined"==typeof i?1:i,"string"==typeof e)e=o(e);else if(void 0!=e.r&&void 0!=e.g&&void 0!=e.b)e=a(e);else{if(void 0==e.h||void 0==e.s||void 0==e.b)return this;e=E(e)}return this.each(function(){if(t(this).data("colpickId")){var o=t("#"+t(this).data("colpickId"));o.data("colpick").color=e,o.data("colpick").origColor=e,l(e,o.get(0)),d(e,o.get(0)),n(e,o.get(0)),p(e,o.get(0)),s(e,o.get(0)),u(e,o.get(0)),o.data("colpick").onChange.apply(o.parent(),[e,r(e),c(e),o.data("colpick").el,1]),i&&f(e,o.get(0))}})},destroy:function(){t("#"+t(this).data("colpickId")).remove()}}}(),i=function(t){return t=parseInt(t.indexOf("#")>-1?t.substring(1):t,16),{r:t>>16,g:(65280&t)>>8,b:255&t}},o=function(t){return a(i(t))},a=function(t){var e={h:0,s:0,b:0},i=Math.min(t.r,t.g,t.b),o=Math.max(t.r,t.g,t.b),a=o-i;return e.b=o,e.s=0!=o?255*a/o:0,0!=e.s?t.r==o?e.h=(t.g-t.b)/a:t.g==o?e.h=2+(t.b-t.r)/a:e.h=4+(t.r-t.g)/a:e.h=-1,e.h*=60,e.h<0&&(e.h+=360),e.s*=100/255,e.b*=100/255,e},c=function(t){var e={},i=t.h,o=255*t.s/100,a=255*t.b/100;if(0==o)e.r=e.g=e.b=a;else{var c=a,l=(255-o)*a/255,r=(c-l)*(i%60)/60;360==i&&(i=0),60>i?(e.r=c,e.b=l,e.g=l+r):120>i?(e.g=c,e.b=l,e.r=c-r):180>i?(e.g=c,e.r=l,e.b=l+r):240>i?(e.b=c,e.r=l,e.g=c-r):300>i?(e.b=c,e.g=l,e.r=l+r):360>i?(e.r=c,e.g=l,e.b=c-r):(e.r=0,e.g=0,e.b=0)}return{r:Math.round(e.r),g:Math.round(e.g),b:Math.round(e.b)}},l=function(e){var i=[e.r.toString(16),e.g.toString(16),e.b.toString(16)];return t.each(i,function(t,e){1==e.length&&(i[t]="0"+e)}),i.join("")},r=function(t){return l(c(t))};t.fn.extend({colpick:e.init,colpickHide:e.hidePicker,colpickShow:e.showPicker,colpickSetColor:e.setColor,colpickDestroy:e.destroy}),t.extend({colpick:{rgbToHex:l,rgbToHsb:a,hsbToHex:r,hsbToRgb:c,hexToHsb:o,hexToRgb:i}})});