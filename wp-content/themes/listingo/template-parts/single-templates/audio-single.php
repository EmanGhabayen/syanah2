<?php

/**
 *
 * The template used for displaying audio post formate
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $post;
$height = 205;
$width = 1170;
$video = wp_oembed_get($post_video, array(
    'height' => $height,
    'width' => $width));
$search = array(
    'webkitallowfullscreen',
    'mozallowfullscreen',
    'frameborder="0"');
echo '<div class="' . sanitize_html_class($mediaClass) . '">';
echo str_replace($search, '', $video);
echo '</div>';
