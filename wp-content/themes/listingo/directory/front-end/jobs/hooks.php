<?php
/**
 *
 * Jobs Hooks
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
/**
 * @Add/Edit job
 * @return {}
 */
if (!function_exists('listingo_process_job')) {

    function listingo_process_job() {
        global $current_user, $wp_roles, $userdata;
		$json	=  array();
        $type = !empty($_POST['type']) ? esc_attr($_POST['type']) : '';
        $current = !empty($_POST['current']) ? esc_attr($_POST['current']) : '';
		
		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
        $do_check = check_ajax_referer('listingo_job_nounce', 'listingo_job_nounce', false);
        if ($do_check == false) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('No kiddies please!', 'listingo');
            echo json_encode($json);
            die;
        }

        $validations = array(
            'category' 		=> esc_html__('Category is required.', 'listingo'),
            'title' 		=> esc_html__('Title is required.', 'listingo'),
            'expirydate' 	=> esc_html__('Expiry date is required.', 'listingo'),
            'career_level'  => esc_html__('Career level is required.', 'listingo'),
            'experience' 	=> esc_html__('Experience is required.', 'listingo'),
            'salary' 		=> esc_html__('Salary/Cost is required.', 'listingo'),
            'job_type' 		=> esc_html__('Job type is required.', 'listingo'),
        );

        foreach ($validations as $key => $value) {
            if (empty($_POST['job'][$key])) {
                $json['type'] = 'error';
                $json['message'] = $value;
                echo json_encode($json);
                die;
            }
        }

        $title = !empty($_POST['job']['title']) ? esc_attr($_POST['job']['title']) : esc_html__('unnamed', 'listingo');

        $job_detail 		= wp_kses_post($_POST['job_detail']);
        $job_requirements 	= wp_kses_post($_POST['job_requirements']);
        $benifits 			= listingo_sanitize_array($_POST['benifits']);
        $expirydate 		= !empty($_POST['job']['expirydate']) ? esc_attr($_POST['job']['expirydate']) : '';
        $career_level 		= !empty($_POST['job']['career_level']) ? esc_attr($_POST['job']['career_level']) : '';
        $job_type 			= !empty($_POST['job']['job_type']) ? esc_attr($_POST['job']['job_type']) : '';
        $experience 		= !empty($_POST['job']['experience']) ? esc_attr($_POST['job']['experience']) : '';
        $salary 			= !empty($_POST['job']['salary']) ? esc_attr($_POST['job']['salary']) : '';
        $qualification 		= !empty($_POST['job']['qualification']) ? esc_attr($_POST['job']['qualification']) : '';
		
		$category	= array();
		$author		= array();
		
        $category[] = !empty($_POST['job']['category']) ? esc_attr($_POST['job']['category']) : '';
        $author[] 	= intval($current_user->ID);

        $sub_category_key = !empty($_POST['job']['sub_category']) ? esc_attr($_POST['job']['sub_category']) : '';

        $languages = !empty($_POST['languages']) ? listingo_sanitize_array($_POST['languages']) : '';
        $languages_array = array();
        $languages_search_array = array();

        if (!empty($languages)) {
            foreach ($languages as $key => $value) {
                $language = get_term_by('slug', $value, 'languages');
                if (!empty($language->term_id)) {
                    $languages_array[$key] = $language->term_id;
                    $languages_search_array[$key] = $value;
                }
            }
        }

        $sub_category = array();
        if (!empty($sub_category_key)) {
            $cat = get_term_by('slug', $sub_category_key, 'sub_category');
            if (!empty($cat->term_id)) {
                $sub_category[] = $cat->term_id;
            }
        }

        $dir_profile_page = '';
        if (function_exists('fw_get_db_settings_option')) {
            $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
        }

        $profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';

        //Location Address Data
        if (empty($_POST['location']['address'])) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Address field is required.', 'listingo');
            echo json_encode($json);
            die;
        }
		
        $address = !empty($_POST['location']['address']) ? esc_attr($_POST['location']['address']) : '';
        $longitude = !empty($_POST['location']['longitude']) ? esc_attr($_POST['location']['longitude']) : '-0.1262362';
        $latitude = !empty($_POST['location']['latitude']) ? esc_attr($_POST['location']['latitude']) : '51.5001524';
        $phone = !empty($_POST['location']['phone']) ? esc_attr($_POST['location']['phone']) : '';
        $fax = !empty($_POST['location']['fax']) ? esc_attr($_POST['location']['fax']) : '';
        $email = !empty($_POST['location']['email']) ? esc_attr($_POST['location']['email']) : '';
        $url = !empty($_POST['location']['url']) ? esc_attr($_POST['location']['url']) : '';

        //add/edit job
        if (isset($type) && $type === 'add') {
            $job_post = array(
                'post_title' 	=> $title,
                'post_status' 	=> 'publish',
                'post_content'  => $job_detail,
                'post_author' 	=> $current_user->ID,
                'post_type' 	=> 'sp_jobs',
                'post_date' 	=> current_time( 'mysql' )
            );
			
            $post_id = wp_insert_post($job_post);
            $return_url = Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'jobs', $current_user->ID, 'true', 'listing');
			
			$json['return_url']	= htmlspecialchars_decode($return_url);
			
			if (class_exists('ListingoProcessEmail')) {
				$meta_query_args	   = array();
				$emaildata	           = array();				 
				$jobcategory	= !empty( $_POST['job']['category'] ) ? intval( $_POST['job']['category'] ) : '';
				$query_args = array(
					'role__in' => array('professional', 'business'),
				);
				 
				$meta_query_args[] = array(
					'key' 		=> 'category',
					'value' 	=> $jobcategory,
					'compare' 	=> '=',
				);
				 
				if (!empty($meta_query_args)) {
					$query_relation = array('relation' => 'AND',);
					$meta_query_args = array_merge($query_relation, $meta_query_args);
					$query_args['meta_query'] = $meta_query_args;
				}
				
				$user_query = get_users($query_args);
				if( !empty( $user_query ) ){
					foreach( $user_query as $key => $provider ){
						$username = listingo_get_username($provider->ID);
						$emaildata['user_email']	= $provider->user_email;
						$emaildata['username']	    = $username;
                        $emaildata['job_title']     = $title;
                        $emaildata['salary']        = $salary;
                        $emaildata['description']   = $job_detail;
                        $emaildata['apply_link']    = get_permalink($post_id);
						$email_helper               = new ListingoProcessEmail();
						$email_helper->process_send_email_to_related_providers($emaildata);
					}
				}
			}         
        
		} elseif (isset($type) && $type === 'update' && !empty($current)) {
            $post_author = get_post_field('post_author', $current);
            if (intval($current_user->ID) === intval($post_author)) {
                $job_post = array(
                    'ID' => $current,
                    'post_title' => $title,
                    'post_content' => $job_detail,
                );

                wp_update_post($job_post);
                $post_id = $current;
            } else {
                $json['type'] = 'error';
                $json['message'] = esc_html__('An error occurred, please try again later', 'listingo');
                echo json_encode($json);
                die;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = esc_html__('An error occurred, please try again later', 'listingo');
            echo json_encode($json);
            die;
        }

        //update job meta
        $job_meta = array(
            'category' 		=> $category,
            'sub_category'  => $sub_category,
            'author' 		=> $author,
            'expirydate' 	=> $expirydate,
            'career_level'  => $career_level,
            'job_type' 		=> $job_type,
            'experience' 	=> $experience,
            'salary'		=> $salary,
            'qualification' => $qualification,
            'languages' 	=> $languages_array,
            'requirements'  => $job_requirements,
            'benifits' 		=> $benifits,
            'address' 		=> $address,
            'address_latitude'  => $latitude,
            'address_longitude' => $longitude,
            'phone' 		=> $phone,
            'fax' 			=> $fax,
            'email' 		=> $email,
            'url' 			=> $url
        );

        $new_values = $job_meta;
        if (!empty($post_id)) {
            fw_set_db_post_option($post_id, null, $new_values);
        }

        if (!empty($category[0])) {
            $postdata = get_post($category[0]);
            if (!empty($postdata)) {
                $job_meta['category'] = $postdata->post_name;
            }
        }

        $job_meta['sub_category']   = $sub_category_key;
        $job_meta['languages'] 		= $languages_search_array;
        $job_meta['author'] 		= $current_user->ID;

        //Update post meta for searching
        foreach ($job_meta as $key => $value) {
            update_post_meta($post_id, $key, $value);
        }

        $json['type'] = 'success';
        $json['message'] = esc_html__('Job updated successfully.', 'listingo');
        echo json_encode($json);
        die;
    }

    add_action('wp_ajax_listingo_process_job', 'listingo_process_job');
    add_action('wp_ajax_nopriv_listingo_process_job', 'listingo_process_job');
}

