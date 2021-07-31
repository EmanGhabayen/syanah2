<?php

/**
 * @Woocommerce order hooks
 * return {}
 */
/**
 * @Check user role
 * @return 
 */
if (!function_exists('listingo_payment_complete')) {
    add_action('woocommerce_payment_complete', 'listingo_payment_complete');
	//add_action( 'woocommerce_order_status_completed','listingo_payment_complete' );
    function listingo_payment_complete($order_id) {
		global $current_user, $wpdb;
		
        $order = wc_get_order($order_id);
		$apt_meta_array	= array();
		
		$apt_prefix	= esc_html__( 'Order', 'listingo' );
		if (function_exists('fw_get_db_settings_option')) {
			$apt_prefix = fw_get_db_settings_option('appointment_no_prefix');
		}
		
        $user = $order->get_user();
        $items = $order->get_items();
        $offset = get_option('gmt_offset') * intval(60) * intval(60);
		
		$invoice_id = $apt_prefix . '-' . $order_id;

        foreach ($items as $key => $item) {
            $product_id = $item['product_id'];
            $product_qty = !empty($item['qty']) ? $item['qty'] : 1;

            if ($user) {
				
				$payment_type = wc_get_order_item_meta( $key, 'payment_type', true );
				if( !empty( $payment_type ) && $payment_type === 'booking' ){
					
					$appointment_no = $invoice_id;
					$appointment_form = wc_get_order_item_meta( $key, 'cus_woo_product_data', true );
					
					//Add Booking
					$appointment = array(
						'post_title' 	=> $appointment_no,
						'post_status' 	=> 'publish',
						'post_author' 	=> $user->ID,
						'post_type' 	=> 'sp_appointments',
						'post_date' 	=> current_time('Y-m-d h')
					);

					$post_id 	= wp_insert_post($appointment);
					$blogname 	= wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

					if (!empty($appointment_form)) {
						foreach ($appointment_form as $key => $apt_meta) {
							$apt_meta_array[$key] = $apt_meta;
						}
					}
					
					$apt_meta_array['apt_number'] 	= esc_attr($appointment_no);

					//Update post meta
					foreach ($apt_meta_array as $key => $value) {
						update_post_meta($post_id, $key, $value);
					}
					
					//array data
					update_post_meta($post_id, 'cus_appointment_data', $apt_meta_array);
					
					//Update earning table
					$earnings_table = $wpdb->prefix . 'sp_earnings';
					$earnings_data	 = array();
					
					$earnings_data['user_id'] 		= $apt_meta_array['apt_user_to'];
					$earnings_data['amount'] 		= $apt_meta_array['apt_provider_shares'];
					$earnings_data['order_id'] 		= $order_id;
					$earnings_data['appointment_id'] 		= $post_id;
					$earnings_data['process_date'] 			= current_time('mysql');
					$earnings_data['timestamp'] 			= time();
					$earnings_data['appointment_date'] 		= date('Y-m-d H:i:s',$apt_meta_array['apt_date']);
					$earnings_data['year'] 		= date('Y',$apt_meta_array['apt_date']);
					$earnings_data['month'] 	= date('m',$apt_meta_array['apt_date']);

					$wpdb->insert($earnings_table, $earnings_data);
					
					//Send Confirmation Mail
					if (class_exists('ListingoProcessEmail')) {
						//Send Email
						$email_helper = new ListingoProcessEmail();
						$emailData = array();
						$emailData['post_id'] = $post_id;
						$email_helper->process_appt_confirmation_email($emailData);
						$email_helper->process_appt_approval_email($emailData);
						$email_helper->process_appt_confirmation_email_from_admin($emailData);

						update_user_meta($user->ID, 'appointment_form_hash', '');
						update_user_meta($user->ID, 'appointment_key', '');
						update_user_meta($user->ID, 'appointment_data', '');
					}
					
				} else{
					$sp_duration = get_post_meta($product_id, 'sp_duration', true);
					$sp_featured = get_post_meta($product_id, 'sp_featured', true);
					$sp_jobs = get_post_meta($product_id, 'sp_jobs', true);
					$sp_appointments = get_post_meta($product_id, 'sp_appointments', true);
					$sp_banner = get_post_meta($product_id, 'sp_banner', true);
					$sp_insurance = get_post_meta($product_id, 'sp_insurance', true);
					$sp_favorites = get_post_meta($product_id, 'sp_favorites', true);
					$sp_teams = get_post_meta($product_id, 'sp_teams', true);
					$sp_hours = get_post_meta($product_id, 'sp_hours', true);
					$sp_page_design = get_post_meta($product_id, 'sp_page_design', true);
					$sp_articles = get_post_meta($product_id, 'sp_articles', true);
					
					$sp_gallery_photos  = get_post_meta($product_id, 'sp_gallery_photos', true);
					$sp_videos 			= get_post_meta($product_id, 'sp_videos', true);
					$sp_photos_limit    = get_post_meta($product_id, 'sp_photos_limit', true);
					$sp_banners_limit 	= get_post_meta($product_id, 'sp_banners_limit', true);
					$sp_contact_information 	= get_post_meta($product_id, 'sp_contact_information', true);
					$sp_chat = get_post_meta($product_id, 'sp_chat', true);

					//Ads data
					$sp_number_of_ads 	= get_post_meta($product_id, 'sp_ads_limit', true);
					$sp_number_of_featured_ads 	= get_post_meta($product_id, 'sp_featured_ads_limit', true);
					$sp_featured_ads_duration 	= get_post_meta($product_id, 'sp_featured_ads_duration', true);

					$current_date = current_time('mysql');

					$sp_jobs 	 		 = !empty($sp_jobs) ? $sp_jobs : 0;
					$sp_gallery_photos 	 = !empty($sp_gallery_photos) ? $sp_gallery_photos : 0;
					$sp_videos 			 = !empty($sp_videos) ? $sp_videos : 0;
					$sp_photos_limit 	 = !empty($sp_photos_limit) ? $sp_photos_limit : 0;
					$sp_banners_limit 	 = !empty($sp_banners_limit) ? $sp_banners_limit : 0;


					$provider_category = listingo_get_provider_category($user->ID);
					if( apply_filters('listingo_is_feature_allowed', $provider_category, 'articles') === true ){
						$sp_articles = !empty($sp_articles) ? $sp_articles : 0;
					} else{
						$sp_articles = 0;
					}

					$sp_duration = $sp_duration * $product_qty;
					$sp_featured = $sp_featured * $product_qty;
					$sp_number_of_ads = $sp_number_of_ads * $product_qty;
					$sp_number_of_featured_ads = $sp_number_of_featured_ads * $product_qty;
					$sp_featured_ads_duration = $sp_featured_ads_duration * $product_qty;
					$sp_jobs = $sp_jobs * $product_qty;

					$user_featured_date = listingo_get_subscription_meta('subscription_featured_expiry', $user->ID);
					$ad_featured_date = listingo_get_subscription_meta('subscription_ad_featured_expiry', $user->ID);

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
					if (!empty($ad_featured_date) && $ad_featured_date > strtotime($current_date)) {
						$duration = $sp_featured_ads_duration; //no of days for a featured listings
						if ($duration > 0) {
							$featured_ad_date = strtotime("+" . $duration . " days", $ad_featured_date);
							$featured_ad_date = date('Y-m-d H:i:s', $featured_ad_date);
						}
					} else {
						$duration = $sp_featured_ads_duration; //no of days for a featured 
						if ($duration > 0) {
							$featured_ad_date = strtotime("+" . $duration . " days", strtotime($current_date));
							$featured_ad_date = date('Y-m-d H:i:s', $featured_ad_date);
						}
					}

					//Package Expiry
					$package_expiry = current_time('mysql');
					$user_package_expiry = listingo_get_subscription_meta('subscription_expiry', $user->ID);

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

					$package_expiry 	= strtotime($package_expiry);
					$featured_date 		= strtotime($featured_date);
					$featured_ad_date 	= strtotime($featured_ad_date);
					
					if( $featured_date > strtotime($current_date) ){
						$is_featured	= 1;
					} else{
						$is_featured	= 0;
					}

					//update data
					$package_data = array(
						'subscription_id' 		=> $product_id,
						'subscription_expiry' 	=> $package_expiry,
						'subscription_featured_expiry' 		=> $featured_date,
						'is_featured' 						=> $is_featured,
						'subscription_jobs' 				=> intval($sp_jobs),
						'subscription_appointments' 		=> $sp_appointments,
						'subscription_profile_banner' 		=> $sp_banner,
						'subscription_insurance' 			=> $sp_insurance,
						'subscription_favorites' 			=> $sp_favorites,
						'subscription_teams' 				=> $sp_teams,
						'subscription_business_hours' 		=> $sp_hours,
						'subscription_page_design' 			=> $sp_page_design,
						'subscription_articles'  			=> $sp_articles,
						'subscription_gallery_photos'  		=> $sp_gallery_photos,
						'subscription_videos'  				=> $sp_videos,
						'subscription_photos_limit'  		=> $sp_photos_limit,
						'subscription_banners_limit'  		=> $sp_banners_limit,
						'subscription_contact_information'  => $sp_contact_information,		
						'subscription_ads'  				=> $sp_number_of_ads,
						'subscription_chat'  				=> $sp_chat,
						'subscription_featured_ads' 		=> $sp_number_of_featured_ads,
						'subscription_ad_featured_expiry'  	=> $featured_ad_date,
					);
					
					if (apply_filters('listingo_get_user_type', $current_user->ID) === 'customer' ) {
						$exclude = array('subscription_featured_expiry' => 'subscription_featured_expiry', 
										'is_featured' => 'is_featured', 
										'subscription_appointments' => 'subscription_appointments',
										'is_featured' => 'is_featured', 
										'subscription_profile_banner' => 'subscription_profile_banner', 
										'subscription_insurance' => 'subscription_insurance', 
										'subscription_teams' => 'subscription_teams', 
										'subscription_business_hours' => 'subscription_business_hours', 
										'subscription_page_design' => 'subscription_page_design', 
										'subscription_gallery_photos' => 'subscription_gallery_photos', 
										'subscription_articles' => 'subscription_articles', 
										'subscription_photos_limit' => 'subscription_photos_limit', 
										'subscription_videos' => 'subscription_videos', 
										'subscription_banners_limit' => 'subscription_banners_limit', 
										'subscription_contact_information' => 'subscription_contact_information', 
										'subscription_videos' => 'subscription_videos', 
										'subscription_videos' => 'subscription_videos', 
									  );
						
						$package_data	= array_diff_key($package_data, $exclude);
					}
						
					
					update_user_meta($user->ID, 'sp_subscription', $package_data);
					foreach ($package_data as $key => $value) {
						update_user_meta($user->ID, $key, $value);
					}
					
					if( $featured_date > strtotime($current_date) ){
						update_user_meta($user->ID, 'subscription_featured_expiry', 1);
					}
					
					//Prepare Email Data.
					$product = wc_get_product($product_id);
					$invoice_id = esc_html__('Order #','listingo') . '&nbsp;' . $order_id;
					$package_name = $product->get_title();
					$amount = $product->get_price();
					$status = $order->get_status();
					$method = $order->payment_method;
					$name 	= $order->billing_first_name . '&nbsp;' . $order->billing_last_name;

					//Get UTC Time Format
					$expiry_package_date = date('Y-m-d H:i:s', $package_expiry);

					//Get UTC Time Format
					$order_timestamp = strtotime($order->order_date);
					$order_local_timestamp = $order_timestamp;
					$order_date = date('Y-m-d H:i:s', $order_local_timestamp);

					$billing_address = $order->get_formatted_billing_address();
					$mail_to = $order->billing_email;


					//Send Invoice Email
					if (class_exists('ListingoProcessEmail')) {
						$email_helper = new ListingoProcessEmail();

						$emailData = array();
						$emailData['invoice_id'] 	= esc_attr($invoice_id);
						$emailData['mail_to'] 		= esc_attr($mail_to);
						$emailData['name'] 			= esc_attr($name);
						$emailData['package_name'] 	= esc_attr($package_name);
						$emailData['amount'] 		= esc_attr($amount);
						$emailData['status'] 		= esc_attr(ucwords($status));
						$emailData['method'] 		= esc_attr(ucwords($method));
						$emailData['date'] 			= esc_attr($order_date);
						$emailData['expiry'] 		= esc_attr($expiry_package_date);
						$emailData['address'] 		= force_balance_tags($billing_address);

						$email_helper->process_invoice_email($emailData);
					}
				}
            }
        }
    }
}

