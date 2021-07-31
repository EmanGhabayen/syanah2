<?php

/**
 * @ Visual Composer Shortcode
 * @ Class Services Grid
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_Services_Items_Two')) {

    class SC_VC_Core_Services_Items_Two extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_Services_Grid_init"));
        }

        /**
         * @ Admin Init
         * # return {options
         */
        public function listingo_vc_Services_Grid_init() {
            vc_map(array(
                "name" => esc_html__("SP Services V2", 'listingo_vc_shortcodes'),
                "base" => "listingo_services_item_two",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-services-2/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(                   
                        array(
                            'type' => 'textfield',
                            'save_always' => true,
                            'value' => '',
                            'heading' => esc_html__('Section Title', 'listingo_vc_shortcodes'),
                            'param_name' => 'sec_heading',
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
                        'type' => 'param_group',
                        'value' => '',
                        'heading' => esc_html__('Services', 'listingo_vc_shortcodes'),
                        'param_name' => 'services',
                        "description" => esc_html__("Add Services.", 'listingo_vc_shortcodes'),
                        'params' => array(											             
							array(
								'type' => 'colorpicker',
								'save_always' => true,
								'value' => '',
								'heading' => esc_html__('Color', 'listingo_vc_shortcodes'),
								'param_name' => 'color',
								"description" => esc_html__("Choose color for the count text", 'listingo_vc_shortcodes'),
								'dependency' => array(
									'element' => 'show_count',
									'value' => 'yes',
								),
							),      																	
							$this->get_icon_library('list'),
							$this->get_icon_library('fontawesome'),
							$this->get_icon_library('openiconic'),
							$this->get_icon_library('typicons'),
							$this->get_icon_library('entypo'),
							$this->get_icon_library('linecons'),
							$this->get_icon_library('monosocial'),
							$this->get_icon_library('material'),  
							//$this->get_icon_library('linear'),  							                                      
							array(
								'type' => 'textarea',
								'save_always' => true,
								'value' => '',
								'heading' => esc_html__('Service Description', 'listingo_vc_shortcodes'),
								'param_name' => 'service_description',
								"description" => esc_html__("Add service description, please leave it empty to hide.", 'listingo_vc_shortcodes')
							),
							array(
								'type' => 'vc_link',
								'value' => '',
								'heading' => esc_html__('Link', 'listingo_vc_shortcodes'),
								'param_name' => 'service_link',
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

    new SC_VC_Core_Services_Items_Two();
}