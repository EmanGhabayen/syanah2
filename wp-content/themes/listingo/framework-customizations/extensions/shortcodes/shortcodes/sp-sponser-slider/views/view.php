<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$heading 		= !empty($atts['sponser_heading']) ? $atts['sponser_heading'] : '';
$description 	= !empty($atts['sponser_description']) ? $atts['sponser_description'] : '';
$sponsers_list  = !empty($atts['sponser_list']) ? $atts['sponser_list'] : array();

$direction 		= !empty($atts['direction']) ? $atts['direction'] : '';
$sorting 		= !empty($atts['sorting']) ? $atts['sorting'] : '';
$autoplay 		= !empty($atts['autoplay']) ? $atts['autoplay'] : 'true';
$direction		=  isset( $direction ) && $direction === 'right_to_left' ? 'true' : listingo_owl_rtl_check();
$flag			= rand(1,9999);

?>

<div class="sp-sponsers-slider-wrap tg-haslayout">
	<?php if (!empty($heading) || !empty($description)) { ?>
		<div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
			<div class="tg-bannercontent">
				<?php if (!empty($heading)) { ?>
					<h1><?php echo esc_attr($heading); ?></h1>
				<?php } ?>
				<?php if (!empty($description)) { ?>
					<h2><?php echo wp_kses_post(wpautop(do_shortcode($description))); ?></h2>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
	<?php if (!empty($sponsers_list)) { ?>
		<div class="tg-advantagies">
			<div class="tg-haslayout sp-sponsers-slider owl-carousel" id="sponsers-slider-<?php echo esc_attr( $flag );?>">
				<?php
				$count = 1;
				foreach ($sponsers_list as $key => $sponser) {
					$sponser_icon = !empty($sponser['sponser_icon']) ? $sponser['sponser_icon'] : ''; 
					$sponser_title = !empty($sponser['sponser_title']) ? $sponser['sponser_title'] : '';
					$sponser_link = !empty($sponser['sponser_link']) ? $sponser['sponser_link'] : '#';
					$target = !empty($sponser['link_target']) ? $sponser['link_target'] : '_self';

					$thumb_meta = array();
					if (!empty($sponser_icon)) {
						$thumb_meta = listingo_get_image_metadata($sponser_icon['attachment_id']);
					}
					$image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : '';
					$image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;

					?>
					<div class="item">
						<div class="tg-advantage tg-advantageplan">
							<a href="<?php echo esc_url($sponser_link); ?>" target="<?php echo esc_attr($target); ?>">
								<span class="tg-sponserlogo">
									<em><img src="<?php echo esc_url($sponser_icon['url']); ?>" alt="<?php echo esc_attr($image_alt); ?>"></em>
								</span>
								<?php if (!empty($sponser_title)) { ?>
									<div class="tg-title">
										<h3><?php echo esc_attr($sponser_title); ?></h3>
									</div>
								<?php } ?>
							</a>
						</div>
					</div>

					<?php
					$count++;
				}
				?>
			</div>
			<?php
			   $script = "
					jQuery(document).ready(function(){
						jQuery('#sponsers-slider-".$flag."').owlCarousel({
							items:4,
							nav:false,
							loop:true,
							autoplay:".$autoplay.",
							rtl: ".$direction.",
							smartSpeed:450,
							dots:false,
							animateOut: 'fadeOut',
							animateIn: 'fadeIn',
							navClass: ['sp-prev', 'sp-next'],
							navContainerClass: 'sp-slidernav',
							navText: ['<span class=\"fa fa-angle-left\"></span>', '<span class=\"fa fa-angle-right\"></span>'],
							responsive: {
								0: {items: 2, },
								640: {items: 2, },
								768: {items: 4, },
								992: {items: 5, }
							}
						});
					});";
			    
				if( isset( $sorting ) && $sorting === 'shuffled' ){
					$shuffled = "
						jQuery(document).ready(function(){
							jQuery.fn.shuffle = function() {
								var allElems = this.get(),
									getRandom = function(max) {
										return Math.floor(Math.random() * max);
									},
									shuffled = jQuery.map(allElems, function(){
										var random = getRandom(allElems.length),
											randEl = jQuery(allElems[random]).clone(true)[0];
										allElems.splice(random, 1);
										return randEl;
								   });

								this.each(function(i){
									jQuery(this).replaceWith(jQuery(shuffled[i]));
								});

								return jQuery(shuffled);
							};
							
							jQuery('#sponsers-slider-".$flag.".owl-carousel .item').shuffle();
						});";
				   wp_add_inline_script('owl.carousel', $shuffled, 'after');
			  }
			  
			  wp_add_inline_script('owl.carousel', $script, 'after');
			  
	   		?>
		</div>
	<?php } ?>
</div>