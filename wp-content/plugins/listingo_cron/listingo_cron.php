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
 * @package           Listingo Cron
 *
 * @wordpress-plugin
 * Plugin Name:       Listingo Cron
 * Plugin URI:        https://themeforest.net/user/themographics/portfolio
 * Description:       This plugin is used for creating cron jobs for Listingo WordPress Theme
 * Version:           1.0
 * Author:            Themographics
 * Author URI:        https://themeforest.net/user/themographics
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       listingo_cron
 * Domain Path:       /languages
 */

/**
 * Active plugin
 *
 * @throws error
 * @author Themographics <info@themographics.com>
 * @return 
 */
if( !function_exists('listingo_cron_activation') ) {
	function listingo_cron_activation() {	
		if ( ! wp_next_scheduled( 'listingo_update_featured_expiry_listing' ) ) {
		  wp_schedule_event( time(), 'hourly', 'listingo_update_featured_expiry_listing' );
		}
		
	}
	register_activation_hook (__FILE__, 'listingo_cron_activation');
}

/**
 * Update expiry
 *
 * @throws error
 * @author Amentotech <info@themographics.com>
 * @return 
 */
if( !function_exists('listingo_update_featured_expiry_listing') ) {
	function listingo_update_featured_expiry_listing() {
		global $wpdb;
		$current_date 	= current_time('mysql');

		$table_user = $wpdb->prefix . 'users';
		$table_meta = $wpdb->prefix . 'usermeta';

		$user_data 		= $wpdb->get_results("SELECT $table_user.ID
							FROM $table_user INNER JOIN $table_meta
							ON $table_user.ID = $table_meta.user_id 
							WHERE $table_meta.meta_key = 'wp_capabilities' AND ( $table_meta.meta_value LIKE '%professional%' || $table_meta.meta_value LIKE '%business%' )
							");

		if( !empty( $user_data ) ){
			foreach( $user_data as $key => $user ){
				$subscription = listingo_get_subscription_meta('subscription_featured_expiry', $user->ID);
				if( !empty( $subscription ) && $subscription > strtotime($current_date) ){
					update_user_meta($user->ID, 'subscription_featured_expiry', 1);
				} else{
					update_user_meta($user->ID, 'subscription_featured_expiry', 0);
				}
			}
		}
		
		
		//Services expiry
		$query_args = array(
			'posts_per_page' 	  => -1,
			'post_type' 	 	  => array( 'sp_ads' ),
			'post_status' 	 	  => array( 'publish' ),
			'ignore_sticky_posts' => 1,
		);
		
		$all_posts 		= get_posts( $query_args );
		$current_time   = strtotime( current_time( 'mysql' ) );
		if( !empty( $all_posts ) ){
			foreach( $all_posts as $key => $item ){

				$get_expiry	= get_post_meta($item->ID,'_expiry_string',true);
				$get_expiry_stamp	= get_post_meta($item->ID,'_featured_timestamp',true);
				
				if( !empty( $get_expiry ) && $get_expiry > strtotime($current_date) ){
					update_post_meta( $item->ID, '_featured_timestamp', 1 );
				} else if( !empty( $get_expiry_stamp ) && $get_expiry_stamp > strtotime($current_date) ){
					update_post_meta( $item->ID, '_expiry_string', $get_expiry_stamp );
					update_post_meta( $item->ID, '_featured_timestamp', 1 );
				} else {
					update_post_meta( $item->ID, '_featured_timestamp', 0 );
				}
	
			}
		}
	}
	add_action( 'listingo_update_featured_expiry_listing', 'listingo_update_featured_expiry_listing' );
}


/**
 * Deactive plugin
 *
 * @throws error
 * @author Amentotech <info@themographics.com>
 * @return 
 */
if( !function_exists('listingo_cron_deactivate') ) {
	function listingo_cron_deactivate() {	
		$timestamp = wp_next_scheduled ('listingo_update_featured_expiry_listing');
		wp_unschedule_event ($timestamp, 'listingo_update_featured_expiry_listing');
	} 
	register_deactivation_hook (__FILE__, 'listingo_cron_deactivate');
}

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
add_action( 'init', 'listingo_cron_load_textdomain' );
function listingo_cron_load_textdomain() {
  load_plugin_textdomain( 'listingo_cron', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}