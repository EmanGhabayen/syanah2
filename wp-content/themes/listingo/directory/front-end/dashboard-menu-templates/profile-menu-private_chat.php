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
$is_chat			= listingo_is_chat_enabled($current_user->ID);
$url_identity = $user_identity;
if (isset($_GET['identity']) && !empty($_GET['identity'])) {
	$url_identity = $_GET['identity'];
}

$dir_profile_page = '';
if (function_exists('fw_get_db_settings_option')) {
	$dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
}

$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
							  
if( !empty($is_chat) && $is_chat === 'yes' ){
?>
<li class="<?php echo ( $reference === 'chat' ? 'tg-active' : ''); ?>">
	<a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'chat', $user_identity); ?>">
		<i class="lnr lnr-bubble"></i>
		<span><?php esc_html_e('Inbox', 'listingo'); ?>&nbsp;<em class="wtunread-count"><?php do_action('listingo_chat_count', $user_identity );?></em></span>
	</a>
</li>
<?php }