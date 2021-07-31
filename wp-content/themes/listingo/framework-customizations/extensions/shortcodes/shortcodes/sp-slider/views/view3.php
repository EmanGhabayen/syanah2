<?php if (!defined('FW')) die('Forbidden'); 

$image 				= !empty( $atts['slider_view']['view3']['image'] ) ? $atts['slider_view']['view3']['image'] : '';
$images 			= !empty( $atts['slider_view']['view3']['images'] ) ? $atts['slider_view']['view3']['images'] : array();
$title 				= !empty( $atts['slider_view']['view3']['title'] ) ? $atts['slider_view']['view3']['title'] : '';
$sub_title 			= !empty( $atts['slider_view']['view3']['sub_title'] ) ? $atts['slider_view']['view3']['sub_title'] : '';
$show_pagination 	= !empty( $atts['slider_view']['view3']['show_pagination'] ) ? $atts['slider_view']['view3']['show_pagination'] : '';
$show_form			= !empty( $atts['slider_view']['view3']['show_form']['gadget'] ) ? $atts['slider_view']['view3']['show_form']['gadget'] : '';
$form_button		= !empty( $atts['slider_view']['view3']['show_form']['yes']['btn_link'] ) ? $atts['slider_view']['view3']['show_form']['yes']['btn_link']  : esc_html__('Search Now', 'listingo');
$bg_color			= !empty( $atts['slider_view']['view3']['overlay_color'] ) ? $atts['slider_view']['view3']['overlay_color']  : 'rgba(0, 0, 0, 0.50)';

$counter 			= rand(9999, 9999999);

$img_url = !empty( $image['url'] ) ? $image['url'] : '';

if ( !empty( $show_pagination ) && $show_pagination === 'enable' ) {	
	$dots_class = "true";
} else {	
	$dots_class = "false";
}

$dir_search_page = fw_get_db_settings_option('dir_search_page');
if (isset($dir_search_page[0]) && !empty($dir_search_page[0])) {
    $search_page = get_permalink((int) $dir_search_page[0]);
} else {
    $search_page = '';
}
?>

<div class="sc-sliders tg-haslayout sp-slider-v3">
	<div class="tg-bannerholder">
		<div class="tg-bannercontent">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 col-lg-push-2 col-xs-12 sp-search-form3">
						<?php if (!empty( $title ) || !empty( $sub_title ) || !empty( $img_url ) ) { ?>
							<div class="tg-bannercaption">
								<?php if ( !empty( $img_url ) ) { ?>
									<figure class="sp-top-image">
										<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php esc_html_e('Image', 'listingo'); ?>">
									</figure>
								<?php } ?>
								<?php if ( !empty( $title ) ) { ?>
									<h1><?php echo esc_attr( $title ); ?></h1>
								<?php } ?>
								<?php if ( !empty( $sub_title ) ) { ?>
									<h2><?php echo esc_attr( $sub_title ); ?></h2>
								<?php } ?>												
							</div>
						<?php } ?>	
						<?php if ( !empty( $show_form  ) && $show_form  === 'yes' ){ ?>
							<div class="tg-verticalmiddle">
								<div class="tg-searchbox3">
									<form class="tg-formtheme tg-formsearch" method="get" action="<?php echo esc_url( $search_page ); ?>">
										<fieldset>																				
											<div class="form-group">
												<?php do_action('listingo_get_search_geolocation'); ?>
											</div>															
											<div class="tg-btns">
												<button class="tg-btn" type="submit"><?php echo esc_attr( $form_button ); ?></button>
											</div>
										</fieldset>
									</form>
								</div>
							</div>
						<?php } ?>				
					</div>
				</div>
			</div>
		</div>
		<?php if ( !empty( $images  ) ) { ?>
			<div id="tg-homebannervtwo-<?php echo esc_attr( $counter  ); ?>" class="tg-homebanner tg-homebannervtwo owl-carousel">
				<?php 
					foreach ( $images  as $key => $value ) {
					$slide_image 		= !empty( $value['url'] ) ? $value['url'] : '';
					if ( !empty( $slide_image ) ) {

				?>
					<figure class="tg-homebannerimg">
						<img src="<?php echo esc_url( $slide_image ); ?>" alt="<?php esc_html_e('Slide image', 'listingo'); ?>">
						<figcaption style="background:<?php echo esc_attr( $bg_color );?>"></figcaption>
					</figure>	
				<?php } } ?>			
			</div>
			<?php 
				wp_add_inline_script('listingo_callbacks', "
				var _tg_slider = jQuery('#tg-homebannervtwo-".esc_js( $counter  )."')
				_tg_slider.owlCarousel({
				items:1,
				dots:". esc_js( $dots_class ) .",				
				loop:true,
				autoplay:false,
				rtl: ".listingo_owl_rtl_check().",
				smartSpeed:450,
				navClass: ['tg-btnprev', 'tg-btnnext'],
				animateOut: 'fadeOut',
				animateIn: 'fadeIn',
				navContainerClass: 'tg-featuredprofilesbtns',
				navText: [
							'<span><em>prev</em><i class=\'fa fa-angle-left\'></i></span>',
							'<span><i class=\'fa fa-angle-right\'></i><em>next</em></span>',
						],		
									
				});
				", 'after');
			?>
		<?php } ?>
	</div>
</div>