/**
 * @Update order meta
 * @return 
 */
if (!function_exists('listingo_woocommerce_checkout_update_order_meta')) {
	add_action('woocommerce_checkout_update_order_meta','listingo_woocommerce_checkout_update_order_meta',10,2);
	function listingo_woocommerce_checkout_update_order_meta( $order_id, $posted ) {
		global $wpdb;
		$order = wc_get_order($order_id);
		$payment_method	= $order->get_payment_method();
		$apt_meta_array	= array();
		
		if( !empty( $payment_method ) && ( $payment_method === 'cod' || $payment_method === 'cheque' || $payment_method === 'bacs' )  ){
			
			$apt_prefix	= esc_html__( 'Order', 'listingo' );
			if (function_exists('fw_get_db_settings_option')) {
				$apt_prefix = fw_get_db_settings_option('appointment_no_prefix');
			}

			$user 		= $order->get_user();
			$items 		= $order->get_items();
			$offset 	= get_option('gmt_offset') * intval(60) * intval(60);

			$invoice_id = $apt_prefix . '-' . $order_id;

			foreach ($items as $key => $item) {
				$product_id = $item['product_id'];
				$product_qty = !empty($item['qty']) ? $item['qty'] : 1;

				if ($user) {

					$payment_type = wc_get_order_item_meta( $key, 'payment_type', true );
					if( !empty( $payment_type ) && $payment_type === 'booking' ){

						$appointment_no = $invoice_id;
						$appointment_form = wc_get_order_item_meta( $key, 'cus_woo_product_data', true );

						//Add Booking
						$appointment = array(
							'post_title' 	=> $appointment_no,
							'post_status' 	=> 'pending',
							'post_author' 	=> $user->ID,
							'post_type' 	=> 'sp_appointments',
							'post_date' 	=> current_time('Y-m-d h')
						);

						$post_id 	= wp_insert_post($appointment);
						$blogname 	= wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

						if (!empty($appointment_form)) {
							foreach ($appointment_form as $key => $apt_meta) {
								$apt_meta_array[$key] = $apt_meta;
							}
						}

						$apt_meta_array['apt_number'] 	= esc_attr($appointment_no);

						//Update post meta
						foreach ($apt_meta_array as $key => $value) {
							update_post_meta($post_id, $key, $value);
						}

						//array data
						update_post_meta($post_id, 'cus_appointment_data', $apt_meta_array);

						//Update earning table
						$earnings_table  = $wpdb->prefix . 'sp_earnings';
						$earnings_data	 = array();

						$earnings_data['user_id'] 		= $apt_meta_array['apt_user_to'];
						$earnings_data['amount'] 		= $apt_meta_array['apt_provider_shares'];
						$earnings_data['order_id'] 		= $order_id;
						$earnings_data['appointment_id'] 		= $post_id;
						$earnings_data['process_date'] 			= current_time('mysql');
						$earnings_data['timestamp'] 			= time();
						$earnings_data['appointment_date'] 		= date('Y-m-d H:i:s',$apt_meta_array['apt_date']);
						$earnings_data['year'] 		= date('Y',$apt_meta_array['apt_date']);
						$earnings_data['month'] 	= date('m',$apt_meta_array['apt_date']);
						$wpdb->insert($earnings_table, $earnings_data);

						//Send Confirmation Mail
						if (class_exists('ListingoProcessEmail')) {
							//Send Email
							$email_helper = new ListingoProcessEmail();
							$emailData = array();
							$emailData['post_id'] = $post_id;
							$email_helper->process_appt_confirmation_email($emailData);
							$email_helper->process_appt_confirmation_email_from_admin($emailData);

							update_user_meta($user->ID, 'appointment_form_hash', '');
							update_user_meta($user->ID, 'appointment_key', '');
							update_user_meta($user->ID, 'appointment_data', '');
						}
					}
				}
			}
		}
	}
}

