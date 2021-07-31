<?php

if (!defined('FW'))
    die('Forbidden');

$options = array(   
     'slider_view' => array(
        'type'  => 'multi-picker',
        'label' => false,
        'desc'  => false,
        'value'=> array(       
            'gadget' => 'view1',
        ),
        'picker' => array(
            'gadget' => array(
                'label'   => esc_html__('Select style', 'listingo'),
                'type'    => 'select', 
                'choices' => array(
                    'view1'  => esc_html__('View 1', 'listingo'),
                    'view2' => esc_html__('View 2', 'listingo'),
                    'view3' => esc_html__('View 3', 'listingo')
                ),              
            ),
        ),  
        'choices' => array(
            'view1' => array(
                  'slides' => array(
                        'label' => esc_html__('Slider', 'listingo'),
                        'type' => 'addable-popup',
                        'value' => array(),
                        'desc' => esc_html__('Add slide.', 'listingo'),
                        'popup-options' => array(
                            'title' => array(
                                'label' => esc_html__('Title', 'listingo'),
                                'desc' => esc_html__('Enter title.', 'listingo'),
                                'type' => 'text',
                            ), 
                            'sub_title' => array(
                                'label' => esc_html__('Sub title', 'listingo'),
                                'desc' => esc_html__('Enter sub title.', 'listingo'),
                                'type' => 'text',
                            ), 
                            'slide_description' => array(
                                'type' => 'wp-editor',
                                'value' => '',
                                'attr' => array('class' => 'custom-class', 'data-foo' => 'bar'),
                                'label' => esc_html__('Description', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'size' => 'small', // small, large
                                'editor_height' => 400,
                                'wpautop' => true,
                                'editor_type' => false, // tinymce, html
                            ),  
                            'slide_image' => array(
                                'type' => 'upload',
                                'label' => esc_html__('Image', 'listingo'),
                                'desc' => esc_html__('Upload your slide image here.', 'listingo'),
                                'images_only' => true,
                                'files_ext' => array('jpg', 'jpeg', 'png'),
                                'extra_mime_types' => array('audio/x-aiff, aif aiff')
                            ), 
                            'slide_buttons' => array(
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
                                'limit' => 2, // limit the number of boxes that can be added
                                'add-button-text' => esc_html__('Add', 'listingo'),
                                'sortable' => true,
                            ),
                        ),
                    'template' => '{{- title }}',
                ), 
                'show_pagination' => array(
                    'type'  => 'switch',
                    'value' => 'disable',
                    'label' => esc_html__('Show Pagination?', 'listingo'),
                    'desc'  => esc_html__('Show/Hide slider Pagination', 'listingo'),
                    'left-choice' => array(
                        'value' => 'disable',
                        'label' => esc_html__('Disable', 'listingo'),
                    ),
                    'right-choice' => array(
                        'value' => 'enable',
                        'label' => esc_html__('Enable', 'listingo'),
                    ),
                ),
                'show_navigation' => array(
                    'type'  => 'switch',
                    'value' => 'disable',
                    'label' => esc_html__('Show Navigation?', 'listingo'),
                    'desc'  => esc_html__('Show/Hide slider navigation button', 'listingo'),
                    'left-choice' => array(
                        'value' => 'disable',
                        'label' => esc_html__('Disable', 'listingo'),
                    ),
                    'right-choice' => array(
                        'value' => 'enable',
                        'label' => esc_html__('Enable', 'listingo'),
                    ),
                ),
            ), 
            'view2' => array(
                'images' =>array(
                    'type'  => 'multi-upload',    
                    'label' => esc_html__('Select images', 'listingo'),
                    'desc'  => esc_html__('Select multiple images', 'listingo'),
                    'images_only' => true,    
                ),
                'title' => array(
                    'label' => esc_html__('Title', 'listingo'),
                    'desc' => esc_html__('Enter title.', 'listingo'),
                    'type' => 'text',
                ), 
                'sub_title' => array(
                    'label' => esc_html__('Sub title', 'listingo'),
                    'desc' => esc_html__('Enter sub title.', 'listingo'),
                    'type' => 'text',
                ), 
                'slide_description' => array(
                    'type' => 'wp-editor',
                    'value' => '',
                    'label' => esc_html__('Description', 'listingo'),
                    'desc' => esc_html__('', 'listingo'),
                    'size' => 'small', // small, large
                    'editor_height' => 400,
                    'wpautop' => true,
                    'editor_type' => false, // tinymce, html
                ),  
                'slide_buttons' => array(
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
                    'limit' => 2, // limit the number of boxes that can be added
                    'add-button-text' => esc_html__('Add', 'listingo'),
                    'sortable' => true,
                ),
                'show_pagination' => array(
                    'type'  => 'switch',
                    'value' => 'disable',
                    'label' => esc_html__('Show Pagination?', 'listingo'),
                    'desc'  => esc_html__('Show/Hide slider Pagination', 'listingo'),
                    'left-choice' => array(
                        'value' => 'disable',
                        'label' => esc_html__('Disable', 'listingo'),
                    ),
                    'right-choice' => array(
                        'value' => 'enable',
                        'label' => esc_html__('Enable', 'listingo'),
                    ),
                ),         
                'show_form' => array(
                    'type' => 'multi-picker',
                    'label' => false,
                    'desc' => false,
                    'picker' => array(
                        'gadget' => array(
                            'type' => 'switch',
                            'value' => 'no',
                            'label' => esc_html__('Show Form ?', 'listingo'),
                            'desc' => esc_html__('Enable or Disable search form.', 'listingo'),
                            'left-choice' => array(
                                'value' => 'no',
                                'label' => esc_html__('No', 'listingo'),
                            ),
                            'right-choice' => array(
                                'value' => 'yes',
                                'label' => esc_html__('Yes', 'listingo'),
                            ),
                        )
                    ),
                    'choices' => array(
                        'yes' => array(
                            'form_title' => array(    
                                'value' => '',
                                'label' => esc_html__('Form Title', 'listingo'),
                                'desc' => esc_html__('Enter title.', 'listingo'),
                                'type' => 'text',
                            ),
                            'btn_link' => array(    
                                'value' => '',
                                'label' => esc_html__('Button text', 'listingo'),
                                'desc' => esc_html__('Ente button text.', 'listingo'),
                                'type' => 'text',
                            ),
                        ),
                    )
                ),        
            ), 
            'view3' => array(
                'image' =>array(
                    'type'  => 'upload',    
                    'label' => esc_html__('Top image', 'listingo'),
                    'desc'  => esc_html__('Leave it empty to hide.', 'listingo'),
                    'images_only' => true,    
                ),
                'images' =>array(
                    'type'  => 'multi-upload',    
                    'label' => esc_html__('Backgroun images?', 'listingo'),
                    'desc'  => esc_html__('Upload slider background images.', 'listingo'),
                    'images_only' => true,    
                ),
                'title' => array(
                    'label' => esc_html__('Title?', 'listingo'),
                    'desc' => esc_html__('Add title.', 'listingo'),
                    'type' => 'text',
                ), 
                'sub_title' => array(
                    'label' => esc_html__('Sub title?', 'listingo'),
                    'desc'  => esc_html__('Enter sub title here.', 'listingo'),
                    'type'  => 'text',
                ),  
                'show_pagination' => array(
                    'type'  => 'switch',
                    'value' => 'disable',
                    'label' => esc_html__('Show Pagination?', 'listingo'),
                    'desc'  => esc_html__('Show/Hide slider pagination', 'listingo'),
                    'left-choice' => array(
                        'value' => 'disable',
                        'label' => esc_html__('Disable', 'listingo'),
                    ),
                    'right-choice' => array(
                        'value' => 'enable',
                        'label' => esc_html__('Enable', 'listingo'),
                    ),
                ),   
                'overlay_color' => array(
                    'label' => esc_html__('Background overlay Color', 'listingo'),
                    'desc' => esc_html__('Please select the background overlay color', 'listingo'),
                    'type' => 'rgba-color-picker',
                    'value' => 'rgba(0, 0, 0, 0.50)',
                ),  
                'show_form' => array(
                    'type' => 'multi-picker',
                    'label' => false,
                    'desc' => false,
                    'picker' => array(
                        'gadget' => array(
                            'type'  => 'switch',
                            'value' => 'no',
                            'label' => esc_html__('Show Form?', 'listingo'),
                            'desc'  => esc_html__('Enable or disable search form.', 'listingo'),
                            'left-choice' => array(
                                'value' => 'no',
                                'label' => esc_html__('No', 'listingo'),
                            ),
                            'right-choice' => array(
                                'value' => 'yes',
                                'label' => esc_html__('Yes', 'listingo'),
                            ),
                        )
                    ),
                    'choices' => array(
                        'yes' => array(           
                            'btn_link' => array(    
                                'value' => '',
                                'label' => esc_html__('Button text', 'listingo'),
                                'desc' => esc_html__('Add button text.', 'listingo'),
                                'type' => 'text',
                            ),
                        ),
                    )
                ),        
            ), 
        ),
    ),   
);
