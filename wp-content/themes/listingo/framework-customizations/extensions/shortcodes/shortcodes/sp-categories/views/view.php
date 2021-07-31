<?php
if (!defined('FW'))
    die('Forbidden');


$dir_search_page = fw_get_db_settings_option('dir_search_page');
if (isset($dir_search_page[0]) && !empty($dir_search_page[0])) {
    $search_page = get_permalink((int) $dir_search_page[0]);
} else {
    $search_page = '';
}

/**
 * @var $atts
 */
global $paged;
$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);

$posts_in['post__in'] = !empty($atts['posts']) ? $atts['posts'] : array();

$order = !empty($atts['order']) ? $atts['order'] : 'DESC';
$orderby = !empty($atts['orderby']) ? $atts['orderby'] : 'ID';
$show_posts = !empty($atts['show_posts']) ? $atts['show_posts'] : '-1';

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
<div class="sp-sc-categories tg-haslayout">
    <?php if (!empty($atts['category_heading']) || !empty($atts['category_description'])) { ?>
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
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
        </div>
    <?php } ?>
    <div class="tg-topcategories">
		<div class="row">
			<?php
			if ($query->have_posts()) {
				while ($query->have_posts()) {
					$query->the_post();
					global $post;

					$user_ID = get_the_author_meta('ID');


					$thumnail = get_template_directory_uri() . '/images/img-370x270.jpg';
					$category_icon = '';
					$category_color = '';
					if (function_exists('fw_get_db_post_option')) {
						$categoy_bg_img = fw_get_db_post_option($post->ID, 'category_image', true);
						$category_icon = fw_get_db_post_option($post->ID, 'category_icon', true);
						$category_color = fw_get_db_post_option($post->ID, 'category_color', true);
					}

					if (!empty($categoy_bg_img['url'])) {
						$thumnail = $categoy_bg_img['url'];
					}

					$thumb_meta = array();
					if (!empty($categoy_bg_img['attachment_id'])) {
						$thumb_meta = listingo_get_image_metadata($categoy_bg_img['attachment_id']);
					}
					$image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : 'no-name';
					$image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;

					$total_users	= listingo_get_total_users_under_category($post->ID);

					//Generate Directory page link
					$directory_link = add_query_arg('category', $post->post_name, $search_page);
					?>

					<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 tg-verticaltop">
						<div class="tg-category">
							<figure>
								<?php if (!empty($thumnail)) { ?>
									<img src="<?php echo esc_url($thumnail); ?>" alt="<?php echo esc_attr($image_alt); ?>">
								<?php } ?>
								<figcaption class="tg-automotive">
									<?php
									if (isset($category_icon['type']) && $category_icon['type'] === 'icon-font') {
										do_action('enqueue_unyson_icon_css');
										if (!empty($category_icon['icon-class'])) {
											?>
											<span class="<?php echo esc_attr($category_icon['icon-class']); ?> tg-categoryicon" style="background: <?php echo esc_attr($category_color); ?>;"></span>
											<?php
										}
									} else if (isset($category_icon['type']) && $category_icon['type'] === 'custom-upload') {
										if (!empty($category_icon['url'])) {
											?>
											<em><img src="<?php echo esc_url($category_icon['url']); ?>" alt="<?php echo esc_attr($image_alt); ?>"></em>
											<?php
										}
									}
									?>
									<span class="tg-categoryname">
										<a href="<?php echo esc_url($directory_link); ?>">
											<?php echo get_the_title(); ?>
										</a>
									</span>
									<?php if (!empty($total_users)) { ?>
										<a href="<?php echo esc_url($directory_link); ?>" class="tg-themetag tg-tagjobcount">
											<i class="fa fa-clone"></i>
											<em><?php echo intval($total_users); ?></em>
										</a>
									<?php } ?>
								</figcaption>
							</figure>
						</div>
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