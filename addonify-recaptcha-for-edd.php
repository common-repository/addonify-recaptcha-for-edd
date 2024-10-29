<?php
/**
 *
 * @link              https://addonify.com
 * @since             1.0.0
 * @package           Addonify_Recaptcha_For_Edd
 *
 * @wordpress-plugin
 * Plugin Name:       Addonify - reCaptcha For EDD
 * Plugin URI:        https://addonify.com/downloads/recaptcha-for-edd
 * Description:       Addonify reCaptcha For EDD is a simple plugin that adds Google reCaptcha in Easy Digital Downloads login and registration forms.
 * Version:           1.0.12
 * Author:            Addonify
 * Author URI:        https://addonify.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       addonify-recaptcha-for-edd
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ADDONIFY_RECAPTCHA_FOR_EDD_VERSION', '1.0.12' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-addonify-recaptcha-for-edd-activator.php
 */
function activate_addonify_recaptcha_for_edd() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-addonify-recaptcha-for-edd-activator.php';
	Addonify_Recaptcha_For_Edd_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-addonify-recaptcha-for-edd-deactivator.php
 */
function deactivate_addonify_recaptcha_for_edd() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-addonify-recaptcha-for-edd-deactivator.php';
	Addonify_Recaptcha_For_Edd_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_addonify_recaptcha_for_edd' );
register_deactivation_hook( __FILE__, 'deactivate_addonify_recaptcha_for_edd' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-addonify-recaptcha-for-edd.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_addonify_recaptcha_for_edd() {

	$plugin = new Addonify_Recaptcha_For_Edd();
	$plugin->run();

}
run_addonify_recaptcha_for_edd();
