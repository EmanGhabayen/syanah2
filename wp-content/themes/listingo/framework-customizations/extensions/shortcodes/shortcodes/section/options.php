<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'general_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('Genral Settings', 'listingo'),
        'options' => array(
            'section_heading' => array(
                'label' => esc_html__('Section Heading', 'listingo'),
                'desc' => esc_html__('Enter Your Section Heading Here', 'listingo'),
                'type' => 'text',
            ),
            'is_fullwidth' => array(
                'type' => 'select',
                'value' => 'default',
                'attr' => array(),
                'label' => esc_html__('Section Settings', 'listingo'),
                'desc' => esc_html__('Select Section Settings', 'listingo'),
                'help' => esc_html__('', 'listingo'),
                'choices' => array(
                    'default' => esc_html__('Default', 'listingo'),
                    'stretch_section' => esc_html__('Stretch Section', 'listingo'),
                    'stretch_section_contents' => esc_html__('Stretch Section With Contents', 'listingo'),
                    'stretch_section_contents_corner' => esc_html__('Stretch Section With Contents(No Padding)', 'listingo'),
                ),
            ),
            'background_color' => array(
                'label' => esc_html__('Background Color', 'listingo'),
                'desc' => esc_html__('Please select the background color', 'listingo'),
                'type' => 'rgba-color-picker',
				'value' => '',
            ),
            'background_image' => array(
                'label' => esc_html__('Background Image', 'listingo'),
                'desc' => esc_html__('Please select the background image', 'listingo'),
                'type' => 'background-image',
                'choices' => array(//	in future may will set predefined images
                )
            ),
            'background_repeat' => array(
                'type' => 'select',
                'value' => 'no-repeat',
                'attr' => array(),
                'label' => esc_html__('Background Repeat', 'listingo'),
                'desc' => esc_html__('Repeat Background', 'listingo'),
                'help' => esc_html__('', 'listingo'),
                'choices' => array(
                    'no-repeat' => esc_html__('No Repeat', 'listingo'),
                    'repeat' => esc_html__('Repeat', 'listingo'),
                    'repeat-x' => esc_html__('Repeat X', 'listingo'),
                    'repeat-y' => esc_html__('Repeat Y', 'listingo'),
                ),
            ),
            'positioning_x' => array(
                'type' => 'slider',
                'value' => 0,
                'properties' => array(
                    'min' => -100,
                    'max' => 100,
                    'sep' => 1,
                ),
                'desc' => esc_html__('Background position Horizontally', 'listingo'),
                'label' => esc_html__('Position X, IN ( % )', 'listingo'),
            ),
            'positioning_y' => array(
                'type' => 'slider',
                'value' => 100,
                'properties' => array(
                    'min' => -100,
                    'max' => 100,
                    'sep' => 1,
                ),
                'desc' => esc_html__('Background position Vertically', 'listingo'),
                'label' => esc_html__('Position Y, IN ( % )', 'listingo'),
            ),
            'video' => array(
                'label' => esc_html__('Background Video', 'listingo'),
                'desc' => esc_html__('Insert Video URL to embed this video', 'listingo'),
                'type' => 'text',
				'help' => esc_html__('Note: Mobile browsers do not allow videos to auto play due to bandwidth concerns. Background will not attempt to load videos on mobile devices, instead the poster image will be displayed.', 'listingo'),
            ),
            'custom_id' => array(
                'label' => esc_html__('Custom ID', 'listingo'),
                'desc' => esc_html__('Add Custom ID', 'listingo'),
                'type' => 'text',
            ),
            'custom_classes' => array(
                'label' => esc_html__('Custom Classes', 'listingo'),
                'desc' => esc_html__('Add Custom Classes', 'listingo'),
                'type' => 'text',
            )
        )
    ),
    'margin_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('Margin', 'listingo'),
        'options' => array(
            'margin_top' => array(
                'type' => 'text',
                'value' => '',
                'label' => esc_html__('Margin Top', 'listingo'),
                'desc' => esc_html__('add margin, Leave it empty to hide, Note: add only integer value as : 10', 'listingo'),
            ),
            'margin_bottom' => array(
                'type' => 'text',
                'value' => '',
                'label' => esc_html__('Margin Bottom', 'listingo'),
                'desc' => esc_html__('add margin, Leave it empty to hide, Note: add only integer value as : 10', 'listingo'),
            ),
            'margin_left' => array(
                'type' => 'text',
                'value' => '',
                'label' => esc_html__('Margin Left', 'listingo'),
                'desc' => esc_html__('add margin, Leave it empty to hide, Note: add only integer value as : 10', 'listingo'),
            ),
            'margin_right' => array(
                'type' => 'text',
                'value' => '',
                'label' => esc_html__('Margin Right', 'listingo'),
                'desc' => esc_html__('add margin, Leave it empty to hide, Note: add only integer value as : 10', 'listingo'),
            ),
        )
    ),
    'padding_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('Padding', 'listingo'),
        'options' => array(
            'padding_top' => array(
                'type' => 'text',
                'value' => '',
                'label' => esc_html__('Padding Top', 'listingo'),
                'desc' => esc_html__('add padding, Leave it empty to hide, Note: add only integer value as : 10', 'listingo'),
            ),
            'padding_bottom' => array(
                'type' => 'text',
                'value' => '',
                'label' => esc_html__('Padding Bottom', 'listingo'),
                'desc' => esc_html__('add padding, Leave it empty to hide, Note: add only integer value as : 10', 'listingo'),
            ),
            'padding_left' => array(
                'type' => 'text',
                'value' => '',
                'label' => esc_html__('Padding Left', 'listingo'),
                'desc' => esc_html__('add padding, Leave it empty to hide, Note: add only integer value as : 10', 'listingo'),
            ),
            'padding_right' => array(
                'type' => 'text',
                'value' => '',
                'label' => esc_html__('Padding Right', 'listingo'),
                'desc' => esc_html__('add padding, Leave it empty to hide, Note: add only integer value as : 10', 'listingo'),
            ),
        )
    ),
    'parallax_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('Parallax', 'listingo'),
        'options' => array(
            'parallax' => array(
                'label' => esc_html__('Parallax', 'listingo'),
                'desc' => esc_html__('Use background image as parallax.', 'listingo'),
                'type' => 'switch',
                'value' => 'off',
                'left-choice' => array(
                    'value' => 'on',
                    'label' => esc_html__('ON', 'listingo'),
                ),
                'right-choice' => array(
                    'value' => 'off',
                    'label' => esc_html__('OFF', 'listingo'),
                ),
            ),
            'parallax_bleed' => array(
                'type' => 'slider',
                'value' => 0,
                'properties' => array(
                    'min' => 0,
                    'max' => 500,
                    'sep' => 1,
                ),
                'label' => esc_html__('Parallax Data Bleed', 'listingo'),
            ),
            'parallax_speed' => array(
                'type' => 'select',
                'value' => 'no-repeat',
                'attr' => array(),
                'label' => esc_html__('Parallax Speed', 'listingo'),
                'desc' => esc_html__('Choose Your Parallax Speed', 'listingo'),
                'help' => esc_html__('', 'listingo'),
                'choices' => array(
                    '0' => esc_html__('0', 'listingo'),
                    '0.1' => esc_html__('0.1', 'listingo'),
                    '0.2' => esc_html__('0.2', 'listingo'),
                    '0.3' => esc_html__('0.3', 'listingo'),
                    '0.4' => esc_html__('0.4', 'listingo'),
                    '0.5' => esc_html__('0.5', 'listingo'),
                    '0.6' => esc_html__('0.6', 'listingo'),
                    '0.7' => esc_html__('0.7', 'listingo'),
                    '0.8' => esc_html__('0.8', 'listingo'),
                    '0.9' => esc_html__('0.9', 'listingo'),
                    '1.0' => esc_html__('1.0', 'listingo'),
                ),
            ),
        )
    ),
    'sidebars' => array(
        'type' => 'tab',
        'title' => esc_html__('Sidebar', 'listingo'),
        'options' => array(
            'sidebar' => array(
                'type' => 'multi-picker',
                'label' => false,
                'desc' => false,
                'value' => array('gadget' => 'full'),
                'picker' => array(
                    'gadget' => array(
                        'label' => esc_html__('Section Sidebar', 'listingo'),
                        'type' => 'image-picker',
                        'choices' => array(
                            'full' => get_template_directory_uri() . '/images/sidebars/full.png',
                            'left' => get_template_directory_uri() . '/images/sidebars/left.png',
                            'right' => get_template_directory_uri() . '/images/sidebars/right.png',
                        )
                    )
                ),
                'choices' => array(
                    'full' => array(),
                    'left' => array(
                        'left_sidebar' => array(
                            'type' => 'select',
                            'value' => '',
                            'attr' => array(),
                            'label' => esc_html__('Select Sidebar', 'listingo'),
                            'desc' => esc_html__('Select Left Sidebar', 'listingo'),
                            'help' => esc_html__('', 'listingo'),
                            'choices' => listingo_get_registered_sidebars(),
                        ),
                    ),
                    'right' => array(
                        'right_sidebar' => array(
                            'type' => 'select',
                            'value' => '',
                            'attr' => array(),
                            'label' => esc_html__('Select Sidebar', 'listingo'),
                            'desc' => esc_html__('Select Right Sidebar', 'listingo'),
                            'help' => esc_html__('', 'listingo'),
                            'choices' => listingo_get_registered_sidebars(),
                        ),
                    ),
                )
            )
        )
    ),
);
