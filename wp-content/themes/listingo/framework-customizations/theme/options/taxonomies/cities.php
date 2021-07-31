<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'cities_settings' => array(
        'type' => 'group',
        'options' => array(
            'country' => array(
                'type' => 'multi-select',
                'label' => esc_html__('Choose Country', 'listingo'),
                'desc' => esc_html__('Choose country to which you want to assign this city.', 'listingo'),
                'population' => 'taxonomy',
                'source' => 'countries',
                'prepopulate' => 2500,
                'limit' => 1
            ),
            'image' => array(
                'type' => 'upload',
                'attr' => array('class' => 'custom-class', 'data-foo' => 'bar'),
                'label' => esc_html__('City Image', 'listingo'),
                'desc' => esc_html__('Upload here cities background image. It will display in listing.', 'listingo'),
                'images_only' => true,
            ),
        )
    ),
);

