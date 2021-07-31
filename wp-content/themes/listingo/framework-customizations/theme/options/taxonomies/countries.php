<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'countries_settings' => array(
        'title' => esc_html__('Category Settings', 'listingo'),
        'type' => 'group',
        'options' => array(
            'country_image' => array(
                'type' => 'upload',
                'attr' => array('class' => 'custom-class', 'data-foo' => 'bar'),
                'label' => esc_html__('Country Image', 'listingo'),
                'desc' => esc_html__('Upload here countries background image. It will display in listing.', 'listingo'),
                'images_only' => true,
            ),
        )
    ),
);

