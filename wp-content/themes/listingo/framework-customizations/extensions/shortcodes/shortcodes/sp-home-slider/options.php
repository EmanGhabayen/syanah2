<?php

if (!defined('FW'))
    die('Forbidden');



$options = array(
    'banner_slides' => array(
        'type' => 'addable-popup',
        'label' => esc_html__('Add Slides', 'listingo'),
        'desc' => esc_html__('Add slides of the home banner slider', 'listingo'),
        'template' => '{{- slide_title }}',
        'popup-title' => null,
        'size' => 'small', // small, medium, large
        'limit' => 0, // limit the number of popup`s that can be added
        'add-button-text' => esc_html__('Add', 'listingo'),
        'sortable' => true,
        'popup-options' => array(
            'bg_image' => array(
                'label' => esc_html__('Background Image', 'listingo'),
                'type' => 'upload',
                'value' => '',
                'desc' => esc_html__('Upload Background image of the slide', 'listingo'),
            ),
            'slide_title' => array(
                'type' => 'text',
                'label' => esc_html__('Slide Title', 'listingo'),
                'value' => '',
                'desc' => esc_html__('Add slide title ', 'listingo'),
            ),
            'slide_desc' => array(
                'type' => 'wp-editor',
                'label' => esc_html__('Slide Description', 'listingo'),
                'value' => '',
                'desc' => esc_html__('Add decription of the slide', 'listingo'),
            ),
            'slide_btns' => array(
                'type' => 'addable-popup',
                'label' => esc_html__('Slide Buttons', 'listingo'),
                'value' => '',
                'desc' => esc_html__('Add Slide Buttons', 'listingo'),
                'template' => '{{- btn_title }}',
                'popup-options' => array(
                    'btn_title' => array(
                        'type' => 'text',
                        'label' => esc_html__('Button Title', 'listingo'),
                    ),
                    'btn_link' => array(
                        'type' => 'text',
                        'label' => esc_html__('Button Link', 'listingo'),
                    ),
                    'btn_target' => array(
                        'type' => 'select',
                        'value' => '_self',
                        'label' => esc_html__('Button Target', 'listingo'),
                        'choices' => array(
                            '_self' => esc_html__('Self', 'listingo'),
                            '_blank' => esc_html__('Blank', 'listingo'),
                        ),
                    ),
                    'btn_active' => array(
                        'type' => 'select',
                        'value' => 'simple',
                        'label' => esc_html__('Choose Button Style', 'listingo'),
                        'choices' => array(
                            'simple' => esc_html__('Simple', 'listingo'),
                            'active' => esc_html__('Active', 'listingo'),
                        ),
                    ),
                ),
            ),
        ),
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
