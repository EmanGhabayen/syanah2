//"use strict";
"use strict";
jQuery(document).on('ready', function ($) {
    var loader_html = '<div class="provider-site-wrap"><div class="provider-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';
    var delete_appointment_type_text = scripts_vars.delete_appointment_type_text;
    var delete_appointment_type_message = scripts_vars.delete_appointment_type_message;
    var delete_appointment_type_reason = scripts_vars.delete_appointment_type_reason;
    var delete_appointment_type_reason_message = scripts_vars.delete_appointment_type_reason_message;
    var sp_appointment_service_msg = scripts_vars.sp_appointment_service_msg;
    var sp_appointment_types_msg = scripts_vars.sp_appointment_types_msg;
    var sp_appointment_reasosns_msg = scripts_vars.sp_appointment_reasosns_msg;
    var sp_appointment_auth = scripts_vars.sp_appointment_auth;
    var sp_appointment_pass = scripts_vars.sp_appointment_pass;
    var sp_appointment_pass_confirm = scripts_vars.sp_appointment_pass_confirm;
    var sp_appointment_pass_match = scripts_vars.sp_appointment_pass_match;
    var approve_appt_type_msg = scripts_vars.approve_appt_type_msg;
    var approve_appt_type = scripts_vars.approve_appt_type;
    var reject_appt_type = scripts_vars.reject_appt_type;
    var reject_appt_type_msg = scripts_vars.reject_appt_type_msg;
    var sp_rejection_title_field = scripts_vars.sp_rejection_title_field;
    var is_loggedin = scripts_vars.is_loggedin;
    var system_error = scripts_vars.system_error;
    var fav_message = scripts_vars.fav_message;
	var complete_fields = scripts_vars.complete_fields;
	var exclude_auth = scripts_vars.exclude_auth;

    /*****************************************
     * Job date picker
     ***************************************/
    jQuery('.expirydate').datetimepicker({
        format: 'd-m-Y',
        datepicker: true,
        timepicker: false,
        minDate: new Date(),
		dayOfWeekStart:scripts_vars.startweekday
    });


    var Appoint_Steps = {};
    Appoint_Steps.booking_step = {};
    window.Appoint_Steps = Appoint_Steps;
    Appoint_Steps.booking_step = 1;

    jQuery(document).on('click', '.bk-step-next', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var data_id = jQuery('.tg-appointmenttabcontent').data('id');

        //Check step 1
        if (Appoint_Steps.booking_step == 1) {

            jQuery('body').append(loader_html);
            var dataString = '&action=listingo_get_appointment_step_two';
            jQuery.ajax({
                type: "POST",
                url: scripts_vars.ajaxurl,
                data: dataString,
                dataType: "json",
                success: function (response) {
					jQuery('.tg-formprogressbar li.tg-active').next().addClass('tg-active');
					if( jQuery('.tg-formprogressbar li.tg-active').hasClass('.first-item') ){
						jQuery('.bk-step-prev').hide();
					} else{
						jQuery('.bk-step-prev').show();
					}
					
                    Appoint_Steps.booking_step = 2;
                    jQuery('.step-two-contents').html(response.data);
                    listingo_appointment_tabs(2);
                    jQuery('.bk-step-2').trigger('click');
                    jQuery('body').find('.provider-site-wrap').remove();
					_this.text(scripts_vars.next);
                }
            });
        } else if (Appoint_Steps.booking_step == 2) {
            var sp_service = jQuery('.sp_service option:selected').val();
            var sp_service_appointment_types = jQuery('.sp_appointment_types option:selected').val();
            var sp_service_appointment_reasosns = jQuery('.sp_appointment_reasons option:selected').val();
            if (sp_service === '' || sp_service == null) {
                jQuery.sticky(sp_appointment_service_msg, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                return false;
            } else if (sp_service_appointment_types === '' || sp_service_appointment_types == null) {
                jQuery.sticky(sp_appointment_types_msg, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                return false;
            } else if (sp_service_appointment_reasosns === '' || sp_service_appointment_reasosns == null) {
                jQuery.sticky(sp_appointment_reasosns_msg, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                return false;
            }
            
			jQuery('body').append(loader_html);
            var dataString = jQuery('.tg-form-appointment-wizard').serialize() + '&action=listingo_get_appointment_step_three';
            jQuery.ajax({
                type: "POST",
                url: scripts_vars.ajaxurl,
                data: dataString,
                dataType: "json",
                success: function (response) {
					jQuery('.tg-formprogressbar li.tg-active').next().addClass('tg-active');
                    Appoint_Steps.booking_step = 3;
                    jQuery('.step-three-contents').html(response.data);
                    listingo_appointment_tabs(3);
                    jQuery('.bk-step-3').trigger('click');
                    jQuery('body').find('.provider-site-wrap').remove();
                }
            });
        } else if (Appoint_Steps.booking_step == 3) {
			
			if( exclude_auth === 'yes' ){
				var dataString = 'action=listingo_get_appointment_step_four';
			} else{
				var appointment_auth = jQuery('input[name="appointment_authenticate"]').val();
				if (appointment_auth === '' || appointment_auth == null) {
					jQuery.sticky(sp_appointment_auth, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
					return false;
				}
				
				var dataString = jQuery('.tg-form-appointment-wizard-auth').serialize() + '&action=listingo_get_appointment_step_four';
			}

            jQuery('body').append(loader_html);
            
            jQuery.ajax({
                type: "POST",
                url: scripts_vars.ajaxurl,
                data: dataString,
                dataType: "json",
                success: function (response) {
                    
                    if (response.type === 'error') {
						jQuery('body').find('.provider-site-wrap').remove();
                        jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                    } else {
						Appoint_Steps.booking_step = 1;
						jQuery('.tg-formprogressbar li.tg-active').next().addClass('tg-active');
                        jQuery('.step-four-contents').html(response.appt_data);
                        listingo_appointment_tabs(4);
                        jQuery('.bk-step-4').trigger('click');
						jQuery('.step-one-contents').remove();
						jQuery('.step-two-contents').remove();
						jQuery('.step-three-contents').remove();
						jQuery('.bk-step-prev').remove();
						jQuery('.bk-step-next').remove();
						
						if (response.mode === 'woo') {
							jQuery('.tg-appointmenttabcontent .tg-btnarea').remove();
							window.location.replace(response.checkout_url);
						} else if (response.mode === 'adaptive') {
							jQuery('body').find('.provider-site-wrap').remove();
						} else{
							jQuery('.go-back-author').text(scripts_vars.finish);
							jQuery('.go-back-author').removeClass('tg-btndontwant').addClass('tg-btn');
							jQuery('body').find('.provider-site-wrap').remove();
						}	
                    }

                }
            });
        }
    });

    /*************************************
     * Appointment Previous Button Code
     ***********************************/
    jQuery(document).on('click', '.bk-step-prev', function () {
		console.log(Appoint_Steps.booking_step);
        if (Appoint_Steps.booking_step == 5) {
            Appoint_Steps.booking_step = 4;
            listingo_appointment_tabs(4);
            jQuery('.bk-step-5').parent('li').removeClass('tg-active active');
        } else if (Appoint_Steps.booking_step == 4) {
            Appoint_Steps.booking_step = 3;
            listingo_appointment_tabs(3);
            jQuery('.bk-step-4').parent('li').removeClass('tg-active active');
        } else if (Appoint_Steps.booking_step == 3) {
            Appoint_Steps.booking_step = 2;
            listingo_appointment_tabs(2);
            jQuery('.bk-step-3').parent('li').removeClass('tg-active active');
        } else if (Appoint_Steps.booking_step == 2) {
            Appoint_Steps.booking_step = 1;
            listingo_appointment_tabs(1);
            jQuery('.bk-step-2').parent('li').removeClass('tg-active active');
			jQuery('.bk-step-next').text(scripts_vars.understand);
			jQuery('.bk-step-prev').hide();
        } else {
			jQuery('.bk-step-prev').hide();
            Appoint_Steps.booking_step = 1;
			jQuery('.bk-step-next').text(scripts_vars.understand);
        }
    });
	
	//adaptive booking process
	jQuery(document).on('click', '.confirm-adaptive-booking', function () {
		jQuery('body').append(loader_html);
		var dataString = jQuery('.adaptive_payment_type').serialize() + '&action=listingo_process_adaptive_payment';
		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: dataString,
			dataType: "json",
			success: function (response) {
				if (response.type === 'error') {
					jQuery('body').find('.provider-site-wrap').remove();
					jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
				} else {
					Appoint_Steps.booking_step = 1;
					window.location.replace(response.checkout_url);
				}

			}
		});
	});
	
});


//Listingo Appointent Tabs Navigation
function listingo_appointment_tabs(current) {
    //Tab Items
    jQuery('.tg-navdocappointment li').removeClass('active');
    var _navitems = jQuery(".tg-navdocappointment li");
    _navitems.each(function (index, li) {
        if (parseInt(index) < parseInt(current)) {
            jQuery(this).addClass('active');
        }
    });

    //Tab Contents
    jQuery('.tg-appointmenttabcontent .tab-pane').hide();

    if (current == 1) {
        jQuery('.tg-appointmenttabcontent .step-one-contents').show();
    } else if (current == 2) {
        jQuery('.tg-appointmenttabcontent .step-two-contents').show();
    } else if (current == 3) {
        jQuery('.tg-appointmenttabcontent .step-three-contents').show();
    } else if (current == 4) {
        jQuery('.tg-appointmenttabcontent .step-four-contents').show();
    } else if (current == 5) {
        jQuery('.tg-appointmenttabcontent .step-five-contents').show();
    }

}
