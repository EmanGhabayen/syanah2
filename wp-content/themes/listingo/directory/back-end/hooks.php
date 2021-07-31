<?php
/**
 *
 * Hooks
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


/**
 * @Save widthdrawal settings
 * @return {}
 */
if (!function_exists('listingo_get_withdrawal_history')) {

    function listingo_get_withdrawal_history() {
        global $current_user, $wpdb;
        
		$month	= date('m');
		$year	= date('Y');
		
		$user_id	= !empty( $_POST['userid'] ) ? intval( $_POST['userid'] ) : '';
		$offset = get_option('gmt_offset') * intval(60) * intval(60);
		
		$bk_settings	 = listingo_get_booking_settings();
		$price_symbol	 = get_woocommerce_currency_symbol();
		$minamount		 = !empty( $bk_settings['minamount'] ) ? esc_attr( $bk_settings['minamount'] ) : '';

		$db_withdrawal = listingo_get_withdrawal_settings($user_id);

		$status_paid	= 'paid';
		$status_unpaid	= 'un-paid';
		
		$table = $wpdb->prefix . 'sp_earnings';
		$table_withdrawal = $wpdb->prefix . 'sp_withdrawal_history';
		
		$earnings_query = $wpdb->get_results(
							$wpdb->prepare(
									"SELECT * FROM $table 
									WHERE $table.user_id = %d
									AND $table.status = %s ", 
									$user_id,
									$status_unpaid
							), ARRAY_A);
		
		$withdrawal_query = $wpdb->get_results(
							$wpdb->prepare(
									"SELECT * FROM $table_withdrawal 
									WHERE $table_withdrawal.user_id = %d
									AND $table_withdrawal.year = %d
									AND $table_withdrawal.month = %d
									AND $table_withdrawal.status = %s ", 
									$user_id,
									$year,
									$month,
									$status_paid
							), ARRAY_A);

		$amount_to_process	= 0;
		
		
			
		$html	= '';
		$html	.= '<div class="widthdrawal-detail">';
		
		
		$html	.= '<span class="widthdrawal-title">';
		$html	.= esc_html__('Earning of', 'listingo').'&nbsp;'.date_i18n('F, Y', strtotime(current_time('mysql')));
		$html	.= '</span>';
		
		if( !empty( $earnings_query ) ){
			foreach( $earnings_query as $kye => $value ){
				$amount_to_process	= $amount_to_process + $value['amount'];
				$html	.= '<div class="cus-options-data">';
				$html	.= '<label><span>'.date(get_option('date_format'), strtotime($value['process_date'])).'</span></label>';
				$html	.= '<div class="step-value"><span>'.$price_symbol.$value['amount'].'</span></div>';
				$html	.= '</div>';
			}	
		}
		
		$html	.= '<div class="cus-options-data">';
		$html	.= '<label><span>'.esc_html__('Total Amount', 'listingo').'</span></label>';
		$html	.= '<div class="step-value"><span>'.$price_symbol.$amount_to_process.'</span></div>';
		$html	.= '</div>';
		$html	.= '<div class="cus-options-data">';
		$html	.= '<label><span>'.esc_html__('Requested Date', 'listingo').'</span></label>';
		$html	.= '<div class="step-value"><span>'.date(get_option('date_format'), strtotime(current_time('mysql'))).' at '.date(get_option('time_format'), strtotime(current_time('mysql'))).'</span></div>';
		$html	.= '</div>';
		
		if( !empty( $db_withdrawal['type'] ) && !empty( $db_withdrawal['paypal'] ) ){
			$html	.= '<div class="cus-options-data"><label><span>'.esc_html__('Withdrawal Method', 'listingo').'</span></label><div class="step-value"><span>'.ucwords($db_withdrawal['type']).'</span></div></div>';
			$html	.= '<div class="cus-options-data"><label><span>'.esc_html__('Account Detail', 'listingo').'</span></label><div class="step-value"><span>'.$db_withdrawal['paypal'].'</span></div></div>';
		}
		
		if( isset( $amount_to_process ) && $amount_to_process > $minamount ){
			if( !empty( $withdrawal_query ) ){
				$html	.= '<span class="widthdrawal-message widthdrawal-head">';
				$html	.= '<p>'.esc_html__('Sorry! you have already process withdrawal for this month. Now you can process this amount next month.', 'listingo').'</p>';
				$html	.= '</span>';
			} else{
				if( !empty( $db_withdrawal['type'] ) && $db_withdrawal['type'] === 'paypal' && empty( $db_withdrawal['paypal'] ) ){
					$html	.= '<div class="widthdrawal-head">';
					$html	.= '<p>'.esc_html__('Provider didn\'t setup PayPal Account. You can\'t process this withdrawal until provider will add account detail', 'listingo').'</p>';
					$html	.= '</div>';
				}else{
					$html	.= '<div class="widthdrawal-head">';
					$html	.= '<a href="javascript:;" data-id="'.$user_id.'" class="process-withdrawal tg-btn">'.esc_html__('Process Now', 'listingo').'</a>';
					$html	.= '</div>';
				}
			}
			
		} else{
			$html	.= '<span class="widthdrawal-message widthdrawal-head">';
			$html	.= '<p>'.esc_html__('Sorry! minimum amount should be >= ', 'listingo').$price_symbol.$minamount.'&nbsp;'.esc_html__('to process this withdrawal', 'listingo').'</p>';
			$html	.= '</span>';
		}
		
		$html	.= '</div>';
		
		
        $json['data'] = $html;
		$json['type'] = 'success';
        $json['message'] = esc_html__('Withdrawal detail.', 'listingo');
        echo json_encode($json);
        die;
		
    }

    add_action('wp_ajax_listingo_get_withdrawal_history', 'listingo_get_withdrawal_history');
}

