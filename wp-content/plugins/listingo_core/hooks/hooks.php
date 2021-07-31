<?php
/**
 *
 * @package   Listingo Core
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * @Rename Menu
 * @return {}
 */
if (!function_exists('tg_edit_admin_menus')) {

    function tg_edit_admin_menus() {
        global $menu, $submenu;
        foreach ($menu as $key => $menu_item) {
            if ($menu_item[2] == 'edit.php?post_type=categories') {
                $menu[$key][0] = esc_html__('Listingo', 'listingo_core');
            }
        }
    }

    add_action('admin_menu', 'tg_edit_admin_menus');
}


/**
 * @User Delete
 * Return{}
 */
if (!function_exists('listingo_wp_user_delete_notification')) {

    function listingo_wp_user_delete_notification($user_id = '', $reason = '') {

        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

        $message = sprintf(esc_html__('User deleted %s:', 'listingo_core'), $blogname) . "\r\n\r\n";
        $message = sprintf(esc_html__('An existing user has deleted your account due to following reason: %s', 'listingo_core'), $reason) . "\r\n\r\n";
        $message .= sprintf(esc_html__('Username: %s', 'listingo_core'), $user->user_login) . "\r\n\r\n";
        $message .= sprintf(esc_html__('E-mail: %s', 'listingo_core'), $user->user_email) . "\r\n";

        @wp_mail(get_option('admin_email'), sprintf(esc_html__('[%s] User Deleted', 'listingo_core'), $blogname), $message);
    }

}

/**
 * @User registeration
 * Return{}
 */
