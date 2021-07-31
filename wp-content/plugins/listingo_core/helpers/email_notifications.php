<?php
/**
 * Email Helper For Theme
 * @since    1.0.0
 */
if (!class_exists('ListingoProcessEmail')) {

    class ListingoProcessEmail {

        public function __construct() {
            add_filter('wp_mail_content_type', array(&$this, 'listingo_set_content_type'));
            add_filter('wp_mail_from', array(&$this, 'listingo_wp_mail_from'));
            add_filter('wp_mail_from_name', array(&$this, 'listingo_wp_mail_from_name'));
        }

        /**
         * Email Headers From
         * @since    1.0.0
         */
        public function listingo_wp_mail_from($email) {
            if (function_exists('fw_get_db_settings_option')) {
                $email_from_id = fw_get_db_settings_option('email_from_id');
            }

            if (!empty($email_from_id)) {
                return $email_from_id;
            } else {
                return 'info@no-reply.com';
            }
        }

        /**
         * Email Headers From name
         * @since    1.0.0
         */
        public function listingo_wp_mail_from_name($name) {
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

            if (function_exists('fw_get_db_settings_option')) {
                $email_from_name = fw_get_db_settings_option('email_from_name');
            }

            if (!empty($email_from_name)) {
                return $email_from_name;
            } else {
                return $blogname;
            }
        }

        /**
         * Email Content type
         *
         *
         * @since    1.0.0
         */
        public function listingo_set_content_type() {
            return "text/html";
        }

        /**
         * Get Email Header
         * Return email header html
         * @since    1.0.0
         */
        public function prepare_email_headers() {
            global $current_user;
            ob_start();
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
            $email_banner = array();
            if (function_exists('fw_get_db_settings_option')) {
                $email_banner = fw_get_db_settings_option('email_banner');
            }

            if (!empty($email_banner['url'])) {
                $banner = $email_banner['url'];
				$banner = listingo_add_http($banner);
            }
            ?>
            <div style="min-width:100%;background-color:#f6f7f9;margin:0;width:100%;color:#283951;font-family:'Helvetica','Arial',sans-serif;padding: 60px 0;">
				<div style="background: #FFF;max-width: 600px; width: 100%; margin: 0 auto; overflow: hidden; color: #919191; font:400 16px/26px 'Open Sans', Arial, Helvetica, sans-serif;">
					<div style="width: 100%; float: left; padding: 30px 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
						<strong style="float: left; padding: 0 0 0 30px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><a style="float: left; color: #55acee; text-decoration: none;" href="<?php echo esc_url(home_url('/')); ?>"><?php echo ( $this->process_get_logo() ); ?></a></strong>
						<!--<div style="float: right; padding: 14px 30px 14px 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"></div>-->
					</div>
					<?php if (!empty($banner)) { ?>
						<div id="tg-banner" class="tg-banner" style="width: 100%; float: left; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><img style="width: 100%; height: auto; display: block;" src="<?php echo esc_url($banner); ?>" alt="<?php echo esc_attr($blogname); ?>"></div>
					<?php } ?>
					<div style="width: 100%; float: left; padding: 30px 30px 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
                    <?php
                    return ob_get_clean();
                }

		/**
		 * Get Email Footer
		 *
		 * Return email footer html
		 *
		 * @since    1.0.0
		 */
		public function prepare_email_footers($params = '') {
			global $current_user;
			ob_start();
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			?>
				</div>
				<div style="width:100%;float:left;background: #002c49;padding: 30px 15px;text-align:center;box-sizing:border-box;border-radius: 0  0 5px 5px;">
					<p style="font-size: 13px; line-height: 13px; color: #aaaaaa; margin: 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php esc_html_e('Copyright', 'listingo_core'); ?>&nbsp;&copy;&nbsp;<?php echo date('Y'); ?><?php esc_html_e(' | All Rights Reserved', 'listingo_core'); ?> <a href="<?php echo esc_url(home_url('/')); ?>" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; color: #348eda; margin: 0; padding: 0;"><?php echo esc_attr($blogname); ?></a></p>
				</div>
			</div>
			<?php
			return ob_get_clean();
		}

		/**
		 * @Process Sender Information
		 * @since 1.0.0
		 * 
		 * @return {data}
		 */
		public function process_sender_information($params = '') {
			global $current_user;
			ob_start();
			$avatar 	= '';;
			$blogname 	= wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			$tagline 	= wp_specialchars_decode(get_option('blogdescription'), ENT_QUOTES);

			$sender_avatar = array();
			$email_sender_name = '';
			$email_sender_tagline = '';
			$sender_url = '';
			
			if (function_exists('fw_get_db_settings_option')) {
				$sender_avatar = fw_get_db_settings_option('email_sender_avatar');
				$email_sender_name = fw_get_db_settings_option('email_sender_name');
				$email_sender_tagline = fw_get_db_settings_option('email_sender_tagline');
				$sender_url = fw_get_db_settings_option('email_sender_url');
			}

			if (!empty($email_sender_name)) {
				$sender_name = $email_sender_name;
			} else {
				$sender_name = $blogname;
			}

			if (!empty($email_sender_tagline)) {
				$sender_tagline = $email_sender_tagline;
			} else {
				$sender_tagline = $tagline;
			}

			if (!empty($sender_avatar['url'])) {
				$avatar = $sender_avatar['url'];
				$avatar = listingo_add_http($avatar);
			}
			?>
			<div style="width: 100%; float: left; padding: 15px 0 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
				<?php if (!empty($avatar)) { ?>
					<div style="float: left; border-radius: 5px; overflow: hidden; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
						<img style="display: block;" src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($blogname); ?>">
					</div>
				<?php } ?>
				<?php if (!empty($sender_name) || !empty($sender_tagline) || !empty($sender_url)) { ?>
					<div style="overflow: hidden; padding: 0 0 0 20px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
						<p style="margin: 0 0 7px; font-size: 14px; line-height: 14px; color: #919191; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php esc_html_e('Regards', 'listingo_core'); ?></p>
						<?php if (!empty($sender_name)) { ?>
							<h2 style="font-size: 18px; line-height: 18px; margin: 0 0 5px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; color: #333; font-weight: normal;font-family: 'Work Sans', Arial, Helvetica, sans-serif;"><?php echo esc_attr($sender_name); ?></h2>
						<?php } ?>
						<?php if (!empty($sender_tagline)) { ?>
							<p style="margin: 0 0 7px; font-size: 14px; line-height: 14px; color: #919191; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php echo esc_attr($sender_tagline); ?></p>
						<?php } ?>
						<?php if (!empty($sender_url)) { ?>
							<p style="margin: 0; font-size: 14px; line-height: 14px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><a style=" color: #55acee; text-decoration: none;" href="<?php echo esc_url($sender_url); ?>"><?php echo esc_url($sender_url); ?></a></p>
							<?php } ?>
					</div>
				<?php } ?>
			</div>
			<?php
			return ob_get_clean();
		}

		/**
		 * @Registration
		 *
		 * @since 1.0.0
		 */
		public function process_get_logo($params = '') {
			//Get Logo
			if (function_exists('fw_get_db_settings_option')) {
				$email_logo = fw_get_db_settings_option('email_logo');
				$main_logo = fw_get_db_settings_option('main_logo');
			}

			if (!empty($email_logo['url'])) {
				$logo = !empty( $email_logo['url'] ) ? $email_logo['url'] : get_template_directory_uri() . '/images/logo.png';;
			} elseif (!empty($main_logo['url'])) {
				$logo = !empty( $main_logo['url'] ) ? $main_logo['url'] : get_template_directory_uri() . '/images/logo.png';;
			} else {
				$logo = get_template_directory_uri() . '/images/logo.png';
			}

			$logo = listingo_add_http($logo);
			return '<img style="max-width:100px;" src="' . esc_url($logo) . '" alt="" />';
			
		}

		/**
		 * @Process Appointment Authentication Email
		 *
		 * @since 1.0.0
		 */
		public function process_appt_authentication_email($params = '') {
			global $current_user;
			extract($params);

			//Get username based on user id
			if( empty( $apt_name ) ){
				$apt_name = listingo_get_username($user_id);
			}



			//Get user email address based on user id
			$user_data = get_userdata($user_id);
			$email = $user_data->user_email;

			if (!empty($apt_email)) {
				$email = $apt_email;
			}

			//Appointment Hash Code from param extract
			$appt_code = $appt_hash;
			//Email Sender information
			$sender_info = $this->process_sender_information();


			$subject = esc_html__('Appointment Authentication Code!', 'listingo_core');
			$email_content_default = 'Hello %user_name%!<br/>

								To complete your appointment please enter the below authentication code in appointment form.
								<br/>
								Your Authentication code is : %code%<br/>

								%signature%<br/>';

			if (function_exists('fw_get_db_post_option')) {
				$appt_subject = fw_get_db_settings_option('appt_auth_subject');
				$appt_content = fw_get_db_settings_option('appt_auth_content');
			}

			//set defalt contents
			if (empty($appt_content)) {
				$appt_content = $email_content_default;
			}

			if (empty($appt_subject)) {
				$appt_subject = $subject;
			}

			$appt_content = str_replace("%user_name%", $apt_name, $appt_content); //Replace Name
			$appt_content = str_replace("%code%", $appt_code, $appt_content); //Replace Code
			$appt_content = str_replace("%signature%", $sender_info, $appt_content); //Replace Signature

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $appt_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();
			wp_mail($email, $appt_subject, $body);
		}

		/**
		 * @Process Appointment Approval Email
		 *
		 * @since 1.0.0
		 */
		public function process_appt_approval_email($params = '') {
			global $current_user;
			extract($params);

			//Get Post meta based on post id
			$apt_services = get_post_meta($post_id, 'apt_services', true);
			$apt_user_from = get_post_meta($post_id, 'apt_user_from', true);
			$apt_user_to = get_post_meta($post_id, 'apt_user_to', true);

			//Get user email address based on user id
			$user_data = get_userdata($apt_user_from);
			$email = $user_data->user_email;

			$booking_services = get_user_meta($apt_user_to, 'profile_services', true);
			$apt_time = get_post_meta($post_id, 'apt_time', true);
			$apt_date = get_post_meta($post_id, 'apt_date', true);

			$date_format = get_option('date_format');
			$time_format = get_option('time_format');
			$time = explode('-', $apt_time);
			$apt_format_time = '';
			if (!empty($time[0]) && !empty($time[1])) {
				$apt_format_time = date($time_format, strtotime('2016-01-01 ' . $time[0])) . '&nbsp;-&nbsp;' . date($time_format, strtotime('2016-01-01 ' . $time[1]));
			}

			//Get Customet Name
			$customer_name = listingo_get_username($apt_user_from);
			//Get Provider Name
			$provider_name = listingo_get_username($apt_user_to);

			//Get Appointment Approval subject and content
			$appt_subject = get_user_meta($apt_user_to, 'appt_approved_title', true);
			$appt_content = get_user_meta($apt_user_to, 'appt_booking_approved', true);

			if (!empty($booking_services[$apt_services])) {
				$apt_services = $booking_services[$apt_services]['title'];
			}
			//Email Sender information
			$sender_info = $this->process_sender_information();

			$subject = esc_html__('Your Appointment Approved!', 'listingo_core');
			$email_content_default = 'Hi, %customer_name%!<br/>
										This is confirmation that your booking regarding "%service%" with %provider% has approved.<br/>
										We are waiting on %appointment_date% at %appointment_time%.<br/>
										<br/><br/>
										%signature%<br/>
										';

			//set defalt contents
			if (empty($appt_content)) {
				$appt_content = $email_content_default;
			}

			if (empty($appt_subject)) {
				$appt_subject = $subject;
			}

			$appt_content = str_replace("%customer_name%", $customer_name, $appt_content); //Replace Customer Name
			$appt_content = str_replace("%service%", $apt_services, $appt_content); //Replace Service Name
			$appt_content = str_replace("%provider%", $provider_name, $appt_content); //Replace Provider Name
			$appt_content = str_replace("%appointment_date%", date($date_format, $apt_date), $appt_content); //Replace date
			$appt_content = str_replace("%appointment_time%", $apt_format_time, $appt_content); //Replace time
			$appt_content = str_replace("%signature%", $sender_info, $appt_content); //Replace Signature

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $appt_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			wp_mail($email, $appt_subject, $body);
			return true;
		}

		/**
		 * @Process Appointment Rejection Email
		 *
		 * @since 1.0.0
		 */
		public function process_appt_rejection_email($params = '') {
			global $current_user;
			extract($params);

			//Get Post meta based on post id
			$apt_services = get_post_meta($post_id, 'apt_services', true);
			$apt_user_from = get_post_meta($post_id, 'apt_user_from', true);
			$apt_user_to = get_post_meta($post_id, 'apt_user_to', true);

			//Get user email address based on user id
			$user_data = get_userdata($apt_user_from);
			$email = $user_data->user_email;

			$booking_services = get_user_meta($apt_user_to, 'profile_services', true);

			//Get Customet Name
			$customer_name = listingo_get_username($apt_user_from);
			//Get Provider Name
			$provider_name = listingo_get_username($apt_user_to);

			//Get Appointment Approval subject and content
			$appt_subject = get_user_meta($apt_user_to, 'appt_cancelled_title', true);
			$appt_content = get_user_meta($apt_user_to, 'appt_booking_cancelled', true);

			if (!empty($booking_services[$apt_services])) {
				$apt_services = $booking_services[$apt_services]['title'];
			}
			//Email Sender information
			$sender_info = $this->process_sender_information();


			$subject = esc_html__('Your Appointment Cancelled!', 'listingo_core');
			$email_content_default = 'Hi %customer_name%!<br/>
										This is confirmation that your booking regarding "%service%" with %provider% has cancelled.<br/>
										We are very sorry to process your booking right now.<br/><br/>
										%reason_title%<br/>
										%reason_description%<br/><br/>
										%signature%<br/>';

			//set defalt contents
			if (empty($appt_content)) {
				$appt_content = $email_content_default;
			}

			if (empty($appt_subject)) {
				$appt_subject = $subject;
			}

			$appt_content = str_replace("%customer_name%", $customer_name, $appt_content); //Replace Customer Name
			$appt_content = str_replace("%service%", $apt_services, $appt_content); //Replace Service Name
			$appt_content = str_replace("%provider%", $provider_name, $appt_content); //Replace Provider Name
			$appt_content = str_replace("%reason_title%", $rejection_title, $appt_content); //Replace Provider Name
			$appt_content = str_replace("%reason_description%", $rejection_reason, $appt_content); //Replace Provider Name
			$appt_content = str_replace("%signature%", $sender_info, $appt_content); //Replace Signature

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $appt_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			wp_mail($email, $appt_subject, $body);
			return true;
		}

		/**
		 * @Process Appointment Confirmation Email
		 *
		 * @since 1.0.0
		 */
		public function process_appt_confirmation_email($params = '') {
			global $current_user;
			extract($params);

			//Get Post meta based on post id
			$apt_services  = get_post_meta($post_id, 'apt_services', true);
			$apt_user_from = get_post_meta($post_id, 'apt_user_from', true);
			$apt_user_to   = get_post_meta($post_id, 'apt_user_to', true);

			//Get user email address based on user id
			$user_data = get_userdata($apt_user_from);
			$email 	   = $user_data->user_email;

			$booking_services = get_user_meta($apt_user_to, 'profile_services', true);

			$apt_time = get_post_meta($post_id, 'apt_time', true);
			$apt_date = get_post_meta($post_id, 'apt_date', true);

			$date_format = get_option('date_format');
			$time_format = get_option('time_format');
			$time = explode('-', $apt_time);
			$apt_format_time = '';
			if (!empty($time[0]) && !empty($time[1])) {
				$apt_format_time = date($time_format, strtotime('2016-01-01 ' . $time[0])) . '&nbsp;-&nbsp;' . date($time_format, strtotime('2016-01-01 ' . $time[1]));
			}

			//Get Customet Name
			$customer_name = listingo_get_username($apt_user_from);
			//Get Provider Name
			$provider_name = listingo_get_username($apt_user_to);

			//Get Appointment Approval subject and content
			$appt_subject = get_user_meta($apt_user_to, 'appt_confirmation_title', true);
			$appt_content = get_user_meta($apt_user_to, 'appt_booking_confirmed', true);

			if (!empty($booking_services[$apt_services])) {
				$apt_services = $booking_services[$apt_services]['title'];
			}


			//Email Sender information
			$sender_info = $this->process_sender_information();


			$subject = esc_html__('Your Appointment Confirmation!', 'listingo_core');
			$email_content_default = 'Hey %customer_name%!<br/>
										This is confirmation that you have booked "%service%"
										with %provider%<br/>

										We will let your know regarding your booking soon.<br/><br/>
										Thank you for choosing our company.<br/><br/>
										%signature%<br/>';

			//set defalt contents
			if (empty($appt_content)) {
				$appt_content = $email_content_default;
			}

			if (empty($appt_subject)) {
				$appt_subject = $subject;
			}

			$appt_content = str_replace("%customer_name%", $customer_name, $appt_content); //Replace Customer Name
			$appt_content = str_replace("%service%", $apt_services, $appt_content); //Replace Service Name
			$appt_content = str_replace("%provider%", $provider_name, $appt_content); //Replace Provider Name
			$appt_content = str_replace("%appointment_date%", date($date_format, $apt_date), $appt_content); //Replace date
			$appt_content = str_replace("%appointment_time%", $apt_format_time, $appt_content); //Replace time
			$appt_content = str_replace("%signature%", $sender_info, $appt_content); //Replace Signature

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $appt_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';

			$body .= $this->prepare_email_footers();
			wp_mail($email, $appt_subject, $body);
			return true;
		}

		/**
		 * @Process Appointment Confirmation Email From Admin to Provider
		 *
		 * @since 1.0.0
		 */
		public function process_appt_confirmation_email_from_admin($params = '') {
			global $current_user;
			extract($params);

			//Get Post meta based on post id
			$apt_user_from = get_post_meta($post_id, 'apt_user_from', true);
			$apt_user_to   = get_post_meta($post_id, 'apt_user_to', true);

			//Get user email address based on user id
			$user_data 	= get_userdata($apt_user_to);
			$email 		= $user_data->user_email;

			//Get Customet Name
			$customer_name = listingo_get_username($apt_user_from);


			$apt_time = get_post_meta($post_id, 'apt_time', true);
			$apt_date = get_post_meta($post_id, 'apt_date', true);

			$date_format = get_option('date_format');
			$time_format = get_option('time_format');
			$time = explode('-', $apt_time);
			$apt_format_time = '';
			if (!empty($time[0]) && !empty($time[1])) {
				$apt_format_time = date($time_format, strtotime('2016-01-01 ' . $time[0])) . '&nbsp;-&nbsp;' . date($time_format, strtotime('2016-01-01 ' . $time[1]));
			}

			//Get Appointment Approval subject and content
			if (function_exists('fw_get_db_post_option')) {
				$appt_subject = fw_get_db_settings_option('appt_confirm_subject');
				$appt_content = fw_get_db_settings_option('appt_confirm_content');
			}

			//Email Sender information
			$sender_info = $this->process_sender_information();


			$subject = esc_html__('Appointment Confirmation!', 'listingo_core');
			$email_content_default = 'Hello<br/>

				This is confirmation that you have received a new appointment from %user_from%.
									<br/>

				%signature%<br/>';

			//set defalt contents
			if (empty($appt_content)) {
				$appt_content = $email_content_default;
			}

			if (empty($appt_subject)) {
				$appt_subject = $subject;
			}

			$appt_content = str_replace("%appointment_date%", date($date_format, $apt_date), $appt_content); //Replace date
			$appt_content = str_replace("%appointment_time%", $apt_format_time, $appt_content); //Replace time
			$appt_content = str_replace("%user_from%", $customer_name, $appt_content); //Replace Customer Name
			$appt_content = str_replace("%signature%", $sender_info, $appt_content); //Replace Signature

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $appt_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			wp_mail($email, $appt_subject, $body);
			return true;
		}

		/**
		 * @Process Claim admin email
		 *
		 * @since 1.0.0
		 */
		public function process_claim_admin_email($params = '') {
			global $current_user;
			extract($params);
			$subject = 'A user has claimed!';
			$claim_content_default = 'Hi,<br/>
				This %claimed_user% has been claimed by %claimed_by%
				<br/><br/>
				Message is given below.
				<br/>
				%message%
				<br/>
				%signature%,<br/>';

			$admin_email = '';
			if (function_exists('fw_get_db_post_option')) {
				$subject = fw_get_db_settings_option('claim_subject');
				$admin_email = fw_get_db_settings_option('claim_admin_email');
				$claim_content = fw_get_db_settings_option('claim_content');
			}

			//Email Sender information
			$sender_info = $this->process_sender_information();

			//set defalt contents
			if (empty($claim_content)) {
				$claim_content = $claim_content_default;
			}

			$claimed_user = '<a href="' . $claimed_user_link . '"  alt="' . esc_html__('Claimed', 'listingo_core') . '">' . $claimed_user_name . '</a>';
			$claimed_by = '<a href="' . $claimed_by_link . '"  alt="' . esc_html__('Claimed By', 'listingo_core') . '">' . $claimed_by_name . '</a>';

			$claim_content = str_replace("%claimed_user%", $claimed_user, $claim_content); //Claimed user
			$claim_content = str_replace("%claimed_by%", $claimed_by, $claim_content); //Claimed by
			$claim_content = str_replace("%message%", $message, $claim_content); //Message
			$claim_content = str_replace("%signature%", $sender_info, $claim_content); //Replace Logo

			if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $admin_email)) {
				$admin_email = get_option('admin_email', 'info@themographics.com');
			}

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $claim_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			wp_mail($admin_email, $subject, $body);
			return true;
		}

		/**
		 * @Lost password
		 *
		 * @since 1.0.0
		 */
		public function process_lostpassword_email($params = '') {
			global $current_user;
			extract($params);

			$name = listingo_get_username($user_identity);

			$subject = 'Forgot Password!';
			$email_content_default = 'Hey %name%!<br/>

								<p><strong>Lost Password reset</strong></p>
								<p>Someone requested to reset the password of following account:</p>
								<p>Email Address: %account_email%</p>
								<p>If this was a mistake, just ignore this email and nothing will happen.</p>
								<p>To reset your password, click reset link below:</p>
								<p><a href="%link%">Reset</a></p>
								%signature%,<br/>
								';

			if (function_exists('fw_get_db_post_option')) {
				$subject = fw_get_db_settings_option('lp_subject');
				$lp_content = fw_get_db_settings_option('lp_content');
			}

			//Email Sender information
			$sender_info = $this->process_sender_information();

			//set defalt contents
			if (empty($lp_content)) {
				$lp_content = $email_content_default;
			}

			$lp_content = str_replace("%name%", $name, $lp_content); //Replace Name
			$lp_content = str_replace("%account_email%", $email, $lp_content); //Replace email
			$lp_content = str_replace("%link%", $link, $lp_content); //Replace Link
			$lp_content = str_replace("%signature%", $sender_info, $lp_content); //Replace Logo

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $lp_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();
			wp_mail($email, $subject, $body);
		}

		/**
		 * @Email Verification
		 *
		 * @since 1.0.0
		 */
		public function process_email_verification($params = '') {
			global $current_user;
			extract($params);

			$name = listingo_get_username($user_identity);

			$subject_default = esc_html__('Account Verification', 'listingo_core');
			$email_content_default = 'Hi %name%!<br/>

									<p><strong>Verify Your Account</strong></p>
									<p>You account has created with given below email address:</p>
									<p>Email Address: %account_email%</p>
									<p>If this was a mistake, just ignore this email and nothing will happen.</p>
									<p>To verifiy your account, click below link:</p>
									<p><a href="%link%">Verify</a></p><br />
									%signature%
								';

			if (function_exists('fw_get_db_post_option')) {
				$subject = fw_get_db_settings_option('ave_subject');
				$ave_content = fw_get_db_settings_option('ave_content');
			}

			//Email Sender information
			$sender_info = $this->process_sender_information();

			//set defalt contents
			if (empty($ave_content)) {
				$ave_content = $email_content_default;
			}

			//set defalt subject
			if (empty($subject)) {
				$subject = $subject_default;
			}

			$ave_content = str_replace("%name%", $name, $ave_content); //Replace Name
			$ave_content = str_replace("%account_email%", $email, $ave_content); //Replace email
			$ave_content = str_replace("%link%", $verify_link, $ave_content); //Replace Link
			$ave_content = str_replace("%signature%", $sender_info, $ave_content); //Replace Logo

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $ave_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();
			wp_mail($email, $subject, $body);
		}

		/**
		 * @Registration
		 *
		 * @since 1.0.0
		 */
		public function process_registeration_email($params = '') {
			global $current_user;

			extract($params);

			$name = listingo_get_username($user_identity);

			$subject_default = 'Thank you for registering!';
			$register_content_default = 'Hey %name%!<br/>

										Thanks for registering at Listingo. You can now login to manage your account using the following credentials:
										<br/>
										Username: %email%<br/>
										Password: %password%<br/>

										%signature%,<br/>';

			if ( apply_filters('listingo_get_user_type', $user_identity) === 'business' 
				 || apply_filters('listingo_get_user_type', $user_identity) === 'professional' 
			 ){
				if (function_exists('fw_get_db_post_option')) {
					$subject = fw_get_db_settings_option('provider_register_subject');
					$register_content = fw_get_db_settings_option('provider_register_content');
				}
			} else{
				if (function_exists('fw_get_db_post_option')) {
					$subject = fw_get_db_settings_option('register_subject');
					$register_content = fw_get_db_settings_option('register_content');
				}
			}

			//set defalt contents
			if (empty( $register_content )) {
				$register_content = $register_content_default;
			}

			//set defalt subject
			if (empty($subject)) {
				$subject = $subject_default;
			}

			//Email Sender information
			$sender_info = $this->process_sender_information();

			$register_content = str_replace("%name%", $name, $register_content); //Replace Name
			$register_content = str_replace("%username%", $username, $register_content); //Replace username
			$register_content = str_replace("%password%", $password, $register_content); //Replace password
			$register_content = str_replace("%email%", $email, $register_content); //Replace email
			$register_content = str_replace("%signature%", $sender_info, $register_content); //Replace Logo

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $register_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			wp_mail($email, $subject, $body);
		}

		/**
		 * @Registration admin email
		 *
		 * @since 1.0.0
		 */
		public function process_registeration_admin_email($params = '') {
			global $current_user;

			extract($params);

			$name = listingo_get_username($user_identity);			
			$user_link = get_author_posts_url($user_identity);

			//Email Sender information
			$sender_info = $this->process_sender_information();

			$subject = 'New Registration!';
			$register_content_default = 'Hey!<br/>

										A new user "%username%" with email address "%email%" has registered on your website. Please login to check user detail.
										<br/>
										You can check user detail at: %link%<br/>

										%signature%';

			$admin_email = '';
			if (function_exists('fw_get_db_post_option')) {
				$subject = fw_get_db_settings_option('admin_register_subject');
				$admin_email = fw_get_db_settings_option('admin_email');
				$register_content = fw_get_db_settings_option('admin_register_content');
			}

			//set defalt contents
			if (empty($register_content)) {
				$register_content = $register_content_default;
			}

			$register_content = str_replace("%username%", $name, $register_content); //Replace username
			$register_content = str_replace("%email%", $email, $register_content); //Replace email
			$register_content = str_replace("%link%", $user_link, $register_content); //Replace email
			$register_content = str_replace("%signature%", $sender_info, $register_content); //Replace Logo

			if (!is_email($admin_email) ) {
				$admin_email = get_option('admin_email', 'info@themographics.com');
			}

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $register_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			wp_mail($admin_email, $subject, $body);

		}

		/**
		 * @Invoice
		 *
		 * @since 1.0.0
		 */
		public function process_invoice_email($params = '') {
			global $current_user;
			extract($params);

			$subject = 'Thank you for purchasing package!';
			$payment_content_default = 'Hey %name%!<br/>

										Thanks for purchasing the package. Your payment has been received and your invoice detail is given below:
										<br/>
										Invoice ID: %invoice%<br/>
										Package Name: %package_name%<br/>
										Payment Amount: %amount%<br/>
										Payment Status: %status%<br/>
										Payment Method: %method%<br/>
										Purchase Date: %date%<br/>
										Expiry Date: %expiry%<br/>
										Address: %address%<br/>

										%signature%';

			if (function_exists('fw_get_db_post_option')) {
				$subject = fw_get_db_settings_option('invoice_subject');
				$payment_content = fw_get_db_settings_option('payment_content');
			}

			//Email Sender information
			$sender_info = $this->process_sender_information();


			//set defalt contents
			if (empty($payment_content)) {
				$payment_content = $payment_content_default;
			}

			$payment_content = str_replace("%name%", $name, $payment_content); //Replace Name
			$payment_content = str_replace("%invoice%", $invoice_id, $payment_content); //Replace invoice id
			$payment_content = str_replace("%amount%", $amount, $payment_content); //Replace amount
			$payment_content = str_replace("%package_name%", $package_name, $payment_content); //Replace amount
			$payment_content = str_replace("%status%", $status, $payment_content); //Replace status
			$payment_content = str_replace("%method%", $method, $payment_content); //Replace payment method
			$payment_content = str_replace("%date%", $date, $payment_content); //Replace expiry date
			$payment_content = str_replace("%expiry%", $expiry, $payment_content); //Replace password
			$payment_content = str_replace("%address%", nl2br($address), $payment_content); //Replace email
			$payment_content = str_replace("%signature%", $sender_info, $payment_content); //Replace logo


			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $payment_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			wp_mail($mail_to, $subject, $body);
			return true;
		}

		/**
		 * @Rating
		 *
		 * @since 1.0.0
		 */
		public function process_rating_email($params = '') {
			global $current_user;

			extract($params);

			$subject = 'New rating received!';
			$rating_content_default = 'Hey %name%!<br/>

				A new rating has been received, Detail for rating is given below:
				<br/>
				Rating: %rating%<br/>
				Rating From: %rating_from%<br/>
				Reason: %reason%<br/>
				---------------------------------------<br/>
				You can view this at %link%

				<br/>
				%signature%';


			if (function_exists('fw_get_db_post_option')) {
				$subject = fw_get_db_settings_option('rating_subject');
				$rating_content = fw_get_db_settings_option('rating_content');
			}

			//Email Sender information
			$sender_info = $this->process_sender_information();

			//set defalt contents
			if (empty($rating_content)) {
				$rating_content = $rating_content_default;
			}

			$logo = $this->process_get_logo();

			$rating_content = str_replace("%rating%", $rating, $rating_content); //Replace rating
			$rating_content = str_replace("%reason%", $reason, $rating_content); //Replace reason
			$rating_content = str_replace("%name%", $username_to, $rating_content); //Replace name

			$rating_content = str_replace("%rating_from%", $username_from, $rating_content); //Replace email
			$rating_content = str_replace("%link%", $link_to, $rating_content); //Replace email
			$rating_content = str_replace("%signature%", $sender_info, $rating_content); //Replace logo

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $rating_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			wp_mail($email_to, $subject, $body);
			return true;
		}

		/**
		 * @Invitation
		 *
		 * @since 1.0.0
		 */
		public function process_invitation_email($params = '') {
			global $current_user;

			extract($params);

			$subject = 'You have invitation for signup!';
			$invitation_content_default = 'Hi,<br/>

										%username% has invited you to signup at %link%. You have invitation message given below
										<br/>
										%message%
										<br/>

										%signature%';


			if (function_exists('fw_get_db_post_option')) {
				$subject = fw_get_db_settings_option('invitation_subject');
				$invitation_content = fw_get_db_settings_option('invitation_content');
			}

			//Email Sender information
			$sender_info = $this->process_sender_information();

			//set defalt contents
			if (empty($invitation_content)) {
				$invitation_content = $invitation_content_default;
			}

			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
		   // $link = '<a href="' . $link . '" alt="' . esc_html__('Site Link', 'listingo_core') . '">' . $blogname . '</a>';

			$invitation_content = str_replace("%username%", $username, $invitation_content); //Replace username
			$invitation_content = str_replace("%message%", $message, $invitation_content); //Replace message
			$invitation_content = str_replace("%link%", $link, $invitation_content); //Replace link
			$invitation_content = str_replace("%signature%", $sender_info, $invitation_content); //Replace logo

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $invitation_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			wp_mail($email_to, $subject, $body);
			return true;
		}

		/**
		 * @Contact Form
		 *
		 * @since 1.0.0
		 */
		public function process_contact_form_email($params = '') {
			global $current_user;

			extract($params);

			$email_subject = !empty($email_subject) ? $email_subject : "(" . $bloginfo . ")" . esc_html__('Contact Form Received', 'listingo_core');
			$contact_default = 'Hello,<br/>

								A person has contacted you, description of message is given below.<br/><br/>
								Subject : %subject%<br/>
								Name : %name%<br/>
								Email : %email%<br/>
								Phone Number : %phone%<br/>
								Message : %message%<br/><br/>

								<br/>
								%signature%';


			//Email Sender information
			$sender_info = $this->process_sender_information();

			if (function_exists('fw_get_db_settings_option')) {
				$contact_subject = fw_get_db_settings_option('contact_subject');
				$contact_content = fw_get_db_settings_option('contact_content');
			}

			//set defalt contents
			if (empty($contact_content)) {
				$contact_content = $contact_default;
			}

			//set defalt title
			if (empty($contact_subject)) {
				$email_subject = $email_subject;
			}

			$contact_content = str_replace("%subject%", $subject, $contact_content); //Replace username
			$contact_content = str_replace("%name%", $name, $contact_content); //Replace Name
			$contact_content = str_replace("%email%", $email, $contact_content); //Replace email
			$contact_content = str_replace("%phone%", $phone, $contact_content); //Replace phone
			$contact_content = str_replace("%message%", $message, $contact_content); //Replace message
			$contact_content = str_replace("%signature%", $sender_info, $contact_content); //Replace logo

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $contact_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			wp_mail($email_to, $subject, $body);
		}

		/**
		 * @Process Apply job email
		 *
		 * @since 1.0.0
		 */
		public function process_applyjob_user($params = '') {
			global $current_user;

			extract($params);

			$subject_default = esc_html__('Job application received', 'listingo_core');
			$job_default = 'Hi %name%,<br/>
							Thank you very much for applying job. We will contact you shortly.<br/>                                                   
							<br/>
							%signature%';

			//Email Sender information
			$sender_info = $this->process_sender_information();

			if (function_exists('fw_get_db_settings_option')) {
				$email_subject  = fw_get_db_settings_option('job_subject');                    
				$job_content 	= fw_get_db_settings_option('job_content');
			}

			//set defalt contents
			if (empty($job_content)) {
				$job_content = $job_default;
			}

			//set defalt title
			if (empty($email_subject)) {
				$email_subject = $subject_default;
			}

			//Get job title
			$job_title 			= get_the_title( $job );
			$job_link 			= get_the_permalink( $job );
			$author_id 			= get_post_field( 'post_author', $job );      
			$author_name 		= listingo_get_username( $author_id );

			$job_content = str_replace("%subject%", $job_title, $job_content); //Replace username
			$job_content = str_replace("%name%", $name, $job_content); //Replace Name
			$job_content = str_replace("%email%", $email, $job_content); //Replace email
			$job_content = str_replace("%phone%", $phone, $job_content); //Replace phone
			$job_content = str_replace("%author_name%", $author_name, $job_content); //Replace 
			$job_content = str_replace("%author_email%", $author_email, $job_content); //
			$job_content = str_replace("%author_phone%", $author_phone, $job_content); //
			$job_content = str_replace("%education%", $education, $job_content); //
			$job_content = str_replace("%status%", $status, $job_content); //
			$job_content = str_replace("%address%", $address, $job_content); //
			$job_content = str_replace("%description%", $description, $job_content); //
			$job_content = str_replace("%link%", $job_link, $job_content); //
			$job_content = str_replace("%signature%", $sender_info, $job_content); //Replace logo

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $job_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			//Setting repeient email to provided email
			$email_to = $email;
			wp_mail($email_to, $email_subject, $body);                             
			return true;
		}

		/**
		 * @Send job email to job author
		 *
		 * @since 1.0.0
		 */
		public function process_applyjob_author($params = '') {
			global $current_user;

			extract($params);

			$subject_default = esc_html__('Job application received', 'listingo_core');
			$contact_default = 'Hi,<br/>
								A person has applied to job you posted, description of message is given below.<br/><br/>
								Subject : %subject%<br/>
								Name : %name%<br/>
								Email : %email%<br/>
								Phone Number : %phone%<br/>
								Education : %education%<br/>
								Job Status : %status%<br/>
								Address : %address%<br/>
								Job Description : %description%<br/>';                        
			
			if (function_exists('fw_get_db_settings_option')) {
				$email_subject = fw_get_db_settings_option('apply_job_subject');
				$application_content = fw_get_db_settings_option('apply_job_content');
			}

			//set defalt contents
			if (empty($application_content)) {
				$application_content = $contact_default;
			}

			//set defalt title
			if (empty($email_subject)) {
				$email_subject = $subject_default;
			}
			
			//Getting Author Details
			$author_id 			= get_post_field( 'post_author', $job );      
			$author_name 		= listingo_get_username( $author_id );          
			$author_email    	= get_the_author_meta( 'user_email', $author_id );
			$author_phone   	= get_the_author_meta( 'phone', $author_id );
			$job_link 			= get_post_permalink( $job );
			
			$job_title = get_the_title( $job );
			$application_content = str_replace("%subject%", $job_title, $application_content); 
			$application_content = str_replace("%name%", $name, $application_content);
			$application_content = str_replace("%email%", $email, $application_content); 
			$application_content = str_replace("%phone%", $phone, $application_content); 
			$application_content = str_replace("%author_name%", $author_name, $application_content); 
			$application_content = str_replace("%author_email%", $author_email, $application_content); 
			$application_content = str_replace("%author_phone%", $author_phone, $application_content); 
			$application_content = str_replace("%education%", $education, $application_content); 
			$application_content = str_replace("%status%", $status, $application_content); 
			$application_content = str_replace("%address%", $address, $application_content); 
			$application_content = str_replace("%description%", $description, $application_content); 
			$application_content = str_replace("%link%", $job_link, $application_content); 
			$application_content = str_replace("%signature%", $sender_info, $application_content); //Replace logo


			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $application_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';

			$body .= $this->prepare_email_footers();                
			$body .= $this->prepare_email_footers();
			wp_mail($author_email, $email_subject, $body);
		}

		/**
		 * @Send job email to job author
		 *
		 * @since 1.0.0
		 */
		public function process_applyjob_admin($params = '') {
			global $current_user;

			extract($params);

			$subject_default = esc_html__('Job application received', 'listingo_core');
			$contact_default = 'Hi,<br/>
								A person has applied to job on your website, description of message is given below.<br/><br/>                                   
								Job Title : %subject%<br/>
								Applicant Name : %name%<br/>
								Applicant Email : %email%<br/>
								Applicant Phone : %phone%<br/>

								Job Author Name: %author_name%<br/>
								Job Author Email: %author_email%<br/>
								Job Author Phone: %author_phone%<br/>      

								<br/>
								%signature%';

			//Email Sender information
			$sender_info = $this->process_sender_information();

			if (function_exists('fw_get_db_settings_option')) {
				$email_subject = fw_get_db_settings_option('apply_job_subject_admin');
				$application_content = fw_get_db_settings_option('apply_job_content_admin');
				$admin_email = fw_get_db_settings_option('admin_email_id');
			}

			//set defalt contents
			if (empty($application_content)) {
				$application_content = $contact_default;
			}

			//set defalt title
			if (empty($email_subject)) {
				$email_subject = $subject_default;
			}

			//Set default email id
			if(empty($admin_email)){
				$admin_email = get_option('admin_email');
			}

			//Getting Author Details
			$author_id 			= get_post_field( 'post_author', $job );      
			$author_name 		= listingo_get_username( $author_id );          
			$author_email    	= get_the_author_meta( 'user_email', $author_id );
			$author_phone   	= get_the_author_meta( 'phone', $author_id );
			$job_link 			= get_post_permalink( $job );

			//Get job title                
			$job_title = get_the_title( $job );
			$application_content = str_replace("%subject%", $job_title, $application_content); //Replace username
			$application_content = str_replace("%name%", $name, $application_content); //Replace Name
			$application_content = str_replace("%email%", $email, $application_content); //Replace email
			$application_content = str_replace("%phone%", $phone, $application_content); //Replace phone
			$application_content = str_replace("%author_name%", $author_name, $application_content); //Replace 
			$application_content = str_replace("%author_email%", $author_email, $application_content); //
			$application_content = str_replace("%author_phone%", $author_phone, $application_content); //
			$application_content = str_replace("%education%", $education, $application_content); //
			$application_content = str_replace("%status%", $status, $application_content); //
			$application_content = str_replace("%address%", $address, $application_content); //
			$application_content = str_replace("%description%", $description, $application_content); //
			$application_content = str_replace("%link%", $job_link, $application_content); //
			$application_content = str_replace("%signature%", $sender_info, $application_content); //Replace logo

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $application_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();
			$email_to  = $admin_email;                                             
			wp_mail($email_to, $email_subject, $body);                 
		}            

		/**
		 * @Send email to provider to inform that a question has posted.
		 *
		 * @since 1.0.0
		 */
		public function process_question_email($params = '') {
			global $current_user;

			extract($params);
			$username = listingo_get_username($user_id);

			$subject_default = esc_html__('A question has posted on your profile', 'listingo_core');
			$qa_default = 'Hi %name%,<br/>
								A person has posted aquestion at your profile, question is given below.<br/><br/>

								%question%

								<br/>
								%signature%';

			//Email Sender information
			$sender_info = $this->process_sender_information();

			if (function_exists('fw_get_db_settings_option')) {
				$qa_subject = fw_get_db_settings_option('qa_subject');
				$qa_content = fw_get_db_settings_option('qa_content');
			}

			//set defalt contents
			if (empty($qa_content)) {
				$qa_content = $qa_default;
			}

			//set defalt title
			if (empty($qa_subject)) {
				$qa_subject = $subject_default;
			}

			$qa_content = str_replace("%name%", $username, $qa_content); //Replace Name
			$qa_content = str_replace("%question%", $question_title, $qa_content); //Replace email
			$qa_content = str_replace("%signature%", $sender_info, $qa_content); //Replace logo

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $qa_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			$user_data = get_userdata($user_id);
			$email_to  = $user_data->user_email;
			wp_mail($email_to, $qa_subject, $body);                 
		}

		/**
		 * @Send email to provider to inform that a question has posted.
		 *
		 * @since 1.0.0
		 */
		public function process_answer_email($params = '') {
			global $current_user;

			extract($params);
			$username = listingo_get_username($answer_author);
			$name 	  = listingo_get_username($question_author);

			$subject_default = esc_html__('New answer posted on your question', 'listingo_core');
			$answers_default = 'Hi %name%,<br/>
							A person with name "%username%" has posted an answers on your question ( %question% ), To view all answers please follow given below link<br/><br/>

							%link%

							<br/>
							%signature%';

			//Email Sender information
			$sender_info = $this->process_sender_information();

			if (function_exists('fw_get_db_settings_option')) {
				$answers_subject = fw_get_db_settings_option('answer_subject');
				$answers_content = fw_get_db_settings_option('answer_content');
			}

			//set defalt contents
			if (empty($answers_content)) {
				$answers_content = $answers_default;
			}

			//set defalt title
			if (empty($answers_subject)) {
				$answers_subject = $subject_default;
			}

			$answers_content = str_replace("%name%", $name, $answers_content); //Replace Name
			$answers_content = str_replace("%username%", $username, $answers_content); //Replace Name
			$answers_content = str_replace("%question%", $question_title, $answers_content); //Replace question title
			$answers_content = str_replace("%link%", $link, $answers_content); //Replace link
			$answers_content = str_replace("%signature%", $sender_info, $answers_content); //Replace logo

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $answers_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			$user_data = get_userdata($question_author);
			$email_to  = $user_data->user_email;
			wp_mail($email_to, $answers_subject, $body);                 
		}

		/**
		 * @Send email to provider for withdrawal
		 *
		 * @since 1.0.0
		 */
		public function process_withdrawal_email($params = '') {
			global $current_user;

			extract($params);
			$name 	  = listingo_get_username($user_id);

			$subject_default = esc_html__('Your Request for Withdrawal has been Processed', 'listingo_core');
			$withdrawal_default = 'Hi %name%,<br/>
								We just processed your request for %amount% via %method%.<br/>
								Your payment was sent to %email%<br/><br/>

								Happy Spending!
								%signature%';

			//Email Sender information
			$sender_info = $this->process_sender_information();

			if (function_exists('fw_get_db_settings_option')) {
				$withdrawal_subject = fw_get_db_settings_option('withdrawal_subject');
				$withdrawal_content = fw_get_db_settings_option('withdrawal_content');
			}

			//set defalt contents
			if (empty($withdrawal_content)) {
				$withdrawal_content = $withdrawal_default;
			}

			//set defalt title
			if (empty($withdrawal_subject)) {
				$withdrawal_subject = $subject_default;
			}

			$withdrawal_content = str_replace("%name%", $name, $withdrawal_content); //Replace Name
			$withdrawal_content = str_replace("%email%", $email, $withdrawal_content); //Replace email
			$withdrawal_content = str_replace("%amount%", $amount, $withdrawal_content); //Replace amount
			$withdrawal_content = str_replace("%method%", $method, $withdrawal_content); //Replace payment method
			$withdrawal_content = str_replace("%signature%", $sender_info, $withdrawal_content); //Replace logo

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $withdrawal_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			$user_data = get_userdata($user_id);
			$email_to  = $user_data->user_email;
			wp_mail($email_to, $withdrawal_subject, $body);                 
		}


		/**
		 * @Send email to admin when any user delete account
		 *
		 * @since 1.0.0
		 */
		public function delete_user_account($params = '') {
			global $current_user;

			extract($params);
			$username = listingo_get_username($user_identity);


			$subject_default = esc_html__('Delete Account', 'listingo_core');
			$delete_content_default = 'Hi,<br/>

								An existing user has deleted account due to following reason: 
								<br/>
								%reason%
								<br/>
								%signature%,<br/>';


			if (function_exists('fw_get_db_settings_option')) {
				$delete_subject= fw_get_db_settings_option('delete_subject');
				$delete_content = fw_get_db_settings_option('delete_content');
				$admin_email = fw_get_db_settings_option('delete_email');
			}

			//set defalt contents
			if (empty($delete_content)) {
				$delete_content = $delete_content_default;
			}

			//set defalt title
			if (empty($delete_subject)) {
				$delete_subject = $subject_default;
			}

			//Email Sender information
			$sender_info = $this->process_sender_information();

			$delete_content = str_replace("%username%", $username, $delete_content); //Replace Name
			$delete_content = str_replace("%reason%", $reason, $delete_content); //Replace question title
			$delete_content = str_replace("%email%", $email, $delete_content); //Replace link
			$delete_content = str_replace("%signature%", $sender_info, $delete_content); //Replace logo

			if( empty( $admin_email ) ) { 
				$admin_email	= get_option( 'admin_email' ,'info@themographics.com' );
			}

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $delete_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();
			wp_mail($admin_email, $delete_subject, $body);                 
		}

		/**
		 * @Send email to admin to approve article
		 *
		 * @since 1.0.0
		 */
		public function approve_article($params = '') {
			global $current_user;
			extract($params);

			$subject_default = esc_html__('Article Needs Approval', 'listingo_core');
			$article_content_default = 'Hi,<br/>

										A provider has publish an article with the name "%article_name%" and needs approval. below is link to approve.
										<br/>
										<br/>
										<a style="color: #fff; padding: 0 50px; margin: 0 0 15px; font-size: 20px; font-weight: 600; line-height: 60px; border-radius: 8px; background: #5dc560; vertical-align: top; display: inline-block;" href="%link%">Approve</a>

										<br/>
										<br/>
										%signature%,<br/>';


				if (function_exists('fw_get_db_settings_option')) {
					$article_subject= fw_get_db_settings_option('article_subject');
					$article_content = fw_get_db_settings_option('article_content');
					$admin_email = fw_get_db_settings_option('article_email');
				}

				//set defalt contents
				if (empty($article_content)) {
					$article_content = $article_content_default;
				}

				//set defalt title
				if (empty($article_subject)) {
					$article_subject = $subject_default;
				}

				//Email Sender information
				$sender_info = $this->process_sender_information();

				$article_content = str_replace("%link%", $link, $article_content); //Replace link
				$article_content = str_replace("%article_name%", $article_name, $article_content); 
				$article_content = str_replace("%signature%", $sender_info, $article_content); //Replace logo

				if( empty( $admin_email ) ) { 
					$admin_email	= get_option( 'admin_email' ,'info@themographics.com' );
				}

				$body = '';
				$body .= $this->prepare_email_headers();

				$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
				$body .= '<div style="width: 100%; float: left;">';
				$body .= '<p>' . $article_content . '</p>';
				$body .= '</div>';
				$body .= '</div>';
				$body .= $this->prepare_email_footers();
				wp_mail($admin_email, $article_subject, $body);                 
		}

		/**
		 * @Send email to admin to approve ad
		 *
		 * @since 1.0.0
		 */
		public function approve_ad($params = '') {
			global $current_user;
			extract($params);
			$subject_default = esc_html__('Ad Created', 'listingo_core');
			$ad_content_default = 'Hi,<br/>

										A provider named "%username%" has publish an ad with the name "%ad_name%". <br/>
										Below is link to view ad for further action.
										<br/>
										<a style="color: #fff; padding: 0 50px; margin: 0 0 15px; font-size: 20px; font-weight: 600; line-height: 60px; border-radius: 8px; background: #5dc560; vertical-align: top; display: inline-block;" href="%link%">Approve</a>

										<br/><br/>
										%signature%,<br/>';


			if (function_exists('fw_get_db_settings_option')) {
				$ad_subject= fw_get_db_settings_option('ad_subject');
				$ad_content = fw_get_db_settings_option('ad_content');
				$admin_email = fw_get_db_settings_option('ad_email');
			}

			//set defalt contents
			if (empty($ad_content)) {
				$ad_content = $ad_content_default;
			}

			//set defalt title
			if (empty($ad_subject)) {
				$ad_subject = $subject_default;
			}

			//Email Sender information
			$sender_info = $this->process_sender_information();                    
			$ad_content = str_replace("%userlink%", $user_link, $ad_content);
			$ad_content = str_replace("%username%", $user_name, $ad_content);
			$ad_content = str_replace("%ad_link%", $link, $ad_content); 
			$ad_content = str_replace("%ad_name%", $ad_name, $ad_content); 
			$ad_content = str_replace("%signature%", $sender_info, $ad_content);

			if( empty( $admin_email ) ) { 
				$admin_email    = get_option( 'admin_email' ,'info@example.com' );
			}

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $ad_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';

			$body .= $this->prepare_email_footers();  
			wp_mail($admin_email, $ad_subject, $body);

		}


		/**
		 * @Send job email to job author
		 *
		 * @since 1.0.0
		 */
		public function process_send_email_to_related_providers($params = '') {
			global $current_user;
			extract($params);

			$subject_default = esc_html__('New Job Posted', 'listingo_core');
			$content_default = 'Hi,<br/>
								A new Job have been posted, if you are interest apply below.<br/><br/>
								Subject         : %subject%<br/>
								Salary          : %salary%<br/>                                   
								Job Description : %description%<br/>                             

								<p style="text-align: center" ><a style="display: inline-block;padding: 15px 50px;margin: auto;text-decoration: none;font-size: 20px;font-weight: bold;background: black;color: white;color: #348eda;background: #348eda;color: white;" href="%link%">Apply Now</a>
								</p>
								<br/>
								%signature%';

			//Email Sender information
			$sender_info = $this->process_sender_information();

			if (function_exists('fw_get_db_settings_option')) {
				$email_subject = fw_get_db_settings_option('providers_apply_job_subject');
				$application_content = fw_get_db_settings_option('providers_apply_job_content');
			}

			//set defalt contents
			if (empty($application_content)) {
				$application_content = $content_default;
			}

			//set defalt title
			if (empty($email_subject)) {
				$email_subject = $subject_default;
			}

			//Get job title               
			$application_content = str_replace("%subject%", $job_title, $application_content); //Replace username
			$application_content = str_replace("%salary%", $salary, $application_content); //Replace email
			$application_content = str_replace("%description%", $description, $application_content); //Replace message
			$application_content = str_replace("%link%", $apply_link, $application_content); //Replace message
			$application_content = str_replace("%signature%", $sender_info, $application_content); //Replace logo

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $application_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';

			$body .= $this->prepare_email_footers();

			wp_mail($user_email, $email_subject, $body);                 
		}
		
		/**
		 * @Ad Contact Form
		 *
		 * @since 1.0.0
		 */
		public function process_ad_contact_form_email($params = '') {
			global $current_user;

			extract($params);              
			$email_subject = !empty($subject) ? $subject : "(" . $bloginfo . ")" . esc_html__('Ad Contact form', 'listingo_core');
			$contact_default = 'Hi,<br/>
									A person has contact you for "%ad_title%", description of message is given below.<br/><br/>
									Subject : %subject%<br/>
									Name : %username%<br/>
									Email : %useremail%<br/> 
									Phone : %phone%<br/>                                 
									Message : %message%<br/><br/><br/>
									Ad Link : %ad_link%<br/><br/><br/>
									%signature%';


			//Email Sender information
			$sender_info = $this->process_sender_information();

			if (function_exists('fw_get_db_settings_option')) {
				$contact_subject = fw_get_db_settings_option('ad_contact_subject');
				$contact_content = fw_get_db_settings_option('ad_contact_content');
			}

			//set defalt contents
			if (empty($contact_content)) {
				$contact_content = $contact_default;
			}

			//set default title
			if (empty($contact_subject)) {
				$email_subject = $email_subject;
			}

			$contact_content = str_replace("%username%", $username, $contact_content); 
			$contact_content = str_replace("%useremail%", $useremail, $contact_content); 
			$contact_content = str_replace("%subject%", $subject, $contact_content); 
			$contact_content = str_replace("%phone%", $phone, $contact_content); 
			$contact_content = str_replace("%message%", $message, $contact_content); 
			$contact_content = str_replace("%ad_link%", $ad_link, $contact_content); 
			$contact_content = str_replace("%ad_title%", $ad_title, $contact_content); 
			$contact_content = str_replace("%signature%", $sender_info, $contact_content);

			
			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $contact_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			wp_mail($email_to, $email_subject, $body);
			return true;
		}
		
		/**
		 * @change provider category
		 *
		 * @since 1.0.0
		 */
		public function process_request_change_category($params = '') {
			global $current_user;
			extract($params);

			$subject_default = esc_html__('Request to change category', 'listingo_core');
			$request_default = 'Hello,<br/>
							"%username%" has requested to change the parent category with "%category_title%"<br/><br/>
							"%username%" comments are given below.<br/><br/>
							%message%<br/><br/>
							<a href="%edit_user%">Assign Now</a>
							<br/>
							%signature%';

			//Email Sender information
			$sender_info = $this->process_sender_information();

			if (function_exists('fw_get_db_settings_option')) {
				$email_subject  = fw_get_db_settings_option('request_subject'); 
				$request_email  = fw_get_db_settings_option('request_email'); 
				$request_content 	= fw_get_db_settings_option('request_content');
			}

			//set defalt contents
			if (empty($request_content)) {
				$request_content = $request_default;
			}

			//set defalt title
			if (empty($email_subject)) {
				$email_subject = $subject_default;
			}

			//Get job title
			$category_title		= get_the_title( $new_category );    
			$username 			= listingo_get_username( $user_id );
			$edit_user			= admin_url( 'user-edit.php?user_id=' . $user_id, 'http' );

			$request_content = str_replace("%username%", $username, $request_content); 
			$request_content = str_replace("%category_title%", $category_title, $request_content);
			$request_content = str_replace("%message%", $message, $request_content);
			$request_content = str_replace("%edit_user%", $edit_user, $request_content); 
			$request_content = str_replace("%signature%", $sender_info, $request_content); 

			if( empty( $request_email ) ){
				$request_email = get_option('admin_email', 'info@example.com');
			}

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= '<p>' . $request_content . '</p>';
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();

			//Setting repeient email to provided email
			wp_mail($request_email, $email_subject, $body);                             
			return true;
		}

	}

	new ListingoProcessEmail();
}