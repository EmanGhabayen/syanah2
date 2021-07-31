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
$profile_amenities = get_user_meta($user_identity, 'profile_amenities', true);
$profile_amenities	= !empty( $profile_amenities ) ? array_unique( $profile_amenities ) : array(); 
?>
<?php if( apply_filters('listingo_is_feature_allowed', $provider_category, 'amenities') === true ){?>
<div class="tg-dashboardbox tg-amenitiesfeatures">
	<div class="tg-dashboardtitle">
		<h2><?php esc_html_e('Amenities / Features', 'listingo'); ?><?php do_action('listingo_get_tooltip','section','amenities');?></h2>
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
			if (!empty($profile_amenities) && is_array( $profile_amenities )) {
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
	<script type="text/template" id="tmpl-load-profile-amenities">
		<li data-amenities-key="{{data.ameni_val}}">
		<span class="tg-tagdashboard">
		<i class="fa fa-close delete_profile_amenity"></i>
		<em>{{data.ameni_val}}</em>
		</span>
		<input type="hidden" name="amenities[]" value="{{data.ameni_key}}">
		</li>
	</script>
</div>
<?php }?>
                