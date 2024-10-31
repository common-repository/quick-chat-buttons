<?php
/**
 * Modals for channels
 *
 * @author  : Klaxon.app <contact@klaxon.app>
 * @license : GPL2
 * */
defined('ABSPATH') or die('Direct Access is not allowed');

foreach ($buttons as $key => $button) {
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
    $buttonSettings        = shortcode_atts($defaultButtonSettings, $buttonSettings);?>
    <div class="kl-modal m-size" id="<?php echo esc_attr($key) ?>-setting" data-button="<?php echo esc_attr($key) ?>">
        <div class="kl-modal-bg"></div>
        <div class="kl-modal-container">
            <div class="kl-modal-content">
                <div class="kl-modal-title">
                    <?php echo esc_attr($button['title']) ?>
                </div>
                <div class="kl-modal-body">
                    <div class="kl-field in-flex">
                        <div class="kl-field-left">
                            <label for="<?php echo esc_attr($key) ?>_label"><?php echo esc_attr($button['label'])?></label>
                        </div>
                        <div class="kl-field-right">
                            <input class="kl-input kl-required" type="text" name="button_setting[<?php echo esc_attr($key) ?>][value]" id="<?php echo esc_attr($key) ?>_label" value="<?php echo esc_attr($buttonSettings['value'])?>">
                            <span class="kl-error-message"><?php esc_html_e("This field is required", "quick-chat-buttons"); ?></span>
                            <span class="kl-example"><?php esc_html_e("Example: ", "quick-chat-buttons") ?><?php echo esc_attr($button['example']) ?></span>
                        </div>
                    </div>
                    <div class="kl-field in-flex">
                        <div class="kl-field-left">
                            <label for="<?php echo esc_attr($key) ?>_title"><?php esc_html_e("Title", "quick-chat-buttons") ?></label>
                        </div>
                        <div class="kl-field-right">
                            <input class="kl-input button-title" type="text" name="button_setting[<?php echo esc_attr($key) ?>][title]" id="<?php echo esc_attr($key) ?>_title" value="<?php echo esc_attr($buttonSettings['title'])?>" >
                        </div>
                    </div>
                    <div class="kl-field in-flex">
                        <div class="kl-field-left">
                            <label for="<?php echo esc_attr($key) ?>_desktop" class="pt-0"><?php esc_html_e("Desktop", "quick-chat-buttons") ?></label>
                        </div>
                        <div class="kl-field-right">
                            <div class="qcb-custom-checkbox-box">
                                <input type="hidden" name="button_setting[<?php echo esc_attr($key) ?>][has_desktop]" value="0">
                                <input type="checkbox" value="1" class="qcb-custom-checkbox" name="button_setting[<?php echo esc_attr($key) ?>][has_desktop]" <?php checked($buttonSettings['has_desktop'], 1) ?> id="<?php echo esc_attr($key) ?>_desktop">
                            </div>
                        </div>
                    </div>
                    <div class="kl-field in-flex">
                        <div class="kl-field-left">
                            <label for="<?php echo esc_attr($key) ?>_mobile" class="pt-0"><?php esc_html_e("Mobile", "quick-chat-buttons") ?></label>
                        </div>
                        <div class="kl-field-right">
                            <div class="qcb-custom-checkbox-box">
                                <input type="hidden" name="button_setting[<?php echo esc_attr($key) ?>][has_mobile]" value="0">
                                <input type="checkbox" value="1" class="qcb-custom-checkbox" name="button_setting[<?php echo esc_attr($key) ?>][has_mobile]" <?php checked($buttonSettings['has_mobile'], 1) ?> id="<?php echo esc_attr($key) ?>_mobile">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kl-modal-footer">
                    <div class="footer-buttons">
                        <button type="button" class="kl-button primary-button add-channel-button"><?php esc_html_e("Add", "quick-chat-buttons"); ?></button>
                        <button type="button" class="kl-button trash-button remove-channel-button"><?php esc_html_e("Remove", "quick-chat-buttons"); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }//end foreach