if (!function_exists('listingo_user_registration')) {

    function listingo_user_registration($atts = '') {
        global $wpdb;
        $captcha_settings = '';
		$verify_user 	  = 'off';
		$verify_switch 	  = '';

		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
		if (function_exists('fw_get_db_settings_option')) {
            $verify_switch = fw_get_db_settings_option('verify_user', $default_value = null);
        }

        //Validations
        if (isset($_POST['register']['account']) && esc_attr($_POST['register']['account']) === 'seeker') {
            $do_check = check_ajax_referer('register_seeker_request', 'register_seeker_request', false);
            if ($do_check == false) {
                $json['type'] = 'error';
                $json['message'] = esc_html__('No kiddies please!', 'listingo_core');
                echo json_encode($json);
                die;
            }

            $data_array = array(
                'username' => esc_html__('Username is required.', 'listingo_core'),
                'first_name' => esc_html__('First name is required.', 'listingo_core'),
                'last_name' => esc_html__('Last name is required.', 'listingo_core'),
                'gender' => esc_html__('Gender is required.', 'listingo_core'),
                'phone' => esc_html__('Phone number is required.', 'listingo_core'),
                'email' => esc_html__('Email address is required.', 'listingo_core'),
                'password' => esc_html__('Password is required.', 'listingo_core'),
                'confirm_password' => esc_html__('Please re-type your password.', 'listingo_core'),
            );

            $db_user_role = 'customer';
        } else {
            $do_check = check_ajax_referer('register_provider_request', 'register_provider_request', false);
            if ($do_check == false) {
                $json['type'] = 'error';
                $json['message'] = esc_html__('No kiddies please!', 'listingo_core');
                echo json_encode($json);
                die;
            }
			
			if( empty( $_POST['register']['type'] ) ){
				$json['type'] = 'error';
                $json['message'] = esc_html__('Please select user type first.', 'listingo_core');
                echo json_encode($json);
                die;
			}

            if (isset($_POST['register']['type']) && esc_attr($_POST['register']['type']) === 'business') {
                $required_fields = array(
                    'company_name' => esc_html__('Company name is required.', 'listingo_core'),
                );
                $db_user_role = 'business';
            } else {

                $required_fields = array(
                    'first_name' => esc_html__('First name is required.', 'flistingo_core'),
                    'last_name' => esc_html__('Last name is required.', 'listingo_core'),
                    'gender' => esc_html__('Gender is required.', 'listingo_core'),
                );
                $db_user_role = 'professional';
            }

            $data_array = array(
                'category' => esc_html__('Please select category.', 'listingo_core'),
                'sub_category' => esc_html__('Sub category is required.', 'listingo_core'),
                'phone' => esc_html__('Phone number is required.', 'listingo_core'),
                'email' => esc_html__('Email address is required.', 'listingo_core'),
                'password' => esc_html__('Password is required.', 'listingo_core'),
                'confirm_password' => esc_html__('Please re-type your password.', 'listingo_core'),
            );

            $data_array = array_merge($data_array, $required_fields);
        }

		//filter to remove/add some required fields from registration form
		$data_array	= apply_filters('listingo_dev_filter_required_fields',$data_array,'yes',$_POST);

        $emailData = array();
        foreach ($data_array as $key => $value) {
            if (empty($_POST['register'][$key])) {
                $json['type'] = 'error';
                $json['message'] = $value;
                echo json_encode($json);
                die;
            }

            if ($key === 'email') {
                if (!is_email($_POST['register'][$key])) {
                    $json['type'] = 'error';
                    $json['message'] = esc_html__('Please add a valid email address.', 'listingo_core');
                    echo json_encode($json);
                    die;
                }
            }

            if ($key === 'confirm_password') {
                if ($_POST['register']['password'] != $_POST['register']['confirm_password']) {
                    $json['type'] = 'error';
                    $json['message'] = esc_html__('Password does not match.', 'listingo_core');
                    echo json_encode($json);
                    die;
                }
            }
        }


        if ($_POST['terms'] === '0') {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Please select term and conditions', 'listingo_core');
            echo json_encode($json);
            die;
        }

        if (function_exists('fw_get_db_settings_option')) {
            $captcha_settings = fw_get_db_settings_option('captcha_settings', $default_value = null);
        }

        //recaptcha check
        if (isset($captcha_settings) && $captcha_settings === 'enable'
        ) {
            if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
                $docReResult = listingo_get_recaptcha_response($_POST['g-recaptcha-response']);

                if ($docReResult == 1) {
                    $workdone = 1;
                } else if ($docReResult == 2) {
                    echo json_encode(array('type' => 'error', 'loggedin' => false, 'message' => esc_html__('An error occurred, please try again later.', 'listingo_core')));
                    die;
                } else {
                    echo json_encode(array('type' => 'error', 'loggedin' => false, 'message' => esc_html__('Wrong reCaptcha. Please verify first.', 'listingo_core')));
                    die;
                }
            } else {
                echo json_encode(array('type' => 'error', 'loggedin' => false, 'message' => esc_html__('Please enter reCaptcha!', 'listingo_core')));
                die;
            }
        }

        //extract post data
        extract($_POST['register']);
        $json = array();
		
		$first_name		= !empty( $first_name ) ? $first_name : '';
		$last_name		= !empty( $last_name ) ? $last_name : '';
		$gender			= !empty( $gender ) ? $gender : '';
		$phone			= !empty( $phone ) ? $phone : '';
		$first_name		= !empty( $first_name ) ? $first_name : '';
		$user_nicename	= !empty( $user_nicename ) ? $user_nicename : $username;

        $random_password = $password;
		
		$userdata = array(
			'user_login'  		=> $username,
			'user_pass'    		=> $random_password,
			'user_email'   		=> $email,  
			'user_nicename'     => $user_nicename,  
		);
		
        $user_identity 	 = wp_insert_user($userdata);
		
        if (is_wp_error($user_identity)) {
            $json['type'] = "error";
            $json['message'] = esc_html__("User already exists. Please try another one.", 'listingo_core');
            echo json_encode($json);
            die;
        } else {
            global $wpdb;
            wp_update_user(array('ID' => esc_sql($user_identity), 'role' => esc_sql($db_user_role), 'user_status' => 1));

            $wpdb->update(
                    $wpdb->prefix . 'users', array('user_status' => 1), array('ID' => esc_sql($user_identity))
            );


            if (isset($_POST['register']['account']) && esc_attr($_POST['register']['account']) === 'seeker') {
                update_user_meta($user_identity, 'first_name', $first_name);
                update_user_meta($user_identity, 'last_name', $last_name);
				update_user_meta($user_identity, 'gender', esc_attr($gender));
            } else {
                if (isset($_POST['register']['type']) && esc_attr($_POST['register']['type']) === 'business') {
                    update_user_meta($user_identity, 'company_name', $company_name);
                } else {
                    update_user_meta($user_identity, 'first_name', $first_name);
                    update_user_meta($user_identity, 'last_name', $last_name);
					update_user_meta($user_identity, 'gender', esc_attr($gender));
                }
            }
			
			$full_name = listingo_get_username($user_identity);
			
			if (function_exists('fw_get_db_settings_option')) {
				$dir_longitude  = fw_get_db_settings_option('dir_longitude');
				$dir_latitude   = fw_get_db_settings_option('dir_latitude');
				$dir_longitude	= !empty( $dir_longitude ) ? $dir_longitude : '-0.1262362';
				$dir_latitude	= !empty( $dir_latitude ) ? $dir_latitude : '51.5001524';
			} else{
				$dir_longitude  = '-0.1262362';
				$dir_latitude   = '51.5001524';
			}

            update_user_meta($user_identity, 'show_admin_bar_front', false);
            update_user_meta($user_identity, 'verify_user', $verify_user);
            update_user_meta($user_identity, 'full_name', esc_attr($full_name));
            update_user_meta($user_identity, 'phone', esc_attr($phone));
            update_user_meta($user_identity, 'email', esc_attr($email));
            update_user_meta($user_identity, 'category', esc_attr($category));
            update_user_meta($user_identity, 'sub_category', $sub_category);
            update_user_meta($user_identity, 'activation_status', 'active');
			update_user_meta($user_identity, 'subscription_featured_expiry', 0);
			update_user_meta($user_identity, 'rich_editing', 'true' );
			update_user_meta($user_identity, 'is_avatar_available', 0);
			update_user_meta($user_identity, 'set_profile_view', 0);
			update_user_meta($user_identity, 'latitude', $dir_latitude);
			update_user_meta($user_identity, 'longitude', $dir_longitude);
			
			do_action('listingo_update_category_search',$category,'category',$user_identity);
			do_action('listingo_update_category_search',$sub_category,'sub_category',$user_identity);
			
			//Privacy settings
			$privacy_settings	= 'a:20:{s:13:"profile_photo";s:2:"on";s:14:"profile_banner";s:2:"on";s:19:"profile_appointment";s:2:"on";s:15:"profile_contact";s:2:"on";s:13:"profile_hours";s:2:"on";s:15:"profile_service";s:2:"on";s:12:"profile_team";s:2:"on";s:15:"profile_gallery";s:2:"on";s:14:"profile_videos";s:2:"on";s:20:"privacy_introduction";s:2:"on";s:17:"privacy_languages";s:2:"on";s:18:"privacy_experience";s:2:"on";s:14:"privacy_awards";s:2:"on";s:21:"privacy_qualification";s:2:"on";s:15:"privacy_amenity";s:2:"on";s:17:"privacy_insurance";s:2:"on";s:17:"privacy_brochures";s:2:"on";s:20:"privacy_job_openings";s:2:"on";s:16:"privacy_articles";s:2:"on";s:13:"privacy_share";s:2:"on";}';
		
			$privacy_array	= unserialize( $privacy_settings );

			update_user_meta( $user_identity, 'privacy', unserialize( $privacy_settings ) );

			if (!empty($privacy_array) && is_array($privacy_array)) {
				foreach ($privacy_array as $key => $privacy) {
					update_user_meta($user_identity, esc_attr($key), esc_attr($privacy));
				}
			}

			$key_hash = md5(uniqid(openssl_random_pseudo_bytes(32)));
			update_user_meta( $user_identity, 'confirmation_key', $key_hash);
			
			$protocol = is_ssl() ? 'https' : 'http';
			
			$verify_link = esc_url(add_query_arg(array(
                'key' => $key_hash.'&verifyemail='.$email
                            ), home_url('/', $protocol)));

			
			$json_message = esc_html__("Your account has created. You can now login to use your account.", "listingo_core");

			//action to manage post data
			do_action('listingo_dev_manage_registraton_data',$_POST,$user_identity);
			
			//Send email to users and admin
            if (class_exists('ListingoProcessEmail')) {
                $email_helper = new ListingoProcessEmail();

                $emailData = array();
                $emailData['user_identity'] = $user_identity;
                $emailData['first_name'] = esc_attr($first_name);
                $emailData['last_name']  = esc_attr($last_name);
                $emailData['password']   = $random_password;
                $emailData['username']   = $username;
                $emailData['email'] 	 = $email;

                $email_helper->process_registeration_email($emailData);
                $email_helper->process_registeration_admin_email($emailData);
				
				if( isset( $verify_switch ) && $verify_switch === 'verified' ){
					$emailData['verify_link'] 	 = $verify_link;
					$email_helper->process_email_verification($emailData);
					$json_message = esc_html__("An email has sent to your email address, please verify your account before using our services or contact to administrator to verify your account.", "listingo_core");
				} else{
					$json_message = esc_html__("Your account has created. Your account verification is in progress. ", "listingo_core");
				}
            }
			
			do_action('listingo_manage_free_listing','set',$user_identity); // add in free users list if option enabled
			
			$dir_profile_page = '';
			if (function_exists('fw_get_db_settings_option')) {
				$dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
			}

			$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';

			$profile_url	= '';
			if( !empty($profile_page) ) {
				$profile_url	= Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'settings', $user_identity, true);
			}
			
			$user_array = array();
			$user_array['user_login'] = $email;
        	$user_array['user_password'] = $random_password;
				
			$status = wp_signon($user_array, false);
			
			$json['redirect'] 	= $profile_url;
            $json['type'] 		= "success";
            $json['message']	= $json_message;
            echo json_encode($json);
            die;
        }
        die();
    }

    add_action('wp_ajax_listingo_user_registration', 'listingo_user_registration');
    add_action('wp_ajax_nopriv_listingo_user_registration', 'listingo_user_registration');
}


