<?php
/**
 *
 * Author Sidebar Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $wp_query, $current_user;
/**
 * Get User Queried Object Data
 */
$author_profile = $wp_query->get_queried_object();
$profile_section = apply_filters('listingo_get_profile_sections',$author_profile->ID,'sidebar',$author_profile->ID);
?>
<div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
    <aside id="tg-sidebar" class="tg-sidebar">
        <div class="tg-widget tg-widgetlocationandcontactinfo">
            <?php get_template_part('directory/front-end/author-partials/provider/template-author-sidebar', 'map');?>
			<?php get_template_part('directory/front-end/author-partials/provider/template-author-sidebar', 'contactinfo');?>
		</div>
       	<?php
			foreach( $profile_section as $key => $value  ){
				get_template_part('directory/front-end/author-partials/provider/template-author-sidebar', $key);
			}
		?>
       <?php if (is_active_sidebar('user-page-sidebar')) {?>
		  <div class="tg-advertisement">
			<?php dynamic_sidebar('user-page-sidebar'); ?>
		  </div>
	   <?php }?>
    </aside>
</div>