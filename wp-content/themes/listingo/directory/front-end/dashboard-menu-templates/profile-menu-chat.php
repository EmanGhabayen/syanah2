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

if ( function_exists('fw_get_db_settings_option') && fw_ext('private-messaging')) { ?>
	<li class="tg-privatemessages tg-hasdropdown <?php echo ( $reference === 'messages' ? 'tg-active' : ''); ?>">
		<a id="tg-btntoggle" class="tg-btntoggle" href="javascript:;">
			<i class="lnr lnr-envelope"></i>
			<span><?php esc_html_e('Private Messages', 'listingo'); ?></span>
			<em class="tg-totalmessages">526</em>
			<em class="tg-newmessages">1</em>
		</a>
		<ul class="tg-emailmenu">
			<li>
				<a href="javascript:;" data-toggle="modal" data-target=".tg-composemsgmodal" data-backdrop="static" data-keyboard="false">
					<span><?php esc_html_e('Compose', 'listingo'); ?></span>
				</a>
			</li>
			<li class="<?php echo ( $mode === 'inbox' ? 'tg-active' : ''); ?>">
				<a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'messages', $user_identity, '', 'inbox'); ?>">
					<span><?php esc_html_e('Inbox', 'listingo'); ?></span>
					<em class="tg-totalmessages">526</em>
					<em class="tg-newmessages">1</em>
				</a>
			</li>
			<li class="<?php echo ( $mode === 'sent' ? 'tg-active' : ''); ?>">
				<a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'messages', $user_identity, '', 'sent'); ?>">
					<span><?php esc_html_e('Sent', 'listingo'); ?></span>
					<em class="tg-totalmessages">370</em>
				</a>
			</li>
			<li class="<?php echo ( $mode === 'trash' ? 'tg-active' : ''); ?>">
				<a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'messages', $user_identity, '', 'trash'); ?>">
					<span><?php esc_html_e('Trash', 'listingo'); ?></span>
					<em class="tg-totalmessages">160</em>
				</a>
			</li>
		</ul>
	</li>
<?php } ?>