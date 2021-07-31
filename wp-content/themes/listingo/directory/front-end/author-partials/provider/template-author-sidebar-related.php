<?php
/**
 *
 * Author Sidebar Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $wp_query, $current_user;
/**
 * Get User Queried Object Data
 */
$author_profile = $wp_query->get_queried_object();
$provider_category 		= listingo_get_provider_category($author_profile->ID);
$category_type = $author_profile->category;

if (function_exists('fw_get_db_settings_option')) {
    $dir_map_marker = fw_get_db_post_option($category_type, 'dir_map_marker', true);
	$dir_hide_providers = fw_get_db_settings_option('dir_hide_providers');
} else {
    $dir_map_marker = '';
	$dir_hide_providers = '';
}

?>
<?php
	if( isset( $dir_hide_providers ) && $dir_hide_providers === 'no' ){
		get_template_part('directory/front-end/author-partials/provider/template-author-related', 'providers');
	}
?>