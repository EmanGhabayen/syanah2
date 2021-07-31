<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Top Categories
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Listingo_Top_Categories')) {

    class SC_VC_Core_Listingo_Top_Categories extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_top_categories_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_top_categories_init() {
            vc_map(array(
                "name" => esc_html__("SP Top Categories", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_top_categories",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-top-categories/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(                       
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Section Heading', 'listingo_vc_shortcodes'),
                        'param_name' => 'section_heading',
                        "description" => esc_html__("Add section heading. leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Section Sub-Heading', 'listingo_vc_shortcodes'),
                        'param_name' => 'section_subheading',
                        "description" => esc_html__("Add section sub heading. It will appear above the main heading. Leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'checkbox',
                        'save_always' => true,
                        'heading' => esc_html__('Select Posts', 'listingo_vc_shortcodes'),
                        'param_name' => 'specific_posts',
                        "description" => esc_html__("Please select posts to show", 'listingo_vc_shortcodes'),
                        'value' => $this->listingo_vc_shortcodes_prepare_custom_posts('sp_categories', 50),                    
                    ), 
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_Listingo_Top_Categories();
}