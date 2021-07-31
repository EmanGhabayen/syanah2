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
$longitude 		= $author_profile->longitude;
$latitude 		= $author_profile->latitude;
$address 				= $author_profile->address;
$provider_category	= listingo_get_provider_category($author_profile->ID);
$map_marker 		= fw_get_db_post_option($provider_category, 'dir_map_marker', true);

if (!empty($map_marker['url'])) {
    $dir_map_marker = $map_marker['url'];
} else {
	if (function_exists('fw_get_db_settings_option')) {
    	$dir_map_marker = fw_get_db_settings_option('dir_map_marker');
	}
    $dir_map_marker = !empty($dir_map_marker['url']) ? $dir_map_marker['url'] : '';
}

if (empty($dir_map_marker)) {
    $dir_map_marker = get_template_directory_uri() . '/images/map-marker.png';
}
$sp_usersdata = array();
$sp_userinfo['userinfo']	=  array();

$sp_usersdata['marker'] 	= $dir_map_marker;
$sp_usersdata['longitude'] 	= $longitude;
$sp_usersdata['latitude'] 	= $latitude;
$sp_usersdata['address'] 	= $address;
$sp_userinfo['userinfo'][]  = $sp_usersdata;
?>
<div class="tg-mapbox">
	<?php if (!empty($latitude) && !empty($longitude)) { ?>
		<div id="tg-locationmap" class="tg-locationmap"></div>
		<?php
			$script = "jQuery(document).ready(function () {listingo_init_detail_map_script(" . json_encode($sp_userinfo) . ");});";
			wp_add_inline_script('listingo_gmaps', $script, 'after');
		?>
	<?php } ?>
</div>