/**
 * @remove payment gateway
 * @return 
 */
if (!function_exists('listingo_unused_payment_gateways')) {
    //add_filter('woocommerce_payment_gateways', 'listingo_unused_payment_gateways', 20, 1);

    function listingo_unused_payment_gateways($load_gateways) {
        $remove_gateways = array(
            'WC_Gateway_BACS',
            'WC_Gateway_Cheque',
            'WC_Gateway_COD',
        );
        foreach ($load_gateways as $key => $value) {
            if (in_array($value, $remove_gateways)) {
                unset($load_gateways[$key]);
            }
        }
        return $load_gateways;
    }

}

/**
 * @remove product types
 * @return 
 */
if (!function_exists('listingo_remove_product_types')) {
    add_filter('product_type_selector', 'listingo_remove_product_types');

    function listingo_remove_product_types($types) {
        unset($types['grouped']);
        unset($types['external']);
        unset($types['variable']);

        return $types;
    }

}

/**
 * @remove tabs settings
 * @return 
 */
if (!function_exists('listingo_remove_product_setting_tabs')) {
    add_filter('woocommerce_product_data_tabs', 'listingo_remove_product_setting_tabs', 10, 1);

    function listingo_remove_product_setting_tabs($tabs) {
        unset($tabs['inventory']);
        unset($tabs['shipping']);
        unset($tabs['linked_product']);
        unset($tabs['attribute']);
        unset($tabs['advanced']);
        return($tabs);
    }

}

