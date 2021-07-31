<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg = array(
	'page_builder' => array(
		'title' => esc_html__('Recent Ads', 'listingo'),
		'description' => esc_html__('Display recent posted ads', 'listingo'),
		'tab' => esc_html__('Listingo', 'listingo'),
		'popup_size' => 'small' // can be large, medium or small
	)
);