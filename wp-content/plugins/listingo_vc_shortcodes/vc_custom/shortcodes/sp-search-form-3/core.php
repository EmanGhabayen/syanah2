<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Listingo_Search_Form_3')) {

    class SC_VC_Core_Listingo_Search_Form_3 extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_search_form_three_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_search_form_three_init() {
            vc_map(array(
                "name" => esc_html__("SP Search Form 3", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_search_form_three",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-search-form-3/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(                       
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Title?', 'listingo_vc_shortcodes'),
                        'param_name' => 'main_title',
                        "description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
					array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Sub Title?', 'listingo_vc_shortcodes'),
                        'param_name' => 'sub_title',
                        "description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'colorpicker',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Text Color', 'listingo_vc_shortcodes'),
                        'param_name' => 'color',
                        "description" => esc_html__("Choose color for title and sub title ", 'listingo_vc_shortcodes')
                    ),
					array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Button Title', 'listingo_vc_shortcodes'),
                        'param_name' => 'btn_title',
                        "description" => esc_html__("Add sub title, please leave it empty to hide.", 'listingo_vc_shortcodes')
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
                        'type' => 'checkbox',
                        'save_always' => true,
                        'heading' => esc_html__('Select Posts', 'listingo_vc_shortcodes'),
                        'param_name' => 'specific_posts',
                        "description" => esc_html__("Please select posts to show", 'listingo_vc_shortcodes'),
                        'value' => $this->listingo_vc_shortcodes_prepare_custom_posts('sp_categories', 50),                    
                    ), 
					array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Pagination', 'listingo_vc_shortcodes'),
                        'param_name' => 'show_pagination',
                        "description" => esc_html__("Show/Hide slider Pagination", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('true', 'listingo_vc_shortcodes') => 'true',
                            esc_html__('false', 'listingo_vc_shortcodes') => 'false'
                        ),
                    ),
					array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Loop', 'listingo_vc_shortcodes'),
                        'param_name' => 'loop',
                        "description" => esc_html__("Slider loop", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('true', 'listingo_vc_shortcodes') => 'true',
                            esc_html__('false', 'listingo_vc_shortcodes') => 'false'
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Autoplay', 'listingo_vc_shortcodes'),
                        'param_name' => 'autpolay',
                        "description" => esc_html__("Slider Autoplay", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('true', 'listingo_vc_shortcodes') => 'true',
                            esc_html__('false', 'listingo_vc_shortcodes') => 'false'
                        ),
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_Listingo_Search_Form_3();
}