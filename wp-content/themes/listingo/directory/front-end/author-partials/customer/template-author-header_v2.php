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
        'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 100, 'height' => 100), $author_profile->ID), array('width' => 100, 'height' => 100) //size width,height
);
/* ============Get The User Dashboard Banner==================== */

$user_banner = apply_filters(
        'listingo_get_media_filter', listingo_get_user_banner(array('width' => 0, 'height' => 0), $author_profile->ID), array('width' => 1920, 'height' => 380) //size width,height
);
/* ==================Get Company Name & Tag Line================== */
$user_name = listingo_get_username($author_profile->ID);

?>
<div class="tg-detailpagehead sp-provider-wrap">
	<div class="tg-detailpagehead">
		<figure>
			<img src="<?php echo esc_url($user_banner); ?>" alt="<?php esc_html_e('Banner', 'listingo'); ?>">
		</figure>
		<div class="tg-detailpageheadcontent">
			<?php if (!empty($user_avatar)) { ?>
				<div class="tg-companylogo">
					<img src="<?php echo esc_url($user_avatar); ?>" alt="<?php esc_html_e('Author Avatar', 'listingo'); ?>">
				</div>
			<?php } ?>
			<div class="tg-companycontent">
				<div class="tg-title">
					<?php if (!empty($user_name)) { ?>
						<h1><?php echo esc_attr($user_name); ?></h1>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>