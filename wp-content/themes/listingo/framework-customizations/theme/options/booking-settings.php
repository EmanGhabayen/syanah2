<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array(
    'bookings-settings' => array(
        'title' => esc_html__('Booking Settings', 'listingo'),
        'type' => 'tab',
        'options' => array(
            'booking-box' => array(
                'title' => esc_html__('Booking Settings', 'listingo'),
                'type' => 'box',
                'options' => array(
                    'booking_settings' => array(
                        'type' => 'multi-picker',
                        'label' => false,
                        'desc' => '',
                        'picker' => array(
                            'gadget' => array(
                                'type' => 'switch',
                                'value' => 'disable',
                                'attr' => array(),
                                'label' => esc_html__('Booking Payments?', 'listingo'),
                                'desc' => esc_html__('Enable/Disable Booking online payments.', 'listingo'),
                                'left-choice' => array(
                                    'value' => 'disable',
                                    'label' => esc_html__('Disable', 'listingo'),
                                ),
                                'right-choice' => array(
                                    'value' => 'enable',
                                    'label' => esc_html__('Enable', 'listingo'),
                                ),
                            )
                        ),
                        'choices' => array(
                            'enable' => array(
                                'pay' => array(
									'type' => 'multi-picker',
									'label' => false,
									'desc' => '',
									'picker' => array(
										'type' => array(
											'label' => esc_html__('Payments type', 'listingo'),
											'type' => 'select',
											'value' => 'no-repeat',
											'desc' => esc_html__('Select your payment process.', 'listingo'),
											'help' => esc_html__('', 'listingo'),
											'choices' => array(
												'woo' => esc_html__('WooCommerce', 'listingo'),
												'adaptive' => esc_html__('Custom: Adaptive Payments', 'listingo'),
											),
										),
									),
									'choices' => array(
										'woo' => array(
											'min_amount' => array(
												'type' => 'text',
												'label' => esc_html__('Minimum Amount', 'listingo'),
												'desc' => esc_html__('Add minimum amount to process wallet.', 'listingo'),
											),
											'hide_wallet' => array(
												'type' => 'switch',
												'value' => 'no',
												'attr' => array(),
												'label' => esc_html__('Hide wallet?', 'listingo'),
												'desc' => esc_html__('Hide or show wallet system from users dashboard and from admin side. Payments will work as it is but wallet system will not display in users dashboard.', 'listingo'),
												'left-choice' => array(
													'value' => 'yes',
													'label' => esc_html__('Yes', 'listingo'),
												),
												'right-choice' => array(
													'value' => 'no',
													'label' => esc_html__('No', 'listingo'),
												),
											)
										),
										'adaptive' => array(
											'paypal_hint' => array(
												'type' => 'html',
												'html' => esc_html__('Adaptive Payments Settings', 'listingo'),
												'label' => esc_html__('', 'listingo'),
												'desc' => esc_html__('Adaptive Payments is supporte now. In adaptive payments commission will be transferred to admin and other payment will be directly transferred to provider account.', 'listingo'),
												'help' => esc_html__('', 'listingo'),
												'images_only' => true,
											),
											'paypal_app' => array(
												'type' => 'text',
												'label' => esc_html__('PayPal APP ID', 'listingo'),
												'desc' => esc_html__('Add PayPal APP ID here', 'listingo'),
											),
											'paypal_email' => array(
												'type' => 'text',
												'label' => esc_html__('PayPal email ID', 'listingo'),
												'desc' => esc_html__('Add PayPal email ID here', 'listingo'),
											),
											'paypal_fee' => array(
												'label' => esc_html__('Fees by?', 'listingo'),
												'type' => 'select',
												'value' => 'PRIMARYRECEIVER',
												'attr' => array(),
												'desc' => esc_html__('Either admin will pay PayPal fees or both provider and admin.', 'listingo'),
												'help' => esc_html__('', 'listingo'),
												'choices' => array(
													'PRIMARYRECEIVER' => esc_html__('Admin', 'listingo'),
													'EACHRECEIVER' => esc_html__('Both provider and admin', 'listingo'),
												),
											),
											'paypal_mode' => array(
												'label' => esc_html__('PayPal Enviroment?', 'listingo'),
												'type' => 'select',
												'value' => 'sandbox',
												'attr' => array(),
												'desc' => esc_html__('', 'listingo'),
												'help' => esc_html__('', 'listingo'),
												'choices' => array(
													'sandbox' => esc_html__('Sandbox', 'listingo'),
													'live' => esc_html__('Live', 'listingo'),
												),
											),
											'paypal_username' => array(
												'type' => 'text',
												'label' => esc_html__('PayPal username?', 'listingo'),
												'desc' => esc_html__('', 'listingo'),
											),
											'paypal_password' => array(
												'type' => 'text',
												'label' => esc_html__('PayPal password?', 'listingo'),
												'desc' => esc_html__('', 'listingo'),
											),	
											'paypal_signature' => array(
												'type' => 'text',
												'label' => esc_html__('PayPal signature?', 'listingo'),
												'desc' => esc_html__('', 'listingo'),
											),
											'paypal_payment_name' => array(
												'type' => 'text',
												'label' => esc_html__('PayPal payment name?', 'listingo'),
												'desc' => esc_html__('', 'listingo'),
											),
										)
									),
								),
								'percentage' => array(
									'type' => 'slider',
									'value' => 0,
									'properties' => array(
										'min' => 0,
										'max' => 100,
										'sep' => 1,
									),
									'desc' => esc_html__('Select booking commission in percentage ( % )', 'listingo'),
									'label' => esc_html__('Booking Commission', 'listingo'),
								),
                            ),
                            'default' => array(),
                        ),
                        'show_borders' => false,
                    ),				
                )
            ),
        )
    )
);
