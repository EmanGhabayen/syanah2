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
global $post, $post_video;

$url = parse_url($post_video);
$height = 466;
$width = 1170;

if ( isset( $url['host'] ) && $url['host'] == $_SERVER["SERVER_NAME"]) {
    echo '<figure class="tg-classimg">';
    echo do_shortcode('[video width="' . intval( $width ) . '" height="' . intval( $height ) . '" src="' . esc_attr( $post_video ) . '"][/video]');
    echo '</figure>';
} else {
    if ( isset( $url['host'] ) &&  $url['host'] == 'vimeo.com' || $url['host'] == 'player.vimeo.com') {
        echo '<figure class="tg-classimg">';
        $content_exp = explode("/", $post_video);
        $content_vimo = array_pop($content_exp);
        echo '<iframe width="' . intval( $width ) . '" height="' . intval( $height ) . '" src="https://player.vimeo.com/video/' . esc_attr( $content_vimo ) . '" 
></iframe>';
        echo '</figure>';
    } elseif ( isset( $url['host'] ) && $url['host'] == 'soundcloud.com') {
        $height = 205;
        $width = 1170;
        $video = wp_oembed_get($post_video, array(
            'height' => intval( $height )));
        $search = array(
            'webkitallowfullscreen',
            'mozallowfullscreen',
            'frameborder="0"');
        echo '<figure class="tg-classimg">';
        echo str_replace($search, '', $video);
        echo '</figure>';
    } else {
        echo '<figure class="tg-classimg">';
        $content = str_replace(array(
            'watch?v=',
            'http://www.dailymotion.com/'), array(
            'embed/',
            '//www.dailymotion.com/embed/'), $post_video);
        echo '<iframe width="' . intval( $width ) . '" height="' . intval( $height ) . '" src="' . esc_attr( $content ) . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
        echo '</figure>';
    }
}
