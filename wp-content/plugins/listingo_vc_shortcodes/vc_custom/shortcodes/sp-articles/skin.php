<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Blog Posts
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Article_Posts')) {

    class SC_VC_Skin_Article_Posts extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_article_posts", array(
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
                "specific_posts" => '',
                "no_of_posts" => '',              
                "show_pagination" => 'on',
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

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_article_posts', $args);

            $classes[] = $custom_classes;
            $classes[] = $css_class;

            if (isset($custom_columns) && $custom_columns === 'yes') {
                $item_classes = $column_xs . ' ' . $column_sm . ' ' . $column_md . ' ' . $column_lg;
            } else {
                $item_classes = 'col-xs-6 col-sm-6 col-md-4 col-lg-4';
            }
            
            global $paged;

            $pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
            $pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
            //paged works on single pages, page - works on homepage
            $paged = max($pg_page, $pg_paged);

            $posts_in['post__in'] = explode(',', $specific_posts);
            $show_posts = !empty($no_of_posts) ? $no_of_posts : '-1';                        

            //Main Query 
            $query_args = array(
                'posts_per_page' => $show_posts,
                'post_type' => 'sp_articles',
                'paged' => $paged,
                'order' => $order,
                'orderby' => $orderby,
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1);

            //By Posts 
            if (!empty($posts_in)) {
                $query_args = array_merge($query_args, $posts_in);
            }

            ob_start();
            ?>

            <div class="sp-sc-articles tg-haslayout">
                <?php if (!empty( $section_heading ) || !empty( $content )) { ?>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
                        <div class="tg-sectionhead">
                            <?php if (!empty( $section_heading )) { ?>
                                <div class="tg-sectiontitle">
                                    <h2><?php echo esc_attr( $section_heading ); ?></h2>
                                </div>
                            <?php } ?>
                            <?php if (!empty( $content )) { ?>
                                <div class="tg-description">
                                    <?php echo wp_kses_post(wpautop(do_shortcode( $content ))); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="tg-newsandposts tg-bloggird">
                    <div class="row">
                        <?php
                        $query = new WP_Query($query_args);
						$found_posts = $query->found_posts;
                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                global $post;
                                $height = 270;
                                $width  = 370;

                                $author_id = $post->post_author;;

                                $post_thumbnail_id = get_post_thumbnail_id($post->ID);
                                $thumbnail = listingo_prepare_thumbnail($post->ID, $width, $height);

                                $thumb_meta = array();
                                if (!empty($post_thumbnail_id)) {
                                    $thumb_meta = listingo_get_image_metadata($post_thumbnail_id);
                                }
                                $image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : 'no-name';
                                $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;
                                
                                $author_name = listingo_get_username($author_id);
                                $author_avatar = apply_filters(
                                        'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 70, 'height' => 70), $author_id), array('width' => 100, 'height' => 100) //size width,height
                                );
                                ?>
                                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 tg-verticaltop">
                                    <article class="tg-post">
                                        <figure class="tg-featuredimg">
                                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                                <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                            </a>
                                        </figure>
                                        <div class="tg-title">
                                            <h3><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo esc_attr(get_the_title()); ?></a></h3>
                                        </div>
                                        <div class="tg-serviceprovidercontent">
                                            <div class="tg-companylogo">
                                                <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
                                                    <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php esc_html_e('author', 'listingo_vc_shortcodes'); ?>">
                                                </a>
                                            </div>
                                            <div class="tg-companycontent">
                                                <div class="tg-title">
                                                    <h2 class="sp-written-by"><?php esc_html_e('Written by', 'listingo_vc_shortcodes'); ?>&nbsp;<a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>"><?php echo esc_attr($author_name); ?></a></h2>
                                                </div>
                                                <h3><?php  echo '<time datetime="' . date_i18n('Y-m-d', strtotime(get_the_date('Y-m-d', $post->ID))) . '"><span>' . date_i18n(get_option('date_format'), strtotime(get_the_date('Y-m-d', $post->ID))) . '</span></time>';;?></h3>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <?php
                            } wp_reset_postdata();
                        }
                        ?>
                        <?php if ( isset($show_pagination) && $show_pagination == 'on' && $found_posts > $show_posts ) : ?>
                            <div class="col-md-12">
                                <?php listingo_prepare_pagination($found_posts, $show_posts); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }          

    }

    new SC_VC_Skin_Article_Posts();
}
        