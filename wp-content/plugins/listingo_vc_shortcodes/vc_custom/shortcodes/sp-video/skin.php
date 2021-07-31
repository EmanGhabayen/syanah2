<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Ad Box
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Video')) {

    class SC_VC_Skin_Video extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_video", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {
            extract(shortcode_atts(array(               
                "video_link" => '',
                "video_height" => '',
                "video_width" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));


            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_video', $args);
            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            ob_start();
            ?>

            <div class="sp-sc-video <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>                 
                <div class="tg-videoshortcode">
                    <?php
                    $url = parse_url($video_link);
                    $height = $video_height;
                    $width = $video_width;
                    if ($url['host'] == $_SERVER["SERVER_NAME"]) {
                        echo do_shortcode('[video width="' . $width . '" height="' . $height . '" src="' . $video_link . '"][/video]');
                    } else {
                        if ($url['host'] == 'vimeo.com' || $url['host'] == 'player.vimeo.com') {

                            $content_exp = explode("/", $video_link);
                            $content_vimo = array_pop($content_exp);
                            echo '<iframe width="' . $width . '" height="' . $height . '" src="https://player.vimeo.com/video/' . $content_vimo . '" 
></iframe>';
                        } elseif ($url['host'] == 'soundcloud.com') {
                            $height = $video_height;
                            $width = $video_width;
                            $video = wp_oembed_get($video_link, array(
                                'height' => $height));
                            $search = array(
                                'webkitallowfullscreen',
                                'mozallowfullscreen',
                                'frameborder="0"');
                            echo str_replace($search, '', $video);
                        } else {

                            $content = str_replace(array(
                                'watch?v=',
                                'http://www.dailymotion.com/'), array(
                                'embed/',
                                '//www.dailymotion.com/embed/'), $video_link);
                            echo '<iframe width="' . $width . '" height="' . $height . '" src="' . $content . '"></iframe>';
                        }
                    }
                    ?>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_Video();
}
