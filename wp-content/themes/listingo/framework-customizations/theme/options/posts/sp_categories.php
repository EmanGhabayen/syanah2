<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'category_general_settings' => array(
        'title' => esc_html__('General Settings', 'listingo'),
        'type' => 'box',
        'options' => array(
            'appointments' => array(
                'type' => 'switch',
                'value' => 'disable',
                'label' => esc_html__('Appointment', 'listingo'),
                'desc' => esc_html__('Enable/Disable Appointment Button.', 'listingo'),
                'left-choice' => array(
                    'value' => 'disable',
                    'label' => esc_html__('Disable', 'listingo'),
                ),
                'right-choice' => array(
                    'value' => 'enable',
                    'label' => esc_html__('Enable', 'listingo'),
                ),
            ),
			'articles' => array(
                'type' => 'switch',
                'value' => 'enable',
                'label' => esc_html__('Articles?', 'listingo'),
                'desc' => esc_html__('Enable/Disable articles. Providers get registered under this category will be able to create articles.', 'listingo'),
                'left-choice' => array(
                    'value' => 'disable',
                    'label' => esc_html__('Disable', 'listingo'),
                ),
                'right-choice' => array(
                    'value' => 'enable',
                    'label' => esc_html__('Enable', 'listingo'),
                ),
            ),
			'qa' => array(
                'type' => 'switch',
                'value' => 'enable',
                'label' => esc_html__('Questions and Answers?', 'listingo'),
                'desc' => esc_html__('Enable/Disable Questions and Answers. Providers get registered under this category will be able to show post questions on their detail page.', 'listingo'),
                'left-choice' => array(
                    'value' => 'disable',
                    'label' => esc_html__('Disable', 'listingo'),
                ),
                'right-choice' => array(
                    'value' => 'enable',
                    'label' => esc_html__('Enable', 'listingo'),
                ),
            ),
            'experience' => array(
				'type' => 'switch',
				'value' => 'disable',
				'attr' => array(),
				'label' => esc_html__('Experience', 'listingo'),
				'desc' => esc_html__('Enable/Disable Experience', 'listingo'),
				'left-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'listingo'),
				),
				'right-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'listingo'),
				),
			),
            'awards' => array(
				'type' => 'switch',
				'value' => 'disable',
				'attr' => array(),
				'label' => esc_html__('Awards', 'listingo'),
				'desc' => esc_html__('Enable/Disable Certification & Awards', 'listingo'),
				'left-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'listingo'),
				),
				'right-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'listingo'),
				),
			),
            'qualifications' => array(
				'type' => 'switch',
				'value' => 'disable',
				'attr' => array(),
				'label' => esc_html__('Qualifications', 'listingo'),
				'desc' => esc_html__('Enable/Disable Qualifications', 'listingo'),
				'left-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'listingo'),
				),
				'right-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'listingo'),
				),
			),
            'amenities' => array(
				'type' => 'switch',
				'value' => 'disable',
				'attr' => array(),
				'label' => esc_html__('Amenities/Features', 'listingo'),
				'desc' => esc_html__('Enable/Disable Amenities/Features', 'listingo'),
				'left-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'listingo'),
				),
				'right-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'listingo'),
				),
			),
            'teams' => array(
				'type' => 'switch',
				'value' => 'disable',
				'attr' => array(),
				'label' => esc_html__('Teams', 'listingo'),
				'desc' => esc_html__('Enable/Disable Teams', 'listingo'),
				'left-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'listingo'),
				),
				'right-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'listingo'),
				),
			),
            'gallery' => array(
				'type' => 'switch',
				'value' => 'disable',
				'attr' => array(),
				'label' => esc_html__('Gallery', 'listingo'),
				'desc' => esc_html__('Enable/Disable Gallery', 'listingo'),
				'left-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'listingo'),
				),
				'right-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'listingo'),
				),
			),
            'videos' => array(
				'type' => 'switch',
				'value' => 'disable',
				'attr' => array(),
				'label' => esc_html__('Videos', 'listingo'),
				'desc' => esc_html__('Enable/Disable Videos', 'listingo'),
				'left-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'listingo'),
				),
				'right-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'listingo'),
				),
			),
			'insurance' => array(
				'type' => 'switch',
				'value' => 'disable',
				'attr' => array(),
				'label' => esc_html__('Insurance', 'listingo'),
				'desc' => esc_html__('Enable/Disable insurance plans', 'listingo'),
				'left-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'listingo'),
				),
				'right-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'listingo'),
				),
			),
			'brochures' => array(
				'type' => 'switch',
				'value' => 'disable',
				'attr' => array(),
				'label' => esc_html__('Brochures', 'listingo'),
				'desc' => esc_html__('Enable/Disable brochures', 'listingo'),
				'left-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'listingo'),
				),
				'right-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'listingo'),
				),
			),
            'claims' => array(
                'type' => 'switch',
                'value' => 'enable',
                'label' => esc_html__('Enable Claims/Reports', 'listingo'),
                'desc' => esc_html__('Enable or disable claims/reports for this Category type.', 'listingo'),
                'help' => esc_html__('', 'listingo'),
                'left-choice' => array(
                    'value' => 'disable',
                    'label' => esc_html__('Disable', 'listingo'),
                ),
                'right-choice' => array(
					'value' => 'enable',
                    'label' => esc_html__('enable', 'listingo'),
                ),
            ),
			'favorite' => array(
				'type' => 'switch',
				'value' => 'enable',
				'attr' => array(),
				'label' => esc_html__('Favorite', 'listingo'),
				'desc' => esc_html__('Enable/Disable favorite listings. Providers get registered under this category will be able to add users in their wishlist.', 'listingo'),
				'left-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'listingo'),
				),
				'right-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'listingo'),
				),
			),
			'facebook_chat' => array(
                'type' => 'switch',
                'value' => 'enable',
                'label' => esc_html__('Facebook Chat?', 'listingo'),
                'desc' => esc_html__('Enable or disable facebook customer chat module. Providers get registered under this category will be able to show facebook customer chat messanger on their profile.', 'listingo'),
                'left-choice' => array(
                    'value' => 'disable',
                    'label' => esc_html__('Disable', 'listingo'),
                ),
                'right-choice' => array(
                    'value' => 'enable',
                    'label' => esc_html__('Enable', 'listingo'),
                ),
            ),
        )
    ),
    'category_media_settings' => array(
        'title' => esc_html__('Media Settings', 'listingo'),
        'type' => 'box',
        'context' => 'side',
        'priority' => 'high',
        'options' => array(
            'category_color' => array(
                'type' => 'color-picker',
                'palettes' => array(
                    '#ef5350',
                    '#ec407a',
                    '#ab47bc',
                    '#7e57c2',
                    '#5c6bc0',
                    '#42a5f5',
                    '#29b6f6',
                    '#26c6da'
                ),
                'label' => esc_html__('Category color?', 'listingo'),
                'desc' => esc_html__('Add category color for text or backgrounds.', 'listingo'),
            ),
            'category_icon' => array(
                'type' => 'icon-v2',
                'preview_size' => 'small',
                'modal_size' => 'medium',
                'attr' => array('class' => 'custom-class', 'data-foo' => 'bar'),
                'label' => esc_html__('Category Icon', 'listingo'),
                'desc' => esc_html__('Choose Category Icon. Leave blank to not display.', 'listingo'),
                'help' => esc_html__('', 'listingo'),
            ),
            'category_image' => array(
                'type' => 'upload',
                'label' => esc_html__('Category Image', 'listingo'),
                'desc' => esc_html__('Add category image here. It will be shown in box as background in categories listing.', 'listingo'),
                'images_only' => true,
            ),
            'dir_map_marker' => array(
                'type' => 'upload',
                'label' => esc_html__('Marker Image', 'listingo'),
                'desc' => esc_html__('Add Marker image here. It will be shown on google maps.', 'listingo'),
                'images_only' => true,
            ),
	
			'default_banner' => array(
                'type' => 'upload',
                'label' => esc_html__('Default banner?', 'listingo'),
                'desc' => esc_html__('Add default banner image. Users get registered under this category will get this banner at their detail pages. leave it empty to use from Theme Settings > Directory Settings > General Settings', 'listingo'),
                'images_only' => true,
            ),
	
			'default_avatar' => array(
                'type' => 'upload',
                'label' => esc_html__('Default Avatar?', 'listingo'),
                'desc' => esc_html__('Add default avatar image. Users get registered under this category will get this banner at their detail pages. leave it empty to use from Theme Settings > Directory Settings > General Settings', 'listingo'),
                'images_only' => true,
            ),
        ),
    ),
    'category_reviews_settings' => array(
        'title' => esc_html__('Review Settings', 'listingo'),
        'type' => 'box',
        'options' => array(
            'enable_reviews' => array(
                'type' => 'multi-picker',
                'label' => false,
                'desc' => '',
                'picker' => array(
                    'gadget' => array(
                        'type' => 'switch',
                        'value' => 'disable',
                        'attr' => array(),
                        'label' => esc_html__('Reviews', 'listingo'),
                        'desc' => esc_html__('Enable/Disable Reviews', 'listingo'),
                        'left-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disable', 'listingo'),
                        ),
                        'right-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'listingo'),
                        ),
                    )
                ),
                'choices' => array(
                    'enable' => array(
                        'total_wait_time' => array(
                            'type' => 'addable-option',
                            'value' => array(),
                            'label' => esc_html__('Total Wait Time', 'listingo'),
                            'desc' => esc_html__('Add total wait time here.', 'listingo'),
                            'option' => array('type' => 'text'),
                            'add-button-text' => esc_html__('Add', 'listingo'),
                            'sortable' => true,
                        ),
                        'leave_rating' => array(
                            'type' => 'addable-option',
                            'value' => array(esc_html__('Ease of Appointment', 'listingo'), 
											 esc_html__('Promptness', 'listingo'), 
											 esc_html__('Courteous Staff', 'listingo')
										),
                            'label' => esc_html__('Rating Headings', 'listingo'),
                            'desc' => esc_html__('Add leave your rating headings.', 'listingo'),
                            'option' => array('type' => 'text'),
                            'add-button-text' => esc_html__('Add', 'listingo'),
                            'sortable' => true,
                        )
                    ),
                    'default' => array(),
                ),
                'show_borders' => false,
            ),
        ),
    )
);
