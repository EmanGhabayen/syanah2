<?php
/**
 *
 * Author Company Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * Get User Queried Object Data
 */
$author_profile = $wp_query->get_queried_object();
$user_avatar = apply_filters(
        'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 170, 'height' => 170), $author_profile->ID), array('width' => 170, 'height' => 170) //size width,height
);

$sphide_map	= 'no';
if (function_exists('fw_get_db_settings_option')) {
	$show_info_for = fw_get_db_settings_option('show_info_for', $default_value = null);
	$sphide_map 	= fw_get_db_settings_option('sphide_map');
}
$auth_page	= listingo_get_login_registration_page_uri();
?>
<section class="tg-haslayout spv-bglight  spv4-section map-visivbility-<?php echo esc_attr( $sphide_map );?>" id="section-contact-info">
	<div class="tg-haslayout tg-comconectinfo">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-push-1">
					<ul class="tg-contectdetails">
						<?php 
						if( apply_filters('listingo_is_contact_informations_enabled', 'yes','yes',$author_profile->ID) === 'yes') {
							if (!empty($author_profile->phone)) {
							if( isset( $show_info_for ) && $show_info_for === 'registered_only' && !is_user_logged_in() ){?>
								<li class="tg-envelopecolor">
									<h3><a target="_blank" href="<?php echo esc_url($auth_page); ?>?redirect=<?php echo esc_url(get_author_posts_url($author_profile->ID)); ?>" ><i class="lnr lnr-phone-handset"></i><span><?php esc_html_e('Login to view phone number', 'listingo'); ?></span></a></h3>
								</li>
							<?php }else{?>
								<li class="tg-numcolor">
									<h3><a href="tel:<?php echo esc_attr($author_profile->phone); ?>"><i class="lnr lnr-phone-handset"></i><span><?php echo esc_attr($author_profile->phone); ?></span></a></h3>
								</li>
							<?php } ?>
						<?php } }?>
						<?php 
						if ( apply_filters('listingo_is_contact_informations_enabled', 'yes','yes',$author_profile->ID) === 'yes') {
							if (!empty($author_profile->user_email)) {
								if( isset( $show_info_for ) && $show_info_for === 'registered_only' && !is_user_logged_in() ){?>
									<li class="tg-envelopecolor">
										<h3><a target="_blank" href="<?php echo esc_url($auth_page); ?>?redirect=<?php echo esc_url(get_author_posts_url($author_profile->ID)); ?>" ><i class="lnr lnr-envelope"></i><span><?php esc_html_e('Login to view email address', 'listingo'); ?></span></a></h3>
									</li>
								<?php }else{?>
									<li class="tg-envelopecolor">
										<h3><a href="mailto:<?php echo esc_attr($author_profile->user_email); ?>"><i class="lnr lnr-envelope"></i><span><?php esc_html_e('Send a Message', 'listingo'); ?></span></a></h3>
									</li>
								<?php } ?>
						<?php }} ?>
						<?php if (!empty($author_profile->fax)) { ?>
						<li class="tg-printercolor">
							<h3><i class="lnr lnr-printer"></i><span><?php echo esc_attr($author_profile->fax); ?></span></h3>
						</li>
						<?php } ?>
						<?php if (!empty($author_profile->user_url)) { ?>
						<li class="tg-screencolor">
							<h3><a href="<?php echo esc_url($author_profile->user_url); ?>" target="_blank"><i class="lnr lnr-screen"></i><span><?php esc_html_e('Website', 'listingo'); ?></span></a></h3>
						</li>
						<?php } ?>
						<li class="tg-sharecolor">
							<div class="tg-themedropdown tg-userdropdown">
								<h3>
									<i class="fa fa-share"></i>
									<span class="tg-userdropdown"><?php esc_html_e('Share Profile', 'listingo'); ?></span>
								</h3>
								<div class="tg-dropdownmenu tg-statusmenu" aria-labelledby="tg-usermenu">
									<nav class="tg-dashboardnav">
									  <?php listingo_prepare_social_sharing('false', '', 'false', '', $user_avatar); ?>
									</nav>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>	
		</div>
	</div>
	<div class="tg-haslayout">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="tg-mapboxvtwo">
						<?php get_template_part('directory/front-end/author-partials/provider/template-author-sidebar', 'map'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>



