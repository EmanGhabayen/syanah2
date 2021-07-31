<?php

/**
 *
 * Booking/Appointments Hooks
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
/**
 * @Add Time Slots
 * @return {}
 */
if (!function_exists('listingo_add_time_slots')) {

    function listingo_add_time_slots() {
        global $current_user, $wp_roles, $userdata;
        $user_identity = $current_user->ID;
		
		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
        if (empty($_POST['day'])) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('An error occurred, please try again later', 'listingo');
            echo json_encode($json);
            die;
        }

        $default_slots = array();
        $default_slots = get_user_meta($user_identity, 'default_slots', true);

        $day 			= sanitize_text_field($_POST['day']);
        $slot_title 	= sanitize_text_field($_POST['slot_title']);
        $start_time 	= sanitize_text_field($_POST['start_time']);
        $end_time 		= sanitize_text_field($_POST['end_time']);
        $meeting_time 	= sanitize_text_field($_POST['meeting_time']);
        $padding_time 	= sanitize_text_field($_POST['padding_time']);
        $count 			= sanitize_text_field($_POST['count']);

        if (empty($default_slots)): $default_slots = array();
        endif;

        do {

            $newStartTime = date("Hi", strtotime('+' . $meeting_time . ' minutes', strtotime($start_time)));

            if (!empty($default_slots[$day][$start_time . '-' . $newStartTime])) {
                $currentCount = $default_slots[$day][$start_time . '-' . $newStartTime];
            } else {
                $currentCount = 0;
            }

            $default_slots[$day][$start_time . '-' . $newStartTime] = $count + $currentCount;

            $default_slots[$day . '-details'][$start_time . '-' . $newStartTime]['slot_title'] = $slot_title;

            if ($padding_time):
                $time_to_add = $padding_time + $meeting_time;
            else :
                $time_to_add = $meeting_time;
            endif;

            $start_time = date("Hi", strtotime('+' . $time_to_add . ' minutes', strtotime($start_time)));
            if ($start_time == '0000'):
                $start_time = '2400';
            endif;
        } while ($start_time < $end_time);

        update_user_meta($user_identity, 'default_slots', $default_slots);


        $json['slots_data'] = listingo_get_default_slots($day, 'return');
        $json['message_type'] = 'success';
        $json['message'] = esc_html__('Slots added successfully.', 'listingo');
        echo json_encode($json);
        die;
    }

    add_action('wp_ajax_listingo_add_time_slots', 'listingo_add_time_slots');
    add_action('wp_ajax_nopriv_listingo_add_time_slots', 'listingo_add_time_slots');
}

/**
 * @Add Time Slots
 * @return {}
 */
if (!function_exists('listingo_delete_time_slot')) {

    function listingo_delete_time_slot() {
        global $current_user, $wp_roles, $userdata, $post;
        $user_identity = $current_user->ID;
		
		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
        if (empty($_POST['day']) ||
                empty($_POST['time'])
        ) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('An error occurred, please try again later', 'listingo');
            echo json_encode($json);
            die;
        }

        $day = sanitize_text_field($_POST['day']);
        $time = sanitize_text_field($_POST['time']);

        $default_slots = get_user_meta($user_identity, 'default_slots', true);

        if (isset($default_slots[$day][$time])) {
            unset($default_slots[$day][$time]);
            unset($default_slots[$day . '-details'][$time]);

            update_user_meta($user_identity, 'default_slots', $default_slots);

            $json['type'] = 'success';
            $json['message'] = esc_html__('Slot deleted succesfully.', 'listingo');
        } else {
            $json['type'] = 'error';
            $json['message'] = esc_html__('An error occurred, please try again later', 'listingo');
        }

        echo json_encode($json);
        die;
    }

    add_action('wp_ajax_listingo_delete_time_slot', 'listingo_delete_time_slot');
    add_action('wp_ajax_nopriv_listingo_delete_time_slot', 'listingo_delete_time_slot');
}

/**
 * @get Time slots
 * @return json
 */
