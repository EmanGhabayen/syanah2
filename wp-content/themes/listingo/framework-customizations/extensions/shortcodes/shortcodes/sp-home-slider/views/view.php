<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$slides = !empty($atts['banner_slides']) ? $atts['banner_slides'] : array();
$loop = !empty($atts['loop']) && $atts['loop'] === 'true' ? 'true' : 'false';
$nav = !empty($atts['nav']) && $atts['nav'] === 'true' ? 'true' : 'false';
$autoplay = !empty($atts['autoplay']) && $atts['autoplay'] === 'true' ? 'true' : 'false';

$flag = rand(1, 9999);
?>
<div class="sp-sc-home-banner-slider tg-haslayout">
    <?php if (!empty($slides)) {?>
        <div id="tg-homebannervthree-<?php echo esc_attr($flag); ?>" class="tg-homebannervthree tg-haslayout owl-carousel">
            <?php
            foreach ($slides as $key => $banner_slide) {
                $slide_img = !empty($banner_slide['bg_image']['url']) ? $banner_slide['bg_image']['url'] : '';
                $slide_title = !empty($banner_slide['slide_title']) ? $banner_slide['slide_title'] : '';
                $slide_desc = !empty($banner_slide['slide_desc']) ? $banner_slide['slide_desc'] : '';
                $slide_btns = !empty($banner_slide['slide_btns']) ? $banner_slide['slide_btns'] : array();

                if (!empty($slide_title) ||
					!empty($slide_desc) ||
					!empty($slide_btns) ||
					!empty($slide_img)) {
                    ?>
                    <figure class="tg-homebannerimg">
                        <?php if (!empty($slide_img)) { ?>
                            <img src="<?php echo esc_url($slide_img); ?>" alt="<?php esc_html_e('Banner', 'listingo') ?>">
                        <?php } ?>
                        <?php
                        if (!empty($slide_title) ||
							!empty($slide_desc) ||
							!empty($slide_btns)) {
                            ?>
                            <figcaption>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-md-push-2 col-lg-8 col-lg-push-2">
                                            <div class="tg-bannercontent">
                                                <?php if (!empty($slide_title)) {?>
                                                    <h1><?php echo force_balance_tags($slide_title); ?></h1>
                                                <?php } ?>
                                                <?php if (!empty($slide_desc)) { ?>
                                                    <div class="tg-description">
                                                        <?php echo wpautop(do_shortcode($slide_desc)); ?>
                                                    </div>
                                                <?php } ?>
                                                <?php if (!empty($slide_btns)) { ?>
                                                    <div class="tg-btnbox">
                                                        <?php
                                                        foreach ($slide_btns as $key => $slide_btn) {
                                                            $btn_title = !empty($slide_btn['btn_title']) ? $slide_btn['btn_title'] : '';
                                                            $btn_link = !empty($slide_btn['btn_link']) ? $slide_btn['btn_link'] : '#';
                                                            $btn_target = !empty($slide_btn['btn_target']) ? $slide_btn['btn_target'] : '_self';
                                                            $btn_active = !empty($slide_btn['btn_active']) && $slide_btn['btn_active'] === 'active' ? 'tg-active' : '';
                                                            
                                                            if (!empty($btn_title)) { ?>
                                                                <a class="tg-btn tg-btnvtwo <?php echo esc_attr($btn_active); ?>" target="<?php echo esc_attr($btn_target); ?>" href="<?php echo esc_url($btn_link); ?>"><?php echo esc_attr($btn_title); ?></a>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </figcaption>
                        <?php } ?>
                    </figure>
                    <?php
                }
            }
            $script = '
            	jQuery("#tg-homebannervthree-' . esc_js($flag) . '").owlCarousel({
                    items:1,
                    nav: ' . esc_js($nav) . ',
                    loop:' . esc_js($loop) . ',
                    dots:false,
                    autoplay:' . esc_js($autoplay) . ',
					rtl: ' . listingo_owl_rtl_check() . ',
                    smartSpeed:450,
                    navClass: ["tg-btnprev", "tg-btnnext"],
                    animateOut: "fadeOut",
                    animateIn: "fadeIn",
                    navContainerClass: "tg-featuredprofilesbtnsvtwo",
                    navText: [
                        "<span>'.esc_html__('PR','listingo').'<em>'.esc_html__('EV','listingo').'</em></span>",
                        "<span>'.esc_html__('NE','listingo').'<em>'.esc_html__('XT','listingo').'</em></span>",
                    ],
                });
            ';
            wp_add_inline_script('listingo_callbacks', $script, 'after');
            ?>
        </div>
    <?php } ?>
</div>
