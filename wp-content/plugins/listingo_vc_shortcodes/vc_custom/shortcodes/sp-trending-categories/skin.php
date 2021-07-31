<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Trending_Categories')) {

    class SC_VC_Skin_Listingo_Trending_Categories extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_trending_categories", array(
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
                "custom_id" => '',
                "specific_posts" => array(),
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_trending_categories', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            //setting search URL
            $dir_search_page = '';
            if (function_exists('fw_get_db_settings_option')) {
                $dir_search_page = fw_get_db_settings_option('dir_search_page');
            }
            if (isset($dir_search_page[0]) && !empty($dir_search_page[0])) {
                $search_page = get_permalink((int) $dir_search_page[0]);
            } else {
                $search_page = '';
            }

            /**
             * @var $atts
             */
            global $paged;
            $posts_in['post__in'] = !empty($specific_posts) ? explode(',', $specific_posts) : array();

            //total posts Query 
            $query_args = array(
                'posts_per_page' => -1,
                'post_type' => 'sp_categories',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1);

            //By Posts 
            if (!empty($posts_in)) {
                $query_args = array_merge($query_args, $posts_in);
            }

            $query = new WP_Query($query_args);
            $flag = rand(1, 99999);
            ob_start();
            ?>               
            <div class="sp-sc-trending-categories tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-push-1 col-lg-10">
                    <div class="tg-categoriessearch">
                        <div class="row">
                            <?php if (!empty($sec_title)) { ?>
                                <div class="tg-title">
                                    <h2><?php echo force_balance_tags($sec_title); ?></h2>
                                </div>
                            <?php } ?>
                            <?php if ($query->have_posts()) { ?>
                                <div id="tg-categoriesslider-<?php echo esc_attr($flag); ?>" class="tg-categoriesslider tg-categories owl-carousel">
                                    <?php
                                    while ($query->have_posts()) {
                                        $query->the_post();
                                        global $post;
                                        $category_icon = '';
                                        $category_color = '';
                                        if (function_exists('fw_get_db_post_option')) {
                                            $categoy_bg_img = fw_get_db_post_option($post->ID, 'category_image', true);
                                            $category_icon = fw_get_db_post_option($post->ID, 'category_icon', true);
                                            $category_color = fw_get_db_post_option($post->ID, 'category_color', true);
                                        }

                                        //Generate Directory page link
                                        $directory_link = add_query_arg('category', $post->post_name, $search_page);
                                        ?>
                                        <div class="tg-category">
                                            <div class="tg-categoryholder">
                                                <a href="<?php echo esc_url(get_permalink()); ?>">
                                                    <figure>
                                                        <?php
                                                        if (isset($category_icon['type']) && $category_icon['type'] === 'icon-font') {
                                                            do_action('enqueue_unyson_icon_css');
                                                            if (!empty($category_icon['icon-class'])) {
                                                                ?>
                                                                <span class="<?php echo esc_attr($category_icon['icon-class']); ?> tg-categoryicon" style="background: <?php echo esc_attr($category_color); ?>;"></span>
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
                                                    </figure>
                                                    <h3><?php echo get_the_title(); ?></h3>
                                                </a>
                                            </div>
                                        </div>
                                    <?php } wp_reset_postdata(); ?>
                                </div>
                                <?php
                                $script = "
                                    jQuery('#tg-categoriesslider-" . $flag . "').owlCarousel({
                                        items : 5,
                                        nav: true,
                                        loop: true,
                                        dots: false,
                                        rtl: " . listingo_owl_rtl_check() . ",
                                        center: true,
                                        autoplay: false,
                                        dotsClass: 'tg-sliderdots',
                                        navClass: ['tg-prev', 'tg-next'],
                                        navContainerClass: 'tg-slidernav',
                                        navText: ['<span class=\"fa fa-angle-left\"></span>', '<span class=\"fa fa-angle-right\"></span>'],
                                        responsive:{
                                            0:{ items:1, center:false},
                                            480:{ items:2, center:false},
                                            568:{ items:3, center:false},
                                            640:{ items:3, center:false},
                                            992:{ items:5, center:false},
                                        }
                                    });
                                    ";
                                wp_add_inline_script('listingo_callbacks', $script, 'after');
                                ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>    
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_Listingo_Trending_Categories();
}
