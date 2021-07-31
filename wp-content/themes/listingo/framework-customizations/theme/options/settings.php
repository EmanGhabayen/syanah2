<?php

if (!defined('FW')) {
    die('Forbidden');
}
/**
 * Framework options
 *
 * @var array $options Fill this array with options to generate framework settings form in backend
 */

$app_settings = array();
if( class_exists('ListingoAppGlobalSettings') ){
	$app_settings = array(
    	fw()->theme->get_options('app-settings')
	);
}

$options = array(
    fw()->theme->get_options('general-settings'),
    fw()->theme->get_options('headers-settings'),
    fw()->theme->get_options('titlebar-settings'),
    fw()->theme->get_options('footer-settings'),
    fw()->theme->get_options('blog-settings'),
    fw()->theme->get_options('typo-settings'),
    fw()->theme->get_options('colors-settings'),
    fw()->theme->get_options('social-sharing-settings'),
    fw()->theme->get_options('directory-settings'),
    fw()->theme->get_options('api-settings'),
    fw()->theme->get_options('email-settings'),
	fw()->theme->get_options('booking-settings'),
	fw()->theme->get_options('social-connect-settings'),
    fw()->theme->get_options('underconstruction-settings'),
	fw()->theme->get_options('captcha-settings'),
	//$app_settings
);




