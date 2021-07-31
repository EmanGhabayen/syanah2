<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'form_heading' => array(
        'type' => 'text',
        'label' => esc_html__('Form Heading', 'listingo'),
    ),
    'form_subheading' => array(
        'type' => 'text',
        'label' => esc_html__('Form Sub Heading', 'listingo'),
    ),
    'form_image' => array(
        'type' => 'upload',
        'label' => esc_html__('Upload image', 'listingo'),
        'desc' => esc_html__('Upload Image of the form. Preffered size is 84 x 60','listingo'),
    ),
    'frm_btn_txt' => array(
        'type' => 'text',
        'label' => esc_html__('Form Button Text', 'listingo'),
        'desc' => esc_html__('Add form button text or leave it empty ifyou want to stay with "Sign Up"','listingo'),
    ),
	'color' => array(
		'label' => esc_html__('text color', 'listingo'),
		'type' => 'color-picker',
		'value' => '#333333',
		'desc' => esc_html__('Select text color. Leave it empty to use default.', 'listingo')
	),
);
