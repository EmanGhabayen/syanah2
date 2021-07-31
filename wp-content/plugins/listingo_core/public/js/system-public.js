var signin_reset;
var signup_reset;
var signup_reset_provider;
var password_forgot;
jQuery(document).ready(function (e) {
    "use strict";
    var loader_html = '<div class="provider-site-wrap"><div class="provider-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';
	
	var tip_content_bg	   = scripts_vars.tip_content_bg;
	var tip_content_color  = scripts_vars.tip_content_color;
	var tip_title_bg	   = scripts_vars.tip_title_bg;
	var tip_title_color	   = scripts_vars.tip_title_color;
	
    jQuery(document).on('change', '.register_type', function (e) {
        e.preventDefault();
		
        var _this = jQuery(this);
        var _type = _this.val();
        if (_type === 'business') {
            var load_fields = wp.template('load-business');
        } else {
            var load_fields = wp.template('load-indvidual');
        }

        jQuery('.by-category-fields').html(load_fields);

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
		
    });


    /* ---------------------------------------
     registration Ajax
     --------------------------------------- */
    jQuery(document).on('click', '.do-regiter-me', function (event) {
        event.preventDefault();
        var _this = jQuery(this);

        jQuery('body').append(loader_html);
        var _authenticationform = _this.parents('form.do-registration-form').serialize();

        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: _authenticationform + '&action=listingo_user_registration',
            dataType: "json",
            success: function (response) {
                if (response.type == 'success') {
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
					jQuery('form.do-registration-form').get(0).reset();
					window.location.replace(response.redirect);
                } else {
					jQuery('body').find('.provider-site-wrap').remove();
                    if (scripts_vars.captcha_settings === 'enable') {
                        grecaptcha.reset(signup_reset);
						grecaptcha.reset(signup_reset_provider);
                    }
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });
    });
	
    /* ---------------------------------------
     Login Ajax
     --------------------------------------- */
    jQuery(document).on('click', '.do-login-button', function (event) {
        event.preventDefault();
        var _this = jQuery(this);
        jQuery('body').append(loader_html);
        var _serialize = _this.parents('form.do-login-form').serialize();
		
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: _serialize + '&action=listingo_ajax_login',
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                if (response.type === 'success') {
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 500000, position: 'top-right'});
					window.location.replace(response.redirect);
                    
                } else {
                    if (scripts_vars.captcha_settings === 'enable') {
                        grecaptcha.reset(signin_reset);
                    }
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });
    });

    /* ---------------------------------------
     Swap Lost passowrd
     --------------------------------------- */
    jQuery('.sp-forgot-password').on('click', function () {
        // Load up a new modal...
        jQuery('.sp-user-lp-model').modal('show');
    });

    /* ---------------------------------------
     Lost password Ajax
     --------------------------------------- */
    jQuery('.do-forgot-form').on('click', '.do-lp-button', function (event) {
        event.preventDefault();
        var _this = jQuery(this);
        var _email = jQuery('.do-forgot-form').find('.psemail').val();

        jQuery('body').append(loader_html);

        if (!(listingo_isValidEmailAddress(_email))) {
            jQuery('body').find('.provider-site-wrap').remove();
            jQuery.sticky(scripts_vars.valid_email, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
            return false;
        }

        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: jQuery('.do-forgot-form').serialize() + '&action=listingo_ajax_lp',
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.provider-site-wrap').remove();
                if (response.type == 'success') {
                    jQuery('.do-forgot-form').get(0).reset();
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
                    jQuery('.sp-user-lp-model').modal('hide');
                    if (scripts_vars.captcha_settings === 'enable') {
                        grecaptcha.reset(password_forgot);
                    }
                } else {
                    if (scripts_vars.captcha_settings === 'enable') {
                        grecaptcha.reset(password_forgot);
                    }
                    jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
                }
            }
        });
    });

});

/*
 * @get absolute path
 * @return{}
 */
function getAbsolutePath() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
}

/*
 * @Validate email
 * @return{}
 */
function listingo_isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}
;