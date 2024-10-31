<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package    Quick_Chat_Buttons
 * @subpackage Quick_Chat_Buttons/public
 * @author     Klaxon.app <contact@klaxon.app>
 * @license    GPL2
 * @link       https://klaxon.app
 * @since      1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       Quick Chat Buttons
 * Plugin URI:        https://klaxon.app
 * Description:       Quick Chat Buttons
 * Version:           1.0.4
 * Author:            Klaxon.app
 * Author URI:        https://klaxon.app
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       quick-chat-buttons
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

/*
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */

if(!defined('QUICK_CHAT_BUTTONS_VERSION')) {
    define('QUICK_CHAT_BUTTONS_VERSION', '1.0.4');
}

if (!defined('QCB_PLUGIN_BASE')) {
    define("QCB_PLUGIN_BASE", plugin_basename(__FILE__));
}

if (!defined('QCB_PLUGIN_URL')) {
    define("QCB_PLUGIN_URL", plugin_dir_url(__FILE__));
}

define('QCB_DEV_VERSION', true);

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-quick-chat-buttons-activator.php
 */
function activate_quick_chat_buttons()
{
    include_once plugin_dir_path(__FILE__).'includes/class-quick-chat-buttons-activator.php';
    Quick_Chat_Buttons_Activator::activate();

}//end activate_quick_chat_buttons()


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-quick-chat-buttons-deactivator.php
 */
function deactivate_quick_chat_buttons()
{
    include_once plugin_dir_path(__FILE__).'includes/class-quick-chat-buttons-deactivator.php';
    Quick_Chat_Buttons_Deactivator::deactivate();

}//end deactivate_quick_chat_buttons()


register_activation_hook(__FILE__, 'activate_quick_chat_buttons');
register_deactivation_hook(__FILE__, 'deactivate_quick_chat_buttons');

/*
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */

require plugin_dir_path(__FILE__).'includes/class-quick-chat-buttons.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_quick_chat_buttons()
{

    $plugin = new Quick_Chat_Buttons();
    $plugin->run();

}//end run_quick_chat_buttons()3

// Redirect on setting page on activation.
if (!function_exists("qcb_redirect_on_activate")) {
    add_action('activated_plugin', 'qcb_redirect_on_activate');

    /**
     * Redirect to dashboard page on activate of plugin.
     *
     * @since  1.1.2
     * @param  string $plugin The name of plugin.
     * @return null
     */
    function qcb_redirect_on_activate($plugin)
    {
        if ($plugin == plugin_basename(__FILE__)) {

            $adminUrl = esc_url(admin_url('admin.php?page=quick-chat-buttons'));
            wp_redirect($adminUrl);
            exit;
        }

    }//end gsw_redirect_on_activate()
}//end if

if(!function_exists('prefix_sanitize_svg')) {
    function prefix_sanitize_svg($svg = '')
    {
        $allowed_html = [
            'svg' => [
                'xmlns' => [],
                'fill' => [],
                'viewbox' => [],
                'role' => [],
                'aria-hidden' => [],
                'focusable' => [],
                'height' => [],
                'width' => [],
            ],
            'path' => [
                'd' => [],
                'fill' => [],
            ],
        ];

        return wp_kses($svg, $allowed_html);
    }
}

run_quick_chat_buttons();
