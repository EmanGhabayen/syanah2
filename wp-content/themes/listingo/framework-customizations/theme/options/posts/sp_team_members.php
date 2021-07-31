<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'team_settings' => array(
        'title' => esc_html__('Member detail', 'listingo'),
        'type' => 'box',
        'options' => array(
            'author' => array(
                'label' => esc_html__('Created By?', 'listingo'),
                'type' => 'multi-select',
                'population' => 'users',
                'source' => array('business', 'professional'),
                'limit' => 1
            ),
            't_member_designation' => array(
                'type' => 'text',
                'label' => esc_html__('Designation', 'listingo'),
                'desc' => esc_html__('Add member designation', 'listingo'),
            ),
            't_member_email' => array(
                'type' => 'text',
                'label' => esc_html__('Email?', 'listingo'),
                'desc' => esc_html__('Add member email ID', 'listingo'),
            ),
            't_member_phone' => array(
                'type' => 'text',
                'label' => esc_html__('Phone?', 'listingo'),
                'desc' => esc_html__('Add member contact number', 'listingo'),
            ),
        ),
    ),
);
