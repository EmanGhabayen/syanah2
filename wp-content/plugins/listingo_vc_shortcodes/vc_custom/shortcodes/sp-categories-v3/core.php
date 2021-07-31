<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Listingo_Categories_vthree')) {

    class SC_VC_Core_Listingo_Categories_vthree extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_search_sp_categories_three_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_search_sp_categories_three_init() {
            vc_map(array(
                "name" => esc_html__("SP Categories V3", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_categories_vthree",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-trending-categories/images/screenshot.png',
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
                        'type' => 'textarea_html',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Section Description', 'listingo_vc_shortcodes'),
                        'param_name' => 'content',
                        "description" => esc_html__("Add description, please leave it empty to hide.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'checkbox',
                        'save_always' => true,
                        'heading' => esc_html__('Select Posts', 'listingo_vc_shortcodes'),
                        'param_name' => 'specific_posts',
                        "description" => esc_html__("Please select posts to show", 'listingo_vc_shortcodes'),
                        'value' => $this->listingo_vc_shortcodes_prepare_custom_posts('sp_categories', 50),                    
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
                        "value" => array(
                            esc_html__("Vew 1", 'listingo_vc_shortcodes') => "one",
                            esc_html__("View 2", 'listingo_vc_shortcodes') => "two",
                            esc_html__("View 3", 'listingo_vc_shortcodes') => "three",
                        ),
                        'heading' => 'Select View',
                        'param_name' => 'view',
                        "description" => esc_html__("Please select style view.", 'listingo_vc_shortcodes'),
                    ),                                   
                    array(
                        'type' => 'vc_link',
                        'value' => '',
                        'heading' => esc_html__('Link', 'listingo_vc_shortcodes'),
                        'param_name' => 'service_link',
                        'dependency' => array(
                            'element' => 'view',
                            'value' => array('one', 'three'),
                        ),
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_Listingo_Categories_vthree();
}