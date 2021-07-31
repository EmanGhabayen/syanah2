<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Ad Box
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Video')) {

    class SC_VC_Core_Video extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_Video_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_Video_init() {
            vc_map(array(
                "name" => esc_html__("SP Video", 'listingo_vc_shortcodes'),
                "base" => "listingo_video",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-video/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Title', 'listingo_vc_shortcodes'),
                        'param_name' => 'sec_title',
                        "description" => esc_html__("Add main title, please leave it empty to hide.", 'listingo_vc_shortcodes')
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
                        'type' => 'textfield',
                        'value' => '',
                        'heading' => 'Video link',
                        'param_name' => 'video_link',
                        "description" => esc_html__("To place a video/audio, please put video link in this field", 'listingo_vc_shortcodes')
                    ), array(
                        'type' => 'textfield',
                        'value' => '',
                        'heading' => 'Height',
                        'param_name' => 'video_height',
                        "description" => esc_html__("Height of iframe", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textfield',
                        'value' => '',
                        'heading' => 'Width',
                        'param_name' => 'video_width',
                        "description" => esc_html__("Width of iframe", 'listingo_vc_shortcodes')
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom Classes
                )
            ));
        }

    }

    new SC_VC_Core_Video();
}