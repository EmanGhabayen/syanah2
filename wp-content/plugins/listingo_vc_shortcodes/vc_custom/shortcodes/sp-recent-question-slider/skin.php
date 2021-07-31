<?php
/**
 * @ Visual Composer Shortcode
 * @ Class SP Home Slider
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_SP_Recent_Ques_Slider')) {

    class SC_VC_Skin_SP_Recent_Ques_Slider extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_recent_ques_slider", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                'link_url' => '',
                "specific_posts" => '',
                "no_of_posts" => '',
                "excerpt_length" => 60,
                "order" => '',
                "nav" => 'true',
                "loop" => 'true',
                "autoplay" => 'true',
                "orderby" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_sp_recent_ques_slider', $args);
            $classes = array();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            global $paged;

            $pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
            $pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
            //paged works on single pages, page - works on homepage
            $paged = max($pg_page, $pg_paged);

            $posts_in['post__in'] = !empty($specific_posts) ? explode(',', $specific_posts) : array();

            $show_posts = !empty($no_of_posts) ? $no_of_posts : '-1';

            //Main Query
            $query_args = array(
                'posts_per_page' => $show_posts,
                'post_type' => 'sp_questions',
                'order' => $order,
                'orderby' => $orderby,
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1);

            //By Posts 
            if (!empty($posts_in)) {
                $query_args = array_merge($query_args, $posts_in);
            }

            $query = new WP_Query($query_args);
            $count_post = $query->found_posts;

            if (isset($show_pagination) && $show_pagination === 'on' && $count_post > $show_posts) {
                $paged = $paged;
            } else {
                $paged = 1;
            }

            $slide_nav = !empty($nav) && $nav === 'true' ? 'true' : 'false';
            $slide_autoplay = !empty($autoplay) && $autoplay === 'true' ? 'true' : 'false';
            $slide_loop = !empty($loop) && $loop === 'true' ? 'true' : 'false';
            $flag = rand(999, 9999);
            ob_start();
            ?>
            <div class="sp-sc-questions-slider tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <div id="tg-searchslider-<?php echo esc_attr($flag); ?>" class="tg-searchslider tg-haslayout owl-carousel">
                    <?php
                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                            global $post;
                            $question_by = get_post_meta($post->ID, 'question_by', true);
                            $question_to = get_post_meta($post->ID, 'question_to', true);
                            $category = get_post_meta($post->ID, 'question_cat', true);

                            $category_icon = '';
                            $category_color = '';
                            $bg_color = '';

                            if (function_exists('fw_get_db_post_option') && !empty($category)) {
                                $categoy_bg_img = fw_get_db_post_option($category, 'category_image', true);
                                $category_icon = fw_get_db_post_option($category, 'category_icon', true);
                                $category_color = fw_get_db_post_option($category, 'category_color', true);

                                $bg_color = fw_get_db_post_option($category, 'category_color', true);
                                if (!empty($bg_color)) {
                                    $bg_color = 'style=background:' . $bg_color;
                                }
                            }
                            ?>
                            <div class="item tg-searchsliderinfo">
                                <div class="tg-searchdtails">
                                    <?php if (!empty($category)) { ?>
                                        <div class="tg-adverifiedadd">
                                            <a class="tg-verifiedadditem tg-business" <?php echo esc_attr($bg_color); ?> href="<?php echo esc_url(get_permalink($category)); ?>">
                                                <?php echo esc_attr(get_the_title($category)); ?>
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <div class="tg-title">
                                        <h2><a href="<?php echo esc_url(get_permalink()); ?>"> <?php echo esc_attr(get_the_title()); ?> </a></h2>
                                    </div>
                                    <div class="tg-description">
                                        <?php listingo_prepare_excerpt($excerpt_length, 'false', '...'); ?>
                                    </div>
                                </div>
                                <?php if (function_exists('fw_get_db_settings_option') && fw_ext('questionsanswers')){?>
									<div class="tg-searchmeta">
										<?php fw_ext_get_views_and_time_html($post->ID); ?>
										<?php fw_ext_get_votes_html($post->ID, esc_html__('Is this helpful?', 'listingo_vc_shortcodes')); ?>
									</div>
                                <?php }?>
                            </div>
                            <?php
                        } wp_reset_postdata();
                        $script = "
                            jQuery('#tg-searchslider-" . esc_js($flag) . "').owlCarousel({
                                items:2,
                                nav:" . esc_js($slide_nav) . ",
                                margin:20,
                                loop:" . esc_js($slide_loop) . ",
                                autoplay:" . esc_js($slide_autoplay) . ",
								rtl: " . listingo_owl_rtl_check() . ",
                                dotsClass: 'tg-sliderdots',
                                navClass: ['tg-prev', 'tg-next'],
                                navContainerClass: 'tg-slidernav',
                                navText: ['<span class=\'lnr lnr-chevron-left\'></span>', '<span class=\'lnr lnr-chevron-right\'></span>'],
                                responsiveClass:true,
                                    responsive:{
                                        0:{items:1,},
                                        991:{items:1,},
                                        992:{items:2}
                                    },
                            });
                        ";
                        wp_add_inline_script('listingo_callbacks', $script, 'after');
                    }
                    ?>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_SP_Recent_Ques_Slider();
}
