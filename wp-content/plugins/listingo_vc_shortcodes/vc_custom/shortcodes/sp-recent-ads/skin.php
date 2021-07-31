<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Recent ads
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Recent_Ads')) {

    class SC_VC_Skin_Recent_Ads extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_recent_ads", array(
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
                "no_of_posts" => 10,
                "show_pagination" => '',
                "orderby" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_recent_ads', $args);

            $classes[] = $custom_classes;
            $classes[] = $css_class;

            //testing starts
            $pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
			$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
			//paged works on single pages, page - works on homepage
			$paged = max($pg_page, $pg_paged);

			if (isset($posts_by) && $posts_by === 'by_catgories' ) {

				$cat_sepration = array();
                if (isset($categories) && !empty($categories)) {
                    $cat_sepration = explode(',', $categories);
                }

                if (!empty($cat_sepration)) {
                    $slugs = array();
                    foreach ($cat_sepration as $key => $value) {
                        $slugs[] = $value;
                    }

                    $filterable = $slugs;
                    $tax_query['tax_query'] = array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' 	=> 'ad_category',
                            'terms' 	=> $filterable,
                            'field' 	=> 'term_id',
                    ));
                }
			}

			$show_posts	 			 = $no_of_posts;
			$show_pagination		 = !empty( $show_pagination ) ? $show_pagination : '';
			$limit  	 = (int) $show_posts;
			$uniq_flag 	 = fw_unique_increment();
			
			$query_args = array(
				'post_type' 	=> 'sp_ads',
				'posts_per_page' => -1,
				'post_status' 	=> 'publish',
				'posts_per_page'=> $limit,
				'order' 		=> 'DESC',
				'orderby' 		=> 'ID',
			);

			//By Categories
            if (!empty($tax_query)) {
                $query_args = array_merge($query_args, $tax_query);
            }

			//featured on top
			$query_args['order'] 	= 'DESC';
			$query_args['orderby'] 	= 'meta_value_num';
			$query_args['meta_key'] = '_featured_timestamp';

			$ads_data 		= new WP_Query($query_args);
			$total_posts 	= $ads_data->found_posts;

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
                <div class="tg-custom-search-grid">
					<div class="row">
						<?php
						if ($ads_data->have_posts()) {
							while ($ads_data->have_posts()) : $ads_data->the_post();
								global $post;						
								$width 	= intval(360);
								$height = intval(240);
								$thumbnail  = listingo_prepare_thumbnail($post->ID, $width, $height);
								if( empty( $thumbnail ) ) {
									$thumbnail = get_template_directory_uri().'/images/placeholder-360x240.jpg';
								} 
								$post_author_id	= $post->post_author;						

							?>
						   <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 tg-verticaltop">
							   <div class="tg-oneslides  tg-automotivegrid">
								  <div class="tg-automotive">
										<figure class="tg-featuredimg tg-authorlink">				
											<?php do_action('listingo_get_ad_featured_tag', $post->ID ); ?>									
											<img src="<?php echo esc_url( $thumbnail );?>" alt="<?php the_title();?>">
											<?php do_action('listingo_get_ad_category',$post->ID);?>
											<?php do_action('listingo_print_favorite_ads',$post->ID,$post_author_id);?>
										</figure>
										<div class="tg-companycontent tg-authorfeature">
											<div class="tg-featuredetails">
												<div class="tg-title">
													<h2>
														<?php do_action('listingo_get_ad_title',$post->ID,get_the_title());?>
													</h2>											
												</div>									
												<?php do_action('listingo_get_ad_address',$post->ID);?>
											</div>
											<?php do_action('listingo_get_ad_provider_detail',$post->ID,$post_author_id);?>
											<?php do_action('listingo_get_ad_meta',$post->ID,$post_author_id);?>
										</div>
									</div>
								</div>
						   </div>
						   <?php
								endwhile;
								wp_reset_postdata();
							}else{
								Listingo_Prepare_Notification::listingo_info('', esc_html__('No ads found.', 'listingo_vc_shortcodes'));
							}
						?>
					</div>
					<?php if ( $show_pagination === 'on' && !empty($total_posts) && !empty($show_posts) && $total_posts > $show_posts) {?>
						<div class="tg-haslayout page-wrap">
							<?php listingo_prepare_pagination($total_posts, $show_posts); ?>
						</div>
					<?php } ?>
				 </div>
            </div>      
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_Recent_Ads();
}
        