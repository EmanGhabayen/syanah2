<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'enable_quote' => array(
        'type' => 'switch',
        'value' => 'show',
        'label' => esc_html__('Show / Hide Quote icon', 'listingo'),
        'left-choice' => array(
            'value' => 'show',
            'label' => esc_html__('Show', 'listingo'),
        ),
        'right-choice' => array(
            'value' => 'hide',
            'label' => esc_html__('Hide', 'listingo'),
        ),
    ),
    'testimonials' => array(
        'label' => esc_html__('Testimonials', 'listingo'),
        'type' => 'addable-popup',
        'value' => array(),
        'desc' => esc_html__('Add Social Icons as much as you want. Choose the icon, url and the title', 'listingo'),
        'popup-options' => array(
            'testimonail_heading' => array(
                'type' => 'text',
                'label' => esc_html__('Heading', 'listingo'),
            ),
            'testimonail_author' => array(
                'type' => 'text',
                'label' => esc_html__('Author Name', 'listingo'),
            ),
            'testimonial_description' => array(
                'type' => 'textarea',
                'label' => esc_html__('Description', 'listingo'),
            ),
            'testimonial_image' => array(
                'type' => 'upload',
                'label' => esc_html__('Thumbnail', 'listingo'),
                'images_only' => true,
                'files_ext' => array('jpg', 'jpeg', 'png'),
                'extra_mime_types' => array('audio/x-aiff, aif aiff')
            ),
        ),
        'template' => '{{- testimonail_heading }}',
    ),
);
