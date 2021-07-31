<?php
/**
 *
 * The template part to add new ad.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 */
global $current_user;
$user_identity = $current_user->ID;
$content = esc_html__('Add your ad content here.', 'listingo');
$settings = array('media_buttons' => false,'quicktags' => true);

$ad_limit = 0;
if (function_exists('fw_get_db_settings_option')) {
	$ad_limit = fw_get_db_settings_option('ad_limit');
}

$ad_limit 			= !empty( $ad_limit ) ? $ad_limit  : 0;
$remaining_ads 		= listingo_get_subscription_meta('subscription_ads', $user_identity);

$remaining_ads 	= !empty( $remaining_ads ) ? $remaining_ads  : 0;
$remaining_ads 	= $remaining_ads + $ad_limit; //total in package and one free
$posted_ads		= listingo_get_total_posts_by_user($user_identity,'sp_ads');

$social_links 	= apply_filters('listingo_get_social_media_icons_list',array());
$price_types	= apply_filters('listingo_get_price_type_list',listingo_ad_price_type());

//location 
$profile_latitude  	= get_user_meta($user_identity, 'latitude', true);
$profile_longitude 	= get_user_meta($user_identity, 'longitude', true);

if (function_exists('fw_get_db_settings_option')) {
    $dir_longitude = fw_get_db_settings_option('dir_longitude');
    $dir_latitude = fw_get_db_settings_option('dir_latitude');
    $dir_longitude = !empty($dir_longitude) ? $dir_longitude : '-0.1262362';
    $dir_latitude = !empty($dir_latitude) ? $dir_latitude : '51.5001524';
} else {
    $dir_longitude = '-0.1262362';
    $dir_latitude = '51.5001524';
}

$profile_latitude 	= !empty($profile_latitude) ? $profile_latitude : $dir_longitude;
$profile_longitude 	= !empty($profile_longitude) ? $profile_longitude : $dir_latitude;
$business_days 		= listingo_prepare_business_hours_settings();
$timezones 			= apply_filters('listingo_time_zones', array()); 

$ad_videos = array(
        0 => ''
    );
