<?php
/**
 * Get response from PayPal
 *
 *
 * @link              https://themeforest.net/user/themographics/portfolio
 * @since             1.0.0
 * @package           Listingo
 *
 */

if( !function_exists('listingo_process_paypal_payment') ){
	function listingo_process_paypal_payment( $sandbox, $paypal_username, $paypal_password, $paypal_signature, $currency, $payer_fee, $receivers, $return_page, $ipn_page, $appid, $cancel_url = '' ) { 	 
		
		// Create PayPal object. 	
		$PayPalConfig = array( 		
			'Sandbox' 				=> $sandbox, 
			'DeveloperAccountEmail' => '', 
			'ApplicationID' 		=> $appid, 
			'DeviceID' 				=> '', 
			'IPAddress' 			=> $_SERVER['REMOTE_ADDR'], 
			'APIUsername' 			=> $paypal_username, 
			'APIPassword' 			=> $paypal_password, 
			'APISignature' 			=> $paypal_signature, 
			'APISubject'			=> ''
		);
		
		
		$PayPal = new angelleye\PayPal\Adaptive($PayPalConfig);
		
		// Prepare request arrays
		$PayRequestFields = array(
			'ActionType' 		=> 'PAY', 
			'CancelURL' 		=> $cancel_url, 	
			'CurrencyCode' 		=> $currency, 	
			'FeesPayer' 		=> $payer_fee, 			
			'IPNNotificationURL'=> $ipn_page, 	
			'Memo' 				=> '', 	
			'Pin' 				=> '', 	
			'PreapprovalKey' 	=> '', 
			'ReturnURL' 		=> $return_page, 
			'ReverseAllParallelPaymentsOnError' => '', 
			'SenderEmail' 		=> '',           
			'TrackingID' 		=> ''	
		);

		$ClientDetailsFields = array(
			'CustomerID' 		=> '', 		
			'CustomerType' 		=> '', 				
			'GeoLocation' 		=> '', 		
			'Model' 			=> '', 				
			'PartnerName'		=> 'Always Give Back'
		);

		$FundingTypes = array('ECHECK', 'BALANCE', 'CREDITCARD');

		$SenderIdentifierFields = array(
			'UseCredentials' => ''			
		);

		$AccountIdentifierFields = array(
			'Email' => '', 			
			'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => '')	
		);

		$PayPalRequestData = array(
			'PayRequestFields' 			=> $PayRequestFields, 
			'ClientDetailsFields' 		=> $ClientDetailsFields, 
			'Receivers' 				=> $receivers, 
			'SenderIdentifierFields' 	=> $SenderIdentifierFields, 
			'AccountIdentifierFields' 	=> $AccountIdentifierFields
		);
		
		$PayPalResult = $PayPal->Pay($PayPalRequestData);
		return $PayPalResult;
	}
}
