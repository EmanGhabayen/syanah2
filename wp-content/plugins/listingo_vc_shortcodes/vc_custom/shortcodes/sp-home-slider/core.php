<?php

/**
 * @ Visual Composer Shortcode
 * @ Class SP Home Slider
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_SP_Home_Slider')) {

    class SC_VC_Core_SP_Home_Slider extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_shortcodes_vc_SP_Home_Slider_init"));
        }

        /**
         * @ Admin Init
         * # return {options}
         */
        public function listingo_vc_shortcodes_vc_SP_Home_Slider_init() {
            vc_map(array(
                "name" => esc_html__("SP Home Slider", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_sp_home_slider",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-home-slider/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
                    array(
                        'type' => 'param_group',
                        'value' => '',
                        'heading' => esc_html__('Slider', 'listingo_vc_shortcodes'),
                        'param_name' => 'slides',
                        "description" => esc_html__("Add slide.", 'listingo_vc_shortcodes'),
                        'params' => array(
                            array(
                                'type' => 'attach_image',
                                'save_always' => true,
                                'heading' => esc_html__('Add Background Image', 'listingo_vc_shortcodes'),
                                'param_name' => 'bg_image',
                                'description' => esc_html__("Upload background Image of the Slide", 'listingo_vc_shortcodes'),
                                'value' => '',
                            ),
                            array(
                                'type' => 'textfield',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Slide Title', 'listingo_vc_shortcodes'),
                                'param_name' => 'slide_title',
                                "description" => esc_html__("Add slide title, please leave it empty to hide.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'textarea',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Slide Description', 'listingo_vc_shortcodes'),
                                'param_name' => 'slide_desc',
                                "description" => esc_html__("Add description of the slide, please leave it empty to hide.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'param_group',
                                'value' => '',
                                'heading' => esc_html__('Add Slider Buttons', 'listingo_vc_shortcodes'),
                                'param_name' => 'slide_btns',
                                "description" => esc_html__("Add Slide Buttons.", 'listingo_vc_shortcodes'),
                                'params' => array(
                                    array(
                                        'type' => 'vc_link',
                                        'heading' => esc_html__('Button Link', 'listingo_vc_shortcodes'),
                                        'param_name' => 'btn_link',
                                        'description' => esc_html__('Add slider buttton link here.', 'listingo_vc_shortcodes')
                                    ),
                                    array(
                                        'type' => 'dropdown',
                                        'heading' => esc_html__('Button Style', "listingo_vc_shortcodes"),
                                        'param_name' => 'btn_active',
                                        'value' => array(
                                            esc_html__('Simple', "listingo_vc_shortcodes") => 'simple',
                                            esc_html__('Active', "listingo_vc_shortcodes") => 'active',
                                        ),
                                        "description" => esc_html__("Select button style you want", "listingo_vc_shortcodes")
                                    ),
                                )
                            ),
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Navigation', "listingo_vc_shortcodes"),
                        'param_name' => 'nav',
                        'value' => array(
                            esc_html__('True', "listingo_vc_shortcodes") => 'true',
                            esc_html__('False', "listingo_vc_shortcodes") => 'false',
                        ),
                        "description" => esc_html__("Select navigation to be true or false for the slider", "listingo_vc_shortcodes")
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Loop', "listingo_vc_shortcodes"),
                        'param_name' => 'loop',
                        'value' => array(
                            esc_html__('True', "listingo_vc_shortcodes") => 'true',
                            esc_html__('False', "listingo_vc_shortcodes") => 'false',
                        ),
                        "description" => esc_html__("Select loop to be true or false for the slider", "listingo_vc_shortcodes")
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Autoplay', "listingo_vc_shortcodes"),
                        'param_name' => 'autoplay',
                        'value' => array(
                            esc_html__('True', "listingo_vc_shortcodes") => 'true',
                            esc_html__('False', "listingo_vc_shortcodes") => 'false',
                        ),
                        "description" => esc_html__("Select autoplay to be true or false for the slider", "listingo_vc_shortcodes")
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                ),
            ));
        }

    }

    new SC_VC_Core_SP_Home_Slider();
}