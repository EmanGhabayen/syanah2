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

$provider_category 		= listingo_get_provider_category($author_profile->ID);
$profile_brochure 	= !empty($author_profile->profile_brochure) ? $author_profile->profile_brochure : array();

if (!empty($profile_brochure['file_data']) && apply_filters('listingo_is_feature_allowed', $provider_category, 'brochures') === true) { ?>
	<div class="tg-widget tg-widgetbrochure">
		<div class="tg-widgettitle">
			<h3><?php esc_html_e('Download Brochure', 'listingo'); ?></h3>
		</div>
		<div class="tg-widgetcontent">
			<?php
			foreach ($profile_brochure['file_data'] as $key => $value) {
				if (!empty($value['file_title']) || !empty($value['file_relpath'])) {
					?>
					<a download class="tg-btndownload" href="<?php echo esc_url($value['file_relpath']); ?>">
						<?php if (!empty($value['file_icon'])) { ?>
							<i class="<?php echo esc_attr($value['file_icon']); ?>"></i>
						<?php } ?>
						<?php if (!empty($value['file_title'])) { ?>
							<span><?php echo esc_attr($value['file_title']); ?></span>
						<?php } ?>
						<i class="lnr lnr-download"></i>
					</a>
					<?php
				}
			}
			?>
		</div>
	</div>
<?php } ?>