<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'general_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('General Settings', 'listingo'),
        'options' => array(
            'custom_classes' => array(
                'label' => esc_html__('Custom Classes', 'listingo'),
                'desc' => esc_html__('Add Custom Classes', 'listingo'),
                'type' => 'text',
            ),
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
        ),
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
    'responsive_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('Responsive Settings', 'listingo'),
        'options' => array(
			'xs_settings' => array(
				'type' => 'tab',
				'title' => esc_html__('Extra small', 'listingo'),
				'options' => array(
					'extra_small_switch' => array(
						'label' => esc_html__('Extra small Screen', 'listingo'),
						'desc' => esc_html__('Show/hide Small Screen Settings', 'listingo'),
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
					'extra_small' => array(
						'type' => 'select',
						'value' => 'no-repeat',
						'attr' => array(),
						'label' => esc_html__('Small Screen Class', 'listingo'),
						'desc' => esc_html__('Choose Your Small Screen Class', 'listingo'),
						'help' => esc_html__('', 'listingo'),
						'choices' => array(
							'col-xs-1' => esc_html__('col-xs-1', 'listingo'),
							'col-sm-2' => esc_html__('col-xs-2', 'listingo'),
							'col-xs-3' => esc_html__('col-xs-3', 'listingo'),
							'col-xs-4' => esc_html__('col-xs-4', 'listingo'),
							'col-xs-5' => esc_html__('col-xs-5', 'listingo'),
							'col-xs-6' => esc_html__('col-xs-6', 'listingo'),
							'col-xs-7' => esc_html__('col-xs-7', 'listingo'),
							'col-xs-8' => esc_html__('col-xs-8', 'listingo'),
							'col-xs-9' => esc_html__('col-xs-9', 'listingo'),
							'col-xs-10' => esc_html__('col-xs-10', 'listingo'),
							'col-xs-11' => esc_html__('col-xs-11', 'listingo'),
							'col-xs-12' => esc_html__('col-xs-12', 'listingo'),
						),
					),
				),
			),
			'sm_settings' => array(
				'type' => 'tab',
				'title' => esc_html__('Small Screen', 'listingo'),
				'options' => array(
					'responsive_switch' => array(
						'label' => esc_html__('Responsive Settings', 'listingo'),
						'desc' => esc_html__('Show/hide Small Screen Settings', 'listingo'),
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
					'responsive_classes' => array(
						'type' => 'select',
						'value' => 'no-repeat',
						'attr' => array(),
						'label' => esc_html__('Small Screen Class', 'listingo'),
						'desc' => esc_html__('Choose Your Small Screen Class', 'listingo'),
						'help' => esc_html__('', 'listingo'),
						'choices' => array(
							'col-sm-1' => esc_html__('col-sm-1', 'listingo'),
							'col-sm-2' => esc_html__('col-sm-2', 'listingo'),
							'col-sm-3' => esc_html__('col-sm-3', 'listingo'),
							'col-sm-4' => esc_html__('col-sm-4', 'listingo'),
							'col-sm-5' => esc_html__('col-sm-5', 'listingo'),
							'col-sm-6' => esc_html__('col-sm-6', 'listingo'),
							'col-sm-7' => esc_html__('col-sm-7', 'listingo'),
							'col-sm-8' => esc_html__('col-sm-8', 'listingo'),
							'col-sm-9' => esc_html__('col-sm-9', 'listingo'),
							'col-sm-10' => esc_html__('col-sm-10', 'listingo'),
							'col-sm-11' => esc_html__('col-sm-11', 'listingo'),
							'col-sm-12' => esc_html__('col-sm-12', 'listingo'),
						),
					),
				),
			),
            'md_settings' => array(
				'type' => 'tab',
				'title' => esc_html__('Medium Screen', 'listingo'),
				'options' => array(
					'medium_switch' => array(
						'label' => esc_html__('Medium Screen Settings', 'listingo'),
						'desc' => esc_html__('Show/hide Medium Screen Settings', 'listingo'),
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
					'medium_classes' => array(
						'type' => 'select',
						'value' => 'no-repeat',
						'attr' => array(),
						'label' => esc_html__('Medium Screen Class', 'listingo'),
						'desc' => esc_html__('Choose Your Medium Screen Class', 'listingo'),
						'help' => esc_html__('', 'listingo'),
						'choices' => array(
							'col-md-1' => esc_html__('col-md-1', 'listingo'),
							'col-md-2' => esc_html__('col-md-2', 'listingo'),
							'col-md-3' => esc_html__('col-md-3', 'listingo'),
							'col-md-4' => esc_html__('col-md-4', 'listingo'),
							'col-md-5' => esc_html__('col-md-5', 'listingo'),
							'col-md-6' => esc_html__('col-md-6', 'listingo'),
							'col-md-7' => esc_html__('col-md-7', 'listingo'),
							'col-md-8' => esc_html__('col-md-8', 'listingo'),
							'col-md-9' => esc_html__('col-md-9', 'listingo'),
							'col-md-10' => esc_html__('col-md-10', 'listingo'),
							'col-md-11' => esc_html__('col-md-11', 'listingo'),
							'col-md-12' => esc_html__('col-md-12', 'listingo'),
						),
					),
				),
			),
			'lg_settings' => array(
				'type' => 'tab',
				'title' => esc_html__('Large Screen', 'listingo'),
				'options' => array(
					'large_switch' => array(
						'label' => esc_html__('Large Screen Settings', 'listingo'),
						'desc' => esc_html__('Show/hide Large Screen Settings', 'listingo'),
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
					'large_classes' => array(
						'type' => 'select',
						'value' => 'no-repeat',
						'attr' => array(),
						'label' => esc_html__('Large Screen Class', 'listingo'),
						'desc' => esc_html__('Choose Your Large Screen Class', 'listingo'),
						'help' => esc_html__('', 'listingo'),
						'choices' => array(
							'col-lg-1' => esc_html__('col-lg-1', 'listingo'),
							'col-lg-2' => esc_html__('col-lg-2', 'listingo'),
							'col-lg-3' => esc_html__('col-lg-3', 'listingo'),
							'col-lg-4' => esc_html__('col-lg-4', 'listingo'),
							'col-lg-5' => esc_html__('col-lg-5', 'listingo'),
							'col-lg-6' => esc_html__('col-lg-6', 'listingo'),
							'col-lg-7' => esc_html__('col-lg-7', 'listingo'),
							'col-lg-8' => esc_html__('col-lg-8', 'listingo'),
							'col-lg-9' => esc_html__('col-lg-9', 'listingo'),
							'col-lg-10' => esc_html__('col-lg-10', 'listingo'),
							'col-lg-11' => esc_html__('col-lg-11', 'listingo'),
							'col-lg-12' => esc_html__('col-lg-12', 'listingo'),
						),
					),
				),
			),
        )
    ),
);
