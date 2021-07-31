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

$profile_avatars = get_user_meta($user_identity, 'profile_avatar', true);
$profile_banners = get_user_meta($user_identity, 'profile_banner_photos', true);
$profile_gallery = get_user_meta($user_identity, 'profile_gallery_photos', true);
$profile_languages = get_user_meta($user_identity, 'profile_languages', true);
$profile_amenities = get_user_meta($user_identity, 'profile_amenities', true);
$profile_insurance = get_user_meta($user_identity, 'profile_insurance', true);
$profile_brochure = get_user_meta($user_identity, 'profile_brochure', true);
$profile_latitude = get_user_meta($user_identity, 'latitude', true);
$profile_longitude = get_user_meta($user_identity, 'longitude', true);
$profile_country = get_user_meta($user_identity, 'country', true);
$profile_city = get_user_meta($user_identity, 'city', true);
$profile_address = get_user_meta($user_identity, 'address', true);
$profile_videos = get_user_meta($user_identity, 'audio_video_urls', true);
$provider_category	= listingo_get_provider_category($current_user->ID);

if (empty($profile_videos)) {
    $profile_videos = array(
        0 => ''
    );
}

$professional_statements = get_user_meta($user_identity, 'professional_statements', true);
$profile_awards = get_user_meta($user_identity, 'awards', true);
$profile_experinces = get_user_meta($user_identity, 'experience', true);
$profile_qualification = get_user_meta($user_identity, 'qualification', true);

if (function_exists('fw_get_db_settings_option')) {
    $dir_longitude = fw_get_db_settings_option('dir_longitude');
    $dir_latitude = fw_get_db_settings_option('dir_latitude');
    $dir_longitude = !empty($dir_longitude) ? $dir_longitude : '-0.1262362';
    $dir_latitude = !empty($dir_latitude) ? $dir_latitude : '51.5001524';
} else {
    $dir_longitude = '-0.1262362';
    $dir_latitude = '51.5001524';
}

$profile_latitude = !empty($profile_latitude) ? $profile_latitude : $dir_longitude;
$profile_longitude = !empty($profile_longitude) ? $profile_longitude : $dir_latitude;

$profile_settings	= listingo_profile_settings();
$profile_settings	= apply_filters('listingo_filter_profile_settings',$profile_settings);
?>
<div id="tg-content" class="tg-content">
    <div class="tg-dashboard tg-dashboardprofilesetting">
        <form class="tg-themeform sp-dashboard-profile-form">
            <fieldset>
               	<?php 
					foreach( $profile_settings as $key => $value  ){
						get_template_part('directory/front-end/templates/profile-settings/profile-setting', $key);

					}
				?>
                <div id="tg-updateall" class="tg-updateall">
                    <div class="tg-holder">
                        <?php wp_nonce_field('sp_profile_settings_nonce', 'profile-settings-update'); ?>
                        <span class="tg-note"><?php esc_html_e('Click update now to update the latest added details.', 'listingo'); ?></span>
                        <a class="tg-btn update-profile-dashboard" href="javascript:;"><?php esc_html_e('Update Now', 'listingo'); ?></a>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>