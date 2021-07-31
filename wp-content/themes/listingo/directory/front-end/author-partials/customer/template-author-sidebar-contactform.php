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
?>
<div class="tg-widget tg-widgetcontact">
	<div class="tg-widgettitle">
		<h3><?php esc_html_e('Contact Form', 'listingo'); ?></h3>
	</div>
	<div class="tg-widgetcontent">
		<form class="tg-themeform tg-dashboardform">
			<fieldset>
				<div class="form-group">
					<input type="text" class="form-control" name="subject" placeholder="<?php esc_html_e('Your Subject', 'listingo'); ?>">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="name" placeholder="<?php esc_html_e('Your Name', 'listingo'); ?>">
				</div>
				<div class="form-group">
					<input type="email" class="form-control" name="email" placeholder="<?php esc_html_e('Email Address', 'listingo'); ?>">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="phone" placeholder="<?php esc_html_e('Phone', 'listingo'); ?>">
				</div>
				<div class="form-group">
					<textarea class="form-control" name="description" placeholder="<?php esc_html_e('Message', 'listingo'); ?>"></textarea>
				</div>
				<input type="hidden" name="email_to" value="<?php echo esc_attr($author_profile->user_email); ?>" class="form-control">
				<?php wp_nonce_field('sp_dashboard_contact_form', 'security'); ?>
				<button class="tg-btn tg-btn-lg tg-dashboard-form-btn" type="button"><?php esc_html_e('Send Now', 'listingo'); ?></button>
			</fieldset>
		</form>
	</div>
</div>