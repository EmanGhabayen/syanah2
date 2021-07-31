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

if (apply_filters('listingo_is_feature_allowed', $provider_category, 'claims') === true) {
	if (isset($current_user->ID) && 
			$current_user->ID != $author_profile->ID &&
			is_user_logged_in()
	) {
		?>
		<div class="claim-box tg-widget tg-widgetclaim">
			<div class="tg-widgettitle">
				<h3><?php esc_html_e('Report/Claim Form', 'listingo'); ?></h3>
			</div>
			<div class=" tg-widgetcontent sp-claim">
				<form class="tg-themeform claim_form tg-claimform">
					<fieldset>
						<div class="form-group">
							<input type="text" class="form-control" name="subject" placeholder="<?php esc_html_e('Report Subject', 'listingo'); ?>">
						</div>
						<div class="form-group">
							<textarea name="report" class="form-control" placeholder="<?php esc_html_e('Detail', 'listingo'); ?>"></textarea>
						</div>
						<button class="tg-btn tg-btn-lg report_now" type="submit"><?php esc_html_e('Report Now', 'listingo'); ?></button>
						<?php wp_nonce_field('sp_claim', 'security'); ?>
						<input type="hidden" name="user_to" class="user_to" value="<?php echo esc_attr($author_profile->ID); ?>" />
					</fieldset>
				</form>
			</div>
		</div>
	<?php } else if ($current_user->ID != $author_profile->ID) { ?>
		<div class="claim-box tg-widget tg-widgetclaim">
			<a class="tg-btn tg-btn-lg" href="<?php echo esc_url(site_url() . '/authentication/'); ?>">
				<i class="fa fa-exclamation-triangle"></i>
				<?php esc_html_e('Claim This User', 'listingo'); ?>
			</a>
		</div>
		<?php
	}
}

        
       