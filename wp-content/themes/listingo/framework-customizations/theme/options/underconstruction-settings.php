<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array(
    'comingsoon_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('Maintenance', 'listingo'),
        'options' => array(
            'comingsoon-box' => array(
                'title' => esc_html__('Coming Soon Settings', 'listingo'),
                'type' => 'box',
                'options' => array(
                    'maintenance' => array(
                        'type' => 'switch',
                        'value' => 'disable',
                        'label' => esc_html__('Maintenance Mode', 'listingo'),
                        'left-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'listingo'),
                        ),
                        'right-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disable', 'listingo'),
                        ),
                    ),
                    'background' => array(
                        'type' => 'upload',
                        'label' => esc_html__('Background Image', 'listingo'),
                        'desc' => esc_html__('Upload Your background image on coming soon page.', 'listingo'),
                        'images_only' => true,
                    ),
                    'maintenance_logo' => array(
                        'type' => 'upload',
                        'label' => esc_html__('Logo Image', 'listingo'),
                        'desc' => esc_html__('Upload Your logo image on coming soon page. Leave it empty to hide.', 'listingo'),
                        'images_only' => true,
                    ),
                    'maintenance_title' => array(
                        'type' => 'text',
                        'label' => esc_html__('Title', 'listingo'),
                        'value' => 'We’re Launching Soon',
                        'desc' => esc_html__('Leave it empty to hide.', 'listingo'),
                    ),
                    'maintenance_subtitle' => array(
                        'type' => 'text',
                        'label' => esc_html__('Sub Title', 'listingo'),
                        'value' => 'Seriously, We’re Working Really Hard!',
                        'desc' => esc_html__('Leave it empty to hide.', 'listingo'),
                    ),
                    'maintenance_description' => array(
                        'type' => 'textarea',
                        'label' => esc_html__('Description', 'listingo'),
                        'value' => '',
                        'desc' => esc_html__('Custom HTML Accepted. Leave it empty to hide.', 'listingo'),
                    ),
                    'maintenance_date' => array(
                        'type' => 'datetime-picker',
                        'label' => esc_html__('Set Date', 'listingo'),
                        'datetime-picker' => array(
                            'format' => 'Y/m/d H:i:s', // Format datetime.
                            'maxDate' => false, // By default there is not maximum date , set a date in the datetime format.
                            'minDate' => false, // By default minimum date will be current day, set a date in the datetime format.
                            'timepicker' => true, // Show timepicker.
                            'datepicker' => true, // Show datepicker.
                            'defaultTime' => '12:00' // If the input value is empty, timepicker will set time use defaultTime.
                        ),
                    ),
                    'maintenance_copyright' => array(
                        'type' => 'textarea',
                        'label' => esc_html__('Footer Description', 'listingo'),
                        'value' => 'Copyright © 2017 All Rights Reserved - Listingo',
                        'desc' => esc_html__('', 'listingo'),
                    ),
                    'newsletter' => array(
                        'type' => 'switch',
                        'value' => 'disable',
                        'label' => esc_html__('Newsletter', 'listingo'),
                        'left-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'listingo'),
                        ),
                        'right-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disable', 'listingo'),
                        ),
                    ),
                )
            ),
        )
    )
);
