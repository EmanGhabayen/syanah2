<?php
/**
 *
 * The template part to edit ads.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
global $current_user,
 $wp_roles,
 $userdata;
$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (!empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$content = esc_html__('Ad detail will be here', 'listingo');
$placeholder = fw_get_template_customizations_directory_uri() . '/extensions/ads/static/img/thumbnails/placeholder.jpg';
$settings = array('media_buttons' => false,'quicktags' => true);
$edit_id = !empty($_GET['id']) ? intval($_GET['id']) : '';
$post_author = get_post_field('post_author', $edit_id);
$status = get_post_status($edit_id);
$social_links = apply_filters('listingo_get_social_media_icons_list',array());
$price_types	= apply_filters('listingo_get_price_type_list',listingo_ad_price_type());
if (function_exists('fw_get_db_settings_option')) {
    $dir_longitude = fw_get_db_settings_option('dir_longitude');
    $dir_latitude = fw_get_db_settings_option('dir_latitude');
    $dir_longitude = !empty($dir_longitude) ? $dir_longitude : '-0.1262362';
    $dir_latitude = !empty($dir_latitude) ? $dir_latitude : '51.5001524';
} else {
    $dir_longitude = '-0.1262362';
    $dir_latitude = '51.5001524';
}

$business_days = listingo_prepare_business_hours_settings();
$timezones = apply_filters('listingo_time_zones', array()); 
?>
<div id="tg-content" class="tg-content edit-mode spv-ad-modify">
    <div class="tg-dashboardbox tg-businesshours">
        <?php
        if (intval($url_identity) === intval($post_author)) {
            if (isset($status) && $status === 'publish') {
                $args = array('posts_per_page' => '-1',
                    'post_type' => 'sp_ads',
                    'orderby' => 'ID',
                    'post_status' => 'publish',
                    'post__in' => array($edit_id),
                    'suppress_filters' => false
                );

                $query = new WP_Query($args);

                while ($query->have_posts()) : $query->the_post();
                    global $post;
					
					$tagline = '';
					$website = '';
					$phone = '';
					$email = '';
					$currency = '';
					$dbpricing_type = '';
					$price = '';
					$address = '';
					$longitude = '';
					$latitude = '';
					$country = '';
					$city = '';
					$_time_details = array();
				
					if (function_exists('fw_get_db_post_option')) {
						$tagline = fw_get_db_post_option($post->ID, 'tagline', true);
						$website  = fw_get_db_post_option($post->ID, 'website', true);
						$phone  = fw_get_db_post_option($post->ID, 'phone', true);
						$email  = fw_get_db_post_option($post->ID, 'email', true);
						$dbpricing_type = fw_get_db_post_option($post->ID, 'pricing_type', true);
						$price = fw_get_db_post_option($post->ID, 'price', true);
						$currency = fw_get_db_post_option($post->ID, 'currency', true);
						$address = fw_get_db_post_option($post->ID, 'address', true);
						$longitude = fw_get_db_post_option($post->ID, 'longitude', true);
						$latitude  = fw_get_db_post_option($post->ID, 'latitude', true);
						$country  = get_post_meta($post->ID, 'country', true);
						$city = get_post_meta($post->ID, 'city', true);
						$ad_videos = fw_get_db_post_option($post->ID, 'videos', true);
						$gallery = fw_get_db_post_option($post->ID, 'gallery', true);
					}
					
					$time_zone 	   		= get_post_meta($post->ID, '_timezone', true);
					$is_featured 	   	= get_post_meta($post->ID, '_featured_timestamp', true);	

					if( empty( $ad_videos ) ){
						$ad_videos = array(
							0 => ''
						);
					}					
				
					$profile_latitude  = !empty($latitude) ? $latitude : $dir_latitude; 
					$profile_longitude = !empty($longitude) ? $longitude : $dir_longitude;

					$sub_category = get_the_terms( $post->ID, 'ad_category' );
					if( !empty( $sub_category ) ){
						$sub_category = wp_list_pluck($sub_category, 'term_id');
					}
					
				
					$ad_tags = get_the_terms( $post->ID, 'ad_tags' );
					if( !empty( $ad_tags ) ){
						$ad_tags = wp_list_pluck($ad_tags, 'term_id');
					}
				
					$amenities = get_the_terms( $post->ID, 'ad_amenity' );
					if( !empty( $amenities ) ){
						$amenities = wp_list_pluck($amenities, 'term_id');
					}
					
                    ?>
                    <div class="tg-dashboardtitle">
                        <h2><?php esc_html_e('Edit Ad', 'listingo'); ?></h2>
                    </div>
                    <div class="tg-servicesmodal tg-categoryModal">
                    	<div class="tg-modalcontent">
							<form class="tg-themeform tg-formamanagejobs tg-manage-ad-form tg-addad sp-dashboard-profile-form">
								<fieldset>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
											<div class="form-group">
												<input type="text" name="ad[title]" value="<?php the_title();?>" class="form-control" placeholder="<?php esc_html_e('Ad Title', 'listingo'); ?>">
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
											<div class="form-group">
												<?php wp_editor(get_the_content(), 'ad_detail', $settings); ?>
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
													<input type="text" name="ad[tagline]" value="<?php echo esc_attr( $tagline );?>" class="form-control" placeholder="<?php esc_html_e('Ad tagline', 'listingo'); ?>">
												</div>
											</div>
										</div>
									</div>
								</fieldset>
								<fieldset>
									<div class="tg-amenitiesfeaturesbox">
										<div class="tg-dashboardbox tg-basicinformation">
											<h2><?php esc_html_e('Categories', 'listingo'); ?></h2>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
													<div class="form-group">
														<span class="tg-select">
															<select name="ad[categories][]" data-placeholder="<?php esc_html_e('Select categories', 'listingo'); ?>" multiple class="sp-sub-categories">
																<option value=""><?php esc_html_e('Select categories', 'listingo'); ?></option>
																<?php listingo_get_term_options_with_key($sub_category, 'ad_category'); ?>
															</select>
														</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</fieldset>
								<?php do_action('listingo_featured_ad_selection', $user_identity, $edit_id); ?>
								<fieldset>
									<div class="tg-amenitiesfeaturesbox">
										<div class="tg-dashboardbox tg-basicinformation">
											<h2><?php esc_html_e('Tags', 'listingo'); ?></h2>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
													<div class="form-group">
														<span class="tg-select">
															<select name="ad[tags][]" data-placeholder="<?php esc_html_e('Select tags', 'listingo'); ?>" multiple class="sp-sub-categories">
																<option value=""><?php esc_html_e('Select tags', 'listingo'); ?></option>
																<?php listingo_get_term_options_with_key($ad_tags, 'ad_tags'); ?>
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
										<div class="tg-dashboardbox tg-basicinformation">
											<h2><?php esc_html_e('Amenties/Features', 'listingo'); ?></h2>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
													<div class="form-group">
														<span class="tg-select">
															<select name="ad[amenities][]" data-placeholder="<?php esc_html_e('Select amenities', 'listingo'); ?>" multiple class="sp-sub-categories">
																<option value=""><?php esc_html_e('Select amenities', 'listingo'); ?></option>
																<?php listingo_get_term_options_with_key($amenities, 'ad_amenity'); ?>
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
													<input type="text" name="ad[website]" value="<?php echo esc_attr($website);?>" class="form-control" placeholder="<?php esc_html_e('Ad website', 'listingo'); ?>">
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
												<div class="form-group">
													<input type="text" name="ad[email]" value="<?php echo esc_attr($email);?>" class="form-control" placeholder="<?php esc_html_e('Ad email address', 'listingo'); ?>">
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
												<div class="form-group">
													<input type="text" name="ad[phone]" value="<?php echo esc_attr($phone);?>" class="form-control" placeholder="<?php esc_html_e('Ad phone number', 'listingo'); ?>">
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
														$social_val = fw_get_db_post_option($post->ID, $key, true);
													?>
													<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
														<div class="form-group tg-inputwithicon <?php echo esc_attr( $classes );?>">
															<i class="tg-icon <?php echo esc_attr( $icon );?>" style="background:<?php echo esc_attr( $color );?>"></i>
															<input type="text" class="form-control" name="ad[social][<?php echo esc_attr( $key );?>]" value="<?php echo esc_attr( $social_val );?>" placeholder="<?php echo esc_attr( $placeholder );?>">
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
												foreach ($business_days as $key => $days) {
													$db_hours_settings = listingo_get_db_ad_business_settings($post->ID, $key);
													$start_time = !empty($db_hours_settings['starttime']) ? $db_hours_settings['starttime'] : '';
													$end_time = !empty($db_hours_settings['endtime']) ? $db_hours_settings['endtime'] : '';

													$checked = '';
													if (!empty($db_hours_settings['off_day']) && $db_hours_settings['off_day']) {
														$checked = 'checked';
													}
													?>
													<div class="tg-businesshourssbox">
														<div class="form-group">
															<div class="tg-daychckebox">
																<h3><?php echo esc_attr($days); ?></h3>
																<div class="tg-checkbox">
																	<input <?php echo esc_attr($checked); ?> value="true" type="checkbox" name="schedules[<?php echo esc_attr($key); ?>][off_day]" id="<?php echo esc_attr($key); ?>">
																	<label for="<?php echo esc_attr($key); ?>"><?php esc_html_e('Mark As Day Off', 'listingo'); ?></label>
																</div>
															</div>
														</div>
														<div class="time-slot-wrap">
															<div class="tg-startendtime">
																<div class="form-group">
																	<div class="tg-inpuicon">
																		<i class="lnr lnr-clock"></i>
																		<input type="text" value="<?php echo esc_attr($start_time); ?>" name="schedules[<?php echo esc_attr($key); ?>][starttime]" class="form-control business-hours-time" placeholder="<?php esc_html_e('Open Time', 'listingo'); ?>">
																	</div>
																</div>
																<div class="form-group">
																	<div class="tg-inpuicon">
																		<i class="lnr lnr-clock"></i>
																		<input type="text" value="<?php echo esc_attr($end_time); ?>" name="schedules[<?php echo esc_attr($key); ?>][endtime]" class="form-control business-hours-time" placeholder="<?php esc_html_e('Close Time', 'listingo'); ?>">
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
																	<option <?php selected( $dbpricing_type, $key); ?> value="<?php echo esc_attr( $key );?>"><?php echo esc_attr($value['desc']); ?></option>
															<?php }}?>
														</select>
													</span>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
												<div class="form-group">
													<input type="text" value="<?php echo esc_attr($price);?>" name="ad[price]" class="form-control" placeholder="<?php esc_html_e('Ad Price', 'listingo'); ?>">
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
												<div class="form-group">
													<input type="text" value="<?php echo esc_attr($currency);?>" name="ad[currency]" class="form-control" placeholder="<?php esc_html_e('Currency Symbol', 'listingo'); ?>">
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
														<input type="text" name="ad[address]" value="<?php echo esc_attr($address);?>" class="form-control" id="location-address-0" />
														<a href="javascript:;" data-key="fetch" class="geolocate"><img src="<?php echo get_template_directory_uri(); ?>/images/geoicon.svg" width="16" height="16" class="geo-locate-me" alt="<?php esc_html_e('Locate me!', 'listingo'); ?>"></a>
													</div>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
													<p><strong><?php esc_html_e('Important Instructions: The given below latitude and longitude fields are required to show your ad on map. You can simply search location in the above location field and the system will auto detect the latitude, longitude, country and city. If for some reason this does not return the required result, you can manually type in the information.', 'listingo'); ?></strong></p>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
													<div class="form-group">
														<input type="text" placeholder="<?php esc_html_e('Longitude', 'listingo'); ?>" value="<?php echo esc_attr($longitude);?>" name="ad[longitude]" class="form-control" id="location-longitude-0" />
													</div>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
													<div class="form-group">
														<input type="text" placeholder="<?php esc_html_e('Latitude', 'listingo'); ?>" value="<?php echo esc_attr($latitude);?>" name="ad[latitude]" class="form-control" id="location-latitude-0" />
													</div>
												</div>

												<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
													<div class="form-group">
														<span class="tg-select">
															<select name="ad[country]" class="sp-country-select">
																<option value=""><?php esc_html_e('Choose Country', 'listingo'); ?></option>
																<?php listingo_get_term_options($country, 'countries'); ?>
															</select>
														</span>
													</div>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
													<div class="form-group">
														<span class="tg-select">
															<select name="ad[city]" class="sp-city-select">
																<option value=""><?php esc_html_e('Choose City', 'listingo'); ?></option>
																<?php
																	if (!empty($country)) {
																		$country = sanitize_text_field($country);
																		$args = array(
																			'hide_empty' => false,
																			'meta_key' 		=> 'country',
																			'meta_value' 	=> $country
																		);
																		$terms = get_terms('cities', $args);
																		if (!empty($terms)) {
																			foreach ($terms as $key => $term) {
																				$selected = '';
																				if ($city === $term->slug) {
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
																	<?php 
																		if( !empty( $gallery ) ){
																			$gallery_counter	= 0;
																			foreach( $gallery as $key=> $value){
																				$gallery_counter++;
																				$attachment_id	= !empty( $value['attachment_id'] ) ? $value['attachment_id'] : '';
																				if( !empty( $attachment_id ) ){
																					$thumb	= listingo_prepare_image_source($attachment_id,150,150);
																					?>
																					<div class="tg-galleryimg tg-galleryimg-item item-<?php echo esc_attr($attachment_id);?>" data-id="<?php echo esc_attr($attachment_id);?>">
																						<figure>
																							<img src="<?php echo esc_url($thumb); ?>" alt="">
																							<input type="hidden" name="gallery[<?php echo esc_attr($gallery_counter); ?>][attachment_id]" value="<?php echo esc_attr($value['attachment_id']); ?>">
																							<input type="hidden" name="gallery[<?php echo esc_attr($gallery_counter); ?>][url]" value="<?php echo !empty( $value['url'] ) ? esc_attr($value['url']) : ''; ?>">
																							<figcaption>
																								<i class="fa fa-close del-profile-ad-photo"></i>
																							</figcaption>
																						</figure>
																					</div>
																					<?php
																				}
																			}
																		}
																	?>
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
											<span class="tg-note"><?php esc_html_e('Click to', 'listingo'); ?> <strong> <?php esc_html_e('Update Ad Button', 'listingo'); ?> </strong> <?php esc_html_e('to add the ad.', 'listingo'); ?></span>
											<?php wp_nonce_field('listingo_ad_nounce', 'listingo_ad_nounce'); ?>
											<input type="hidden" name="current" value="<?php echo intval($post->ID); ?>">
											<a class="tg-btn process-ad" data-type="update" href="javascript:;"><?php esc_html_e('Update Ad', 'listingo'); ?></a>
										</div>
									</div>
								</fieldset>
							</form>
						</div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            } else {
                ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php Listingo_Prepare_Notification::listingo_warning(esc_html__('Restricted Access', 'listingo'), esc_html__('This ad needs to be approve/publish to update.', 'listingo')); ?>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php Listingo_Prepare_Notification::listingo_warning(esc_html__('Restricted Access', 'listingo'), esc_html__('You have not any privilege to view this page.', 'listingo')); ?>
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
	<div class="tg-galleryimg item-{{data.attachment_id}}" data-id="{{data.attachment_id}}">
		<figure>
			<img src="{{data.thumbnail}}">
			<figcaption>
				<i class="fa fa-close del-profile-ad-photo"></i>
			</figcaption>
			<input type="hidden" class="edit-remove-image" name="temp_items[]" value="{{data.name}}">
		</figure>
	</div>
</script>