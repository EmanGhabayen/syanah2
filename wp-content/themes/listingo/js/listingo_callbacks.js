"use strict";
var is_end = true;
var review_pagi		= 2;
var signin_reset;
var signup_reset;
var signup_reset_provider;
var password_forgot;
var password_reset;
var recaptcha_reset;
jQuery(document).on('ready', function () {
	/* -------------------------------------
	 Theme Loader
	 -------------------------------------- */
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
	var calendar_locale	   = scripts_vars.calendar_locale;
	var loading_duration	   = scripts_vars.loading_duration;
	var tip_content_bg	   = scripts_vars.tip_content_bg;
	var tip_content_color  = scripts_vars.tip_content_color;
	var tip_title_bg	   = scripts_vars.tip_title_bg;
	var tip_title_color	   = scripts_vars.tip_title_color;
	var cache_title	   	   = scripts_vars.cache_title;
	var cache_message	   = scripts_vars.cache_message;
	var placeholder_text_multiple	   = scripts_vars.placeholder_text_multiple;
	var no_results_text	   = scripts_vars.no_results_text;
	var current_user_id	   = scripts_vars.current_user_id;
	var placeholder_text_single = scripts_vars.placeholder_text_single;
	
	//Reset 
	jQuery(document).on('click', '.tg-reset-apt a', function(e) {
		e.preventDefault(); 
        var _this    	  = jQuery(this);
		jQuery('.set_appt_date').val('');
		jQuery('.sp-sortby').prop('selectedIndex',0);
		jQuery('.sp-orderby').prop('selectedIndex',0);
		jQuery('.sp-showposts').prop('selectedIndex',0);
		jQuery('.sp-appointment-status').prop('selectedIndex',0);
		_this.parents('.tg-dashboardappointmentsetting').find('form').submit();
	});
	
	//Submit load more reviews
	jQuery(document).on('click', '.loadmore-reviews', function(e){
		e.preventDefault(); 
        var _this    	  = jQuery(this);  
		var _author_id    = _this.data('id');
		jQuery('body').append(loader_html);
		
		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: {
				action		 	: 'listingo_get_more_reviews',
				page			: review_pagi,
				author_id		: _author_id
			},
			dataType: "json",
			success: function (response) {
				jQuery('body').find('.provider-site-wrap').remove();
				
				if (response.type === 'success') {
					review_pagi++;
					jQuery('.review-wrap').append(response.reviews);
				} else {
					jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
					jQuery('.loadmore-reviews').hide();
				}
			}
		});	
	});
	
	//GET QR Code
    jQuery(document).on('click', '.tg-qrcodedetails', function (e) {
        e.preventDefault();
        jQuery('body').append(loader_html);
            var _this = jQuery(this);
            var id = _this.data('key'); 
            var type = _this.data('type');  
            var dataString = 'key=' + id + '&type=' + type + '&action=listingo_generate_qr_code';   
            jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
            jQuery('body').find('.provider-site-wrap').remove();
            if (response.type === 'success') {  
                jQuery('.tg-qr-img').attr('src', response.key);
                jQuery('.tg-qrscan figcaption').remove();
            } else {
                jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
            }
        }
        });
    });
	
	//ask for location
	if ( window.navigator.geolocation ) {
		window.navigator.geolocation.getCurrentPosition(
			function(pos) {
				jQuery.cookie("geo_location", pos.coords.latitude+"|"+pos.coords.longitude, { expires : 365 });
			}
		);
	}
	
	//toggle filters
	jQuery(document).on('click', '.spv-menu  a[href^="#"]', function(e) {
       var id = $(this).attr('href');

		// target element
		var _id = jQuery(id);
		if (_id.length === 0) {
			return;
		}
		
		e.preventDefault();
		if( scripts_vars.navfixed == 'yes' ){
			var pos = _id.offset().top - 175;
		} else{
			var pos = _id.offset().top;
		}
        
		
		// animated top scrolling
		jQuery('body, html').animate({scrollTop: pos},1000);
	});
	
	//toggle filters
	jQuery('.tg-advancedlink').on('click', function(event){	
		var _this = jQuery(this);
		event.preventDefault();
		_this.siblings('.tg-filtertype').slideToggle();
	});
	
	//switch view
	jQuery(document).on('click','.switch-view', function(event){
		var _this = jQuery(this);
		var _key	= _this.data('key');
		jQuery('#current-view').val(_key);
		_this.parents('form.sp-form-search').submit();
	});
	
	//status change
	jQuery(document).on('click', '.status-current', function (e) {
		e.preventDefault();
        var _this = jQuery(this);
		var _id = _this.data('key');
        var dataString = 'key=' + _id + '&action=listingo_update_profile_status';
		_this.addClass('sploading');
		
		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: dataString,
			dataType: "json",
			success: function (response) {
				if (response.type === 'success') {
					//do nothing
					jQuery('.spprofile-statuswrap').removeClass('away offline online busy sphide').addClass(_id);
					jQuery('.spprofile-statuswrap .spactive-status span').removeClass().addClass(_id);
					jQuery('.status-current').removeClass('status-selected sploading');
					_this.addClass('status-selected');
					
				} else {
					//do nothing
				}
			}
		});
	});
	
	/*
     * @renew package
     * @return{}
     */
    jQuery(document).on('click', '.renew-package', function (e) {
        e.preventDefault();
        var _this = jQuery(this);

        var _id = _this.data('key');
        var dataString = 'id=' + _id + '&action=listingo_update_cart';

        jQuery.confirm({
            'title': scripts_vars.order,
            'message': scripts_vars.order_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        jQuery('body').append(loader_html);

                        jQuery.ajax({
                            type: "POST",
                            url: scripts_vars.ajaxurl,
                            data: dataString,
                            dataType: "json",
                            success: function (response) {
                                if (response.type === 'success') {
                                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
                                    window.location.replace(response.checkout_url);
                                } else {
                                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                                }
                            }
                        });
                    }
                },
                'No': {
                    'class': 'gray',
                    'action': function () {
                        return false;
                    }	// Nothing to do in this case. You can as well omit the action property.
                }
            }
        });
    });
	
	//Mailchimp newsletter
	jQuery(document).on('click', '.subscribe_me', function (event) {
		event.preventDefault();
		var _this = jQuery(this);
		jQuery('body').append(loader_html);

		jQuery.ajax({
			type: 'POST',
			url: scripts_vars.ajaxurl,
			data: _this.parents('.signup-newletter').serialize() + '&action=listingo_subscribe_mailchimp',
			dataType: "json",
			success: function (response) {
				jQuery('body').find('.provider-site-wrap').remove();
				if (response.type == 'success') {
					 jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
					_this.parents('.signup-newletter').get(0).reset();

				} else {
					jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000, });
				}
			}
		});
	});
	
	//Toolip init
	function tipso_init(){
		if(jQuery('.sp-data-tipso').length > 0){
			jQuery('.sp-data-tipso').tipso({
				tooltipHover	  : true,
				useTitle		  : false,
				background        : tip_content_bg,
				titleBackground   : tip_title_bg,
				color             : tip_content_color,
				titleColor        : tip_title_color,
			});
		}
	}
	
	tipso_init();
	
	//Parralax issue
	jQuery(window).trigger('resize.px.parallax');
	
	//get sub categories.
    jQuery(document).on('change', '.sp-category', function (event) {
        event.preventDefault();
        var _this = jQuery(this);
        var _id = jQuery('.sp-category').val();
        jQuery('body').append(loader_html);

        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: 'id=' + _id + '&action=listingo_get_terms_by_post',
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();

                if (response.type == 'success') {
                    jQuery('.sp-sub-category').html(response.options);
					exlude_empty_options();
					jQuery('.sp-sub-category').trigger("chosen:updated");
					
                }
            }
        });
    });
	
	//registration categopry multi select
	jQuery(".sp-register-ms").chosen({placeholder_text_multiple:placeholder_text_multiple});
	
	//Reset password Ajax
    jQuery('.do-reset-form').on('click', '.do-reset-button', function (event) {
        event.preventDefault();
        var _this = jQuery(this);
        var _pass = jQuery('.do-reset-form').find('.resetnew').val();

        jQuery('body').append(loader_html);

        if (_pass === '') {
            jQuery('body').find('.provider-site-wrap').remove();
            jQuery.sticky(scripts_vars.password_require, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
            return false;
        }

        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: jQuery('.do-reset-form').serialize() + '&action=listingo_ajax_reset_password',
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                if (response.type == 'success') {
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
                    jQuery('.do-reset-form').get(0).reset();
                    window.location.replace(response.redirect_url);
                    if (scripts_vars.captcha_settings === 'enable') {
                        grecaptcha.reset(password_reset);
                    }
                } else {
                    if (scripts_vars.captcha_settings === 'enable') {
                        grecaptcha.reset(password_reset);
                    }
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });
    });
	
	//Generate Appointment time slots link
    jQuery(document).on('click', '.tg-apointment-slots-btn', function (e) {
        e.preventDefault();

        var serialize_data = jQuery('.tg-formappointment').serialize();
        var dataString = serialize_data + '&action=listingo_appointmnet_slot_link';
		jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                if (response.type == 'success') {
                    window.setTimeout(function () {
                        window.location.href = response.appointment_link;
                    }, 3000);
                } else {
					jQuery('body').find('.provider-site-wrap').remove();
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });
    });

	
	//Submit Review
    jQuery(document).on('click', '.review-submit-btn', function () {
        jQuery('body').append(loader_html);
        //Submit Review
        var serialize_data = jQuery('.tg-formleavefeedback').serialize();
        var dataString = serialize_data + '&action=listingo_make_review';

        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                if (response.type == 'success') {
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
					window.location.reload();
                } else {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });
    });
	
	//@Report User Claim functionality
	jQuery('.sp-claim').on('click', '.report_now', function (e) {
        e.preventDefault();
        var _this = jQuery(this);

        jQuery('body').append(loader_html);
        var serialize_data = jQuery('.claim_form').serialize();
        var dataString = serialize_data + '&action=listingo_submit_claim';

        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                _this.find('i').remove();
                if (response.type == 'success') {
                    jQuery('body').find('.provider-site-wrap').remove();
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
                    _this.parents('.doc-claim').find('.claim_form').get(0).reset();
                } else {
                    jQuery('body').find('.provider-site-wrap').remove();
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });

        return false;
    });
	
	// Load Cities by selecting the Countries
    jQuery(".sp-country-select").chosen().change(function () {
        var _this = jQuery(this);
        var country = _this.val();
		   
        if (country != 0) {
            var dataString = 'country=' + encodeURIComponent( country ) + '&action=listingo_find_cities';
			
			if( jQuery("body").hasClass('sp-provider-dashboard')){
            	jQuery('body').append(loader_html);
			}
			
            jQuery.ajax({
                type: "POST",
                url: scripts_vars.ajaxurl,
                data: dataString,
                dataType: "json",
                success: function (response) {
                    jQuery('body').find('.provider-site-wrap').remove();
                    if (response.type == 'error') {
                        jQuery(".sp-city-select").html('');
                        jQuery(".sp-city-select").val('').trigger("chosen:updated");
                    } else {
                        jQuery(".sp-city-select").html(response.cities_data);
                        jQuery(".sp-city-select").val('').trigger("chosen:updated");
                    }
                }
            });
        }
    });
	
	jQuery(".sp-city-select").chosen({
        no_results_text: no_results_text, 
        placeholder_text_single:placeholder_text_single
    });
	//calendar locale
	if( calendar_locale  && calendar_locale != null){
		jQuery.datetimepicker.setLocale(calendar_locale);
		moment.locale(calendar_locale);
	}
	
	//Google Connect
	jQuery(document).on('click', '.update-gallery-meta', function (event) {
		event.preventDefault();
		var _this = jQuery(this);
		
		var _id		= _this.data('id');
		var _title	= _this.parents('.tg-modalcontent').find('.meta-title').val();
		var _link	= _this.parents('.tg-modalcontent').find('.meta-link').val();
		
		jQuery('body').append(loader_html);
		
		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: 'id='+_id+'&title='+_title+'&link='+_link+'&action=listingo_update_gallery_meta',
			dataType: "json",
			success: function (response) {
				jQuery('body').find('.provider-site-wrap').remove();
				if (response.type == 'success') {
					jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
				} else {
					jQuery('body').find('.provider-site-wrap').remove();
					jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
				}
			}
		});
	});
	
	//Detail page Sorting
	jQuery(".sp-content-sort, .sp-sidebar-sort").sortable({
		delay: 300,
		opacity: 0.6,
		update: function() {
			var serialize_data = jQuery('.sp-sorting-form').serialize();
			jQuery('body').append(loader_html);
			var dataString = serialize_data+'&action=listingo_update_provider_page_sorting';
			jQuery.ajax({
				type: "POST",
				url: scripts_vars.ajaxurl,
				data: dataString,
				dataType: "json",
				success: function (response) {
					jQuery('body').find('.provider-site-wrap').remove();
					if (response.type == 'success') {
						jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
					} else {
						jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
					}
					
				}
			});
		}
	});
	
	//Google Connect
	jQuery(document).on('click', '.sp-googl-connect', function (event) {
		event.preventDefault();
		var _this = jQuery(this);
		jQuery('body').append(loader_html);
		
		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: '&action=listingo_google_connect',
			dataType: "json",
			success: function (response) {
				if (response.type == 'success') {
					jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
					window.location.replace(response.authUrl);
				} else {
					jQuery('body').find('.provider-site-wrap').remove();
					jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
				}
			}
		});
	});
	
	//facebook Connect
	jQuery(document).on('click', '.sp-fb-connect', function (event) {
		event.preventDefault();
		var _this = jQuery(this);
		jQuery('body').append(loader_html);
		
		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: '&action=listingo_fb_connect',
			dataType: "json",
			success: function (response) {
				if (response.type == 'success') {
					jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
					window.location.replace(response.authUrl);
				} else {
					jQuery('body').find('.provider-site-wrap').remove();
					jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
				}
			}
		});
	});
	
	//activate profile page view
    jQuery('.activate-detail-page').on('click', '.current-active', function (event) {
        event.preventDefault();
		var _this = jQuery(this);
		
		jQuery('.current-active').find('input[type=radio]').prop('checked', false); // Checks it
		_this.find('input[type=radio]').prop('checked', true); // Checks it

        jQuery('body').append(loader_html);
        var _activate = _this.parents('form.do-activate-style').serialize();

        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: _activate + '&action=listingo_activate_profile_page',
            dataType: "json",
            success: function (response) {
				jQuery('body').find('.provider-site-wrap').remove();
                if (response.type == 'success') {
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
					window.location.reload();
                } else {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
				return false;
            }
        });
    });
	
	//Social registration Ajax
    jQuery(document).on('click', '.do-complete-profile', function (event) {
        event.preventDefault();
        var _this = jQuery(this);

        jQuery('body').append(loader_html);
        var _authenticationform = _this.parents('form.do-complete-form').serialize();

        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: _authenticationform + '&action=listingo_complete_profile',
            dataType: "json",
            success: function (response) {
                if (response.type == 'success') {
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
					jQuery('form.do-complete-form').get(0).reset();
					 window.location.replace(response.redirect);
                } else {
					jQuery('body').find('.provider-site-wrap').remove();
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });
    });
	
	//Menu dropdown
	function collapseMenu() {
		jQuery('.menu-item-has-children, .page_item_has_children').prepend('<span class="tg-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>');
		jQuery('.menu-item-has-children span , .page_item_has_children span').on('click', function () {
			jQuery(this).next().next().slideToggle(300);
			jQuery(this).parent('.menu-item-has-children, .page_item_has_children').toggleClass('tg-open');
		});
	}
	collapseMenu();
	
	//Show email on click in listings
	var _clickelement = jQuery('ul.tg-companycontactinfo li span a, ul.tg-contactinfo li span a');
	_clickelement.one('click',function(){
		return false;
	}).click(function(){
		var _this	=  jQuery(this);
		var _last	= _this.parents('span').data('last');
		_this.find('em').text(_last);
	});
	
	
	/*
	 * @Map Sticky in Parent
	 * @return{}
	 */
	if(jQuery("#tg-mapclustring").length > 0){
		var _tg_mapclustring = jQuery("#tg-mapclustring");
		if( scripts_vars.navfixed == 'yes' ){
			_tg_mapclustring.stick_in_parent({
				offset_top: 72,
			});
		} else{
			_tg_mapclustring.stick_in_parent({
				offset_top: 0,
			});
		}
	}

	//Choosen Category
	jQuery(".sp-caetgory-select").chosen();
	jQuery(".chosen-lang-select").chosen();
	jQuery(".chosen-insurance-select").chosen();
	jQuery(".tg-bannertabs .sp-sub-categories").chosen();
	jQuery(".sp-change-category").chosen();
	jQuery("._timezone").chosen();
	jQuery(".sp-sub-categories").chosen();
	
	

	/* -------------------------------------
			REFINE SEARCH TOGGLE
	-------------------------------------- */
	var _tg_btnadvancefilters = jQuery('#tg-btnadvancefilters');
	_tg_btnadvancefilters.on('click', function(event) {
		event.preventDefault();
		jQuery('.tg-advancedfilters').slideToggle(1000);
	});
	
	
	/* -------------------------------------
	 PRETTY PHOTO GALLERY
	 -------------------------------------- */
	jQuery("a[data-rel]").each(function () {
		jQuery(this).attr('rel', jQuery(this).data('rel'));
	});
	jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
		animation_speed: 'normal',
		theme: 'dark_square',
		slideshow: 3000,
		autoplay_slideshow: false,
		social_tools: false
	});	
	/* -------------------------------------
	 DASHBOARD LEFT NAV TOGGLE
	 -------------------------------------- */
	jQuery('.tg-btntoggle').on('click', function (event) {
		event.preventDefault();
		var _this = jQuery(this);
		_this.parents('li').toggleClass('tg-openmenu');
		_this.parents('li').find('.tg-emailmenu').slideToggle('slow');
	});
	
	jQuery(window).load(function() {
		jQuery( '.tg-active.tg-openmenu' ).find('.tg-emailmenu').slideToggle('slow');
	});
	
	//geo dropdown
	jQuery(document).on('click', '.geodistance', function (event) {
		event.preventDefault();
		var _this	= jQuery(this);
		_this.next('.geodistance_range').toggle();
	});
	
	//Toggles accordions
	jQuery(function() {
		jQuery('.tg-panelcontent').hide();
		jQuery('.tg-accordion').find('div.tg-accordionheading:first').addClass('active').next().slideDown('slow');
		jQuery('.tg-accordion div.tg-accordionheading').on('click',function() {
			var _this	= jQuery(this);
			if(_this.next().is(':hidden')) {
				_this.parents('.tg-accordion ').find('div.tg-accordionheading').removeClass('active').next().slideUp('slow');
				_this.toggleClass('active').next().slideDown('slow');
			}
		});
	});

	jQuery('.tg-themescrollbar, .tg-emailnavscroll').mCustomScrollbar({
		axis: "y",
		autoHideScrollbar: true,
	});
	jQuery('.tg-horizontalthemescrollbar').mCustomScrollbar({
		axis: "x",
	});

	/* ---------------------------------------
	 Add to favorites
	 --------------------------------------- */
	jQuery(document).on('click', '.add-to-fav', function (event) {
		event.preventDefault();

		if (is_loggedin == 'false') {
			jQuery.sticky(fav_message, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000});
			return false;
		}

		var _this = jQuery(this);
		var wl_id = _this.data('wl_id');
		jQuery('body').append(loader_html);

		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: 'wl_id=' + wl_id + '&action=listingo_update_wishlist',
			dataType: "json",
			success: function (response) {
				jQuery('body').find('.provider-site-wrap').remove();

				if (response.type == 'success') {
					
					jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
					if( response.undo === 'yes' ){
						_this.addClass('add-to-fav');
						_this.removeClass('tg-dislike');
					} else{
						_this.addClass('tg-dislike');
					}
					
				} else {
					jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
				}
			}
		});
	});

	/************************************************
	 * Sort jobs
	 **********************************************/
	jQuery(document).on('change', '.sort_by, .order_by', function (event) {
		jQuery(".form-sort-jobs").submit();
	});

	/***********************************************
	 * load sub categories
	 **********************************************/
	jQuery('.sp-current-category select').change(function () {
		var id = jQuery('option:selected', this).data('id');
		var dir_name = jQuery(this).find(':selected').data('dir_name');

		if (id === undefined || id === null) {
			jQuery('.subcat-search-wrap').html('');
		}

		if ( SP_Editor.elements[id]) {
			var load_subcategories = wp.template('load-subcategories');
			var data = [];
			data['childrens'] = SP_Editor.elements[id];
			var _options = load_subcategories(data);
			jQuery('.subcat-search-wrap').html(_options);
			_show_hide_list('.subcat-search-wrap');
			
			if(jQuery('body .sub-cat-dp').length > 0){
				var load_subcategories_dd = wp.template('load-subcategories-dd');
				var data = [];
				data['childrens'] = SP_Editor.elements[id];
				var _options = load_subcategories_dd(data);
				jQuery('.subcategories-wrap').html(_options);

				jQuery(".subcategories-wrap").chosen();
				jQuery('.subcategories-wrap').trigger("chosen:updated");
			}
		} else {
			jQuery('.subcat-search-wrap').html('');
		}
	});

	jQuery('.sp-current-category select').trigger('change');

	/*
	 * @Contact Form
	 * @return{}
	 */
	jQuery(document).on('click', '.tg-dashboard-form-btn', function (e) {
		e.preventDefault();
		var _this = jQuery(this);

		var serialize_data = jQuery('.tg-dashboardform').serialize();
		var dataString = serialize_data + '&action=listingo_dashboard_contact_form';
		jQuery('body').append(loader_html);
		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: dataString,
			dataType: "json",
			success: function (response) {
				jQuery('body').find('.provider-site-wrap').remove();
				if (response.type === 'success') {
					jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
					_this.parents('.tg-dashboardform').get(0).reset();
				} else {
					jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
				}
			}
		});
		return false;
	});
	
	/*
	 * @Fixed Navigation
	 * @return{}
	 */
	if( scripts_vars.navfixed == 'yes' ){
		var winwidth	= jQuery(window).width();
		
		if( winwidth > 768 ){
			var win = jQuery(window);    
			var header = jQuery("#tg-fixednav");
			var headerOffset = header.offset().top || 0;
			var flag = true;
			var triger_once = true;
			jQuery(window).scroll(function() {
				if (win.scrollTop() > headerOffset) {
					if (flag){
						flag = false;
						jQuery("#tg-wrapper").addClass("sp-sticky");
						jQuery(window).trigger('resize').trigger('scroll');
						setTimeout(
						  function() 
						  {
	 						jQuery(window).trigger('resize.px.parallax');
						  }, 300);
					}

				} else {
					if (!flag) {
						flag = true;
						jQuery("#tg-wrapper").removeClass("sp-sticky");
						jQuery(window).trigger('resize').trigger('scroll');
						setTimeout(
						  function() 
						  {
	 						jQuery(window).trigger('resize.px.parallax');
						  }, 300);
					}
				}
			});
		}
	}

	/*
	 * @Job application model box show/hide
	 * @return{}
	 */

    jQuery(document).on('click', '.tg-apply-job-model', function () {
        jQuery('.sp-apply-job-modal').modal('show');        
    });
    
    /*
	 * @Date picker to date of birth
	 * @return{}
	*/
    jQuery('#tg-date-birth').datetimepicker({
        format: scripts_vars.calendar_format,
        datepicker: true,
        timepicker: false,
		dayOfWeekStart:scripts_vars.startweekday
    });

    jQuery(document).on('click', '.tg-apply-job', function(){
    	var _this = jQuery(this);
    	jQuery('body').append(loader_html);
		var serialize_data = jQuery('.tg-job-application-form').serialize();
		var dataString = serialize_data + '&action=listingo_apply_job_form';

    	jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: dataString,
			dataType: "json",
			success: function (response) {
				jQuery('body').find('.provider-site-wrap').remove();
				if (response.type === 'success') {
					jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });				
					jQuery('.sp-apply-job-modal').modal('hide');
					jQuery('.tg-job-application-form')[0].reset();
				} else {
					jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
				}
			}
		});
    });

});


