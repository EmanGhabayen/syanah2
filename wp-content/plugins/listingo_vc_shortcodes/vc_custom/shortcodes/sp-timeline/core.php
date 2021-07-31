<?php

/**
 * @ Visual Composer Shortcode
 * @ Class SP Timeline
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_SP_Timeline')) {

    class SC_VC_Core_SP_Timeline extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_shortcodes_vc_Call_To_Action_init"));
        }

        /**
         * @ Admin Init
         * # return {options}
         */
        public function listingo_vc_shortcodes_vc_Call_To_Action_init() {
            vc_map(array(
                "name" => esc_html__("SP Timeline", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_sp_timeline",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-timeline/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Heading', 'listingo_vc_shortcodes'),
                        'param_name' => 'sec_heading',
                        "description" => esc_html__("Add main heading, please leave it empty to hide.", 'listingo_vc_shortcodes')
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
                        'type' => 'param_group',
                        'value' => '',
                        'heading' => esc_html__('Timeline History', 'listingo_vc_shortcodes'),
                        'param_name' => 'timeline_tabs',
                        "description" => esc_html__("Add Timeline History.", 'listingo_vc_shortcodes'),
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Timeline Year.', 'listingo_vc_shortcodes'),
                                'param_name' => 'timeline_year',
                                "description" => esc_html__("Add timeline year, please leave it empty to hide.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'textfield',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Timeline Title', 'listingo_vc_shortcodes'),
                                'param_name' => 'timeline_title',
                                "description" => esc_html__("Add title here. Leave it empty to hide.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'textarea',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Timeline Description', 'listingo_vc_shortcodes'),
                                'param_name' => 'timeline_desc',
                                "description" => esc_html__("Add description, please leave it empty to hide.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'attach_images',
                                'value' => '',
                                'heading' => 'Timeline Gallery',
                                'param_name' => 'timeline_gallery',
                                "description" => esc_html__("Add timeline gallery here.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'vc_link',
                                'heading' => esc_html__('Timeline URL (Link)', 'listingo_vc_shortcodes'),
                                'param_name' => 'timeline_link',
                                'description' => esc_html__('', 'listingo_vc_shortcodes')
                            ),
                        )
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_SP_Timeline();
}