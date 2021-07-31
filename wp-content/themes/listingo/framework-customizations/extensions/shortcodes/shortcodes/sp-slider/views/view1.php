<?php if (!defined('FW')) die('Forbidden'); 

$slides				= !empty( $atts['slider_view']['view1']['slides'] ) ? $atts['slider_view']['view1']['slides'] : array();
$show_pagination 	= !empty( $atts['slider_view']['view1']['show_pagination'] ) ? $atts['slider_view']['view1']['show_pagination'] : '';
$show_navigation	= !empty( $atts['slider_view']['view1']['show_navigation'] ) ? $atts['slider_view']['view1']['show_navigation'] : '';
$counter 			= rand(9999, 9999999);

if ( !empty( $show_pagination ) && $show_pagination === 'enable' ) {	
	$dots_class = "true";
} else {	
	$dots_class = "false";
}

if ( !empty( $show_navigation ) && $show_navigation === 'enable' ) {
	$nav_class = "nav:true,";
	$nav_class .= "navClass: ['tg-btnprev', 'tg-btnnext'],";
	$nav_class .= "navContainerClass: 'tg-featuredprofilesbtns',";
	$nav_class .= "navText: [
						'<span><em>prev</em><i class=\'fa fa-angle-left\'></i></span>',
						'<span><i class=\'fa fa-angle-right\'></i><em>next</em></span>',
					],";
} else {
	$nav_class = "nav:false,";
}

?>
<div class="sc-slider tg-haslayout sp-slider-v1">
	<?php if ( !empty( $slides ) ) { ?>
		<div id="tg-homebanner-<?php echo esc_attr( $counter  ); ?>" class="tg-homebanner owl-carousel">
			<?php 
				foreach ($slides as $key => $value) {
				$slide_title 	 	= !empty( $value['title'] ) ? $value['title'] : '';
				$slide_sub_title 	= !empty( $value['sub_title'] ) ? $value['sub_title'] : '';
				$slide_description 	= !empty( $value['slide_description'] ) ? $value['slide_description'] : '';
				$slide_image 		= !empty( $value['slide_image']['url'] ) ? $value['slide_image']['url'] : '';
				$slide_buttons 		= !empty( $value['slide_buttons'] ) ? $value['slide_buttons'] : array();
			?>
				<figure class="tg-homebannerimg">
					<?php if ( !empty( $slide_image ) ) { ?>
						<img src="<?php echo esc_url( $slide_image ); ?>" alt="<?php esc_html_e('Slide image', 'listingo'); ?>">
					<?php } ?>
					<figcaption>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-8 col-md-push-2 col-lg-8 col-lg-push-2">
								<?php if (!empty( $slide_title ) || !empty( $slide_sub_title ) || !empty( $slide_description ) || !empty( $slide_buttons ) ) { ?>
									<div class="tg-bannercontent">
										<?php if ( !empty( $slide_title ) ) { ?>
											<h1><?php echo esc_attr( $slide_title ); ?></h1>
										<?php } ?>
										<?php if ( !empty( $slide_sub_title ) ) { ?>
											<h2><?php echo esc_attr( $slide_sub_title ); ?></h2>
										<?php } ?>
										<?php if ( !empty( $slide_description ) ) { ?>
											<div class="tg-description">
												<?php echo wpautop( do_shortcode( $slide_description ) ); ?>
											</div>
										<?php } ?>
										<?php 
										if ( !empty( $slide_buttons ) ) {?>
											<div class="tg-btnbox">
												<?php 
													foreach ($slide_buttons as $key => $value) {
														$btn_text = !empty( $value['button_text'] ) ? $value['button_text'] : '';
														$btn_link = !empty( $value['button_link'] ) ? $value['button_link'] : '#';
														if ( !empty( $btn_text ) ) {
														?>	
														<a class="tg-btn" href="<?php echo esc_attr( $btn_link ); ?>"><?php echo esc_attr( $btn_text ); ?></a>
												<?php }}?>
											</div>
										<?php }?>
									</div>
								<?php } ?>
							</div>
						</div>
					</figcaption>
				</figure>
			<?php } ?>
		</div>
		<?php 
			wp_add_inline_script('listingo_callbacks', "
			jQuery('#tg-homebanner-".esc_js( $counter  )."').owlCarousel({
			items:1,
			dots:". esc_js( $dots_class ) .",	
			". ( $nav_class ) . "		
			loop:true,			
			autoplay:false,
			rtl: ".listingo_owl_rtl_check().",
			smartSpeed:450,			
			animateOut: 'fadeOut',
			animateIn: 'fadeIn',															
			});
			", 'after');
		} ?>
</div>
