<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'heading' => array(
        'type' => 'text',
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('Add section heading. leave it empty to hide.', 'listingo'),
    ),
    'description' => array(
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
    'button_link' => array(
        'label' => esc_html__('Button Link', 'listingo'),
        'type' => 'text',
        'desc' => esc_html__('Add button link here. Leave it eampty to hide.', 'listingo')
    ),
    'button_title' => array(
        'label' => esc_html__('Button Title', 'listingo'),
        'type' => 'text',
        'desc' => esc_html__('Add button title here. Leave it eampty to hide.', 'listingo')
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
);
