<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array(
    'app' => array(
        'title' => esc_html__('APP Settings', 'listingo'),
        'type' => 'tab',
        'options' => array(
            'app_settings' => array(
                'title' => esc_html__('APP Settings', 'listingo'),
                'type' => 'box',
                'options' => array(
                    'app_logo' => array(
                        'type' => 'upload',
                        'label' => esc_html__('Upload APP Logo', 'listingo'),
                        'desc' => esc_html__('Upload Your APP Logo Here, Preferred size is 130 by 61.', 'listingo'),
                        'images_only' => true,
                    ),
                )
            ),
        )
    )
);
