<?php 
/**
 *
 * The template used for displaying ad post style
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $post, $current_user;
do_action('sp_set_posttype_views', $post->ID, 'ad_views','ads_view_count');
get_header();
?>
<div class="spv-ads-single tg-haslayout">
	<?php
	while (have_posts()) { the_post(); 
	global $post;		
		$favorite_ads 		= '';
		$ad_views 			= '';
		$average_ratings 	= listingo_get_comment_average_ratings( $post->ID );		
		$favorite_ads 		= get_post_meta($post->ID, 'favorite_ads', true);
		$favorite_ads 		= !empty( $favorite_ads ) ? $favorite_ads : 0;
		$ad_views 			= get_post_meta($post->ID, 'ad_views', true);
		$gallery 			= array();
		if ( function_exists('fw_get_db_post_option') ) {
			$gallery 		= fw_get_db_post_option( $post->ID, 'gallery', true );
		}					  
		if( !empty( $gallery ) ) { ?>
			<div class="tg-innerbannerholder">
				<div id="tg-innerbannerslider" class="tg-innerbannerslider tg-ad-gallery owl-carousel" data-pswp-uid="1">
				<?php 
					foreach( $gallery as $key => $value ) {
						$thumb	= listingo_prepare_image_source($value['attachment_id'],480,380);
					?> 
					<figure class="item" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject"> 
						<a class="spv-ag-gallery" href="<?php echo esc_url( $value['url'] ); ?>" data-rel="prettyPhoto[gallery]">
							<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $value['attachment_id'] ) ); ?>">
		                 </a>
				    </figure>						
				<?php } ?>
				</div>
				<?php
				$script = "
				jQuery(document).ready(function(){
					jQuery('#tg-innerbannerslider').owlCarousel({
						items:4,
						nav:false,
						margin:0,
						loop:true,
						dots:false,
						center: true,
						autoplay:false,
						rtl: ".listingo_owl_rtl_check().",
						smartSpeed:450,
						responsive:{
								0:{items:1,},
								992:{items:2,},
								1200:{items:4,}
							},
						navClass: ['tg-btnprev', 'tg-btnnext'],
						navContainerClass: 'tg-innerbannerbtns',
						navText: [
								'<span><i class=\"lnr lnr-chevron-left\"></i></span>',
								'<span><i class=\"lnr lnr-chevron-right\"></i></span>',
							],
					});
				});";
			
				wp_add_inline_script('listingo_callbacks', $script, 'after');
				?>
			</div>
		<?php } ?>
		<div id="tg-twocolumns" class="tg-twocolumns tg-twocolumnsresult">
			<div class="container">
				<div class="row">		
					<div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
						<div class="tg-ad-holder">
							<div id="tg-content" class="tg-content">
								<div class="tg-detailsholder">
									<?php do_action('listingo_get_ad_featured_tag', $post->ID ); ?>
									<div class="tg-detailheader tg-sectionpaddingvtwo">
										<div class="tg-title">
											<h2><?php do_action('listingo_get_ad_title',$post->ID,get_the_title());?></h2>
										</div>
										<ul class="tg-postarticlemetavtwo">
											<li class="tg-postclock">
												<i class="fa fa-clock-o"></i>				
												<?php do_action('listingo_get_ad_status', $post->ID);?>
											</li>
											<li class="tg-poststar">
												<i class="fa fa-star"></i>
												<?php if( empty( $average_ratings ) ) { ?>
													<span><?php esc_html_e('No Reviews', 'listingo'); ?></span>
												<?php } else { ?>
													<span><?php echo esc_attr( $average_ratings ); ?>&nbsp;/&nbsp;<?php esc_html_e('5.0', 'listingo'); ?></span>
												<?php } ?>
											</li>
											<?php if( !empty( $ad_views ) ) { ?>
												<li class="tg-posteye">
													<i class="fa fa-eye"></i>
													<span><?php echo esc_attr( $ad_views ); ?>&nbsp;<?php esc_html_e('Views', 'listingo'); ?></span>
												</li>
											<?php } ?>
											<li class="tg-postheart">
												<a href="javascript:;" class="sp-save-ad" data-wl_id="<?php echo esc_attr( $post->ID ); ?>">
													<i class="fa fa-heart"></i>
													<span><?php echo esc_attr( $favorite_ads ); ?>&nbsp;<?php esc_html_e('Added', 'listingo'); ?></span>
												</a>
											</li>										
										</ul>
										<div class="tg-description">
											<?php the_content(); ?>					
										</div>
									</div>
									<?php get_template_part('framework-customizations/extensions/ads/ads-templates/ads-amenities'); ?>	
									<?php get_template_part('framework-customizations/extensions/ads/ads-templates/ads-timings'); ?>					
									<?php get_template_part('framework-customizations/extensions/ads/ads-templates/ads-video'); ?>									
									<?php listingo_get_ad_tags($post->ID, 'tg-tag', 'ad_tags',esc_html__('Tags','listingo'),'yes');?>		
															
									<?php	                        
		                            if (comments_open() || get_comments_number()) :
		                                comments_template();	                                
		                            endif;	                        
		                        	?>
								</div>							
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-5 col-md-4 col-lg-4 pull-right">
						<?php get_template_part('framework-customizations/extensions/ads/ads-templates/ads-sidebar'); ?>
					</div>			
				</div>
			</div>
		</div>
	<?php } ?>
</div>
<?php get_footer();