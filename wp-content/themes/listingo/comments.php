<?php
/**
 *
 * Comments Page
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
if (post_password_required()) {
    return;
}

//Get ads commment tempalte if ads page
if( is_singular('sp_ads') ) { 
    get_template_part('/framework-customizations/extensions/ads/ads-templates/ads-comments');
} else {
if (have_comments()) :?>
    <div id="tg-box" class="tg-companyfeaturebox tg-reviews">
        <div class="tg-companyfeaturetitle">
            <h3><?php comments_number(esc_html__('0 Comments', 'listingo'), esc_html__('1 Comment', 'listingo'), esc_html__('% Comments', 'listingo')); ?></h3>
        </div>
        <ul class="tg-feedbacks sp-comments-wrap">
            <?php
            wp_list_comments(array(
                'callback' => 'listingo_comments'));
            ?>
        </ul>
    <?php the_comments_navigation(); ?>
    </div>	
<?php endif; ?>
<?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
    <div class="alert alert-info tg-alertmessage fade in comments_closed">
        <i class="lnr lnr-flag"></i>
        <span><?php esc_html_e('Comments are closed.', 'listingo'); ?></span>
    </div>
    <p class="no-comments"></p>
<?php endif; ?>

    <?php if (comments_open()) : ?>
    <div class="tg-companyfeaturebox tg-reviewformrating">
        <?php
        $comments_args = array(
            'must_log_in' => '<div class="col-sm-12"><p class="must-log-in">' . sprintf(__("You must be %slogged in%s to post a comment.", "listingo"), '<a href="' . wp_login_url(apply_filters('the_permalink', get_permalink())) . '">', '</a>') . '</p></div>',
            'logged_in_as' => '<div class="col-sm-12"><p class="logged-in-as">' . esc_html__("Logged in as", "listingo") . ' <a href="' . admin_url("profile.php") . '">' . $user_identity . '</a>. <a href="' . wp_logout_url(get_permalink()) . '" title="' . esc_html__("Log out of this account", "listingo") . '">' . esc_html__("Log out &raquo;", "listingo") . '</a></p></div>',
            'comment_field' => '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><div class="form-group"><textarea name="comment" id="comment" cols="39" rows="4" tabindex="4" class="form-control" placeholder="' . esc_html__("Type Your Comment Here", "listingo") . '"></textarea></div></div>',
            'notes' => '',
            'comment_notes_before' => '',
            'comment_notes_after' => '',
            'id_form' => 'tg-formtheme',
            'id_submit' => 'tg-formtheme',
            'class_form' => 'tg-formfeedback tg-formtheme',
            'class_submit' => 'tg-btn',
            'name_submit' => 'submit',
            'title_reply' => esc_html__('Leave a Reply', 'listingo'),
            'title_reply_to' => esc_html__('Leave a reply to %s', 'listingo'),
            'title_reply_before' => '<div class="tg-companyfeaturetitle"><h3>',
            'title_reply_after' => '</h3></div>',
            'cancel_reply_before' => '',
            'cancel_reply_after' => '',
            'cancel_reply_link' => esc_html__('Cancel reply', 'listingo'),
            'label_submit' => esc_html__('Post Comment', 'listingo'),
            'submit_button' => '<div class="col-xs-12 col-sm-12"><button name="%1$s" type="submit" id="%2$s" value="%4$s" class="tg-btn">%4$s</button></div>',
            'submit_field' => ' %1$s %2$s ',
            'format' => 'xhtml',
        );
        comment_form($comments_args);
        ?>
    </div>
    <?php
endif; // if you delete this the sky will fall on your head 
}