/**
 * @delete job
 * @return json
 */
if (!function_exists('listingo_delete_job')) {

    function listingo_delete_job() {
        global $current_user, $wp_roles, $userdata;

        $post_id = intval($_POST['id']);
        $post_author = get_post_field('post_author', $post_id);

        if (!empty($post_id) && intval($current_user->ID) === intval($post_author)) {
            wp_delete_post($post_id);
            $json['type'] = 'success';
            $json['message'] = esc_html__('Job deleted successfully.', 'listingo');
            echo json_encode($json);
            die;
        } else {
            $json['type'] = 'error';
            $json['message'] = esc_html__('An error occurred, please try again later', 'listingo');
            echo json_encode($json);
            die;
        }
    }

    add_action('wp_ajax_listingo_delete_job', 'listingo_delete_job');
    add_action('wp_ajax_nopriv_listingo_delete_job', 'listingo_delete_job');
}


/**
 * @get job search filters
 * @return html
 */
if (!function_exists('listingo_get_job_search_filtrs')) {

    function listingo_get_job_search_filtrs() {
        $languages_list 	= listingo_get_taxonomy_array('languages');
        $get_languages 		= !empty($_GET['languages']) ? $_GET['languages'] : array();
        $get_job_types 		= !empty($_GET['job_type']) ? $_GET['job_type'] : array();
        $list_job_types 	= listingo_get_job_type();
        $experiences 		= listingo_get_experience_list();
        $get_experiences 	= !empty($_GET['experience']) ? $_GET['experience'] : array();
        ob_start();
        ?>
        <fieldset class="subcat-search-wrap"></fieldset>
        <fieldset class="jobtypes-search-wrap">
            <h4><?php esc_html_e('Filter By Job Type', 'listingo'); ?></h4>
            <div class="tg-checkboxgroup">
                <?php
                if (!empty($list_job_types)) {
                    foreach ($list_job_types as $key => $value) {
                        $checked = '';
                        if (!empty($get_job_types) && in_array($key, $get_job_types)) {
                            $checked = 'checked';
                        }
                        ?>
                        <span class="tg-checkbox">
                            <input <?php echo esc_attr($checked); ?> type="checkbox" id="tg-<?php echo esc_attr($key); ?>" name="job_type[]" value="<?php echo esc_attr($key); ?>">
                            <label for="tg-<?php echo esc_attr($key); ?>"><?php echo esc_attr($value); ?></label>
                        </span>
                        <?php
                    }
                }
                ?>
                <?php if (listingo_count_items($list_job_types) > 5) { ?>
                    <a href="javascript:;" class="sp-loadMore"><?php esc_html_e('Load More', 'listingo'); ?></a>
                <?php } ?>
                <?php  wp_add_inline_script('listingo_callbacks', "_show_hide_list('.jobtypes-search-wrap');", 'after');?>
            </div>
        </fieldset>
        <fieldset class="experience-search-wrap">
            <h4><?php esc_html_e('Filter By Experience', 'listingo'); ?></h4>
            <div class="tg-checkboxgroup data-list">
                <?php
                if (!empty($experiences)) {
                    foreach ($experiences as $key => $value) {
                        $checked = '';
                        if (!empty($get_experiences) && in_array($key, $get_experiences)) {
                            $checked = 'checked';
                        }
                        ?>
                        <span class="tg-checkbox sp-load-item">
                            <input <?php echo esc_attr($checked); ?> type="checkbox" id="tg-<?php echo esc_attr($key); ?>" name="experience[]" value="<?php echo esc_attr($key); ?>">
                            <label for="tg-<?php echo esc_attr($key); ?>"><?php echo esc_attr($value); ?></label>
                        </span>
                        <?php
                    }
                }
                ?>
                <?php if (listingo_count_items($experiences) > 5) { ?>
                    <a href="javascript:;" class="sp-loadMore"><?php esc_html_e('Load More', 'listingo'); ?></a>
                <?php } ?>
                <?php
                wp_add_inline_script('listingo_callbacks', "_show_hide_list('.experience-search-wrap');", 'after');
                ?>
            </div>
        </fieldset>
        <?php if (!empty($languages_list)) { ?>
            <fieldset class="lang-search-wrap">
                <h4><?php esc_html_e('Filter By Language', 'listingo'); ?></h4>
                <div class="tg-checkboxgroup data-list">
                    <?php
                    foreach ($languages_list as $pterm) {
                        $checked = '';
                        if (!empty($get_languages) && in_array($pterm->slug, $get_languages)) {
                            $checked = 'checked';
                        }
                        ?>
                        <span class="tg-checkbox sp-load-item">
                            <input type="checkbox" <?php echo esc_attr($checked); ?> id="lang-<?php echo esc_attr($pterm->slug); ?>" name="languages[]" value="<?php echo esc_attr($pterm->slug); ?>">
                            <label for="lang-<?php echo esc_attr($pterm->slug); ?>"><?php echo esc_attr($pterm->name); ?></label>
                        </span>
                        <?php
                    }
                    ?>
                    <?php if (listingo_count_items($languages_list) > 10) { ?>
                        <a href="javascript:;" class="sp-loadMore"><?php esc_html_e('Load More', 'listingo'); ?></a>
                    <?php } ?>
                </div>
                <?php
                wp_add_inline_script('listingo_callbacks', "_show_hide_list('.lang-search-wrap');", 'after');
                ?>
            </fieldset>
        <?php } ?>
        <fieldset>
            <button class="tg-btn" type="submit"><?php esc_html_e('Apply', 'listingo'); ?></button>
        </fieldset>
        <?php
        echo ob_get_clean();
    }

    add_action('listingo_get_job_search_filtrs', 'listingo_get_job_search_filtrs');
}