//Custom ajax listings
var ListingoPaging = ( function() {
  /*declare private variables*/
	var first = 0;
	
	if(typeof _last != 'undefined'){
		var last = _last;
	} else{
		var last = 2;
	}
	
	if(typeof _step != 'undefined'){
		var step = _step;
	} else{
		var step = 3;
	}
	
  //GET next featured users
  function searchNext() {
	if( is_end ===  true ){
		var _this = jQuery(this);
		var _input = jQuery('.data-search-string');
		var searchjson = _input.val();
		var dataString = 'searchjson=' + searchjson + '&action=listingo_get_ajax_featured_users';  
		
		jQuery('.ajax-search-result').append(scripts_vars.spinner);
        jQuery('.ajax-search-result').addClass('spoverlay');
		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: dataString,
			dataType: "json",
			success: function (response) {
				jQuery('.ajax-search-result').find('.sp-spin').remove();
                jQuery('.ajax-search-result').removeClass('spoverlay');
				if (response.type === 'success') {  
					jQuery('.data-search-string').val(response.datajson);
					jQuery('.ajax-search-result').append(response.listings);
					if( response.is_next === 'yes' ){
						is_end =  true;
					} else{
						is_end =  false;
					}
					ListingoPaging.nextAjaxPage();
					
				} else {
					ListingoPaging.nextAjaxPage();
					is_end =  false;
					jQuery.sticky(response.message, {classList: 'important', speed: 200, autoclose: 5000});
				}
			}
		});
	} else{
		ListingoPaging.nextAjaxPage();
	}
  }
  
  //Next page 
  function nextAjaxPage(){
	first += step;
    last += step;
    ListingoPagingHelper();
  }
  
  //Previuos page record
  function searchPrev() {
    //previous function
    //decrease first and last variables
    first -= step;
    last -= step;
    ListingoPagingHelper();
  }
  
  //ListingoPaging Helper
  function ListingoPagingHelper() {
    //get all child elements with class front-pro 
    //of element with class .inner-content
    var childElems = jQuery(".ajax-search-result .tg-verticaltop");
    //iterate through the elements
    childElems.each(function(i, el) {
      //show the elements that match the criteria removing css class
      if ( i >= first && i <= last ) {
        jQuery(el).removeClass('hidden');
      } else {
        //hide rest
        jQuery(el).addClass('hidden');
      }
    });
    nextPreviousToggle(childElems.length);
  }

  function nextPreviousToggle(maxEle) {
    //here the code is to show/hide next/previous buttons
    if (last >= maxEle) {
      jQuery(".spnext").hide();
    } else {
      jQuery(".spnext").show();
    }
    if (first === 0) {
      jQuery(".spprev").hide();
    } else {
      jQuery(".spprev").show();
    }
  }
  return {
    searchNext: searchNext,
    searchPrev: searchPrev,
	nextAjaxPage: nextAjaxPage
  }
})();


