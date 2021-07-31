<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
	'form_v3_info' => array(
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
	'btn_title' => array(
        'label' => esc_html__('Button Title?', 'listingo'),
        'type' => 'text',
		'value' =>  'Search Places',
        'desc' => esc_html__('Add button title here.', 'listingo')
    ),
	'trendings' => array(
        'type' => 'multi-select',
        'label' => esc_html__('Select categories', 'listingo'),
        'population' => 'posts',
        'source' => 'sp_categories',
        'prepopulate' => 500,
        'desc' => esc_html__('Show categories by selection. Leave it empty to show all', 'listingo'),
    ),
	'autoplay' => array(
		'label' => esc_html__('Autoplay', 'listingo'),
		'desc' => esc_html__('Select play type of slider for ternding categories', 'listingo'),
		'type' => 'select',
		'value' => 'true',
		'choices' => array(
			'true' => esc_html__('Yes', 'listingo'),
			'false' => esc_html__('No', 'listingo'),
		)
	),
	'pagination' => array(
		'label' => esc_html__('Pagination', 'listingo'),
		'desc' => esc_html__('Show slider pagination or not', 'listingo'),
		'type' => 'select',
		'value' => 'true',
		'choices' => array(
			'true' => esc_html__('Yes', 'listingo'),
			'false' => esc_html__('No', 'listingo'),
		)
	),
	'loop' => array(
		'label' => esc_html__('Loop', 'listingo'),
		'desc' => esc_html__('Select either repeat the categories of slider or not', 'listingo'),
		'type' => 'select',
		'value' => 'false',
		'choices' => array(
			'true' => esc_html__('Yes', 'listingo'),
			'false' => esc_html__('No', 'listingo'),
		)
	),
);
