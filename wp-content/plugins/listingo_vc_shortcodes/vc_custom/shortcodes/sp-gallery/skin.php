<?php
/**
 * @ Visual Composer Shortcode
 * @ Class SP Gallery
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_SP_Gallery')) {

    class SC_VC_Skin_SP_Gallery extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_sp_gallery", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "sec_heading" => '',
                "gallery_images" => array(),
                "button_link" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_sp_gallery', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;
            $gallery_image_ids = explode(',', $gallery_images);

            ob_start();
            ?>
            <div class="sc-sp-photo-gallery sp-photo-gallery tg-companyfeaturebox tg-gallery tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>

                <?php if (!empty($sec_heading) || !empty($content)) { ?>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
                        <div class="tg-sectionhead">
                            <?php if (!empty($sec_heading)) { ?>
                                <div class="tg-sectiontitle">
                                    <h2><?php echo esc_attr($sec_heading); ?></h2>
                                </div>
                            <?php } ?>
                            <?php if (!empty($content)) { ?>
                                <div class="tg-description">
                                    <?php echo wp_kses_post(wpautop(do_shortcode($content))); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if (!empty($gallery_image_ids)) { ?>
                    <ul>
                        <?php
                        foreach ($gallery_image_ids as $images) {

                            $thumb_meta = array();
                            $thumbnail = '';
                            $full_thumb = '';

                            if (!empty($images)) {
                                $thumb_meta = $this->listingo_vc_shortcodes_get_image_metadata($images);
                                $thumbnail = $this->listingo_vc_shortcodes_get_image_source($images, intval(150), intval(150));
                                $full_thumb = $this->listingo_vc_shortcodes_get_image_source($images, intval(0), intval(0));
                            }
                            $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $thumb_meta['title'];
                            if (!empty($thumbnail)) {
                                ?>
                                <li>
                                    <div class="tg-galleryimgbox">
                                        <figure>
                                            <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                            <a class="tg-btngallery" href="<?php echo esc_url($full_thumb); ?>" data-rel="prettyPhoto[gallery]" rel="prettyPhoto[gallery]">
                                                <i class="lnr lnr-magnifier"></i>
                                            </a>
                                        </figure>
                                    </div>
                                </li>				
                                <?php
                            }
                        }
                        ?>
                    </ul>
                <?php } ?>
            </div>
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_SP_Gallery();
}
