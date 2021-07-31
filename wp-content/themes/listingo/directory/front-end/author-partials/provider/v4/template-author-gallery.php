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
$list_gallery = array();
if (!empty($author_profile->profile_gallery_photos)) {
    $list_gallery = $author_profile->profile_gallery_photos;
}

if (!empty($list_gallery)) { 
?>
<section class="tg-haslayout tg-introductionhold spv4-gallery spv-bglight spv4-section" id="section-gallery">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-lg-push-2">
				<?php get_template_part('directory/front-end/author-partials/provider/template-author', 'gallery'); ?>
			</div>
		</div>
	</div>
</section>
<?php }
