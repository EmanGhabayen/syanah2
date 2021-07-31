<?php

/**
 *  Contants
 */
if (!function_exists('fw_ext_ad_sp_prepare_constants')) {

    function fw_ext_ad_sp_prepare_constants() {
        $is_loggedin = 'false';
        if (is_user_logged_in()) {
            $is_loggedin = 'true';
        }
        wp_localize_script('fw_ext_ads_callback', 'fw_ext_ads_scripts_vars', array(
            'ajaxurl' => admin_url('admin-ajax.php'),            
            'delete_ad_title' => esc_html__('Ad delete notification.', 'listingo'),
			'delete_ad_msg' => esc_html__('Are you sure, you want to delete this ad?', 'listingo'),
            'fav_message' => esc_html__('Please login first', 'listingo'),
            'is_loggedin' => $is_loggedin,
            'sp_upload_nonce' => wp_create_nonce('sp_upload_nonce'),
            'sp_upload_gallery' => esc_html__('Gallery Upload', 'listingo'),
            'delete_all_ad_title' => esc_html__('Ads delete notification.', 'listingo'),
			'delete_all_ad_msg' => esc_html__('Are you sure, you want to delete all ads?', 'listingo'),
			'listingo_featured_nounce' => wp_create_nonce ( 'listingo_featured_nounce' ),
			'file_upload_title' => esc_html__('Feature image upload','listingo'),
			'theme_path_uri' => get_template_directory_uri(),
			'theme_path' => get_template_directory(),
        ));
    }

    add_action('wp_enqueue_scripts', 'fw_ext_ad_sp_prepare_constants', 90);
}