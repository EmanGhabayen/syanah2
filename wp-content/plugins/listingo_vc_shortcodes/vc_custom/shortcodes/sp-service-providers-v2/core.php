<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Service Providers V2
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Sp_Service_Providers_V2')) {

    class SC_VC_Core_Sp_Service_Providers_V2 extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_service_providers_v2_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_service_providers_v2_init() {
            vc_map(array(
                "name" => esc_html__("SP Listingo V2", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_sp_service_providers_v2",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-service-providers-v2/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Heading', 'listingo_vc_shortcodes'),
                        'param_name' => 'heading',
                        "description" => esc_html__("Add Section heading, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Sub Heading', 'listingo_vc_shortcodes'),
                        'param_name' => 'sub_heading',
                        "description" => esc_html__("Add Section Sub heading, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),   
                    array(
                        'type' => 'vc_number',
                        'class' => '',
                        'heading' => __('No of posts', 'listingo_vc_shortcodes'),
                        'param_name' => 'no_of_posts',
                        'value' => 6,
                        'min' => 1,
                        'max' => 1000,
                        'save_always' => true,
                        'description' => __('Default is .6', 'listingo_vc_shortcodes'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Pagination',
                        'param_name' => 'show_pagination',
                        'save_always' => true,
                        "description" => esc_html__("Show or hide pagination.", 'listingo_vc_shortcodes'),
                        'value' => array(
                            'ON' => 'on',
                            'OFF' => 'off'
                        )
                    ),                   
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_Sp_Service_Providers_V2();
}