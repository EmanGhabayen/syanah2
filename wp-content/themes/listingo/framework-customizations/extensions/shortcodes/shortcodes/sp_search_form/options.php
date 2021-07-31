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
	'form_title' => array(
        'label' => esc_html__('Form title?', 'listingo'),
        'type' => 'text',
		'value' => 'Search Thousands of Qualified Professionals',
        'desc' => esc_html__('Add form title here.', 'listingo')
    ),
);
