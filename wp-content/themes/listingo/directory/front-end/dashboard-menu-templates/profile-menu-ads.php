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
$provider_category = listingo_get_provider_category($user_identity); ?>
	<?php if ( function_exists('fw_get_db_settings_option') && fw_ext('ads')) { ?>
		<li class="tg-privatemessages tg-hasdropdown <?php echo ( $reference === 'ads' ? 'tg-active tg-openmenu' : ''); ?>">
			<a id="tg-btntoggle" class="tg-btntoggle" href="javascript:">
				<i class="lnr lnr-pencil"></i>
				<span><?php esc_html_e('Manage Ads', 'listingo'); ?></span>
				<?php do_action('listingo_get_tooltip','menu','menu_ads');?>
				<em class="tg-totalmessages"><?php echo intval(listingo_get_total_posts_by_user($user_identity)); ?></em>
			</a>
			<ul class="tg-emailmenu">
				<li class="<?php echo ( $mode === 'listing' ? 'tg-active' : ''); ?>">
					<a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'ads', $user_identity, '', 'listing'); ?>">
						<span><?php esc_html_e('Ads listing', 'listingo'); ?></span>
					</a>
				</li>
				<li class="<?php echo ( $mode === 'add' ? 'tg-active' : ''); ?>">
					<a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'ads', $user_identity, '', 'add'); ?>">
						<span><?php esc_html_e('Create New Ad', 'listingo'); ?></span>
					</a>
				</li>
				<li class="<?php echo ( $mode === 'favorite_ads' ? 'tg-active' : ''); ?>">
					<a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'ads', $user_identity, '', 'favorite_ads'); ?>">
						<span><?php esc_html_e('Favorite ads', 'listingo'); ?></span>
					</a>
				</li>
			</ul>
		</li>
	<?php }