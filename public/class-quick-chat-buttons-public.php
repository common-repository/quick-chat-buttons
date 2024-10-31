<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Quick_Chat_Buttons
 * @subpackage Quick_Chat_Buttons/public
 * @author     Klaxon.app <contact@klaxon.app>
 * @license    GPL2
 * @link       https://klaxon.app
 * @since      1.0.0
 */
defined('ABSPATH') or die('Direct Access is not allowed');
class Quick_Chat_Buttons_Public
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
     * Check widget active or not.
     *
     * @var    string    $isWidgetActive    Check widget active or not.
     * @since  1.0.1
     * @access public
     */
    public $isWidgetActive = null;

    /**
     * Store settings value.
     *
     * @var    array    $settings    Store settings value.
     * @since  1.0.1
     * @access public
     */
    private $settings = [];

    /**
     * ID of post.
     *
     * @var    integer    $postId    ID of post.
     * @since  1.0.1
     * @access public
     */
    public $postId = 0;


    /**
     * Initialize the class and set its properties.
     *
     * @param string $pluginName The name of the plugin.
     * @param string $version    The version of this plugin.
     */
    public function __construct($pluginName, $version)
    {

        $this->check_for_quick_buttons();
        $this->pluginName = $pluginName;
        $this->version    = $version;

    }//end __construct()


    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function enqueue_styles()
    {
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

        wp_enqueue_style($this->pluginName, plugin_dir_url(__FILE__).'css/quick-chat-buttons-public'.$minified.'.css', [], $this->version, 'all');

    }//end enqueue_styles()


    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {
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

        wp_enqueue_script($this->pluginName, plugin_dir_url(__FILE__).'js/quick-chat-buttons-public'.$minified.'.js', [ 'jquery' ], $this->version, false);
        $settings = [
            'buttons' => $this->settings,
        ];
        wp_localize_script($this->pluginName, "quick_btn_settings", $settings);

    }//end enqueue_scripts()


    /**
     * Check for widget is active or not.
     *
     * @since  1.0.1
     * @return boolean The widget is active or not.
     */
    public function check_for_quick_buttons()
    {
        $args    = [
            'post_type'   => 'quick_chat_buttons',
            'post_status' => 'publish',
        ];
        $records = get_posts($args);

        $settings = [];
        if (!empty($records) && count($records) > 0) {
            foreach ($records as $record) {
                $channel = $this->check_for_social_channels($record->ID);
                $status = $this->get_widget_status($record->ID);
                if ($status == 1 && !empty($channel)) {
                    $otherSettings = $this->get_other_setting($record->ID);
                    $triggerSettings = $this->get_trigger_setting($record->ID);
                    $status        = 1;
                    $setting       = [
                        'channel_setting'   => $channel,
                        'customize_setting' => $otherSettings,
                        'trigger_setting'   => $triggerSettings,
                        'id'                => $record->ID,
                    ];
                    $settings[]    = $setting;
                }
            }
        }

        $this->settings       = $settings;
        $this->isWidgetActive = false;
        if (!empty($this->settings)) {
            $this->isWidgetActive = true;
        }

        return $this->isWidgetActive;

    }//end check_for_quick_buttons()


    /**
     * Get other settings.
     *
     * @param  string $postId Id of the post.
     * @return array The channel setting of widget.
     */
    public function get_other_setting($postId)
    {
        $otherSettings   = get_post_meta($postId, "widget_setting", true);
        $otherSettings   = is_array($otherSettings) && !empty($otherSettings) ? $otherSettings : [];
        $defaultSettings = Quick_Chat_Buttons::get_customize_widget_settings();
        $otherSettings   = shortcode_atts($defaultSettings, $otherSettings);

        $otherSettings['side_position'] = esc_attr($otherSettings['side_position']);
        $otherSettings['bottom_position'] = esc_attr($otherSettings['bottom_position']);
        $otherSettings['num_of_message'] = empty($otherSettings['num_of_message']) ? 1 : esc_attr($otherSettings['num_of_message']);
        $otherSettings['cta_text'] = esc_attr($otherSettings['cta_text']);

        $ctaIcon = Quick_Chat_Buttons::get_cta_icon();
        $key = $otherSettings['cta_icon'];
        $otherSettings['cta_icon'] = $ctaIcon[$key]['icon'];

        return $otherSettings;

    }//end get_other_setting()


    /**
     * Get widget status.
     *
     * @param  string $postId Id of the post.
     * @return int The status of widget.
     */
    public function get_widget_status($postId) {
        $triggerSetting = get_post_meta($postId, "trigger_setting", true);
        if(isset($triggerSetting['widget_status'])) {
            $widgetStatus = $triggerSetting['widget_status'];
        } else {
            $widgetStatus = 1;
        }
        return $widgetStatus;
    }


    /**
     * Get widget status.
     *
     * @param  string $postId Id of the post.
     * @return array The trigger setting of widget.
     */
    public function get_trigger_setting($postId) {
        $triggerSettings = get_post_meta($postId, "trigger_setting", true);
        $triggerSettings = is_array($triggerSettings) && !empty($triggerSettings) ? $triggerSettings : [];
        $defaultTriggerSettings = Quick_Chat_Buttons::get_trigger_settings();
        $triggerSettings = shortcode_atts($defaultTriggerSettings, $triggerSettings);
        if($triggerSettings['after_seconds'] == 0 || empty($triggerSettings['seconds'])) {
            $triggerSettings['seconds'] = 0;
        }

        if($triggerSettings['after_scroll'] == 0 || empty($triggerSettings['page_scroll'])) {
            $triggerSettings['page_scroll'] = 0;
        }

        return $triggerSettings;
    }


    /**
     * Check for buttons.
     *
     * @param  string $postId Id of the post.
     * @return array The channel setting of widget.
     */
    public function check_for_social_channels($postId)
    {
        $this->isWidgetActive = true;
        $channelSetting         = get_post_meta($postId, "channel_setting", true);
        $channel_settings = [];
        $channels = Quick_Chat_Buttons::get_buttons();
        if(!empty($channelSetting) && isset($channelSetting)) {
            $device = "";
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
                $device = "mobile";
            }else {
                $device = "desktop";
            }
            $preMessage = "";

            foreach ($channelSetting as $channelKey => $channel) {
                $hover_text = "";
                if (isset($channels[$channelKey]) && ($channel['has_desktop'] || $channel['has_mobile']) && !empty($channel['value'])) {
                    $setting = $channels[$channelKey];
                    $defaultChannelSetting = Quick_Chat_Buttons::get_channel_setting($setting);
                    $channels_setting = shortcode_atts($defaultChannelSetting, $channel);

                    $channels_setting['channel'] = $channelKey;
                    $channels_setting['value'] = trim(esc_attr($channels_setting['value']));
                    $channels_setting['title'] = esc_attr($channels_setting['title']);
                    $channels_setting['icon'] = $channels[$channelKey]['icon'];
                    $link = "javascript:;";
                    $target = "";
                    if ($channelKey == "whatsapp") {
                        $channels_setting['value'] = trim($channels_setting['value'], "+");
                        $channels_setting['value'] = str_replace(['-', ' ', '_'], ['', '', ''], $channels_setting['value']);
                        $target = "_blank";
                        $link = "https://web.whatsapp.com/send?phone=" . $channels_setting['value'];
                        if($device == "mobile") {
                            $link = "https://wa.me/" . $channels_setting['value'];
                        }
                    } else if ($channelKey == "facebook_messenger") {
                        $target = "_blank";
                        $link = "https://m.me/" . $channels_setting['value'];
                    } else if ($channelKey == "viber") {
                        $channels_setting['value'] = ltrim($channels_setting['value'], "+");
                        $href = "";
                        if ($device == "mobile") {
                            $href = $channels_setting['value'];
                        } else {
                            $href = "+" . $channels_setting['value'];
                        }
                        $link = "viber://chat?number=" . $href;
                    } else if ($channelKey == "mail") {
                        $link = "mailto:" . $channels_setting['value'];
                    } else if ($channelKey == "telegram") {
                        $channels_setting['value'] = ltrim($channels_setting['value'], "@");
                        $link = "https://telegram.me/" . $channels_setting['value'];
                        $target = "_blank";
                    } else if ($channelKey == "vkontakte") {
                        $link = "https://vk.me/" . $channels_setting['value'];
                        $target = "_blank";
                    } else if ($channelKey == "sms") {
                        $link = "sms:" . $channels_setting['value'];
                    } else if ($channelKey == "phone") {
                        $channels_setting['value'] = str_replace(['+', '-', ' '], ['', '', ''], $channels_setting['value']);
                        $link = "tel:" . $channels_setting['value'];
                    } else if ($channelKey == "skype") {
                        $link = "skype:" . $channels_setting['value'] . "?chat";
                    } else if($channelKey == "wechat") {
                        if($channels_setting['value'] != '') {
                            $hover_text .= ': ' . $channels_setting['value'];
                        }
                    }
                    else {
                        if (!empty($channels_setting['value'])) {
                            $strPos = strpos($channels_setting['value'], "javascript");
                            if ($strPos === false && $channels_setting['value'] != "#") {
                                $link = $channels_setting['value'];
                                $target = "_blank";
                            } else {
                                $link = $channels_setting['value'];
                            }
                        }
                    }
                    $channels_setting['link'] = $link;
                    $channels_setting['target'] = $target;
                    $desktop = ($channels_setting['has_desktop'] == "1") ? "is-desktop" : "";
                    $mobile = ($channels_setting['has_mobile'] == "1") ? "is-mobile" : "";
                    $channels_setting['desktop'] = $desktop;
                    $channels_setting['mobile'] = $mobile;
                    $channels_setting['hover_text'] = $hover_text;

                    $channel_settings[] = $channels_setting;
                }
            }
        }
        return $channel_settings;

    }//end check_for_social_channels()

}//end class
