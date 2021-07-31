<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'history_heading' => array(
        'type' => 'text',
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('Add section heading. leave it empty to hide.', 'listingo'),
    ),
    'history_desc' => array(
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
    'timeline_tabs' => array(
        'label' => esc_html__('Timeline History', 'listingo'),
        'type' => 'addable-popup',
        'value' => array(),
        'desc' => esc_html__('Add timeline history.', 'listingo'),
        'popup-options' => array(
            'timeline_year' => array(
                'type' => 'text',
                'label' => esc_html__('Choose Year', 'listingo'),
            ),
            'timeline_title' => array(
                'label' => esc_html__('Timeline Title', 'listingo'),
                'type' => 'text',
                'desc' => esc_html__('Add title here. Leave it empty to hide.', 'listingo')
            ),
            'timeline_desc' => array(
                'type' => 'wp-editor',
                'label' => esc_html__('Description', 'listingo'),
                'desc' => esc_html__('Add timeline description.', 'listingo'),
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
            'timeline_gallery' => array(
                'type' => 'multi-upload',
                'label' => esc_html__('Timeline Gallery', 'listingo'),
                'desc' => esc_html__('Add timeline gallery here.', 'listingo'),
                'images_only' => true,
                'files_ext' => array('png', 'jpg', 'jpeg'),
                'extra_mime_types' => array('audio/x-aiff, aif aiff')
            ),
            'timeline_btn_text' => array(
                'label' => esc_html__('Link URL', 'listingo'),
                'type' => 'text',
                'desc' => esc_html__('Add timeline button text here.', 'listingo')
            ),
            'timeline_btn_link' => array(
                'label' => esc_html__('Link URL', 'listingo'),
                'type' => 'text',
                'desc' => esc_html__('Add timeline button link here.', 'listingo')
            ),
            'timeline_btn_target' => array(
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
        'template' => '{{- timeline_title }}',
    ),
);
