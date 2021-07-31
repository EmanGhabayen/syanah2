<?php

/**
 * @ Visual Composer Shortcode
 * @ Class SP Categories
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_SP_Cities')) {

    class SC_VC_Core_SP_Cities extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_SP_Cities_init"));
        }

        /**
         * @ Admin Init
         * # return {options}
         */
        public function listingo_vc_SP_Cities_init() {
            vc_map(array(
                "name" => esc_html__("SP Cities", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_sp_cities",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-cities/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Heading', 'listingo_vc_shortcodes'),
                        'param_name' => 'category_heading',
                        "description" => esc_html__("Add main heading, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textarea_html',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Description', 'listingo_vc_shortcodes'),
                        'param_name' => 'content',
                        "description" => esc_html__("Add section description, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),       
                    array(
                        'type' => 'checkbox',
                        'save_always' => true,
                        'heading' => esc_html__('Select Cities', 'listingo_vc_shortcodes'),
                        'param_name' => 'cities',
                        "description" => esc_html__("Select cities to show.", 'listingo_vc_shortcodes'),
                        'value' => $this->listingo_vc_shortcodes_prepare_taxonomies('sp_categories', 'cities', 0), // [Post Type][Taxonomy][Hide Empty ,0,1]                      
                    ),     
                    array(
                        'type' => 'vc_link',
                        'value' => '',
                        'heading' => esc_html__('Add Button', 'listingo_vc_shortcodes'),
                        'param_name' => 'link',
                    ),                                                  
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_SP_Cities();
}