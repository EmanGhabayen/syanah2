<?php
/**
 * Get Author Profile Object
 */
global $wp_query;

$author_profile = $wp_query->get_queried_object();
$db_timezone	= get_user_meta($author_profile->ID, 'default_timezone', true);
$current_time_date = current_time( 'mysql' ); 
$calender_date	= date('Y-m-d',strtotime($current_time_date));
?>
<div class="modal fade tg-appointmentModal" tabindex="-1">
    <div class="modal-dialog tg-modaldialog" role="document">
        <div class="modal-content tg-modalcontent">
            <div class="tg-modalhead">
                <h2><?php esc_html_e('Select Appointment Date', 'listingo'); ?></h2>
            </div>
            <form class="tg-themeform tg-formappointment">
                <div class="tg-modalbody">
                    <div id="tg-datepicker" class="tg-datepicker"></div>
                </div>
                <div class="tg-modalfoot">
                    <h2><?php esc_html_e('Select Appointment Time:', 'listingo'); ?></h2>
                    <div class="tg-availabletimeslotbox">
                        <div class="tg-dateandcount">
                            <time class="app_selected_date" datetime="2017-02-02"><?php echo esc_js(date(get_option('date_format'),strtotime(current_time('mysql'))));?></time>
                        </div>
                        <div class="tg-timeslotsradio">
                            <?php listingo_get_appointment_slots($author_profile->ID,current_time('mysql'), 'echo');?>
                        </div>
                    </div>
                    <div class="tg-btnbox">
                        <?php wp_nonce_field('sp_appointment_settings_nonce', 'appointment-settings-update'); ?>
                        <input type="hidden" name="slot_date" class="time_slot_date" value="">
                        <input type="hidden" name="author_id" value="<?php echo intval($author_profile->ID); ?>">
                        <button class="tg-btn tg-apointment-slots-btn" type="submit"><?php esc_html_e('Start Booking', 'listingo'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$script = "jQuery(document).ready(function(){
            var defaul_date = '" . esc_js( $calender_date ) . "';
	
            jQuery('.tg-appointmentModal').find('.app_selected_date').attr('datetime', defaul_date);
            jQuery('.tg-appointmentModal').find('.time_slot_date').val(defaul_date);
            jQuery('#tg-datepicker').datepicker({
                format: '" . esc_js(date(get_option('date_format'))) . "',
                minDate : 0,
                onSelect: function(dateText, inst) {
                    var _this = jQuery(this);
                    var date  = jQuery(this).val();
					
					var theDate = new Date(Date.parse(jQuery(this).datepicker('getDate')));
					var dateFormatted = jQuery.datepicker.formatDate('yy-mm-dd', theDate);
					
                   _this.parents('.tg-appointmentModal').find('.app_selected_date').text(date);
                   _this.parents('.tg-appointmentModal').find('.app_selected_date').attr('datetime', date);
                   _this.parents('.tg-appointmentModal').find('.time_slot_date').val(dateFormatted);
                   var serialize_data = jQuery('.tg-formappointment').serialize();
                   var dataString = serialize_data + '&action=listingo_appointment_time_slots';
                   jQuery('body').append(loader_html);
                    jQuery.ajax({
                        type: 'POST',
                        url: scripts_vars.ajaxurl,
                        data: dataString,
                        dataType: 'json',
                        success: function (response) {
                            jQuery('body').find('.provider-site-wrap').remove();
                            if(response.type === 'error'){
                                jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                                _this.parents('.tg-appointmentModal').find('.tg-timeslotsradio').html('');
                            }else{
                                _this.parents('.tg-appointmentModal').find('.tg-timeslotsradio').html(response.slot_data);
                            }
                        }
                    });
                }
            });
        });";
wp_add_inline_script('jquery-ui-datepicker', $script, 'after');