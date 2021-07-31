<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'amenities_settings' => array(
        'type' => 'group',
        'options' => array(
            'amenities_icon' => array(
                'type' => 'icon-v2',
                'preview_size' => 'small',
                'modal_size' => 'medium',
                'attr' => array('class' => 'custom-class', 'data-foo' => 'bar'),
                'label' => esc_html__('Amenities Icon', 'listingo'),
                'desc' => esc_html__('Choose Amenities/Features Icon. Leave blank to not display.', 'listingo'),
            ),
        )
    ),
);

