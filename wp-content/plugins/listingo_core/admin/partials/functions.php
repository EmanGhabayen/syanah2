<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themeforest.net/user/themographics/portfolio
 * @since      1.0.0
 *
 * @package    Listingo
 * @subpackage Listingo/admin
 */
/**
 * Save Meta options
 * @return 
 */
if (!function_exists('listingo_save_meta_data')) {

    function listingo_save_meta_data($post_id = '') {

        if (!is_admin()) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }


        //Job meta update
        if (get_post_type() == 'sp_jobs') {
            if (!function_exists('fw_get_db_post_option')) {
                return;
            }

            if (!empty($_POST['fw_options'])) {
                foreach ($_POST['fw_options'] as $key => $value) {
					
					if( $key === 'category' ) {
						if( !empty( $value ) ){
							$postdata = get_post($value); 
							if( !empty( $postdata->post_name ) ){
								$value = $postdata->post_name;
							}
						}
					} elseif( $key === 'sub_category' ) {
						if( !empty( $value ) ){
							$cat = get_term_by('term_id', $value, 'sub_category');
							if(!empty( $cat->slug )) {
								$value	= $cat->slug;
							} 

						}
					} elseif( $key === 'author' ) {
						remove_action('save_post', 'listingo_save_meta_data');
						$post_arg = array(
							'ID' => $post_id,
							'post_author' => $value,
						);
						wp_update_post( $post_arg );
						add_action(' ', 'listingo_save_meta_data');
					} elseif( $key === 'languages' ) {
						$languages	= explode('/*/',$value);
						$languages_array	=  array();

						if ( !empty($languages) ) {
							foreach ($languages as $lang_key => $lang_value) {
								$language = get_term_by('term_id', $lang_value, 'languages');
								if(!empty( $language->slug )) {
									$languages_array[$lang_key]	= $language->slug;
								} 
							}
						}
						
						$value	= $languages_array;
					} 

                    update_post_meta($post_id, $key, $value); //exit;
                }
            }
        }

        //Save format
        if (get_post_type() == 'post') {
            if (!function_exists('fw_get_db_post_option')) {
                return;
            }

            if (isset($_POST['fw_options']['post_settings']['gadget'])) {
                update_post_meta($post_id, 'post_format_type', $_POST['fw_options']['post_settings']['gadget']); //exit;
            }
        }
		
		//if review update
        if ( get_post_type() == 'sp_reviews') {
            if (!function_exists('fw_get_db_post_option')) {
                return;
            }

			
            if (!empty($_POST['fw_options'])) {
				$post_status	= esc_attr( $_POST['post_status'] );
				$user_to		= intval( $_POST['fw_options']['user_to'] );
				$user_from		= intval( $_POST['fw_options']['user_from'] );
				$recommended	= trim(stripslashes($_POST['fw_options']['recommended']),'"');
				$db_category_type = get_user_meta($user_to, 'category', true);
				$category_type		= intval( $_POST['fw_options']['category_type'] );
				$review_wait_time		= esc_attr( $_POST['fw_options']['review_wait_time'] );
				$review_date			= esc_attr( $_POST['fw_options']['review_date'] );
				
				//Rating
				$rating = 0;

				/* Get the rating headings */
				$rating_evaluation = listingo_get_reviews_evaluation($db_category_type, 'leave_rating');
				$rating_evaluation_count = !empty($rating_evaluation) ? count($rating_evaluation) : 0;

				$review_extra_meta = array();

				//Office Evaluation		
				if (!empty($rating_evaluation)) {
					foreach ($rating_evaluation as $slug => $label) {
						if (isset($_POST['fw_options'][$slug])) {
							$review_extra_meta[$slug] = esc_attr($_POST['fw_options'][$slug]);
							update_post_meta($post_id, $slug, esc_attr($_POST['fw_options'][$slug]));
							$rating += (int) $_POST['fw_options'][$slug];
						}
					}
				}

				$user_rating = $rating / $rating_evaluation_count;

				$user_rating = number_format((float) $user_rating, 2, '.', '');
				
				$review_meta = array(
					'user_rating' 		=> $user_rating,
					'user_from' 		=> $user_from,
					'user_to' 			=> $user_to,
					'recommended' 		=> $recommended,
					'category_type' 	=> $category_type,
					'review_wait_time' 	=> $review_wait_time,
					'review_date' 		=> $review_date,
				);

				$review_meta = array_merge($review_meta, $review_extra_meta);

				//Update post meta
				foreach ($review_meta as $key => $value) {
					update_post_meta($post_id, $key, $value);
				}
				
				$review_meta['user_from'] 	= array($user_from);
            	$review_meta['user_to'] 	= array($user_to);
				
				$new_values = $review_meta;
				if (!empty($post_id)) {
					fw_set_db_post_option($post_id, null, $new_values);
				}

				
                $user_review_meta = array();
				
				//Update post meta
				$average_rating = listingo_get_everage_rating($user_to);

				foreach ($average_rating as $key => $rating) {
					$user_review_meta[$key] = $rating;
				}
				
				$total_rating	= !empty( $user_review_meta['sp_average_rating'] ) ? $user_review_meta['sp_average_rating'] : 0;
				
				update_user_meta($user_to, 'review_data', $user_review_meta);
				update_user_meta($user_to, 'rating_filter', $total_rating);

            }
        }
    }

    add_action('save_post', 'listingo_save_meta_data');
}

