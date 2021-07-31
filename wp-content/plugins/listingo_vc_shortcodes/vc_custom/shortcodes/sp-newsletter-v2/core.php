<?php

/**
 * @ Visual Composer Shortcode
 * @ Class News Letter V2
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Listingo_Newsletter_V2')) {

    class SC_VC_Core_Listingo_Newsletter_V2 extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_newsletter_v2_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_newsletter_v2_init() {
            vc_map(array(
                "name" => esc_html__("News Letter V2", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_newsletter_v2",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-newsletter-v2/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(           
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Form Heading', 'listingo_vc_shortcodes'),
                        'param_name' => 'form_heading',
                        "description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Form Sub Heading', 'listingo_vc_shortcodes'),
                        'param_name' => 'form_subheading',
                        "description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'attach_image',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Upload Image', 'listingo_vc_shortcodes'),
                        'param_name' => 'form_image',
                        "description" => esc_html__("Upload Image of the form. Preffered size is 84 x 60", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Form Button Text', 'listingo_vc_shortcodes'),
                        'param_name' => 'frm_btn_txt',
                        "description" => esc_html__("Add form button text, if left empty 'Signup Now' will be button text.", 'listingo_vc_shortcodes')
                    ),
					array(
                        'type' => 'colorpicker',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Text Color', 'listingo_vc_shortcodes'),
                        'param_name' => 'color',
                        "description" => esc_html__("Choose color for title and sub title", 'listingo_vc_shortcodes')
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_Listingo_Newsletter_V2();
}