if (!function_exists('listingo_appointment_time_slots')) {

    function listingo_appointment_time_slots() {
        $json = array();
        $time_slots_data = array();
        $do_check = check_ajax_referer('sp_appointment_settings_nonce', 'appointment-settings-update', false);
        if ($do_check == false) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('No kiddies please!', 'listingo');
            echo json_encode($json);
            die;
        }

        $author_id = esc_attr( $_REQUEST['author_id'] );
        $slot_date = esc_attr( $_REQUEST['slot_date'] );

        $time_slots_data = listingo_get_appointment_slots($author_id, $slot_date, 'return');

        if (!empty($time_slots_data)) {
            $json['type'] = 'success';
            $json['message'] = esc_html__('Time slots Found.', 'listingo');
            $json['slot_data'] = $time_slots_data;
            echo json_encode($json);
            die;
        } else {
            $json['type'] = 'error';
            $json['message'] = esc_html__('No time slots found.', 'listingo');
            echo json_encode($json);
            die;
        }
    }

    add_action('wp_ajax_listingo_appointment_time_slots', 'listingo_appointment_time_slots');
    add_action('wp_ajax_nopriv_listingo_appointment_time_slots', 'listingo_appointment_time_slots');
}

/**
 * @generate Appointment link
 * @retun {data}
 */
if (!function_exists('listingo_appointmnet_slot_link')) {

    function listingo_appointmnet_slot_link() {
        global $current_user;
        $json = array();
        $time_slot_link = '';
        $do_check = check_ajax_referer('sp_appointment_settings_nonce', 'appointment-settings-update', false);
        if ($do_check == false) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('No kiddies please!', 'listingo');
            echo json_encode($json);
            die;
        }
		
		do_action('listingo_is_action_allow'); //is action allow
		
        if (empty($_REQUEST['tg-timeslot'])) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Kindly choose the time slot first.', 'listingo');
            echo json_encode($json);
            die;
        }

        if (!empty($_REQUEST['tg-timeslot']) && !empty($_REQUEST['author_id'])) {
            $protocol = is_ssl() ? 'https' : 'http';

            $time_slot = $_REQUEST['tg-timeslot'];
            $slot_date = $_REQUEST['slot_date'];
            $author_id = $_REQUEST['author_id'];

            $merge_appointment_data = sprintf("%u%s%s%s%s", $author_id, '|', $time_slot, '|', $slot_date);
            $key_hash = md5(uniqid(openssl_random_pseudo_bytes(32)));

            $appointment_page = '';
            if (function_exists('fw_get_db_settings_option')) {
                $appointment_page = fw_get_db_settings_option('appointment_form_page', true);
            }

            if (empty($appointment_page[0])) {
                $json['type'] = 'error';
                $json['message'] = esc_html__('Please set the page first in directory settings.', 'listingo');
                echo json_encode($json);
                die;
            } else {
                $appt_page_slug = listingo_get_slug($appointment_page[0]);
            }

            $time_slot_link = esc_url(add_query_arg(array(
                'key' => $key_hash
                            ), home_url('/' . esc_attr($appt_page_slug) . '/', $protocol)));

            //Update appointmnet key in user logged in table.
            update_user_meta($current_user->ID, 'appointment_data', $merge_appointment_data);
            update_user_meta($current_user->ID, 'appointment_key', $key_hash);

            $json['type'] = 'success';
            $json['appointment_link'] = $time_slot_link;
            echo json_encode($json);
            die;
        }
    }

    add_action('wp_ajax_listingo_appointmnet_slot_link', 'listingo_appointmnet_slot_link');
    add_action('wp_ajax_nopriv_listingo_appointmnet_slot_link', 'listingo_appointmnet_slot_link');
}

/**
 * @Set appointment approval status
 * @return {status}
 */
if (!function_exists('listingo_set_appointment_approve')) {

    function listingo_set_appointment_approve() {
        global $current_user;
        $json = array();

		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
        if (!empty($_POST['post_id'])) {

            $post_status = array(
                'ID' => intval($_POST['post_id']),
                'post_status' => 'publish'
            );
            wp_update_post($post_status);

            if (class_exists('ListingoProcessEmail')) {
                $email_helper = new ListingoProcessEmail();
                $emailData = array();
                $emailData['post_id'] = intval($_POST['post_id']);
                $email_helper->process_appt_approval_email($emailData);
            }

            $json['type'] = 'success';
            $json['message'] = esc_html__('Appointment Approved', 'listingo');
            echo json_encode($json);
            die;
        }
    }

    add_action('wp_ajax_listingo_set_appointment_approve', 'listingo_set_appointment_approve');
    add_action('wp_ajax_nopriv_listingo_set_appointment_approve', 'listingo_set_appointment_approve');
}