//exclude empty strings
function exlude_empty_options(){
	jQuery('.sp-sub-category option').filter(function() {
		return !this.value || jQuery.trim(this.value).length == 0 || jQuery.trim(this.text).length == 0;
	}).remove();
}
exlude_empty_options();


//back to top
jQuery(window).scroll(function() {
	if (jQuery(this).scrollTop() > 50 ) {
		jQuery('.tg-btnscrolltop:hidden').stop(true, true).fadeIn();
	} else {
		jQuery('.tg-btnscrolltop').stop(true, true).fadeOut();
	}
});

jQuery(function(){jQuery(".tg-btnscrolltop").click(function(){jQuery("html,body").animate({scrollTop:jQuery("#tg-wrapper").offset().top},"1000");return false})});

/* ---------------------------------------
 Confirm Box
 --------------------------------------- */
(function ($) {

    $.confirm = function (params) {

        if ($('#confirmOverlay').length) {
            // A confirm is already shown on the page:
            return false;
        }

        var buttonHTML = '';
        $.each(params.buttons, function (name, obj) {

			// Generating the markup for the buttons:
			if( name == 'Yes' ){
				name	= scripts_vars.yes;
			} else if( name == 'No' ){
				name	= scripts_vars.no;
			} else{
				name	= name;
			}
			
            buttonHTML += '<a href="#" class="button ' + obj['class'] + '">' + name + '<span></span></a>';
            if (!obj.action) {
                obj.action = function () {
                };
            }
        });
        var markup = [
            '<div id="confirmOverlay">',
            '<div id="confirmBox">',
            '<h1>', params.title, '</h1>',
            '<p>', params.message, '</p>',
            '<div id="confirmButtons">',
            buttonHTML,
            '</div></div></div>'
        ].join('');
        $(markup).hide().appendTo('body').fadeIn();
        var buttons = $('#confirmBox .button'),
                i = 0;
        $.each(params.buttons, function (name, obj) {
            buttons.eq(i++).click(function () {

                // Calling the action attribute when a
                // click occurs, and hiding the confirm.

                obj.action();
                $.confirm.hide();
                return false;
            });
        });
    }

    $.confirm.hide = function () {
        $('#confirmOverlay').fadeOut(function () {
            $(this).remove();
        });
    }

})(jQuery);

