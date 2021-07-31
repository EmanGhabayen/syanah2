<?php

if (!defined('FW'))
    die('Forbidden');



$options = array(    
    'category_heading' => array(
        'label' => esc_html__('Heading', 'listingo'),
        'desc' => esc_html__('Add heading. leave it empty to hide.', 'listingo'),
        'type' => 'text',
    ),
    'category_description' => array(
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
    'posts' => array(
        'type' => 'multi-select',
        'label' => esc_html__('Select Posts', 'listingo'),
        'population' => 'posts',
        'source' => 'sp_categories',
        'prepopulate' => 500,
        'desc' => esc_html__('Show posts by post selection.', 'listingo'),
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
        'label' => esc_html__('Show No of Posts', 'listingo'),
    ),
    'cat_view' => array(
        'type'  => 'multi-picker',
        'label' => false,
        'desc'  => false,
        'value'=> array(       
            'gadget' => 'view1',
        ),
        'picker' => array(
            'gadget' => array(
                'label'   => __('Select style', 'listingo'),
                'type'    => 'select', 
                'choices' => array(
                    'view1'  => __('View 1', 'listingo'),
                    'view2' => __('View 2', 'listingo'),
                    'view3' => __('View 3', 'listingo')
                ),              
            ),
        ),
        'choices' => array(
            'view1' => array(
                'show_buttons' => array(
                    'type' => 'addable-box',
                    'label' => esc_html__('Add Button', 'listingo'),
                    'desc' => esc_html__('', 'listingo'),
                    'box-options' => array(
                        'button_text' => array('type' => 'text'),
                        'button_link' => array('type' => 'text'),
                    ),
                    'template' => '{{- button_text }}', // box title
                    'box-controls' => array(// buttons next to (x) remove box button
                        'control-id' => '<small class = "dashicons dashicons-smiley"></small>',
                    ),
                    'limit' => 1, // limit the number of boxes that can be added
                    'add-button-text' => esc_html__('Add', 'listingo'),
                    'sortable' => true,
                ),
            ), 
            'view3' => array(
                'show_buttons' => array(
                    'type' => 'addable-box',
                    'label' => esc_html__('Add Button', 'listingo'),
                    'desc' => esc_html__('', 'listingo'),
                    'box-options' => array(
                        'button_text' => array('type' => 'text'),
                        'button_link' => array('type' => 'text'),
                    ),
                    'template' => '{{- button_text }}', // box title
                    'box-controls' => array(// buttons next to (x) remove box button
                        'control-id' => '<small class = "dashicons dashicons-smiley"></small>',
                    ),
                    'limit' => 1, // limit the number of boxes that can be added
                    'add-button-text' => esc_html__('Add', 'listingo'),
                    'sortable' => true,
                ),
            ), 
        ),
    ),

);
