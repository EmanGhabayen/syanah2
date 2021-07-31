<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
	'title' => array(
        'label' => esc_html__('Title?', 'listingo'),
        'type' => 'text',
		'value' => 'Packages title goes here',
        'desc' => esc_html__('Add title here.', 'listingo')
    ),
	'sub_title' => array(
        'label' => esc_html__('Sub Title?', 'listingo'),
        'type' => 'textarea',
		'value' => 'Packages sub title goes here',
        'desc' => esc_html__('Add sub title here.', 'listingo')
    ),
	'type' => array(
		'type' => 'select',
		'value' => 'providers',
		'label' => esc_html__('Packages type?', 'listingo'),
		'choices' => array(
			'provider' => esc_html__('Providers', 'listingo'),
			'customer' => esc_html__('Customers', 'listingo'),
		),
		'no-validate' => false,
	),
);
