<?php

if (!defined('FW')) {
    die('Forbidden');
}
$manifest = array();
$manifest['id'] = 'listingo';
$manifest['supported_extensions'] = array(
    'page-builder' => array(),
    'backups' => array(),
	'megamenu' => array(),
    'sidebars' => array(),
    'breadcrumbs' => array(),
    //'seo' => array(),
    'analytics' => array(),
	'articles' => array()	
);
