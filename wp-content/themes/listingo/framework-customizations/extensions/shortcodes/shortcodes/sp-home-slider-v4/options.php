<?php

if (!defined('FW'))
    die('Forbidden');
$options = array(
    'slider_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('Slider Settings', 'listingo'),
        'options' => array(
            'posts' => array(
                'type' => 'multi-select',
                'label' => esc_html__('Select Slides', 'listingo'),
                'population' => 'posts',
                'source' => 'sp_categories',
                'prepopulate' => 500,
                'desc' => esc_html__('Select your desired posts. Each post will be used as a slide', 'listingo'),
            ),       
            'sub_title' => array(
                'label' => esc_html__('Slide sub title', 'listingo'),
                'desc' => esc_html__('This text will be shown over slide title', 'listingo'),
                'type' => 'text',
                'value' => '',       
            ),
            'sub_title_below' => array(
                'label' => esc_html__('Slide description', 'listingo'),
                'desc' => esc_html__('This text will be shown below slide title', 'listingo'),
                'type' => 'text',
                'value' => '',       
            ),
            'geo_type' => array(
                'label' => esc_html__('Location type', 'listingo'),
                'desc' => esc_html__('Select location type.', 'listingo'),
                'type' => 'select',
                'value' => 'geo',
                'choices' => array(
                    'geo' => esc_html__('Geo location?', 'listingo'),
                    'countries' => esc_html__('Countries list', 'listingo'),
                )
            ),            
            'autoplay' => array(
                'type' => 'select',
                'value' => 'true',
                'label' => esc_html__('Autoplay', 'listingo'),
                'desc' => esc_html__('Slider autoplay setting.', 'listingo'),
                'choices' => array(
                    'true' => esc_html__('True', 'listingo'),
                    'false' => esc_html__('False', 'listingo'),
                ),
            ),
            'show_nav' => array(
                'type' => 'select',
                'value' => 'true',
                'label' => esc_html__('Show Navigation', 'listingo'),
                'desc' => esc_html__('Show slider navigation?', 'listingo'),
                'choices' => array(
                    'true' => esc_html__('True', 'listingo'),
                    'false' => esc_html__('False', 'listingo'),
                ),
            ),
            'progress' => array(
                'type' => 'select',
                'value' => 'true',
                'label' => esc_html__('Show Progress bar?', 'listingo'),
                'desc' => esc_html__('Show slider progress bar?', 'listingo'),
                'choices' => array(
                    'true' => esc_html__('True', 'listingo'),
                    'false' => esc_html__('False', 'listingo'),
                ),
            ),
            'pause_ov_hover' => array(
                'type' => 'select',
                'value' => 'true',
                'label' => esc_html__('Pause on hover', 'listingo'),
                'desc' => esc_html__('Play/Pause slide on hover', 'listingo'),
                'choices' => array(
                    'true' => esc_html__('True', 'listingo'),
                    'false' => esc_html__('False', 'listingo'),
                ),
            ),
            'responsive' => array(
                'type' => 'select',
                'value' => 'true',
                'label' => esc_html__('Responsive', 'listingo'),
                'desc' => esc_html__('Allow slider responsiveness?', 'listingo'),
                'choices' => array(
                    'true' => esc_html__('True', 'listingo'),
                    'false' => esc_html__('False', 'listingo'),
                ),
            ),
            'scroll' => array(
                'type' => 'select',
                'value' => 'true',
                'label' => esc_html__('Scroll', 'listingo'),
                'desc' => esc_html__('Show slider scrolls?', 'listingo'),
                'choices' => array(
                    'true' => esc_html__('True', 'listingo'),
                    'false' => esc_html__('False', 'listingo'),
                ),
            ),    
            'time_out' => array(
                'label' => esc_html__('Autoplay time out', 'listingo'),
                'desc' => esc_html__('Add your number to time out autoplay', 'listingo'),
                'desc' => esc_html__('Slide timeout', 'listingo'),
                'type' => 'text',
                'value' => '',       
            ), 
            'height' => array(
                'label' => esc_html__('Height', 'listingo'),
                'desc' => esc_html__('Your desired slider height', 'listingo'),
                'type' => 'text',
                'value' => '',       
            ), 
        ),
    ),
    'provider_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('Provider Settings', 'listingo'),
        'options' => array(
            'pro_title' => array(
                'label' => esc_html__('Tab title', 'listingo'),        
                'type' => 'text',
                'value' => '',  
                'desc' => esc_html__('This text will serve as Tab title for provider\'s tab. Default is Providers', 'listingo'),     
            ),
            'pro_tab_title' => array(
                'label' => esc_html__('Form title', 'listingo'),       
                'type' => 'text',
                'value' => '', 
                'desc' => esc_html__('This text will serve as provider form title', 'listingo'),       
            ),
            'provider_button' => array(
                'label' => esc_html__('Form button text', 'listingo'),        
                'type' => 'text',
                'value' => '',       
                'desc' => esc_html__('This text will be used as Form submission button', 'listingo'),
            ),  
        ),      
    ),
    'ad_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('Ad Settings', 'listingo'),
        'options' => array(
            'ad_title' => array(
                'label' => esc_html__('Tab title', 'listingo'),        
                'type' => 'text',
                'value' => '',       
                'desc' => esc_html__('This text will serve as Tab title for Ad\'s tab. Default is Ads', 'listingo'),
            ),
            'ad_tab_title' => array(
                'label' => esc_html__('Form title', 'listingo'),        
                'type' => 'text',
                'value' => '', 
                'desc' => esc_html__('This text will be used as Ad form title', 'listingo'),      
            ),
            'ad_button' => array(
                'label' => esc_html__('Form button text', 'listingo'),        
                'type' => 'text',
                'value' => '',       
                'desc' => esc_html__('This text will be used as Form submission button', 'listingo'),
            ),  
        ),
    ),      
);
