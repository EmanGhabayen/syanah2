<?php

if (!defined('FW'))
    die('Forbidden');



$options = array(
    'category_heading' => array(
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('Add heading. leave it empty to hide.', 'listingo'),
        'type' => 'text',
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
