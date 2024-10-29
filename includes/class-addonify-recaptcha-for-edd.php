<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Addonify_Recaptcha_For_Edd
 * @subpackage Addonify_Recaptcha_For_Edd/includes
 * @author     Addonify <addonify@gmail.com>
 */
class Addonify_Recaptcha_For_Edd {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Addonify_Recaptcha_For_Edd_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ADDONIFY_RECAPTCHA_FOR_EDD_VERSION' ) ) {
			$this->version = ADDONIFY_RECAPTCHA_FOR_EDD_VERSION;
		} else {
			$this->version = '1.0.3';
		}
		$this->plugin_name = 'addonify-recaptcha-for-edd';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		if ( ! in_array( 'easy-digital-downloads/easy-digital-downloads.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

			add_action( 'admin_notices', [ $this, 'admin_notice' ] );
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Addonify_Recaptcha_For_Edd_Loader. Orchestrates the hooks of the plugin.
	 * - Addonify_Recaptcha_For_Edd_i18n. Defines internationalization functionality.
	 * - Addonify_Recaptcha_For_Edd_Admin. Defines all hooks for the admin area.
	 * - Addonify_Recaptcha_For_Edd_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-addonify-recaptcha-for-edd-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-addonify-recaptcha-for-edd-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-addonify-recaptcha-for-edd-admin.php';

		/**
		 * The class responsible for defining edd settings required for reCAPTCHA.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-addonify-recaptcha-for-edd-settings.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-addonify-recaptcha-for-edd-public.php';

		$this->loader = new Addonify_Recaptcha_For_Edd_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Addonify_Recaptcha_For_Edd_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Addonify_Recaptcha_For_Edd_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Addonify_Recaptcha_For_Edd_Admin( $this->get_plugin_name(), $this->get_version() );

		$edd_settings = get_option( 'edd_settings' );
		
		if ( isset( $edd_settings['addonify_recaptcha_for_edd_show_recaptcha_in_register_form'] ) && $edd_settings['addonify_recaptcha_for_edd_show_recaptcha_in_register_form'] == '1' ) {
			$this->loader->add_action( 'edd_process_register_form', $plugin_admin, 'recaptcha_process' );
		}

		if ( isset( $edd_settings['addonify_recaptcha_for_edd_show_recaptcha_in_login_form'] ) && $edd_settings['addonify_recaptcha_for_edd_show_recaptcha_in_login_form'] == '1' ) {
			$this->loader->add_filter( 'init', $plugin_admin, 'process_login' );
		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$edd_settings = get_option( 'edd_settings' );

		$plugin_public = new Addonify_Recaptcha_For_Edd_Public( $this->get_plugin_name(), $this->get_version() );

		if ( isset( $edd_settings['addonify_recaptcha_for_edd_show_recaptcha_in_register_form'] ) && $edd_settings['addonify_recaptcha_for_edd_show_recaptcha_in_register_form'] == '1' ) {
			$this->loader->add_action( 'edd_register_form_fields_before_submit', $plugin_public, 'insert_recaptcha_element' );
		}

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts', 10 );

		// $this->loader->add_action( 'wp_footer', $plugin_public, 'g_recaptcha_render_script', 10 );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'g_recaptcha_script', 20 );

		$this->loader->add_filter( 'script_loader_tag', $plugin_public, 'g_recaptcha_script_loader_tag', 20, 3 );
	}


	public function admin_notice() {
		?>
		<div class="notice notice-error">
			<p><?php echo __( 'Addonify reCaptcha For EDD is enabled but not effective. It requires Easy Digital Downloads in order to work.', 'addonify-recaptcha-for-edd' ); ?></p>
		</div>
		<?php	
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {

		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Addonify_Recaptcha_For_Edd_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {

		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {

		return $this->version;
	}
}
