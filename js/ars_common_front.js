function ars_counter_animation(){jQuery.isFunction(jQuery().animateNumber)&&jQuery(".ars_animate_counter").each(function(){var a,e,r,t=jQuery(this).attr("data-count"),o=jQuery(this).attr("data-format"),_=(t=arsocialshare_format_numbers(t,o)).split("~|~"),l=_[1],i=_[0];-1<i.indexOf("k")||-1<i.indexOf("m")||-1<i.indexOf("b")||-1<i.indexOf("t")?(a=new RegExp(/^-?(\d+)(\.\d+)?(.*)$/,"g"),i=(e=i).replace(a,"$1"),r=e.replace(a,"$2"),i+=r,i=parseFloat(i),l=e.replace(a,"$3"),jQuery.animateNumber.numberStepFactories.append(l)):(i=i.replace(l,""),jQuery.animateNumber.numberStepFactories.separator(l));var n=jQuery(this);jQuery(n).animateNumber({number:i,easing:"easeInQuad",numberStep:function(a,e){var r=jQuery(e.elem);a=-1===i.toString().indexOf(".")?a.toFixed(0):a.toFixed(1),-1<["k","m","b","t"].indexOf(l)?r.text(a+l):(a=ars_check_number_format(a,0,"",l),r.text(a))}},1e3,"linear")})}function ars_check_number_format(a,e,r,t){a=(a+"").replace(/[^0-9+\-Ee.]/g,"");var o,_,l,i=isFinite(+a)?+a:0,n=isFinite(+e)?Math.abs(e):0,s=void 0===t?",":t,p=void 0===r?".":r,u="";return 3<(u=(n?(o=i,_=n,l=Math.pow(10,_),""+(Math.round(o*l)/l).toFixed(_)):""+Math.round(i)).split("."))[0].length&&(u[0]=u[0].replace(/\B(?=(?:\d{3})+(?!\d))/g,s)),(u[1]||"").length<n&&(u[1]=u[1]||"",u[1]+=new Array(n-u[1].length+1).join("0")),u.join(p)}function arsocialshare_format_numbers(a,e){var r=a||0,t=convert_formated_numbers_to_value(r),o="";switch(e){case"style1":r=ars_check_number_format(t,0,"",""),o="";break;case"style2":r=ars_check_number_format(t=t.replace(".",""),0,"","."),o=".";break;case"style3":r=ars_check_number_format(t=t.replace(",",""),0,"",","),o=",";break;case"style4":r=ars_check_number_format(t=t.replace(" ",""),0,""," "),o=" ";break;case"style5":default:r=abbrNum(t,2)}return r+"~|~"+o}function convert_formated_numbers_to_value(a){var e;return-1<a.indexOf("k")?(e=(e=a.replace("k","")).replace(",",""),1e3*parseFloat(e)):-1<a.indexOf("m")?(e=(e=a.replace("m","")).replace(",",""),1e6*parseFloat(e)):a}function abbrNum(a,e){e=Math.pow(10,e);for(var r=["k","m","b","t"],t=r.length-1;0<=t;t--){var o=Math.pow(10,3*(t+1));if(o<=a){1e3==(a=Math.round(a*e/o)/e)&&t<r.length-1&&(a=1,t++),a+=r[t];break}}return a}function ars_global_like_settings(){return document.getElementById("ars_global_like_settings").value}function ars_like_shortcode_settings(){return document.getElementById("ars_like_shortcode_settings").value}function arsocialshare_options(){return document.getElementById("arsocialshare_options").value}function ars_global_fan_settings(){return document.getElementById("ars_global_fan_settings").value}function ars_batch_lock_opts(){return document.getElementById("ars_batch_lock_opts").value}function ars_locker_options(){return document.getElementById("ars_locker_options").value}function ars_global_settings(){return document.getElementById("ars_global_settings").value}"undefined"!=typeof angular&&angular.element(document).ready(function(){!function(a){function e(a){a&&r.push(a)}for(var r=[a],t=[],o=[],_=["ng:module","ng-module","x-ng-module","data-ng-module","ng:modules","ng-modules","x-ng-modules","data-ng-modules"],l=/\sng[:\-]module[s](:\s*([\w\d_]+);?)?\s/,i=0;i<_.length;i++){var n=_[i];if(e(document.getElementById(n)),n=n.replace(":","\\:"),a.querySelectorAll){for(var s=a.querySelectorAll("."+n),p=0;p<s.length;p++)e(s[p]);s=a.querySelectorAll("."+n+"\\:");for(p=0;p<s.length;p++)e(s[p]);s=a.querySelectorAll("["+n+"]");for(p=0;p<s.length;p++)e(s[p])}}for(i=0;i<r.length;i++){var u=" "+(a=r[i]).className+" ",c=l.exec(u);if(c)t.push(a),o.push((c[2]||"").replace(/\s+/g,","));else if(a.attributes)for(p=0;p<a.attributes.length;p++){var y=a.attributes[p];-1!=_.indexOf(y.name)&&(t.push(a),o.push(y.value))}}for(i=0;i<t.length;i++){var d=t[i],f=o[i].replace(/ /g,"").split(",");try{angular.bootstrap(d,f)}catch(a){}}}(document)}),jQuery(document).ready(function(){var a,e,r,t,o,_,l,i,n,s,p;"undefined"!=jQuery("#ars_page_id").val()&&"undefined"!=jQuery("#ars_locker_id").val()&&(localStorage.getItem("arsocial_lite_locker_"+jQuery("#ars_locker_id").val()+"_"+jQuery("#ars_page_id").val())&&(a="__ARSLOCKER__"+jQuery("#ars_locker_id").val(),e=jQuery("#ars_locker_id").val(),jQuery("#arsocial_lite_locker_"+e).find("#arsociallocker_popup").hide(),jQuery("#"+a).show(),ars_front_show_locked_content(a,e)),"function"==typeof ars_locker_options&&document.getElementById("ars_locker_options")&&(r=ars_locker_options(),o=(t=JSON.parse(r)).locker_id,_=t.container,"undefined"!=typeof Storage&&(l=jQuery("#ars_page_id").val(),localStorage.getItem("arsocial_lite_locker_"+o+"_"+l)===_&&(jQuery("#arsocial_lite_locker_"+o).find(".arsocial_lite_locker_popup").remove(),jQuery(".arsocialshare_locked_content#"+_).show(),"function"==typeof ars_batch_lock_opts&&document.getElementById("ars_batch_lock_opts")&&(i=ars_batch_lock_opts(),!(n=JSON.parse(i)).is_element_lock||""!=(s=n.class_elements)&&(p=s.split(","),jQuery(p).each(function(a){p[a]=p[a].trim(),jQuery("."+p[a]).show()}))),ars_front_show_locked_content(_,o)))));function u(){var a=jQuery(window).scrollTop();f<a||h<a||j<a?(c.addClass("ars_sticky_top_belt"),y.addClass("ars_sticky_top_belt"),d.addClass("ars_sticky_top_belt")):(c.removeClass("ars_sticky_top_belt"),y.removeClass("ars_sticky_top_belt"),d.removeClass("ars_sticky_top_belt"))}var c=jQuery('.arsocialshare_network_button_settings[data-enable-floating="1"]'),y=jQuery('.arsocialshare_network_like_button_settings[data-enable-floating="1"]'),d=jQuery('.arsocialshare_network_fan_button_settings[data-enable-floating="1"]'),f=0<c.length?c.offset().top:0,h=0<y.length?y.offset().top:0,j=0<d.length?d.offset().top:0;u(),jQuery(window).scroll(function(){u()}),ars_counter_animation()}),jQuery(document).on("click",'#arsocial_lite_fly_more_btn,#arsocial_lite_more_button_icon[data-action="display_popup"]',function(){var a=jQuery(this).attr("data-page-id"),e=jQuery(this).attr("data-network-id"),r=jQuery("#arsocialshare_admin_ajaxurl").val(),t=jQuery(this).attr("data-skin"),o=jQuery(this).attr("data-button-style"),_=jQuery(this).attr("data-show-counter"),l=jQuery(this).attr("data-type"),i=jQuery(this).attr("data-button-width"),n=jQuery(this).attr("data-effect"),s=jQuery(this).attr("data-custom_names"),p=jQuery(this).attr("data-all-networks"),u=jQuery(this).attr("data-number-format");jQuery(".arsocial_lite_more_network_model").remove(),jQuery.ajax({url:r,type:"post",dataType:"json",data:"action=arsocial_lite_get_more_networks&post_id="+a+"&network_id="+e+"&theme="+t+"&counter="+_+"&button_style="+o+"&effect="+n+"&display_from="+l+"&button_width="+i+"&custom_names="+s+"&all_networks="+p+"&number_format="+u,success:function(a){a.status&&(jQuery("body").append(a.content),jQuery("#arsocial_lite_more_network_model").bPopup())}})}),jQuery(document).on("click",".arsocial_lite_model_close_btn",function(){jQuery("#arsocial_lite_more_network_model").bPopup().close(),"ars_fan_model"===jQuery(this).attr("id")&&jQuery("#arsfan_more_network_model").bPopup().close()}),jQuery(document).on("click","#arsocial_lite_more_button_icon",function(){var a=jQuery(this).attr("data-no");if("display_inline"===jQuery(this).attr("data-action")){if(jQuery(this).parents().hasClass("arsocialshare_media_wrapper"))return console.log(jQuery(this).closest(".arsocialshare_media_wrapper").find(".arsocialshare_button")),jQuery(this).closest(".arsocialshare_media_wrapper").find('.arsocialshare_button[data-no="'+a+'"]').toggleClass("arsocialshare_hidden_buttons"),jQuery(this).find("span").toggleClass("socialshare-plus"),jQuery(this).find("span").toggleClass("socialshare-dot-3"),void jQuery(this).find("span").toggleClass("socialshare-minus");jQuery('.arsocialshare_button[data-no="'+a+'"]').toggleClass("arsocialshare_hidden_buttons"),jQuery(this).find("span").toggleClass("socialshare-plus"),jQuery(this).find("span").toggleClass("socialshare-dot-3"),jQuery(this).find("span").toggleClass("socialshare-minus")}}),jQuery(document).on("click","#ars_lite_fan_more_button_icon",function(){var a=jQuery(this).attr("data-on");"display_inline"===jQuery(this).attr("data-action")&&(jQuery('.ars_lite_fan_main_wrapper ul li[data-on="'+a+'"]').toggleClass("ars_fan_hidden_buttons"),jQuery(this).find("i").toggleClass("socialshare-plus"),jQuery(this).find("i").toggleClass("socialshare-dot-3"),jQuery(this).find("i").toggleClass("socialshare-minus"))}),jQuery(document).on("click",'#ars_lite_fan_more_button_icon[data-action="display_popup"]',function(){var a=jQuery(this).attr("data-page-id"),e=jQuery(this).attr("data-network-id"),r=jQuery(this).attr("data-skin"),t=jQuery(this).attr("data-display-from"),o=jQuery(this).attr("data-counter-format"),_=jQuery("#arsocialshare_admin_ajaxurl").val();jQuery(".arsocial_lite_more_network_model#arsfan_more_network_model").remove(),jQuery.ajax({url:_,type:"POST",dataType:"json",data:"action=ars_lite_fan_get_networks&post_id="+a+"&network_id="+e+"&skin="+r+"&post_type="+t+"&display_format="+o,success:function(a){console.log(a),jQuery("body").append(a.content),jQuery("#arsfan_more_network_model").bPopup()}})}),jQuery(document).ready(function(){var a,e,r,t,o,_,l,i,n,s,p,u=jQuery("#arsocialshare_popup_wrapper").attr("data-is_popup"),c=jQuery("#arsocialshare_fly_in_wrapper").attr("data-is_fly_in"),y=jQuery("#arsociallike_fly_in_wrapper").attr("data-is_fly_in"),d=jQuery("#arsocial_lite_like_popup_wrapper").attr("data-is_popup"),f=jQuery("#arsocialfan_fly_in_wrapper").attr("data-is_fly_in"),h=jQuery("#arsocialfan_popup_wrapper").attr("data-is_popup");"true"==u&&(u=jQuery("#arsocialshare_popup_wrapper").attr("data-is_popup"),_=jQuery("#arsocialshare_popup_wrapper").attr("data-popup_close_button"),jQuery("#arsocialshare_popup_wrapper").attr("data-popup_height"),jQuery("#arsocialshare_popup_wrapper").attr("data-popup_width"),l=jQuery("#arsocialshare_popup_wrapper").attr("data-popup_open_delay"),i=jQuery("#arsocialshare_popup_wrapper").attr("data-popup_open_scroll"),"popup_onload"==jQuery("#arsocialshare_popup_wrapper").attr("data-popup_type")?(n=0,""!=l&&(n=parseInt(1e3*l)),setTimeout(function(){jQuery("#arsocialshare_popup_wrapper").bPopup({modalClose:"true"==_,escClose:!1})},n)):(s=parseInt(i),p=!1,jQuery(window).scroll(function(){var a=jQuery(document).height()-jQuery(window).height(),e=jQuery(window).scrollTop(),r=parseInt(e/a*100);s<=r&&0==p&&(jQuery("#arsocialshare_popup_wrapper").bPopup({modalClose:"true"==_,escClose:!1}),p=!0)}))),"true"==c&&(jQuery("#arsocialshare_fly_in_wrapper").attr("data-fly_in_position"),a=jQuery("#arsocialshare_fly_in_wrapper").attr("data-fly_in_type"),e=jQuery("#arsocialshare_fly_in_wrapper").attr("data-fly_in_open_delay"),r=jQuery("#arsocialshare_fly_in_wrapper").attr("data-fly_in_open_scroll"),jQuery("#arsocialshare_fly_in_wrapper").attr("data-fly_in_width"),jQuery("#arsocialshare_fly_in_wrapper").attr("data-fly_in_height"),jQuery("#arsocialshare_fly_in_wrapper").attr("data-fly_in_close_button"),"fly_in_onload"==a?(n=0,""!=e&&(n=parseInt(1e3*e)),setTimeout(function(){jQuery("#arsocialshare_fly_in_wrapper").fadeIn("slow")},n)):(t=parseInt(r),o=!1,jQuery(window).scroll(function(){var a=jQuery(document).height()-jQuery(window).height(),e=jQuery(window).scrollTop(),r=parseInt(e/a*100);t<=r&&0==o&&(jQuery("#arsocialshare_fly_in_wrapper").fadeIn("slow"),o=!0)}))),"true"==y&&(jQuery("#arsociallike_fly_in_wrapper").attr("data-fly_in_position"),a=jQuery("#arsociallike_fly_in_wrapper").attr("data-fly_in_type"),e=jQuery("#arsociallike_fly_in_wrapper").attr("data-fly_in_open_delay"),r=jQuery("#arsociallike_fly_in_wrapper").attr("data-fly_in_open_scroll"),jQuery("#arsociallike_fly_in_wrapper").attr("data-fly_in_width"),jQuery("#arsociallike_fly_in_wrapper").attr("data-fly_in_height"),jQuery("#arsociallike_fly_in_wrapper").attr("data-fly_in_close_button"),"fly_in_onload"==a?(n=0,""!=e&&(n=parseInt(1e3*e)),setTimeout(function(){jQuery("#arsociallike_fly_in_wrapper").fadeIn("slow")},n)):(t=parseInt(r),o=!1,jQuery(window).scroll(function(){var a=jQuery(document).height()-jQuery(window).height(),e=jQuery(window).scrollTop(),r=parseInt(e/a*100);t<=r&&0==o&&(jQuery("#arsociallike_fly_in_wrapper").fadeIn("slow"),o=!0)}))),"true"==f&&(jQuery("#arsocialfan_fly_in_wrapper").attr("data-fly_in_position"),a=jQuery("#arsocialfan_fly_in_wrapper").attr("data-fly_in_type"),e=jQuery("#arsocialfan_fly_in_wrapper").attr("data-fly_in_open_delay"),r=jQuery("#arsocialfan_fly_in_wrapper").attr("data-fly_in_open_scroll"),jQuery("#arsocialfan_fly_in_wrapper").attr("data-fly_in_width"),jQuery("#arsocialfan_fly_in_wrapper").attr("data-fly_in_height"),jQuery("#arsocialfan_fly_in_wrapper").attr("data-fly_in_close_button"),"fly_in_onload"==a?(n=0,""!=e&&(n=parseInt(1e3*e)),setTimeout(function(){jQuery("#arsocialfan_fly_in_wrapper").fadeIn("slow")},n)):(t=parseInt(r),o=!1,jQuery(window).scroll(function(){var a=jQuery(document).height()-jQuery(window).height(),e=jQuery(window).scrollTop(),r=parseInt(e/a*100);t<=r&&0==o&&(jQuery("#arsocialfan_fly_in_wrapper").fadeIn("slow"),o=!0)}))),"true"==d&&(u=jQuery("#arsocial_lite_like_popup_wrapper").attr("data-is_popup"),_=jQuery("#arsocial_lite_like_popup_wrapper").attr("data-popup_close_button"),jQuery("#arsocial_lite_like_popup_wrapper").attr("data-popup_height"),jQuery("#arsocial_lite_like_popup_wrapper").attr("data-popup_width"),l=jQuery("#arsocial_lite_like_popup_wrapper").attr("data-popup_open_delay"),i=jQuery("#arsocial_lite_like_popup_wrapper").attr("data-popup_open_scroll"),"onload"==jQuery("#arsocial_lite_like_popup_wrapper").attr("data-popup_type")?(n=0,""!=l&&(n=parseInt(1e3*l)),setTimeout(function(){jQuery("#arsocial_lite_like_popup_wrapper").bPopup({modalClose:"true"==_})},n)):(s=parseInt(i),p=!1,jQuery(window).scroll(function(){var a=jQuery(document).height()-jQuery(window).height(),e=jQuery(window).scrollTop(),r=parseInt(e/a*100);s<=r&&0==p&&(jQuery("#arsocial_lite_like_popup_wrapper").bPopup({modalClose:"true"==_}),p=!0)}))),"true"==h&&(u=jQuery("#arsocialfan_popup_wrapper").attr("data-is_popup"),_=jQuery("#arsocialfan_popup_wrapper").attr("data-popup_close_button"),jQuery("#arsocialfan_popup_wrapper").attr("data-popup_height"),jQuery("#arsocialfan_popup_wrapper").attr("data-popup_width"),l=jQuery("#arsocialfan_popup_wrapper").attr("data-popup_open_delay"),i=jQuery("#arsocialfan_popup_wrapper").attr("data-popup_open_scroll"),"popup_onload"==jQuery("#arsocialfan_popup_wrapper").attr("data-popup_type")?(n=0,""!=l&&(n=parseInt(1e3*l)),setTimeout(function(){jQuery("#arsocialfan_popup_wrapper").bPopup({modalClose:"true"==_})},n)):(s=parseInt(i),p=!1,jQuery(window).scroll(function(){var a=jQuery(document).height()-jQuery(window).height(),e=jQuery(window).scrollTop(),r=parseInt(e/a*100);s<=r&&0==p&&(jQuery("#arsocialfan_popup_wrapper").bPopup({modalClose:"true"==_}),p=!0)}))),(jQuery(".arsocialshare_network_button_settings").hasClass("ars_sticky_bottom_belt")||jQuery(".arsocialshare_network_like_button_settings").hasClass("ars_sticky_bottom_belt")||jQuery(".arsocialshare_network_fan_button_settings").hasClass("ars_sticky_bottom_belt"))&&jQuery(window).scroll(function(){var a=jQuery(document).height()-jQuery(window).height(),e=jQuery(window).scrollTop();25<=parseInt(e/a*100)?jQuery(".ars_sticky_bottom_belt").slideDown("slow"):jQuery(".ars_sticky_bottom_belt").slideUp("slow")})}),jQuery(document).on("click","#arsocial_lite_popup_wrapper_close",function(a){return a.preventDefault(),jQuery("#arsocialshare_popup_wrapper").bPopup().close(),!1}),jQuery(document).on("click","#arsocial_lite_fly_in_close",function(){return jQuery("#arsocialshare_fly_in_wrapper").fadeOut("slow"),!1}),jQuery(document).on("click","#arsocial_lite_like_fly_in_close",function(){return jQuery("#arsociallike_fly_in_wrapper").fadeOut("slow"),!1}),jQuery(document).on("click","#arsocial_lite_fan_fly_in_close",function(){return jQuery("#arsocialfan_fly_in_wrapper").fadeOut("slow"),!1}),jQuery(document).on("click","#arsocial_lite_like_popup_wrapper_close",function(a){return a.preventDefault(),jQuery("#arsocial_lite_like_popup_wrapper").bPopup().close(),!1}),jQuery(document).on("click","#arsocial_lite_fan_popup_wrapper_close",function(a){return a.preventDefault(),jQuery("#arsocialfan_popup_wrapper").bPopup().close(),!1}),jQuery(document).on("click","#arsocial_lite_share_button_bar_wrapper, #arsocialshare_share_point_wrapper,#arsocialshare_mobile_button_icon",function(){jQuery("#arsocialshare_mobile_wrapper").fadeIn()}),jQuery(document).on("click","#arsocial_lite_like_mobile_more_wraper,#arsocialshare_like_point_wrapper,#arsocialshare_like_button_bar_wrapper",function(){jQuery("#arsocial_like_mobile_wrapper").fadeIn()}),jQuery(document).on("click","#ars_fan_mobile_more_button_icon,#arsocialshare_fan_point_wrapper,#arsocialshare_fan_button_bar_wrapper",function(){jQuery("#arsocial_fan_mobile_wrapper").fadeIn()}),jQuery(document).on("click","#arsocialshare_mobile_close",function(){jQuery("#arsocialshare_mobile_wrapper").fadeOut(),jQuery("#arsocial_like_mobile_wrapper").fadeOut(),jQuery("#arsocial_fan_mobile_wrapper").fadeOut()});