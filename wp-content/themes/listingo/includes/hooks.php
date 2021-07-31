<?php
/**
 *
 * Custom Hooks
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * @get next post
 * @return link
 */
if (!function_exists('listingo_next_post')) {

    function listingo_next_post($format) {
        $format = str_replace('href=', 'class="btn-prevpost fa fa-arrow-left" href=', $format);
        return $format;
    }

    add_filter('next_post_link', 'listingo_next_post');
}

/**
 * @get next post
 * @return link
 */
if (!function_exists('listingo_previous_post')) {

    function listingo_previous_post($format) {
        $format = str_replace('href=', 'class="btn-nextpost fa fa-arrow-right" href=', $format);
        return $format;
    }

    add_filter('previous_post_link', 'listingo_previous_post');
}


/**
 * @Naigation Filter
 * @return {sMenu Item class}
 */
if (!function_exists('listingo_add_menu_parent_class')) {
    add_filter('wp_nav_menu_objects', 'listingo_add_menu_parent_class');

    function listingo_add_menu_parent_class($items) {
        $parents = array();
        foreach ($items as $item) {
            if ($item->menu_item_parent && $item->menu_item_parent > 0) {
                $parents[] = $item->menu_item_parent;
            }
        }
        foreach ($items as $item) {
            if (in_array($item->ID, $parents)) {
                $item->classes[] = 'dropdown';
            }
        }
        return $items;
    }

}

/**
 * @get custom Excerpt
 * @return link
 */
if (!function_exists('listingo_prepare_custom_excerpt')) {

    function listingo_prepare_custom_excerpt($more = '...') {
        return '....';
    }

    add_filter('excerpt_more', 'listingo_prepare_custom_excerpt');
}

/**
 * @Change Reply link Class
 * @return sizes
 */
if (!function_exists('listingo_replace_reply_link_class')) {
    add_filter('comment_reply_link', 'listingo_replace_reply_link_class');

    function listingo_replace_reply_link_class($class) {
        $class = str_replace("class='comment-reply-link", 'class="tg-btnreply"', $class);
        return $class;
    }

}

/**
 * @Section wraper before
 * @return 
 */
if (!function_exists('listingo_prepare_section_wrapper_before')) {

    function listingo_prepare_section_wrapper_before() {
        echo '<div class="main-page-wrapper">';
    }

    add_action('listingo_prepare_section_wrapper_before', 'listingo_prepare_section_wrapper_before');
}

/**
 * @Section wraper after
 * @return 
 */
if (!function_exists('listingo_prepare_section_wrapper_after')) {

    function listingo_prepare_section_wrapper_after() {
        echo '</div>';
    }

    add_action('listingo_prepare_section_wrapper_after', 'listingo_prepare_section_wrapper_after');
}


/**
 * @Post Classes
 * @return 
 */
if (!function_exists('listingo_post_classes')) {

    function listingo_post_classes($classes, $class, $post_id) {
        //Add Your custom classes
        return $classes;
    }

    add_filter('post_class', 'listingo_post_classes', 10, 3);
}
/**
 * @Add Body Class
 * @return 
 */
