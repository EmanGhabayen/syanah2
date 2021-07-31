<?php
/**
 *
 * The template part for displaying the dashboard business hours.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();

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

$time_format = get_user_meta($user_identity, 'business_hours_format', true);
/* Get Business Hours Settings Array */
$business_days = listingo_prepare_business_hours_settings();
?>
<div id="tg-content" class="tg-content">
    <div class="tg-dashboard tg-dashboarbusinesshours">
        <form class="tg-themeform tg-business-hours-form">
            <fieldset>
                <div class="tg-dashboardbox tg-businesshours">
                    <div class="tg-dashboardtitle">
                        <h2><?php esc_html_e('Business Hours', 'listingo'); ?><?php do_action('listingo_get_tooltip','section','business_hour');?></h2>
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
                                                <div class="form-group">
                                                    <div class="tg-inpuicon">
                                                        <i class="lnr lnr-clock"></i>
                                                        <input type="text" value="<?php echo esc_attr($start_time); ?>" name="schedules[<?php echo esc_attr($key); ?>][starttime][]" class="form-control business-hours-time" placeholder="<?php esc_html_e('Start Time', 'listingo'); ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="tg-inpuicon">
                                                        <i class="lnr lnr-clock"></i>
                                                        <input type="text" value="<?php echo esc_attr($end_time); ?>" name="schedules[<?php echo esc_attr($key); ?>][endtime][]" class="form-control business-hours-time" placeholder="<?php esc_html_e('End Time', 'listingo'); ?>">
                                                    </div>
                                                </div>
                                                <?php if ($day_key > 0) { ?>
                                                    <button type="button" class="tg-addtimeslot tg-deleteslot delete-time-slot"><i class="lnr lnr-trash"></i></button>
                                                <?php } else { ?>
                                                    <button type="button" data-business_day="<?php echo esc_attr($key); ?>" class="tg-addtimeslot add-new-timeslot"><?php echo esc_attr('+'); ?></button>
                                                <?php } ?>
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
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<span class="tg-select row">
						<select name="time_format">
							<option value="12hour" <?php selected( $time_format, '12hour',true); ?>><?php esc_html_e('Show Time in 12-hour clock','listingo'); ?></option>
							<option value="24hour" <?php selected( $time_format, '24hour',true); ?>><?php esc_html_e('Show Time in 24-hour clock','listingo'); ?></option>
						</select>
					</span>
				</div>
                <div id="tg-updateall" class="tg-updateall">
                    <div class="tg-holder">
                        <span class="tg-note"><?php esc_html_e('Click to','listingo'); ?> <strong> <?php esc_html_e('Update Now Button', 'listingo'); ?> </strong> <?php esc_html_e('to update the latest added detail.', 'listingo'); ?></span>
                        
                        <?php wp_nonce_field('listingo_business_hours_nonce', 'dashboard-business-hours'); ?>
                        <a class="tg-btn update-business-hours" href="javascript:;"><?php esc_html_e('Update Now', 'listingo'); ?></a>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<!----------------------------------------------------
* Underscore Templates
----------------------------------------------------->
<script type="text/template" id="tmpl-load-business-hours">
    <div class="tg-startendtime">
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
</script>