/**
 * @Save widthdrawal settings
 * @return {}
 */
if (!function_exists('listingo_process_withdrawal')) {

    function listingo_process_withdrawal() {
        global $current_user, $wpdb;
		
		$month	= date('m');
		$year	= date('Y');
		
		$user_id	= !empty( $_POST['userid'] ) ? intval( $_POST['userid'] ) : '';
		$offset = get_option('gmt_offset') * intval(60) * intval(60);
		
		$bk_settings	 = listingo_get_booking_settings();
		$price_symbol	 = get_woocommerce_currency_symbol();
		$db_withdrawal 	 = listingo_get_withdrawal_settings($user_id);
		$minamount		 = !empty( $bk_settings['minamount'] ) ? esc_attr( $bk_settings['minamount'] ) : '';
		
		if( !empty( $db_withdrawal[$db_withdrawal['type']] ) ){
			$status_unpaid	= 'un-paid';
			$table = $wpdb->prefix . 'sp_earnings';

			$earnings_query = $wpdb->get_results(
								$wpdb->prepare(
										"SELECT * FROM $table 
										WHERE $table.user_id = %d
										AND $table.status = %s ", 
										$user_id,
										$status_unpaid
								), ARRAY_A);



			$amount_to_process	= 0;
			if( !empty( $earnings_query ) ){
				foreach( $earnings_query as $kye => $value ){
					$amount_to_process	= $amount_to_process + $value['amount'];


					//Update record
					$update_data = array(
						'status' => 'paid',
					);
					$wpdb->update($table, $update_data, array('id' => intval($value['id'])));
				}	
			}

			//Update earning table
			$earnings_table  = $wpdb->prefix . 'sp_withdrawal_history';
			$earnings_data	 = array();

			$earnings_data['user_id'] 		= $user_id;
			$earnings_data['amount'] 		= $amount_to_process;
			$earnings_data['currency_symbol'] 	= $price_symbol;

			$earnings_data['payment_method'] 	= esc_html__('PayPal', 'listingo').'&nbsp;'.esc_html__('to','listingo').'&nbsp;'.$db_withdrawal[$db_withdrawal['type']];
			$earnings_data['processed_date'] 		= current_time('mysql');
			$earnings_data['timestamp'] 			= time();
			$earnings_data['status'] 	= 'paid';
			$earnings_data['year'] 		= date('Y');
			$earnings_data['month'] 	= date('m');

			$is_insert	= $wpdb->insert($earnings_table, $earnings_data);

			if( $is_insert ){

				if (class_exists('ListingoProcessEmail')) {
					$email_helper = new ListingoProcessEmail();
					$emailData = array();
					$emailData['amount'] 	= $price_symbol.$amount_to_process;
					$emailData['email'] 	= $db_withdrawal[$db_withdrawal['type']];
					$emailData['method'] 	= esc_html__('PayPal', 'listingo');
					$emailData['user_id'] 	= $user_id;
					$email_helper->process_withdrawal_email($emailData);
				}

				$json['type'] = 'success';
				$json['message'] = esc_html__('Congratulations! transaction has been processed.', 'listingo');
			} else{
				$json['type'] = 'error';
				$json['message'] = esc_html__('An error occurred, please try again later', 'listingo');
			}
		} else{
			$json['type'] = 'error';
			$json['message'] = esc_html__('User didn\'t added withdrawal settings.', 'listingo');
		}
		
		echo json_encode($json);
		die;
		
	}
	add_action('wp_ajax_listingo_process_withdrawal', 'listingo_process_withdrawal');
}


