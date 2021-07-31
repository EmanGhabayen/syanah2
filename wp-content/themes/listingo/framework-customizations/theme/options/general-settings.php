<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array(
    'general' => array(
        'title' => esc_html__('General Settings', 'listingo'),
        'type' => 'tab',
        'options' => array(
            'general-box' => array(
                'title' => esc_html__('General Settings', 'listingo'),
                'type' => 'box',
                'options' => array(
                    'preloader' => array(
                        'type' => 'multi-picker',
                        'label' => false,
                        'desc' => false,
                        'picker' => array(
                            'gadget' => array(
                                'label' => esc_html__('Enable Preloader', 'listingo'),
                                'type' => 'switch',
                                'value' => 'enable',
                                'desc' => esc_html__('Preloader on/off', 'listingo'),
                                'left-choice' => array(
                                    'value' => 'enable',
                                    'label' => esc_html__('Enable', 'listingo'),
                                ),
                                'right-choice' => array(
                                    'value' => 'disable',
                                    'label' => esc_html__('Disable', 'listingo'),
                                ),
                            )
                        ),
                        'choices' => array(
                            'enable' => array(
                                'preloader' => array(
                                    'type' => 'multi-picker',
                                    'label' => false,
                                    'desc' => false,
                                    'picker' => array(
                                        'gadget' => array(
                                            'type' => 'select',
                                            'value' => 'default',
                                            'label' => esc_html__('Select Type', 'listingo'),
                                            'desc' => esc_html__('Please select loader type.', 'listingo'),
                                            'choices' => array(
                                                'default' => esc_html__('Default', 'listingo'),
                                                'custom' => esc_html__('Custom', 'listingo'),
                                            ),
                                        )
                                    ),
                                    'choices' => array(
                                        'custom' => array(
                                            'loader' => array(
                                                'type' => 'upload',
                                                'label' => esc_html__('Loader Image?', 'listingo'),
                                                'desc' => esc_html__('Upload loader image.', 'listingo'),
                                                'images_only' => true,
                                            ),
                                        ),
                                    ),
                                ),
                                'loader_speed' => array(
                                    'type' => 'select',
                                    'value' => '1000',
                                    'label' => esc_html__('Loader duration?', 'listingo'),
                                    'desc' => esc_html__('Seelct site loader speed', 'listingo'),
                                    'choices' => array(
                                        '250' => esc_html__('1/4th Seconds', 'listingo'),
                                        '500' => esc_html__('Half Second', 'listingo'),
                                        '1000' => esc_html__('1 Second', 'listingo'),
                                        '2000' => esc_html__('2 Seconds', 'listingo'),
                                        '3000' => esc_html__('3 Seconds', 'listingo'),
                                        '4000' => esc_html__('4 Seconds', 'listingo'),
                                        '5000' => esc_html__('5 Seconds', 'listingo'),
                                    ),
                                )
                            ),
                        )
                    ),
                    '404_logo' => array(
                        'type' => 'upload',
                        'label' => esc_html__('Upload Logo', 'listingo'),
                        'desc' => esc_html__('Upload 404 page logo, Preferred size is 370 by 270.', 'listingo'),
                        'images_only' => true,
                    ),
                    '404_title' => array(
                        'type' => 'text',
                        'value' => 'Oooops!',
                        'label' => esc_html__('404 Title', 'listingo'),
                    ),
                    '404_sub_title' => array(
                        'type' => 'text',
                        'value' => 'The page you are looking for does not exist.',
                        'label' => esc_html__('404 Sub Title', 'listingo'),
                    ),
                    '404_description' => array(
                        'type' => 'textarea',
                        'value' => '',
                        'label' => esc_html__('404 Description', 'listingo'),
                    ),
                    'custom_css' => array(
                        'type' => 'textarea',
                        'label' => esc_html__('Custom CSS', 'listingo'),
                        'desc' => esc_html__('Add your custom css code here if you want to target specifically on different elements.', 'listingo'),
                    ),
                )
            ),
        )
    )
);
