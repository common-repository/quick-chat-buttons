<?php
/**
 * Admin Dashboard
 *
 * @author  : Klaxon.app <contact@klaxon.app>
 * @license : GPL2
 * */
defined('ABSPATH') or die('Direct Access is not allowed');
$buttons = Quick_Chat_Buttons::get_buttons();
$arg     = [
    'post_type'    => 'quick_chat_buttons',
    'post_status'  => 'publish',
    'num_of_posts' => -1,
];
$postId  = 0;
$posts   = get_posts($arg);
if (!empty($posts)) {
    foreach ($posts as $post) {
        $postId = $post->ID;
    }
}


$otherSettings   = get_post_meta($postId, "other_setting", true);
$otherSettings   = is_array($otherSettings) && !empty($otherSettings) ? $otherSettings : [];
$defaultSettings = [
    'button_back_color'         => "#5067f3",
    'button_font_color'         => '#ffffff',
    'button_position'           => 'right',
    'side_position'             => '25',
    'bottom_position'           => '25',
    'icon_view'                 => 'vertical',
    'has_pending_message'       => 0,
    'no_of_messages'            => 1,
    'message_bg_color'          => '#ff0000',
    'message_text_color'        => '#ffffff',
    'message_border_color'      => '#ffffff',
    'button_size'               => '54',
    'button_text'               => 'Contact Us',
    'widget_state'              => 'click_to_open',
    'cta_icon'                  => 'chat-circle',
    'hide_close_button'         => 0,
    'attention_effect'          => 'attention-none'
];
$otherSettings   = shortcode_atts($defaultSettings, $otherSettings);

$defaultTriggerSettings = [
    'widget_status'     => 1,
    'after_few_seconds' => 0,
    'seconds'           => 0,
    'after_page_scroll' => 0,
    'page_scroll'       => 0

];
$triggerSettings = get_post_meta($postId, "trigger_setting", true);
$triggerSettings = is_array($triggerSettings) && !empty($triggerSettings) ? $triggerSettings : [];
$triggerSettings = shortcode_atts($defaultTriggerSettings, $triggerSettings);

