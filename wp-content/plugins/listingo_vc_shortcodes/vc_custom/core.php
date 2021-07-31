<?php
/**
 * @ Visual Composer Base Class
 * @ Base Class
 * @ return {}
 * @ Autor Themographics
 */
if (!class_exists('SC_VC_Core')) {

    class SC_VC_Core {

        public function __construct() {
            //
        }

        /**
         * @ Admin Init
         * @ return {}
         */
        public function get_section_defaults($key = 'nothing', $number = 10, $post_type = 'post', $taxanomy = 'category') {

            $defaults = array(
                'nothing' => array(
                    'type' => 'textfield',
                    'save_always' => true,
                    'value' => '',
                    'heading' => 'Nothing',
                    'param_name' => 'nothing',
                    "description" => esc_html__("No such array field exists.", 'listingo_vc_shortcodes')
                ),
                'custom_id' => array(
                    'type' => 'textfield',
                    'save_always' => true,
                    'value' => '',
                    'heading' => 'Custom ID',
                    'param_name' => 'custom_id',
                    "description" => esc_html__("", 'listingo_vc_shortcodes')
                ),
                'custom_classes' => array(
                    'type' => 'textfield',
                    'save_always' => true,
                    'value' => '',
                    'heading' => 'Custom Classes',
                    'param_name' => 'custom_classes',
                    "description" => esc_html__("", 'listingo_vc_shortcodes')
                ),
                'css' => array(
                    'type' => 'css_editor',
                    'heading' => esc_html__('Css', 'listingo_vc_shortcodes'),
                    'param_name' => 'css',
                    'group' => esc_html__('Design options', 'listingo_vc_shortcodes'),
                ),
            );
            return $defaults[$key];
        }

        public function get_icon_library($key = 'list') {
            $icons['list'] = array(
                'type' => 'dropdown',
                'heading' => esc_html__('Icon library', 'listingo_vc_shortcodes'),
                'value' => array(
                    esc_html__('Font Awesome', 'listingo_vc_shortcodes') => 'fontawesome',
                    esc_html__('Open Iconic', 'listingo_vc_shortcodes') => 'openiconic',
                    esc_html__('Typicons', 'listingo_vc_shortcodes') => 'typicons',
                    esc_html__('Entypo', 'listingo_vc_shortcodes') => 'entypo',
                    esc_html__('Linecons', 'listingo_vc_shortcodes') => 'linecons',
                    esc_html__('Mono Social', 'listingo_vc_shortcodes') => 'monosocial',
                    esc_html__('Material', 'listingo_vc_shortcodes') => 'material',
                    esc_html__('Linear Icon', 'listingo_vc_shortcodes') => 'linear',
                ),
				'dependency' => array(
                    'element' 	=> 'icon_image',
                    'value' 	=> 'icon',
                ),
                'admin_label' => true,
                'param_name' => 'type',
                'description' => esc_html__('Select icon library.', 'listingo_vc_shortcodes'),
            );
            $icons['fontawesome'] = array(
                'type' => 'iconpicker',
                'heading' => __('Icon', 'listingo_vc_shortcodes'),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-adjust',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'fontawesome',
                ),
                'description' => esc_html__('Select icon from library.', 'listingo_vc_shortcodes'),
            );
            $icons['openiconic'] = array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'listingo_vc_shortcodes'),
                'param_name' => 'icon_openiconic',
                'value' => 'vc-oi vc-oi-dial',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'openiconic',
                    'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'openiconic',
                ),
                'description' => esc_html__('Select icon from library.', 'listingo_vc_shortcodes'),
            );
            $icons['typicons'] = array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'listingo_vc_shortcodes'),
                'param_name' => 'icon_typicons',
                'value' => 'typcn typcn-adjust-brightness',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'typicons',
                    'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'typicons',
                ),
                'description' => __('Select icon from library.', 'listingo_vc_shortcodes'),
            );
            $icons['entypo'] = array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'listingo_vc_shortcodes'),
                'param_name' => 'icon_entypo',
                'value' => 'entypo-icon entypo-icon-note',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'entypo',
                    'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'entypo',
                ),
            );
            $icons['linecons'] = array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'listingo_vc_shortcodes'),
                'param_name' => 'icon_linecons',
                'value' => 'vc_li vc_li-heart',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'linecons',
                    'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'linecons',
                ),
                'description' => esc_html__('Select icon from library.', 'listingo_vc_shortcodes'),
            );
            $icons['monosocial'] = array(
                'type' => 'iconpicker',
                'heading' => __('Icon', 'listingo_vc_shortcodes'),
                'param_name' => 'icon_monosocial',
                'value' => 'vc-mono vc-mono-fivehundredpx',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'monosocial',
                    'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'monosocial',
                ),
                'description' => esc_html__('Select icon from library.', 'listingo_vc_shortcodes'),
            );
            //testin for linear icons 
            $icons['linear'] = array(
                'type' => 'iconpicker',
                'heading' => __('Icon', 'listingo_vc_shortcodes'),
                'param_name' => 'icon_linear',
                'value' => '',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'linear',
                    'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'linear',
                ),
                'description' => esc_html__('Select icon from library.', 'listingo_vc_shortcodes'),
            );
            //testing for linear icons end
            $icons['material'] = array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'listingo_vc_shortcodes'),
                'param_name' => 'icon_material',
                'value' => 'vc-material vc-material-cake',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'material',
                    'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'material',
                ),
                'description' => esc_html__('Select icon from library.', 'listingo_vc_shortcodes'),
            );
            $icons['listingovsicon'] = array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'listingo_vc_shortcodes'),
                'param_name' => 'icon_listingovcicon',
                'value' => '',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'listingovsicon',
                    'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'listingovsicon',
                ),
                'description' => esc_html__('Select icon from library.', 'listingo_vc_shortcodes'),
            );
            return $icons[$key];
        }

        /**
         * @Custom post types
         * @return {}
         */
        public function listingo_vc_shortcodes_prepare_custom_posts($post_type = 'post', $number = '10') {
            $posts_array = array();
            $args = array(
                'posts_per_page' => $number,
                'post_type' => $post_type,
                'order' => 'DESC',
                'orderby' => 'ID',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1
            );
            $posts_query = get_posts($args);
            foreach ($posts_query as $post_data):
                $posts_array[$post_data->post_title] = $post_data->ID;
            endforeach;
            return $posts_array;
        }

        /**
         * @Get All users of role business and professional
         * @return {}
         */
        public function listingo_vc_shortcodes_prepare_professionals($number = '10') {
            $args = array(
                'orderby' => 'nicename',
                'order' => 'DESC',
                'role__in'     => array('business', 'professional'),
            );

            $site_user = get_users($args);
            $user_list = array();
            foreach ($site_user as $user) {
                $user_list[$user->data->display_name] = $user->data->ID;
            }

            return $user_list;
        }

        /**
         * @ Uniqueue ID
         * @ return {}
         */
        public static function listingo_vc_shortcodes_unique_increment($length = 5) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }

        /**
         * @ Numbers ID
         * @ return {}
         */
        public static function listingo_vc_shortcodes_get_numbers($numbers = 500, $start = 1) {
            $numberData['-------'] = '';
            for ($i = $start; $i <= $numbers; $i++) {
                $numberData[$i] = $i;
            }
            return $numberData;
        }

        /**
         * Get Image Src
         * @return 
         */
        public function listingo_vc_shortcodes_get_image_source($thumb_id = '', $width = 300, $height = 300) {
            $thumb_url = wp_get_attachment_image_src($thumb_id, array($width, $height), true);
            if ($thumb_url[1] == $width and $thumb_url[2] == $height) {
                return $thumb_url[0];
            } else {
                $thumb_url = wp_get_attachment_image_src($thumb_id, "full", true);
                return $thumb_url[0];
            }
        }

        /**
         * Get Image Src
         * @return 
         */
        public function listingo_vc_shortcodes_get_image_metadata($attachment_id) {

            if ($attachment_id) {
                $attachment = get_post($attachment_id);
                return array(
                    'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
                    'caption' => $attachment->post_excerpt,
                    'description' => $attachment->post_content,
                    'href' => get_permalink($attachment->ID),
                    'src' => $attachment->guid,
                    'title' => $attachment->post_title
                );
            }
        }


        /**
         * Enqueue share script
         * @return 
         */
        public function listingo_vc_shortcodes_init_share_script() {
            wp_enqueue_script('listingo_vc_shortcodes_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', '', '', true);
        }

        /**
         * @preprare Custom ID
         * @return 
         */
        public function listingo_vc_shortcodes_prepare_custom_id($custom_id = '') {
            if (isset($custom_id) && !empty($custom_id)) {
                $custom_id = 'id=' . $custom_id;
            }
            echo ( $custom_id );
        }

        /**
         * @prepare Custom classess
         * @return 
         */
        public function listingo_vc_shortcodes_prepare_custom_classes($custom_classes = '') {
            if (!empty($custom_classes)) {
                echo implode(' ', $custom_classes);
            }
        }

        /**
         * @prepare Custom taxonomies array
         * @return array
         */
        public function listingo_vc_shortcodes_prepare_taxonomies($post_type = 'post', $taxonomy = 'category', $hide_empty = 1, $dataType = 'input') {
            $args = array(
                'type' => $post_type,
                'child_of' => 0,
                'parent' => '',
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => $hide_empty,
                'hierarchical' => 1,
                'exclude' => '',
                'include' => '',
                'number' => '',
                'taxonomy' => $taxonomy,
                'pad_counts' => false
            );

            $categories = get_categories($args);

            if ($dataType == 'array') {
                return $categories;
            }

            $custom_Cats = array();

            if (isset($categories) && !empty($categories)) {
                foreach ($categories as $key => $value) {
                    $custom_Cats[$value->name] = $value->term_id;
                }
            }

            return $custom_Cats;
        }

        /**
         * @Pearl
         * $return {HTML}
         */
        public static function success($message = 'No recored found') {
            global $post;

            $output = '';
            $output .= '<div class="col-md-12 message-success alert alert-success  alert-dismissible" role="alert"><p>';
            $output .= $message;
            $output .= '</p></div>';

            echo force_balance_tags($output);
        }

        /**
         * @Errors
         * $return {HTML}
         */
        public static function error($message = 'No recored found') {
            global $post;

            $output = '';
            $output .= '<div class="col-md-12 message-warning alert alert-danger alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"> <i class="icon-times-circle"></i></span></button>
						  <i class="icon-warning2"></i>' . $message . '
						</div>';

            echo force_balance_tags($output);
        }

        /**
         * @Warnings
         * $return {HTML}
         */
        public static function warning($message = 'No recored found') {
            global $post;

            $output = '';
            $output .= '<div class="col-md-12 message-warning alert alert-warning  alert-dismissible" role="alert"><p>';
            $output .= $message;
            $output .= '</p></div>';

            echo force_balance_tags($output);
        }

        /**
         * @Infomation
         * $return {HTML}
         */
        public static function informations($message = 'No recored found') {
            global $post;

            $output = '';
            $output .= '<div class="col-md-12 message-informations alert alert-info  alert-dismissible"  role="alert"><p>';
            $output .= $message;
            $output .= '</p></div>';

            echo force_balance_tags($output);
        }


        /* @Post author HTML
         * $return {HTML}
         */

        public function listingo_vc_shortcodes_get_post_author($post_author_id = '', $linked = 'linked', $post_id = '') {
            global $post;
            echo '<a href="' . esc_url(get_author_posts_url($post_author_id)) . '">' . get_the_author() . '</a>';
        }

        /* @Post date HTML
         * $return {HTML}
         */

        public function listingo_vc_shortcodes_get_post_date($post_id = '') {
            global $post;
            echo '<time datetime="' . date_i18n('Y-m-d', strtotime(get_the_date('Y-m-d', $post_id))) . '">' . date_i18n(get_option('date_format'), strtotime(get_the_date('Y-m-d', $post_id))) . '</time>';
        }

        /* @Post title HTML
         * $return {HTML}
         */

        public function listingo_vc_shortcodes_get_post_title($post_id = '') {
            global $post;
            echo '<a href="' . get_the_permalink($post_id) . '">' . get_the_title($post_id) . '</a>';
        }

        /* @Play button HTML
         * $return {HTML}
         */

        public function listingo_vc_shortcodes_get_play_link($post_id = '') {
            global $post;
            echo '<a class="th-btnplay" href="' . get_the_permalink($post_id) . '"></a>';
        }

        /**
         * Get Social Icon Name
         * $return HTML
         */
        public function listingo_vc_shortcodes_get_social_icon_name($icon_class = '') {
            $icons = array(
                'fa-facebook' => 'tg-facebook',
                'fa-facebook-square' => 'tg-facebook',
                'fa-facebook-official' => 'tg-facebook',
                'fa-facebook-f' => 'tg-facebook',
                'fa-twitter' => 'tg-twitter',
                'fa-twitter-square' => 'tg-twitter',
                'fa-linkedin' => 'tg-linkedin',
                'fa-linkedin-square' => 'tg-linkedin',
                'fa-google-plus' => 'tg-googleplus',
                'fa-google-plus-square' => 'tg-googleplus',
                'fa-google' => 'tg-googleplus',
                'fa-rss' => 'tg-rss',
                'fa-rss-square' => 'tg-rss',
                'fa-dribbble' => 'tg-dribbble',
                'fa-youtube' => 'tg-youtube',
                'fa-youtube-play' => 'tg-youtube',
                'fa-youtube-square' => 'tg-youtube',
                'fa-pinterest-square' => 'tg-pinterest',
                'fa-pinterest-p' => 'tg-pinterest',
                'fa-pinterest' => 'tg-pinterest',
                'fa-flickr' => 'tg-flickr',
                'fa-whatsapp' => 'tg-whatsapp',
                'fa-tumblr-square' => 'tg-tumblr',
                'fa-tumblr' => 'tg-tumblr',
            );
            if (!empty($icon_class)) {
                $substr_icon_class = substr($icon_class, 3);
                if (array_key_exists($substr_icon_class, $icons)) {
                    return $icons[$substr_icon_class];
                }
            }
        }

        /**
         * @Sort by distance
         * @return array
         */
        function listingo_vc_get_total_users_under_category($cat_id, $returntype = 'number') {

            /**
             * Count Total users that have 
             * been registered in categories.
             */
            $query_args = array(
                'role__in' => array('professional', 'business'),
                'order' => 'DESC',
            );

            $meta_query_args = array();

            $meta_query_args[] = array(
                'key' => 'category',
                'value' => $cat_id,
                'compare' => '=',
            );
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

            $total_query = new WP_User_Query($query_args);
            if ($returntype === 'number') {
                return $total_query->total_users;
            } else {
                return $total_query; //return query
            }
        }

    }

}

add_filter( 'vc_iconpicker-type-linear', 'vc_iconpicker_type_linear' );
/**
 * Material icon set from Google
 * @since 5.0
 *
 * @param $icons
 *
 * @return array
 */
function vc_iconpicker_type_linear( $icons ) {
    $linearicons = array(
        
        array( 'lnr lnr-magic-wand'  => 'Magic Wand' ),
        array( 'lnr lnr-heart' => 'Heart' ),
        array( 'lnr lnr-thumbs-up' => 'Thumb' ),
        array( 'lnr lnr-license' => 'Licence' ),
        array( 'lnr lnr-clock' => 'Clock' ),
        array( 'lnr lnr-tag' => 'Tag' ),
        array( 'lnr lnr-star' => 'Star' ),
        array( 'lnr lnr-cart' => 'Cart' ),
    );

    return array_merge( $icons, $linearicons );
}
