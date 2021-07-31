<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'heading' => array(
		'type' => 'text',
		'label' => esc_html__('Heading', 'listingo'),
	),
	'description' => array(
		'type' => 'textarea',
		'label' => esc_html__('Description', 'listingo'),
	),
	'form_heading' => array(
		'type' => 'text',
		'label' => esc_html__('Form Heading', 'listingo'),
	),
	'username' => array(
        'type' => 'switch',
        'value' => 'show',
		'desc' => esc_html__('Include or exclude first name in form.', 'listingo'),
        'label' => esc_html__('First name?', 'listingo'),
        'left-choice' => array(
            'value' => 'yes',
            'label' => esc_html__('Yes', 'listingo'),
        ),
        'right-choice' => array(
            'value' => 'no',
            'label' => esc_html__('No', 'listingo'),
        ),
    ),
);