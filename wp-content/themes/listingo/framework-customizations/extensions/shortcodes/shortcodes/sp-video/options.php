<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'video_link' => array(
        'label' => esc_html__('Video Link', 'listingo'),
        'type' => 'text',
        'desc' => esc_html__('Add video / audio link here.', 'listingo')
    ),
    'video_width' => array(
        'label' => esc_html__('Video Width', 'listingo'),
        'type' => 'text',
        'desc' => esc_html__('Add video widht here with out px.', 'listingo')
    ),
    'video_height' => array(
        'label' => esc_html__('Video Height', 'listingo'),
        'type' => 'text',
        'desc' => esc_html__('Add video height here with out px.', 'listingo')
    ),
);
