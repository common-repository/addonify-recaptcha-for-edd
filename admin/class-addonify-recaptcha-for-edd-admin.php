<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Recaptcha_For_Edd
 * @subpackage Addonify_Recaptcha_For_Edd/admin
 */
class Addonify_Recaptcha_For_Edd_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/addonify-recaptcha-for-edd-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/addonify-recaptcha-for-edd-admin.js', array( 'jquery' ), $this->version, false );
	}

	public function process_login() {

		if ( ! isset( $_POST['edd_action'] ) || 'user_login' !== $_POST['edd_action'] ) {

			return;
		}

		$is_captcha_valid = $this->recaptcha_process();

		if ( ! $is_captcha_valid ) {

			$_POST['edd_login_nonce'] = false;
		}
	}

	public function recaptcha_process() {

		if ( empty( $_POST['g-recaptcha-response'] ) ) {

			edd_set_error(
				'empty_captcha',
				__( 'Please, pass reCAPTCHA validation', 'addonify-recaptcha-for-edd' )
			);

			return false;
		}

		$result = $this->validate_recaptcha();

		if ( false === $result ) {

			edd_set_error(
				'fail_captcha',
				__( 'reCAPTCHA validation failed, please try again', 'addonify-recaptcha-for-edd' )
			);
			
			return false;
		}

		return true;
	}


	private function validate_recaptcha() {

		$edd_settings = get_option( 'edd_settings' );

		$server_secret_key = $edd_settings['addonify_recaptcha_for_edd_server_key'];

		if ( ! $server_secret_key ) {

			return false;
		} 

		$request_args = array(
			'response' => $_POST['g-recaptcha-response'],
			'secret' => $server_secret_key
		);

		$request = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', array( 'body' => $request_args ) );

		$result = json_decode( $request['body'], true );

		if ( empty( $result ) || ! $result['success'] ) {

			return false;
		}

		return true;
	}

}
