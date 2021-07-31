<?php
/**
 *
 * The template part for displaying the dashboard profile settings.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */

/* Define Global Variables */
global $current_user,
 $wp_roles,
 $userdata,
 $post;

$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (isset($_GET['identity']) && !empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$professional_statements = get_user_meta($user_identity, 'professional_statements', true);

?>
<div class="tg-dashboardbox tg-introduction">
	<div class="tg-dashboardtitle">
		<h2><?php esc_html_e('Introduction', 'listingo'); ?></h2>
	</div>
	<div class="tg-introductionbox">
		<p><strong><?php esc_html_e('It will be shown in user detail page below user short description.', 'listingo'); ?></strong></p>
		<?php
		$professional_statements = !empty($professional_statements) ? $professional_statements : '';
		$settings = array('media_buttons' => false,'quicktags' => true);
		wp_editor($professional_statements, 'professional_statements', $settings);
		?>
	</div>
</div>
               