<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Counter
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Counter')) {

    class SC_VC_Core_Counter extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_shortcodes_vc_Counter_init"));
        }

        /**
         * @ Admin Init
         * # return {options}
         */
        public function listingo_vc_shortcodes_vc_Counter_init() {
            vc_map(array(
                "name" => esc_html__("SP Counter", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_counter",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-counter/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
					array(
                        'type' => 'colorpicker',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Text Color', 'listingo_vc_shortcodes'),
                        'param_name' => 'color',
                        "description" => esc_html__("Choose text color for", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'param_group',
                        'value' => '',
                        'heading' => esc_html__('Counters', 'listingo_vc_shortcodes'),
                        'param_name' => 'sp_counters',
                        "description" => esc_html__("Add Counters", 'listingo_vc_shortcodes'),
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Counter Title', 'listingo_vc_shortcodes'),
                                'param_name' => 'counter_title',
                                "description" => esc_html__("Add main heading, please leave it empty to hide.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'textfield',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Counter Value From', 'listingo_vc_shortcodes'),
                                'param_name' => 'counter_value_from',
                                "description" => esc_html__("Add Starting value of the counter, if empty it will be considered as 0.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'textfield',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Counter Value To', 'listingo_vc_shortcodes'),
                                'param_name' => 'counter_value_to',
                                "description" => esc_html__("Add Ending value of the counter, if empty it will be considered as 0", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'textfield',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Counter Speed', 'listingo_vc_shortcodes'),
                                'param_name' => 'counter_speed',
                                "description" => esc_html__("Add spped of the counter e.g 8000", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'textfield',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Data Refresh Interval', 'listingo_vc_shortcodes'),
                                'param_name' => 'counter_interval',
                                "description" => esc_html__("interval of data or increment of values in the counter e.g 50, 100 etc", 'listingo_vc_shortcodes')
                            ),
                        ),
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                ),
            ));
        }

    }

    new SC_VC_Core_Counter();
}