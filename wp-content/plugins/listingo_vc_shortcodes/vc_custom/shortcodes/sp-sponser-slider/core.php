<?php

/**
 * @ Visual Composer Shortcode
 * @ Class SP Slider
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_SP_Sponsor_Slider')) {

    class SC_VC_Core_SP_Sponsor_Slider extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_shortcodes_vc_SP_Sponsor_Slider_init"));
        }

        /**
         * @ Admin Init
         * # return {options}
         */
        public function listingo_vc_shortcodes_vc_SP_Sponsor_Slider_init() {
            vc_map(array(
                "name" => esc_html__("SP Sponsor Slider", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_sp_sponsor_slider",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-sponser-slider/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
                    array(
						'type' => 'textfield',
						'save_always' => true,
						'value' => '',
						'heading' => esc_html__('Title', 'listingo_vc_shortcodes'),
						'param_name' => 'heading',
						"description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes')
					),
					array(
						'type' => 'textarea',
						'save_always' => true,
						'value' => '',
						'heading' => esc_html__('Description', 'listingo_vc_shortcodes'),
						'param_name' => 'description',
						"description" => esc_html__("Add Description, please leave it empty to hide.", 'listingo_vc_shortcodes')
					),
                    array(
                        'type' => 'param_group',
                        'value' => '',
                        'heading' => esc_html__('Sponsors', 'listingo_vc_shortcodes'),
                        'param_name' => 'sponsers_list',
                        "description" => esc_html__("Add Sponsors.", 'listingo_vc_shortcodes'),
                        'params' => array(
							array(
                                'type' => 'attach_image',
								'save_always' => true,
                                'value' => '',
                                'heading' => 'Image',
                                'param_name' => 'sponsor_image',
                                "description" => esc_html__("Upload sponsor image here.", 'listingo_vc_shortcodes')
                            ),
                            array(
                                'type' => 'textfield',
                                'save_always' => true,
                                'value' => '',
                                'heading' => esc_html__('Title', 'listingo_vc_shortcodes'),
                                'param_name' => 'sponser_title',
                                "description" => esc_html__("Add title, please leave it empty to hide.", 'listingo_vc_shortcodes')
                            ),
                            array(
								'type' => 'vc_link',
								'save_always' => true,
								'heading' => esc_html__('Sponsor Link', 'listingo_vc_shortcodes'),
								'param_name' => 'sponser_link',
								'description' => esc_html__('Add sponsor link here.', 'listingo_vc_shortcodes')
							),
							array(
								'type' => 'dropdown',
								'save_always' => true,
								'heading' => esc_html__('Link Target', 'listingo_vc_shortcodes'),
								'param_name' => 'link_target',
								"description" => esc_html__("Set link target to blank or self tabs.", 'listingo_vc_shortcodes'),
								'value' => array(
									esc_html__('blank', 'listingo_vc_shortcodes') => '_blank',
									esc_html__('self', 'listingo_vc_shortcodes') => '_self'
								),
							),
						),
					),
					array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Loop', 'listingo_vc_shortcodes'),
                        'param_name' => 'loop',
                        "description" => esc_html__("Slider loop", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('true', 'listingo_vc_shortcodes') => 'true',
                            esc_html__('false', 'listingo_vc_shortcodes') => 'false'
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Autoplay', 'listingo_vc_shortcodes'),
                        'param_name' => 'autpolay',
                        "description" => esc_html__("Slider Autoplay", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('true', 'listingo_vc_shortcodes') => 'true',
                            esc_html__('false', 'listingo_vc_shortcodes') => 'false'
                        ),
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_SP_Sponsor_Slider();
}