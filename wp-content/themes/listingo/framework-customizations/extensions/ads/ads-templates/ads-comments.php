<?php 
global $post, $comment;
$current_user 	= wp_get_current_user();
$user_identity 	= '';
$user_link 		= '';
$user_id 		= '';
$author_id 		= $post->post_author;
$username 		= '';
if ( $current_user->exists() ) {
	$username 	= listingo_get_username($current_user->ID);
	$user_id 	= $current_user->ID;
	$user_link  = get_author_posts_url($user_id);
}   

$count   = listingo_get_comment_total_ratings($post->ID);
$average = listingo_get_comment_average_ratings($post->ID);

if( $count > 0 ){
	//Do nothing
} else {
	$count = 'No';
}

if( is_numeric($count) && is_numeric($average)){
	$width = $average / 5 * 100;
} else {
	$width = 0;
}
?>
<div id="tg-box" class="tg-sectionpaddingvtwo tg-questionsvtwo">     
	 <div class="tg-sectiontitlevthree text-left">
		<h2><?php esc_html_e('Reviews', 'listingo'); ?></h2>           
		<div class="tg-rightarea tg-reviewsinfo">
			<?php if( !empty( $average ) ) { ?>
				<h3><?php echo esc_attr( $average ); ?>&nbsp;/&nbsp;<?php esc_html_e('5.0', 'listingo'); ?></h3> 
				<span class="tg-stars"><span style="width: <?php echo esc_attr( $width ); ?>%"></span></span>
					<em><?php echo esc_attr( $count ); ?>&nbsp;<?php esc_html_e('Reviews', 'listingo'); ?></em>
			<?php } else { ?>
				<h3><?php esc_html_e('No Reviews', 'listingo'); ?></h3> 
			<?php } ?>         
		</div>    
	</div>
	<?php if (have_comments()) :?>
	<div class="comments-ad-wrap">
		<?php wp_list_comments(array('callback' => 'listingo_ads_comments'));?>
	</div> 
    <?php the_comments_navigation(); ?> 
<?php endif; ?>
<?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
    <div class="alert alert-info tg-alertmessage fade in comments_closed">
        <i class="lnr lnr-flag"></i>
        <span><?php esc_html_e('Comments are closed.', 'listingo'); ?></span>
    </div>
<?php endif;
	
if (comments_open() ) { ?>
    <div class="comment-form-wrap">     
        <?php
        $comments_args = array(
            'must_log_in' => '<div class="col-sm-12"><p class="must-log-in">' . sprintf(__("You must be %slogged in%s to post a comment.", "listingo"), '<a href="' . wp_login_url(apply_filters('the_permalink', get_permalink())) . '">', '</a>') . '</p></div>',
            'logged_in_as' => '<div class="col-sm-12"><p class="logged-in-as">' . esc_html__("Logged in as", "listingo") . ' <a href="' . $user_link . '">' . $username . '</a>. <a href="' . wp_logout_url(get_permalink()) . '" title="' . esc_html__("Log out of this account", "listingo") . '">' . esc_html__("Log out &raquo;", "listingo") . '</a></p></div>',
            'comment_field' => '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><div class="form-group"><textarea name="comment" id="comment" cols="39" rows="4" tabindex="4" class="form-control" placeholder="' . esc_html__("Leave your review", "listingo") . '"></textarea></div></div>',
            'notes' => '',
            'comment_notes_before' => '',
            'comment_notes_after' => '',
            'id_form' => 'tg-formtheme',
            'id_submit' => 'tg-formtheme',
            'class_form' => 'tg-formfeedback tg-formtheme tg-ad-comment',
            'class_submit' => 'tg-send-comment tg-btn ',
            'name_submit' => 'submit',
            'title_reply' => esc_html__('Leave a Review', 'listingo'),
            'title_reply_to' => esc_html__('Leave a review to %s', 'listingo'),
            'title_reply_before' => '<div class="tg-companyfeaturetitle"><h3>',
            'title_reply_after' => '</h3></div>',
            'cancel_reply_before' => '',
            'cancel_reply_after' => '',
            'cancel_reply_link' => esc_html__('Cancel Review', 'listingo'),
            'label_submit' => esc_html__('Post Review', 'listingo'),
            'submit_button' => '<div class="col-xs-12 col-sm-12"><button name="%1$s" type="submit" id="%2$s" value="%4$s" class="tg-btn tg-send-comment">%4$s</button></div>',
            'submit_field' => ' %1$s %2$s ',
            'format' => 'xhtml',
        );
        comment_form($comments_args);        
        ?>
    </div>
    <?php } ?>
</div>
<?php
$script = "jQuery(document).ready(function(){                
		jQuery(function () {
			var that = this;
			var toolitup = $('#jRatevtwo').jRate({
			rating: 3,
			strokeColor: '#dadadacc',
			precision: 1,
			startColor: '#fdd003',
			endColor: '#fdd003',
			backgroundColor: '#dadadacc',
			minSelected: 1,
			shapeGap: '5px',
			count: 5,
			onChange: function(rating) {
				jQuery('.counter').text(rating + ' Stars');
				jQuery('.tg-star-rating').val(rating);
			},
			onSet: function(rating) {

			}
		});        
	});
});";
wp_add_inline_script('listingo_callbacks', $script, 'after');