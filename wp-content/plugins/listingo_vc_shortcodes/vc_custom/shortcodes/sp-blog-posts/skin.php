<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Blog Posts
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Blog_Posts')) {

    class SC_VC_Skin_Listingo_Blog_Posts extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_blog_posts", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {
            extract(shortcode_atts(array(
                "blog_style" => '',
                "section_heading" => '',
                "posts_by" => 'by_catgories',
                "categories" => '',
                "specific_posts" => '',
                "no_of_posts" => '',
                "excerpt_length" => 60,
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

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_blog_posts', $args);

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
			
            if (isset($posts_by) && $posts_by === 'by_posts' && !empty($specific_posts)
            ) {
                $posts_in['post__in'] = explode(',', $specific_posts);
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
                'posts_per_page' => "-1",
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
            $count_post = $query->post_count;
			
			if( isset( $show_pagination ) && $show_pagination === 'on' && $count_post > $show_posts ){
				$paged	= $paged;
			} else{
				$paged	= 1;
			}
			
            //Main Query 
            $query_args = array(
                'posts_per_page' => $show_posts,
                'post_type' => 'post',
                'paged' => $paged,
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
            ob_start();
            ?>
            <div class="sp-sc-news tg-haslayout">
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
                    if (isset($blog_style) && $blog_style === 'list_view') {
                        $this->listingo_vc_prepare_blog_list_view($query_args, $show_pagination, $count_post, $show_posts, $excerpt_length);
                    } else {
                        $this->listingo_vc_prepare_blog_grid_view($query_args, $show_pagination, $count_post, $show_posts, $excerpt_length, $item_classes);
                    }
                ?>   
            </div>      
                <?php
                return ob_get_clean();
            }

        /**
         * Blog Grid View
         */
		public function listingo_vc_prepare_blog_grid_view($query_args = array(), $show_pagination = 'off', $count_post = '', $no_of_posts = '', $excerpt_length = '', $item_classes) {
			ob_start();
			$query = new WP_Query($query_args);
			if (!empty($query)) {
				?>
				<div class="tg-newsandposts tg-bloggird">
                <div class="row">
                    <?php
                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                            global $post;
                            $height = 200;
                            $width = 280;

                            $user_ID = get_the_author_meta('ID');
                            $post_thumbnail_id = get_post_thumbnail_id($post->ID);
                            $thumbnail = listingo_prepare_thumbnail($post->ID, $width, $height);
                            $enable_author = '';
                            if (function_exists('fw_get_db_post_option')) {
                                $enable_author = fw_get_db_post_option($post->ID, 'enable_author', true);
                            }

                            $thumb_meta = array();
                            if (!empty($post_thumbnail_id)) {
                                $thumb_meta = listingo_get_image_metadata($post_thumbnail_id);
                            }
                            $image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : 'no-name';
                            $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;
                            ?>
                            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 tg-verticaltop">
                                <article class="tg-post">
                                    <?php if (!empty($thumbnail)) { ?>
                                        <figure class="tg-featuredimg">
                                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                                <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                            </a>
                                        </figure>
                                    <?php } ?>
                                    <div class="tg-postcontent">
                                        <div class="tg-title">
                                            <h3><?php listingo_get_post_title($post->ID); ?></h3>
                                        </div>
                                        <ul class="tg-postmatadata">
                                            <?php if (!empty($enable_author) && $enable_author === 'enable') { ?>
                                                <li>
                                                    <?php listingo_get_post_author($user_ID, 'linked', $post->ID); ?>
                                                </li>
                                            <?php } ?>
                                            <li>
                                                <a href="javascript:;"><?php listingo_get_post_date($post->ID); ?></a>
                                            </li>
                                        </ul>
                                        <?php if (!empty($excerpt_length) && function_exists('listingo_prepare_search_content')) { ?>
                                            <div class="tg-description">
                                                <p><?php echo listingo_prepare_search_content(20); ?></p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </article>
                            </div>
                            <?php
                        } wp_reset_postdata();
                    }
                    ?>
                    <?php if (isset($show_pagination) && $show_pagination == 'on') : ?>
                        <div class="col-md-12">
                            <?php listingo_prepare_pagination($count_post, $no_of_posts); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
				<?php
			}
			echo ob_get_clean();
		}

        /**
         * Blog List View
         */
        public function listingo_vc_prepare_blog_list_view($query_args = array(), $show_pagination = 'off', $count_post = '', $no_of_posts = '', $excerpt_length = '') {
            ob_start();
            $query = new WP_Query($query_args);           
            if (!empty($query)) {
                ?>
					<div class="tg-bloglist">
					<?php
					if ($query->have_posts()) {
						while ($query->have_posts()) {
							$query->the_post();
							global $post;
							$height = 400;
							$width = 1180;

							$user_ID = get_the_author_meta('ID');
							$post_thumbnail_id = get_post_thumbnail_id($post->ID);
							$thumbnail = listingo_prepare_thumbnail($post->ID, $width, $height);
							$enable_author = '';
							if (function_exists('fw_get_db_post_option')) {
								$enable_author = fw_get_db_post_option($post->ID, 'enable_author', true);
							}

							$thumb_meta = array();
							if (!empty($post_thumbnail_id)) {
								$thumb_meta = listingo_get_image_metadata($post_thumbnail_id);
							}
							$image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : 'no-name';
							$image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;
							?>
							<article class="tg-post">
								<?php if (!empty($thumbnail)) { ?>
									<figure class="tg-featuredimg">
										<a href="<?php echo esc_url(get_permalink()); ?>">
											<img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($image_alt); ?>">
										</a>
									</figure>
								<?php } ?>
								<div class="tg-postcontent">
									<div class="tg-title">
										<h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php listingo_get_post_title($post->ID); ?></a></h3>
									</div>
									<ul class="tg-postmatadata">
										<?php if (!empty($enable_author) && $enable_author === 'enable') { ?>
											<li>
												<?php listingo_get_post_author($user_ID, 'linked', $post->ID); ?>
											</li>
										<?php } ?>
										<li>
											<a href="javascript:;"><?php listingo_get_post_date($post->ID); ?></a>
										</li>
									</ul>
									<?php if (!empty($excerpt_length) && function_exists('listingo_prepare_search_content')) { ?>
										<div class="tg-description">
											<p><?php echo listingo_prepare_search_content(20); ?></p>
										</div>
									<?php } ?>
									<a class="tg-btn" href="<?php echo esc_url(get_the_permalink()); ?>"><?php esc_html_e('read more', 'listingo_vc_shortcodes'); ?></a>
								</div>
							</article>
							<?php
						} wp_reset_postdata();
					}
					?>
					<?php if (isset($show_pagination) && $show_pagination == 'on') : ?>
						<div class="col-md-12">
							<?php listingo_prepare_pagination($count_post, $no_of_posts); ?>
						</div>
					<?php endif; ?>
				</div>
             <?php
            }
            echo ob_get_clean();
        }
    }

    new SC_VC_Skin_Listingo_Blog_Posts();
}
        