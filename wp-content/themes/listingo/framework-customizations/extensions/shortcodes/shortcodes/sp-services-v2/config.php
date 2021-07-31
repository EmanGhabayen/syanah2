<?php

if (!defined('FW')) {
    die('Forbidden');
}

$cfg = array();

$cfg = array(
    'page_builder' => array(
        'title' => esc_html__('Services v2', 'listingo'),
        'description' => esc_html__('Display icon services v2.', 'listingo'),
        'tab' => esc_html__('Listingo', 'listingo'),
        'popup_size' => 'small' // can be large, medium or small
    )
);
