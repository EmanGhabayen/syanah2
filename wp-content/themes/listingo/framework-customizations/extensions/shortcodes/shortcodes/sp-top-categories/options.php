<?php

if (!defined('FW'))
    die('Forbidden');



$options = array(
    'section_heading' => array(
        'type' => 'text',
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('Add section heading. leave it empty to hide.', 'listingo'),
    ),
    'section_subheading' => array(
        'type' => 'text',
        'label' => esc_html__('Sub Heading', 'listingo'),
        'desc' => esc_html__('Add section sub heading. It will appear above the main heading. Leave it empty to hide.', 'listingo'),
    ),
    'posts' => array(
        'type' => 'multi-select',
        'label' => esc_html__('Select Posts', 'listingo'),
        'population' => 'posts',
        'source' => 'sp_categories',
        'prepopulate' => 500,
        'desc' => esc_html__('Show posts by post selection.', 'listingo'),
    ),
);