/**
 * @Wp Login
 * @return 
 */
if (!function_exists('listingo_ajax_login')) {

    function listingo_ajax_login() {
        $captcha_settings = '';
        $user_array = array();
        $user_array['user_login'] = sanitize_text_field($_POST['email']);
        $user_array['user_password'] = sanitize_text_field($_POST['password']);
		
		$redirect	= !empty( $_POST['redirect'] ) ? esc_url( $_POST['redirect'] ) : '';
		
        if (function_exists('fw_get_db_settings_option')) {
            $captcha_settings = fw_get_db_settings_option('captcha_settings', $default_value = null);
        }

        //recaptcha check
        if (isset($captcha_settings) && $captcha_settings === 'enable'
        ) {
            if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
                $docReResult = listingo_get_recaptcha_response($_POST['g-recaptcha-response']);

                if ($docReResult == 1) {
                    $workdone = 1;
                } else if ($docReResult == 2) {
                    echo json_encode(array('type' => 'error', 'loggedin' => false, 'message' => esc_html__('An error occurred, please try again later.', 'listingo_core')));
                    die;
                } else {
                    echo json_encode(array('type' => 'error', 'loggedin' => false, 'message' => esc_html__('Wrong reCaptcha. Please verify first.', 'listingo_core')));
                    die;
                }
            } else {
                echo json_encode(array('type' => 'error', 'loggedin' => false, 'message' => esc_html__('Please enter reCaptcha!', 'listingo_core')));
                die;
            }
        }

        if (isset($_POST['rememberme'])) {
            $remember = sanitize_text_field($_POST['rememberme']);
        } else {
            $remember = '';
        }

        if ($remember) {
            $user_array['remember'] = true;
        } else {
            $user_array['remember'] = false;
        }
		
		
        if ($user_array['user_login'] == '') {
            echo json_encode(array('type' => 'error', 'loggedin' => false, 'message' => esc_html__('Username/Email should not be empty.', 'listingo_core')));
            exit();
        } elseif ($user_array['user_password'] == '') {
            echo json_encode(array('type' => 'error', 'loggedin' => false, 'message' => esc_html__('Password should not be empty.', 'listingo_core')));
            exit();
        } else {
			
			$user = wp_signon($user_array, false);
			if (is_wp_error($user)) {
				echo json_encode(array('type' => 'error', 'loggedin' => false, 'message' => esc_html__('Wrong email/username or password.', 'listingo_core')));
			} else {

                if( empty( $redirect ) ){
                    $dir_profile_page = '';
                    if (function_exists('fw_get_db_settings_option')) {
                        $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
                    }
                    $profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';

                    $profile_url    = '';
                    if( !empty($profile_page) ) {
                        $profile_url    = Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'settings', $user->ID, true);
                    }
                    
                    $redirect   = $profile_url;
                }

				echo json_encode(array('type' => 'success', 'redirect' => $redirect, 'url' => home_url('/'), 'loggedin' => true, 'message' => esc_html__('Successfully Logged in.', 'listingo_core')));
			}
			
        }

        die();
    }

    add_action('wp_ajax_listingo_ajax_login', 'listingo_ajax_login');
    add_action('wp_ajax_nopriv_listingo_ajax_login', 'listingo_ajax_login');
}


/**
 * REcaptucha
 *
 * @param json
 * @return string
 */
