<?php if (!defined('FW')) die('Forbidden');
/**
 * @var string $uri Demo directory url
 */

$manifest = array();
$manifest['title'] = esc_html__('Listingo VC-Addon', 'listingo');
$manifest['screenshot'] = get_template_directory_uri(). '/demo-content/images/vc.jpg';
$manifest['preview_link'] = 'https://themographics.com/wordpress/vc_addon/';