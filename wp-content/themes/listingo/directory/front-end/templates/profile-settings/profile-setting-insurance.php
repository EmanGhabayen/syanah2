<?php
/**
 *
 * The template part for displaying the dashboard profile settings.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */

/* Define Global Variables */
global $current_user,
 $wp_roles,
 $userdata,
 $post;

$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (isset($_GET['identity']) && !empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$provider_category	= listingo_get_provider_category($current_user->ID);
$profile_insurance = get_user_meta($user_identity, 'profile_insurance', true);
$profile_insurance	= !empty( $profile_insurance ) ? array_unique( $profile_insurance ) : array(); 

if( apply_filters('listingo_is_feature_allowed', $provider_category, 'insurance') === true 
    && apply_filters('listingo_is_setting_enabled', $user_identity, 'subscription_insurance') === true
){?>
<div class="tg-dashboardbox tg-insurancefeatures">
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
	<script type="text/template" id="tmpl-load-profile-insurance">
		<li data-insurance-key="{{data.insurance_value}}">
		<span class="tg-tagdashboard">
		<i class="fa fa-close delete_profile_insurance"></i>
		<em>{{data.insurance_value}}</em>
		</span>
		<input type="hidden" name="insurance[]" value="{{data.insurance_key}}">
		</li>
	</script>
</div>       
<?php }