/**
 * @Reject Appointment
 */
if (!function_exists('listingo_set_appointment_rejection')) {

    function listingo_set_appointment_rejection() {
        global $current_user;
        $json = array();
		
		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
        if (!empty($_POST['post_id'])) {

            $post_status = array(
                'ID' => intval($_POST['post_id']),
                'post_status' => 'trash'
            );
            wp_update_post($post_status);

            if (class_exists('ListingoProcessEmail')) {
                $email_helper = new ListingoProcessEmail();
                $emailData = array();
                $emailData['post_id'] = intval($_POST['post_id']);
                $emailData['rejection_title'] = esc_attr($_POST['rejection_title']);
                $emailData['rejection_reason'] = esc_attr($_POST['rejection_reason']);
                $email_helper->process_appt_rejection_email($emailData);
            }

            $json['type'] = 'success';
            $json['message'] = esc_html__('Appointment Rejected', 'listingo');
            echo json_encode($json);
            die;
        }
    }

    add_action('wp_ajax_listingo_set_appointment_rejection', 'listingo_set_appointment_rejection');
    add_action('wp_ajax_nopriv_listingo_set_appointment_rejection', 'listingo_set_appointment_rejection');
}

/**
 * @check settings for packages options
 * @return 
 */
if (!function_exists('listingo_get_booking_meta')) {

    function listingo_get_booking_meta($cart_items) {
		$cart_items	 = !empty( $cart_items ) ? $cart_items : array();
		
		$time_format = get_option('time_format');
		$date_format = get_option('date_format');
		
        $exclude	= array(
			'apt_services'	=> '',
			'apt_types'	=> '',
			'apt_reasons'	=> '',
			'apt_currency_symbol'	=> '',
			'price'	=> '',
			'apt_user_from'	=> '',
			'apt_user_to'	=> '',
			'apt_services'	=> '',
			'apt_price'	=> '',
			'payment_type'	=> '',
			'apt_admin_shares'	=> '',
			'apt_provider_shares'	=> '',
			'apt_number' => '',
		);
		
		if( !empty( $cart_items['apt_time'] ) ){
			$time = explode('-', $cart_items['apt_time']);
			$format_time = date($time_format, strtotime('2016-01-01 ' . $time[0])).'&nbsp;-&nbsp;'.date($time_format, strtotime('2016-01-01 ' . $time[1]));
			$cart_items['apt_time']	= $format_time;
		}
		
		if( !empty( $cart_items['apt_date'] ) ){
			$cart_items['apt_date']	= date($date_format, $cart_items['apt_date']);
		}

		$cart_items = array_replace(
									array_flip(
											array('apt_date', 'apt_time','title','apt_name','apt_mobile','apt_email','reason','type','apt_description')
									), $cart_items
								);
		
		return array_diff_key($cart_items,$exclude);
    }

    add_filter('listingo_get_booking_meta', 'listingo_get_booking_meta', 10, 2);
}

/**
 * @Proce paypal payment
 * @return 
 */
