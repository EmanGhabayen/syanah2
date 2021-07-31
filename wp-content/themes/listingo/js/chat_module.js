//"use strict";
var chat_interval;
var eonearea;
var thread_page = 0;
var older_more = 'yes';
jQuery(document).on('ready', function() {
    var loader_html = '<div class="provider-site-wrap"><div class="provider-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';
	var chatloader  = scripts_vars.chatloader;
	
	/* THEME VERTICAL SCROLLBAR */
    jQuery('.wt-listverticalscrollbar').mCustomScrollbar({
		axis:"y",
		autoHideScrollbar: false,
	});

	//message holder
    jQuery(document).on('click', '.wt-ad', function(e){
        jQuery(this).parents('.wt-messages-holder').addClass('wt-openmsg');
    });
	
	//Back click
    jQuery(document).on('click', '.wt-back', function(e){
        jQuery(this).parents('.wt-messages-holder').removeClass('wt-openmsg');
    });
    
	//Apply user filter
	jQuery('.wt-filter-users').on('keyup', function($){
		var content = jQuery(this).val();           
		jQuery(this).parents('li').find('.wt-adcontent h3:contains(' + content + ')').parents('.wt-ad').show();
		jQuery(this).parents('li').find('.wt-adcontent h3:not(:contains(' + content + '))').parents('.wt-ad').hide(); 
	});
	
	// Case insenstive in Contains
	jQuery.expr[":"].contains = jQuery.expr.createPseudo(function(arg) {
		return function( elem ) {
			return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
		};
	});
	
	//Load One to One Chat
    jQuery(document).on('click','.wt-load-chat', function(e){
	    e.preventDefault();
		thread_page			= 0;
		older_more 			= 'yes';
        var _this 			= jQuery(this);
        var user_id 		= _this.data('userid');     
        var current_user_id = _this.data('currentid');   
        var msg_id 			= _this.data('msgid');  
        var ischat 			= _this.data('ischat');
		
		var chat_img 			= _this.data('img');
		var chat_url 			= _this.data('url');
		var chat_name 			= _this.data('name');
		thread_page			= thread_page;
		
		//load user info
		var load_message_sidebar = wp.template('load-user-details');
		var chat_user = {chat_img: chat_img,chat_url: chat_url,chat_name: chat_name};       
		load_message_sidebar = load_message_sidebar(chat_user); 
		jQuery('.chat-current-user').html(load_message_sidebar);
		
		jQuery('.load-wt-chat-message').html('');
		jQuery('.load-wt-chat-message').append(chatloader);
		
        //Get chat
	    var dataString = 'thread_page=' + thread_page + '&user_id=' + user_id + '&current_id=' + current_user_id + '&msg_id=' + msg_id + '&action=fetchUserConversation';
	    jQuery.ajax({
	        type: "POST",
	        url: scripts_vars.ajaxurl,
	        data: dataString,
	        dataType: "json",
	        success: function (response) {
				jQuery('.provider-site-wrap').remove();
				_this.addClass('wt-active').siblings().removeClass('wt-active');
				_this.removeClass('wt-dotnotification');
	           if (response.type === 'success') {                   
                    
				    //Load Reply Box Template
                    var load_reply_box = wp.template('load-chat-replybox');                                  
                    var user_data = {receiver_id: response.chat_receiver_id};        
                    load_reply_box = load_reply_box(user_data);
				   
                    //Load Messages Template
                    var load_message_temp = wp.template('load-chat-messagebox');
                    var chat_data = {chat_nodes: response.chat_nodes};        
                    load_message_temp = load_message_temp(chat_data); 
                    _this.parents('.wt-offersmessages').find('.load-wt-chat-message').html(load_reply_box);
                    _this.parents('.wt-offersmessages').find('.load-wt-chat-message .wt-messages').append(load_message_temp);
				    refreshScrollBarObject();
				    eonearea = jQuery(".reply_msg").emojioneArea();
	            } else {
	                jQuery.sticky(response.message, {classList: 'important', speed: 200, autoclose: 5000});
	            }
	        }
        });

		
    });
	
    //Send One to One Chat
    jQuery(document).on('click','.wt-send', function (e) {
        e.preventDefault();              
        var _this = jQuery(this);
        var receiver_id   = _this.data('receiver_id');
		var status   	  = _this.data('status');
		var msg_type   	  = _this.data('msgtype');
        var reply_msg 	  = _this.parents('.wt-replaybox').find('textarea.reply_msg').val();       
		
		
        //Send message  
        _this.parents('.wt-iconbox, .wt-iconboxv').addClass('sp-chatsendspin');       
		
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data:  {
				action	: 'sendUserMessage',
				status		: status,
				msg_type	: msg_type,
				message		: reply_msg,
				receiver_id	: receiver_id
			},
            dataType: "json",
            success: function (response) {
				_this.parents('.wt-iconbox, .wt-iconboxv').removeClass('sp-chatsendspin');
				if (response.type === 'success') {  
					_this.parents('.wt-replaybox').find('textarea.reply_msg').val('');
					if(response.msg_type === 'modal'){
						jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
					}else{
						
						var load_message_temp = wp.template('load-chat-messagebox');
						var chat_data = {chat_nodes: response.chat_nodes};        
						load_message_temp = load_message_temp(chat_data); 
						jQuery('.load-wt-chat-message').find('.wt-messages .mCSB_container').append(load_message_temp);
						jQuery('.wt-offersmessages').find('#load-user-chat-'+response.chat_receiver_id).attr('data-msgid', response.last_id);

						//last message
						var load_message_recent_data_temp = wp.template('load-chat-recentmsg-data');
						var chat_recent_data = {desc:response.replace_recent_msg}
						load_message_recent_data_temp = load_message_recent_data_temp(chat_recent_data);
						jQuery('.wt-offersmessages').find('#load-user-chat-'+response.chat_receiver_id+ ' .wt-adcontent .list-last-message').html(load_message_recent_data_temp);
						
						eonearea[0].emojioneArea.setText(''); // clear input 
						refreshScrollBarObject();
					}
				}else{
					jQuery.sticky(response.message, {classList: 'important', speed: 200, autoclose: 5000});
				}
            }
        });               
    });  

    //Delete One to One Chat Message
    jQuery(document).on('click','.wt-delete-message', function (e) {
        e.preventDefault();            
        var _this = jQuery(this);
        var messageId   = _this.data('id');
        var userId      = _this.data('user');

        //Delete message  
        jQuery('body').append(loader_html);       
        var dataString = 'msgid=' + messageId + '&user_id=' + userId + '&action=deleteChatMessage';
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
            jQuery('.provider-site-wrap').remove();
               if (response.type === 'success') {  
                    _this.parents('.wt-msg-thread').remove();                                          
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });                   
                } else {
                    jQuery.sticky(response.message, {classList: 'important', speed: 200, autoclose: 5000});
                }
            }
        });               
    });
});

