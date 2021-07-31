<?php
/**
 *
 * The template part for displaying the dashboard privacy settings.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();

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

/* Get Privacy Settings Array */
$privacy_settings = listingo_prepare_privacy_settings();
/* Get DB Privacy Settings */
$db_privacy = listingo_get_privacy_settings($user_identity);
$provider_category = listingo_get_provider_category($url_identity);
?>
<div id="tg-content" class="tg-content">
    <div class="tg-dashboard tg-dashboardprivacysettings">
        <form class="tg-themeform tg-dashboard-privacy-form">
            <fieldset>
                <div class="tg-dashboardbox tg-privacysettings">
                    <div class="tg-dashboardtitle">
                        <h2><?php esc_html_e('Privacy Settings', 'listingo'); ?><?php do_action('listingo_get_tooltip','section','privacy');?></h2>
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
									if( apply_filters('listingo_is_setting_enabled', $url_identity, $settings['subscription_check_key'] ) === true ){
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
                          }
						?>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>