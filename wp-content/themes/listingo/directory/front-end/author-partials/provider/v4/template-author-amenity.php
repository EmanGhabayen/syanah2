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
$list_amenities = array();
if (!empty($author_profile->profile_amenities)) {
    $list_amenities = $author_profile->profile_amenities;
}

if (!empty($list_amenities) && is_array($list_amenities)) { 
?>
<section class="tg-haslayout tg-introductionhold spv-bglight spv4-amenity spv4-section" id="section-amenity">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php get_template_part('directory/front-end/author-partials/provider/template-author', 'amenity'); ?>
			</div>
		</div>
	</div>
</section>
<?php }?>
