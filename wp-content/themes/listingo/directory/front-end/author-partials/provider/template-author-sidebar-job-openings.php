<?php
/**
 *
 * Author Opening Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $wp_query, $current_user;
/**
 * Get User Queried Object Data
 */
$author_profile = $wp_query->get_queried_object();
$args = array('posts_per_page' => '-1',
    'post_type' 		=> 'sp_jobs',
    'orderby' 			=> 'ID',
    'post_status' 		=> 'publish',
    'author' 			=> $author_profile->ID,
    'suppress_filters'  => false
);

$job_query = new WP_Query($args);
if( $job_query->have_posts() ){
?>
<div class="tg-widget tg-widgetbrochure">
	<div class="tg-widgettitle">
		<h3><?php esc_html_e('Job Openings', 'listingo'); ?></h3>
	</div>
	<div class="tg-widgetcontent">
	 <ul>
		 <?php
			$today = time();
			while ($job_query->have_posts()) : $job_query->the_post();
				global $post;
				$type = fw_get_db_post_option($post->ID, 'job_type', true);
				?>
				<li>
				  <div class="tg-serviceprovidercontent">
					<div class="tg-companycontent">
					  <div class="tg-title">
						<h3><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a></h3>
					  </div>
					  
					  <ul class="tg-matadata">
						<li><a href="<?php echo esc_url(get_the_permalink()); ?>"> <?php esc_html_e('View detail', 'listingo'); ?> </a></li>
					  </ul>
					</div>
				  </div>
				</li>
				<?php
				endwhile;
				wp_reset_postdata();
			?>
		 </ul>
	</div>
</div>
<?php }