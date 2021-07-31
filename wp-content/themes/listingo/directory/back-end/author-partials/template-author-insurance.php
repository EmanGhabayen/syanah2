<?php
/**
 *
 * Author Insurance Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;
if ( ( $profileuser->roles[0] === 'professional' || $profileuser->roles[0] === 'business' ) ){
	$user_identity = $profileuser->ID;
	$profile_insurance = get_user_meta($user_identity, 'profile_insurance', true);
	$provider_category	= listingo_get_provider_category($user_identity);

	if( apply_filters('listingo_is_feature_allowed', $provider_category, 'insurance') === true 
			 && apply_filters('listingo_is_setting_enabled', $user_identity, 'subscription_insurance') === true
	){?>
	<div class="tg-dashboardbox tg-insurancefeatures">
		<div class="sp-row">
			<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
				<div class="tg-dashboardtitle">
					<h2><?php esc_html_e('Insurance', 'listingo'); ?></h2>
				</div>
				<div class="tg-amenitiesfeaturesbox sp-insurancefeaturesbox">
					<div class="form-group">
						<span class="tg-select">
							<select name="insurance" class="sp-insurance-select">
								<option value=""><?php esc_html_e('Select Insurance', 'listingo'); ?></option>
								<?php $insurance = listingo_get_term_options('', 'insurance'); ?>
							</select>
						</span>
						<button class="tg-btn add_profile_insurance" type="button"><?php esc_html_e('Add Now', 'listingo'); ?></button>
					</div>
					<ul class="tg-tagdashboardlist sp-insurance-wrap">
						<?php
						if (!empty($profile_insurance)) {
							foreach ($profile_insurance as $insurance) {
								$term_data = get_term_by('slug', $insurance, 'insurance');
								?>
								<?php if (!empty($term_data->name)) { ?>
									<li data-insurance-key="<?php echo esc_attr($insurance); ?>">
										<span class="tg-tagdashboard">
											<i class="fa fa-close delete_profile_amenity"></i>
											<em><?php echo esc_attr($term_data->name); ?></em>
										</span>
										<input type="hidden" name="insurance[]" value="<?php echo esc_attr($insurance); ?>">
									</li>
								<?php } ?>
								<?php
							}
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<script type="text/template" id="tmpl-load-profile-insurance">
		<li data-insurance-key="{{data.insurance_value}}">
			<span class="tg-tagdashboard">
				<i class="fa fa-close delete_profile_insurance"></i>
				<em>{{data.insurance_value}}</em>
			</span>
			<input type="hidden" name="insurance[]" value="{{data.insurance_key}}">
		</li>
	</script>
	<?php }
}