<?php

/**
 *
 * Template Name: Ads Search
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
global $paged, $wp_query;
get_header();
if ( function_exists('fw_get_db_settings_option') && fw_ext('ads')) {
	do_action('_filter_fw_ext_search_ads');
} else{
	//display message
}
get_footer();
