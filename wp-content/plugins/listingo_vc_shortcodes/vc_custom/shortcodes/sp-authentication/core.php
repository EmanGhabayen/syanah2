<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Services Grid
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Authentication')) {

    class SC_VC_Core_Authentication extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_authentication_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_authentication_init() {
            vc_map(array(
                "name" => esc_html__("Authentication", 'listingo_vc_shortcodes'),
                "base" => "listingo_auth",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-services-2/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(   
					 array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Form Type', 'listingo_vc_shortcodes'),
                        'param_name' => 'form_type',
                        'std' => 'no',
                        "description" => esc_html__("Select form type.", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('Both Form', 'listingo_vc_shortcodes') => 'both',
                            esc_html__('Login Form', 'listingo_vc_shortcodes') => 'login',
							esc_html__('Register Form', 'listingo_vc_shortcodes') => 'register'
                        ),
                        "group" => "form",
                    ),
					array(
						'type' => 'textfield',
						'save_always' => true,
						'value' => 'Login Now',
						'heading' => esc_html__('Login Title', 'listingo_vc_shortcodes'),
						'param_name' => 'login_title',
						"description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes'),
						'dependency' => array(
                            'element' => 'form_type',
                            'value' => 'login',
                        ),
                        "group" => "form",
					),
					array(
						'type' => 'textfield',
						'save_always' => true,
						'value' => 'Register As',
						'heading' => esc_html__('Register Title', 'listingo_vc_shortcodes'),
						'param_name' => 'register_title',
						"description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes'),
						'dependency' => array(
                            'element' => 'form_type',
                            'value' => 'register',
                        ),
                        "group" => "form",
					),
					array(
						'type' => 'textfield',
						'save_always' => true,
						'value' => 'Login Now',
						'heading' => esc_html__('Login Title', 'listingo_vc_shortcodes'),
						'param_name' => 'both_login_title',
						"description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes'),
						'dependency' => array(
                            'element' => 'form_type',
                            'value' => 'both',
                        ),
                        "group" => "form",
					),
					array(
						'type' => 'textfield',
						'save_always' => true,
						'value' => 'Register As',
						'heading' => esc_html__('Register Title', 'listingo_vc_shortcodes'),
						'param_name' => 'both_register_title',
						"description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes'),
						'dependency' => array(
                            'element' => 'form_type',
                            'value' => 'both',
                        ),
                        "group" => "form",
					),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_Authentication();
}