if (!function_exists('listingo_content_classes')) {

    function listingo_content_classes($classes) {

        if (is_singular()) {
            $_post = get_post();
            if ($_post != null) {
                if ($_post && preg_match('/vc_row/', $_post->post_content)) {
                    $classes[] = 'vc_being_used';
                }
            }
        }

        //check if maintenance is enable
        if (function_exists('fw_get_db_settings_option')) {
            $maintenance = fw_get_db_settings_option('maintenance');
        }

        $post_name = listingo_get_post_name();
        if (( isset($maintenance) && $maintenance == 'enable' && !is_user_logged_in() ) || $post_name == "coming-soon"
        ) {
            $classes[] = 'tg-comingsoon-page';
        }

        if (class_exists('Woocommerce') && is_woocommerce() && is_shop()) {
            $classes[] = 'tg-shop-page';
        }
		
		//add dashboard class
		if (is_page_template('directory/dashboard.php')) {
			$classes[] = 'sp-provider-dashboard';
		}
		
		//search template classes
		if ( is_page_template('directory/search.php') 
			|| is_singular('sp_categories') 
			|| is_tax('sub_category') 
			|| is_tax('countries') 
			|| is_tax('cities') 
			|| is_tax('insurance') 
			|| is_tax('languages') 
			|| is_tax('amenities') 
		) {
			$default_view = '';
			if (function_exists('fw_get_db_post_option')) {
				$default_view = fw_get_db_settings_option('dir_search_view');
			}

			if( !empty( $_GET['view'] ) ){
				$default_view	= esc_attr( $_GET['view'] );
			}

			if( $default_view === 'grid-left' || $default_view === 'list-left' ){
				 $classes[] = 'sticky-map';
			}
			
			$classes[] = 'sp-search-tpl';
		}
		
        return $classes;
    }

    add_filter('body_class', 'listingo_content_classes', 1);
}

/**
 * @Remove VC Classes
 * @return 
 */
if (!function_exists('listingo_classes_for_vc_row_and_vc_column')) {

    function listingo_classes_for_vc_row_and_vc_column($class_string, $tag) {
        if ($tag == 'vc_row' || $tag == 'vc_row_inner') {
            $class_string = preg_replace('/vc_row/', 'service-providers-elm-section vc-listingo-section', $class_string);
            $class_string = $class_string . ' service-providers-elm-section';
        }
        return $class_string; // Important: you should always return modified or original $class_string
    }

    add_filter('vc_shortcodes_css_class', 'listingo_classes_for_vc_row_and_vc_column', 10, 2);
}

/**
 * @Hook Favicon
 * @return favicon
 */
if (!function_exists('listingo_prepare_favicon')) {

    function listingo_prepare_favicon() {
        if (!function_exists('has_site_icon') || !has_site_icon()) {
            if (!function_exists('fw_get_db_settings_option')) {
                return;
            } else {
                $listingo_favicaon = fw_get_db_settings_option('favicon');
                if (isset($listingo_favicaon['url'])) {
                    echo '<link rel="shortcut icon" href="' . esc_url($listingo_favicaon['url']) . '">';
                }
            }
        } else {
            listingo_wp_favicon();
        }
    }

    add_action('listingo_get_favicon', 'listingo_prepare_favicon');
}

/**
 * @Favicon Fallback
 * @return favicon
 */
if (!function_exists('listingo_wp_favicon')) {

    function listingo_wp_favicon() {
        if (!has_site_icon() && !is_customize_preview()) {
            return;
        }

        $meta_tags = array(
            sprintf('<link rel="icon" href="%s" sizes="32x32" />', esc_url(get_site_icon_url(32))),
            sprintf('<link rel="icon" href="%s" sizes="192x192" />', esc_url(get_site_icon_url(192))),
            sprintf('<link rel="apple-touch-icon-precomposed" href="%s">', esc_url(get_site_icon_url(180))),
            sprintf('<meta name="msapplication-TileImage" content="%s">', esc_url(get_site_icon_url(270)))
        );

        /**
         * Filter the site icon meta tags, so Plugins can add their own.
         *
         * @since 4.3.0
         *
         * @param array $meta_tags Site Icon meta elements.
         */
        $meta_tags = apply_filters('site_icon_meta_tags', $meta_tags);
        $meta_tags = array_filter($meta_tags);
        foreach ($meta_tags as $meta_tag) {
            echo "$meta_tag\n";
        }
    }

}

/**
 * @Set Post Views
 * @return {}
 */
