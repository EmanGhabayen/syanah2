<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Blog Posts
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Featured_Listing_V2')) {

    class SC_VC_Skin_Listingo_Featured_Listing_V2 extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_featured_listing_v2", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {
            extract(shortcode_atts(array(
                "heading" => '',
                "sub_heading" => '',
                "posts_by" => 'by_catgories',
                "categories" => '',
                "specific_posts" => '',
                "no_of_posts" => 10,
                "show_pagination" => '',
                "btn" => 'yes',
                "order" => '',
                "orderby" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_featured_listing_v2', $args);
            $classes = array();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            //testing starts
            $today = time();
            $pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
            $pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
            //paged works on single pages, page - works on homepage
            $paged = max($pg_page, $pg_paged);

            if (isset($posts_by) && $posts_by === 'by_users' && !empty($specific_posts)
            ) {
                $users_list = explode(',', $specific_posts);
            } else {
                $cat_sepration = array();
                if (isset($categories) && !empty($categories)) {
                    $cat_sepration = explode(',', $categories);
                }
            }

            $show_users = !empty($no_of_posts) ? $no_of_posts : 9;
            $order = !empty($order) ? $order : 'DESC';
            $show_pagination = !empty($show_pagination) ? $show_pagination : '';
            $uniq_flag = rand(1, 99999);
            $limit = (int) $show_users;

            $query_args = array(
                'role__in' => array('professional', 'business'),
                'order' => $order,
            );

            if (!empty($cat_sepration)) {
                foreach ($cat_sepration as $key => $value) {
                    $meta_category[] = array(
                        'key' => 'category',
                        'value' => $value,
                        'compare' => '='
                    );
                }
            }

            $meta_query_args	= array();
			//Verify user
			$meta_query_args[] = array(
				'key' 		=> 'verify_user',
				'value' 	=> 'on',
				'compare'   => '='
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

            //By Categories
            if (!empty($meta_category)) {
                $query_relations = array('relation' => 'OR',);
                $meta_query_args = array_merge($query_relations, $meta_category);
                $query_args['meta_query'][] = $meta_query_args;
            }

            //Featured
            $expiry_args = array(
                'key' => 'subscription_featured_expiry',
                'value' => 0,
                'type' => 'numeric',
                'compare' => '>'
            );

            $query_args['meta_query'][] = $expiry_args;
            $query_args['meta_key'] = 'subscription_featured_expiry';
            $query_args['orderby'] = 'meta_value';

            //By users
            if (!empty($users_list)) {
                $query_args['include'] = $users_list;
            }

            if (!empty($limit) && (!empty($show_pagination) && $show_pagination === 'on' )) {
                $offset = ($paged - 1) * $limit;
            } else {
                $limit = (int) $show_users;
                $offset = 0;
            }

            $query_args['number'] = $limit;
            $query_args['offset'] = $offset;

            //testing ends 
            ob_start();
            ?>
            <div class="sp-featured-providers-v2 tg-haslayout spv4-listing <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <div class="tg-featuredproviders tg-listview">
                    <div class="row">
                        <?php if (!empty($heading) || !empty($sub_heading)) { ?>
                            <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
                                <div class="tg-sectionheadvtwo">
                                    <div class="tg-sectiontitle">
                                        <?php if (!empty($heading)) { ?><span><?php echo esc_attr($heading); ?></span><?php } ?>
                                        <?php if (!empty($sub_heading)) { ?><h2><?php echo esc_attr($sub_heading); ?></h2><?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        $this->listingo_vc_listing_view($query_args, $show_pagination, $limit, $btn);
                        ?>
                    </div>
                </div>
            </div>      
            <?php
            return ob_get_clean();
        }

        /**
         * Blog Grid View
         */
        public function listingo_vc_listing_view($query_args = array(), $show_pagination = 'off', $limit = 0, $btn = 'yes') {
            ob_start();
			$user_query = new WP_User_Query($query_args);
            ?>				
            <div class="tg-featuredproviders">
				<div class="row">
					<?php
					if (!empty($user_query->results)) {
						foreach ($user_query->results as $user) {
							$username = listingo_get_username($user->ID);
							?>
							<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 tg-verticaltop">
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
					} else {
						?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<?php Listingo_Prepare_Notification::listingo_info(esc_html__('Sorry!', 'listingo_vc_shortcodes'), esc_html__('Nothing found.', 'listingo_vc_shortcodes')); ?>
						</div>
					<?php } ?>
					<?php if (!empty($btn) && $btn === 'yes') { ?>
						<div class="tg-btnboxvtwo">
							<a class="tg-btn tg-btnvtwo" href="<?php echo listingo_get_search_page_uri(); ?>"><?php esc_html_e('View all', 'listingo_vc_shortcodes'); ?></a>
						</div>
					<?php } ?>
				</div>
          	</div>
            <?php
            echo ob_get_clean();
        }

    }

    new SC_VC_Skin_Listingo_Featured_Listing_V2();
}
        