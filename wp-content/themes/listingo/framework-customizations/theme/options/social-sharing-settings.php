<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array (
    'social_sharing' => array (
        'title'   => esc_html__('Sharing Sharing' , 'listingo') ,
        'type'    => 'tab' ,
        'options' => array (
            'social_facebook'  => array (
                'label'        => esc_html__('Faceobook' , 'listingo') ,
                'type'         => 'switch' ,
                'value'        => 'enable' ,
                'desc'         => esc_html__('Sharing on/off' , 'listingo') ,
                'left-choice'  => array (
                    'value' => 'enable' ,
                    'label' => esc_html__('Enable' , 'listingo') ,
                ) ,
                'right-choice' => array (
                    'value' => 'disable' ,
                    'label' => esc_html__('Disable' , 'listingo') ,
                ) ,
            ) ,
			'social_twitter' => array(
				'type'         => 'multi-picker',
				'label'        => false,
				'desc'         => false,
				'picker'       => array(
					'gadget' => array(
						'label'        => esc_html__('Twitter' , 'listingo') ,
						'type'         => 'switch' ,
						'value'        => 'enable' ,
						'desc'         => esc_html__('Sharing on/off' , 'listingo') ,
						'left-choice'  => array (
							'value' => 'enable' ,
							'label' => esc_html__('Enable' , 'listingo') ,
						) ,
						'right-choice' => array (
							'value' => 'disable' ,
							'label' => esc_html__('Disable' , 'listingo') ,
						) ,
					)
				),
				'choices'      => array(
					'enable'  => array(
						'twitter_username' => array (
							'type'  => 'text' ,
							'value' => '' ,
							'label' => esc_html__('Twitter username' , 'listingo') ,
							'desc'  => esc_html__('This will be used in the tweet for the via parameter. The site name will be used if no twitter username is provided. Do not include the @' , 'listingo') ,
						) ,
					),
				)
			),
			'social_gmail'   => array (
                'label'        => esc_html__('Google Share' , 'listingo') ,
                'type'         => 'switch' ,
                'value'        => 'enable' ,
                'desc'         => esc_html__('Sharing on/off' , 'listingo') ,
                'left-choice'  => array (
                    'value' => 'enable' ,
                    'label' => esc_html__('Enable' , 'listingo') ,
                ) ,
                'right-choice' => array (
                    'value' => 'disable' ,
                    'label' => esc_html__('Disable' , 'listingo') ,
                ) ,
            ) ,
			'social_pinterest'   => array (
                'label'        => esc_html__('Pinterest Share' , 'listingo') ,
                'type'         => 'switch' ,
                'value'        => 'enable' ,
                'desc'         => esc_html__('Sharing on/off' , 'listingo') ,
                'left-choice'  => array (
                    'value' => 'enable' ,
                    'label' => esc_html__('Enable' , 'listingo') ,
                ) ,
                'right-choice' => array (
                    'value' => 'disable' ,
                    'label' => esc_html__('Disable' , 'listingo') ,
                ) ,
            ) ,
        ) ,
    ) ,
);