/**
 * @get subscription meta
 * @return 
 */
if (!function_exists('listingo_get_subscription_meta')) {

    function listingo_get_subscription_meta($key = '', $user_id) {
        $sp_subscription = get_user_meta($user_id, 'sp_subscription', true);      
		$current_date = current_time('mysql');
		
        if (is_array( $sp_subscription ) && !empty($sp_subscription[$key]) ) {
			
			if( apply_filters('listingo_is_listing_free', false,$user_id) === false ){
				if (!empty($sp_subscription['subscription_expiry']) && $sp_subscription['subscription_expiry'] > strtotime($current_date)) {
					return $sp_subscription[$key];
				} else{
					return '';
				}
			} else{
				return !empty( $sp_subscription[$key] ) ? $sp_subscription[$key] : '';
			} 
        }

        return '';
    }

}

/**
 * @get package meta
 * @return 
 */
if (!function_exists('listingo_get_package_features')) {

    function listingo_get_package_features($key='') {
        $features = array(
            'sp_package_type' 	=> esc_html__( 'Package Type?', 'listingo' ),
			'sp_duration' 		=> esc_html__( 'Package Duration', 'listingo' ), 
			'sp_featured' 		=> esc_html__( 'Featured duration', 'listingo' ), 
			'sp_jobs' 			=> esc_html__( 'Jobs included?', 'listingo' ), 
			'sp_ads' 			=> esc_html__( 'Ads included?', 'listingo' ), 
			'sp_featured_ads' 	=> esc_html__( 'Featured ads included?', 'listingo' ), 
			'sp_articles' 		=> esc_html__( 'Articles included?', 'listingo' ), 
			'sp_appointments' 	=> esc_html__( 'Appointments included?', 'listingo' ), 
			'sp_banner' 		=> esc_html__( 'Profile banner included?', 'listingo' ), 
			'sp_insurance' 		=> esc_html__( 'Insurance included?', 'listingo' ), 
			'sp_favorites' 		=> esc_html__( 'Favorites included?', 'listingo' ), 
			'sp_teams' 			=> esc_html__( 'Teams included?', 'listingo' ), 
			'sp_hours' 			=> esc_html__( 'Business hours included?', 'listingo' ),
			'sp_page_design' 	=> esc_html__( 'Page design options included?', 'listingo' ),
			'sp_gallery_photos' => esc_html__( 'Number of gallery photos?', 'listingo' ),
			'sp_videos' 		=> esc_html__( 'Number of video links?', 'listingo' ),
			'sp_contact_information' 		=> esc_html__( 'Contact informations included ( Phone and email )', 'listingo' ),
			'sp_photos_limit' => esc_html__( 'Number of profile photos?', 'listingo' ),
			'sp_banners_limit' 		=> esc_html__( 'Number of banner photos?', 'listingo' ),
			'apt_description' 	=> esc_html__( 'Message', 'listingo' ),
			'apt_name' 			=> esc_html__( 'Name', 'listingo' ),
			'apt_mobile' 		=> esc_html__( 'Phone', 'listingo' ),
			'apt_email' 		=> esc_html__( 'Email Address', 'listingo' ),
			'apt_location'  	=> esc_html__( 'Location', 'listingo' ),
			'title'  			=> esc_html__( 'Service', 'listingo' ),
			'reason' 			=> esc_html__( 'Booking Reason', 'listingo' ),
			'type' 				=> esc_html__( 'Booking Type', 'listingo' ),
			'apt_time'  		=> esc_html__( 'Booking Time', 'listingo' ),
			'apt_date'  		=> esc_html__( 'Booking Date', 'listingo' ),
			'apt_number'  		=> esc_html__( 'Appointment Number', 'listingo' ),
			'apt_admin_shares'  		=> esc_html__( 'Admin Shares', 'listingo' ),
			'apt_provider_shares'  		=> esc_html__( 'Provider Shares', 'listingo' ),		
			'sp_chat'  		=> esc_html__( 'Chat included?', 'listingo' ),
        );
		
		$features	= apply_filters('listingo_add_new_subscription_variables',$features);
		if( !empty( $features[$key] ) ){
			return $features[$key];
		} else{
			return '';
		}
    }
}

