<?php
/**
 *
 * Author Languages Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;
if ( ( $profileuser->roles[0] === 'professional' || $profileuser->roles[0] === 'business' ) ){
	$user_identity = $profileuser->ID;
	$profile_languages = array();
	$profile_languages  = get_user_meta($user_identity, 'profile_languages', true);

	?>
	<div class="tg-dashboardbox tg-languages sp-dashboard-profile-form">
		<div class="sp-row">
			<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
				<div class="tg-dashboardtitle">
					<h2><?php esc_html_e('Languages', 'listingo'); ?></h2>
				</div>
				<div class="tg-languagesbox">
					<div class="form-group">
						<span class="tg-select">
							<select name="languages" class="sp-language-select">
								<option value=""><?php esc_html_e('Select Language', 'listingo'); ?></option>
								<?php listingo_get_term_options('', 'languages'); ?>
							</select>
						</span>
						<button class="tg-btn add_profie_language" type="button"><?php esc_html_e('Add Now', 'listingo'); ?></button>
					</div>
					<ul class="tg-tagdashboardlist sp-languages-wrap">
						<?php
						if (!empty($profile_languages)) {
							foreach ($profile_languages as $language) {
								$term_data = get_term_by('slug', $language, 'languages');
								?>
								<?php if (!empty($term_data->name)) { ?>
									<li data-language-key="<?php echo esc_attr($language); ?>">
										<span class="tg-tagdashboard">
											<i class="fa fa-close delete_profile_lang"></i>
											<em><?php echo esc_attr($term_data->name); ?></em>
										</span>
										<input type="hidden" name="languages[]" value="<?php echo esc_attr($language); ?>">
									</li>
								<?php } ?>
								<?php
							}
						}
						?>
					</ul>
				</div>
				<script type="text/template" id="tmpl-load-profile-languages">
					<li data-language-key="{{data.lang_val}}">
						<span class="tg-tagdashboard">
							<i class="fa fa-close delete_profile_lang"></i>
						<em>{{data.lang_val}}</em>
						</span>
						<input type="hidden" name="languages[]" value="{{data.lang_key}}">
					</li>
				</script>
			</div>
		</div>
	</div>
<?php }