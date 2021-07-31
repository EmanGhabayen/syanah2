<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Listingo_home_search_slider_4')) {

    class SC_VC_Core_Listingo_home_search_slider_4 extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_search_home_form_slider_v4_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_search_home_form_slider_v4_init() {
            vc_map(array(
                "name" => esc_html__("Search Ads and Providers", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_search_form_home_slider_four",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-search-form-2/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(     
                    array(
                        'type' => 'checkbox',
                        'save_always' => true,
						"class" => "vc-checkboxstyles",
                        'heading' => esc_html__('Select Slides', 'listingo_vc_shortcodes'),
                        'param_name' => 'posts',
                        "description" => esc_html__("Each post will serve as a slide", 'listingo_vc_shortcodes'),
                        'value' => $this->listingo_vc_shortcodes_prepare_custom_posts('sp_categories', -1),                        
                    ),                              
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Tab Title', 'listingo_vc_shortcodes'),
                        'param_name' => 'pro_title',
                        "description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes'),
                        "group" => "Provider Settings",
                    ),  
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Form sub title', 'listingo_vc_shortcodes'),
                        'param_name' => 'pro_sub_title',
                        "description" => esc_html__("Add sub title, please leave it empty to hide.", 'listingo_vc_shortcodes'),
                        "group" => "Provider Settings",
                    ),                  
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Form title', 'listingo_vc_shortcodes'),
                        'param_name' => 'pro_tab_title',
                        "description" => esc_html__("Add description, please leave it empty to hide.", 'listingo_vc_shortcodes'),
                        "group" => "Provider Settings",
                    ),                    
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Form button text', 'listingo_vc_shortcodes'),
                        'param_name' => 'provider_button',
                        "description" => esc_html__("Add text, please leave it empty to use default.", 'listingo_vc_shortcodes'),
                        "group" => "Provider Settings",
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Tab Title', 'listingo_vc_shortcodes'),
                        'param_name' => 'ad_title',
                        "description" => esc_html__("Add title, please leave it empty to use default.", 'listingo_vc_shortcodes'),
                        "group" => "Ad Settings",
                    ),      
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Form sub title', 'listingo_vc_shortcodes'),
                        'param_name' => 'ad_sub_title',
                        "description" => esc_html__("Add sub title, please leave it empty to hide.", 'listingo_vc_shortcodes'),
                        "group" => "Ad Settings",
                    ),                         
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Form title', 'listingo_vc_shortcodes'),
                        'param_name' => 'ad_tab_title',
                        "description" => esc_html__("Add text, please leave it empty to hide.", 'listingo_vc_shortcodes'),
                        "group" => "Ad Settings",
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Form button text', 'listingo_vc_shortcodes'),
                        'param_name' => 'ad_button',
                        "description" => esc_html__("Add text, please leave it empty to use default.", 'listingo_vc_shortcodes'),
                        "group" => "Ad Settings",
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Slide sub title', 'listingo_vc_shortcodes'),
                        'param_name' => 'sub_title',
                        "description" => esc_html__("This text will be used above slide title.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Slide description', 'listingo_vc_shortcodes'),
                        'param_name' => 'sub_title_below',
                        "description" => esc_html__("This text will be shown below slide title.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        "value" => array(
                            esc_html__('Geo location?', 'listingo_vc_shortcodes') => "geo",
                            esc_html__('Countries list', 'listingo_vc_shortcodes') => "countries",
                        ),
                        'heading' => esc_html__('Location type', 'listingo_vc_shortcodes'),
                        'param_name' => 'geo_type',
                        "description" => esc_html__("Select location type.", 'listingo_vc_shortcodes'),
                    ), 
                	array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        "value" => array(
                            esc_html__('True', 'listingo_vc_shortcodes') => "true",
                            esc_html__('False', 'listingo_vc_shortcodes') => "false",
                        ),
                        'heading' => esc_html__('Autoplay','listingo_vc_shortcodes'),
                        'param_name' => 'autoplay',
                        "description" => esc_html__("Autoplay true/false", 'listingo_vc_shortcodes'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        "value" => array(
                            esc_html__('True', 'listingo_vc_shortcodes') => "true",
                            esc_html__('False', 'listingo_vc_shortcodes') => "false",
                        ),
                        'heading' => esc_html__('Show Nav','listingo_vc_shortcodes'),
                        'param_name' => 'show_nav',
                        "description" => esc_html__("Show nav true/false", 'listingo_vc_shortcodes'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        "value" => array(
                            esc_html__('True', 'listingo_vc_shortcodes') => "true",
                            esc_html__('False', 'listingo_vc_shortcodes') => "false",
                        ),
                        'heading' => esc_html__('Progress', 'listingo_vc_shortcodes'),
                        'param_name' => 'progress',
                        "description" => esc_html__("Progress true/false", 'listingo_vc_shortcodes'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        "value" => array(
                            esc_html__('True', 'listingo_vc_shortcodes') => "true",
                            esc_html__('False', 'listingo_vc_shortcodes') => "false",
                        ),
                        'heading' => esc_html__('Pause on hover', 'listingo_vc_shortcodes'),
                        'param_name' => 'pause_on_hover',
                        "description" => esc_html__("Pause on hover true/false", 'listingo_vc_shortcodes'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        "value" => array(
                            esc_html__('True', 'listingo_vc_shortcodes') => "true",
                            esc_html__('False', 'listingo_vc_shortcodes') => "false",
                        ),
                        'heading' => esc_html__('Responsive', 'listingo_vc_shortcodes'),
                        'param_name' => 'responsive',
                        "description" => esc_html__("Responsive true/false", 'listingo_vc_shortcodes'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        "value" => array(
                            esc_html__('True', 'listingo_vc_shortcodes') => "true",
                            esc_html__('False', 'listingo_vc_shortcodes') => "false",
                        ),
                        'heading' => esc_html__('Scroll buttons', 'listingo_vc_shortcodes'),
                        'param_name' => 'scroll',
                        "description" => esc_html__("Control scroll buttons true/false", 'listingo_vc_shortcodes'),
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '5000',
                        'heading' => esc_html__('Time out', 'listingo_vc_shortcodes'),
                        'param_name' => 'time_out',
                        "description" => esc_html__("Add sub title, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '445',
                        'heading' => esc_html__('Slider Height', 'listingo_vc_shortcodes'),
                        'param_name' => 'height',
                        "description" => esc_html__("Add height, please leave it empty for default value 445.", 'listingo_vc_shortcodes')
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_Listingo_home_search_slider_4();
}