/**
 * @get package meta
 * @return 
 */
if (!function_exists('listingo_get_package_feature_value')) {

    function listingo_get_package_feature_value($key='') {
		if( isset( $key ) && $key === 'yes' ){
			$return	= '<i class="fa fa-check-circle sp-pk-allowed"></i>';
		} elseif( isset( $key ) && $key === 'no' ){
			$return	= '<i class="fa fa-times-circle sp-pk-not-allowed"></i>';
		} else{
			$return	= $key;
		}
		
		return $return;
	}
}

/**
 * @Display order detail t cgeckout page
 * @return 
 */
if (!function_exists('listingo_get_booking_title')) {
	function listingo_get_booking_title($cart_items,$default) {
		if( !empty( $cart_items['cart_data']['title'] ) ){
			$title	= $cart_items['cart_data']['title'];
		} else if( !empty( $cart_items['title'] ) ){
			$title	= $cart_items['title'];
		}else if( !empty( $cart_items['product_id'] ) ){
			$title	= get_the_title($cart_items['product_id']);
		} else{
			$title	= $default;
		}
		
		return $title;
	}
}

/**
 * @Display order detail t cgeckout page
 * @return 
 */
if (!function_exists('listingo_add_new_fields_checkout')) {
	add_filter( 'woocommerce_checkout_after_customer_details', 'listingo_add_new_fields_checkout', 10, 1 );
	function listingo_add_new_fields_checkout() {
		global $product,$woocommerce;
		$cart_data = WC()->session->get( 'cart', null );

		if( !empty( $cart_data ) ) {
			foreach( $cart_data as $key => $cart_items ){
				$quantity	= !empty( $cart_items['quantity'] ) ?  $cart_items['quantity'] : 1;

				if( !empty( $cart_items['cart_data'] ) ){
					
					if( !empty( $cart_items['payment_type'] ) && $cart_items['payment_type'] === 'booking' ){
						$cart_items['cart_data']	= apply_filters('listingo_get_booking_meta', $cart_items['cart_data']);					
					}
					
					$title	= listingo_get_booking_title($cart_items,'');
				?>
				<div class="col-md-12">
					<div class="cart-data-wrap">
					  <h3><?php echo esc_attr( $title );?>( <span class="cus-quantity">×<?php echo esc_attr( $quantity );?></span> )</h3>
					  <div class="selection-wrap">
						<?php 
							$counter	= 0;
							foreach( $cart_items['cart_data'] as $key => $value ){
								$counter++;
							?>
								<div class="cart-style"> 
									<span class="style-lable"><?php echo listingo_get_package_features($key);?></span> 
									<span class="style-name"><?php echo listingo_get_package_feature_value( $value );?></span> 
								</div>
							<?php }?>
					  </div>
					</div>
				 </div>	
				<?php
				}
			}
		}
	}
}

