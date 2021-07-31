<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array(
    'provider_heading' => array(
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('Add news section heading. leave it empty to hide.', 'listingo'),
        'type' => 'text',
    ),
    'provider_description' => array(
        'type' => 'wp-editor',
        'label' => esc_html__('Description', 'listingo'),
        'desc' => esc_html__('Add section description. leave it empty to hide.', 'listingo'),
        'tinymce' => true,
        'media_buttons' => false,
        'teeny' => false,
        'wpautop' => false,
        'editor_css' => '',
        'reinit' => true,
        'size' => 'small', // small | large
        'editor_type' => 'tinymce',
        'editor_height' => 200
    ),
    'categories' => array(
		'type' => 'multi-select',
		'label' 	=> esc_html__('Select Categories', 'listingo'),
		'population' => 'posts',
		'source' => 'sp_categories',
		'limit'	=> 500,
		'desc' => esc_html__('Show featured users by category selection.', 'listingo'),
	),
	'show_posts' => array(
		'type' => 'slider',
		'value' => 9,
		'properties' => array(
			'min' => 1,
			'max' => 100,
			'sep' => 1,
		),
		'label' => esc_html__('Show No of Posts', 'listingo'),
	),
	'order' => array(
		'type' => 'select',
		'value' => 'DESC',
		'desc' => esc_html__('Post Order', 'listingo'),
		'label' => esc_html__('Posts By', 'listingo'),
		'choices' => array(
			'ASC' => esc_html__('ASC', 'listingo'),
			'DESC' => esc_html__('DESC', 'listingo'),
		),
	), 
);
