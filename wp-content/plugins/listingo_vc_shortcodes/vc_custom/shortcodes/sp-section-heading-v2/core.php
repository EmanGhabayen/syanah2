<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Listingo_Section_Heading_V2')) {

    class SC_VC_Core_Listingo_Section_Heading_V2 extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_Section_heading_v2_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_Section_heading_v2_init() {
            vc_map(array(
                "name" => esc_html__("SP Section Heading V2", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_section_heading_v2",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-section-heading-v2/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(           
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Heading', 'listingo_vc_shortcodes'),
                        'param_name' => 'section_heading',
                        "description" => esc_html__("Add section heading. leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Sub Heading', 'listingo_vc_shortcodes'),
                        'param_name' => 'section_subheading',
                        "description" => esc_html__("Add section sub heading. It will appear above the main heading. Leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_Listingo_Section_Heading_V2();
}