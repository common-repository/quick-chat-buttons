(function( $ ) {
    var formOptions = {
        beforeSubmit:  showRequest,  // pre-submit callback
        success:       showResponse
    };
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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

    var tempString = "";
    var errorMessage = "";
    var isInMobile = false;
    var regExpression = "";

	$(document).ready(function(){

        if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
            || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
            isInMobile = true;
        }

        /**
         * To remove a channel from widget.
         **/
		$(document).on("click", ".remove-channel-button", function(e){
			e.preventDefault();
			$(this).closest(".kl-modal").removeClass("active");
            var data_btn = $(this).closest(".kl-modal").data("button");
			$("."+data_btn+"-button").removeClass("active");
            $("input[name='button_setting["+data_btn+"][status]']").val("0");
            buttonPreview();
            defaultState();
            makePreviewCss();
		});

        /**
        * To add a channel in a widget.
        * */
		$(document).on("click", ".add-channel-button", function(e){
			e.preventDefault();
			var inputErrors = 0;
			$(this).closest(".kl-modal").find(".has-input-error").removeClass("has-input-error");
			$(this).closest(".kl-modal").find(".kl-required").each(function(){
				if($(this).val() == "") {
					$(this).closest(".kl-field").addClass("has-input-error");
					inputErrors++;
				}
			});
			if(inputErrors == 0) {
				$(this).closest(".kl-modal").removeClass("active");
				buttonPreview();
                defaultState();
                makePreviewCss();
			}
		});

		$(document).on("click", ".chat-button-list a", function(e){
			e.stopPropagation();
			$(this).addClass("active");
            var data_btn = $(this).data("button");
			$("#"+data_btn+"-setting").addClass("active");
            $("input[name='button_setting["+data_btn+"][status]']").val("1");
            $(".qcb-content").remove();
		});

        $(document).on("click", ".qcb-content:not(.has-single-button) .qcb-main-button a", function(e){
            e.preventDefault();
            $(this).closest(".qcb-content").toggleClass("show-icons");
        });

        $(document).on("keyup",".kl-input", function () {
            makePreviewCss();
        });


        /**
        *  Submit button setting form value
        **/
        $(document).on("submit", "#qc_buttons_setting_form", function(){
            var errorCount = 0;
            $(this).find(".has-error").removeClass("has-error");
            $(this).find(".is-required").each(function(){
                if($.trim($(this).val()) == "") {
                    $(this).addClass("has-error");
                    errorCount++;
                }
            });
            $(this).find(".select-required").each(function(){
                if($.trim($(this).val()) == "") {
                    $(this).addClass("has-error");
                    errorCount++;
                }
            });
            if(errorCount == 0) {
                $(this).ajaxSubmit(formOptions);
            } else {
                $(this).find(".has-error:first").focus();
            }
            return false;
        });

        $(document).on("keyup", ".only-numeric", function(){
            regExpression = /^[0-9]+$/;
            var nValue = $(this).val();
            if (nValue.match(regExpression)) {

            } else {
                $(this).val(nValue.replace(/\D/g, ""));
            }
        });

        /**
        * Add a minicolors color picker
        **/
        $('.color-picker').minicolors( {
            opacity:true,
            format:'rgb',
            change: function (rgba) {
                $(this).closest(".kl-field").find(".color_val").val(rgba);
                makePreviewCss();
            }
        });

        $(document).on("click","#collapse-menu",function () {
            makePreviewCss();
        });

        $(document).on("change", ".kl-inner-box", function (){
           makePreviewCss();
        });

        $(window).resize(function(){
            makePreviewCss();
        });

        /**
        * Show and hide pending message setting
        **/
        $(document).on("click", "#has_pending_message", function (){
            if($(this).is(":checked")) {
                $(".pending-message-box").addClass("active");
            } else {
                $(".pending-message-box").removeClass("active");
            }
        });

        $(document).on("mouseenter", ".qcb-content", function (){
            var state = $("input[name='other_settings[widget_state]']:checked").val();
            var activeButtons = $(".chat-button-list .channel-button.active").length;
            if(state == "hover_to_open" && !isInMobile && ($(".qcb-buttons .chat-btn").length > 1)) {
                $(this).addClass("show-icons");
            }
            attention_effect();
        });

        $(document).on("click", ".widget-state", function (){
            if($(this).val() == "open_by_default") {
                $(".widget-state-box").addClass("active");
            } else {
                $(".widget-state-box").removeClass("active");
            }
        });

        $(".sumoselect").SumoSelect();

        buttonPreview();
        makePreviewCss();

        $(document).on("click", ".qcb-content .qcb-main-button a", function (){
           attention_effect();
        });

        $(document).on("click", "#after_few_seconds", function (){
            if($(this).is(":checked")) {
                $(".after-seconds-box").addClass("active");
            } else {
                $(".after-seconds-box").removeClass("active");
            }
        });

        $(document).on("click", "#after_page_scroll", function (){
            if($(this).is(":checked")) {
                $(".after-page-scroll-box").addClass("active");
            } else {
                $(".after-page-scroll-box").removeClass("active");
            }
        });

        $(document).on("click", "#widget_status", function(){
            if($(this).is(":checked")) {
                $(".trigger-box").addClass("active");
                $(".warning-message").removeClass("active");
            } else {
                $(".trigger-box").removeClass("active");
                $(".warning-message").addClass("active");
            }
        });

    });

    /**
     * Add a preview of widget css in head
    **/
    function makePreviewCss() {

        var buttonCSS = "";
        var activeButtons = $(".chat-button-list .channel-button.active").length;
        var buttonSize = parseInt($("input[name='other_settings[button_size]']:checked").val());
        var icon_view = $("input[name='other_settings[icon_view]']:checked").val();
        var position = $("input[name='other_settings[button_position]']:checked").val();

        var tooltipPos = $("input[name='other_settings[button_position]']:checked").val();
        var state = $("input[name='other_settings[widget_state]']:checked").val();
        var side_position = $("#side_position").val().replace(/(<([^>]+)>)/ig,"");
        var bottom_position = $("#bottom_position").val().replace(/(<([^>]+)>)/ig,"");

        position = (position == "left")?"left":"right";
        tooltipPos = (tooltipPos == "left")?"right":"left";

        $(".qcb-content").removeClass("qcb-"+$(".qcb-content").attr("data-position")).addClass("qcb-"+position);
        $(".qcb-content").attr("data-position", position);
        $(".qcb-content").removeClass("qcb-"+$(".qcb-content").attr("data-view")).addClass("qcb-"+icon_view);
        $(".qcb-content").attr("data-view", icon_view);
        $(".qcb-main-button .kl-button-text").removeClass("kl-pos-"+$(".kl-button-text").attr("data-tooltip-pos")).addClass("kl-pos-"+tooltipPos);
        $(".kl-button-text").attr("data-tooltip-pos", tooltipPos);

        var channelTooltipPos = (position == "left")?"right":"left";
        if(icon_view == "horizontal") {
            channelTooltipPos = "top";
        }
        $(".qcb-buttons .channel-btn").removeClass("kl-pos-"+$(".kl-tooltip").attr("data-tooltip-pos")).addClass("kl-pos-"+channelTooltipPos);
        $(".kl-tooltip").attr("data-tooltip-pos", channelTooltipPos);

        var contact_text = $("#button_text").val().replace(/(<([^>]+)>)/ig,"");
        $(".qcb-main-button .chat-btn .kl-button-text").text(contact_text);
        if(contact_text == '') {
            $(".qcb-main-button .chat-btn .kl-button-text").remove();
        } else {
            $(".qcb-main-button .chat-btn .kl-button-text").remove();
            $(".qcb-main-button .chat-btn").append("<div class='kl-button-text kl-pos-"+tooltipPos+"'data-tooltip-pos='"+tooltipPos+"'>"+contact_text+"</div>");
        }

        $(".chat-button-list .channel-button.active").each(function(i){
            var buttonTitle = $.trim($("#"+$(this).data("button")+"-setting .button-title").val());
            $(".qcb-content .qcb-buttons .chat-btn ."+$(this).data("button")+"-button .kl-button-text").text(buttonTitle);
        });

        buttonCSS += ".qcb-content .qcb-buttons .chat-btn { transition: none; }";
        buttonCSS += ".qcb-content .chat-btn { transition: none; }";
        buttonCSS += ".kl-main-icon, .kl-close-icon { transition: none; }";

        $(document).on("change", ".icon-position", function (){
           if(icon_view == "horizontal") {
               var transitionCss = ".qcb-content .chat-btn { transition: all 0.3s ease-in-out; }";
               transitionCss += ".kl-main-icon, .kl-close-icon { transition: all 0.3s ease-in-out; }";
               $("#transition_position").remove();
               $("head").append("<style id='transition_position'>"+transitionCss+"</style>");
           }
        });

        $(document).on("change", "#hide_close_button, .widget-state", function (){
            var transitionCss = ".qcb-content .chat-btn { transition: all 0.3s ease-in-out; }";
            transitionCss += ".kl-main-icon, .kl-close-icon { transition: all 0.3s ease-in-out; }";
            $("#transition_close_button").remove();
            $("head").append("<style id='transition_close_button'>"+transitionCss+"</style>");
        });

        $(document).on("click", ".qcb-main-button a", function (){
            var transitionCss = ".qcb-content .qcb-buttons .chat-btn { transition: all 0.3s ease-in-out; }";
            transitionCss += ".qcb-content .chat-btn { transition: all 0.3s ease-in-out; }";
            transitionCss += ".kl-main-icon, .kl-close-icon { transition: all 0.3s ease-in-out; }";
            $("#transition_click").remove();
            $("head").append("<style id='transition_click'>"+transitionCss+"</style>");
        });

        if(state == "open_by_default" && activeButtons > 1 && ($(".qcb-buttons .chat-btn").length > 1)) {
            $(".qcb-content").addClass("show-icons");
        } else {
            $(".qcb-content").removeClass("show-icons");
        }

        if(state == "open_by_default" && $("#hide_close_button:checked").val() == 1 && ($(".qcb-buttons .chat-btn").length > 1)) {
            $(".qcb-content").addClass("hide-close-button");
            $(".qcb-content .qcb-main-button").hide();
        } else {
            $(".qcb-content").removeClass("hide-close-button");
            $(".qcb-content .qcb-main-button").show();
        }

        if(activeButtons) {
            if(activeButtons > 1) {
                var verticalActiveBtn = 0;
                $(".chat-button-list .channel-button.active").each(function (i) {
                    var for_desktop = $("input[name='button_setting[" + $(this).data("button") + "][has_desktop]']:checked").val();
                    var for_mobile = $("input[name='button_setting[" + $(this).data("button") + "][has_mobile]']:checked").val();
                    if ((for_desktop == 1 && !isInMobile) || (for_mobile == 1 && isInMobile)) {
                        verticalActiveBtn += 1;
                    }
                });
                buttonCSS += ".qcb-content.qcb-vertical .qcb-buttons .chat-btn {transform: scale(0.5) translate(0, " + ((buttonSize + 10)) + "px) }";
                $(".chat-button-list .channel-button.active").each(function (i) {
                    buttonCSS += ".qcb-content.show-icons.qcb-vertical .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(0, -" + ((buttonSize + 10) * (verticalActiveBtn-- - 1)) + "px)}";
                });

                var horizontalActiveBtn = 0;
                $(".chat-button-list .channel-button.active").each(function (i) {
                    var for_desktop = $("input[name='button_setting[" + $(this).data("button") + "][has_desktop]']:checked").val();
                    var for_mobile = $("input[name='button_setting[" + $(this).data("button") + "][has_mobile]']:checked").val();
                    if ((for_desktop == 1 && !isInMobile) || (for_mobile == 1 && isInMobile)) {
                        horizontalActiveBtn += 1;
                    }
                });
                if (icon_view == "horizontal") {
                    buttonCSS += ".qcb-content.qcb-" + icon_view + " .qcb-buttons .chat-btn {transform: scale(0.5) translate(0, " + ((buttonSize) * 2) + "px) }";
                    $(".chat-button-list .channel-button.active").each(function (i) {
                        if (position == "left") {
                            buttonCSS += ".qcb-content.qcb-" + icon_view + ".show-icons .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(" + (((buttonSize + 10) * (horizontalActiveBtn-- + 1)) - (buttonSize + 10)) + "px, " + (buttonSize + 10) + "px)}";
                        } else {
                            buttonCSS += ".qcb-content.qcb-" + icon_view + ".show-icons .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(-" + (((buttonSize + 10) * (horizontalActiveBtn-- + 1)) - (buttonSize + 10)) + "px, " + (buttonSize + 10) + "px)}";
                        }
                    });
                }
			}

            buttonCSS += ".qcb-content {bottom: " + bottom_position + "px; }";
            buttonCSS += ".qcb-content.qcb-left {left: " + side_position + "px; }";
            buttonCSS += ".qcb-content.qcb-right {right: " + side_position + "px; }";

            var buttonPadding = parseInt(2 * buttonSize / 9);
            buttonCSS += ".qcb-content .chat-btn {width: "+(buttonSize+10)+"px; height: "+(buttonSize+10)+"px;}";
            buttonCSS += ".qcb-content .channel-btn {width: "+buttonSize+"px; height: "+buttonSize+"px;}";
            buttonCSS += ".qcb-content .channel-btn {padding: "+(buttonPadding)+"px;}";

			var mainButtonSize = parseInt(buttonSize / 10);
			var scaleBtn = buttonSize/(buttonSize+mainButtonSize);
			// buttonCSS += ".qcb-content.show-icons .qcb-main-button .channel-btn {transform: scale("+scaleBtn+")}";

			var spanSize = (buttonSize+10) - (2*buttonPadding);
			buttonCSS += ".qcb-content .kl-main-icon, .qcb-content .kl-close-icon {width: "+spanSize+"px; height: "+spanSize+"px; }";
			buttonCSS += ".qcb-content .qcb-main-button .chat-btn {width: "+(buttonSize+20)+"px; height: "+(buttonSize+20)+"px;}"
			buttonCSS += ".qcb-content .qcb-main-button .channel-btn {width: "+(buttonSize+10)+"px; height: "+(buttonSize+10)+"px;}"


			buttonCSS += ".qcb-content.show-icons .qcb-main-button .channel-btn {width: "+(buttonSize)+"px; height: "+(buttonSize)+"px;}"
			buttonCSS += ".qcb-content.show-icons .kl-main-icon, .qcb-content.show-icons .kl-close-icon {width: "+(spanSize - 10)+"px; height: "+(spanSize -10)+"px; }";

            buttonCSS += ".qcb-content .kl-pending-message {background-color: " + $("#message_bg_color").val() + "; border-color: " + $("#message_border_color").val() + "; color: " + $("#message_text_color").val() + "}";

            var messageWidth = (buttonSize * 20) / 54;
            var messageHeight = (buttonSize * 20) / 54;

            buttonCSS += ".qcb-content .kl-pending-message {width: " + messageWidth + "px !important; height: " + messageHeight + "px !important; line-height: " + ((messageHeight / 2))  + "px; font-size: " + (parseInt(messageHeight / 4) + 4) + "px;}";

            var back_color = $("input[name='other_settings[button_back_color]']").val();
            var font_color = $("input[name='other_settings[button_font_color]']").val();
            buttonCSS += '.qcb-content .qcb-main-button .chat-btn a{background-color:'+back_color+';}';
            buttonCSS += '.qcb-content:not(.has-single-button) .qcb-main-button .chat-btn a svg path{fill:'+font_color+' !important;}';

            var verticalActiveBtn = 0;
            $(".chat-button-list .channel-button.active").each(function (i) {
                var for_desktop = $("input[name='button_setting[" + $(this).data("button") + "][has_desktop]']:checked").val();
                var for_mobile = $("input[name='button_setting[" + $(this).data("button") + "][has_mobile]']:checked").val();
                if ((for_desktop == 1 && !isInMobile) || (for_mobile == 1 && isInMobile)) {
                    verticalActiveBtn += 1;
                }
            });
            $(".chat-button-list .channel-button.active").each(function (i) {
                if (position == "left") {
                    buttonCSS += ".qcb-content.qcb-vertical.show-icons.hide-close-button .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(0, -" + ((buttonSize + 10) * (verticalActiveBtn-- - 1)) + "px)}";
                } else {
                    buttonCSS += ".qcb-content.qcb-vertical.show-icons.hide-close-button .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(-" + (buttonSize + 10) + "px, -" + ((buttonSize + 10) * (verticalActiveBtn-- - 1)) + "px)}";
                }
            });

            var horizontalActiveBtn = 0;
            $(".chat-button-list .channel-button.active").each(function (i) {
                var for_desktop = $("input[name='button_setting[" + $(this).data("button") + "][has_desktop]']:checked").val();
                var for_mobile = $("input[name='button_setting[" + $(this).data("button") + "][has_mobile]']:checked").val();
                if ((for_desktop == 1 && !isInMobile) || (for_mobile == 1 && isInMobile)) {
                    horizontalActiveBtn += 1;
                }
            });
            $(".chat-button-list .channel-button.active").each(function (i) {
                if (position == "left") {
                    buttonCSS += ".qcb-content.qcb-horizontal.show-icons.hide-close-button .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(" + (((buttonSize + 10) * (horizontalActiveBtn-- - 1))) + "px, 0)}";
                } else {
                    buttonCSS += ".qcb-content.qcb-horizontal.show-icons.hide-close-button .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(-" + (((buttonSize + 10) * (horizontalActiveBtn-- + 1)) - (buttonSize + 10)) + "px, 0)}";
                }
            });

        }

        if(!$("#button-css").length) {
            $("head").append("<style id='button-css'></style>");
        }
        $("#button-css").html(buttonCSS);

        qcbPosition();

        var no_of_messages = $("#no_of_messages").val().replace(/(<([^>]+)>)/ig,"");
        $(".kl-pending-message").remove();
        var activeButtons = $(".chat-button-list .channel-button.active").length;
        if((activeButtons == 1) || ((activeButtons > 1) && (state == "click_to_open")) || ((activeButtons > 1) && (state == "hover_to_open"))) {
            if(no_of_messages != "" && $("#has_pending_message").is(":checked")) {
                $(".qcb-content.has-single-button .qcb-main-button .chat-btn a.channel-btn, .qcb-content .qcb-main-button .chat-btn a.channel-btn").append("<span class='kl-pending-message'>"+no_of_messages+"</span>");

                tempString = 0;
                $(".kl-pending-message").each(function(){
                    if(tempString < $(this).width()) {
                        tempString = $(this).width();
                    }else {
                        tempString = 10;
                    }
                    if(tempString < $(this).height()) {
                        tempString = $(this).height();
                    }else {
                        tempString = 10;
                    }
                });

                $(".kl-pending-message").width(tempString).height(tempString);
            }
        }

        var cta_icon = $(".cta-icon-"+$("input[name='other_settings[cta_icon]']:checked").val()).html();
        $(".qcb-content .qcb-main-button .kl-main-icon").html(cta_icon);

        attention_effect();

    }

    function attention_effect() {
        var state = $("input[name='other_settings[widget_state]']:checked").val();
        if($(".qcb-content").hasClass("show-icons")) {
            $(".qcb-content.show-icons .qcb-main-button .chat-btn a").removeClass($(".btn-attention-effect").val());
        } else {
            if(state != "open_by_default") {
                var effects = $(".qcb-content:not(.show-icons) .qcb-main-button .chat-btn a").attr("data-effect");
                $(".qcb-content:not(.show-icons) .qcb-main-button .chat-btn a").removeClass(effects).addClass($(".btn-attention-effect").val()).attr("data-effect", $(".btn-attention-effect").val());
            }
        }
    }

    function defaultState() {
        var state = $("input[name='other_settings[widget_state]']:checked").val();
        var activeButtons = $(".chat-button-list .channel-button.active").length;
        if(state == "open_by_default" && activeButtons > 1 && ($(".qcb-buttons .chat-btn").length > 1)) {
            $(".qcb-content").addClass("show-icons");
        }
    }


    /**
     * Make a preview of widget
    **/
    function buttonPreview() {
		var previewHtml = "";
		if($(".chat-button-list .channel-button.active").length) {
			var activeButtons = $(".chat-button-list .channel-button.active").length;

			var tooltipPos = $("input[name='other_settings[button_position]']:checked").val();
			var buttonPos = $("input[name='other_settings[button_position]']:checked").val();
            var state = $("input[name='other_settings[widget_state]']:checked").val();
            var icon_view = $("input[name='other_settings[icon_view]']:checked").val();
            var cta_icon = $(".cta-icon-"+$("input[name='other_settings[cta_icon]']:checked").val()).html();
            var attention_effect = $(".btn-attention-effect").val();
            var button_text = $("#button_text").val().replace(/(<([^>]+)>)/ig,"");

			buttonPos = (buttonPos == "left")?"left":"right";
			tooltipPos = (tooltipPos == "left")?"right":"left";


			if(activeButtons == 1) {

                var for_desktop = $("input[name='button_setting["+$(".channel-button.active").data("button")+"][has_desktop]']:checked").val();
                var for_mobile = $("input[name='button_setting["+$(".channel-button.active").data("button")+"][has_mobile]']:checked").val();

                if((for_desktop == 1 && !isInMobile) || (for_mobile == 1 && isInMobile)) {

                    var mainButton = "<div class='qcb-main-button'>";
                    mainButton += "<div class='chat-btn'>";
                    if ($.trim(button_text) != "") {
                        mainButton += "<div class='kl-button-text kl-pos-" + tooltipPos + "' data-tooltip-pos='" + tooltipPos + "'>" + button_text + "</div>";
                    }
                    mainButton += "<a href='javascript:;' class='channel-btn active " + $(".channel-button.active").data("button") + "-button'>";
                    mainButton += $(".channel-button.active .button-icon").html();
                    mainButton += "</a>";
                    mainButton += "</div>";
                    mainButton += "</div>";

                    previewHtml = "<div class='qcb-content has-single-button qcb-" + buttonPos + "' data-position='" + buttonPos + "'>";
                    previewHtml += mainButton;
                    previewHtml += "</div>";
                }
			} else {
				var mainButton = "<div class='qcb-main-button'>";
				mainButton += "<div class='chat-btn'>";
				if($.trim(button_text) != "") {
					mainButton += "<div class='kl-button-text kl-pos-"+tooltipPos+"' data-tooltip-pos='"+tooltipPos+"'>"+button_text+"</div>"
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
                if(icon_view == "horizontal") {
                    tooltipPos = "top";
                }
				$(".chat-button-list .channel-button.active").each(function(i){
                    var for_desktop = $("input[name='button_setting["+$(this).data("button")+"][has_desktop]']:checked").val();
                    var for_mobile = $("input[name='button_setting["+$(this).data("button")+"][has_mobile]']:checked").val();
                    if((for_desktop == 1 && !isInMobile) || (for_mobile == 1 && isInMobile)) {
                        channelButtons += "<div class='chat-btn'>";
                        channelButtons += "<a href='javascript:;' class='channel-btn kl-tooltip kl-pos-" + tooltipPos + " active " + $(this).data("button") + "-button' data-tooltip-pos='" + tooltipPos + "'>";
                        var buttonTitle = $.trim($("#" + $(this).data("button") + "-setting .button-title").val().replace(/(<([^>]+)>)/ig,""));
                        if (buttonTitle != "") {
                            channelButtons += "<span class='kl-button-text'>" + buttonTitle + "</span>";
                        }
                        channelButtons += $(this).find(".button-icon").html();
                        channelButtons += "</a>";
                        channelButtons += "</div>";
                    }
				});

				$(".kl-dashboard-right").html("");
				previewHtml = "<div class='qcb-content qcb-"+buttonPos+" qcb-"+ icon_view +"' data-position='"+buttonPos+"' data-view='"+icon_view+"'>";
				previewHtml += "<div class='qcb-buttons'>";
				previewHtml += channelButtons;
				previewHtml += "</div>";
				previewHtml += mainButton;
				previewHtml += "</div>";
                var back_color = $("input[name='other_settings[button_back_color]']").val();
                previewHtml += "<style id='button_css'>";
                previewHtml += ".qcb-main-button .chat-btn a{background-color:"+back_color+"}";
                previewHtml += "</style>";

			}
		}
		$(".kl-dashboard-right").html(previewHtml);

        if($(".qcb-buttons .chat-btn").length == 1) {
            $(".qcb-content").addClass("has-single-button");
            $(".qcb-main-button .chat-btn").remove();
            $(".qcb-main-button").prepend($(".qcb-buttons").html());
            $(".qcb-buttons .chat-btn").hide();
        }

        if($(".qcb-buttons .chat-btn").length == 0 && $(".chat-button-list .channel-button.active").length > 1) {
            $(".qcb-content").remove();
        }

        qcbPosition();

	}

    function qcbPosition() {
        var menu_width = $("#adminmenuback").width();
        var side_position = $("#side_position").val().replace(/(<([^>]+)>)/ig,"");
        $("body.rtl .qcb-content").css("style",'');
        $('body:not(.rtl)').find(".qcb-content").attr("style",'');

        if(side_position != '') {
            $("body.rtl .qcb-right").css("right",(menu_width+parseInt(side_position)));
            $('body:not(.rtl)').find(".qcb-left").css("left",(menu_width+parseInt(side_position)));
        } else {
            $("body.rtl .qcb-right").css("right",menu_width);
            $('body:not(.rtl)').find(".qcb-left").css("left",menu_width);
        }

    }

    function showRequest(formData, jqForm, options) {
        $(".kl-buttons .primary-button").prop("disabled", true);
        $(".kl-buttons .kl-loader").addClass("active");
        $(".form-buttons").addClass("form-loading");
        $(".gp-modal-content").addClass("form-loading");
    }

    function showResponse(responseText, statusText, xhr, $form) {
        $(".gp-loader").removeClass("active");
        $(".form-buttons").removeClass("form-loading");
        $(".gp-modal-content").removeClass("form-loading");
        responseText = $.parseJSON(responseText);
        const swipeHandler = new SwipeHandler();
        const toastsHandler = new ToastsHandler(swipeHandler);
        if(responseText.status == 1) {
            toastsHandler.createToast({
                type: "success",
                icon: "info-circle",
                message: responseText.message,
                duration: 5000
            });
            setTimeout(function(){
                window.location = responseText.data.URL;
            }, 1000);
        } else {
            $(".save-changes").prop("disabled", false);
            toastsHandler.createToast({
                type: "error",
                icon: "info-circle",
                message: responseText.message,
                duration: 5000
            });
        }
    }

})( jQuery );