//recaptcha
var ListingoCaptchaCallback = function() {
	if(jQuery('#recaptcha_signin').length > 0){
		signin_reset 	= grecaptcha.render('recaptcha_signin', {'sitekey' : scripts_vars.site_key });
	}
	
	if(jQuery('#recaptcha_signup').length > 0){
		signup_reset 	= grecaptcha.render('recaptcha_signup', {'sitekey' : scripts_vars.site_key });
	}
	
	if(jQuery('#recaptcha_signup_provider').length > 0){
		signup_reset_provider 	= grecaptcha.render('recaptcha_signup_provider', {'sitekey' : scripts_vars.site_key });
	}
	
	if(jQuery('#recaptcha_forgot').length > 0){
		password_forgot 		= grecaptcha.render('recaptcha_forgot', {'sitekey' : scripts_vars.site_key });
	}
	
	if(jQuery('#recaptcha_reset').length > 0){
		password_reset 		= grecaptcha.render('recaptcha_reset', {'sitekey' : scripts_vars.site_key });
	}
};

//Preloader
jQuery(window).load(function () {
	var loading_duration = scripts_vars.loading_duration;
    jQuery(".preloader-outer").delay(loading_duration).fadeOut();
    jQuery(".pins").delay(loading_duration).fadeOut("slow");
});

