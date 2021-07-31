"use strict";
jQuery(document).ready(function($) {
	$(document).on('click', '.icon-picker-elm', function () {
        var _this = jQuery(this);
        var icon = _this.find('i').data('icon');
        _this.parents('.zpb-wrapper').prev('.zpb-wrapper').find('input.icons-search').val(icon);
        _this.parents('.zpb-wrapper').prev('.zpb-wrapper').find('i').attr('class', icon);
        _this.parents('.zpb-wrapper').prev('.zpb-wrapper').find('.selected-icon').show();
        _this.parents('.zpb-wrapper').find('.icon-picker-elm').removeClass('active');
        _this.addClass('active');
    });
	
	//Save settings
	jQuery(document).on('click', '.save-data-settings', function(event) {
		event.preventDefault();
		var serialize_data = jQuery('.save-settings-form').serialize();
		var dataString = serialize_data + '&action=listingo_save_theme_settings';
		
		var _this = jQuery(this);
		jQuery('.tg-featurescontent').append('<div class="inportusers">'+localize_vars.spinner+'</div>');
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			dataType:"json",
			data: dataString,
			success: function(response) {
				jQuery('.tg-featurescontent').find('.inportusers').remove();
				jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
				window.location.reload();
			}
		});

    });
	
	//menu page Sorting
	jQuery(".sp-content-sort").sortable({
		delay: 300,
		opacity: 0.6,
		update: function() {
			jQuery('.tg-featurescontent').append('<div class="inportusers">'+localize_vars.spinner+'</div>');
			var serialize_data = jQuery('.save-settings-form').serialize();
			var dataString = serialize_data+'&action=listingo_update_provider_menu_sorting';
			jQuery.ajax({
				type: "POST",
				url: ajaxurl,
				data: dataString,
				dataType: "json",
				success: function (response) {
					jQuery('.tg-featurescontent').find('.inportusers').remove();
					if (response.type == 'success') {
						jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
					} else {
						jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
					}
					
				}
			});
		}
	});
	
	//menu page reset
	jQuery(document).on('click', '.sp-reset-menu', function() {
		 jQuery.confirm({
			'title': 'Reset Menu',
			'message': 'Are you sure, you want to reset menu?',
			'buttons': {
				'Yes': {
					'class': 'blue',
					'action': function () {
						jQuery('.tg-featurescontent').append('<div class="inportusers">'+localize_vars.spinner+'</div>');
						var dataString = 'action=listingo_reset_dashboard_menu';
						jQuery.ajax({
							type: "POST",
							url: ajaxurl,
							data: dataString,
							dataType: "json",
							success: function (response) {
								jQuery('.tg-featurescontent').find('.inportusers').remove();
								if (response.type == 'success') {
									jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
									window.location.reload();
								} else {
									jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
								}

							}
						});
				
						return false;
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
	  * Import Users
	  *---------------------------------------------------------------------*/
	 jQuery(document).on('click', '.doc-import-users', function() {
		 jQuery.confirm({
			'title': 'Import Users',
			'message': 'Are you sure, you want to import users?',
			'buttons': {
				'Yes': {
					'class': 'blue',
					'action': function () {
						var dataString = 'action=listingo_import_users';
						var $this = jQuery(this);
						jQuery('#import-users').append('<div class="inportusers">'+localize_vars.spinner+'</div>');
						jQuery.ajax({
							type: "POST",
							url: ajaxurl,
							dataType:"json",
							data: dataString,
							success: function(response) {
								jQuery('#import-users').find('.inportusers').remove();
								jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
							}
						});
				
						return false;
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
});


/*Validation for Donation Amount */
function validateAmount() {
	if (isNaN(jQuery.trim(jQuery('input[name=featured_days]').val()))) {
		jQuery('input[name=featured_days]').val("");

	} else {
		var amt = jQuery('input[name=featured_days]').val();
		if (amt != '') {
			if (amt.length > 16) {
				amt = amt.substr(0, 16);
				jQuery(".featured_days").val(amt);
			}
			//amount = amt;
			//jQuery("#amountToShow").html(jQuery.trim(amount));
			return true;
		} else {
			//amount = gloAmount;
			//jQuery("#amountToShow").html("--");
			return true;
		}
	}
}
	
/* ---------------------------------------
 Confirm Box
 --------------------------------------- */
(function ($) {

		jQuery.confirm = function (params) {
	
			if (jQuery('#confirmOverlay').length) {
				// A confirm is already shown on the page:
				return false;
			}
	
			var buttonHTML = '';
			jQuery.each(params.buttons, function (name, obj) {
	
				// Generating the markup for the buttons:
				if( name == 'Yes' ){
					name	= localize_vars.yes;
				} else if( name == 'No' ){
					name	= localize_vars.no;
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
	
			jQuery(markup).hide().appendTo('body').fadeIn();
	
			var buttons = jQuery('#confirmBox .button'),
					i = 0;
	
			jQuery.each(params.buttons, function (name, obj) {
				buttons.eq(i++).click(function () {
	
					// Calling the action attribute when a
					// click occurs, and hiding the confirm.
	
					obj.action();
					jQuery.confirm.hide();
					return false;
				});
			});
		}
	
		jQuery.confirm.hide = function () {
			jQuery('#confirmOverlay').fadeOut(function () {
				jQuery(this).remove();
			});
		}
	
})(jQuery);

/*
	Sticky v2.1.2 by Andy Matthews
	http://twitter.com/commadelimited

	forked from Sticky by Daniel Raftery
	http://twitter.com/ThrivingKings
*/
(function ($) {

	jQuery.sticky = jQuery.fn.sticky = function (note, options, callback) {

		// allow options to be ignored, and callback to be second argument
		if (typeof options === 'function') callback = options;

		// generate unique ID based on the hash of the note.
		var hashCode = function(str){
				
				var hash = 0,
					i = 0,
					c = '',
					len = str.length;
				if (len === 0) return hash;
				for (i = 0; i < len; i++) {
					c = str.charCodeAt(i);
					hash = ((hash<<5)-hash) + c;
					hash &= hash;
				}
				return 's'+Math.abs(hash);
			},
			o = {
				position: 'top-right', // top-left, top-right, bottom-left, or bottom-right
				speed: 'fast', // animations: fast, slow, or integer
				allowdupes: true, // true or false
				autoclose: 5000,  // delay in milliseconds. Set to 0 to remain open.
				classList: '' // arbitrary list of classes. Suggestions: success, warning, important, or info. Defaults to ''.
			},
			uniqID = hashCode(note), // a relatively unique ID
			display = true,
			duplicate = false,
			tmpl = '<div class="sticky border-POS CLASSLIST" id="ID"><span class="sticky-close"></span><p class="sticky-note">NOTE</p></div>',
			positions = ['top-right', 'top-center', 'top-left', 'bottom-right', 'bottom-center', 'bottom-left'];

		// merge default and incoming options
		if (options) jQuery.extend(o, options);

		// Handling duplicate notes and IDs
		jQuery('.sticky').each(function () {
			if (jQuery(this).attr('id') === hashCode(note)) {
				duplicate = true;
				if (!o.allowdupes) display = false;
			}
			if (jQuery(this).attr('id') === uniqID) uniqID = hashCode(note);
		});

		// Make sure the sticky queue exists
		if (!jQuery('.sticky-queue').length) {
			jQuery('body').append('<div class="sticky-queue ' + o.position + '">');
		} else {
			// if it exists already, but the position param is different,
			// then allow it to be overridden
			jQuery('.sticky-queue').removeClass( positions.join(' ') ).addClass(o.position);
		}

		// Can it be displayed?
		if (display) {
			// Building and inserting sticky note
			jQuery('.sticky-queue').prepend(
				tmpl
					.replace('POS', o.position)
					.replace('ID', uniqID)
					.replace('NOTE', note)
					.replace('CLASSLIST', o.classList)
			).find('#' + uniqID)
			.slideDown(o.speed, function(){
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
		jQuery('.sticky').ready(function () {
			// If 'autoclose' is enabled, set a timer to close the sticky
			if (o.autoclose) {
				jQuery('#' + uniqID).delay(o.autoclose).fadeOut(o.speed, function(){
					// remove element from DOM
					jQuery(this).remove();
				});
			}
		});

		// Closing a sticky
		jQuery('.sticky-close').on('click', function () {
			jQuery('#' + jQuery(this).parent().attr('id')).dequeue().fadeOut(o.speed, function(){
				// remove element from DOM
				jQuery(this).remove();
			});
		});

	};
})(jQuery);