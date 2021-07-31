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

$provider_category	= listingo_get_provider_category($url_identity);

if( apply_filters('listingo_is_feature_allowed', $provider_category, 'facebook_chat') === true ){
	$social_api = apply_filters('listingo_get_social_api_settings',array(),'facebook');
?>
<div class="tg-dashboardbox tg-socialinformation">
	<div class="tg-dashboardtitle">
		<h2><?php esc_html_e('Facebook Customer Chat', 'listingo'); ?><?php do_action('listingo_get_tooltip','section','chat');?></h2>
	</div>
	<div class="tg-socialinformationbox">
		<div class="row">
			<?php foreach( $social_api as $key => $value ){?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
				<div class="form-group">
					<input type="text" class="form-control" name="social_api[facebook][chat][<?php echo esc_attr($key);?>]" value="<?php echo esc_attr($value['value']);?>" placeholder="<?php echo esc_attr($value['title']); ?>">
				</div>
			</div>
			<?php }?>
		</div>
	</div>
</div>
<?php }?>