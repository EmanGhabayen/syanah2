<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'subcategory_settings' => array(
        'title' => esc_html__('Sub Category Settings', 'listingo'),
        'type' => 'group',
        'options' => array(
            'subcat_color' => array(
				'type' => 'color-picker',
				'value' => '#5dc560',
				'label' => esc_html__('Color?', 'listingo'),
				'desc' => esc_html__('Add sub category color. It will be used for background or text color.', 'listingo'),
			),        
        )
    ),
);

