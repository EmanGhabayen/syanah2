<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Section_Heading')) {

    class SC_VC_Skin_Listingo_Section_Heading extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_section_heading", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "sec_title" => '',
                "heading_size" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args)); 

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_section_heading', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            ob_start();
            ?>       
            <div class="sp-sc-section-heading <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
               <?php if (!empty($sec_title) || !empty($content)) { ?>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
                        <div class="tg-sectionhead">
                             <?php if (!empty($sec_title)) { ?>
                                <div class="tg-sectiontitle">
                                    <h2><?php echo esc_attr($sec_title); ?></h2>
                                </div>
                            <?php } ?>
                            <?php if (!empty($content)) { ?>
                                <div class="tg-description">
                                    <?php echo wpautop(do_shortcode($content)); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_Listingo_Section_Heading();
}
