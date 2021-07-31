<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array(
    'colors' => array(
        'title' => esc_html__('Styling Options', 'listingo'),
        'type' => 'tab',
        'options' => array(
            'general-box' => array(
                'title' => esc_html__('Styling Options', 'listingo'),
                'type' => 'box',
                'options' => array(
                    'color_settings' => array(
                        'type' => 'multi-picker',
                        'label' => false,
                        'desc' => '',
                        'picker' => array(
                            'gadget' => array(
                                'label' => esc_html__('Styling Options', 'listingo'),
                                'type' => 'switch',
                                'left-choice' => array(
                                    'value' => 'default',
                                    'label' => esc_html__('Default Color', 'listingo')
                                ),
                                'right-choice' => array(
                                    'value' => 'custom',
                                    'label' => esc_html__('Custom Color', 'listingo')
                                ),
                                'value' => 'disbale',
                            )
                        ),
                        'choices' => array(
                            'custom' => array(
                                'primary_color' => array(
                                    'type' => 'color-picker',
                                    'value' => '#5dc560',
                                    'attr' => array(),
                                    'label' => esc_html__('Primary Color', 'listingo'),
                                    'desc' => esc_html__('Add theme primary color.', 'listingo'),
                                    'help' => esc_html__('', 'listingo'),
                                ),
                            ),
                            'default' => array(),
                        ),
                        'show_borders' => false,
                    ),
					'tags_styling' => array(
                        'type' => 'multi-picker',
                        'label' => false,
                        'desc' => '',
                        'picker' => array(
                            'gadget' => array(
                                'label' => esc_html__('Tags styling', 'listingo'),
                                'type' => 'switch',
                                'left-choice' => array(
                                    'value' => 'default',
                                    'label' => esc_html__('Default Color', 'listingo')
                                ),
                                'right-choice' => array(
                                    'value' => 'custom',
                                    'label' => esc_html__('Custom Color', 'listingo')
                                ),
                                'value' => 'disbale',
                            )
                        ),
                        'choices' => array(
                            'custom' => array(
                                'featured_text' => array(
                                    'type' => 'color-picker',
                                    'value' => '#FFF',
                                    'label' => esc_html__('Featured tag color?', 'listingo'),
                                    'desc' => esc_html__('Add featured tag text color.', 'listingo'),
                                ),
								'featured_bg' => array(
                                    'type' => 'color-picker',
                                    'value' => '#dd3333',
                                    'label' => esc_html__('Featured tag background?', 'listingo'),
                                    'desc' => esc_html__('Add featured tag background color.', 'listingo'),
                                ),
								'verified_text' => array(
                                    'type' => 'color-picker',
                                    'value' => '#FFF',
                                    'label' => esc_html__('Verified tag color?', 'listingo'),
                                    'desc' => esc_html__('Add verified tag text color.', 'listingo'),
                                ),
								'verified_bg' => array(
                                    'type' => 'color-picker',
                                    'value' => '#4caf50',
                                    'label' => esc_html__('Verified tag background?', 'listingo'),
                                    'desc' => esc_html__('Add verified tag background color.', 'listingo'),
                                ),
                            ),
                            'default' => array(),
                        ),
                        'show_borders' => false,
                    ),
                )
            ),
        )
    )
);
