<?php

if (!defined('FW')) {
    die('Forbidden');
}
global $post;
//Create Answers Link
$answer_link = esc_url( get_permalink( $post->post_parent ) );

$options = array(
    'answers_recommend' => array(
        'title' => esc_html__('Answers', 'listingo'),
        'type' => 'box',
        'context' => 'side',
        'priority' => 'high',
        'options' => array(
            'answer_button' => array(
                'type' => 'html',
                'label' => esc_html__('', 'listingo'),
                'desc' => esc_html__('Click above link to view all answers', 'listingo'),
                'html' => '<a href="'.esc_url($answer_link).'" target="_blank">'.esc_html__('View Answers', 'listingo').'</a>',
            )
        ),
    ),
);

