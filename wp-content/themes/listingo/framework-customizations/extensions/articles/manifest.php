<?php
if (!defined('FW'))
    die('Forbidden');

$manifest = array();
$manifest['name'] = esc_html__('Articles', 'listingo');
$manifest['uri'] = 'https://themeforest.net/user/themographics/portfolio';
$manifest['description'] = esc_html__('This extension will enable providers to create articles from their dashboard.', 'listingo');
$manifest['version'] = '2.8';
$manifest['author'] = 'Themographics';
$manifest['display'] = true;
$manifest['standalone'] = true;
$manifest['author_uri'] = 'https://themeforest.net/user/themographics/portfolio';
$manifest['github_repo'] = 'https://github.com/etwordpress01/articles';
$manifest['github_update'] = 'etwordpress01/articles';
$manifest['requirements'] = array(
    'wordpress' => array(
        'min_version' => '4.0',
    )
);

$manifest['thumbnail'] = fw_get_template_customizations_directory_uri().'/extensions/articles/static/img/thumbnails/articles.png';
