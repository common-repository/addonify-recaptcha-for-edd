<?php
/**
 * Class - Addonify_Recaptcha_For_Edd_Public
 *
 * @link       https://addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Recaptcha_For_Edd
 * @subpackage Addonify_Recaptcha_For_Edd/public
 */
class Addonify_Recaptcha_For_Edd_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/addonify-recaptcha-for-edd-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_register_script ( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/addonify-recaptcha-for-edd-public.js', array(), $this->version, true );

		$args = array(
			'showRecaptchaInLogin' => false,
			'showRecaptchaInRegister' => false,
			'clientSecreteKey' => ''
		);

		$edd_settings = get_option( 'edd_settings' );

		if ( isset( $edd_settings['addonify_recaptcha_for_edd_show_recaptcha_in_login_form'] ) && $edd_settings['addonify_recaptcha_for_edd_show_recaptcha_in_login_form'] == '1' ) {
			$args['showRecaptchaInLogin'] = true;
		}

		if ( isset( $edd_settings['addonify_recaptcha_for_edd_show_recaptcha_in_register_form'] ) && $edd_settings['addonify_recaptcha_for_edd_show_recaptcha_in_register_form'] == '1' ) {
			$args['showRecaptchaInRegister'] = true;
		}

		if ( isset( $edd_settings['addonify_recaptcha_for_edd_client_key'] ) && $edd_settings['addonify_recaptcha_for_edd_client_key'] ) {
			$args['clientSecreteKey'] = $edd_settings['addonify_recaptcha_for_edd_client_key'];
		}

		wp_localize_script( $this->plugin_name, 'addonifyRecaptchaArgs', $args );

		wp_enqueue_script ( $this->plugin_name );
	}

	public function g_recaptcha_script() {
		
		wp_enqueue_script( $this->plugin_name . '-recaptcha', 'https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit', array(), '', true );
	}

	public function g_recaptcha_script_loader_tag( $tag, $handle, $src ) {

		if ( $this->plugin_name . '-recaptcha' === $handle ) {
        	$tag = '<script type="text/javascript" src="' . esc_url( $src ) . '" async="async" defer="defer"></script>';
	    }
	 
	    return $tag;
	}

	public function insert_recaptcha_element() {

		echo '<p id="addonify-g-recaptcha"></p>';
	}
}