if (!function_exists('listingo_post_views')) {

    function listingo_post_views($post_id = '',$key='set_blog_view') {

        if (!is_single())
            return;

        if (empty($post_id)) {
            global $post;
            $post_id = $post->ID;
        }

        if (!isset($_COOKIE[$key . $post_id])) {
            setcookie($key . $post_id, $key, time() + 3600);
            $view_key = $key;

            $count = get_post_meta($post_id, $view_key, true);

            if ($count == '') {
                $count = 0;
                delete_post_meta($post_id, $view_key);
                add_post_meta($post_id, $view_key, '0');
            } else {
                $count++;
                update_post_meta($post_id, $view_key, $count);
            }
        }
    }

    add_action('listingo_post_views', 'listingo_post_views', 5, 2);
}


/**
 * Add theme version to admin footer
 * @return CSS
 */
if (!function_exists('add_listingo_version_to_footer_admin')) {

    function add_listingo_version_to_footer_admin($html) {
		$theme_version 	  = wp_get_theme('listingo');
        $listingo_version = $theme_version->get('Version');
        $listingo_name = '<a href="' . $theme_version->get('AuthorURI') . '" target="_blank">' . $theme_version->get('Name') . '</a>';

        return ( empty($html) ? '' : $html . ' | ' ) . $listingo_name . ' ' . $listingo_version;
    }

    if (is_admin()) {
        add_filter('update_footer', 'add_listingo_version_to_footer_admin', 13);
    }
}


/**
 * @Admin Menu 
 * @return 
 */
if (!function_exists('listingo_theme_options')) {
	add_action('admin_bar_menu', 'listingo_theme_options', 1000);
	function listingo_theme_options(){
		global $wp_admin_bar;
		if(!is_super_admin() || !is_admin_bar_showing()) return;
		
		$url = admin_url();
		if ( function_exists('fw_get_db_post_option') ) {
			// Add Parent Menu
			$argsParent	= array(
				'id' => 'listingo_setup',
				'title' => esc_html__('Listingo Theme Settings','listingo'),
				'href' => $url.'themes.php?page=fw-settings',
			);

			$wp_admin_bar->add_node( $argsParent );	
		}
	}
}

/**
 * @Product Image 
 * @return {}
 */
if (!function_exists('listingo_prepare_post_thumbnail')) {

    function listingo_prepare_post_thumbnail($object, $atts) {
        extract(shortcode_atts(array(
            "width" => '300',
            "height" => '300',
                        ), $atts));

        if (isset($object) && !empty($object)) {
            return $object;
        } else {
            $object_url = get_template_directory_uri() . '/images/fallback-' . intval( $width ) . 'x' . intval( $height ) . '.jpg';
            return '<img width="' . intval( $width ) . '" height="' . intval( $height ) . '" src="' . esc_url($object_url) . '" alt="' . esc_html__('Placeholder', 'listingo') . '">';
        }
    }

    add_filter('listingo_prepare_post_thumbnail', 'listingo_prepare_post_thumbnail', 10, 3);
}

/**
 * @ Prevoius Links
 * @return 
 */