?>
<form action="<?php echo admin_url("admin-ajax.php") ?>" method="post" id="qc_buttons_setting_form" autocomplete="off">
<div class="kl-dashboard">
    <div class="kl-dashboard-left">
        <div class="kl-title"><?php esc_html_e("Settings", "quick-chat-buttons") ?></div>
        <div class="kl-setting-box">
            <div class="kl-box">
                <div class="kl-box-title"><b><?php esc_html_e("Step 1:", "quick-chat-buttons") ?></b><?php esc_html_e(" Choose Popular Messenger Channels", "quick-chat-buttons") ?></div>
                <div class="kl-inner-box">
                    <div class="chat-button-list">
                        <div class="chat-buttons">
                            <?php foreach ($buttons as $key => $button) {
                                $buttonSettings        = get_post_meta($postId, "button_setting", true);
                                $buttonSettings        = isset($buttonSettings[$key]) && is_array($buttonSettings[$key]) ? $buttonSettings[$key] : [];
                                $defaultButtonSettings = [
                                    'label'   => $button['label'],
                                    'title'   => $button['title'],
                                    'color'   => $button['color'],
                                    'status'  => 0,
                                    'value'   => $button['value'],
                                    'has_desktop' => 1,
                                    'has_mobile' => 1
                                ];
                                $buttonSettings        = shortcode_atts($defaultButtonSettings, $buttonSettings);
                            ?>
                                <div class="chat-button" id="<?php echo esc_attr($key) ?>-button">
                                    <a href="javascript:;" role="button" class="channel-button channel-tooltip  <?php echo esc_attr($key) ?>-button <?php echo ($buttonSettings['status'] == "1") ? "active" : "" ?>" data-title="<?php echo esc_attr($button['title']) ?>" data-button="<?php echo esc_attr($key) ?>">
                                        <span class="button-status"></span>
                                        <span class="button-icon">
                                            <?php echo prefix_sanitize_svg($button['icon']) ?>
                                        </span>
                                    </a>
                                    <input type="hidden" name="button_setting[<?php echo esc_attr($key) ?>][status]" value="<?php echo esc_attr($buttonSettings['status']) ?>">
                                    <input type="hidden" name="button_setting[<?php echo esc_attr($key) ?>][slug]" value="<?php echo esc_attr($key) ?>">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kl-box">
                <div class="kl-box-title"><b><?php esc_html_e("Step 2:", "quick-chat-buttons") ?></b><?php esc_html_e(" Customize Your Button", "quick-chat-buttons") ?></div>
                <div class="kl-inner-box">

                    <div class="kl-field">
                        <label for="cta_icon"><?php esc_html_e("CTA Icon", "quick-chat-buttons"); ?></label>
                        <div class="cta-icon-list">
                            <ul>
                                <?php
                                $ctaIcon = Quick_Chat_Buttons::get_cta_icon();
                                foreach ($ctaIcon as $key => $value) {
                                    ?>
                                    <li>
                                        <input type="radio" id="cta_icon_<?php echo esc_attr($key) ?>" class="sr-only" name="other_settings[cta_icon]" value="<?php echo esc_attr($value['value']) ?>" <?php checked($otherSettings['cta_icon'], $key) ?>>
                                        <label for="cta_icon_<?php echo esc_attr($key) ?>" class="cta-icon-<?php echo esc_attr($key) ?>">
                                            <?php echo $value['icon'] ?>
                                        </label>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>

                    <div class="kl-field">
                        <label for="button_text"><?php esc_html_e("Button Text", "quick-chat-buttons") ?></label>
                        <textarea class="kl-input widget-tooltip" type="text" name="other_settings[button_text]" id="button_text"><?php echo esc_attr($otherSettings['button_text']) ?></textarea>
                    </div>

                    <div class="kl-field">
                        <label for="button_icon_color"><?php esc_html_e("Button Size ", "quick-chat-buttons") ?><span class="small_text"><?php esc_html_e("(in px)", "quick-chat-buttons") ?></span></label>
                        <?php
                        $sizes = [
                            45,
                            54,
                            63,
                            72,
                            81,
                            90,
                            100,
                        ];
                        ?>
                        <div class="kl-radio-list">
                            <div class="kl-radio-buttons">
                                <?php foreach ($sizes as $key => $size) { ?>
                                    <div class="kl-radio-button">
                                        <input class="sr-only" type="radio" name="other_settings[button_size]" <?php echo checked($otherSettings['button_size'], $size) ?> id="size_<?php echo esc_attr($key) ?>" value="<?php echo esc_attr($size) ?>">
                                        <label for="size_<?php echo esc_attr($key) ?>"><?php echo esc_attr($size) ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="kl-field in-flex kl-btn-position">
                        <div>
                            <label for="button_icon_color"><?php esc_html_e("Position", "quick-chat-buttons") ?></label>
                            <?php
                            $positions = [
                                "left"  => esc_html__("Left", 'quick-chat-buttons'),
                                "right" => esc_html__("Right", 'quick-chat-buttons'),
                            ];
                            ?>
                            <div class="kl-radio-list">
                                <div class="kl-radio-buttons">
                                    <?php foreach ($positions as $key => $position) { ?>
                                        <div class="kl-radio-button">
                                            <input class="sr-only icon-position" type="radio" name="other_settings[button_position]" <?php echo checked($otherSettings['button_position'], $key) ?> id="position_<?php echo esc_attr($key) ?>" value="<?php echo esc_attr($key) ?>">
                                            <label for="position_<?php echo esc_attr($key) ?>"><?php echo esc_attr($position) ?></label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="ml-25 label-prefix" data-prefix="PX">
                            <label for="side_position"><?php esc_html_e("Side Position ", "quick-chat-buttons") ?></label>
                            <input class="kl-input pos-input is-required only-numeric" type="text" name="other_settings[side_position]" id="side_position" value="<?php echo esc_attr($otherSettings['side_position']) ?>" data-label="Side Position">
                        </div>

                        <div class="ml-25 label-prefix" data-prefix="PX">
                            <label for="bottom_position"><?php esc_html_e("Bottom Position ", "quick-chat-buttons") ?></label>
                            <input class="kl-input pos-input is-required only-numeric" type="text" name="other_settings[bottom_position]" id="bottom_position" value="<?php echo esc_attr($otherSettings['bottom_position']) ?>" data-label="Bottom Position">
                        </div>

                    </div>

                    <div class="kl-field">
                        <label for="button_icon_color"><?php esc_html_e("Icon View", "quick-chat-buttons") ?>
                            <span class="qcb-info" data-qcb-tooltip="Show buttons either vertical or horizontal as per your requirement"><span class="dashicons dashicons-editor-help"></span></span>
                        </label>
                        <?php
                        $view = [
                            "vertical"  => esc_html__("Vertical", 'quick-chat-buttons'),
                            "horizontal" => esc_html__("Horizontal", 'quick-chat-buttons'),
                        ];
                        ?>
                        <div class="kl-radio-list">
                            <div class="kl-radio-buttons">
                                <?php foreach ($view as $key => $value) { ?>
                                    <div class="kl-radio-button">
                                        <input class="sr-only" type="radio" name="other_settings[icon_view]" <?php echo checked($otherSettings['icon_view'], $key) ?> id="icon_view_<?php echo esc_attr($key) ?>" value="<?php echo esc_attr($key) ?>">
                                        <label for="icon_view_<?php echo esc_attr($key) ?>"><?php echo esc_attr($value) ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    $state = [
                        'click_to_open'   => 'Click to Open',
                        'hover_to_open'   => 'Hover to Open',
                        'open_by_default' => 'Opened by Default'
                    ];
                    ?>
                    <div class="kl-field">
                        <label for=""><?php esc_html_e("State", "quick-chat-buttons"); ?>
                            <span class="qcb-info" data-qcb-tooltip="You can show buttons on hover or on click, you can also show channel buttons by default when visitor visit on your website"><span class="dashicons dashicons-editor-help"></span></span>
                        </label>
                        <div class="kl-radio-list">
                            <div class="kl-radio-buttons">
                                <?php foreach ($state as $key => $value) { ?>
                                    <div class="kl-radio-button">
                                        <input class="sr-only widget-state" type="radio" name="other_settings[widget_state]" <?php echo checked($otherSettings['widget_state'], $key) ?> id="<?php echo esc_attr($key) ?>" value="<?php echo esc_attr($key) ?>">
                                        <label for="<?php echo esc_attr($key) ?>"><?php echo esc_attr($value) ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="p-20 d-none widget-state-box <?php echo ($otherSettings['widget_state'] == "open_by_default") ? "active" : "" ?>">
                            <div class="in-flex qcb-custom-checkbox-box">
                                <input type="hidden" name="other_settings[hide_close_button]" value="0">
                                <input type="checkbox" value="1" class="qcb-custom-checkbox" name="other_settings[hide_close_button]" <?php checked($otherSettings['hide_close_button'], 1) ?> id="hide_close_button">
                                <label for="hide_close_button"><?php esc_html_e("Hide Close Button", "quick-chat-buttons"); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="kl-field">
                        <label for="button_bg_color"><?php esc_html_e("Button Background Color", "quick-chat-buttons") ?></label>
                        <input type="text" class="sr-only color-picker" name="" value="<?php echo esc_attr($otherSettings['button_back_color'])  ?>"/>
                        <input type="hidden" class="color_val" name="other_settings[button_back_color]" value="<?php echo esc_attr($otherSettings['button_back_color'])  ?>">
                    </div>

                    <div class="kl-field">
                        <label for="button_icon_color"><?php esc_html_e("Button Icon Color", "quick-chat-buttons") ?></label>
                        <input type="text" class="sr-only color-picker" name="" value="<?php echo esc_attr($otherSettings['button_font_color']) ?>"/>
                        <input type="hidden" class="color_val" name="other_settings[button_font_color]" value="<?php echo esc_attr($otherSettings['button_font_color']) ?>">
                    </div>

                    <?php $attentionEffect = Quick_Chat_Buttons::get_attention_effects(); ?>
                    <div class="kl-field">
                        <label for=""><?php esc_html_e("Attention Effect", "quick-chat-buttons"); ?></label>
                        <select name="other_settings[attention_effect]" class="sumoselect btn-attention-effect">
                            <?php foreach ($attentionEffect as $key => $value) { ?>
                                <option value="<?php echo esc_attr($value['value']) ?>" <?php selected($value['value'], $otherSettings['attention_effect']) ?>><?php echo esc_attr($value['title']) ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="kl-field">
                        <div class="in-flex qcb-custom-checkbox-box">
                            <input type="hidden" name="other_settings[has_pending_message]" value="0">
                            <input type="checkbox" value="1" class="qcb-custom-checkbox" name="other_settings[has_pending_message]" <?php checked($otherSettings['has_pending_message'], 1) ?> id="has_pending_message">
                            <label for="has_pending_message" class="d-flex-end"><?php esc_html_e("Show Chat Bubble", "quick-chat-buttons"); ?>
                                <span class="qcb-info" data-qcb-tooltip="Show Bubble on CTA button"><span class="dashicons dashicons-editor-help"></span></span>
                            </label>
                        </div>
                        <div class="container-box d-none pending-message-box <?php echo ($otherSettings['has_pending_message'] == 1) ? "active" : "" ?>">
                            <div class="kl-field">
                                <label for="no_of_messages"><?php esc_html_e("Number of Messages ", "quick-chat-buttons") ?></label>
                                <input class="kl-input pos-input is-required" type="text" name="other_settings[no_of_messages]" id="no_of_messages" value="<?php echo esc_attr($otherSettings['no_of_messages']) ?>" data-label="No of Messages">
                            </div>
                            <div class="in-flex mt-15 pending-message-color-box">
                                <div class="flex-1 kl-field">
                                    <label for="message_bg_color"><?php esc_html_e("Background Color", "quick-chat-buttons") ?></label>
                                    <input type="text" class="sr-only color-picker" name="" value="<?php echo esc_attr($otherSettings['message_bg_color'])  ?>"/>
                                    <input type="hidden" class="color_val" id="message_bg_color" name="other_settings[message_bg_color]" value="<?php echo esc_attr($otherSettings['message_bg_color'])  ?>">
                                </div>
                                <div class="ml-25 flex-1 kl-field">
                                    <label for="message_text_color"><?php esc_html_e("Text Color", "quick-chat-buttons") ?></label>
                                    <input type="text" class="sr-only color-picker" name="" value="<?php echo esc_attr($otherSettings['message_text_color'])  ?>"/>
                                    <input type="hidden" class="color_val" id="message_text_color" name="other_settings[message_text_color]" value="<?php echo esc_attr($otherSettings['message_text_color'])  ?>">
                                </div>
                                <div class="ml-25 flex-1 kl-field">
                                    <label for="message_border_color"><?php esc_html_e("Border Color", "quick-chat-buttons") ?></label>
                                    <input type="text" class="sr-only color-picker" name="" value="<?php echo esc_attr($otherSettings['message_border_color'])  ?>"/>
                                    <input type="hidden" class="color_val" id="message_border_color" name="other_settings[message_border_color]" value="<?php echo esc_attr($otherSettings['message_border_color'])  ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="kl-box">
                <div class="kl-box-title"><b><?php esc_html_e("Step 3:", "quick-chat-buttons") ?></b><?php esc_html_e(" Trigger Setting", "quick-chat-buttons") ?></div>
                <div class="kl-inner-box">
                    <div class="kl-field ">
                        <div class="in-flex qcb-custom-checkbox-box">
                            <input type="hidden" name="trigger_settings[widget_status]" value="0">
                            <input type="checkbox" value="1" class="qcb-custom-checkbox" name="trigger_settings[widget_status]" <?php checked($triggerSettings['widget_status'], 1) ?> id="widget_status">
                            <label for="widget_status"><?php esc_html_e("Widget Status", "quick-chat-buttons"); ?></label>
                        </div>
                    </div>

                    <div class="warning-message <?php echo ($triggerSettings['widget_status'] == 0) ? "active" : "" ?>">
                        <span class="warning-icon"><span class="dashicons dashicons-info-outline"></span></span>
                        <span class="warning-title">Widget is disabled</span>
                    </div>

                    <div class="trigger-box mt-15 <?php echo ($triggerSettings['widget_status'] == 1) ? "active" : "" ?>">
                        <div class="kl-field">
                            <div class="in-flex qcb-custom-checkbox-box">
                                <input type="hidden" name="trigger_settings[after_few_seconds]" value="0">
                                <input type="checkbox" value="1" class="qcb-custom-checkbox" name="trigger_settings[after_few_seconds]" <?php checked($triggerSettings['after_few_seconds'], 1) ?> id="after_few_seconds">
                                <label for="after_few_seconds"><?php esc_html_e("After Few Seconds", "quick-chat-buttons"); ?></label>
                            </div>
                            <div class="container-box d-none after-seconds-box <?php echo ($triggerSettings['after_few_seconds'] == 1) ? "active" : "" ?>">
                                <div class="kl-field">
                                    <span><?php esc_html_e("Show Chat Buttons after visitor spent ","quick-chat-buttons") ?><input type="text" class="kl-input only-numeric small-input" name="trigger_settings[seconds]" value="<?php echo esc_attr($triggerSettings['seconds']) ?>"><?php esc_html_e(" seconds on website", "quick-chat-buttons") ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="kl-field">
                            <div class="in-flex qcb-custom-checkbox-box">
                                <input type="hidden" name="trigger_settings[after_page_scroll]" value="0">
                                <input type="checkbox" value="1" class="qcb-custom-checkbox" name="trigger_settings[after_page_scroll]" <?php checked($triggerSettings['after_page_scroll'], 1) ?> id="after_page_scroll">
                                <label for="after_page_scroll"><?php esc_html_e("After Page Scroll", "quick-chat-buttons"); ?></label>
                            </div>
                            <div class="container-box d-none after-page-scroll-box <?php echo ($triggerSettings['after_page_scroll'] == 1) ? "active" : "" ?>">
                                <div class="kl-field">
                                    <span><?php esc_html_e("Show Chat Buttons after visitor scroll ","quick-chat-buttons") ?><input type="text" class="kl-input only-numeric small-input" name="trigger_settings[page_scroll]" value="<?php echo esc_attr($triggerSettings['page_scroll']) ?>"><?php esc_html_e(" % on page", "quick-chat-buttons") ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="kl-buttons">
                <button type="submit" class="kl-button primary-button"><?php esc_html_e("Save Changes", "quick-chat-buttons") ?></button>
                <div class="kl-loader">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M142.9 142.9c62.2-62.2 162.7-62.5 225.3-1L327 183c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H463.5c0 0 0 0 0 0H472c13.3 0 24-10.7 24-24V72c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2L413.4 96.6c-87.6-86.5-228.7-86.2-315.8 1C73.2 122 55.6 150.7 44.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5c7.7-21.8 20.2-42.3 37.8-59.8zM16 312v7.6 .7V440c0 9.7 5.8 18.5 14.8 22.2s19.3 1.7 26.2-5.2l41.6-41.6c87.6 86.5 228.7 86.2 315.8-1c24.4-24.4 42.1-53.1 52.9-83.7c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.2 62.2-162.7 62.5-225.3 1L185 329c6.9-6.9 8.9-17.2 5.2-26.2s-12.5-14.8-22.2-14.8H48.4h-.7H40c-13.3 0-24 10.7-24 24z"/></svg>
                </div>
            </div>
        </div>
    </div>
    <div class="kl-dashboard-right">

    </div>
    <?php require "modal.php" ?>
        <input type="hidden" name="action" value="save_qc_buttons_setting" />
        <input type="hidden" id="button_setting_nonce" name="nonce" value="<?php echo wp_create_nonce("save_qc_buttons_setting") ?>" />
        <input type="hidden" name="post_id" value="<?php echo esc_attr($postId) ?>">
</div>
</form>