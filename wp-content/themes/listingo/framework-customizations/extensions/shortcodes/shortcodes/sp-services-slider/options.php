<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'service_heading' => array(
        'type' => 'text',
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('Add section heading. leave it empty to hide.', 'listingo'),
    ),
    'service_description' => array(
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
    'service_list' => array(
        'label' => esc_html__('Services', 'listingo'),
        'type' => 'addable-popup',
        'value' => array(),
        'desc' => esc_html__('Add Social Icons as much as you want. Choose the icon, url and the title', 'listingo'),
        'popup-options' => array(
            'enable_count' => array(
                'type' => 'multi-picker',
                'label' => false,
                'desc' => '',
                'picker' => array(
                    'gadget' => array(
                        'type' => 'switch',
                        'value' => 'show',
                        'label' => esc_html__('Show / Hide Count', 'listingo'),
                        'left-choice' => array(
                            'value' => 'show',
                            'label' => esc_html__('Show', 'listingo'),
                        ),
                        'right-choice' => array(
                            'value' => 'hide',
                            'label' => esc_html__('Hide', 'listingo'),
                        ),
                    )
                ),
                'choices' => array(
                    'show' => array(
                        'counter_color' => array(
                            'type' => 'color-picker',
                            'palettes' => array('#ec407a', '#42a5f5', '#66bb6a', '#ffa726'),
                            'label' => esc_html__('Color', 'listingo'),
                            'desc' => esc_html__('Set counter background color.', 'listingo'),
                        ),
                    ),
                    'default' => array(),
                ),
                'show_borders' => false,
            ),
            'service_icon' => array(
                'type' => 'icon-v2',
                'preview_size' => 'medium',
                'modal_size' => 'medium',
                'label' => esc_html__('Icon', 'listingo'),
                'desc' => esc_html__('Choose service icon here.', 'listingo'),
            ),
            'service_title' => array(
                'label' => esc_html__('Title', 'listingo'),
                'type' => 'text',
                'desc' => esc_html__('Add service title here.', 'listingo')
            ),
            'service_desc' => array(
                'label' => esc_html__('Description', 'listingo'),
                'type' => 'textarea',
                'desc' => esc_html__('Add service description here.', 'listingo')
            ),
            'service_link' => array(
                'label' => esc_html__('Link URL', 'listingo'),
                'type' => 'text',
                'desc' => esc_html__('Add service link url here.', 'listingo')
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
        'template' => '{{- service_title }}',
    ),
);
