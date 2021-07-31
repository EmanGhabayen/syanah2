<?php

if (!defined('FW'))
    die('Forbidden');
if( !function_exists('_filter_theme_disable_default_shortcodes') ){
	function _filter_theme_disable_default_shortcodes($to_disable) {
		$to_disable[] = 'map';
		return $to_disable;
	}

	add_filter('fw_ext_shortcodes_disable_shortcodes', '_filter_theme_disable_default_shortcodes');
}

