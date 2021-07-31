<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Blog Posts
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Providers_Cat')) {

    class SC_VC_Skin_Listingo_Providers_Cat extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_providers_cat", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {
            extract(shortcode_atts(array(
                "style" => '',
                "categories" => '',
                "heading" => '',
                "sub_heading" => '',
                "no_of_posts" => '',
                "show_pagination" => 'on',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));
            
            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_providers_cat', $args);
            $classes = array();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            global $paged;

            $per_page = intval(8);
            if (!empty($no_of_posts)) {
                $per_page = $no_of_posts;
            }

            $pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
            $pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
            $cat_sepration = !empty($categories) ? explode(',', $categories) : '';
            
            //paged works on single pages, page - works on homepage
            $paged = max($pg_page, $pg_paged);
            $limit = (int) $per_page;

            $meta_query_args = array();
            $query_args = array(
                'role__in' => array('professional', 'business'),
                'order' => 'DESC',
                'orderby' => 'ID',
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

            if (!empty($cat_sepration)) {
                foreach ($cat_sepration as $key => $value) {
                    $meta_category[] = array(
                        'key' => 'category',
                        'value' => $value,
                        'compare' => '='
                    );
                }
            }

            //By Categories
            if (!empty($meta_category)) {
                $query_relations = array('relation' => 'OR',);
                $meta_query_args = array_merge($query_relations, $meta_category);
                $query_args['meta_query'][] = $meta_query_args;
            }

            if (!empty($show_pagination) && $show_pagination === 'yes') {
                $offset = ($paged - 1) * $limit;
            } else {
                $offset = 0;
            }

            $query_args['number'] = $limit;
            $query_args['offset'] = $offset;
            ob_start();
            ?>
            <div class="sc-listing-bycat tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <?php if (!empty($heading) || !empty($sub_heading)) { ?>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="tg-sectionheadvtwo">
                            <div class="tg-sectiontitle">
                                <?php if (!empty($heading)) { ?><span><?php echo esc_attr($heading); ?></span><?php } ?>
                                <?php if (!empty($sub_heading)) { ?><h2><?php echo esc_attr($sub_heading); ?></h2><?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php
					if (isset($style) && $style === 'list_view') {
						$this->listingo_vc_prepare_users_list_view($query_args, $show_pagination, $limit);
					} else {
						$this->listingo_vc_prepare_users_grid_view($query_args, $show_pagination, $limit);
					}
                ?>   
            </div>      
            <?php
            return ob_get_clean();
        }

        /**
         * Providers By Category Grid View
         */
        public function listingo_vc_prepare_users_grid_view($query_args = array(), $show_pagination = 'off',$limit = '') {
            ob_start();
			$user_query 	= new WP_User_Query($query_args);
			$total_users 	= $user_query->total_users;
            ?>
            <div class="sc-listing-bycat-grid sp-featured-providers-v2 tg-haslayout spv4-listing">
				<div class="tg-featuredproviders tg-listview">
					<div class="tg-featuredproviders">
						<div class="row">
							<?php
							if (!empty($user_query->results)) {
								foreach ($user_query->results as $user) {
									$username = listingo_get_username($user->ID);
									$category = get_user_meta($user->ID, 'category', true);
									$avatar = apply_filters(
											'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 92, 'height' => 92), $user->ID), array('width' => 92, 'height' => 92)
									);
									?>
									<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 tg-verticaltop">
										<div class="tg-featuredad">
											<?php do_action('listingo_result_avatar_v2', $user->ID,'',array('width' => 275, 'height' => 152)); ?>
											<div class="tg-featuredetails">
												<?php do_action('listingo_result_tags_v2', $user->ID); ?>
												<div class="tg-title">
													<h2><a href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><?php echo esc_attr($username); ?></a></h2>
												</div>
												<?php do_action('sp_get_rating_and_votes', $user->ID); ?>
											</div>
											<ul class="tg-phonelike">
												<?php do_action('listingo_get_user_meta','phone',$user);?>
												<?php do_action('listingo_add_to_wishlist', $user->ID); ?>
											</ul>
										</div>
									</div>
									<?php
								}
							}
							?>
						</div>
					</div>
				</div>
				<?php if (!empty($total_users) && !empty($limit) && $total_users > $limit ) { ?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php listingo_prepare_pagination($total_users, $limit); ?>
					</div>
				<?php } ?>
          	</div>
            <?php
            echo ob_get_clean();
        }

        /**
         * Providers By Category List View
         */
        public function listingo_vc_prepare_users_list_view($query_args = array(), $show_pagination = 'off', $limit = '') {
            ob_start();
			$user_query 	= new WP_User_Query($query_args);
			$total_users 	= $user_query->total_users;
            ?>
            <div class="sc-listing-bycat-list tg-haslayout spv4-listing">
				<div class="tg-featuredproviders tg-twocolumnsresult">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
							<div class="row">
								<div class="tg-listview tg-listviewvtwo">
								<?php
								if (!empty($user_query->results)) {
									foreach ($user_query->results as $user) {
										$username = listingo_get_username($user->ID);
										$useremail = $user->user_email;
										$userphone = $user->phone;
										if( !empty( $user->user_email ) ){
											$email = explode('@', $user->user_email);
										}

										$profile_view = apply_filters('sp_get_profile_views', $user->ID, 'set_profile_view');
										$profile_status	= get_user_meta($user->ID,'profile_status',true);

										//Gallery
										$list_gallery = array();
										if (!empty($user->profile_gallery_photos)) {
											$list_gallery = $user->profile_gallery_photos;
										}

										$category = get_user_meta($user->ID, 'category', true);

										if( function_exists('fw_get_db_post_option') ){
											$map_marker = fw_get_db_post_option($category, 'dir_map_marker', true);
										}

										$avatar = apply_filters(
												'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 92, 'height' => 92), $user->ID), array('width' => 92, 'height' => 92)
										);
										?>
										<div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
										  <div class="tg-automotive">
											<?php do_action('listingo_result_avatar_v2', $user->ID,'tg-featuredimg',array('width' => 285, 'height' => 225)); ?>
											<div class="tg-companycontent">
											  <div class="tg-featuredetails">
												<?php do_action('listingo_result_tags_v2', $user->ID); ?>
												<div class="tg-title">
													<h2><a href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><?php echo esc_attr($username); ?></a></h2>
												</div>
												<?php do_action('sp_get_rating_and_votes', $user->ID); ?>
												<ul class="tg-companycontactinfo">
												  <?php do_action('listingo_get_user_meta','phone',$user);?>
												  <?php do_action('listingo_get_user_meta','email',$user);?>
												</ul>
												<?php if( !empty( $list_gallery ) ){?>
													<ul class="tg-searchgallery">
													<?php 
														$totalitems		= count($list_gallery['image_data']);
														$list_gallery 	= !empty( $list_gallery['image_data'] ) ? $list_gallery['image_data'] : array();;
														$gcounter		= 0;
														$totalitems		= $totalitems - 4;

														foreach ($list_gallery as $key => $gitem) {
															$gcounter++;
															$thumb 		= !empty($gitem['thumb']) ? $gitem['thumb'] : '';
															$title  	= !empty($gitem['title']) ? $gitem['title'] : '';
															$image_id   = !empty($gitem['image_id']) ? $gitem['image_id'] : '';
															$moreclass	= '';

															$thumb		= listingo_prepare_image_source($image_id,85,62);

															$linkClass	= empty( $link ) ? 'sp-link-empty' : 'sp-link-available';

															if (strpos($thumb,'wp-includes/images/media') !== false) {
																$thumb	= '';
																$gcounter--;
															}

															if( $gcounter === 4 && $totalitems > 0 ){$moreclass	= 'tg-viewmore';}

															if (!empty($thumb) && $gcounter < 5) {?>
																<li class="<?php echo esc_attr($moreclass); ?>">
																	<?php if( $gcounter === 4 && $totalitems > 0 ){?>
																		<figure>
																			<img src="<?php echo get_template_directory_uri();?>/images/more-imgs.png" alt="<?php esc_html_e('more', 'listingo_vc_shortcodes'); ?>" >
																		</figure>
																		<a href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>" class="spviewmore">
																			<figure>
																				<img src="<?php echo esc_url($thumb); ?>" class="tg-viewmoreimg" alt="<?php echo esc_attr($title); ?>">
																				<span><?php esc_html_e('view', 'listingo_vc_shortcodes'); ?><em><?php esc_html_e('more', 'listingo_vc_shortcodes'); ?></em></span>
																			</figure>
																		</a>
																	<?php } else{?>
																		<figure>
																			<img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>">
																		</figure>
																	<?php }?>			
																</li>
															<?php }?>				
														 <?php }?>
													</ul>
												<?php }?>
											  </div>
											  <div class="tg-phonelike">
												<ul class="tg-searchinfo">
												  <li> <em><?php esc_html_e('No. of views', 'listingo_vc_shortcodes'); ?>:</em> <span><?php echo intval( $profile_view );?></span> </li>
												  <li> <em><?php esc_html_e('Member since', 'listingo_vc_shortcodes'); ?>:</em> <span><?php echo esc_attr(date_i18n(get_option('date_format'), strtotime($user->user_registered))); ?></span> </li>
												  <?php 
													if( !empty( $profile_status ) && $profile_status != 'sphide'){
														echo '<li>';
															listingo_get_profile_status('','echo',$user->ID);
														echo '</li>';
													} 
												  ?>
												</ul>
												<?php do_action('listingo_add_to_wishlist', $user->ID); ?>
											  </div>
											</div>
										  </div>
										</div>
										<?php
										}
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php if (!empty($total_users) && !empty($limit) && $total_users > $limit ) { ?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php listingo_prepare_pagination($total_users, $limit); ?>
					</div>
				<?php } ?>
          	</div>
            <?php
            echo ob_get_clean();
        }

    }

    new SC_VC_Skin_Listingo_Providers_Cat();
}
        