//"use strict";
jQuery(document).ready(function ($) {

    /*******************************************************
     * Localize Script Variales
     *****************************************************/
    var sp_upload_nonce = scripts_vars.sp_upload_nonce;
    var sp_upload_profile = scripts_vars.sp_upload_profile;
    var sp_upload_banner = scripts_vars.sp_upload_banner;
    var sp_upload_gallery = scripts_vars.sp_upload_gallery;
    var sp_upload_awards = scripts_vars.sp_upload_awards;
    var sp_upload_brochure = scripts_vars.sp_upload_brochure;
    var data_size_in_kb = scripts_vars.data_size_in_kb;
    var appointment_check = scripts_vars.appointment_check;
    var free_check = scripts_vars.free_check;
    var delete_business_hour = scripts_vars.delete_business_hour;
    var delete_business_hour_message = scripts_vars.delete_business_hour_message;
    var delete_video_link = scripts_vars.delete_video_link;
    var delete_video_link_message = scripts_vars.delete_video_link_message;
    var delete_award = scripts_vars.delete_award;
    var delete_award_message = scripts_vars.delete_award_message;
    var delete_experience = scripts_vars.delete_experience;
    var delete_experience_message = scripts_vars.delete_experience_message;
    var delete_qualification = scripts_vars.delete_qualification;
    var delete_qualification_message = scripts_vars.delete_qualification_message;
    var delete_service = scripts_vars.delete_service;
    var delete_service_message = scripts_vars.delete_service_message;
    var delete_message = scripts_vars.delete_message;
    var deactivate = scripts_vars.deactivate;
    var delete_title = scripts_vars.delete_title;
    var deactivate_title = scripts_vars.deactivate_title;
    var avatar_active_title = scripts_vars.avatar_active_title;
    var avatar_active_message = scripts_vars.avatar_active_message;
    var banner_active_title = scripts_vars.banner_active_title;
    var banner_active_message = scripts_vars.banner_active_message;
    var language_select = scripts_vars.language_select;
    var language_already_add = scripts_vars.language_already_add;
    var amenities_select = scripts_vars.amenities_select;
    var amenities_already_add = scripts_vars.amenities_already_add;
    var delete_amenity_title = scripts_vars.delete_amenity_title;
    var delete_amenity_msg = scripts_vars.delete_amenity_msg;
    var delete_lang_title = scripts_vars.delete_lang_title;
    var delete_lang_msg = scripts_vars.delete_lang_msg;

    var insurance_select = scripts_vars.insurance_select;
    var insurance_already_add = scripts_vars.insurance_already_add;
    var delete_insurance_title = scripts_vars.delete_insurance_title;
    var delete_insurance_msg = scripts_vars.delete_insurance_msg;
    var no_favorite = scripts_vars.no_favorite;
    var delete_favorite = scripts_vars.delete_favorite;
    var delete_favorite_message = scripts_vars.delete_favorite_message;
    var infomation = scripts_vars.infomation;
	
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
	var allowed_photos	   = scripts_vars.allowed_photos;
	var allowed_videos	   = scripts_vars.allowed_videos;
	var upload_message	   = scripts_vars.upload_message;
	var upload_alllowed_message	   = scripts_vars.upload_alllowed_message;
	var video_limit	   = scripts_vars.video_limit;
	var no_results_text	   = scripts_vars.no_results_text;
    var placeholder_text_single = scripts_vars.placeholder_text_single;
	var request_category_title = scripts_vars.request_category_title;
	var request_category_desc = scripts_vars.request_category_desc;

    loader_html = '<div class="provider-site-wrap"><div class="provider-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';
	
	if( calendar_locale  && calendar_locale != null){
		jQuery.datetimepicker.setLocale(calendar_locale);
		moment.locale(calendar_locale);
	}

	//appointment search
	jQuery(document).ready(function () {
		var date = listingo_getUrlParam('appointment_date');
        jQuery('#tg-datepicker').datepicker(
			{
				dateFormat: "yy-mm-dd",
				defaultDate: date,
				onSelect: function (dateText, inst) {
					var _this = jQuery(this);
					var date = _this.val();
				   jQuery('.sp-appointment-form-search').find('.set_appt_date').val(date);
				   jQuery('.sp-appointment-form-search').submit();
				}
        });
		
        jQuery(document).on('change', '.sp-sortby, .sp-orderby, .sp-showposts, .sp-appointment-status', function (event) {
            jQuery('.sp-appointment-form-search').submit();
        });
    });
	
	//Package expiry
	jQuery('.expirydate').datetimepicker({
        format: scripts_vars.calendar_format,
        datepicker: true,
        timepicker: false,
        minDate: new Date(),
		dayOfWeekStart:scripts_vars.startweekday
    });
	
	
	//Request to change category
	jQuery(document).on('click', '.request-change-category', function () {
        var _this = jQuery(this);
        $.confirm({
            'title': request_category_title,
            'message': request_category_desc,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        var serialize_data = jQuery('.user-request-form').serialize();
						jQuery('body').append(loader_html);
						var dataString = serialize_data + '&action=listingo_request_to_change_category';
						jQuery.ajax({
							type: "POST",
							url: scripts_vars.ajaxurl,
							data: dataString,
							dataType: "json",
							success: function (response) {
								jQuery('body').find('.provider-site-wrap').remove();
								if (response.type === 'success') {	
									jQuery('.user-request-form').get(0).reset();
									jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
								} else{
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
	
	//Gallery Sortable
	function sp_sort_gallery_images(){
		jQuery('.sp-profile-gallery-photos .tg-galleryimages').sortable({
			delay: 300,
			opacity: 0.6,
			cursor: 'move',
			update: function() {
				var _this = jQuery(this);
				var ids = [];
				jQuery('.sp-profile-gallery-photos  .tg-galleryimages .tg-galleryimg-item').each(function (index) {
					ids.push(jQuery(this).data('id'));
				});

				var serialize_data = jQuery('.tg-dashboard-privacy-form').serialize();
				jQuery('body').append(loader_html);
				var dataString = 'data='+ids + '&action=listingo_update_gallery_order';
				jQuery.ajax({
					type: "POST",
					url: scripts_vars.ajaxurl,
					data: dataString,
					dataType: "json",
					success: function (response) {
						jQuery('body').find('.provider-site-wrap').remove();
						jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
					}
				});
			}
		});
	}
	sp_sort_gallery_images();
	
	
    /*********************************************
     * User Dashboard Privacy Settings
     *******************************************/
    jQuery(document).on('change', '.dashboard-privacy', function () {
        var _this = jQuery(this);
        var serialize_data = jQuery('.tg-dashboard-privacy-form').serialize();
        jQuery('body').append(loader_html);
        var dataString = serialize_data + '&action=listingo_save_privacy_settings';
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
            }
        });
    });
	
	/*********************************************
     * User Dashboard withdrawal settings
     *******************************************/
    jQuery(document).on('click', '.update-withdrawal', function () {
        var _this = jQuery(this);
        var serialize_data = jQuery('form.payment_mods').serialize();
        jQuery('body').append(loader_html);
        var dataString = serialize_data + '&action=listingo_save_withdrawal_settings';
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
            }
        });
    });

    /**************************************************
     * Initiate Datetimepicker For Business Hours
     ************************************************/
    jQuery('.business-hours-time').datetimepicker({
        format: 'H:i',
        datepicker: false,
		dayOfWeekStart:scripts_vars.startweekday
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
            datepicker: false,
			dayOfWeekStart:scripts_vars.startweekday
        });
    });

    /*****************************************************
     * Delete Time Slot Which is Created By Underscore
     ****************************************************/
    jQuery(document).on('click', '.tg-startendtime .delete-time-slot', function () {
        var _this = jQuery(this);
        $.confirm({
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

    /*********************************************
     * User Dashboard Business Hours
     *******************************************/
    jQuery(document).on('click', '.update-business-hours', function () {
        var _this = jQuery(this);
        var serialize_data = jQuery('.tg-business-hours-form').serialize();
        jQuery('body').append(loader_html);
        var dataString = serialize_data + '&action=listingo_save_business_hours_settings';
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
				jQuery('body').find('.provider-site-wrap').remove();
				if (response.type === 'success') {	
					jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
				} else{
					jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
				}
            }
        });
    });


    /*********************************************************
     * @Profile Images Uploader
     * @Profile images update code
     ********************************************************/
    var uploaderArguments = {
        browse_button: 'upload-profile-photo', // this can be an id of a DOM element or the DOM element itself
        file_data_name: 'sp_image_uploader',
        container: 'plupload-profile-container',
        runtimes: 'html5',
        drop_element: 'upload-profile-photo',
        multipart_params: {
            "type": "profile_photo",
        },
        url: scripts_vars.ajaxurl + "?action=listingo_image_uploader&nonce=" + sp_upload_nonce,
        filters: {
            mime_types: [
                {title: sp_upload_profile, extensions: "jpg,jpeg,gif,png"}
            ],
            max_file_size: data_size_in_kb,
            prevent_duplicates: false
        }
    };

    var ProfileUploader = new plupload.Uploader(uploaderArguments);
    ProfileUploader.init();
	
	//bind
    ProfileUploader.bind('FilesAdded', function (up, files) {
        var _thumb = "";
        plupload.each(files, function (file) {
            _thumb += '<div class="tg-galleryimg gallery-item gallery-thumb-item" id="thumb-' + file.id + '">' + '' + '</div>';
        });

        jQuery('.sp-profile-photo').append(_thumb);
        up.refresh();
        ProfileUploader.start();
    });

    //bind
    ProfileUploader.bind('UploadProgress', function (up, file) {
		
		if ( jQuery("#thumb-" + file.id).children().length > 0 ) { return false;}
		
        jQuery('.gallery-thumb-item').addClass('tg-uploading');
		jQuery("#thumb-" + file.id).append('<figure class="user-avatar"><span class="tg-loader"><i class="fa fa-spinner"></i></span><span class="tg-uploadingbar"><span class="tg-uploadingbar-percentage" style="width:' + file.percent + 'px;"></span></span></figure>');
		
		listingo_uploader_progressbar(file.percent,'add');
        
    });

    //Error
    ProfileUploader.bind('Error', function (up, err) {
        jQuery.sticky(err.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
    });


    //display data
    ProfileUploader.bind('FileUploaded', function (up, file, ajax_response) {

        var response = $.parseJSON(ajax_response.response);
        if (response.type === 'success') {
            var load_profile_thumb = wp.template('load-profile-thumb');
            var _thumb = load_profile_thumb(response);
            jQuery("#thumb-" + file.id).html(_thumb);
            if (response.is_replace === 'yes') {
                jQuery('.sp-user-profile-img').find('img').attr('src', response.thumbnail);
            }
        } else {
			jQuery("#thumb-" + file.id).remove();
            jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
        }
		
		listingo_uploader_progressbar('','remove');
    });
	

    //Delete Gallery Image
    jQuery(document).on('click', '.sp-profile-photo .del-profile-photo', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var type = _this.parents('.tg-gallery').find('.sp-profile-photo').data('image_type');
        var attach_id = _this.parents('.tg-galleryimg').data('id');
        var dataString = 'id=' + attach_id + '&image_type=' + type + '&action=listingo_delete_profile_image';
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                if (response.type === 'success') {
					_this.parents('.tg-galleryimg').remove();
                    _this.parents('.tg-galleryimg').find('img').attr('src', response.avatar);
                    jQuery('.sp-user-profile-img').find('img').attr('src', response.avatar);
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
                } else {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });
    });

    //Active the profile user avatar
    jQuery(document).on('click', '.sp-profile-photo .active-profile-photo', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var avatar_id = _this.parents('.tg-galleryimg').data('id');
        var type = _this.parents('.sp-profile-photo').data('image_type');
        $.confirm({
            'title': avatar_active_title,
            'message': avatar_active_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        jQuery('body').append(loader_html);
                        jQuery('.tg-galleryimg').removeClass('active');
                        jQuery.ajax({
                            type: "POST",
                            url: scripts_vars.ajaxurl,
                            data: 'id=' + avatar_id + '&image_type=' + type + '&action=listingo_set_profile_image',
                            dataType: "json",
                            success: function (response) {
                                jQuery('body').find('.provider-site-wrap').remove();
                                if (response.type == 'success') {
                                    _this.parents('.tg-galleryimg').addClass('active');
                                    jQuery('.sp-user-profile-img').find('img').attr('src', response.avatar);
                                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 7000 });
                                } else {
                                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000});
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

    /*********************************************************
     * @Profile Banner Images Uploader
     * @Profile Banner images update code
     ********************************************************/
    var uploaderArguments = {
        browse_button: 'upload-profile-banner-photo', // this can be an id of a DOM element or the DOM element itself
        file_data_name: 'sp_image_uploader',
        container: 'plupload-banner-container',
        drop_element: 'upload-profile-banner-photo',
        multipart_params: {
            "type": "profile_banner_photo",
        },
        url: scripts_vars.ajaxurl + "?action=listingo_image_uploader&nonce=" + sp_upload_nonce,
        filters: {
            mime_types: [
                {title: sp_upload_banner, extensions: "jpg,jpeg,gif,png"}
            ],
            max_file_size: data_size_in_kb,
            prevent_duplicates: false
        }
    };

    var BannerUploader = new plupload.Uploader(uploaderArguments);
    BannerUploader.init();

    //Bind
    BannerUploader.bind('FilesAdded', function (up, files) {
        var bannerThumb = "";
        plupload.each(files, function (file) {
            bannerThumb += '<div class="tg-galleryimg gallery-item gallery-thumb-item" id="thumb-' + file.id + '">' + '' + '</div>';
        });

        jQuery('.sp-profile-banner-photos').append(bannerThumb);
        up.refresh();
        BannerUploader.start();
    });

    //Bind
    BannerUploader.bind('UploadProgress', function (up, file) {
		if ( jQuery("#thumb-" + file.id).children().length > 0 ) { return false;}
        jQuery('.gallery-thumb-item').addClass('tg-uploading');
        jQuery("#thumb-" + file.id).append('<figure class="user-avatar"><span class="tg-loader"><i class="fa fa-spinner"></i></span><span class="tg-uploadingbar"><span class="tg-uploadingbar-percentage" style="width:' + file.percent + 'px;"></span></span></figure>');
		
		listingo_uploader_progressbar(file.percent,'add');
    });


    //Error
    BannerUploader.bind('Error', function (up, err) {
        jQuery.sticky(err.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
    });


    //display data
    BannerUploader.bind('FileUploaded', function (up, file, ajax_response) {

        var response = $.parseJSON(ajax_response.response);

         if (response.type === 'success') {
            var load_banner_thumb = wp.template('load-profile-banenr-thumb');
            var _thumb = load_banner_thumb(response);
            jQuery("#thumb-" + file.id).html(_thumb);
            if (response.is_replace === 'yes') {
                jQuery('.sp-profile-banner-img').find('img').attr('src', response.banner);
            }
        } else {
			jQuery("#thumb-" + file.id).remove();
            jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
        }
		
		listingo_uploader_progressbar('','remove');
    });

    //Delete Gallery Image
    jQuery(document).on('click', '.sp-profile-banner-photos .del-profile-banner-photo', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var type = _this.parents('.tg-gallery').find('.sp-profile-banner-photos').data('image_type');
        var attach_id = _this.parents('.tg-galleryimg').data('id');
        var dataString = 'id=' + attach_id + '&image_type=' + type + '&action=listingo_delete_profile_image';
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                _this.parents('.tg-galleryimg').remove();
                if (response.type === 'success') {
                    _this.parents('.tg-galleryimg').find('img').attr('src', response.avatar);
                    jQuery('.tg-widgetprofile .sp-profile-banner-img').find('img').attr('src', response.avatar);
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
                } else {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });
    });

    //Active the profile Banner Photo
    jQuery(document).on('click', '.sp-profile-banner-photos .active-profile-banner', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var avatar_id = _this.parents('.tg-galleryimg').data('id');
        var type = _this.parents('.sp-profile-banner-photos').data('image_type');
        $.confirm({
            'title': banner_active_title,
            'message': banner_active_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        jQuery('body').append(loader_html);
                        jQuery('.tg-galleryimg').removeClass('active');
                        jQuery.ajax({
                            type: "POST",
                            url: scripts_vars.ajaxurl,
                            data: 'id=' + avatar_id + '&image_type=' + type + '&action=listingo_set_profile_image',
                            dataType: "json",
                            success: function (response) {
                                jQuery('body').find('.provider-site-wrap').remove();
                                if (response.type == 'success') {
                                    _this.parents('.tg-galleryimg').addClass('active');
                                    jQuery('.sp-profile-banner-img').find('img').attr('src', response.avatar);
                                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 7000 });
                                } else {
                                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000});
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

    /*********************************************************
     * @Profile Gallery Images Uploader
     * @Profile Gallery images update code
     ********************************************************/
    
    var uploaderArguments = {
        browse_button: 'upload-gallery-photos', // this can be an id of a DOM element or the DOM element itself
        file_data_name: 'sp_image_uploader',
        container: 'plupload-gallery-container',
        drop_element: 'upload-gallery-photos',
        multipart_params: {
            "type": "profile_gallery",
        },
        url: scripts_vars.ajaxurl + "?action=listingo_image_uploader&nonce=" + sp_upload_nonce,
        filters: {
            mime_types: [
                {title: sp_upload_gallery, extensions: "jpg,jpeg,gif,png"}
            ],
            max_file_size: data_size_in_kb,
            prevent_duplicates: false
        }
    };

    var GalleryUploader = new plupload.Uploader(uploaderArguments);
    GalleryUploader.init();

    //Bind
    GalleryUploader.bind('FilesAdded', function (up, files) {
        var _thumb = "";
        plupload.each(files, function (file) {
            _thumb += '<div class="tg-galleryimg gallery-item gallery-thumb-item" id="thumb-' + file.id + '">' + '' + '</div>';
        });

        jQuery('.sp-profile-gallery-photos .tg-galleryimages').append(_thumb);
        up.refresh();
        GalleryUploader.start();
    });

    //Bind
    GalleryUploader.bind('UploadProgress', function (up, file) {
		if ( jQuery("#thumb-" + file.id).children().length > 0 ) { return false;}
		
        jQuery('.gallery-thumb-item').addClass('tg-uploading');
        jQuery("#thumb-" + file.id).append('<figure class="user-avatar"><span class="tg-loader"><i class="fa fa-spinner"></i></span><span class="tg-uploadingbar"><span class="tg-uploadingbar-percentage" style="width:' + file.percent + 'px;"></span></span></figure>');
		
		listingo_uploader_progressbar(file.percent,'add');
    });


    //Error
    GalleryUploader.bind('Error', function (up, err) {
        jQuery.sticky(err.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
    });


    //display data
    GalleryUploader.bind('FileUploaded', function (up, file, ajax_response) {

        var response = $.parseJSON(ajax_response.response);

        if (response.type === 'success') {
            var load_gallery_thumb = wp.template('load-profile-gallery-thumb');
            var _thumb = load_gallery_thumb(response);
            jQuery("#thumb-" + file.id).html(_thumb);
			sp_sort_gallery_images();
        } else {
            jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
			jQuery("#thumb-" + file.id).remove();
        }
		
		listingo_uploader_progressbar('','remove');
    });

    //Delete Gallery Image
    jQuery(document).on('click', '.sp-profile-gallery-photos .del-profile-gallery-photo', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var type = _this.parents('.tg-gallery').data('image_type');
        var attach_id = _this.parents('.tg-galleryimg').data('id');
        var dataString = 'id=' + attach_id + '&image_type=' + type + '&action=listingo_delete_profile_image';
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                _this.parents('.tg-galleryimg').remove();
                if (response.type === 'success') {
                    _this.parents('.tg-galleryimg').find('img').attr('src', response.avatar);
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
                } else {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });
    });
	
	//Ad gallery
    var uploaderArguments = {
        browse_button: 'upload-ad-photos', // this can be an id of a DOM element or the DOM element itself
        file_data_name: 'sp_image_uploader',
        container: 'plupload-ad-container',
        drop_element: 'upload-ad-photos',
        multipart_params: {
            "type": "profile_ad",
        },
        url: scripts_vars.ajaxurl + "?action=listingo_temp_image_uploade&nonce=" + sp_upload_nonce,
        filters: {
            mime_types: [
                {title: sp_upload_gallery, extensions: "jpg,jpeg,gif,png"}
            ],
            max_file_size: data_size_in_kb,
            prevent_duplicates: false
        }
    };

    var AdUploader = new plupload.Uploader(uploaderArguments);
    AdUploader.init();

    //Bind
    AdUploader.bind('FilesAdded', function (up, files) {
        var _thumb = "";
        plupload.each(files, function (file) {
            _thumb += '<div class="tg-galleryimg tg-galleryimg-item ad-thumb-item" id="thumb-' + file.id + '">' + '' + '</div>';
        });

        jQuery('.sp-profile-ad-photos .tg-galleryimages').append(_thumb);
        up.refresh();
        AdUploader.start();
    });

    //Bind
    AdUploader.bind('UploadProgress', function (up, file) {
		if ( jQuery("#thumb-" + file.id).children().length > 0 ) { return false;}
		
        jQuery('.ad-thumb-item').addClass('tg-uploading');
        jQuery("#thumb-" + file.id).append('<figure class="user-avatar"><span class="tg-loader"><i class="fa fa-spinner"></i></span><span class="tg-uploadingbar"><span class="tg-uploadingbar-percentage" style="width:' + file.percent + 'px;"></span></span></figure>');
    });

    //Error
    AdUploader.bind('Error', function (up, err) {
        jQuery.sticky(err.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
    });

    //display data
    AdUploader.bind('FileUploaded', function (up, file, ajax_response) {
        var response = $.parseJSON(ajax_response.response);

        if (response.type === 'success') {
            var load_ad_thumb = wp.template('load-profile-ad-thumb');
            var _thumb = load_ad_thumb(response);
            jQuery("#thumb-" + file.id).html(_thumb);
			//sp_sort_gallery_images();
        } else {
            jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
			jQuery("#thumb-" + file.id).remove();
        }
		
		listingo_uploader_progressbar('','remove');
    });
	
	//Delete Gallery Image
    jQuery(document).on('click', '.sp-profile-ad-photos .del-profile-ad-photo', function (e) {        
        e.preventDefault();
        jQuery('body').append(loader_html);
        var _this = jQuery(this);    
        _this.closest('.tg-galleryimg-item').remove();
        jQuery('body').find('.provider-site-wrap').remove();
    });
	
    //Award uploader
    function awardupload(current_uploader, image_counter) {

        var uploaderArguments = {
            browse_button: 'upload-award-photo-' + current_uploader, // this can be an id of a DOM element or the DOM element itself
            file_data_name: 'sp_image_uploader',
            container: 'plupload-award-container-' + current_uploader,
            drop_element: 'upload-award-photo-' + current_uploader,
            multipart_params: {
                "type": "profile_award",
            },
            multi_selection: false,
            url: scripts_vars.ajaxurl + "?action=listingo_image_uploader&nonce=" + sp_upload_nonce,
            filters: {
                mime_types: [
                    {title: sp_upload_awards, extensions: "jpg,jpeg,gif,png"}
                ],
                max_file_size: data_size_in_kb,
                max_file_count: 1,
                prevent_duplicates: false
            }
        };

        var AwardUploader = new plupload.Uploader(uploaderArguments);
        AwardUploader.init();
		//bind
        AwardUploader.bind('FilesAdded', function (up, files) {
            var awardThumb = "";
            plupload.each(files, function (file) {
                awardThumb += '<div class="tg-galleryimg gallery-item gallery-thumb-item" id="thumb-' + file.id + '">' + '' + '</div>';
            });

            jQuery('.awards-parent-wrap-' + current_uploader + ' .sp-awards-photo .tg-galleryimages').html(awardThumb);
            up.refresh();
            AwardUploader.start();
        });

        //bind
        AwardUploader.bind('UploadProgress', function (up, file) {
			if ( jQuery("#thumb-" + file.id).children().length > 0 ) { return false;}
            jQuery('.gallery-thumb-item').addClass('tg-uploading');
            jQuery("#thumb-" + file.id).append('<figure class="user-avatar"><span class="tg-loader"><i class="fa fa-spinner"></i></span><span class="tg-uploadingbar"><span class="tg-uploadingbar-percentage" style="width:' + file.percent + 'px;"></span></span></figure>');
			
			listingo_uploader_progressbar(file.percent,'add');
        });


        //Error
        AwardUploader.bind('Error', function (up, err) {
            jQuery.sticky(err.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
        });


        //display data
        AwardUploader.bind('FileUploaded', function (up, file, ajax_response) {

            var response = $.parseJSON(ajax_response.response);

            if ( response.type === 'success' ) {
                var load_award_thumb = wp.template('load-profile-award-thumb');
                var counter = image_counter;
                var data = {count: counter, response: response};
                var load_award_thumb = load_award_thumb(data);
                jQuery("#thumb-" + file.id).html(load_award_thumb);
                jQuery('.awards-parent-wrap-' + current_uploader + ' .sp-award-photo-thumb').find('img').attr('src', response.banner);
            } else {
                jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
            }
			
			listingo_uploader_progressbar('','remove');
        });

        //Delete Award Image
        jQuery(document).on('click', '.sp-awards-photo .del-profile-award-photo', function (e) {
            e.preventDefault();
            var _this = jQuery(this);
            _this.parents('.tg-galleryimg').remove();
        });

    }

    //init
    var brochureArguments = {
        browse_button: 'upload-brochure', // this can be an id of a DOM element or the DOM element itself
        file_data_name: 'sp_file_uploader',
        container: 'plupload-brochure-container',
        drop_element: 'upload-brochure',
        multipart_params: {
            "type": "profile_brochure",
        },
        url: scripts_vars.ajaxurl + "?action=listingo_file_uploader&nonce=" + sp_upload_nonce,
        filters: {
            mime_types: [
                {title: sp_upload_brochure, extensions: "pdf,doc,docx,xls,xlsx,ppt,pptx,csv"}
            ],
            max_file_size: data_size_in_kb,
            prevent_duplicates: false
        }
    };

    var BrochureUploader = new plupload.Uploader(brochureArguments);
    BrochureUploader.init();

    //bind
    BrochureUploader.bind('FilesAdded', function (up, files) {
        var brochureThumbnail = "";
        plupload.each(files, function (file) {
            brochureThumbnail += '<li class="brochure-item brochure-thumb-item added-item" data-brochure_id="" id="thumb-' + file.id + '">' + '' + '</li>';
        });

        jQuery('.sp-profile-brochure').append(brochureThumbnail);
        up.refresh();
        BrochureUploader.start();
    });

    //bind
    BrochureUploader.bind('UploadProgress', function (up, file) {
		if ( jQuery("#thumb-" + file.id).children().length > 0 ) { return false;}
		
        jQuery(".sp-profile-brochure #thumb-" + file.id).html('<em><span class="tg-loader"><i class="fa fa-spinner"></i></span><span class="tg-uploadingbar"><span class="tg-uploadingbar-percentage" style="width:' + file.percent + 'px;"></span></span></em>');
		
		listingo_uploader_progressbar(file.percent,'add');
    });


    //Error
    BrochureUploader.bind('Error', function (up, err) {
        jQuery.sticky(err.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000});
    });


    //display data
    BrochureUploader.bind('FileUploaded', function (up, file, ajax_response) {
        var response = $.parseJSON(ajax_response.response);
        if (response.success) {
            var load_brochure = wp.template('load-profile-brochure');
            var _thumb = load_brochure(response);
            jQuery("#thumb-" + file.id).replaceWith(_thumb);
        } else {
			jQuery("#thumb-" + file.id).remove();
            jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
        }
		
		listingo_uploader_progressbar('','remove');
    });

    //Delete brochure Image
    jQuery(document).on('click', '.sp-profile-brochure .brochure-item .delete_brochure_file', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var type = _this.parents('.sp-profile-brochure').data('file_type');
        var attach_id = _this.parents('.brochure-item').data('brochure_id');
        var dataString = 'id=' + attach_id + '&file_type=' + type + '&action=listingo_delete_profile_file';
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                if (response.type === 'success') {
                    _this.parents('.brochure-item').remove();
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
                } else {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });
    });

    //Update Account Password
    jQuery('.change-account-password-form').on('click', '.do-change-password', function (e) {
        e.preventDefault();
        var $this = jQuery(this);
        var dataString = jQuery('.change-account-password-form').serialize() + '&action=listingo_change_user_password';
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                if (response.type == 'error') {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000});
                } else {
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 7000});
                }
            }
        });
        return false;
    });

    //Deactivate & Activate Account
    jQuery('.deactivate-account-form').on('click', '.do-process-account-status', function (event) {
        event.preventDefault();
        var $this = jQuery(this);
        var process_type = $this.data('action');

        if (process_type == 'deleteme') {
            var message = delete_message;
            var title = delete_title;
        } else if (process_type == 'deactivateme') {
            var message = deactivate;
            var title = deactivate_title;
        } else {
            var message = delete_message;
            var title = delete_title;
        }

        if (process_type == 'activateme') {
            jQuery('body').append(loader_html);
            jQuery.ajax({
                type: "POST",
                url: scripts_vars.ajaxurl,
                data: jQuery('.deactivate-account-form').serialize() + '&process=' + process_type + '&action=listingo_process_account_status',
                dataType: "json",
                success: function (response) {
                    jQuery('body').find('.provider-site-wrap').remove();
                    if (response.type == 'success') {
                        jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 7000 });
                        window.location.reload();
                    } else {
                        jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000});
                    }
                }
            });
        } else {
            $.confirm({
                'title': title,
                'message': message,
                'buttons': {
                    'Yes': {
                        'class': 'blue',
                        'action': function () {
                            jQuery('body').append(loader_html);
                            jQuery.ajax({
                                type: "POST",
                                url: scripts_vars.ajaxurl,
                                data: jQuery('.deactivate-account-form').serialize() + '&process=' + process_type + '&action=listingo_process_account_status',
                                dataType: "json",
                                success: function (response) {
                                    jQuery('body').find('.provider-site-wrap').remove();
                                    if (response.type == 'success') {
                                        jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 7000 });
                                        window.location.reload();
                                    } else {
                                        jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000});
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
        }
    });

    //Language, Amenities & Countries Chosen Select Object
    jQuery(".sp-language-select, .sp-amenities-select, .sp-country-select, .sp-city-select, .sp-insurance-select, .sp-sub-categories").chosen({
        no_results_text: no_results_text, 
        placeholder_text_single:placeholder_text_single,
    });

    
    //Add Profile Languages
    jQuery('.sp-dashboard-profile-form').on('click', '.add_profie_language', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var load_languages = wp.template('load-profile-languages');
        var language_key = _this.parents('.tg-languagesbox').find('.sp-language-select').val();
        var language_value = _this.parents('.tg-languagesbox').find('.sp-language-select option:selected').text();
        var errors = false;
        if (language_key == '') {
            jQuery.sticky(language_select, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000});
        } else {
            /*Check if there is already added language then throw error*/
            jQuery(".sp-languages-wrap li").each(function (index) {
                var _this = jQuery(this);
                var lang_key = _this.data('language-key');
                if (lang_key == language_key) {
                    jQuery.sticky(language_already_add, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000});
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


    //Delete Profile Dashboard Languages
    jQuery(document).on('click', '.delete_profile_lang', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        $.confirm({
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

    //Add Profile amenities
    jQuery('.sp-dashboard-profile-form').on('click', '.add_profile_amenities', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var load_amenity = wp.template('load-profile-amenities');
        var amenity_key = _this.parents('.tg-amenitiesfeaturesbox').find('.sp-amenities-select').val();
        var amenity_value = _this.parents('.tg-amenitiesfeaturesbox').find('.sp-amenities-select option:selected').text();
        var errors = false;
        if (amenity_key == 0) {
            jQuery.sticky(amenities_select, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000});
        } else {
            /*Check if there is already added language then throw error*/
            jQuery(".sp-amenities-wrap li").each(function (index) {
                var _this = jQuery(this);
                var current_key = _this.data('amenities-key');
                if ( current_key === amenity_key ) {
                    jQuery.sticky(amenities_already_add, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000});
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



    //Delete Profile Dashboard Amenities
    jQuery(document).on('click', '.delete_profile_amenity', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        $.confirm({
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

    //Add Profile insurance
    jQuery('.sp-dashboard-profile-form').on('click', '.add_profile_insurance', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var load_insurance = wp.template('load-profile-insurance');
        var insurance_key = _this.parents('.sp-insurancefeaturesbox').find('.sp-insurance-select').val();
        var insurance_value = _this.parents('.sp-insurancefeaturesbox').find('.sp-insurance-select option:selected').text();
        var errors = false;
        if (insurance_key == 0) {
            jQuery.sticky(insurance_select, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000});
        } else {
            /*Check if there is already added language then throw error*/
            jQuery(".sp-insurance-wrap li").each(function (index) {
                var _this = jQuery(this);
                var current_key = _this.data('insurance-key');
                if ( current_key === insurance_key ) {
                    jQuery.sticky(insurance_already_add, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000});
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

    //Delete Profile Dashboard Amenities
    jQuery(document).on('click', '.delete_profile_insurance', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        $.confirm({
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

    //Save Profile Dashboard Settings
    jQuery(document).on('click', '.update-profile-dashboard', function (e) {
        e.preventDefault();

        if( typeof tinyMCE === 'object' ) {
		  tinyMCE.triggerSave();
		}
		
        var _this = jQuery(this);
        var serialize_data = jQuery('.sp-dashboard-profile-form').serialize();
        var dataString = serialize_data + '&action=listingo_process_profile_settings';

        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                if (response.type === 'error') {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                } else {
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
					
					if (typeof listingo_print_data !== 'undefined' && jQuery.isFunction(listingo_print_data)) {
						listingo_print_data(response, _this);
					}
                }
            }
        });
        return false;
    });

    //Prepare Underscore Template For Dashboard
    jQuery(document).on('click', '.add-new-videoslot', function () {
        var _this = jQuery(this);
		var added_videos	= jQuery('.video-slot-wrap').find('.tg-startendtime').length;

		if( added_videos >= allowed_videos ){
			jQuery.sticky(video_limit, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000 });
		} else{
			 var load_video_slot = wp.template('load-media-links');
        	_this.parents('.video-slot-wrap').append(load_video_slot);
		}
    });

    //Delete Time Slot Which is Created By Underscore
    jQuery(document).on('click', '.tg-startendtime .delete-video-slot', function () {
        var _this = jQuery(this);
        $.confirm({
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

        awardupload(current_uploader, counter);
    });

    /*************************************************
     * Edit Certification & Awards
     ***********************************************/
    jQuery(document).on('click', '.tg-certificatesawards .edit_awards, .tg-certificatesawards .sp-awards-title', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        _this.parents('.tg-certificatesaward').find('.sp-awards-edit-collapse').slideToggle('slow');
        jQuery('.awards_date').datetimepicker({
            format: scripts_vars.calendar_format,
            datepicker: true,
            timepicker: false,
			dayOfWeekStart:scripts_vars.startweekday
        });
    });
    /*****************************************************
     * Delete Certification & Awards
     ****************************************************/
    jQuery(document).on('click', '.tg-certificatesawards .delete_awards', function () {
        var _this = jQuery(this);
        $.confirm({
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

    /*Change inputed title in Awards title location*/
    jQuery(document).on('change', '.tg-themeform .sp-awards-title-input', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        _this.parents('.tg-certificatesaward').find('.sp-awards-title').text(_this.val());
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
            format: scripts_vars.calendar_format,
            datepicker: true,
            timepicker: false,
			dayOfWeekStart:scripts_vars.startweekday
        });
        jQuery('.end_date').datetimepicker({
            format: scripts_vars.calendar_format,
            datepicker: true,
            timepicker: false,
			dayOfWeekStart:scripts_vars.startweekday
        });
    });

    /*****************************************************
     * Delete Experience
     ****************************************************/
    jQuery(document).on('click', '.tg-experience .delete_experience', function () {
        var _this = jQuery(this);
        $.confirm({
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

    /*Change inputed title in Experience title location*/
    jQuery(document).on('change', '.tg-formexperience .sp-job-title-input', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        _this.parents('.tg-experience').find('.sp-job-title').text(_this.val());
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
            format: scripts_vars.calendar_format,
            datepicker: true,
            timepicker: false,
			dayOfWeekStart:scripts_vars.startweekday
        });
        jQuery('.end_date').datetimepicker({
            format: scripts_vars.calendar_format,
            datepicker: true,
            timepicker: false,
			dayOfWeekStart:scripts_vars.startweekday
        });
    });

    /*****************************************************
     * Delete Qualification
     ****************************************************/
    jQuery(document).on('click', '.tg-qualification .delete_qualification', function () {
        var _this = jQuery(this);
        $.confirm({
            'title': delete_qualification,
            'message': delete_qualification_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        _this.parents('.tg-qualification').remove();
                        _this.parents('.sp-qualification-edit-collapse').remove();
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

    /*Change inputed title in Qualification title location*/
    jQuery(document).on('change', '.tg-formqualification .sp-degree-title-input', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        _this.parents('.tg-qualification').find('.sp-degree-title').text(_this.val());
    });

    /*************************************************
     * Add Services
     ***********************************************/

    jQuery(document).on('click', '.add-services', function (e) {
        e.preventDefault();

        var _this 			= jQuery(this);
        var load_services 	= wp.template('load-services');
        var counter 		= jQuery('.sp-services-wrap > div').length;
        var load_services 	= load_services(counter);
        _this.parents('.tg-dashboardmanageservices').find('.sp-services-wrap').append(load_services);
		
		jQuery('.sp-services-wrap > .tg-dashboardservice > .sp-services-edit-collapse').hide();
		jQuery('.sp-services-wrap > .tg-dashboardservice > .sp-services-edit-collapse').last().show();
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
        $.confirm({
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

    /*****************************************
     * Fetch Input Fields Data and display
     * in specific html areas for services
     * section.
     ***************************************/
    jQuery(document).on('change', '.tg-themeform .sp-service-title-input', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        _this.parents('.tg-dashboardservice').find('.sp-service-title').text(_this.val());
    });
    jQuery(document).on('click', '.tg-themeform .appointment', function (e) {
        var _this = jQuery(this);
        if (jQuery('.appointment').is(':checked')) {
            _this.parents('.tg-dashboardservice').find('.service_appoint').html(appointment_check);
        } else {
            _this.parents('.tg-dashboardservice').find('.service_appoint').html('');
        }
    });
    jQuery(document).on('click', '.tg-themeform .freeservice', function (e) {
        var _this = jQuery(this);
        var price = jQuery('.sp-service-price-input').val();
        var type  = jQuery('.sp-service-price-type').val();
        var price_val_html = '<span class="sp-price-val">' + price + '</span>';
        var price_type_html = '<span class="sp-price-type">' + type + '</span>';
        if (jQuery('.freeservice').is(':checked')) {
            _this.parents('.tg-dashboardservice').find('.sp-price-wrapper').empty();
            _this.parents('.tg-dashboardservice').find('.sp-price-wrapper').html(free_check);
        } else {
            _this.parents('.tg-dashboardservice').find('.sp-price-wrapper').html(price_val_html + price_type_html);
        }
    });
    jQuery(document).on('change', '.tg-themeform .sp-service-price-input', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var price_value = _this.val();
        _this.parents('.tg-dashboardservice').find('.sp-price-wrapper .sp-price-val').html(price_value);
    });
    jQuery(document).on('change', '.tg-themeform .sp-service-price-type', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var price_type = _this.val();
		var price_type = _this.find(':selected').data('key');
        _this.parents('.tg-dashboardservice').find('.sp-price-wrapper .sp-price-type').html(price_type);
    });

    /*************************************************
     * Save Services Data
     ************************************************/
    jQuery(document).on('click', '.update-services-dashboard', function () {
        var _this = jQuery(this);
        var serialize_data = jQuery('.tg-formaddservices').serialize();

        jQuery('body').append(loader_html);
        var dataString = serialize_data + '&action=listingo_save_services_settings';
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                if (response.type == 'error') {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                } else {
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
                }

            }
        });
    });


    /*************************************************
     * Save Appointment Settings Data
     ************************************************/
    jQuery(document).on('click', '.update-appointment-settings', function () {

        if( typeof tinyMCE === 'object' ) {
		  tinyMCE.triggerSave();
		}
		
        var _this = jQuery(this);
        var serialize_data = jQuery('.tg-appointment-settings-form').serialize();

        jQuery('body').append(loader_html);
        var dataString = serialize_data + '&action=listingo_save_appointment_settings';
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                if (response.type == 'error') {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                } else {
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
                }

            }
        });
    });

    /*************************************************
     * Update Wishlist
     ************************************************/
    jQuery(document).on('click', '.remove-wishlist', function () {
        var _this = jQuery(this);
        var _type = _this.data('type');
        var _wl_id = _this.data('wl_id');
        var dataString = 'type=' + _type + '&wl_id=' + _wl_id + '&action=listingo_remove_wishlist';

        $.confirm({
            'title': delete_favorite,
            'message': delete_favorite_message,
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
                                jQuery('body').find('.provider-site-wrap').remove();
                                if (response.type == 'error') {
                                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                                } else {
                                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
                                    console.log(_type);
                                    if (_type == 'all' && _type != null) {
                                        jQuery('.tg-dashboardappointmentbox').html('<div class="alert alert-info tg-alertmessage fade in"><i class="lnr lnr-flag"></i><span><strong>' + infomation + ' : </strong>' + no_favorite + '</span></div>');
                                        jQuery('.remove-wishlist').remove();
                                    } else {
                                        _this.parents('#wishlist-' + _wl_id).remove();
                                    }

                                    if (jQuery('.tg-dashboardappointmentbox .tg-dashboardappointment').length < 1) {
                                        jQuery('.tg-dashboardappointmentbox').html('<div class="alert alert-info tg-alertmessage fade in"><i class="lnr lnr-flag"></i><span><strong>' + infomation + ' : </strong>' + no_favorite + '</span></div>');
                                    }
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
	
	//Add Default Slots
    jQuery(document).on('click', '.save-time-slots', function (e) {
        e.preventDefault();
        var _this = jQuery(this);

        var day = _this.parents('.sp-daytimeslot').data('day');
        var slot_title = _this.parents('.sp-daytimeslot').find('input[name=slot_title]').val();
        var start_time = _this.parents(".sp-daytimeslot").find('.start_time option:selected').val();
        var end_time   = _this.parents(".sp-daytimeslot").find('.end_time option:selected').val();
        var meeting_time = _this.parents(".sp-daytimeslot").find('.meeting_time option:selected').val();
        var padding_time = _this.parents(".sp-daytimeslot").find('.padding_time option:selected').val();
        var count = _this.parents(".sp-daytimeslot").find('.count option:selected').val();

        jQuery('body').append(loader_html);

        if (start_time == ''
                ||
                end_time == ''
                ||
                meeting_time == ''
                ||
                padding_time == ''
                ) {
            jQuery('body').find('.provider-site-wrap').remove();
            jQuery.sticky(complete_fields, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
            return false;
        }

        var dataString = 'count=' + count + '&day=' + day + '&slot_title=' + slot_title + '&start_time=' + start_time + '&end_time=' + end_time + '&meeting_time=' + meeting_time + '&padding_time=' + padding_time + '&action=listingo_add_time_slots';

        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                if (response.message_type == 'error') {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                } else {
                    _this.parents('.sp-daytimeslot').find('.timeslots-data-area').html(response.slots_data);
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});

                }
            }
        });
        return false;
    });

    //Delete Time Slot
    jQuery(document).on('click', '.delete-current-slot', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var day = _this.data('day');
        var time = _this.data('time');

        if (day == '' || time == '') {
            jQuery.sticky(system_error, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
            return false;
        }

        var dataString = 'day=' + day + '&time=' + time + '&action=listingo_delete_time_slot';

        jQuery.confirm({
            'title': scripts_vars.delete_slot,
            'message': scripts_vars.delete_slot_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        //Process dadtabase item
                        jQuery('body').append(loader_html);

                        jQuery.ajax({
                            type: "POST",
                            url: scripts_vars.ajaxurl,
                            data: dataString,
                            dataType: "json",
                            success: function (response) {
                                jQuery('body').find('.provider-site-wrap').remove();
                                if (response.type == 'error') {
                                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                                } else {
                                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
                                    _this.parents('.tg-radiotimeslot').remove();
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

        return false;
    });

    /*
     * @Invite users
     * @return{}
     */
    jQuery(document).on('click', '.invite-users', function (e) {
        e.preventDefault();
        var _this = jQuery(this);

        var serialize_data = jQuery('.user-invitation-form').serialize();
        var dataString = serialize_data + '&action=listingo_invite_users';
        jQuery('body').append(loader_html);

        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();

                if (response.type === 'error') {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                } else {
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
                    jQueyr('.user-invitation-form').get(0).reset();
                }
            }
        });
        return false;
    });

    //@remove team member
    jQuery(document).on('click', '.remove-team-member', function (event) {
        event.preventDefault();
        var _this = jQuery(this);
        var _id = _this.parents('li').data('id');

        jQuery.confirm({
            'title': scripts_vars.delete_teams,
            'message': scripts_vars.delete_teams_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        jQuery('body').append(loader_html);

                        jQuery.ajax({
                            type: "POST",
                            url: scripts_vars.ajaxurl,
                            data: 'id=' + _id + '&action=listingo_remove_team_member',
                            dataType: "json",
                            success: function (response) {
                                jQuery('body').find('.provider-site-wrap').remove();
                                if (response.type == 'success') {
                                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
                                    _this.parents('#team-' + _id).remove();
                                    if (jQuery('.tg-teammembers-wrap li').length < 1) {
                                        jQuery('.tg-teammembers-wrap').html('<li class="no-team-item"><div class="tg-list"><p>' + scripts_vars.no_team + '</div></li>');
                                    }

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

	
	/***********************************************
     * Add/Edit new job
     **********************************************/
    jQuery(document).on('click', '.process-job', function (e) {
        e.preventDefault();
        if( typeof tinyMCE === 'object' ) {
		  tinyMCE.triggerSave();
		}

        var _this = jQuery(this);
        var _type = _this.data('type');
        var serialize_data = jQuery('.tg-formamanagejobs').serialize();
        var dataString = 'type=' + _type + '&' + serialize_data + '&action=listingo_process_job';

        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                if (response.type == 'error') {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                } else {
                    if (response.return_url) {
                        window.location.replace(response.return_url);
                    }
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
                }
            }
        });
        return false;
    });

    /***********************************************
     * delete job
     **********************************************/
    jQuery(document).on('click', '.btn-job-del', function (event) {
        event.preventDefault();
        var _this = jQuery(this);
        var _id = _this.data('key');

        jQuery.confirm({
            'title': scripts_vars.delete_job_title,
            'message': scripts_vars.delete_job_msg,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        jQuery('body').append(loader_html);

                        jQuery.ajax({
                            type: "POST",
                            url: scripts_vars.ajaxurl,
                            data: 'id=' + _id + '&action=listingo_delete_job',
                            dataType: "json",
                            success: function (response) {
                                jQuery('body').find('.provider-site-wrap').remove();
                                if (response.type == 'success') {
                                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
                                    _this.parents('tr').remove();
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
	
	/*****************************************
     * Add job features
     ***************************************/
    jQuery('.tg-formamanagejobs').on('click', '.add-features', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var _input = jQuery('.input-feature');
		var current_val	= _input.val();
		
		if( current_val ){
			var load_feature = wp.template('load-job-features');
			var load_feature = load_feature(_input.val());
			_this.parents('.tg-addallowances').find('.sp-feature-wrap').append(load_feature);
			_input.val('');
		}   
    });

    /************************************************
     * Delete job feature
     **********************************************/
    jQuery(document).on('click', '.delete_benifit', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        _this.parents('li').remove();
    });
	
	//Add slots
    jQuery(document).on('click', '.add-default-slots', function () {
        var _this = jQuery(this);
        var _form = jQuery(this).parents('.tg-row').find('.timeslots-form-area .default-slot-wrap');

        if (_form.length == 0) {
            var default_slots = wp.template('load-slots');
            _this.parents('.tg-row').find('.timeslots-form-area').append(default_slots);
        }

    });

    //Remove Form
    jQuery(document).on('click', '.remove-slots-form', function () {
        jQuery(this).parents('.default-slot-wrap').remove();
    });

    //Disbale/Enable Timings
    jQuery(document).on('change', 'select[name=start_time]', function (e) {

        var endTimeSelect = jQuery(this).parents('.tg-row').find('select[name=end_time]');
        var startTimeVal = jQuery(this).val();
        endTimeSelect.find('option').removeAttr('disabled');
        endTimeSelect.find('option').each(function () {
            var current = jQuery(this).val();
            if (current <= startTimeVal) {
                jQuery(this).attr('disabled', true);
            }
        });
    });
	
	/*****************************************************
     * Prepare Underscore Template For Appointment Types
     ***************************************************/
    jQuery(document).on('click', '.add-new-appointment-type', function () {
        var _this = jQuery(this);
        var load_appoint_type_slot = wp.template('load-appointment-types');
        _this.parents('.appointment-type-wrap').append(load_appoint_type_slot);
    });

    /*****************************************************
     * Delete Time Slot Which is Created By Underscore
     ****************************************************/
    jQuery(document).on('click', '.tg-startendtime .delete-appointment-type-slot', function () {
        var _this = jQuery(this);
        jQuery.confirm({
            'title': delete_appointment_type_text,
            'message': delete_appointment_type_message,
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

    /*****************************************************
     * Prepare Underscore Template For Appointment Types
     ***************************************************/
    jQuery(document).on('click', '.add-new-appointment-reason', function () {
        var _this = jQuery(this);
        var load_appoint_reason_slot = wp.template('load-appointment-reasons');
        _this.parents('.appointment-reasons-wrap').append(load_appoint_reason_slot);
    });

    /*****************************************************
     * Delete Time Slot Which is Created By Underscore
     ****************************************************/
    jQuery(document).on('click', '.tg-startendtime .delete-appointment-reason-slot', function () {
        var _this = jQuery(this);
        jQuery.confirm({
            'title': delete_appointment_type_reason,
            'message': delete_appointment_type_reason_message,
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

    /*****************************************************
     * Approve Appointments
     ****************************************************/
    jQuery(document).on('click', '.tg-dashboardappointmentbox .tg-appt-approval', function () {
        var _this = jQuery(this);
        var post_id = _this.parents('.tg-dashboardappointmentbox').find('.tg-dashboardappointment').data('postid');
        var dataString = 'post_id=' + post_id + '&action=listingo_set_appointment_approve';
		
		
        jQuery.confirm({
            'title': approve_appt_type,
            'message': approve_appt_type_msg,
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
								jQuery('body').find('.provider-site-wrap').remove();
                                if (response.type === 'success') {
                                    _this.parents('.tg-dashboardappointmentbox').find('.tg-appointmentapprovemodal').modal('hide');
                                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
									window.setTimeout(function () {
                                       window.location.reload();
                                    }, 1000);
                                } else{
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

    /*****************************************************
     * Rejection of an Appointment
     ****************************************************/

    jQuery(document).on('click', '.tg-rejection-model', function () {
        var _this = jQuery(this);
        var load_reject_form = wp.template('load-rejection-form');
        var post_id = _this.parents('.tg-dashboardappointment').data('postid');
        var load_reject_form = load_reject_form(post_id);
        jQuery('.sp-rejectmodal').modal('show');
        jQuery('.sp-rejectmodal').find('.sp-rejection-appt-wrap').html(load_reject_form);

    });

    jQuery(document).on('click', '.tg-appointmentrejectmodal .sp-appt-rejection', function () {
        var _this = jQuery(this);
        var dataString = _this.parents('.tg-appointmentrejectmodal').find('.tg-formreject').serialize() + '&action=listingo_set_appointment_rejection';
        var reject_title = jQuery('input[name="rejection_title"]').val();
        if (reject_title === '' || reject_title == null) {
            jQuery.sticky(sp_rejection_title_field, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
            return false;
        }


        jQuery.confirm({
            'title': reject_appt_type,
            'message': reject_appt_type_msg,
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
								jQuery('body').find('.provider-site-wrap').remove();
                                if (response.type === 'success') {
									jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
                                    jQuery('body').find('.provider-site-wrap').remove();
                                    
									window.setTimeout(function () {
                                       window.location.reload();
                                    }, 1000);
                                } else{
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
	
	//Auto Complete for users
	var timer;
	jQuery('.get_users_list').autoComplete({
		minChars: 1,
		delay: 500,
		cache: true,
		source: function (term, suggest) {

			var term = term.toLowerCase();

			if (term !== '') {
				jQuery('.search-input-wrap').find('.fa-spinner').remove();
				jQuery('.search-input-wrap').append("<i class='fa fa-spinner fa-spin'></i>");
				jQuery.ajax({
					type: "POST",
					url: scripts_vars.ajaxurl,
					data: 'email=' + term + '&action=listingo_get_team_members',
					dataType: "json",
					success: function (response) {

						jQuery('.search-input-wrap').find('.fa-spinner').remove();
						if (response.type === 'success') {
							var Z_TEAMS = {};
							Z_TEAMS.elements = {};
							window.Z_TEAMS = Z_TEAMS;
							Z_TEAMS.elements = jQuery.parseJSON(response.teams_data);

							var data = response.user_json;

							var teamData = [];
							for (var i in data) {
								var item = data[i];
								var outer = [];
								outer.push(data[i]['user_email']);
								outer.push(data[i]['id']);
								outer.push(data[i]['user_link']);
								outer.push(data[i]['username']);
								outer.push(data[i]['full_name']);
								outer.push(data[i]['photo']);

								teamData.push(outer);
							}

							var choices = teamData;

							var suggestions = [];

							for (i = 0; i < choices.length; i++) {
								if (~(choices[i][0] + ' ' + choices[i][3]).toLowerCase().indexOf(term))
									suggestions.push(choices[i]);
							}

							suggest(suggestions);

						} else {
							jQuery.sticky(response.msg, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
						}
					}
				});
			}
		},
		renderItem: function (item, search) {
			search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
			var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");

			return '<div class="autocomplete-suggestion" data-name="' + item[4] + '" data-url="' + item[2] + '" data-photo="' + item[5] + '" data-id="' + item[1] + '" data-val="' + search + '"><div class="searched-item-wrap"><img width="50" height="50" src="' + item[5] + '" /><span class="searched-name">' + item[4].replace(re, "<b>$1</b>") + '</span><a class="searched-add-new" href="javascript:;">' + scripts_vars.add_team + '</a></div></div>';
		},
		onSelect: function (e, term, item) {

			var id 	  = item.data('id');
			var name  = item.data('name');
			var url   = item.data('url');
			var photo = item.data('photo');
			var email = item.data('val');

			jQuery('body').append(loader_html);
			

			var _html = '<li data-id="' + id + '" id="team-' + id + '"><div class="tg-teammember"><a class="tg-btndel remove-team-member" href="javascript:;"><i class="fa fa-close"></i></a><figure><a href="' + url + '"><img width="60" height="60" src="' + photo + '"></a></figure><div class="tg-memberinfo"><h5><a href="' + url + '">' + name + '</a></h5><a href="' + url + '">' + scripts_vars.view_profile + '</a> </div></div></li>';

			jQuery.ajax({
				type: "POST",
				url: scripts_vars.ajaxurl,
				data: 'id=' + id + '&action=listingo_update_team_members',
				dataType: "json",
				success: function (response) {
					jQuery('body').find('.provider-site-wrap').remove();

					if (response.type == 'error') {
						jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
					} else {
						jQuery('.tg-teammembers-wrap').find('li.no-team-item').remove();
						jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
						jQuery('.tg-teammembers-wrap').append(_html);
					}
				}
			});

		}
	});
});

//Get URL param value
function listingo_getUrlVars() {
	var vars = {};
	window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		vars[key] = value;
	});

	return vars;
}

function listingo_getUrlParam(parameter, default_val){
	var param = default_val;
	if(window.location.href.indexOf(parameter) > -1){
		param = listingo_getUrlVars()[parameter];
	}

	return param;
}

/*****************************************************
 * Package Expiry Counter
 ****************************************************/
function listingo_package_counter(_data){
	// Set the date we're counting down to "Dec 31, 2017 24:00:00"
	var countDownDate = new Date(_data).getTime();
	// Update the count down every 1 second
	var x = setInterval(function() {
		// Get todays date and time
		var now = new Date().getTime();
		// Find the distance between now an the count down date
		var distance = countDownDate - now;
		// Time calculations for days, hours, minutes and seconds
		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		// Output the result in an element with id="demo"
		document.getElementById("tg-countdown").innerHTML = "<ul><li><h3>" + days + "</h3><h4>"+scripts_vars.days+"</h4></li><li><h3>" + hours + "</h3><h4>"+scripts_vars.hours+"</h4></li><li><h3>" + minutes + "</h3><h4>"+scripts_vars.minutes+"</h4></li><li><h3>" + seconds + "</h3><h4>"+scripts_vars.seconds+"</h4></li></ul>";
		// If the count down is over, write some text
		if (distance < 0) {
			clearInterval(x);
			document.getElementById("tg-countdown").innerHTML = scripts_vars.expired;
		}
		jQuery('#tg-note').html("<span>"+ days + " "+scripts_vars.days+"</span><span> " + hours + " "+scripts_vars.hours+"</span><span> " + minutes + " "+scripts_vars.min_and+"</span><span> " + seconds + " "+scripts_vars.seconds+"</span>");
	}, 1000);
}

