<?php
$defaultTriggerSetting = Quick_Chat_Buttons::get_trigger_settings();
$triggerSettings = get_post_meta($postId, "trigger_setting", true);
$triggerSettings = isset($triggerSettings) && !empty($triggerSettings) ? $triggerSettings : [];
$triggerSetting = shortcode_atts($defaultTriggerSetting, $triggerSettings);

$timeZones = Quick_Chat_Buttons::get_timezone();
?>
<div class="form-field">
    <div class="switch-box">
        <input type="hidden" name="trigger_setting[widget_status]" value="0">
        <input type="checkbox" class="sr-only" id="widget_status" value="1" name="trigger_setting[widget_status]" <?php echo checked($triggerSetting['widget_status'], 1) ?>>
        <label for="widget_status"><?php esc_html_e("Widget Status", "quick-chat-buttons") ?></label>
    </div>
</div>

<div class="warning-message <?php echo ($triggerSetting['widget_status'] == 0) ? "active" : "" ?>">
    <span class="warning-icon"><span class="dashicons dashicons-info-outline"></span></span>
    <span class="warning-title"><?php esc_html_e("Widget is Disabled", "quick-chat-buttons") ?></span>
</div>

<div class="trigger-rules <?php echo ($triggerSetting['widget_status'] == 1) ? "active" : "" ?>">
    <div class="form-field">
        <div class="switch-box">
            <input type="hidden" name="trigger_setting[after_seconds]" value="0">
            <input type="checkbox" class="sr-only" id="after_few_sec" name="trigger_setting[after_seconds]" value="1" <?php echo checked($triggerSetting['after_seconds'], 1) ?>>
            <label for="after_few_sec"><?php esc_html_e("After Few Seconds", "quick-chat-buttons") ?></label>
        </div>
    </div>

    <div class="form-field seconds-box <?php echo ($triggerSetting['after_seconds'] == 1) ? "active" : "" ?>">
        <span class="span-input"><?php esc_html_e("Show Chat Buttons after visitor spent ", "quick-chat-buttons") ?><input type="text" name="trigger_setting[seconds]" class="input-field only-numeric" value="<?php echo esc_attr($triggerSetting['seconds']) ?>" ><?php esc_html_e(" seconds on website", "quick-chat-buttons") ?></span>
    </div>

    <div class="form-field">
        <div class="switch-box">
            <input type="hidden" name="trigger_setting[after_scroll]" value="0">
            <input type="checkbox" class="sr-only" id="after_page_scroll" name="trigger_setting[after_scroll]" value="1" <?php echo checked($triggerSetting['after_scroll'], 1) ?>>
            <label for="after_page_scroll"><?php esc_html_e("On Page Scroll", "quick-chat-buttons") ?></label>
        </div>
    </div>
    <div class="form-field page-scroll-box <?php echo ($triggerSetting['after_scroll'] == 1) ? "active" : "" ?>">
        <span class="span-input"><?php esc_html_e("Show Chat Buttons after visitor scroll ", "quick-chat-buttons") ?><input type="text" name="trigger_setting[page_scroll]" class="input-field only-numeric" value="<?php echo esc_attr($triggerSetting['page_scroll']) ?>" ><?php esc_html_e("  % on page", "quick-chat-buttons") ?></span>
    </div>
</div>

<div class="custom-rules">
    <div class="rule-label">
        <?php esc_html_e("Page Rules", "quick-chat-buttons") ?>
        <span class="kl-tooltip">
            <span class="kl-tooltip-text"><?php esc_html_e("Select the pages where you want to hide or show this widget. You can use conditions like URL is, URL contains, URL starts with, URL ends with.", "quick-chat-buttons") ?></span>
            <span class="tooltip-icon"><?php echo $icon['help'] ?></span>
        </span>
    </div>
    <div class="page-rule-section active pro-content">
        <div class="page-rules">
            <div class="page-rule">
                <div class="page-status">
                    <div class="radio-buttons">
                        <div class="radio-button">
                            <input type="radio" id="show_on_0" class="sr-only" name="" value="show_on" checked>
                            <label for="show_on_0"><?php esc_html_e("Show On", "quick-chat-buttons") ?></label>
                        </div>
                        <div class="radio-button">
                            <input type="radio" id="hide_on_0" class="sr-only" name="" value="hide_on">
                            <label for="hide_on_0"><?php esc_html_e("Hide On", "quick-chat-buttons") ?></label>
                        </div>
                    </div>
                </div>
                <div class="page-content">
                    <select class="select2" name="">
                        <option value=""><?php esc_html_e("Select Rule", "quick-chat-buttons") ?></option>
                        <option value="equal"><?php esc_html_e("URL Is", "quick-chat-buttons") ?></option>
                        <option value="contains"><?php esc_html_e("URL Contains", "quick-chat-buttons") ?></option>
                        <option value="begin"><?php esc_html_e("URL Begins With", "quick-chat-buttons") ?></option>
                        <option value="end"><?php esc_html_e("URL Ends With", "quick-chat-buttons") ?></option>
                    </select>
                </div>
                <div class="page-value">
                    <input type="text" name="" class="input-field" value="">
                </div>
                <div class="remove-row">
                    <a href="javascript:;" class="remove-selected-rule">
                        <?php echo $icon['trash'] ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="pro-overlay">
            <a class="kl-upgrade-link pro-button upgrade-widget"
               href="javascript:;" data-title="<?php esc_html_e("Page Targeting is a Pro feature", "quick-chat-buttons") ?>"><span
                        class="svg-icon lock-icon"><?php echo $icon['lock'] ?></span><span
                        class="display-ib"><?php esc_html_e("Upgrade to Pro", "quick-chat-buttons") ?></span></a>
        </div>
    </div>
    <a href="javascript:;" id="create_page_rule" class="create-rule-button"><?php esc_html_e("Create Rule", "quick-chat-buttons") ?></a>
    <a href="javascript:;" id="remove_page_rule" class="remove-rule-button"><?php esc_html_e("Remove Rule", "quick-chat-buttons") ?></a>
