jQuery(document).ready(function(e) {
	loader_html = '<div class="provider-site-wrap"><div class="provider-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';
    
	var sp_upload_nonce = localize_vars.sp_upload_nonce;
    var sp_upload_profile = localize_vars.sp_upload_profile;
    var sp_upload_banner = localize_vars.sp_upload_banner;
    var sp_upload_gallery = localize_vars.sp_upload_gallery;
    var sp_upload_awards = localize_vars.sp_upload_awards;
    var sp_upload_brochure = localize_vars.sp_upload_brochure;
    var data_size_in_kb = localize_vars.data_size_in_kb;
    var appointment_check = localize_vars.appointment_check;
    var free_check = localize_vars.free_check;
    var delete_business_hour = localize_vars.delete_business_hour;
    var delete_business_hour_message = localize_vars.delete_business_hour_message;
    var delete_video_link = localize_vars.delete_video_link;
    var delete_video_link_message = localize_vars.delete_video_link_message;
    var delete_award = localize_vars.delete_award;
    var delete_award_message = localize_vars.delete_award_message;
    var delete_experience = localize_vars.delete_experience;
    var delete_experience_message = localize_vars.delete_experience_message;
    var delete_qualification = localize_vars.delete_qualification;
    var delete_qualification_message = localize_vars.delete_qualification_message;
    var delete_service = localize_vars.delete_service;
    var delete_service_message = localize_vars.delete_service_message;
    var delete_message = localize_vars.delete_message;
    var deactivate = localize_vars.deactivate;
    var delete_title = localize_vars.delete_title;
    var deactivate_title = localize_vars.deactivate_title;
    var avatar_active_title = localize_vars.avatar_active_title;
    var avatar_active_message = localize_vars.avatar_active_message;
    var banner_active_title = localize_vars.banner_active_title;
    var banner_active_message = localize_vars.banner_active_message;
    var language_select = localize_vars.language_select;
    var language_already_add = localize_vars.language_already_add;
    var amenities_select = localize_vars.amenities_select;
    var amenities_already_add = localize_vars.amenities_already_add;
    var delete_amenity_title = localize_vars.delete_amenity_title;
    var delete_amenity_msg = localize_vars.delete_amenity_msg;
    var delete_lang_title = localize_vars.delete_lang_title;
    var delete_lang_msg = localize_vars.delete_lang_msg;

    var insurance_select = localize_vars.insurance_select;
    var insurance_already_add = localize_vars.insurance_already_add;
    var delete_insurance_title = localize_vars.delete_insurance_title;
    var delete_insurance_msg = localize_vars.delete_insurance_msg;
    var no_favorite = localize_vars.no_favorite;
    var delete_favorite = localize_vars.delete_favorite;
    var delete_favorite_message = localize_vars.delete_favorite_message;
    var infomation = localize_vars.infomation;
	
	var delete_appointment_type_text = localize_vars.delete_appointment_type_text;
    var delete_appointment_type_message = localize_vars.delete_appointment_type_message;
    var delete_appointment_type_reason = localize_vars.delete_appointment_type_reason;
    var delete_appointment_type_reason_message = localize_vars.delete_appointment_type_reason_message;
    var sp_appointment_service_msg = localize_vars.sp_appointment_service_msg;
    var sp_appointment_types_msg = localize_vars.sp_appointment_types_msg;
    var sp_appointment_reasosns_msg = localize_vars.sp_appointment_reasosns_msg;
    var sp_appointment_auth = localize_vars.sp_appointment_auth;
    var sp_appointment_pass = localize_vars.sp_appointment_pass;
    var sp_appointment_pass_confirm = localize_vars.sp_appointment_pass_confirm;
    var sp_appointment_pass_match = localize_vars.sp_appointment_pass_match;
    var approve_appt_type_msg = localize_vars.approve_appt_type_msg;
    var approve_appt_type = localize_vars.approve_appt_type;
    var reject_appt_type = localize_vars.reject_appt_type;
    var reject_appt_type_msg = localize_vars.reject_appt_type_msg;
    var sp_rejection_title_field = localize_vars.sp_rejection_title_field;
    var is_loggedin = localize_vars.is_loggedin;
    var system_error = localize_vars.system_error;
    var fav_message = localize_vars.fav_message;
	var complete_fields = localize_vars.complete_fields;
	var spinner = localize_vars.spinner;
	
	var process_withdrawal_title = localize_vars.process_withdrawal_title;
	var process_withdrawal_desc = localize_vars.process_withdrawal_desc;
	
	var complete_fields = localize_vars.complete_fields;
	var calendar_locale	   = localize_vars.calendar_locale;
	var is_author_edit	   = localize_vars.is_author_edit;
	
	if( calendar_locale  && calendar_locale != null){
		jQuery.datetimepicker.setLocale(calendar_locale);
		moment.locale(calendar_locale);
	}
	
	//Unyson Fix
	jQuery('.postbox-header').on('click',function(){
		var _this = jQuery(this);
		_this.next('.inside').toggle();
	});
	
	//init chosen 
	jQuery("._timezone").chosen();
	
	//Init user location map
	var _latitude	= jQuery('#location-pickr-map').data('latitude');
	var _longitude	= jQuery('#location-pickr-map').data('longitude');
	jQuery.listingo_init_map(_latitude,_longitude);

	
	//Category change
	jQuery(document).on('change', '.sp-caetgory-select', function (event) {
        event.preventDefault();
        var _this = jQuery(this);
        var _id = jQuery('.sp-caetgory-select').val();
		var _current = jQuery('.sp-caetgory-select').data('current');
		var _current_sub = jQuery('.sp-caetgory-select').data('current_sub');

        _this.parents('.tg-startendtime').append(spinner);
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: 'id=' + _id + '&action=listingo_get_terms_by_post',
            dataType: "json",
            success: function (response) {
                _this.parents('.tg-startendtime').find('img.sp-spin').remove();

                if (response.type == 'success') {
                    jQuery('.sp-sub-category').html(response.options);
					if( _id == _current ){
						jQuery('select.sp-sub-category option').each(function(index, elem) {
							var _val	= jQuery(this).val();
							if(jQuery.inArray(_val, _current_sub) !== -1){
							   jQuery(this).prop('selected', true);
							}
						});
					}
					
					exlude_empty_options();
					
					if( is_author_edit && is_author_edit === 'yes' ){
						jQuery('.sp-sub-category').trigger("chosen:updated");
					}
                }
            }
        });
    });
	
	
	//exlude empty options
	function exlude_empty_options(){
		jQuery('.sp-sub-category option').filter(function() {
			return !this.value || jQuery.trim(this.value).length == 0 || jQuery.trim(this.text).length == 0;
		}).remove();
	}
	exlude_empty_options();
	
	//is author edit page
	if( is_author_edit && is_author_edit === 'yes' ){
		jQuery(".sp-sub-category").chosen();
	}
	
	
	/*---------------------------------------------------------------------
	 * Z Multi Uploader
	 *---------------------------------------------------------------------*/
	var avatar_container	= jQuery('.avatar-container');
	var avatar_frame;
	
	jQuery('#upload-profile-photo').on('click', function(event) {
		
		var $el = jQuery(this);
		event.preventDefault();
		if ( avatar_frame ) {
			avatar_frame.open();
			return;
		}
		
		// Create the media frame.
		avatar_frame = wp.media.frames.avatar = wp.media({
			title	: $el.data('choose'),
			library  : { type : 'image'},
			button   : {
				text : $el.data('update'),
			},
			states   : [
				new wp.media.controller.Library({
					title		: $el.data('choose'),
					filterable: 'image',
					multiple	 : true,
				})
			]
		});

		// When an image is selected, run a callback.
		avatar_frame.on( 'select', function() {
			var selection = avatar_frame.state().get('selection');
			selection.map( function( attachment ) {
				attachment = attachment.toJSON();
					if ( attachment.id ) {
						var _full	= attachment.url;;
						var _banner	= attachment.url;;
						var _thumb	= attachment.url;;
						var _id		= attachment.id;;

						if( typeof(attachment.sizes['thumbnail']) != "undefined" && attachment.sizes['thumbnail'] !== null) {
							_thumb	= attachment.sizes['thumbnail']['url'];
							_banner	= attachment.sizes['thumbnail']['url'];
						}

						var data = {id: _id, thumb: _thumb, banner: _banner, full: _full};
						var load_profile_thumb = wp.template('load-profile-thumb');
						var _thumb = load_profile_thumb(data);

						jQuery(".sp-profile-photo").append(_thumb);
						
					}
				});

			});
			// Finally, open the modal.
			avatar_frame.open();

		});
	
	//Remove photo
	jQuery(document).on('click', '.del-profile-photo', function (e) {
		 var _this	= jQuery(this);
		 _this.parents('.tg-galleryimg-item').remove();
	});
		
	/*---------------------------------------------------------------------
	 * Z Multi Uploader for banner
	 *---------------------------------------------------------------------*/
	var banner_frame;
	
	jQuery('#upload-profile-banner-photo').on('click', function(event) {
		
		var $el = jQuery(this);
		event.preventDefault();
		if ( banner_frame ) {
			banner_frame.open();
			return;
		}
		
		// Create the media frame.
		banner_frame = wp.media.frames.avatar = wp.media({
			title	: $el.data('choose'),
			library  : { type : 'image'},
			button   : {
				text : $el.data('update'),
			},
			states   : [
				new wp.media.controller.Library({
					title		: $el.data('choose'),
					 filterable: 'image',
					multiple	 : true,
				})
			]
		});

		// When an image is selected, run a callback.
		banner_frame.on( 'select', function() {
			var selection = banner_frame.state().get('selection');
			selection.map( function( attachment ) {
				attachment = attachment.toJSON();
				//console.log(attachment);
					if ( attachment.id ) {
						var _full	= attachment.url;;
						var _banner	= attachment.url;;
						var _thumb	= attachment.url;;
						var _id		= attachment.id;;

						if( typeof(attachment.sizes['thumbnail']) != "undefined" && attachment.sizes['thumbnail'] !== null) {
							_thumb	= attachment.sizes['thumbnail']['url'];
							_banner	= attachment.sizes['thumbnail']['url'];
						}

						var data = {id: _id, thumb: _thumb, banner: _banner, full: _full};
						var load_banner_thumb = wp.template('load-banner-thumb');
						var _thumb = load_banner_thumb(data);

						jQuery(".sp-profile-banner-photos").append(_thumb);
						
					}
				});

			});
			// Finally, open the modal.
			banner_frame.open();

		});
	
	//Remove banner
	jQuery(document).on('click', '.del-profile-banner-photo', function (e) {
		 var _this	= jQuery(this);
		 _this.parents('.tg-galleryimg-item').remove();
	});
	
	/******************************************
     * Load Cities by selecting the Countries
     ****************************************/
    jQuery(".sp-country-select").on('change',function () {
        var _this = jQuery(this);
        var country = _this.val();

        if (country != 0) {
            var dataString = 'country=' + encodeURIComponent( country ) + '&action=listingo_find_cities';

            jQuery('.sp-city-wrap').append(spinner);
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: dataString,
                dataType: "json",
                success: function (response) {
                    jQuery('.sp-city-wrap').find('img.sp-spin').remove();
					jQuery(".sp-city-select option:first").attr('selected','selected');
					
                    if (response.type == 'error') {
                        jQuery(".sp-city-select").html('');
                    } else {
                        jQuery(".sp-city-select").html(response.cities_data);
                    }
                }
            });
        }
    });
	
	/*****************************************
     * Add Profile Languages
     ***************************************/
    jQuery('.sp-dashboard-profile-form').on('click', '.add_profie_language', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var load_languages = wp.template('load-profile-languages');
        var language_key   = _this.parents('.tg-languagesbox').find('.sp-language-select').val();
        var language_value = _this.parents('.tg-languagesbox').find('.sp-language-select option:selected').text();
        var errors = false;
        
		if (language_key == '') {
            jQuery.sticky(language_select, {classList: 'important', speed: 200, autoclose: 7000});
        } else {
            /*Check if there is already added language then throw error*/
            jQuery(".sp-languages-wrap li").each(function (index) {
                var _this = jQuery(this);
                var lang_key = _this.data('language-key');
                if (lang_key == language_key) {
                    jQuery.sticky(language_already_add, {classList: 'important', speed: 200, autoclose: 7000});
                    errors = true;
                }
            });
			
            if (errors == false) {
                var data = {lang_key: language_key, lang_val: language_value};
                var load_languages = load_languages(data);
                _this.parents('.tg-languagesbox').find('.sp-languages-wrap').append(load_languages);
            }
        }
    });
	
	/************************************************
     * Delete Profile Dashboard Languages
     **********************************************/
    jQuery(document).on('click', '.delete_profile_lang', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        jQuery.confirm({
            'title': delete_lang_title,
            'message': delete_lang_msg,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        _this.parent('.tg-tagdashboard').parent('li').remove();
                    }
                },
                'No': {
                    'class': 'gray',
                    'action': function () {
                        return false;
                    }
                }
            }
        });
    });
	
	
	/*************************************************
     * Add Certification & Awards
     ***********************************************/
    jQuery(document).on('click', '.add-profile-awards', function (e) {
        e.preventDefault();
        var _this = jQuery(this);

        var load_awards = wp.template('load-awards');
        var counter = jQuery('.profile-awards-wrap > div').length;
        var current_uploader = counter + 1;
        var load_awards = load_awards(counter);
        _this.parents('.tg-certificatesawards').find('.profile-awards-wrap').append(load_awards);
    });

    /*************************************************
     * Edit Certification & Awards
     ***********************************************/
    jQuery(document).on('click', '.tg-certificatesawards .edit_awards, .tg-certificatesawards .sp-awards-title', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        _this.parents('.tg-certificatesaward').find('.sp-awards-edit-collapse').slideToggle('slow');
        jQuery('.awards_date').datetimepicker({
            format: localize_vars.calendar_format,
            datepicker: true,
            timepicker: false
        });
    });
	
    /*****************************************************
     * Delete Certification & Awards
     ****************************************************/
    jQuery(document).on('click', '.tg-certificatesawards .delete_awards', function () {
        var _this = jQuery(this);
        jQuery.confirm({
            'title': delete_award,
            'message': delete_award_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        _this.parents('.tg-certificatesaward').remove();
                        _this.parents('.sp-awards-edit-collapse').remove();
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
	
	
	jQuery(document).on('click','.upload-award-photo', function () {
		var $ = jQuery;
		var _this = jQuery(this);
		var custom_uploader = wp.media({
			multiple: false
		}).on('select', function () {
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			
			var _full	= attachment.url;;
			var _banner	= attachment.url;;
			var _thumb	= attachment.url;;
			var _id		= attachment.id;;

			if( typeof(attachment.sizes['thumbnail']) != "undefined" && attachment.sizes['thumbnail'] !== null) {
				_thumb	= attachment.sizes['thumbnail']['url'];
				_banner	= attachment.sizes['thumbnail']['url'];
			}
			
			jQuery(_this).parents('.tg-box').find('.award_hidden_id').val(_id);
			jQuery(_this).parents('.tg-box').find('.award_hidden_thumb').val(_thumb);
			jQuery(_this).parents('.tg-box').find('.award_hidden_banner').val(_banner);
			jQuery(_this).parents('.tg-box').find('.award_hidden_full').val(_full);
											
			var data = {id: _id, thumb: _thumb, banner: _banner, full: _full};
			
			var load_award_thumb = wp.template('load-profile-award-thumb');
			var load_award_thumb = load_award_thumb(data);
			jQuery(_this).parents('.tg-box').find('.tg-galleryimages').html(load_award_thumb);
			
			jQuery('.awards-parent-wrap-<?php echo esc_attr($counter_awards); ?> .sp-award-photo-thumb').find('img').attr('src', response.banner);
			
		}).open();

	});
	
	/*************************************************
     * Add Experiences
     ***********************************************/
    jQuery(document).on('click', '.add-profile-experience', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var load_experience = wp.template('load-experience');
        var counter = jQuery('.profile-experience-wrap > div').length;
        var load_experience = load_experience(counter);
        _this.parents('.tg-experiences').find('.profile-experience-wrap').append(load_experience);
    });

    /*************************************************
     * Edit Experience
     ***********************************************/
    jQuery(document).on('click', '.tg-experience .edit_experience, .profile-experience-wrap .sp-job-title', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        _this.parents('.tg-experience').find('.sp-experience-edit-collapse').slideToggle('slow');
        jQuery('.start_date').datetimepicker({
            format: localize_vars.calendar_format,
            datepicker: true,
            timepicker: false
        });
        jQuery('.end_date').datetimepicker({
            format:localize_vars.calendar_format,
            datepicker: true,
            timepicker: false
        });
    });
	
	/*****************************************************
     * Delete Experience
     ****************************************************/
    jQuery(document).on('click', '.tg-experience .delete_experience', function () {
        var _this = jQuery(this);
        jQuery.confirm({
            'title': delete_experience,
            'message': delete_experience_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        _this.parents('.tg-experience').remove();
                        _this.parents('.sp-experience-edit-collapse').remove();
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
	
	/*************************************************
     * Add Qualification
     ***********************************************/
    jQuery(document).on('click', '.add-profile-qualification', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var load_qualification = wp.template('load-qualification');
        var counter = jQuery('.profile-qualification-wrap > div').length;
        var load_qualification = load_qualification(counter);
        _this.parents('.tg-qualifications').find('.profile-qualification-wrap').append(load_qualification);
    });

    /*************************************************
     * Edit Qualification
     ***********************************************/
    jQuery(document).on('click', '.tg-qualification .edit_qualification, .tg-qualification .sp-degree-title', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        _this.parents('.tg-qualification').find('.sp-qualification-edit-collapse').slideToggle('slow');
        jQuery('.start_date').datetimepicker({
            format: localize_vars.calendar_format,
            datepicker: true,
            timepicker: false
        });
        jQuery('.end_date').datetimepicker({
            format: localize_vars.calendar_format,
            datepicker: true,
            timepicker: false
        });
    });

    /*****************************************************
     * Delete Qualification
     ****************************************************/
    jQuery(document).on('click', '.tg-qualification .delete_qualification', function () {
        var _this = jQuery(this);
        jQuery.confirm({
            'title': delete_qualification,
            'message': delete_qualification_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        _this.parents('.tg-qualification').remove();
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
    
	
	/*****************************************
     * Add Profile amenities
     ***************************************/
    jQuery(document).on('click', '.add_profile_amenities', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var load_amenity  = wp.template('load-profile-amenities');
        var amenity_key   = _this.parents('.tg-amenitiesfeaturesbox').find('.sp-amenities-select').val();
        var amenity_value = _this.parents('.tg-amenitiesfeaturesbox').find('.sp-amenities-select option:selected').text();
        var errors = false;
		
        if (amenity_key == 0) {
            jQuery.sticky(amenities_select, {classList: 'important', speed: 200, autoclose: 7000});
        } else {
            /*Check if there is already added language then throw error*/
            jQuery(".sp-amenities-wrap li").each(function (index) {
                var _this = jQuery(this);
                var current_key = _this.data('amenities-key');
                if ( current_key === amenity_key ) {
                    jQuery.sticky(amenities_already_add, {classList: 'important', speed: 200, autoclose: 7000});
                    errors = true;
                    return false;
                }
            });
            if (errors == false) {
                var data = {ameni_key: amenity_key, ameni_val: amenity_value};
                var load_amenity = load_amenity(data);
                _this.parents('.tg-amenitiesfeaturesbox').find('.sp-amenities-wrap').append(load_amenity);
            }
        }
    });



    /************************************************
     * Delete Profile Dashboard Amenities
     **********************************************/
    jQuery(document).on('click', '.delete_profile_amenity', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        jQuery.confirm({
            'title': delete_amenity_title,
            'message': delete_amenity_msg,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        _this.parent('.tg-tagdashboard').parent('li').remove();
                    }
                },
                'No': {
                    'class': 'gray',
                    'action': function () {
                        return false;
                    }
                }
            }
        });
    });

	
	/*****************************************
     * Add Profile insurance
     ***************************************/
    jQuery(document).on('click', '.add_profile_insurance', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var load_insurance = wp.template('load-profile-insurance');
        var insurance_key = _this.parents('.sp-insurancefeaturesbox').find('.sp-insurance-select').val();
        var insurance_value = _this.parents('.sp-insurancefeaturesbox').find('.sp-insurance-select option:selected').text();
        var errors = false;
        if (insurance_key == 0) {
            jQuery.sticky(insurance_select, {classList: 'important', speed: 200, autoclose: 7000});
        } else {
            /*Check if there is already added language then throw error*/
            jQuery(".sp-insurance-wrap li").each(function (index) {
                var _this = jQuery(this);
                var current_key = _this.data('insurance-key');
                if ( current_key === insurance_key ) {
                    jQuery.sticky(insurance_already_add, {classList: 'important', speed: 200, autoclose: 7000});
                    errors = true;
                    return false;
                }
            });
            if (errors == false) {
                var data = {insurance_key: insurance_key, insurance_value: insurance_value};
                var load_insurance = load_insurance(data);
                _this.parents('.sp-insurancefeaturesbox').find('.sp-insurance-wrap').append(load_insurance);
            }
        }
    });

    /************************************************
     * Delete Profile Dashboard Amenities
     **********************************************/
    jQuery(document).on('click', '.delete_profile_insurance', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        jQuery.confirm({
            'title': delete_insurance_title,
            'message': delete_insurance_msg,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        _this.parent('.tg-tagdashboard').parent('li').remove();
                    }
                },
                'No': {
                    'class': 'gray',
                    'action': function () {
                        return false;
                    }
                }
            }
        });
    });
	
	/**************************************************
     * Prepare Underscore Template For Dashboard
     * Audio/Video Section..
     *************************************************/
    jQuery(document).on('click', '.add-new-videoslot', function () {
        var _this = jQuery(this);
        var load_video_slot = wp.template('load-media-links');
        _this.parents('.video-slot-wrap').append(load_video_slot);
    });

    /*****************************************************
     * Delete Time Slot Which is Created By Underscore
     ****************************************************/
    jQuery(document).on('click', '.tg-startendtime .delete-video-slot', function () {
        var _this = jQuery(this);
        jQuery.confirm({
            'title': delete_video_link,
            'message': delete_video_link_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        _this.parents('.tg-startendtime').remove();
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
	
	
	/*---------------------------------------------------------------------
	* Z Multi Uploader for gallery
	*---------------------------------------------------------------------*/
	var gallery_frame;

	jQuery('#upload-gallery-photos').on('click', function(event) {

	var $el = jQuery(this);
	event.preventDefault();
	if ( gallery_frame ) {
		gallery_frame.open();
		return;
	}

	// Create the media frame.
	gallery_frame = wp.media.frames.avatar = wp.media({
		title	: $el.data('choose'),
		library  : { type : 'image'},
		button   : {
			text : $el.data('update'),
		},
		states   : [
			new wp.media.controller.Library({
				title		: $el.data('choose'),
				 filterable: 'image',
				multiple	 : true,
			})
		]
	});

	// When an image is selected, run a callback.
	gallery_frame.on( 'select', function() {
		var selection = gallery_frame.state().get('selection');
		selection.map( function( attachment ) {
			attachment = attachment.toJSON();
				if ( attachment.id ) {
					var _full	= attachment.url;;
					var _banner	= attachment.url;;
					var _thumb	= attachment.url;;
					var _id		= attachment.id;;

					if( typeof(attachment.sizes['thumbnail']) != "undefined" && attachment.sizes['thumbnail'] !== null) {
						_thumb	= attachment.sizes['thumbnail']['url'];
						_banner	= attachment.sizes['thumbnail']['url'];
					}

					var data = {id: _id, thumb: _thumb, banner: _banner, full: _full};
					var load_gallery_thumb = wp.template('load-gallery-thumb');
					var _thumb = load_gallery_thumb(data);

					jQuery(".sp-profile-gallery-photos").append(_thumb);
					sp_sort_backend_gallery_images();
				}
			});

		});
		// Finally, open the modal.
		gallery_frame.open();

	});
	
	//sort gallery images
	function sp_sort_backend_gallery_images(){
		jQuery('.sp-profile-gallery-photos .tg-galleryimages').sortable({
			delay: 300,
			opacity: 0.6,
			cursor: 'move',
			placeholder: "spvsort-highlight",
			update: function() {
				var _this = jQuery(this);
				var ids = [];
				var user_id	= _this.parents('.sp-profile-gallery-photos').data('user_id');
				jQuery('.sp-profile-gallery-photos  .tg-galleryimages .tg-galleryimg-item').each(function (index) {
					ids.push(jQuery(this).data('id'));
				});

				var serialize_data = jQuery('.tg-dashboard-privacy-form').serialize();
				jQuery('body').append(loader_html);
				var dataString = 'data='+ids + '&user_id='+user_id + '&action=listingo_backend_update_gallery_order';
				jQuery.ajax({
					type: "POST",
					url: ajaxurl,
					data: dataString,
					dataType: "json",
					success: function (response) {
						jQuery('body').find('.provider-site-wrap').remove();
						jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
					}
				});
			}
		}).disableSelection();;
	}
	sp_sort_backend_gallery_images();
	
	//Remove brochures
	jQuery(document).on('click', '.del-profile-gallery-photo', function (e) {
		 var _this	= jQuery(this);
		 _this.parents('.tg-galleryimg-item').remove();
	});
	
	/*---------------------------------------------------------------------
	* Z Multi Uploader for brochures
	*---------------------------------------------------------------------*/
	var brochures_frame;

	jQuery('#upload-brochure').on('click', function(event) {

		var $el = jQuery(this);
		event.preventDefault();
		if ( brochures_frame ) {
			brochures_frame.open();
			return;
		}

		// Create the media frame.
		brochures_frame = wp.media.frames.avatar = wp.media({
			title	: $el.data('choose'),
			button   : {
				text : $el.data('update'),
			},
			states   : [
				new wp.media.controller.Library({
					title		 : $el.data('choose'),
					filterable	 : 'image',
					multiple	 : true,
				})
			]
		});

	// When an image is selected, run a callback.
	brochures_frame.on( 'select', function() {
		var selection = brochures_frame.state().get('selection');
		selection.map( function( attachment ) {
			attachment = attachment.toJSON();
				if ( attachment.id ) {
					
					var file_type			= attachment.mime;
					var file_title			= attachment.title;
					var file_abspath		= '';
					var file_relpath		= attachment.url;
					var file_id				= attachment.id;

					var file_icon	= 'fa fa-file-o';
					
					if ( file_type === "application/vnd.openxmlformats-officedocument.wordprocessingml.document" ){
						file_icon = 'fa fa-file-word-o';
					} else if ( file_type === "text/plain" ) {
						file_icon = 'fa fa-file-text-o';
					} else if ( file_type === "application/pdf" ) {
						file_icon = 'fa fa-file-pdf-o';
					} else if (file_type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || file_type === 'text/csv' ) {
						file_icon = 'fa fa-file-excel-o';
					} else if ( file_type === "application/vnd.openxmlformats-officedocument.presentationml.presentation" || file_type === "application/vnd.openxmlformats-officedocument.presentationml.slideshow" ) {
						file_icon = 'fa fa-file-powerpoint-o';
					}
					

					var data = {file_type: file_type, file_title: file_title, file_abspath: file_abspath, file_relpath: file_relpath, id: file_id,file_icon: file_icon};
					
					var load_brochures_thumb = wp.template('load-profile-brochure');
					var _brochures = load_brochures_thumb(data);

					jQuery(".sp-profile-brochure").append(_brochures);
					
				}
			});

		});
		// Finally, open the modal. 
		brochures_frame.open();

	});
	
	//Remove brochures
	jQuery(document).on('click', '.sp-profile-brochure .brochure-item .delete_brochure_file', function (e) {
		 var _this	= jQuery(this);
		 _this.parents('li').remove();
	});
	
	/**************************************************
     * Initiate Datetimepicker For Business Hours
     ************************************************/
    jQuery('.business-hours-time').datetimepicker({
        format: 'H:i',
        datepicker: false
    });

    /**************************************************
     * Prepare Underscore Template For Dashboard
     * Business Hours..
     *************************************************/
    jQuery(document).on('click', '.add-new-timeslot', function () {
        var _this = jQuery(this);
        var load_time_slot = wp.template('load-business-hours');
        var business_day = _this.data('business_day');
        var load_time_slot = load_time_slot(business_day);
        _this.parents('.time-slot-wrap').append(load_time_slot);

        //init templated timeslot date

        jQuery('.business-hours-time').datetimepicker({
            format: 'H:i',
            datepicker: false
        });
    });
	
	//Delete Time Slot Which is Created By Underscore
	jQuery(document).on('click', '.tg-startendtime .delete-time-slot', function () {
        var _this = jQuery(this);
        jQuery.confirm({
            'title': delete_business_hour,
            'message': delete_business_hour_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        _this.parents('.tg-startendtime').remove();
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
	
	/*************************************************
     * Add Services
     ***********************************************/

    jQuery(document).on('click', '.add-services', function (e) {
        e.preventDefault();

        var _this = jQuery(this);
        var load_services = wp.template('load-services');
        var counter = jQuery('.sp-services-wrap > div').length;
        var load_services = load_services(counter);
        _this.parents('.tg-dashboardmanageservices').find('.sp-services-wrap').append(load_services);
    });

    /*************************************************
     * Edit Services
     ***********************************************/
    jQuery(document).on('click', '.tg-dashboardservice .edit_service', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        _this.parents('.tg-dashboardservice').find('.sp-services-edit-collapse').slideToggle('slow');
    });
	
    /*****************************************************
     * Delete Services
     ****************************************************/
    jQuery(document).on('click', '.tg-dashboardservice .delete-service', function () {
        var _this = jQuery(this);
        jQuery.confirm({
            'title': delete_service,
            'message': delete_service_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        _this.parents('.tg-dashboardservice').remove();
                    }
                },
                'No': {
                    'class': 'gray',
                    'action': function () {
                        return false;
                    }
                }
            }
        });
    });
	
	/* -------------------------------------
     Packages type
     -------------------------------------- */
	if( jQuery( 'body' ).find( '.woocommerce_options_panel' ) ){
		var select_pack	= jQuery('.sp_package_type').val();
		if( select_pack !== null && select_pack === 'customer' ){
			jQuery('.sp-woo-field').parents('.form-field').show();
			jQuery('.sp_provider').parents('.form-field').hide();
		}else if( select_pack !== null && select_pack === 'provider' ){
			jQuery('.sp-woo-field').parents('.form-field').show();
			jQuery('.sp_provider').parents('.form-field').show();
		} else{
			jQuery('.sp-woo-field').parents('.form-field').hide();
		}
	}
	
	jQuery(document).on('change','.sp_package_type', function (e) {
		var _this	= jQuery(this);
		var _current	= _this.val();	

		if( _current !== null && _current === 'customer' ){
			jQuery('.sp-woo-field').parents('.form-field').show();
			jQuery('.sp_provider').parents('.form-field').hide();
			
		} else if( _current !== null && _current === 'provider' ){
			jQuery('.sp-woo-field').parents('.form-field').show();
			jQuery('.sp_provider').parents('.form-field').show();
		} else{
			jQuery('.sp-woo-field').parents('.form-field').hide();
		}
	});

});

//Init Map
jQuery.listingo_init_map = function (map_lat, map_lng) {
	var mapwrapper = jQuery('#location-pickr-map');

	if (typeof (localize_vars) != "undefined" && localize_vars !== null) {
		var dir_latitude = localize_vars.dir_latitude;
		var dir_longitude = localize_vars.dir_longitude;
		var dir_map_type = localize_vars.dir_map_type;
		var dir_close_marker = localize_vars.dir_close_marker;
		var dir_cluster_marker = localize_vars.dir_cluster_marker;
		var dir_map_marker = localize_vars.dir_map_marker;
		var dir_cluster_color = localize_vars.dir_cluster_color;
		var dir_zoom = localize_vars.dir_zoom;
		var dir_map_scroll = localize_vars.dir_map_scroll;
	} else {
		var dir_latitude  = 51.5001524;
		var dir_longitude = -0.1262362;
		var dir_map_type  = 'ROADMAP';
		var dir_zoom 	  = 12;
		var dir_map_scroll = false;
	}

	if (dir_map_type == 'ROADMAP') {
		var map_id = google.maps.MapTypeId.ROADMAP;
	} else if (dir_map_type == 'SATELLITE') {
		var map_id = google.maps.MapTypeId.SATELLITE;
	} else if (dir_map_type == 'HYBRID') {
		var map_id = google.maps.MapTypeId.HYBRID;
	} else if (dir_map_type == 'TERRAIN') {
		var map_id = google.maps.MapTypeId.TERRAIN;
	} else {
		var map_id = google.maps.MapTypeId.ROADMAP;
	}

	var scrollwheel = true;

	if (dir_map_scroll == 'false') {
		scrollwheel = false;
	}

	mapwrapper.gmap3({
		map: {
			options: {
				panControl: false,
				scaleControl: false,
				navigationControl: false,
				draggable: true,
				scrollwheel: scrollwheel,
				streetViewControl: false,
				center: [map_lat, map_lng],
				zoom: parseInt(dir_zoom),
				mapTypeId: map_id,
				mapTypeControl: true,
				mapTypeControlOptions: {
					style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
					position: google.maps.ControlPosition.RIGHT_BOTTOM
				},
				zoomControl: true,
				zoomControlOptions: {
					position: google.maps.ControlPosition.LEFT_BOTTOM
				},
			},
			callback: function () {
				setTimeout(function () {
					jQuery.listingo_map_fallback();
				}, 300);
			}
		},
		marker: {
			values: [{
					latLng: [map_lat, map_lng],
				}],
			options: {
				draggable: true
			},
			events: {
				dragend: function (marker) {
					jQuery('#location-latitude').val(marker.getPosition().lat());
					jQuery('#location-longitude').val(marker.getPosition().lng());
				},
			},
		}

	});
};
//Call To Add Map
jQuery.listingo_map_fallback = function () {
	var map_div = jQuery('#location-pickr-map').gmap3("get");
	var map_input = document.getElementById("location-address");
	jQuery("#location-address").bind("keypress", function (e) {
		if (e.keyCode == 13) {
			e.preventDefault();
			return false;
		}
	});

	if (typeof (localize_vars) != "undefined" && localize_vars !== null) {
		if (localize_vars.country_restrict !== '') {
			var options = {
				componentRestrictions: {country: localize_vars.country_restrict}
			};

			var autocomplete = new google.maps.places.Autocomplete(map_input, options);
		} else {

			var autocomplete = new google.maps.places.Autocomplete(map_input);
		}
	} else {
		var autocomplete = new google.maps.places.Autocomplete(map_input);
	}

	autocomplete.bindTo("bounds", map_div);

	google.maps.event.addListener(autocomplete, "place_changed", function () {
		var place = autocomplete.getPlace();
		if (!place.geometry) {
			return;
		}

		if (place.geometry.viewport) {
			map_div.fitBounds(place.geometry.viewport);
		} else {
			map_div.setCenter(place.geometry.location);
			//map_div.setZoom(11);
		}
		
		listingo_fetch_user_location(place); //fetch location
		
		jQuery("#location-latitude").val(place.geometry.location.lat());
		jQuery("#location-longitude").val(place.geometry.location.lng());
	});
}

jQuery(document).ready(function(e) {
	
	//Geo Locate
	jQuery(document).on("click",".geolocate",function(){
		jQuery('#location-pickr-map').gmap3({
		  getgeoloc:{
			callback : function(latLng){
			  if (latLng){
				var geocoder = new google.maps.Geocoder();
				geocoder.geocode({"latLng":latLng},function(data,status){
					 if (status == google.maps.GeocoderStatus.OK) {
						if (data[0]) {
							jQuery('#location-pickr-map').gmap3({
							  marker:{ 
								latLng:latLng
							  },
							  map:{
								options:{
								  zoom: 11
								}
							  }
							});
							
							var place = data[0];
							listingo_fetch_user_location(place)
										
							jQuery("#location-address").val(data[0].formatted_address);
							jQuery("#location-latitude").val(latLng.lat());
							jQuery("#location-longitude").val(latLng.lng());
						}
					}
				});
			  }
			}
		  }
		});
		return false;
	});
	
	//Show admin order detail
    jQuery('.view-order-detail').on('click', 'a', function () {
		jQuery('.admin-order-detail-wrap').toggleClass('show-order-info');
	});
	
	/* ---------------------------------------
      Modal box Window
     --------------------------------------- */
	jQuery('.order-edit-wrap').on('click',".cus-open-modal", function(event){
		event.preventDefault();
		var _this	= jQuery(this);
		jQuery(_this.data("target")).show();
		jQuery(_this.data("target")).addClass('in');
		jQuery('body').addClass('cus-modal-open');
	});
	
	jQuery('.order-edit-wrap, .withdrawal').on('click',".cus-close-modal", function(event){
		event.preventDefault();
		var _this	= jQuery(this);
		
		jQuery(_this.data("target")).removeClass('in');
		jQuery(_this.data("target")).hide();
		jQuery('body').removeClass('cus-modal-open');
	});
	
	//withdrawal History
	jQuery('.withdrawal').on('click',".cus-open-modal", function(event){
		event.preventDefault();
		var _this	= jQuery(this);
		jQuery(_this.data("target")).show();
		jQuery(_this.data("target")).addClass('in');
		jQuery('body').addClass('cus-modal-open');
		
		var _key	= _this.data('id');
		var dataString = 'userid=' + _key + '&action=listingo_get_withdrawal_history';
		jQuery('#cus-order-modal-'+_key).find('.edit-withdrawal-wrap').html('<div class="inportusers">'+localize_vars.spinner+'</div>');
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: dataString,
			dataType: "json",
			success: function (response) {
				if (response.type == 'error') {
					jQuery('#cus-order-modal-'+_key).find('.edit-withdrawal-wrap').html(response.message);
				} else {
					jQuery('#cus-order-modal-'+_key).find('.edit-withdrawal-wrap').html(response.data);
					
				}
			}
		});
		
	});
	
	//process withdrawal
	jQuery('.withdrawal').on('click',".process-withdrawal", function(event){
		event.preventDefault();
		var _this	= jQuery(this);
		var _key	= _this.data('id');
        jQuery.confirm({
            'title': 'Process this transaction',
            'message': 'Are your sure you want to prcess this transaction. Please note : after this transaction you will be able to process 2nd transaction for this month.',
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
						var _key	= _this.data('id');
						var dataString = 'userid=' + _key + '&action=listingo_process_withdrawal';
						_this.parents('.edit-withdrawal-wrap').find('.widthdrawal-detail').append('<div class="inportusers">'+localize_vars.spinner+'</div>');
						jQuery.ajax({
							type: "POST",
							url: ajaxurl,
							data: dataString,
							dataType: "json",
							success: function (response) {
								_this.parents('.edit-withdrawal-wrap').find('.inportusers').remove();
								if (response.type == 'error') {
									jQuery.sticky(response.message, {classList: 'error', speed: 200, autoclose: 5000});
								} else {
									jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
									jQuery('.widthdrawal-head').html(response.message);
								}
							}
						});
                    }
                },
                'No': {
                    'class': 'gray',
                    'action': function () {
                        return false;
                    }
                }
            }
        });
		
	});
	
	
});


