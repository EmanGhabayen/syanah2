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
            'no' => esc_html__('No', 'listingo'),
        ),
        'no-validate' => false,
    ),
);
