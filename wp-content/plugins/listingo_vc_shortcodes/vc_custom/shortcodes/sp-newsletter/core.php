<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Listingo_Mailchimp')) {

    class SC_VC_Core_Listingo_Mailchimp extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_mailchimp_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_mailchimp_init() {
            vc_map(array(
                "name" => esc_html__("Mailchimp", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_mailchimp",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-section-heading/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(           
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Section Title', 'listingo_vc_shortcodes'),
                        'param_name' => 'heading',
                        "description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textarea_html',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Section Description', 'listingo_vc_shortcodes'),
                        'param_name' => 'content',
                        "description" => esc_html__("Add description, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
					 array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Form Title', 'listingo_vc_shortcodes'),
                        'param_name' => 'form_heading',
                        "description" => esc_html__("Add form title, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
					array(
                        'type' => 'dropdown',
                        'heading' => esc_html__("Username?", 'listingo_vc_shortcodes'),
                        'param_name' => 'username',
                        'save_always' => true,
                        "description" => esc_html__("Show or hide username.", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__("Yes", 'listingo_vc_shortcodes') => 'yes',
                            esc_html__("No", 'listingo_vc_shortcodes') => 'no'
                        )
                    ),  
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_Listingo_Mailchimp();
}