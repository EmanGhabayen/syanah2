<?php

/**
 * @ Visual Composer Shortcode
 * @ Class SP Slider
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_SP_Slider')) {

    class SC_VC_Core_SP_Slider extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_shortcodes_vc_SP_Slider_init"));
        }

        /**
         * @ Admin Init
         * # return {options}
         */
        public function listingo_vc_shortcodes_vc_SP_Slider_init() {
            vc_map(array(
                "name" => esc_html__("SP Slider", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_sp_slider",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-slider/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Select style', 'listingo_vc_shortcodes'),
                        'param_name' => 'slider_view',
                        "description" => esc_html__("", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('View 1', 'listingo_vc_shortcodes') => 'view1',
                            esc_html__('View 2', 'listingo_vc_shortcodes') => 'view2',
                            esc_html__('View 3', 'listingo_vc_shortcodes') => 'view3'
                        )
                    ),
                    array(
                        'type' => 'param_group',
                        'value' => '',
                        'heading' => esc_html__('Slider', 'listingo_vc_shortcodes'),
                        'param_name' => 'slides',
                        "description" => esc_html__("Add slide.", 'listingo_vc_shortcodes'),
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Title', 'listingo_vc_shortcodes'),
                                'param_name' => 'title',
                                "description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'textfield',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Sub title', 'listingo_vc_shortcodes'),
                                'param_name' => 'sub_title',
                                "description" => esc_html__("Add Sub title, please leave it empty to hide.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'textarea',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Description', 'listingo_vc_shortcodes'),
                                'param_name' => 'slide_description',
                                "description" => esc_html__("Add description, please leave it empty to hide.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'attach_image',
                                'value' => '',
                                'heading' => 'Image',
                                'param_name' => 'slide_image',
                                "description" => esc_html__("Upload your slider image here.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'param_group',
                                'value' => '',
                                'heading' => esc_html__('Add Slider Buttons', 'listingo_vc_shortcodes'),
                                'param_name' => 'slide_buttons',
                                "description" => esc_html__("Add Features.", 'listingo_vc_shortcodes'),
                                'params' => array(
                                    array(
                                        'type' => 'vc_link',
                                        'heading' => esc_html__('Button Link', 'listingo_vc_shortcodes'),
                                        'param_name' => 'button_link',
                                        'description' => esc_html__('Add slider buttton link here.', 'listingo_vc_shortcodes')
                                    ),
                                )
                            ),
                        ),
                        'dependency' => array(
                            'element' => 'slider_view',
                            'value' => 'view1',
                        ),
                    ),               
                    //testing only for 3
                     array(
                        'type' => 'attach_image',                        
                        'heading' => 'Image',
                        'param_name' => 'image',
                        "description" => esc_html__("Upload your top image.", 'listingo_vc_shortcodes'),
                          'dependency' => array(
                            'element' => 'slider_view',
                            'value' => 'view3'
                        ),
                    ),
                    array(
                        'type' => 'attach_images',
                        'value' => '',
                        'heading' => 'Select images',
                        'param_name' => 'slider_images',
                        "description" => esc_html__("Select multiple images.", 'listingo_vc_shortcodes'),
                        'dependency' => array(
                            'element' => 'slider_view',
                            'value' => array('view3','view2'),
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Title', 'listingo_vc_shortcodes'),
                        'param_name' => 'title',
                        "description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes'),
                        'dependency' => array(
                            'element' => 'slider_view',
                            'value' => array('view3','view2'),
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Sub title', 'listingo_vc_shortcodes'),
                        'param_name' => 'sub_title',
                        "description" => esc_html__("Add Sub title, please leave it empty to hide.", 'listingo_vc_shortcodes'),
                        'dependency' => array(
                            'element' => 'slider_view',
                            'value' => array('view3','view2'),
                        ),
                    ),
                    array(
                        'type' => 'textarea',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Description', 'listingo_vc_shortcodes'),
                        'param_name' => 'slide_description',
                        "description" => esc_html__("Add description, please leave it empty to hide.", 'listingo_vc_shortcodes'),
                        'dependency' => array(
                            'element' => 'slider_view',
                            'value' => 'view2',
                        ),
                    ),
                    array(
                        'type' => 'param_group',
                        'value' => '',
                        'heading' => esc_html__('Add Slider Buttons', 'listingo_vc_shortcodes'),
                        'param_name' => 'slide_buttons',
                        "description" => esc_html__("Add Features.", 'listingo_vc_shortcodes'),
                        'params' => array(
                            array(
                                'type' => 'vc_link',
                                'heading' => esc_html__('Button Link', 'listingo_vc_shortcodes'),
                                'param_name' => 'button_link',
                                'description' => esc_html__('Add slider buttton link here.', 'listingo_vc_shortcodes')
                            ),
                        ),
                        'dependency' => array(
                            'element' => 'slider_view',
                            'value' => 'view2',
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Show Form', 'listingo_vc_shortcodes'),
                        'param_name' => 'show_form',
                        "description" => esc_html__("Enable or Disable search form.", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('Disable', 'listingo_vc_shortcodes') => 'disable',
                            esc_html__('Enable', 'listingo_vc_shortcodes') => 'enable'
                        ),
                        'dependency' => array(
                            'element' => 'slider_view',
                            'value' => array('view3','view2'),
                        ),
                    ),
                    //testing only for 3
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Form Title', 'listingo_vc_shortcodes'),
                        'param_name' => 'form_title',
                        "description" => esc_html__("Enter form title here.", 'listingo_vc_shortcodes'),
                        'dependency' => array(
                            'element' => 'show_form',
                            'value' => 'enable',
                        ),
                        'dependency' => array(
                            'element' => 'slider_view',
                            'value' => 'view2',
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Form button text', 'listingo_vc_shortcodes'),
                        'param_name' => 'form_button_title',
                        "description" => esc_html__("Enter form button title here.", 'listingo_vc_shortcodes'),
                        'dependency' => array(
                            'element' => 'show_form',
                            'value' => 'enable',
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Show Pagination', 'listingo_vc_shortcodes'),
                        'param_name' => 'show_pagination',
                        "description" => esc_html__("Show/Hide slider Pagination", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('Disable', 'listingo_vc_shortcodes') => 'disable',
                            esc_html__('Enable', 'listingo_vc_shortcodes') => 'enable'
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Show Navigation', 'listingo_vc_shortcodes'),
                        'param_name' => 'show_navigation',
                        "description" => esc_html__("Show/Hide slider Navigation", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('Disable', 'listingo_vc_shortcodes') => 'disable',
                            esc_html__('Enable', 'listingo_vc_shortcodes') => 'enable'
                        ),
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_SP_Slider();
}