<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array(
    'heading' => array(
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('Add news section heading. leave it empty to hide.', 'listingo'),
        'type' => 'text',
    ),
    'description' => array(
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
    'get_mehtod' => array(
        'type' => 'multi-picker',
        'label' => false,
        'desc' => false,
        'value' => array('gadget' => 'normal'),
        'picker' => array(
            'gadget' => array(
                'type' => 'select',
                'value' => 'by_cats',
                'desc' => esc_html__('Select users by category or user', 'listingo'),
                'label' => esc_html__('Listing type?', 'listingo'),
                'choices' => array(
                    'by_cats' => esc_html__('By Categories', 'listingo'),
                    'by_posts' => esc_html__('All', 'listingo'),
                ),
            )
        ),
        'choices' => array(
            'by_cats' => array(
                'categories' => array(
					'type' => 'multi-select',
					'label' 	 => esc_html__('Select Categories', 'listingo'),
					'population' => 'taxonomy',
                	'source' 	 => 'ad_category',
					'desc' => esc_html__('Show ads from selected categories.', 'listingo'),
				),
            ),
        ),
        'show_borders' => true,
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
	'show_pagination' => array(
        'type' => 'select',
        'value' => 'no',
        'label' => esc_html__('Show Pagination', 'listingo'),
        'desc' => esc_html__('', 'listingo'),
        'choices' => array(
            'yes' => esc_html__('Yes', 'listingo'),
            'no'  => esc_html__('No', 'listingo'),
        ),
        'no-validate' => false,
    ),
);
