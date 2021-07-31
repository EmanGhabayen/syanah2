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
if (function_exists('fw_get_db_settings_option') && fw_ext('members')){
	do_action('render_sp_display_members');
} else{
	if (!empty($author_profile->teams_data)) {
?>
	<section class="tg-haslayout tg-introductionhold spv-bglight spv4-teams spv4-section" id="section-teams">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php get_template_part('directory/front-end/author-partials/provider/template-author', 'teams'); ?>
				</div>
			</div>
		</div>
	</section>
	<?php } 
}