//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//:::                                                                         :::
//:::  This routine calculates the distance between two points (given the     :::
//:::  latitude/longitude of those points). It is being used to calculate     :::
//:::  the distance between two locations using GeoDataSource (TM) prodducts  :::
//:::                                                                         :::
//:::  Definitions:                                                           :::
//:::    South latitudes are negative, east longitudes are positive           :::
//:::                                                                         :::
//:::  Passed to function:                                                    :::
//:::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :::
//:::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :::
//:::    unit = the unit you desire for results                               :::
//:::           where: 'M' is statute miles (default)                         :::
//:::                  'K' is kilometers                                      :::
//:::                  'N' is nautical miles                                  :::
//:::                                                                         :::
//:::  Worldwide cities and other features databases with latitude longitude  :::
//:::  are available at http://www.geodatasource.com                          :::
//:::                                                                         :::
//:::  For enquiries, please contact sales@geodatasource.com                  :::
//:::                                                                         :::
//:::  Official Web site: http://www.geodatasource.com                        :::
//:::                                                                         :::
//:::               GeoDataSource.com (C) All Rights Reserved 2015            :::
//:::                                                                         :::
//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
function _get_distance(lat1, lon1, lat2, lon2, unit) {
    var radlat1 = Math.PI * lat1 / 180
    var radlat2 = Math.PI * lat2 / 180
    var theta = lon1 - lon2
    var radtheta = Math.PI * theta / 180
    var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
    dist = Math.acos(dist)
    dist = dist * 180 / Math.PI
    dist = dist * 60 * 1.1515
    if (unit == "K") {
        dist = dist * 1.609344
    }
    if (unit == "N") {
        dist = dist * 0.8684
    }
    return dist
}

// get rounded value
function _get_round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}

/* -------------------------------------
 SVG Injector
 -------------------------------------- */

;
(function ($, window, document, undefined) {
    var pluginName = 'svgInject';
    function Plugin(element, options) {
        this.element = element;
        this._name = pluginName;
        this.init();
    }
    Plugin.prototype = {init: function () {
            $(this.element).css('visibility', 'hidden');
            this.swapSVG(this.element);
        }, swapSVG: function (el) {
            var imgURL = $(el).attr('src');
            var imgID = $(el).attr('id');
            var imgClass = $(el).attr('class');
            var imgData = $(el).clone(true).data();
            var dimensions = {w: $(el).attr('width'), h: $(el).attr('height')};
            $.get(imgURL, function (data) {
                var svg = $(data).find('svg');
                if (typeof imgID !== undefined) {
                    svg = svg.attr('id', imgID);
                }
                if (typeof imgClass !== undefined) {
                    var cls = (svg.attr('class') !== undefined) ? svg.attr('class') : '';
                    svg = svg.attr('class', imgClass + ' ' + cls + ' replaced-svg');
                }
                $.each(imgData, function (name, value) {
                    svg[0].setAttribute('data-' + name, value);
                });
                svg = svg.removeAttr('xmlns:a');
                var ow = parseFloat(svg.attr('width'));
                var oh = parseFloat(svg.attr('height'));
                if (dimensions.w && dimensions.h) {
                    $(svg).attr('width', dimensions.w);
                    $(svg).attr('height', dimensions.h);
                }
                else if (dimensions.w) {
                    $(svg).attr('width', dimensions.w);
                    $(svg).attr('height', (oh / ow) * dimensions.w);
                }
                else if (dimensions.h) {
                    $(svg).attr('height', dimensions.h);
                    $(svg).attr('width', (ow / oh) * dimensions.h);
                }
                $(el).replaceWith(svg);
                var js = new Function(svg.find('script').text());
                js();
            });
        }};
    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName, new Plugin(this, options));
            }
        });
    };
})(jQuery, window, document);
/* -------------------------------------
 Map Styles
 -------------------------------------- */
