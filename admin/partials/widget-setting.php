<?php
$icon = Quick_Chat_Buttons::get_svg_icon();
$buttons = Quick_Chat_Buttons::get_buttons();
?>

<div class="kl-container">
    <div class="kl-content">
        <form action="<?php echo admin_url("admin-ajax.php") ?>" method="post" autocomplete="off" id="qcb_form_setting">
            <div class="widget-header">
                <div class="container">
                    <div class="widget-head">
                        <div class="widget-left">
                            <a class="back-button" href="<?php echo esc_url(admin_url("admin.php?page=quick-chat-buttons")) ?>">
                                <span><?php echo $icon['prev'] ?></span>
                                <?php esc_html_e("Back to List", "quick-chat-buttons") ?>
                            </a>
                        </div>
                        <div class="widget-center">
                            <div class="form-steps">
                                <div class="steps">
                                    <div class="step step-1 active" data-id="1">
                                        <a href="#">
                                            <span class="step-count">
                                                <span class="step-num"><?php esc_html_e("1", "quick-chat-buttons") ?></span>
                                                <span class="step-svg"><?php echo $icon['check'] ?></span>
                                            </span>
                                            <span class="step-text">
                                                <?php esc_html_e("Select Channels", "quick-chat-buttons") ?>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="step step-2" data-id="2">
                                        <a href="#">
                                            <span class="step-count">
                                                <span class="step-num"><?php esc_html_e("2", "quick-chat-buttons") ?></span>
                                                <span class="step-svg"><?php echo $icon['check'] ?></span>
                                            </span>
                                            <span class="step-text">
                                                <?php esc_html_e("Customize Button", "quick-chat-buttons") ?>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="step step-3" data-id="3">
                                        <a href="#">
                                            <span class="step-count">
                                                <span class="step-num"><?php esc_html_e("3", "quick-chat-buttons") ?></span>
                                                <span class="step-svg"><?php echo $icon['check'] ?></span>
                                            </span>
                                            <span class="step-text">
                                                <?php esc_html_e("Trigger Setting", "quick-chat-buttons") ?>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-right">
                            <div class="next-prev-btn">
                                <button type="button" class="button button-secondary" id="prev-button">
                                    <?php echo $icon['prev'] ?>
                                </button>
                                <button type="button" class="button button-secondary" id="next-button">
                                    <?php echo $icon['next'] ?>
                                </button>
                            </div>
                            <div class="flex-button">
                                <button type="submit" class="button button-primary save-button save-changes">
                                    <span class="kl-loader"><?php echo $icon['loader'] ?></span><?php esc_html_e("Save Changes", "quick-chat-buttons") ?></button>
                                <input type="hidden" name="button_setting_id" id="button_setting_id" value="<?php echo esc_attr($postId); ?>">
                                <input type="hidden" name="action" value="save_qc_buttons_setting">
                                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce("save_qc_buttons_setting_".$postId) ?>">
                                <button type="button" class="button button-secondary preview-btn">
                                    <?php echo $icon['preview'] ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="widget-content">
                    <div class="widget-content-left">
                        <div class="setting-steps">
                            <div class="setting-step active" id="step-1">
                                <div class="step-title">
                                    <?php esc_html_e("Step 1: Select Channels", "quick-chat-buttons") ?>
                                </div>
                                <div class="channel-list">
                                    <?php require_once dirname(__FILE__)."/channels.php"; ?>
                                </div>
                                <div class="selected-channels">
                                    <?php
                                    $channel_meta = get_post_meta($postId, "channel_setting", true);
                                    if (empty($channel_meta)) {
                                        $channel_meta = array(
                                            'whatsapp' => [],
                                            'facebook_messenger' => []
                                        );
                                    }
                                    ?>
                                    <ul>
                                        <?php
                                        foreach($channel_meta as $channel => $value) {
                                            echo Quick_Chat_Buttons_Admin::get_channel_settings($channel, $postId); ?>
                                        <?php } ?>
                                    </ul>
                                    <div class="ajax-loader">
                                        <div class="ball-beat-loader">
                                            <div class="loader-inner ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="no-channels <?php echo empty($channel_meta) ? "active" : "" ?>">
                                    <img src="<?php echo esc_url(QCB_PLUGIN_URL. 'admin/images/no-channels.png') ?>" alt="no channels" />
                                    <div class="empty-message"><?php esc_html_e("Please select at least one channel", "quick-chat-buttons") ?></div>
                                </div>
                            </div>
                            <div class="setting-step" id="step-2">
                                <div class="step-title">
                                    <?php esc_html_e("Step 2: Customize CTA Button", "quick-chat-buttons") ?>
                                </div>
                                <div class="customize-settings">
                                    <?php require_once dirname(__FILE__)."/customize-settings.php"; ?>
                                </div>
                            </div>
                            <div class="setting-step" id="step-3">
                                <div class="step-title">
                                    <?php esc_html_e("Step 3: Trigger Setting", "quick-chat-buttons") ?>
                                </div>
                                <div class="customize-settings">
                                    <?php require_once dirname(__FILE__)."/trigger-settings.php"; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-preview-box">
                            <div class="widget-preview">
                                <div class="preview-content">
                                    <div class="preview-area"></div>
                                    <div class="preview-bottom"></div>
                                </div>
                                <div class="preview-buttons">
                                    <div class="radio-buttons">
                                        <div class="radio-button preview-device">
                                            <input type="radio" id="desktop_device" class="sr-only preview_device preview-desktop-btn" name="preview_device" value="desktop" checked>
                                            <label for="desktop_device"><?php esc_html_e("Desktop", "quick-chat-buttons") ?></label>
                                        </div>
                                        <div class="radio-button preview-device">
                                            <input type="radio" id="mobile_device" class="sr-only preview_device preview-mobile-btn" name="preview_device" value="mobile">
                                            <label for="mobile_device"><?php esc_html_e("Mobile", "quick-chat-buttons") ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="klaxon-modal preview-modal">
    <div class="klaxon-modal-bg"></div>
    <div class="klaxon-modal-container small">
        <div class="klaxon-modal-content">
            <button type="button" class="remove-klaxon-modal">
                <span class="svg-icon">
                    <?php echo $icon['close'] ?>
                </span>
            </button>
            <div class="modal-title"><?php esc_html_e("Preview", "quick-chat-buttons") ?></div>
            <div class="modal-content">
                <div class="widget-preview">
                    <div class="preview-content">
                        <div class="preview-area"></div>
                        <div class="preview-bottom"></div>
                    </div>
                    <div class="preview-buttons">
                        <div class="radio-buttons">
                            <div class="radio-button preview-device">
                                <input type="radio" id="preview_desktop_device" class="sr-only preview_device preview-desktop-btn" name="preview_device_popup" value="desktop" checked>
                                <label for="preview_desktop_device"><?php esc_html_e("Desktop", "quick-chat-buttons") ?></label>
                            </div>
                            <div class="radio-button preview-device">
                                <input type="radio" id="preview_mobile_device" class="sr-only preview_device preview-mobile-btn" name="preview_device_popup" value="mobile">
                                <label for="preview_mobile_device"><?php esc_html_e("Mobile", "quick-chat-buttons") ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="secondary cancel-button"><?php esc_html_e("Cancel", "quick-chat-buttons") ?></button>
            </div>
        </div>
    </div>