/**
 * @Rename Menu
 * @return {}
 */
if (!function_exists('listingo_rename_admin_menus')) {
	add_action( 'admin_menu', 'listingo_rename_admin_menus');
	function listingo_rename_admin_menus() {
		global $menu,$submenu;
		foreach( $menu as $key => $menu_item ) {
			if( $menu_item[2] == 'edit.php?post_type=sp_categories' ){
				$menu[$key][0] = esc_html__('Listingo','listingo_core');
			}
		}

	}
}


/**
 * @User Profile Social Icons
 * @return 
 */

if ( ! function_exists( 'listingo_user_social_mehthods' ) ) {
	
	function listingo_user_social_mehthods( $userid ) {
		$userfields['company_name']			= esc_html__('Company name','listingo_core');
		$userfields['zip']			= esc_html__('Zip Code','listingo_core');
		$userfields['tag_line']		= esc_html__('Tag Line','listingo_core');	
		$userfields['fax']			= esc_html__('Fax','listingo_core');
		
		if( apply_filters('listingo_dev_manage_fields','true','phone') === 'true' ){
			$userfields['phone']		= esc_html__('Phone Number','listingo_core');
		}
		
		$social_links = apply_filters('listingo_get_social_media_icons_list',array());
		
		if( !empty( $social_links ) ){
			foreach( $social_links as $key => $social ){
				$icon		= !empty( $social['icon'] ) ? $social['icon'] : '';
				$title		= !empty( $social['title'] ) ? $social['title'] : '';
				
				$userfields[$key]		= $title;
			}
		}
		
		return $userfields;
	}
	add_filter('user_contactmethods', 'listingo_user_social_mehthods', 10, 1);
}

/**
 * @Import User Menu
 * @return {}
 */
if (!function_exists('listingo_import_users_menu')) {
	add_action('admin_menu', 'listingo_import_users_menu');
	function  listingo_import_users_menu(){
		add_submenu_page('edit.php?post_type=sp_categories', 
							 esc_html__('Import User','listingo_core'), 
							 esc_html__('Import User','listingo_core'), 
							 'manage_options', 
							 'import_users',
							 'listingo_import_users_template'
						 );
		
		//add_menu_page(esc_html__('Listings','listingo_core'), esc_html__('Listings','listingo_core'), 'manage_options', 'users.php','','dashicons-location');

	}
}

/**
 * @Import Users
 * @return {}
 */
if (!function_exists('listingo_import_users_template')) {
	function  listingo_import_users_template(){
		
		$permalink = add_query_arg( 
								array(
									'&type=file',
								)
							);	
		
		//Import users via file
		if ( !empty( $_FILES['users_csv']['tmp_name'] ) ) {
			$import_user	= new SP_Import_User();
			$import_user->listingo_import_user();
			?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e('User Imported Successfully','listingo_core');?></p>
			</div>
			<?php
		}
	   ?>
       <h3 class="theme-name"><?php esc_html_e('Import Dummy Directory Users','listingo_core');?></h3>
       <div id="import-users" class="import-users">
            <div class="theme-screenshot">
                <img alt="<?php esc_attr_e('Import Users','listingo_core');?>" src="<?php echo get_template_directory_uri();?>/admin/images/users.jpg">
            </div>
			<h3 class="theme-name"><?php esc_html_e('Import Users','listingo_core');?></h3>
            <div class="user-actions">
                <a href="javascript:;" class="button button-primary doc-import-users"><?php esc_html_e('Import Dummy','listingo_core');?></a>
            </div>
	   </div>
       <div id="import-users" class="import-users custom-import">
            <form method="post" action="<?php echo cus_prepare_final_url('file','import_users'); ?>"  enctype="multipart/form-data">
				<div class="theme-screenshot">
					<img alt="<?php esc_attr_e('Import Users','listingo_core');?>" src="<?php echo get_template_directory_uri();?>/admin/images/users.jpg">
				</div>
				<h3 class="theme-name">
					<input id="upload-dummy-csv" type="file" name="users_csv" >
					<label for="upload-dummy-csv" class="button button-primary upload-dummy-csv"><?php esc_html_e('Choose File','listingo_core');?></lable>
				</h3>
				<div class="user-actions">
					<input type="submit" class="button button-primary" value="<?php esc_html_e('Import From File','listingo_core');?>">
					
				</div>
            </form>
		</div>
        <?php
	}
}


