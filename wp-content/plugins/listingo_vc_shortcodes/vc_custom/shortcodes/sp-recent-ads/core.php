<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Recent Ads
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_SP_Recent_Ads')) {

    class SC_VC_Core_SP_Recent_Ads extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_recent_ads"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_recent_ads() {
            vc_map(array(
                "name" => esc_html__("Recent Ads", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_recent_ads",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-featured-listing/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Section Heading', 'listingo_vc_shortcodes'),
                        'param_name' => 'section_heading',
                        "description" => esc_html__("Add Section heading, please leave it empty to hide.", 'listingo_vc_shortcodes')
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
                        "value" => array(
                            esc_html__("By Categories", 'listingo_vc_shortcodes') => "by_catgories",
                            esc_html__("All", 'listingo_vc_shortcodes') => "by_posts",
                        ),
                        'heading' => esc_html__("Ads listing type", 'listingo_vc_shortcodes'),
                        'param_name' => 'posts_by',
                        "description" => esc_html__("Please select type show ads.", 'listingo_vc_shortcodes'),
                    ),
                    array(
                        'type' => 'checkbox',
                        'save_always' => true,
                        'heading' => esc_html__('Select Categories', 'listingo_vc_shortcodes'),
                        'param_name' => 'categories',
                        "description" => esc_html__("Select Categories to show ads.", 'listingo_vc_shortcodes'),
                        'value' => $this->listingo_vc_shortcodes_prepare_taxonomies('sp_ads','ad_category',0),// [Post Type][Taxonomy][Hide Empty ,0,1]
                        'dependency' => array(
                            'element' => 'posts_by',
                            'value' => 'by_catgories',
                        ),
                    ),
                    array(
                        'type' => 'vc_number',
                        'class' => '',
                        'heading' => __('no of ads', 'listingo_vc_shortcodes'),
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
                            esc_html__("ON", 'listingo_vc_shortcodes') => 'on',
                            esc_html__("OFF", 'listingo_vc_shortcodes') => 'off'
                        )
                    ),
                    
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_SP_Recent_Ads();
}