<?php
/**
 *
 * Author Payments Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $profileuser, $woocommerce;

if (class_exists('WooCommerce')) {
	$user_identity = $profileuser->ID;
	$current_date = current_time('mysql');
	$today = strtotime($current_date);
	$package_id = listingo_get_subscription_meta('subscription_id', $user_identity);
	$package_expiry = listingo_get_subscription_meta('subscription_expiry', $user_identity);
	$featured_expiry = listingo_get_subscription_meta('subscription_featured_expiry', $user_identity);
	$package_title = !empty($package_id) ? get_the_title($package_id) : esc_html__('No package purchased yet.', 'listingo');
	$roles = $profileuser->roles;
	$package_type = 'provider';
	$is_chat			= listingo_is_chat_enabled();
	$provider_category  = listingo_get_provider_category($user_identity);
	if (!empty($roles[0]) && $roles[0] === 'customer') {
		$package_type = 'customer';
	}
	?>
	<div class="tg-formtheme tg-dashboardbox" id="sp-pkgexpireyandcounter">
		<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6 pull-left">
			<div class="tg-pkgexpireyandcounter">
				<div class="tg-dashboardtitle">
					<h2><?php esc_html_e('Packages Settings', 'listingo'); ?></h2>
				</div>
			</div>
			<div class="tg-dashboardbox tg-languagesbox">
				<div class="tg-packagesbox">
					<?php if( apply_filters('listingo_is_listing_free', false,$user_identity) === false ){?>		
						<div class="tg-pkgexpirey sp-pack-note">
							<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12 pull-left">
								<p><?php esc_html_e('If you want to upgrade/change package then select package from drowdown and update it. Leave it empty to while updating user, otherwise selected package will be updated as user current package.', 'listingo'); ?></p>
								<p><?php esc_html_e('You can also exclude or include number of day from package and featured date.', 'listingo'); ?></p>
							</div>
						</div>
						<div class="tg-pkgexpirey sp-current-pack">
							<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12 pull-left">
								<?php if ( !empty($package_title)) { ?>
									<h3><?php echo esc_attr($package_title); ?></h3>
								<?php } ?>
								<div class="tg-timecounter tg-expireytimecounter">
									<div class="package-expireon">
										<?php if ( !empty($package_expiry) && $package_expiry > $today) { ?>
											<p><?php echo esc_attr(date(get_option('date_format'), $package_expiry)); ?> <?php esc_html_e('at', 'listingo'); ?> <?php echo esc_attr(date('H:i A', $package_expiry)); ?></p>
										<?php } else { ?>
											<?php if ( !empty($package_expiry)) { ?>
												<p><?php esc_html_e('This has expired and expiry date was:', 'listingo'); ?>&nbsp;<strong><?php echo esc_attr(date(get_option('date_format'), $package_expiry)); ?> <?php esc_html_e('at', 'listingo'); ?> <?php echo esc_attr(date(get_option('time_format'), $package_expiry)); ?></strong></p>
											<?php } ?>
										<?php } ?>
									</div>
									<div class="sp-row">
										<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12 pull-left">
											<div class="form-group">
												<p><?php esc_html_e('Add number of days to set/update featured expiry date', 'listingo'); ?></p>
												<input type="text" placeholder="<?php esc_html_e('Add number of days', 'listingo'); ?>" name="package_include" class="form-control" value="" />
											</div>
										</div>
									</div>      
									<?php
										if (!empty($package_type) && $package_type === 'provider') {
											if ( !empty($package_expiry) && $package_expiry > $today) {
												?> 
												<div class="sp-row">
													<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12 pull-left">
														<div class="form-group">
															<p><?php esc_html_e('Or remove specific number of days from package expiry date', 'listingo'); ?></p>
															<input type="text" placeholder="<?php esc_html_e('Exclude number of days', 'listingo'); ?>" name="package_exclude" class="form-control" value="" />
														</div>
													</div>
												</div>            
												<?php
											}
										}
									?>
								</div>
							</div>
						</div>
					<?php } ?>
					<div class="tg-pkgexpirey sp-current-expiry">
						<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12 pull-left">
							<h3><?php esc_html_e('Featured Till', 'listingo'); ?></h3>
							<div class="tg-timecounter tg-expireytimecounter">
								<div class="package-expireon">
									<?php if (!empty( $featured_expiry ) && $featured_expiry > $today) { ?>
										<p><?php echo esc_attr(date(get_option('date_format'), $featured_expiry)); ?> <?php esc_html_e('at', 'listingo'); ?> <?php echo esc_attr(date('H:i A', $featured_expiry)); ?></p>
									<?php } else {?>
										<?php if (!empty( $featured_expiry ) ) { ?>
											<p><?php esc_html_e('This user has excluded from featured listings. Expiry date was:', 'listingo'); ?>&nbsp;<strong><?php echo esc_attr(date(get_option('date_format'), $featured_expiry)); ?> <?php esc_html_e('at', 'listingo'); ?> <?php echo esc_attr(date(get_option('time_format'), $featured_expiry)); ?></strong></p>
										<?php } ?>
									<?php } ?>
								</div>	
								<div class="sp-row">
									<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12 pull-left">
										<div class="form-group">
											<p><?php esc_html_e('Add number of days to set/update featured expiry date', 'listingo'); ?></p>
											<input type="text" placeholder="<?php esc_html_e('Include number of days', 'listingo'); ?>" name="featured_include" class="form-control featured_include" value="" />
										</div>
									</div>
								</div>
								<?php
								if (!empty($package_type) && $package_type === 'provider') {
									if ( !empty( $featured_expiry ) && $featured_expiry > $today) {
										?>
										<div class="sp-row">
											<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12 pull-left">
												<div class="form-group">
													<p><?php esc_html_e('Or remove specific number of days from featured expiry date', 'listingo'); ?></p>
													<input type="text" placeholder="<?php esc_html_e('Exclude number of days', 'listingo'); ?>" name="featured_exclude" class="form-control featured_exclude" value="" />
												</div>
											</div>
										</div>
										<?php
									}
								}
								?>
							</div>
						</div>
					</div>
					<?php if( apply_filters('listingo_is_listing_free', false,$user_identity) === false ){?>		
						<div class="tg-pkgplans tg-pkgplansvtwo">
						<div class="sp-row">
							<?php
							$args = array(
								'post_type' => 'product',
								'posts_per_page' => -1,
								'post_status' => 'publish',
								'ignore_sticky_posts' => 1
							);


							$meta_query_args[] = array(
								'key' => 'sp_package_type',
								'value' => $package_type,
								'compare' => '=',
							);
							$query_relation = array('relation' => 'AND',);
							$meta_query_args = array_merge($query_relation, $meta_query_args);
							$args['meta_query'] = $meta_query_args;
							$packages_options = array();
							$loop = new WP_Query($args);

							if ($loop->have_posts()) {
								while ($loop->have_posts()) : $loop->the_post();
									global $product;
									$sp_duration = get_post_meta($product->get_id(), 'sp_duration', true);
									$sp_jobs = get_post_meta($product->get_id(), 'sp_jobs', true);
									$sp_articles = get_post_meta($product->get_id(), 'sp_articles', true);
									$sp_favorites = get_post_meta($product->get_id(), 'sp_favorites', true);
									$pk_sp_chat 	  = get_post_meta( $product->get_id(), 'sp_chat', true );

									$sp_articles = !empty($sp_articles) ? $sp_articles : 0;
									$sp_jobs = !empty($sp_jobs) ? $sp_jobs : 0;
								
									//Ads
									if ( function_exists('fw_get_db_settings_option') && fw_ext('ads')) {
										$sp_ads_limit = get_post_meta( $product->get_id(), 'sp_ads_limit', true );
										$sp_featured_ads_limit = get_post_meta( $product->get_id(), 'sp_featured_ads_limit', true );
										
										$sp_ads_limit 					= !empty($sp_ads_limit) ? $sp_ads_limit : 0;
										$sp_featured_ads_limit 			= !empty($sp_featured_ads_limit) ? $sp_featured_ads_limit : 0;
										$sp_featured_ads_duration = get_post_meta( $product->get_id(), 'sp_featured_ads_duration', true );
										$sp_featured_ads_duration = !empty( $sp_featured_ads_duration ) ? $sp_featured_ads_duration : 0;
									}
									//Ads
									if (!empty($package_type) && $package_type === 'provider') {
										$sp_featured = get_post_meta($product->get_id(), 'sp_featured', true);
										$sp_appointments = get_post_meta($product->get_id(), 'sp_appointments', true);
										$sp_banner = get_post_meta($product->get_id(), 'sp_banner', true);
										$sp_insurance = get_post_meta($product->get_id(), 'sp_insurance', true);
										$sp_teams = get_post_meta($product->get_id(), 'sp_teams', true);
										$sp_hours = get_post_meta($product->get_id(), 'sp_hours', true);
										$sp_page_design = get_post_meta( $product->get_id(), 'sp_page_design', true ); 
										$sp_contact_information = get_post_meta( $product->get_id(), 'sp_contact_information', true );

										$sp_gallery_photos 	= get_post_meta( $product->get_id(), 'sp_gallery_photos', true );
										$sp_videos 			= get_post_meta( $product->get_id(), 'sp_videos', true );
										$sp_photos_limit 	= get_post_meta( $product->get_id(), 'sp_photos_limit', true );
										$sp_banners_limit	= get_post_meta( $product->get_id(), 'sp_banners_limit', true );

										$sp_gallery_photos  = !empty($sp_gallery_photos) ? $sp_gallery_photos : 0;
										$sp_videos 			= !empty($sp_videos) ? $sp_videos : 0;
										$sp_photos_limit 	= !empty($sp_photos_limit) ? $sp_photos_limit : 0;
										$sp_banners_limit 	= !empty($sp_banners_limit) ? $sp_banners_limit : 0;

									}

									$packages_options[$product->get_id()] = get_the_title();
									?>
									<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-6 pull-left">
										<div class="tg-pkgplan">
											<div class="tg-pkgplanhead">
												<h3><?php the_title(); ?></h3>
												<h4><?php echo force_balance_tags($product->get_price_html()); ?> <em><?php esc_html_e('for', 'listingo'); ?>&nbsp;<?php echo intval($sp_duration); ?>&nbsp;<?php esc_html_e('days', 'listingo'); ?></em></h4>
											</div>
											<ul>
												<?php if ( apply_filters('listingo_get_theme_settings', 'jobs') == 'yes') {?>
													<li><span><?php esc_html_e('Number of job(s)', 'listingo'); ?></span><span><?php echo intval($sp_jobs); ?></span></li>
												<?php }?>

												<?php if( apply_filters('listingo_is_favorite_allowed',$user_identity) === true ){?>
													<li><span><?php esc_html_e('Favorites Listings', 'listingo'); ?></span><span><?php echo listingo_is_feature_support($sp_favorites);?></span></li>
												<?php }?>

												<?php if (!empty($package_type) && $package_type === 'provider') { ?>

													<li><span><?php esc_html_e('Featured listing for', 'listingo'); ?></span><span><?php echo intval($sp_featured); ?>&nbsp;<?php esc_html_e('days', 'listingo'); ?></span></li>

													<?php if( apply_filters('listingo_is_feature_allowed', $provider_category, 'appointments') === true ){?>
														<li><span><?php esc_html_e('Appointments', 'listingo'); ?></span><span><?php echo listingo_is_feature_support($sp_appointments);?></span></li>
													<?php } ?>

													<li><span><?php esc_html_e('Profile Banner', 'listingo'); ?></span><span><?php echo listingo_is_feature_support($sp_banner);?></span></li>

													<?php if( apply_filters('listingo_is_feature_allowed', $provider_category, 'insurance') === true ){?>
														<li><span><?php esc_html_e('Insurance Fields', 'listingo'); ?></span><span><?php echo listingo_is_feature_support($sp_insurance);?></span></li>
													<?php } ?>

													<?php if( apply_filters('listingo_is_feature_allowed', $provider_category, 'teams') === true ){?>
														<li><span><?php esc_html_e('Team Options', 'listingo'); ?></span><span><?php echo listingo_is_feature_support($sp_teams);?></span></li>
													<?php } ?>

													<li><span><?php esc_html_e('Business Hours', 'listingo'); ?></span><span><?php echo listingo_is_feature_support($sp_hours);?></span></li>

													<?php if ( function_exists('fw_get_db_settings_option') && fw_ext('articles')) {?>
														<?php if( apply_filters('listingo_is_feature_allowed', $provider_category, 'articles') === true ){?>
															<li><span><?php esc_html_e('Number of articles', 'listingo'); ?></span><span><?php echo esc_attr($sp_articles); ?></span></li>
														<?php } ?>
													<?php } ?>

													<li><span><?php esc_html_e( 'Page Design','listingo' );?></span><span><?php echo listingo_is_feature_support($sp_page_design);?></span></li>

													<?php if( apply_filters('listingo_is_feature_allowed', $provider_category, 'gallery') === true ){?>
														<li><span><?php esc_html_e( 'Number of gallery photos','listingo' );?></span><span><?php echo esc_attr($sp_gallery_photos);?></span></li>
													<?php } ?>

													<li><span><?php esc_html_e( 'Number of profile photos','listingo' );?></span><span><?php echo esc_attr($sp_photos_limit);?></span></li>
													<li><span><?php esc_html_e( 'Number of banner photos','listingo' );?></span><span><?php echo esc_attr($sp_banners_limit);?></span></li>

													<?php if( apply_filters('listingo_is_feature_allowed', $provider_category, 'videos') === true ){?>
														<li><span><?php esc_html_e( 'Number of video links','listingo' );?></span><span><?php echo esc_attr($sp_videos);?></span></li>
													<?php } ?>

													<?php if ( apply_filters('listingo_is_contact_informations_enabled', 'yes','','') === 'yes') {?>
														<li><span><?php esc_html_e( 'Contact informations','listingo' );?></span><span><?php echo listingo_is_feature_support($sp_contact_information);?></span></li>
													 <?php }?>

												<?php } ?>
												<?php if ( function_exists('fw_get_db_settings_option') && fw_ext('ads')) {?>
													  <li><span><?php esc_html_e( 'Number of ADS','listingo' );?></span><span><?php echo esc_attr($sp_ads_limit);?></span></li>
													  <?php if( $sp_ads_limit > 0 ) {?>
													  	<li><span><?php esc_html_e( 'Featured ADS out of','listingo' );?>&nbsp;<?php echo esc_attr($sp_ads_limit);?></span><span><?php echo esc_attr($sp_featured_ads_limit);?></span></li>
													  <?php } else {?>
													  	<li><span><?php esc_html_e( 'Featured ADS','listingo' );?></span><span><?php echo esc_attr($sp_featured_ads_limit);?></span></li>
													  <?php 
													  } ?>
													  <li><span><?php esc_html_e( 'Featured Ad duration','listingo' );?></span><span><?php echo esc_attr($sp_featured_ads_duration);?></span></li>
													  <?php
												  }
											  	?>
											  	<?php 
												if (( apply_filters('listingo_get_user_type', $user_identity) === 'business' 
													 || apply_filters('listingo_get_user_type', $user_identity) === 'professional' 
													) && ( !empty( $is_chat ) && ( $is_chat === 'paid_providers' || $is_chat === 'paid_all' ) )
												) {?>
												<li><span><?php esc_html_e( 'Private Chat','listingo' );?></span><span><?php echo listingo_is_feature_support($pk_sp_chat);?></span></li>
											  <?php } elseif (( apply_filters('listingo_get_user_type', $user_identity) === 'customer' ) 
															  && ( !empty( $is_chat ) && $is_chat === 'paid_all' )
												) {?>
												<li><span><?php esc_html_e( 'Private Chat','listingo' );?></span><span><?php echo listingo_is_feature_support($pk_sp_chat);?></span></li>
											  <?php }?>	

											</ul>
										</div>
									</div>
									<?php
								endwhile;
							}
							wp_reset_postdata();
							?> 
						</div>
					</div>
					<?php }?>
				</div>
			</div>
			<?php if( apply_filters('listingo_is_listing_free', false,$user_identity) === false ){?>		
			<div class="tg-languagesbox">
				<div class="tg-startendtime">
					<div class="form-group">
						<span class="tg-select">
							<select name="package_id">
								<option value=""><?php esc_html_e('Select Package', 'listingo'); ?></option>
								<?php
								if (!empty($packages_options)) {
									$counter = 0;
									foreach ($packages_options as $key => $pack) {
										echo '<option value="' . $key . '">' . $pack . '</option>';
									}
								}
								?>

							</select>
						</span>
					</div>
					<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12 pull-left"><p><?php esc_html_e('Leave it empty to while updating user, otherwise selected package will be updated as user current package.', 'listingo'); ?></p></div>
				</div>
			</div>
			<?php }?>
		</div>
	</div>
<?php }