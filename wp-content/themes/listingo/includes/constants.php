<?php

/**
 *  Contants
 */
if (!function_exists('listingo_prepare_constants')) {

    function listingo_prepare_constants() {
		global $current_user;
		$allowed_photos	= apply_filters( 'listingo_get_allowed_number', 'subscription_gallery_photos','sp_gallery_photos' );
		$allowed_videos	= apply_filters( 'listingo_get_allowed_number', 'subscription_videos','sp_videos' );
		$allowed_profile_photos	= apply_filters( 'listingo_get_allowed_number', 'subscription_photos_limit','sp_photos_limit' );
		$allowed_banners_photos	= apply_filters( 'listingo_get_allowed_number', 'subscription_banners_limit','sp_banners_limit' );
		
        $is_loggedin = 'false';
        if (is_user_logged_in()) {
            $is_loggedin = 'true';
        }
		
		$dir_spinner = get_template_directory_uri() . '/images/spinner.gif';
		$chatloader = get_template_directory_uri() . '/images/chatloader.gif';
		
		$navfixed	= 'no';	
		$calendar_locale    = 'en';
		$calendar_format	= 'Y-m-d';
		$loading_duration	= 500;
		
		$startweekday	= get_option('start_of_week');
		$startweekday	=  !empty( $startweekday ) ?  $startweekday : 0;
		
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
			$sticky = fw_get_db_settings_option('sticky');
			$preloader = fw_get_db_settings_option('preloader');
			$calendar_format    = fw_get_db_settings_option('calendar_format');
			$calendar_locale    = fw_get_db_settings_option('calendar_locale');
			$sm_success    = fw_get_db_settings_option('sm_success');
			$calendar_format	= !empty( $calendar_format ) ?  $calendar_format : 'Y-m-d';
			
			$tip_content_bg     = fw_get_db_settings_option('tip_content_bg');
			$tip_content_color  = fw_get_db_settings_option('tip_content_color');
			$tip_title_bg    	= fw_get_db_settings_option('tip_title_bg');
			$tip_title_color    = fw_get_db_settings_option('tip_title_color');
			$exclude_auth    = fw_get_db_settings_option('exclude_auth');
			$captcha_settings = fw_get_db_settings_option('captcha_settings');
			$site_key = fw_get_db_settings_option('site_key');
			
			
			$loading_duration	= !empty( $preloader['enable']['loader_speed'] ) ? $preloader['enable']['loader_speed'] : 500;
			
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
			$sticky	= 'no';
			$loading_duration	= 500;
			$captcha_settings = '';
			$site_key = '';
        }
		
		if( isset( $sticky ) && $sticky === 'enable' ){
			$navfixed	= 'yes';	
		}
		
		if( $dir_datasize >= 1024 ){
			 $dir_datasize	= trim($dir_datasize);
			 $data_size_in_kb = $dir_datasize / 1024;
		} else{
			$data_size_in_kb = 5242880;
		}
		
		$unit	= listingo_get_distance_scale();
		$distance_unit = !empty( $unit ) && $unit === 'Mi' ? esc_html__('Mi','listingo') : esc_html__('Km','listingo');
		
		$sm_success	=  !empty( $sm_success ) ?  $sm_success : 'top-right';
		
		$tip_content_bg		=  !empty( $tip_content_bg ) ?  $tip_content_bg : '';
		$tip_content_color	=  !empty( $tip_content_color ) ?  $tip_content_color : '';
		$tip_title_bg		=  !empty( $tip_title_bg ) ?  $tip_title_bg : '';
		$tip_title_color	=  !empty( $tip_title_color ) ?  $tip_title_color : '';
		$exclude_auth		=  !empty( $exclude_auth ) ?  $exclude_auth : 'no';
		
		$current_user_id	= !empty( $current_user->ID ) ? $current_user->ID : '';
		
        wp_localize_script('listingo_callbacks', 'scripts_vars', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
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
			'captcha_settings' => $captcha_settings,
			'site_key' => $site_key,
            'dir_map_scroll' => $dir_map_scroll,
			'chatloader'   => '<img class="sp-chatspin" src="'.esc_url($chatloader).'">',
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
            'is_loggedin' => $is_loggedin,
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
			'with_in' => esc_html__('within','listingo'),
			'kilometer' => $distance_unit,
			'spinner'   => '<img class="sp-spin" src="'.esc_url($dir_spinner).'">',
			'navfixed'  => $navfixed,
			'account_verification' => esc_html__('Your account has verified.','listingo'),
			'login_beofer_vote' => esc_html__('Please login before add your vote.','listingo'),
			
			'days' => esc_html__('Days','listingo'),
			'hours' => esc_html__('Hours','listingo'),
			'minutes' => esc_html__('Minutes','listingo'),
			'expired' => esc_html__('EXPIRED','listingo'),
			'min_and' => esc_html__('Minutes and','listingo'),
			'seconds' => esc_html__('Seconds','listingo'),
			
			'calendar_format' => $calendar_format,
			'calendar_locale' => $calendar_locale,
			
			'yes' => esc_html__('Yes','listingo'),
			'no' => esc_html__('No','listingo'),
			
			'allowed_photos' => $allowed_photos,
			'allowed_videos' => $allowed_videos,
			'allowed_profile_photos' => $allowed_profile_photos,
			'allowed_banners_photos' => $allowed_banners_photos,
			'loading_duration' => $loading_duration,
			'sm_success' => $sm_success,
			
			'tip_content_bg' => $tip_content_bg,
			'tip_content_color' => $tip_content_color,
			'tip_title_bg' => $tip_title_bg,
			'tip_title_color' => $tip_title_color,
			'current_user_id' => $current_user_id,
			'startweekday' => $startweekday,
			'exclude_auth' => $exclude_auth,

			'upload_message' => esc_html__('Oops! you reached to maximum upload limit. Please upgrade your package or contact to your site administrator.','listingo'),
			'upload_alllowed_message' => esc_html__('Allowed number of photos are only','listingo'),
			'video_limit' => esc_html__('Oops! you reached to maximum allowed limit. Please upgrade your package to add more video links','listingo'),
			'valid_email' => esc_html__('Please add a valid email address.','listingo'),
			
			'cache_title' => esc_html__('Confirm?','listingo'),
			'cache_message' => esc_html__('Never show this message again','listingo'),
			'placeholder_text_multiple' => esc_html__('Select options','listingo'),
			'no_results_text' => esc_html__('Oops, nothing found!','listingo'),
			'fileuploading' => esc_html__('File uploading','listingo'),
            'placeholder_text_single' => esc_html__('Select an Option','listingo'),
			'request_category_title' => esc_html__('Confirm Request?','listingo'),
			'request_category_desc' => esc_html__('Are you sure you want to requet to change your category','listingo'),
        ));
    }

    add_action('wp_enqueue_scripts', 'listingo_prepare_constants', 90);
}