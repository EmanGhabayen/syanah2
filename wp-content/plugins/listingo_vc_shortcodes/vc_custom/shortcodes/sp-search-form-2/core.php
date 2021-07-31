<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Listingo_Search_Form_2')) {

    class SC_VC_Core_Listingo_Search_Form_2 extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_search_form_two_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_search_form_two_init() {
            vc_map(array(
                "name" => esc_html__("SP Search Form 2", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_search_form_two",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-search-form-2/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(                       
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Form Title', 'listingo_vc_shortcodes'),
                        'param_name' => 'sec_title',
                        "description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Form Sub title', 'listingo_vc_shortcodes'),
                        'param_name' => 'sub_title',
                        "description" => esc_html__("Add sub title, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'colorpicker',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Color', 'listingo_vc_shortcodes'),
                        'param_name' => 'color',
                        "description" => esc_html__("Choose color for title and sub title ", 'listingo_vc_shortcodes')
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
                            esc_html__('No', 'listingo_vc_shortcodes') => "no",
                            esc_html__('Yes', 'listingo_vc_shortcodes') => "yes",
                        ),
                        'heading' => 'Sub categories',
                        'param_name' => 'sub_cats',
                        "description" => esc_html__("Enable sub categories in search form?", 'listingo_vc_shortcodes'),
                    ),
					array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Button text?', 'listingo_vc_shortcodes'),
                        'param_name' => 'btn_text',
                        "description" => esc_html__("Add sub title, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_Listingo_Search_Form_2();
}