<?php
/**
 *
 * Author Category Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;

if ( ( $profileuser->roles[0] === 'professional' || $profileuser->roles[0] === 'business' ) ){
	$user_identity = $profileuser->ID;
	$timezones  = apply_filters('listingo_time_zones', array());
	$time_zone	= get_user_meta($user_identity, 'default_timezone', true);
	?>
	<div class="tg-dashboardbox tg-languages sp-dashboard-profile-form">
		<div class="sp-row">
			<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
				<div class="tg-dashboardtitle">
					<h2><?php esc_html_e('Timezone Settings', 'listingo'); ?></h2>
				</div>
				<div class="tg-languagesbox">
					<div class="tg-startendtime">
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
<?php }