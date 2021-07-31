<?php
/**
 *
 * The template used for displaying audio post formate
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $post, $blog_post_gallery;
$uniq_flag = fw_unique_increment();
?>
<div class="slider-type-two">
    <div id="tg_detail_post_slider" class="owl-carousel tg-blog-detail-slider tg-haslayout">
        <?php
        foreach ($blog_post_gallery as $blog_gallery) {
            $width = 1180;
            $height = 400;
            $thumbnail = listingo_prepare_image_source($blog_gallery['attachment_id'], $width, $height);
            $thumb_meta = array();
            if (!empty($blog_gallery['attachment_id'])) {
                $thumb_meta = listingo_get_image_metadata($blog_gallery['attachment_id']);
            }
            $image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : 'no-name';
            $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;
            if (isset($thumbnail) && !empty($thumbnail)) {
                ?>
                <div class="item">
                    <figure class="tg-themepost-img">
                        <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($image_alt); ?>" />
                    </figure>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>
<?php
$script = "jQuery(document).ready(function(){
	jQuery('#tg_detail_post_slider').owlCarousel({
		items:1,
		nav:true,
		loop:true,
		rtl: ".listingo_owl_rtl_check().",
		autoplay:false,
		smartSpeed:450,
		navClass: ['tg-btnprev', 'tg-btnnext'],
		animateOut: 'fadeOut',
		animateIn: 'fadeIn',
		navContainerClass: 'tg-featuredprofilesbtns',
		navText: [
					'<span><em>prev</em><i class=\"fa fa-angle-left\"></i></span>',
					'<span><i class=\"fa fa-angle-right\"></i><em>next</em></span>',
				],
		
	});
    });";
wp_add_inline_script('listingo_callbacks', $script, 'after');
?>