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
        'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 300, 'height' => 300), $author_profile->ID), array('width' => 300, 'height' => 300) //size width,height
);
/* ============Get The User Dashboard Banner==================== */

$user_banner = apply_filters(
        'listingo_get_media_filter', listingo_get_user_banner(array('width' => 0, 'height' => 0), $author_profile->ID), array('width' => 1920, 'height' => 510) //size width,height
);
/* ==================Get Company Name & Tag Line================== */
$company_name = listingo_get_username($author_profile->ID);
$provider_category	= listingo_get_provider_category($author_profile->ID);
$db_privacy = listingo_get_privacy_settings($author_profile->ID);
$profile_status	= get_user_meta($author_profile->ID,'profile_status',true);
$profile_email	= get_user_meta($author_profile->ID,'phone',true);
$profile_email	= get_user_meta($author_profile->ID,'email',true);

$tag_line = '';
if (!empty($author_profile->tag_line)) {
    $tag_line = $author_profile->tag_line;
}

if (function_exists('fw_get_db_settings_option')) {
	$show_info_for = fw_get_db_settings_option('show_info_for', $default_value = null);
}
//Authentication page
$auth_page	= listingo_get_login_registration_page_uri();
$accessCol = 'col-md-12 col-lg-12 access-infono';
if ( apply_filters('listingo_is_contact_informations_enabled', 'yes','yes',$author_profile->ID) === 'yes') {
	$accessCol = 'col-md-6 col-lg-6';
}
?>
<section id="tg-innerbanner" class="tg-innerbanner tg-innerbannervtwo spv4-header tg-haslayout">
	<figure class="tg-innerbannerimg">
		<img src="<?php echo esc_url($user_banner); ?>" alt="<?php esc_html_e('User Banner', 'listingo'); ?>">
		<figcaption>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 <?php echo esc_attr($accessCol); ?>  col-aligncenter">
						<div class="tg-userstatusholder">
							<figure class="tg-userstatusimg">
								<img src="<?php echo esc_url($user_avatar); ?>" alt="<?php esc_html_e('Author Avatar', 'listingo'); ?>">
								<div class="tg-userdropdownstatus <?php echo esc_attr( $profile_status );?>"> 
									<a href="javascript:;" class="tg-userstatus">
									</a>
								</div>
							</figure>
							<div class="tg-adverifiedadd tg-adverifiedaddvtwo">
								<?php listingo_result_tags($author_profile->ID, 'echo'); ?>
							</div>
							<div class="tg-userinfo">
								<div class="tg-title">
									<?php if (!empty($company_name)) { ?>
										<h2><?php echo esc_attr($company_name); ?></h2>
									<?php } ?>
									<?php if (!empty($tag_line)) { ?>
										<span><?php echo esc_attr($tag_line); ?></span>
									<?php } ?>
								</div>
							</div>
							<div class="tg-userinforating">
								<?php do_action('sp_get_rating_and_votes', $author_profile->ID, 'echo'); ?>
							</div>
							<div class="tg-btnbox">
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
					<?php 
					if ( apply_filters('listingo_is_contact_informations_enabled', 'yes','yes',$author_profile->ID) === 'yes') {
						if( !empty( $author_profile->phone ) ){
							if( isset( $show_info_for ) && $show_info_for === 'registered_only' && !is_user_logged_in() ){?>
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 pull-left">
									<div class="tg-usermobile">
										<span><a target="_blank" href="<?php echo esc_url($auth_page); ?>?redirect=<?php echo esc_url(get_author_posts_url($author_profile->ID)); ?>" ><i class="lnr lnr-phone-handset"></i><?php esc_html_e('Login to view phone number', 'listingo'); ?></a></span>
									</div>
								</div>
							<?php }else{?>
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 pull-left">
									<div class="tg-usermobile">
										<span><a href="tel:<?php echo esc_attr($author_profile->phone); ?>"><i class="lnr lnr-phone-handset"></i><?php echo esc_attr($author_profile->phone); ?></a></span>
									</div>
								</div>
					<?php }}}?>
					<?php 
					if ( apply_filters('listingo_is_contact_informations_enabled', 'yes','yes',$author_profile->ID) === 'yes') {
					if( !empty( $author_profile->user_email ) ){
						if( isset( $show_info_for ) && $show_info_for === 'registered_only' && !is_user_logged_in() ){?>
							<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 pull-right">
								<div class="tg-usermobile">
									<span><a target="_blank" href="<?php echo esc_url($auth_page); ?>?redirect=<?php echo esc_url(get_author_posts_url($author_profile->ID)); ?>"><i class="lnr lnr-envelope"></i><?php esc_html_e('Login to view email address', 'listingo'); ?></a></span>
								</div>
							</div>
						<?php }else{?>
						<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 pull-right">
							<div class="tg-usermobile">
								<span><a href="mailto:<?php echo esc_attr($author_profile->user_email); ?>"><i class="lnr lnr-envelope"></i><?php esc_html_e('Send a Message', 'listingo'); ?></a></span>
							</div>
						</div>
					<?php }}}?>
				</div>
			</div>
		</figcaption>
	</figure>
</section>