/**
 * @init            tab url
 * @package         Tailors Online
 * @subpackage      tailors-online/admin/partials
 * @since           1.0
 * @desc            Display The Tab System URL
 */
if (!function_exists('cus_prepare_final_url')) {

    function cus_prepare_final_url($tab='',$page='import_users') {
		$permalink = '';
		$permalink = add_query_arg( 
								array(
									'?page'	=>   urlencode( $page ) ,
									'tab'	=>   urlencode( $tab ) ,
								)
							);	
		
		return esc_url( $permalink );
	}
}

/**
 * @Import Users
 * @return {}
 */
if (!function_exists('listingo_import_users')) {
	function  listingo_import_users(){
		$import_user	= new SP_Import_User();
		$import_user->listingo_import_user();
		if ( function_exists('listingo_update_users')) { listingo_update_users(); }
		$json	= array();
		$json['type']	= 'success';	
		$json['message']	= esc_html__('User Imported Successfully','listingo_core' );
		echo json_encode( $json );
		die;	
	}
	add_action('wp_ajax_listingo_import_users', 'listingo_import_users');	
}

/**
 * @Categories
 * @return {}
 */
if (!function_exists('listingo_get_posts_categories_walker')) {
	function listingo_get_posts_categories_walker($post_type='post',$taxanomy='category',$parent=0,$seprator='-',$cat_array=array()){
		global $wpdb;
		$args = array(
			'type'                     => $post_type,
			'child_of'                 => $parent,
			'orderby'                  => 'name',
			'order'                    => 'DESC',
			'hide_empty'               => 1,
		); 

		$categories = get_categories( $args );
		foreach ($categories as $key => $velue) {
			 $parent_id = $velue->term_id;
    		 $children = $wpdb->get_results( "SELECT term_id FROM $wpdb->term_taxonomy WHERE parent=$parent_id" );
			 $no_children = count($children);
			 $cat_array[$velue->term_id]	= $seprator.$velue->name; 
			 if ($no_children > 0) {
				listingo_get_posts_categories_walker('post','category',$parent_id,'-',$cat_array);
			 }
		}
		return $cat_array; 
	}
}


/**
 * @Import Users
 * @return {}
 */
if (!function_exists('listingo_save_theme_settings')) {
	function  listingo_save_theme_settings(){
		$settings	= $_POST['settings'];
		$json	= array();
		
		update_option( 'sp_theme_settings', $settings, true );
		$json['type']	= 'success';	
		$json['message']	= esc_html__('Settings updated','listingo_core' );
		echo json_encode( $json );
		die;	
	}
	add_action('wp_ajax_listingo_save_theme_settings', 'listingo_save_theme_settings');	
}


/**
 * @Import Users
 * @return {}
 */
if (!function_exists('listingo_update_provider_menu_sorting')) {
	function  listingo_update_provider_menu_sorting(){
		$settings	= $_POST['menu'];
		$json	= array();
		
		update_option( 'sp_dashboard_menu_settings', $settings, true );
		$json['type']		= 'success';	
		$json['message']	= esc_html__('Sorting updated.','listingo_core' );
		echo json_encode( $json );
		die;	
	}
	add_action('wp_ajax_listingo_update_provider_menu_sorting', 'listingo_update_provider_menu_sorting');	
}

/**
 * @Import Users
 * @return {}
 */
if (!function_exists('listingo_reset_dashboard_menu')) {
	function  listingo_reset_dashboard_menu(){
		$settings	= array();
		$json		= array();
		
		update_option( 'sp_dashboard_menu_settings', $settings, true );
		$json['type']		= 'success';	
		$json['message']	= esc_html__('Menu has reset.','listingo_core' );
		echo json_encode( $json );
		die;	
	}
	add_action('wp_ajax_listingo_reset_dashboard_menu', 'listingo_reset_dashboard_menu');	
}

/**
 * @get settings
 * @return {}
 */
if (!function_exists('listingo_get_theme_settings')) {
	function  listingo_get_theme_settings($key){
		$sp_theme_settings = get_option( 'sp_theme_settings' );
		$setting	= !empty( $sp_theme_settings[$key] ) ? $sp_theme_settings[$key] : '';
		return $setting;
	}
	add_filter('listingo_get_theme_settings', 'listingo_get_theme_settings', 10, 1);
}