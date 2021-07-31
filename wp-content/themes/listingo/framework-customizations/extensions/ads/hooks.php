<?php
if (!defined('FW')) {
    die('Forbidden');
}

/**
 * @hook render ads listing view
 * @type echo
 */
if (!function_exists('_filter_fw_ext_get_render_ad_listing')) {

    function _filter_fw_ext_get_render_ad_listing() {
		echo fw_ext_get_render_ads_listing();
    }

    add_action('render_ad_listing_view', '_filter_fw_ext_get_render_ad_listing', 10);
}

/**
 * @hook render ads favorite listings
 * @type echo
 */
if (!function_exists('_filter_fw_ext_favorite_ads_view')) {

    function _filter_fw_ext_favorite_ads_view() {
        echo fw_ext_get_render_favorite_ads();
    }

    add_action('render_favorite_ads_view', '_filter_fw_ext_favorite_ads_view', 10);
}

/**
 * @hook render ads add view
 * @type echo
 */
if (!function_exists('_filter_fw_ext_get_render_ad_add')) {

    function _filter_fw_ext_get_render_ad_add() {
        echo fw_ext_get_render_ads_add();
    }

    add_action('render_ad_add_view', '_filter_fw_ext_get_render_ad_add', 10);
}


/**
 * @hook render ads profile detail
 * @type echo
 */
if (!function_exists('_filter_fw_ext_get_render_ad_dashboard_view')) {

    function _filter_fw_ext_get_render_ad_dashboard_view() {
        echo fw_ext_get_render_ads_dashboard_view();
    }

    add_action('render_sp_display_ads', '_filter_fw_ext_get_render_ad_dashboard_view', 10);
}

/**
 * @hook render ads search template
 * @type echo
 */
if (!function_exists('_filter_fw_ext_search_ads')) {

    function _filter_fw_ext_search_ads() {
        echo fw_ext_get_render_ads_search();
    }

    add_action('_filter_fw_ext_search_ads', '_filter_fw_ext_search_ads', 10);
}


/**
 * @hook render ads dashboard view
 * @type echo
 */
if (!function_exists('_filter_fw_ext_ad_view')) {

    function _filter_fw_ext_ad_view() {
        echo filter_fw_ext_ad_view_v2();
    }

    add_action('render_sp_display_ads_v2', '_filter_fw_ext_ad_view', 10);
}

/**
 * @hook render ads edit view
 * @type echo
 */
if (!function_exists('_filter_fw_ext_get_render_ad_edit')) {

    function _filter_fw_ext_get_render_ad_edit() {
        echo fw_ext_get_render_ads_edit();
    }

    add_action('render_ad_edit_view', '_filter_fw_ext_get_render_ad_edit', 10);
}

/**
 * @hook render ads dashboard view
 * @type echo
 */
if (!function_exists('_filter_fw_ext_get_render_profile_ads_view')) {

    function _filter_fw_ext_get_render_profile_ads_view() {
        echo fw_ext_get_render_profile_ads_view();
    }

    add_action('render_sp_display_profile_ads', '_filter_fw_ext_get_render_profile_ads_view', 10);
}

/**
 * @hook render ads dashboard view
 * @type echo
 */
if (!function_exists('_filter_fw_ext_get_render_ads_detail_view')) {

    function _filter_fw_ext_get_render_ads_detail_view() {
        echo filter_fw_ext_ad_detail_view();
    }

    add_action('render_sp_display_detail_ads_view', '_filter_fw_ext_get_render_ads_detail_view', 10);
}

/**
 * @hook render ads search
 * @type echo
 */
if (!function_exists('_filter_fw_ext_get_render_ads_archive_view')) {

    function _filter_fw_ext_get_render_ads_archive_view() {
        echo filter_fw_ext_ad_archive_view();
    }

    add_action('render_sp_display_archive_view', '_filter_fw_ext_get_render_ads_archive_view', 10);
}

/**
 * @hook process ads
 * @type insert
 */
