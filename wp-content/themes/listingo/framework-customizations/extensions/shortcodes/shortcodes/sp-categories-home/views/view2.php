<?php
if (!defined('FW'))
    die('Forbidden');

/**
 * @var $atts
 */
global $paged;
$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);

$posts_in['post__in'] = !empty($atts['posts']) ? $atts['posts'] : array();

$order 			= !empty($atts['order']) ? $atts['order'] : 'DESC';
$orderby 		= !empty($atts['orderby']) ? $atts['orderby'] : 'ID';
$show_posts 	= !empty($atts['show_posts']) ? $atts['show_posts'] : '-1';

//total posts Query 
$query_args = array(
    'posts_per_page' => -1,
    'post_type' => 'sp_categories',
    'order' => $order,
    'orderby' => $orderby,
    'post_status' => 'publish',
    'ignore_sticky_posts' => 1);

//By Posts 
if (!empty($posts_in)) {
    $query_args = array_merge($query_args, $posts_in);
}
$query = new WP_Query($query_args);
$count_post = $query->post_count;

//Main Query 
$query_args = array(
    'posts_per_page' => $show_posts,
    'post_type' => 'sp_categories',
    'paged' => $paged,
    'order' => $order,
    'orderby' => $orderby,
    'post_status' => 'publish',
    'ignore_sticky_posts' => 1);

//By Posts 
if (!empty($posts_in)) {
    $query_args = array_merge($query_args, $posts_in);
}
$query = new WP_Query($query_args);
?>

<div class="sc-home-category-3 tg-haslayout tg-paddingtopzero">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
			<?php if ( !empty( $atts['category_heading'] ) || !empty( $atts['category_description'] ) ) { ?>
				<div class="tg-sectionhead">
					<?php if (!empty($atts['category_heading'])) { ?>
                    <div class="tg-sectiontitle">
                        <h2><?php echo esc_attr($atts['category_heading']); ?></h2>
                    </div>
	                <?php } ?>
	                <?php if (!empty($atts['category_description'])) { ?>
	                    <div class="tg-description">
	                        <?php echo wp_kses_post(wpautop(do_shortcode($atts['category_description']))); ?>
	                    </div>
	                <?php } ?>
				</div>
			<?php } ?>
		</div>
		<?php if ($query->have_posts()) { ?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<ul class="tg-popularcatagories">
					<?php
						while ($query->have_posts()) {
						$query->the_post();
						global $post;
											
						$categoy_bg_img = '';	
						$category_icon = '';
						$category_color = '';
						if (function_exists('fw_get_db_post_option')) {
							$categoy_bg_img = fw_get_db_post_option($post->ID, 'category_image', true);
							$category_icon = fw_get_db_post_option($post->ID, 'category_icon', true);
							$category_color = fw_get_db_post_option($post->ID, 'category_color', true);
						}							

						$thumb_meta = array();
						if (!empty($categoy_bg_img['attachment_id'])) {
							$thumb_meta = listingo_get_image_metadata($categoy_bg_img['attachment_id']);
						}
						$image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : 'no-name';
						$image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;	

						$icon_class = '';
						if ( !empty( $category_icon ) ) {
							$icon_class = !empty( $category_icon['icon-class'] ) ? $category_icon['icon-class'] : '';
						}

						$icon_style = '#000000';
						if ( !empty( $category_color ) ) {
							$icon_style = 'style="color: '.$category_color.'"';
						}							
						?>			
						<li>							
							<?php 
								if (isset($category_icon['type']) && $category_icon['type'] === 'icon-font') {
									do_action('enqueue_unyson_icon_css');
									if (!empty($category_icon['icon-class'])) {
										?>
										<span class="tg-categoryicon" <?php echo ( $icon_style ); ?>><i class="<?php echo esc_attr( $icon_class ); ?>"></i></span>
										<?php
									}
								} else if (isset($category_icon['type']) && $category_icon['type'] === 'custom-upload') {
									if (!empty($category_icon['url'])) {
										?>
										<img src="<?php echo esc_url($category_icon['url']); ?>" alt="<?php echo esc_attr($image_alt); ?>">
										<?php
									}
								}		
							?>									
							<span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
						</li>																		
					<?php } wp_reset_postdata(); ?>					
				</ul>
			</div>
		<?php } ?>
	</div>
</div>