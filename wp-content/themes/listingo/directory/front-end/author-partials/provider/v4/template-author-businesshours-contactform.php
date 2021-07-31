<?php
/**
 *
 * Author Company Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * Get User Queried Object Data
 */
$author_profile = $wp_query->get_queried_object();
$schedule_time_format 	= isset($author_profile->business_hours_format) ? $author_profile->business_hours_format : '12hour';
$business_hours 	= !empty($author_profile->business_hours) ? $author_profile->business_hours : array();
$business_days 		= listingo_prepare_business_hours_settings();
$db_privacy 			= listingo_get_privacy_settings($author_profile->ID);
$contact_form_sec	= 'col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-6 col-lg-push-3';
?>
<section class="tg-haslayout tg-sectionspacevthree tg-businesshours spv4-businesshours spv-bglight  spv4-section" id="section-hours">
	<div class="container">
		<div class="row">
			<?php if (!empty($business_hours) && apply_filters('listingo_is_setting_enabled', $author_profile->ID, 'subscription_business_hours') === true && ( isset($db_privacy['profile_hours']) && $db_privacy['profile_hours'] === 'on' ) ) {
				$contact_form_sec	= 'col-xs-12 col-sm-12 col-md-4 col-lg-4';
				$total_rows = 1;
				foreach ($business_hours as $day_key => $hours) {
					$temp_rows	= count( $hours['starttime'] );
					if( $total_rows < $temp_rows ){
						$total_rows = $temp_rows;
					}
				}
				
			?>
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				<?php if (!empty($business_days) && is_array($business_days)) {?>
					<div class="tg-sectiontitlevthree">
						<h2><?php esc_html_e('Business Hours', 'listingo'); ?></h2>
					</div>
				<?php
					if (isset($schedule_time_format) && $schedule_time_format === '24hour') {
						$time_format = 'G:i';
					} else {
						$time_format = 'g:i A';
					}

					foreach ($business_days as $key => $days) {
						$db_hours_settings = listingo_get_db_business_settings($author_profile->ID, $key);

						$current_day = '';
						$today_day = date('l');

						if (strtolower($today_day) === $key) {
							$current_day = 'tg-currentday';
						}
					?>
					<ul class="tg-businesshoursholder tg-shiftsdays">
						<li><span><?php echo esc_attr( $days );?></span></li>
						<?php
							if (is_array($db_hours_settings['starttime'])) {
								for( $day_key =0; $day_key < $total_rows; $day_key++) {
									$start_time = '';
									$end_time = '';
									$period = '<span>'.'-'.'</span>';
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
											$period = '<span>'.$start_time_formate . '</span><span>' . $end_time_formate.'</span>';
										} else if (!empty($start_time_formate)) {
											$period = '<span>'.$start_time_formate.'</span>';
										} else if (!empty($end_time_formate)) {
											$period = '<span>'.$end_time_formate.'</span>';
										}
									} else {
										$period = '<span>'.'-'.'</span>';
									}
									?>
									<li><?php echo force_balance_tags($period); ?></li>
									<?php
								}
							}
						?>
					</ul>
				<?php }?>
			</div>
			<?php }}?>
			<?php if (isset($db_privacy['profile_contact']) && $db_privacy['profile_contact'] === 'on') {?>
				<div class="<?php echo esc_attr($contact_form_sec);?>">
					<?php get_template_part('directory/front-end/author-partials/provider/template-author-sidebar', 'contactform'); ?>
				</div>
			<?php }?>
		</div>
	</div>
</section>
