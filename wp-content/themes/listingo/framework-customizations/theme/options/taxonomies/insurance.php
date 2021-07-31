<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'settings' => array(
        'type' => 'group',
        'options' => array(
            'logo' => array(
                'type' => 'upload',
                'label' => esc_html__('Insurance Logo', 'listingo'),
                'desc' => esc_html__('Please upload isnurance logo. Leave it empty to hide.', 'listingo'),
            ),
        )
    ),
);

