<?php
/**
 * Add order from paypal adaptive
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://themeforest.net/user/themographics/portfolio
 * @since             1.0.0
 * @package           Listingo
 *
 */

$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once( $parse_uri[0] . 'wp-load.php' );

$payment_status	= '';
$status	= '';
$bk_user_id	= '';
$txnid	= '';

define("DEBUG", 1);
define("USE_SANDBOX", 1);
define("LOG_FILE", "./ipn.log");

$raw_post_data 		= file_get_contents('php://input');
$raw_post_array 	= explode('&', $raw_post_data);
$paypal_post_data   = array();
foreach ($raw_post_array as $keyval) {
	$keyval = explode ('=', $keyval);
	if (count($keyval) == 2)
		$paypal_post_data[$keyval[0]] = urldecode($keyval[1]);
}


$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
	$get_magic_quotes_exists = true;
}

foreach ($paypal_post_data as $key => $value) {
	if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
		$value = urlencode(stripslashes($value));
	} else {
		$value = urlencode($value);
	}
	
	//Paypal pay_key
	if($key == "pay_key"){
		$pay_key = $value;
	}
	
	//Paypal status
	if($key == "status"){
		$status = $value;
	}
	
	//Paypal transaction status
	if($key == "transaction%5B0%5D.status"){
		$payment_status = $value;
	}
	
	//Paypal custom ID
	if($key == "bk_user_id"){
		$bk_user_id = $value;
	}

	$req .= "&$key=$value";
}


$bk_user_id = !empty($_GET['bk_user_id']) ? intval($_GET['bk_user_id']) : '';

$db_pay_key 		= get_user_meta($bk_user_id, 'booking_paykey', true);
$sp_booking_cart	= get_user_meta($bk_user_id, 'sp_booking_cart', true);

if( $payment_status == "Completed" 
    && $status == "COMPLETED" 
    && !empty( $bk_user_id ) 
    && !empty( $db_pay_key ) 
    && $db_pay_key === $pay_key 
 ){

	$apt_meta_array	= array();

	// Set data
	$address = listingo_get_user_billing_address($bk_user_id);
	$product_id 			= listingo_get_booking_product_id();
	$new_product_price 		= $sp_booking_cart['apt_price']; // the new product price  <==== <==== <====
	$quantity 				= 1; // The line item quantity

	$product 				= wc_get_product( $product_id );
	$product->set_price( $new_product_price );

	// Create the order
	$order 			= wc_create_order();
	$invoice_id		= $order->get_id();
	
	$apt_prefix	= esc_html__( 'Order', 'listingo_core' );
	if (function_exists('fw_get_db_settings_option')) {
		$apt_prefix = fw_get_db_settings_option('appointment_no_prefix');
	}
	
	$appointment_no = $apt_prefix . '-' . $invoice_id;
	
	// Add the product to the order
	$order->add_product( $product, $quantity);
	$order->set_address( $address, 'billing' );

	## You will need to add customer data, tax line item  ##

	$order->calculate_totals(); // updating totals
	//$order->update_status("Completed", 'Imported order', TRUE);
	$order->update_status( 'completed' );
	$order->payment_complete();

	$items = $order->get_items();
	foreach ( $items as $key => $item ) {
		wc_add_order_item_meta( $key, 'payment_type', 'booking' );
		wc_add_order_item_meta( $key, 'cus_woo_product_data', $sp_booking_cart );
	}
	
	//Add Booking
	$appointment = array(
		'post_title' 	=> $appointment_no,
		'post_status' 	=> 'publish',
		'post_author' 	=> $bk_user_id,
		'post_type' 	=> 'sp_appointments',
		'post_date' 	=> current_time('Y-m-d h')
	);

	$post_id 	= wp_insert_post($appointment);
	$blogname 	= wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	if (!empty($sp_booking_cart)) {
		foreach ($sp_booking_cart as $key => $apt_meta) {
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
	
	$payment_method 		= 'paypal';
	$payment_method_title   = esc_html__('PayPal','listingo_core');

	update_post_meta( $order->get_id(), '_payment_method', $payment_method );
	update_post_meta( $order->get_id(), '_payment_method_title', $payment_method_title );
	
	//Send Confirmation Mail
	if (class_exists('ListingoProcessEmail')) {
		//Send Email
		$email_helper = new ListingoProcessEmail();
		$emailData = array();
		$emailData['post_id'] = $post_id;
		$email_helper->process_appt_confirmation_email($emailData);
		$email_helper->process_appt_confirmation_email_from_admin($emailData);

		update_user_meta($bk_user_id, 'appointment_form_hash', '');
		update_user_meta($bk_user_id, 'appointment_key', '');
		update_user_meta($bk_user_id, 'appointment_data', '');
	}
	
	$order->save(); // Save the order data

	// create a new checkout instance and order id
	/*$checkout = new WC_Checkout();
	$this_order_id = $checkout->create_order();
	$order = new WC_Order($this_order_id);
	$order->update_status('completed');*/
	// 4 x $10 simple helper product
	error_log($req, 3, LOG_FILE);
}
