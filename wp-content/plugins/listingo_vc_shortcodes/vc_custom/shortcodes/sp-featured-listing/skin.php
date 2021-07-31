<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Blog Posts
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Featured_Listing')) {

    class SC_VC_Skin_Listingo_Featured_Listing extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_featured_listing", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {
            extract(shortcode_atts(array(
                "section_heading" => '',
                "posts_by" => 'by_catgories',
                "categories" => '',
                "specific_posts" => '',
                "no_of_posts" => 10,
                "show_pagination" => '',
                "order" => '',
                "orderby" => '',
                "custom_columns" => '',
                "column_lg" => '',
                "column_md" => '',
                "column_sm" => '',
                "column_xs" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_featured_listing', $args);

            $classes[] = $custom_classes;
            $classes[] = $css_class;

            if (isset($custom_columns) && $custom_columns === 'yes') {
                $item_classes = $column_xs . ' ' . $column_sm . ' ' . $column_md . ' ' . $column_lg;
            } else {
                $item_classes = 'col-xs-6 col-sm-6 col-md-4 col-lg-4';
            }

            //testing starts
            $today = time();
            $pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
            $pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
            //paged works on single pages, page - works on homepage
            $paged = max($pg_page, $pg_paged);

            if (isset($posts_by) && $posts_by === 'by_posts' && !empty($specific_posts)
            ) {
                $users_list = explode(',', $specific_posts);
            } else {
                $cat_sepration = array();
                if (isset($categories) && !empty($categories)) {
                    $cat_sepration = explode(',', $categories);
                }
            }

            $show_users = !empty($no_of_posts) ? $no_of_posts : 9;
            $order = !empty($order) ? $order : 'DESC';
            $show_pagination = !empty($show_pagination) ? $show_pagination : '';
            $uniq_flag = rand(1, 99999);
            $limit = (int) $show_users;

            $query_args = array(
                'role__in' => array('professional', 'business'),
                'order' => $order,
            );

            if (!empty($cat_sepration)) {
                foreach ($cat_sepration as $key => $value) {
                    $meta_category[] = array(
                        'key' => 'category',
                        'value' => $value,
                        'compare' => '='
                    );
                }
            }

            //Verify user
            $meta_query_args[] = array(
                'key' => 'verify_user',
                'value' => 'on',
                'compare' => '='
            );

            //active users filter
            $meta_query_args[] = array(
                'key' => 'activation_status',
                'value' => 'active',
                'compare' => '='
            );

            if (!empty($meta_query_args)) {
                $query_relation = array('relation' => 'AND',);
                $meta_query_args = array_merge($query_relation, $meta_query_args);
                $query_args['meta_query'] = $meta_query_args;
            }

            //By Categories
            if (!empty($meta_category)) {
                $query_relations = array('relation' => 'OR',);
                $meta_query_args = array_merge($query_relations, $meta_category);
                $query_args['meta_query'][] = $meta_query_args;
            }

            //Featured
            $expiry_args = array(
                'key' => 'subscription_featured_expiry',
                'value' => 0,
                'type' => 'numeric',
                'compare' => '>'
            );

            $query_args['meta_query'][] = $expiry_args;
            $query_args['meta_key'] = 'subscription_featured_expiry';
            $query_args['orderby'] = 'meta_value';

            //By users
            if (!empty($users_list)) {
                $query_args['include'] = $users_list;
            }

            $user_query = new WP_User_Query($query_args);
            $total_users = $user_query->total_users;

            if (!empty($total_users) && !empty($limit) && $total_users > $limit && (!empty($show_pagination) && $show_pagination === 'on' )) {
                $offset = ($paged - 1) * $limit;
            } else {
                $limit = (int) $show_users;
                $offset = 0;
            }

            $query_args['number'] = $limit;
            $query_args['offset'] = $offset;

            //testing ends 
            ob_start();
            ?>
            <div class="sp-featured-providers tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <?php if (!empty($section_heading) || !empty($content)) { ?>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
                        <div class="tg-sectionhead">
                            <?php if (!empty($section_heading)) { ?>
                                <div class="tg-sectiontitle">
                                    <h2><?php echo esc_attr($section_heading); ?></h2>
                                </div>
                            <?php } ?>
                            <?php if (!empty($content)) { ?>
                                <div class="tg-description">
                                    <?php echo wpautop(do_shortcode($content)); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <?php
                $this->listingo_vc_listing_view($query_args, $show_pagination, $total_users, $limit,$item_classes);
                ?>   
            </div>      
            <?php
            return ob_get_clean();
        }

        /**
         * Blog Grid View
         */
        public function listingo_vc_listing_view($query_args = array(), $show_pagination = 'off', $total_users = '', $limit = 0,$item_classes) {
            ob_start();
			if (function_exists('fw_get_db_settings_option')) {
				$google_key = fw_get_db_settings_option('google_key');
			} else {
				$google_key = '';
			}
            ?>				
            <div class="tg-latestserviceproviders">
                <div class="row">
                    <div class="tg-serviceproviders">
                        <?php
                        $user_query = new WP_User_Query($query_args);
                        if (!empty($user_query->results)) {
                            foreach ($user_query->results as $user) {
                                $username = listingo_get_username($user->ID);
                                $useremail = $user->user_email;
                                $userphone = $user->phone;
                                $email = explode('@', $user->user_email);

                                $category = get_user_meta($user->ID, 'category', true);
                                $map_marker = fw_get_db_post_option($category, 'dir_map_marker', true);
                                $avatar = apply_filters(
                                        'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 92, 'height' => 92), $user->ID), array('width' => 92, 'height' => 92)
                                );
                                ?>
                                <div class="<?php echo esc_attr($item_classes);?> tg-verticaltop">
                                    <div class="tg-serviceprovider">
                                        <?php do_action('listingo_result_avatar', $user->ID); ?>
                                        <div class="tg-companycontent">
                                            <?php do_action('listingo_result_tags', $user->ID); ?>
                                            <div class="tg-title">
                                                <h3><a href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><?php echo esc_attr($username); ?></a></h3>
                                            </div>
                                            <?php do_action('sp_get_rating_and_votes', $user->ID); ?>
                                            <ul class="tg-companycontactinfo">
                                                <?php do_action('listingo_get_user_meta', 'phone', $user); ?>
                                                <?php do_action('listingo_get_user_meta', 'email', $user); ?>

                                                <?php
                                                if (!empty($user->latitude) && !empty($user->longitude)) {
                                                    $unit = listingo_get_distance_scale();
                                                    $unit = !empty($unit) && $unit === 'Mi' ? 'M' : 'K';

                                                    if (!empty($_GET['geo'])) {
                                                        $args = array(
                                                            'timeout' => 15,
                                                            'headers' => array('Accept-Encoding' => ''),
                                                            'sslverify' => false
                                                        );

                                                        $address = sanitize_text_field($_GET['geo']);
                                                        $prepAddr = str_replace(' ', '+', $address);

                                                        $url	 = 'https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&key='.$google_key;;
                                                        $response = wp_remote_get($url, $args);
                                                        $geocode = wp_remote_retrieve_body($response);
                                                        $output = json_decode($geocode);

                                                        if (isset($output->results) && !empty($output->results)) {
                                                            $Latitude = $output->results[0]->geometry->location->lat;
                                                            $Longitude = $output->results[0]->geometry->location->lng;
                                                            $distance = listingo_GetDistanceBetweenPoints($Latitude, $Longitude, $user->latitude, $user->longitude);
                                                        }
                                                    }
                                                    ?>
                                                    <?php if (!empty($distance)) { ?>
                                                        <li class="dynamic-locations"><i class='lnr lnr-location'></i><span><?php esc_html_e('within', 'listingo_vc_shortcodes'); ?>&nbsp;<?php echo esc_attr($distance); ?></span></li>
                                                    <?php } else { ?>
                                                        <li class="dynamic-location-<?php echo intval($user->ID); ?>"></li>
                                                        <?php
                                                        wp_add_inline_script('listingo_callbacks', 'if ( window.navigator.geolocation ) {
                                                                window.navigator.geolocation.getCurrentPosition(
                                                                        function(pos) {
                                                                                jQuery.cookie("geo_location", pos.coords.latitude+"|"+pos.coords.longitude, { expires : 365 });
                                                                                var with_in = _get_distance(pos.coords.latitude, pos.coords.longitude, ' . esc_js($user->latitude) . ',' . esc_js($user->longitude) . ',"' . $unit . '");
                                                                                jQuery(".dynamic-location-' . intval($user->ID) . '").html("<i class=\'lnr lnr-location\'></i><span>"+scripts_vars.with_in+"&nbsp;"+_get_round(with_in, 2)+"&nbsp;"+scripts_vars.kilometer+"</i></span>");

                                                                        }
                                                                );
                                                            }
                                                        ');
                                                    }
                                                    ?>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <?php Listingo_Prepare_Notification::listingo_info(esc_html__('Sorry!', 'listingo_vc_shortcodes'), esc_html__('Nothing found.', 'listingo_vc_shortcodes')); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if (!empty($total_users) && !empty($limit) && $total_users > $limit && (!empty($show_pagination) && $show_pagination === 'on' )) { ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php listingo_prepare_pagination($total_users, $limit); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
            echo ob_get_clean();
        }

    }

    new SC_VC_Skin_Listingo_Featured_Listing();
}
        