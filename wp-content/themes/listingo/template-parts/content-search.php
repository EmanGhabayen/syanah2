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
	$search_show_posts    = fw_get_db_settings_option('search_show_posts' , $default_value = null);
	$search_order    = fw_get_db_settings_option('search_order' , $default_value = null);
	$search_orderby    = fw_get_db_settings_option('search_orderby' , $default_value = null);
	$search_meta_information    = fw_get_db_settings_option('search_meta_information' , $default_value = null);
	$search_enable_sidebar    = fw_get_db_settings_option('search_enable_sidebar' , $default_value = null);
	$search_sidebar_position    = fw_get_db_settings_option('search_sidebar_position' , $default_value = null);	
} else{
	$search_show_posts    = get_option('posts_per_page');
	$search_order    = 'DESC';
	$search_orderby    = 'ID';
	$search_meta_information    = 'enable';
	$search_enable_sidebar    = 'enable';
	$search_sidebar_position    = 'right';
}

if ( isset( $search_enable_sidebar ) && $search_enable_sidebar === 'disable' ) {
	$section_width = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
} else{
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$section_width = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
	} else{
		$section_width = 'col-xs-12 col-sm-8 col-md-8 col-lg-9';
	}
	
}
	
if ( isset($search_sidebar_position) && $search_sidebar_position === 'left') {
    $aside_class = 'pull-left';
    $content_class = 'pull-right';
} else {
	$aside_class = 'pull-right';
    $content_class = 'pull-left';
}
			
?>
<div class="<?php echo esc_attr( $section_width );?> page-section <?php echo sanitize_html_class($content_class); ?>">
    <div class="border-left">
        <h3><?php printf(esc_attr('Search Results for: %s' , 'listingo') , '<span>' . get_search_query() . '</span>'); ?></h3>
    </div><!-- .page-header -->
	<?php if ( have_posts() && strlen( trim(get_search_query()) ) != 0 ) {?>
		<div class="need-help">
			<h4><?php  esc_html_e('Need a new search?','listingo');?> </h4>
			<p><?php  esc_html_e('If you didn\'t find what you were looking for, try a new search!','listingo');?></p>
		</div>
		<div class="tg-blog-search">
			<?php get_search_form();?>
		</div>
	<?php 
		get_template_part( 'template-parts/archive-templates/search', 'list' );
	} else{
	?>
	<div class="search-result-none">
		<p><?php  esc_html_e('Couldn\'t find what you\'re looking for!','listingo');?></p>
		<div class="need-help">
			<h4><?php  esc_html_e('Try again!','listingo');?> </h4>
			<p><?php  esc_html_e('If you want to rephrase your query, here is your chance:','listingo');?></p>
		</div>
		<div class="tg-blog-search">
			<?php get_search_form();?>
		</div>
	</div>
	<?php
	}
    ?>
</div>
<?php if ( is_active_sidebar( 'sidebar-1' ) && $search_enable_sidebar === 'enable' ) {?>
	<aside id="tg-sidebar" class="col-xs-12 col-sm-4 col-md-4 col-lg-3 <?php echo sanitize_html_class($aside_class); ?>">
		<div class="tg-sidebar">
			<?php get_sidebar(); ?>
		</div>
	</aside>
<?php } ?>
			
