<?php

if (!defined('FW')) {
    die('Forbidden');
}

/**
 * Return the ad listing view.
 * @return string
 */
if (!function_exists('fw_ext_get_render_ads_listing')) {
	function fw_ext_get_render_ads_listing() {
		return fw()->extensions->get('ads')->render_ad_listing();
	}
}

/**
 * Return the favorite ads
 * @return string
 */
if (!function_exists('fw_ext_get_render_favorite_ads')) {
	function fw_ext_get_render_favorite_ads() {
		return fw()->extensions->get('ads')->render_favorite_ads();
	}
}

/**
 * Return the ads add view.
 * @return string
 */
if (!function_exists('fw_ext_get_render_ads_add')  ) {
	function fw_ext_get_render_ads_add() {
		return fw()->extensions->get('ads')->render_add_ads();
	}
}

/**
 * Return the ads edit view.
 * @return string
 */
if (!function_exists('fw_ext_get_render_ads_edit')) {
	function fw_ext_get_render_ads_edit() {
		return fw()->extensions->get('ads')->render_edit_ads();
	}
}

/**
 * Return the ads dashboard display view.
 * @return string
 */
if (!function_exists('fw_ext_get_render_ads_dashboard_view')) {
	function fw_ext_get_render_ads_dashboard_view() {
		return fw()->extensions->get('ads')->render_display_dashboard_ads();
	}
}

/**
 * Return the ads dashboard display view.
 * @return string
 */
if (!function_exists('fw_ext_get_render_ads_search')) {
	function fw_ext_get_render_ads_search() {
		return fw()->extensions->get('ads')->render_display_search_result();
	}
}

/**
 * Return the provider detail page ads
 * @return string
 */
if (!function_exists('fw_ext_get_render_profile_ads_view')) {
	function fw_ext_get_render_profile_ads_view() {
		return fw()->extensions->get('ads')->render_display_profile_ads();
	}
}

/**
 * Return the ads dashboard display view.
 * @return string
 */
if (!function_exists('filter_fw_ext_ad_view_v2')) {
	function filter_fw_ext_ad_view_v2() {
		return fw()->extensions->get('ads')->render_list_ads();
	}
}

/**
 * Return the ads detail view.
 * @return string
 */
if (!function_exists('filter_fw_ext_ad_detail_view')) {
	function filter_fw_ext_ad_detail_view() {
		return fw()->extensions->get('ads')->render_display_profile_ads_detail_view();
	}
}

/**
 * Return the ads archive view.
 * @return string
 */
if (!function_exists('filter_fw_ext_ad_archive_view')) {
	function filter_fw_ext_ad_archive_view() {
		return fw()->extensions->get('ads')->render_display_ads_archive_view();
	}
}