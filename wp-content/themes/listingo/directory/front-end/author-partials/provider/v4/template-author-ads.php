<?php
/**
 *
 * Author ads Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * Get User Queried Object Data
 */
global $wp_query;
$author_profile = $wp_query->get_queried_object();

/**
 * Get The Dashboard Ads
 */
$author_profile = $wp_query->get_queried_object();
$posted_ads		= listingo_get_total_posts_by_user($author_profile->ID,'sp_ads');
if ( function_exists('fw_get_db_settings_option') && fw_ext('ads') && $posted_ads >  0 ) { ?>
	<section class="tg-author-profile-ads-listing tg-haslayout tg-introductionhold spv4-ads spv4-section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
					<?php do_action('render_sp_display_profile_ads'); ?>
				</div>
			</div>
		</div>
	</section>
<?php
}