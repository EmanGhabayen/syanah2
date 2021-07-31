<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array (
    'typo' => array (
        'title'   => esc_html__('Typo Settings' , 'listingo') ,
        'type'    => 'tab' ,
        'options' => array (
            'typo-box' => array (
                'title'   => esc_html__('Typography Settings' , 'listingo') ,
                'type'    => 'box' ,
                'options' => array (
                    'enable_typo' => array (
                        'type'         => 'switch' ,
                        'value'        => 'off' ,
                        'attr'         => array (
                            'class'    => 'custom-class' ,
                            'data-foo' => 'bar' ) ,
                        'label'        => esc_html__('Typography' , 'listingo') ,
                        'desc'         => esc_html__('Please enable settings to user typography' , 'listingo') ,
                        'left-choice'  => array (
                            'value' => 'off' ,
                            'label' => esc_html__('Off' , 'listingo') ,
                        ) ,
                        'right-choice' => array (
                            'value' => 'on' ,
                            'label' => esc_html__('ON' , 'listingo') ,
                        ) ,
                    ) ,
					'body_font' => array(
						'label'      => __( 'Regular Font', 'listingo' ),
						'desc'       => esc_html__('Default Font for body ul li' , 'listingo') ,
						'type'       => 'typography-v2',
						'value'      => array(
							'family'         => 'Arial',
							'subset'         => 'latin-ext',
							'variation'      => 'regular',
							'size'           => 14,
							'line-height'    => 20,
							'letter-spacing' => 0,
							'color'          => '#919191'
						),
						'components' => array(
							'family'         => true,
							'size'           => true,
							'line-height'    => true,
							'letter-spacing' => true,
							'color'          => true
						),
					),
					'body_p' => array(
						'label'      => __( 'Body paragraph', 'listingo' ),
						'desc'       => esc_html__('Default Font for body paragraph' , 'listingo') ,
						'type'       => 'typography-v2',
						'value'      => array(
							'family'         => 'Arial',
							'subset'         => 'latin-ext',
							'variation'      => 'regular',
							'size'           => 14,
							'line-height'    => 20,
							'letter-spacing' => 0,
							'color'          => '#919191'
						),
						'components' => array(
							'family'         => true,
							'size'           => true,
							'line-height'    => true,
							'letter-spacing' => true,
							'color'          => true
						),
					),
                    'h1_font'     => array (
                        'type'       => 'typography-v2' ,
                        'value'      => array (
                            'family'         => 'Arial',
							'subset'         => 'latin-ext',
							'variation'      => 'regular',
							'size'           => 14,
							'line-height'    => 20,
							'letter-spacing' => 0,
							'color'          => '#333'
                        ) ,
                        'components' => array (
                            'family'         => true,
							'size'           => true,
							'line-height'    => true,
							'letter-spacing' => true,
							'color'          => true
                        ) ,
                        'label'      => esc_html__('H1 Heading' , 'listingo') ,
                        'desc'       => esc_html__('Choose Your H1 Heading font-family, font-size, color, font-weight.' , 'listingo') ,
                    ) ,
                    'h2_font'     => array (
                        'type'       => 'typography-v2' ,
                        'value'      => array (
                            'family'         => 'Arial',
							'subset'         => 'latin-ext',
							'variation'      => 'regular',
							'size'           => 14,
							'line-height'    => 20,
							'letter-spacing' => 0,
							'color'          => '#333'
                        ) ,
                        'components' => array (
                            'family'         => true,
							'size'           => true,
							'line-height'    => true,
							'letter-spacing' => true,
							'color'          => true
                        ) ,
                        'label'      => esc_html__('H2 Heading' , 'listingo') ,
                        'desc'       => esc_html__('Choose Your H2 Heading font-family, font-size, color, font-weight.' , 'listingo') ,
                    ) ,
                    'h3_font'     => array (
                        'type'       => 'typography-v2' ,
                        'value'      => array (
                            'family'         => 'Arial',
							'subset'         => 'latin-ext',
							'variation'      => 'regular',
							'size'           => 14,
							'line-height'    => 20,
							'letter-spacing' => 0,
							'color'          => '#333'
                        ) ,
                        'components' => array (
                           'family'         => true,
							'size'           => true,
							'line-height'    => true,
							'letter-spacing' => true,
							'color'          => true
                        ) ,
                        'label'      => esc_html__('H3 Heading' , 'listingo') ,
                        'desc'       => esc_html__('Choose Your H3 Heading font-family, font-size, color, font-weight.' , 'listingo') ,
                    ) ,
                    'h4_font'     => array (
                        'type'       => 'typography-v2' ,
                        'value'      => array (
                            'family'         => 'Arial',
							'subset'         => 'latin-ext',
							'variation'      => 'regular',
							'size'           => 14,
							'line-height'    => 20,
							'letter-spacing' => 0,
							'color'          => '#333'
                        ) ,
                        'components' => array (
                            'family'         => true,
							'size'           => true,
							'line-height'    => true,
							'letter-spacing' => true,
							'color'          => true
                        ) ,
                        'label'      => esc_html__('H4 Heading' , 'listingo') ,
                        'desc'       => esc_html__('Choose Your H4 Heading font-family, font-size, color, font-weight.' , 'listingo') ,
                    ) ,
                    'h5_font'     => array (
                        'type'       => 'typography-v2' ,
                        'value'      => array (
                            'family'         => 'Arial',
							'subset'         => 'latin-ext',
							'variation'      => 'regular',
							'size'           => 14,
							'line-height'    => 20,
							'letter-spacing' => 0,
							'color'          => '#333'
                        ) ,
                        'components' => array (
                            'family'         => true,
							'size'           => true,
							'line-height'    => true,
							'letter-spacing' => true,
							'color'          => true
                        ) ,
                        'label'      => esc_html__('H5 Heading' , 'listingo') ,
                        'desc'       => esc_html__('Choose Your H5 Heading font-family, font-size, color, font-weight.' , 'listingo') ,
                    ) ,
                    'h6_font'     => array (
                        'type'       => 'typography-v2' ,
                        'value'      => array (
                            'family'         => 'Arial',
							'subset'         => 'latin-ext',
							'variation'      => 'regular',
							'size'           => 14,
							'line-height'    => 20,
							'letter-spacing' => 0,
							'color'          => '#333'
                        ) ,
                        'components' => array (
                            'family'         => true,
							'size'           => true,
							'line-height'    => true,
							'letter-spacing' => true,
							'color'          => true
                        ) ,
                        'label'      => esc_html__('H6 Heading' , 'listingo') ,
                        'desc'       => esc_html__('Choose Your H6 Heading font-family, font-size, color, font-weight.' , 'listingo') ,
                    ) ,
                )
            ) ,
        )
    )
);
