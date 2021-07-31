<?php

if (!defined('FW')) {
    die('Forbidden');
}

$cfg = array();

$cfg = array(
    'page_builder' => array(
        'title' => esc_html__('Our Partners', 'listingo'),
        'description' => esc_html__('Display our partners.', 'listingo'),
        'tab' => esc_html__('Listingo', 'listingo'),
        'popup_size' => 'small' // can be large, medium or small
    )
);
