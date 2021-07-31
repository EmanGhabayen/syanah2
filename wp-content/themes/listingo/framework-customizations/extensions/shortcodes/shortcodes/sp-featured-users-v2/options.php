<?php

if (!defined('FW')) {
    die('Forbidden');
}
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
	'btn' => array(
        'type' => 'select',
        'value' => 'no',
        'label' => esc_html__('Show button', 'listingo'),
        'desc' => esc_html__('Display view all button', 'listingo'),
        'choices' => array(
            'yes' => esc_html__('Yes', 'listingo'),
            'no'  => esc_html__('No', 'listingo'),
        ),
    ),
);
