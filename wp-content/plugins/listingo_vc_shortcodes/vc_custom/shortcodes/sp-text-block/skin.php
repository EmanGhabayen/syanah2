<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Text_Block')) {

    class SC_VC_Skin_Listingo_Text_Block extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_text_block", array(
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
                "block_link" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args)); 

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_text_block', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            $link = '';
            if (!empty($block_link)) {
                $link = vc_build_link($block_link);
            }
            $title = !empty($link['title']) ? $link['title'] : '';
            $target = !empty($link['target']) ? $link['target'] : '_self';
            $link_url = !empty($link['url']) ? $link['url'] : '#';

            ob_start();
            ?>      
            <div class="sp-sc-text-block">
                <?php if (!empty($sec_title) || !empty($content) || !empty( $title )) { ?>
                    <div class="tg-textshortcode">
                        <?php if (!empty($sec_title)) { ?>
                            <div class="tg-bordertitle">
                                <h2><?php echo esc_attr($sec_title); ?></h2>
                            </div>
                        <?php } ?>
                        <?php if (!empty($content)) { ?>
                            <div class="tg-description">
                                <?php echo wp_kses_post(wpautop(do_shortcode($content))); ?>
                            </div>
                        <?php } ?>
                        <?php if (!empty($title)) { ?>
                            <a class="tg-btn" target="<?php echo esc_attr($target); ?>" href="<?php echo esc_url($link_url); ?>"><?php echo esc_attr($title); ?></a>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>       
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_Listingo_Text_Block();
}