//load new message
function loadNewMessage(senderid,receiverid){
	chat_interval 	 = setInterval(function(){
		var msgid  		 = document.getElementById('load-user-chat-'+receiverid);
		var msg_id 		 = msgid.dataset.msgid;
		var SP_Editor 	 = '';
		window.SP_Editor = msg_id;

		var dataString = 'sender_id=' + senderid + '&receiver_id=' + receiverid + '&last_msg_id=' + msg_id + '&action=getIntervalChatHistoryData';
		jQuery.ajax({
			type: 'POST',
			url: scripts_vars.ajaxurl,
			processData: false,
			data: dataString,
			dataType: 'json',
			success:function(response){
				if (response.type === 'success') {  
					window.SP_Editor = parseInt( response.last_id );
					var load_message_temp = wp.template('load-chat-messagebox');
					var chat_data = {chat_nodes: response.chat_nodes};        
					load_message_temp = load_message_temp(chat_data); 
					jQuery('.load-wt-chat-message').find('.wt-messages .mCSB_container').html(load_message_temp);
					jQuery('.wt-offersmessages').find('#load-user-chat-'+response.receiver_id).attr('data-msgid', response.last_id);

					//last message
					var load_message_recent_data_temp = wp.template('load-chat-recentmsg-data');
					var chat_recent_data = {desc:response.last_message}
					load_message_recent_data_temp = load_message_recent_data_temp(chat_recent_data);
					jQuery('.wt-offersmessages').find('#load-user-chat-'+response.receiver_id+ ' .wt-adcontent .list-last-message').html(load_message_recent_data_temp);

					refreshScrollBarObject();
				}
			}
		});
	},15000);
}

//init nicescroll       
function refreshScrollBarObject() {
    jQuery('.wt-verticalscrollbar').mCustomScrollbar({
		axis:"y",
		scrollbarPosition: "outside",
		autoHideScrollbar: true,
		scrollTo:'bottom',
		setTop:"9999px",
		callbacks:{
			onTotalScrollBack:function(){ _add_older_messages(this) },
			onTotalScrollBackOffset:100,
			alwaysTriggerOffsets:false
		},
		advanced:{updateOnContentResize:false} //disable auto-updates (optional)
	});
	
	jQuery('.wt-msg-thread .wt-description').linkify();
	
	//scroll to bottom
	jQuery('.wt-verticalscrollbar').mCustomScrollbar('scrollTo','bottom');
}

// Load older messages
function _add_older_messages(el){
	if( older_more === 'yes' ){
		thread_page++;
		var _this = jQuery('.wt-active');
		var chatloader  = scripts_vars.chatloader;
		var oldContentHeight	=	jQuery(".wt-verticalscrollbar .mCSB_container").innerHeight();

		var user_id 		= _this.data('userid');     
		var current_user_id = _this.data('currentid');   
		var msg_id 			= _this.data('msgid');  
		var ischat 			= _this.data('ischat');

		var chat_img 			= _this.data('img');
		var chat_url 			= _this.data('url');
		var chat_name 			= _this.data('name');
		thread_page				= thread_page;
		
		jQuery('.load-wt-chat-message').addClass('slighloader');
		jQuery('.load-wt-chat-message').append(chatloader);
		
		//Get chat
		var dataString = 'thread_page=' + thread_page + '&user_id=' + user_id + '&current_id=' + current_user_id + '&msg_id=' + msg_id + '&action=fetchUserConversation';
		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: dataString,
			dataType: "json",
			success: function (response) {
			   jQuery('.load-wt-chat-message').removeClass('slighloader');
			   jQuery('.sp-chatspin').remove();
			   if (response.type === 'success') {
				   
					//Load Messages Template
					var load_message_temp = wp.template('load-chat-messagebox');
					var chat_data = {chat_nodes: response.chat_nodes};        
					load_message_temp = load_message_temp(chat_data); 
					el.mcs.content.prepend(load_message_temp);
				   
				    var heightDiff	= jQuery(".wt-verticalscrollbar .mCSB_container").innerHeight() - oldContentHeight;
					jQuery(".wt-verticalscrollbar").mCustomScrollbar("update"); //update manually
					jQuery(".wt-verticalscrollbar").mCustomScrollbar("scrollTo","-="+heightDiff,{scrollInertia:0,timeout:0}); //scroll-to
				   
				} else {
					jQuery.sticky(response.message, {classList: 'important', speed: 200, autoclose: 5000});
					older_more  = 'no';
					thread_page = 0;
				}
			}
		});
	}
}