/**
 * @cron update users withdrawal
 * @return {}
 */
if (!function_exists('listingo_process_providers_withdrawal')) {
	add_action('listingo_process_providers_withdrawal', 'listingo_process_providers_withdrawal');
	function listingo_process_providers_withdrawal() {
		global $current_user, $wpdb;
		$month	= date('m');
		$year	= date('Y');

		$query_args = array(
			'role__in' => array('professional', 'business'),
		);

		$user_query = new WP_User_Query($query_args);

		foreach ($user_query->results as $user) {


			$user_id	= $user->ID;
			$offset 	= get_option('gmt_offset') * intval(60) * intval(60);
			$bk_settings	 = listingo_get_booking_settings();
			$price_symbol	 = get_woocommerce_currency_symbol();
			$db_withdrawal 	 = listingo_get_withdrawal_settings($user_id);
			$minamount		 = !empty( $bk_settings['minamount'] ) ? esc_attr( $bk_settings['minamount'] ) : '';


			if( !empty( $db_withdrawal[$db_withdrawal['type']] ) ){
				$status_unpaid	= 'un-paid';
				$table = $wpdb->prefix . 'sp_earnings';

				$earnings_query = $wpdb->get_results(
									$wpdb->prepare(
											"SELECT * FROM $table 
											WHERE $table.user_id = %d
											AND $table.status = %s ", 
											$user_id,
											$status_unpaid
									), ARRAY_A);



				$amount_to_process	= 0;
				if( !empty( $earnings_query ) ){
					foreach( $earnings_query as $kye => $value ){
						$amount_to_process	= $amount_to_process + $value['amount'];

						//Update record
						$update_data = array(
							'status' => 'paid',
						);

						$where_ids['id'] = intval($value['id']);

					}	
				}

				if( isset( $amount_to_process ) && $amount_to_process > $minamount ){
					//Update earning table
					$earnings_table  = $wpdb->prefix . 'sp_withdrawal_history';
					$earnings_data	 = array();

					$earnings_data['user_id'] 		= $user_id;
					$earnings_data['amount'] 		= $amount_to_process;
					$earnings_data['currency_symbol'] 	= $price_symbol;
					$earnings_data['payment_method'] 	= esc_html__('PayPal', 'listingo').'&nbsp;'.esc_html__('to','listingo').'&nbsp;'.$db_withdrawal[$db_withdrawal['type']];

					$earnings_data['processed_date'] 		= current_time('mysql');
					$earnings_data['timestamp'] 			= time();
					$earnings_data['status'] 	= 'paid';
					$earnings_data['year'] 		= date('Y');
					$earnings_data['month'] 	= date('m');

					$is_update	= $wpdb->insert($earnings_table, $earnings_data); //update

					if( $is_update ){
						//update table
						if( !empty( $earnings_query ) ){
							foreach( $earnings_query as $kye => $value ){
								$amount_to_process	= $amount_to_process + $value['amount'];

								//Update record
								$update_data = array(
									'status' => 'paid',
								);

								$wpdb->update($table, $update_data, intval($value['id']));

							}	
						}

						if (class_exists('ListingoProcessEmail')) {
							$email_helper = new ListingoProcessEmail();
							$emailData = array();
							$emailData['amount'] 	= $price_symbol.$amount_to_process;
							$emailData['email'] 	= $db_withdrawal[$db_withdrawal['type']];
							$emailData['method'] 	= esc_html__('PayPal', 'listingo');
							$emailData['user_id'] 	= $user_id;
							$email_helper->process_withdrawal_email($emailData);
						}
					}
				}		
			}
		}
	}
}

