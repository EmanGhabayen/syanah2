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
$user_avatar = apply_filters(
        'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 300, 'height' => 300), $author_profile->ID), array('width' => 300, 'height' => 300) //size width,height
);

?>
<div class="tg-widget tg-widgetshare">
	<div class="tg-widgettitle">
		<h3><?php esc_html_e('Share', 'listingo'); ?></h3>
	</div>
	<div class="tg-widgetcontent">
		<?php listingo_prepare_social_sharing('false', '', 'false', '', $user_avatar); ?>
	</div>
</div>