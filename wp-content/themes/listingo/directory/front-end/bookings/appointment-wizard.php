<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $current_user;

//Get user appointment key data meta
$apointment_meta = '';
$author_id = '';
$time_slot = '';
$slot_date = '';
$apointment_meta = get_user_meta($current_user->ID, 'appointment_data', true);

//exclude auth
if (function_exists('fw_get_db_settings_option')) {
	$exclude_auth    = fw_get_db_settings_option('exclude_auth');
}

$exclude_auth		=  !empty( $exclude_auth ) ?  $exclude_auth : 'no';

if( isset( $exclude_auth ) && $exclude_auth === 'yes' ){
	$step_title	= esc_html__('Confirm', 'listingo'); 
} else{
	$step_title	= esc_html__('Code Authentication', 'listingo'); 
}
			
if (!empty($apointment_meta)) {
    $apointment_data = explode("|", $apointment_meta);
    $author_id = !empty($apointment_data[0]) ? $apointment_data[0] : '';
    $time_slot = !empty($apointment_data[1]) ? $apointment_data[1] : '';
    $slot_date = !empty($apointment_data[2]) ? $apointment_data[2] : '';
}

$time_format = get_option('time_format');
$time = explode('-', $time_slot);

$start_time 	= !empty($time[0]) ? rtrim(chunk_split(substr($time[0],-6),2,':'),':')  : '';
$end_time 		= !empty($time[1]) ? rtrim(chunk_split(substr($time[1],-6),2,':'),':') : '';
$format_time = date($time_format, strtotime('01-01-2020 '.$start_time)).'&nbsp;-&nbsp;'.date($time_format, strtotime('01-01-2020 '.$end_time));

$change_format = date_i18n('D, M d', strtotime($slot_date));
$dob_format    = listingo_get_dob_format($slot_date, 'return');

$formatted_date = sprintf('%s %s%s%s %s %s', $change_format, '(',$dob_format,')', esc_html__('At', 'listingo'), $format_time);

//check if already booked
$is_available	= listingo_check_booked_slot($time_slot,$slot_date,$author_id);
?>
<div class="tg-appointmentsetting">
    <fieldset class="booking-model-contents">
        <?php if( isset( $is_available['available'] ) && $is_available['available'] === 'yes' ){?>
        <div class="tg-appointmenthead">
            <div class="tg-appointmentheading">
                <h2><?php echo esc_attr($formatted_date); ?></h2>
            </div>
        </div>
        <div class="tg-progressbox">
            <ul class="tg-formprogressbar tg-navdocappointment" role="tablist">
                <li class="tg-active first-item"><a href="javascript:;" class="bk-step-1"><?php esc_html_e('Instructions', 'listingo'); ?></a></li>
                <li><a href="javascript:;" class="bk-step-2"><?php esc_html_e('Your Detail', 'listingo'); ?></a></li>
                <li><a href="javascript:;" class="bk-step-3"><?php echo esc_attr($step_title); ?></a></li>
                <li><a href="javascript:;" class="bk-step-4"><?php esc_html_e('All Done', 'listingo'); ?></a></li>
            </ul>

            <div class="tab-content tg-appointmenttabcontent" data-id="<?php echo intval($author_id); ?>">
                <div class="tab-pane active step-one-contents" id="one">
                    <?php listingo_get_appointment_step_one($author_id, 'echo'); ?>
                </div>
                <div class="tab-pane step-two-contents" id="two"></div>
                <div class="tab-pane step-three-contents" id="three"></div>
                <div class="tab-pane step-four-contents" id="four"></div>
                <div class="tg-btnarea">
                    <button type="button" class="tg-btn bk-step-prev" style="display: none"><?php esc_html_e('Previous', 'listingo'); ?></button>
                    <a href="javascript:;" class="tg-btn tg-btnnext bk-step-next"><?php esc_html_e('I Understand!', 'listingo'); ?></a>
                    <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="tg-btndontwant go-back-author"><?php esc_html_e('No I Don\'t Want', 'listingo'); ?></a>
                </div>
            </div>
        </div>
        <?php } else{?>
        	<div class="tg-dashboardappointmentbox">
				<?php Listingo_Prepare_Notification::listingo_info(esc_html__('Information', 'listingo'), esc_html__('Sorry! This slot is not available for booking.', 'listingo')); ?>
			</div>
        <?php }?>
    </fieldset>
</div>