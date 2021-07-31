<?php
/**
 *
 * The template part for displaying the dashboard ads.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
global $current_user,
 $wp_roles,
 $userdata,
 $paged;

$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (!empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$wishlist 	= get_user_meta($url_identity, 'favorite_ads', true);
$wishlist 	= !empty($wishlist) && is_array($wishlist) ? $wishlist : array();

$dir_profile_page = '';
if (function_exists('fw_get_db_settings_option')) {
    $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
}

$get_username = listingo_get_username($url_identity);
$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
$show_posts = get_option('posts_per_page') ? get_option('posts_per_page') : 10;

$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);

$order 		= 'DESC';
$sorting 	= 'ID';
?>
<div id="tg-content" class="tg-content">
    <div class="tg-joblisting tg-dashboardmanagejobs">
        <div class="tg-dashboardhead">
            <div class="tg-dashboardtitle">
                <h2><?php esc_html_e('Favorite Ads', 'listingo'); ?></h2>
            </div>
            <?php if( count( $wishlist ) > 0 ) {?>
            <div class="tg-btnaddservices">
                <a href="javascript:;" class="btn-ad-del-favorite" data-type="all" data-key=""><?php esc_html_e('Delete all', 'listingo'); ?></a>
            </div>
            <?php }?>
        </div>
        <?php 
		if( count( $wishlist ) > 0 ) {
			$args = array('posts_per_page' => $show_posts,
				'post_type' => 'sp_ads',
				'orderby' => $sorting,
				'order' => $order,
				'post_status' => 'publish',
				'post__in' => $wishlist,
				'paged' => $paged,
				'suppress_filters' => false,

			);

			$query = new WP_Query($args);
			$count_post = $query->found_posts;
			
			if ($query->have_posts()) { ?>
				<table class="tg-tablejoblidting job-listing-wrap fw-ext-ad-listing">
						<thead>    
							<tr>                
								<th><?php esc_html_e('Photo', 'listingo'); ?></th>
								<th><?php esc_html_e('Title', 'listingo'); ?></th>
								<th><?php esc_html_e('Category', 'listingo'); ?></th>
								<th><?php esc_html_e('Action', 'listingo'); ?></th>
							</tr>
						</thead> 
						<tbody>               
						<?php
						$today = time();
						while ($query->have_posts()) : $query->the_post();
							global $post;                        
							$height = 92;
							$width = 92;
							$address = '';
							$thumbnail = listingo_prepare_thumbnail($post->ID, $width, $height);
							if( empty( $thumbnail ) ) {
								$thumbnail = get_template_directory_uri().'/images/img-92x92.jpg';
							}
							if (function_exists('fw_get_db_post_option')) {
								$address = fw_get_db_post_option($post->ID, 'address', true);
							}
							$args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
							$categories = wp_get_post_terms( $post->ID, 'ad_category', $args );
							?>
							<tr>
								<td>
									<figure>
										<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php the_title(); ?>">
									</figure>
								</td>
								<td>                                
									<div class="tg-contentbox"> 
										<div class="tg-title">
											<h3><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a></h3>
										</div>
										<?php if( !empty( $address ) ) { ?>
										<span><i class="lnr lnr-location"></i>&nbsp;<?php echo esc_attr($address); ?></span> 
										<?php } ?>
									</div>
								</td>
								<td>
									<?php 
										if( !empty( $categories ) ) {
										$total = count($categories); 
										$show_total = '';
										if( $total > 1 ){
											$show_total = $total - 1;
										}
										$counter = 0;            
										foreach ($categories as $key => $value) { 
											$counter++;
											if( $counter == 1 ){
									?>
									<a class="tg-addcategorylink" href="<?php echo esc_url( get_term_link( $value->term_id ) ); ?>"><?php echo esc_attr( $value->name ); ?></a>
										<?php if( !empty( $show_total ) ) { ?>
											<em>+<?php echo esc_attr( $show_total ); ?></em>
										<?php } ?>
										<?php 
										} }
									}
									?>
								</td>                            
								<td>
									<div class="tg-actionbtns">
										<a class="tg-btnview" href="<?php the_permalink(); ?>"><i class="lnr lnr-eye"></i></a>                                   
										<a class="tg-btnedite btn-ad-del-favorite" data-type="single" data-key="<?php echo intval($post->ID); ?>"><i class="lnr lnr-trash"></i></a>
									</div>                                
								</td>
							</tr>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</tbody>
				</table>
				<?php
				if (!empty($count_post) && $count_post > $show_posts) {
					listingo_prepare_pagination($count_post, $show_posts);
				}
			} else { ?>
			<div class="tg-dashboardappointmentbox">
				<?php Listingo_Prepare_Notification::listingo_info(esc_html__('Information', 'listingo'), esc_html__('No ads in favorites', 'listingo')); ?>
			</div>
		<?php } 
		} else { ?>
			<div class="tg-dashboardappointmentbox">
				<?php Listingo_Prepare_Notification::listingo_info(esc_html__('Information', 'listingo'), esc_html__('No ads in favorites', 'listingo')); ?>
			</div>
		<?php } ?>
    </div>
</div>