/**
 * @get sortby field
 * @return html
 */
if (!function_exists('listingo_get_default_sortby')) {

    function listingo_get_default_sortby() {
        ob_start();
        ?>
        <div class="tg-select">
            <select name="sortby" class="sp-sortby">
                <option value=""><?php esc_html_e('Sort By', 'listingo'); ?></option>
                <option value="ID" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'ID' ? 'selected' : ''; ?>><?php esc_html_e('ID', 'listingo'); ?></option>
                <option value="author" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'author' ? 'selected' : ''; ?>><?php esc_html_e('Author', 'listingo'); ?></option>
                <option value="title" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'title' ? 'selected' : ''; ?>><?php esc_html_e('Title', 'listingo'); ?></option>
                <option value="date" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'date' ? 'selected' : ''; ?>><?php esc_html_e('Date', 'listingo'); ?></option>
                <option value="modified" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'modified' ? 'selected' : ''; ?>><?php esc_html_e('Modified', 'listingo'); ?></option>
                <option value="rand" <?php echo isset($_GET['sortby']) && $_GET['sortby'] == 'rand' ? 'selected' : ''; ?>><?php esc_html_e('Random', 'listingo'); ?></option>
            </select>
        </div>
        <?php
        echo ob_get_clean();
    }

    add_action('listingo_get_default_sortby', 'listingo_get_default_sortby');
}


