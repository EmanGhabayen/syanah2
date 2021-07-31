<?php

if (!defined('FW'))
    die('Forbidden');

$options = array(
    'heading' => array(
        'label' => esc_html__('Form Heading', 'listingo'),
        'desc' => esc_html__('Search the forum for previous questions or ask a new question.', 'listingo'),
        'type' => 'text',
    ),
    'form_image' => array(
        'label' => esc_html__('Upload Image', 'listingo'),
        'desc' => esc_html__('Form image that would be display at the start of the heading.', 'listingo'),
        'type' => 'upload',
    ),
);