?>
<div id="tg-content" class="tg-content spv-ad-modify">
    <div class="tg-dashboardbox tg-businesshours">
        <div class="tg-dashboardtitle">
            <h2><?php esc_html_e('Post an ad', 'listingo'); ?></h2>
        </div>
        <?php if ( isset($remaining_ads) && $remaining_ads > $posted_ads ) { ?>
        <div class="tg-servicesmodal tg-categoryModal">
            <div class="tg-modalcontent">
                <form class="tg-themeform tg-formamanagejobs tg-manage-ad-form tg-addad sp-dashboard-profile-form">
                    <fieldset>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                                <div class="form-group">
                                    <input type="text" name="ad[title]" class="form-control" placeholder="<?php esc_html_e('Ad Title', 'listingo'); ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                                <div class="form-group">
                                    <?php wp_editor($content, 'ad_detail', $settings); ?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                      	<div class="tg-amenitiesfeaturesbox">
							<div class="tg-dashboardtitle"><h2><?php esc_html_e('Tagline', 'listingo'); ?></h2></div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
									<div class="form-group">
										<input type="text" name="ad[tagline]" class="form-control" placeholder="<?php esc_html_e('Ad tagline', 'listingo'); ?>">
									</div>
								</div>
							</div>
						</div>
                    </fieldset>
                    <fieldset>
                        <div class="tg-dashboardbox tg-basicinformation">
							<div class="tg-amenitiesfeaturesbox">
								<h2><?php esc_html_e('Categories', 'listingo'); ?></h2>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
										<div class="form-group">
											<span class="tg-select">
												<select name="ad[categories][]" data-placeholder="<?php esc_html_e('Select categories', 'listingo'); ?>" multiple class="sp-sub-categories">
													<option value=""><?php esc_html_e('Select categories', 'listingo'); ?></option>
													<?php listingo_get_term_options_with_key('', 'ad_category'); ?>
												</select>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </fieldset>
                    <?php do_action('listingo_featured_ad_selection', $user_identity, ''); ?>      
                    <fieldset>
                        <div class="tg-dashboardbox tg-basicinformation">
							<div class="tg-amenitiesfeaturesbox">
								<h2><?php esc_html_e('Tags', 'listingo'); ?></h2>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
										<div class="form-group">
											<span class="tg-select">
												<select name="ad[tags][]" data-placeholder="<?php esc_html_e('Select tags', 'listingo'); ?>" multiple class="sp-sub-categories">
													<option value=""><?php esc_html_e('Select tags', 'listingo'); ?></option>
													<?php listingo_get_term_options_with_key('', 'ad_tags'); ?>
												</select>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </fieldset>
                    <fieldset>
                        <div class="tg-dashboardbox tg-basicinformation">
							<div class="tg-amenitiesfeaturesbox">
								<h2><?php esc_html_e('Amenties/Features', 'listingo'); ?></h2>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
										<div class="form-group">
											<span class="tg-select">
												<select name="ad[amenities][]"  data-placeholder="<?php esc_html_e('Select amenities', 'listingo'); ?>" multiple class="sp-sub-categories">
													<option value=""><?php esc_html_e('Select amenities', 'listingo'); ?></option>
													<?php listingo_get_term_options_with_key('', 'ad_amenity'); ?>
												</select>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </fieldset>
                    <fieldset>
                      	<div class="tg-amenitiesfeaturesbox">
							<h2><?php esc_html_e('Contact informations', 'listingo'); ?></h2>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
									<div class="form-group">
										<input type="text" name="ad[website]" class="form-control" placeholder="<?php esc_html_e('Ad website', 'listingo'); ?>">
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
									<div class="form-group">
										<input type="text" name="ad[email]" class="form-control" placeholder="<?php esc_html_e('Ad email address', 'listingo'); ?>">
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
									<div class="form-group">
										<input type="text" name="ad[phone]" class="form-control" placeholder="<?php esc_html_e('Ad phone number', 'listingo'); ?>">
									</div>
								</div>
							</div>
                   		</div>
                    </fieldset>
                    <fieldset>
                        <div class="tg-socialinformation tg-amenitiesfeaturesbox spv-ad-hours">
                        	<div class="tg-dashboardtitle">
								<h2><?php esc_html_e('Social Links', 'listingo'); ?></h2>
								<span class="spv-collap-config"><i class="lnr lnr-pencil"></i></span>
							</div>
							<div class="spv-ads-config tg-haslayout elm-none">
								<div class="row tg-socialinformationbox">
									<?php 
									if( !empty( $social_links ) ){
										foreach( $social_links as $key => $social ){
											$icon		= !empty( $social['icon'] ) ? $social['icon'] : '';
											$classes	= !empty( $social['classses'] ) ? $social['classses'] : '';
											$placeholder		= !empty( $social['placeholder'] ) ? $social['placeholder'] : '';
											$color		= !empty( $social['color'] ) ? $social['color'] : '#484848';
										?>
										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
											<div class="form-group tg-inputwithicon <?php echo esc_attr( $classes );?>">
												<i class="tg-icon <?php echo esc_attr( $icon );?>" style="background:<?php echo esc_attr( $color );?>"></i>
												<input type="text" class="form-control" name="ad[social][<?php echo esc_attr( $key );?>]" value="" placeholder="<?php echo esc_attr( $placeholder );?>">
											</div>
										</div>
									<?php }}?>
								</div>
                 			</div>
                  		</div>
                    </fieldset>                
                 	<fieldset>
						<div class="tg-amenitiesfeaturesbox spv-ad-hours">
							<div class="tg-dashboardtitle">
								<h2><?php esc_html_e('Business Hours', 'listingo'); ?></h2>
								<span class="spv-collap-config"><i class="lnr lnr-pencil"></i></span>
							</div>
							<div class="spv-ads-config tg-haslayout elm-none">
								<div class="tg-haslayout spv-timezone">
									<div class="tg-dashboardtitle">
										<h2><?php esc_html_e('Timezone', 'listingo'); ?></h2>
										<p><?php esc_html_e('You can set timezone for this add. Leave it empty to use default timezone from Profile Settings.', 'listingo'); ?></p>
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
											<div class="form-group">
												<?php if( !empty( $timezones ) ) {?>
												<span class="tg-select">
													<select name="_timezone" class="_timezone">
														<?php								
														foreach ($timezones as $key => $value) { 
															if( $time_zone == $key ){
																$selected = 'selected';
															} else {
																$selected = '';
															}	
														?>
														<option value="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_attr( $value ); ?></option>
														<?php } ?>
													</select>									
												</span>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
								<?php
								if (!empty($business_days) && is_array($business_days)) {
									foreach ($business_days as $key => $days) {?>
										<div class="tg-businesshourssbox">
											<div class="form-group">
												<div class="tg-daychckebox">
													<h3><?php echo esc_attr($days); ?></h3>
													<div class="tg-checkbox">
														<input type="checkbox" value="true" name="schedules[<?php echo esc_attr($key); ?>][off_day]" id="<?php echo esc_attr($key); ?>">
														<label for="<?php echo esc_attr($key); ?>"><?php esc_html_e('Mark As Day Off', 'listingo'); ?></label>
													</div>
												</div>
											</div>
											<div class="time-slot-wrap"> 
												<div class="tg-startendtime">
													<div class="form-group">
														<div class="tg-inpuicon">
															<i class="lnr lnr-clock"></i>
															<input type="text" value="" name="schedules[<?php echo esc_attr($key); ?>][starttime]" class="form-control business-hours-time" placeholder="<?php esc_html_e('Open Time', 'listingo'); ?>">
														</div>
													</div>
													<div class="form-group">
														<div class="tg-inpuicon">
															<i class="lnr lnr-clock"></i>
															<input type="text" value="" name="schedules[<?php echo esc_attr($key); ?>][endtime]" class="form-control business-hours-time" placeholder="<?php esc_html_e('Close Time', 'listingo'); ?>">
														</div>
													</div>	
												</div>	
											</div>
										</div>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
					</fieldset>                     
                    <fieldset>
                      	<div class="tg-amenitiesfeaturesbox">
							<h2><?php esc_html_e('Ad Pricings', 'listingo'); ?></h2>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
									<div class="form-group">
										<span class="tg-select">
											<select name="ad[pricing_type]">
												<option value=""><?php esc_html_e('Select pricing options', 'listingo'); ?></option>
												<?php if( !empty( $price_types ) ) {
														foreach( $price_types as $key => $value ){?>
													<option value="<?php echo esc_attr( $key );?>"><?php echo esc_attr($value['desc']); ?></option>
												<?php }}?>
											</select>
										</span>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
									<div class="form-group">
										<input type="text" name="ad[price]" class="form-control" placeholder="<?php esc_html_e('Ad Price', 'listingo'); ?>">
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
									<div class="form-group">
										<input type="text" name="ad[currency]" class="form-control" placeholder="<?php esc_html_e('Currency Symbol', 'listingo'); ?>">
									</div>
								</div>
							</div>
                   		</div>
                    </fieldset>
                    <fieldset>
                    	<div class="tg-dashboardbox tg-videogallery">
							<div class="tg-videogallerybox">
								<div class="tg-dashboardtitle">
									<h2><?php esc_html_e('Audio/Video', 'listingo'); ?></h2>
								</div>
								<div class="video-slot-wrap">
									<?php
									if (!empty($ad_videos)) {
										$video_count = 0;
										foreach ($ad_videos as $key => $media) {
											$video_count++;
											?>
											<div class="tg-startendtime">
												<div class="form-group">
													<div class="tg-inpuicon">
														<i class="lnr lnr-film-play"></i>
														<input type="text" value="<?php echo esc_url($media); ?>" name="ad[videos][]" class="form-control" placeholder="<?php esc_html_e('Audio/Video Link', 'listingo'); ?>">
													</div>
												</div>
												<?php if ($video_count === 1) { ?>
													<button type="button" class="tg-addtimeslot add-new-videoslot">+</button>
												<?php } else { ?>
													<button type="button" class="tg-addtimeslot tg-deleteslot delete-video-slot"><i class="lnr lnr-trash"></i></button>
												<?php } ?>
											</div>
											<?php
										}
									}
									?>
								</div>
							</div>
						</div>
                    </fieldset>
                    <fieldset>
                    	<div class="tg-dashboardbox tg-location">
							<div class="tg-dashboardtitle">
								<h2><?php esc_html_e('Location', 'listingo'); ?><?php do_action('listingo_get_tooltip','section','location');?></h2>
							</div>
							<div class="tg-locationbox">
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
										<div class="form-group locate-me-wrap">
											<input type="text" value="" name="ad[address]" class="form-control" id="location-address-0" />
											<a href="javascript:;" data-key="fetch" class="geolocate"><img src="<?php echo get_template_directory_uri(); ?>/images/geoicon.svg" width="16" height="16" class="geo-locate-me" alt="<?php esc_html_e('Locate me!', 'listingo'); ?>"></a>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
										<p><strong><?php esc_html_e('Important Instructions: The given below latitude and longitude fields are required to show your ad on map. You can simply search location in the above location field and the system will auto detect the latitude, longitude, country and city. If for some reason this does not return the required result, you can manually type in the information.', 'listingo'); ?></strong></p>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
										<div class="form-group">
											<input type="text" placeholder="<?php esc_html_e('Longitude', 'listingo'); ?>" value="" name="ad[longitude]" class="form-control" id="location-longitude-0" />
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
										<div class="form-group">
											<input type="text" placeholder="<?php esc_html_e('Latitude', 'listingo'); ?>" value="" name="ad[latitude]" class="form-control" id="location-latitude-0" />
										</div>
									</div>

									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
										<div class="form-group">
											<span class="tg-select">
												<select name="ad[country]" class="sp-country-select">
													<option value=""><?php esc_html_e('Choose Country', 'listingo'); ?></option>
													<?php listingo_get_term_options('', 'countries'); ?>
												</select>
											</span>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
										<div class="form-group">
											<span class="tg-select">
												<select name="ad[city]" class="sp-city-select">
													<option value=""><?php esc_html_e('Choose City', 'listingo'); ?></option>
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
									<div class="col-md-12 col-sm-12 col-xs-12 pull-left">
										<div class="form-group">
											<div id="location-pickr-map" class="location-pickr-map"></div>
										</div>
									</div>

									<?php
										$script = "jQuery(document).ready(function (e) {
													jQuery.listingo_init_profile_map(0,'location-pickr-map', ". esc_js($profile_latitude) . "," . esc_js($profile_longitude) . ");
												});";
										wp_add_inline_script('listingo_maps', $script, 'after');
									?>
								</div>
							</div>
						</div>
                    </fieldset>
                    <fieldset>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                                <div class="tg-dashboardbox tg-imggallery">
									<div class="tg-dashboardtitle">
										<h2><?php esc_html_e('Gallery', 'listingo'); ?></h2>
									</div>
									<div class="tg-imggallerybox">
										<div class="tg-upload">
											<div class="tg-uploadhead">
												<span>
													<h3><?php esc_html_e('Upload Photo Gallery', 'listingo'); ?></h3>
													<i class="fa fa-exclamation-circle"></i>
												</span>
												<i class="lnr lnr-upload"></i>
											</div>
											<div class="tg-box">
												<label class="tg-fileuploadlabel" for="tg-photogallery">
													<div id="plupload-ad-container">
														<a href="javascript:;" id="upload-ad-photos" class="tg-fileinput sp-upload-container">
															<i class="lnr lnr-cloud-upload"></i>
															<span><?php esc_html_e('Or Drag Your Files Here To Upload', 'listingo'); ?></span>
														</a>
													</div> 
												</label>
												<div class="tg-ad sp-profile-ad-photos">
													<div class="tg-galleryimages">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div id="tg-updateall" class="tg-updateall">
                            <div class="tg-holder">
                                <span class="tg-note"><?php esc_html_e('Click to', 'listingo'); ?> <strong> <?php esc_html_e('Submit Ad Button', 'listingo'); ?> </strong> <?php esc_html_e('to add the ad.', 'listingo'); ?></span>
                                <?php wp_nonce_field('listingo_ad_nounce', 'listingo_ad_nounce'); ?>
                                <a class="tg-btn process-ad" data-type="add" href="javascript:;"><?php esc_html_e('Submit Ad', 'listingo'); ?></a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <?php } else { ?>
            <div class="tg-dashboardappointmentbox">
                <?php Listingo_Prepare_Notification::listingo_info(esc_html__('Oops', 'listingo'), esc_html__('You reached to maximum limit of ads post. Please upgrade your package to add more ads.', 'listingo')); ?>
            </div>
        <?php } ?>
    </div>
</div>
<script type="text/template" id="tmpl-load-media-links">
	<div class="tg-startendtime">
	<div class="form-group">
	<div class="tg-inpuicon">
	<i class="lnr lnr-film-play"></i>
	<input type="text" name="ad[videos][]" class="form-control" placeholder="<?php esc_html_e('Audio/Video Link', 'listingo'); ?>">
	</div>
	</div>
	<button type="button" class="tg-addtimeslot tg-deleteslot delete-video-slot"><i class="lnr lnr-trash"></i></button>
	</div>
</script>
<script type="text/template" id="tmpl-load-profile-ad-thumb">
	<div class="tg-galleryimg">
		<figure>
			<img src="{{data.thumbnail}}">
			<figcaption>
				<i class="fa fa-close del-profile-ad-photo"></i>
			</figcaption>
			<input type="hidden" name="temp_items[]" value="{{data.name}}">
		</figure>
	</div>
</script>