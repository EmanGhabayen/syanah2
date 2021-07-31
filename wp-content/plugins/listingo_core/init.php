<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://themeforest.net/user/themographics/portfolio
 * @since             1.0
 * @package           Listingo Core
 *
 * @wordpress-plugin
 * Plugin Name:       Listingo Core
 * Plugin URI:        https://themeforest.net/user/themographics/portfolio
 * Description:       This plugin is used for creating custom post types and other functionality for Listingo Theme
 * Version:           3.2.4
 * Author:            Themographics
 * Author URI:        https://themeforest.net/user/themographics
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       listingo_core
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-elevator-activator.php
 */
if( !function_exists( 'activate_listingo' ) ) {
	function activate_listingo() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-system-activator.php';
		Listingo_Activator::activate();
		
	} 
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-elevator-deactivator.php
 */
if( !function_exists( 'deactivate_listingo' ) ) {
	function deactivate_listingo() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-system-deactivator.php';
		Listingo_Deactivator::deactivate();
	}
}

register_activation_hook( __FILE__, 'activate_listingo' );
register_deactivation_hook( __FILE__, 'deactivate_listingo' );

/**
 * Plugin configuration file,
 * It include getter & setter for global settings
 */
require plugin_dir_path( __FILE__ ) . 'config.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-system.php';
include listingo_template_exsits( 'hooks/hooks' );
require plugin_dir_path( __FILE__ ) . 'widgets/config.php';
include listingo_template_exsits( 'libraries/mailchimp/class-mailchimp' );
require plugin_dir_path( __FILE__ ) . 'libraries/mailchimp/class-mailchimp-oath.php';
include listingo_template_exsits( 'shortcodes/class-authentication' );
include listingo_template_exsits( 'helpers/email_notifications' );
require plugin_dir_path( __FILE__ ) . 'import-users/class-readcsv.php';
require plugin_dir_path( __FILE__ ) . 'admin/settings/settings.php';
include listingo_template_exsits( 'import-users/class-import-user' );

require plugin_dir_path( __FILE__ ) . 'libraries/paypal/includes/config.php';
require plugin_dir_path( __FILE__ ) . 'libraries/paypal/class-paypal.php';
require plugin_dir_path( __FILE__ ) . 'libraries/paypal/autoload.php';
require plugin_dir_path( __FILE__ ) . 'libraries/paypal/includes/process.php';
require plugin_dir_path( __FILE__ ) . 'libraries/google/init.php';
require plugin_dir_path( __FILE__ ) . 'social-connect/class-facebook.php';
require plugin_dir_path( __FILE__ ) . 'social-connect/class-google.php';
require_once( 'libraries/recaptchalib/recaptchalib.php');


/**
 * Get template from plugin or theme.
 *
 * @param string $file  Template file name.
 * @param array  $param Params to add to template.
 *
 * @return string
 */
function listingo_template_exsits( $file, $param = array() ) {
	extract( $param );
	if ( is_dir( get_stylesheet_directory() . '/extend/' ) ) {
		if ( file_exists( get_stylesheet_directory() . '/extend/' . $file . '.php' ) ) {
			$template_load = get_stylesheet_directory() . '/extend/' . $file . '.php';
		} else {
			$template_load = ListingoGlobalSettings::get_plugin_path() . '/' . $file . '.php';
		}
	} else {
		$template_load = ListingoGlobalSettings::get_plugin_path() . '/' . $file . '.php';
	}
	return $template_load;
}


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
if( !function_exists( 'run_Listingo' ) ) {
	function run_Listingo() {
	
		$plugin = new Listingo_Core();
		$plugin->run();
	
	}
	run_Listingo();
}

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
add_action( 'init', 'listingo_load_textdomain' );
function listingo_load_textdomain() {
  load_plugin_textdomain( 'listingo_core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}
