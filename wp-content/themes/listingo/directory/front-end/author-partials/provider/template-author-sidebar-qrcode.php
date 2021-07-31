<?php
/**
 *
 * Author Sidebar Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $wp_query, $current_user;
/**
 * Get User Queried Object Data
 */
$author_profile = $wp_query->get_queried_object();
$remove_qr = 'no'; 
if (function_exists('fw_get_db_settings_option')) {
	$remove_qr = fw_get_db_settings_option('remove_qr');
}

if( !empty( $remove_qr ) && $remove_qr === 'no' ){
?>
<div class="tg-widget spv-auth-qrcode"  id="section-qrcode">
	<div class="tg-widgettitle">
		<h3><?php esc_html_e('Get Profile URL', 'listingo'); ?></h3>
	</div>
	<?php do_action('listingo_get_qr_code', 'user', $author_profile->ID );?>
</div>
<?php }
	
