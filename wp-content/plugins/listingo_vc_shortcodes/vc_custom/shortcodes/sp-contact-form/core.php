<?php

/**
 * @ Visual Composer Shortcode
 * @ Class SP Contact Form
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_SP_Contact_Form')) {

    class SC_VC_Core_SP_Contact_Form extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_shortcodes_vc_SP_Contact_Form_init"));
        }

        /**
         * @ Admin Init
         * # return {options}
         */
        public function listingo_vc_shortcodes_vc_SP_Contact_Form_init() {
            vc_map(array(
                "name" => esc_html__("SP Contact Form", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_sp_contact_form",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-contact-form/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Heading', 'listingo_vc_shortcodes'),
                        'param_name' => 'sec_heading',
                        "description" => esc_html__("Add heading, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textarea_html',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Description', 'listingo_vc_shortcodes'),
                        'param_name' => 'content',
                        "description" => esc_html__("Add description, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Select Contact Form', 'listingo_vc_shortcodes'),
                        'param_name' => 'sp_contact_form',
                        "description" => esc_html__("Please select contact form to show", 'listingo_vc_shortcodes'),
                        'value' => $this->listingo_vc_shortcodes_prepare_custom_posts('wpcf7_contact_form', -1),
                        'dependency' => array(
                            'element' => 'posts_by',
                            'value' => 'by_posts',
                        ),
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_SP_Contact_Form();
}