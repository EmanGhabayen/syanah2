<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
	'cats' => array(
        'type' => 'multi-select',
        'label' => esc_html__('Category?', 'listingo'),
        'population' => 'posts',
        'source' => 'sp_categories',
        'prepopulate' => 500,
        'desc' => esc_html__('Show users by category selection. Leave it emty to show from all category.', 'listingo'),
    ),
    'show_users' => array(
        'type' => 'slider',
        'value' => 9,
        'properties' => array(
            'min' => 1,
            'max' => 100,
            'sep' => 1,
        ),
        'label' => esc_html__('Show no of users', 'listingo'),
    ),
	'order' => array(
        'type' => 'select',
        'value' => 'DESC',
        'label' => esc_html__('Order', 'listingo'),
        'desc' => esc_html__('', 'listingo'),
        'choices' => array(
            'DESC' => esc_html__('DESC', 'listingo'),
            'ASC' => esc_html__('ASC', 'listingo'),
        ),
        'no-validate' => false,
    ),
);
