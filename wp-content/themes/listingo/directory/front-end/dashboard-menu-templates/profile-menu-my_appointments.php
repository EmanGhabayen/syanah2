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

$url_identity = $user_identity;
if (isset($_GET['identity']) && !empty($_GET['identity'])) {
	$url_identity = $_GET['identity'];
}

$dir_profile_page = '';
if (function_exists('fw_get_db_settings_option')) {
	$dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
}

$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
?>
<li class="tg-hasdropdown myappointmentsmenu <?php echo ( $reference === 'myappointments' ? 'tg-active' : ''); ?>">
	<a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'myappointments', $user_identity, ''); ?>">
		<span class="lnr lnr-wheelchair"></span>
		<span><?php esc_html_e('Booked Appointments', 'listingo'); ?></span>
	</a>
</li>