<?php
$buttons = Quick_Chat_Buttons::get_buttons();
$buttonSetting = get_post_meta($postId, "button_setting", true);
?>
<div class="chat-button-list">
    <div class="chat-buttons">
        <?php foreach ($buttons as $key => $button) {
            $defaultChannelSetting = [
                'status' => $button['status'],
                'slug' => $key
            ];
            $buttonSettings = isset($buttonSetting[$key]) && !empty($buttonSetting[$key]) ? $buttonSetting[$key] : [];
            $buttonSettings = shortcode_atts($defaultChannelSetting, $buttonSettings);
            $channel_meta = get_post_meta($postId, "channel_setting", true);
            if (empty($channel_meta)) {
                if($key == "whatsapp" || $key == "facebook_messenger") {
                    $buttonSettings['status'] = 1;
                }
            }
        ?>
            <div class="chat-button" id="<?php echo esc_attr($key) ?>-button">
                <a href="javascript:;" role="button" data-qcb-tooltip="<?php echo esc_attr($button['title']) ?>"
                   class="channel-button channel-tooltip  <?php echo esc_attr($key) ?>-button <?php echo ($buttonSettings['status'] == "1") ? "active" : "" ?>"
                   data-title="<?php echo esc_attr($button['title']) ?>" data-button="<?php echo esc_attr($key) ?>">
                    <span class="button-status"></span>
                    <span class="button-icon">
                        <?php echo $button['icon'] ?>
                    </span>
                </a>
                <input type="hidden" name="button_setting[<?php echo esc_attr($key) ?>][status]"
                       value="<?php echo esc_attr($buttonSettings['status']) ?>">
                <input type="hidden" name="button_setting[<?php echo esc_attr($key) ?>][slug]"
                       value="<?php echo esc_attr($key) ?>">
            </div>
        <?php } ?>
    </div>
</div>