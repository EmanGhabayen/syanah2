<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */

$uniq_flag = fw_unique_increment();


if (function_exists('fw_get_db_settings_option')) {
    $dir_search_page = fw_get_db_settings_option('dir_search_page');
	
	$zip_search = fw_get_db_settings_option('zip_search');
	$misc_search = fw_get_db_settings_option('misc_search');
	$dir_search_insurance = fw_get_db_settings_option('dir_search_insurance');
	$language_search = fw_get_db_settings_option('language_search');
	$country_cities = fw_get_db_settings_option('country_cities');
	$dir_radius = fw_get_db_settings_option('dir_radius');
	$dir_location = fw_get_db_settings_option('dir_location');
	$dir_keywords = fw_get_db_settings_option('dir_keywords');
} else {
    $dir_search_page = '';
	
	$dir_radius = '';
	$dir_location = '';
	$dir_keywords = '';
	$misc_search = '';
	$zip_search = '';
	$dir_search_insurance = '';
	$language_search = '';
	$country_cities = '';
}

$color			= !empty( $atts['color'] ) ? $atts['color'] : '';
$trendings		= !empty( $atts['trendings'] )  ? $atts['trendings'] : array();
$geo_type		= !empty( $atts['geo_type'] ) ? $atts['geo_type'] : '';
$btn_title		= !empty( $atts['btn_title'] ) ? $atts['btn_title'] : esc_html__('Search Places','listingo');
$pagination 	= isset($atts['pagination']) && $atts['pagination'] === 'true' ? 'true' : 'false';
$loop       	= isset($atts['loop']) && $atts['loop'] === 'true' ? 'true' : 'false';
$autoplay   	= isset($atts['autoplay']) && $atts['autoplay'] === 'true' ? 'true' : 'false';


//total posts Query 
$query_args = array(
    'posts_per_page' => -1,
    'post_type' => 'sp_categories',
    'post_status' => 'publish',
    'ignore_sticky_posts' => 1);

//By Posts 
if (!empty($trendings)) {
	$posts_in['post__in']	= $trendings;
    $query_args = array_merge($query_args, $posts_in);
}

$catquery = new WP_Query($query_args);
?>
<div class="sp-search-provider-banner-v2 sp-version tg-mapinnerbanner tg-haslayout">
	<div class="tg-searchbox">
		<?php if (!empty($atts['title']) || !empty($atts['subtitle']) ) { ?>
			<div class="tg-bannercontent">
				<?php if (!empty($atts['title'])) { ?><h1 style="color:<?php echo ( $color ) ;?>"><?php echo esc_attr($atts['title']); ?></h1><?php }?>
				<?php if (!empty($atts['subtitle'])) { ?><h2 style="color:<?php echo ( $color ) ;?>"><?php echo esc_attr($atts['subtitle']); ?></h2><?php }?>
			</div>
		<?php }?>
		<div class="tg-themeform tg-formsearch tg-haslayout">
			<form class="sp-form-search" action="<?php echo listingo_get_search_page_uri();?>" method="get">  
				<fieldset>
					<?php if (!empty($dir_keywords) && $dir_keywords === 'enable') { ?>
						<div class="form-group">
							<?php do_action('listingo_get_search_keyword'); ?>
						</div>
					<?php }?>
					<?php 
					if( isset( $geo_type ) && $geo_type === 'countries' ){
						do_action('listingo_get_countries_list');
					}else {
						if (!empty($dir_location) && $dir_location === 'enable') { ?>
							<div class="form-group tg-inputwithicon">
								<?php do_action('listingo_get_search_geolocation'); ?>
							</div>
						<?php }?>
					<?php }?>
					<div class="form-group">
						<?php do_action('listingo_get_search_category'); ?>
					</div>
					
				</fieldset>
				<div class="btn-center">
					<?php do_action('listingo_get_search_permalink_setting');?>
					<button class="tg-btn" type="submit"><?php echo esc_attr( $btn_title );?><span class="lnr lnr-chevron-right"></span></button>
				</div>
			</form>
		</div>
		<div class="sp-sponsers-slider trending-cats owl-carousel" id="trencat-slider-<?php echo esc_attr( $uniq_flag );?>">
			<?php
			while ($catquery->have_posts()) {
				$catquery->the_post();
					global $post;
					$category_icon = '';
					$category_color = '';
					if (function_exists('fw_get_db_post_option')) {
						$categoy_bg_img = fw_get_db_post_option($post->ID, 'category_image', true);
						$category_icon = fw_get_db_post_option($post->ID, 'category_icon', true);
						$category_color = fw_get_db_post_option($post->ID, 'category_color', true);
					}

					//Generate Directory page link
					$directory_link = add_query_arg('category', $post->post_name, $search_page);
				?>
				<div class="tg-categoryv2 item">
					<div class="tg-categoryholder">
						<a href="<?php echo esc_url(get_permalink()); ?>">
							<figure>
								<?php
									if (isset($category_icon['type']) && $category_icon['type'] === 'icon-font') {
										do_action('enqueue_unyson_icon_css');
										if (!empty($category_icon['icon-class'])) {
											?>
											<span class="<?php echo esc_attr($category_icon['icon-class']); ?> tg-categoryicon" style="color:<?php echo ( $color ) ;?>"></span>
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
							</figure>
							<h3><?php echo get_the_title(); ?></h3>
						</a>
					</div>
				</div>
				<?php
			   $script = "
					jQuery(document).ready(function(){
						jQuery('#trencat-slider-".$uniq_flag."').owlCarousel({
							items:5,
							loop:".esc_js($loop).",
							margin:0,
							autoplay:".esc_js($autoplay).",
							rtl: ".listingo_owl_rtl_check().",
							smartSpeed:450,
							dots:".esc_js($pagination).",
							animateOut: 'fadeOut',
							animateIn: 'fadeIn',
							responsive: {
								0: {items: 1, },
								640: {items: 2, },
								768: {items: 3, },
								992: {items: 5, }
							}
						});
					});";
			   wp_add_inline_script('owl.carousel', $script, 'after');
	   		?>
			<?php } wp_reset_postdata();?>
		</div>
	</div>
</div>