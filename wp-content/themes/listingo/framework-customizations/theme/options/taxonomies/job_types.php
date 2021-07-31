<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'job_type_settings' => array(
        'title' => esc_html__('Title bar Settings', 'listingo'),
        'type' => 'box',
        'options' => array(
            'enable_breadcrumbs' => array(
                'type' => 'switch',
                'value' => 'disable',
                'label' => esc_html__('Breadcrumbs', 'listingo'),
                'desc' => esc_html__('Enable or Disable breadcrumbs. Please note global settings(From Theme Settings) should be enabled', 'listingo'),
                'left-choice' => array(
                    'value' => 'enable',
                    'label' => esc_html__('Enable', 'listingo'),
                ),
                'right-choice' => array(
                    'value' => 'disable',
                    'label' => esc_html__('Disable', 'listingo'),
                ),
            ),
            'titlebar_type' => array(
                'type' => 'multi-picker',
                'label' => false,
                'desc' => false,
                'picker' => array(
                    'gadget' => array(
                        'label' => esc_html__('Title bar Type', 'listingo'),
                        'desc' => esc_html__('Select Title bar Type, Please note global settings(From Theme Settings) should be enabled', 'listingo'),
                        'type' => 'select',
                        'value' => 'default',
                        'choices' => array(
                            'default' => esc_html__('Default Settings(Theme Settings)', 'listingo'),
                            'custom_titlebar' => esc_html__('Custom titlebar', 'listingo'),
                            'rev_slider' => esc_html__('Revolution Slider', 'listingo'),
                            'system_slider' => esc_html__('Theme Slider', 'listingo'),
                            'custom_shortcode' => esc_html__('Custom Shortcode', 'listingo'),
                            'none' => esc_html__('None, hide it', 'listingo'),
                        )
                    )
                ),
                'choices' => array(
                    'custom_titlebar' => array(
                        'titlebar_bg_image' => array(
                            'type' => 'upload',
                            'label' => esc_html__('Upload background image', 'listingo'),
                            'desc' => esc_html__('', 'listingo'),
                            'images_only' => true,
                        ),
                        'titlebar_color' => array(
                            'type' => 'color-picker',
                            'value' => '#FFF',
                            'label' => esc_html__('Text color', 'listingo'),
                            'desc' => esc_html__('Title bar text color.', 'listingo'),
                        ),
                        'titlebar_contents' => array(
                            'type' => 'wp-editor',
                            'value' => '',
                            'attr' => array(),
                            'label' => esc_html__('Title bat contents', 'listingo'),
                            'desc' => esc_html__('Leave it empty to use from theme settings, if theme settings is empty then default title of page will be shown.', 'listingo'),
                            'help' => esc_html__('', 'listingo'),
                            'size' => 'small', // small, large,
                            'wpautop' => true,
                            'editor_type' => true, // tinymce, html
                            'editor_height' => 400,
                        ),
                    ),
                    'system_slider' => array(
                        'system_slider' => array(
                            'type' => 'select',
                            'value' => '',
                            'label' => esc_html__('Theme Slider', 'listingo'),
                            'desc' => esc_html__('Please Select theme slider.', 'listingo'),
                            'help' => esc_html__('Please create a new slider and then select here.', 'listingo'),
                            'choices' => listingo_prepare_sliders(),
                        ),
                    ),
                    'rev_slider' => array(
                        'rev_slider' => array(
                            'type' => 'select',
                            'value' => '',
                            'label' => esc_html__('Revolution Slider', 'listingo'),
                            'desc' => esc_html__('Please Select Revolution slider.', 'listingo'),
                            'help' => esc_html__('Please install revolution slider first.', 'listingo'),
                            'choices' => listingo_prepare_rev_slider(),
                        ),
                    ),
                    'custom_shortcode' => array(
                        'custom_shortcode' => array(
                            'type' => 'textarea',
                            'value' => '',
                            'desc' => esc_html__('Custom Shortcode, You can add any shortcode here.', 'listingo'),
                            'label' => esc_html__('Custom Shortcode', 'listingo'),
                        ),
                    ),
                )
            ),
        )
    ),
);

