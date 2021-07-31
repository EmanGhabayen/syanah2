<?php

/**
 * @ Visual Composer Shortcode
 * @ Class SP Testimonials Slider
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_SP_Testimonial_Slider')) {

    class SC_VC_Core_SP_Testimonial_Slider extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_shortcodes_vc_SP_Testimonial_Slider_init"));
        }

        /**
         * @ Admin Init
         * # return {options}
         */
        public function listingo_vc_shortcodes_vc_SP_Testimonial_Slider_init() {
            vc_map(array(
                "name" => esc_html__("SP Testimonial Slider", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_sp_testimonial_slider",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-testimonials-slider/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
                    array(
                        'type' => 'param_group',
                        'value' => '',
                        'heading' => esc_html__('Testimonials', 'listingo_vc_shortcodes'),
                        'param_name' => 'sp_testimonials',
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
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('User Ratings', "listingo_vc_shortcodes"),
                                'param_name' => 'user_rating',
                                'value' => array(
                                    esc_html__('One Star', "listingo_vc_shortcodes") => '1',
                                    esc_html__('Two Star', "listingo_vc_shortcodes") => '2',
                                    esc_html__('Three Star', "listingo_vc_shortcodes") => '3',
                                    esc_html__('Four Star', "listingo_vc_shortcodes") => '4',
                                    esc_html__('Five Star', "listingo_vc_shortcodes") => '5',
                                ),
                                "description" => esc_html__("Add Star Rating of the user", "listingo_vc_shortcodes")
                            ),
                        )
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
                )
            ));
        }

    }

    new SC_VC_Core_SP_Testimonial_Slider();
}