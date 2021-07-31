<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Listingo_Post_Questions')) {

    class SC_VC_Core_Listingo_Post_Questions extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_search_post_questions_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_search_post_questions_init() {
            vc_map(array(
                "name" => esc_html__("SP Post Questions", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_post_questions",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-post-questions/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(                       
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Section Title', 'listingo_vc_shortcodes'),
                        'param_name' => 'sec_title',
                        "description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'dropdown',
                        'class' => '',
                        'save_always' => true,
                        'heading' => esc_html__('Show Recent Questions', 'listingo_vc_shortcodes'),
                        'param_name' => 'recent',
                        'description' => esc_html__('Show recent questions.', 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('Yes', 'listingo_vc_shortcodes') => 'yes',
                            esc_html__('No', 'listingo_vc_shortcodes') => 'no',
                        ),
                    ), 
					 array(
                        'type' => 'vc_number',
                        'class' => '',
                        'heading' => __('No of question?', 'listingo_vc_shortcodes'),
                        'param_name' => 'no_of_posts',
                        'value' => 18,
                        'min' => 1,
                        'max' => 1000,
                        'save_always' => true,
                        'description' => __('Default is .18', 'listingo_vc_shortcodes'),
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_Listingo_Post_Questions();
}