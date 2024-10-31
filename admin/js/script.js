(function( $ ) {
    var formOptions = {
        beforeSubmit:  showRequest,  // pre-submit callback
        success:       showResponse,
        error:         showErrors,
    };
    var type = "";
    var widgetId = 0;
    var selectedDevice = "desktop"
    var previewPopup = false;
    var tempString = "";
    $(document).ready(function() {

        $(document).on("click", ".preview-btn", function(){
            $(".preview-modal").addClass("active");
        });

        $(document).on("click", ".setting-top", function(e){
            e.preventDefault();
            $(this).closest("li").find(".setting-bottom").slideToggle(200, function(){
                $(this).closest("li").toggleClass("active");
            });
        });

        $("#prev-button").prop("disabled", true);
        $(document).on("click", ".steps .step", function (){
           $(".step").removeClass("active");
           $(".step").removeClass("done");
           $(this).addClass("active");
           var id = $(this).attr("data-id");
           $(".setting-steps .setting-step").removeClass("active");
           $(".setting-steps #step-"+id).addClass("active");
           $("#prev-button").prop("disabled", false);
           $("#next-button").prop("disabled", false);
           $(".steps .step").each(function (){
              var id2 = $(this).attr("data-id");
              if(id2 < id) {
                  $(this).addClass("done");
              }
           });
           if(id == 1) {
               $("#prev-button").prop("disabled", true);
           }
           if(id == 3) {
               $("#next-button").prop("disabled", true);
           }
        });

        $(document).on("click", "#prev-button", function (){
            var step = $(".steps .step.active").attr("data-id");
            var step_prev = parseInt(step) - 1;
            $(".steps .step-"+step_prev).trigger("click");
        });

        $(document).on("click", "#next-button", function (){
            var step = $(".steps .step.active").attr("data-id");
            var step_next = parseInt(step) + 1;
            $(".steps .step-"+step_next).trigger("click");
        });

        $(document).on("click", ".remove-channel-icon", function (){
            var channel = $(this).closest("li.channel-lists").data("channel");
            $("."+channel+"-channel").remove();
            $("input[name='button_setting["+channel+"][status]']").val(0);
            $("."+channel+"-button").removeClass("active");
            if($(".chat-button-list .chat-button a.active").length >= 1) {
                $(".no-channels").removeClass("active");
            } else {
                $(".no-channels").addClass("active");
            }
            buttonPreview();
            makePreviewCss();
        });

        $(document).on("click", ".chat-button-list .chat-button a", function (){
            var channel = $(this).data("button");
            if($(this).hasClass("active")) {
                $("."+channel+"-channel").remove();
                $("input[name='button_setting["+channel+"][status]']").val(0);
                $(this).removeClass("active");
                buttonPreview();
                makePreviewCss();
            } else {
                $("."+channel+"-button").addClass("active");
                if($("li.channel-lists").length) {
                    $("html, body").animate({
                        scrollTop: $("li.channel-lists:last-child").offset().bottom
                    }, 600);
                }
                $(".ajax-loader").addClass("active");
                $.ajax({
                    url: QUICK_CHAT_BUTTONS_SETTING.AJAX_URL,
                    data: {
                        channel: channel,
                        post_id: $("#button_setting_id").val(),
                        action: 'get_qcb_settings'
                    },
                    type: 'post',
                    success: function (responseText) {
                        $(".ajax-loader").removeClass("active");
                        responseText = $.parseJSON(responseText);
                        $(".selected-channels > ul").append(responseText.message);
                        $("."+responseText.channel+"-channel").find(".setting-bottom").slideToggle(200, function(){
                            $("."+responseText.channel+"-channel").toggleClass("active");
                        });
                        $("html, body").animate({
                            scrollTop: $("."+responseText.channel+"-channel").offset().top - 80
                        }, 600);
                        $("."+responseText.channel+"-channel .channel-value").focus();
                        $("input[name='button_setting["+responseText.channel+"][status]']").val(1);
                        $(".color-picker").each (function () {
                            $(".color-picker").minicolors( {
                                opacity:true,
                                format:'rgb',
                                change: function (rgba) {
                                    $(this).closest(".minicolors").find(".minicolors-swatch").css("outline-color",rgba);
                                    makePreviewCss();
                                }
                            });
                            var color = $(this).val();
                            $(this).closest(".minicolors").find(".minicolors-swatch").css("outline-color",color);
                        });
                        buttonPreview();
                        makePreviewCss();
                    }
                });
            }
            if($(".chat-button-list .chat-button a").hasClass("active")) {
                $(".no-channels").removeClass("active");
            } else {
                $(".no-channels").addClass("active");
            }
        });

        $(".select2").select2();

        $('.select2-animation').select2({
            minimumResultsForSearch: -1
        });

        // $(document).on("click",".minicolors",function () {
        //     $(this).find("input").prop("checked",true);
        // });

        $(".color-picker").each (function () {
            $(".color-picker").minicolors( {
                opacity:true,
                format:'rgb',
                change: function (rgba) {
                    $(this).closest(".minicolors").find(".minicolors-swatch").css("outline-color",rgba);
                    makePreviewCss();
                }
            });
            var color = $(this).val();
            $(this).closest(".minicolors").find(".minicolors-swatch").css("outline-color",color);
        });

        $(document).on("click", ".create-widget", function (){
            $(".add-widget-modal").addClass("active");
            $(".add-widget-modal #widget_title").focus();
        });

        $(document).on("submit", "#qcb_form_setting", function(){
            var errorCount = 0;
            $(this).find(".has-error").removeClass("has-error");
            $(this).find(".qcb-error-msg").remove();
            $(this).find(".is-required").each(function(){
                if($.trim($(this).val()) == "") {
                    var input_label = $(this).data("name");
                    $(this).after("<span class='qcb-error-msg'>"+input_label+" is required</span>");
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
                if($(".form-steps").length) {
                    if($(".channel-value").hasClass("has-error")) {
                        if($(".form-steps .steps .step-2").hasClass("active") || $(".form-steps .steps .step-3").hasClass("active")) {
                            $(".form-steps .steps .step").removeClass("active");
                            $(".form-steps .steps .step").removeClass("done");
                            $(".form-steps .steps .step-1").addClass("active");
                            $(".setting-steps .setting-step").removeClass("active");
                            $(".setting-steps #step-1").addClass("active");
                        }
                        $(".channel-value.has-error:first").closest(".setting-bottom").show();
                        $(this).closest("li").addClass("active");
                        $(".channel-value.has-error:first").closest("li.channel-lists").addClass("active");
                    }
                }
                $(this).find(".has-error:first").focus();

            }
            return false;
        });

        $(document).on("click", ".trash-record", function (){
            widgetId = $(this).closest('tr').data('id');
            $(".delete-widget").addClass("active");
        });

        $(document).on("click", "#delete_widget:not(.disabled)", function(e){
            $(this).addClass("disabled");
            $(".kl-loader").addClass("active");
            $(".save-changes").prop("disabled", true);
            e.preventDefault();
            $.ajax({
                url: QUICK_CHAT_BUTTONS_SETTING.AJAX_URL,
                data: {
                    setting_id: widgetId,
                    action: 'remove_qcb_widget',
                    nonce: $("tr.widget-col-"+widgetId).data("nonce")
                },
                type: 'post',
                success: function(responseText) {
                    $(".save-changes").prop("disabled", false);
                    $(".kl-loader").removeClass("active");
                    $(".delete-widget").removeClass("active");
                    $("#delete_widget").removeClass("disabled");
                    responseText = $.parseJSON(responseText);
                    const swipeHandler = new SwipeHandler();
                    const toastsHandler = new ToastsHandler(swipeHandler);
                    if(responseText.status == 1) {
                        $("tr.widget-col-"+widgetId).remove();
                        toastsHandler.createToast({
                            type: "success",
                            icon: "info-circle",
                            message: responseText.message,
                            duration: 5000
                        });
                        setTimeout(function(){
                            window.location.reload();
                        },2000);
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
            });
        });

        $(document).on("click", ".widget-status", function(){
            var isChecked = $(this).is(":checked")?1:0;
            var widgetId = $(this).closest('tr').data('id');
            $.ajax({
                url: QUICK_CHAT_BUTTONS_SETTING.AJAX_URL,
                data: {
                    setting_id: $(this).closest("tr").data("id"),
                    status: isChecked,
                    action: 'qcb_change_widget_status',
                    nonce: $("tr.widget-col-"+widgetId).data("nonce")
                },
                type: 'post'
            });
        });

        $(document).on("click", ".icon-state", function (){
            if($(this).val() == "open_by_default") {
                $(".hide-close-btn").addClass("active");
            } else {
                $(".hide-close-btn").removeClass("active");
            }
        });

        $(document).on("click", "#show_bubble", function (){
            if($(this).is(":checked")) {
                $(".pending-message-box").addClass("active");
            } else {
                $(".pending-message-box").removeClass("active");
            }
        });

        $(document).on("click", "#after_few_sec", function (){
            if($(this).is(":checked")) {
                $(".seconds-box").addClass("active");
            } else {
                $(".seconds-box").removeClass("active");
            }
        });

        $(document).on("click", "#after_page_scroll", function (){
            if($(this).is(":checked")) {
                $(".page-scroll-box").addClass("active");
            } else {
                $(".page-scroll-box").removeClass("active");
            }
        });

        $(document).on("click", "#widget_status", function (){
            if($(this).is(":checked")) {
                $(".trigger-rules").addClass("active");
                $(".warning-message").removeClass("active");
            } else {
                $(".trigger-rules").removeClass("active");
                $(".warning-message").addClass("active");
            }
        });

        $(document).on("click", ".qcb-content:not(.has-single-button) .qcb-main-button a", function(e){
            e.preventDefault();
            $(this).closest(".qcb-content").toggleClass("show-icons");
            attention_effect();
        });

        $(document).on("mouseenter", ".qcb-content", function (){
            var state = $("input[name='widget_setting[icon_state]']:checked").val();
            var activeButtons = $(".channel-for-"+selectedDevice+":checked").length;
            if(state == "hover_to_open" && selectedDevice != "mobile" && (activeButtons > 1)) {
                $(this).addClass("show-icons");
            }
            attention_effect();
        });

        $(document).on("click", "filter-menu-list", function(e) {
            e.stopPropagation();
        });

        $(document).on("click", ".filter-menu > button", function(e){
            e.stopPropagation();
            $(this).closest(".filter-menu").toggleClass("active");
        });

        $(document).on("click", "body, html", function(){
            $(".filter-menu").removeClass("active");
        });

        $(document).on("keyup",".input-field", function () {
            makePreviewCss();
        });

        $(document).on("change", ".setting-steps", function (){
            makePreviewCss();
        });

        $(document).on("click", ".device-checkbox", function (){
            buttonPreview();
        });

        $(window).resize(function(){
            makePreviewCss();
        });

        $(document).on("change", ".icon-state", function (){
            if($(this).val() == "open_by_default" && $(".channel-for-"+selectedDevice+":checked").length > 1) {
                $(".qcb-content").addClass("show-icons");
            } else {
                $(".qcb-content").removeClass("show-icons");
                $(".qcb-content .qcb-main-button .chat-btn a").removeClass($("#attention_effect").val());
            }
            transition_effect();
        });

        $(document).on("change", "input[name='preview_device_popup']", function (){
            if($(this).val() == "mobile") {
                $(".preview-area").addClass("for-mobile");
            } else {
                $(".preview-area").removeClass("for-mobile");
            }
        });

        $(document).on("keyup", ".only-numeric", function(){
            regExpression = /^[0-9]+$/;
            var nValue = $(this).val();
            if (nValue.match(regExpression)) {

            } else {
                $(this).val(nValue.replace(/\D/g, ""));
            }
        });

        $(document).on("change", ".preview_device", function (){
           buttonPreview();
           makePreviewCss();
        });

        $(document).on("click", ".upgrade-widget, #upgrade_widget", function (){
            var title = $(this).data("title");
            $(".upgrade-plan-modal").addClass("active");
            $(".upgrade-plan-modal-title").text(title);
        });

        $(document).on("click", "#create_page_rule", function (){
            $(this).closest(".custom-rules").addClass("active");
            $(".page-rules .page-rule").show();
        });

        $(document).on("click", "#remove_page_rule", function (){
            $(this).closest(".custom-rules").removeClass("active");
            $(".page-rules .page-rule").hide();
        });

        $(document).on("click", "#create_date_rule", function (){
            $(this).closest(".custom-rules").addClass("active");
            $(".date-schedules").addClass("active");
        });

        $(document).on("click", "#remove_date_rule", function (){
            $(this).closest(".custom-rules").removeClass("active");
            $(".date-schedules").removeClass("active");
        });

        $(document).on("click", "#create_day_time_rule", function (){
            $(this).closest(".custom-rules").addClass("active");
            $(".days-schedule").addClass("active");
        });

        $(document).on("click", "#remove_day_time_rule", function (){
            $(this).closest(".custom-rules").removeClass("active");
            $(".days-schedule").removeClass("active");
        });

        $(document).on("click", ".plan-switcher .plan-switch", function (){
            $(".plan-switch").removeClass("active");
            $(this).addClass("active");
            var plan_type = $(this).data("plan");
            var old_plan_type = $(".pricing-table").attr("data-plan");
            $(".pricing-table").removeClass(old_plan_type).addClass(plan_type);
            $(".pricing-table").attr("data-plan", plan_type);
            var old_plan_type_mobile = $(".mobile-view-table .pricing-tables").attr("data-plan");
            $(".mobile-view-table .pricing-tables").removeClass(old_plan_type_mobile).addClass(plan_type);
            $(".mobile-view-table .pricing-tables").attr("data-plan", plan_type);
        });

        $(document).on("click", ".remove-klaxon-modal, .cancel-button, .klaxon-modal-bg", function(){
            $(".klaxon-modal").removeClass("active");
        });

        $(document).on('keyup', function(e) {
            if(e.keyCode == 27) {
                $(".klaxon-modal").removeClass("active");
            }
        });

        $('.pro-section-slider').slick({
            infinite: true,
            adaptiveHeight: true,
            fade: true,
            dots: true,
            arrows: false,
            autoplay: true
        });

        $(window).resize(function (){
            setPreviewPopup();
            setHeader();
        });

        $(".selected-channels ul").sortable({
            placeholder : 'custom-ui-placeholder',
            handle: ".setting-top",
        });

        $("form").attr('autocomplete', 'off');

        $(window).on("scroll", function () {
            setHeader();
        });

        buttonPreview();
        makePreviewCss();

    });

    function setHeader() {
        if($(window).width() <= 583) {
            var topPosition = $(window).scrollTop();
            if(topPosition > 0) {
                $(".widget-header").css("cssText","top: 0 !important");
            }
            if(topPosition == 0) {
                $(".widget-header").css("cssText","top: 46px !important");
            }
        }
    }

    function setPreviewPopup() {
        if($(window).width() <= 842) {
            previewPopup = true;
            tempString = $("input[name='preview_device_popup']:checked").val();
            if(tempString == "mobile") {
                $(".preview-area").addClass("for-mobile");
                selectedDevice = "mobile";
            } else {
                $(".preview-area").removeClass("for-mobile");
                selectedDevice = "desktop";
            }
        }
    }

    function buttonPreview() {
        if($(".selected-channels").length) {
            tempString = $("input[name='preview_device']:checked").val();
            if (tempString == "mobile") {
                selectedDevice = "mobile";
                $(".preview-area").addClass("for-mobile");
            } else {
                selectedDevice = "desktop";
                $(".preview-area").removeClass("for-mobile");
            }

            setPreviewPopup();

            if ($(".preview-area").hasClass("for-mobile")) {
                $(".preview-desktop-btn").prop("checked", false);
                $(".preview-mobile-btn").prop("checked", true);
            } else {
                $(".preview-mobile-btn").prop("checked", false);
                $(".preview-desktop-btn").prop("checked", true);
            }

            $(".qcb-content").remove();
            var previewHtml = "";
            if ($(".channel-for-" + selectedDevice + ":checked").length > 0) {
                var activeButtons = $(".channel-for-" + selectedDevice + ":checked").length;

                var tooltipPos = $("input[name='widget_setting[position]']:checked").val();
                var buttonPos = $("input[name='widget_setting[position]']:checked").val();
                var state = $("input[name='widget_setting[icon_state]']:checked").val();
                var icon_view = $("input[name='widget_setting[icon_view]']:checked").val();
                var cta_icon = $(".cta-icon-" + $("input[name='widget_setting[cta_icon]']:checked").val()).html();
                var button_text = $("#cta_text").val().replace(/(<([^>]+)>)/ig, "");

                buttonPos = (buttonPos == "left") ? "left" : "right";
                tooltipPos = (tooltipPos == "left") ? "right" : "left";

                if (activeButtons == 1) {

                    var mainButton = "<div class='qcb-main-button'>";
                    mainButton += "<div class='chat-btn'>";
                    if ($.trim(button_text) != "") {
                        mainButton += "<div class='kl-button-text kl-pos-" + tooltipPos + "' data-tooltip-pos='" + tooltipPos + "'>" + button_text + "</div>";
                    }
                    var channel_name = $(".channel-for-" + selectedDevice + ":checked").closest("li.channel-lists").data("channel");
                    mainButton += "<a href='javascript:;' class='channel-btn active " + channel_name + "-button'>";
                    mainButton += $("." + channel_name + "-button .button-icon").html();
                    mainButton += "</a>";
                    mainButton += "</div>";
                    mainButton += "</div>";

                    previewHtml = "<div class='qcb-content has-single-button qcb-" + buttonPos + "' data-position='" + buttonPos + "'>";
                    previewHtml += mainButton;
                    previewHtml += "</div>";

                } else {
                    var mainButton = "<div class='qcb-main-button'>";
                    mainButton += "<div class='chat-btn'>";
                    if ($.trim(button_text) != "") {
                        mainButton += "<div class='kl-button-text kl-pos-" + tooltipPos + "' data-tooltip-pos='" + tooltipPos + "'>" + button_text + "</div>"
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
                    $(".channel-for-" + selectedDevice + ":checked").each(function () {
                        var channel_name = $(this).closest("li.channel-lists").data("channel");
                        channelButtons += "<div class='chat-btn'>";
                        channelButtons += "<a href='javascript:;' class='channel-btn kl-tooltip kl-pos-" + tooltipPos + " active " + channel_name + "-button' data-tooltip-pos='" + tooltipPos + "'>";
                        var buttonTitle = $.trim($("#channel-" + channel_name + " .channel-title").val().replace(/(<([^>]+)>)/ig, ""));
                        if (buttonTitle != "") {
                            channelButtons += "<span class='kl-button-text'>" + buttonTitle + "</span>";
                        }
                        channelButtons += $("." + channel_name + "-button").find(".button-icon").html();
                        channelButtons += "</a>";
                        channelButtons += "</div>";
                    });

                    $(".kl-dashboard-right").html("");
                    previewHtml = "<div class='qcb-content qcb-" + buttonPos + " qcb-" + icon_view + "' data-position='" + buttonPos + "' data-view='" + icon_view + "'>";
                    previewHtml += "<div class='qcb-buttons'>";
                    previewHtml += channelButtons;
                    previewHtml += "</div>";
                    previewHtml += mainButton;
                    previewHtml += "</div>";
                    var back_color = $("input[name='widget_setting[btn_bg_color]']").val();
                    previewHtml += "<style id='button_css'>";
                    previewHtml += ".qcb-main-button .chat-btn a{background-color:" + back_color + "}";
                    previewHtml += "</style>";

                }
                $(".preview-area").html(previewHtml);
            }
        }
    }

    function makePreviewCss() {
        if($(".selected-channels").length) {
            var buttonCSS = "";
            var activeButtons = $(".channel-for-" + selectedDevice + ":checked").length;
            var buttonSize = parseInt($("input[name='widget_setting[button_size]']:checked").val());
            var icon_view = $("input[name='widget_setting[icon_view]']:checked").val();
            var position = $("input[name='widget_setting[position]']:checked").val();

            var tooltipPos = $("input[name='widget_setting[position]']:checked").val();
            var state = $("input[name='widget_setting[icon_state]']:checked").val();

            position = (position == "left") ? "left" : "right";
            tooltipPos = (tooltipPos == "left") ? "right" : "left";

            $(".qcb-content").removeClass("qcb-" + $(".qcb-content").attr("data-position")).addClass("qcb-" + position);
            $(".qcb-content").attr("data-position", position);
            $(".qcb-content").removeClass("qcb-" + $(".qcb-content").attr("data-view")).addClass("qcb-" + icon_view);
            $(".qcb-content").attr("data-view", icon_view);
            $(".qcb-main-button .kl-button-text").removeClass("kl-pos-" + $(".kl-button-text").attr("data-tooltip-pos")).addClass("kl-pos-" + tooltipPos);
            $(".kl-button-text").attr("data-tooltip-pos", tooltipPos);

            var channelTooltipPos = (position == "left") ? "right" : "left";
            if (icon_view == "horizontal") {
                channelTooltipPos = "top";
            }
            $(".qcb-buttons .channel-btn").removeClass("kl-pos-" + $(".kl-tooltip").attr("data-tooltip-pos")).addClass("kl-pos-" + channelTooltipPos);
            $(".kl-tooltip").attr("data-tooltip-pos", channelTooltipPos);

            var contact_text = $("#cta_text").val().replace(/(<([^>]+)>)/ig, "");
            $(".qcb-main-button .chat-btn .kl-button-text").text(contact_text);
            if (contact_text == '') {
                $(".qcb-main-button .chat-btn .kl-button-text").remove();
            } else {
                $(".qcb-main-button .chat-btn .kl-button-text").remove();
                $(".qcb-main-button .chat-btn").append("<div class='kl-button-text kl-pos-" + tooltipPos + "'data-tooltip-pos='" + tooltipPos + "'>" + contact_text + "</div>");
            }

            $(".channel-for-" + selectedDevice + ":checked").each(function () {
                var channel_name = $(this).closest("li.channel-lists").data("channel");
                var buttonTitle = $.trim($("#channel-" + channel_name + " .channel-title").val().replace(/(<([^>]+)>)/ig, ""));
                if (buttonTitle != "") {
                    $(".qcb-content .qcb-buttons .chat-btn ." + channel_name + "-button .kl-button-text").remove();
                    $(".qcb-content .qcb-buttons .chat-btn ." + channel_name + "-button").prepend("<span class='kl-button-text'>" + buttonTitle + "</span>");
                } else {
                    $(".qcb-content .qcb-buttons .chat-btn ." + channel_name + "-button .kl-button-text").remove();
                }
            });

            transition_effect();

            if (state == "open_by_default" && activeButtons > 1) {
                $(".qcb-content").addClass("show-icons");
            } else {
                if ($(".qcb-content").hasClass("show-icons")) {
                    // alert()
                    // $(".qcb-content").addClass("show-icons");
                } else {
                    $(".qcb-content").removeClass("show-icons");
                }
            }

            if (state == "open_by_default" && $("#hide_close_button:checked").val() == 1 && activeButtons > 1) {
                $(".qcb-content").addClass("hide-close-button");
                $(".qcb-content .qcb-main-button").hide();
            } else {
                $(".qcb-content").removeClass("hide-close-button");
                $(".qcb-content .qcb-main-button").show();
            }

            if (activeButtons) {
                if (activeButtons > 1) {
                    var verticalActiveBtn = activeButtons;
                    buttonCSS += ".qcb-content.qcb-vertical .qcb-buttons .chat-btn {transform: scale(0.5) translate(0, " + ((buttonSize + 10)) + "px) }";
                    $(".channel-for-" + selectedDevice + ":checked").each(function (i) {
                        buttonCSS += ".qcb-content.show-icons.qcb-vertical .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(0, -" + ((buttonSize + 10) * (verticalActiveBtn-- - 1)) + "px)}";
                    });

                    var horizontalActiveBtn = activeButtons;
                    if (icon_view == "horizontal") {
                        buttonCSS += ".qcb-content.qcb-" + icon_view + " .qcb-buttons .chat-btn {transform: scale(0.5) translate(0, " + ((buttonSize) * 2) + "px) }";
                        $(".channel-for-" + selectedDevice + ":checked").each(function (i) {
                            if (position == "left") {
                                buttonCSS += ".qcb-content.qcb-" + icon_view + ".show-icons .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(" + (((buttonSize + 10) * (horizontalActiveBtn-- + 1)) - (buttonSize + 10)) + "px, " + (buttonSize + 10) + "px)}";
                            } else {
                                buttonCSS += ".qcb-content.qcb-" + icon_view + ".show-icons .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(-" + (((buttonSize + 10) * (horizontalActiveBtn-- + 1)) - (buttonSize + 10)) + "px, " + (buttonSize + 10) + "px)}";
                            }
                        });
                    }
                }

                var buttonPadding = parseInt(2 * buttonSize / 9);
                buttonCSS += ".qcb-content .chat-btn {width: " + (buttonSize + 10) + "px; height: " + (buttonSize + 10) + "px;}";
                buttonCSS += ".qcb-content .channel-btn {width: " + buttonSize + "px; height: " + buttonSize + "px;}";
                buttonCSS += ".qcb-content .channel-btn {padding: " + (buttonPadding) + "px;}";

                var spanSize = (buttonSize + 10) - (2 * buttonPadding);
                buttonCSS += ".qcb-content .kl-main-icon, .qcb-content .kl-close-icon {width: " + spanSize + "px; height: " + spanSize + "px; }";
                buttonCSS += ".qcb-content .qcb-main-button .chat-btn {width: " + (buttonSize + 20) + "px; height: " + (buttonSize + 20) + "px;}"
                buttonCSS += ".qcb-content .qcb-main-button .channel-btn {width: " + (buttonSize + 10) + "px; height: " + (buttonSize + 10) + "px;}"

                buttonCSS += ".qcb-content.show-icons .qcb-main-button .channel-btn {width: " + (buttonSize) + "px; height: " + (buttonSize) + "px;}";
                buttonCSS += ".qcb-content.show-icons .kl-main-icon, .qcb-content.show-icons .kl-close-icon {width: " + (spanSize - 10) + "px; height: " + (spanSize - 10) + "px; }";

                buttonCSS += ".qcb-content .kl-pending-message {background-color: " + $("#message_bg_color").val() + "; border-color: " + $("#message_border_color").val() + "; color: " + $("#message_text_color").val() + "}";

                var messageWidth = (buttonSize * 20) / 54;
                var messageHeight = (buttonSize * 20) / 54;

                buttonCSS += ".qcb-content .kl-pending-message {width: " + messageWidth + "px !important; height: " + messageHeight + "px !important; line-height: " + ((messageHeight / 2)) + "px; font-size: " + (parseInt(messageHeight / 4) + 4) + "px;}";

                var back_color = $("input[name='widget_setting[btn_bg_color]']").val();
                var font_color = $("input[name='widget_setting[btn_icon_color]']").val();
                buttonCSS += '.qcb-content .qcb-main-button .chat-btn a{background-color:' + back_color + ';}';
                buttonCSS += '.qcb-content:not(.has-single-button) .qcb-main-button .chat-btn a svg path{fill:' + font_color + ' !important;}';

                var verticalActiveBtn = activeButtons;
                $(".channel-for-" + selectedDevice + ":checked").each(function (i) {
                    if (position == "left") {
                        buttonCSS += ".qcb-content.qcb-vertical.show-icons.hide-close-button .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(0, -" + ((buttonSize + 10) * (verticalActiveBtn-- - 1)) + "px)}";
                    } else {
                        buttonCSS += ".qcb-content.qcb-vertical.show-icons.hide-close-button .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(-" + (buttonSize + 15) + "px, -" + ((buttonSize + 10) * (verticalActiveBtn-- - 1)) + "px)}";
                    }
                });

                var horizontalActiveBtn = activeButtons;
                $(".channel-for-" + selectedDevice + ":checked").each(function (i) {
                    if (position == "left") {
                        buttonCSS += ".qcb-content.qcb-horizontal.show-icons.hide-close-button .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(" + (((buttonSize + 10) * (horizontalActiveBtn-- - 1))) + "px, 0)}";
                    } else {
                        buttonCSS += ".qcb-content.qcb-horizontal.show-icons.hide-close-button .qcb-buttons .chat-btn:nth-child(" + (i + 1) + ") { transform: scale(1) translate(-" + (((buttonSize + 10) * (horizontalActiveBtn-- + 1)) - (buttonSize + 10)) + "px, 0)}";
                    }
                });

            }

            $("li.channel-lists .channel-bg-color").each(function () {
                var channel_name = $(this).closest("li.channel-lists").data("channel");
                if (channel_name != "instagram") {
                    buttonCSS += ".qcb-content a.channel-btn." + channel_name + "-button {background-color: " + $(this).val() + " !important}";
                }
                if (channel_name == "instagram" && $(this).val() != "#df0079" && $(this).val() != "rgba(223, 0, 121, 1)") {
                    buttonCSS += ".qcb-content a.channel-btn." + channel_name + "-button {background: " + $(this).val() + " !important}";
                }
            });

            $("li.channel-lists .channel-icon-color").each(function () {
                var channel_name = $(this).closest("li.channel-lists").data("channel");
                buttonCSS += ".qcb-content a.channel-btn." + channel_name + "-button svg {fill: " + $(this).val() + " !important}";
                if (channel_name == "slack" && $(this).val() != "#ffffff" && $(this).val() != "rgba(255, 255, 255, 1)") {
                    buttonCSS += ".qcb-content a.channel-btn." + channel_name + "-button svg path {fill: " + $(this).val() + " !important}";
                }
            });

            if (!$("#button-css").length) {
                $("head").append("<style id='button-css'></style>");
            }
            $("#button-css").html(buttonCSS);

            var no_of_messages = $("#no_of_messages").val().replace(/(<([^>]+)>)/ig, "");
            if(no_of_messages == "") {
                no_of_messages = 1;
            }
            $(".kl-pending-message").remove();
            if ((activeButtons == 1 && state != "open_by_default") || ((activeButtons > 1) && (state == "click_to_open")) || ((activeButtons > 1) && (state == "hover_to_open"))) {
                if (no_of_messages != "" && $("#show_bubble").is(":checked")) {
                    $(".qcb-content.has-single-button .qcb-main-button .chat-btn a.channel-btn, .qcb-content .qcb-main-button .chat-btn a.channel-btn").append("<span class='kl-pending-message'>" + no_of_messages + "</span>");

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

            var cta_icon = $(".cta-icon-" + $("input[name='widget_setting[cta_icon]']:checked").val()).html();
            $(".qcb-content .qcb-main-button .kl-main-icon").html(cta_icon);

            attention_effect();
        }
    }

    function transition_effect() {
        var icon_view = $("input[name='widget_setting[icon_view]']:checked").val();;
        var buttonCSS = "";
        buttonCSS += ".qcb-content .qcb-buttons .chat-btn { transition: none !important; }";
        buttonCSS += ".qcb-content .chat-btn { transition: none !important; }";
        buttonCSS += ".kl-main-icon, .kl-close-icon { transition: none !important; }";

        $(document).on("change", ".icon-position", function (){
            if(icon_view == "horizontal") {
                var transitionCss = ".qcb-content .chat-btn { transition: all 0.3s ease-in-out; }";
                transitionCss += ".kl-main-icon, .kl-close-icon { transition: all 0.3s ease-in-out; }";
                transitionCss += ".qcb-content .qcb-buttons .chat-btn { transition: none !important; }";
                $("#transition_position").remove();
                $("head").append("<style id='transition_position'>"+transitionCss+"</style>");
            }
        });

        $(document).on("change", "#hide_close_button, .icon-state, .preview_device", function (){
            var transitionCss = ".qcb-content .chat-btn { transition: all 0.3s ease-in-out; }";
            transitionCss += ".kl-main-icon, .kl-close-icon { transition: all 0.3s ease-in-out; }";
            transitionCss += ".qcb-content .qcb-buttons .chat-btn { transition: none !important; }";
            $("#transition_close_button").remove();
            $("head").append("<style id='transition_close_button'>"+transitionCss+"</style>");
        });

        $(document).on("click", ".qcb-main-button a", function (){
            var transitionCss = ".qcb-content .qcb-buttons .chat-btn { transition: all 0.3s ease-in-out !important; }";
            transitionCss += ".qcb-content .chat-btn { transition: all 0.3s ease-in-out !important; }";
            transitionCss += ".kl-main-icon, .kl-close-icon { transition: all 0.3s ease-in-out !important; }";
            $("#transition_click").remove();
            $("head").append("<style id='transition_click'>"+transitionCss+"</style>");
        });

        $(document).on("mouseenter", ".qcb-main-button a", function (){
            var transitionCss = ".qcb-content .qcb-buttons .chat-btn { transition: all 0.3s ease-in-out !important; }";
            transitionCss += ".qcb-content .chat-btn { transition: all 0.3s ease-in-out !important; }";
            transitionCss += ".kl-main-icon, .kl-close-icon { transition: all 0.3s ease-in-out !important; }";
            $("#transition_hover").remove();
            $("head").append("<style id='transition_hover'>"+transitionCss+"</style>");
        });

        if(!$("#transition-css").length) {
            $("head").append("<style id='transition-css'></style>");
        }
        $("#transition-css").html(buttonCSS);
    }

    function attention_effect() {
        var state = $("input[name='widget_setting[icon_state]']:checked").val();
        if($(".qcb-content").hasClass("show-icons")) {
            $(".qcb-content.show-icons .qcb-main-button .chat-btn a").removeClass($("#attention_effect").val());
        } else {
            if(state != "open_by_default") {
                var effects = $(".qcb-content:not(.show-icons) .qcb-main-button .chat-btn a").attr("data-effect");
                $(".qcb-content:not(.show-icons) .qcb-main-button .chat-btn a").removeClass(effects).addClass($("#attention_effect").val()).attr("data-effect", $("#attention_effect").val());
            }
        }
    }

    function showRequest(formData, jqForm, options) {
        $(".save-changes").prop("disabled", true);
        $(".kl-loader").addClass("active");
        $(".pusher").addClass("active");
        $(".save-button .svg-icon").hide();
    }

    function showResponse(responseText, statusText, xhr, $form) {
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
                $(".kl-loader").removeClass("active");
                $(".save-button .svg-icon").show();
                window.location = responseText.data.URL;
            }, 1000);
        } else {
            $(".save-changes").prop("disabled", false);
            $(".kl-loader").removeClass("active");
            $(".save-button .svg-icon").show();
            $(".pusher").removeClass("active");
            toastsHandler.createToast({
                type: "error",
                icon: "info-circle",
                message: responseText.message,
                duration: 5000
            });
        }
    }

    function showErrors(e, t ,r) {
        const swipeHandler = new SwipeHandler();
        const toastsHandler = new ToastsHandler(swipeHandler);
        $(".save-changes").prop("disabled", false);
        $(".kl-loader").removeClass("active");
        $(".save-button .svg-icon").show();
        $(".pusher").removeClass("active");
        toastsHandler.createToast({
            type: "error",
            icon: "info-circle",
            message: "Some issue with your request",
            duration: 5000
        });
    }

})( jQuery );