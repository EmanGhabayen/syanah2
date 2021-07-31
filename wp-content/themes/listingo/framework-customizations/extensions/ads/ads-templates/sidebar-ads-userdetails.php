<?php 
/**
 *
 * The template used for displaying ad sidebar
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $post;
$post_author_id = get_post_field( 'post_author', $post->ID );
do_action('listingo_get_ad_author_box', $post_author_id);
