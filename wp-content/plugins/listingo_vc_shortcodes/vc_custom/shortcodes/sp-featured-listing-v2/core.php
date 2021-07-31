<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Blog Posts
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_SP_Featured_Listings_V2')) {

    class SC_VC_Core_SP_Featured_Listings_V2 extends SC_VC_Core {

        public function __construct() {
            add_action("init", array(
                &$this,
                "listingo_vc_featured_listing_v2_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_featured_listing_v2_init() {
            vc_map(array(
                "name" => esc_html__("Featured Users V2", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_featured_listing_v2",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-featured-listing-v2/images/screenshot.png',
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
                        'save_always' => true,
                        "value" => array(
                            esc_html__("By Categories", 'listingo_vc_shortcodes') => "by_catgories",
                            esc_html__("By Users", 'listingo_vc_shortcodes') => "by_users",
                        ),
                        'heading' => 'Users By',
                        'param_name' => 'posts_by',
                        "description" => esc_html__("Please select users selection type.", 'listingo_vc_shortcodes'),
                    ),
                    array(
                        'type' => 'checkbox',
                        'save_always' => true,
                        'heading' => esc_html__('Select Categories', 'listingo_vc_shortcodes'),
                        'param_name' => 'categories',
                        "description" => esc_html__("Select Categories to show users from selected categories.", 'listingo_vc_shortcodes'),
                        'value' => $this->listingo_vc_shortcodes_prepare_custom_posts('sp_categories', 50),// [Post Type][Taxonomy][Hide Empty ,0,1]
                        'dependency' => array(
                            'element' => 'posts_by',
                            'value' => 'by_catgories',
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'save_always' => true,
                        'heading' => esc_html__('Select Users', 'listingo_vc_shortcodes'),
                        'param_name' => 'specific_posts',
                        "description" => esc_html__("Please select users to show", 'listingo_vc_shortcodes'),
                        'value' => $this->listingo_vc_shortcodes_prepare_professionals(),
                        'dependency' => array(
                            'element' => 'posts_by',
                            'value' => 'by_users',
                        ),
                    ),
                    array(
                        'type' => 'vc_number',
                        'class' => '',
                        'heading' => esc_html__('No of users', 'listingo_vc_shortcodes'),
                        'param_name' => 'no_of_posts',
                        'value' => 6,
                        'min' => 1,
                        'max' => 1000,
                        'save_always' => true,
                        'description' => esc_html__('Default is .6', 'listingo_vc_shortcodes'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Pagination',
                        'param_name' => 'show_pagination',
                        'save_always' => true,
                        "description" => esc_html__("Show or hide pagination.", 'listingo_vc_shortcodes'),
                        'value' => array(
                            'ON' => 'on',
                            'OFF' => 'off'
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('User Order', 'listingo_vc_shortcodes'),
                        'param_name' => 'order',
                        "description" => esc_html__("User Order", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('ASC', 'listingo_vc_shortcodes') => 'ASC',
                            esc_html__('DESC', 'listingo_vc_shortcodes') => 'DESC'
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Show Button?', 'listingo_vc_shortcodes'),
                        'param_name' => 'btn',
                        "description" => esc_html__("Show View all button", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('YES', 'listingo_vc_shortcodes') => 'yes',
                            esc_html__('NO', 'listingo_vc_shortcodes') => 'no'
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Order By', 'listingo_vc_shortcodes'),
                        'param_name' => 'orderby',
                        "description" => esc_html__("User Order", 'listingo_vc_shortcodes'),
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
                    
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_SP_Featured_Listings_V2();
}