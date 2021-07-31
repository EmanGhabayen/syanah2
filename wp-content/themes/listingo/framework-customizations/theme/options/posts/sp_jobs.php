<?php

if (!defined('FW')) {
    die('Forbidden');
}

$career_level = apply_filters('listingo_get_career_levels', listingo_get_career_level());
$job_type = apply_filters('listingo_get_job_type', listingo_get_job_type());
$experiences = listingo_get_experience_list();

$options = array(
    'jobs_general_settings' => array(
        'title' => esc_html__('Job detail', 'listingo'),
        'type' => 'box',
        'options' => array(
            'category' => array(
                'label' => esc_html__('Category?', 'listingo'),
                'type' => 'multi-select',
                'population' => 'posts',
                'source' => 'sp_categories',
                'desc' => esc_html__('', 'listingo'),
                'limit' => 1
            ),
            'sub_category' => array(
                'label' => esc_html__('Sub category?', 'listingo'),
                'type' => 'multi-select',
                'population' => 'taxonomy',
                'source' => 'sub_category',
                'desc' => esc_html__('', 'listingo'),
                'limit' => 1
            ),
            'author' => array(
                'label' => esc_html__('Author?', 'listingo'),
                'type' => 'multi-select',
                'population' => 'users',
                'source' => array('business', 'professional', 'customer'),
                'desc' => esc_html__('', 'listingo'),
                'limit' => 1
            ),
            'expirydate' => array(
                'type' => 'date-picker',
                'label' => esc_html__('Expiry Date', 'listingo'),
                'desc' => esc_html__('Job expiry date', 'listingo'),
                'monday-first' => true,
                'min-date' => date('d-m-Y'),
                'max-date' => null,
            ),
            'career_level' => array(
                'type' => 'select',
                'label' => esc_html__('Career level', 'listingo'),
                'choices' => $career_level,
            ),
            'job_type' => array(
                'type' => 'select',
                'label' => esc_html__('Job type', 'listingo'),
                'choices' => $job_type,
            ),
            'experience' => array(
                'type' => 'select',
                'label' => esc_html__('Experience', 'listingo'),
                'choices' => $experiences,
            ),
            'salary' => array(
                'type' => 'text',
                'label' => esc_html__('Salary/Cost', 'listingo'),
                'desc' => esc_html__('Add job salary/cost', 'listingo'),
            ),
            'qualification' => array(
                'type' => 'text',
                'label' => esc_html__('Qualifications', 'listingo'),
                'desc' => esc_html__('Add job qualification', 'listingo'),
            ),
            'languages' => array(
                'label' => esc_html__('Languages?', 'listingo'),
                'type' => 'multi-select',
                'population' => 'taxonomy',
                'source' => 'languages',
                'desc' => esc_html__('Choose languages here.', 'listingo'),
            ),
            'requirements' => array(
                'type' => 'wp-editor',
                'attr' => array(),
                'label' => esc_html__('Job requirements', 'listingo'),
                'desc' => esc_html__('', 'listingo'),
            ),
            'benifits' => array(
                'type' => 'addable-option',
                'label' => esc_html__('Benefits', 'listingo'),
                'desc' => esc_html__('Add job benifits', 'listingo'),
                'option' => array('type' => 'text'),
                'add-button-text' => esc_html__('Add', 'listingo'),
                'sortable' => true,
            ),
        ),
    ),
    'jobs_location_settings' => array(
        'title' => esc_html__('Contact Information', 'listingo'),
        'type' => 'box',
        'context' => 'side',
        'priority' => 'high',
        'options' => array(
            'address' => array(
                'type' => 'text',
                'label' => esc_html__('Address', 'listingo'),
                'desc' => esc_html__('Add Location address.', 'listingo'),
            ),
            'address_latitude' => array(
                'type' => 'text',
                'label' => esc_html__('Latitude', 'listingo'),
                'desc' => esc_html__('Add address latitude.', 'listingo'),
            ),
            'address_longitude' => array(
                'type' => 'text',
                'label' => esc_html__('Longitude', 'listingo'),
                'desc' => esc_html__('Add address longitude.', 'listingo'),
            ),
            'phone' => array(
                'type' => 'text',
                'label' => esc_html__('Phone', 'listingo'),
                'desc' => esc_html__('Add phone number.', 'listingo'),
            ),
            'fax' => array(
                'type' => 'text',
                'label' => esc_html__('Fax', 'listingo'),
                'desc' => esc_html__('Add fax number.', 'listingo'),
            ),
            'email' => array(
                'type' => 'text',
                'label' => esc_html__('Email', 'listingo'),
                'desc' => esc_html__('Add email address.', 'listingo'),
            ),
            'url' => array(
                'type' => 'text',
                'label' => esc_html__('URL', 'listingo'),
                'desc' => esc_html__('Add website address.', 'listingo'),
            ),
        ),
    ),
);