if (!function_exists('fw_ext_listingo_process_ads')) {

    function fw_ext_listingo_process_ads() {        	
        global $current_user, $wp_roles, $userdata;
		
        if (function_exists('listingo_is_demo_site')) {
            listingo_is_demo_site();
        } //if demo site then prevent

        do_action('listingo_is_action_allow'); //is action allow

        $return_url 	= '';        
        $user_name 		= listingo_get_username($current_user->ID);     
		$upload 		= wp_upload_dir();
		$upload_dir 	= $upload['basedir'];
		$upload_dir 	= $upload_dir . '/listing-temp/';		
        $type 			= !empty($_POST['type']) ? esc_attr($_POST['type']) : '';
        $current 		= !empty($_POST['current']) ? esc_attr($_POST['current']) : '';
        $ad_type 	    = !empty( $_POST['featured_ad'] ) ? $_POST['featured_ad'] : '';       
     
        $provider_category = listingo_get_provider_category($current_user->ID);
        remove_all_filters("content_save_pre");                

        $do_check = check_ajax_referer('listingo_ad_nounce', 'listingo_ad_nounce', false);
        if ($do_check == false) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('No kiddies please!', 'listingo');
            echo json_encode($json);
            die;
        }

        if (empty($_POST['ad']['title'])) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Title field should not be empty.', 'listingo');
            echo json_encode($json);
            die;
        }

        $title = !empty($_POST['ad']['title']) ? esc_attr($_POST['ad']['title']) : esc_html__('unnamed', 'listingo');
        $ad_detail = force_balance_tags($_POST['ad_detail']);

        $gallery  		= !empty($_POST['gallery']) ? ($_POST['gallery']) : array();
		$temp_items  	= !empty($_POST['temp_items']) ? ($_POST['temp_items']) : array();
        $ad_tags   		= !empty($_POST['ad']['tags']) ? $_POST['ad']['tags'] : array();
		$amenities   	= !empty($_POST['ad']['amenities']) ? $_POST['ad']['amenities'] : array();
		$categories   	= !empty($_POST['ad']['categories']) ? $_POST['ad']['categories'] : array();
		
		$time_slots   	= !empty( $_POST['schedules'] )  ? $_POST['schedules'] : array();	
		$time_zone 		= !empty( $_POST['_timezone'] )	? $_POST['_timezone'] : '';		

		$required_fields	= array(
			'pricing_type' => array(
				'required'  => true,
				'message'	=> esc_html__('Pricing Type is required','listingo')
			),
			
			'address' => array(
				'required'  => true,
				'message'	=> esc_html__('Address is required','listingo')
			),
			'longitude' => array(
				'required'  => true,
				'message'	=> esc_html__('Longitude is required','listingo')
			),
			'longitude' => array(
				'required'  => true,
				'message'	=> esc_html__('Latitude is required','listingo')
			),
			'country' => array(
				'required'  => false,
				'message'	=> esc_html__('','listingo')
			),
			'city' => array(
				'required'  => false,
				'message'	=> esc_html__('','listingo')
			),
		);
		
		$required_fields = apply_filters('listingo_ad_required_options',$required_fields);
		
		$ad_data = is_array( $_POST['ad'] ) ? $_POST['ad'] : array();		
		
		foreach( $required_fields as $key => $field ){
			if( isset( $field['required'] ) && $field['required'] ===  true && empty($_POST['ad'][$key]) ){
				$json['type'] = 'error';
				$json['message'] = $field[message];
				echo json_encode($json);
				die;
			}
		}

        $dir_profile_page = '';
        if (function_exists('fw_get_db_settings_option')) {
            $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
        }

        $profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';

        if (function_exists('fw_get_db_settings_option')) {
            $approve_ads = fw_get_db_settings_option('approve_ads', $default_value = null);
        }

		$ad_db_meta = array();
		$ad_meta = array(
			'tagline' 		=> 'tagline',
			'website'  		=> 'website',			
			'email' 		=> 'email',
			'phone' 		=> 'phone',
			'pricing_type'  => 'pricing_type',
			'price' 		=> 'price',
			'currency' 		=> 'currency',
			'address'		=> 'address',
			'latitude' 		=> 'latitude',
			'longitude' 	=> 'longitude',
			'country'  		=> 'country',
			'city' 			=> 'benifits',
			'videos' 		=> 'address',
			'social'		=> array(
				'facebook' 		=> 'facebook',
				'twitter' 		=> 'twitter',
				'linkedin' 		=> 'linkedin',
				'skype' 		=> 'skype',
				'googleplus' 	=> 'googleplus',
				'pinterest'  	=> 'pinterest',
				'tumblr' 		=> 'tumblr',
				'instagram' 	=> 'instagram',
				'flickr' 		=> 'flickr',
				'medium' 		=> 'medium',
				'tripadvisor' 	=> 'tripadvisor',
				'wikipedia'  	=> 'wikipedia',
				'vimeo' 		=> 'vimeo',
				'youtube' 		=> 'youtube',
				'whatsapp' 		=> 'whatsapp',
				'vkontakte' 	=> 'vkontakte',
				'odnoklassniki' => 'odnoklassniki'
			)
		);
		
        //add/edit ad
        if (isset($type) && $type === 'add') {

            if (isset($approve_ads) && $approve_ads === 'need_approval') {
                $status 		 = 'pending';
                $json['message'] = esc_html__('Your ad has submitted and will be publish after the review.', 'listingo');
            } else {
                $status 			= 'publish';
                $json['message'] 	= esc_html__('ad added successfully.', 'listingo');
            }

            $ad_post = array(
                'post_title' => $title,
                'post_status' => $status,
                'post_content' => $ad_detail,
                'post_author' => $current_user->ID,
                'post_type' => 'sp_ads',
                'post_date' => current_time('Y-m-d H:i:s')
            );

            $post_id = wp_insert_post($ad_post);
			
			//Update meta
			foreach( $required_fields as $key => $field ){
				$value   = !empty($_POST['ad'][$key]) ? esc_attr( $_POST['ad'][$key] ) : '';
				update_post_meta( $post_id, $key, $value );
			}
			
			//move temp files to WordPress media
			if( !empty( $temp_items ) ){
				foreach( $temp_items as $kye => $name ){
					$url 		= $upload_dir.$name;
					$gallery[]	= fw_ext_temp_upload($url,$post_id);
				}
			}

			if (!empty($gallery)) {
				$attachment_id = !empty($gallery[1]['attachment_id']) ? $gallery[1]['attachment_id'] : '';
			}
			
			//update gallery
            if (!empty($attachment_id)) {
                set_post_thumbnail($post_id, $attachment_id);
            }

			wp_set_post_terms($post_id, $ad_tags, 'ad_tags');
			wp_set_post_terms($post_id, $amenities, 'ad_amenity');
			wp_set_post_terms($post_id, $categories, 'ad_category');

			//other meta
			foreach( $ad_data as $key => $field ){
				if( $key === 'social' ){
					foreach( $field as $skey => $field ){
						if( isset( $ad_data['social'][$skey] ) ){
							$ad_db_meta[$skey] = $ad_data['social'][$skey];
						}
					}
				} else if( $key === 'country' ){
					$term = get_term_by('slug', $ad_data[$key], 'countries');
					if( !empty( $term ) ){
						$ad_db_meta[$key][0] = $term->term_id;
					}
				}else if( $key === 'city' ){
					$term = get_term_by('slug', $ad_data[$key], 'cities');
					if( !empty( $term ) ){
						$ad_db_meta[$key][0] = $term->term_id;
					}
				}else{
					if( isset( $ad_data[$key] ) ){
						$ad_db_meta[$key] = $ad_data[$key];
					}
					
				}
			}
			
			//Gallery
			$gallery_meta	= array();
			if( !empty( $gallery ) ){
				$gcount = 0;
				foreach( $gallery as $key => $value ){
					$gallery_meta[$gcount] = $gallery[$key];
					$gcount++;
				}
			}
			
			$ad_db_meta['gallery'] = $gallery_meta;		
			
		    //time slots			
			$_time_slots	= array();
			$_time_slots[0]['timezone'] = $time_zone;
			if( !empty( $time_slots ) ){				
				foreach( $time_slots as $key => $value ){
					$_time_slots[0][$key][0] = $value;					
				}
			}				   
			
			$ad_db_meta['time_details'] = $_time_slots;	

		    //Featured ad			
			if( !empty( $ad_type ) && $ad_type === 'featured' ) {
				$ad_db_meta['featured'] = $ad_type;
				$is_featured_allowed = listingo_get_subscription_meta('subscription_featured_ads', $current_user->ID);
				if( !empty( $is_featured_allowed ) && $is_featured_allowed > 0 ){
					//Allowed
					$current_date = current_time('mysql');
					$get_featured_time = listingo_get_subscription_meta('subscription_ad_featured_expiry', $current_user->ID);
					
					if( !empty( $get_featured_time ) && $get_featured_time > strtotime($current_date) ){
						update_post_meta($post_id, '_featured_timestamp', 1);
						update_post_meta($post_id, '_expiry_string', $get_featured_time);
					} else{
						update_post_meta($post_id, '_featured_timestamp', 0);
					}
					
					$sp_subscription = get_user_meta($current_user->ID, 'sp_subscription', true);
					$sp_subscription['subscription_featured_ads'] = !empty( $sp_subscription['subscription_featured_ads'] ) ? $sp_subscription['subscription_featured_ads'] - 1 : 0;
					$sp_subscription['subscription_ads'] = !empty( $sp_subscription['subscription_ads'] ) ? $sp_subscription['subscription_ads'] - 1 : 0;
					update_user_meta($current_user->ID, 'sp_subscription', $sp_subscription);

				} else {
					$ad_db_meta['featured'] = 'standard';
					update_post_meta($post_id, '_featured_timestamp', 0);
				} 				
			} else {
				$ad_db_meta['featured'] = 'standard';
				update_post_meta($post_id, '_featured_timestamp', 0);
			}
			
			$new_values = $ad_db_meta;
			if (!empty($post_id)) {
				fw_set_db_post_option($post_id, null, $new_values);
			}			

            $return_url = Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'ads', $current_user->ID, 'true', 'listing');
            $json['return_url'] = htmlspecialchars_decode($return_url);
			
			//add time slots
			if( !empty( $time_slots ) ) {
				update_post_meta( $post_id, '_time_details', $time_slots );
			}

			//Time zone
			if( !empty( $time_zone ) ) {
				update_post_meta($post_id, '_timezone', $time_zone);
			}
            
            if (class_exists('ListingoProcessEmail')) {
                $email_helper = new ListingoProcessEmail();
                $emailData = array();
                $emailData['user_link'] = get_author_posts_url($current_user->ID);
                $emailData['user_name'] = $user_name;
                $emailData['ad_name'] 	= $title;
                
				if( get_post_status( $post_id ) === 'pending' ){
                	$emailData['link'] 	  = get_edit_post_link($post_id);
                } else {
                	$emailData['link'] 	  = get_the_permalink($post_id);
                }
				
                $email_helper->approve_ad($emailData);                    
            }           
			
        } elseif (isset($type) && $type === 'update' && !empty($current)) {
            $post_author = get_post_field('post_author', $current);
            $post_id 	 = $current;
            $status 	 = get_post_status($post_id);

            if (intval($current_user->ID) === intval($post_author)) {
                $ad_post = array(
                    'ID' => $current,
                    'post_title' => $title,
                    'post_content' => $ad_detail,
                    'post_status' => $status,
                );

                wp_update_post($ad_post);            

                //Update meta
				foreach( $required_fields as $key => $field ){
					$value   = !empty($_POST['ad'][$key]) ? esc_attr( $_POST['ad'][$key] ) : '';
					update_post_meta( $post_id, $key, $value );
				}
				
				//move temp files to WordPress media
				if( !empty( $temp_items ) ){
					foreach( $temp_items as $kye => $name ){
						$url 		= $upload_dir.$name;
						$gallery[]	= fw_ext_temp_upload($url,$post_id);
					}
				}				

				wp_set_post_terms($post_id, $ad_tags, 'ad_tags');
				wp_set_post_terms($post_id, $amenities, 'ad_amenity');
				wp_set_post_terms($post_id, $categories, 'ad_category');
				
				
				//other meta
				foreach( $ad_data as $key => $field ){
					if( $key === 'social' ){
						foreach( $field as $skey => $field ){
							if( isset( $ad_data['social'][$skey] ) ){
								$ad_db_meta[$skey] = $ad_data['social'][$skey];
							}
						}
					} else if( $key === 'country' ){
						$term = get_term_by('slug', $ad_data[$key], 'countries');
						if( !empty( $term ) ){
							$ad_db_meta[$key][0] = $term->term_id;
						}
					}else if( $key === 'city' ){
						$term = get_term_by('slug', $ad_data[$key], 'cities');
						if( !empty( $term ) ){
							$ad_db_meta[$key][0] = $term->term_id;
						}
					}else{
						if( isset( $ad_data[$key] ) ){
							$ad_db_meta[$key] = $ad_data[$key];
						}

					}
				}
				
				//Gallery
				$prev_gallery = array();
				if (function_exists('fw_get_db_post_option')) {
					$prev_gallery = fw_get_db_post_option($post_id, 'gallery', true);
				}
				
				$resulted 		= array();
				$old_gallery 	= array();
				$new_gallery 	= array();
				if( !empty( $prev_gallery ) ) {
					foreach ($prev_gallery as $value) {
						$old_gallery[] = $value['attachment_id'];
					}
				}

				if( !empty( $gallery ) ) {
					foreach ($gallery as $value) {
						$new_gallery[] = $value['attachment_id'];
					}
				}
				
				//delete unattached media
				$resulted = array_diff($old_gallery, $new_gallery);
				if( !empty( $resulted ) ) {
					foreach ($resulted as $value) {								
						wp_delete_attachment( $value, true );
					}					
				}						
										
				//Gallery
				$gallery_meta	= array();
				if( !empty( $gallery ) ){
					$gcount = 0;
					foreach( $gallery as $key => $value ){
						$gallery_meta[$gcount] = $gallery[$key];
						$gcount++;
					}
				}								

				$ad_db_meta['gallery'] = $gallery_meta;				
				
				if (!empty($gallery_meta)) {
					$attachment_id = !empty($gallery_meta[0]['attachment_id']) ? $gallery_meta[0]['attachment_id'] : '';
				}				
				
				//update gallery
				if (!empty($attachment_id)) {
					set_post_thumbnail($post_id, $attachment_id);
				} else {
					delete_post_thumbnail( $post_id );
				}
				
                //time slots			
				$_time_slots	= array();
				$_time_slots[0]['timezone'] = $time_zone;
				if( !empty( $time_slots ) ){				
					foreach( $time_slots as $key => $value ){
						$_time_slots[0][$key][0] = $value;					
					}
				}								
				
				$ad_db_meta['time_details'] = $_time_slots;				
               
                //Featured ad			
				if( !empty( $ad_type ) && $ad_type === 'featured' ) {
					$ad_db_meta['featured'] = $ad_type;
					$is_featured_allowed = listingo_get_subscription_meta('subscription_featured_ads', $current_user->ID);
					if( !empty( $is_featured_allowed ) && $is_featured_allowed > 0 ){
						//Allowed
						$current_date = current_time('mysql');
						$get_featured_time = listingo_get_subscription_meta('subscription_ad_featured_expiry', $current_user->ID);			
						update_post_meta($post_id, '_featured_timestamp', $get_featured_time);
						
						if( !empty( $get_featured_time ) && $get_featured_time > strtotime($current_date) ){
							update_post_meta($post_id, '_featured_timestamp', 1);
							update_post_meta($post_id, '_expiry_string', $get_featured_time);
						} else{
							update_post_meta($post_id, '_featured_timestamp', 0);
						}
						
						$sp_subscription = get_user_meta($current_user->ID, 'sp_subscription', true);
						$sp_subscription['subscription_featured_ads'] = !empty( $sp_subscription['subscription_featured_ads'] ) ? $sp_subscription['subscription_featured_ads'] - 1 : 0;
						$sp_subscription['subscription_ads'] = !empty( $sp_subscription['subscription_ads'] ) ? $sp_subscription['subscription_ads'] - 1 : 0;
						update_user_meta($current_user->ID, 'sp_subscription', $sp_subscription);
					} else {
						$ad_db_meta['featured'] = 'standard';
						update_post_meta($post_id, '_featured_timestamp', 0);
					} 				
				} else {
					$ad_db_meta['featured'] = 'standard';
					update_post_meta($post_id, '_featured_timestamp', 0);
				}

				$new_values = $ad_db_meta;

				if (!empty($post_id)) {
					fw_set_db_post_option($post_id, null, $new_values);
				}
				
				//add time slots				
				if( !empty( $time_slots ) ) {
					update_post_meta( $post_id, '_time_details', $time_slots );
				}

				//Time zone
				if( !empty( $time_zone ) ) {
					update_post_meta($post_id, '_timezone', $time_zone);
				}				
				
				$return_url = Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'ads', $current_user->ID, 'true', 'listing');
            	$json['return_url'] = htmlspecialchars_decode($return_url);
				
                $json['message'] = esc_html__('ad updated successfully.', 'listingo');
            } else {
                $json['type'] = 'error';
                $json['message'] = esc_html__('An error occurred, please try again later', 'listingo');
                echo json_encode($json);
                die;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = esc_html__('An error occurred, please try again later', 'listingo');
            echo json_encode($json);
            die;
        }


        $json['type'] = 'success';

        echo json_encode($json);
        die;
    }

    add_action('wp_ajax_fw_ext_listingo_process_ads', 'fw_ext_listingo_process_ads');
    add_action('wp_ajax_nopriv_fw_ext_listingo_process_ads', 'fw_ext_listingo_process_ads');
}

