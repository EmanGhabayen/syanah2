<?php
/**
 *
 * Author Amenities Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;
$user_identity = $profileuser->ID;
if ( ( $profileuser->roles[0] === 'professional' || $profileuser->roles[0] === 'business' ) ){
	$profile_amenities = get_user_meta($user_identity, 'profile_amenities', true);
	$provider_category	= listingo_get_provider_category($user_identity);
	?>
	<?php if( apply_filters('listingo_is_feature_allowed', $provider_category, 'amenities') === true ){?>
	<div class="tg-dashboardbox tg-amenitiesfeatures">
		<div class="sp-row">
			<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
				<div class="tg-dashboardtitle">
					<h2><?php esc_html_e('Amenities / Features', 'listingo'); ?></h2>
				</div>
				<div class="tg-amenitiesfeaturesbox">
					<div class="form-group">
						<span class="tg-select">
							<select name="amenities" class="sp-amenities-select">
								<option value=""><?php esc_html_e('Select Amenities', 'listingo'); ?></option>
								<?php $amenities = listingo_get_term_options('', 'amenities');?>
							</select>
						</span>
						<button class="tg-btn add_profile_amenities" type="button"><?php esc_html_e('Add Now', 'listingo'); ?></button>
					</div>
					<ul class="tg-tagdashboardlist sp-amenities-wrap">
						<?php
						if (!empty($profile_amenities) && is_array($profile_amenities)) {
							foreach ($profile_amenities as $amenities) {
								$term_data = get_term_by('slug', $amenities, 'amenities');
								?>
								<?php if (!empty($term_data->name)) { ?>
									<li data-amenities-key="<?php echo esc_attr($amenities); ?>">
										<span class="tg-tagdashboard">
											<i class="fa fa-close delete_profile_amenity"></i>
											<em><?php echo esc_attr($term_data->name); ?></em>
										</span>
										<input type="hidden" name="amenities[]" value="<?php echo esc_attr($amenities); ?>">
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
	<script type="text/template" id="tmpl-load-profile-amenities">
		<li data-amenities-key="{{data.ameni_val}}">
			<span class="tg-tagdashboard">
				<i class="fa fa-close delete_profile_amenity"></i>
				<em>{{data.ameni_val}}</em>
			</span>
			<input type="hidden" name="amenities[]" value="{{data.ameni_key}}">
		</li>
	</script>
	<?php }
}