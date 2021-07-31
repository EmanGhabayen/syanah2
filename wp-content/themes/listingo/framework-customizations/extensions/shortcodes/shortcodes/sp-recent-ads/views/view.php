<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */

$today = time();
$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);

if (isset($atts['get_mehtod']['gadget']) && $atts['get_mehtod']['gadget'] === 'by_cats' ) {
    $cat_sepration = !empty($atts['get_mehtod']['by_cats']['categories']) ? $atts['get_mehtod']['by_cats']['categories'] : array();

	if (isset($cat_sepration) && !empty($cat_sepration)) {
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

$show_posts	 			 = !empty( $atts['show_posts'] ) ? $atts['show_posts'] : 20;
$show_pagination		 = !empty( $atts['show_pagination'] ) ? $atts['show_pagination'] : '';
$limit  	 = (int) $show_posts;
$uniq_flag 	 = fw_unique_increment();
$meta_query_args	= array();
$tax_query_args		= array();

$query_args = array(
	'post_type' 	=> 'sp_ads',
	'posts_per_page' => -1,
	'post_status' 	=> 'publish',
	'posts_per_page'=> $limit,
	'order' 		=> 'DESC',
	'orderby' 		=> 'ID',
);

//By Categories
if (!empty($cat_sepration)) {
	$query_args = array_merge($query_args, $tax_query);
}

//featured on top
$query_args['order'] 	= 'DESC';
$query_args['orderby'] 	= 'meta_value_num';
$query_args['meta_key'] = '_featured_timestamp';
$ads_data 		= new WP_Query($query_args);
$total_posts 	= $ads_data->found_posts;
?>
<div class="sp-recent-ads tg-haslayout">
	<div class="row">
		<?php if (!empty($atts['heading']) || !empty($atts['description'])) { ?>
			<div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
				<div class="tg-sectionhead">
					<?php if (!empty($atts['heading'])) { ?>
						<div class="tg-sectiontitle">
							<h2><?php echo esc_attr($atts['heading']); ?></h2>
						</div>
					<?php } ?>
					<?php if (!empty($atts['description'])) { ?>
						<div class="tg-description">
							<?php echo wp_kses_post(wpautop(do_shortcode($atts['description']))); ?>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
   		<div class="tg-custom-search-grid">
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
								<div class="ad-media-wrap"><img src="<?php echo esc_url( $thumbnail );?>" alt="<?php the_title();?>"></div>
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
					Listingo_Prepare_Notification::listingo_info('', esc_html__('No ads found.', 'listingo'));
				}
			?>
			<?php
			if ( $show_pagination === 'yes' && !empty($total_posts) && !empty($show_posts) && $total_posts > $show_posts) {?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php listingo_prepare_pagination($total_posts, $show_posts); ?>
				</div>
			<?php } ?>
		 </div>
    </div>
</div>
