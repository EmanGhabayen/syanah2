<?php
/**
 *
 * The template part for displaying the dashboard privacy settings.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;
if ( ( $profileuser->roles[0] === 'professional' || $profileuser->roles[0] === 'business' ) ){
	$user_identity = $profileuser->ID;
	/* Get Privacy Settings Array */
	$privacy_settings = listingo_prepare_privacy_settings();
	/* Get DB Privacy Settings */
	$db_privacy = listingo_get_privacy_settings($user_identity);
	$provider_category = listingo_get_provider_category($user_identity);
	?>
	<div class="tg-dashboard tg-dashboardprivacysettings">
		<div class="sp-row">
			<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
				<div class="tg-themeform tg-dashboard-privacy-form">
					<fieldset>
						<div class="tg-dashboardbox tg-privacysettings">
							<div class="tg-dashboardtitle">
								<h2><?php esc_html_e('Privacy Settings', 'listingo'); ?></h2>
							</div>
							<div class="tg-privacysettingsbox">
								<?php if (!empty($privacy_settings) && is_array($privacy_settings)) { 
									foreach ($privacy_settings as $key => $settings) {
										$is_feature_allowed			= 'yes';
										$is_subscription_allowed	= 'yes';

										if( $settings['feature_check'] === 'yes' ){
											if (apply_filters('listingo_is_feature_allowed', $provider_category, $settings['feature_check_key']) === true) {
												$is_feature_allowed	= 'yes';
											}else{
												$is_feature_allowed	= 'no';
											}
										}

										if( $settings['subscription_check'] === 'yes' ){
											if( apply_filters('listingo_is_setting_enabled', $user_identity, $settings['subscription_check_key'] ) === true ){
												$is_subscription_allowed	= 'yes';
											}else{
												$is_subscription_allowed = 'no';	
											}
										}
										
										if( isset( $settings['extension_check'] ) && $settings['extension_check'] === 'yes' ){
									
											//jobs
											if( isset( $settings['extension_check_key'] ) && $settings['extension_check_key'] === 'jobs' ){
												if ( apply_filters('listingo_get_theme_settings', 'jobs') == 'yes') {
													$is_feature_allowed	= 'yes';
												}else{
													$is_feature_allowed	= 'no';
												}
											}

											//Articles
											if( isset( $settings['extension_check_key'] ) && $settings['extension_check_key'] === 'articles' ){
												if ( function_exists('fw_get_db_settings_option') && fw_ext('articles')) {
													$is_feature_allowed	= 'yes';
												}else{
													$is_feature_allowed	= 'no';
												}
											}

										}

										if( $is_feature_allowed === 'yes' && $is_subscription_allowed === 'yes' ){?>
											<div class="tg-privacysetting">
												<span><?php echo esc_attr($settings['title']); ?></span>
												<div class="tg-iosstylcheckbox">
													<input type="hidden" name="privacy[<?php echo esc_attr($key); ?>]">
													<input class="dashboard-privacy" <?php echo isset($db_privacy[$key]) && $db_privacy[$key] === 'on' ? 'checked' : ''; ?> type="checkbox" id="<?php echo esc_attr($key); ?>" name="privacy[<?php echo esc_attr($key); ?>]" >
													<label for="<?php echo esc_attr($key); ?>" data-disable="<?php esc_html_e('Disable', 'listingo'); ?>" data-enable="<?php esc_html_e('Enable', 'listingo'); ?>"></label>
												</div>
											</div>
										<?php
										}
									}
								  } ?>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
	</div>
<?php }