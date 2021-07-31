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

if (isset($atts['get_mehtod']['gadget']) && $atts['get_mehtod']['gadget'] === 'by_posts' && !empty($atts['get_mehtod']['by_posts']['posts'])) {
    $posts_in['post__in'] = !empty($atts['get_mehtod']['by_posts']['posts']) ? $atts['get_mehtod']['by_posts']['posts'] : array();
    $order = 'DESC';
    $orderby = 'ID';
    $show_posts = !empty($atts['get_mehtod']['by_posts']['show_posts']) ? $atts['get_mehtod']['by_posts']['show_posts'] : '-1';
} else {
    $cat_sepration = array();
    $cat_sepration = $atts['get_mehtod']['by_cats']['categories'];
    $order = !empty($atts['get_mehtod']['by_cats']['order']) ? $atts['get_mehtod']['by_cats']['order'] : 'DESC';
    $orderby = !empty($atts['get_mehtod']['by_cats']['orderby']) ? $atts['get_mehtod']['by_cats']['orderby'] : 'ID';
    $show_posts = !empty($atts['get_mehtod']['by_cats']['show_posts']) ? $atts['get_mehtod']['by_cats']['show_posts'] : '-1';

    if (!empty($cat_sepration)) {
        $slugs = array();
        foreach ($cat_sepration as $key => $value) {
            $term = get_term($value, 'category');
            $slugs[] = $term->slug;
        }

        $filterable = $slugs;
        $tax_query['tax_query'] = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'category',
                'terms' => $filterable,
                'field' => 'slug',
        ));
    }
}

//Main Query 
$query_args = array(
    'posts_per_page' => $show_posts,
    'post_type' => 'post',
    'paged' => $paged,
    'order' => $order,
    'orderby' => $orderby,
    'post_status' => 'publish',
    'ignore_sticky_posts' => 1);

//By Categories
if (!empty($cat_sepration)) {
    $query_args = array_merge($query_args, $tax_query);
}

//By Posts 
if (!empty($posts_in)) {
    $query_args = array_merge($query_args, $posts_in);
}

$query = new WP_Query($query_args);
$count_post = $query->found_posts;
?>
<div class="sp-sc-news tg-haslayout">
    <?php if (!empty($atts['news_heading']) || !empty($atts['news_description'])) { ?>
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
            <div class="tg-sectionhead">
                <?php if (!empty($atts['news_heading'])) { ?>
                    <div class="tg-sectiontitle">
                        <h2><?php echo esc_attr($atts['news_heading']); ?></h2>
                    </div>
                <?php } ?>
                <?php if (!empty($atts['news_description'])) { ?>
                    <div class="tg-description">
                        <?php echo wp_kses_post(wpautop(do_shortcode($atts['news_description']))); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
	<div class="tg-newsandposts tg-bloggird">
		<div class="row">
			<?php
			if ($query->have_posts()) {
				while ($query->have_posts()) {
					$query->the_post();
					global $post;
					$height = 200;
					$width = 280;

					$user_ID = get_the_author_meta('ID');
					$post_thumbnail_id = get_post_thumbnail_id($post->ID);
					$thumbnail = listingo_prepare_thumbnail($post->ID, $width, $height);
					$enable_author = '';
					if (function_exists('fw_get_db_post_option')) {
						$enable_author = fw_get_db_post_option($post->ID, 'enable_author', true);
					}

					$thumb_meta = array();
					if (!empty($post_thumbnail_id)) {
						$thumb_meta = listingo_get_image_metadata($post_thumbnail_id);
					}
					$image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : 'no-name';
					$image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;
					?>
					<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 tg-verticaltop">
						<article class="tg-post">
							<?php if (!empty($thumbnail)) { ?>
								<figure class="tg-featuredimg">
									<a href="<?php echo esc_url(get_permalink()); ?>">
										<img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($image_alt); ?>">
									</a>
								</figure>
							<?php } ?>
							<div class="tg-postcontent">
								<div class="tg-title">
									<h3><?php listingo_get_post_title($post->ID); ?></h3>
								</div>
								<ul class="tg-postmatadata">
									<?php if (!empty($enable_author) && $enable_author === 'enable') { ?>
										<li>
											<?php listingo_get_post_author($user_ID, 'linked', $post->ID); ?>
										</li>
									<?php } ?>
									<li>
										<a href="javascript:;"><?php listingo_get_post_date($post->ID); ?></a>
									</li>
								</ul>
								<?php if (!empty($atts['excerpt'])) { ?>
									<div class="tg-description">
										<?php listingo_prepare_excerpt($atts['excerpt'], 'false', ''); ?>
									</div>
								<?php } ?>
							</div>
						</article>
					</div>
					<?php
				} wp_reset_postdata();
			}
			?>
			<?php if (isset($atts['show_pagination']) && $atts['show_pagination'] == 'yes') : ?>
				<div class="col-md-12">
					<?php listingo_prepare_pagination($count_post, $show_posts); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>