<?php

if (!defined('FW'))
    die('Forbidden');



$options = array(
    'heading' => array(
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('Add heading. Leave it empty to hide', 'listingo'),
        'type' => 'text',
    ),
	'sub_heading' => array(
        'label' => esc_html__('Sub Heading', 'listingo'),
        'desc' => esc_html__('Add sub heading. Leave it empty to hide', 'listingo'),
        'type' => 'text',
    ),
	'view' => array(
		'type' => 'select',
		'value' => 'list',
		'desc' => esc_html__('Select listing View', 'listingo'),
		'label' => esc_html__('Listing View', 'listingo'),
		'choices' => array(
			'list' => esc_html__('List', 'listingo'),
			'grid' => esc_html__('Grid', 'listingo'),
		),
	), 
	'categories' => array(
		'type' => 'multi-select',
		'label' 	=> esc_html__('Select Categories', 'listingo'),
		'population' => 'posts',
		'source' => 'sp_categories',
		'limit'	=> 500,
		'desc' => esc_html__('Show users by category selection. Leave it empty to show from all categories', 'listingo'),
	),
    'show_posts' => array(
        'type' => 'slider',
        'value' => 8,
        'properties' => array(
            'min' => 1,
            'max' => 100,
            'sep' => 1,
        ),
        'label' => esc_html__('Show No of Posts', 'listingo'),
    ),
    'show_pagination' => array(
        'type' => 'select',
        'value' => 'no',
        'label' => esc_html__('Show Pagination', 'listingo'),
        'desc' => esc_html__('', 'listingo'),
        'choices' => array(
            'yes' => esc_html__('Yes', 'listingo'),
            'no' => esc_html__('No', 'listingo'),
        ),
        'no-validate' => false,
    ),
);
