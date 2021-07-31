<?php
/**
 *
 * Author Company Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * Get User Queried Object Data
 */
$author_profile = $wp_query->get_queried_object();
$list_videos = array();
if (!empty($author_profile->audio_video_urls)) {
    $list_videos = $author_profile->audio_video_urls;
}

if (!empty($list_videos[0])) {?>
<section class="tg-haslayout tg-introductionhold spv4-videos spv-bglight spv4-section" id="section-videos">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php get_template_part('directory/front-end/author-partials/provider/template-author', 'videos'); ?>
			</div>
		</div>
	</div>
</section>
<?php }
