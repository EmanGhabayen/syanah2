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
$social_links = apply_filters('listingo_get_social_media_icons_list',array());
$social_target 	= get_user_meta($user_identity, 'social_target', true);
?>
<div class="tg-dashboardbox tg-socialinformation">
	<div class="tg-dashboardtitle">
		<h2><?php esc_html_e('Social Information', 'listingo'); ?></h2>
	</div>
	<div class="tg-socialinformationbox">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
				<div class="form-group">
					<span class="tg-select">
						<select name="basics[social_target]">
							<option value="_self" <?php selected( $social_target, '_self'); ?>><?php esc_html_e('Open in same window', 'listingo'); ?></option>
							<option value="_blank" <?php selected( $social_target, '_blank'); ?>><?php esc_html_e('Open in new window', 'listingo'); ?></option>
						</select>
					</span>
				</div>
			</div>
			<?php 
			if( !empty( $social_links ) ){
				foreach( $social_links as $key => $social ){
					$icon		= !empty( $social['icon'] ) ? $social['icon'] : '';
					$classes	= !empty( $social['classses'] ) ? $social['classses'] : '';
					$placeholder		= !empty( $social['placeholder'] ) ? $social['placeholder'] : '';
					$color		= !empty( $social['color'] ) ? $social['color'] : '#484848';
				?>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
					<div class="form-group tg-inputwithicon <?php echo esc_attr( $classes );?>">
						<i class="tg-icon <?php echo esc_attr( $icon );?>" style="background:<?php echo esc_attr( $color );?>"></i>
						<input type="text" class="form-control" name="socials[<?php echo esc_attr( $key );?>]" value="<?php echo get_user_meta($user_identity, $key, true); ?>" placeholder="<?php echo esc_attr( $placeholder );?>">
						<?php do_action('listingo_get_tooltip','element',$key);?>
					</div>
				</div>
			<?php }}?>
			
		</div>
	</div>
</div>