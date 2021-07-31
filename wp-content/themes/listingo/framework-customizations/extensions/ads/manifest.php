<?php
if (!defined('FW'))
    die('Forbidden');

$manifest = array();
$manifest['name'] = esc_html__('Ads', 'listingo');
$manifest['uri'] = 'https://themeforest.net/user/themographics/portfolio';
$manifest['description'] = esc_html__('This extension will enable the providers to create ads/listings from their dashboard.', 'listingo');
$manifest['version'] = '1.7';
$manifest['author'] = 'Themographics';
$manifest['display'] = true;
$manifest['standalone'] = true;
$manifest['author_uri'] = 'https://themeforest.net/user/themographics/portfolio';
$manifest['github_repo'] = 'https://github.com/etwordpress01/ads';
$manifest['github_update'] = 'etwordpress01/ads';
$manifest['requirements'] = array(
    'wordpress' => array(
        'min_version' => '4.0',
    )
);

$manifest['thumbnail'] = fw_get_template_customizations_directory_uri().'/extensions/ads/static/img/thumbnails/ads.png';