if (!function_exists('listingo_get_recaptcha_response')) {

    function listingo_get_recaptcha_response($recaptcha_data = '') {
        if (function_exists('fw_get_db_settings_option')) {
            $response = null;
            $captcha_settings = fw_get_db_settings_option('captcha_settings', $default_value = null);
            $secret_key = fw_get_db_settings_option('secret_key', $default_value = null);

            if (!empty($secret_key)) {
                $reCaptcha = new ReCaptcha($secret_key);

                if ($recaptcha_data) {
                    $response = $reCaptcha->verifyResponse(
                            $_SERVER["REMOTE_ADDR"], $recaptcha_data
                    );
                }

                if ($response != null && $response->success) {
                    $statusofjob = 1;
                } else {
                    $statusofjob = 0;
                }
            } else {
                $statusofjob = 2;
            }
        }

        return $statusofjob;
    }

}

/**
 * @Demo Ready
 * @return {}
 */
if (!function_exists('listingo_is_demo_site')) {
	function listingo_is_demo_site($message=''){
		$json = array();
		$message	= !empty( $message ) ? $message : esc_html__("Sorry! you are restricted to perform this action on demo site.",'listingo_core' );
		if( isset( $_SERVER["SERVER_NAME"] ) 
			&& $_SERVER["SERVER_NAME"] === 'themographics.com' ){
			$json['type']	   =  "error";
			$json['message']	=  $message;
			echo json_encode( $json );
			exit();
		}
	}
}

/**
 * @Contact Doctor
 * @return 
 */
if (!function_exists('listingo_dashboard_contact_form')) {

    function listingo_dashboard_contact_form() {
        global $current_user;
        $json = array();

        $do_check = check_ajax_referer('sp_dashboard_contact_form', 'security', false);
        if ($do_check == false) {
            $json['type'] = 'error';
			$json['message'] = esc_html__('No kiddies please.', 'listingo_core');
			echo json_encode($json);
			die;
        }

        $bloginfo = get_bloginfo();
        $email_subject = "(" . $bloginfo . ") Contact Form Received";
        $success_message = esc_html__('Message Sent.', 'listingo_core');
        $failure_message = esc_html__('Message Fail.', 'listingo_core');

        $recipient = esc_attr($_POST['email_to']);

        if (empty($_POST['email_to'])) {
            $recipient = get_option('admin_email', 'etwordpress01@gmail.com');
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the form fields and remove whitespace.

            if (empty($_POST['name']) 
				|| empty($_POST['email']) 
				|| empty($_POST['phone']) 
				|| empty($_POST['subject']) 
				|| empty($_POST['description'])
            ) {
                $json['type'] = 'error';
                $json['message'] = esc_html__('Please fill all fields.', 'listingo_core');
                echo json_encode($json);
                die;
            }

            if (!is_email($_POST['email'])) {
                $json['type'] = 'error';
                $json['message'] = esc_html__('Email address is not valid.', 'listingo_core');
                echo json_encode($json);
                die;
            }

            $name 		= esc_attr($_POST['name']);
            $email 		= esc_attr($_POST['email']);
            $subject 	= esc_attr($_POST['subject']);
            $phone 		= esc_attr($_POST['phone']);
            $message 	= esc_attr($_POST['description']);

            if (class_exists('ListingoProcessEmail')) {
                $email_helper = new ListingoProcessEmail();
                $emailData = array();
                $emailData['name'] 			= $name;
                $emailData['email'] 		= $email;
                $emailData['email_subject'] = $email_subject;
                $emailData['subject'] 		= $subject;
                $emailData['phone'] 		= $phone;
                $emailData['message'] 		= $message;
                $emailData['email_to'] 		= $recipient;

                $email_helper->process_contact_form_email($emailData);
            }

            // Send the email.
            $json['type'] = "success";
            $json['message'] = esc_attr($success_message);
            echo json_encode($json);
            die();
        } else {
            echo
            $json['type'] = "error";
            $json['message'] = esc_attr($failure_message);
            echo json_encode($json);
            die();
        }
    }

    add_action('wp_ajax_listingo_dashboard_contact_form', 'listingo_dashboard_contact_form');
    add_action('wp_ajax_nopriv_listingo_dashboard_contact_form', 'listingo_dashboard_contact_form');
}

/**
 * @Register new user from bac-kend
 * @return 
 */
if (!function_exists('listingo_registration_save')) {
	add_action( 'user_register', 'listingo_registration_save', 10, 1 );
	function listingo_registration_save( $user_id ) {
		$full_name = listingo_get_username($user_id);
		$verify_user 	  = 'on';
		update_user_meta($user_id, 'show_admin_bar_front', false);
		update_user_meta($user_id, 'verify_user', $verify_user);
		update_user_meta($user_id, 'full_name', esc_attr($full_name));
		update_user_meta($user_id, 'activation_status', 'active');
		update_user_meta($user_id, 'subscription_featured_expiry', 0);
		
		$privacy_settings	= 'a:20:{s:13:"profile_photo";s:2:"on";s:14:"profile_banner";s:2:"on";s:19:"profile_appointment";s:2:"on";s:15:"profile_contact";s:2:"on";s:13:"profile_hours";s:2:"on";s:15:"profile_service";s:2:"on";s:12:"profile_team";s:2:"on";s:15:"profile_gallery";s:2:"on";s:14:"profile_videos";s:2:"on";s:20:"privacy_introduction";s:2:"on";s:17:"privacy_languages";s:2:"on";s:18:"privacy_experience";s:2:"on";s:14:"privacy_awards";s:2:"on";s:21:"privacy_qualification";s:2:"on";s:15:"privacy_amenity";s:2:"on";s:17:"privacy_insurance";s:2:"on";s:17:"privacy_brochures";s:2:"on";s:20:"privacy_job_openings";s:2:"on";s:16:"privacy_articles";s:2:"on";s:13:"privacy_share";s:2:"on";}';
		
		$privacy_array	= unserialize( $privacy_settings );
		
		update_user_meta($user_id, 'privacy', unserialize( $privacy_settings ) );
		update_user_meta($user_id, 'is_avatar_available', 0);
		update_user_meta($user_id, 'set_profile_view', 0);

		if (!empty($privacy_array) && is_array($privacy_array)) {
			foreach ($privacy_array as $key => $privacy) {
				update_user_meta($user_id, esc_attr($key), esc_attr($privacy));
			}
		}

		//Allow free registration for life time.
		if (function_exists('fw_get_db_settings_option')) {
			$sp_system_access = fw_get_db_settings_option('sp_system_access', $default_value = null);
			if( isset( $sp_system_access['gadget'] ) && $sp_system_access['gadget'] === 'specific' ){
				$sp_allowed	= !empty( $sp_system_access['specific']['sp_allow_type'] ) ? $sp_system_access['specific']['sp_allow_type'] : '';
				
				if( isset( $sp_allowed ) && $sp_allowed === 'yes' ){
					do_action('listingo_manage_free_listing','set',$user_id); // add in free users list if option enabled
				}	
			}
		}
	}
}

