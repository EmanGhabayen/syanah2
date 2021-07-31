<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'settings' => array(
        'title' => 'Packages Settings',
        'type' => 'box',
        'options' => array(
            'featured' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Make Featured?', 'listingo'),
                'desc' => esc_html__('Show this package is trending.', 'listingo'),
            ),
            'pac_subtitle' => array(
                'type' => 'text',
                'attr' => array(),
                'label' => esc_html__('Package Sub Title', 'listingo'),
                'desc' => esc_html__('Add Package Sub Title', 'listingo'),
            ),
            'short_description' => array(
                'type' => 'textarea',
                'attr' => array(),
                'label' => esc_html__('Package Description', 'listingo'),
                'desc' => esc_html__('Add Package short description.', 'listingo'),
            ),
            'duration' => array(
                'type' => 'text',
                'attr' => array(),
                'label' => esc_html__('Package Duration', 'listingo'),
                'help' => esc_html__('Package Duation is in Days. Please add number of days for this package.', 'listingo'),
                'desc' => esc_html__('Add Duration as : 30, please add only integer value', 'listingo'),
            ),
            'price' => array(
                'type' => 'text',
                'attr' => array(),
                'label' => esc_html__('Package price', 'listingo'),
                'desc' => esc_html__('Pleas add price for this package. for currency settings please go to Tools > Theme Settings > Payment Settings', 'listingo'),
            ),
            'featured_listing' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Featured listing included', 'listingo'),
                'desc' => esc_html__('If you enable this setting then users who buy this package, will be in featured listing for given below number of days.', 'listingo'),
            ),
            'featured_expiry' => array(
                'type' => 'text',
                'label' => esc_html__('Featured expiry', 'listingo'),
                'desc' => esc_html__('If you enable this setting then users who buy this package, will be in featured listing for given number of days.', 'listingo'),
            ),
            'appointments' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Appointments included', 'listingo'),
                'desc' => esc_html__('If you enable this setting then users who buy this package, will be able to see bookings module.', 'listingo'),
            ),
            'profile_banner' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Profile Banner Included', 'listingo'),
                'desc' => esc_html__('', 'listingo'),
            ),
            'insurance' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Insurance included', 'listingo'),
                'desc' => esc_html__('If you enable this setting then users who buy this package, will be able to add insurance.', 'listingo'),
            ),
            'favorite' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Favorite Listings included', 'listingo'),
                'desc' => esc_html__('If you enable this setting then users who buy this package, will be able to see favorite listings.', 'listingo'),
            ),
            'team' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Teams Management included', 'listingo'),
                'desc' => esc_html__('If you enable this setting then users who buy this package, will be able to add teams.', 'listingo'),
            ),
            'schedules' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Opening Hours/Schedules included', 'listingo'),
                'desc' => esc_html__('If you enable this setting then users who buy this package, will be able to add Opening Hours/Schedules.', 'listingo'),
            ),
        )
    ),
);
