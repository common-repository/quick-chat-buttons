<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Quick_Chat_Buttons
 * @subpackage Quick_Chat_Buttons/admin
 * @author     Klaxon.app <contact@klaxon.app>
 * @license    GPL2
 * @link       https://klaxon.app
 * @since      1.0.0
 */
defined('ABSPATH') or die('Direct Access is not allowed');
class Quick_Chat_Buttons_Admin
{

    /**
     * The ID of this plugin.
     *
     * @var    string    $pluginName    The ID of this plugin.
     * @since  1.0.0
     * @access private
     */
    private $pluginName;

    /**
     * The version of this plugin.
     *
     * @var    string    $version    The current version of this plugin.
     * @since  1.0.0
     * @access private
     */
    private $version;


    /**
     * Initialize the class and set its properties.
     *
     * @param string $pluginName The name of this plugin.
     * @param string $version    The version of this plugin.
     */
    public function __construct($pluginName, $version)
    {

        $this->pluginName = $pluginName;
        $this->version    = $version;

    }//end __construct()


    /**
     * Setting and upgrade link.
     *
     * @param array $links Setting links
     *
     * @return links
     */
    public function setting_and_upgrade_link($links)
    {
        $settings = '<a href="'.admin_url("admin.php?page=quick-chat-buttons").'" >'.esc_html__('Settings', 'quick-chat-buttons').'</a>';
        $settings .= '<a href="'.admin_url("admin.php?page=quick-chat-buttons-go-pro").'" >'.esc_html__(' | Upgrade to Pro', 'quick-chat-buttons').'</a>';
        array_unshift($links, $settings);
        return $links;

    }//end setting_and_upgrade_link()


