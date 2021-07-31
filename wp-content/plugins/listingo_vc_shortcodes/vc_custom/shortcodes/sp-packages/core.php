<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Listingo_Packages')) {

    class SC_VC_Core_Listingo_Packages extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_packages_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_packages_init() {
            vc_map(array(
                "name" => esc_html__("Packages", 'listingo_vc_shortcodes'),
                "base" => "listingo_packages",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-search-form/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(                       
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Title', 'listingo_vc_shortcodes'),
                        'param_name' => 'title',
                        "description" => esc_html__("Packages title goes here", 'listingo_vc_shortcodes')
                    ),
					array(
                        'type' => 'textarea',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Title', 'listingo_vc_shortcodes'),
                        'param_name' => 'sub_title',
                        "description" => esc_html__("Packages sub title goes here", 'listingo_vc_shortcodes')
                    ),
					array(
						'type' => 'dropdown',
						'save_always' => true,
						"value" => array(
							esc_html__("Providers", 'listingo_vc_shortcodes') => "provider",
							esc_html__("Customers", 'listingo_vc_shortcodes') => "customer",
						),
						'heading' => 'Package type',
						'param_name' => 'type',
						"description" => esc_html__("Please select package type.", 'listingo_vc_shortcodes'),
					),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_Listingo_Packages();
}