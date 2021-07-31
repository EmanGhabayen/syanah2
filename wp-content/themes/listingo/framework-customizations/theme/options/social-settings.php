<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array (
    'social_icons' => array (
        'title'   => esc_html__('Social Profiles' , 'listingo') ,
        'type'    => 'tab' ,
        'options' => array (
            'social_icons'       => array (
                'label'         => esc_html__('Social Profiles' , 'listingo') ,
                'type'          => 'addable-popup' ,
                'value'         => array () ,
                'desc'          => esc_html__('Add Social Icons as much as you want. Choose the icon, url and the title' , 'listingo') ,
                'popup-options' => array (
                    'social_name'       => array (
                        'label' => esc_html__('Title' , 'listingo') ,
                        'type'  => 'text' ,
                        'value' => 'Name' ,
                        'desc'  => esc_html__('The Title of the Link' , 'listingo')
                    ) ,
                    'social_icons_list' => array (
                        'type'  => 'new-icon' ,
                        'value' => 'fa-smile-o' ,
                        'attr'  => array () ,
                        'label' => esc_html__('Choos Icon' , 'listingo') ,
                        'desc'  => esc_html__('' , 'listingo') ,
                        'help'  => esc_html__('' , 'listingo') ,
                    ) ,
                    'social_url'        => array (
                        'label' => esc_html__('Url' , 'listingo') ,
                        'type'  => 'text' ,
                        'value' => '#' ,
                        'desc'  => esc_html__('The link to the social profile.' , 'listingo')
                    ) ,
                ) ,
                'template'      => '{{- social_name }}' ,
            ) ,
            'social_icon_target' => array (
                'label' => esc_html__('Open in New Window' , 'listingo') ,
                'type'  => 'switch' ,
                'desc'  => esc_html__('The links will be opened into new tab or window when your visitors clicked on the link.' , 'listingo')
            ) ,
        ) ,
    ) ,
);
