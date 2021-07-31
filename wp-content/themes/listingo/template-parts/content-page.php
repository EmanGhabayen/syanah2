<?php
/**
 *
 * The template part for displaying results in search pages.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */

if (function_exists('fw_get_db_settings_option')) {
	$archive_show_posts    = fw_get_db_settings_option('archive_show_posts' , $default_value = null);
	$archive_order    = fw_get_db_settings_option('archive_order' , $default_value = null);
	$archive_orderby    = fw_get_db_settings_option('archive_orderby' , $default_value = null);
	$archive_meta_information    = fw_get_db_settings_option('archive_meta_information' , $default_value = null);
	$archive_enable_sidebar    = fw_get_db_settings_option('archive_pages_sidebar' , $default_value = null);
	$archive_sidebar_position    = fw_get_db_settings_option('archive_pages_position' , $default_value = null);	
} else{
	$archive_show_posts    = get_option('posts_per_page');
	$archive_order    = 'DESC';
	$archive_orderby    = 'ID';
	$archive_meta_information    = 'enable';
	$archive_enable_sidebar    = 'enable';
	$archive_sidebar_position    = 'right';
}

if ( isset( $archive_enable_sidebar ) && $archive_enable_sidebar === 'disable' ) {
	$section_width = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
} else{
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$section_width = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
	} else{
		$section_width = 'col-xs-12 col-sm-8 col-md-8 col-lg-9';
	}
	
}
	
if ( isset($archive_sidebar_position) && $archive_sidebar_position === 'left') {
    $aside_class = 'pull-left';
    $content_class = 'pull-right';
} else {
	$aside_class = 'pull-right';
    $content_class = 'pull-left';
}
			
?>
<div class="<?php echo esc_attr( $section_width );?> page-section <?php echo sanitize_html_class($content_class); ?>">
	<?php 
		if ( have_posts() ) { 
			get_template_part( 'template-parts/archive-templates/content', 'list' );
		} else{
			get_template_part( 'template-parts/content', 'none' );
		}
	?>
</div>
<?php if ( is_active_sidebar( 'sidebar-1' ) && $archive_enable_sidebar === 'enable' ) {?>
	<aside id="tg-sidebar" class="col-xs-12 col-sm-4 col-md-4 col-lg-3 <?php echo sanitize_html_class($aside_class); ?>">
		<div class="tg-sidebar">
			<?php get_sidebar(); ?>
		</div>
	</aside>
<?php } ?>
			
