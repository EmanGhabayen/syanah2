<?php

if (!defined('FW')) {
    die('Forbidden');
}

$social_links   = apply_filters('listingo_get_social_media_icons_list',array());
$timezone       = apply_filters('listingo_time_zones', array());
$socials	= array();
if( !empty( $social_links ) ){
	foreach($social_links as $key=>$link){
		$placeholder		= !empty( $link['placeholder'] ) ? $link['placeholder'] : '';
		$socials[$key] = array(
			'label' => $placeholder,
			'type' => 'text',
			'desc' => esc_html__('', 'listingo'),
		);
	}
}
if( function_exists('listingo_ad_price_type') ){
	$list	= listingo_ad_price_type();
	$flist  = array();
	foreach( $list as $key => $val ){
		$flist[$key]	= $val['desc'];
	}
} else{
	$list	= array();
}

$price_types	= apply_filters('listingo_get_price_type_list',$flist);

$options = array(
	'media_settings' => array(
        'title' => esc_html__('Media Settings', 'listingo'),
        'type' => 'box',
        'context' => 'side',
        'priority' => 'high',
        'options' => array(
			'gallery' => array(
				'type' => 'multi-upload',
				'label' => esc_html__('Add gallery', 'listingo'),
				'desc' => esc_html__('Add ad gallery images. Please donot upload featured image, first image will becomes ad featured image.', 'listingo'),
				'help' => esc_html__('', 'listingo'),
				'images_only' => true,
			),
		)
	),
    'ad_settings' => array(
        'title' => esc_html__('Ad detail', 'listingo'),
        'type' => 'box',
        'options' => array(
			'tagline' => array(
                'type' => 'text',
                'label' => esc_html__('Tagline', 'listingo'),
                'desc' => esc_html__('Ad tagline goes here.', 'listingo'),
            ),    
            'featured' => array(
                'type' => 'select',
                'label' => esc_html__('Ad type?', 'listingo'),
                'choices' => array(
                    'standard' => esc_html__('Standard', 'listingo'),
                    'featured' => esc_html__('Featured', 'listingo'),
                ),
                'desc' => esc_html__('Featured tag will work only if ad author has a package set which allows featured ad', 'listingo'),
            ),      
            'time_details' => array(
                'label' => esc_html__('Time Details', 'listingo'),
                'type' => 'addable-popup',
                'value' => array(),
                'desc' => esc_html__('Add time zone and time details', 'listingo'),
                'popup-options' => array(
                    'timezone' => array(
                        'type' => 'select',
                        'label' => esc_html__('Select time zone', 'listingo'),
                        'choices' => $timezone,
                    ),
                    'monday' => array(
                        'label' => esc_html__('Monday', 'listingo'),
                        'type' => 'addable-popup',
                        'value' => array(),
                        'desc' => esc_html__('Add time zone and time details', 'listingo'),
                        'popup-options' => array( 
							'off_day' => array(
								'type' => 'checkbox',
								'label' => esc_html__('Day off?', 'listingo'),
								'desc' => esc_html__('You can make it day off. If you are not workin on this day.', 'listingo'),
							),
                            'starttime' => array(
                                'type' => 'datetime-picker',
                                'datetime-picker' => array(
                                    'datepicker' => false,
                                    'format' => 'H:i'
                                ),
                                'desc' => esc_html__('Monday opening time.', 'listingo'),
                            ),
                            'endtime' => array(
                                'type' => 'datetime-picker',
                                'datetime-picker' => array(
                                    'datepicker' => false,
                                    'format' => 'H:i'
                                ),
                                'desc' => esc_html__('Monday closing time.', 'listingo'),
                            ),                     
                        ),
                        'template' => '{{- starttime}}',
                        'limit' => 1,
                    ), 
                    'tuesday' => array(
                        'label' => esc_html__('Tuesday', 'listingo'),
                        'type' => 'addable-popup',
                        'value' => array(),
                        'desc' => esc_html__('Add time zone and time details', 'listingo'),
                        'popup-options' => array(
							'off_day' => array(
								'type' => 'checkbox',
								'label' => esc_html__('Day off?', 'listingo'),
								'desc' => esc_html__('You can make it day off. If you are not workin on this day.', 'listingo'),
							),
                            'starttime' => array(
                                'type' => 'datetime-picker',
                                'datetime-picker' => array(
                                    'datepicker' => false,
                                    'format' => 'H:i'
                                ),
                                'desc' => esc_html__('Tuesday opening time.', 'listingo'),
                            ),
                            'endtime' => array(
                                'type' => 'datetime-picker',
                                'datetime-picker' => array(
                                    'datepicker' => false,
                                    'format' => 'H:i'
                                ),
                                'desc' => esc_html__('Tuesday ending time.', 'listingo'),
                            ),                  
                        ),
                        'template' => '{{- starttime}}',
                        'limit' => 1,
                    ), 
                    'wednesday' => array(
                        'label' => esc_html__('Wednesday', 'listingo'),
                        'type' => 'addable-popup',
                        'value' => array(),
                        'desc' => esc_html__('Add time zone and time details', 'listingo'),
                        'popup-options' => array(
							'off_day' => array(
								'type' => 'checkbox',
								'label' => esc_html__('Day off?', 'listingo'),
								'desc' => esc_html__('You can make it day off. If you are not workin on this day.', 'listingo'),
							),
                            'starttime' => array(
                                'type' => 'datetime-picker',
                                'datetime-picker' => array(
                                    'datepicker' => false,
                                    'format' => 'H:i'
                                ),
                                'desc' => esc_html__('Wednesday opening time.', 'listingo'),
                            ),
                            'endtime' => array(
                                'type' => 'datetime-picker',
                                'datetime-picker' => array(
                                    'datepicker' => false,
                                    'format' => 'H:i'
                                ),
                                'desc' => esc_html__('Wednesday clsoing time.', 'listingo'),
                            ),                  
                        ),
                        'template' => '{{- starttime}}',
                        'limit' => 1,
                    ),
                    'thursday' => array(
                        'label' => esc_html__('Thursday', 'listingo'),
                        'type' => 'addable-popup',
                        'value' => array(),
                        'desc' => esc_html__('Add time zone and time details', 'listingo'),
                        'popup-options' => array(
							'off_day' => array(
								'type' => 'checkbox',
								'label' => esc_html__('Day off?', 'listingo'),
								'desc' => esc_html__('You can make it day off. If you are not workin on this day.', 'listingo'),
							),
                            'starttime' => array(
                                'type' => 'datetime-picker',
                                'datetime-picker' => array(
                                    'datepicker' => false,
                                    'format' => 'H:i'
                                ),
                                'desc' => esc_html__('Thursday opening time.', 'listingo'),
                            ),
                            'endtime' => array(
                                'type' => 'datetime-picker',
                                'datetime-picker' => array(
                                    'datepicker' => false,
                                    'format' => 'H:i'
                                ),
                                'desc' => esc_html__('Thursday clsoing time.', 'listingo'),
                            ),                  
                        ),
                        'template' => '{{- starttime}}',
                        'limit' => 1,
                    ),
                    'friday' => array(
                        'label' => esc_html__('Friday', 'listingo'),
                        'type' => 'addable-popup',
                        'value' => array(),
                        'desc' => esc_html__('Add time zone and time details', 'listingo'),
                        'popup-options' => array(
							'off_day' => array(
								'type' => 'checkbox',
								'label' => esc_html__('Day off?', 'listingo'),
								'desc' => esc_html__('You can make it day off. If you are not workin on this day.', 'listingo'),
							),
                            'starttime' => array(
                                'type' => 'datetime-picker',
                                'datetime-picker' => array(
                                    'datepicker' => false,
                                    'format' => 'H:i'
                                ),
                                'desc' => esc_html__('Friday opening time.', 'listingo'),
                            ),
                            'endtime' => array(
                                'type' => 'datetime-picker',
                                'datetime-picker' => array(
                                    'datepicker' => false,
                                    'format' => 'H:i'
                                ),
                                'desc' => esc_html__('Friday clsoing time.', 'listingo'),
                            ),                  
                        ),
                        'template' => '{{- starttime}}',
                        'limit' => 1,
                    ),
                    'saturday' => array(
                        'label' => esc_html__('Saturday', 'listingo'),
                        'type' => 'addable-popup',
                        'value' => array(),
                        'desc' => esc_html__('Add time zone and time details', 'listingo'),
                        'popup-options' => array(
							'off_day' => array(
								'type' => 'checkbox',
								'label' => esc_html__('Day off?', 'listingo'),
								'desc' => esc_html__('You can make it day off. If you are not workin on this day.', 'listingo'),
							),
                            'starttime' => array(
                                'type' => 'datetime-picker',
                                'datetime-picker' => array(
                                    'datepicker' => false,
                                    'format' => 'H:i'
                                ),
                                'desc' => esc_html__('Saturday opening time.', 'listingo'),
                            ),
                            'endtime' => array(
                                'type' => 'datetime-picker',
                                'datetime-picker' => array(
                                    'datepicker' => false,
                                    'format' => 'H:i'
                                ),
                                'desc' => esc_html__('Saturday clsoing time.', 'listingo'),
                            ),                  
                        ),
                        'template' => '{{- starttime}}',
                        'limit' => 1,
                    ),
                    'sunday' => array(
                        'label' => esc_html__('Sunday', 'listingo'),
                        'type' => 'addable-popup',
                        'value' => array(),
                        'desc' => esc_html__('Add time zone and time details', 'listingo'),
                        'popup-options' => array( 
							'off_day' => array(
								'type' => 'checkbox',
								'label' => esc_html__('Day off?', 'listingo'),
								'desc' => esc_html__('You can make it day off. If you are not workin on this day.', 'listingo'),
							),
                            'starttime' => array(
                                'type' => 'datetime-picker',
                                'datetime-picker' => array(
                                    'datepicker' => false,
                                    'format' => 'H:i'
                                ),
                                'desc' => esc_html__('Sunday opening time.', 'listingo'),
                            ),
                            'endtime' => array(
                                'type' => 'datetime-picker',
                                'datetime-picker' => array(
                                    'datepicker' => false,
                                    'format' => 'H:i'
                                ),
                                'desc' => esc_html__('Sunday clsoing time.', 'listingo'),
                            ),                  
                        ),
                        'template' => '{{- starttime}}',
                        'limit' => 1,
                    ),
                ),
                'template' => '{{- timezone }}',
                'limit' => 1,
            ),            
			'website' => array(
                'type' => 'text',
                'label' => esc_html__('Webiste?', 'listingo'),
                'desc' => esc_html__('Ad website address goes here.', 'listingo'),
            ),
			'email' => array(
                'type' => 'text',
                'label' => esc_html__('Email address?', 'listingo'),
                'desc' => esc_html__('Ad email ID goes here.', 'listingo'),
            ),
			'phone' => array(
                'type' => 'text',
                'label' => esc_html__('Phone', 'listingo'),
                'desc' => esc_html__('Ad phone number goes here.', 'listingo'),
            ),
		    'fax' => array(
                'type' => 'text',
                'label' => esc_html__('Fax', 'listingo'),
                'desc' => esc_html__('Ad fax number goes here.', 'listingo'),
            ),
			'pricing_type' => array(
                'type' => 'select',
                'label' => esc_html__('Pricing Type', 'listingo'),
                'choices' => $price_types
            ),
			'price' => array(
                'type' => 'text',
                'label' => esc_html__('Price?', 'listingo'),
                'desc' => esc_html__('Ad price goes here.', 'listingo'),
            ),
			
			'currency' => array(
                'type' => 'text',
                'label' => esc_html__('Currency?', 'listingo'),
                'desc' => esc_html__('Ad currency symbol goes here.', 'listingo'),
            ),
			
			'address' => array(
                'type' => 'text',
                'label' => esc_html__('Address?', 'listingo'),
                'desc' => esc_html__('Ad address goes here.', 'listingo'),
            ),
			'latitude' => array(
                'type' => 'text',
                'label' => esc_html__('Latitude?', 'listingo'),
                'desc' => esc_html__('Ad latitude goes here.', 'listingo'),
            ),
			'longitude' => array(
                'type' => 'text',
                'label' => esc_html__('Longitude', 'listingo'),
                'desc' => esc_html__('Ad longitude goes here.', 'listingo'),
            ),
			'address' => array(
                'type' => 'text',
                'label' => esc_html__('Address', 'listingo'),
                'desc' => esc_html__('Ad address goes here.', 'listingo'),
            ),
			'country' => array(
                'label' => esc_html__('Country?', 'listingo'),
                'type' => 'multi-select',
                'population' => 'taxonomy',
                'source' => 'countries',
                'desc' => esc_html__('', 'listingo'),
				'limit' => 1
            ),
			'city' => array(
                'label' => esc_html__('Cities?', 'listingo'),
                'type' => 'multi-select',
                'population' => 'taxonomy',
                'source' => 'cities',
                'desc' => esc_html__('', 'listingo'),
				'limit' => 1
            ),
            'videos' => array(
                'type' => 'addable-option',
                'label' => esc_html__('Videos', 'listingo'),
                'desc' => esc_html__('Ad video/audio link goes here.', 'listingo'),
                'option' => array('type' => 'text'),
                'add-button-text' => esc_html__('Add', 'listingo'),
                'sortable' => true,
            ),
			
			$socials
        ),
    ),
);
