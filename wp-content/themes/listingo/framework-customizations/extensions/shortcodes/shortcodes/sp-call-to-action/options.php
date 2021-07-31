<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'cta_heading' => array(
        'type' => 'text',
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('Add section heading. leave it empty to hide.', 'listingo'),
    ),
    'cta_sub_heading' => array(
        'type' => 'text',
        'label' => esc_html__('Sub Heading', 'listingo'),
        'desc' => esc_html__('Add sub heading. leave it empty to hide.', 'listingo'),
    ),
    'cta_description' => array(
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
    'cta_logo' => array(
        'type' => 'upload',
        'label' => esc_html__('Call to action logo.', 'listingo'),
        'desc' => esc_html__('add your call to action logo here. Leave it empty to hide.', 'listingo'),
        'images_only' => true,
        'files_ext' => array('jpg', 'jpeg', 'png'),
        'extra_mime_types' => array('audio/x-aiff, aif aiff')
    ),
    'cta_button_text' => array(
        'label' => esc_html__('Button Text', 'listingo'),
        'type' => 'text',
        'desc' => esc_html__('Add button text here.', 'listingo')
    ),
    'cta_link' => array(
        'label' => esc_html__('Button URL', 'listingo'),
        'type' => 'text',
        'desc' => esc_html__('Add button url here.', 'listingo')
    ),
    'cta_link_target' => array(
        'type' => 'select',
        'value' => '_self',
        'label' => esc_html__('Link Target', 'listingo'),
        'choices' => array(
            '_blank' => esc_html__('_blank', 'listingo'),
            '_self' => esc_html__('_self', 'listingo'),
        ),
        'no-validate' => false,
    ),
);
