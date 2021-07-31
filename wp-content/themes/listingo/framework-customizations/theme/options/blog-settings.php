<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array(
    'blogs' => array(
        'title' => esc_html__('Blog Settings', 'listingo'),
        'type' => 'tab',
        'options' => array(
            'general-box' => array(
                'title' => esc_html__('General Settings', 'listingo'),
                'type' => 'tab',
                'options' => array(
                    'enable_author' => array(
                        'type' => 'switch',
                        'value' => 'enable',
                        'label' => esc_html__('Author information', 'listingo'),
                        'desc' => esc_html__('Enable or Disable author information at listing & detail page.', 'listingo'),
                        'left-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'listingo'),
                        ),
                        'right-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disable', 'listingo'),
                        ),
                    ),
                    'enable_comments' => array(
                        'type' => 'switch',
                        'value' => 'enable',
                        'label' => esc_html__('Enable Comments', 'listingo'),
                        'desc' => esc_html__('Enable or Disable comments. It will be effect all over the site in blog detail/listings.', 'listingo'),
                        'left-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'listingo'),
                        ),
                        'right-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disable', 'listingo'),
                        ),
                    ),
                    'enable_categories' => array(
                        'type' => 'switch',
                        'value' => 'enable',
                        'label' => esc_html__('Enable Categories/Tags', 'listingo'),
                        'desc' => esc_html__('Enable or Disable Categories/Tags. It will be effect all over the site in blog detail/listings.', 'listingo'),
                        'left-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'listingo'),
                        ),
                        'right-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disable', 'listingo'),
                        ),
                    ),
                    'enable_sharing' => array(
                        'type' => 'switch',
                        'value' => 'disable',
                        'label' => esc_html__('Enable Sharing', 'listingo'),
                        'desc' => esc_html__('Enable or Disable social sharing at detail page.', 'listingo'),
                        'left-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'listingo'),
                        ),
                        'right-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disable', 'listingo'),
                        ),
                    )
                )
            ),
            'archive-box' => array(
                'title' => esc_html__('Archive Pages Settings', 'listingo'),
                'type' => 'tab',
                'options' => array(
                    'archive_show_posts' => array(
                        'type' => 'slider',
                        'value' => 10,
                        'properties' => array(
                            'min' => 1,
                            'max' => 100,
                            'step' => 1, // Set slider step. Always > 0. Could be fractional.
                        ),
                        'attr' => array(),
                        'label' => esc_html__('Show posts', 'listingo'),
                        'desc' => esc_html__('Show number of posts per page. It will be used for archive pages.', 'listingo'),
                        'help' => esc_html__('', 'listingo'),
                    ),
                    'archive_order' => array(
                        'label' => esc_html__('Post Order', 'listingo'),
                        'desc' => esc_html__('It will be used for archive pages.', 'listingo'),
                        'type' => 'select',
                        'value' => 'DESC',
                        'choices' => array(
                            'DESC' => 'DESC',
                            'ASC' => 'ASC',
                        )
                    ),
                    'archive_orderby' => array(
                        'label' => esc_html__('Order by', 'listingo'),
                        'desc' => esc_html__('It will be used for archive pages.', 'listingo'),
                        'type' => 'select',
                        'value' => 'ID',
                        'choices' => array(
                            'ID' => esc_html__('Order by post id', 'listingo'),
                            'author' => esc_html__('Order by author', 'listingo'),
                            'title' => esc_html__('Order by title', 'listingo'),
                            'name' => esc_html__('Order by post name', 'listingo'),
                            'date' => esc_html__('Order by date', 'listingo'),
                            'modified' => esc_html__('Order by last modified date', 'listingo'),
                            'rand' => esc_html__('Random order', 'listingo'),
                        )
                    ),
                    'archive_meta_information' => array(
                        'type' => 'switch',
                        'value' => 'enable',
                        'label' => esc_html__('Post Meta Information', 'listingo'),
                        'desc' => esc_html__('Enable or disable post meta information. It will be used for archive pages.', 'listingo'),
                        'left-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'listingo'),
                        ),
                        'right-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disable', 'listingo'),
                        ),
                    ),
                    'archive_pages_sidebar' => array(
                        'type' => 'switch',
                        'value' => 'enable',
                        'attr' => array(),
                        'label' => esc_html__('Sidebar ON/OFF', 'listingo'),
                        'desc' => esc_html__('', 'listingo'),
                        'left-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'listingo'),
                        ),
                        'right-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disable', 'listingo'),
                        ),
                    ),
                    'archive_pages_position' => array(
                        'type' => 'select',
                        'value' => 'right',
                        'attr' => array(),
                        'label' => esc_html__('Sidebar Position', 'listingo'),
                        'desc' => esc_html__('', 'listingo'),
                        'help' => esc_html__('', 'listingo'),
                        'choices' => array(
                            'left' => esc_html__('Left', 'listingo'),
                            'right' => esc_html__('Right', 'listingo'),
                        ),
                    ),
                )
            ),
            'search-box' => array(
                'title' => esc_html__('Search Pages Settings', 'listingo'),
                'type' => 'tab',
                'options' => array(
                    'search_show_posts' => array(
                        'type' => 'slider',
                        'value' => 10,
                        'properties' => array(
                            'min' => 1,
                            'max' => 100,
                            'step' => 1, // Set slider step. Always > 0. Could be fractional.
                        ),
                        'attr' => array(),
                        'label' => esc_html__('Show posts', 'listingo'),
                        'desc' => esc_html__('Show number of posts per page. It will be used for search pages.', 'listingo'),
                        'help' => esc_html__('', 'listingo'),
                    ),
                    'search_order' => array(
                        'label' => esc_html__('Post Order', 'listingo'),
                        'desc' => esc_html__('It will be used for search pages.', 'listingo'),
                        'type' => 'select',
                        'value' => 'DESC',
                        'choices' => array(
                            'DESC' => 'DESC',
                            'ASC' => 'ASC',
                        )
                    ),
                    'search_orderby' => array(
                        'label' => esc_html__('Order by', 'listingo'),
                        'desc' => esc_html__('It will be used for search pages.', 'listingo'),
                        'type' => 'select',
                        'value' => 'ID',
                        'choices' => array(
                            'ID' => esc_html__('Order by post id', 'listingo'),
                            'author' => esc_html__('Order by author', 'listingo'),
                            'title' => esc_html__('Order by title', 'listingo'),
                            'name' => esc_html__('Order by post name', 'listingo'),
                            'date' => esc_html__('Order by date', 'listingo'),
                            'modified' => esc_html__('Order by last modified date', 'listingo'),
                            'rand' => esc_html__('Random order', 'listingo'),
                        )
                    ),
                    'search_meta_information' => array(
                        'type' => 'switch',
                        'value' => 'enable',
                        'label' => esc_html__('Post Meta Information', 'listingo'),
                        'desc' => esc_html__('Enable or disable post meta information. It will be used for search pages.', 'listingo'),
                        'left-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'listingo'),
                        ),
                        'right-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disable', 'listingo'),
                        ),
                    ),
                    'search_enable_sidebar' => array(
                        'type' => 'switch',
                        'value' => 'enable',
                        'attr' => array(),
                        'label' => esc_html__('Page Sidebar ON/OFF', 'listingo'),
                        'desc' => esc_html__('', 'listingo'),
                        'left-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disable', 'listingo'),
                        ),
                        'right-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'listingo'),
                        ),
                    ),
                    'search_sidebar_position' => array(
                        'type' => 'select',
                        'value' => 'right',
                        'attr' => array(),
                        'label' => esc_html__('Sidebar Position', 'listingo'),
                        'desc' => esc_html__('', 'listingo'),
                        'help' => esc_html__('', 'listingo'),
                        'choices' => array(
                            'left' => esc_html__('Left', 'listingo'),
                            'right' => esc_html__('Right', 'listingo'),
                        ),
                    ),
                )
            )
        )
    )
);
