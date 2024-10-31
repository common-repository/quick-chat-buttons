(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

    var tempString = 0;
    var isInMobile = false;

     $(document).ready(function () {

         if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
             || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
             isInMobile = true;
         }

         $(quick_btn_settings.buttons).each ( function () {
             console.log(quick_btn_settings.buttons);
             $(quick_btn_settings.buttons).each ( function(key,button) {
                 buttonPreview(button.channel_setting,button.customize_setting,button.id,button.trigger_setting);
             });

         });

         $(document).on("click", ".qcb-content:not(.has-single-button) .qcb-main-button a", function(e){
             e.preventDefault();
             $(this).closest(".qcb-content").toggleClass("show-icons");
         });

     });

     /* Create widget */
    function buttonPreview(channel,settings,id,trigger_settings) {

        var previewHtml = "";
        if(channel.length) {
            var tooltipPos = settings.position;
            var buttonPos = settings.position;
            var state = settings.icon_state;
            var icon_view = settings.icon_view;
            var cta_icon = settings.cta_icon;
            var button_text = settings.cta_text;
            var activeButtons = channel.length;

            buttonPos = (buttonPos == "left") ? "left" : "right";
            tooltipPos = (tooltipPos == "left") ? "right" : "left";

            if (activeButtons == 1) {

                var mainButton = "<div class='qcb-main-button'>";
                $(channel).each(function (key, value) {
                    mainButton += "<div class='chat-btn check-device " + value.desktop + " " + value.mobile + "'>";
                    if ($.trim(button_text) != "") {
                        mainButton += "<div class='kl-button-text kl-pos-" + tooltipPos + "'>" + button_text + "</div>";
                    }
                    mainButton += "<a href='" + value.link + "' target='" + value.target + "' rel='nofollow' class='channel-btn active " + value.channel + "-button'>";
                    mainButton += value.icon;
                    mainButton += "</a>";
                    mainButton += "</div>";
                });
                mainButton += "</div>";

                previewHtml = "<div class='qcb-content has-single-button qcb-" + buttonPos + " qcb-" + id + " active'>";
                previewHtml += mainButton;
                previewHtml += "</div>";

            } else {
                var mainButton = "<div class='qcb-main-button'>";
                mainButton += "<div class='chat-btn'>";
                if ($.trim(button_text) != "") {
                    mainButton += "<div class='kl-button-text kl-pos-" + tooltipPos + "'>" + button_text + "</div>"
                }
                mainButton += "<a href='javascript:;' class='channel-btn active'>";
                mainButton += "<span class='kl-main-icon'>";
                mainButton += cta_icon;
                mainButton += "</span>";
                mainButton += "<span class='kl-close-icon'>";
                mainButton += '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M18.83 16l8.6-8.6a2 2 0 0 0-2.83-2.83l-8.6 8.6L7.4 4.6a2 2 0 0 0-2.82 2.82l8.58 8.6-8.58 8.6a2 2 0 1 0 2.83 2.83l8.58-8.6 8.6 8.6a2 2 0 0 0 2.83-2.83z"></path></svg>';
                mainButton += "</span>";
                mainButton += "</a>";
                mainButton += "</div>";
                mainButton += "</div>";

                var channelButtons = "";
                if (icon_view == "horizontal") {
                    tooltipPos = "top";
                }
                $(channel).each(function (key, value) {
                    var new_hover_text = "";
                    if (value.hover_text != null) {
                        new_hover_text = value.title + value.hover_text;
                    } else {
                        new_hover_text = value.title;
                    }
                    channelButtons += "<div class='chat-btn check-device " + value.desktop + " " + value.mobile + "'>";
                    channelButtons += "<a href='" + value.link + "' target='" + value.target + "' rel='nofollow' class='channel-btn kl-tooltip kl-pos-" + tooltipPos + " active " + value.channel + "-button'>";
                    if (new_hover_text != '') {
                        channelButtons += "<span class='kl-button-text'>" + new_hover_text + "</span>";
                    }
                    channelButtons += value.icon;
                    channelButtons += "</a>";
                    channelButtons += "</div>";
                });

                previewHtml = "<div class='qcb-content qcb-" + buttonPos + " qcb-" + icon_view + " qcb-" + id + " active'>";
                previewHtml += "<div class='qcb-buttons'>";
                previewHtml += channelButtons;
                previewHtml += "</div>";
                previewHtml += mainButton;
                previewHtml += "</div>";

            }
            $("body").append(previewHtml);

            setButtonsForMobileOrDesktop(id);

            $(document).on("mouseenter", ".qcb-content.qcb-" + id, function () {
                if (state == "hover_to_open" && !isInMobile && ($(".qcb-" + id + " .qcb-buttons .chat-btn").length > 1)) {
                    $(this).addClass("show-icons");
                    setCookie("qcb-" + id, true, 2);
                    $(".qcb-" + id + " .qcb-main-button .chat-btn a").removeClass(settings.attention_effect);
                }
            });

            if ($(".qcb-" + id + " .qcb-buttons .chat-btn").length == 1) {
                $(".qcb-content.qcb-" + id).addClass("has-single-button");
                $(".qcb-" + id + " .qcb-main-button .chat-btn").remove();
                $(".qcb-" + id + " .qcb-main-button").prepend($(".qcb-" + id + " .qcb-buttons").html());
                $(".qcb-" + id + " .qcb-main-button .chat-btn a").removeClass("kl-pos-" + tooltipPos + " kl-tooltip");
                tooltipPos = (buttonPos == "left") ? "right" : "left";
                if($(".qcb-" + id + " .qcb-main-button .chat-btn .kl-button-text").length == 1) {
                    $(".qcb-" + id + " .qcb-main-button .chat-btn .kl-button-text").remove();
                    $(".qcb-" + id + " .qcb-main-button .chat-btn").prepend("<div class='kl-button-text kl-pos-" + tooltipPos + "'>" + settings.cta_text + "</div>")
                } else {
                    $(".qcb-" + id + " .qcb-main-button .chat-btn").prepend("<div class='kl-button-text kl-pos-" + tooltipPos + "'>" + settings.cta_text + "</div>");
                }
                $(".qcb-" + id + " .qcb-buttons .chat-btn").hide();
            }

            if ($(".qcb-" + id + " .qcb-buttons .chat-btn").length == 0 && activeButtons > 1) {
                $(".qcb-content.qcb-" + id).remove();
            }

            if (state == "open_by_default" && ($(".qcb-" + id + " .qcb-buttons .chat-btn").length > 1)) {
                $(".qcb-" + id).addClass("show-icons");
            }

            $(document).on("click", ".qcb-" + id + " .qcb-main-button a", function () {
                setCookie("qcb-" + id, true, 2);
                $(".kl-pending-message").remove();
                $(".qcb-" + id + " .qcb-main-button .chat-btn a").removeClass(settings.attention_effect);
            });

            if (state == "open_by_default" && settings.hide_close_btn == 1 && ($(".qcb-" + id + " .qcb-buttons .chat-btn").length > 1)) {
                $(".qcb-" + id).addClass("hide-close-button");
                $(".qcb-" + id + " .qcb-main-button").remove();
            }

            attention_effect(id, settings);

            makePreviewCss(channel,settings,id);

            setPendingMessage(settings, id, channel);

            checkForAfterSeconds(trigger_settings, id);

            checkForAfterPageScroll(trigger_settings, id);
        }

    }

    /* Widget CSS */
    function makePreviewCss(channel,settings,id) {
        var activeButtons = channel.length;
        var icon_view = settings.icon_view;
        var buttonSize = parseInt(settings.button_size);
        var buttonPosition = settings.position;
        var buttonCSS = "";
        if(activeButtons > 1) {
            var verticalActiveBtn = $(".qcb-"+id+" .qcb-buttons .chat-btn").length;
            buttonCSS += ".qcb-content.qcb-"+id+" .qcb-buttons .chat-btn {transform: scale(0.5) translate(0, " + ((buttonSize + 10)) + "px) }";
            $(".qcb-"+id+" .qcb-buttons .chat-btn").each(function(i) {
                buttonCSS += ".qcb-"+id+".show-icons .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(0, -" + ((buttonSize + 10) * (verticalActiveBtn-- -1)) + "px)}";
            });

            var horizontalActiveBtn = $(".qcb-"+id+" .qcb-buttons .chat-btn").length;
            if(icon_view == "horizontal") {
                buttonCSS += ".qcb-content.qcb-"+icon_view+" .qcb-buttons .chat-btn {transform: scale(0.5) translate(0, " + ((buttonSize) * 2) + "px) }";
                $(".qcb-"+id+" .qcb-buttons .chat-btn").each(function(i) {
                    if(buttonPosition == "left") {
                        buttonCSS += ".qcb-"+id+".qcb-"+icon_view+".show-icons .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(" + (((buttonSize + 10) * (horizontalActiveBtn-- +1)) - (buttonSize + 10)) + "px, " + (buttonSize + 10) + "px)}";
                    } else {
                        buttonCSS += ".qcb-"+id+".qcb-"+icon_view+".show-icons .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(-" + (((buttonSize + 10) * (horizontalActiveBtn-- +1)) - (buttonSize + 10)) + "px, " + (buttonSize + 10) + "px)}";
                    }
                });
            }
        }

        buttonCSS += ".qcb-"+id+" {bottom: " + settings.bottom_position + "px; }";
        buttonCSS += ".qcb-"+id+".qcb-left {left: " + settings.side_position + "px; }";
        buttonCSS += ".qcb-"+id+".qcb-right {right: " + settings.side_position + "px; }";

        var buttonPadding = parseInt(2 * buttonSize / 9);
        buttonCSS += ".qcb-"+id+" .chat-btn {width: "+(buttonSize+10)+"px; height: "+(buttonSize+10)+"px;}";
        buttonCSS += ".qcb-"+id+" .channel-btn {width: "+buttonSize+"px; height: "+buttonSize+"px;}";
        buttonCSS += ".qcb-"+id+" .channel-btn {padding: "+(buttonPadding)+"px;}";

        var spanSize = (parseInt(buttonSize)+10) - (2*parseInt(buttonPadding));
        buttonCSS += ".qcb-"+id+" .kl-main-icon, .qcb-"+id+" .kl-close-icon {width: "+spanSize+"px; height: "+spanSize+"px; }";
        buttonCSS += ".qcb-"+id+" .qcb-main-button .chat-btn {width: "+(buttonSize+20)+"px; height: "+(buttonSize+20)+"px;}";
        buttonCSS += ".qcb-"+id+" .qcb-main-button .channel-btn {width: "+(buttonSize+10)+"px; height: "+(buttonSize+10)+"px;}";

        buttonCSS += ".qcb-"+id+".show-icons .qcb-main-button .channel-btn {width: "+(buttonSize)+"px; height: "+(buttonSize)+"px;}";
        buttonCSS += ".qcb-"+id+".show-icons .kl-main-icon, .qcb-"+id+".show-icons .kl-close-icon {width: "+(spanSize - 10)+"px; height: "+(spanSize -10)+"px; }";

        var messageWidth = (buttonSize * 20) / 54;
        var messageHeight = (buttonSize * 20) / 54;
        buttonCSS += ".qcb-"+id+" .kl-pending-message {width: " + messageWidth + "px !important; height: " + messageHeight + "px !important; line-height: " + ((messageHeight / 2))  + "px; font-size: " + (parseInt(messageHeight / 4) + 4) + "px;}";
        buttonCSS += ".qcb-"+id+" .kl-pending-message {background-color: " + settings.message_bg_color + "; border-color: " + settings.message_border_color + "; color: " + settings.message_text_color + "}";

        var verticalActiveBtn = $(".qcb-"+id+" .qcb-buttons .chat-btn").length;
        $(".qcb-"+id+" .qcb-buttons .chat-btn").each(function(i) {
            if(buttonPosition == "left") {
                buttonCSS += ".qcb-"+id+".qcb-content.show-icons.hide-close-button .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(0, -" + ((buttonSize + 10) * (verticalActiveBtn-- -1)) + "px)}";
            } else {
                buttonCSS += ".qcb-"+id+".qcb-content.show-icons.hide-close-button .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(-"+ (buttonSize + 10) +"px, -" + ((buttonSize + 10) * (verticalActiveBtn-- -1)) + "px)}";
            }
        });

        var horizontalActiveBtn = $(".qcb-"+id+" .qcb-buttons .chat-btn").length;
        $(".qcb-"+id+" .qcb-buttons .chat-btn").each(function(i) {
            if(buttonPosition == "left") {
                buttonCSS += ".qcb-"+id+".qcb-content.qcb-horizontal.show-icons.hide-close-button .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(" + (((buttonSize + 10) * (horizontalActiveBtn-- -1))) + "px, 0)}";
            } else {
                buttonCSS += ".qcb-"+id+".qcb-content.qcb-horizontal.show-icons.hide-close-button .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(-" + (((buttonSize + 10) * (horizontalActiveBtn-- +1)) - (buttonSize + 10)) + "px, 0)}";
            }
        });

        $(channel).each(function (key, value){
            if(value.channel != "instagram" || (value.channel == "instagram" && value.bg_color != "#df0079" && value.bg_color != "rgba(223, 0, 121, 1)")) {
                buttonCSS += ".qcb-"+id+" a.channel-btn." + value.channel + "-button {background: " + value.bg_color + " !important}";
            }

            buttonCSS += ".qcb-"+id+" a.channel-btn."+value.channel+"-button svg {fill: "+ value.icon_color +"}";
            if(value.channel == "slack" && value.icon_color != "#ffffff" && value.icon_color != "rgba(255, 255, 255, 1)") {
                buttonCSS += ".qcb-"+id+" a.channel-btn."+value.channel+"-button svg path {fill: "+ value.icon_color +"}";
            }
        });

        buttonCSS += '.qcb-'+id+' .qcb-main-button .chat-btn a{background-color:'+settings.btn_bg_color+';}';
        buttonCSS += '.qcb-'+id+':not(.has-single-button) .qcb-main-button .chat-btn a svg, .qcb-'+id+':not(.has-single-button) .qcb-main-button .chat-btn a svg path {fill:'+settings.btn_icon_color+' !important;}';

        $("head").append("<style>"+buttonCSS+"</style>");

    }

    /* Add attention effect */
    function attention_effect(id, settings) {
        var checkCookie = getCookie("qcb-"+id);
        var state = settings.icon_state;
        if (!checkCookie) {
            if(state == "open_by_default") {
                $(".qcb-" + id + " .qcb-main-button .chat-btn a").removeClass(settings.attention_effect);
            } else {
                $(".qcb-" + id + " .qcb-main-button .chat-btn a").addClass(settings.attention_effect);
            }
        }
    }

    /* Set pending message */
    function setPendingMessage(settings, id, channel) {
        var checkCookie = getCookie("qcb-"+id);
        var state = settings.icon_state;
        var activeButtons = channel.length;
        if (!checkCookie) {
            if ((activeButtons == 1 && state != "open_by_default") || ((activeButtons > 1) && (state == "click_to_open")) || ((activeButtons > 1) && (state == "hover_to_open"))) {
                if (settings.num_of_message != "" && settings.show_chat_bubble == 1) {
                    $(".qcb-"+id+" .qcb-main-button .chat-btn a.channel-btn").append("<span class='kl-pending-message'>" + settings.num_of_message + "</span>");

                    tempString = 0;
                    $(".kl-pending-message").each(function () {
                        if (tempString < $(this).width()) {
                            tempString = $(this).width();
                        } else {
                            tempString = 10;
                        }
                        if (tempString < $(this).height()) {
                            tempString = $(this).height();
                        } else {
                            tempString = 10;
                        }
                    });

                    $(".kl-pending-message").width(tempString).height(tempString);
                }
            }
        }
    }

    function setButtonsForMobileOrDesktop(id) {
        if(isInMobile) {
            $(".qcb-"+id+" .check-device:not(.is-mobile)").remove();
        } else {
            $(".qcb-"+id+" .check-device:not(.is-desktop)").remove();
        }
    }

    /* Check for time delay */
    function checkForAfterSeconds(trigger_settings, id) {
        var checkCookie = getCookie("qcb-view-"+id);
        if(!checkCookie) {
            $(".qcb-"+id).removeClass("active");
            var seconds = parseInt(trigger_settings.seconds);
            if(seconds > 0) {
                setTimeout(function (){
                    setCookie("qcb-view-"+id, true, 2);
                    $(".qcb-"+id).addClass("active");
                }, seconds * 1000);
            } else {
                $(".qcb-"+id).addClass("active");
            }
        }
    }

    /* Check for page scroll */
    function checkForAfterPageScroll(trigger_settings, id) {
        var checkCookie = getCookie("qcb-view-"+id);
        if(!checkCookie) {
            var page_scroll = parseInt(trigger_settings.page_scroll);
            if(page_scroll > 0) {
                $(".qcb-" + id).removeClass("active");
                $(window).scroll(function () {
                    var scrollHeight = $(document).height() - $(window).height();
                    var scrollPos = $(window).scrollTop();
                    if (scrollPos != 0) {
                        if (((scrollPos / scrollHeight) * 100) >= page_scroll) {
                            $(".qcb-" + id).addClass("active");
                            setCookie("qcb-view-" + id, true, 2);
                        }
                    }
                });
            }
        }
    }

    /* Global Cookie Functions for Read, Write and Remove  */
    function getCookie(name) {
        var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
        return v ? v[2] : null;
    }

    function setCookie(name, value, days) {
        var d = new Date;
        d.setTime(d.getTime() + 24*60*60*1000*days);
        document.cookie = name + "=" + value + ";path=/;expires=" + d.toGMTString();
    }

    function deleteCookie(name) {
        setCookie(name, '', -1);
    }

})( jQuery );
