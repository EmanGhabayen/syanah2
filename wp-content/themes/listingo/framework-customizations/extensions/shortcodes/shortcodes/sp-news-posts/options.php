<?php

if (!defined('FW'))
    die('Forbidden');



$options = array(
    'news_heading' => array(
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('Add news section heading. leave it empty to hide.', 'listingo'),
        'type' => 'text',
    ),
    'news_description' => array(
        'type' => 'wp-editor',
        'label' => esc_html__('Description', 'listingo'),
        'desc' => esc_html__('Add section description. leave it empty to hide.', 'listingo'),
        'tinymce' => true,
        'media_buttons' => false,
        'teeny' => false,
        'wpautop' => false,
        'editor_css' => '',
        'reinit' => true,
        'size' => 'small', // small | large
        'editor_type' => 'tinymce',
        'editor_height' => 200
    ),
    'blog_view' => array(
        'type' => 'select',
        'value' => 'list',
        'label' => esc_html__('Select View', 'listingo'),
        'choices' => array(
            'grid' => esc_html__('Grid', 'listingo'),
            'list' => esc_html__('List', 'listingo'),
        ),
    ),
    'get_mehtod' => array(
        'type' => 'multi-picker',
        'label' => false,
        'desc' => false,
        'value' => array('gadget' => 'normal'),
        'picker' => array(
            'gadget' => array(
                'type' => 'select',
                'value' => 'by_cats',
                'desc' => esc_html__('Select news by category or item', 'listingo'),
                'label' => esc_html__('News By', 'listingo'),
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
                    'label' => esc_html__('Select Categories', 'listingo'),
                    'population' => 'taxonomy',
                    'source' => 'category',
                    'prepopulate' => 500,
                    'desc' => esc_html__('Show posts by category selection.', 'listingo'),
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
                        'comment_count' => esc_html__('Order by number of comments', 'listingo'),
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
                    'label' => esc_html__('Show No of Posts', 'listingo'),
                ),
            ),
            'by_posts' => array(
                'posts' => array(
                    'type' => 'multi-select',
                    'label' => esc_html__('Select Posts', 'listingo'),
                    'population' => 'posts',
                    'source' => 'post',
                    'prepopulate' => 500,
                    'desc' => esc_html__('Show posts by post selection.', 'listingo'),
                ),
                'show_posts' => array(
                    'type' => 'slider',
                    'value' => 9,
                    'properties' => array(
                        'min' => 1,
                        'max' => 100,
                        'sep' => 1,
                    ),
                    'label' => esc_html__('Show No of Posts', 'listingo'),
                ),
            )
        ),
        'show_borders' => true,
    ),
    'excerpt' => array(
        'value' => '',
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
);
