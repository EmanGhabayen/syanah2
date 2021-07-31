<?php
/**
 *
 * Business Hours
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;
$user_identity = $profileuser->ID;
if ( ( $profileuser->roles[0] === 'professional' || $profileuser->roles[0] === 'business' ) ){
/* Get Business Hours Settings Array */
$business_days = listingo_prepare_business_hours_settings();
$time_format = get_user_meta($user_identity, 'business_hours_format', true);
?>
	<div class="sp-business-hours-wrap">
		<div class="sp-row">
			<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
				<div class="tg-dashboard tg-dashboarbusinesshours">
					<div class="tg-themeform tg-business-hours-form">
						<fieldset>
							<div class="tg-dashboardbox tg-businesshours">
								<div class="tg-dashboardtitle">
									<h2><?php esc_html_e('Business Hours', 'listingo'); ?></h2>
								</div>
								<?php
								if (!empty($business_days) && is_array($business_days)) {
									foreach ($business_days as $key => $days) {
										$db_hours_settings = listingo_get_db_business_settings($user_identity, $key);
										$checked = '';
										if (!empty($db_hours_settings['off_day']) && $db_hours_settings['off_day'] === 'on') {
											$checked = 'checked';
										}
										?>
										<div class="tg-businesshourssbox">
											<div class="form-group">
												<div class="tg-daychckebox">
													<h3><?php echo esc_attr($days); ?></h3>
													<div class="tg-checkbox">
														<input <?php echo esc_attr($checked); ?> type="checkbox" name="schedules[<?php echo esc_attr($key); ?>][off_day]" id="<?php echo esc_attr($key); ?>">
														<label for="<?php echo esc_attr($key); ?>"><?php esc_html_e('Mark As Day Off', 'listingo'); ?></label>
													</div>
												</div>
											</div>
											<div class="time-slot-wrap"> 
												<?php
												if (is_array($db_hours_settings['starttime'])) {
													foreach ($db_hours_settings['starttime'] as $day_key => $hours) {
														$start_time = !empty($db_hours_settings['starttime'][$day_key]) ? $db_hours_settings['starttime'][$day_key] : '';
														$end_time = !empty($db_hours_settings['endtime'][$day_key]) ? $db_hours_settings['endtime'][$day_key] : '';
														?>
														<div class="tg-startendtime">
															<div class="sp-row">
																<div class="form-group">
																	<i class="lnr lnr-clock"></i>
																	<input type="text" value="<?php echo esc_attr($start_time); ?>" name="schedules[<?php echo esc_attr($key); ?>][starttime][]" class="form-control business-hours-time" placeholder="<?php esc_html_e('Start Time', 'listingo'); ?>">
																</div>
																<div class="form-group">
																	<i class="lnr lnr-clock"></i>
																	<input type="text" value="<?php echo esc_attr($end_time); ?>" name="schedules[<?php echo esc_attr($key); ?>][endtime][]" class="form-control business-hours-time" placeholder="<?php esc_html_e('End Time', 'listingo'); ?>">
																</div>
																<?php if ($day_key > 0) { ?>
																	<button type="button" class="tg-addtimeslot tg-deleteslot delete-time-slot"><i class="lnr lnr-trash"></i></button>
																<?php } else { ?>
																	<button type="button" data-business_day="<?php echo esc_attr($key); ?>" class="tg-addtimeslot add-new-timeslot"><?php echo esc_attr('+'); ?></button>
																<?php } ?>
															</div>
														</div>
														<?php
													}
												}
												?>
											</div>
										</div>
									<?php } ?>
								<?php } ?>
							</div>
							<div class="sp-row">
								<div class="sp-xs-12 sp-sm-12 sp-md-6 sp-lg-6">
									<span class="tg-select row">
										<select name="time_format">
											<option value="12hour" <?php selected( $time_format, '12hour',true); ?>><?php esc_html_e('Show Time in 12-hour clock','listingo'); ?></option>
											<option value="24hour" <?php selected( $time_format, '24hour',true); ?>><?php esc_html_e('Show Time in 24-hour clock','listingo'); ?></option>
										</select>
									</span>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/template" id="tmpl-load-business-hours">
		<div class="tg-startendtime">
			<div class="sp-row">
				<div class="form-group">
					<div class="tg-inpuicon">
						<i class="lnr lnr-clock"></i>
						<input type="text" name="schedules[{{data}}][starttime][]" class="form-control business-hours-time" placeholder="<?php esc_html_e('Start Time', 'listingo'); ?>">
					</div>
				</div>
				<div class="form-group">
					<div class="tg-inpuicon">
						<i class="lnr lnr-clock"></i>
						<input type="text" name="schedules[{{data}}][endtime][]" class="form-control business-hours-time" placeholder="<?php esc_html_e('End Time', 'listingo'); ?>">
					</div>
				</div>
				<button type="button" class="tg-addtimeslot tg-deleteslot delete-time-slot"><i class="lnr lnr-trash"></i></button>
			</div>
		</div>
	</script>
<?php }