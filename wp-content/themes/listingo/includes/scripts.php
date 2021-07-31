<?php

/**
 *
 * General Theme Functions
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
if (!function_exists('listingo_scripts')) {

    function listingo_scripts() {
        $theme_version = wp_get_theme('listingo');
        $google_key = '';

        if (function_exists('fw_get_db_settings_option')) {
            $google_key = fw_get_db_settings_option('google_key');
        }

        $protocol = is_ssl() ? 'https' : 'http';

        wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), $theme_version->get('Version'));
        wp_register_style('normalize', get_template_directory_uri() . '/css/normalize.css', array(), $theme_version->get('Version'));
        wp_register_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), $theme_version->get('Version'));
        wp_register_style('listingo_linearicons', get_template_directory_uri() . '/css/linearicons.css', array(), $theme_version->get('Version'));
        wp_register_style('scrollbar', get_template_directory_uri() . '/css/scrollbar.css', array(), $theme_version->get('Version'));
        wp_register_style('jquery-ui', get_template_directory_uri() . '/css/jquery-ui.css', array(), $theme_version->get('Version'));
        wp_register_style('prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css', array(), $theme_version->get('Version'));
        wp_register_style('owl.carousel', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), $theme_version->get('Version'));
        wp_register_style('owl.theme.default', get_template_directory_uri() . '/css/owl.theme.default.min.css', array(), $theme_version->get('Version'));
        wp_register_style('jquery.countdown', get_template_directory_uri() . '/css/jquery.countdown.css', array(), $theme_version->get('Version'));
        wp_register_style('animate', get_template_directory_uri() . '/css/animate.css', array(), $theme_version->get('Version'));
        wp_register_style('chat_module_css', get_template_directory_uri() . '/css/chat_module.css', array(), $theme_version->get('Version'));
        wp_register_style('listingo_transitions', get_template_directory_uri() . '/css/transitions.css', array(), $theme_version->get('Version'));
        wp_register_style('listingo_style', get_template_directory_uri() . '/style.css', array(), $theme_version->get('Version'));
        wp_register_style('listingo_typo', get_template_directory_uri() . '/css/typo.css', array(), $theme_version->get('Version'));
        wp_register_style('listingo_color', get_template_directory_uri() . '/css/color.css', array(), $theme_version->get('Version'));
        wp_register_style('listingo_responsive', get_template_directory_uri() . '/css/responsive.css', array('chat_module_css'), $theme_version->get('Version'));
        wp_register_style('datetimepicker', get_template_directory_uri() . '/css/datetimepicker.css', array(), $theme_version->get('Version'));
        wp_register_style('chosen', get_template_directory_uri() . '/css/chosen.css', array(), $theme_version->get('Version'));
        wp_register_style('balloon', get_template_directory_uri() . '/css/balloon.min.css', array(), $theme_version->get('Version'));      
        wp_register_style('pogoslider', get_template_directory_uri() . '/css/pogoslider.css', array(), $theme_version->get('Version'));  
        wp_register_style('emojionearea.min', get_template_directory_uri() . '/css/emoji/emojionearea.min.css', array(), $theme_version->get('Version'));                 
         
        $custom_css = listingo_add_dynamic_styles();

        wp_enqueue_style('bootstrap');
        wp_enqueue_style('normalize');
        wp_enqueue_style('font-awesome');
        wp_enqueue_style('jquery-ui');
        wp_enqueue_style('listingo_linearicons');
        wp_enqueue_style('scrollbar');
        wp_enqueue_style('prettyPhoto');
        wp_enqueue_style('owl.carousel');
        wp_enqueue_style('owl.theme.default');
        wp_enqueue_style('jquery.countdown');
        wp_enqueue_style('datetimepicker');
        wp_enqueue_style('chosen');
        wp_enqueue_style('listingo_transitions');
        wp_enqueue_style('listingo_style');
        wp_enqueue_style('listingo_color');
        wp_enqueue_style('listingo_typo');
        wp_add_inline_style('listingo_typo', $custom_css);
        
        if(is_rtl()){
            wp_register_style('listingo-rtl', get_template_directory_uri() . '/css/styles-rtl.css', array(), $theme_version->get('Version'));             
            wp_enqueue_style('listingo-rtl');
            wp_enqueue_style('listingo_responsive', array('listingo-rtl','chat_module_css'));
        } else {
            wp_enqueue_style('listingo_responsive');
        }
                       
        //script
        wp_register_script('modernizr-2.8.3-respond-1.4.2.min', get_template_directory_uri() . '/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js', array(), $theme_version->get('Version'), false);
        wp_register_script('bootstrap.min', get_template_directory_uri() . '/js/vendor/bootstrap.min.js', array(), $theme_version->get('Version'), true);
        wp_register_script('jquery.countdown', get_template_directory_uri() . '/js/jquery.countdown.js', array(), $theme_version->get('Version'), true);
        wp_register_script('owl.carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), $theme_version->get('Version'), true);
        wp_register_script('scrollbar.min', get_template_directory_uri() . '/js/scrollbar.min.js', array(), $theme_version->get('Version'), true);
        wp_register_script('prettyPhoto', get_template_directory_uri() . '/js/prettyPhoto.js', array(), $theme_version->get('Version'), true);
        wp_register_script('readmore', get_template_directory_uri() . '/js/readmore.js', array(), $theme_version->get('Version'), true);
        wp_register_script('listingo_callbacks', get_template_directory_uri() . '/js/listingo_callbacks.js', array(
            'jquery'), $theme_version->get('Version'), true);
        wp_register_script('listingo_user_dashboard', get_template_directory_uri() . '/js/user-dashboard.js', array(), $theme_version->get('Version'), true);
        wp_register_script('listingo_bookings', get_template_directory_uri() . '/js/bookings.js', array(), $theme_version->get('Version'), true);
        wp_register_script('moment', get_template_directory_uri() . '/js/moment.js', array(), $theme_version->get('Version'));
        wp_register_script('datetimepicker', get_template_directory_uri() . '/js/datetimepicker.js', array(), $theme_version->get('Version'), true);
        wp_register_script('chosen.jquery', get_template_directory_uri() . '/js/chosen.jquery.js', array(), $theme_version->get('Version'), true);
        wp_register_script('auto-complete', get_template_directory_uri() . '/js/jquery.auto-complete.js', array(), $theme_version->get('Version'), true);
        wp_register_script('markerclusterer', get_template_directory_uri() . '/js/maps/markerclusterer.min.js', array(), $theme_version->get('Version'), true);
        wp_register_script('listingo_gmaps', get_template_directory_uri() . '/js/maps/gmaps.js', array(), $theme_version->get('Version'), true);		
        wp_register_script('oms', get_template_directory_uri() . '/js/maps/oms.min.js', array(), $theme_version->get('Version'), true);
        wp_register_script('listingo_infobox', get_template_directory_uri() . '/js/maps/infobox.js', array(), $theme_version->get('Version'), true);
        wp_register_script('listingo_maps', get_template_directory_uri() . '/js/listingo_maps.js', array(), $theme_version->get('Version'), true);
        wp_register_script('jRate', get_template_directory_uri() . '/js/jRate.js', '', '', true);
        wp_register_script('parallax', get_template_directory_uri() . '/js/parallax.js', '', '', true);
        wp_register_script('tipso.min', get_template_directory_uri() . '/js/tipso.min.js', '', '', true);
        wp_register_script('sticky-kit', get_template_directory_uri() . '/js/jquery.sticky-kit.min.js', '', '', true);
        wp_register_script('countTo', get_template_directory_uri() . '/js/countTo.js', '', '', false);
        wp_register_script('appear', get_template_directory_uri() . '/js/appear.js', '', '', false);  
        wp_register_script('pogoslider', get_template_directory_uri() . '/js/pogoslider.js', '', '', false);
        wp_register_script('chat_module_js', get_template_directory_uri() . '/js/chat_module.js', array(), '', true);
		wp_register_script('linkify.min', get_template_directory_uri() . '/js/linkify/linkify.min.js', array(), '', true);
		wp_register_script('linkify-string.min', get_template_directory_uri() . '/js/linkify/linkify-string.min.js', array(), '', true);
		wp_register_script('linkify-jquery.min.js', get_template_directory_uri() . '/js/linkify/linkify-jquery.min.js', array(), '', true);
		
		wp_register_script('emojionearea.min', get_template_directory_uri() . '/js/emoji/emojionearea.min.js', array(), '', true);         
        
        if (!empty($google_key)) {
            wp_register_script('jquery-googleapis', $protocol . '://maps.googleapis.com/maps/api/js?key=' . trim($google_key) . '&libraries=places', '', '', true);
        } else {
            wp_register_script('jquery-googleapis', $protocol . '://maps.googleapis.com/maps/api/js?sensor=false&libraries=places', '', '', true);
        }

        wp_register_script('gmap3', get_template_directory_uri() . '/js/gmap3.min.js', array('jquery-ui-autocomplete'), '', true);

        wp_enqueue_script('modernizr-2.8.3-respond-1.4.2.min');
        wp_enqueue_script('bootstrap.min');
        wp_enqueue_script('jquery-googleapis');
        wp_enqueue_script('gmap3');
        wp_enqueue_script('jquery.countdown');
        wp_enqueue_script('owl.carousel');
        wp_enqueue_script('scrollbar.min');
        wp_enqueue_script('prettyPhoto');
        wp_enqueue_script('listingo_callbacks');
        wp_enqueue_script('moment');
        wp_enqueue_script('datetimepicker');
        wp_enqueue_script('wp-util');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-slider');
        wp_enqueue_script('chosen.jquery');
        wp_enqueue_script('auto-complete');
        wp_enqueue_script('parallax');
        wp_enqueue_script('countTo');
        wp_enqueue_script('appear');

        //gMaps scripts at search result page.
        if (is_page_template('directory/search.php') || is_singular('sp_categories') || is_tax('sub_category') || is_tax('countries') || is_tax('cities') || is_tax('insurance') || is_tax('languages') || is_tax('amenities')
        ) {
            wp_enqueue_script('markerclusterer');
            wp_enqueue_script('listingo_infobox');
            wp_enqueue_script('listingo_maps');
            wp_enqueue_script('listingo_gmaps');
            wp_enqueue_script('oms');
            wp_enqueue_script('sticky-kit');
        }
		
		//Captcha settings
		if(function_exists('fw_get_db_settings_option')){
			$language_code    = fw_get_db_settings_option('language_code');
			$captcha_settings = fw_get_db_settings_option('captcha_settings');
			$language_code	  = empty( $language_code ) ? 'en' : $language_code;
		} else {
			$language_code    = 'en';
			$captcha_settings = '';
		}
		
		if( isset( $captcha_settings ) && $captcha_settings === 'enable' ) {
			wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js?onload=ListingoCaptchaCallback&render=explicit&hl='.$language_code, array(), $theme_version->get( 'Version' ), true);
		}
		
        if ( ( is_page_template('directory/dashboard.php') && isset($_GET['ref']) == 'chat' ) || is_author() ) {
			
			if( ( is_page_template('directory/dashboard.php') && isset($_GET['ref']) == 'chat' ) ){
				wp_enqueue_script('linkify.min');
				wp_enqueue_script('linkify-string.min');
				wp_enqueue_script('linkify-jquery.min.js');
			}
           
            wp_enqueue_script('chat_module_js');
            wp_enqueue_style('chat_module_css');
            wp_enqueue_style('emojionearea.min');
            wp_enqueue_script('emojionearea.min');
        }

        //Add maps in dashboard
        if (is_page_template('directory/dashboard.php')) {
            wp_enqueue_script('listingo_maps');
            wp_enqueue_script('plupload');
            wp_enqueue_script('listingo_user_dashboard');
            wp_enqueue_script('tipso.min');
        }
		
		
		if (is_singular()) {
            $_post = get_post();
            if ($_post != null) {
                if ($_post &&
                        (
							preg_match('/listingo_authentication/', $_post->post_content) ||
							preg_match('/listingo_authentication_signup/', $_post->post_content) ||
							preg_match('/listingo_authentication_signin/', $_post->post_content) ||
							preg_match('/user_lostpassword/', $_post->post_content)

                        )
                ) {
                   wp_enqueue_script('tipso.min');
                }
            }
        }
		
        //Add rating script in at detail page.
        if ( is_author() || is_singular('sp_ads') ) {
            wp_enqueue_script('jRate');
            wp_enqueue_script('listingo_gmaps');
            wp_enqueue_script('readmore');
        }

        //Map at job detail page
        if (is_singular('sp_jobs')) {
            wp_enqueue_script('listingo_maps');
            wp_enqueue_script('readmore');
        }

        //Ad detail page files
        if (is_singular('sp_ads')) {
            wp_enqueue_script('jRate');
            wp_enqueue_script('plupload');                                      
        }        
		
        //Bookings
        if (is_page_template('directory/appointment-booking.php')) {
            wp_enqueue_script('listingo_bookings');
        }

        //Ui slider enqueue script
        if (is_singular()) {
            $_post = get_post();
            if ($_post != null) {
                if ($_post &&
                        (
							preg_match('/sp_search_form_v2/', $_post->post_content) ||
							preg_match('/sp_search_form/', $_post->post_content) ||
							preg_match('/sp_slider/', $_post->post_content) ||
							preg_match('/sp_home_slider_v4/', $_post->post_content) ||
							preg_match('/listingo_vc_search_form_two/', $_post->post_content) ||
							preg_match('/listingo_vc_search_form/', $_post->post_content) ||
							preg_match('/listingo_vc_sp_slider/', $_post->post_content) ||
							preg_match('/listingo_vc_search_form_home_slider_four/', $_post->post_content)
                        )
                ) {
                    wp_enqueue_script('listingo_maps');
                }
            }
        }

        $sticky_header = '';
        if (function_exists('fw_get_db_settings_option')) {
            $sticky_header = fw_get_db_settings_option('sticky_header');
        }

        wp_localize_script('listingo_callbacks', 'scripts_vars', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'sticky_header' => $sticky_header,
        ));

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        if (function_exists('fw_get_framework_directory_uri')):
            if (!is_admin()) {
                wp_enqueue_script('fw-form-helpers', fw_get_framework_directory_uri('/static/js/fw-form-helpers.js'));
            }
        endif;
    }

    add_action('wp_enqueue_scripts', 'listingo_scripts', 88);
}


/**
 * @Enqueue admin scripts and styles.
 * @return{}
 */
