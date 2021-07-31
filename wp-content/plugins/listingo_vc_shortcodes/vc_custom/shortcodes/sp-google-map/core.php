<?php

/**
 * @ Visual Composer Shortcode
 * @ Class SP Google Map
 * @ return {options}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core_SP_Goole_Map')) {

    class SC_VC_Core_SP_Goole_Map extends SC_VC_Core {

        public function __construct() {
            add_action( "admin_init", array(
                &$this,
                "listingo_vc_shortcodes_vc_SP_Google_Map_init"));
        }

        /**
         * @ Admin Init
         * # return {options}
         */
        public function listingo_vc_shortcodes_vc_SP_Google_Map_init() {
            vc_map(array(
                "name" => esc_html__("SP Google Map", 'listingo_vc_shortcodes'),
                "base" => "listingo_vc_sp_google_map",
                "class" => "",
                "controls" => "full",
                "show_settings_on_create" => true,
                "icon" => ListingoVCGlobalSettings::get_plugin_url() . '/vc_custom/shortcodes/sp-google-map/images/screenshot.png',
                "category" => esc_html__('Listingo Addon', 'listingo_vc_shortcodes'),
                "params" => array(
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '400',
                        'heading' => esc_html__('Map height', 'listingo_vc_shortcodes'),
                        'param_name' => 'map_height',
                        "description" => esc_html__("Add height in PX as : 200, Default is 300.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '-0.127758',
                        'heading' => esc_html__('Latitude', 'listingo_vc_shortcodes'),
                        'param_name' => 'latitude',
                        "description" => esc_html__("Add Latitude", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '51.507351',
                        'heading' => esc_html__('Longitude', 'listingo_vc_shortcodes'),
                        'param_name' => 'longitude',
                        "description" => esc_html__("Add Longitude.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'vc_number',
                        'class' => '',
                        'heading' => __('Zoom Level', 'listingo_vc_shortcodes'),
                        'param_name' => 'map_zoom',
                        'value' => 16,
                        'min' => 1,
                        'max' => 20,
                        'save_always' => true,
                        'description' => __('Default is .16', 'listingo_vc_shortcodes'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Map Type', 'listingo_vc_shortcodes'),
                        'param_name' => 'map_type',
                        "description" => esc_html__("Select map type", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('ROADMAP', 'listingo_vc_shortcodes') => 'ROADMAP',
                            esc_html__('HYBRID', 'listingo_vc_shortcodes') => 'HYBRID',
                            esc_html__('SATELLITE', 'listingo_vc_shortcodes') => 'SATELLITE',
                            esc_html__('TERRAIN', 'listingo_vc_shortcodes') => 'TERRAIN'
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Map Style', 'listingo_vc_shortcodes'),
                        'param_name' => 'map_styles',
                        "description" => esc_html__("Select map style. It will override map type.", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('NONE', 'listingo_vc_shortcodes') => 'none',
                            esc_html__('Default', 'listingo_vc_shortcodes') => 'view_1',
                            esc_html__('View 2', 'listingo_vc_shortcodes') => 'view_2',
                            esc_html__('View 3', 'listingo_vc_shortcodes') => 'view_3',
                            esc_html__('View 4', 'listingo_vc_shortcodes') => 'view_4',
                            esc_html__('View 5', 'listingo_vc_shortcodes') => 'view_5',
                            esc_html__('View 6', 'listingo_vc_shortcodes') => 'view_6'
                        ),
                    ),
                    array(
                        'type' => 'textarea',
                        'save_always' => true,
                        'value' => '',
                        'heading' => esc_html__('Map Infobox content', 'listingo_vc_shortcodes'),
                        'param_name' => 'map_info',
                        "description" => esc_html__("Enter the marker content.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '250',
                        'heading' => esc_html__('Map Infobox width', 'listingo_vc_shortcodes'),
                        'param_name' => 'info_box_width',
                        "description" => esc_html__("Set max width for the google map info box.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'textfield',
                        'save_always' => true,
                        'value' => '150',
                        'heading' => esc_html__('Map Infobox height', 'listingo_vc_shortcodes'),
                        'param_name' => 'info_box_height',
                        "description" => esc_html__("Set max height for the google map info box.", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'attach_image',
                        'value' => '',
                        'heading' => 'Upload Marker',
                        'param_name' => 'marker',
                        "description" => esc_html__("", 'listingo_vc_shortcodes')
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Map Controls', 'listingo_vc_shortcodes'),
                        'param_name' => 'map_controls',
                        "description" => esc_html__("Select map controls.", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('Off', 'listingo_vc_shortcodes') => 'true',
                            esc_html__('On', 'listingo_vc_shortcodes') => 'false'
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Map Dragable', 'listingo_vc_shortcodes'),
                        'param_name' => 'map_dragable',
                        "description" => esc_html__("Select map dragable.", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('Yes', 'listingo_vc_shortcodes') => 'true',
                            esc_html__('No', 'listingo_vc_shortcodes') => 'false'
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'save_always' => true,
                        'heading' => esc_html__('Scroll', 'listingo_vc_shortcodes'),
                        'param_name' => 'scroll',
                        "description" => esc_html__("Enable/Disbale Mouse over scroll.", 'listingo_vc_shortcodes'),
                        'value' => array(
                            esc_html__('Yes', 'listingo_vc_shortcodes') => 'true',
                            esc_html__('No', 'listingo_vc_shortcodes') => 'false'
                        ),
                    ),
                    $this->get_section_defaults('custom_id'), // Custom ID
                    $this->get_section_defaults('custom_classes'), //Custom Classes
                    $this->get_section_defaults('css'), //Custom css
                )
            ));
        }

    }

    new SC_VC_Core_SP_Goole_Map();
}