<?php

/**
 *
 * Class used as base to create theme Sub Header
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
if (!class_exists('Listingo_Prepare_TitleBar')) {

    class Listingo_Prepare_TitleBar {

        function __construct() {
            add_action('listingo_prepare_titlebars' , array (&$this , 'listingo_prepare_titlebars'));
        }

        /**
         * @Prepare Sub headers settings
         * @return {}
         * @author themographics
         */
        public function listingo_prepare_titlebars() {
            global $post;
			$page_id = '';
			
			$object_id = get_queried_object_id();
			$current_object_type	= get_post_type();
			
			//hide for post type and taxonomies
			$post_types = array('sp_ads');
			$taxonomies = array('ad_tags', 'ad_category', 'ad_amenity');
			if (is_singular($post_types)) {
				return false;
			}
			if ( is_tax( $taxonomies ) ) {
				return false;
			}
			
			//hide for taxanomies
			if (is_page_template('directory/search.php')) {
				$default_view = 'list';
				if (function_exists('fw_get_db_post_option')) {
					$default_view = fw_get_db_settings_option('dir_search_view');
				}

				if (!empty($_GET['view'])) {
					$default_view = esc_attr($_GET['view']);
				}
				if ( ( isset($default_view) && $default_view === 'list-default' ) || ( isset($default_view) && $default_view === 'grid-default')) {
					//do nothing
				} else{
					return false;
				}
			}
			
			
			/*if( is_tax( 'sub_category' )  
			   || is_tax( 'countries' ) 
			   || is_tax( 'cities' ) 
			   || is_tax( 'languages' ) 
			   || is_tax( 'amenities' ) 
			   || is_tax( 'insurance' )
			   || $current_object_type == 'sp_categories'
			   || apply_filters('listingo_check_to_show_title_bar', false)
			){
				$default_view = 'list';
				if (function_exists('fw_get_db_post_option')) {
					$default_view = fw_get_db_settings_option('dir_search_view');
				}

				if (!empty($_GET['view'])) {
					$default_view = esc_attr($_GET['view']);
				}
				if ( ( isset($default_view) && $default_view === 'list-default' ) || ( isset($default_view) && $default_view === 'grid-default')) {
					//do nothing
				} else{
					return false;
				}
			}*/
			
			
			if((get_option('show_on_front') && get_option('page_for_posts') && is_home()) ||
				(get_option('page_for_posts') && is_archive() && !is_post_type_archive()) && !(is_tax('product_cat') || is_tax('product_tag')) || (get_option('page_for_posts') && is_search())) {
					$page_id = get_option('page_for_posts');		
			} else {
				if(isset($object_id)) {
					$page_id = $object_id;
				}
			}
			
			if( is_404() 
				|| is_archive() 
				|| is_search() 
				|| is_category() 
				|| is_tag() 
			) {
				if(function_exists('fw_get_db_settings_option')){
					$titlebar_type 	= fw_get_db_settings_option('titlebar_type', true);
					if(  isset( $titlebar_type['gadget'] ) && $titlebar_type['gadget'] === 'default' && !is_author() ) {
						$this->listingo_get_titlebars($page_id);
					} 
				} else{
					$this->listingo_get_titlebars($page_id);
				}
			} else {
				if(function_exists('fw_get_db_settings_option')){
					$titlebar_type 		  = fw_get_db_post_option($page_id, 'titlebar_type', true);
					$default_titlebar_type 	= fw_get_db_settings_option('titlebar_type', true);
					
					if( isset( $titlebar_type ) && is_array( $titlebar_type ) ){
						if( isset( $titlebar_type ) && is_array( $titlebar_type ) ){
							if(  isset( $titlebar_type['gadget'] ) 
								&& $titlebar_type['gadget'] === 'rev_slider' 
								&& !empty( $titlebar_type['rev_slider']['rev_slider'] )
							){
								echo '<div class="serviceproviders-slider-container">';
								echo do_shortcode( '[rev_slider '.$titlebar_type['rev_slider']['rev_slider'].']' );
								echo '</div>';
							}else if(  isset( $titlebar_type['gadget'] ) 
								&& $titlebar_type['gadget'] === 'custom_shortcode' 
								&& !empty( $titlebar_type['custom_shortcode']['custom_shortcode'] )
							){
								echo '<div class="serviceproviders-shortcode-container">';
								echo do_shortcode( $titlebar_type['custom_shortcode']['custom_shortcode'] );
								echo '</div>';
							} else if(  isset( $titlebar_type['gadget'] ) 
								&& $titlebar_type['gadget'] === 'default' 
							){
								$titlebar_type 	= fw_get_db_settings_option('titlebar_type', true);
								if(  isset( $titlebar_type['gadget'] ) && $titlebar_type['gadget'] === 'default' ) {
									$this->listingo_get_titlebars($page_id);
								} 
							} else if( isset( $titlebar_type['gadget'] ) 
								&& $titlebar_type['gadget'] === 'custom' 
							){
								$this->listingo_get_titlebars($page_id);
							} else if(  isset( $titlebar_type['gadget'] ) 
								&& $titlebar_type['gadget'] === 'none' 
							){
								//do nothing
							} else{
								if(  isset( $default_titlebar_type['gadget'] ) && $default_titlebar_type['gadget'] === 'none') {
									//do nothing
								} else{
									$this->listingo_get_titlebars($page_id);
								}
							}
						} else{
							if(  isset( $default_titlebar_type['gadget'] ) && $default_titlebar_type['gadget'] === 'none') {
								//do nothing
							} else{
								$this->listingo_get_titlebars($page_id);
							}
						}
					}else{
						if(  isset( $default_titlebar_type['gadget'] ) && $default_titlebar_type['gadget'] === 'none') {
							//do nothing
						} else{
							$this->listingo_get_titlebars($page_id);
						}
					}
				} else{
					$this->listingo_get_titlebars($page_id);
				}
			}
        }
        
        /**
         * @Prepare Subheaders
         * @return {}
         * @author themographics
         */
        public function listingo_get_titlebars($page_id='') {
			global $post;
			$title = '';
			$page_title		= false;
			$titlebar_bg 	= 'rgba(54, 59, 77, 0.40)';
			
			if( is_404() 
				|| is_archive() 
				|| is_search() 
				|| is_category() 
				|| is_tag() 
			) {
				
				if(function_exists('fw_get_db_settings_option')){
					$titlebar_type 	= fw_get_db_settings_option('titlebar_type', true);
					if(  isset( $titlebar_type['gadget'] ) 
					   	 && $titlebar_type['gadget'] === 'default' 
					) {
						$titlebar_type 	= fw_get_db_settings_option('titlebar_type', true);
						$titlebar_bg_image 	    = !empty( $titlebar_type['default']['titlebar_bg_image']['url'] ) ? $titlebar_type['default']['titlebar_bg_image']['url'] : get_template_directory_uri().'/images/pt.jpg';
						$titlebar_bg 	    	= !empty( $titlebar_type['default']['titlebar_bg'] ) ? $titlebar_type['default']['titlebar_bg'] : 'rgba(54, 59, 77, 0.40)';
						$enable_breadcrumbs 	= !empty( $titlebar_type['default']['enable_breadcrumbs'] ) ? $titlebar_type['default']['enable_breadcrumbs'] : '';
						$titlebar_style 	= !empty( $titlebar_type['default']['titlebar_style'] ) ? $titlebar_type['default']['titlebar_style'] : 'style_1';
					} else{
						$titlebar_bg_image 	= get_template_directory_uri().'/images/pt.jpg';;
						$titlebar_bg 		= 'rgba(54, 59, 77, 0.40)';
						$enable_breadcrumbs = '';
						$titlebar_style = 'style_1';
					}
				} else{
					$titlebar_bg_image 	= get_template_directory_uri().'/images/pt.jpg';;
					$titlebar_bg 		= 'rgba(54, 59, 77, 0.40)';
					$enable_breadcrumbs = '';
					$titlebar_style = 'style_1';
				}
				
				
				$background_image	= '';
				
				if( isset( $titlebar_bg_image['url'] ) && !empty( $titlebar_bg_image['url'] ) ) {
					$background_image = $titlebar_bg_image['url'];
				} else if( isset( $titlebar_bg_image ) && !empty( $titlebar_bg_image ) ) {
					 $background_image = $titlebar_bg_image;
				}
				
				
				if (is_404()) {
 					$title = esc_html__('404', 'listingo');
                } else if( class_exists( 'Woocommerce' ) 
					&& is_woocommerce() 
					&& ( is_product() || is_shop() ) 
					&& ! is_search() 
				) {
					if( ! is_product() ) {
						$title = woocommerce_page_title( false );
					} else{
						$title = esc_html__('Archive', 'listingo');
					}
				}else if ( is_category() ) {
                    $title = single_cat_title("", false);
                } else if ( is_archive() ) {
                    $title = esc_html__('Archive', 'listingo');
                } else if (is_search()) {
                    $title = esc_html__('Search', 'listingo');
                }
					
					
			} else{
				
				$object_id = get_queried_object_id();
				if((get_option('show_on_front') && get_option('page_for_posts') && is_home()) ||
					(get_option('page_for_posts') && is_archive() && !is_post_type_archive()) && !(is_tax('product_cat') || is_tax('product_tag')) || (get_option('page_for_posts') && is_search())) {
						$page_id = get_option('page_for_posts');		
				} else {
					if(isset($object_id)) {
						$page_id = $object_id;
					}
				}
						
				if(function_exists('fw_get_db_settings_option')){
					$titlebar_type 		= fw_get_db_post_option($page_id, 'titlebar_type', true);
					if(  isset( $titlebar_type['gadget'] ) && ( $titlebar_type['gadget'] === 'custom' ) ){
						$titlebar_bg_image 	    = !empty( $titlebar_type['custom']['titlebar_bg_image']['url'] ) ? $titlebar_type['custom']['titlebar_bg_image']['url'] : get_template_directory_uri().'/images/pt.jpg';
						$titlebar_bg 	    	= !empty( $titlebar_type['custom']['titlebar_bg'] ) ? $titlebar_type['custom']['titlebar_bg'] : 'rgba(0,0,0,0.3)';
						$enable_breadcrumbs 	= !empty( $titlebar_type['custom']['enable_breadcrumbs'] ) ? $titlebar_type['custom']['enable_breadcrumbs'] : '';
						$titlebar_style 	= !empty( $titlebar_type['custom']['titlebar_style'] ) ? $titlebar_type['custom']['titlebar_style'] : 'style_1';
					} else {
						$titlebar_type 	= fw_get_db_settings_option('titlebar_type', true);
						$titlebar_bg_image 	    = !empty( $titlebar_type['default']['titlebar_bg_image']['url'] ) ? $titlebar_type['default']['titlebar_bg_image']['url'] : get_template_directory_uri().'/images/pt.jpg';
						$titlebar_bg 	    	= !empty( $titlebar_type['default']['titlebar_bg'] ) ? $titlebar_type['default']['titlebar_bg'] : 'rgba(54, 59, 77, 0.40)';
						$enable_breadcrumbs    	= !empty( $titlebar_type['default']['enable_breadcrumbs'] ) ? $titlebar_type['default']['enable_breadcrumbs'] : '';
						$titlebar_style    	= !empty( $titlebar_type['default']['titlebar_style'] ) ? $titlebar_type['default']['titlebar_style'] : 'style_1';
					}
					
				} else{
					$titlebar_bg_image 	    = get_template_directory_uri().'/images/pt.jpg';
					$titlebar_bg 			= 'rgba(54, 59, 77, 0.40)';
					$enable_breadcrumbs 	= '';
					$titlebar_style 		= 'style_1';
				}
				
				$background_image	= '';

				if( isset( $titlebar_bg_image['url'] ) && !empty( $titlebar_bg_image['url'] ) ) {
					$background_image	= $titlebar_bg_image['url'];
				} else if( isset( $titlebar_bg_image ) && !empty( $titlebar_bg_image ) ) {
					 $background_image = $titlebar_bg_image;
				}
				
				
				//Title
				if( empty( $title ) ) {
					$title	= get_the_title( $page_id );
				}
			}
			
			if( isset( $titlebar_style ) && $titlebar_style === 'style_2' ){
				$background_image	= is_ssl() ? preg_replace("/^http:/i", "https:", $background_image ) : $background_image ;
			}else{
				if(  !empty( $background_image ) ) {
					$background_image	= is_ssl() ? preg_replace("/^http:/i", "https:", $background_image ) : $background_image ;
					$background_image = 'data-appear-top-offset="600" data-parallax="scroll" data-image-src="'.$background_image.'"';
				}
			}

			if( class_exists( 'Woocommerce' ) 
				&& is_woocommerce() 
				&& ( is_product() || is_shop() ) 
				&& ! is_search() 
			) {
				if( ! is_product() ) {
					$title = woocommerce_page_title( false );
				}
			}
		  
		  if( isset( $titlebar_style ) && $titlebar_style === 'style_2' ){
		  ?>
          <div id="tg-innerbanner" class="system-titlebar tg-innerbanner tg-haslayout">
			<figure class="tg-innerbannerimg">
				<img src="<?php echo esc_url( $background_image );?>" alt="<?php esc_html__('Banner', 'listingo');?>">
			</figure>
			<?php if( isset( $enable_breadcrumbs ) && $enable_breadcrumbs == 'enable' ) {?>
			<div class="tg-innerpagebannervtwo">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<?php if( function_exists('fw_ext_breadcrumbs') ) { fw_ext_breadcrumbs(''); }?>
						</div>
					</div>
				</div>
			</div>
		  </div>
          <?php } }else{?>
			  <div class="tg-innerpagebanner" <?php echo( $background_image );?>>
				 <div class="tg-pageinnerbanner tg-parallaximg tg-innerbannerimg" style="background:<?php echo esc_attr($titlebar_bg);?>">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="tg-pagetitle">
									<?php if( !empty( $title ) ){?><h1><?php echo esc_attr($title);?></h1><?php }?>
									<?php
										if( isset( $enable_breadcrumbs ) && $enable_breadcrumbs == 'enable' ) {
											if( function_exists('fw_ext_breadcrumbs') ) { fw_ext_breadcrumbs(''); }
										}
									?>
								</div>
							</div>
						</div>
					</div>
				 </div>
			  </div>
			<?php
			}
		}
    }
    new Listingo_Prepare_TitleBar();
}