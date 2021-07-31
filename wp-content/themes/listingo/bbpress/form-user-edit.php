<?php

/**
 * bbPress User Profile Edit Part
 *
 * @package bbPress
 * @subpackage Theme
 */
global $current_user;
if (function_exists('fw_get_db_settings_option')) {
	$dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
}

$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
esc_html_e('You can manage your profie here','listingo');
?>
&nbsp;<a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'dashboard', $current_user->ID); ?>"><?php echo esc_html_e('Manage Your Profile','listingo');;?></a>
