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
	$profile_status  = get_user_meta($user_identity, 'profile_status', true);
	$statuses	= listingo_get_status_list();
	?>
	<div class="tg-dashboardbox tg-languages sp-dashboard-profile-form">
		<div class="sp-row">
			<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
				<div class="tg-dashboardtitle">
					<h2><?php esc_html_e('Profile Status', 'listingo'); ?></h2>
				</div>
				<div class="tg-languagesbox">
					<div class="tg-startendtime">
						<div class="form-group">
							<span class="tg-select">
								<select name="basics[profile_status]">
									 <?php if( !empty( $statuses ) ) {?>
									 	<?php foreach( $statuses as $key => $value ){?>
										 	<option <?php echo isset($key) && $key === $profile_status ? 'selected' : '';?> value="<?php echo esc_attr($key);?>"><?php echo esc_attr($value['title']);?></option>
									 <?php }}?>
								</select>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php }