/**
 * @Contact Ad Author
 * @return 
 */
if (!function_exists('listingo_ad_contact_form')) {

    function listingo_ad_contact_form() {
        global $current_user;
        $json = array();      

        $bloginfo = get_bloginfo();
        $success_message = esc_html__('Your message has sent', 'listingo');
        $failure_message = esc_html__('Message Fail.', 'listingo');

		// Get the form fields and remove whitespace.
		if (empty($_POST['name']) 
			|| empty($_POST['email']) 
			|| empty($_POST['phone']) 
			|| empty($_POST['subject']) 
			|| empty($_POST['description'])
		) {
			$json['type'] = 'error';
			$json['message'] = esc_html__('All the fields are required.', 'listingo');
			echo json_encode($json);
			die;
		}

		if (!is_email($_POST['email'])) {
			$json['type'] = 'error';
			$json['message'] = esc_html__('Email address is not valid.', 'listingo');
			echo json_encode($json);
			die;
		}

		$name       = esc_attr($_POST['name']);
		$email      = esc_attr($_POST['email']);
		$subject    = esc_attr($_POST['subject']);
		$phone      = esc_attr($_POST['phone']);
		$message    = esc_attr($_POST['description']);
		$ad_id      = esc_attr( $_POST['ad_id']);
		$link 		= esc_url( get_the_permalink( $ad_id ) );
		
		$title 		= esc_attr( get_the_title( $ad_id ) ); 
		$post_author_id = get_post_field( 'post_author', $ad_id );
		$author_obj 	= get_user_by('id', $post_author_id);

		if (class_exists('ListingoProcessEmail')) {
			$email_helper 	= new ListingoProcessEmail();
			$emailData 		= array();
			$emailData['username']      = $name;
			$emailData['useremail']     = $email;
			$emailData['subject']       = $subject;
			$emailData['phone']         = $phone;
			$emailData['message']       = $message;
			$emailData['email_to']      = $author_obj->user_email;;
			$emailData['ad_id']            = $ad_id;
			$emailData['ad_link']          = $link;
			$emailData['ad_title']         = $title;

			$email_helper->process_ad_contact_form_email($emailData);
		}

		// Send the email.
		$json['type']	 = "success";
		$json['message'] = esc_attr($success_message);
		echo json_encode($json);
		die();
	}
	
    add_action('wp_ajax_listingo_ad_contact_form', 'listingo_ad_contact_form');
    add_action('wp_ajax_nopriv_listingo_ad_contact_form', 'listingo_ad_contact_form');
}


/**
 * Delete Comment Gallery Images
 * 
 * @param json
 * @return String
 */
if (!function_exists('listingo_delete_ad_comment_image')) {

    function listingo_delete_ad_comment_image() {       
        $json = array();
        $attach_id = !empty($_REQUEST['url'] ) ? $_REQUEST['url'] : '';             
        $base = ABSPATH .'wp-content/uploads/listing-temp/';	
        $file_name = '';
        if( !empty( $attach_id ) ) {
        	$file_name = basename($attach_id); 
        	$base = $base.$file_name;        	
        	if( !empty( $base ) ) {			
				if ( unlink( $base ) ) {			
					$json['type'] = 'success';
			        $json['message'] = esc_html__('Deleted.', 'listingo');
			        echo json_encode($json);
			        exit;
				} else {				
			        $json['type'] = 'error';
			        $json['message'] = esc_html__('Some thing went wrong.', 'listingo');
			        echo json_encode($json);
			        exit;
				}			
			}
        } else {
        	$json['type'] = 'error';
	        $json['message'] = esc_html__('Some thing went wrong.', 'listingo');
	        echo json_encode($json);
	        exit;
        }                     	           
    }

    add_action('wp_ajax_listingo_delete_ad_comment_image', 'listingo_delete_ad_comment_image');
    add_action('wp_ajax_nopriv_listingo_delete_ad_comment_image', 'listingo_delete_ad_comment_image');
}




