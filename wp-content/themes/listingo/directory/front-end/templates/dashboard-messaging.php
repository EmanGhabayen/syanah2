<?php 
/**
 * Messaging template
 **/
global $current_user;
$user_identity = $current_user->ID;
?>
<section class="wt-haslayout wt-dbsectionspace am-chat-module">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-10">
            <div class="wt-dashboardbox wt-messages-holder">
                <div class="wt-chat-head">
	                <div class="wt-dashboardboxtitle">
	                   <h2><?php esc_html_e('Messages', 'listingo'); ?></h2>
					</div>
					<div class="wt-dashboardboxtitle wt-titlemessages chat-current-user"></div>
				</div>
				<div class="wt-dashboardboxcontent wt-dashboardholder wt-offersmessages">
					<?php
						if (isset($_GET['ref']) && $_GET['ref'] == 'chat' && $_GET['identity'] == $user_identity) {
							do_action('fetch_users_threads', $user_identity);
						}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/template" id="tmpl-load-chat-replybox">
<div class="wt-messages wt-verticalscrollbar wt-dashboardscrollbar"></div>
<div class="wt-replaybox">
	<div class="form-group">
		<textarea class="form-control reply_msg" name="reply" placeholder="<?php esc_html_e('Type message here', 'listingo'); ?>"></textarea>
	</div>
	<div class="wt-iconbox">
		<a href="javascript:;" class="wt-btnsendmsg wt-send" data-status="unread" data-receiver_id="{{data.receiver_id}}"><?php esc_html_e('Send', 'listingo'); ?></a>
	</div>
</div>
</script>
<script type="text/template" id="tmpl-load-chat-messagebox">
<# if( !_.isEmpty(data.chat_nodes) ) { #>
<# 
_.each( data.chat_nodes , function( element, index ) { 
	var chat_class = 'wt-offerermessage wt-msg-thread';
	if(element.chat_is_sender === 'yes'){
		chat_class = 'wt-memessage wt-readmessage wt-msg-thread';
	}
	
	message		= element.chat_message;
#>
<div class="{{chat_class}}" data-id="{{element.chat_id}}">
	<figure><img src="{{element.chat_avatar}}" alt="{{element.chat_username}}"></figure>
	<div class="wt-description">
		<p>{{message}}</p>
		<div class="clearfix"></div>
		<time datetime="2017-08-08">{{element.chat_date}}</time>
		<div class="clearfix"></div>
	</div>
</div>
<# }); #>
<# } #>
</script>
<script type="text/template" id="tmpl-load-chat-recentmsg-data">
	{{data.desc}}
</script>
<script type="text/template" id="tmpl-load-user-details">
<a href="javascript:;" class="wt-back back-chat"><i class="lnr lnr-arrow-left"></i></a>
<div class="wt-userlogedin">
	<figure class="wt-userimg">
		<img src="{{data.chat_img}}" alt="{{data.chat_name}}">
	</figure>
	<div class="wt-username">
		<h3>{{data.chat_name}}</h3>
		<a target="_blank" href="{{data.chat_url}}" class="wt-viewprofile"><?php esc_html_e('View Profile', 'listingo'); ?></a>
	</div>
</div>
<a href="{{data.chat_url}}" class="wt-viewprofile"><span class="lnr lnr-unlink"></span></a>
</script>