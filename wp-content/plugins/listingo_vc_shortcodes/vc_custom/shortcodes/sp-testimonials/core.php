<?php

/**
 * @ Visual Composer Shortcode
 * @ Class SP Testimonial
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_SP_Testimonial')) {

    class SC_VC_Core_SP_Testimonial extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_shortcodes_vc_SP_Testimonial_init"));
        }

        /**
         * @ Admin Init
         * # return {options}
         */
        public function listingo_vc_shortcodes_vc_SP_Testimonial_init() {
            vc_map(array(
                "name" => esc_html__("SP Testimonial", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_sp_testimonial",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-testimonials/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Show / Hide Quote icon', 'listingo_vc_shortcodes'),
                        'param_name' => 'enable_quote',
                        "description" => esc_html__("", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('Enable', 'listingo_vc_shortcodes') => 'enable',
                            esc_html__('Disable', 'listingo_vc_shortcodes') => 'disable'
                        ),
                    ),
                    array(
                        'type' => 'param_group',
                        'value' => '',
                        'heading' => esc_html__('Testimonials', 'listingo_vc_shortcodes'),
                        'param_name' => 'testimonials',
                        "description" => esc_html__("Add Testimonials.", 'listingo_vc_shortcodes'),
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Testimonial Heading.', 'listingo_vc_shortcodes'),
                                'param_name' => 'testimonail_heading',
                                "description" => esc_html__("Add testimonail heading, please leave it empty to hide.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'textfield',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Testimonial Author', 'listingo_vc_shortcodes'),
                                'param_name' => 'testimonail_author',
                                "description" => esc_html__("Add Author here. Leave it empty to hide.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'textarea',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Testimonial Description', 'listingo_vc_shortcodes'),
                                'param_name' => 'testimonial_description',
                                "description" => esc_html__("Add description, please leave it empty to hide.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'attach_image',
                                'value' => '',
                                'heading' => 'Testimonial Thumbnail',
                                'param_name' => 'testimonial_image',
                                "description" => esc_html__("Add Testimonial image here.", 'listingo_vc_shortcodes')
                            ),
                        )
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_SP_Testimonial();
}