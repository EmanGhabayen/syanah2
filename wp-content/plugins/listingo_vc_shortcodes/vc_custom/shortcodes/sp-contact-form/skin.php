<?php
/**
 * @ Visual Composer Shortcode
 * @ Class SP Contact Form
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_SP_Contact_Form')) {

    class SC_VC_Skin_SP_Contact_Form extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_sp_contact_form", array(
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
                "sp_contact_form" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_sp_contact_form', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            ob_start();
            ?>
            <div class="sc-sp-contact-form <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <?php if (!empty($sec_heading) || !empty($content)) { ?>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
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
                <?php } ?>
                <?php if (!empty($sp_contact_form)) { ?>
                    <div class="tg-contactusarea contact_wrap">
                        <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-10 col-lg-push-1">
                            <div class="form-refinesearch tg-haslayout tg-themeform contact_form">
                                <fieldset>
                                    <?php echo do_shortcode('[contact-form-7 id="' . $sp_contact_form . '"]'); ?>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_SP_Contact_Form();
}
