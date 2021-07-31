<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Blog Posts
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_SP_Blog_Posts')) {

    class SC_VC_Core_SP_Blog_Posts extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_blog_posts_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_blog_posts_init() {
            vc_map(array(
                "name" => esc_html__("SP News Posts", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_blog_posts",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-blog-posts/images/screenshot.png',
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
                        'class' => '',
                        'save_always' => true,
                        'heading' => esc_html__('Blog View', 'listingo_vc_shortcodes'),
                        'param_name' => 'blog_style',
                        'description' => esc_html__('Choose Blog view.', 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('Grid View', 'listingo_vc_shortcodes') => 'grid_view',
                            esc_html__('List View', 'listingo_vc_shortcodes') => 'list_view',
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        "value" => array(
                            esc_html__("By Categories", 'listingo_vc_shortcodes') => "by_catgories",
                            esc_html__("By Posts", 'listingo_vc_shortcodes') => "by_posts",
                        ),
                        'heading' => 'Posts By',
                        'param_name' => 'posts_by',
                        "description" => esc_html__("Please select posts selection type.", 'listingo_vc_shortcodes'),
                    ),
                    array(
                        'type' => 'checkbox',
                        'save_always' => true,
                        'heading' => esc_html__('Select Categories', 'listingo_vc_shortcodes'),
                        'param_name' => 'categories',
                        "description" => esc_html__("Select Categories to show posts from selected categories.", 'listingo_vc_shortcodes'),
                        'value' => $this->listingo_vc_shortcodes_prepare_taxonomies('post', 'category', 0), // [Post Type][Taxonomy][Hide Empty ,0,1]
                        'dependency' => array(
                            'element' => 'posts_by',
                            'value' => 'by_catgories',
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'save_always' => true,
                        'heading' => esc_html__('Select Posts', 'listingo_vc_shortcodes'),
                        'param_name' => 'specific_posts',
                        "description" => esc_html__("Please select posts to show", 'listingo_vc_shortcodes'),
                        'value' => $this->listingo_vc_shortcodes_prepare_custom_posts('post', 50),
                        'dependency' => array(
                            'element' => 'posts_by',
                            'value' => 'by_posts',
                        ),
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
                        'save_always' => true,
                        'heading' => esc_html__('Custom Columns', 'listingo_vc_shortcodes'),
                        'param_name' => 'custom_columns',
                        'std' => 'no',
                        "description" => esc_html__("Add custom culumns for blog posts.", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('Add Now', 'listingo_vc_shortcodes') => 'yes',
                            esc_html__('Leave it default', 'listingo_vc_shortcodes') => 'no'
                        ),
                        "group" => "Columns Settings",
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        "value" => array(
                            "default" => "Default",
                            "col-lg-1" => "col-lg-1",
                            "col-lg-2" => "col-lg-2",
                            "col-lg-3" => "col-lg-3",
                            "col-lg-4" => "col-lg-4",
                            "col-lg-5" => "col-lg-5",
                            "col-lg-6" => "col-lg-6",
                            "col-lg-7" => "col-lg-7",
                            "col-lg-8" => "col-lg-8",
                            "col-lg-9" => "col-lg-9",
                            "col-lg-10" => "col-lg-10",
                            "col-lg-11" => "col-lg-11",
                            "col-lg-12" => "col-lg-12",
                        ),
                        'heading' => 'Large Columns',
                        'param_name' => 'column_lg',
                        "description" => esc_html__("Add your Custom Grid Classes for large screens. Default is col-lg-4", 'listingo_vc_shortcodes'),
                        'dependency' => array(
                            'element' => 'custom_columns',
                            'value' => 'yes',
                        ),
                        "group" => "Columns Settings",
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        "value" => array(
                            "col-md-1" => "col-md-1",
                            "col-md-2" => "col-md-2",
                            "col-md-3" => "col-md-3",
                            "col-md-4" => "col-md-4",
                            "col-md-5" => "col-md-5",
                            "col-md-6" => "col-md-6",
                            "col-md-7" => "col-md-7",
                            "col-md-8" => "col-md-8",
                            "col-md-9" => "col-md-9",
                            "col-md-10" => "col-md-10",
                            "col-md-11" => "col-md-11",
                            "col-md-12" => "col-md-12",
                        ),
                        'heading' => 'Medium Columns',
                        'param_name' => 'column_md',
                        "description" => esc_html__("Select your Custom Grid Classes for medium screens. Default is col-md-4", 'listingo_vc_shortcodes'),
                        'dependency' => array(
                            'element' => 'custom_columns',
                            'value' => 'yes',
                        ),
                        "group" => "Columns Settings",
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        "value" => array(
                            "col-sm-1" => "col-sm-1",
                            "col-sm-2" => "col-sm-2",
                            "col-sm-3" => "col-sm-3",
                            "col-sm-4" => "col-sm-4",
                            "col-sm-5" => "col-sm-5",
                            "col-sm-6" => "col-sm-6",
                            "col-sm-7" => "col-sm-7",
                            "col-sm-8" => "col-sm-8",
                            "col-sm-9" => "col-sm-9",
                            "col-sm-10" => "col-sm-10",
                            "col-sm-11" => "col-sm-11",
                            "col-sm-12" => "col-sm-12",
                        ),
                        'heading' => 'Small Columns',
                        'param_name' => 'column_sm',
                        "description" => esc_html__("Select your Custom Grid Classes for small screens. Default is col-sm-6", 'listingo_vc_shortcodes'),
                        'dependency' => array(
                            'element' => 'custom_columns',
                            'value' => 'yes',
                        ),
                        "group" => "Columns Settings",
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        "value" => array(
                            "col-xs-1" => "col-xs-1",
                            "col-xs-2" => "col-xs-2",
                            "col-xs-3" => "col-xs-3",
                            "col-xs-4" => "col-xs-4",
                            "col-xs-5" => "col-xs-5",
                            "col-xs-6" => "col-xs-6",
                            "col-xs-7" => "col-xs-7",
                            "col-xs-8" => "col-xs-8",
                            "col-xs-9" => "col-xs-9",
                            "col-xs-10" => "col-xs-10",
                            "col-xs-11" => "col-xs-11",
                            "col-xs-12" => "col-xs-12",
                        ),
                        'heading' => 'Extra Small Columns',
                        'param_name' => 'column_xs',
                        "description" => esc_html__("Select your Custom Grid Classes for extra small screens. Default is col-xs-6", 'listingo_vc_shortcodes'),
                        'dependency' => array(
                            'element' => 'custom_columns',
                            'value' => 'yes',
                        ),
                        "group" => "Columns Settings",
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_SP_Blog_Posts();
}