//Fetch country and city from locations and save it
function listingo_fetch_user_location(data){
	var spinner = localize_vars.spinner;
	var place = data;
	var componentForm = {
	  locality: 'long_name',
	  administrative_area_level_1: 'short_name',
	  country: 'long_name',
	  postal_town: 'short_name',
	};
	
	for (var component in componentForm) {
		document.getElementById(component).value = '';
	}
	
	for (var i = 0; i < place.address_components.length; i++) {
		var addressType = place.address_components[i].types[0];

		if (componentForm[addressType]) {
		  var val = place.address_components[i][componentForm[addressType]];
		  document.getElementById(addressType).value = val;
		}
		// for the country, get the country code (the "short name") also
		if (addressType == "country") {
		  document.getElementById("country_code").value = place.address_components[i].short_name;
		}
	}

	var obj = {};
	jQuery(".sp-data-location input[type=hidden]").each(function() {
		var _this	= jQuery(this);
		var _key	= _this.data('key');
		obj[_key] = _this.val();
	});

	if(obj && !jQuery.isEmptyObject(obj)){
		var serialize_data = obj;
		
		var json = JSON.stringify(obj);
		var dataString = 'location='+json+'&action=listingo_update_user_location';
		jQuery('.sp-city-wrap').append(spinner);
		
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: dataString,
			dataType: "json",
			success: function (response) {
				jQuery('.sp-city-wrap').find('img.sp-spin').remove();
				
				if (response.type == 'success') {
					//jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
					
					jQuery(".sp-country-select").html(response.countries);
                    jQuery(".sp-country-select").val(response.country_slug).trigger("chosen:updated");
					
					jQuery(".sp-city-select").html(response.cities);
                    jQuery(".sp-city-select").val(response.city_slug).trigger("chosen:updated");
					
				} else {
					//jQuery.sticky(response.message, {classList: 'important', speed: 200, autoclose: 5000});
				}
			}
		});
	}
}