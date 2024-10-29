<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Recaptcha_For_Edd
 * @subpackage Addonify_Recaptcha_For_Edd/includes
 */
class Addonify_Recaptcha_For_Edd_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'addonify-recaptcha-for-edd',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}