/**
 * @save into meta
 * @return 
 */
if (!function_exists('listingo_woo_convert_item_session_to_order_meta')) {
	add_action( 'woocommerce_add_order_item_meta', 'listingo_woo_convert_item_session_to_order_meta', 10, 3 ); //Save cart data
	function listingo_woo_convert_item_session_to_order_meta( $item_id, $values, $cart_item_key ) {
		$cart_key	= 'cart_data';
		$cart_type_key	= 'payment_type';
		$apt_admin_shares		= 'admin_shares';
		$apt_provider_shares	= 'provider_shares';
		
		$cart_item_data = listingo_woo_get_item_data( $cart_item_key,$cart_key );
		$cart_item_type = listingo_woo_get_item_data( $cart_item_key,$cart_type_key );
		$admin_shares = listingo_woo_get_item_data( $cart_item_key,$apt_admin_shares );
		$provider_shares = listingo_woo_get_item_data( $cart_item_key,$apt_provider_shares );
		
		// Add the array of all meta data to "_ld_woo_product_data". These are hidden, and cannot be seen or changed in the admin.
		
		if ( !empty( $cart_item_data ) ) {
			wc_add_order_item_meta( $item_id, 'cus_woo_product_data', $cart_item_data );
		}
		
		if ( !empty( $cart_item_type ) ) {
			wc_add_order_item_meta( $item_id, 'payment_type', $cart_item_type );
		}
		
		if( !empty( $admin_shares ) ){
			wc_add_order_item_meta( $item_id, 'admin_shares', $admin_shares );
		}
		
		if( !empty( $provider_shares ) ){
			wc_add_order_item_meta( $item_id, 'provider_shares', $provider_shares );
		}

	}
}

/**
 * get woo session data
 *
 */
if (!function_exists('listingo_woo_get_item_data')) {
	function listingo_woo_get_item_data( $cart_item_key, $key = null, $default = null ) {
		global $woocommerce;

		$data = (array)WC()->session->get( 'cart',$cart_item_key );
		if ( empty( $data[$cart_item_key] ) ) {
			$data[$cart_item_key] = array();
		}

		// If no key specified, return an array of all results.
		if ( $key == null ) {
			return $data[$cart_item_key] ? $data[$cart_item_key] : $default;
		}else{
			return empty( $data[$cart_item_key][$key] ) ? $default : $data[$cart_item_key][$key];
		}
	}
}


