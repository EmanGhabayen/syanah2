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

global $paged,$query;
if (function_exists('fw_get_db_settings_option')) {
	$search_show_posts    = fw_get_db_settings_option('search_show_posts' , $default_value = null);
	$search_order    = fw_get_db_settings_option('search_order' , $default_value = null);
	$search_orderby    = fw_get_db_settings_option('search_orderby' , $default_value = null);
	$search_meta_information    = fw_get_db_settings_option('search_meta_information' , $default_value = null);
} else{
	$search_show_posts    = get_option('posts_per_page');
	$search_order    = 'DESC';
	$search_orderby    = 'ID';
	$search_meta_information    = 'enable';
}

?>
<div class="blog-list-view-template">
	<?php 
	get_option('posts_per_page');
	
	if (empty($paged)) {
		$paged = 1;
	}
	
	if (!isset($_GET["s"])) {
		$_GET["s"] = '';
	}
	$counter_no = 0;

	while (have_posts()) : the_post();
		global $post;
		$user_ID    = get_the_author_meta('ID');
		$height = 400;
        $width = 1180;
		$thumbnail = listingo_prepare_thumbnail($post->ID , $width , $height);
		
		if (!function_exists('fw_get_db_post_option')) {
			$enable_author = 'enable';
			$enable_date = 'enable';
		} else {
			$enable_author = fw_get_db_post_option($post->ID, 'enable_author', true);
			$enable_date = fw_get_db_post_option($post->ID, 'enable_date', true);
		}
	
		$stickyClass = '';
		if (is_sticky()) {
			$stickyClass = 'sticky';
		}
		?>                         
		<article class="tg-post">
			<?php if( !empty( $thumbnail ) ){?>
				<figure class="tg-themepost-img">
					<?php listingo_get_post_thumbnail($thumbnail,$post->ID,'linked');?>
				</figure>
			<?php }?>
			<div class="tg-postcontent">
				<div class="tg-title"><h3><?php listingo_get_post_title($post->ID);?></h3></div>
				<div class="tg-description">
					<p><?php echo listingo_prepare_search_content(50); ?></p>
				</div>
				<a class="tg-btn" href="<?php echo esc_url(get_permalink());?>"><?php esc_html_e('read more', 'listingo'); ?></a>
			</div>
			<?php if (is_sticky()) {?>
				<span class="sticky-wrap tg-themetag tg-tagclose"><i class="fa fa-bolt" aria-hidden="true"></i><?php esc_html_e('Featured','listingo');?></span>
			<?php }?>
		</article>
		<?php
		endwhile;
		wp_reset_postdata();
		$qrystr = '';
		if ($wp_query->found_posts > $search_show_posts) {
			?>
			<div class="theme-nav">
				<?php 
					if (function_exists('listingo_prepare_pagination')) {
						echo listingo_prepare_pagination($wp_query->found_posts, $search_show_posts);
					}
				?>
			</div>
		<?php }?>
</div>