function listingo_get_map_styles(style) {

    var styles = '';
    if (style == 'view_1') {
        var styles = [{"featureType": "administrative.country", "elementType": "geometry", "stylers": [{"visibility": "simplified"}, {"hue": "#ff0000"}]}];
    } else if (style == 'view_2') {
        var styles = [{"featureType": "water", "elementType": "all", "stylers": [{"hue": "#7fc8ed"}, {"saturation": 55}, {"lightness": -6}, {"visibility": "on"}]}, {"featureType": "water", "elementType": "labels", "stylers": [{"hue": "#7fc8ed"}, {"saturation": 55}, {"lightness": -6}, {"visibility": "off"}]}, {"featureType": "poi.park", "elementType": "geometry", "stylers": [{"hue": "#83cead"}, {"saturation": 1}, {"lightness": -15}, {"visibility": "on"}]}, {"featureType": "landscape", "elementType": "geometry", "stylers": [{"hue": "#f3f4f4"}, {"saturation": -84}, {"lightness": 59}, {"visibility": "on"}]}, {"featureType": "landscape", "elementType": "labels", "stylers": [{"hue": "#ffffff"}, {"saturation": -100}, {"lightness": 100}, {"visibility": "off"}]}, {"featureType": "road", "elementType": "geometry", "stylers": [{"hue": "#ffffff"}, {"saturation": -100}, {"lightness": 100}, {"visibility": "on"}]}, {"featureType": "road", "elementType": "labels", "stylers": [{"hue": "#bbbbbb"}, {"saturation": -100}, {"lightness": 26}, {"visibility": "on"}]}, {"featureType": "road.arterial", "elementType": "geometry", "stylers": [{"hue": "#ffcc00"}, {"saturation": 100}, {"lightness": -35}, {"visibility": "simplified"}]}, {"featureType": "road.highway", "elementType": "geometry", "stylers": [{"hue": "#ffcc00"}, {"saturation": 100}, {"lightness": -22}, {"visibility": "on"}]}, {"featureType": "poi.school", "elementType": "all", "stylers": [{"hue": "#d7e4e4"}, {"saturation": -60}, {"lightness": 23}, {"visibility": "on"}]}];
    } else if (style == 'view_3') {
        var styles = [{"featureType": "water", "stylers": [{"saturation": 43}, {"lightness": -11}, {"hue": "#0088ff"}]}, {"featureType": "road", "elementType": "geometry.fill", "stylers": [{"hue": "#ff0000"}, {"saturation": -100}, {"lightness": 99}]}, {"featureType": "road", "elementType": "geometry.stroke", "stylers": [{"color": "#808080"}, {"lightness": 54}]}, {"featureType": "landscape.man_made", "elementType": "geometry.fill", "stylers": [{"color": "#ece2d9"}]}, {"featureType": "poi.park", "elementType": "geometry.fill", "stylers": [{"color": "#ccdca1"}]}, {"featureType": "road", "elementType": "labels.text.fill", "stylers": [{"color": "#767676"}]}, {"featureType": "road", "elementType": "labels.text.stroke", "stylers": [{"color": "#ffffff"}]}, {"featureType": "poi", "stylers": [{"visibility": "off"}]}, {"featureType": "landscape.natural", "elementType": "geometry.fill", "stylers": [{"visibility": "on"}, {"color": "#b8cb93"}]}, {"featureType": "poi.park", "stylers": [{"visibility": "on"}]}, {"featureType": "poi.sports_complex", "stylers": [{"visibility": "on"}]}, {"featureType": "poi.medical", "stylers": [{"visibility": "on"}]}, {"featureType": "poi.business", "stylers": [{"visibility": "simplified"}]}];
    } else if (style == 'view_4') {
        var styles = [{"elementType": "geometry", "stylers": [{"hue": "#ff4400"}, {"saturation": -68}, {"lightness": -4}, {"gamma": 0.72}]}, {"featureType": "road", "elementType": "labels.icon"}, {"featureType": "landscape.man_made", "elementType": "geometry", "stylers": [{"hue": "#0077ff"}, {"gamma": 3.1}]}, {"featureType": "water", "stylers": [{"hue": "#00ccff"}, {"gamma": 0.44}, {"saturation": -33}]}, {"featureType": "poi.park", "stylers": [{"hue": "#44ff00"}, {"saturation": -23}]}, {"featureType": "water", "elementType": "labels.text.fill", "stylers": [{"hue": "#007fff"}, {"gamma": 0.77}, {"saturation": 65}, {"lightness": 99}]}, {"featureType": "water", "elementType": "labels.text.stroke", "stylers": [{"gamma": 0.11}, {"weight": 5.6}, {"saturation": 99}, {"hue": "#0091ff"}, {"lightness": -86}]}, {"featureType": "transit.line", "elementType": "geometry", "stylers": [{"lightness": -48}, {"hue": "#ff5e00"}, {"gamma": 1.2}, {"saturation": -23}]}, {"featureType": "transit", "elementType": "labels.text.stroke", "stylers": [{"saturation": -64}, {"hue": "#ff9100"}, {"lightness": 16}, {"gamma": 0.47}, {"weight": 2.7}]}];
    } else if (style == 'view_5') {
        var styles = [{"featureType": "water", "elementType": "geometry", "stylers": [{"color": "#e9e9e9"}, {"lightness": 17}]}, {"featureType": "landscape", "elementType": "geometry", "stylers": [{"color": "#f5f5f5"}, {"lightness": 20}]}, {"featureType": "road.highway", "elementType": "geometry.fill", "stylers": [{"color": "#ffffff"}, {"lightness": 17}]}, {"featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [{"color": "#ffffff"}, {"lightness": 29}, {"weight": 0.2}]}, {"featureType": "road.arterial", "elementType": "geometry", "stylers": [{"color": "#ffffff"}, {"lightness": 18}]}, {"featureType": "road.local", "elementType": "geometry", "stylers": [{"color": "#ffffff"}, {"lightness": 16}]}, {"featureType": "poi", "elementType": "geometry", "stylers": [{"color": "#f5f5f5"}, {"lightness": 21}]}, {"featureType": "poi.park", "elementType": "geometry", "stylers": [{"color": "#dedede"}, {"lightness": 21}]}, {"elementType": "labels.text.stroke", "stylers": [{"visibility": "on"}, {"color": "#ffffff"}, {"lightness": 16}]}, {"elementType": "labels.text.fill", "stylers": [{"saturation": 36}, {"color": "#333333"}, {"lightness": 40}]}, {"elementType": "labels.icon", "stylers": [{"visibility": "off"}]}, {"featureType": "transit", "elementType": "geometry", "stylers": [{"color": "#f2f2f2"}, {"lightness": 19}]}, {"featureType": "administrative", "elementType": "geometry.fill", "stylers": [{"color": "#fefefe"}, {"lightness": 20}]}, {"featureType": "administrative", "elementType": "geometry.stroke", "stylers": [{"color": "#fefefe"}, {"lightness": 17}, {"weight": 1.2}]}];
    } else if (style == 'view_6') {
        var styles = [{"featureType": "landscape", "stylers": [{"hue": "#FFBB00"}, {"saturation": 43.400000000000006}, {"lightness": 37.599999999999994}, {"gamma": 1}]}, {"featureType": "road.highway", "stylers": [{"hue": "#FFC200"}, {"saturation": -61.8}, {"lightness": 45.599999999999994}, {"gamma": 1}]}, {"featureType": "road.arterial", "stylers": [{"hue": "#FF0300"}, {"saturation": -100}, {"lightness": 51.19999999999999}, {"gamma": 1}]}, {"featureType": "road.local", "stylers": [{"hue": "#FF0300"}, {"saturation": -100}, {"lightness": 52}, {"gamma": 1}]}, {"featureType": "water", "stylers": [{"hue": "#0078FF"}, {"saturation": -13.200000000000003}, {"lightness": 2.4000000000000057}, {"gamma": 1}]}, {"featureType": "poi", "stylers": [{"hue": "#00FF6A"}, {"saturation": -1.0989010989011234}, {"lightness": 11.200000000000017}, {"gamma": 1}]}];
    } else {
        var styles = [{"featureType": "administrative.country", "elementType": "geometry", "stylers": [{"visibility": "simplified"}, {"hue": "#ff0000"}]}];
    }
    return styles;
}

/* -------------------------------------
 Validate Amount
 -------------------------------------- */
function validateAmount(_this) {
    if (isNaN(jQuery.trim(jQuery(_this).val()))) {
        jQuery(_this).val("");
    } else {
        var amt = jQuery(_this).val();
        if (amt != '') {
            if (amt.length > 16) {
                amt = amt.substr(0, 16);
                jQuery(_this).val(amt);
            }
            //amount = amt;
            return true;
        } else {
            //amount = gloAmount;
            return true;
        }
    }
}

/* -------------------------------------
 Init Full Width Sections
 -------------------------------------- */
builder_full_width_section(); //Init Sections
var $ = window.jQuery;
$(window).off("resize.sectionSettings").on("resize.sectionSettings", builder_full_width_section);
function builder_full_width_section() {
    var $sections = jQuery('.main-page-wrapper .stretch_section');
    jQuery.each($sections, function (key, item) {
        var _sec = jQuery(this);
        var _sec_full = _sec.next(".section-current-width");
        _sec_full.length || (_sec_full = _sec.parent().next(".section-current-width"));
        var _sec_margin_left = parseInt(_sec.css("margin-left"), 10);
        var _sec_margin_right = parseInt(_sec.css("margin-right"), 10);
        var offset = 0 - _sec_full.offset().left - _sec_margin_left;
        var width = jQuery(window).width();
        if (_sec.css({
            position: "relative",
            left: offset,
            "box-sizing": "border-box",
            width: jQuery(window).width()
        }), !_sec.hasClass("stretch_data")) {
            var padding = -1 * offset;
            0 > padding && (padding = 0);
            var paddingRight = width - padding - _sec_full.width() + _sec_margin_left + _sec_margin_right;
            0 > paddingRight && (paddingRight = 0), _sec.css({
                "padding-left": padding + "px",
                "padding-right": paddingRight + "px"
            })
        }
    });
}

/**
 * Mega Menu
 */
jQuery(function ($) {

    function hoverIn() {
        var a = $(this);
        var nav = a.closest('.tg-navigation');
        var mega = a.find('.mega-menu');
        var offset = rightSide(nav) - leftSide(a);
        var winwidth	= jQuery(window).width();
		if( winwidth > 768 ){
			mega.width(Math.min(rightSide(nav), columns(mega) * 325));
			mega.css('left', Math.min(0, offset - mega.width()));
			mega.fadeIn('fast').css("display","block");
		}
		
    }

    function hoverOut() {
		var winwidth	= jQuery(window).width();
		if( winwidth > 768 ){
			var a = $(this);
			var nav = a.closest('.tg-navigation');
			var mega = a.find('.mega-menu');
			mega.fadeOut('fast').css("display","none");
		}
    }

    function columns(mega) {
        var columns = 0;
        mega.children('.mega-menu-row').each(function () {
            columns = Math.max(columns, $(this).children('.mega-menu-col').length);
        });
        return columns;
    }

    function leftSide(elem) {
        return elem.offset().left;
    }

    function rightSide(elem) {
        return elem.offset().left + elem.width();
    }
	
	var winwidth	= jQuery(window).width();
	jQuery('.tg-navigation .menu-item-has-mega-menu').hover(hoverIn, hoverOut);
});

//Get URL params
var ListingoGetUrlParameter = function getUrlParameter(sParam, is_array) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;
    var array_data = [];
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (is_array === 'yes') {
            if (sParameterName[0] === sParam) {
                sParameterName[1] === undefined ? true : array_data.push(sParameterName[1]);
            }
        } else {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }

    return array_data;
};

//Load More Options
var items_wrap = '.subcat-search-wrap';
function _show_hide_list(items_wrap) {
    var size_li = jQuery(items_wrap + " .data-list .sp-load-item").size();
    var x = 10;
    jQuery(items_wrap + ' .data-list .sp-load-item:lt(' + x + ')').show();
    jQuery(items_wrap + ' .sp-loadMore').click(function () {
        x = (x + 10 <= size_li) ? x + 10 : size_li;
        jQuery(items_wrap + ' .data-list .sp-load-item:lt(' + x + ')').show();
    });

    jQuery(items_wrap + ' sp-showLess').click(function () {
        x = (x - 10 < 0) ? 10 : x - 10;
        jQuery(items_wrap + ' .data-list .sp-load-item').not(':lt(' + x + ')').hide();
    });

    if (size_li <= 10) {
        jQuery(items_wrap + " .sp-loadMore").hide();
    }

}

//Uploader progressbar
function listingo_uploader_progressbar(_pecentage,_type){
	var fileuploading	   = scripts_vars.fileuploading;
	if( _type === 'add' ){
		if(jQuery('.spuploader-progressbar').length > 0){
			jQuery('.spuploader-progressbar .percentage').html('('+_pecentage+'%)');
		} else{
			var progressbar_html = '<div class="spuploader-progressbar"><div class="spuploader-loader active progress-bar-striped progress-bar-animated"><span>'+fileuploading+'</span> <span class="loaderdots"></span><span class="percentage"> ('+_pecentage+'%)</span></div></div>';
			jQuery('body').find('.spuploader-progressbar').remove();
			jQuery('body').append(progressbar_html);
			//jQuery('body').addClass('spuploader-progressbar');
			jQuery( function() {
				jQuery( '.spuploader-loader span.loaderdots' ).loadingdots();
			});
		}
		
		
	} else{
		jQuery('body').find('.spuploader-progressbar').remove();
		//jQuery('body').removeClass('spuploader-progressbar');
	}
}

(function($){
  $.fn.loadingdots = function( options )
  {
    var i = 0, settings = $.extend( {}, { duration : 250 }, options ),

    bucle = function() {
      var $el = $( this ), cycle, timing = i * settings.duration, first = true;
      i++;

      cycle = function()
      {
        // if it's not the first time the cycle is called for a dot then the timing fired is 0
        if ( !first )
          timing = 0;
        else
          first = false;
        // delay the animation the timing needed, and then make the animation to fadeIn and Out the dot to make the effect
        $el.delay( timing )
          .fadeTo( 1000, 0.4 )
          .fadeTo( 1000, 0, cycle );
      };

      cycle( first );
    };
    // for every element where the plugin was called we create the loading dots html and start the animations
    return this.each( function()
    {
      $( this )
        .html( '<em class="spdot"></em><em class="spdot"></em><em class="spdot"></em>' )
        .find( '.spdot' )
        .each( bucle );
    });

  };
})(jQuery);

/* -------------------------------------
 Form Serilization
 -------------------------------------- */
// Serialize Function
$.fn.serializeObject = function () {
    "use strict";
    var a = {}, b = function (b, c) {
        var d = a[c.name];
        "undefined" != typeof d && d !== null ? $.isArray(d) ? d.push(c.value) : a[c.name] = [d, c.value] : a[c.name] = c.value
    };
    return $.each(this.serializeArray(), b), a
};

/*
 Sticky v2.1.2 by Andy Matthews
 http://twitter.com/commadelimited
 
 forked from Sticky by Daniel Raftery
 http://twitter.com/ThrivingKings
 */
(function ($) {

    $.sticky = $.fn.sticky = function (note, options, callback) {

        // allow options to be ignored, and callback to be second argument
        if (typeof options === 'function')
            callback = options;

        // generate unique ID based on the hash of the note.
        var hashCode = function (str) {
            var hash = 0,
                    i = 0,
                    c = '',
                    len = str.length;
            if (len === 0)
                return hash;
            for (i = 0; i < len; i++) {
                c = str.charCodeAt(i);
                hash = ((hash << 5) - hash) + c;
                hash &= hash;
            }
            return 's' + Math.abs(hash);
        },
                o = {
                    position: 'top-right', // top-left, top-right, bottom-left, or bottom-right
                    speed: 'fast', // animations: fast, slow, or integer
                    allowdupes: true, // true or false
                    autoclose: 5000, // delay in milliseconds. Set to 0 to remain open.
                    classList: '' // arbitrary list of classes. Suggestions: success, warning, important, or info. Defaults to ''.
                },
        uniqID = hashCode(note), // a relatively unique ID
                display = true,
                duplicate = false,
                //tmpl = '<div class="tg-alertmessage" id="ID"><div class="sticky border-POS"><em class="lnr lnr-bullhorn CLASSLIST"></em><span class="sticky-close"></span><p class="sticky-note">NOTE</p></div></div>',
				tmpl = '<div id="ID" class="jf-alert alert-dismissible border-POS CLASSLIST" role="alert"><button type="button" class="jf-close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="lnr lnr-cross"></i></span></button><i class="lnr lnr-bullhorn"></i><div class="jf-description"><p>NOTE</p></div></div>',
                positions = ['top-right', 'top-center', 'top-left', 'bottom-right', 'bottom-center', 'bottom-left','middle-left','middle-right','middle-center'];

        // merge default and incoming options
        if (options)
            $.extend(o, options);

        // Handling duplicate notes and IDs
        $('.sticky').each(function () {
            if ($(this).attr('id') === hashCode(note)) {
                duplicate = true;
                if (!o.allowdupes)
                    display = false;
            }
            if ($(this).attr('id') === uniqID)
                uniqID = hashCode(note);
        });
		
		if( scripts_vars.sm_success ){
			var _position	= scripts_vars.sm_success;
		} else{
			var _position	= o.position;
		}
		
        // Make sure the sticky queue exists
        if (!$('.sticky-queue').length) {
            $('body').append('<div class="sticky-queue ' + _position + '">');
        } else {
            // if it exists already, but the position param is different,
            // then allow it to be overridden
            $('.sticky-queue').removeClass(positions.join(' ')).addClass(_position);
        }

        // Can it be displayed?
        if (display) {
            // Building and inserting sticky note
            $('.sticky-queue').prepend(
                    tmpl
                    .replace('POS', _position)
                    .replace('ID', uniqID)
                    .replace('NOTE', note)
                    .replace('CLASSLIST', o.classList)
                    ).find('#' + uniqID)
                    .slideDown(o.speed, function () {
                        display = true;
                        // Callback function?
                        if (callback && typeof callback === 'function') {
                            callback({
                                'id': uniqID,
                                'duplicate': duplicate,
                                'displayed': display
                            });
                        }
                    });

        }

        // Listeners
        $('.sticky').ready(function () {
            // If 'autoclose' is enabled, set a timer to close the sticky
            if (o.autoclose) {
                $('#' + uniqID).delay(o.autoclose).fadeOut(o.speed, function () {
                    // remove element from DOM
                    $(this).remove();
                });
            }
        });

        // Closing a sticky
        $('.jf-close').on('click', function () {
			var _this	= $(this);
			
			if( _this.parents('.jf-alert').hasClass('sp-cacheit') ){
				$.confirm({
					'title': scripts_vars.cache_title,
					'message': scripts_vars.cache_message,
					'buttons': {
						'Yes': {
							'class': 'blue',
							'action': function () {

								if( _this.parents('.jf-alert').hasClass('cache-verification') ){
									$.cookie('sp_cache_verification_'+scripts_vars.current_user_id, 'true', { expires: 365 });
								} else if( _this.parents('.jf-alert').hasClass('cache-deactivation') ){
									$.cookie('sp_cache_deactivation_'+scripts_vars.current_user_id, 'true', { expires: 365 });
								}

								//Remove message
								$('#' + _this.parents('.jf-alert').attr('id')).dequeue().fadeOut(o.speed, function () {
									// remove element from DOM
									_this.remove();
								});

							}
						},
						'No': {
							'class': 'gray',
							'action': function () {
								return false;
							}	// Nothing to do in this case. You can as well omit the action property.
						}
					}
				});
			} else{
				//Remove message
				$('#' + _this.parents('.jf-alert').attr('id')).dequeue().fadeOut(o.speed, function () {
					// remove element from DOM
					_this.remove();
				});
			}
        });

    };
})(jQuery);

/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2006, 2014 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD (Register as an anonymous module)
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node/CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {

    var pluses = /\+/g;
    function encode(s) {
        return config.raw ? s : encodeURIComponent(s);
    }

    function decode(s) {
        return config.raw ? s : decodeURIComponent(s);
    }

    function stringifyCookieValue(value) {
        return encode(config.json ? JSON.stringify(value) : String(value));
    }

    function parseCookieValue(s) {
        if (s.indexOf('"') === 0) {
            // This is a quoted cookie as according to RFC2068, unescape...
            s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
        }

        try {
            // Replace server-side written pluses with spaces.
            // If we can't decode the cookie, ignore it, it's unusable.
            // If we can't parse the cookie, ignore it, it's unusable.
            s = decodeURIComponent(s.replace(pluses, ' '));
            return config.json ? JSON.parse(s) : s;
        } catch (e) {
        }
    }

    function read(s, converter) {
        var value = config.raw ? s : parseCookieValue(s);
        return $.isFunction(converter) ? converter(value) : value;
    }

    var config = $.cookie = function (key, value, options) {

        // Write
        if (arguments.length > 1 && !$.isFunction(value)) {
            options = $.extend({}, config.defaults, options);
            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setMilliseconds(t.getMilliseconds() + days * 864e+5);
            }

            return (document.cookie = [
                encode(key), '=', stringifyCookieValue(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path ? '; path=' + options.path : '',
                options.domain ? '; domain=' + options.domain : '',
                options.secure ? '; secure' : ''
            ].join(''));
        }

        // Read

        var result = key ? undefined : {},
                // To prevent the for loop in the first place assign an empty array
                // in case there are no cookies at all. Also prevents odd result when
                // calling $.cookie().
                cookies = document.cookie ? document.cookie.split('; ') : [],
                i = 0,
                l = cookies.length;
        for (; i < l; i++) {
            var parts = cookies[i].split('='),
                    name = decode(parts.shift()),
                    cookie = parts.join('=');
            if (key === name) {
                // If second argument (value) is a function it's a converter...
                result = read(cookie, value);
                break;
            }

            // Prevent storing a cookie that we couldn't decode.
            if (!key && (cookie = read(cookie)) !== undefined) {
                result[name] = cookie;
            }
        }

        return result;
    };
    config.defaults = {};
    $.removeCookie = function (key, options) {
        // Must not alter options, thus extending a fresh object...
        $.cookie(key, '', $.extend({}, options, {expires: -1}));
        return !$.cookie(key);
    };

}));


