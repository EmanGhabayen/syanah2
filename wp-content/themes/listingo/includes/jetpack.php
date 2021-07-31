<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package Charity
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
if (!function_exists('listingo_jetpack_setup')) {
	function listingo_jetpack_setup() {
		add_theme_support( 'infinite-scroll', array(
			'container' => 'main',
			'render'    => 'listingo_infinite_scroll_render',
			'footer'    => 'page',
		) );
	} // end function listingo_jetpack_setup
	add_action( 'after_setup_theme', 'listingo_jetpack_setup' );
}

if (!function_exists('listingo_infinite_scroll_render')) {
	function listingo_infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content', get_post_format() );
		}
	} // end function listingo_infinite_scroll_render
}