<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array(
    'social_counters' => array(
        'title' => esc_html__('Social Counter', 'listingo'),
        'type' => 'tab',
        'options' => array(
            'facebook_counter' => array(
                'type' => 'multi-picker',
                'label' => false,
                'desc' => false,
                'picker' => array(
                    'gadget' => array(
                        'type' => 'switch',
                        'value' => 'disable',
                        'label' => esc_html__('Facebook', 'listingo'),
                        'desc' => esc_html__('Enable facebook counter', 'listingo'),
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
                'choices' => array(
                    'enable' => array(
                        'fb_pageid' => array(
                            'type' => 'text',
                            'value' => '',
                            'label' => esc_html__('Facebook Page ID', 'listingo'),
                            'hint' => esc_html__('', 'listingo'),
                            'desc' => wp_kses(__('ID Facebook page. Must be the numeric ID or your page slug.<br>You can find this data clicking to edit your page on Facebook. The URL will be similar to this: <br>https://www.facebook.com/pages/edit/?id=162354720442454 or https://www.facebook.com/WordPress', 'listingo'), array('a' => array(
                                    'href' => array(),
                                    'title' => array()
                                ),
                                'br' => array(),
                                'em' => array(),
                                'strong' => array(),)),
                        ),
                        'fb_appid' => array(
                            'type' => 'text',
                            'value' => '',
                            'label' => esc_html__('Facebook App ID', 'listingo'),
                            'hint' => esc_html__('', 'listingo'),
                            'desc' => wp_kses(__('Create an App on Facebook in and get this data <a href=" https://developers.facebook.com/">Here</a>', 'listingo'), array('a' => array(
                                    'href' => array(),
                                    'title' => array()
                                ),
                                'br' => array(),
                                'em' => array(),
                                'strong' => array(),)),
                        ),
                        'fb_secreat' => array(
                            'type' => 'text',
                            'value' => '',
                            'label' => esc_html__('Facebook App Secret', 'listingo'),
                            'hint' => esc_html__('', 'listingo'),
                            'desc' => wp_kses(__('Create an App on Facebook in and get this data <a href=" https://developers.facebook.com/">Here</a>', 'listingo'), array('a' => array(
                                    'href' => array(),
                                    'title' => array()
                                ),
                                'br' => array(),
                                'em' => array(),
                                'strong' => array(),)),
                        ),
                    )
                ),
                'show_borders' => true,
            ),
            'google_counter' => array(
                'type' => 'multi-picker',
                'label' => false,
                'desc' => false,
                'picker' => array(
                    'gadget' => array(
                        'type' => 'switch',
                        'value' => 'disable',
                        'label' => esc_html__('Google Plus', 'listingo'),
                        'desc' => esc_html__('Enable google plus counter', 'listingo'),
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
                'choices' => array(
                    'enable' => array(
                        'g-plus_pageid' => array(
                            'type' => 'text',
                            'value' => '',
                            'label' => esc_html__('Google+ ID', 'listingo'),
                            'hint' => esc_html__('', 'listingo'),
                            'desc' => wp_kses(__('Google+ page or profile ID.<br>Example: https://plus.google.com/106146333300678794719 or https://plus.google.com/+ClaudioSanches', 'listingo'), array('a' => array(
                                    'href' => array(),
                                    'title' => array()
                                ),
                                'br' => array(),
                                'em' => array(),
                                'strong' => array(),)),
                        ),
                        'g-plus_api' => array(
                            'type' => 'text',
                            'value' => '',
                            'label' => esc_html__('Google API Key', 'listingo'),
                            'hint' => esc_html__('', 'listingo'),
                            'desc' => wp_kses(__('Get your API key creating a project/app in <a href=" https://console.developers.google.com/project">Here </a>then inside your project go to "APIs & auth > APIs" and turn on the "Google+ API", finally go to "APIs & auth > <br>APIs > Credentials > Public API access" and click in the "CREATE A NEW KEY" button,<br>select the "Browser key" option and click in the "CREATE" button, now just copy your API key and paste here.', 'listingo'), array('a' => array(
                                    'href' => array(),
                                    'title' => array()
                                ),
                                'br' => array(),
                                'em' => array(),
                                'strong' => array(),)),
                        ),
                    )
                ),
                'show_borders' => true,
            ),
            'twitter_counter' => array(
                'type' => 'multi-picker',
                'label' => false,
                'desc' => false,
                'picker' => array(
                    'gadget' => array(
                        'type' => 'switch',
                        'value' => 'disable',
                        'label' => esc_html__('Twitter', 'listingo'),
                        'desc' => esc_html__('Enable twitter counter', 'listingo'),
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
                'choices' => array(
                    'enable' => array(
                        'tw_name' => array(
                            'type' => 'text',
                            'value' => '',
                            'label' => esc_html__('Twitter Username', 'listingo'),
                            'hint' => esc_html__('', 'listingo'),
                            'desc' => esc_html__('Insert the Twitter username. Example: claudiosmweb.', 'listingo')
                        ),
                        'tw_key' => array(
                            'type' => 'text',
                            'value' => '',
                            'label' => esc_html__('Twitter Consumer key', 'listingo'),
                            'hint' => esc_html__('', 'listingo'),
                            'desc' => wp_kses(__('Create an App on Twitter in and get this data.<a href="https://dev.twitter.com/apps">Here</a>', 'listingo'), array('a' => array(
                                    'href' => array(),
                                    'title' => array()
                                ),
                                'br' => array(),
                                'em' => array(),
                                'strong' => array(),)),
                        ),
                        'tw_secret' => array(
                            'type' => 'text',
                            'value' => '',
                            'label' => esc_html__('Twitter Consumer secret', 'listingo'),
                            'hint' => esc_html__('', 'listingo'),
                            'desc' => wp_kses(__('Create an App on Twitter in and get this data.<a href="https://dev.twitter.com/apps">Here</a>', 'listingo'), array('a' => array(
                                    'href' => array(),
                                    'title' => array()
                                ),
                                'br' => array(),
                                'em' => array(),
                                'strong' => array(),)),
                        ),
                        'tw_token' => array(
                            'type' => 'text',
                            'value' => '',
                            'label' => esc_html__('Twitter Access token', 'listingo'),
                            'hint' => esc_html__('', 'listingo'),
                            'desc' => wp_kses(__('Create an App on Twitter in and get this data.<a href="https://dev.twitter.com/apps">Here</a>', 'listingo'), array('a' => array(
                                    'href' => array(),
                                    'title' => array()
                                ),
                                'br' => array(),
                                'em' => array(),
                                'strong' => array(),)),
                        ),
                        'tw_token_secret' => array(
                            'type' => 'text',
                            'value' => '',
                            'label' => esc_html__('Twitter Access token secret', 'listingo'),
                            'hint' => esc_html__('', 'listingo'),
                            'desc' => wp_kses(__('Create an App on Twitter in and get this data.<a href="https://dev.twitter.com/apps">Here</a>', 'listingo'), array('a' => array(
                                    'href' => array(),
                                    'title' => array()
                                ),
                                'br' => array(),
                                'em' => array(),
                                'strong' => array(),)),
                        ),
                    )
                ),
                'show_borders' => true,
            ),
            
            'pinterest_counter' => array(
                'type' => 'multi-picker',
                'label' => false,
                'desc' => false,
                'picker' => array(
                    'gadget' => array(
                        'type' => 'switch',
                        'value' => 'disable',
                        'label' => esc_html__('Pinterest', 'listingo'),
                        'desc' => esc_html__('Enable pinterest counter', 'listingo'),
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
                'choices' => array(
                    'enable' => array(
                        'pinterest_name' => array(
                            'type' => 'text',
                            'value' => '',
                            'label' => esc_html__('Pinterest Username', 'listingo'),
                            'hint' => esc_html__('', 'listingo'),
                            'desc' => esc_html__('Insert your Pinterest username. Example: claudiosmweb.', 'listingo'),
                        ),
                    )
                ),
                'show_borders' => true,
            ),
        ),
    ),
);
