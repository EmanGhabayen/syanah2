<?php
/**
 *
 * The template part for displaying the dashboard menu
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */

global $current_user, $wp_roles, $userdata, $post;
$user_identity 	 = $current_user->ID;
if (apply_filters('listingo_do_check_user_type', $user_identity) === true) { ?>
<li>
	<a class="sp-request-category" href="javascript:" data-toggle="modal" data-target=".sp-requestModal">
		<i class="lnr lnr-pointer-up"></i>
		<span><?php esc_html_e('Request to change category', 'listingo'); ?></span>
	</a>
</li>
<?php }