    /**
     * Register the stylesheets for the admin area.
     *
     * @param  string $page The name of this page.
     * @return null
     */
    public function enqueue_styles($page="")
    {
        $pages = [
            'toplevel_page_quick-chat-buttons',
            'quick-chat-buttons_page_quick-chat-buttons-go-pro',
            'quick-chat-buttons_page_quick-chat-buttons-new-widget',
        ];
        if (!in_array($page, $pages)) {
            return;
        }

        /*
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Quick_Chat_Buttons_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Quick_Chat_Buttons_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        $minified = ".min";
        if (QCB_DEV_VERSION) {
            $minified = "";
        }

        if ($page == "toplevel_page_quick-chat-buttons") {
            wp_enqueue_style($this->pluginName . "-preview", plugin_dir_url(__FILE__) . 'css/preview' . $minified . '.css', [], $this->version, 'all');
            wp_enqueue_style($this->pluginName . "-color", plugin_dir_url(__FILE__) . 'css/jquery.minicolors.css', [], $this->version, 'all');
            wp_enqueue_style($this->pluginName . "-select2", plugin_dir_url(__FILE__) . 'css/select2.min.css', [], $this->version, 'all');
            wp_enqueue_style($this->pluginName, plugin_dir_url(__FILE__) . 'css/styles' . $minified . '.css', [], $this->version, 'all');

            $buttons = Quick_Chat_Buttons::get_buttons();
            $css = "";
            foreach ($buttons as $key => $button) {
                $css .= "a.channel-button." . $key . "-button {background-image: linear-gradient(" . $button['bg_color'] . ", " . $button['bg_color'] . ")}";
                $css .= "a.channel-button." . $key . "-button.active {background-color: " . $button['bg_color'] . "}";
                $css .= "a.channel-button." . $key . "-button:hover {background-image: linear-gradient(" . $button['bg_color'] . ", " . $button['bg_color'] . ")}";
            }

            wp_add_inline_style($this->pluginName, $css);
        } else if($page == "quick-chat-buttons_page_quick-chat-buttons-new-widget") {
            wp_enqueue_style($this->pluginName . "-new-widget", plugin_dir_url(__FILE__) . 'css/new-widget' . $minified . '.css', [], $this->version, 'all');
            wp_enqueue_style($this->pluginName . "-styles", plugin_dir_url(__FILE__) . 'css/styles' . $minified . '.css', [], $this->version, 'all');
            wp_enqueue_style($this->pluginName . "-slick-css", plugin_dir_url(__FILE__) . 'css/slick.min.css', [], $this->version, 'all');
        }

        if ($page == "quick-chat-buttons_page_quick-chat-buttons-go-pro") {
            wp_enqueue_style($this->pluginName . "-pricing-css", plugin_dir_url(__FILE__) . 'css/pricing-table' . $minified . '.css', [], $this->version, 'all');
        }



    }//end enqueue_styles()


    /**
     * Register the JavaScript for the admin area.
     *
     * @param string $page The name of this page.
     */
    public function enqueue_scripts($page="")
    {
        $pages = [
            'toplevel_page_quick-chat-buttons',
            'quick-chat-buttons_page_quick-chat-buttons-go-pro',
            'quick-chat-buttons_page_quick-chat-buttons-new-widget',
        ];
        if(!in_array($page, $pages)) {
            return ;
        }

        /*
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Quick_Chat_Buttons_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Quick_Chat_Buttons_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        $minified = ".min";
        if(QCB_DEV_VERSION) {
            $minified = "";
        }

        wp_enqueue_script($this->pluginName, plugin_dir_url(__FILE__).'js/script'.$minified.'.js', [ 'jquery', 'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery-ui-sortable' ], $this->version, false);
        wp_enqueue_script($this->pluginName."ajax-submit", plugin_dir_url(__FILE__).'js/jquery.ajaxsubmit.js', [ 'jquery' ], $this->version, false);
        wp_enqueue_script($this->pluginName."color-picker", plugin_dir_url(__FILE__).'/js/jquery.minicolors.js');
        wp_enqueue_script($this->pluginName."select2-js", plugin_dir_url(__FILE__).'/js/select2.min.js');
        wp_enqueue_script($this->pluginName."slick-js", plugin_dir_url(__FILE__).'/js/slick.min.js');
        wp_localize_script($this->pluginName, "QUICK_CHAT_BUTTONS_SETTING", [
            'AJAX_URL' => admin_url("admin-ajax.php"),
            'required_message'  => esc_html__("%s is required", "quick-chat-buttons"),
        ]);

    }//end enqueue_scripts()


    /**
     * Creates Admin Menu
     *
     * @param string $page The name of this page.
     */
    public function admin_menu($page="")
    {

        add_menu_page(
            esc_html__('Quick Chat Buttons', 'quick-chat-buttons'),
            esc_html__('Quick Chat Buttons', 'quick-chat-buttons'),
            'manage_options',
            'quick-chat-buttons',
            [
                $this,
                'admin_dashboard',
            ],
            'data:image/svg+xml;base64,' . base64_encode('<svg viewBox="0 0 511.63 511.63" xml:space="preserve" fill="#ffffff" xmlns="http://www.w3.org/2000/svg"><path d="m301.93 327.6c30.926-13.038 55.34-30.785 73.23-53.248 17.888-22.458 26.833-46.915 26.833-73.372 0-26.458-8.945-50.917-26.84-73.376-17.888-22.459-42.298-40.208-73.228-53.249-30.93-13.039-64.571-19.556-100.93-19.556-36.354 0-69.995 6.521-100.93 19.556-30.929 13.04-55.34 30.789-73.229 53.249-17.891 22.463-26.838 46.918-26.838 73.377 0 22.648 6.767 43.975 20.28 63.96 13.512 19.981 32.071 36.829 55.671 50.531-1.902 4.572-3.853 8.754-5.852 12.566-2 3.806-4.377 7.467-7.139 10.991-2.76 3.525-4.899 6.283-6.423 8.275-1.523 1.998-3.997 4.812-7.425 8.422-3.427 3.617-5.617 5.996-6.567 7.135 0-0.191-0.381 0.24-1.143 1.287-0.763 1.047-1.191 1.52-1.285 1.431-0.096-0.103-0.477 0.373-1.143 1.42-0.666 1.048-1 1.571-1 1.571l-0.715 1.423c-0.282 0.575-0.476 1.137-0.57 1.712-0.096 0.567-0.144 1.19-0.144 1.854s0.094 1.28 0.288 1.854c0.381 2.471 1.475 4.466 3.283 5.996 1.807 1.52 3.756 2.279 5.852 2.279h0.857c9.515-1.332 17.701-2.854 24.552-4.569 29.312-7.61 55.771-19.797 79.372-36.545 17.129 3.046 33.879 4.568 50.247 4.568 36.357 0.013 70.002-6.502 100.93-19.542z"></path><path d="m491.35 338.17c13.518-19.889 20.272-41.247 20.272-64.09 0-23.414-7.146-45.316-21.416-65.68-14.277-20.362-33.694-37.305-58.245-50.819 4.374 14.274 6.563 28.739 6.563 43.398 0 25.503-6.368 49.676-19.129 72.519-12.752 22.836-31.025 43.01-54.816 60.524-22.08 15.988-47.205 28.261-75.377 36.829-28.164 8.562-57.573 12.848-88.218 12.848-5.708 0-14.084-0.377-25.122-1.137 38.256 25.119 83.177 37.685 134.76 37.685 16.371 0 33.119-1.526 50.251-4.571 23.6 16.755 50.06 28.931 79.37 36.549 6.852 1.718 15.037 3.237 24.554 4.568 2.283 0.191 4.381-0.476 6.283-1.999 1.903-1.522 3.142-3.61 3.71-6.272-0.089-1.143 0-1.77 0.287-1.861 0.281-0.09 0.233-0.712-0.144-1.852-0.376-1.144-0.568-1.715-0.568-1.715l-0.712-1.424c-0.198-0.376-0.52-0.903-0.999-1.567-0.476-0.66-0.855-1.143-1.143-1.427-0.28-0.284-0.705-0.763-1.28-1.424-0.568-0.66-0.951-1.092-1.143-1.283-0.951-1.143-3.139-3.521-6.564-7.139-3.429-3.613-5.899-6.42-7.422-8.418-1.523-1.999-3.665-4.757-6.424-8.282-2.758-3.518-5.14-7.183-7.139-10.991-1.998-3.806-3.949-7.995-5.852-12.56 23.602-13.716 42.156-30.513 55.667-50.409z"></path></svg>')
        );

        add_submenu_page(
            'quick-chat-buttons',
            esc_attr__('Dashboard', 'quick-chat-buttons'),
            esc_attr__('Dashboard', 'quick-chat-buttons'),
            'manage_options',
            'quick-chat-buttons',
            [
                $this,
                'admin_dashboard',
            ]
        );

        /*if ($this->isSettingExists()) {
            add_submenu_page(
                'quick-chat-buttons',
                esc_attr__('New Widget', 'quick-chat-buttons'),
                esc_attr__('New Widget', 'quick-chat-buttons'),
                'manage_options',
                'quick-chat-buttons-new-widget',
                [
                    $this,
                    'admin_new_widget',
                ]
            );
        }*/

        add_submenu_page(
            'quick-chat-buttons',
            esc_attr__('Upgrade to Pro', 'quick-chat-buttons'),
            esc_attr__('Upgrade to Pro', 'quick-chat-buttons'),
            'manage_options',
            'quick-chat-buttons-go-pro',
            [
                $this,
                'go_pro',
            ]
        );

    }//end admin_menu()


    /**
     * Creates Admin Menu
     *
     * @param string $page The name of this page.
     */
    public function admin_dashboard($page="")
    {
        $isSettingExists = "";
        $postId = 0;
        $task  = sanitize_text_field(filter_input(INPUT_GET, 'task'));
        $edit  = sanitize_text_field(filter_input(INPUT_GET, 'edit'));
        $nonce = sanitize_text_field(filter_input(INPUT_GET, 'nonce'));

        if (isset($task) && $task == "edit-widget" && isset($edit) && isset($nonce)) {
            $postId = !empty($edit) ? $edit : 0;
            $nonce = !empty($nonce) ? $nonce : "";
            if (wp_verify_nonce($nonce, "edit_widget_" . $postId)) {
                include_once dirname(__FILE__) . "/partials/widget-setting.php";
            }
        } else {
            $posts = get_posts(
                [
                    "post_type"    => "quick_chat_buttons",
                    "num_of_posts" => 1,
                ]
            );
            if ($this->isSettingExists()) {
                $isSettingExists = 1;
            }

            include_once dirname(__FILE__)."/partials/widget-list.php";
        }//end if

    }//end admin_dashboard()


    /**
     * Creates go pro page
     */
    public function go_pro() {
        include_once dirname(__FILE__)."/partials/go-pro.php";
    }


    function admin_new_widget()
    {
        $icons = Quick_Chat_Buttons::get_svg_icon();
        if ($this->isSettingExists()) {
            include_once dirname(__FILE__)."/partials/widget-new.php";
        }
    }


    /**
     * Get ID of widget if widget is exists.
     *
     * @return integer The ID of widget.
     */
    public function isSettingExists()
    {

        $posts  = get_posts(
            [
                "post_type"    => "quick_chat_buttons",
                "num_of_posts" => 1,
            ]
        );
        $postID = false;
        if (!empty($posts)) {
            $postID = isset($posts[0]->ID) ? $posts[0]->ID : false;
        }

        return $postID;

    }//end isSettingExists()


    /**
     * Creates Admin Menu
     */
    public function get_qcb_settings() {
        $response = [
            'status' => 0,
            'message' => 'Invalid request, Please try again later'
        ];
        $status = 0;

        $channel = sanitize_text_field(filter_input(INPUT_POST, 'channel'));
        $postId = sanitize_text_field(filter_input(INPUT_POST, 'post_id'));

        $message = self::get_channel_settings($channel, $postId);

        if (!empty($message)) {
            $status = 1;
        }

        $response = [
            'status'  => $status,
            'message' => $message,
            'channel' => $channel
        ];
        echo json_encode($response);
        exit;
    }


    public static function get_channel_settings($channel, $postId) {

        $icon = Quick_Chat_Buttons::get_svg_icon();
        $buttons = Quick_Chat_Buttons::get_buttons();
        $message = "";
        $channelSettings = get_post_meta($postId, "channel_setting", true);
        foreach ($buttons as $key => $value) {
            if($key == $channel) {
                ob_start();
                $defaultChannelSetting = Quick_Chat_Buttons::get_channel_setting($value);
                $channelSettings = isset($channelSettings[$key]) && !empty($channelSettings[$key]) ? $channelSettings[$key] : [];
                $channelSetting = shortcode_atts($defaultChannelSetting, $channelSettings);
                ?>
                <li id="channel-<?php echo esc_attr($channel) ?>" class="<?php echo esc_attr($channel) ?>-channel channel-lists" data-channel="<?php echo esc_attr($channel) ?>">
                    <a class="setting-top" href="#">
                        <span class="setting-top-left"><?php echo esc_attr($value['title']) ?><?php esc_html_e(" Setting","quick-chat-buttons"); ?></span>
                        <span class="setting-top-right channel-toggle-arrow">
                            <?php echo $icon['chevron_down'] ?>
                        </span>
                    </a>
                    <div class="setting-bottom">
                        <div class="form-field in-flex">
                            <label class="form-label" for="<?php echo esc_attr($channel) ?>_value">
                                <?php echo esc_attr($value['label']) ?>
                            </label>
                            <div class="form-input d-grid">
                                <input type="text" id="<?php echo esc_attr($channel) ?>_value" class="input-field channel-value is-required" placeholder="<?php echo esc_attr($value['example']) ?>" name="channel_setting[<?php echo esc_attr($channel) ?>][value]" value="<?php echo esc_attr($channelSetting['value']) ?>" data-name="<?php echo esc_attr($value['label']) ?>">
                            </div>
                        </div>
                        <div class="form-field in-flex">
                            <label class="form-label" for="<?php echo esc_attr($channel) ?>_title">
                                <?php esc_html_e("Title","quick-chat-buttons"); ?>
                            </label>
                            <div class="form-input">
                                <input type="text" id="<?php echo esc_attr($channel) ?>_title" class="input-field channel-title" name="channel_setting[<?php echo esc_attr($channel) ?>][title]" value="<?php echo esc_attr($channelSetting['title']) ?>">
                            </div>
                        </div>
                        <div class="form-field in-flex">
                            <label class="form-label">
                                <?php esc_html_e("Devices","quick-chat-buttons"); ?>
                            </label>
                            <div class="form-input">
                                <ul class="device-list">
                                    <li>
                                        <div class="device-checkbox">
                                            <input type="hidden" name="channel_setting[<?php echo esc_attr($channel) ?>][has_desktop]" value="0">
                                            <input class="sr-only channel-for-desktop" type="checkbox" value="1" id="desktop_<?php echo esc_attr($channel) ?>"
                                                   name="channel_setting[<?php echo esc_attr($channel) ?>][has_desktop]" <?php echo checked($channelSetting['has_desktop'], 1) ?>>
                                            <label for="desktop_<?php echo esc_attr($channel) ?>">
                                                <?php esc_html_e("Desktop","quick-chat-buttons"); ?>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="device-checkbox">
                                            <input type="hidden" name="channel_setting[<?php echo esc_attr($channel) ?>][has_mobile]" value="0">
                                            <input class="sr-only channel-for-mobile" type="checkbox" value="1" id="mobile_<?php echo esc_attr($channel) ?>"
                                                   name="channel_setting[<?php echo esc_attr($channel) ?>][has_mobile]" <?php echo checked($channelSetting['has_mobile'], 1) ?>>
                                            <label for="mobile_<?php echo esc_attr($channel) ?>">
                                                <?php esc_html_e("Mobile","quick-chat-buttons"); ?>
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-field in-flex">
                            <label class="form-label">
                                <?php esc_html_e("Background Color","quick-chat-buttons"); ?>
                            </label>
                            <div class="form-input">
                                <input type="text" name="channel_setting[<?php echo esc_attr($channel) ?>][bg_color]" class="color-picker channel-bg-color" value="<?php echo esc_attr($channelSetting['bg_color']) ?>">
                            </div>
                        </div>
                        <div class="form-field in-flex">
                            <label class="form-label">
                                <?php esc_html_e("Icon Color","quick-chat-buttons"); ?>
                            </label>
                            <div class="form-input">
                                <input type="text" name="channel_setting[<?php echo esc_attr($channel) ?>][icon_color]" class="color-picker channel-icon-color" value="<?php echo esc_attr($channelSetting['icon_color']) ?>">
                            </div>
                        </div>
                        <div class="form-field in-flex">
                            <label class="">
                                <a href="javascript:;" id="" class="remove-rule-button remove-channel-icon"><?php esc_html_e("Remove", "quick-chat-buttons") ?></a>
                            </label>
                        </div>
                    </div>
                </li>
                <?php
                $message = ob_get_clean();
            }
        }
        return $message;
    }


    /**
     * Save sticky buttons settings in database.
     */
    public function save_qc_buttons_setting()
    {
        $nonce = filter_input(INPUT_POST, 'nonce');
        if (isset($nonce)) {
            $nonce = sanitize_text_field($nonce);
        }

        $postId = filter_input(INPUT_POST, 'button_setting_id');
        if (isset($postId)) {
            $postId = sanitize_text_field($postId);
        }

        $response = [
            'status'  => 0,
            'message' => esc_html__("Invalid Request, Please try again", "quick-chat-buttons"),
            'data'    => ["URL" => ""],
        ];
        if (!empty($nonce) && wp_verify_nonce($nonce, "save_qc_buttons_setting_".$postId)) {
            $buttonSetting = filter_input(INPUT_POST, 'button_setting', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $buttonSetting = isset($buttonSetting) ? (array) $buttonSetting : [];

            $channelSetting = filter_input(INPUT_POST, 'channel_setting', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $channelSetting = isset($channelSetting) ? (array) $channelSetting : [];

            $widgetSetting = filter_input(INPUT_POST, 'widget_setting', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $widgetSetting = isset($widgetSetting) ? (array) $widgetSetting : [];

            $triggerSetting = filter_input(INPUT_POST, "trigger_setting", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $triggerSetting = isset($triggerSetting) ? (array) $triggerSetting : [];

            if (!empty($postId)) {
                $arg    = [
                    'ID' => $postId,
                    'post_type'   => 'quick_chat_buttons',
                    'post_status' => 'publish',
                ];
                wp_update_post($arg);
            }

            if (!empty($postId)) {
                update_post_meta($postId, "button_setting", $buttonSetting);
                update_post_meta($postId, "channel_setting", $channelSetting);
                update_post_meta($postId, "widget_setting", $widgetSetting);
                update_post_meta($postId, "trigger_setting", $triggerSetting);

                setcookie("qcb-".$postId,  -1, time(), "/");
                setcookie("qcb-view-".$postId, -1, time(), "/");

                $response['status']      = 1;
                $response['message']     = esc_html__("Widget updated successfully", "quick-chat-buttons");
                $response['data']['URL'] = admin_url("admin.php?page=quick-chat-buttons");
            }
        }//end if

        echo json_encode($response);
        exit;

    }//end save_qc_buttons_setting()


    /**
     * save sticky button title in database.
     */
    public function save_qcb_widget_title() {
        $response = [
            'status' => 0,
            'message' => esc_html__('Invalid request, Please try again', "quick-chat-buttons"),
            'data' => [
                'URL' => ''
            ]
        ];

        $widgetTitle = sanitize_text_field(filter_input(INPUT_POST, 'widget_title'));
        $nonce = sanitize_text_field(filter_input(INPUT_POST, 'nonce'));

        if (!empty($nonce) && wp_verify_nonce($nonce, "save_qcb_widget_title")) {
            $arg = [
                'post_title' => $widgetTitle,
                'post_type' => 'quick_chat_buttons',
                'post_status' => 'publish'
            ];
            $postId = wp_insert_post($arg);

            $response['status'] = 1;
            $response['message'] = "Widget is created successfully";
            $response['data']['URL'] = admin_url('admin.php?page=quick-chat-buttons&task=edit-widget&edit=' . $postId . '&nonce=' . wp_create_nonce('edit_widget_' . $postId));
        }

        echo json_encode($response);
        exit;
    }


    /**
     * change widget status in database.
     */
    public function qcb_change_widget_status() {
        $nonce = sanitize_text_field(filter_input(INPUT_POST, 'nonce'));
        $postId = sanitize_text_field(filter_input(INPUT_POST, 'setting_id'));
        $status = sanitize_text_field(filter_input(INPUT_POST, 'status'));

        $response = [
            'status'  => 0,
            'message' => '',
            'data'    => [],
        ];
        if (!empty($nonce) && wp_verify_nonce($nonce, "qcb_widget_col_".$postId)) {
            $triggerSetting = get_post_meta($postId, "trigger_setting", true);
            $triggerSetting['widget_status'] = $status;
            update_post_meta($postId, "trigger_setting", $triggerSetting);
            $response['status'] = 1;
        }

        echo json_encode($response);
        exit;
    }


    /**
     * Remove sticky buttons settings from database.
     */
    public function remove_qcb_widget() {
        $nonce = sanitize_text_field(filter_input(INPUT_POST, 'nonce'));
        $postId = sanitize_text_field(filter_input(INPUT_POST, 'setting_id'));

        $response = [
            'status'  => 0,
            'message' => esc_html__("Widget is removed successfully", "quick-chat-buttons"),
            'data'    => [],
        ];
        if (!empty($nonce) && wp_verify_nonce($nonce, "qcb_widget_col_".$postId)) {
            $postId = esc_sql($postId);
            wp_delete_post($postId);
            delete_post_meta($postId, "button_setting");
            delete_post_meta($postId, "channel_setting");
            delete_post_meta($postId, "widget_setting");
            delete_post_meta($postId, "trigger_setting");
            $response['status'] = 1;
        }

        echo json_encode($response);
        exit;
    }

    public function in_admin_header()
    {
        if(isset($_GET['page']) && ($_GET['page'] == "quick-chat-buttons" || $_GET['page'] == "quick-chat-buttons-go-pro" || $_GET['page'] == "quick-chat-buttons-new-widget")) {
            remove_all_actions('admin_notices');
            remove_all_actions('all_admin_notices');
        }
    }


}//end class
