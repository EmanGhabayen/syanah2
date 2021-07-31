<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
	 'auth' => array(
		'type'         => 'multi-picker',
		'label'        => false,
		'desc'         => false,
		'picker'       => array(
			'gadget' => array(
				'label'        => esc_html__('Form type?' , 'listingo') ,
				'type' 		   => 'select',
				'value'        => 'both' ,
				'desc'         => esc_html__('Select form type' , 'listingo') ,
				'choices' => array(
					'login' 	=> esc_html__('Login Form', 'listingo'),
					'register'  => esc_html__('Register Form', 'listingo'),
					'both'  	=> esc_html__('Both Form', 'listingo'),
				),
			)
		),
		'choices'      => array(
			'login'  => array(
				'title' => array(
					'type' => 'text',
					'value' => 'Login Now',
					'label' => esc_html__('Login Title?', 'listingo'),
				),
			),
			'register'  => array(
				'title' => array(
					'type' => 'text',
					'value' => 'Register As',
					'label' => esc_html__('Register Title?', 'listingo'),
				),
			),
			'both'  => array(
				'login' => array(
					'type' => 'text',
					'value' => 'Login Now',
					'label' => esc_html__('Title?', 'listingo'),
				),
				'register' => array(
					'type' => 'text',
					'value' => 'Register As',
					'label' => esc_html__('Title?', 'listingo'),
				),
			),
		)
	),
);