if (!function_exists('listingo_do_process_next_previous_link')) {

    function listingo_do_process_next_previous_link($post_type = 'post') {
        global $post;
        $prevous_post_id = $next_post_id = '';
        $post_type = get_post_type($post->ID);
        $count_posts = wp_count_posts("$post_type")->publish;
        $args = array(
            'posts_per_page' => -1,
            'order' => 'ASC',
            'post_type' => "$post_type",
        );

        $all_posts = get_posts($args);

        $ids = array();
        foreach ($all_posts as $current_post) {
            $ids[] = $current_post->ID;
        }
        $current_index = array_search($post->ID, $ids);

        if (isset($ids[$current_index - 1])) {
            $prevous_post_id = $ids[$current_index - 1];
        }

        if (isset($ids[$current_index + 1])) {
            $next_post_id = $ids[$current_index + 1];
        }
        ?>
        <ul class="tg-postnav">
            <?php
            if (isset($prevous_post_id) && !empty($prevous_post_id) && $prevous_post_id >= 0) {
                $prev_thumb = listingo_prepare_thumbnail_from_id($prevous_post_id, 71, 71);
                if (empty($prev_thumb)) {
                    $prev_thumb = get_template_directory_uri() . '/images/img-71x71.jpg';
                }
                ?>
                <li class="tg-postprev">
                    <article class="tg-themepost th-thumbpost">
                        <figure class="tg-themepost-img">
                            <a href="<?php echo esc_url(get_permalink($prevous_post_id)); ?>"><img alt="<?php echo sanitize_title(get_the_title($next_post_id)); ?>" src="<?php echo esc_url($prev_thumb); ?>"></a>
                        </figure>
                        <div class="tg-contentbox">
                            <a class="tg-btnprevpost" href="<?php echo esc_url(get_permalink($prevous_post_id)); ?>"><?php esc_html_e('previous post', 'listingo'); ?></a>
                            <div class="tg-posttitle">
                                <h2><a href="<?php echo esc_url(get_permalink($prevous_post_id)); ?>"><?php echo esc_attr(get_the_title($next_post_id)); ?></a></h2>
                            </div>
                        </div>
                    </article>
                </li>

            <?php } ?>
            <?php
            if (isset($next_post_id) && !empty($next_post_id) && $next_post_id >= 0) {
                $next_thumb = listingo_prepare_thumbnail_from_id($next_post_id, 71, 71);

                if (empty($next_thumb)) {
                    $next_thumb = get_template_directory_uri() . '/images/img-71x71.jpg';
                }
                ?>
                <li class="tg-postnext">
                    <article class="tg-themepost tg-thumbpost">
                        <figure class="tg-themepost-img"> 
                            <a href="<?php echo esc_url(get_permalink($next_post_id)); ?>"><img alt="<?php echo sanitize_title(get_the_title($next_post_id)); ?>" src="<?php echo esc_url($next_thumb); ?>"></a> 
                        </figure>
                        <div class="tg-contentbox"> 
                            <a class="tg-btnnextpost" href="<?php echo esc_url(get_permalink($next_post_id)); ?>"><?php esc_html_e('Next post', 'listingo'); ?></a>
                            <div class="tg-posttitle">
                                <h2><a href="<?php echo esc_url(get_permalink($next_post_id)); ?>"><?php echo esc_attr(get_the_title($next_post_id)); ?></a></h2>
                            </div>
                        </div>
                    </article>
                </li>
            <?php } ?>
        </ul>
        <?php
        wp_reset_postdata();
    }

    add_action('do_process_next_previous_link', 'listingo_do_process_next_previous_link');
}

/**
 * @ Next/Prevoius Products
 * @return 
 */
