<?php
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @package    Quick_Chat_Buttons
 * @subpackage Quick_Chat_Buttons/includes
 * @author     Klaxon.app <contact@klaxon.app>
 * @license    GPL2
 * @link       https://klaxon.app
 * @since      1.0.0
 */
defined('ABSPATH') or die('Direct Access is not allowed');
class Quick_Chat_Buttons_I18n
{


    /**
     * Load the plugin text domain for translation.
     *
     * @since 1.0.0
     */
    public function load_plugin_textdomain()
    {

        load_plugin_textdomain(
            'quick-chat-buttons',
            false,
            dirname(dirname(plugin_basename(__FILE__))).'/languages/'
        );

    }//end load_plugin_textdomain()


}//end class
