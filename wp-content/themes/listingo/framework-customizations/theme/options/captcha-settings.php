<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'captcha' => array(
		'title'   => esc_html__( 'reCaptcha Security', 'listingo' ),
		'type'    => 'tab',
		'options' => array(
			'general-box' => array(
				'title'   => esc_html__( 'reCaptcha Settings', 'listingo' ),
				'type'    => 'box',
				'options' => array(
					'captcha_settings' => array(
						'type'  => 'switch',
						'value' => 'disable',
						'label' => esc_html__('Enable reCaptcha', 'listingo'),
						'desc' => wp_kses( __( 'Secure your forms with <a href="https://www.google.com/recaptcha/admin" target="_blank"> reCapthca </a> To use reCaptcha you must obtain a free API key for your domain. To obtain one, visit: <a href="https://www.google.com/recaptcha/admin" target="_blank">Here</a>', 'listingo' ),array(
																		'a' => array(
																			'href' => array(),
																			'title' => array()
																		),
																		'br' => array(),
																		'em' => array(),
																		'strong' => array(),
																	)),
						'left-choice' => array(
							'value' => 'enable',
							'label' => esc_html__('Enable', 'listingo'),
						),
						'right-choice' => array(
							'value' => 'disable',
							'label' => esc_html__('Disable', 'listingo'),
						),
					),
					'site_key' => array(
                        'type' => 'text',
                        'value' => '',
                        'label' => esc_html__('Site Key', 'listingo'),
                        'desc' => esc_html__('Enter Site key here.', 'listingo'),
                    ),
					'secret_key' => array(
                        'type' => 'text',
                        'value' => '',
                        'label' => esc_html__('Secret Key', 'listingo'),
                        'desc' => esc_html__('Enter Secret key here.', 'listingo'),
                    ),
					'language_code' => array(
                        'type' => 'text',
                        'value' => 'en',
                        'label' => esc_html__('Add Language Code', 'listingo'),
                        'desc' => esc_html__('Add language code here. eg en.', 'listingo'),
						'desc' => wp_kses( __( 'Add language code here. eg en. Please type your language code <a href="https://developers.google.com/recaptcha/docs/language" target="_blank"> Get Code </a>', 'listingo' ),array(
																		'a' => array(
																			'href' => array(),
																			'title' => array()
																		),
																		'br' => array(),
																		'em' => array(),
																		'strong' => array(),
																	)),
                    ),
					
				)
			),
		)
	)
);