<?php

if (!defined('FW')) {
    die('Forbidden');
}

$current_date = current_time('mysql');

$time_dynamic_data = array();
$dynamic_rating_data = array();
if (!empty($_GET['post'])) {
    $review_id = intval($_GET['post']);
    $user_to = get_post_meta(intval($review_id), 'user_to', true);
    $category_type = get_user_meta($user_to, 'category', true);

    /* Get the total wait time. */
    $total_time = listingo_get_reviews_evaluation($category_type, 'total_wait_time');
    /* Get the rating headings */
    $rating_titles = listingo_get_reviews_evaluation($category_type, 'leave_rating');

    if (!empty($total_time)) {
        foreach ($total_time as $slug => $label) {
            $time_dynamic_data[$slug] = $label;
        }
    }

    if (!empty($rating_titles)) {
        foreach ($rating_titles as $slug => $label) {
            $dynamic_rating_data[$slug] = array(
                'type' => 'slider',
                'value' => $label,
                'properties' => array(
                    'min'  => intval(1),
                    'max'  => intval(5),
                    'step' => intval(1),
                ),
                'label' => $label,
            );
        }
    }
}

$options = array(
    'settings' => array(
        'title' => esc_html__('Review Detail', 'listingo'),
        'type' => 'box',
        'options' => array(
            'category_type' => array(
                'type' => 'hidden',
                'value' => '',
            ),
            'review_date' => array(
                'type' => 'hidden',
                'value' => $current_date,
            ),
            'review_wait_time' => array(
                'type' => 'select',
                'label' => esc_html__('Wait time', 'listingo'),
                'desc' => esc_html__('Review wait time.', 'listingo'),
                'choices' => $time_dynamic_data,
            ),
            'user_from' => array(
                'type' => 'multi-select',
                'label' => esc_html__('User From', 'listingo'),
                'desc' => esc_html__('Select user who rate.', 'listingo'),
                'population' => 'users',
                'source' => array('professional', 'business', 'customer', 'administrator'),
                'limit' => 1,
            ),
            'user_to' => array(
                'type' => 'multi-select',
                'label' => esc_html__('User To', 'listingo'),
                'desc' => esc_html__('Select user who is being rated.', 'listingo'),
                'population' => 'users',
                'source' => array('professional', 'business', 'customer', 'administrator'),
                'limit' => 1,
            ),
        )
    ),
    'reviews_ratings' => array(
        'title' => esc_html__('Individual Ratings', 'listingo'),
        'type' => 'box',
        'context' => 'side',
        'priority' => 'high',
        'options' => array(
            $dynamic_rating_data
        ),
    ),
    'reviews_recommend' => array(
        'title' => esc_html__('Recommendation', 'listingo'),
        'type' => 'box',
        'context' => 'side',
        'priority' => 'high',
        'options' => array(
            'recommended' => array(
                'type' => 'switch',
                'value' => 'yes',
                'label' => esc_html__('Recommended ?', 'listingo'),
                'desc' => esc_html__('Yes or No to recommend.', 'listingo'),
                'left-choice' => array(
                    'value' => 'yes',
                    'label' => esc_html__('Yes', 'listingo'),
                ),
                'right-choice' => array(
                    'value' => 'no',
                    'label' => esc_html__('No', 'listingo'),
                ),
            )
        ),
    ),
);

