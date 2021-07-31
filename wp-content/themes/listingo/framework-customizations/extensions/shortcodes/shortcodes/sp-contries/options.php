<?php

if (!defined('FW'))
    die('Forbidden');



$options = array(
    'title' => array(
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('Add section heading. leave it empty to hide.', 'listingo'),
        'type' => 'text',
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
    'countries' => array(
        'type' => 'multi-select',
        'label' => esc_html__('Select Countries', 'listingo'),
        'population' => 'taxonomy',
        'source' => 'countries',
        'prepopulate' => 500,
        'desc' => esc_html__('Show countires as per your selection. Leave it empty to show from all.', 'listingo'),
    ),
    'country_buttons' => array(
        'type' => 'addable-box',
        'label' => esc_html__('Add Button', 'listingo'),
        'desc' => esc_html__('', 'listingo'),
        'box-options' => array(
            'button_text' => array('type' => 'text'),
            'button_link' => array('type' => 'text'),
        ),
        'template' => '{{- button_text }}', // box title
        'box-controls' => array(// buttons next to (x) remove box button
            'control-id' => '<small class = "dashicons dashicons-smiley"></small>',
        ),
        'limit' => 1, // limit the number of boxes that can be added
        'add-button-text' => esc_html__('Add', 'listingo'),
        'sortable' => true,
    ),
);