if (!function_exists('listingo_process_adaptive_payment')) {

    function listingo_process_adaptive_payment() {
        global $current_user;
		$json = array();
		
		if (!function_exists('listingo_process_paypal_payment')) {
			$json['type'] = 'error';
			$json['message'] = esc_html__('Oops! Listingo Core plugin is not upto date. Please contact to site administrator.', 'listingo');
			echo json_encode($json);
			die();
		}
		
		if( empty($_POST['type']) ){
			$json['type'] = 'success';
			$json['message'] = esc_html__('Please select payment gateway.', 'listingo');
			echo json_encode($json);
			die();
		}
		
		$type	= esc_attr( $_POST['gateway'] );
		
		$user_id		    = $current_user->ID;
		$sp_booking_cart	= get_user_meta($user_id, 'sp_booking_cart', true);
		$db_withdrawal 		= listingo_get_withdrawal_settings($sp_booking_cart['apt_user_to']);
		$bk_settings		= listingo_get_booking_settings();
		$currency			= get_woocommerce_currency();
		
		$sandbox 			= !empty($bk_settings['paypal_mode']) && $bk_settings['paypal_mode'] == 'sandbox' ? true : false;
		$paypal_app 		= !empty($bk_settings['paypal_app']) ? $bk_settings['paypal_app'] : '';
		$paypal_username 	= !empty($bk_settings['paypal_username']) ? $bk_settings['paypal_username'] : '';
		$paypal_password 	= !empty($bk_settings['paypal_password']) ? $bk_settings['paypal_password'] : '';
		$paypal_signature 	= !empty($bk_settings['paypal_signature']) ? $bk_settings['paypal_signature'] : '';
		$paypal_fee_by 		= !empty($bk_settings['paypal_fee']) ? $bk_settings['paypal_fee'] : '';
		$paypal_email 		= !empty($bk_settings['paypal_email']) ? $bk_settings['paypal_email'] : '';
		
		if( empty($paypal_app)
		   || empty($paypal_username)
		   || empty($paypal_password)
		   || empty($paypal_signature)
		   || empty($paypal_fee_by)
		   || empty($paypal_email)
		   || empty($currency)
		){
			$json['type'] = 'error';
			$json['message'] = esc_html__('An error occurred, Please contact to site administrator.', 'listingo');
			echo json_encode($json);
			die();
		}
		
		$paypal_listner_url	= '';
		if( class_exists( 'ListingoGlobalSettings' ) ) {
			$plugin_url	= ListingoGlobalSettings::get_plugin_url();
			$paypal_listner_url	   = $plugin_url. 'payment/paypal/order.php?bk_user_id='.$user_id;
		}

		$secondaryemail	= $db_withdrawal['paypal'];
		
		if( empty($secondaryemail) ){
			$json['type'] = 'error';
			$json['message'] = esc_html__('You can\'t make payment with this provider, Please contact to site administrator.', 'listingo');
			echo json_encode($json);
			die();
		}
		
		$Receivers = array();
		
		$receiver = array(
			'Amount'            => $sp_booking_cart['apt_price'],
			'Email'             => $paypal_email,	
			'InvoiceID' 		=> '', 
			'PaymentType' 		=> '', 
			'PaymentSubType' 	=> '', 
			'AccountID' 		=> '',
			'Phone' 			=> array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), 
			'Primary'           => 'true',
				
	    );
		
		array_push($Receivers,$receiver);
		
		$receiver = array(
			'Amount'            => $sp_booking_cart['apt_provider_shares'],
			'Email'             => $secondaryemail,
			'InvoiceID' 		=> '', 	
			'PaymentType' 		=> '', 
			'PaymentSubType' 	=> '', 
			'AccountID' 		=> '',
			'Phone' 			=> array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''),
			'Primary'           => 'false',
		);
		
		array_push($Receivers,$receiver);

		$user_page		= esc_url(get_author_posts_url($sp_booking_cart['apt_user_to']));

		$return_page = add_query_arg( array('status' => 'success'), $user_page );
		$cancel_url  = add_query_arg( array('status' => 'cancelled'), $user_page );

		try {
			
			$output = listingo_process_paypal_payment( $sandbox, $paypal_username,$paypal_password, $paypal_signature, $currency, $paypal_fee_by, $Receivers, $return_page, $paypal_listner_url, $paypal_app, $cancel_url);

			if($output['Ack'] == 'Success'){
				
				update_user_meta($user_id, 'booking_paykey',$output['PayKey']);
				
				$json['type'] 	 	= 'success';
				$json['checkout_url']   = $output['RedirectURL'];
				$json['message'] 		= esc_html__('Please wait while you are redireting to checkout.', 'listingo');
				echo json_encode($json);
				die();
				
			}else{
				$json['type'] = 'error';
				if( !empty( $output['Errors'][0]['Message'] ) ){
					$json['message'] = $output['Errors'][0]['Message'];
				} else{
					$json['message'] = esc_html__('An error occurred, please try again later', 'listingo');
				}
				echo json_encode($json);
				die();
			}
		} catch (Exception $e) {
			
			$json['type'] = 'error';
			$json['message'] = esc_html__('An error occurred, please try again later', 'listingo');
			echo json_encode($json);
			die();
		}

    }

    add_action('wp_ajax_listingo_process_adaptive_payment', 'listingo_process_adaptive_payment');
    add_action('wp_ajax_nopriv_listingo_process_adaptive_payment', 'listingo_process_adaptive_payment');
}