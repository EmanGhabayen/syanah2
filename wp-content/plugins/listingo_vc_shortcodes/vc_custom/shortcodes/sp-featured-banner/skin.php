<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Blog Posts
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Featured_Listing_Banner')) {

    class SC_VC_Skin_Listingo_Featured_Listing_Banner extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_featured_listing_banner", array(
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
                "categories" => array(),
                "no_of_posts" => 10,
                "order" => '',
                "custom_columns" => '',
                "column_lg" => '',
                "column_md" => '',
                "column_sm" => '',
                "column_xs" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_featured_listing_banner', $args);

            $classes[] = $custom_classes;
            $classes[] = $css_class;

            if (isset($custom_columns) && $custom_columns === 'yes') {
                $item_classes = $column_xs . ' ' . $column_sm . ' ' . $column_md . ' ' . $column_lg;
            } else {
                $item_classes = 'col-xs-6 col-sm-6 col-md-4 col-lg-4';
            }
            
            $today = time();
            $cat_sepration = array();
            if (isset($categories) && !empty($categories)) {
                $cat_sepration = explode(',', $categories);
            } 
            $show_users = !empty( $no_of_posts ) ? $no_of_posts : 10;
            $order       = !empty( $order ) ? $order : 'DESC';
            $uniq_flag = rand(1,99999);

            $query_args = array(
                'role__in' => array('professional', 'business'),
                'order'  => $order,
                'number' => $show_users 
             );

            if( !empty( $cat_sepration ) ) {
                foreach( $cat_sepration as $key => $value ){
                    $meta_category[] = array(
                                    'key'     => 'category',
                                    'value'   => $value,
                                    'compare' => '='
                                );
                }
                
            }

            //Verify user
            $meta_query_args[] = array(
                'key'       => 'verify_user',
                'value'     => 'on',
                'compare'   => '='
            );
            //active users filter
            $meta_query_args[] = array(
                'key'       => 'activation_status',
                'value'     => 'active',
                'compare'   => '='
            );

            $meta_query_args[] = array(
                'key'     => 'subscription_featured_expiry',
                'value'   => 0,
                'type'    => 'numeric',
                'compare' => '>'
            );

            if( !empty( $meta_query_args ) ) {
                $query_relation = array('relation' => 'AND',);
                $meta_query_args    = array_merge( $query_relation,$meta_query_args );
                $query_args['meta_query'] = $meta_query_args;
            }

            //By Categories
            if( !empty( $meta_category ) ) {
                $query_relations = array( 'relation' => 'OR',);
                $meta_query_args    = array_merge( $query_relations, $meta_category );
                $query_args['meta_query'][] = $meta_query_args;
            }

            $query_args['meta_key']    = 'subscription_featured_expiry';
            $query_args['orderby']     = 'meta_value';
            //testing ends 
            ob_start();
				?>
				<div class="sp-featured-providers tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
					<?php $this->listingo_vc_prepare_slider($query_args);?>
				</div>
				<?php
			return ob_get_clean();
        }

        /**
         * Slider View
         */
		public function listingo_vc_prepare_slider($query_args = array()) {
			ob_start();
			$query = new WP_Query($query_args);
			if (!empty($query)) {
				?>				
                <div class="sp-featured-provider-banner tg-haslayout">
                   <div class="tg-featuredprofiles">
                      <h1>
                        <span><?php esc_html_e('Featured','listingo_vc_shortcodes');?></span>
                        <span><?php esc_html_e('Providers','listingo_vc_shortcodes');?></span>
                      </h1>
                      <div id="tg-featuredprofileslider" class="tg-featuredprofileslider owl-carousel">
                        <?php 
                        $user_query = new WP_User_Query($query_args);
                        if (!empty($user_query->results)) {
                            $sp_userslist['status'] = 'found';

                            if (!empty($sp_category)) {
                                $title = get_the_title($sp_category);
                                $postdata = get_post($sp_category);
                                $slug = $postdata->post_name;
                            } else {
                                $title = '';
                                $slug = '';
                            }

                            foreach ($user_query->results as $user) {
                                $username = listingo_get_username($user->ID);
                                $avatar = apply_filters(
                                        'listingo_get_media_filter', 
                                        listingo_get_user_avatar(array('width' => 92, 'height' => 92), $user->ID), 
                                        array('width' => 92, 'height' => 92)
                                );
                                
                                $user_banner = apply_filters(
                                        'listingo_get_media_filter', 
                                        listingo_get_user_banner(array('width' => 1920, 'height' => 380), $user->ID), 
                                        array('width' => 1920, 'height' => 380) //size width,
                                );
                                ?>
                                <div class="item tg-profile tg-featuredprofile">
                                  <figure style="background-image:url(<?php echo esc_url( $user_banner );?>);">
                                    <figcaption>
                                      <div class="tg-featuredprofilecontent">
                                        <div class="tg-contentbox">
                                          <div class="tg-companylogo"><a href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><img src="<?php echo esc_url($avatar); ?>" alt="<?php esc_html_e('Profile Avatar', 'listingo_vc_shortcodes'); ?>"></a></div>
                                          <div class="tg-companycontent">
                                            <?php do_action('listingo_result_tags', $user->ID); ?>
                                            <div class="tg-title">
                                              <h3><a href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><?php echo esc_attr($username); ?></a></h3>
                                            </div>
                                            <?php do_action('sp_get_rating_and_votes', $user->ID); ?>
                                          </div>
                                        </div>
                                        <a class="tg-btn" href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><?php esc_html_e('View Profile', 'listingo_vc_shortcodes'); ?></a> </div>
                                    </figcaption>
                                  </figure>
                                </div>
                        <?php }}?>
                       </div>
                       <?php
                       $script = "                            
                            jQuery(window).on('load', function(){
                                jQuery('#tg-featuredprofileslider').owlCarousel({
                                    items:1,
                                    nav:true,
                                    loop:true,
                                    autoplay:false,
                                    rtl: ".listingo_owl_rtl_check().",
                                    smartSpeed:450,
                                    navClass: ['tg-btnprev', 'tg-btnnext'],
                                    animateOut: 'fadeOut',
                                    animateIn: 'fadeIn',
                                    navContainerClass: 'tg-featuredprofilesbtns',
                                    navText: [
                                                '<span><em>prev</em><i class=\"fa fa-angle-left\"></i></span>',
                                                '<span><i class=\"fa fa-angle-right\"></i><em>next</em></span>',
                                            ],
                                });
                            });";
                       wp_add_inline_script('owl.carousel', $script, 'after');
                            
                       ?>
                    </div>
                </div>
                </div>
				<?php
			}
			echo ob_get_clean();
		}
   
    }

    new SC_VC_Skin_Listingo_Featured_Listing_Banner();
}
        