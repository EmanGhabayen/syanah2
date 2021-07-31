<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Section_Heading_V2')) {

    class SC_VC_Skin_Listingo_Section_Heading_V2 extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_section_heading_v2", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "section_heading" => '',
                "section_subheading" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_section_heading_v2', $args);

            $classes = array();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            ob_start();
            ?>       
            <div class="sp-sc-section-heading-v2 <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <?php if (!empty($section_heading) || !empty($section_subheading)) { ?>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
                        <div class="tg-sectionheadvtwo">
                            <div class="tg-sectiontitle">
                                <?php if (!empty($section_subheading)) { ?>
                                    <span><?php echo esc_attr($section_subheading); ?></span>
                                <?php } ?>
                                <?php if (!empty($section_heading)) { ?>
                                    <h2><?php echo esc_attr($section_heading); ?></h2>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_Listingo_Section_Heading_V2();
}