if (!function_exists('listingo_admin_enqueue')) {

    function listingo_admin_enqueue($hook) {
        global $post;
        $protolcol = is_ssl() ? "https" : "http";
        $theme_version = wp_get_theme('listingo');

        //Styles
		$colorpicker_l10n = array(
			'clear' 		=> esc_html__( 'Clear', 'listingo' ),
			'defaultString' => esc_html__( 'Default', 'listingo' ),
			'pick' 			=> esc_html__( 'Select Color', 'listingo' ),
			'current' 		=> esc_html__( 'Current Color', 'listingo' ),
		);
		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n ); 
		
        wp_enqueue_style('chosen', get_template_directory_uri() . '/css/chosen.css', array(), $theme_version->get('Version'));
        wp_enqueue_style('listingo_fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), $theme_version->get('Version'));
        wp_enqueue_style('listingo_admin_style', get_template_directory_uri() . '/admin/css/admin-style.css', array(), $theme_version->get('Version'));
        wp_enqueue_style('listingo_linearicons', get_template_directory_uri() . '/css/linearicons.css', array(), $theme_version->get('Version'));
        wp_enqueue_style('datetimepicker', get_template_directory_uri() . '/css/datetimepicker.css', array(), $theme_version->get('Version'));


        $google_key = '';
        if (function_exists('fw_get_db_settings_option')) {
            $google_key = fw_get_db_settings_option('google_key');
        }

        wp_enqueue_media();
        wp_enqueue_script('moment', get_template_directory_uri() . '/js/moment.js', array(), $theme_version->get('Version'));
        wp_enqueue_script('datetimepicker', get_template_directory_uri() . '/js/datetimepicker.js', array(), $theme_version->get('Version'), true);
        wp_enqueue_script('jquery-goolge-places', $protolcol . '://maps.googleapis.com/maps/api/js?key=' . esc_attr($google_key) . '&libraries=places', '', '', true);
        wp_enqueue_script('gmap3', get_template_directory_uri() . '/js/gmap3.min.js', array('jquery-ui-autocomplete'), '', false);
        wp_enqueue_script('chosen.jquery', get_template_directory_uri() . '/js/chosen.jquery.js', array(), $theme_version->get('Version'), true);
        wp_enqueue_script('listingo_admin_functions', get_template_directory_uri() . '/admin/js/admin_functions.js', array('jquery'), $theme_version->get('Version'), false);

        if (function_exists('fw_get_db_settings_option')) {
            $dir_cluster_marker = fw_get_db_settings_option('dir_cluster_marker');
            $dir_map_marker = fw_get_db_settings_option('dir_map_marker');
            $dir_cluster_color = fw_get_db_settings_option('dir_cluster_color');
            $dir_map_type = fw_get_db_settings_option('dir_map_type');
            $dir_zoom = fw_get_db_settings_option('dir_zoom');
            $dir_longitude = fw_get_db_settings_option('dir_longitude');
            $dir_latitude = fw_get_db_settings_option('dir_latitude');
            $dir_datasize = fw_get_db_settings_option('dir_datasize');
            $dir_map_scroll = fw_get_db_settings_option('dir_map_scroll');
            $map_styles = fw_get_db_settings_option('map_styles');
            $country_restrict = fw_get_db_settings_option('country_restrict');
            $dir_close_marker = get_template_directory_uri() . '/images/close.gif';

            if (!empty($country_restrict['gadget']) && $country_restrict['gadget'] === 'enable' && !empty($country_restrict['enable']['country_code'])) {
                $country_restrict = $country_restrict['enable']['country_code'];
            } else {
                $country_restrict = '';
            }

            if (!empty($dir_cluster_marker)) {
                $dir_cluster_marker = $dir_cluster_marker['url'];
            } else {
                $dir_cluster_marker = get_template_directory_uri() . '/images/cluster.png';
            }

            if (empty($dir_map_marker)) {
                $dir_map_marker = get_template_directory_uri() . '/images/marker.png';
            }

            if (empty($dir_cluster_color)) {
                $dir_cluster_color = '#7dbb00';
            }

            if (empty($dir_map_type)) {
                $dir_map_type = 'ROADMAP';
            }

            if (empty($dir_zoom)) {
                $dir_zoom = '12';
            }

            if (empty($dir_longitude)) {
                $dir_longitude = '-0.1262362';
            }

            if (empty($dir_latitude)) {
                $dir_latitude = '51.5001524';
            }

            if (empty($dir_datasize)) {
                $dir_datasize = '5242880';
            }

            if (empty($dir_map_scroll)) {
                $dir_map_scroll = 'false';
            }
        } else {
            $dir_cluster_marker = get_template_directory_uri() . '/images/cluster.png';
            $dir_map_marker = get_template_directory_uri() . '/images/marker.png';
            $dir_cluster_color = '#7dbb00';
            $dir_map_type = 'ROADMAP';
            $dir_zoom = '12';
            $dir_longitude = '-0.1262362';
            $dir_latitude = '51.5001524';
            $dir_datasize = '5242880';
            $dir_map_scroll = 'false';
            $map_styles = 'none';
            $country_restrict = '';
            $dir_close_marker = get_template_directory_uri() . '/images/close.gif';
        }

        $calendar_locale = 'en';
        $calendar_format = 'Y-m-d';
        $data_size_in_kb = $dir_datasize / 1024;

        if (function_exists('fw_get_db_settings_option')) {
            $calendar_format = fw_get_db_settings_option('calendar_format');
            $calendar_locale = fw_get_db_settings_option('calendar_locale');
            $calendar_format = !empty($calendar_format) ? $calendar_format : 'Y-m-d';
        }

        $dir_spinner = get_template_directory_uri() . '/images/spinner.gif';


        //
        $is_author_edit = '';
        if (isset($hook) && $hook == 'user-edit.php') {
            $is_author_edit = 'yes';
        }

        wp_localize_script('listingo_admin_functions', 'localize_vars', array(
            'calendar_locale' => $calendar_locale,
            'calendar_format' => $calendar_format,
            'avatar_size' => esc_html__('Minimum avatar size should be 370x270', 'listingo'),
            'banner_size' => esc_html__('Minimum avatar size should be 1920x350', 'listingo'),
            'gallery_size' => esc_html__('Minimum avatar size should be 150x150', 'listingo'),
            'no_record' => esc_html__('No Record Found.', 'listingo'),
            'delete_business_hour' => esc_html__('Time Slot Deleted Notification', 'listingo'),
            'delete_business_hour_message' => esc_html__('Are you sure, you want to delete this time slot?', 'listingo'),
            'delete_video_link' => esc_html__('Audio/Video Slot Deleted Notification', 'listingo'),
            'delete_video_link_message' => esc_html__('Are you sure, you want to delete this audio/video slot?', 'listingo'),
            'delete_appointment_type_text' => esc_html__('Appointment Type Deleted Notification', 'listingo'),
            'delete_appointment_type_message' => esc_html__('Are you sure, you want to delete this appintment type?', 'listingo'),
            'delete_appointment_type_reason' => esc_html__('Appointment Reason Deleted Notification', 'listingo'),
            'delete_appointment_type_reason_message' => esc_html__('Are you sure, you want to delete this appintment reason?', 'listingo'),
            'delete_award' => esc_html__('Awards & Certifications Deleted Notification', 'listingo'),
            'delete_award_message' => esc_html__('Are you sure, you want to delete this award or certification?', 'listingo'),
            'delete_experience' => esc_html__('Experience Deleted Notification', 'listingo'),
            'delete_experience_message' => esc_html__('Are you sure, you want to delete this Experience?', 'listingo'),
            'delete_qualification' => esc_html__('Qualification Deleted Notification', 'listingo'),
            'delete_qualification_message' => esc_html__('Are you sure, you want to delete this Qualification?', 'listingo'),
            'delete_service' => esc_html__('Service Deleted Notification', 'listingo'),
            'delete_service_message' => esc_html__('Are you sure, you want to delete this delete service?', 'listingo'),
            'appointment_check' => esc_html__('(In Appointment)', 'listingo'),
            'free_check' => esc_html__('Free', 'listingo'),
            'sp_upload_nonce' => wp_create_nonce('sp_upload_nonce'),
            'sp_upload_profile' => esc_html__('Avatar Upload', 'listingo'),
            'sp_upload_banner' => esc_html__('Banner Upload', 'listingo'),
            'sp_upload_gallery' => esc_html__('Gallery Upload', 'listingo'),
            'sp_upload_awards' => esc_html__('Awards Image Upload', 'listingo'),
            'sp_upload_brochure' => esc_html__('Brochure Upload', 'listingo'),
            'data_size_in_kb' => $data_size_in_kb . 'kb',
            'delete_message' => esc_html__('Are you sure you want to delete your account?', 'listingo'),
            'deactivate' => esc_html__('Are you sure you want to deactivate your account?', 'listingo'),
            'delete_title' => esc_html__('Delete account?', 'listingo'),
            'deactivate_title' => esc_html__('Deactivate account?', 'listingo'),
            'avatar_active_title' => esc_html__('Set Profile Avatar', 'listingo'),
            'avatar_active_message' => esc_html__('Are you sure you want to set your default profile avatar photo?', 'listingo'),
            'banner_active_title' => esc_html__('Set Profile Banner', 'listingo'),
            'banner_active_message' => esc_html__('Are you sure you want to set your default profile banner photo?', 'listingo'),
            'language_select' => esc_html__('Please Choose the langugae first.', 'listingo'),
            'language_already_add' => esc_html__('You have already added the langugae.', 'listingo'),
            'amenities_select' => esc_html__('Please Choose the Amenity first.', 'listingo'),
            'amenities_already_add' => esc_html__('You have already added the Amenity.', 'listingo'),
            'delete_amenity_title' => esc_html__('Delete Amenity?.', 'listingo'),
            'delete_amenity_msg' => esc_html__('Are you sure you want to delete this Amenity.', 'listingo'),
            'insurance_select' => esc_html__('Please Choose the insurance first.', 'listingo'),
            'insurance_already_add' => esc_html__('You have already added the insurance.', 'listingo'),
            'delete_insurance_title' => esc_html__('Delete insurance?.', 'listingo'),
            'delete_insurance_msg' => esc_html__('Are you sure you want to delete this insurance.', 'listingo'),
            'delete_lang_title' => esc_html__('Delete Language?', 'listingo'),
            'delete_lang_msg' => esc_html__('Are you sure you want to delete this Language.', 'listingo'),
            'dir_close_marker' => $dir_close_marker,
            'dir_cluster_marker' => $dir_cluster_marker,
            'dir_map_marker' => $dir_map_marker,
            'dir_cluster_color' => $dir_cluster_color,
            'dir_map_type' => $dir_map_type,
            'dir_zoom' => $dir_zoom,
            'dir_longitude' => $dir_longitude,
            'dir_latitude' => $dir_latitude,
            'dir_datasize' => $dir_datasize,
            'dir_map_scroll' => $dir_map_scroll,
            'map_styles' => $map_styles,
            'country_restrict' => $country_restrict,
            'complete_fields' => esc_html__('Please fill all the fields.', 'listingo'),
            'system_error' => esc_html__('An error occurred, please try again later', 'listingo'),
            'delete_slot' => esc_html__('Delete slot?', 'listingo'),
            'delete_slot_message' => esc_html__('Are you sure you want to delete this slot.', 'listingo'),
            'add_team' => esc_html__('Add to list', 'listingo'),
            'view_profile' => esc_html__('View Full Profile', 'listingo'),
            'delete_teams' => esc_html__('Delete member', 'listingo'),
            'delete_teams_message' => esc_html__('Are you sure, you want to delete this team member?', 'listingo'),
            'no_team' => esc_html__('No team members, Add your teams now.', 'listingo'),
            'order' => esc_html__('Process order?', 'listingo'),
            'order_message' => esc_html__('Are you sure, you want to process this order?', 'listingo'),
            'nothing_update' => esc_html__('Oops! Nothing to update.', 'listingo'),
            'delete_job_title' => esc_html__('Delete job?', 'listingo'),
            'delete_job_msg' => esc_html__('Are you sure you want to delete this job.', 'listingo'),
            'rating_1' => esc_html__('Not Satisfied', 'listingo'),
            'rating_2' => esc_html__('Satisfied', 'listingo'),
            'rating_3' => esc_html__('Good', 'listingo'),
            'rating_4' => esc_html__('Very Good', 'listingo'),
            'rating_5' => esc_html__('Excellent', 'listingo'),
            'title_blank' => esc_html__('Review title is required.', 'listingo'),
            'description_blank' => esc_html__('Review description is required.', 'listingo'),
            'submit_review' => esc_html__('Submit review', 'listingo'),
            'fav_message' => esc_html__('Please login to add user in favorite list.', 'listingo'),
            'sp_appointment_service_msg' => esc_html__('Please choose the service first.', 'listingo'),
            'sp_appointment_types_msg' => esc_html__('Please choose the appointment type.', 'listingo'),
            'sp_appointment_reasosns_msg' => esc_html__('Please choose the appointment reasosn.', 'listingo'),
            'sp_appointment_auth' => esc_html__('Authentication field must not be empty.', 'listingo'),
            'sp_appointment_pass' => esc_html__('Password Field must not be empty.', 'listingo'),
            'sp_appointment_pass_confirm' => esc_html__('Password confirmation field must not be empty.', 'listingo'),
            'sp_appointment_pass_match' => esc_html__('You password did not match.', 'listingo'),
            'approve_appt_type' => esc_html__('Appointment Approve Notification.', 'listingo'),
            'approve_appt_type_msg' => esc_html__('Are you sure, you want to approve this appintment.', 'listingo'),
            'reject_appt_type' => esc_html__('Appointment Rejection Notification.', 'listingo'),
            'reject_appt_type_msg' => esc_html__('Are you sure, you want to reject this appintment.', 'listingo'),
            'sp_rejection_title_field' => esc_html__('Rejection title required.', 'listingo'),
            'no_favorite' => esc_html__('No favorite provider.', 'listingo'),
            'infomation' => esc_html__('Information', 'listingo'),
            'delete_favorite' => esc_html__('Delete?', 'listingo'),
            'next' => esc_html__('Next', 'listingo'),
            'understand' => esc_html__('I Understand!', 'listingo'),
            'finish' => esc_html__('Finish', 'listingo'),
            'delete_favorite_message' => esc_html__('Are you sure you want to delete this?', 'listingo'),
            'spinner' => '<img class="sp-spin" src="' . esc_url($dir_spinner) . '">',
            'process_withdrawal_title' => esc_html__('Process this transaction', 'listingo'),
            'process_withdrawal_desc' => esc_html__('Are your sure you want to prcess this ttransaction. Please note : after this transaction you will be able to process 2nd transaction for this month.', 'listingo'),
            'yes' => esc_html__('Yes', 'listingo'),
            'no' => esc_html__('No', 'listingo'),
            'is_author_edit' => $is_author_edit
        ));
    }

    add_action('admin_enqueue_scripts', 'listingo_admin_enqueue', 10, 1);
}

/**
 * @Theme Editor Style
 * 
 */
if (!function_exists('listingo_add_editor_styles')) {

    function listingo_add_editor_styles() {
        $theme_version = wp_get_theme('listingo');
        add_editor_style(get_template_directory_uri() . '/admin/css/listingo-editor-style.css', array(), $theme_version->get('Version'));
    }

    add_action('admin_init', 'listingo_add_editor_styles');
}