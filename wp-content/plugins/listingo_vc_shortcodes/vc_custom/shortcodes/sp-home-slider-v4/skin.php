<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Home_Search_slider_four')) {

    class SC_VC_Skin_Listingo_Home_Search_slider_four extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_search_form_home_slider_four", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "posts"             => '',   
                "geo_type"          => '', 
                "pro_title"         => '',
				"ad_title"          => '',
				"pro_tab_title"     => '',   
                "pro_sub_title"     => '', 
                "ad_tab_title"      => '',
                "ad_sub_title"      => '',
                "ad_button"         => '',
                "provider_button"   => '',
                "sub_title"         => '',
                "sub_title_below"   => '',
                "time_out"          => intval(5000),
                "custom_classes"    => '',
                "autoplay"          => 'false',
                "show_nav"          => 'false',
                "progress"          => 'false',
                "pause_on_hover"    => 'false',
                "responsive"        => 'true',
                "scroll"            => 'false',
                "height"            => intval(445),
                "custom_id" 		=> '',
                "custom_classes" 	=> '',
                "css" 				=> '',
                            ), $args)); 
           
                $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_search_form_home_slider_four', $args);
				$classes = array();
                $classes[] = $custom_classes;
                $classes[] = $css_class;	

                $pro_title       = !empty( $pro_title ) ? $pro_title : esc_html__('Providers', 'listingo_vc_shortcodes');
                $ad_title        = !empty( $ad_title ) ? $ad_title : esc_html__('Ads', 'listingo_vc_shortcodes');
                $ad_button       = !empty( $ad_button ) ? $ad_button : esc_html__('Start Your Search','listingo_vc_shortcodes');
                $provider_button = !empty( $provider_button )  ? $provider_button : esc_html__('Start Your Search','listingo_vc_shortcodes');
                
				
				if ( function_exists('fw_get_db_settings_option') && fw_ext('ads')) {
					$classes[] = 'sp-both-search';
				} else{
					$classes[] = 'sp-single-search';
				}
			
				//Arguments
				$search_page    	= '';
				if( function_exists('listingo_get_ads_search_page_uri') ){
					$search_page    	= listingo_get_ads_search_page_uri();
				}
                
                $dir_location       = '';
                if( function_exists('fw_get_db_settings_option')){
                    $dir_location       = fw_get_db_settings_option('dir_location');
					$dir_keywords = fw_get_db_settings_option('dir_keywords');
                }

                if( !intval( $height ) || empty( $height ) ) {
                    $height = intval(445);
                }
			
                if( !intval( $time_out ) || empty( $time_out ) ) {
                    $time_out = intval(5000);
                }
                
                $posts_in['post__in'] = !empty($posts) ? explode(',', $posts) : array();
			
                //posts Query 
                $query_args = array(
                    'posts_per_page' => -1,
                    'post_type' => 'sp_categories',    
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => 1);

                if (!empty($posts_in)) {
                    $query_args = array_merge($query_args, $posts_in);
                }
			
                $query = new WP_Query($query_args);
                if( $query->have_posts() ){ 
					wp_enqueue_script('pogoslider');
					wp_enqueue_style('pogoslider');

					//counter          
					$counter = rand(1,99999); 
					ob_start();
				?>
				<div class="sp-sc-counter tg-homeslidervfourhold tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
					<div id="tg-homeslidervfour-<?php echo esc_attr( $counter ); ?>" class="tg-homeslidervfour tg-homeslider tg-haslayout">
						<?php 
						while( $query->have_posts() ){ 
							$query->the_post(); 
							global $post; 
							$default_banner	= listingo_get_category_banner(array(1920,510),$post->ID);
						if( !empty( $default_banner ) ) {?>
						<div class="pogoSlider-slide tg-borderimg" data-transition="fade" data-duration="2000" style="background:url(<?php echo esc_url( $default_banner ) ; ?>) no-repeat scroll 0 0;">
							<div class="tg-slidercontenthold">
								<div class="container">
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 pull-right">
											<div class="row">
												  <div class="tg-slidercontent pogoSlider-slide-element" data-in="slideLeft" data-out="slideLeft" data-duration="0">
													<div class="tg-slidertitle">
														<?php if( !empty( $sub_title ) ) { ?>
															<span class="tg-subtitle">
																<?php echo esc_attr( $sub_title ); ?>
															</span>
														<?php } ?>
														<h2><?php the_title(); ?></h2>
													</div>
													<?php if( !empty( $sub_title_below ) ) { ?>
														<div class="tg-description">
															<p><?php echo esc_attr( $sub_title_below ); ?></p>
														</div>
													<?php } ?>
													<div class="tg-btns">
														<a class="tg-btn tg-btnvtwo tg-btnwithicon" href="<?php the_permalink(); ?>"><?php esc_html_e('View All', 'listingo_vc_shortcodes'); ?><i class="lnr lnr-arrow-right"></i></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php } } wp_reset_postdata(); ?>
					</div>                    
					<div class="tg-bannertabs">
						<div class="container">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 pull-left">
									<div class="tg-tabnavhold">
										<ul class="tg-tabnav tg-tabnavtwo" role="tablist">
											<li role="presentation" class="active">
												<a href="#regularuser" data-toggle="tab" aria-expanded="true">
													<div class="tg-navcontent">
														<div class="tg-navcontent">
															<span><?php echo esc_attr( $pro_title ); ?></span>
														</div>
													</div>
												</a>
											</li>
											<?php if ( function_exists('fw_get_db_settings_option') && fw_ext('ads')) {?>
												<li role="presentation" class="">
													<a href="#company" data-toggle="tab" aria-expanded="false">
														<div class="tg-navcontent">
															<div class="tg-navcontent">
																<span><?php echo esc_attr( $ad_title ); ?></span>
															</div>
														</div>
													</a>
												</li>
											<?php } ?>
										</ul>
										<div class="tg-searchbox tg-searchboxvtwo tab-content">
											<form class="tg-formtheme tg-formsearch tab-pane active fade in" id="regularuser" action="<?php echo listingo_get_search_page_uri();?>" method="get">
													<fieldset>
														<?php if( !empty( $pro_tab_title ) || !empty( $pro_sub_title ) ) { ?>
															<legend class="tg-formtitle">
																<?php 
																if( !empty( $pro_sub_title ) ) { ?>
																	<span>
																	<?php echo esc_attr( $pro_sub_title ); ?>
																	</span>
																<?php } ?>
																<?php if( !empty( $pro_tab_title ) ){ 
																	echo esc_attr( $pro_tab_title );
																} ?>
															</legend>
														<?php } ?>   
														<?php if (!empty($dir_keywords) && $dir_keywords === 'enable') { ?>                                
															<div class="form-group tg-inputwithicon">
																<i class="lnr lnr-magnifier"></i>          
																<?php do_action('listingo_get_search_keyword'); ?>
															</div>
														<?php } ?>   
														<?php 
														if( isset( $geo_type ) && $geo_type === 'countries' ){ ?>
															<div class="form-group tg-inputwithicon">
																<i class="lnr lnr-map-marker"></i>
																<?php do_action('listingo_get_countries_list'); ?>
															</div>
														<?php } else {
															if (!empty($dir_location) && $dir_location === 'enable') { ?>
																<div class="form-group tg-inputwithicon">
																	<i class="lnr lnr-map-marker"></i>
																	<?php do_action('listingo_get_search_geolocation'); ?>
																</div>
															<?php }?>
														<?php } ?>                         
														<div class="form-group tg-inputwithicon">
															<i class="lnr lnr-layers"></i>
															<?php do_action('listingo_get_search_category'); ?>
														</div>       
														<div class="tg-btns">
															<button class="tg-btn tg-btnvtwo" type="submit"><?php echo esc_attr( $provider_button ); ?></button>
														</div>
														<div class="tg-filterholder">
															<div class="tg-title"><h4><?php esc_html_e('Misc :', 'listingo_vc_shortcodes'); ?></h4></div>
															<div class="tg-checkboxgroupvtwo">
																<span class="tg-checkboxvtwo">
																	<input type="checkbox" id="tg-appointment1" name="appointment" value="true">
																	<label for="tg-appointment1">
																		<span><?php esc_html_e('Online Appointment', 'listingo_vc_shortcodes'); ?></span>
																	</label>
																</span>
																<span class="tg-checkboxvtwo">
																	<input type="checkbox" id="tg-profile1" name="photo" value="true">
																	<label for="tg-profile1">
																		<span><?php esc_html_e('With Profile Photo', 'listingo_vc_shortcodes'); ?></span>
																	</label>
																</span>
															</div>
														</div>
													</fieldset>
											</form>
											<?php if ( function_exists('fw_get_db_settings_option') && fw_ext('ads')) {?>
												<form class="tg-formtheme tg-formsearch tab-pane fade in" id="company" action="<?php echo esc_url( $search_page );?>" method="get">
													<fieldset>
														<?php if( !empty( $ad_tab_title ) || !empty( $ad_sub_title ) ) { ?>
															<legend class="tg-formtitle">
																<?php if( !empty( $ad_sub_title ) ) { ?>
																	<span><?php echo esc_attr( $ad_sub_title ); ?></span>
																<?php } ?>
																<?php if( !empty( $ad_tab_title ) ) {
																	echo esc_attr( $ad_tab_title );
																} ?>
															</legend>
														<?php } ?>                                
														<div class="form-group tg-inputwithicon">
															<i class="lnr lnr-magnifier"></i>
															<?php do_action('listingo_get_search_keyword'); ?>
														</div>                                       
														<?php 
														if( isset( $geo_type ) && $geo_type === 'countries' ){ ?>
															<div class="form-group tg-inputwithicon">
																<i class="lnr lnr-map-marker"></i>
															<?php do_action('listingo_get_countries_list'); ?>
															</div>
														<?php } else {
															if (!empty($dir_location) && $dir_location === 'enable') { ?>
																<div class="form-group tg-inputwithicon">
																	<i class="lnr lnr-map-marker"></i>
																	<?php do_action('listingo_get_ads_search_geolocation'); ?>
																</div>
															<?php }?>
														<?php } ?>
														<div class="form-group tg-select tg-inputwithicon">
															<i class="lnr lnr-layers"></i>
															<?php do_action('listingo_get_ad_category_filter');?>
														</div>
														<div class="tg-btns">
															<button class="tg-btn tg-btnvtwo" type="submit"><?php echo esc_attr( $ad_button ); ?></button>
														</div>                                  
													</fieldset>
												</form>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            <?php
				$script = '
				jQuery(document).ready(function(){
					var mySlider = jQuery("#tg-homeslidervfour-'.esc_js($counter).'").pogoSlider({
						autoplay: '.esc_js($autoplay).',
						generateNav: '.esc_js($show_nav).',
						displayProgess: '.esc_js($progress).',
						pauseOnHover: '.esc_js($pause_on_hover).',
						targetHeight: '.esc_js($height).',
						responsive: '.esc_js($responsive).',
						autoplayTimeout: '.esc_js($time_out).',
						generateButtons:'.esc_js($scroll).',
					}).data("plugin_pogoSlider");});';
				wp_add_inline_script('listingo_callbacks', $script, 'after');
            }                       
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_Listingo_Home_Search_slider_four();
}
