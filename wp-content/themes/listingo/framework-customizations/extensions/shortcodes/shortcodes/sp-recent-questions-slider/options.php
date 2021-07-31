<?php

if (!defined('FW'))
    die('Forbidden');



$options = array(
    'get_mehtod' => array(
        'type' => 'multi-picker',
        'label' => false,
        'desc' => false,
        'value' => array('gadget' => 'normal'),
        'picker' => array(
            'gadget' => array(
                'type' => 'select',
                'value' => 'by_cats',
                'desc' => esc_html__('Select question by category or item', 'listingo'),
                'label' => esc_html__('Questions By', 'listingo'),
                'choices' => array(
                    'by_cats' => esc_html__('By Categories', 'listingo'),
                    'by_posts' => esc_html__('By item', 'listingo'),
                ),
            )
        ),
        'choices' => array(
            'by_cats' => array(
                'categories' => array(
                    'type' => 'multi-select',
                    'label' => esc_html__('Select category', 'listingo'),
                    'population' => 'posts',
                    'source' => 'sp_categories',
                    'prepopulate' => 500,
                    'desc' => esc_html__('Show question by category selection. Leave it empty to get from all categories.', 'listingo'),
                ),
                'order' => array(
                    'type' => 'select',
                    'value' => 'DESC',
                    'desc' => esc_html__('Post Order', 'listingo'),
                    'label' => esc_html__('Posts By', 'listingo'),
                    'choices' => array(
                        'ASC' => esc_html__('ASC', 'listingo'),
                        'DESC' => esc_html__('DESC', 'listingo'),
                    ),
                ),
                'orderby' => array(
                    'type' => 'select',
                    'value' => 'ID',
                    'desc' => esc_html__('Post Order', 'listingo'),
                    'label' => esc_html__('Posts By', 'listingo'),
                    'choices' => array(
                        'ID' => esc_html__('Order by post id', 'listingo'),
                        'author' => esc_html__('Order by author', 'listingo'),
                        'title' => esc_html__('Order by title', 'listingo'),
                        'name' => esc_html__('Order by post name', 'listingo'),
                        'date' => esc_html__('Order by date', 'listingo'),
                        'rand' => esc_html__('Random order', 'listingo'),
                    ),
                ),
                'show_posts' => array(
                    'type' => 'slider',
                    'value' => 9,
                    'properties' => array(
                        'min' => 1,
                        'max' => 100,
                        'sep' => 1,
                    ),
                    'label' => esc_html__('Show no of posts', 'listingo'),
                ),
            ),
            'by_posts' => array(
                'posts' => array(
                    'type' => 'multi-select',
                    'label' => esc_html__('Select questions', 'listingo'),
                    'population' => 'posts',
                    'source' => 'sp_questions',
                    'prepopulate' => 500,
                    'desc' => esc_html__('Show questions item selection.', 'listingo'),
                ),
                'show_posts' => array(
                    'type' => 'slider',
                    'value' => 9,
                    'properties' => array(
                        'min' => 1,
                        'max' => 100,
                        'sep' => 1,
                    ),
                    'label' => esc_html__('Show no of posts', 'listingo'),
                ),
            )
        ),
        'show_borders' => true,
    ),
    'excerpt' => array(
        'value' => '65',
        'label' => esc_html__('Excerpt Length', 'listingo'),
        'desc' => esc_html__('Enter excerpt length. leave it empty to hide.', 'listingo'),
        'type' => 'text',
    ),
    'show_pagination' => array(
        'type' => 'select',
        'value' => 'no',
        'label' => esc_html__('Show Pagination', 'listingo'),
        'desc' => esc_html__('', 'listingo'),
        'choices' => array(
            'yes' => esc_html__('Yes', 'listingo'),
            'no' => esc_html__('No', 'listingo'),
        ),
        'no-validate' => false,
    ),
    'autoplay' => array(
        'type' => 'switch',
        'value' => 'true',
        'label' => esc_html__('Autoplay?', 'listingo'),
        'desc' => esc_html__('Set it true for auto-rotating slides', 'listingo'),
        'left-choice' => array(
            'value' => 'false',
            'label' => esc_html__('False', 'listingo'),
        ),
        'right-choice' => array(
            'value' => 'true',
            'label' => esc_html__('True', 'listingo'),
        ),
    ),
    'loop' => array(
        'type' => 'switch',
        'value' => 'true',
        'label' => esc_html__('Loop?', 'listingo'),
        'desc' => esc_html__('Set it true for looping slides', 'listingo'),
        'left-choice' => array(
            'value' => 'false',
            'label' => esc_html__('False', 'listingo'),
        ),
        'right-choice' => array(
            'value' => 'true',
            'label' => esc_html__('True', 'listingo'),
        ),
    ),
    'nav' => array(
        'type' => 'switch',
        'value' => 'true',
        'label' => esc_html__('Navigation?', 'listingo'),
        'desc' => esc_html__('Set it true to enable navigation', 'listingo'),
        'left-choice' => array(
            'value' => 'false',
            'label' => esc_html__('False', 'listingo'),
        ),
        'right-choice' => array(
            'value' => 'true',
            'label' => esc_html__('True', 'listingo'),
        ),
    ),
);
