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
                    'by_users' => esc_html__('By user', 'listingo'),
                ),
            )
        ),
        'choices' => array(
            'by_cats' => array(
                'categories' => array(
					'type' => 'multi-select',
					'label' 	=> esc_html__('Select Category', 'listingo'),
					'population' => 'posts',
        			'source' => 'sp_categories',
					'limit'	=> 500,
					'desc' => esc_html__('Show featured users by category selection.', 'listingo'),
				),
            ),
            'by_users' => array(
                'users' => array(
                    'type' => 'multi-select',
                    'label' => esc_html__('Select users', 'listingo'),
                    'population' => 'users',
					'prepopulate' => 500,
                    'source' => array( 'business', 'prfessional'),
                    'desc' => esc_html__('Show users by selection.', 'listingo'),
                ),
            )
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
