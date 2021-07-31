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
$list_services = array();
if (!empty($author_profile->profile_services)) {
    $list_services = $author_profile->profile_services;
}

if (!empty($list_services)) {?>
<section class="tg-haslayout tg-introductionhold spv4-services spv-bglight spv4-section"  id="section-services">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-lg-push-2">
				<?php get_template_part('directory/front-end/author-partials/provider/template-author', 'services'); ?>
			</div>
		</div>
	</div>
</section>
<?php }?>
