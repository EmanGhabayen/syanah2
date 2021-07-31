<?php

if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}


$options = array(
	'api_settings' => array(
		'type' => 'tab',
		'title' => esc_html__( 'API Credentials', 'listingo' ),
		'options' => array(
			'mailchimp' => array(
				'title' => esc_html__( 'Mail Chimp', 'listingo' ),
				'type' => 'tab',
				'options' => array(
					'mailchimp_key' => array(
						'type' => 'text',
						'value' => 'e12c8ee5546cf3134b83f02b8b12702e-us11',
						'label' => esc_html__( 'MailChimp Key', 'listingo' ),
						'desc' => wp_kses( __( 'Get Api key From <a href="https://us11.admin.mailchimp.com/account/api/" target="_blank"> Get API KEY </a> <br/> You can create list <a href="https://us11.admin.mailchimp.com/lists/" target="_blank">here</a>', 'listingo' ), array(
							'a' => array(
								'href' => array(),
								'title' => array()
							),
							'br' => array(),
							'em' => array(),
							'strong' => array(),
						) ),
					),
					'mailchimp_list' => array(
						'type' => 'select',
						'label' => esc_html__( 'MailChimp List', 'listingo' ),
						'choices' => listingo_mailchimp_list(),
					)
				)
			),
			'google' => array(
				'title' => esc_html__( 'Google', 'listingo' ),
				'type' => 'tab',
				'options' => array(
					'google_key' => array(
						'type' => 'gmap-key',
						'value' => '',
						'label' => esc_html__( 'Google Map Key', 'listingo' ),
						'desc' => wp_kses( __( 'Enter google map key here. It will be used for google maps. Get and Api key From <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank"> Get API KEY </a>', 'listingo' ), array(
							'a' => array(
								'href' => array(),
								'title' => array()
							),
							'br' => array(),
							'em' => array(),
							'strong' => array(),
						) ),
					),
				)
			),
			'twiter' => array(
				'title' => esc_html__( 'Twitter', 'listingo' ),
				'type' => 'tab',
				'options' => array(
					'consumer_key' => array(
						'type' => 'text',
						'label' => esc_html__( 'Consumer Key', 'listingo' ),
						'desc' => esc_html__( 'Enter your Twitter Consumer Key Here.', 'listingo' ),
					),
					'consumer_secret' => array(
						'type' => 'text',
						'label' => esc_html__( 'Consumer Key Secret', 'listingo' ),
						'desc' => esc_html__( 'Enter Your Twitter Consumer Key Secret Here.', 'listingo' ),
					),
					'access_token' => array(
						'type' => 'text',
						'label' => esc_html__( 'Access Token', 'listingo' ),
						'desc' => esc_html__( 'Enter Your Twitter Access Token Here.', 'listingo' ),
					),
					'access_token_secret' => array(
						'type' => 'text',
						'label' => esc_html__( 'Access Token Secret', 'listingo' ),
						'desc' => esc_html__( 'Enter Your Access Token Secret Here.', 'listingo' ),
					),
				)
			),
		)
	)
);