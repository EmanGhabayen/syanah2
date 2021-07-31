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
 * @package           Listingo VC Addon
 *
 * @wordpress-plugin
 * Plugin Name:       Listingo VC Addon
 * Plugin URI:        https://themeforest.net/user/themographics/portfolio
 * Description:       This plugin will create shortcodes tab in visual composer plugin for listingo theme.
 * Version:           3.2
 * Author:            Themographics
 * Author URI:        https://themeforest.net/user/themographics
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       listingo_vc_shortcodes
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
if( !function_exists( 'activate_listingo_vc_shortcodes' ) ) {
	function activate_listingo_vc_shortcodes() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-system-activator.php';
		Listingo_VC_Shortcodes_Activator::activate();
	}
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-elevator-deactivator.php
 */
if( !function_exists( 'deactivate_listingo_vc_shortcodes' ) ) {
	function deactivate_listingo_vc_shortcodes() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-system-deactivator.php';
		Listingo_VC_Shortcodes_Deactivator::deactivate();
	}
}

register_activation_hook( __FILE__, 'activate_listingo_vc_shortcodes' );
register_deactivation_hook( __FILE__, 'deactivate_listingo_vc_shortcodes' );

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
require plugin_dir_path( __FILE__ ) . 'hooks/hooks.php';
require plugin_dir_path( __FILE__ ) . 'vc_custom/core.php';
require plugin_dir_path( __FILE__ ) . 'vc_custom/config.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
if( !function_exists( 'run_Listingo_VC' ) ) {
	function run_Listingo_VC() {
	
		$plugin = new Listingo_VC_Core();
		$plugin->run();
	
	}
	run_Listingo_VC();
}

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
add_action( 'init', 'listingo_vc_shortcodes_load_textdomain' );
function listingo_vc_shortcodes_load_textdomain() {
  load_plugin_textdomain( 'listingo_vc_shortcodes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}