<?php

if (!defined('FW'))
    die('Forbidden');

$options = array(
    'provider_heading' => array(
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('Add news section heading. leave it empty to hide.', 'listingo'),
        'type' => 'text',
    ),
    'provider_description' => array(
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
    'images' =>array(
        'type'  => 'multi-upload',    
        'label' => __('Select images', 'listingo'),
        'desc'  => __('Select multiple images', 'listingo'),
        'images_only' => true,    
    ),
);
