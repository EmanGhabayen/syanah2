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

$schedule_time_format 	= isset($author_profile->business_hours_format) ? $author_profile->business_hours_format : '12hour';
$business_hours 	= !empty($author_profile->business_hours) ? $author_profile->business_hours : array();
$business_days 		= listingo_prepare_business_hours_settings();
$db_privacy 		= listingo_get_privacy_settings($author_profile->ID);
$db_timezone		= get_user_meta($author_profile->ID, 'default_timezone', true);

if (!empty($business_hours) 
	&& apply_filters('listingo_is_setting_enabled', $author_profile->ID, 'subscription_business_hours') === true 
	&& ( isset($db_privacy['profile_hours']) && $db_privacy['profile_hours'] === 'on' )
) {
	?>
	<div class="tg-widget tg-widgetbusinesshours" id="section-hours">
		<div class="tg-widgettitle">
			<h3><?php esc_html_e('Business Hours', 'listingo'); ?></h3>
		</div>
		<?php if (!empty($business_days) && is_array($business_days)) {?>
			<div class="tg-widgetcontent">
				<ul>
				<?php
					if (isset($schedule_time_format) && $schedule_time_format === '24hour') {
						$time_format = 'G:i';
					} else {
						$time_format = 'g:i A';
					}

					foreach ($business_days as $key => $days) {
						$db_hours_settings = listingo_get_db_business_settings($author_profile->ID, $key);
						
						//user timezone
						if( !empty( $db_timezone ) )  {									
							$date = new DateTime("now", new DateTimeZone($db_timezone) );
							$current_time_date = $date->format('Y-m-d H:i:s');					
						} else {					  			  	
							$current_time_date = current_time( 'mysql' ); 
						}
						
						//Current Day	
						$current_day 	= '';
						$today_day = date('l', strtotime($current_time_date));
						$today_day = strtolower($today_day);	

						if (strtolower($today_day) === $key) {
							$current_day = 'tg-currentday';
						}
						?>
						<li id="sh-<?php echo esc_attr($key); ?>" class="<?php echo sanitize_html_class($current_day); ?>">
							<span class="tg-dayname"><?php echo esc_attr($days); ?></span>
							<?php
							if (!empty($db_hours_settings['off_day']) && $db_hours_settings['off_day'] === 'on') {
								?>
								<div class="tg-timebox">
									<i class="lnr lnr-lock"></i>
									<time datetime="2017-01-01"><?php esc_html_e('Emergency Only (Closed)', 'listingo'); ?></time>
								</div>
								<?php
							} else {
								if (is_array($db_hours_settings['starttime'])) {

									foreach ($db_hours_settings['starttime'] as $day_key => $hours) {
										$start_time = '';
										$end_time = '';
										$period = '';
										if (!empty($db_hours_settings['starttime'][$day_key]) || !empty($db_hours_settings['endtime'][$day_key])) {
											if (!empty($db_hours_settings['starttime'][$day_key])) {
												$start_time = $db_hours_settings['starttime'][$day_key];
											}

											if (!empty($db_hours_settings['endtime'][$day_key])) {
												$end_time = $db_hours_settings['endtime'][$day_key];
											}

											if (!empty($start_time) || !empty($end_time)) {
												$period = $start_time . '&nbsp;-&nbsp;' . $end_time;
											}

											if (!empty($start_time)) {
												$start_time_formate = date($time_format, strtotime($start_time));
											}


											if (!empty($end_time)) {
												$end_time_formate = date($time_format, strtotime($end_time));
												$end_time_formate = listingo_date_24midnight($time_format, strtotime($end_time));
											}

											if (!empty($start_time_formate) && $end_time_formate) {
												$period = $start_time_formate . ' - ' . $end_time_formate;
											} else if (!empty($start_time_formate)) {
												$period = $start_time_formate;
											} else if (!empty($end_time_formate)) {
												$period = $end_time_formate;
											}
										} else {
											$period = esc_html__('Emergency Only (Closed)', 'listingo');
										}
										?>
										<div class="tg-timebox">
											<i class="lnr lnr-clock"></i>
											<time datetime="2016-10-10"><?php echo esc_attr($period); ?></time>
										</div>
										<?php
									}
								}
							}
							?>
						</li>
						<?php
					}
					?>
				</ul>
			</div>
		<?php } ?>
	</div>
<?php }