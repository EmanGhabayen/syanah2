<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'category_settings' => array(
        'title' => esc_html__('Category Settings', 'listingo'),
        'type' => 'group',
        'options' => array(
            'cat_color' => array(
				'type' => 'color-picker',
				'value' => '#5dc560',
				'label' => esc_html__('Color?', 'listingo'),
				'desc' => esc_html__('Add category color. It will be used for background or text color.', 'listingo'),
			),        
        )
    ),
);

