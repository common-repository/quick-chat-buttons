<?php
$defaultCustomizeSetting = Quick_Chat_Buttons::get_customize_widget_settings();
$customizeSettings = get_post_meta($postId, "widget_setting", true);
$customizeSettings = isset($customizeSettings) && !empty($customizeSettings) ? $customizeSettings : [];
$customizeSetting = shortcode_atts($defaultCustomizeSetting, $customizeSettings);

$ctaIcons = Quick_Chat_Buttons::get_cta_icon();
$sizes = Quick_Chat_Buttons::get_button_size();
?>
<div class="form-field">
    <label class="form-label">
        <?php esc_html_e("CTA Icon", "quick-chat-buttons") ?>
    </label>
    <div class="form-input">
        <div class="cta-icon-list">
            <ul>
                <?php
                foreach ($ctaIcons as $key => $value) {
                    ?>
                    <li>
                        <input type="radio" id="cta_icon_<?php echo esc_attr($key) ?>" class="sr-only" name="widget_setting[cta_icon]" value="<?php echo esc_attr($value['value']) ?>" <?php echo checked($customizeSetting['cta_icon'], $key) ?>>
                        <label for="cta_icon_<?php echo esc_attr($key) ?>" class="cta-icon-<?php echo esc_attr($key) ?>">
                            <?php echo $value['icon'] ?>
                        </label>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<div class="form-field">
    <label class="form-label" for="cta_text">
        <?php esc_html_e("CTA Text", "quick-chat-buttons") ?>
    </label>
    <div class="form-input">
        <textarea name="widget_setting[cta_text]" id="cta_text" class="input-field"><?php echo esc_attr($customizeSetting['cta_text']) ?></textarea>
    </div>
</div>
<div class="form-field">
    <label class="form-label">
        <?php esc_html_e("Button Size", "quick-chat-buttons") ?>
    </label>
    <div class="form-input">
        <div class="radio-buttons">
            <?php foreach ($sizes as $key => $value) { ?>
                <div class="radio-button">
                    <input type="radio" id="size_<?php echo esc_attr($key) ?>" class="sr-only" name="widget_setting[button_size]" value="<?php echo esc_attr($value) ?>" <?php echo checked($customizeSetting['button_size'], $value) ?>>
                    <label for="size_<?php echo esc_attr($key) ?>"><?php echo esc_attr($value) ?></label>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="position-input-row">
    <div class="form-field">
        <label class="form-label">
            <?php esc_html_e("Position", "quick-chat-buttons") ?>
        </label>
        <?php
        $position = [
            'left' => 'Left',
            'right' => 'Right'
        ]
        ?>
        <div class="form-input">
            <div class="radio-buttons">
                <?php foreach ($position as $key => $value) { ?>
                    <div class="radio-button">
                        <input type="radio" id="position_<?php echo esc_attr($key) ?>" class="sr-only icon-position" name="widget_setting[position]" value="<?php echo esc_attr($key) ?>" <?php echo checked($customizeSetting['position'], $key) ?>>
                        <label for="position_<?php echo esc_attr($key) ?>"><?php echo esc_attr($value) ?></label>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="form-field">
        <label class="form-label" for="side_position">
            <?php esc_html_e("Side Position", "quick-chat-buttons") ?>
        </label>
        <div class="form-input label-prefix" data-prefix="PX">
            <input type="text" name="widget_setting[side_position]" id="side_position" class="input-field only-numeric" value="<?php echo esc_attr($customizeSetting['side_position']) ?>">
        </div>
    </div>
    <div class="form-field">
        <label class="form-label" for="bottom_position">
            <?php esc_html_e("Bottom Position", "quick-chat-buttons") ?>
        </label>
        <div class="form-input label-prefix" data-prefix="PX">
            <input type="text" name="widget_setting[bottom_position]" id="bottom_position" class="input-field only-numeric" value="<?php echo esc_attr($customizeSetting['bottom_position']) ?>">
        </div>
    </div>
</div>
<div class="form-field">
    <label class="form-label">
        <?php esc_html_e("Icon View", "quick-chat-buttons") ?>
    </label>
    <?php
    $views = [
        'vertical' => 'Vertical',
        'horizontal' => 'Horizontal'
    ];
    ?>
    <div class="form-input">
        <div class="radio-buttons">
            <?php foreach ($views as $key => $value) { ?>
                <div class="radio-button">
                    <input type="radio" id="icon_view_<?php echo esc_attr($key) ?>" class="sr-only" name="widget_setting[icon_view]" value="<?php echo esc_attr($key) ?>" <?php echo checked($customizeSetting['icon_view'], $key) ?>>
                    <label for="icon_view_<?php echo esc_attr($key) ?>"><?php echo esc_attr($value) ?></label>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="form-field">
    <label class="form-label">
        <?php esc_html_e("State", "quick-chat-buttons") ?>
    </label>
    <?php
    $state = [
        'click_to_open' => 'Click to Open',
        'hover_to_open' => 'Hover to Open',
        'open_by_default' => 'Open by Default'
    ];
    ?>
    <div class="form-input">
        <div class="radio-buttons">
            <?php foreach ($state as $key => $value) { ?>
                <div class="radio-button">
                    <input type="radio" id="state_<?php echo esc_attr($key) ?>" class="sr-only icon-state" name="widget_setting[icon_state]" value="<?php echo esc_attr($key) ?>" <?php echo checked($customizeSetting['icon_state'], $key) ?>>
                    <label for="state_<?php echo esc_attr($key) ?>"><?php echo esc_attr($value) ?></label>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="form-field hide-close-btn <?php echo ($customizeSetting['icon_state'] == "open_by_default") ? "active" : "" ?>">
    <div class="switch-box">
        <input type="hidden" name="widget_setting[hide_close_btn]" value="0">
        <input type="checkbox" class="sr-only" id="hide_close_button" name="widget_setting[hide_close_btn]" value="1" <?php echo checked($customizeSetting['hide_close_btn'], 1) ?>>
        <label for="hide_close_button"><?php esc_html_e("Hide Close Button", "quick-chat-buttons") ?></label>
    </div>
</div>
<div class="form-field">
    <label class="form-label">
        <?php esc_html_e("Button Background Color", "quick-chat-buttons") ?>
    </label>
    <div class="form-input">
        <?php
        $colors = ["#ffffff", "#000000", "#512DA8",'#ff6472','#71f1f1','#f4ac60','#5cc0fa','#8ed476'];
        ?>
        <div class="color-list">
            <ul>
                <li>
                    <input type="text" name="widget_setting[btn_bg_color]" class="color-picker custom-color" id="btn_back_color_custom" value="<?php echo esc_attr($customizeSetting['btn_bg_color']) ?>">
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="form-field">
    <label class="form-label">
        <?php esc_html_e("Button Icon Color", "quick-chat-buttons") ?>
    </label>
    <div class="form-input">
        <div class="color-list">
            <ul>
                <li>
                    <input type="text" name="widget_setting[btn_icon_color]" class="color-picker custom-color" id="btn_icon_color_custom" value="<?php echo esc_attr($customizeSetting['btn_icon_color']) ?>">
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="form-field">
    <?php
    $attection = [
        'attention-none' => 'None',
        'attention-bounce' => 'Bounce',
        'attention-flash' => 'Flash',
        'attention-gelatine' => 'Gelatine',
        'attention-pulse' => 'Pulse',
        'attention-shake' => 'Shake',
        'attention-shockwave' => 'Shockwave',
        'attention-spin' => 'Spin',
        'attention-swing' => 'Swing',
    ]
    ?>
    <label class="form-label">
        <?php esc_html_e("Attention Effect", "quick-chat-buttons") ?>
        <span class="kl-tooltip">
            <span class="kl-tooltip-text"><?php esc_html_e("Show smart animation to CTA button to capture users attention and focus. It will be shown until user clicks on it.", "quick-chat-buttons") ?></span>
            <span class="tooltip-icon"><?php echo $icon['help'] ?></span>
        </span>
    </label>
    <div class="form-input">
        <select class="select2-animation" name="widget_setting[attention_effect]" id="attention_effect">
            <?php foreach($attection as $key=>$value) { ?>
                <option value="<?php echo esc_attr($key) ?>" <?php echo selected($customizeSetting['attention_effect'], $key) ?>><?php echo esc_attr($value) ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-field">
    <div class="switch-box">
        <input type="hidden" name="widget_setting[show_chat_bubble]" value="0">
        <input type="checkbox" name="widget_setting[show_chat_bubble]" class="sr-only" id="show_bubble" value="1" <?php echo checked($customizeSetting['show_chat_bubble'], 1) ?>>
        <label for="show_bubble">
            <?php esc_html_e("Show Chat Bubble", "quick-chat-buttons") ?>
            <span class="kl-tooltip">
                <span class="kl-tooltip-text"><?php esc_html_e("Enable the chat bubble icon to provide users with easy access to messaging and communication. When activated, this feature displays a small bubble icon on the widget CTA button.", "quick-chat-buttons") ?></span>
                <span class="tooltip-icon"><?php echo $icon['help'] ?></span>
            </span>
        </label>
    </div>
</div>

<div class="pending-message-box form-field <?php echo ($customizeSetting['show_chat_bubble'] == 1) ? "active" : "" ?>">
    <div class="form-field">
        <label class="form-label" for="no_of_messages">
            <?php esc_html_e("Number of Messages", "quick-chat-buttons") ?>
        </label>
        <div class="form-input d-grid">
            <input type="text" name="widget_setting[num_of_message]" id="no_of_messages" class="input-field only-numeric" placeholder="1" value="<?php echo esc_attr($customizeSetting['num_of_message']) ?>" data-name="No of messages">
        </div>
    </div>
    <div class="position-input-row message-colors">
        <div class="form-field">
            <label class="form-label">
                <?php esc_html_e("Background Color", "quick-chat-buttons") ?>
            </label>
            <div class="form-input">
                <div class="color-list">
                    <ul>
                        <li>
                            <input type="text" name="widget_setting[message_bg_color]" class="color-picker" id="message_bg_color" value="<?php echo esc_attr($customizeSetting['message_bg_color']) ?>">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="form-field">
            <label class="form-label">
                <?php esc_html_e("Text Color", "quick-chat-buttons") ?>
            </label>
            <div class="form-input">
                <div class="color-list">
                    <ul>
                        <li>
                            <input type="text" name="widget_setting[message_text_color]" class="color-picker" id="message_text_color" value="<?php echo esc_attr($customizeSetting['message_text_color']) ?>">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="form-field">
            <label class="form-label">
                <?php esc_html_e("Border Color", "quick-chat-buttons") ?>
            </label>
            <div class="form-input">
                <div class="color-list">
                    <ul>
                        <li>
                            <input type="text" name="widget_setting[message_border_color]" class="color-picker" id="message_border_color" value="<?php echo esc_attr($customizeSetting['message_border_color']) ?>">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>