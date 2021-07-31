<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
	'form_v1_info' => array(
		'type' => 'html',
		'html' => esc_html__('Search Form Settings', 'listingo'),
		'label' => esc_html__('', 'listingo'),
		'desc' => esc_html__('You can disable search form fields from Theme Settings > Directory Settings >Search Settings', 'listingo'),
		'help' => esc_html__('', 'listingo'),
		'images_only' => true,
	),
	'title' => array(
        'label' => esc_html__('Title?', 'listingo'),
        'type' => 'text',
		'value' =>  'World’s Largest Marketplace',
        'desc' => esc_html__('Add title here.', 'listingo')
    ),
	'subtitle' => array(
        'label' => esc_html__('Sub Title?', 'listingo'),
        'type' => 'text',
		'value' =>  'Search From 12,45,754 Listingo',
        'desc' => esc_html__('Add title here.', 'listingo')
    ),
	'color' => array(
        'label' => esc_html__('Text Color?', 'listingo'),
        'type' => 'color-picker',
        'desc' => esc_html__('Add text color, leave it empty to use default.', 'listingo')
    ),
	'geo_type' => array(
		'label' => esc_html__('Location type', 'listingo'),
		'desc' => esc_html__('Select location type.', 'listingo'),
		'type' => 'select',
		'value' => 'geo',
		'choices' => array(
			'geo' => esc_html__('Geo location?', 'listingo'),
			'countries' => esc_html__('Countries list', 'listingo'),
		)
	),
	'sub_cats' => array(
		'type' => 'select',
		'value' => 'no',
		'attr' => array(),
		'label' => esc_html__('Sub categories?', 'listingo'),
		'desc' => esc_html__('Enable sub categories in search form?', 'listingo'),
		'choices' => array(
			'no' => esc_html__('No', 'listingo'),
			'yes' => esc_html__('Yes', 'listingo'),
		),
	),
	'btn_text' => array(
        'label' => esc_html__('Button text?', 'listingo'),
        'type' => 'text',
		'value' =>  '',
        'desc' => esc_html__('Add title here. leave it empty to use icon.', 'listingo')
    ),
);
