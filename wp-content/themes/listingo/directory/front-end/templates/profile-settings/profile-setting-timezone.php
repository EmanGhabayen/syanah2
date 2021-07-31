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

$timezones  = apply_filters('listingo_time_zones', array());
$time_zone	= get_user_meta($url_identity, 'default_timezone', true);
?>
<div class="tg-dashboardbox tg-basicinformation">
	<div class="tg-haslayout spv-timezone">
		<div class="tg-dashboardtitle">
			<h2><?php esc_html_e('Timezone', 'listingo'); ?></h2>			
		</div>
		<div class="tg-amenitiesfeaturesbox">
			<p><?php esc_html_e('Please select your timezone in which you are providing your services. This will be used for business hours, ads and appointments. ', 'listingo'); ?></p>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
					<div class="form-group">
						<?php if( !empty( $timezones ) ) {?>
						<span class="tg-select">
							<select name="basics[default_timezone]" class="_timezone">
								<?php								
								foreach ($timezones as $key => $value) { 
									if( $time_zone == $key ){
										$selected = 'selected';
									} else {
										$selected = '';
									}	
								?>
								<option value="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_attr( $value ); ?></option>
								<?php } ?>
							</select>									
						</span>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>