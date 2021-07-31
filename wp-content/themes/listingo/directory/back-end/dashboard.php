<?php
/**
 * Dashboard backend
 *
 * @package Listingo
 * @since Listingo 1.0
 * @desc Template used for front end dashboard.
 */
/* Define Global Variables */

/**
 * @User Public Profile
 * @return {}
 */
if (!function_exists('listingo_edit_user_profile_edit')) {

    function listingo_edit_user_profile_edit($user) {
		
		if ( ( $user->roles[0] === 'professional' || $user->roles[0] === 'business' || $user->roles[0] === 'customer' ) ){
			$profile_settings	= listingo_profile_backend_settings();
			$profile_settings	= apply_filters('listingo_filter_profile_back_end_settings',$profile_settings);

			foreach( $profile_settings as $key => $value  ){
				get_template_part('directory/back-end/author-partials/template-author', $key);
			}
		}
	}
}


/**
 * @User Public Profile Save
 * @return {}
 */
if (!function_exists('listingo_personal_options_save')) {

    function listingo_personal_options_save($user_identity) {
        if ( current_user_can('edit_user',$user_identity) ) {
			$current_date	= current_time('mysql');

			$data = get_userdata($user_identity);
            if (isset($data->roles[0]) && !empty($data->roles[0]) &&
                    (( $data->roles[0] === 'business') 
					 || ($data->roles[0] === 'professional' )
					 || ($data->roles[0] === 'customer' )
					)
			) {
			
				//Avatar update
				$profile_avatar = !empty( $_POST['profile_avatar'] ) ? ( $_POST['profile_avatar'] ) : array();
				update_user_meta($user_identity, 'profile_avatar', $profile_avatar);

				if( !empty( $_POST['profile_avatar']['image_data'] ) ){
					update_user_meta($user_identity, 'is_avatar_available', 1);
				} else{
					update_user_meta($user_identity, 'is_avatar_available', 0);
				}
				
				//banner update
				$profile_gallery_photos = !empty( $_POST['profile_gallery_photos'] ) ? ( $_POST['profile_gallery_photos'] ) : array();
				update_user_meta($user_identity, 'profile_gallery_photos', $profile_gallery_photos);

				//gallery update
				$profile_banner_photos = !empty( $_POST['profile_banner_photos'] ) ? ( $_POST['profile_banner_photos'] ) : array();
				update_user_meta($user_identity, 'profile_banner_photos', $profile_banner_photos);

				//profile brochure update
				$profile_brochure = !empty( $_POST['profile_brochure'] ) ? ( $_POST['profile_brochure'] ) : '';
				update_user_meta($user_identity, 'profile_brochure', $profile_brochure);

				//professional statements
				$professional_statements = !empty( $_POST['professional_statements'] ) ? ( $_POST['professional_statements'] ) : '';
				update_user_meta($user_identity, 'professional_statements', $professional_statements);

				//update business hours
				if (!empty($_POST['schedules']) && is_array($_POST['schedules'])) {
					update_user_meta($user_identity, 'business_hours', $_POST['schedules'] );
				}

				update_user_meta($user_identity, 'business_hours_format', esc_attr( $_POST['time_format']) );

				/**
				 * Save Basic Information
				 */
				$first_name = '';
				$last_name = '';
				if (isset($_POST['basics']) && !empty($_POST['basics'])) {
					foreach ($_POST['basics'] as $key => $value) {
						update_user_meta($user_identity, $key, $value);
					}
				}

				/**
				 * Update User Name
				 */
				$username = listingo_get_username($user_identity);
				update_user_meta($user_identity, 'username', esc_attr($username));
				update_user_meta($user_identity, 'full_name', esc_attr($username));

				/**
				 * Save Profile Dashboard Languages
				 */
				if (!empty($_POST['languages'])) {
					update_user_meta($user_identity, 'profile_languages', ($_POST['languages']));
				}
				
				/**
				 * Save Profile Dashboard categories
				 */
				if (!empty($_POST['sub_category'])) {
					update_user_meta($user_identity, 'sub_category', ($_POST['sub_category']));
					$provider_category	= listingo_get_provider_category($user_identity);
					do_action('listingo_update_category_search',$provider_category,'category',$user_identity);
					do_action('listingo_update_category_search',$_POST['sub_category'],'sub_category',$user_identity);
				}
				
				/**
				 * Save Profile Dashboard Amenities
				 */
				if (!empty($_POST['amenities'])) {
					update_user_meta($user_identity, 'profile_amenities', ($_POST['amenities']));
				}

				/**
				 * Save Profile Dashboard insurance
				 */
				if (!empty($_POST['insurance'])) {
					update_user_meta($user_identity, 'profile_insurance', ($_POST['insurance']));
				} else{
					update_user_meta($user_identity, 'profile_insurance', array());
				}

				/**
				 * Save Audio/Video Links
				 */
				update_user_meta($user_identity, 'audio_video_urls', ($_POST['videos']));

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
							$awards[$counter]['date']  = !empty($value['date']) ? strtotime($value['date']) : '';
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
							$experience[$counter]['current']  	 = !empty( $value['current'] ) ? esc_attr($value['current']) : '';
							$experience[$counter]['title'] 		 = esc_attr($value['title']);
							$experience[$counter]['company'] 	 = esc_attr($value['company']);
							$experience[$counter]['start_date']  = !empty($value['start_date']) ? strtotime($value['start_date']) : '';
							$experience[$counter]['end_date']    = !empty($value['end_date']) ? strtotime($value['end_date']) : '';
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
							$qualification[$counter]['institute']   = esc_attr($value['institute']);
							$qualification[$counter]['start_date']  = !empty($value['start_date']) ? strtotime($value['start_date']) : '';
							$qualification[$counter]['end_date']    = !empty($value['end_date']) ? strtotime($value['end_date']) : '';
							$qualification[$counter]['description'] = esc_attr($value['description']);
							$counter++;
						}
					}
					$json['qualification'] = $qualification;
				}
				update_user_meta($user_identity, 'qualification', $qualification);


				//Get services meta
				$services_db = get_user_meta($user_identity, 'profile_services', true);

				/**
				 * Save Services
				 */
				$services = array();

				if (!empty($_POST['services'])) {

					foreach ($_POST['services'] as $key => $value) {
						$service_key = !empty( $value['title'] ) ? sanitize_title($value['title']) : '';;
						if (array_key_exists($key, $services_db)) {
							$service_key = $key;
						}

						$services[$service_key]['title'] = !empty( $value['title'] ) ? esc_attr($value['title']) : '';
						$services[$service_key]['price'] = !empty( $value['price'] ) ? esc_attr($value['price']) : '';
						$services[$service_key]['type']  = !empty( $value['type'] ) ? esc_attr($value['type']) : '';
						$services[$service_key]['description'] = !empty( $value['description'] ) ? esc_attr($value['description']) : '';
						$services[$service_key]['appointment'] = !empty( $value['appointment'] ) ? esc_attr($value['appointment']) : '';
						$services[$service_key]['freeservice'] = !empty( $value['freeservice'] ) ? esc_attr($value['freeservice']) : '';
					}
					$json['services'] = $services;
				}

				update_user_meta($user_identity, 'profile_services', $services);

				//Update Privacy settings
				update_user_meta($user_identity, 'privacy', listingo_sanitize_array($_POST['privacy']));

				//update privacy for search
				if (!empty($_POST['privacy']) && is_array($_POST['privacy'])) {
					foreach ($_POST['privacy'] as $key => $value) {
						update_user_meta($user_identity, esc_attr($key), esc_attr($value));
					}
				}
				do_action('listingo_do_update_profile_backend_settings',$_POST,$user_identity); //Developers Hook: action to update newly added data

			}

			$package_id			= listingo_get_subscription_meta('subscription_id',$user_identity);
			$updated_pack_id	= intval( $_POST['package_id'] );
			$offset 			= get_option('gmt_offset') * intval(60) * intval(60);

			if( empty( $updated_pack_id ) ){
				$subscription_expiry = listingo_get_subscription_meta('subscription_expiry', $user_identity);
				$subscription_featured_expiry = listingo_get_subscription_meta('subscription_featured_expiry', $user_identity);							
				$current_date = current_time('mysql');
				$current_date_string	= strtotime($current_date);
				$package_include	= !empty( $_POST['package_include'] ) ? intval( $_POST['package_include'] ) : '';
				$package_exclude	= !empty( $_POST['package_exclude'] ) ? intval( $_POST['package_exclude'] ) : '';
				$featured_include	= !empty( $_POST['featured_include'] ) ? intval( $_POST['featured_include'] ) : '';
				$featured_exclude	= !empty( $_POST['featured_exclude'] ) ? intval( $_POST['featured_exclude'] ) : '';

				if( !empty( $package_include )
				  	|| !empty( $package_exclude )
				    || !empty( $featured_include )
				    || !empty( $featured_exclude )
				) {
					//Package Update
					if( !empty( $package_include )  ){
						if( !empty( $subscription_expiry ) && $subscription_expiry > $current_date_string ){
							$subscription_expiry	= strtotime("+".$package_include." days", $subscription_expiry);
						} else{
							$subscription_expiry	= strtotime("+".$package_include." days", $current_date_string);
						}

					} else if( !empty( $package_exclude ) ){
						if( !empty( $subscription_expiry ) ){
							$subscription_expiry	= strtotime("-".$package_exclude." days", $subscription_expiry);
						}
					}

					//Feature Expiry Update
					if( !empty( $featured_include )  ){
						if( !empty( $subscription_featured_expiry ) && $subscription_featured_expiry > $current_date_string ){
							$subscription_featured_expiry	= strtotime("+".$featured_include." days", $subscription_featured_expiry);
						} else{
							$subscription_featured_expiry	= strtotime("+".$featured_include." days", $current_date_string);
						}
					} else if( !empty( $featured_exclude ) ){
						if( !empty( $subscription_featured_expiry ) ){
							$subscription_featured_expiry	= strtotime("-".$featured_exclude." days", $subscription_featured_expiry);
						}

					}		
					
					 $sp_subscription = get_user_meta($user_identity, 'sp_subscription', true);
					 $sp_subscription	=  !empty( $sp_subscription ) && is_array( $sp_subscription ) ? $sp_subscription : array();
					 $sp_subscription['subscription_expiry']			= $subscription_expiry;
					 $sp_subscription['subscription_featured_expiry']	= $subscription_featured_expiry;					
					 update_user_meta( $user_identity, 'sp_subscription', $sp_subscription );
					
					 foreach ($sp_subscription as $key => $value) {
						update_user_meta($user_identity, $key, $value);
					 }
					
					if( $subscription_featured_expiry > strtotime($current_date) ){
						update_user_meta($user_identity, 'subscription_featured_expiry', 1);
					}
					
				}
			} else if( !empty( $updated_pack_id ) ){

				$sp_duration = get_post_meta($updated_pack_id, 'sp_duration', true);
				$sp_featured = get_post_meta($updated_pack_id, 'sp_featured', true);
				$sp_jobs = get_post_meta($updated_pack_id, 'sp_jobs', true);
				$sp_appointments = get_post_meta($updated_pack_id, 'sp_appointments', true);
				$sp_banner = get_post_meta($updated_pack_id, 'sp_banner', true);
				$sp_insurance = get_post_meta($updated_pack_id, 'sp_insurance', true);
				$sp_favorites = get_post_meta($updated_pack_id, 'sp_favorites', true);
				$sp_teams = get_post_meta($updated_pack_id, 'sp_teams', true);
				$sp_hours = get_post_meta($updated_pack_id, 'sp_hours', true);
				$sp_articles = get_post_meta($updated_pack_id, 'sp_articles', true);
				$sp_page_design = get_post_meta($updated_pack_id, 'sp_page_design', true);
				$sp_gallery_photos = get_post_meta($updated_pack_id, 'sp_gallery_photos', true);
				$sp_videos 		= get_post_meta($updated_pack_id, 'sp_videos', true);
				$pk_sp_chat 	  = get_post_meta( $updated_pack_id, 'sp_chat', true );
				$sp_contact_information 		= get_post_meta($updated_pack_id, 'sp_contact_information', true);
				
				$sp_photos_limit 		= get_post_meta($updated_pack_id, 'sp_photos_limit', true);
				$sp_banners_limit 		= get_post_meta($updated_pack_id, 'sp_banners_limit', true);
								
				if ( function_exists('fw_get_db_settings_option') && fw_ext('ads')) {
					$sp_ads_limit = get_post_meta( $updated_pack_id, 'sp_ads_limit', true );
					$sp_featured_ads_limit = get_post_meta( $updated_pack_id, 'sp_featured_ads_limit', true );
					$sp_featured_ads_duration = get_post_meta( $updated_pack_id, 'sp_featured_ads_duration', true );
				}
				
				$sp_ads_limit 					= !empty($sp_ads_limit) ? $sp_ads_limit : 0;
				$sp_featured_ads_limit 			= !empty($sp_featured_ads_limit) ? $sp_featured_ads_limit : 0;					
				$sp_featured_ads_duration 		= !empty( $sp_featured_ads_duration ) ? $sp_featured_ads_duration : 0;

				$current_date = current_time('mysql');

				$sp_jobs 	 		= !empty($sp_jobs) ? $sp_jobs : 0;
				$sp_articles 		= !empty($sp_articles) ? $sp_articles : 0;
				$sp_gallery_photos  = !empty($sp_gallery_photos) ? $sp_gallery_photos : 0;
				$sp_videos 			= !empty($sp_videos) ? $sp_videos : 0;
				$sp_photos_limit 	= !empty($sp_photos_limit) ? $sp_photos_limit : 0;
				$sp_banners_limit 	= !empty($sp_banners_limit) ? $sp_banners_limit : 0;

				$user_featured_date = listingo_get_subscription_meta('subscription_featured_expiry', $user_identity);
				$user_featured_ad = listingo_get_subscription_meta('subscription_ad_featured_expiry', $user_identity);

				//Featured
				if (!empty($user_featured_date) && $user_featured_date > strtotime($current_date)) {
					$duration = $sp_featured; //no of days for a featured listings
					if ($duration > 0) {
						$featured_date = strtotime("+" . $duration . " days", $user_featured_date);
						$featured_date = date('Y-m-d H:i:s', $featured_date);
					}
				} else {
					$duration = $sp_featured; //no of days for a featured listings
					if ($duration > 0) {
						$featured_date = strtotime("+" . $duration . " days", strtotime($current_date));
						$featured_date = date('Y-m-d H:i:s', $featured_date);
					}
				}

				//Featured ad duration
				$featured_ad_date = 0;
				if (!empty($user_featured_ad) && $user_featured_ad > strtotime($current_date)) {
					$duration = $sp_featured_ads_duration; //no of days for a featured listings
					if ($duration > 0) {
						$featured_ad_date = strtotime("+" . $duration . " days", $user_featured_ad);
						$featured_ad_date = date('Y-m-d H:i:s', $featured_ad_date);
					}
				} else {
					$duration = $sp_featured_ads_duration; //no of days for a featured listings
					if ($duration > 0) {
						$featured_ad_date = strtotime("+" . $duration . " days", strtotime($current_date));
						$featured_ad_date = date('Y-m-d H:i:s', $featured_ad_date);
					}
				}

				//Package Expiry
				$package_expiry = current_time('mysql');
				$user_package_expiry = listingo_get_subscription_meta('subscription_expiry', $user_identity);

				if (!empty($user_package_expiry) && $user_package_expiry > strtotime($current_date)) {
					$package_duration = $sp_duration;
					if ($package_duration > 0) {
						$package_expiry = strtotime("+" . $package_duration . " days", $user_package_expiry);
						$package_expiry = date('Y-m-d H:i:s', $package_expiry);
					}
				} else {
					$current_date = current_time('mysql');
					$package_duration = $sp_duration;
					if ($package_duration > 0) {
						$package_expiry = strtotime("+" . $package_duration . " days", strtotime($current_date));
						$package_expiry = date('Y-m-d H:i:s', $package_expiry);
					}
				}
				
				//
				$package_expiry 	= strtotime($package_expiry);
				$featured_date  	= strtotime($featured_date);
				$featured_ad_date   = strtotime($featured_ad_date);
				
				if( $featured_date > strtotime($current_date) ){
					$is_featured	= 1;
				} else{
					$is_featured	= 0;
				}
	
				$package_data = array(
					'subscription_id' 				=> $updated_pack_id,
					'subscription_expiry' 			=> $package_expiry,
					'subscription_featured_expiry' 	=> $featured_date,
					'is_featured' 					=> $is_featured,
					'subscription_jobs' 			=> intval($sp_jobs),
					'subscription_appointments' 	=> $sp_appointments,
					'subscription_profile_banner' 	=> $sp_banner,
					'subscription_insurance' 		=> $sp_insurance,
					'subscription_favorites' 		=> $sp_favorites,
					'subscription_teams' 			=> $sp_teams,
					'subscription_business_hours' 	=> $sp_hours,
					'subscription_page_design' 		=> $sp_page_design,
					'subscription_articles'  		=> $sp_articles,
					'subscription_gallery_photos'  	=> $sp_gallery_photos,
					'subscription_videos'  			=> $sp_videos,
					'subscription_photos_limit'  	=> $sp_photos_limit,
					'subscription_banners_limit'  	=> $sp_banners_limit,
					'subscription_contact_information'  	=> $sp_contact_information,
					'subscription_ads'  					=> $sp_ads_limit,
					'subscription_featured_ads' 			=> $sp_featured_ads_limit,
					'subscription_ad_featured_expiry'  		=> $featured_ad_date,
					'subscription_chat'  					=> $pk_sp_chat,
				);
				
				$package_data	= apply_filters('listingo_add_subscription_meta',$package_data,$updated_pack_id);
				
				update_user_meta($user_identity, 'sp_subscription', $package_data);
				foreach ($package_data as $key => $value) {
					update_user_meta($user_identity, $key, $value);
				}
				
				if( $featured_date > strtotime($current_date) ){
					update_user_meta($user_identity, 'subscription_featured_expiry', 1);
				}
			}
		}
	}
}