/**
 * @upload images to temp folder
 * @return {}
 */
if ( ! function_exists( 'listingo_temp_uploader' ) ) {
	function listingo_temp_uploader() {
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;

		$uploadspath	= wp_upload_dir();
		$folderRalativePath = $uploadspath['baseurl']."/wp-custom-uploader";
		$folderAbsolutePath = $uploadspath['basedir']."/wp-custom-uploader";

		mkdir($folderAbsolutePath, 0755, true);
		
		$temp 			= explode(".", $_FILES["listingo_uploader"]["name"]);
		$filename 		= $_FILES['listingo_uploader']['name'];
		$newfilename	= round(microtime(true)) . '.' . end($temp);

		$target_abs_path 	= $folderAbsolutePath . "/" . $newfilename;
		$target_rel_path    = $folderRalativePath . "/" . $newfilename;
		
		if(move_uploaded_file($_FILES['listingo_uploader']['tmp_name'], $target_abs_path)) {
			$ajax_response = array(
				'type' 			=> 'success',
				'url' 			=> $target_rel_path,
				'filename' 		=> $newfilename,
				'message' 		=> esc_html__('Image deleted.','listingo')	
			);
		} else{
			$ajax_response['type']		=  'error';	
			$ajax_response['message']	= esc_html__('An error occurred, please try again later','listingo');	
		}
		
		
		chmod("{$target_abs_path}", 0755);
		
		echo json_encode($ajax_response);
		exit;

	}
	add_action('wp_ajax_listingo_temp_uploader', 'listingo_temp_uploader');
	add_action('wp_ajax_nopriv_listingo_temp_uploader', 'listingo_temp_uploader');
}


/**
 * @Read images from temp folder and upload
 * @return {}
 */
if ( ! function_exists( 'listingo_crop_and_upload_user_avatar' ) ) {
	function listingo_crop_and_upload_user_avatar() {
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		$parent_post_id	= 0;
		$uploadspath	= wp_upload_dir();
		$folderRalativePath = $uploadspath['baseurl']."/wp-custom-uploader";
		$folderAbsolutePath = $uploadspath['basedir']."/wp-custom-uploader";

		$filename = $_REQUEST[ 'filename' ];
		
		$target_path = $folderAbsolutePath . "/" . $filename;
		if(move_uploaded_file($_FILES['listingo_uploader']['tmp_name'], $target_path)) {
			
			$file = $folderAbsolutePath.'/'.$filename; 
			$response	= wp_remote_get($file);
			$filedata   = wp_remote_retrieve_body( $response );
			
			$upload_file = wp_upload_bits($filename, null,$filedata );

			if (!$upload_file['error']) {
				$wp_filetype = wp_check_filetype($filename, null );
				$attachment = array(
					'post_mime_type' 	=> $wp_filetype['type'],
					'post_parent' 		=> $parent_post_id,
					'post_title' 		=> preg_replace('/\.[^.]+$/', '', $filename),
					'post_content' 		=> '',
					'post_status' 		=> 'inherit'
				);

				$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
				if (!is_wp_error($attachment_id)) {
					require_once(ABSPATH . "wp-admin" . '/includes/image.php');
					$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
					wp_update_attachment_metadata( $attachment_id,  $attachment_data );

					unlink($target_path);
					
					if( is_user_logged_in() ){
						update_user_meta($user_identity, 'userprofile_media', $attachment_id);
						$avatar = apply_filters(
								'listingo_get_user_avatar_filter',
								 listingo_get_user_avatar(array('width'=>270,'height'=>270), $user_identity) //size width,height
							);
					} else{
						$avatar = !empty( $upload_file['url'] ) ? $upload_file['url'] : '';
					}

					$ajax_response = array(
						'type' 			=> 'success',
						'url' 			=> $avatar,
						'attachment_id' => $attachment_id,
						'filename' 		=> '',
						'message' 		=> esc_html__('Image cropped and uploaded.','listingo')	
					);
					
					echo json_encode($ajax_response); 
					die;
				} else{
					$ajax_response = array(
						'type' 			=> 'error',
						'url' 			=> '',
						'filename' 		=> '',
						'attachment_id' => '',
						'message' 		=> esc_html__('An error occurred, please try again later','listingo')
					);
				}
			}
			
		} else{
			$ajax_response = array(
				'type' 			=> 'error',
				'url' 			=> '',
				'filename' 		=> '',
				'attachment_id' => '',
				'message' 		=> esc_html__('An error occurred, please try again later','listingo')
			);
		}
		
		
		echo json_encode($ajax_response); 
		die;

	}
	add_action('wp_ajax_listingo_crop_and_upload_user_avatar', 'listingo_crop_and_upload_user_avatar');
	add_action('wp_ajax_nopriv_listingo_crop_and_upload_user_avatar', 'listingo_crop_and_upload_user_avatar');
}