</div>

<div class="custom-rules">
    <div class="rule-label">
        <?php esc_html_e("Date and Time Schedule", "quick-chat-buttons") ?>
        <span class="kl-tooltip">
            <span class="kl-tooltip-text"><?php esc_html_e("Specify the date and time when you want to show this widget to your website visitors.", "quick-chat-buttons") ?></span>
            <span class="tooltip-icon"><?php echo $icon['help'] ?></span>
        </span>
    </div>
    <div class="pro-content">
        <div class="date-schedules">
            <div class="form-field">
                <label class="form-label">
                    <?php esc_html_e("Timezone", "quick-chat-buttons") ?>
                </label>
                <div class="form-input">
                    <select class="select2" name="">
                        <?php foreach ($timeZones as $key => $value) { ?>
                            <option value="<?php echo esc_attr($key) ?>"><?php echo esc_attr($value) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="date-settings">
                <div class="date-setting">
                    <div class="form-field">
                        <label class="form-label">
                            <?php esc_html_e("Start Date", "quick-chat-buttons") ?>
                        </label>
                        <div class="form-input">
                            <span class="calender-input">
                                <input type="text" name="" id="start_date_time_picker" class="input-field start-end-date" value="">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="date-setting">
                    <div class="form-field">
                        <label class="form-label">
                            <?php esc_html_e("End Date", "quick-chat-buttons") ?>
                        </label>
                        <div class="form-input">
                            <span class="calender-input">
                                <input type="text" name="" id="end_date_time_picker" class="input-field start-end-date" value="">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pro-overlay">
            <a class="kl-upgrade-link pro-button upgrade-widget"
               href="javascript:;" data-title="<?php esc_html_e("Date and Time Schedule is a Pro feature", "quick-chat-buttons") ?>"><span
                        class="svg-icon lock-icon"><?php echo $icon['lock'] ?></span><span
                        class="display-ib"><?php esc_html_e("Upgrade to Pro", "quick-chat-buttons") ?></span></a>
        </div>
    </div>
    <a href="javascript:;" class="create-rule-button" id="create_date_rule"><?php esc_html_e("Create Rule", "quick-chat-buttons") ?></a>
    <a href="javascript:;" class="remove-rule-button" id="remove_date_rule"><?php esc_html_e("Remove Rule", "quick-chat-buttons") ?></a>
</div>

<div class="custom-rules">
    <div class="rule-label">
        <?php esc_html_e("Days and Hours Schedule", "quick-chat-buttons") ?>
        <span class="kl-tooltip">
            <span class="kl-tooltip-text"><?php esc_html_e("Specify the days and times when you want to show this widget to your website visitors.", "quick-chat-buttons") ?></span>
            <span class="tooltip-icon"><?php echo $icon['help'] ?></span>
        </span>
    </div>
    <div class="pro-content">
        <div class="days-schedule">
            <div class="form-field">
                <label class="form-label">
                    <?php esc_html_e("Timezone", "quick-chat-buttons") ?>
                </label>
                <div class="form-input">
                    <select class="select2" name="">
                        <?php foreach ($timeZones as $key => $value) { ?>
                            <option value="<?php echo esc_attr($key) ?>"><?php echo esc_attr($value) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="week-schedule">
                <?php for ($i = 0;
                           $i < 7;
                           $i++) { ?>
                    <div class="day-schedule">
                        <div class="day-title">
                            <div class="switch-box">
                                <input type="hidden" name="" value="0">
                                <input type="checkbox" name="" class="sr-only day-time-rule-status" id="day_time_status_<?php echo esc_attr($i) ?>" value="1" checked>
                                <label for="day_time_status_<?php echo esc_attr($i) ?>"><?php echo date("l", strtotime("1970-01-" . ($i + 4))) ?></label>
                            </div>
                        </div>
                        <div class="day-setting active">
                            <div class="widget-off"><?php esc_html_e("Widget Off", "quick-chat-buttons") ?></div>
                            <div class="time-settings">
                                <div class="from-time">
                                    <label><?php esc_html_e("From", "quick-chat-buttons") ?></label>
                                    <span class="clock-input">
                                        <input type="text" id="start_time_picker_setting_<?php echo esc_attr($i) ?>" name="" class="start-timepicker" value="10:00">
                                    </span>
                                </div>
                                <div class="to-time">
                                    <label><?php esc_html_e("To", "quick-chat-buttons") ?></label>
                                    <span class="clock-input">
                                        <input type="text" id="end_time_picker_setting_<?php echo esc_attr($i) ?>" name="" class="end-timepicker" value="19:00">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="pro-overlay">
            <a class="kl-upgrade-link pro-button upgrade-widget"
               href="javascript:;" data-title="<?php esc_html_e("Days and Hours Schedule is a Pro feature", "quick-chat-buttons") ?>"><span
                        class="svg-icon lock-icon"><?php echo $icon['lock'] ?></span><span
                        class="display-ib"><?php esc_html_e("Upgrade to Pro", "quick-chat-buttons") ?></span></a>
        </div>
    </div>
    <a href="javascript:;" id="create_day_time_rule" class="create-rule-button"><?php esc_html_e("Create Rule", "quick-chat-buttons") ?></a>
    <a href="javascript:;" id="remove_day_time_rule" class="remove-rule-button"><?php esc_html_e("Remove Rule", "quick-chat-buttons") ?></a>
</div>