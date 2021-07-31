<?php

/**
 * @ Visual Composer Shortcode
 * @ Class SP Recent Question Slider
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_SP_Recent_Ques_Slider')) {

    class SC_VC_Core_SP_Recent_Ques_Slider extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_shortcodes_vc_SP_Recent_Ques_Slider_init"));
        }

        /**
         * @ Recent Question Slider
         * # return {options}
         */
        public function listingo_vc_shortcodes_vc_SP_Recent_Ques_Slider_init() {
            vc_map(array(
                "name" => esc_html__("SP Recent Question Slider", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_recent_ques_slider",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-recent-question-slider/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
                    array(
                        'type' => 'checkbox',
                        'save_always' => true,
                        'heading' => esc_html__('Select Posts', 'listingo_vc_shortcodes'),
                        'param_name' => 'specific_posts',
                        "description" => esc_html__("Please select posts to show", 'listingo_vc_shortcodes'),
                        'value' => $this->listingo_vc_shortcodes_prepare_custom_posts('sp_questions', 50),
                    ),
                    array(
                        'type' => 'vc_number',
                        'class' => '',
                        'heading' => __('Excerpt Length', 'listingo_vc_shortcodes'),
                        'param_name' => 'excerpt_length',
                        'value' => 60,
                        'min' => 1,
                        'max' => 1000,
                        'save_always' => true,
                        'description' => __('Default is .60', 'listingo_vc_shortcodes'),
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
                        'save_always' => true,
                        'heading' => esc_html__('Post Order', 'listingo_vc_shortcodes'),
                        'param_name' => 'order',
                        "description" => esc_html__("Post Order", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('ASC', 'listingo_vc_shortcodes') => 'ASC',
                            esc_html__('DESC', 'listingo_vc_shortcodes') => 'DESC'
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Order By', 'listingo_vc_shortcodes'),
                        'param_name' => 'orderby',
                        "description" => esc_html__("Post Order", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('Order by post id', 'listingo_vc_shortcodes') => 'ID',
                            esc_html__('Order by author', 'listingo_vc_shortcodes') => 'author',
                            esc_html__('Order by title', 'listingo_vc_shortcodes') => 'title',
                            esc_html__('Order by post name', 'listingo_vc_shortcodes') => 'name',
                            esc_html__('Order by date', 'listingo_vc_shortcodes') => 'date',
                            esc_html__('Order by last modified date', 'listingo_vc_shortcodes') => 'modified',
                            esc_html__('Random order', 'listingo_vc_shortcodes') => 'rand',
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
                )
            ));
        }

    }

    new SC_VC_Core_SP_Recent_Ques_Slider();
}