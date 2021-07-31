<?php

if (!defined('FW'))
    die('Forbidden');


$options = array(
	'color' => array(
		'label' => esc_html__('text color', 'listingo'),
		'type' => 'color-picker',
		'value' => '#333333',
		'desc' => esc_html__('Select text color. Leave it empty to use default.', 'listingo')
	),
    'sp_counters' => array(
        'type' => 'addable-popup',
        'label' => esc_html__('Counters', 'listingo'),
        'desc' => esc_html__('Adding counters to your themes', 'listingo'),
        'template' => '{{- counter_title }}',
        'popup-title' => null,
        'size' => 'small', // small, medium, large
        'limit' => 0, // limit the number of popup`s that can be added
        'add-button-text' => esc_html__('Add Counters', 'listingo'),
        'sortable' => true,
        'popup-options' => array(
            'counter_title' => array(
                'label' => esc_html__('Title', 'listingo'),
                'type' => 'text',
                'desc' => esc_html__('Title of the counter', 'listingo'),
            ),
            'counter_value_from' => array(
                'label' => esc_html__('Value From', 'listingo'),
                'type' => 'text',
                'desc' => esc_html__('the value from where you want to start the counter', 'listingo'),
            ),
            'counter_value_to' => array(
                'label' => esc_html__('Value To', 'listingo'),
                'type' => 'text',
                'desc' => esc_html__('the value where you want to end the counter', 'listingo'),
            ),
            'counter_speed' => array(
                'label' => esc_html__('Speed', 'listingo'),
                'type' => 'text',
                'desc' => esc_html__('speed of the counter in millisecond e.g 8000, 2000 etc', 'listingo'),
            ),
            'counter_interval' => array(
                'label' => esc_html__('Data Refresh Interval', 'listingo'),
                'type' => 'text',
                'desc' => esc_html__('interval of data or increment of values in the counter e.g 50, 100 etc', 'listingo'),
            ),
        ),
    )
);
