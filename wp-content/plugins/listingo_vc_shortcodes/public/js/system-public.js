"use strict";
jQuery(document).ready(function (e) {
	var loader_html	= '<div class="gym-site-wrap"><div class="gym-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';

	/*
	 * @Contact Me
	 * @return{}
	*/
	jQuery('.contact_wrap').on('click','.consult_with_me',function(e){
		e.preventDefault();
		var $this 	= jQuery(this);
		
		var email_to	= $this.parents('.contact_wrap').find('.contact_form').data('email');
		var serialize_data	= $this.parents('.contact_wrap').find('.contact_form').serialize();
		var dataString = serialize_data+'&email_to='+email_to+'&action=listingo_vc_shortcodes_contact_me';
		
		$this.parents('.contact_wrap').find('.message_contact').html('').hide();
		jQuery($this).parents('.contact_form').append("<i class='fa fa-refresh fa-spin'></i>");
		$this.parents('.contact_wrap').find('.message_contact').removeClass('alert-success');
		$this.parents('.contact_wrap').find('.message_contact').removeClass('alert-danger');

		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: dataString,
			dataType:"json",
			success: function(response) {
				jQuery($this).parents('.contact_form').find('i').remove();
				jQuery('.message_contact').show();
				if( response.type == 'error' ) {
					$this.parents('.contact_wrap').find('.message_contact').addClass('alert alert-danger').show();
					$this.parents('.contact_wrap').find('.message_contact').html(response.message);
				} else{
					$this.parents('.contact_wrap').find('.contact_form').get(0).reset();
					$this.parents('.contact_wrap').find('.message_contact').addClass('alert alert-success').show();
					$this.parents('.contact_wrap').find('.message_contact').html(response.message);
				}
			}
		});
		
		return false;
		
	});
	
	/*
	 * @Contact Form
	 * @return{}
	*/
	jQuery('.contact_wrap').on('click','.contact_now',function(e){
		e.preventDefault();
		var $this 	= jQuery(this);
		
		var success	= $this.parents('.contact_form').find('.form-data').data('success');
		var error	= $this.parents('.contact_form').find('.form-data').data('error');
		var email	= $this.parents('.contact_form').find('.form-data').data('email');
		
		var serialize_data	= $this.parents('.contact_wrap').find('.contact_form').serialize();
		var dataString = serialize_data+'&success='+success+'&error='+error+'&email='+email+'&action=listingo_vc_shortcodes_submit_contact';
		
		$this.parents('.contact_wrap').find('.message_contact').html('').hide();
		$this.parents('.contact_form').append("<i class='fa fa-refresh fa-spin'></i>");
		$this.parents('.contact_wrap').find('.message_contact').removeClass('alert-success');
		$this.parents('.contact_wrap').find('.message_contact').removeClass('alert-danger');

		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: dataString,
			dataType:"json",
			success: function(response) {
				$this.parents('.contact_form').find('i').remove();
				jQuery('.message_contact').show();
				if( response.type == 'error' ) {
					$this.parents('.contact_wrap').find('.message_contact').addClass('alert alert-danger').show();
					$this.parents('.contact_wrap').find('.message_contact').html(response.message);
				} else{
					$this.parents('.contact_wrap').find('.contact_form').get(0).reset();
					$this.parents('.contact_wrap').find('.message_contact').addClass('alert alert-success').show();
					$this.parents('.contact_wrap').find('.message_contact').html(response.message);
				}
			}
		});
		
		return false;
		
	});
	
	/* ---------------------------------------
     Login Ajax
     --------------------------------------- */
	jQuery('.do-login-form').on('click', '.do-login-button', function (event) {
		event.preventDefault();
		var _this	= jQuery(this);
		_this.append('<i class="fa fa-refresh fa-spin"></i>');

		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: jQuery('.do-login-form').serialize() + '&action=listingo_vc_shortcodes_ajax_login',
			dataType: "json",
			success: function (response) {
				_this.find('i.fa-spin').remove();
				if( response.type == 'success' ) {
					jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
					window.location.reload();
					
				} else{
					jQuery.sticky(response.message, {classList: 'important', speed: 200, autoclose: 5000});
				}
			}
	   });
	});
	
	/* ---------------------------------------
     registration Ajax
     --------------------------------------- */
	jQuery('.do-registration-form').on('click', '.do-register-button', function (event) {
		event.preventDefault();
		var _this	= jQuery(this);
		_this.append('<i class="fa fa-refresh fa-spin"></i>');
		
		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: jQuery('.do-registration-form').serialize() + '&action=listingo_vc_shortcodes_user_registration',
			dataType: "json",
			success: function (response) {
				_this.find('i.fa-spin').remove();
				if( response.type == 'success' ) {
					jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
					window.location.reload();
					
				} else{
					jQuery.sticky(response.message, {classList: 'important', speed: 200, autoclose: 5000});
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