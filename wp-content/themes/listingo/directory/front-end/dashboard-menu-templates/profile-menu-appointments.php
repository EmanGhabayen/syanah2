<?php
/**
 *
 * The template part for displaying the dashboard menu
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */

global $current_user, $wp_roles, $userdata, $post;

$reference 		 = (isset($_GET['ref']) && $_GET['ref'] <> '') ? $_GET['ref'] : '';
$mode 			 = (isset($_GET['mode']) && $_GET['mode'] <> '') ? $_GET['mode'] : '';
$user_identity 	 = $current_user->ID;
$bk_settings	 = listingo_get_booking_settings();

$url_identity = $user_identity;
if (isset($_GET['identity']) && !empty($_GET['identity'])) {
	$url_identity = $_GET['identity'];
}

$dir_profile_page = '';
$insight_page = '';
if (function_exists('fw_get_db_settings_option')) {
	$dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
	$insight_page = fw_get_db_settings_option('insight_page', $default_value = null);
}

$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
$provider_category = listingo_get_provider_category($user_identity);

if (apply_filters('listingo_is_setting_enabled', $user_identity, 'subscription_appointments') === true 
	&& apply_filters('listingo_do_check_user_type', $user_identity) === true
	&& apply_filters('listingo_is_feature_allowed', $provider_category, 'appointments') === true
) {
	?>
	<li class="tg-hasdropdown <?php echo ( $reference === 'appointment' ? 'tg-active tg-openmenu' : ''); ?>">
		<a id="tg-btntoggle" class="tg-btntoggle" href="javascript:">
			<i class="lnr lnr-calendar-full"></i>
			<span><?php esc_html_e('Manage Appointments', 'listingo'); ?></span>
			<?php do_action('listingo_get_tooltip','menu','menu_appointments');?>
		</a>
		<ul class="tg-emailmenu">
			<li class="<?php echo ( $mode === 'appointments' ? 'tg-active' : ''); ?>">
				<a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'appointment', $user_identity, '', 'appointments'); ?>">
					<span><?php esc_html_e('Appointments', 'listingo'); ?></span>
				</a> 
			</li>
			<li class="<?php echo ( $mode === 'appointment_schedules' ? 'tg-active' : ''); ?>">
				<a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'appointment', $user_identity, '', 'appointment_schedules'); ?>">
					<span><?php esc_html_e('Appointment Schedules', 'listingo'); ?></span>
				</a>
			</li>
			<li class="<?php echo ( $mode === 'appointment_settings' ? 'tg-active' : ''); ?>">
				<a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'appointment', $user_identity, '', 'appointment_settings'); ?>">
					<span><?php esc_html_e('Appointment Settings', 'listingo'); ?></span>
				</a>
			</li>
		</ul>
	</li>
<?php }