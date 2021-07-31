<?php
/**
 *
 * Listingo display author articles..
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $current_user, $wp_query;
//Get User Queried Object Data
$queried_object = $wp_query->get_queried_object();

if( is_single() ){
	$exclude_post 	= $queried_object->ID;
	$post_author_id = $queried_object->post_author;
} else{
	$exclude_post	= array();
	$post_author_id = $queried_object->ID;
}

$args = array(
    'post_type' => 'sp_articles',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'author' => $post_author_id,
    'order' => 'DESC',
	'post__not_in' => array(intval($exclude_post))
);

$username = listingo_get_username($post_author_id);
$query = new WP_Query($args);
if ($query->have_posts()) :?>
    <section class="tg-haslayout tg-introductionhold spv-bglight spv4-articles  spv4-section"  id="section-articles">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="tg-companyfeaturetitle">
						<h3><?php esc_html_e('Articles', 'listingo'); ?></h3>
					</div>
					<div class="tg-posts tg-newsarticles">
					  <div class="row">
						<?php
						while ($query->have_posts()) : $query->the_post();
							global $post;
							$height = 152;
							$width  = 275;
							$user_ID = get_the_author_meta('ID');
							$user_url = get_author_posts_url($user_ID);
							$thumbnail = listingo_prepare_thumbnail($post->ID, $width, $height);
							?>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 tg-verticaltop">
						  <article class="tg-newsarticle">
							<?php if (!empty($thumbnail)) { ?>
							<figure class="tg-newsimg"> 
								<a href="<?php echo esc_url(get_permalink()); ?>">
									<img src="<?php echo esc_url($thumbnail); ?>" alt="<?php esc_html_e('article', 'listingo'); ?>">
								</a>
							</figure>
							<?php } ?>
							<div class="tg-postauthorname">
							  <div class="tg-articlecontent">
								<div class="tg-articletitle">
								  <h3><a href="<?php echo esc_url(get_permalink()); ?>"> <?php echo esc_attr(get_the_title()); ?> </a></h3>
								</div>
							</div>
							<ul class="tg-postarticlemeta">
							  <li><span>
								<time datetime="2020-01-01"><?php listingo_get_post_date($post->ID); ?></time>
								</span></li>
							</ul>
						  </article>
						</div>
						<?php
							endwhile;
							wp_reset_postdata();
						?>
					  </div>
					</div>
				</div>
			</div>
		</div>
	</section>
    
<?php endif; ?>
 