<?php
/**
 *
 * Author Header Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * Get User Queried Object Data
 */
global $current_user;
$author_profile = $wp_query->get_queried_object();

/* ============Get The User Avatar Image======================= */
$user_avatar = apply_filters(
        'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 100, 'height' => 100), $author_profile->ID), array('width' => 100, 'height' => 100) //size width,height
);
/* ============Get The User Dashboard Banner==================== */

$user_banner = apply_filters(
        'listingo_get_media_filter', listingo_get_user_banner(array('width' => 0, 'height' => 0), $author_profile->ID), array('width' => 1920, 'height' => 510) //size width,height
);
/* ==================Get Company Name & Tag Line================== */
$company_name = listingo_get_username($author_profile->ID);
$provider_category	= listingo_get_provider_category($author_profile->ID);
$db_privacy = listingo_get_privacy_settings($author_profile->ID);

$tag_line = '';
if (!empty($author_profile->tag_line)) {
    $tag_line = $author_profile->tag_line;
}

//Authentication page
$auth_page	= listingo_get_login_registration_page_uri();
?>
<div class="tg-detailpagehead sp-provider-wrap">
	<div class="tg-detailpagehead">
		<figure>
			<img src="<?php echo esc_url($user_banner); ?>" alt="<?php esc_html_e('Banner', 'listingo'); ?>">
		</figure>
		<div class="tg-detailpageheadcontent">
			<?php if (!empty($user_avatar)) { ?>
				<div class="tg-companylogo">
					<img src="<?php echo esc_url($user_avatar); ?>" alt="<?php esc_html_e('Author Avatar', 'listingo'); ?>">
				</div>
			<?php } ?>
			<div class="tg-companycontent">
				<?php listingo_result_tags($author_profile->ID, 'echo'); ?>
				<div class="tg-title">
					<?php if (!empty($company_name)) { ?>
						<h1><?php echo esc_attr($company_name); ?></h1>
					<?php } ?>
					<?php if (!empty($tag_line)) { ?>
						<span><?php echo esc_attr($tag_line); ?></span>
					<?php } ?>
				</div>
				<?php do_action('sp_get_rating_and_votes', $author_profile->ID, 'echo'); ?>
			</div>
			<?php if (is_user_logged_in()) {
				if( apply_filters('listingo_is_feature_allowed', $provider_category, 'appointments') === true
					&& apply_filters('listingo_is_setting_enabled', $author_profile->ID, 'subscription_appointments') === true
					&& $current_user->ID != $author_profile->ID
					&& ( isset( $db_privacy['profile_appointment'] ) && $db_privacy['profile_appointment'] === 'on' )
				){
				?>
					<button class="tg-btn" type="buttton" data-toggle="modal" data-target=".tg-appointmentModal"><?php esc_html_e('Make Appointment', 'listingo'); ?></button>
				<?php }?>
			<?php } else if( apply_filters('listingo_is_feature_allowed', $provider_category, 'appointments') === true 
				&& apply_filters('listingo_is_setting_enabled', $author_profile->ID,'subscription_appointments') === true
				&& ( isset( $db_privacy['profile_appointment'] ) && $db_privacy['profile_appointment'] === 'on' )
				&& !empty($auth_page) ) {?>
				<a class="tg-btn" href="<?php echo esc_url($auth_page); ?>?redirect=<?php echo esc_url(get_author_posts_url($author_profile->ID)); ?>"><?php esc_html_e('Make an appointment', 'listingo'); ?></a>
			<?php }?>
		</div>
	</div>
</div>