/**
 * @create social login URL
 * Return{}
 */
if ( !function_exists( 'listingo_new_social_login_url' ) ) {
	function listingo_new_social_login_url($key='googlelogin') {
	  return site_url('wp-login.php') . '?'.$key.'=1';
	}
}

/**
 * @create social login uniqe ID
 * Return{}
 */
if(!function_exists('listingo_get_uniqid')){
    function listingo_get_uniqid(){
        if(isset($_COOKIE['listingo_uniqid'])){
            if(get_site_transient('n_'.$_COOKIE['listingo_uniqid']) !== false){
                return $_COOKIE['listingo_uniqid'];
            }
        }
		
        $_COOKIE['listingo_uniqid'] = uniqid('listingo', true);
        setcookie('listingo_uniqid', $_COOKIE['listingo_uniqid'], time() + 3600, '/');
        set_site_transient('n_'.$_COOKIE['listingo_uniqid'], 1, 3600);
        
        return $_COOKIE['listingo_uniqid'];
    }
}

/**
 * @create social users
 * Return{}
 */
if ( !function_exists( 'listingo_new_social_login' ) ) {
	add_action( 'login_init', 'listingo_new_social_login' );

	function listingo_new_social_login() {
		
		if ( isset( $_GET[ 'googlelogin' ] ) && $_GET[ 'googlelogin' ] == '1' ) {
			do_action('do_google_connect');
			listingo_new_social_redirect('google');
		} else if ( isset( $_GET[ 'facebooklogin' ] ) && $_GET[ 'facebooklogin' ] == '1' ) {
			do_action('do_facebook_connect');
			listingo_new_social_redirect('facebook');
		}
	}
}

/**
 * @get redirect URL
 * Return{}
 */
if (!function_exists('listingo_create_social_users')) {
	add_action('listingo_create_social_users','listingo_create_social_users',10,2);
	function listingo_create_social_users($type,$user) {
		$email = filter_var( $user[ 'email' ], FILTER_SANITIZE_EMAIL );
		$random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
		
		if ( function_exists( 'fw_get_db_settings_option' ) ) {
			$fb_prefix = fw_get_db_settings_option( 'fb_prefix' );
			$g_prefix = fw_get_db_settings_option( 'g_prefix' );
		}
		
		if( isset( $type ) && $type === 'facebook' && !empty( $fb_prefix ) ){
			$type	= $fb_prefix;
		} else if( isset( $type ) && $type === 'google' && !empty( $g_prefix ) ){
			$type	= $g_prefix;
		} else{
			$prefix = '';
		}

		$sanitized_user_login = sanitize_title( $prefix . $user[ 'name' ]);

		if (function_exists('fw_get_db_settings_option')) {
            $verify_switch = fw_get_db_settings_option('verify_user', $default_value = null);
        }
		
		
		if ( !validate_username( $sanitized_user_login ) ) {
			$sanitized_user_login = sanitize_title( $type . $user[ 'id' ]);
		}
		
		$defaul_user_name = $sanitized_user_login;
		$i = 1;
		while ( username_exists( $sanitized_user_login ) ) {
			$sanitized_user_login = $defaul_user_name . $i;
			$i++;
		}

		$ID = wp_create_user( $sanitized_user_login, $random_password, $email );
		
		if ( !is_wp_error( $ID ) ) {
			global $wpdb;
			
			global $wpdb;
            wp_update_user(array('ID' => esc_sql($ID), 'role' => 'subscriber', 'user_status' => 1));
			
			$wpdb->update(
				$wpdb->prefix . 'users', array( 'user_status' => 1 ), array( 'ID' => esc_sql( $ID ) )
			);

			update_user_meta( $ID, 'register_with_social_profiles', 'yes' );
			update_user_meta( $ID, 'company_name', $user[ 'name' ] );
			update_user_meta( $ID, 'first_name', $user[ 'name' ] );
			update_user_meta( $ID, 'subscription_featured_expiry', 0);
			$full_name = listingo_get_username( $ID );

			if ( function_exists( 'fw_get_db_settings_option' ) ) {
				$dir_longitude = fw_get_db_settings_option( 'dir_longitude' );
				$dir_latitude = fw_get_db_settings_option( 'dir_latitude' );
				$dir_longitude = !empty( $dir_longitude ) ? $dir_longitude : '-0.1262362';
				$dir_latitude = !empty( $dir_latitude ) ? $dir_latitude : '51.5001524';
			} else {
				$dir_longitude = '-0.1262362';
				$dir_latitude = '51.5001524';
			}

			
			update_user_meta( $ID, 'show_admin_bar_front', false );
			update_user_meta( $ID, 'full_name', esc_attr( $full_name ) );
			update_user_meta( $ID, 'email', esc_attr( $email ) );
			update_user_meta( $ID, 'activation_status', 'active' );
			update_user_meta( $ID, 'rich_editing', 'true' );

			update_user_meta( $ID, 'latitude', $dir_latitude );
			update_user_meta( $ID, 'longitude', $dir_longitude );
			
			$verify_user	= 'off';
			
			if( isset( $verify_switch ) && $verify_switch === 'verified' ){
				update_user_meta( $ID, 'verify_user', $verify_user );
				$key_hash = md5(uniqid(openssl_random_pseudo_bytes(32)));
				update_user_meta( $ID, 'confirmation_key', $key_hash);
				
				$protocol = is_ssl() ? 'https' : 'http';
				
				$verify_link = esc_url(add_query_arg(array(
                'key' => $key_hash.'&verifyemail='.$email
                            ), home_url('/', $protocol)));

			 	$emailData = array();
                $emailData['user_identity'] = $ID;
                $emailData['email'] 	 	= $email;
				$emailData['verify_link'] 	 = $verify_link;
				
				$email_helper = new ListingoProcessEmail();
				$email_helper->process_email_verification($emailData);
				
			} else{
				update_user_meta( $ID, 'verify_user', $verify_user );
			}

			//Privacy settings
			$privacy_settings = 'a:20:{s:13:"profile_photo";s:2:"on";s:14:"profile_banner";s:2:"on";s:19:"profile_appointment";s:2:"on";s:15:"profile_contact";s:2:"on";s:13:"profile_hours";s:2:"on";s:15:"profile_service";s:2:"on";s:12:"profile_team";s:2:"on";s:15:"profile_gallery";s:2:"on";s:14:"profile_videos";s:2:"on";s:20:"privacy_introduction";s:2:"on";s:17:"privacy_languages";s:2:"on";s:18:"privacy_experience";s:2:"on";s:14:"privacy_awards";s:2:"on";s:21:"privacy_qualification";s:2:"on";s:15:"privacy_amenity";s:2:"on";s:17:"privacy_insurance";s:2:"on";s:17:"privacy_brochures";s:2:"on";s:20:"privacy_job_openings";s:2:"on";s:16:"privacy_articles";s:2:"on";s:13:"privacy_share";s:2:"on";}';

			$privacy_array = unserialize( $privacy_settings );

			update_user_meta( $ID, 'privacy', unserialize( $privacy_settings ) );

			if ( !empty( $privacy_array ) && is_array( $privacy_array ) ) {
				foreach ( $privacy_array as $key => $privacy ) {
					update_user_meta( $ID, esc_attr( $key ), esc_attr( $privacy ) );
				}
			}
			
			do_action('listingo_manage_free_listing','set',$ID); // add in free users list if option enabled
			do_action('listingo_do_upload_social_user_avatar',$user,$type,$ID);
						
			$user_info = get_userdata( $ID );
			update_user_meta( $ID, 'new_'.$type.'_default_password', $user_info->user_pass );
			do_action('listingo_do_social_login',$ID);
			//Send email to user
		}
	}
}

