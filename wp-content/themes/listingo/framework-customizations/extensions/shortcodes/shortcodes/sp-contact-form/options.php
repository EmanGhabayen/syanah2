<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array(
    'contact_form' => array(
        'type' => 'multi-select',
        'label' => esc_html__('Choose Contact Form', 'listingo'),
        'population' => 'array',
        'source' => '',
        'choices' => listingo_prepare_custom_posts('wpcf7_contact_form', -1),
        'prepopulate' => 100,
        'desc' => esc_html__('Choose your contact form 7.', 'listingo'),
        'limit' => 1
    ),
    'contact_heading' => array(
        'type' => 'text',
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('', 'listingo'),
    ),
    'contact_description' => array(
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
        'editor_height' => 150
    ),
);
