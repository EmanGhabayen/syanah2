<?php

/**
 * Fired during plugin activation
 *
 * @link       https://themeforest.net/user/themographics/portfolio
 * @since      1.0.0
 *
 * @package    Listingo
 * @subpackage Listingo/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Elevator
 * @subpackage Listingo/includes
 * @author     Themographics <themographics@gmail.com>
 */
class Listingo_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
       self::create_pages();
	   self::listingo_create_db_tables();
	   self::listingo_save_settings();
	}
	
	/**
	 * @init            save default settings
	 * @package         Tailors Online
	 * @subpackage      listingo_core/admin/partials
	 * @since           1.0
	 * @desc            create page when plugin get activate
	 */
    public static function listingo_save_settings() {
		if (!get_option('sp_theme_settings')) {
			$settings			= array();
			$settings['jobs']	= 'yes';
			update_option('sp_theme_settings' , $settings);
		}
    }
	
	/**
	 * @init            create pages
	 * @package         Tailors Online
	 * @subpackage      listingo_core/admin/partials
	 * @since           1.0
	 * @desc            create page when plugin get activate
	 */
    public static function create_pages() {
		$pages =	array(
						'authentication' => array(
							'name'    => esc_html__( 'Authentication','listingo_core' ),
							'title'   => esc_html__( 'Authentication','listingo_core' ),
							'content' => '[' . 'listingo_authentication'. ' login_title="Login Now" register_title="Register As"]'
						),
					) ;

        foreach ( $pages as $key => $page ) {
            self::listingo_create_page( esc_sql( $page['name'] ), $page['title'], $page['content'] );
        }

    }
	
	/**
     * @init            create db tables
     * @package         Listingo
     * @since           1.0
     * @desc            create page when plugin get activate
     */
    public static function listingo_create_db_tables() {

        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $withdrawal_table_name = $wpdb->prefix . 'sp_withdrawal_history';
        $earnings_table_name = $wpdb->prefix . 'sp_earnings';

        $withdrawal_sql = "CREATE TABLE $withdrawal_table_name (
            id mediumint(11) NOT NULL AUTO_INCREMENT,
            user_id mediumint(11) NOT NULL,
            amount FLOAT NOT NULL DEFAULT '0.0',
			currency_symbol varchar(50) NOT NULL,
            payment_method varchar(255) NOT NULL,
            processed_date DATETIME NULL,
            timestamp BIGINT NOT NULL,
            year YEAR NULL DEFAULT NULL,
			month varchar(5) NOT NULL,
			status ENUM('paid','un-paid') NOT NULL DEFAULT 'paid',
            PRIMARY KEY (id)
            ) $charset_collate;";
        
        $earnings_sql = "CREATE TABLE $earnings_table_name (
            id mediumint(11) NOT NULL AUTO_INCREMENT,
            user_id mediumint(11) NOT NULL,
            amount FLOAT NOT NULL DEFAULT '0.0',
			order_id varchar(50) NOT NULL,
			appointment_id varchar(50) NOT NULL,
            process_date DATETIME NULL,
            timestamp BIGINT NOT NULL,
			appointment_date DATETIME NULL,
            year YEAR NULL DEFAULT NULL,
			month varchar(5) NOT NULL,
			status ENUM('paid','un-paid') NOT NULL DEFAULT 'un-paid',
            PRIMARY KEY (id)
            ) $charset_collate;";
        
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($withdrawal_sql);
        dbDelta($earnings_sql);
    }
    
	/**
	 * @init            create pages
	 * @package         Tailors Online
	 * @subpackage      listingo_core/admin/partials
	 * @since           1.0
	 * @desc            create page when plugin get activate
	 */
	public static function listingo_create_page( $slug='', $page_title = '', $page_content = '') {
		global $wpdb;
		
		if ( strlen( $page_content ) > 0 ) {
			// Search for an existing page with the specified page content (typically a shortcode)
			$valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' ) AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );
		} else {
			// Search for an existing page with the specified page slug
			$valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' )  AND post_name = %s LIMIT 1;", $slug ) );
		}
		
		if ( $valid_page_found ) {
			return $valid_page_found;
		}
		
		// Search for a matching valid trashed page
		if ( strlen( $page_content ) > 0 ) {
			// Search for an existing page with the specified page content (typically a shortcode)
			$trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );
		} else {
			// Search for an existing page with the specified page slug
			$trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_name = %s LIMIT 1;", $slug ) );
		}
	
		if ( $trashed_page_found ) {
			$page_id   = $trashed_page_found;
			$page_data = array(
				'ID'             => $page_id,
				'post_status'    => 'publish',
			);
			wp_update_post( $page_data );
		} else {
			$page_data = array(
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'post_author'    => 1,
				'post_name'      => $slug,
				'post_title'     => $page_title,
				'post_content'   => $page_content,
				'comment_status' => 'closed'
			);
			$page_id = wp_insert_post( $page_data );
		}
	
		return $page_id;
	}

}
