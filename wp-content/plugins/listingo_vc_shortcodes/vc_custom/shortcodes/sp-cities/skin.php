<?php
/**
 * @ Visual Composer Shortcode
 * @ Class SP Categories
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_SP_Cities')) {

    class SC_VC_Skin_SP_Cities extends SC_VC_Core {

        public function __construct() {

            add_shortcode("listingo_vc_sp_cities", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "category_heading"  => '',
                "cities"            => '',        
                "link"              => '',
                "custom_id"         => '',
                "custom_classes"    => '',
                "css"               => '',
                ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_sp_cities', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;
            
            //preparing link
            $real_link = '';
            if (!empty($link)) {
                $real_link = vc_build_link($link);
            }
            $title      = !empty($real_link['title']) ? $real_link['title'] : '';
            $target     = !empty($real_link['target']) ? $real_link['target'] : '_self';
            $link_url   = !empty($real_link['url']) ? $real_link['url'] : '#'; 
            
            ob_start();
            ?>
            <div class="sc-cities tg-haslayout tg-paddingzero <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <div class="row">
                    <?php if (!empty($category_heading) || !empty($content)) { ?>
                        <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
                            <div class="tg-sectionhead">
                                <?php if (!empty($category_heading)) { ?>
                                    <div class="tg-sectiontitle">
                                        <h2><?php echo esc_attr($category_heading); ?></h2>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($content)) { ?>
                                    <div class="tg-description">
                                        <?php echo wp_kses_post(wpautop(do_shortcode($content))); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ( !empty( $cities ) ) { ?>
                        <div class="tg-popularcities">                  
                        <?php 
                            $terms = get_terms( array(
                                'taxonomy' => 'cities',
                                'include' => $cities,
                                'hide_empty' => 0
                            ) );

                            if ( !empty( $terms ) ){                            
								foreach ( $terms as $key => $value ) {
									$country_name = '';					 
									$get_cities_meta = fw_get_db_term_option( $value->term_id, 'countries' );
									if (!empty($get_cities_meta['country'][0])) {
										$country_id = $get_cities_meta['country'][0];
										$country_term = get_term($country_id, 'countries');
										$country_name = $country_term->slug;						    					  
									}

									$city_name = $value->slug;	
									$custom_url = "?country=".$country_name."&city=".$city_name;							
									$term_data = fw_get_db_term_option( $value->term_id, 'cities' );						
									$cat_image = !empty( $term_data['image']['url'] ) ? $term_data['image']['url'] : get_template_directory_uri().'/images/locations/city.jpg';
									$total_users	= listingo_get_total_users_under_taxanomy($city_name,'number','city');
								?>                                      
                                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 tg-verticaltop">
                                    <div class="tg-topcity">
                                        <figure class="tg-cityimg">                                 
                                            <img src="<?php echo esc_url( $cat_image ); ?>" alt="<?php esc_html_e('City Image', 'listingo_vc_shortcodes'); ?>">                                   
                                            <figcaption>                                        
                                                <h3><a href="<?php echo esc_url( get_term_link( $value->term_id, 'cities' ) ); ?>"><?php echo esc_attr( $value->name ); ?></a></h3>
                                                <span><?php echo esc_attr( $total_users ); ?>&nbsp;<?php esc_html_e('Listings', 'listingo_vc_shortcodes'); ?></span>                                     
                                            </figcaption>
                                        </figure>
                                    </div>
                                </div>
                            <?php } } ?>
                        </div>
                    <?php } ?>
                    <?php 
                    if ( !empty( $link ) ) {                        
                        if ( !empty( $title ) ) {
                    ?>  
                        <div class="tg-btnbox">
                            <a class="tg-btn tg-btnviewall" target="<?php echo esc_attr( $target ); ?>" href="<?php echo esc_attr( $link_url ); ?>"><?php echo esc_attr( $title ); ?></a>
                        </div>
                    <?php } } ?>  
                </div>
            </div>
            <?php
            return ob_get_clean();
        }
    }

    new SC_VC_Skin_SP_Cities();
}


