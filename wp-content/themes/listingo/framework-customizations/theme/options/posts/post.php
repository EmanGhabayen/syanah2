<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array(
    'page_settings' => array(
        'title' => esc_html__('Title bar Settings', 'listingo'),
        'type' => 'box',
        'options' => array(
            'titlebar_type' => array(
                'type' => 'multi-picker',
                'label' => false,
                'desc' => false,
                'picker' => array(
                    'gadget' => array(
                        'label' => esc_html__('Title bar Type', 'listingo'),
                        'desc' => esc_html__('Select title bar type', 'listingo'),
                        'type' => 'select',
                        'value' => 'default',
                        'choices' => array(
                            'default' => esc_html__('Default', 'listingo'),
                            'custom' => esc_html__('Custom Setttings', 'listingo'),
                            'rev_slider' => esc_html__('Revolution Slider', 'listingo'),
                            'custom_shortcode' => esc_html__('Custom Shortcode', 'listingo'),
                            'none' => esc_html__('None, hide it', 'listingo'),
                        )
                    )
                ),
                'choices' => array(
                    'default' => array(
                    ),
                    'custom' => array(
						'titlebar_style' => array(
							'label'   => esc_html__( 'Title bar style', 'listingo' ),
							'desc'   => esc_html__( 'Select title bar style', 'listingo' ),
							'type'    => 'select',
							'value'    => 'style_1',
							'choices' => array(
								'style_1' => esc_html__('Style 1', 'listingo'),	
								'style_2' => esc_html__('Style 2', 'listingo'),	
							)
						),
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
                        'titlebar_bg_image' => array(
                            'type' => 'upload',
                            'label' => esc_html__('Background?', 'listingo'),
                            'desc' => esc_html__('Upload background image', 'listingo'),
                            'images_only' => true,
                        ),
                        'titlebar_bg' => array(
                            'type' => 'rgba-color-picker',
                            'value' => 'rgba(54, 59, 77, 0.40)',
                            'label' => esc_html__('Background color', 'listingo'),
                            'desc' => esc_html__('RGBA color will be over image and solid color will override image', 'listingo'),
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
    'post_settings' => array(
        'title' => esc_html__('Post Settings', 'listingo'),
        'type' => 'box',
        'options' => array(
            'enable_author' => array(
                'type' => 'switch',
                'value' => 'enable',
                'label' => esc_html__('Author information', 'listingo'),
                'desc' => esc_html__('Enable or Disable author information at listing & detail page.', 'listingo'),
                'left-choice' => array(
                    'value' => 'enable',
                    'label' => esc_html__('Enable', 'listingo'),
                ),
                'right-choice' => array(
                    'value' => 'disable',
                    'label' => esc_html__('Disable', 'listingo'),
                ),
            ),
            'enable_comments' => array(
                'type' => 'switch',
                'value' => 'enable',
                'label' => esc_html__('Enable Comments', 'listingo'),
                'desc' => esc_html__('Enable or Disable comments. It will be effect all over the site in blog detail/listings.', 'listingo'),
                'left-choice' => array(
                    'value' => 'enable',
                    'label' => esc_html__('Enable', 'listingo'),
                ),
                'right-choice' => array(
                    'value' => 'disable',
                    'label' => esc_html__('Disable', 'listingo'),
                ),
            ),
            'enable_categories' => array(
                'type' => 'switch',
                'value' => 'enable',
                'label' => esc_html__('Enable Categories', 'listingo'),
                'desc' => esc_html__('Enable or Disable Categories. It will be effect all over the site in blog detail/listings.', 'listingo'),
                'left-choice' => array(
                    'value' => 'enable',
                    'label' => esc_html__('Enable', 'listingo'),
                ),
                'right-choice' => array(
                    'value' => 'disable',
                    'label' => esc_html__('Disable', 'listingo'),
                ),
            ),
            'enable_sharing' => array(
                'type' => 'multi-picker',
                'label' => false,
                'desc' => false,
                'picker' => array(
                    'gadget' => array(
                        'type' => 'switch',
                        'value' => 'disable',
                        'label' => esc_html__('Enable Sharing', 'listingo'),
                        'desc' => esc_html__('Enable or Disable social sharing at detail page.', 'listingo'),
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
                        'share_title' => array(
                            'type' => 'text',
                            'value' => 'Share',
                            'label' => esc_html__('Share title', 'listingo'),
                            'desc' => esc_html__('Add share title here. Leave it empty to hide.', 'listingo'),
                        ),
                    ),
                )
            ),
            'post_settings' => array(
                'type' => 'multi-picker',
                'label' => false,
                'desc' => false,
                'picker' => array(
                    'gadget' => array(
                        'label' => esc_html__('Post Format', 'listingo'),
                        'desc' => esc_html__('Select Post Format', 'listingo'),
                        'type' => 'radio',
                        'value' => 'image',
                        'choices' => array(
                            'image' => esc_html__('Image', 'listingo'),
                            'gallery' => esc_html__('Image Slider', 'listingo'),
                            'video' => esc_html__('Audio/Video', 'listingo'),
                        ),
                        'inline' => true,
                    )
                ),
                'choices' => array(
                    'image' => array(
                        'blog_post_image' => array(
                            'type' => 'html',
                            'html' => 'Uplaod Image',
                            'label' => esc_html__('Detail Image', 'listingo'),
                            'desc' => esc_html__('Upload Your detail blog post image as a featured image. (Preferred Size is 1920x800)', 'listingo'),
                            'help' => esc_html__('Please upload your thumbnail image.', 'listingo'),
                            'images_only' => true,
                        ),
                    ),
                    'gallery' => array(
                        'blog_post_gallery' => array(
                            'type' => 'multi-upload',
                            'label' => esc_html__('Image Slider', 'listingo'),
                            'desc' => esc_html__('Add Images for slider. (Preferred Size is 1920x800)', 'listingo'),
                            'help' => esc_html__('Only worked if the post display setting is equal to Image Gallery.', 'listingo'),
                            'images_only' => true,
                        ),
                    ),
                    'video' => array(
                        'blog_video_link' => array(
                            'type' => 'text',
                            'label' => esc_html__('Media Link', 'listingo'),
                            'desc' => esc_html__('Add your custom Audio/Video Link', 'listingo'),
                        ),
                    ),
                )
            ),
        )
    ),
);

