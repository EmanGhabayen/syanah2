<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Blog Posts
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_SP_Providers_Cat')) {

    class SC_VC_Core_SP_Providers_Cat extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_providers_cat_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_providers_cat_init() {
            vc_map(array(
                "name" => esc_html__("Providers By Categories", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_providers_cat",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/providers-by-cats/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Heading', 'listingo_vc_shortcodes'),
                        'param_name' => 'heading',
                        "description" => esc_html__("Add Section heading, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('SubHeading', 'listingo_vc_shortcodes'),
                        'param_name' => 'sub_heading',
                        "description" => esc_html__("Add Section Sub heading, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),  
                    array(
                        'type' => 'dropdown',
                        'class' => '',
                        'save_always' => true,
                        'heading' => esc_html__('Blog View', 'listingo_vc_shortcodes'),
                        'param_name' => 'style',
                        'description' => esc_html__('Choose Blog view.', 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('Grid View', 'listingo_vc_shortcodes') => 'grid_view',
                            esc_html__('List View', 'listingo_vc_shortcodes') => 'list_view',
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'save_always' => true,
                        'heading' => esc_html__('Select Categories', 'listingo_vc_shortcodes'),
                        'param_name' => 'categories',
                        "description" => esc_html__("Show users by category selection. Leave it empty to show from all categories", 'listingo_vc_shortcodes'),
                        'value' => $this->listingo_vc_shortcodes_prepare_custom_posts('sp_categories', 50),// [Post Type][Taxonomy][Hide Empty ,0,1]
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
                        'heading' => 'Pagination',
                        'param_name' => 'show_pagination',
                        'save_always' => true,
                        "description" => esc_html__("Show or hide pagination.", 'listingo_vc_shortcodes'),
                        'value' => array(
                            'YES' => 'yes',
                            'NO' => 'no'
                        )
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_SP_Providers_Cat();
}