// Display order detail
if (!function_exists('listingo_display_order_data')) {
	add_action( 'woocommerce_thankyou', 'listingo_display_order_data', 20 ); 
	add_action( 'woocommerce_view_order', 'listingo_display_order_data', 20 );
	function listingo_display_order_data( $order_id ) {
		global $product,$woocommerce,$wpdb,$current_user;
		$dir_profile_page = '';
		if (function_exists('fw_get_db_settings_option')) {
			$dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
		}
		$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
		
		$order = new WC_Order( $order_id );
		$items = $order->get_items();
		if( !empty( $items ) ) {
			$counter	= 0;
			foreach( $items as $key => $order_item ){
				$counter++;
				$item_id    = $order_item['product_id'];
				$name		= !empty( $order_item['name'] ) ?  $order_item['name'] : '';
				$quantity	= !empty( $order_item['qty'] ) ?  $order_item['qty'] : 5;
				$order_detail = wc_get_order_item_meta( $key, 'cus_woo_product_data', true );
				$payment_type = wc_get_order_item_meta( $key, 'payment_type', true );
				
				if( !empty( $order_detail ) ) {
					
					if( !empty( $payment_type ) && $payment_type === 'booking' ){
						$order_detail	= apply_filters('listingo_get_booking_meta', $order_detail);					
					}

					$name	= listingo_get_booking_title($order_detail,$name);
					?>
					<div class="row">
						<div class="col-md-12">
							<div class="cart-data-wrap">
							  <h3><?php echo esc_attr($name);?>( <span class="cus-quantity">×<?php echo esc_attr( $quantity );?></span> )</h3>
							  <div class="selection-wrap">
								<?php 
									$counter	= 0;
									foreach( $order_detail as $key => $value ){
										$counter++;
									?>
										<div class="cart-style"> 
											<span class="style-lable"><?php echo listingo_get_package_features($key);?></span> 
											<span class="style-name"><?php echo listingo_get_package_feature_value( $value );?></span> 
										</div>
									<?php }?>
							  </div>
							</div>
						 </div>
						 <?php if( !empty( $current_user->ID ) ){?>
							 <div class="col-md-12">
								<a class="tg-btn" href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'dashboard', $current_user->ID); ?>"><?php esc_html_e('Return to dashboard','listingo');?></a>
							 </div>
						 <?php }?>	
					</div>
				<?php
				}
			}
		}
	}
}

 
/**
 *Print order meta at back-end in order detail page
 *
 * @since 1.0
*/
if (!function_exists('listingo_woo_order_meta')) {
	add_filter( 'woocommerce_after_order_itemmeta', 'listingo_woo_order_meta', 10, 3 );
	function listingo_woo_order_meta( $item_id, $item, $_product ) {
		global $product,$woocommerce,$wpdb;
		$order_detail = wc_get_order_item_meta( $item_id, 'cus_woo_product_data', true );
		
		$order_item = new WC_Order_Item_Product($item_id);
		$order	= $order_item->get_order();
		$order_status	= $order->get_status();
  		$customer_user = get_post_meta( $order->get_id(), '_customer_user', true );
		$sp_subscription = get_user_meta( $customer_user, 'sp_subscription', true );
		$payment_type = wc_get_order_item_meta( $item_id, 'payment_type', true );

		if( !empty( $payment_type ) && $payment_type === 'booking' ){
			$order_detail	= apply_filters('listingo_get_booking_meta', $order_detail);					
		}

		if( !empty( $order_detail ) ) {?>
			<div class="order-edit-wrap">
				<div class="view-order-detail">
					<a href="javascript:;" data-target="#cus-order-modal-<?php echo esc_attr( $item_id );?>" class="cus-open-modal cus-btn cus-btn-sm"><?php esc_html_e('View order detail?','listingo');?></a>
				</div>
				<div class="cus-modal" id="cus-order-modal-<?php echo esc_attr( $item_id );?>">
					<div class="cus-modal-dialog">
						<div class="cus-modal-content">
							<div class="cus-modal-header">
								<a href="javascript:;" data-target="#cus-order-modal-<?php echo esc_attr( $item_id );?>" class="cus-close-modal">×</a>
								<h4 class="cus-modal-title"><?php esc_html_e('Order Detail','listingo');?></h4>
							</div>
							<div class="cus-modal-body">
								<div class="sp-order-status">
									<p><?php echo ucwords( $order_status );?></p>
								</div>
								<?php if( !empty( $payment_type ) && $payment_type === 'subscription' ){?>
								<div class="cus-options-data sp-up">
									<label><span><?php esc_html_e('Upgrade Package','listingo');?></span></label>
									<div class="step-value">
										<span><a target="_blank" href="<?php echo get_edit_user_link( $customer_user ) ?>?#sp-pkgexpireyandcounter"><?php esc_html_e('Upgrade','listingo');?></a></span>
									</div>
								</div>
								<?php }?>
								<div class="cus-form cus-form-change-settings">
									<div class="edit-type-wrap">
										<?php 
										$counter	= 0;
										foreach( $order_detail as $key => $value ){
											$counter++;
										?>
										<div class="cus-options-data">
											<label><span><?php echo listingo_get_package_features($key);?></span></label>
											<div class="step-value">
												<span><?php echo listingo_get_package_feature_value( $value );?></span>
											</div>
										</div>
										<?php }?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php						
		}
	}
}


/**
 *Order Email
 * @since 1.0
 */
if (!function_exists('listingo_add_order_meta_email')) {
	//add_action( 'woocommerce_email_before_order_table', 'listingo_add_order_meta_email', 10, 2 );
	function listingo_add_order_meta_email( $order, $sent_to_admin ) {
		global $product,$woocommerce,$wpdb;
		$order_id	= $order->get_id();
		$order = new WC_Order( $order_id );
		$items = $order->get_items();			
		
		if( !empty( $items ) ) {
			$counter	= 0;
			foreach( $items as $key => $order_item ){
				$counter++;
				$item_id    = $order_item['product_id'];
				$name		= !empty( $order_item['name'] ) ?  $order_item['name'] : '';
				$quantity	= !empty( $order_item['qty'] ) ?  $order_item['qty'] : 1;
				$order_detail = wc_get_order_item_meta( $key, 'cus_woo_product_data', true );
				$payment_type = wc_get_order_item_meta( $key, 'payment_type', true );
				
				if( !empty( $order_detail ) ) {
					
					if( !empty( $payment_type ) && $payment_type === 'booking' ){
						$order_detail	= apply_filters('listingo_get_booking_meta', $order_detail);					
					}
					
					$name	= listingo_get_booking_title($order_detail,$name);
				?>
				<table class="cus-table" style="background:#fbfbfb; margin:auto 0; width:600px; border-spacing:0; border-radius: 3px;">
					<tbody>
						<tr style="text-align:left; border:0; line-height: 2.5; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
							<td scope="col" style="text-align:left; padding:0 15px; border:0; border-bottom:1px solid #ececec; line-height: 2.5; font-size: 20px; font-weight: bold;"><?php echo esc_attr($name);?>( <span class="cus-quantity">×<?php echo esc_attr( $quantity );?></span> )</td>
						</tr>
						<tr style="text-align:left; border:0; line-height: 2.5; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
							<td scope="col" style="text-align:left; padding:0 15px; border:0; border-bottom:1px solid #ececec; line-height: 2.5;"><strong><?php echo esc_html__('Order Detail','listingo');?></strong></td>
						</tr>
						<tr style="text-align:left; border:0; line-height: 2.5; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
							<td scope="col" style="text-align:left; padding:0 0; border:0; border-bottom:1px solid #ececec; line-height: 2.5;">
								<table style="width:100%; margin:0; border-spacing:0;">
									<tbody>
										<?php 
										$counter	= 0;
										foreach( $order_detail as $key => $value ){
											$counter++;
										?>
										<tr style="line-height: 2.5; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
											<td scope="col" style="width:50%; text-align:left; padding:0 15px; border:0; border-bottom:1px solid #ececec; border-right:1px solid #ececec; line-height: 2.5;"><?php echo listingo_get_package_features($key);?></td>
											<td scope="col" style="width:50%; text-align:left; padding:0 15px; border:0; border-bottom:1px solid #ececec; line-height: 2.5;"><?php echo esc_attr($value);?></td>
										</tr>
										<?php }?>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<?php 
				}
			}
		}
	}
}


