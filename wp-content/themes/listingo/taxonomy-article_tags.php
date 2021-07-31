<?php
/**
 *
 * The template used for displaying audio post formate
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */

get_header();
global $paged;
$term = get_queried_object();

$archive_show_posts     = get_option('posts_per_page');
$order    		= 'DESC';
$orderby    	= 'ID';
$archive_meta_information    = 'enable';
$archive_enable_sidebar    	 = 'enable';
$archive_sidebar_position    = 'right';

if ( isset( $archive_enable_sidebar ) && $archive_enable_sidebar === 'disable' ) {
	$section_width = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
} else{
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$section_width = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
	} else{
		$section_width = 'col-xs-12 col-sm-8 col-md-8 col-lg-9';
	}
	
}
	
if ( isset($archive_sidebar_position) && $archive_sidebar_position === 'left') {
    $aside_class = 'pull-left';
    $content_class = 'pull-right';
} else {
	$aside_class = 'pull-right';
    $content_class = 'pull-left';
}
$query_args = array(
    'post_type' => 'sp_articles',
    'article_tags' => $term->slug,
	'posts_per_page' => -1,
);

$query = new WP_Query($query_args);
$count_post = $query->post_count;

//Main Query 
$query_args = array(
    'posts_per_page' => $archive_show_posts,
    'post_type' => 'sp_articles',
    'paged' => $paged,
    'order' => $order,
    'orderby' => $orderby,
	'article_tags' => $term->slug,
    'post_status' => 'publish',
    'ignore_sticky_posts' => 1);

$query = new WP_Query($query_args);
?>
<div class="container">
    <div class="row">
        <div class="serviceproviders-inner-content haslayout">
			<div class="<?php echo esc_attr( $section_width );?> page-section <?php echo sanitize_html_class($content_class); ?>">
			<div class="blog-list-view-template">
				<?php 
				$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
				$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
				//paged works on single pages, page - works on homepage
				$paged = max($pg_page, $pg_paged);

				$counter_no = 0;

				while ($query->have_posts()) : $query->the_post();
					global $post;
					$user_ID    = get_the_author_meta('ID');
					$width      = 231;
					$height     = 183;
					$thumbnail = listingo_prepare_thumbnail($post->ID , $width , $height);

					if (!function_exists('fw_get_db_post_option')) {
						$enable_author = 'enable';
						$enable_date = 'enable';
					} else {
						$enable_author = fw_get_db_post_option($post->ID, 'enable_author', true);
						$enable_date = fw_get_db_post_option($post->ID, 'enable_date', true);
					}
					?>                         
					<article class="tg-post">
						<?php if( !empty( $thumbnail ) ){?>
							<figure class="tg-classimg">
								<?php listingo_get_post_thumbnail($thumbnail,$post->ID,'linked');?>
							</figure>
						<?php }?>
						<div class="tg-postcontent">
							<div class="tg-title"><h3><?php listingo_get_post_title($post->ID);?></h3></div>
							<div class="tg-description">
								<p><?php echo listingo_prepare_excerpt(350); ?></p>
							</div>
							<a class="tg-btn" href="<?php echo esc_url(get_permalink());?>"><?php esc_html_e('read more', 'listingo'); ?></a>
						</div>
						<?php if (is_sticky()) {?>
							<span class="sticky-wrap tg-themetag tg-tagclose"><i class="fa fa-bolt" aria-hidden="true"></i>&nbsp;<?php esc_html_e('Featured','listingo');?></span>
						<?php }?>
					</article>
					<?php
					endwhile;
					wp_reset_postdata();
					$qrystr = '';
					if ($count_post > $archive_show_posts) {
						?>
						<div class="theme-nav">
							<div class="col-md-12">
								<?php listingo_prepare_pagination($count_post, $archive_show_posts); ?>
							</div>
						</div>
					<?php }?>
			</div>
			</div>
			<?php if ( is_active_sidebar( 'sidebar-1' ) && $archive_enable_sidebar === 'enable' ) {?>
				<aside id="tg-sidebar" class="col-xs-12 col-sm-4 col-md-4 col-lg-3 <?php echo sanitize_html_class($aside_class); ?>">
					<div class="tg-sidebar">
						<?php get_sidebar(); ?>
					</div>
				</aside>
			<?php } ?>
		</div>
    </div>
</div>
<?php get_footer(); ?>