/**
 * @Apply Job
 * @return 
 */
if (!function_exists('listingo_apply_job_form')) {

    function listingo_apply_job_form() {
        global $current_user;
        $user_id = $current_user->ID;

        $json = array();
        $do_check = check_ajax_referer('sp_dashboard_contact_form', 'security', false);
        if ($do_check == false) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('No kiddies please.', 'listingo');
            echo json_encode($json);
            die;
        }
        
        $validations = array(
            'name' => esc_html__('Name is required.', 'listingo'),
            'dob' => esc_html__('Date of Birth is required.', 'listingo'),
            'email' => esc_html__('Email is required.', 'listingo'),
            'phone' => esc_html__('Phone is required.', 'listingo'),
            'education' => esc_html__('Education is required.', 'listingo'),
            'status' => esc_html__('Current job status is required.', 'listingo'),
            'address' => esc_html__('Address is required', 'listingo'),
            'description' => esc_html__('Content should not be empty', 'listingo'),
            'job' => esc_html__('No! kiddies please.', 'listingo')
        );

        $emailData  =  array();
        foreach ($validations as $key => $value) {
            if (empty($_POST['apply'][$key])) {

                $json['type'] = 'error';
                $json['message'] = $validations[$key];
                echo json_encode($json);
                die;
            }

            $emailData[$key] = esc_attr( $_POST['apply'][$key] );            

        }

        $email = $emailData['email'];
		
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Email addrress is not valid', 'listingo');
            echo json_encode($json);
            die; 
        }           

        if (class_exists('ListingoProcessEmail')) {
            $email_helper = new ListingoProcessEmail();
            $email_helper->process_applyjob_user($emailData);
            $email_helper->process_applyjob_author($emailData);
            $email_helper->process_applyjob_admin($emailData);

            $json['type'] = 'success';
            $json['message'] = esc_html__('Thank you for applying.', 'listingo');
            echo json_encode($json);
            die;
        } else {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Some thing went wrong, kindly try again.', 'listingo');
            echo json_encode($json);
            die;
        }

            
    }

    add_action('wp_ajax_listingo_apply_job_form', 'listingo_apply_job_form');
    add_action('wp_ajax_nopriv_listingo_apply_job_form', 'listingo_apply_job_form');
}