/**
 * Remove item meta from email
 * @since 1.0
 */
if (!function_exists('listingo_filter_woocommerce_display_item_meta')) {
	function listingo_filter_woocommerce_display_item_meta( $html, $item, $args ) {
		// make filter magic happen here... 
		return ''; 
	}; 

	// add the filter 
	add_filter( 'woocommerce_display_item_meta', 'listingo_filter_woocommerce_display_item_meta', 10, 3 ); 
}

/**
 * Add product types for bookings
 * @since 1.0
 */
if (!function_exists('listingo_product_type_options')) {
	add_filter('product_type_options', 'listingo_product_type_options', 10, 1);
	function listingo_product_type_options( $options ) {
		$bk_settings	= listingo_get_booking_settings();

		if( isset( $bk_settings['is_enable'] ) && $bk_settings['is_enable'] === 'yes' ){
			$options['listingo_appointment'] = array(
				'id' => '_listingo_appointment',
				'wrapper_class' => 'show_if_simple show_if_variable',
				'label' => esc_html__('Book Appointments', 'listingo'),
				'description' => esc_html__('Book Appointment products will be use for booking/appointment payment', 'listingo'),
				'default' => 'no'
			);
		}

		return $options;
	}
}

/**
 * save product type
 * @since 1.0
 */
if (!function_exists('listingo_woocommerce_process_product_meta')) {
	add_action('woocommerce_process_product_meta_variable', 'listingo_woocommerce_process_product_meta', 10, 1);
	add_action('woocommerce_process_product_meta_simple', 'listingo_woocommerce_process_product_meta', 10, 1);
	function listingo_woocommerce_process_product_meta( $post_id ) {
		$bk_settings	= listingo_get_booking_settings();
		if( isset( $bk_settings['is_enable'] ) && $bk_settings['is_enable'] === 'yes' ){
			listingo_update_booking_product(); //update default booking product

			$is_listingo_appointment	= isset($_POST['_listingo_appointment']) ? 'yes' : 'no';
			update_post_meta($post_id, '_listingo_appointment', $is_listingo_appointment);
		}
	}
}

/**
 * price override
 * @since 1.0
 */
if (!function_exists('listingo_apply_custom_price_to_cart_item')) {
	
	add_action( 'woocommerce_before_calculate_totals', 'listingo_apply_custom_price_to_cart_item', 99 );
	function listingo_apply_custom_price_to_cart_item( $cart_object ) {  
		$bk_settings	= listingo_get_booking_settings();
		if( isset( $bk_settings['is_enable'] ) && $bk_settings['is_enable'] === 'yes' ){
			if( !WC()->session->__isset( "reload_checkout" )) {
				foreach ( $cart_object->cart_contents as $key => $value ) {
					$product = $value['data'];
					if( !empty( $value['payment_type'] ) && $value['payment_type'] == 'booking' ){
						if( isset( $value['cart_data']['price'] ) ){
							$bk_price = floatval( $value['cart_data']['price'] );
							$value['data']->set_price($bk_price);
						}

						if( isset( $value['cart_data']['apt_services'] ) ){
							$cart_items['cart_data']	= apply_filters('listingo_get_booking_meta', $value['cart_data']);
							$title	= listingo_get_booking_title($cart_items,'');
							
							if( method_exists( $product, 'set_name' ) ){
								$product->set_name( $title );
							} else {
								$product->post->post_title = $title;
							}
						}
					}
				}   
			}
		}
	}
}

/**
 * @Add http from URL
 * @return {}
 */
if (!function_exists('listingo_my_account_menu_items')) {
	add_filter( 'woocommerce_account_menu_items', 'listingo_my_account_menu_items' );
	function listingo_my_account_menu_items( $items ) {
		unset($items['dashboard']);
		unset($items['downloads']);
		unset($items['edit-address']);
		unset($items['payment-methods']);
		unset($items['edit-account']);
		return $items;
	}
}