</div>

<div class="klaxon-modal upgrade-plan-modal">
    <div class="klaxon-modal-bg"></div>
    <div class="klaxon-modal-container small">
        <div class="klaxon-modal-content">
            <button type="button" class="remove-klaxon-modal">
            <span class="svg-icon">
                <?php echo $icon['close'] ?>
            </span>
            </button>
            <div class="modal-content text-center">
                <div class="upgrade-modal-title">
                    <?php esc_html_e("Upgrade to Pro 🎉", "quick-chat-buttons") ?>
                </div>
                <div class="upgrade-sub-modal-title upgrade-plan-modal-title">
                    <?php esc_html_e("Create multiple widget is Pro feature", "quick-chat-buttons") ?>
                </div>
                <div class="pro-feature-list">
                    <span class=""><?php esc_html_e("What you will get in Pro Plan?", "quick-chat-buttons") ?></span>
                    <ul>
                        <li>&#9854;&#65039; <?php esc_html_e("Create Unlimited Widgets", "quick-chat-buttons") ?></li>
                        <li>&#128306; <?php esc_html_e("Clone Widget", "quick-chat-buttons") ?></li>
                        <li>&#127919; <?php esc_html_e("Page Targeting", "quick-chat-buttons") ?></li>
                        <li>&#128197; <?php esc_html_e("Date and Time Schedule", "quick-chat-buttons") ?></li>
                        <li>&#9201;&#65039; <?php esc_html_e("Day and Time Schedule", "quick-chat-buttons") ?></li>
                    </ul>
                </div>
                <div class="upgrade-modal-button">
                    <a href="<?php echo esc_url(admin_url("admin.php?page=quick-chat-buttons-go-pro")) ?>" target="_blank"><?php esc_html_e("Upgrade to Pro", "quick-chat-buttons") ?></a>
                </div>
                <div class="upgrade-modal-footer">
                    <span>&#10148; <?php esc_html_e("Starts from less than $1.6/mo", "quick-chat-buttons") ?></span>
                    <span>&#10148; <?php esc_html_e("14 days refund, no questions will be asked", "quick-chat-buttons") ?></span>
                </div>
            </div>
        </div>
    </div>
</div>