//"use strict";
jQuery(document).on('ready', function () {
    var loader_html = '<div class="provider-site-wrap"><div class="provider-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';
    var delete_ad_title = fw_ext_ads_scripts_vars.delete_ad_title;
    var delete_ad_msg = fw_ext_ads_scripts_vars.delete_ad_msg;
	var delete_all_ad_title = fw_ext_ads_scripts_vars.delete_all_ad_title;
    var delete_all_ad_msg = fw_ext_ads_scripts_vars.delete_all_ad_msg;
	var listingo_featured_nounce	= fw_ext_ads_scripts_vars.listingo_featured_nounce;
	var file_upload_title	= fw_ext_ads_scripts_vars.file_upload_title;
	var is_loggedin = fw_ext_ads_scripts_vars.is_loggedin;
    var fav_message = fw_ext_ads_scripts_vars.fav_message;
	var sp_upload_nonce = scripts_vars.sp_upload_nonce;
    var is_loggedin = fw_ext_ads_scripts_vars.is_loggedin;
    var sp_upload_gallery = scripts_vars.sp_upload_gallery;

	//ad collaps
	jQuery(document).on('click', '.spv-collap-config', function (event) {
		event.preventDefault();
		_this	= jQuery(this);
		console.log('asd');
		_this.parents('.tg-dashboardtitle').next('.spv-ads-config').toggle();
	});
	
	//Add to favorites
	jQuery(document).on('click', '.sp-save-ad', function (event) {
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
			data: 'wl_id=' + wl_id + '&action=listingo_save_favorite_ads',
			dataType: "json",
			success: function (response) {
				jQuery('body').find('.provider-site-wrap').remove();

				if (response.type == 'success') {
					jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
					_this.removeClass('sp-save-ad');
					_this.addClass('tg-liked');
                    _this.children('span').text(response.total + ' Added');
				} else {
					jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
				}
			}
		});
	});

	
    //Add/Edit new Ad
    jQuery(document).on('click', '.process-ad', function (e) {
        e.preventDefault();
        if( typeof tinyMCE === 'object' ) {
		  tinyMCE.triggerSave();
		}
		
        var _this = jQuery(this);
        var _type = _this.data('type');
        var serialize_data = jQuery('.tg-addad').serialize();
        var dataString = 'type=' + _type + '&' + serialize_data + '&action=fw_ext_listingo_process_ads';
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: fw_ext_ads_scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                if( _type == 'update' ) {
                    jQuery('.tg-remove-gallery-media').remove();
                }
                if (response.type == 'error') {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                } else {                 
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
					if (response.return_url) {                      
						window.location.replace(response.return_url);                  
					}
                }
            }
        });
        return false;
    });
	
    //Delete Ad
    jQuery(document).on('click', '.btn-ad-del', function (event) {
        event.preventDefault();
        var _this = jQuery(this);
        var _id = _this.data('key');
        jQuery.confirm({
            'title': delete_ad_title,
            'message': delete_ad_msg,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        jQuery('body').append(loader_html);
                        jQuery.ajax({
                            type: "POST",
                            url: fw_ext_ads_scripts_vars.ajaxurl,
                            data: 'id=' + _id + '&action=fw_ext_listingo_delete_ads',
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
	
	//Delete Ad
    jQuery(document).on('click', '.btn-ad-del-favorite', function (event) {
        event.preventDefault();
        var _this = jQuery(this);
        var _key = _this.data('key');
		var _type = _this.data('type');
		
		if( _type === 'all' ){
			var ad_title	= delete_all_ad_title;
			var ad_msg		= delete_all_ad_msg;
		} else{
			var ad_title	= delete_ad_title;
			var ad_msg		= delete_ad_msg;
		}
		
        jQuery.confirm({
            'title': ad_title,
            'message': ad_msg,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        jQuery('body').append(loader_html);
                        jQuery.ajax({
                            type: "POST",
                            url: fw_ext_ads_scripts_vars.ajaxurl,
                            data: 'id=' + _key + '&type=' + _type + '&action=listingo_delete_favorite_ads',
                            dataType: "json",
                            success: function (response) {
                                jQuery('body').find('.provider-site-wrap').remove();
                                if (response.type == 'success') {
                                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
                                    if( _type === 'all' ){
										jQuery('.job-listing-wrap').remove();
										jQuery('.btn-ad-del-favorite').remove();
									}else{
										_this.parents('tr').remove();
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

    
    //Sort Ads
    jQuery(document).on('change', '.sort_by, .order_by', function (event) {
        jQuery(".form-sort-ads").submit();
    });

    //Add Ad Tags
    jQuery(document).on('click', '.add-ad-tags', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var _input = jQuery('.input-feature');
		var _inputval = jQuery('.input-feature').val();
		
		if( _inputval ){
			var load_tags = wp.template('load-ad-tags');
			var load_tags = load_tags(_inputval);
			_this.parents('.tg-addallowances').find('.sp-feature-wrap').append(load_tags);
			_input.val('');
		}
        
    });

    //Delete Ad Tags
    jQuery(document).on('click', '.delete_ad_tags', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        _this.parents('li').remove();
    });
	
	//Init Plupupload
    if (jQuery(".tg-review-info-holder").length) {
        var uploaderArguments = {
            browse_button: 'upload-ad-comment-photos', // this can be an id of a DOM element or the DOM element itself
            file_data_name: 'sp_image_uploader',
            container: 'plupload-ad-comment-container',
            drop_element: 'upload-ad-comment-photos',
            multipart_params: {
                "type": "profile_ad",
            },
            url: scripts_vars.ajaxurl + "?action=listingo_temp_image_uploade&nonce=" + sp_upload_nonce,
            filters: {
                mime_types: [
                    {title: sp_upload_gallery, extensions: "jpg,jpeg,gif,png"}
                ],
                max_file_size: 9999999999,
                prevent_duplicates: false
            }
        };
		
		//uploader init
        var commentUploader = new plupload.Uploader(uploaderArguments);
        commentUploader.init();

        //Bind
        commentUploader.bind('FilesAdded', function (up, files) {
            var _thumb = "";
            plupload.each(files, function (file) {
                _thumb += '<div class="tg-galleryimg ad-item ad-thumb-item" id="thumb-' + file.id + '">' + '' + '</div>';
            });

            jQuery('.sp-profile-ad-photos .tg-galleryimages').append(_thumb);
            up.refresh();
            commentUploader.start();
        });

        //Bind
        commentUploader.bind('UploadProgress', function (up, file) {
            if ( jQuery("#thumb-" + file.id).children().length > 0 ) { return false;}
            
            jQuery('.ad-thumb-item').addClass('tg-uploading');
            jQuery("#thumb-" + file.id).append('<figure class="comment-gallery user-avatar"><span class="tg-loader"><i class="fa fa-spinner"></i></span><span class="tg-uploadingbar"><span class="tg-uploadingbar-percentage" style="width:' + file.percent + 'px;"></span></span></figure>');
        });


        //Error
        commentUploader.bind('Error', function (up, err) {
            jQuery.sticky(err.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
        });


        //display data
        commentUploader.bind('FileUploaded', function (up, file, ajax_response) {
            var response = $.parseJSON(ajax_response.response);
            if (response.type === 'success') {
                var load_ad_thumb = wp.template('load-comment-ad-thumb');
                var _thumb = load_ad_thumb(response);
                jQuery("#thumb-" + file.id).html(_thumb);
            } else {
                jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                jQuery("#thumb-" + file.id).remove();
            }
            
            listingo_uploader_progressbar('','remove');
        });
    
    }
    //Delete Gallery Image
    jQuery(document).on('click', '.tg-ad-comment-gallery .del-profile-ad-photo', function (e) {
        e.preventDefault();
        var _this = jQuery(this);                
        var attach_id = _this.parents('.ad-thumb-item').find('img').attr('src');       
        var dataString = 'url=' + attach_id + '&action=listingo_delete_ad_comment_image';
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();                
                if (response.type === 'success') {
                    _this.parents('.ad-thumb-item').remove();                    
                } else {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });
    });

    //Like/Dislike Comment
    jQuery('.tg-add-ad-like').on('click', function(e){
        e.preventDefault();
        var _this = jQuery(this);
        var is_loggedin = fw_ext_ads_scripts_vars.is_loggedin;
        var fav_message = fw_ext_ads_scripts_vars.fav_message;    
        if (is_loggedin == 'false') {
            jQuery.sticky(fav_message, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000});
            return false;
        }
        var commentID = _this.data('id'); 
        var postID = _this.data('post');  
        var type    = _this.data('type');  
        var dataString = 'post=' + postID + '&id=' + commentID + '&type=' + type +'&action=listingo_like_dislike_comment';
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
                    jQuery( _this ).children('i').text(' ' + response.total + ' ');
                    jQuery( _this ).removeClass('tg-add-ad-like');
                } else {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });

    });

    //Submit Comment
    jQuery('.tg-send-comment').on('click', function(e){
        e.preventDefault();
        var _this = jQuery(this);
        var is_loggedin = fw_ext_ads_scripts_vars.is_loggedin;
        var fav_message = fw_ext_ads_scripts_vars.fav_message;    
        if (is_loggedin == 'false') {
            jQuery.sticky(fav_message, {classList: 'important',position:'center-center', speed: 200, autoclose: 7000});
            return false;
        }
        var serialize_data = jQuery('.tg-ad-comment').serialize();
        jQuery('body').append(loader_html);           
        var dataString = serialize_data + '&action=listingo_add_ads_comment';      
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
                    location.reload();
                } else {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });

    });    

    //Ad Form Submision 
    jQuery(document).on('click', '.tg-submit-ad-form', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var serialize_data = jQuery('.tg-adform').serialize();
        var dataString = serialize_data + '&action=listingo_ad_contact_form';
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
                    _this.parents('.tg-adform').get(0).reset();
                } else {
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });
        return false;
    });    

});
