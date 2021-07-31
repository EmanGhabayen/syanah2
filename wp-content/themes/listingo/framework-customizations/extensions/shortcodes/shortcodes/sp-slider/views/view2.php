<?php if (!defined('FW')) die('Forbidden'); 

$images 			= !empty( $atts['slider_view']['view2']['images'] ) ? $atts['slider_view']['view2']['images'] : array();
$title 				= !empty( $atts['slider_view']['view2']['title'] ) ? $atts['slider_view']['view2']['title'] : '';
$sub_title 			= !empty( $atts['slider_view']['view2']['sub_title'] ) ? $atts['slider_view']['view2']['sub_title'] : '';
$slide_description 	= !empty( $atts['slider_view']['view2']['slide_description'] ) ? $atts['slider_view']['view2']['slide_description'] : '';
$slide_buttons 		= !empty( $atts['slider_view']['view2']['slide_buttons'] ) ? $atts['slider_view']['view2']['slide_buttons'] : array();
$show_pagination 	= !empty( $atts['slider_view']['view2']['show_pagination'] ) ? $atts['slider_view']['view2']['show_pagination'] : '';
$show_form			= !empty( $atts['slider_view']['view2']['show_form']['gadget'] ) ? $atts['slider_view']['view2']['show_form']['gadget'] : '';
$form_title			= !empty( $atts['slider_view']['view2']['show_form']['yes']['form_title'] ) ? $atts['slider_view']['view2']['show_form']['yes']['form_title']  : '';
$form_button		= !empty( $atts['slider_view']['view2']['show_form']['yes']['btn_link'] ) ? $atts['slider_view']['view2']['show_form']['yes']['btn_link']  : 'Search Now';
$counter 			= rand(9999, 9999999);

if (function_exists('fw_get_db_settings_option')) {
	$dir_location = fw_get_db_settings_option('dir_location');
	$dir_keywords = fw_get_db_settings_option('dir_keywords');
} else {
	$dir_location = '';
	$dir_keywords = '';
}

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

<div class="sc-sliders tg-haslayout sp-slider-v2">
	<div class="tg-bannerholder">
		<div class="tg-bannercontent">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 tg-verticalmiddle">
						<?php if (!empty( $title ) || !empty( $sub_title ) || !empty( $slide_description ) || !empty( $slide_buttons ) ) { ?>
							<div class="tg-bannercaption">
								<?php if ( !empty( $title ) ) { ?>
									<h1><?php echo esc_attr( $title ); ?></h1>
								<?php } ?>
								<?php if ( !empty( $sub_title ) ) { ?>
									<h2><?php echo esc_attr( $sub_title ); ?></h2>
								<?php } ?>
								<?php if ( !empty( $slide_description ) ) { ?>
									<div class="tg-description">
										<?php echo wpautop( do_shortcode( $slide_description ) ); ?>
									</div>
								<?php } ?>
								<?php 
								if ( !empty( $slide_buttons ) ) {
									foreach ($slide_buttons as $key => $value) {
									$btn_text = !empty( $value['button_text'] ) ? $value['button_text'] : '';
									$btn_link = !empty( $value['button_link'] ) ? $value['button_link'] : '#';
									if ( !empty( $btn_text ) ) {
								?>	
									<div class="tg-btnbox">
										<a class="tg-btn" href="<?php echo esc_attr( $btn_link ); ?>"><?php echo esc_attr( $btn_text ); ?></a>
									</div>
								<?php } } } ?>
							</div>
						<?php } ?>					
					</div>
					<?php if ( !empty( $show_form  ) && $show_form  === 'yes' ){ ?>
						<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 tg-verticalmiddle">
							<div class="tg-searchbox">
								<form class="tg-formtheme tg-formsearch" method="get" action="<?php echo esc_url( $search_page ); ?>">
									<fieldset>
										<?php if ( !empty( $form_title ) ) { ?>
											<legend><?php echo esc_attr( $form_title ); ?></legend>
										<?php } ?>
										<?php if (!empty($dir_keywords) && $dir_keywords === 'enable') { ?>
										<div class="form-group">
											<?php do_action('listingo_get_search_keyword'); ?>
										</div>
										<?php }?>
										<?php if (!empty($dir_location) && $dir_location === 'enable') { ?>
										<div class="form-group">
											<?php do_action('listingo_get_search_geolocation'); ?>
										</div>
										<?php }?>
										<div class="form-group tg-inputwithicon">
											<?php do_action('listingo_get_search_category'); ?>										
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
		<?php if ( !empty( $images  ) ) { ?>
			<div id="tg-homebannervtwo-<?php echo esc_attr( $counter  ); ?>" class="tg-homebanner tg-homebannervtwo owl-carousel">
				<?php 
					foreach ( $images  as $key => $value ) {
					$slide_image 		= !empty( $value['url'] ) ? $value['url'] : '';
					if ( !empty( $slide_image ) ) {
				?>
					<figure class="tg-homebannerimg">
						<img src="<?php echo esc_url( $slide_image ); ?>" alt="<?php esc_html_e('Slide image', 'listingo'); ?>">
						<figcaption></figcaption>
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