/**
 * @get redirect URL
 * Return{}
 */
if (!function_exists('listingo_do_upload_social_user_avatar')) {
	add_action('listingo_do_upload_social_user_avatar','listingo_do_upload_social_user_avatar',10,3);
	function listingo_do_upload_social_user_avatar($user,$type,$user_id) {
		$filename	= $user['id'].'.jpg';
		$size_type  = 'avatar';
		$uploaddir 	= wp_upload_dir();
		$uploadfile = $uploaddir['path'] . '/' .$filename;
		
		if( isset( $type ) && $type === 'facebook' ){
			$url= 'https://graph.facebook.com/'.$user['id'].'/picture?width=600';
		} else{
			$url= $user['picture'];
		}
		
		if( empty( $url ) ){ return;}

		$image_string = file_get_contents($url, false);
		$fileSaved 	  = file_put_contents($uploaddir['path'] . "/" . $filename, $image_string);

		$wp_filetype = wp_check_filetype($filename, null );
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title' => $filename,
			'post_content' => '',
			'post_status' => 'inherit'
		);

		$attach_id = wp_insert_attachment( $attachment, $uploadfile );

		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $uploadfile );
		wp_update_attachment_metadata( $attach_id,  $attach_data );
		
		$attachment_json = listingo_get_profile_image_url($attach_data, $size_type, $filename); //get image url
		
		$data_array = array(
                        'image_type' 		=> 'profile_photo',
                        'default_image' 	=> $attach_id,
                        'image_data' 		=> array(
                            $attach_id => array(
                                'full' 			=> $attachment_json['full'],
                                'thumb' 		=> $attachment_json['thumbnail'],
                                'banner' 		=> $attachment_json['banner'],
                                'image_id' 		=> $attach_id
                            ),
                        )
                    );
		
	    update_user_meta($user_id, 'profile_avatar', $data_array);
		
	}
}

/**
 * @get redirect URL
 * Return{}
 */
if (!function_exists('listingo_do_social_login')) {
	add_action('listingo_do_social_login','listingo_do_social_login',10,1);
	function listingo_do_social_login($ID) {
		global $auth_secure_cookie; // XXX ugly hack to pass this to wp_authenticate_cookie
		$secure_cookie = is_ssl();
		$secure_cookie = apply_filters( 'secure_signon_cookie', $secure_cookie, array() );
		$auth_secure_cookie = $secure_cookie;
		wp_set_auth_cookie( $ID, true, $secure_cookie );
		$user_info = get_userdata( $ID );
		do_action( 'wp_login', $user_info->user_login, $user_info );
	}
}

/**
 * @get redirect URL
 * Return{}
 */
if (!function_exists('listingo_new_social_redirect')) {
	function listingo_new_social_redirect($key) {
	  global $current_user;
	  $redirect = get_site_transient( listingo_get_uniqid().'_'.$key.'_r');
	  if( $key === 'facebook' ){
		  $newlogin_url	= listingo_new_social_login_url('facebooklogin');
	  } else{
		  $newlogin_url	= listingo_new_social_login_url('googlelogin');
	  }
	  
	  $newlogin_url	= apply_filters('listingo_social_login_url',$newlogin_url);
		
	  if (!$redirect || $redirect == '' || $redirect == $newlogin_url ) {
		if (isset($_GET['redirect'])) {
		  $redirect = esc_attr( $_GET['redirect'] );
		} else {
		  $redirect = site_url();
		}
	  }
	
		$dir_profile_page = '';
		if (function_exists('fw_get_db_settings_option')) {
			$dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
		}

		$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';

		$profile_url	= '';
		if( !empty($profile_page) ) {
			$profile_url	= Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'settings', $user_identity, true);
		}

		$user_array = array();
		$user_array['user_login'] = $email;
		$user_array['user_password'] = $random_password;

		$status = wp_signon($user_array, false);
		$profile_url	= !empty( $profile_url ) ? $profile_url : $redirect;
		header('LOCATION: ' . $profile_url);
		delete_site_transient( listingo_get_uniqid().'_'.$key.'_r');
		exit;
	}
}

