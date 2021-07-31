<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Call to action
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Call_To_Action')) {

    class SC_VC_Core_Call_To_Action extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_shortcodes_vc_Call_To_Action_init"));
        }

        /**
         * @ Admin Init
         * # return {options}
         */
        public function listingo_vc_shortcodes_vc_Call_To_Action_init() {
            vc_map(array(
                "name" => esc_html__("Call To Action", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_call_to_action",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-call-to-action/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Heading', 'listingo_vc_shortcodes'),
                        'param_name' => 'sec_heading',
                        "description" => esc_html__("Add main heading, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Sub Heading', 'listingo_vc_shortcodes'),
                        'param_name' => 'sub_title',
                        "description" => esc_html__("Add Sub heading, please leave it empty to hide.", 'listingo_vc_shortcodes')
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
                        'type' => 'attach_image',
                        'value' => '',
                        "holder" => "",
                        'heading' => esc_html__('Call to action Image', 'listingo_vc_shortcodes'),
                        'param_name' => 'call_to_action_image',
                    ),
                    array(
                        'type' => 'vc_link',
                        'value' => '',
                        'heading' => esc_html__('Button Link', 'listingo_vc_shortcodes'),
                        'param_name' => 'button_link',
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_Call_To_Action();
}