if (!function_exists('listingo_do_process_next_previous_product')) {

    function listingo_do_process_next_previous_product() {
        global $post;

        $post_type = 'product';
        $prevous_post_id = $next_post_id = '';
        $post_type = get_post_type($post->ID);
        $count_posts = wp_count_posts("$post_type")->publish;
        $args = array(
            'posts_per_page' => -1,
            'post_type' => $post_type,
        );

        $all_posts = get_posts($args);

        $ids = array();
        foreach ($all_posts as $current_post) {
            $ids[] = $current_post->ID;
        }
        $current_index = array_search($post->ID, $ids);

        if (isset($ids[$current_index - 1])) {
            $prevous_post_id = $ids[$current_index - 1];
        }

        if (isset($ids[$current_index + 1])) {
            $next_post_id = $ids[$current_index + 1];
        }
        ?>
        <div class="tg-nextprevpost">
            <?php if (isset($prevous_post_id) && !empty($prevous_post_id) && $prevous_post_id >= 0) { ?>
                <div class="tg-btnprevpost">
                    <a href="<?php echo esc_url(get_permalink($prevous_post_id)); ?>">
                        <i class="lnr lnr-chevron-left"></i>
                        <div class="tg-booknameandtitle">
                            <h3><?php echo esc_attr(get_the_title($next_post_id)); ?></h3>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <?php if (isset($next_post_id) && !empty($next_post_id) && $next_post_id >= 0) { ?>
                <div class="tg-btnnextpost">
                    <a href="<?php echo esc_url(get_permalink($next_post_id)); ?>">
                        <div class="tg-booknameandtitle">
                            <h3><?php echo esc_attr(get_the_title($next_post_id)); ?></h3> 
                        </div>
                        <i class="lnr lnr-chevron-right"></i>
                    </a>
                </div>
            <?php } ?>
        </div>
        <?php
        wp_reset_postdata();
    }

    add_action('listingo_do_process_next_previous_product', 'listingo_do_process_next_previous_product');
}

/**
 * @Alter Query
 * @return 
 */
if (!function_exists('listingo_alter_query')) {
	add_action('pre_get_posts','listingo_alter_query');
    function listingo_alter_query($query) {
        //gets the global query var object
		global $wp_query;
		if (!is_admin() && $query->is_search) {
			if (function_exists('fw_get_db_settings_option')) {
				$search_show_posts = fw_get_db_settings_option('search_show_posts', $default_value = null);
				$search_order = fw_get_db_settings_option('search_order', $default_value = null);
				$search_orderby = fw_get_db_settings_option('search_orderby', $default_value = null);
				$search_meta_information = fw_get_db_settings_option('search_meta_information', $default_value = null);
			} else {
				$search_show_posts = get_option('posts_per_page');
				$search_order = 'DESC';
				$search_orderby = 'ID';
				$search_meta_information = 'enable';
			}

			$query->set('order', $search_order);
			$query->set('orderby', $search_orderby);
			$query->set('posts_per_page', $search_show_posts);
		} else if ( !is_admin() ) {
			
			if ( $query->is_home() && $query->is_main_query() ) {
				if (function_exists('fw_get_db_settings_option')) {
					$archive_show_posts = fw_get_db_settings_option('archive_show_posts', $default_value = null);
					$archive_order = fw_get_db_settings_option('archive_order', $default_value = null);
					$archive_orderby = fw_get_db_settings_option('archive_orderby', $default_value = null);
					$archive_meta_information = fw_get_db_settings_option('archive_meta_information', $default_value = null);
				} else {
					$archive_show_posts = get_option('posts_per_page');
					$archive_order 		= 'DESC';
					$archive_orderby 	= 'ID';
					$archive_meta_information = 'enable';
				}

				$query->set('order', $archive_order);
				$query->set('orderby', $archive_orderby);
				$query->set('posts_per_page', $archive_show_posts);
			}
		}

    }
}



/**
 * @IE Compatibility
 * @return 
 */
if (!function_exists('listingo_ie_compatibility')) {

    function listingo_ie_compatibility() {
        ?>
        <!--[if lt IE 9]>
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php
    }

    add_action('listingo_ie_compatibility', 'listingo_ie_compatibility');
}


/**
 * @Fallback Image 
 * @return {}
 */
if (!function_exists('listingo_get_fallback_image')) {

    function listingo_get_fallback_image($object, $atts = array()) {
        extract(shortcode_atts(array(
            "width" => '300',
            "height" => '300',
                        ), $atts));

        if (isset($object) && !empty($object) && $object != NULL
        ) {
            return $object;
        } else {
            return get_template_directory_uri() . '/images/fallback' . intval( $width ) . 'x' . intval( $height ) . '.jpg';
        }
    }

    add_filter('listingo_get_fallback_image', 'listingo_get_fallback_image', 10, 3);
}

/**
 * Enqueue Unyson Icons CSS
 */
if (!function_exists('enqueue_unyson_icons_css')) {

    function enqueue_unyson_icons_css() {
        /**
         * Detect plugin.
         */
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if (is_plugin_active('unyson/unyson.php')) {
            fw()->backend->option_type('icon-v2')->packs_loader->enqueue_frontend_css();
        }
    }

    add_action('enqueue_unyson_icon_css', 'enqueue_unyson_icons_css');
}


/**
 * @Filter to return Default image if no image found.
 * @return {}
 */
if (!function_exists('listingo_get_media_fallback')) {

    function listingo_get_media_fallback($object, $atts = array()) {
        extract(shortcode_atts(array(
            "width" => '150',
            "height" => '150',
                        ), $atts));

        if (isset($object) && !empty($object) && $object != NULL
        ) {
            return $object;
        } else {
			return get_template_directory_uri() . '/images/img-' . intval( $width ) . 'x' . intval( $height ) . '.jpg';
        }
    }

    add_filter('listingo_get_media_filter', 'listingo_get_media_fallback', 10, 3);
}

/**
 * @User default avatar
 * @return 
 */
if (!function_exists('listingo_user_profile_avatar')) {
	add_filter('get_avatar','listingo_user_profile_avatar',10,5);
	function listingo_user_profile_avatar($avatar = '', $id_or_email, $size = 80, $default = '', $alt = false ){
		
		if ( is_numeric( $id_or_email ) )
			$user_id = (int) $id_or_email;
		elseif ( is_string( $id_or_email ) && ( $user = get_user_by( 'email', $id_or_email ) ) )
			$user_id = $user->ID;
		elseif ( is_object( $id_or_email ) && ! empty( $id_or_email->user_id ) )
			$user_id = (int) $id_or_email->user_id;
		 
		if ( empty( $user_id ) )
			return $avatar;

		if( ( apply_filters('listingo_get_user_type', $user_id ) === 'business' 
			  || apply_filters('listingo_get_user_type', $user_id ) === 'professional' 
			  || apply_filters('listingo_get_user_type', $user_id ) === 'customer' 
			)
			  && !empty( $user_id )
		) {
			$local_avatars = apply_filters('listingo_get_media_filter', listingo_get_user_avatar(array('width' => $size, 'height' => $size), $user_id), array('width' => $size, 'height' => $size));


			if ( empty( $local_avatars ) )
				return $avatar;

			$size = (int) $size;

			if ( empty( $alt ) )
				$alt = get_the_author_meta( 'display_name', $user_id );

			$author_class = is_author( $user_id ) ? ' current-author' : '' ;
			$avatar       = "<img alt='" . esc_attr( $alt ) . "' src='" . $local_avatars . "' class='avatar photo' width='".$size."' height='".$size."'  />";
			
			return apply_filters( 'listingo_get_user_avatar', $avatar );
		} else{
			return $avatar;
		}
	}
}

/**
 * @User default avatar
 * @return 
 */
if (!function_exists('listingo_get_page_color')) {
	add_filter('listingo_get_page_color','listingo_get_page_color',10,1);
	function listingo_get_page_color($color='#5dc560'){
		$post_name = listingo_get_post_name();
		$pages_color	= array(
			'home-v5'	=> '#5dc560',
			'home-page-8'	=> '#017EBE',
			'home-v2'	=> '#5dc560',
			'header-v2'	=> '#5dc560',
		);

		if( isset( $_SERVER["SERVER_NAME"] ) && $_SERVER["SERVER_NAME"] === 'themographics.com' ){
			if( isset( $pages_color[$post_name] ) ){
				return $pages_color[$post_name];
			} else{
				return $color;
			}
		} else{
			return $color;
		}
		
	}
}

/**
 * @schema data
 * @return schema data
 */
if(!function_exists('listingo_print_schema_tags')){
    function listingo_print_schema_tags($data = array()){
        if ( !empty( $data ) ) {            
            echo '<script type="application/ld+json">';
            echo json_encode($data);
            echo  '</script>';
        }
    }
    add_action( 'print_schema_tags', 'listingo_print_schema_tags', 10, 1 );
}


/**
 * @non strict characters allow
 * @return allow non strict characters
 */
if( !function_exists( 'listingo_allow_non_strict_login' ) ) {    

    function listingo_allow_non_strict_login( $username, $raw_username, $strict ) {

        if( !$strict )
        return $username;
        return sanitize_user(stripslashes($raw_username), false);
    }

    add_filter('sanitize_user', 'listingo_allow_non_strict_login', 10, 3);
}