/**
 * @save post meta data
 * @type delete
 */
if (!function_exists('listingo_save_ad_meta_data')) {
	add_action('save_post', 'listingo_save_ad_meta_data');
    function listingo_save_ad_meta_data($post_id) {
		if (!is_admin()) {
			return;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		if (get_post_type() == 'sp_ads') {
			if (!function_exists('fw_get_db_post_option')) {
				return;
			}

			$key_array	= array('pricing_type','price','address','latitude','longitude','country','city','gallery','time_details');
			
			//Set featured ad
			if( !empty( $_POST['fw_options']['featured'] ) ){
				$type = $_POST['fw_options']['featured'];
				if( isset( $type ) && $type === 'featured' ){
					$user_identity  = get_post_field( 'post_author', $post_id );
					
					$ad_db_meta['featured'] = $ad_type;
					$is_featured_allowed = listingo_get_subscription_meta('subscription_featured_ads', $user_identity);
					
					if( !empty( $is_featured_allowed ) && $is_featured_allowed > 0 ){
						$get_featured_time = listingo_get_subscription_meta('subscription_ad_featured_expiry', $user_identity);			

						$current_date = current_time('mysql');		

						if( !empty( $get_featured_time ) && $get_featured_time > strtotime($current_date) ){
							update_post_meta($post_id, '_featured_timestamp', 1);
							update_post_meta($post_id, '_expiry_string', $get_featured_time);
						} else{
							update_post_meta($post_id, '_featured_timestamp', 0);
						}
						
						$sp_subscription = get_user_meta($user_identity, 'sp_subscription', true);
						$sp_subscription['subscription_featured_ads'] = !empty( $sp_subscription['subscription_featured_ads'] ) ? $sp_subscription['subscription_featured_ads'] - 1 : 0;
						$sp_subscription['subscription_ads'] = !empty( $sp_subscription['subscription_ads'] ) ? $sp_subscription['subscription_ads'] - 1 : 0;
						update_user_meta($user_identity, 'sp_subscription', $sp_subscription);
						
						
					} else {
						$ad_db_meta['featured'] = 'standard';
						update_post_meta($post_id, '_featured_timestamp', 0);
					}

					$admin_featured_ads = get_user_meta($user_identity, 'admin_featured_ads', true);
					$admin_featured_ads = !empty( $admin_featured_ads ) ? $admin_featured_ads : array();
					
					if ( !empty( $admin_featured_ads ) && in_array( $post_id, $admin_featured_ads ) ){
						//Already featured
					} else {
						$admin_featured_ads[] = $post_id;
						
						$sp_subscription = get_user_meta($user_identity, 'sp_subscription', true);
						$sp_subscription['subscription_featured_ads'] = !empty( $sp_subscription['subscription_featured_ads'] ) ? $sp_subscription['subscription_featured_ads'] - 1 : 0;
						$sp_subscription['subscription_ads'] = !empty( $sp_subscription['subscription_ads'] ) ? $sp_subscription['subscription_ads'] - 1 : 0;
						update_user_meta($user_identity, 'sp_subscription', $sp_subscription);

						update_user_meta($user_identity, 'admin_featured_ads', $admin_featured_ads);
					}
					
					
				} else {
					update_post_meta($post_id, '_featured_timestamp', 0);
				}
			}
			
			if (!empty($_POST['fw_options'])) {
				foreach ($_POST['fw_options'] as $key => $value) {
					if( in_array($key,$key_array) ){
						if( $key === 'country' ){
							$value = get_term_by('term_id', $value, 'countries');
							if( !empty( $value->slug ) ){
								update_post_meta($post_id, $key, $value->slug); 
							}
							
						} elseif( $key === 'city' ){
							$value = get_term_by('term_id', $value, 'cities');
							if( !empty( $value->slug ) ){
								update_post_meta($post_id, $key, $value->slug); 
							}
						} elseif( $key === 'gallery' ){
							if(!empty( $value )){
								$string = str_replace(array('[',']'),'',$value);
								if( !empty( $string ) ){
									 $value	= explode(',',$string);
									 if( !empty( $value[0] ) ){
										 set_post_thumbnail($post_id, $value[0]);
									 }
								}
							}
							
						} elseif( $key === 'time_details' ){
							$timezones = array();
							if( function_exists('fw_get_db_post_option')){
								$timezones = fw_get_db_post_option($post_id, 'time_details', true);
							}              

							if (!empty($timezones)) {                    
								$time_details = array();
								$time_zone 						= $timezones[0]['timezone'];
								$time_details['monday'] 		= $timezones[0]['monday'][0];
								$time_details['tuesday'] 		= $timezones[0]['tuesday'][0];
								$time_details['wednesday'] 		= $timezones[0]['wednesday'][0];
								$time_details['thursday'] 		= $timezones[0]['thursday'][0];
								$time_details['friday'] 		= $timezones[0]['friday'][0];
								$time_details['saturday'] 		= $timezones[0]['saturday'][0];
								$time_details['sunday'] 		= $timezones[0]['sunday'][0];
								update_post_meta($post_id, '_timezone', $time_zone);
								update_post_meta($post_id, '_time_details', $time_details);
							}
						} else{
							update_post_meta($post_id, $key, $value); 
						}

					}
				}
			}
		}
	}
}

/**
 * @hook delete ads
 * @type delete
 */
if (!function_exists('fw_ext_listingo_delete_ads')) {

    function fw_ext_listingo_delete_ads() {
        global $current_user, $wp_roles, $userdata;

        $post_id = intval($_POST['id']);
        $post_author = get_post_field('post_author', $post_id);

        if (function_exists('listingo_is_demo_site')) {
            listingo_is_demo_site();
        }; //if demo site then prevent

        if (!empty($post_id) && intval($current_user->ID) === intval($post_author)) {
            wp_delete_post($post_id);
            $json['type'] = 'success';
            $json['message'] = esc_html__('ad deleted successfully.', 'listingo');
            echo json_encode($json);
            die;
        } else {
            $json['type'] = 'error';
            $json['message'] = esc_html__('An error occurred, please try again later', 'listingo');
            echo json_encode($json);
            die;
        }
    }

    add_action('wp_ajax_fw_ext_listingo_delete_ads', 'fw_ext_listingo_delete_ads');
    add_action('wp_ajax_nopriv_fw_ext_listingo_delete_ads', 'fw_ext_listingo_delete_ads');
}

/**
 * @upload featured image
 * @return {}
 */
if (!function_exists('listingo_featured_image_uploader')) {

    function listingo_featured_image_uploader() {
        global $current_user, $wp_roles, $userdata, $post;
        $user_identity = $current_user->ID;

        if (function_exists('listingo_is_demo_site')) {
            listingo_is_demo_site();
        }; //if demo site then prevent

        $nonce = $_REQUEST['nonce'];
        $type = $_REQUEST['type'];

        if (!wp_verify_nonce($nonce, 'listingo_featured_nounce')) {
            $ajax_response = array(
                'success' => false,
                'reason' => 'Security check failed!',
            );
            echo json_encode($ajax_response);
            die;
        }

        $submitted_file = $_FILES['listingo_uploader'];
        $uploaded_image = wp_handle_upload($submitted_file, array('test_form' => false));

        if (isset($uploaded_image['file'])) {
            $file_name = basename($submitted_file['name']);
            $file_type = wp_check_filetype($uploaded_image['file']);

            // Prepare an array of post data for the attachment.
            $attachment_details = array(
                'guid' => $uploaded_image['url'],
                'post_mime_type' => $file_type['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($file_name)),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment($attachment_details, $uploaded_image['file']);
            $attach_data = wp_generate_attachment_metadata($attach_id, $uploaded_image['file']);
            wp_update_attachment_metadata($attach_id, $attach_data);

            //Image Size
            $image_size = 'thumbnail';
            $thumbnail_url = listingo_get_profile_image_url($attach_data, $image_size,$file_name); //get image url

            $ajax_response = array(
                'success' => true,
                'url' => $thumbnail_url,
                'attachment_id' => $attach_id
            );

            echo json_encode($ajax_response);
            die;
        } else {
            $ajax_response = array('success' => false, 'reason' => 'Image upload failed!');
            echo json_encode($ajax_response);
            die;
        }
    }

    add_action('wp_ajax_listingo_featured_image_uploader', 'listingo_featured_image_uploader');
    add_action('wp_ajax_nopriv_listingo_featured_image_uploader', 'listingo_featured_image_uploader');
}

/**
 * @ad author detail
 * @return {}
 */
if (!function_exists('listingo_get_ad_provider_detail')) {

    function listingo_get_ad_provider_detail($ad_id,$provider_id) {
		$user_avatar = apply_filters(
        'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 100, 'height' => 100), $provider_id), array('width' => 100, 'height' => 100) //size width,height
);
		$provider_name = listingo_get_username($provider_id);
		?>
		<div class="tg-personfeature">
			<figure>
				<a href="<?php echo esc_url(get_author_posts_url($provider_id)); ?>"><img src="<?php echo esc_url( $user_avatar );?>" alt="<?php echo esc_attr($provider_name);?>"></a>
			</figure>
			<div class="tg-infoperson">
				<span><?php esc_attr_e('Posted By','listingo');?>:</span>
				<span><a href="<?php echo esc_url(get_author_posts_url($provider_id)); ?>"><?php echo esc_attr( $provider_name );?></a></span>
			</div>
		</div>
		<?php
	}
	add_action('listingo_get_ad_provider_detail', 'listingo_get_ad_provider_detail',10,2);
}

/**
 * @ad meta detail
 * @return {}
 */
if (!function_exists('listingo_get_ad_meta')) {

    function listingo_get_ad_meta($ad_id,$provider_id) {
		$dbpricing_type = fw_get_db_post_option($ad_id, 'pricing_type', true);
		$price_types	= apply_filters('listingo_get_price_type_list',listingo_ad_price_type());
		$average_rating = listingo_get_comment_average_ratings($ad_id);
		$total_ratings = listingo_get_comment_total_ratings($ad_id);
		if( $total_ratings > 0 ){
			$show_rating = $average_rating . '&nbsp;/&nbsp;' . '5.0' ;
		} else {
			$show_rating = esc_html__('No Reviews', 'listingo');
		}
		?>
		<ul class="tg-authorperform">
			<li><i class="lnr lnr-clock"></i><?php do_action('listingo_get_ad_status', $ad_id); ?></li>
			<?php if( !empty( $price_types[$dbpricing_type]['title'] ) ){ ?>
				<li><i class="lnr lnr-cart"></i><?php echo esc_attr($price_types[$dbpricing_type]['title']); ?></li>
			<?php } ?>
			<li><i class="lnr lnr-star"></i><?php echo esc_attr( $show_rating ); ?></li>
		</ul>
		<?php
	}
	add_action('listingo_get_ad_meta', 'listingo_get_ad_meta',10,2);
}

/**
 * @ad meta address
 * @return {}
 */
if (!function_exists('listingo_get_ad_address')) {

    function listingo_get_ad_address($ad_id) {
		$address   = fw_get_db_post_option($ad_id, 'address', true);
		$longitude = fw_get_db_post_option($ad_id, 'longitude', true);
		$latitude  = fw_get_db_post_option($ad_id, 'latitude', true);
		if( !empty( $address ) ){
		?>
		<ul class="tg-companycontactinfo">
			<li>
				<i class="lnr lnr-map-marker"></i>
				<span><em><?php echo esc_attr( $address );?></em><a href="//maps.google.com/maps?saddr=&amp;daddr=<?php echo esc_attr($address); ?>" target="_blank"><?php esc_html_e('Get directions', 'listingo'); ?></a></span>
			</li>
		</ul>
		<?php
		}
	}
	add_action('listingo_get_ad_address', 'listingo_get_ad_address',10,1);
}

/**
 * @ad title
 * @return {}
 */
if (!function_exists('listingo_get_ad_title')) {

    function listingo_get_ad_title($ad_id,$title) {	
    		$status = get_post_status( $ad_id );    		
    	?>
		<a href="<?php echo esc_url(get_permalink($ad_id)); ?>">
			<?php echo esc_attr( $title );?>
		</a>
		<?php if( $status === 'publish' ){ ?>
			<i class="fa fa-check-circle"></i>
		<?php }
		}
		add_action('listingo_get_ad_title', 'listingo_get_ad_title',10,2);
}

/**
 * @ad featured tag
 * @return {}
 */
if (!function_exists('listingo_get_ad_featured_tag')) {

    function listingo_get_ad_featured_tag($ad_id) {
		$featured_timestamp = get_post_meta($ad_id, '_featured_timestamp', true);
		$now	= current_time('mysql');
		if( !empty( $featured_timestamp ) && ( $featured_timestamp > strtotime( $now ) || $featured_timestamp == 1 ) ){?>
			<span class="tg-posttag"><i class="fa fa-bolt"></i></span>
		<?php }
	}
	add_action('listingo_get_ad_featured_tag', 'listingo_get_ad_featured_tag',10,1);
}

/**
 * @ad meta address
 * @return {}
 */
if (!function_exists('listingo_get_ad_category')) {

    function listingo_get_ad_category($ad_id,$type='action') {
		$sub_category = get_the_terms( $ad_id, 'ad_category' );
		if( !empty( $sub_category ) ){
			shuffle( $sub_category );
			$current_cat = array_slice( $sub_category, 0, 1 );
			$bg_color = fw_get_db_term_option($current_cat[0]->term_id, 'ad_category');
			if (!empty($bg_color['cat_color'])) {
				$bg_color = 'style=background:' . $bg_color['cat_color'];
			} else{
				$bg_color = '';
			}
			
			ob_start();
		?>
		<figcaption>
			<div class="tg-profilelink">
				<a <?php echo esc_attr($bg_color); ?> href="<?php echo get_term_link($current_cat[0]->term_id);?>"><?php echo esc_attr( $current_cat[0]->name );?></a>
			</div>
		</figcaption>
		<?php
			if( $type === 'filter' ){
				return ob_get_clean();
			} else{
				echo ob_get_clean();
			}
		}
	}
	add_action('listingo_get_ad_category', 'listingo_get_ad_category',10,2);
	add_filter('listingo_get_ad_category', 'listingo_get_ad_category',10,2);
}

/**
 * @ad meta address
 * @return {}
 */
if (!function_exists('listingo_print_favorite_ads')) {

    function listingo_print_favorite_ads($ad_id,$user_id) {
		global $current_user;
		$key		= 'favorite_ads';
		$wishlist = array();
		$wishlist 	= get_user_meta($current_user->ID, $key, true);
        $wishlist 	= !empty($wishlist) && is_array($wishlist) ? $wishlist : array();

		if (!empty($ad_id) && in_array($ad_id, $wishlist)) {
			echo '<div class="tg-like tg-liked"><i class="fa fa-heart"></i></div>';
		} else {
			echo '<div class="tg-like sp-save-ad" data-wl_id="' . $ad_id . '"><i class="fa fa-heart"></i></div>';
		}
	}
	add_action('listingo_print_favorite_ads', 'listingo_print_favorite_ads',10,2);
}


/**
 * @Update add to favorites
 * @return 
 */
if (!function_exists('listingo_save_favorite_ads')) {

    function listingo_save_favorite_ads() {
        global $current_user;
		$json = array();
		
		if( empty( $current_user->ID ) ){
			$json['type'] = 'success';
            $json['message'] = esc_html__('Please login, before add to your favorite ads', 'listingo');
            echo json_encode($json);
            die();
		}
		
	    $wishlist 	= array();
		$key		= 'favorite_ads';
        $wishlist 	= get_user_meta($current_user->ID, $key, true);
        $wishlist 	= !empty($wishlist) && is_array($wishlist) ? $wishlist : array();
        $wl_id 		= sanitize_text_field($_POST['wl_id']);
		$count 		= get_post_meta($wl_id, $key, true);
		$count 		= empty( $count ) ? 1 : $count = $count + 1;		
        if (!empty($wl_id)) {
			if( in_array($wl_id,$wishlist) ){
				$json['type'] = 'error';
	            $json['message'] = esc_html__('Already added to your favorite', 'listingo');
	            echo json_encode($json);
	            die();
			} else{
				//add to user meta
				$wishlist[] = $wl_id;
				$wishlist = array_unique($wishlist);
				update_user_meta($current_user->ID, $key, $wishlist);
				
				//update post meta
				update_post_meta($wl_id, $key, $count);
			}

            $json['type'] = 'success';
            $json['message'] = esc_html__('Successfully! added to your favorite', 'listingo');
            $json['total'] = $count;
            echo json_encode($json);
            die();
        }

        $json = array();
        $json['type'] = 'error';
        $json['message'] = esc_html__('Oops! something is going wrong.', 'listingo');
        echo json_encode($json);
        die();
    }

    add_action('wp_ajax_listingo_save_favorite_ads', 'listingo_save_favorite_ads');
    add_action('wp_ajax_nopriv_listingo_save_favorite_ads', 'listingo_save_favorite_ads');
}

/**
 * @delete favorites ad
 * @return 
 */
if (!function_exists('listingo_delete_favorite_ads')) {

    function listingo_delete_favorite_ads($ad_id) {
        global $current_user;
		$json = array();
		
		if( empty( $current_user->ID ) ){
			$json['type'] = 'success';
            $json['message'] = esc_html__('Please login, before add to your favorite ads', 'listingo');
            echo json_encode($json);
            die();
		}
		
	    $wishlist 	= array();
		$wl_id 		= array();
		$key		= 'favorite_ads';
        $wishlist 	= get_user_meta($current_user->ID, $key, true);
        $wishlist 	= !empty($wishlist) && is_array($wishlist) ? $wishlist : array();
        
		$ad_id 		= sanitize_text_field($_POST['id']);
		$type 		= sanitize_text_field($_POST['type']);
		
		$count 		= get_post_meta($ad_id, $key, true);
		if(!empty( $count ) ){
			$count--;
		}else{
			$count = 0;
		}
		
		if( $type === 'all' ){
			$emp_wishlist = array();
			update_user_meta($current_user->ID, $key, $emp_wishlist);
			
			//update post meta
			foreach( $wishlist  as $wkey => $value){
				$count 		= get_post_meta($value, $key, true);
				if(!empty( $count ) ){
					$count--;
				}else{
					$count = 0;
				}
				
				update_post_meta($value, $key, $count);
			}
			
			
			$json['type'] = 'success';
			$json['message'] = esc_html__('Successfully! All ads removed from your favorite', 'listingo');
			echo json_encode($json);
			die();
		} else{
			if (!empty($ad_id)) {
				//add to user meta
				$wl_id[] 	= $ad_id;
				$wishlist 	= array_diff($wishlist, $wl_id);
				update_user_meta($current_user->ID, $key, $wishlist);

				//update post meta
				update_post_meta($ad_id, $key, $count);
				
				$json['type'] = 'success';
				$json['message'] = esc_html__('Successfully! removed from your favorite', 'listingo');
				echo json_encode($json);
				die();
			}
		}
        

        $json = array();
        $json['type'] = 'error';
        $json['message'] = esc_html__('Oops! something is going wrong.', 'listingo');
        echo json_encode($json);
        die();
    }

    add_action('wp_ajax_listingo_delete_favorite_ads', 'listingo_delete_favorite_ads');
    add_action('wp_ajax_nopriv_listingo_delete_favorite_ads', 'listingo_delete_favorite_ads');
}

/**
 * @get social share v2
 * @return 
 */
if (!function_exists('listingo_get_social_share_v2')) {
	add_action('listingo_get_social_share_v2', 'listingo_get_social_share_v2',10,1);
    function listingo_get_social_share_v2($thumbnail) {
		?>
		<div class="tg-title">
			<h3>
				<span class="lnr lnr-link"></span>
				<?php esc_html_e('Social Share','listingo');?>
			</h3>
			<?php listingo_prepare_social_sharing(false,'', 'true', '', $thumbnail);?>
		</div>
		<?php
	}
}

/**
 * @get QR code
 * @return 
 */
if (!function_exists('listingo_get_ad_author_box')) {
	add_action('listingo_get_ad_author_box', 'listingo_get_ad_author_box',10,1);
    function listingo_get_ad_author_box($post_author_id) {
		$author_profile	= get_userdata( $post_author_id );
		$provider_name = listingo_get_username($post_author_id);
		$user_avatar = apply_filters(
				'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 370, 'height' => 270), $post_author_id), array('width' => 370, 'height' => 270) //size width,height
		);
		?>
		<div class="tg-asideauthor">
			<div class="tg-title">
				<h3><span class="lnr lnr-user"></span><?php esc_html_e('Ad Owner','listingo');?></h3>
			</div>
			<div class="tg-mountainlogo">
				<figure>
					<a target="_blank" href="<?php echo esc_url(get_author_posts_url($post_author_id)); ?>"><img src="<?php echo esc_url( $user_avatar );?>" alt="<?php echo esc_attr($provider_name);?>"></a>
				</figure>
			</div>
			<div class="tg-asideprofile">
				<div class="tg-featuredetails">
					<?php do_action('listingo_result_tags_v2', $post_author_id); ?>
					<div class="tg-title">
						<h2><a target="_blank" href="<?php echo esc_url(get_author_posts_url($post_author_id)); ?>"><?php echo esc_attr($provider_name);?></a></h2>
					</div>
					<?php do_action('sp_get_rating_and_votes', $post_author_id); ?>
					<ul class="tg-companycontactinfo">
						<?php do_action('listingo_get_user_meta','phone',$author_profile);?>
						<?php do_action('listingo_get_user_meta','email',$author_profile);?>
						<?php if (!empty($author_profile->fax)) { ?>
							<li>
								<i class="lnr lnr-printer"></i>
								<span><?php echo esc_attr($author_profile->fax); ?></span>
							</li>
						<?php } ?>
					</ul>
					<div class="tg-asidebutton">
						<a target="_blank"  class="tg-btn" href="<?php echo esc_url(get_author_posts_url($post_author_id)); ?>"><?php esc_html_e('View user profile','listingo');?></a>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

/**
 * @Add extra comment fields
 * @return html
 */
	if( !function_exists('listingo_comment_rating_field')){
		function listingo_comment_rating_field () {
			global $post;
			if( is_singular('sp_ads')){
			?>
			<div class="tg-box tg-review-info-holder">
				<div class="form-group">
					<div class="tg-reviewsinfo tg-reviewsinfovtwo">
						<h3><?php esc_html_e('Leave Your Rating:', 'listingo'); ?></h3>						
						<div class="counter"><?php esc_html_e('3', 'listingo'); ?>&nbsp;<?php esc_html_e('Stars', 'listingo'); ?></div>
						<div id="jRatevtwo" class="tg-ratingstar"></div>
						<input class="tg-star-rating" type="hidden" name="rating" value="3">
					</div>
				</div>
			</div>
			<div class="tg-box">
				<!-- Gallery -->
				<div class="tg-imggallerybox">
					<div class="tg-upload">
						<div class="tg-uploadhead">
							<span>
								<h3><?php esc_html_e('Upload Comment Gallery', 'listingo'); ?></h3>
								<i class="fa fa-exclamation-circle"></i>
							</span>
							<i class="lnr lnr-upload"></i>
						</div>
						<div class="tg-box">
							<label class="tg-fileuploadlabel" for="tg-photogallery">
								<div id="plupload-ad-comment-container">
									<a href="javascript:;" id="upload-ad-comment-photos" class="tg-fileinput sp-upload-container">
										<i class="lnr lnr-cloud-upload"></i>
										<span><?php esc_html_e('Or Drag Your Files Here To Upload', 'listingo'); ?></span>
									</a>
								</div> 
							</label>
							<div class="tg-ad-comment-gallery sp-profile-ad-photos">
								<div class="tg-galleryimages">
								</div>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" name="post-id" value="<?php echo esc_attr( $post->ID ); ?>">
				<script type="text/template" id="tmpl-load-comment-ad-thumb">
					<div class="tg-galleryimg tg-galleryimg-item">
						<figure>
							<img src="{{data.thumbnail}}">
							<figcaption>
								<i class="fa fa-close del-profile-ad-photo"></i>
							</figcaption>
							<input type="hidden" name="temp_items[]" value="{{data.name}}">
						</figure>
					</div>
				</script>
			</div>
			<?php
		}
		}
		add_action( 'comment_form_logged_in_after', 'listingo_comment_rating_field' );
		add_action( 'comment_form_after_fields', 'listingo_comment_rating_field' );
	}

/**
 * @Get the average rating of a post.
 * @return html
 */
	if( !function_exists('listingo_get_comment_average_ratings') ){
		function listingo_get_comment_average_ratings( $id ) {
			$comments = get_approved_comments( $id );
			if ( $comments ) {
				$i = 0;
				$total = 0;
				foreach( $comments as $comment ){
					$rate = get_comment_meta( $comment->comment_ID, 'rating', true );
					if( isset( $rate ) && '' !== $rate ) {
						$i++;
						$total += $rate;
					}
				}

				if ( 0 === $i ) {
					return false;
				} else {
				 	return round( $total / $i, 1 );					
				}
			} else {
				return false;
			}
		}
	}

/**
 * @Get the total rating of a post.
 * @return html
*/
	if( !function_exists('listingo_get_comment_total_ratings') ){
		function listingo_get_comment_total_ratings( $id ) {
			$comments = get_approved_comments( $id );		
			if ( $comments ) {
				$count = 0;
				foreach( $comments as $comment ){
					$count++;			
				}
				return $count;
			} else {
				return 0;
			}
		}
	}

/*
* Get open/close status
*/
if( !function_exists('listingo_get_ad_status')){
	function listingo_get_ad_status( $post_id = ''){
		if( !empty( $post_id ) ) {
			ob_start();
			$time_zone 			= get_post_meta( $post_id, '_timezone', true );	
			$time_details 		= get_post_meta( $post_id, '_time_details', true );						
			$post_author_id 	= get_post_field( 'post_author', $post_id );
			echo $default_timezone	= get_user_meta($post_author_id, 'default_timezone', true);
			
			if( !empty( $time_zone ) && $time_zone !== 'Select Time Zone'  )  {									
				$date = new DateTime("now", new DateTimeZone($time_zone) );
				$current_time_date = $date->format('Y-m-d H:i:s');					
			} elseif( !empty( $default_timezone ) && $time_zone !== 'Select Time Zone' )  {									
				$date = new DateTime("now", new DateTimeZone($default_timezone) );
				$current_time_date = $date->format('Y-m-d H:i:s');					
			} else {					  			  	
		  		$current_time_date = date("Y:m:d H:i:s", time());
			}	
			
		  	//Current Day	
		  	$today_day = date('l', strtotime($current_time_date));
		  	$today_day = strtolower($today_day);	
			
		  	//Current time based on GMT
		  	$today_time = date("H:i", strtotime($current_time_date)); 	
			
		  	//Convert to timestamp
		  	$current_time 	= strtotime($today_time);	
			
			// default status
			$status = esc_html__('Closed','listingo');
			$timestart = '';
			$timeclose = '';
			if( !empty( $time_details[$today_day]['starttime'] ) && !empty( $time_details[$today_day]['endtime'] ) ) {				
				$timestart = strtotime($time_details[$today_day]['starttime']);
				$timeclose = strtotime($time_details[$today_day]['endtime']);
			} 		
			
			if( ( $current_time >= $timestart ) && ( $current_time <= $timeclose ) ){			
				$status = esc_html__('Open','listingo');		
			} 			
			?>
			<span><?php echo esc_attr( $status );?></span>
			<?php
			echo ob_get_clean();
		} 
	}
	add_action('listingo_get_ad_status', 'listingo_get_ad_status', 10, 1);
}

/**
 * @get ad filters
 * @return html
 */
if (!function_exists('listingo_get_ads_search_filtrs')) {

    function listingo_get_ads_search_filtrs() {
		global $wp_query;
		
		$s_amenities	= !empty( $_GET['amenities'] ) ? $_GET['amenities'] : array();
		$s_tags			= !empty( $_GET['tags'] ) ? $_GET['tags'] : array();
		
		$amenities = get_terms( array(
			'taxonomy' => 'ad_amenity',
			'hide_empty' => false,
		) );
		
		$ad_tags = get_terms( array(
			'taxonomy' => 'ad_tags',
			'hide_empty' => false,
		) );

        ob_start();
        ?>
        <div class="tg-advancedlinkholder">
			<a href="javascript:;" class="tg-advancedlink"><?php esc_html_e('Advanced Search', 'listingo'); ?></a>
			<div class="tg-filtertype tg-haslayout" style="display: none;">				
				<div class="tg-advancedpopup">
					<div class="tg-advancedpopupholder">
						<div class="tg-narrowsearch">
							<div class="tg-narrowsearchhead">
								<div class="tg-title">
									<h3><?php esc_html_e('Narrow Your Search', 'listingo'); ?></h3>
								</div>
								<?php do_action('listingo_get_search_permalink_setting');?>
								<button class="tg-btn tg-btnvtwo" type="submit"><?php esc_html_e('Apply Filter', 'listingo'); ?></button>
							</div>
						</div>
						<div class="tg-filterdetails tg-themescrollbar">
							<div class="tg-themeform tg-filterform">
								<div class="tg-filterholder">
									<div class="tg-title"><h4><?php esc_html_e('Amenities', 'listingo'); ?> :</h4></div>
									<?php
									if( !empty( $amenities ) ){
										foreach( $amenities as $key => $term ){
											$slug	= $term->slug;
											$checked	= '';
											if( in_array($slug,$s_amenities) ){
												$checked	= 'checked';
											}
										?>
										<div class="tg-checkboxgroupvtwo">
											<span class="tg-checkboxvtwo">
												<input type="checkbox" <?php echo esc_attr( $checked );?> id="tag-<?php echo esc_attr( $slug );?>" name="amenities[]" value="<?php echo esc_attr( $slug );?>">
												<label for="tag-<?php echo esc_attr( $slug );?>"><?php echo esc_attr( $term->name );?></label>
											</span>
										</div>
									<?php }}?>
								</div>
								<div class="tg-filterholder tg-filterbg">
									<div class="tg-title"><h4><?php esc_html_e('Tags', 'listingo'); ?> :</h4></div>
									<?php
									if( !empty( $ad_tags ) ){
										foreach( $ad_tags as $key => $term ){
											$slug	= $term->slug;
											$checked	= '';
											if( in_array($slug,$s_tags) ){
												$checked	= 'checked';
											}
										?>
										<div class="tg-checkboxgroupvtwo">
											<span class="tg-checkboxvtwo">
												<input type="checkbox" <?php echo esc_attr( $checked );?> id="tag-<?php echo esc_attr( $slug );?>" name="tags[]" value="<?php echo esc_attr( $slug );?>">
												<label for="tag-<?php echo esc_attr( $slug );?>"><?php echo esc_attr( $term->name );?></label>
											</span>
										</div>
									<?php }}?>
								</div>
							</div>
						</div>
					</div>
				</div>
					
			</div>
		</div>

        <?php
        echo ob_get_clean();
	}
	
	add_action('listingo_get_ads_search_filtrs','listingo_get_ads_search_filtrs');
}

/**
 * @get orderby field
 * @return html
 */
if (!function_exists('listingo_get_ads_sortby')) {

    function listingo_get_ads_sortby() {
        ob_start();
		$sortby	= !empty($_GET['sortby']) ? $_GET['sortby'] : ''; 
        ?>
        <div class="tg-select">
            <select name="sortby" class="sp-sortby">
                <option value=""><?php esc_html_e('Sort By', 'listingo'); ?></option>
                <option value="none" <?php selected( $sortby, 'none',true); ?>><?php esc_html_e('none', 'listingo'); ?></option>
				<option value="ID" <?php selected( $sortby, 'ID',true); ?>><?php esc_html_e('Order by post id', 'listingo'); ?></option>
				<option value="author" <?php selected( $sortby, 'author',true); ?>><?php esc_html_e('Order by author', 'listingo'); ?></option>
				<option value="title" <?php selected( $sortby, 'title',true); ?>><?php esc_html_e('Order by title', 'listingo'); ?></option>
				<option value="name" <?php selected( $sortby, 'name',true); ?>><?php esc_html_e('Order by post name', 'listingo'); ?></option>
				<option value="date" <?php selected( $sortby, 'date',true); ?>><?php esc_html_e('Order by date', 'listingo'); ?></option>
				<option value="modified" <?php selected( $sortby, 'modified',true); ?>><?php esc_html_e('Order by last modified date', 'listingo'); ?></option>
				<option value="rand" <?php selected( $sortby, 'rand',true); ?>><?php esc_html_e('Random order', 'listingo'); ?></option>
            </select>
        </div>
        <?php
        echo ob_get_clean();
    }
	
    add_action('listingo_get_ads_sortby', 'listingo_get_ads_sortby');
}

/**
 * @get price types
 * @return html
 */
if (!function_exists('listingo_get_price_type')) {

    function listingo_get_price_type() {
        ob_start();
		$price_type		= !empty($_GET['price_type']) ? $_GET['price_type'] : ''; 
		$price_types	= apply_filters('listingo_get_price_type_list',listingo_ad_price_type());
		?>
		<div class="tg-select">
			<select name="price_type" class="sp-pricetype">
				<option value=""><?php esc_html_e('Price Type', 'listingo'); ?></option>
				<?php if( !empty( $price_types ) ) {
					foreach( $price_types as $key => $value ){?>
						<option <?php selected( $key, $price_type,true); ?> value="<?php echo esc_attr( $key );?>"><?php echo esc_attr($value['desc']); ?></option>
				<?php }}?>
			</select>
		</div>
		<?php
        echo ob_get_clean();
    }

    add_action('listingo_get_price_type', 'listingo_get_price_type');
}

/**
 * @get ad category filter
 * @return html
 */
if (!function_exists('listingo_get_ad_category_filter')) {

    function listingo_get_ad_category_filter() {
        ob_start();
		$category		= !empty($_GET['category']) ? $_GET['category'] : ''; 
		?>
		<div class="tg-select">
			<select name="category" class="sp-sub-categories">
				<option value=""><?php esc_html_e('Select categories', 'listingo'); ?></option>
				<?php listingo_get_term_options($category, 'ad_category'); ?>
			</select>
		</div>
		<?php
        echo ob_get_clean();
    }

    add_action('listingo_get_ad_category_filter', 'listingo_get_ad_category_filter');
}

/**
 * @Get DB Business Hours Settings
 * @return {}
 */
if (!function_exists('listingo_get_db_ad_business_settings')) {

    function listingo_get_db_ad_business_settings($post_id, $day_key) {
        global $wp_roles, $post;

        $business_hours = array();
        if (!empty($post_id)) {
           $business_hours = get_post_meta($post_id, '_time_details', true);
        }

        if (isset($business_hours[$day_key])) {
            return $business_hours[$day_key];
        } else {
             return array(
                'off_day' =>'',
				'starttime' =>'',
                'endtime' => ''
            );
        }
    }

}

/**
 * @Get Featured Ad selection
 * @return {}
 */
if( !function_exists('listingo_featured_ad_selection') ){
	function listingo_featured_ad_selection($user_id, $post_id = ''){
		if( !empty( $user_id ) ) {
			$remaining_ftd_ads 	 = listingo_get_subscription_meta('subscription_featured_ads', $user_id);			
			$remaining_ftd_ads   = !empty( $remaining_ftd_ads ) ? $remaining_ftd_ads : 0;	
			$selected 			 = ''; 
			
			if( !empty( $post_id ) ){
				$_featured_timestamp = get_post_meta($post_id, '_featured_timestamp', true);
					$current_time 	= time();	
					if( !empty( $_featured_timestamp ) && $_featured_timestamp > $current_time ) {									
						$selected = 'selected';
					}
			}			

			if( intval($remaining_ftd_ads) > 0 ){ 
				ob_start();
				?>
				<fieldset>						
					<div class="tg-dashboardbox tg-basicinformation">
						<h2><?php esc_html_e('Ad Type', 'listingo'); ?></h2>
						<div class="tg-amenitiesfeaturesbox">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
									<div class="form-group">
										<span class="tg-select">
											<select name="featured_ad" class="sp-sub-categories">
												<option value="standard" <?php echo esc_attr( $selected ); ?>><?php esc_html_e('Standard', 'listingo'); ?></option>
												<option value="featured" <?php echo esc_attr( $selected ); ?>><?php esc_html_e('Featured', 'listingo'); ?></option>
											</select>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</fieldset>	
				<?php 
			}
			echo ob_get_clean();		
		} 		
	}
	add_action('listingo_featured_ad_selection', 'listingo_featured_ad_selection', 10, 2);
}

/**
 * ad comments listings
 * @return slug
 */
if (!function_exists('listingo_ads_comments')) {

    function listingo_ads_comments($comment, $args, $depth) {
        global $post, $comment;
        $GLOBALS['comment'] = $comment;
        $args['reply_text'] = '<i class="fa fa-mail-reply"></i>';
        $like = 'like';
        $dislike = 'dislike';
        $total_likes        = get_comment_meta(get_comment_ID(), 'likes', true);       
        $total_dislikes     = get_comment_meta(get_comment_ID(), 'dislikes', true);
        $total_likes        = !empty( $total_likes ) ? $total_likes : 0;
        $total_dislikes     = !empty( $total_dislikes ) ? $total_dislikes : 0;    
        $gallery_files      = get_comment_meta( get_comment_ID(), 'gallery_files', true );
        $comment_author_id  = $comment ->user_id;                         
        ?>        
        <div class="tg-interviewprocess">     
        <figure><?php echo get_avatar($comment, 80); ?> </figure>
        <div class="tg-title">
            <h2><a href="<?php echo get_author_posts_url($comment_author_id); ?>">
                    <?php comment_author(); ?>
                </a>                            
            </h2>
            <span>
                <?php printf( _x( '%s Ago', '%s = human-readable time difference', 'listingo' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?>                            
            </span>  
        </div>
        <div class="tg-description">
            <?php if ($comment->comment_approved == '0') : ?>
                <p class="comment-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'listingo'); ?></p>
            <?php endif; ?>
            <?php comment_text(); ?>
        </div>
        <?php            
		if( !empty( $gallery_files ) ) { ?>
			<div class="tg-reviewsgallery">
				<?php                    
					$counter = 0;
					$more_class = '';
					foreach ($gallery_files as $value) {
						$width              = 170;
						$height             = 170; 
						$image              = listingo_prepare_image_source($value, $width, $height );
						$full_image         = wp_get_attachment_url( $value );        
						$counter++;
						if( $counter === 3){
							$more_class = 'tg-moreimgs';
						}
						if( $counter < 4 ){
						if( !empty( $image ) && !empty( $full_image ) ) {
				?>                        
					<figure class="<?php echo esc_attr( $more_class ); ?>">
							<?php if( $counter === 3){ ?>
								<img src="<?php echo esc_url( $image ); ?>">
								<figcaption>
									<a class="tg-comment-gallery spv-ag-gallery" href="<?php echo esc_url( $full_image ); ?>" data-rel="prettyPhoto<?php echo esc_attr( get_comment_ID() ); ?>[gallery]" rel="prettyPhoto<?php echo esc_attr( get_comment_ID() ); ?>[gallery]"><?php esc_html_e('View More', 'listingo'); ?></a>
								</figcaption>

							<?php } else { ?>
								<a class="spv-ag-gallery" href="<?php echo esc_url( $full_image ); ?>" data-rel="prettyPhoto<?php echo esc_attr( get_comment_ID() ); ?>[gallery]" rel="prettyPhoto<?php echo esc_attr( get_comment_ID() ); ?>[gallery]">
								<img src="<?php echo esc_url( $image ); ?>"></a>    
							<?php } ?>
						</a>
					</figure>
				<?php } } } ?>
			</div>
			<?php 
				$script = '
				jQuery("a[data-rel^=prettyPhoto'.get_comment_ID().']").prettyPhoto({
					animation_speed: "normal",
					theme: "dark_square",
					slideshow: 3000,
					autoplay_slideshow: false,
					social_tools: false
			});';                    
				wp_add_inline_script('listingo_callbacks', $script, 'after');
			?>              
		<?php } ?>
		<div class="tg-likebtns">
			<a href="javascript:;" class="tg-btnlikevtwo tg-add-ad-like" data-type="<?php echo esc_attr( $like ); ?>" data-id="<?php echo esc_attr( get_comment_ID() ); ?>" data-post="<?php echo esc_attr( $post->ID ); ?>"><i class="fa fa-thumbs-up">&nbsp;<?php echo esc_attr( $total_likes ); ?>&nbsp;</i> <?php esc_html_e('Likes', 'listingo'); ?></a>
			<a href="javascript:;" class="tg-btndislike tg-add-ad-like" data-type="<?php echo esc_attr( $dislike ); ?>" data-id="<?php echo esc_attr( get_comment_ID() ); ?>" data-post="<?php echo esc_attr( $post->ID ); ?>"><i class="fa fa-thumbs-down">&nbsp;<?php echo esc_attr( $total_dislikes ); ?>&nbsp;</i><?php esc_html_e('Dislikes', 'listingo'); ?></a>    
			</div>            
		</div>
	<?php   
	}

}