/**
 * @Read images from temp folder and upload
 * @return {}
 */
if ( ! function_exists( 'listingo_get_dashboard_menu' ) ) {
	function listingo_get_dashboard_menu() {
		global $current_user;
		
		$menu_settings = get_option( 'sp_dashboard_menu_settings' );
		
		$list	= array(
			'request'	=> array(
				'title' => esc_html__('Request to change category','listingo')
			),
			'insights'	=> array(
				'title' => esc_html__('Insights','listingo')
			),
			'forum'	=> array(
				'title' => esc_html__('Go to forum profile','listingo')
			),
			'profile_settings'	=> array(
				'title' => esc_html__('Profile Settings','listingo')
			),
			'my_appointments'	=> array(
				'title' => esc_html__('My Appointments','listingo')
			),
			'business_hours'	=> array(
				'title' => esc_html__('Business Hours','listingo')
			),
			'services'	=> array(
				'title' => esc_html__('Manage Services','listingo')
			),
			'teams'	=> array(
				'title' => esc_html__('Manage Team Members','listingo')
			),
			'jobs'	=> array(
				'title' => esc_html__('Manage Jobs','listingo')
			),
			'articles'	=> array(
				'title' => esc_html__('Manage Articles','listingo')
			),
			'ads'	=> array(
				'title' => esc_html__('Manage Ads','listingo')
			),
			'private_chat'	=> array(
				'title' => esc_html__('Inbox','listingo')
			),
			'appointments'	=> array(
				'title' => esc_html__('Manage Appointments','listingo')
			),
			'favorite'	=> array(
				'title' => esc_html__('Favourite Listing','listingo')
			),
			'packages'	=> array(
				'title' => esc_html__('Update Package','listingo')
			),
			'security'	=> array(
				'title' => esc_html__('Security Settings','listingo')
			),
			'privacy'	=> array(
				'title' => esc_html__('Privacy Settings','listingo')
			),
			'withdrawal'	=> array(
				'title' => esc_html__('Earning Settings','listingo')
			),
			'page_design'	=> array(
				'title' => esc_html__('Profile Page Design','listingo')
			),
			'logout'	=> array(
				'title' => esc_html__('Logout','listingo')
			)
		);
		
		$final_list	= !empty( $menu_settings ) ? $menu_settings : $list;
		$menu_list 	= apply_filters('listingo_get_extra_dashboard_menu',$final_list);
		return $menu_list;
	}
	add_filter('listingo_get_dashboard_menu', 'listingo_get_dashboard_menu',10,1);
}