/**
 * @Check if user is registered with social profiles
 * @return 
 */
if (!function_exists('listingo_is_social_user')) {

    function listingo_is_social_user($user_identity) {
		$is_social	= 'no';
        if (!empty($user_identity)) {
            $data = get_userdata($user_identity);
            if ( !empty($data->roles[0]) 
				&& $data->roles[0] === 'subscriber'
				&& !empty( $data->register_with_social_profiles ) 
				&& $data->register_with_social_profiles === 'yes'
			) {
                $is_social	= 'yes';
            } else{
				$is_social	= 'no';
			}
			
        }
		
		return $is_social;
    }

    add_filter('listingo_is_social_user', 'listingo_is_social_user', 10, 1);
}

/**
 * @Check user role
 * @return 
 */
if (!function_exists('listingo_complete_registration_form')) {
	add_filter('listingo_complete_registration_form', 'listingo_complete_registration_form', 10);
    function listingo_complete_registration_form($user_identity) {
		?>
		<div class="col-xs-12 col-sm-12 col-md-8 col-md-push-2 col-lg-6 col-lg-push-3">
			<div id="tg-content" class="tg-content">
				<div class="tg-loginviasocial">
					<div class="tg-sectionhead">
						<div class="tg-sectiontitle">
							<h2><?php esc_html_e('You are nearly there !', 'listingo_core'); ?></h2>
						</div>
						<div class="tg-description">
							<p><?php esc_html_e('Please select the options below to complete the signup process.', 'listingo_core'); ?></p>
						</div>
					</div>
					<div class="tg-themeform tg-formlogin-register tg-formlogin-facebook">
						<fieldset>
							<ul class="tg-tabnav" role="tablist">
								<li role="presentation" class="active">
									<a href="#regularuser" data-toggle="tab">
										<span class="lnr lnr-user"></span>
										<div class="tg-navcontent">
											<h3><?php esc_html_e('Regular Single User', 'listingo_core'); ?></h3>
											<span><?php esc_html_e('Register As Service Seeker', 'listingo_core'); ?></span>
										</div>
									</a>
								</li>
								<li role="presentation">
									<a href="#company" data-toggle="tab">
										<span class="lnr lnr-briefcase"></span>
										<div class="tg-navcontent">
											<h3><?php esc_html_e('Company / Professional', 'listingo_core'); ?></h3>
											<span><?php esc_html_e('Register As Service Provider', 'listingo_core'); ?></span>
										</div>
									</a>
								</li>
							</ul>	
							<div class="tg-themetabcontent tab-content">
								<div class="tab-pane active fade in" id="regularuser">
									<div class="tg-description">
										<p><?php esc_html_e('If you click on "Get Started" button then you will be registered as Customer or Service Seeker.', 'listingo_core'); ?></p>
									</div>
									<form action="#" method="post" class="seeker-register do-complete-form tg-companyregister">
										<div class="form-group term-group">
											<div class="tg-checkbox">
												<input type="hidden" name="register[account]" value="seeker">
												<?php wp_nonce_field('register_seeker_request', 'register_seeker_request'); ?>
												<button class="tg-btn do-complete-profile" type="submit"><?php esc_html_e('Get Started', 'listingo_core'); ?></button>
											</div>
										</div>
									</form>
								</div>
								<div class="tab-pane fade in tg-companyregister" id="company">
									<form action="#" method="post" class="do-complete-form">
										<div class="tg-description">
											<p><?php esc_html_e('Please select role, either you want to register as "Business or Professional" then select category and sub category under which you want to register yourself. Don\'t worry we will ask once and next time you can simply login with your social account.', 'listingo_core'); ?></p>
										</div>
										<div class="form-group">
											<div class="tg-registeras">
												<span><?php esc_html_e('Register As', 'listingo_core'); ?>:</span>
												<div class="tg-radio">
													<input type="radio" class="register_type" value="business" id="business" name="register[type]" checked>
													<label for="business"><?php esc_html_e('Business', 'listingo_core'); ?></label>
												</div>
												<div class="tg-radio">
													<input type="radio" class="register_type" value="professional" id="professional" name="register[type]">
													<label for="professional"><?php esc_html_e('professional', 'listingo_core'); ?></label>
												</div>
											</div>
										</div>
										<div class="form-group">
											<span class="tg-select">
												<select name="register[category]" data-placeholder="<?php esc_html_e('Category', 'listingo_core'); ?>" class="sp-category">
													<option value=""><?php esc_html_e('Select Category', 'listingo_core'); ?></option>
													<?php listingo_get_categories('', 'sp_categories'); ?>
												</select>
											</span>
										</div>
										<?php if( apply_filters('listingo_dev_manage_fields','true','sub_category') === 'true' ){?>
										<div class="form-group">
											<span class="tg-select">
												<select name="register[sub_category][]" data-placeholder="<?php esc_html_e('Sub category', 'listingo_core'); ?>" multiple class="sp-sub-category sp-register-ms">
													<option value=""><?php esc_html_e('Select Sub Category', 'listingo_core'); ?></option>
												</select>
											</span>
										</div>
										<?php }?>
										<div class="form-group term-group">
												<input type="hidden" name="register[account]" value="provider">
												<?php wp_nonce_field('register_provider_request', 'register_provider_request'); ?>
												<button class="tg-btn do-complete-profile" type="submit"><?php esc_html_e('Get Started', 'listingo_core'); ?></button>
											</div>
										</div>
									</form>
								</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}


/**
 * @User registeration
 * Return{}
 */
if (!function_exists('listingo_complete_profile')) {

    function listingo_complete_profile() {
        global $wpdb,$current_user;;
		$db_user_role = 'customer';
		$user_identity	= $current_user->ID;
		$json = array();
		
		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
		
        //Validations
        if (isset($_POST['register']['account']) && esc_attr($_POST['register']['account']) === 'seeker') {
            $do_check = check_ajax_referer('register_seeker_request', 'register_seeker_request', false);
            if ($do_check == false) {
                $json['type'] = 'error';
                $json['message'] = esc_html__('No kiddies please!', 'listingo_core');
                echo json_encode($json);
                die;
            }

            $db_user_role = 'customer';
        } else {
			extract($_POST['register']);
			
            $do_check = check_ajax_referer('register_provider_request', 'register_provider_request', false);
            if ($do_check == false) {
                $json['type'] = 'error';
                $json['message'] = esc_html__('No kiddies please!', 'listingo_core');
                echo json_encode($json);
                die;
            }
			
			if (isset($_POST['register']['type']) && esc_attr($_POST['register']['type']) === 'business') {
                $db_user_role = 'business';
            } else {
                $db_user_role = 'professional';
            }
			
            $data_array = array(
                'category' 		=> esc_html__('Please select category.', 'listingo_core'),
                'sub_category'  => esc_html__('Sub category is required.', 'listingo_core'),
            );
			
			//filter to remove/add some required fields from registration form
			$data_array	= apply_filters('listingo_dev_filter_required_fields',$data_array,'no',$_POST);
			
			$emailData = array();
			foreach ($data_array as $key => $value) {
				if (empty($_POST['register'][$key])) {
					$json['type'] = 'error';
					$json['message'] = $value;
					echo json_encode($json);
					die;
				}
			}
			
			$sub_category	= !empty( $sub_category ) ? $sub_category : array();
			
			update_user_meta($user_identity, 'category', esc_attr($category));
            update_user_meta($user_identity, 'sub_category', $sub_category);
			update_user_meta($user_identity, 'subscription_featured_expiry', 0);
			
			do_action('listingo_update_category_search',$category,'category',$user_identity);
			do_action('listingo_update_category_search',$sub_category,'sub_category',$user_identity);
			
			//Privacy settings
			$privacy_settings = 'a:20:{s:13:"profile_photo";s:2:"on";s:14:"profile_banner";s:2:"on";s:19:"profile_appointment";s:2:"on";s:15:"profile_contact";s:2:"on";s:13:"profile_hours";s:2:"on";s:15:"profile_service";s:2:"on";s:12:"profile_team";s:2:"on";s:15:"profile_gallery";s:2:"on";s:14:"profile_videos";s:2:"on";s:20:"privacy_introduction";s:2:"on";s:17:"privacy_languages";s:2:"on";s:18:"privacy_experience";s:2:"on";s:14:"privacy_awards";s:2:"on";s:21:"privacy_qualification";s:2:"on";s:15:"privacy_amenity";s:2:"on";s:17:"privacy_insurance";s:2:"on";s:17:"privacy_brochures";s:2:"on";s:20:"privacy_job_openings";s:2:"on";s:16:"privacy_articles";s:2:"on";s:13:"privacy_share";s:2:"on";}';

			$privacy_array = unserialize( $privacy_settings );

			update_user_meta( $user_identity, 'privacy', $privacy_array );

			if ( !empty( $privacy_array ) && is_array( $privacy_array ) ) {
				foreach ( $privacy_array as $key => $privacy ) {
					update_user_meta( $user_identity, esc_attr( $key ), esc_attr( $privacy ) );
				}
			}
        }

        //extract post data

        global $wpdb;
		wp_update_user(array('ID' => esc_sql($user_identity), 'role' => esc_sql($db_user_role), 'user_status' => 1));

		$wpdb->update(
				$wpdb->prefix . 'users', array('user_status' => 1), array('ID' => esc_sql($user_identity))
		);
		
		//redirect
		$dir_profile_page = '';
		if (function_exists('fw_get_db_settings_option')) {
			$dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
		}

		$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';

		$profile_url	= '';
		if( !empty($profile_page) ) {
			$profile_url	= Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'settings', $user_identity, true);
		}
		
		$hide_dashboard = ''; 
		if (function_exists('fw_get_db_settings_option')) {
			$hide_dashboard = fw_get_db_settings_option('hide_dashboard');
		}
		
		if( !empty($hide_dashboard) && $hide_dashboard === 'yes' ){
			update_user_meta($user_identity, 'sp_subscription', '');  
			$json['message'] = esc_html__('Your profile has updated, Please subscribe to a package', 'listingo_core');
		} else{
			$json['message'] = esc_html__('Your profile has updated, Start editing your content', 'listingo_core');
		}
		
		
		$json['redirect'] 	= $profile_url;
        $json['type'] = 'success';
		echo json_encode($json);
		die;
    }

    add_action('wp_ajax_listingo_complete_profile', 'listingo_complete_profile');
    add_action('wp_ajax_nopriv_listingo_complete_profile', 'listingo_complete_profile');
}

/**
 * @get redirect URL
 * Return{}
 */
if (!function_exists('listingo_get_formwrapper')) {
	add_filter('listingo_get_formwrapper','listingo_get_formwrapper',10,2);
	function listingo_get_formwrapper($single,$default) {
		if( isset( $default ) && $default === 'signin' ){
			if( $single === 'true' ){
				return 'col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-left col-sm-push-3 col-md-push-3 col-lg-push-4 sp-authin-single';
			} else{
				return 'col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-left';
			}	
		} else if( isset( $default ) && $default === 'signup' ){
			if( $single === 'true' ){
				return 'col-xs-12 col-sm-12 col-md-12 col-lg-8 pull-left col-lg-push-2 sp-authup-single';
			} else{
				return 'col-xs-12 col-sm-8 col-md-8 col-lg-8 pull-left';
			}
		}
	}
}