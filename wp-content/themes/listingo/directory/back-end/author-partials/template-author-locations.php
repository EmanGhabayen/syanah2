<?php
/**
 *
 * Author Location Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;
$user_identity = $profileuser->ID;

$profile_latitude  = get_user_meta($user_identity, 'latitude', true);
$profile_longitude = get_user_meta($user_identity, 'longitude', true);
$profile_country   = get_user_meta($user_identity, 'country', true);
$profile_city 	   = get_user_meta($user_identity, 'city', true);
$profile_address   = get_user_meta($user_identity, 'address', true);

if (function_exists('fw_get_db_settings_option')) {
	$dir_longitude  = fw_get_db_settings_option('dir_longitude');
	$dir_latitude   = fw_get_db_settings_option('dir_latitude');
	$dir_longitude	= !empty( $dir_longitude ) ? $dir_longitude : '-0.1262362';
	$dir_latitude	= !empty( $dir_latitude ) ? $dir_latitude : '51.5001524';
} else{
	$dir_longitude  = '-0.1262362';
	$dir_latitude   = '51.5001524';
}

$profile_latitude	=  !empty( $profile_latitude ) ?  $profile_latitude : $dir_latitude;
$profile_longitude	=  !empty( $profile_longitude ) ?  $profile_longitude : $dir_longitude;

?>
<div class="tg-dashboardbox tg-location">
	<div class="sp-row">
		<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
			<div class="tg-dashboardtitle">
				<h2><?php esc_html_e('Location', 'listingo'); ?></h2>
			</div>
			<div class="tg-locationbox">
				<div class="loc-inner-wrap">
					<div class="sp-row">
						<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12">
							<div class="form-group locate-me-wrap">
								<input type="text" value="<?php echo esc_attr($profile_address); ?>" name="basics[address]" class="form-control" id="location-address" />
								<a href="javascript:;" class="geolocate"><img src="<?php echo get_template_directory_uri(); ?>/images/geoicon.svg" width="16" height="16" class="geo-locate-me" alt="<?php esc_html_e('Locate me!', 'listingo'); ?>"></a>
							</div>
						</div>
						<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12">
							<div class="form-group">
								<p class="tg-pleasenone"><strong><?php esc_html_e('Important Instructions: The given below latitude and longitude fields are required to show your profile on map and location search. You can simply search location in the above location field and the system will auto detect the latitude, longitude, country and city. If for some reason this does not return the required result, you can manually type in the information.', 'listingo'); ?></strong></p>
							</div>
						</div>
						<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12">
							<div class="form-group">
								<input type="text" value="<?php echo esc_attr($profile_longitude); ?>" name="basics[longitude]" class="form-control" id="location-longitude" />
							</div>
						</div>
						<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12">
							<div class="form-group">
								<input type="text" value="<?php echo esc_attr($profile_latitude); ?>" name="basics[latitude]" class="form-control" id="location-latitude" />
							</div>
						</div>
						<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
							<div class="form-group">
								<span class="tg-select">
									<select name="basics[country]" class="sp-country-select">
										<option value=""><?php esc_html_e('Choose Country', 'listingo'); ?></option>
										<?php $countries = listingo_get_term_options($profile_country, 'countries'); ?>
									</select>
								</span>
							</div>
						</div>
						<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
							<div class="form-group">
								<span class="tg-select sp-city-wrap">
									<select name="basics[city]" class="sp-city-select">
										<option value=""><?php esc_html_e('Choose City', 'listingo'); ?></option>
										<?php
											if (!empty($profile_country)) {
												$country = esc_attr($profile_country);
												$args = array(
													'hide_empty' => false,
													'meta_key' => 'country',
													'meta_value' => $country
												);
												$terms = get_terms('cities', $args);
												if (!empty($terms)) {
													foreach ($terms as $key => $term) {
														$selected = '';
														if ($profile_city === $term->slug) {
															$selected = 'selected';
														}
														echo '<option ' . esc_attr($selected) . ' value="' . esc_attr($term->slug) . '">' . esc_attr($term->name) . '</option>';
													}
												}
											}
										?>
									</select>
								</span>
							</div>
						</div>
						<div class="sp-data-location">
							<input class="locations-data" data-key="city" type="hidden" value="" placeholder="<?php esc_html_e('City', 'listingo'); ?>" id="locality" disabled="true" />
							<input class="locations-data" data-key="state" type="hidden" value="" placeholder="<?php esc_html_e('State', 'listingo'); ?>" id="administrative_area_level_1" disabled="true" />
							<input class="locations-data" data-key="country" type="hidden" value="" placeholder="<?php esc_html_e('Country', 'listingo'); ?>" id="country" disabled="true" />
							<input class="locations-data" data-key="code" type="hidden" value="" placeholder="<?php esc_html_e('Country Code', 'listingo'); ?>" id="country_code" disabled="true" />
							<input class="locations-data" data-key="postal_town" type="hidden" value="" placeholder="<?php esc_html_e('Postal Town', 'listingo'); ?>" id="postal_town" disabled="true" />
						</div>
						<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12">
							<div id="location-pickr-map" class="location-pickr-map" data-latitude="<?php echo esc_attr( $profile_latitude );?>" data-longitude="<?php echo esc_attr( $profile_longitude );?>"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>