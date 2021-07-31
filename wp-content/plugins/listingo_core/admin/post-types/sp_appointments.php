<?php
/**
 * File Type: Appointments
 */
if (!class_exists('SP_Appointments')) {

    class SP_Appointments {

        public function __construct() {
            global $pagenow;
            add_action('init', array(&$this, 'init_appointment'));
            add_action('add_meta_boxes', array(&$this, 'tg_appointments_add_meta_box'), 10, 1);
            add_filter('manage_sp_appointments_posts_columns', array(&$this, 'appointments_columns_add'));
            add_action('manage_sp_appointments_posts_custom_column', array(&$this, 'appointments_columns'), 10, 2);
        }

        /**
         * @Init Post Type
         * @return {post}
         */
        public function init_appointment() {
            $this->prepare_post_type();
        }

        /**
         * @Prepare Post Type
         * @return {}
         */
        public function prepare_post_type() {
			$apt_slug	= listingo_get_theme_settings('apt_slug');
			$apt_slug	=  !empty( $apt_slug ) ? $apt_slug : 'appointment';
			
            $labels = array(
                'name' => esc_html__('Appointments', 'listingo_core'),
                'all_items' => esc_html__('Appointments', 'listingo_core'),
                'singular_name' => esc_html__('Appointment', 'listingo_core'),
                'add_new' => esc_html__('Add Appointment', 'listingo_core'),
                'add_new_item' => esc_html__('Add New Appointment', 'listingo_core'),
                'edit' => esc_html__('Edit', 'listingo_core'),
                'edit_item' => esc_html__('Edit Appointment', 'listingo_core'),
                'new_item' => esc_html__('New Appointment', 'listingo_core'),
                'view' => esc_html__('View Appointment', 'listingo_core'),
                'view_item' => esc_html__('View Appointment', 'listingo_core'),
                'search_items' => esc_html__('Search Appointment', 'listingo_core'),
                'not_found' => esc_html__('No Appointment found', 'listingo_core'),
                'not_found_in_trash' => esc_html__('No Appointment found in trash', 'listingo_core'),
                'parent' => esc_html__('Parent Appointment', 'listingo_core'),
            );
            $args = array(
                'capabilities' => array('create_posts' => false), //Hide add New Button
                'labels' => $labels,
                'description' => esc_html__('', 'listingo_core'),
                'public' => true,
                'supports' => array('title'),
                'show_ui' => true,
                'capability_type' => 'post',
                'show_in_nav_menus' => false,
                'map_meta_cap' => true,
                'publicly_queryable' => true,
                'show_in_menu' => 'edit.php?post_type=sp_categories',
                'exclude_from_search' => false,
                'hierarchical' => false,
                'menu_position' => 10,
                'rewrite' => array('slug' => $apt_slug, 'with_front' => true),
                'query_var' => false,
                'has_archive' => false,
            );
            register_post_type('sp_appointments', $args);
        }

        /**
         * @Prepare Columns
         * @return {post}
         */
        public function appointments_columns_add($columns) {
            unset($columns['date']);
            $columns['apt_from'] = esc_html__('Appointment From', 'listingo_core');
            $columns['apt_to'] = esc_html__('Appointment To', 'listingo_core');
            $columns['apt_contact'] = esc_html__('Contact Number', 'listingo_core');

            return $columns;
        }

        /**
         * @Get Columns
         * @return {}
         */
        public function appointments_columns($name) {
            global $post;

            $apt_from = '';
            $apt_to = '';
            $apt_contact = '';

            $apt_from = get_post_meta($post->ID, 'apt_user_from', true);
            $apt_to = get_post_meta($post->ID, 'apt_user_to', true);
            $apt_contact = get_post_meta($post->ID, 'apt_mobile', true);
            $apt_from_user = get_user_by('id', intval($apt_from));
            $apt_to_user = get_user_by('id', intval($apt_to));


            switch ($name) {
                case 'apt_from':
                    if (isset($apt_from_user->data) && !empty($apt_from_user->data)) {
                        echo esc_attr($apt_from_user->data->display_name);
                    }
                    break;
                case 'apt_to':
                    if (isset($apt_to_user->data) && !empty($apt_to_user->data)) {
                        echo esc_attr($apt_to_user->data->display_name);
                    }
                    break;
                case 'apt_contact':
                    echo ( $apt_contact );
                    break;
            }
        }

        /**
         * @Init Meta Boxes
         * @return {post}
         */
        public function tg_appointments_add_meta_box($post_type) {
            if ($post_type == 'sp_appointments') {
                add_meta_box(
                        'tg_appointments_info', esc_html__('Appointment Info', 'listingo_core'), array(&$this, 'listingo_meta_box_appointmentinfo'), 'sp_appointments', 'side', 'high'
                );
            }

            if ($post_type == 'sp_appointments') {
                add_meta_box(
                        'tg_appointments_detail', esc_html__('Appointment Detail', 'listingo_core'), array(&$this, 'listingo_appointment_detail'), 'sp_appointments', 'normal', 'high'
                );
            }
        }

        /**
         * @Init Appointment detail
         * @return {post}
         */
        public function listingo_appointment_detail() {
            global $post;

            if (!empty($post->ID) && isset($_GET['post']) && !empty($_GET['post'])) {

                $apt_status 		= get_post_status($post->ID);
                $apt_services 		= get_post_meta($post->ID, 'apt_services', true);
                $apt_types 			= get_post_meta($post->ID, 'apt_types', true);
                $apt_reasons 		= get_post_meta($post->ID, 'apt_reasons', true);
                $apt_description 	= get_post_meta($post->ID, 'apt_description', true);
                $apt_name 			= get_post_meta($post->ID, 'apt_name', true);
                $apt_mobile 		= get_post_meta($post->ID, 'apt_mobile', true);
                $apt_email 			= get_post_meta($post->ID, 'apt_email', true);
                $apt_currency_symbol= get_post_meta($post->ID, 'apt_currency_symbol', true);
                $apt_number 		= get_post_meta($post->ID, 'apt_number', true);
                $apt_user_from 		= get_post_meta($post->ID, 'apt_user_from', true);
                $apt_user_to 		= get_post_meta($post->ID, 'apt_user_to', true);

                $booking_services 	= get_user_meta($apt_user_to, 'profile_services', true);
                $booking_types 		= get_user_meta($apt_user_to, 'appointment_types', true);
                $booking_reasons 	= get_user_meta($apt_user_to, 'appointment_reasons', true);

                $apt_time 		= get_post_meta($post->ID, 'apt_time', true);
                $apt_date 		= get_post_meta($post->ID, 'apt_date', true);
                $apt_user_from  = get_user_by('id', intval($apt_user_from));
                $apt_user_to 	= get_user_by('id', intval($apt_user_to));

                $date_format 	= get_option('date_format');
                $time_format 	= get_option('time_format');
                $time 			= explode('-', $apt_time);
            } else {
                $apt_services 		= esc_html__('NILL', 'listingo_core');
                $apt_types 			= esc_html__('NILL', 'listingo_core');
                $apt_reasons 		= esc_html__('NILL', 'listingo_core');
                $apt_description 	= esc_html__('NILL', 'listingo_core');
                $apt_name 			= esc_html__('NILL', 'listingo_core');
                $apt_mobile 		= esc_html__('NILL', 'listingo_core');
                $apt_email 			= esc_html__('NILL', 'listingo_core');
                $apt_number 		= esc_html__('NILL', 'listingo_core');
                $apt_user_from 		= esc_html__('NILL', 'listingo_core');
                $apt_user_to 		= esc_html__('NILL', 'listingo_core');
                $apt_time 			= esc_html__('NILL', 'listingo_core');
                $apt_date 			= esc_html__('NILL', 'listingo_core');
            }
			
			if( !empty($apt_status) && $apt_status == 'pending' ){
				 $apt_status 	= esc_html__('Pending', 'listingo_core');
			} else if( !empty($apt_status) && $apt_status == 'publish' ){
				$apt_status 	= esc_html__('Completed', 'listingo_core');
			} else{
				$apt_status 	= esc_html__('Pending', 'listingo_core');
			}
            ?>
            <ul class="invoice-info">
                <li>
                    <strong><?php esc_html_e('Tracking id : ', 'listingo_core'); ?></strong>
                    <span><?php echo esc_attr($apt_number); ?></span>
                </li>
                <li>
                    <strong><?php esc_html_e('Appointment Date : ', 'listingo_core'); ?></strong>
                    <span><?php echo date($date_format, $apt_date); ?></span>
                </li>
                <?php if (!empty($booking_services[$apt_services])) { ?>
                    <li>
                        <strong><?php esc_html_e('Appointment Service : ', 'listingo_core'); ?></strong>
                        <span><?php echo esc_attr($booking_services[$apt_services]['title']); ?></span>
                    </li>
                <?php } ?>
                <?php if (!empty($booking_services[$apt_services])) { ?>
                    <li>
                        <strong><?php esc_html_e('Appointment Fee : ', 'listingo_core'); ?></strong>
                        <span><?php echo esc_attr($apt_currency_symbol); ?><?php echo esc_attr($booking_services[$apt_services]['price']); ?></span>
                    </li>
                <?php } ?>
                <li>
                    <strong><?php esc_html_e('Contact Number : ', 'listingo_core'); ?></strong>
                    <span><?php echo esc_attr($apt_mobile); ?></span>
                </li>
                <?php if (!empty($apt_user_from->data)) { ?>
                    <li>
                        <strong><?php esc_html_e('User From : ', 'listingo_core'); ?></strong>
                        <span><a href="<?php echo get_edit_user_link($apt_user_from->data->ID); ?>" target="_blank" title="<?php esc_html__('Click for user details', 'listingo_core'); ?>"><?php echo esc_attr(ucwords($apt_user_from->data->display_name)); ?></a></span>
                    </li>
                <?php } ?>
                <?php if (!empty($apt_user_to->data)) { ?>
                    <li>
                        <strong><?php esc_html_e('User To : ', 'listingo_core'); ?></strong>
                        <span><a href="<?php echo get_edit_user_link($apt_user_to->data->ID); ?>" target="_blank" title="<?php esc_html__('Click for user details', 'listingo_core'); ?>"><?php echo esc_attr(ucwords($apt_user_to->data->display_name)); ?></a></span>
                    </li>
                <?php } ?>
                <?php if (!empty($booking_types[$apt_types])) { ?>
                    <li>
                        <strong><?php esc_html_e('Appointment Type : ', 'listingo_core'); ?></strong>
                        <span><?php echo esc_attr($booking_types[$apt_types]); ?></span>
                    </li>
                <?php } ?>
                <?php if (!empty($booking_reasons[$apt_reasons])) { ?>
                    <li>
                        <strong><?php esc_html_e('Reason For Visit : ', 'listingo_core'); ?></strong>
                        <span><?php echo esc_attr($booking_reasons[$apt_reasons]); ?></span>
                    </li>
                <?php } ?>
                <?php if (!empty($apt_status)) { ?>
                    <li>
                        <strong><?php esc_html_e('Booking Status : ', 'listingo_core'); ?></strong>
                        <span><?php echo esc_attr(ucwords($apt_status)); ?></span>
                    </li>
                <?php } ?>
                <?php if (!empty($time[0]) && !empty($time[1])) { ?>
                    <li>
                        <strong><?php esc_html_e('Metting Time : ', 'listingo_core'); ?></strong>
                        <span><?php echo date($time_format, strtotime('2016-01-01 ' . $time[0])); ?>&nbsp;-&nbsp;<?php echo date($time_format, strtotime('2016-01-01 ' . $time[1])); ?></span>
                    </li>
                <?php } ?>
                <li>
                    <strong><?php esc_html_e('Note : ', 'listingo_core'); ?></strong>
                    <span><?php echo ($apt_description); ?></span>
                </li>
            </ul>
            <?php
        }

        /**
         * @Init Appointment info
         * @return {post}
         */
        public function listingo_meta_box_appointmentinfo() {
            global $post;

            if (function_exists('fw_get_db_settings_option')) {
                $bk_code = get_post_meta($post->ID, 'apt_number', true);
                $bk_code = !empty($bk_code) ? $bk_code : esc_html__('NILL', 'listingo_core');
            } else {
                $bk_code = esc_html__('NILL', 'listingo_core');
            }
            ?>
            <ul class="invoice-info side-panel-info">
                <li>
                    <strong><?php esc_html_e('Appointment Code : ', 'listingo_core'); ?></strong>
                    <span><?php echo esc_attr($bk_code); ?></span>
                </li>
            </ul>
            <?php
        }

    }

    new SP_Appointments();
}