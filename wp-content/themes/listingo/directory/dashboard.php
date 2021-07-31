<?php
/**
 * Template Name: Dashboard
 *
 * @package Listingo
 * @since Listingo 1.0
 * @desc Template used for front end dashboard.
 */
/* Define Global Variables */
get_header();

global $current_user, $wp_roles, $userdata, $post;

$user_identity = $current_user->ID;
$url_identity = $user_identity;

if (isset($_GET['identity']) && !empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$provider_category  = listingo_get_provider_category($user_identity);
$bk_settings		= listingo_get_booking_settings();
$is_chat			= listingo_is_chat_enabled($user_identity);

$insight_page = '';
if (function_exists('fw_get_db_settings_option')) {
	$insight_page = fw_get_db_settings_option('insight_page', $default_value = null);
}

do_action('listingo_is_user_active',$url_identity);
do_action('listingo_is_user_verified',$url_identity);
?>
<div class="container">
	<div class="row">
		<div id = "tg-twocolumns" class = "tg-twocolumns">
			<?php 
			if (is_user_logged_in()) {
				if( apply_filters('listingo_is_social_user', $user_identity) === 'yes' ){
					do_action('listingo_complete_registration_form');
				} else{
					
				if( apply_filters('listingo_packages_visibility', $user_identity) === true ) {?>
					<div class="col-xs-12">
						<?php get_template_part('directory/front-end/templates/dashboard', 'package');?>
					</div>
				<?php } else{?>
					<div class = "col-xs-12 col-sm-5 col-md-4 col-lg-3 pull-left">
						<aside id = "tg-sidebar" class = "tg-sidebar">
							<?php Listingo_Profile_Menu::listingo_profile_menu_left(); ?>
							<?php if (is_active_sidebar('user-dashboard-sidebar')) {?>
							  <div class="tg-advertisement">
								<?php dynamic_sidebar('user-dashboard-sidebar'); ?>
							  </div>
							<?php }?>
						</aside>
					</div>
					<div class="col-xs-12 col-sm-7 col-md-8 col-lg-9 pull-right">
						<?php
						if (isset($_GET['ref']) && $_GET['ref'] === 'settings' && $url_identity == $user_identity) {
							if (apply_filters('listingo_do_check_user_type', $user_identity) === true) {
								get_template_part('directory/front-end/templates/dashboard', 'profile-settings'); //provider
							} else {
								get_template_part('directory/front-end/customer/dashboard', 'profile-settings'); //customer
							}
						} else if (isset($_GET['ref']) && $_GET['ref'] === 'hours' 
								   && $url_identity == $user_identity 
								   && apply_filters('listingo_do_check_user_type', $user_identity) === true 
								   && apply_filters('listingo_is_setting_enabled', $user_identity, 'subscription_business_hours') === true
						) {
							get_template_part('directory/front-end/templates/dashboard', 'hours');
						} else if (isset($_GET['ref']) && $_GET['ref'] === 'switch_account' 
								   && $url_identity == $user_identity 
								   &&  apply_filters('listingo_get_user_type', $user_identity) === 'customer' 
						) {
							get_template_part('directory/front-end/templates/dashboard', 'switch-account');
						} else if (isset($_GET['ref']) && $_GET['ref'] === 'services' 
								   && $url_identity == $user_identity 
								   && apply_filters('listingo_do_check_user_type', $user_identity) === true
						) {
							get_template_part('directory/front-end/templates/dashboard', 'services');
						} else if (isset($_GET['ref']) && $_GET['ref'] === 'myappointments' 
								   && $url_identity == $user_identity 
						) {
							get_template_part('directory/front-end/templates/dashboard', 'myappointments');
						} else if (isset($_GET['ref']) && $_GET['ref'] === 'team' 
								   && $url_identity == $user_identity 
								   && apply_filters('listingo_do_check_user_type', $user_identity) === true 
								   && apply_filters('listingo_is_setting_enabled', $user_identity, 'subscription_teams') === true 
								   && apply_filters('listingo_is_feature_allowed', $provider_category, 'teams') === true
						) {

							if (function_exists('fw_get_db_settings_option') && fw_ext('members') ){
								if (( isset($_GET['ref']) && $_GET['ref'] === 'team' ) 
									&& ( isset($_GET['mode']) && $_GET['mode'] === 'listing' ) 
									&& $url_identity == $user_identity
								) {
									do_action('render_member_listing_view');
								} else if (( isset($_GET['ref']) && $_GET['ref'] === 'team' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'add' ) 
								   && $url_identity == $user_identity
								) {
									do_action('render_member_add_view');
								} else if (( isset($_GET['ref']) && $_GET['ref'] === 'team' ) 
									   && ( isset($_GET['mode']) && $_GET['mode'] === 'edit' ) 
									   && $url_identity == $user_identity
								) {
									do_action('render_member_edit_view');
								} 
							} else{
								get_template_part('directory/front-end/templates/dashboard', 'team');
							}

						} else if (( isset($_GET['ref']) && $_GET['ref'] === 'jobs' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'add' ) 
								   && $url_identity == $user_identity
								   && apply_filters('listingo_get_theme_settings', 'jobs') == 'yes'
						) {
							get_template_part('directory/front-end/templates/dashboard', 'add-job');
						} else if (( isset($_GET['ref']) && $_GET['ref'] === 'jobs' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'edit' ) 
								   && (!empty($_GET['id']) ) && $url_identity == $user_identity
								   && apply_filters('listingo_get_theme_settings', 'jobs') == 'yes'
						) {
							get_template_part('directory/front-end/templates/dashboard', 'edit-job');
						} else if (( isset($_GET['ref']) && $_GET['ref'] === 'jobs' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'listing' ) 
								   && $url_identity == $user_identity
								   && apply_filters('listingo_get_theme_settings', 'jobs') == 'yes'
						) {
							get_template_part('directory/front-end/templates/dashboard', 'jobs');
						} else if (( isset($_GET['ref']) && $_GET['ref'] === 'messages' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'inbox' ) 
								   && $url_identity == $user_identity
						) {
							do_action('render_message_inbox');
						} else if (( isset($_GET['ref']) && $_GET['ref'] === 'messages' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'sent' ) 
								   && $url_identity == $user_identity
						) {
							do_action('render_message_sent');
						} else if (( isset($_GET['ref']) && $_GET['ref'] === 'messages' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'trash' ) 
								   && $url_identity == $user_identity
						) {
							do_action('render_message_trash');
						} else if ((isset($_GET['ref']) && $_GET['ref'] === 'chat')
									 && $url_identity == $user_identity 
									 && !empty($is_chat) && $is_chat === 'yes'
									 ) {
							get_template_part('directory/front-end/templates/dashboard', 'messaging');
						} else if ( ( isset($_GET['ref']) && $_GET['ref'] === 'statement' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'earnings' ) 
								   && $url_identity == $user_identity
								   && apply_filters('listingo_do_check_user_type', $user_identity) === true
								   && isset( $bk_settings['type'] ) && $bk_settings['type'] === 'woo'
								   && isset( $bk_settings['hide_wallet'] ) && $bk_settings['hide_wallet'] === 'no'
						) {
							get_template_part('directory/front-end/templates/dashboard', 'earnings');
						} else if ( ( isset($_GET['ref']) && $_GET['ref'] === 'statement' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'withdrawals' ) 
								   && $url_identity == $user_identity
								   && apply_filters('listingo_do_check_user_type', $user_identity) === true
								   && isset( $bk_settings['type'] ) && $bk_settings['type'] === 'woo'
								   && isset( $bk_settings['hide_wallet'] ) && $bk_settings['hide_wallet'] === 'no'
						) {
							get_template_part('directory/front-end/templates/dashboard', 'withdrawals');
						} else if ( ( isset($_GET['ref']) && $_GET['ref'] === 'statement' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'history' ) 
								   && $url_identity == $user_identity
								   && apply_filters('listingo_do_check_user_type', $user_identity) === true
								   && isset( $bk_settings['type'] ) && $bk_settings['type'] === 'woo'
								   && isset( $bk_settings['hide_wallet'] ) && $bk_settings['hide_wallet'] === 'no'
						) {
							get_template_part('directory/front-end/templates/dashboard', 'withdrawal_history');
						} else if (( isset($_GET['ref']) && $_GET['ref'] === 'articles' ) 
								  && ( isset($_GET['mode']) && $_GET['mode'] === 'listing' ) 
								  && $url_identity == $user_identity
								  && apply_filters('listingo_is_feature_allowed', $provider_category, 'articles') === true
						) {
							do_action('render_article_listing_view');
						} else if (( isset($_GET['ref']) && $_GET['ref'] === 'products' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'listing' ) 
								   && $url_identity == $user_identity
						) {
							do_action('render_products_listing_view');
						} else if (( isset($_GET['ref']) && $_GET['ref'] === 'products' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'add' ) 
								   && $url_identity == $user_identity
						) {
							do_action('render_products_add_view');
						} else if (( isset($_GET['ref']) && $_GET['ref'] === 'products' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'edit' ) 
								   && $url_identity == $user_identity
						) {
							do_action('render_products_edit_view');
						} else if ( ( isset($_GET['ref']) && $_GET['ref'] === 'withdrawal' ) 
								   && $url_identity == $user_identity
								   && apply_filters('listingo_do_check_user_type', $user_identity) === true
								   && isset( $bk_settings['type'] ) && $bk_settings['type'] === 'adaptive'
						) {
							get_template_part('directory/front-end/templates/dashboard-withdrawal', 'adaptive');
						} else if (( isset($_GET['ref']) && $_GET['ref'] === 'articles' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'add' ) 
								   && $url_identity == $user_identity
								   && apply_filters('listingo_is_feature_allowed', $provider_category, 'articles') === true
						) {
							do_action('render_article_add_view');
						} else if (( isset($_GET['ref']) && $_GET['ref'] === 'articles' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'edit' ) 
								   && $url_identity == $user_identity
								   && apply_filters('listingo_is_feature_allowed', $provider_category, 'articles') === true
						) {
							do_action('render_article_edit_view');
						}else if (( isset($_GET['ref']) && $_GET['ref'] === 'ads' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'add' ) 
								   && $url_identity == $user_identity
						) {
							do_action('render_ad_add_view');
						} else if (( isset($_GET['ref']) && $_GET['ref'] === 'ads' ) 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'edit' ) 
								   && $url_identity == $user_identity
						) {
							do_action('render_ad_edit_view');
						}else if (( isset($_GET['ref']) && $_GET['ref'] === 'ads' ) 
								  && ( isset($_GET['mode']) && $_GET['mode'] === 'listing' ) 
								  && $url_identity == $user_identity
						) {
							do_action('render_ad_listing_view');
						} else if (( isset($_GET['ref']) && $_GET['ref'] === 'ads' ) 
								  && ( isset($_GET['mode']) && $_GET['mode'] === 'favorite_ads' ) 
								  && $url_identity == $user_identity
						) {
							do_action('render_favorite_ads_view');
						} else if ((isset($_GET['ref']) && $_GET['ref'] === 'appointment') 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'appointments' ) 
								   && $url_identity == $user_identity && apply_filters('listingo_do_check_user_type', $user_identity) === true 
								   && apply_filters('listingo_is_setting_enabled', $user_identity, 'subscription_appointments') === true 
								   && apply_filters('listingo_is_feature_allowed', $provider_category, 'appointments') === true
						) {
							get_template_part('directory/front-end/templates/dashboard', 'appointment');
						} else if ((isset($_GET['ref']) 
								   && $_GET['ref'] === 'appointment') 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'appointment_schedules' ) 
								   && $url_identity == $user_identity && apply_filters('listingo_do_check_user_type', $user_identity) === true 
								   && apply_filters('listingo_is_setting_enabled', $user_identity, 'subscription_appointments') === true 
								   && apply_filters('listingo_is_feature_allowed', $provider_category, 'appointments') === true
						) {
							get_template_part('directory/front-end/templates/dashboard', 'appointment-schedules');
						} else if ((isset($_GET['ref']) && $_GET['ref'] === 'appointment') 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'appointment_settings' ) 
								   && $url_identity == $user_identity && apply_filters('listingo_do_check_user_type', $user_identity) === true 
								   && apply_filters('listingo_is_setting_enabled', $user_identity, 'subscription_appointments') === true 
								   && apply_filters('listingo_is_feature_allowed', $provider_category, 'appointments') === true
						) {
							get_template_part('directory/front-end/templates/dashboard', 'appointment-settings');
						} else if (isset($_GET['ref'])
								   && $_GET['ref'] === 'favourite' 
								   && $url_identity == $user_identity 
								   && apply_filters('listingo_is_setting_enabled', $user_identity, 'subscription_favorites') === true
						) {
							get_template_part('directory/front-end/templates/dashboard', 'favourite');
						} else if (isset($_GET['ref']) 
								   && $_GET['ref'] === 'package' 
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'invoices' ) 
								   && $url_identity == $user_identity) {
							get_template_part('directory/front-end/templates/dashboard', 'invoice');
						} else if (isset($_GET['ref'])
								   && $_GET['ref'] === 'package'
								   && ( isset($_GET['mode']) && $_GET['mode'] === 'listing' ) 
								   && $url_identity == $user_identity
								   && apply_filters('listingo_is_listing_free', false,$user_identity) === false
						) {
							get_template_part('directory/front-end/templates/dashboard', 'package');
						} else if (isset($_GET['ref']) 
								   && $_GET['ref'] === 'security_settings' 
								   && $url_identity == $user_identity) {
							get_template_part('directory/front-end/templates/dashboard', 'security-settings');
						} else if (isset($_GET['ref']) 
								   && $_GET['ref'] === 'privacy_settings' 
								   && $url_identity == $user_identity 
								   && apply_filters('listingo_do_check_user_type', $user_identity) === true
						) {
							get_template_part('directory/front-end/templates/dashboard', 'privacy-settings');
						} else if (isset($_GET['ref']) 
								   && $_GET['ref'] === 'sorting' 
								   && $url_identity == $user_identity 
								   && apply_filters('listingo_do_check_user_type', $user_identity) === true
						) {
							get_template_part('directory/front-end/templates/dashboard', 'sorting');
						} else {
							if( isset( $insight_page ) && $insight_page === 'enable' ){
								get_template_part('directory/front-end/templates/dashboard', 'insights');
							}
						}
					?>
				</div>
				<?php }?>
			<?php }} else { ?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php Listingo_Prepare_Notification::listingo_warning(esc_html__('Restricted Access', 'listingo'), esc_html__('You have not any privilege to view this page.', 'listingo')); ?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<div class="modal fade tg-modalmanageteam sp-requestModal" tabindex="-1">
	<div class="modal-dialog tg-modaldialog" role="document">
		<div class="modal-content tg-modalcontent">
			<div class="tg-modalhead">
				<h2><?php esc_html_e('Request to change category', 'listingo');?></h2>
			</div>
			<div class="tg-modalbody">
				<form class="tg-themeform user-request-form">
					<div class="form-group">
						<span class="tg-select">
							<select name="category" class="sp-change-category">
								<option value=""><?php esc_html_e('Select Category', 'listingo'); ?></option>
								<?php listingo_get_categories('', 'sp_categories'); ?>
							</select>
						</span>
					</div>
					<fieldset>
						<textarea name="message" placeholder="<?php esc_html_e('Request Message', 'listingo'); ?>"></textarea>
					</fieldset>
				</form>
			</div>
			<div class="tg-modalfoot">
				<a href="javascript:;" class="tg-btn request-change-category" type="submit"><?php esc_html_e('Request Now', 'listingo'); ?></a>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>