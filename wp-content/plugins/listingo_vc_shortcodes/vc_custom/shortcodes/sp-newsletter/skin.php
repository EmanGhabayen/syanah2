<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Mailchimp')) {

    class SC_VC_Skin_Listingo_Mailchimp extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_mailchimp", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "heading" => '',
                "form_heading" => '',
                "username" => 'yes',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_mailchimp', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            ob_start();
            ?>
            <div class="sp-sc-newsletter <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <div class="row">
                    <?php if (!empty($heading) || !empty($content)) { ?>
                        <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8 pull-left">
                            <?php if (!empty($heading)) { ?>
                                <div class="tg-testimonial">
                                    <h2><?php echo esc_attr($heading); ?></h2>
                                </div>
                            <?php } ?>
                            <?php if (!empty($content)) { ?>
                                <div class="tg-description">
                                    <?php echo wp_kses_post(wpautop(do_shortcode($content))); ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-left">
                        <form class="tg-themeform signup-newletter">
                            <?php if (!empty($form_heading)) { ?>
                                <div class="tg-testimonial">
                                    <h2><?php echo esc_attr($form_heading); ?></h2>
                                </div>
                            <?php } ?>
                            <fieldset>
                                <?php if (isset($username) && $username === 'yes') { ?>
                                    <div class="form-group">
                                        <input type="text" name="fname" class="form-control" placeholder="<?php esc_attr_e('Your name', 'listingo_vc_shortcodes'); ?>">
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="<?php esc_attr_e('Your email address', 'listingo_vc_shortcodes'); ?>">
                                </div>
                                <button type="submit" class="tg-btn subscribe_me"><?php esc_html_e('Subscribe', 'listingo_vc_shortcodes'); ?></button>
                            </fieldset>
                        </form>
                    </div>	
                </div>
            </div>            
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_Listingo_Mailchimp();
}
