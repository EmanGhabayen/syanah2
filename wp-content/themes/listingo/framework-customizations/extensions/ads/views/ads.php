<?php
/**
 *
 * Listingo display author ads..
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $wp_query;

$per_page = get_option('posts_per_page');
$limit = (int) $per_page;

$pg_page 		= get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged 		= get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var

//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);
$offset = ($paged - 1) * $limit;

$json = array();
$meta_query_args = array();

$post_author_id	= !empty( $_GET['pid'] ) ? intval($_GET['pid']) : '';

$query_args = array(
	'post_type' 	=> 'sp_ads',
	'post_status' 	=> 'publish',
	'posts_per_page'=> $limit,
	'author'	 	=> $post_author_id,
	'order' 		=> 'DESC',
	'orderby' 		=> 'ID',
);

$query_args	= apply_filters('listingo_apply_provider_ad_filters',$query_args);

//Get User Queried Object Data
$provider_name = listingo_get_username($post_author_id);
$query = new WP_Query($query_args);
$count_post = $query->found_posts;
?>
<div id="tg-twocolumns" class="tg-twocolumns tg-twocolumnsresult">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 pull-left">
				<div class="tg-componyads">
					<div class="tg-title">
						<h5><?php esc_html_e('Ads By','listingo');?>&nbsp;“<?php echo esc_attr( $provider_name );?>”</h5>
					</div>
					<div class="addfeatures tg-user-provider-ads">
						<?php 
							if ( $query->have_posts() ) :
								while ( $query->have_posts() ) : $query->the_post();
									global $post;
									$height 	= intval(255);
									$width 		= intval(200);
									$user_ID 	= get_the_author_meta('ID');
									$user_url 	= get_author_posts_url($user_ID);
									$thumbnail  = listingo_prepare_thumbnail($post->ID, $width, $height);
									if( empty( $thumbnail ) ) {
										$thumbnail = get_template_directory_uri().'/images/placeholder-200x255.jpg';
									}
							?>
							<div class="tg-automotive">
								<figure class="tg-featuredimg tg-authorlink">
									<?php do_action('listingo_get_ad_featured_tag',$post->ID);?>
									<div class="ad-media-wrap"><img src="<?php echo esc_url( $thumbnail );?>" alt="<?php the_title();?>"></div>
									<?php do_action('listingo_get_ad_category',$post->ID);?>
								</figure>
								<div class="tg-companycontent tg-authorfeature">
									<div class="tg-featuredetails">
										<div class="tg-title">
											<h2><?php do_action('listingo_get_ad_title',$post->ID,get_the_title());?></h2>
										</div>
										<?php do_action('listingo_print_favorite_ads',$post->ID,$post_author_id);?>
										<?php do_action('listingo_get_ad_address',$post->ID);?>
									</div>
									<?php do_action('listingo_get_ad_provider_detail',$post->ID,$post_author_id);?>
									<?php do_action('listingo_get_ad_meta',$post->ID,$post_author_id);?>
								</div>
							</div>                                                 

						<?php
							endwhile;
							wp_reset_postdata();
						endif;

						//pagination
						if ( $count_post > $limit ) :
							listingo_prepare_pagination($count_post, $limit);
						endif;
					?>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<?php do_action('listingo_get_ad_author_box',$post_author_id);?>
				<?php if (function_exists('fw_ext_sidebars_get_current_position')) {?>
				  <div class="tg-advertisement">
					<?php echo fw_ext_sidebars_show('blue'); ?>        	
				  </div>
			   <?php }?>                                          
			</div>
		</div>
	</div>
</div>