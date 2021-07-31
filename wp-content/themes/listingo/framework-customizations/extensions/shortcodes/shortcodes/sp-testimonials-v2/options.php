<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
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
                'desc' => esc_html__('Preffered size is 300 x 300', 'listingo'),
                'files_ext' => array('jpg', 'jpeg', 'png'),
                'extra_mime_types' => array('audio/x-aiff, aif aiff')
            ),
            'user_rating' => array(
                'type' => 'select',
                'value' => 'default',
                'attr' => array(),
                'label' => esc_html__('Add rating', 'listingo'),
                'desc' => esc_html__('Add rating or hide it from element.', 'listingo'),
                'help' => esc_html__('', 'listingo'),
                'choices' => array(
                    'none' => esc_html__('Hide', 'listingo'),
                    '1' => esc_html__('1 Star', 'listingo'),
					'2' => esc_html__('2 Star', 'listingo'),
					'3' => esc_html__('3 Star', 'listingo'),
					'4' => esc_html__('4 Star', 'listingo'),
					'5' => esc_html__('5 Star', 'listingo'),
                ),
            ),
        ),
        'template' => '{{- testimonail_heading }}',
    ),
    'autoplay' => array(
        'type' => 'switch',
        'value' => 'true',
        'label' => esc_html__('Autoplay?', 'listingo'),
        'desc' => esc_html__('Set it true for auto-rotating slides', 'listingo'),
        'left-choice' => array(
            'value' => 'false',
            'label' => esc_html__('False', 'listingo'),
        ),
        'right-choice' => array(
            'value' => 'true',
            'label' => esc_html__('True', 'listingo'),
        ),
    ),
    'loop' => array(
        'type' => 'switch',
        'value' => 'true',
        'label' => esc_html__('Loop?', 'listingo'),
        'desc' => esc_html__('Set it true for looping slides', 'listingo'),
        'left-choice' => array(
            'value' => 'false',
            'label' => esc_html__('False', 'listingo'),
        ),
        'right-choice' => array(
            'value' => 'true',
            'label' => esc_html__('True', 'listingo'),
        ),
    ),
    'nav' => array(
        'type' => 'switch',
        'value' => 'true',
        'label' => esc_html__('Navigation?', 'listingo'),
        'desc' => esc_html__('Set it true to enable navigation', 'listingo'),
        'left-choice' => array(
            'value' => 'false',
            'label' => esc_html__('False', 'listingo'),
        ),
        'right-choice' => array(
            'value' => 'true',
            'label' => esc_html__('True', 'listingo'),
        ),
    ),
);
