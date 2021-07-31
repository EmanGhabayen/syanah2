<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Blog Posts V2
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Blog_Posts_V2')) {

    class SC_VC_Skin_Listingo_Blog_Posts_V2 extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_blog_posts_v2", array(
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
                "section_subheading" => '',
                "posts_by" => 'by_catgories',
                "categories" => '',
                'link_url' => '',
                "specific_posts" => '',
                "no_of_posts" => '',
                "excerpt_length" => 60,
                "show_pagination" => 'on',
                "order" => '',
                "orderby" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_blog_posts_v2', $args);
            $classes = array();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            global $paged;

            $pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
            $pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
            //paged works on single pages, page - works on homepage
            $paged = max($pg_page, $pg_paged);

            if (isset($posts_by) && $posts_by === 'by_posts' && !empty($specific_posts)
            ) {
                $posts_in['post__in'] = !empty($specific_posts) ? explode(',', $specific_posts) : array();
            } else {
                $cat_sepration = array();
                if (isset($categories) && !empty($categories)) {
                    $cat_sepration = explode(',', $categories);
                }

                if (isset($cat_sepration) && !empty($cat_sepration)) {
                    $slugs = array();
                    foreach ($cat_sepration as $key => $value) {
                        $term = get_term($value, 'category');
                        $slugs[] = $term->slug;
                    }

                    $filterable = $slugs;
                    $tax_query['tax_query'] = array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'category',
                            'terms' => $filterable,
                            'field' => 'slug',
                    ));
                }
            }

            $show_posts = !empty($no_of_posts) ? $no_of_posts : '-1';

            $query_args = array(
                'posts_per_page' => $show_posts,
                'post_type' => 'post',
                'order' => $order,
                'orderby' => $orderby,
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1);

            //By Categories
            if (!empty($cat_sepration)) {
                $query_args = array_merge($query_args, $tax_query);
            }

            //By Posts 
            if (!empty($posts_in)) {
                $query_args = array_merge($query_args, $posts_in);
            }

            $query = new WP_Query($query_args);

            $link = array();
            $link = vc_build_link($link_url);
            ob_start();
            ?>
            <div class="sp-sc-news-v2 tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <?php if (!empty($section_heading) || !empty($section_subheading)) { ?>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
                        <div class="tg-sectionheadvtwo">
                            <div class="tg-sectiontitle">
                                <?php if (!empty($section_subheading)) { ?>
                                    <span><?php echo esc_attr($section_subheading); ?></span>
                                <?php } ?>
                                <?php if (!empty($section_heading)) { ?>
                                    <h2><?php echo esc_attr($section_heading); ?></h2>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
			
                if (!empty($query)) { ?>
                    <div class="tg-latestarticles">
                        <?php
                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                global $post;
                                $height = 152;
                				$width  = 275;
                                $thumbnail = listingo_prepare_thumbnail($post->ID, $width, $height);
                                ?>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 tg-verticaltop">
									<div class="tg-newsarticle">
										<?php if (!empty($thumbnail)) { ?>
											<figure class="tg-newsimg">
												<?php if (is_sticky($post->ID)) { ?>
													<span class="tg-posttag"><i class="fa fa-bolt"></i></span>
												<?php } ?>
												<img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_html_e('Post image'); ?>">
											</figure>
										<?php } ?>
										<div class="tg-postauthorname">
											<div class="tg-articlecontent">
												<div class="tg-articletitle">
													<h3><?php listingo_get_post_title($post->ID); ?></h3>
												</div>
												<?php if( function_exists('listingo_prepare_excerpt') ){?>
												<div class="tg-description">
													<p><?php echo listingo_prepare_excerpt($excerpt_length, true, esc_html__('read more', 'listingo_vc_shortcodes')); ?></p>
												</div>
												<?php }?>
											</div>
											<ul class="tg-postarticlemeta">
												<li> <span><?php listingo_get_post_date($post->ID); ?></span> </li>
											 </ul>
										</div>
									</div>
								</div>
                                <?php
                            } wp_reset_postdata();
                        }
                        ?>
                    </div>
                    <?php
                    if (!empty($link)) {
                        $btn_title = !empty($link['title']) ? $link['title'] : '';
                        $btn_link = !empty($link['url']) ? $link['url'] : '#';
                        $btn_target = !empty($link['target']) ? $link['target'] : '_self';
                        ?>
                        <div class="tg-btnboxvtwo">
                            <a class="tg-btn tg-btnvtwo" target="<?php echo esc_attr($btn_target); ?>" href="<?php echo esc_url($btn_link); ?>"><?php echo esc_attr($btn_title); ?></a>
                        </div>
                    <?php } ?>
                </div>
                <?php
                echo ob_get_clean();
            }
        }

    }

    new SC_VC_Skin_Listingo_Blog_Posts_V2();
}
        