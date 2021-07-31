<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array(
    'headers' => array(
        'title' => esc_html__('Header Settings', 'listingo'),
        'type' => 'tab',
        'options' => array(
            'general-box' => array(
                'title' => esc_html__('Header Settings', 'listingo'),
                'type' => 'box',
                'options' => array(
                    'main_logo' => array(
                        'type' => 'upload',
                        'label' => esc_html__('Upload Logo', 'listingo'),
                        'desc' => esc_html__('Upload Your Logo Here, Preferred size is 130 by 61.', 'listingo'),
                        'images_only' => true,
                    ),
                    'enable_job' => array(
                        'type' => 'switch',
                        'value' => 'disable',
                        'desc' => esc_html__('Enable / Disable Job button.', 'listingo'),
                        'label' => esc_html__('Post Job button?', 'listingo'),
                        'right-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'listingo'),
                        ),
                        'left-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disbale', 'listingo'),
                        ),
                    ),
                    'sticky' => array(
                        'type' => 'switch',
                        'value' => 'disable',
                        'desc' => esc_html__('Enable sticky header?', 'listingo'),
                        'label' => esc_html__('Sticky header?', 'listingo'),
                        'right-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'listingo'),
                        ),
                        'left-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disbale', 'listingo'),
                        ),
                    ),
                    'enable_login_register' => array(
                        'type' => 'multi-picker',
                        'label' => false,
                        'desc' => '',
                        'picker' => array(
                            'gadget' => array(
                                'type' => 'switch',
                                'value' => 'disable',
                                'attr' => array(),
                                'label' => esc_html__('Login/Register ?', 'listingo'),
                                'desc' => esc_html__('Enable/Disable login/register link.', 'listingo'),
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
                                'registration' => array(
                                    'type' => 'switch',
                                    'value' => 'enable',
                                    'attr' => array(),
                                    'label' => esc_html__('Registeration?', 'listingo'),
                                    'desc' => esc_html__('Enable registeration form.', 'listingo'),
                                    'left-choice' => array(
                                        'value' => 'disable',
                                        'label' => esc_html__('Disable', 'listingo'),
                                    ),
                                    'right-choice' => array(
                                        'value' => 'enable',
                                        'label' => esc_html__('Enable', 'listingo'),
                                    ),
                                ),
                                'login' => array(
                                    'type' => 'switch',
                                    'value' => 'enable',
                                    'attr' => array(),
                                    'label' => esc_html__('Login?', 'listingo'),
                                    'desc' => esc_html__('Enable login form.', 'listingo'),
                                    'left-choice' => array(
                                        'value' => 'disable',
                                        'label' => esc_html__('Disable', 'listingo'),
                                    ),
                                    'right-choice' => array(
                                        'value' => 'enable',
                                        'label' => esc_html__('Enable', 'listingo'),
                                    ),
                                ),
                                'login_reg_page' => array(
                                    'label' => esc_html__('Choose Page', 'listingo'),
                                    'type' => 'multi-select',
                                    'population' => 'posts',
                                    'source' => 'page',
                                    'desc' => esc_html__('Choose login/register template page.', 'listingo'),
                                    'limit' => 1,
                                    'prepopulate' => 100,
                                ),
                                'terms_link' => array(
                                    'label' => esc_html__('Term page?', 'listingo'),
                                    'type' => 'multi-select',
                                    'population' => 'posts',
                                    'source' => 'page',
                                    'desc' => esc_html__('Choose term page', 'listingo'),
                                    'limit' => 1,
                                    'prepopulate' => 100,
                                ),
                            ),
                            'default' => array(),
                        ),
                        'show_borders' => false,
                    ),
                    'header_type' => array(
                        'type' => 'multi-picker',
                        'label' => false,
                        'desc' => false,
                        'value' => array('gadget' => 'header_v1'),
                        'picker' => array(
                            'gadget' => array(
                                'label' => esc_html__('Header Type', 'listingo'),
                                'type' => 'image-picker',
                                'choices' => array(
                                    'header_v1' => array(
                                        'label' => __('Header V1', 'listingo'),
                                        'small' => array(
                                            'height' => 70,
                                            'src' => get_template_directory_uri() . '/images/headers/h_1.jpg'
                                        ),
                                        'large' => array(
                                            'height' => 214,
                                            'src' => get_template_directory_uri() . '/images/headers/h_1.jpg'
                                        ),
                                    ),
                                    'header_v2' => array(
                                        'label' => __('Header V2', 'listingo'),
                                        'small' => array(
                                            'height' => 70,
                                            'src' => get_template_directory_uri() . '/images/headers/h_2.jpg'
                                        ),
                                        'large' => array(
                                            'height' => 214,
                                            'src' => get_template_directory_uri() . '/images/headers/h_2.jpg'
                                        ),
                                    ),
                                    'header_v3' => array(
                                        'label' => __('Header V3', 'listingo'),
                                        'small' => array(
                                            'height' => 70,
                                            'src' => get_template_directory_uri() . '/images/headers/h_3.jpg'
                                        ),
                                        'large' => array(
                                            'height' => 214,
                                            'src' => get_template_directory_uri() . '/images/headers/h_3.jpg'
                                        ),
                                    ),
                                    'header_v4' => array(
                                        'label' => __('Header V4', 'listingo'),
                                        'small' => array(
                                            'height' => 70,
                                            'src' => get_template_directory_uri() . '/images/headers/h_4.jpg'
                                        ),
                                        'large' => array(
                                            'height' => 214,
                                            'src' => get_template_directory_uri() . '/images/headers/h_4.jpg'
                                        ),
                                    ),
                                    'header_v5' => array(
                                        'label' => __('Header V5', 'listingo'),
                                        'small' => array(
                                            'height' => 70,
                                            'src' => get_template_directory_uri() . '/images/headers/h_5.jpg'
                                        ),
                                        'large' => array(
                                            'height' => 214,
                                            'src' => get_template_directory_uri() . '/images/headers/h_5.jpg'
                                        ),
                                    ),
                                ),
                                'desc' => esc_html__('Select header type.', 'listingo'),
                            )
                        ),
                        'choices' => array(
                            'header_v1' => array(
                                'enable_top_strip' => array(
                                    'type' => 'multi-picker',
                                    'label' => false,
                                    'desc' => '',
                                    'picker' => array(
                                        'gadget' => array(
                                            'type' => 'switch',
                                            'value' => 'disable',
                                            'attr' => array(),
                                            'label' => esc_html__('Top Stripe?', 'listingo'),
                                            'desc' => esc_html__('Enable/Disable top stripe', 'listingo'),
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
                                            'topstrip_color' => array(
                                                'label' => esc_html__('Top stripe background?', 'listingo'),
                                                'type' => 'color-picker',
                                                'value' => '#333333',
                                                'desc' => esc_html__('select top stripe background color. Leave it empty to use default.', 'listingo')
                                            ),
                                            'contact_info' => array(
                                                'label' => esc_html__('Add Contact Info.', 'listingo'),
                                                'type' => 'addable-popup',
                                                'value' => array(),
                                                'desc' => esc_html__('Add your contact information.', 'listingo'),
                                                'popup-options' => array(
                                                    'contact_label' => array(
                                                        'label' => esc_html__('Contact Label', 'listingo'),
                                                        'type' => 'text',
                                                        'value' => esc_html__('info@domain.com', 'listingo'),
                                                        'desc' => esc_html__('Add branch title', 'listingo')
                                                    ),
                                                    'contact_icon' => array(
                                                        'type' => 'icon-v2',
                                                        'preview_size' => 'small',
                                                        'modal_size' => 'medium',
                                                        'attr' => array('class' => 'custom-class', 'data-foo' => 'bar'),
                                                        'label' => esc_html__('Contact Icon', 'listingo'),
                                                        'desc' => esc_html__('Choose your contact icon.', 'listingo'),
                                                    ),
                                                    'type' => array(
                                                        'type' => 'select',
                                                        'value' => 'none',
                                                        'label' => esc_html__('Type', 'listingo'),
                                                        'desc' => esc_html__('', 'listingo'),
                                                        'choices' => array(
                                                            'none' => esc_html__('Default', 'listingo'),
                                                            'email' => esc_html__('Email', 'listingo'),
                                                            'phone' => esc_html__('Phone', 'listingo'),
                                                        ),
                                                        'no-validate' => false,
                                                    ),
                                                ),
                                                'template' => '{{- contact_label }}',
                                            ),
                                        ),
                                        'default' => array(),
                                    ),
                                    'show_borders' => false,
                                ),
                            ),
                            'header_v2' => array(
                            ),
                            'header_v3' => array(
                                'contact_address' => array(
                                    'label' => esc_html__('Address', 'listingo'),
                                    'type' => 'text',
                                    'value' => esc_html__('795 South Park Avenue, Door 640 Wonland, CA 94107, Australia', 'listingo'),
                                    'desc' => esc_html__('Add contact address', 'listingo')
                                ),
                                'contact_phone' => array(
                                    'label' => esc_html__('Phone', 'listingo'),
                                    'type' => 'text',
                                    'value' => esc_html__('0800 - 1234 - 562 - 6', 'listingo'),
                                    'desc' => esc_html__('Add contact phone', 'listingo')
                                ),
                                'contact_email' => array(
                                    'label' => esc_html__('Email', 'listingo'),
                                    'type' => 'text',
                                    'value' => esc_html__('support@domain.com', 'listingo'),
                                    'desc' => esc_html__('Add contact email', 'listingo')
                                ),
                            ),
                            'header_v4' => array(
                                'social_icons' => array(
                                    'label' => esc_html__('Social Profiles', 'listingo'),
                                    'type' => 'addable-popup',
                                    'value' => array(),
                                    'desc' => esc_html__('Add Social Icons as much as you want. Choose the icon, url and the title', 'listingo'),
                                    'popup-options' => array(
                                        'social_name' => array(
                                            'label' => esc_html__('Title', 'listingo'),
                                            'type' => 'text',
                                            'value' => 'Name',
                                            'desc' => esc_html__('The Title of the Link', 'listingo')
                                        ),
                                        'social_icons_list' => array(
                                            'type' => 'new-icon',
                                            'value' => 'fa-smile-o',
                                            'attr' => array(),
                                            'label' => esc_html__('Choos Icon', 'listingo'),
                                            'desc' => esc_html__('', 'listingo'),
                                            'help' => esc_html__('', 'listingo'),
                                        ),
                                        'social_url' => array(
                                            'label' => esc_html__('Url', 'listingo'),
                                            'type' => 'text',
                                            'value' => '#',
                                            'desc' => esc_html__('The link to the social profile.', 'listingo')
                                        ),
                                    ),
                                    'template' => '{{- social_name }}',
                                ),
                            ),
                            'header_v5' => array(
								 'search_form' => array(
                                    'type' => 'switch',
                                    'value' => 'enable',
                                    'label' => esc_html__('Search form?', 'listingo'),
                                    'desc' => esc_html__('Enable search form.', 'listingo'),
                                    'left-choice' => array(
                                        'value' => 'disable',
                                        'label' => esc_html__('Disable', 'listingo'),
                                    ),
                                    'right-choice' => array(
                                        'value' => 'enable',
                                        'label' => esc_html__('Enable', 'listingo'),
                                    ),
                                ),
							),
                        ),
                        'show_borders' => true,
                    ),
                )
            ),
        )
    )
);
