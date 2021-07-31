<?php
/**
 *
 * Search template for ads grid view
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
global $paged, $wp_query, $query_args, $showposts;
get_header();

if (function_exists('fw_get_db_settings_option')) {
    $dir_map_marker_default = fw_get_db_settings_option('dir_map_marker');
	$dir_radius = fw_get_db_settings_option('dir_radius');
	$dir_location = fw_get_db_settings_option('dir_location');
} else {
    $dir_map_marker_default = '';
	$dir_radius = '';
	$dir_location = '';
}

$ads_data = new WP_Query($query_args);
$total_posts	= $ads_data->found_posts;
$direction		= listingo_get_location_lat_long();
?>
<div class="ad-search-result tg-listingvtwo tg-haslayout">
	<div class="container-fluid spv-map">
	   <div class="row">
		  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
			 <div class="spv-formtheme tg-ad-search-form">
				<form class="sp-form-search" action="<?php echo listingo_get_ads_search_page_uri();?>" method="get">
					<div class="tg-searchtitle">
						<h3><?php esc_html_e('Search Result', 'listingo'); ?></h3>
						<span><?php esc_html_e('About', 'listingo'); ?> <?php echo intval( $total_posts );?> <?php esc_html_e('result(s)', 'listingo'); ?></span>
					</div>
					<div class="tg-sortfilters tg-searchheadform">
						<div class="tg-sortfilter tg-show">
							<?php do_action('listingo_get_ads_sortby'); ?>
						</div>
						<div class="tg-sortfilter tg-show">
							<?php do_action('listingo_get_orderby'); ?>
						</div>
						<div class="tg-sortfilter tg-show">
							<?php do_action('listingo_get_showposts'); ?>
						</div>
					</div>
					<div class="tg-formsearchresult">
						<div class="tg-formtheme tg-formsearchvtwo">
							<fieldset>
								<div class="form-group tg-inputwithicon">
									<?php do_action('listingo_get_search_keyword'); ?>
								</div>
								<div class="form-group tg-inputwithicon">
									<?php do_action('listingo_get_ad_category_filter');?>
								</div>
								<div class="form-group tg-inputwithicon">
									<?php do_action('listingo_get_price_type');?>
								</div>
								<?php do_action('listingo_get_search_permalink_setting'); ?>
								<button class="tg-btnsearchvtwo" type="submit"><i class="lnr lnr-magnifier"></i></button>
							</fieldset>
						</div>
						<?php do_action('listingo_get_ads_search_filtrs'); ?>
					</div>
				</form>
			 </div>
			 <div class="tg-custom-search-grid">
				<div class="row">
				<?php
				$sp_addata	=  array();
				$sp_adslist	=  array();
				$sp_adslist['status'] = 'none';
				$sp_adslist['lat']  = floatval ( $direction['lat'] );
				$sp_adslist['long'] = floatval ( $direction['long'] );
					
				if ($ads_data->have_posts()) {
					$sp_adslist['status'] = 'found';
					while ($ads_data->have_posts()) : $ads_data->the_post();
						global $post;						
						$width 	= intval(480);
						$height = intval(380);
						$thumbnail  = listingo_prepare_thumbnail($post->ID, $width, $height);
						if( empty( $thumbnail ) ) {
                        	$thumbnail = get_template_directory_uri().'/images/placeholder-360x240.jpg';
                    	} 
					
						$post_author_id	= $post->post_author;						
						$post_title	= get_the_title();
						$post_link	= get_the_permalink();
											
						$sp_addata['latitude']  = get_post_meta($post->ID,'latitude' ,true);
						$sp_addata['longitude'] = get_post_meta($post->ID,'longitude' ,true);
						$address = fw_get_db_post_option($post->ID, 'address', true);
						$sp_addata['title'] 	= $post_title;
					
						$featured_timestamp  = get_post_meta($post->ID,'_featured_timestamp' ,true);

						$infoBox = '';
						$infoBox .= '<div class="tg-infoBox svp-ad-infobox">';
						$infoBox .= '<div class="tg-serviceprovider">';
						$infoBox .= '<div class="tg-featuredimg"><img src="' . esc_url($thumbnail) . '" alt="' . $post_title . '"></div>';
						$infoBox .= '<div class="tg-companycontent">';
						$infoBox .= apply_filters('listingo_get_ad_category',$post->ID,'filter');
						$infoBox .= '<div class="tg-title">';
						$infoBox .= '<h3><a href="' . $post_link . '">' . $post_title . '</a></h3>';
						$infoBox .= '</div>';
						$infoBox .= '<p>'.$address.'</p>';
						$infoBox .= '</div>';
						$infoBox .= '</div>';
						$infoBox .= '</div>';

						if (isset($map_marker['url']) && !empty($map_marker['url'])) {
							$sp_addata['icon'] = $map_marker['url'];
						} else {
							if (!empty($dir_map_marker_default['url'])) {
								$sp_addata['icon'] = $dir_map_marker_default['url'];
							} else {
								$sp_addata['icon'] = get_template_directory_uri() . '/images/map-marker.png';
							}
						}

						$sp_addata['html']['content'] = $infoBox;
						$sp_adslist['ads_list'][] = $sp_addata;
					?>
				   <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 tg-verticaltop" data-date="<?php echo esc_attr($featured_timestamp);?>">
					   <div class="tg-oneslides  tg-automotivegrid">
						  <div class="tg-automotive">
								<figure class="tg-featuredimg tg-authorlink">				
									<?php do_action('listingo_get_ad_featured_tag', $post->ID ); ?>									
									<div class="ad-media-wrap"><img src="<?php echo esc_url( $thumbnail );?>" alt="<?php the_title();?>"></div>
									<?php do_action('listingo_get_ad_category',$post->ID);?>
									<?php do_action('listingo_print_favorite_ads',$post->ID,$post_author_id);?>
								</figure>
								<div class="tg-companycontent tg-authorfeature">
									<div class="tg-featuredetails">
										<div class="tg-title">
											<h2><?php do_action('listingo_get_ad_title',$post->ID,get_the_title());?></h2>		
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
						Listingo_Prepare_Notification::listingo_info('', esc_html__('No ads found.', 'listingo'));
					}
				?>
				</div>
				<?php
				if (!empty($total_posts) && !empty($showposts) && $total_posts > $showposts) {?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php listingo_prepare_pagination($total_posts, $showposts); ?>
					</div>
				<?php } ?>
				 
				<?php
					$script	= "jQuery(document).ready(function ($) {listingo_init_map_script(".json_encode($sp_adslist)."); });";
					wp_add_inline_script('listingo_ad_gmaps', $script,'after');
				?> 
				 
			 </div>
		  </div>
		  <?php do_action('listingo_get_search_map_right'); ?>
	   </div>
	</div>
 </div>
<?php get_footer(); ?>

