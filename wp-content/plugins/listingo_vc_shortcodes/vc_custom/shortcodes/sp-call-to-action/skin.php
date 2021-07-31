<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Call to action
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Call_To_Action')) {

    class SC_VC_Skin_Call_To_Action extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_call_to_action", array(
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
                "sub_title" => '',
                "call_to_action_image" => '',
                "button_link" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_call_to_action', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            $image_meta = array();
            $image = '';
            if (!empty($call_to_action_image)) {
                $image_meta = $this->listingo_vc_shortcodes_get_image_metadata($call_to_action_image);
                $image = $this->listingo_vc_shortcodes_get_image_source($call_to_action_image, 0, 0);
            }
			
            $image_alt = !empty($image_meta['alt']) ? $image_meta['alt'] : '';
			
            $cta_class = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
			
            if (!empty($image)) {
                $cta_class = 'col-xs-12 col-sm-12 col-md-8 col-lg-8';
            }

            $link = '';
            if (!empty($button_link)) {
                $link = vc_build_link($button_link);
            }
			
            $title = !empty($link['title']) ? $link['title'] : esc_html__('Join Now', 'listingo_vc');
            $target = !empty($link['target']) ? $link['target'] : '_self';
            $link_url = !empty($link['url']) ? $link['url'] : '#';

            ob_start();
            ?>
            <div class="sc-sp-call-to-action tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>

                <div class="row">
                    <?php if (!empty($image)) { ?>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
                            <figure class="tg-noticeboard">
                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                            </figure>
                        </div>
                    <?php } ?>
                    <?php
                    if (!empty($sec_heading) ||
						!empty($sub_title) ||
						!empty($content) ||
						!empty($button_text)) {
                        ?>
                        <div class="<?php echo esc_attr($cta_class); ?> pull-left">
                            <div class="tg-secureandreliable">
                                <div class="tg-textshortcode">
                                    <?php if (!empty($sec_heading)) { ?>
                                        <h2><?php echo esc_attr($sec_heading); ?></h2>
                                    <?php } ?>
                                    <?php if (!empty($sub_title)) { ?>
                                        <h3><?php echo esc_attr($sub_title); ?></h3>
                                    <?php } ?>
                                    <?php if (!empty($content)) { ?>
                                        <div class="tg-description">
                                            <?php echo wp_kses_post(wpautop(do_shortcode($content))); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php if (!empty($title)) { ?>
                                    <a class="tg-btn" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($target); ?>">
                                        <?php echo esc_attr($title); ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_Call_To_Action();
}
