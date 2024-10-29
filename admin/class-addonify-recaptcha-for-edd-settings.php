<?php
/**
 * Setting management class
 *
 * @package recaptcha-for-edd
 */

if ( ! class_exists( 'Addonify_reCAPTCHA_For_EDD_Settings' ) ) {

	/**
	 * Register settings for reCAPTCH via EDD settings API
	 *
	 * @since 1.0.0
	 */
	class Addonify_reCAPTCHA_For_EDD_Settings {

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			add_filter( 'edd_settings_tabs', array( $this, 'register_tab' ) );
			add_filter( 'edd_registered_settings', array( $this, 'register_settings' ) );
		}

		/**
		 * Register tab for recaptcha settings
		 *
		 * @since  1.0.0
		 * @param  array $tabs current tabs array.
		 * @return array
		 */
		public function register_tab( $tabs ) {

			$tabs['addonify-recaptcha-for-edd-settings'] = __( 'reCaptcha', 'addonify-recaptcha-for-edd' );

			return $tabs;
		}

		/**
		 * Add recaptcha-related settings
		 *
		 * @since  1.0.0
		 * @param  array $settings current settings array.
		 * @return array
		 */
		public function register_settings( $settings ) {

			$description = sprintf( __( 'If you do not have an API key pair provided by Google, then %1$ssign up for an API key pair%2$s. Copy and paste the key pair inside the fields below.', 'addonify-recaptcha-for-edd' ), '<a href="http://www.google.com/recaptcha/admin" target="_blank">', '</a>' );

			$settings['addonify-recaptcha-for-edd-settings'] = array(
				'addonify_recaptcha_for_edd_show_recaptcha_in_register_form' => array(
					'id'   => 'addonify_recaptcha_for_edd_show_recaptcha_in_register_form',
					'name' => __( 'reCAPTCHA in register form', 'recaptcha-for-edd' ),
					'desc' => __( 'Add reCAPTCHA validation into EDD registration form.', 'addonify-recaptcha-for-edd' ),
					'type' => 'checkbox',
				),
				'addonify_recaptcha_for_edd_show_recaptcha_in_login_form' => array(
					'id'   => 'addonify_recaptcha_for_edd_show_recaptcha_in_login_form',
					'name' => __( 'reCAPTCHA in login form', 'recaptcha-for-edd' ),
					'desc' => __( 'Add reCAPTCHA validation into EDD login form.', 'addonify-recaptcha-for-edd' ),
					'type' => 'checkbox',
				),
				'addonify_recaptcha_for_edd_description' => array(
					'id' => 'addonify_recaptcha_for_edd_description',
					'name' => __( 'API keys', 'addonify-recaptcha-for-edd' ),
					'desc' => $description,
					'type' => 'descriptive_text'
				),
				'addonify_recaptcha_for_edd_client_key' => array(
					'id'   => 'addonify_recaptcha_for_edd_client_key',
					'name' => __( 'Client key', 'recaptcha-for-edd' ),
					'desc' => __( 'Put your client key for reCAPTCHA here.', 'addonify-recaptcha-for-edd' ),
					'type' => 'text',
				),
				'addonify_recaptcha_for_edd_server_key' => array(
					'id'   => 'addonify_recaptcha_for_edd_server_key',
					'name' => __( 'Server key', 'recaptcha-for-edd' ),
					'desc' => __( 'Put your server key for reCAPTCHA here.', 'addonify-recaptcha-for-edd' ),
					'type' => 'text',
				),
			);

			return $settings;
		}
	}
}
new Addonify_reCAPTCHA_For_EDD_Settings();
