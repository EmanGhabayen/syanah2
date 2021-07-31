<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array(
    'map_height' => array(
        'type' => 'text',
        'value' => '400',
        'label' => esc_html__('Map height', 'listingo'),
        'desc' => esc_html__('Add height in PX as : 200, Default is 300', 'listingo'),
    ),
    'latitude' => array(
        'type' => 'text',
        'value' => '-0.127758',
        'label' => esc_html__('Latitude', 'listingo'),
        'desc' => esc_html__('Add Latitude', 'listingo'),
    ),
    'longitude' => array(
        'type' => 'text',
        'value' => '51.507351',
        'label' => esc_html__('Longitude', 'listingo'),
        'desc' => esc_html__('Add Longitude', 'listingo'),
    ),
    'map_zoom' => array(
        'type' => 'slider',
        'value' => 16,
        'properties' => array(
            'min' => 0,
            'max' => 20,
            'sep' => 1,
        ),
        'attr' => array(),
        'label' => esc_html__('Zoom Level', 'listingo'),
        'desc' => esc_html__('', 'listingo'),
    ),
    'map_type' => array(
        'type' => 'select',
        'choices' => array(
            'ROADMAP' => esc_html__('ROADMAP', 'listingo'),
            'HYBRID' => esc_html__('HYBRID', 'listingo'),
            'SATELLITE' => esc_html__('SATELLITE', 'listingo'),
            'TERRAIN' => esc_html__('TERRAIN', 'listingo'),
        ),
        'label' => esc_html__('Map Type', 'listingo'),
        'desc' => esc_html__('Select map type.', 'listingo'),
    ),
    'map_styles' => array(
        'type' => 'select',
        'choices' => array(
            'none' => esc_html__('NONE', 'listingo'),
            'view_1' => esc_html__('Default', 'listingo'),
            'view_2' => esc_html__('View 2', 'listingo'),
            'view_3' => esc_html__('View 3', 'listingo'),
            'view_4' => esc_html__('View 4', 'listingo'),
            'view_5' => esc_html__('View 5', 'listingo'),
            'view_6' => esc_html__('View 6', 'listingo'),
        ),
        'label' => esc_html__('Map Style', 'listingo'),
        'desc' => esc_html__('Select map style. It will override map type.', 'listingo'),
    ),
    'map_info' => array(
        'type' => 'textarea',
        'value' => '',
        'label' => esc_html__('Map Infobox content', 'listingo'),
        'desc' => esc_html__('Enter the marker content', 'listingo'),
    ),
    'info_box_width' => array(
        'type' => 'text',
        'value' => '250',
        'label' => esc_html__('Map Infobox width', 'listingo'),
        'desc' => esc_html__('Set max width for the google map info box', 'listingo'),
    ),
    'info_box_height' => array(
        'type' => 'text',
        'value' => '150',
        'label' => esc_html__('Map Infobox height', 'listingo'),
        'desc' => esc_html__('Set max height for the google map info box', 'listingo'),
    ),
    'marker' => array(
        'type' => 'upload',
        'attr' => array(),
        'label' => esc_html__('Marker', 'listingo'),
        'desc' => esc_html__('Add Map Marker', 'listingo'),
    ),
    'map_controls' => array(
        'type' => 'select',
        'choices' => array(
            'true' => esc_html__('OFF', 'listingo'),
            'false' => esc_html__('ON', 'listingo'),
        ),
        'label' => esc_html__('Map Controls', 'listingo'),
        'desc' => esc_html__('Select map controls.', 'listingo'),
    ),
    'map_dragable' => array(
        'type' => 'select',
        'choices' => array(
            'true' => esc_html__('Yes', 'listingo'),
            'false' => esc_html__('NO', 'listingo'),
        ),
        'label' => esc_html__('Map Dragable', 'listingo'),
        'desc' => esc_html__('Select map dragable?', 'listingo'),
    ),
    'scroll' => array(
        'type' => 'select',
        'choices' => array(
            'false' => 'No',
            'true' => 'Yes',
        ),
        'label' => esc_html__('Scroll', 'listingo'),
        'desc' => esc_html__('Enable/Disbale Mouse over scroll.', 'listingo'),
    ),
);
