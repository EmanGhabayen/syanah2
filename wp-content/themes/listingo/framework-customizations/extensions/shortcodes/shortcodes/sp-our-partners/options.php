<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'partner_heading' => array(
        'type' => 'text',
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('Add section heading. leave it empty to hide.', 'listingo'),
    ),
    'partner_description' => array(
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
    'partners' => array(
        'label' => esc_html__('Partners', 'listingo'),
        'type' => 'addable-popup',
        'value' => array(),
        'desc' => esc_html__('Add partners here. Choose the image.', 'listingo'),
        'popup-options' => array(
            'partner_logo' => array(
                'type' => 'upload',
                'label' => esc_html__('Partner Logo', 'listingo'),
                'desc' => esc_html__('Upload your partner logo here.', 'listingo'),
                'images_only' => true,
                'files_ext' => array('jpg', 'jpeg', 'png'),
                'extra_mime_types' => array('audio/x-aiff, aif aiff')
            ),
            'partner_name' => array(
                'label' => esc_html__('Name', 'listingo'),
                'type' => 'text',
                'desc' => esc_html__('Add partner name here. Note : This will be used for alt tag, so do not leave empty this field.', 'listingo')
            ),
            'partner_link' => array(
                'label' => esc_html__('Link URL', 'listingo'),
                'type' => 'text',
                'desc' => esc_html__('Add partner link url here.', 'listingo')
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
        'template' => '{{- partner_name }}',
    ),
);
