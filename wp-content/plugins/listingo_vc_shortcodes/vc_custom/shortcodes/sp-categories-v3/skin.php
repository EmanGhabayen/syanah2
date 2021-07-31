<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Categories_Vthree')) {

    class SC_VC_Skin_Listingo_Categories_Vthree extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_categories_vthree", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "sec_title" => '',
                "no_of_posts" => -1,
                "view" => 'one',
                "service_link" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args)); 

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_categories_vthree', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            //setting search URL            
            $dir_search_page = fw_get_db_settings_option('dir_search_page');
            if (isset($dir_search_page[0]) && !empty($dir_search_page[0])) {
                $search_page = get_permalink((int) $dir_search_page[0]);
            } else {
                $search_page = '';
            }

            /**
             * @var $atts
             */
            global $paged;
            $posts_in['post__in'] = !empty($specific_posts) ? $specific_posts : array();

            //total posts Query 
            $query_args = array(
                'posts_per_page' => $no_of_posts,
                'post_type' => 'sp_categories',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1);

            //By Posts 
            if (!empty($posts_in)) {
                $query_args = array_merge($query_args, $posts_in);
            }

            $query = new WP_Query($query_args);
            $flag   = rand(1,99999);

            $service_link = !empty( $service_link ) ? $service_link : '';
            $section_class = '';
            if ( !empty( $view ) ){
                if ($view == 'one'){
                    $section_class = '';
                } else {
                    $section_class = 'tg-paddingtopzero';
                }
            }
            ob_start();
            ?>               
            <div class="<?php echo esc_attr( $section_class ); ?> tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
                        <?php if ( !empty( $sec_title) || !empty( $content ) ) { ?>
                            <div class="tg-sectionhead">
                                <?php if (!empty($sec_title)) { ?>
                                <div class="tg-sectiontitle">
                                    <h2><?php echo esc_attr($sec_title); ?></h2>
                                </div>
                                <?php } ?>
                                <?php if (!empty($content)) { ?>
                                    <div class="tg-description">
                                        <?php echo wp_kses_post(wpautop(do_shortcode($content))); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php
                        if (isset($view) && $view === 'one') {
                            $this->listingo_vc_prepare_category_view_one($query_args, $service_link);
                        } if (isset($view) && $view === 'two'){
                            $this->listingo_vc_prepare_category_view_two($query_args);
                        }elseif (isset($view) && $view === 'three') {
                            $this->listingo_vc_prepare_category_view_three($query_args, $service_link);
                        }
                    ?>           
                </div>
            </div>    
            <?php
            return ob_get_clean();
        }
        //view one starts 
        /**
         * Category view 1
         */
        public function listingo_vc_prepare_category_view_one($query_args = array(), $service_link = '') {
            ob_start();           
            if (!empty($query_args)) {
                $query = new WP_Query($query_args);
                if ($query->have_posts()) { ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="tg-searchbycatagory">
                    <?php
                    while ($query->have_posts()) {
                        $query->the_post();
                        global $post;

                        $categoy_bg_img = '';
                        $category_icon = '';
                        $category_color = '';
                        if (function_exists('fw_get_db_post_option')) {
                            $categoy_bg_img = fw_get_db_post_option($post->ID, 'category_image', true);
                            $category_icon = fw_get_db_post_option($post->ID, 'category_icon', true);
                            $category_color = fw_get_db_post_option($post->ID, 'category_color', true);
                        }               

                        $thumb_meta = array();
                        if (!empty($categoy_bg_img['attachment_id'])) {
                            $thumb_meta = listingo_get_image_metadata($categoy_bg_img['attachment_id']);
                        }
                        $image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : 'no-name';
                        $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;    

                        $icon_class = '';
                        if ( !empty( $category_icon ) ) {
                            $icon_class = !empty( $category_icon['icon-class'] ) ? $category_icon['icon-class'] : '';
                        }

                        $icon_style = '#000000';
                        if ( !empty( $category_color ) ) {
                            $icon_style = 'style="color: '.$category_color.'"';
                        }

                       $link = '';
                        if (!empty($service_link)) {
                            $link = vc_build_link($service_link);
                        }
                        $link_title     = !empty($link['title']) ? $link['title'] : '';
                        $target         = !empty($link['target']) ? $link['target'] : '_self';
                        $link_url       = !empty($link['url']) ? $link['url'] : '#';                                                                                                  
                    ?>              
                        <div class="tg-catagory">
                            <a href="<?php the_permalink(); ?>">
                                <?php 
                                    if (isset($category_icon['type']) && $category_icon['type'] === 'icon-font') {
                                        do_action('enqueue_unyson_icon_css');
                                        if (!empty($category_icon['icon-class'])) {
                                            ?>
                                            <span class="tg-categoryicon" <?php echo ( $icon_style ); ?>><i class="<?php echo esc_attr( $icon_class ); ?>"></i></span>
                                            <?php
                                        }
                                    } else if (isset($category_icon['type']) && $category_icon['type'] === 'custom-upload') {
                                        if (!empty($category_icon['url'])) {
                                            ?>
                                            <em><img src="<?php echo esc_url($category_icon['url']); ?>" alt="<?php echo esc_attr($image_alt); ?>"></em>
                                            <?php
                                        }
                                    }       
                                ?>      
                                <span><?php the_title(); ?></span>
                            </a>
                        </div>                                                  
                    <?php } wp_reset_postdata(); ?>
                    <?php 
                            $link = '';
                            $link = vc_build_link($service_link);
                            $link_title = !empty($link['title']) ? $link['title'] : '';
                            $target = !empty($link['target']) ? $link['target'] : '_self';
                            $link_url = !empty($link['url']) ? $link['url'] : '#'; 
                            if ( !empty( $link_title ) ) {
                        ?>
                        <div class="tg-catagory">
                            <a href="<?php echo esc_attr( $link_url ); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/img-07.png" alt="<?php echo esc_attr( $link_title ); ?>">
                                <span><?php echo esc_attr( $link_title ); ?></span>
                            </a>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <?php
            }
            echo ob_get_clean();
        }

        /**
         * Category view 2
         */
        public function listingo_vc_prepare_category_view_two($query_args = array()) {
            ob_start();           
            if (!empty($query_args)) {
                $query = new WP_Query($query_args);
                if ($query->have_posts()) { ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="tg-popularcatagories">
                    <?php
                    while ($query->have_posts()) {
                        $query->the_post();
                        global $post;                

                        $categoy_bg_img = '';   
                        $category_icon = '';
                        $category_color = '';
                        if (function_exists('fw_get_db_post_option')) {
                            $categoy_bg_img = fw_get_db_post_option($post->ID, 'category_image', true);
                            $category_icon = fw_get_db_post_option($post->ID, 'category_icon', true);
                            $category_color = fw_get_db_post_option($post->ID, 'category_color', true);
                        }                           

                        $thumb_meta = array();
                        if (!empty($categoy_bg_img['attachment_id'])) {
                            $thumb_meta = listingo_get_image_metadata($categoy_bg_img['attachment_id']);
                        }
                        $image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : 'no-name';
                        $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;    

                        $icon_class = '';
                        if ( !empty( $category_icon ) ) {
                            $icon_class = !empty( $category_icon['icon-class'] ) ? $category_icon['icon-class'] : '';
                        }

                        $icon_style = '#000000';
                        if ( !empty( $category_color ) ) {
                            $icon_style = 'style="color: '.$category_color.'"';
                        }                                                                      
                                                
                    ?>              
                        <li>
                            <?php 
                                if (isset($category_icon['type']) && $category_icon['type'] === 'icon-font') {
                                    do_action('enqueue_unyson_icon_css');
                                    if (!empty($category_icon['icon-class'])) {
                                        ?>
                                        <span class="tg-categoryicon" <?php echo ( $icon_style ); ?>><i class="<?php echo esc_attr( $icon_class ); ?>"></i></span>
                                        <?php
                                    }
                                } else if (isset($category_icon['type']) && $category_icon['type'] === 'custom-upload') {
                                    if (!empty($category_icon['url'])) {
                                        ?>
                                        <img src="<?php echo esc_url($category_icon['url']); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                        <?php
                                    }
                                }       
                            ?>          
                            <span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
                        </li>                                                                        
                    <?php } wp_reset_postdata(); ?>                    
                    </ul>
                </div>
            <?php } ?>
            <?php
            }
            echo ob_get_clean();
        }
        
        /**
         * Category view 3
         */
        public function listingo_vc_prepare_category_view_three($query_args = array(), $service_link = '') {
            ob_start();           
            if (!empty($query_args)) {
                wp_enqueue_style('balloon');
                $query = new WP_Query($query_args);
                if ($query->have_posts()) { ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="tg-generallabor">
                        <ul>
                    <?php
                    while ($query->have_posts()) {
                        $query->the_post();
                        global $post;

                        $categoy_bg_img = '';
                        $category_icon = '';
                        $category_color = '';
                        if (function_exists('fw_get_db_post_option')) {
                            $categoy_bg_img = fw_get_db_post_option($post->ID, 'category_image', true);
                            $category_icon = fw_get_db_post_option($post->ID, 'category_icon', true);
                            $category_color = fw_get_db_post_option($post->ID, 'category_color', true);
                        }               

                        $thumb_meta = array();
                        if (!empty($categoy_bg_img['attachment_id'])) {
                            $thumb_meta = listingo_get_image_metadata($categoy_bg_img['attachment_id']);
                        }
                        $image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : 'no-name';
                        $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;    

                        $icon_class = '';
                        if ( !empty( $category_icon ) ) {
                            $icon_class = !empty( $category_icon['icon-class'] ) ? $category_icon['icon-class'] : '';
                        }

                        $icon_style = '#000000';
                        if ( !empty( $category_color ) ) {
                            $icon_style = 'style="background: '.$category_color.'"';
                        }                                                            
                                                
                    ?>              
                        <li>
                            <?php 
                                if (isset($category_icon['type']) && $category_icon['type'] === 'icon-font') {
                                    do_action('enqueue_unyson_icon_css');
                                    if (!empty($category_icon['icon-class'])) {
                                        ?>
                                        <a href="<?php the_permalink(); ?>" <?php echo ( $icon_style ); ?> data-balloon="<?php the_title(); ?>" data-balloon-pos="up"><i class="<?php echo esc_attr( $icon_class ); ?>"></i></a>    
                                        <?php
                                    }
                                } else if (isset($category_icon['type']) && $category_icon['type'] === 'custom-upload') {
                                    if (!empty($category_icon['url'])) {
                                        ?>
                                        <a href="<?php the_permalink(); ?>" <?php echo ( $icon_style ); ?> data-balloon="<?php the_title(); ?>" data-balloon-pos="up"><img src="<?php echo esc_url($category_icon['url']); ?>" alt="<?php echo esc_attr($image_alt); ?>"></a>                                       
                                        <?php
                                    }
                                } else { ?>
                                    <a href="<?php the_permalink(); ?>" <?php echo ( $icon_style ); ?> data-balloon="<?php the_title(); ?>" data-balloon-pos="up"><i class="lnr lnr-question-circle"></i></a>
                                <?php }     
                            ?>          
                        </li>                                                
                    <?php } wp_reset_postdata(); ?>
                    <?php 
                        $link = '';
                        if (!empty($service_link)) {
                            $link = vc_build_link($service_link);
                        }
                        $link_title     = !empty($link['title']) ? $link['title'] : '';
                        $target         = !empty($link['target']) ? $link['target'] : '_self';
                        $link_url       = !empty($link['url']) ? $link['url'] : '#';  
                            if ( !empty( $link_title ) ) {
                        ?>
                            <a class="tg-btnviewcatagories" href="<?php echo esc_attr( $link_url ); ?>"><?php echo esc_attr( $link_title ); ?></a>
                    <?php } ?>
                        </ul>
                    </div>
                </div>
            <?php } ?>
            <?php
            }
            echo ob_get_clean();
        } 

    }
    new SC_VC_Skin_Listingo_Categories_Vthree();
}
