<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'sponser_heading' => array(
        'type' => 'text',
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('Add section heading. leave it empty to hide.', 'listingo'),
    ),
    'sponser_description' => array(
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
	'direction' => array(
		'type' => 'select',
		'value' => 'default',
		'label' => esc_html__('Slider direction', 'listingo'),
		'choices' => array(
			'default' 		=> esc_html__('Default', 'listingo'),
			'right_to_left' => esc_html__('Right to left', 'listingo'),
		),
		'no-validate' => false,
	),
	'sorting' => array(
		'type' => 'select',
		'value' => 'default',
		'label' => esc_html__('Slides sorting', 'listingo'),
		'choices' => array(
			'default' 		=> esc_html__('Default', 'listingo'),
			'shuffled' 		=> esc_html__('Random', 'listingo'),
		),
		'no-validate' => false,
	),
	'autoplay' => array(
		'type' => 'select',
		'value' => 'true',
		'label' => esc_html__('Auto play?', 'listingo'),
		'choices' => array(
			'true' 		=> esc_html__('Yes', 'listingo'),
			'false' => esc_html__('No', 'listingo'),
		),
		'no-validate' => false,
	),
    'sponser_list' => array(
        'label' => esc_html__('sponsers', 'listingo'),
        'type' => 'addable-popup',
        'value' => array(),
        'desc' => esc_html__('Add Social Icons as much as you want. Choose the icon, url and the title', 'listingo'),
        'popup-options' => array(
            'sponser_icon' => array(
                'type' => 'upload',
                'label' => esc_html__('Logo', 'listingo'),
                'desc' => esc_html__('Choose sponser logo here.', 'listingo'),
            ),
            'sponser_title' => array(
                'label' => esc_html__('Title', 'listingo'),
                'type' => 'text',
                'desc' => esc_html__('Add sponser title here.', 'listingo')
            ),
            'sponser_link' => array(
                'label' => esc_html__('Link URL', 'listingo'),
                'type' => 'text',
                'desc' => esc_html__('Add sponser link url here.', 'listingo')
            ),
            'link_target' => array(
                'type' => 'select',
                'value' => '_self',
                'label' => esc_html__('Link Target', 'listingo'),
                'choices' => array(
                    '_blank' => esc_html__('_blank', 'listingo'),
                    '_self' => esc_html__('_self', 'listingo'),
                ),
                'no-validate' => false,
            ),
        ),
        'template' => '{{- sponser_title }}',
    ),
);
