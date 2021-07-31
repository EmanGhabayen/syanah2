<?php
/**
 * @ Visual Composer Shortcode
 * @ Class SP Timeline
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_SP_Timeline')) {

    class SC_VC_Skin_SP_Timeline extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_sp_timeline", array(
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
                "timeline_tabs" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_sp_timeline', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            $timeline = array();
            if (isset($timeline_tabs)) {
                $timeline = vc_param_group_parse_atts($timeline_tabs);
            }

            ob_start();
            ?>
            <div class="sp-sc-timeline <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
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

                <?php
                $this->listingo_vc_prepare_timeline_view($timeline, $flag);
                ?>
            </div>
            <?php
            return ob_get_clean();
        }

        public function listingo_vc_prepare_timeline_view($timeline = array(), $flag = '') {
            ob_start();
            if (!empty($timeline)) {
                ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-push-1">
                    <div class="tg-timeline">
                        <ul class="tg-timelinenav" role="tablist">
                            <?php
                            $tab_nav_count = 1;
                            foreach ($timeline as $key => $tab) {
                                extract($tab);
                                $active = $tab_nav_count === 1 ? 'active' : '';

                                if (!empty($timeline_year)) {
                                    ?>
                                    <li role="presentation" class="<?php echo sanitize_html_class($active); ?>">
                                        <a href="#timeline-tab-<?php echo esc_attr($tab_nav_count); ?>" aria-controls="timeline-tab-<?php echo esc_attr($tab_nav_count); ?>" role="tab" data-toggle="tab" data-date="<?php echo intval($timeline_year); ?>"></a>
                                    </li>
                                    <?php
                                }
                                $tab_nav_count++;
                            }
                            ?>
                        </ul>
                        <div class="tab-content tg-timelinetabcontent">
                            <?php
                            $tab_content_count = 1;
                            foreach ($timeline as $key => $inner_tab) {
                                extract($inner_tab);
                                $content_active = $tab_content_count === 1 ? 'active' : '';

                                $link = '';
                                if (!empty($inner_tab['timeline_link'])) {
                                    $link = vc_build_link($inner_tab['timeline_link']);
                                }
                                $title = !empty($link['title']) ? $link['title'] : '';
                                $target = !empty($link['target']) ? $link['target'] : '_self';
                                $link_url = !empty($link['url']) ? $link['url'] : '#';

                                $timeline_gallery = explode(',', $inner_tab['timeline_gallery']);

                                $content_class = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
                                if (!empty($timeline_gallery)) {
                                    $content_class = 'col-xs-12 col-sm-12 col-md-6 col-lg-6';
                                }
                                ?>
                                <div role="tabpanel" class="tab-pane fade in <?php echo esc_attr($content_active); ?>" id="timeline-tab-<?php echo esc_attr($tab_content_count); ?>">
                                    <div class="row">
                                        <?php if (!empty($timeline_title) || !empty($timeline_desc) || !empty($timeline_btn_text)) { ?>
                                            <div class="<?php echo esc_attr($content_class); ?> tg-verticalmiddle">
                                                <div class="tg-textshortcode">
                                                    <?php if (!empty($timeline_title)) { ?>
                                                        <div class="tg-bordertitle">
                                                            <h2><?php echo esc_attr($timeline_title); ?></h2>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if (!empty($timeline_desc)) { ?>
                                                        <div class="tg-description">
                                                            <?php echo wp_kses_post(wpautop(do_shortcode($timeline_desc))); ?>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if (!empty($title)) { ?>
                                                        <a class="tg-btn" target="<?php echo esc_attr($target); ?>" href="<?php echo esc_url($link_url); ?>"><?php echo esc_attr($title); ?></a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if (!empty($timeline_gallery)) { ?>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 tg-verticalmiddle">
                                                <div class="tg-oneslideslidershortcode tg-timeline-<?php echo esc_attr($flag); ?> owl-carousel">
                                                    <?php
                                                    foreach ($timeline_gallery as $gallery) {
                                                        $thumb_meta = array();
                                                        $thumbnail = '';
                                                        if (!empty($gallery)) {
                                                            $thumb_meta = $this->listingo_vc_shortcodes_get_image_metadata($gallery);
                                                            $thumbnail = $this->listingo_vc_shortcodes_get_image_source($gallery, intval(0), intval(0));
                                                        }
                                                        $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $thumb_meta['title'];
                                                        if (!empty($thumbnail)) {
                                                            ?>
                                                            <figure class="item">
                                                                <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                                            </figure>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                                $tab_content_count++;
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                $script = "jQuery(document).ready(function () {
                        var _tg_oneslideslidershortcode = jQuery('.tg-timeline-" . esc_js($flag) . "');
                        _tg_oneslideslidershortcode.owlCarousel({
                            loop: true,
                            margin: 0,
                            nav: true,
                            rtl: " . listingo_owl_rtl_check() . ",
                            items: 1,
                            navText: [
                                '<span class=\"tg-btnroundsmallprev\"><i class=\"fa fa-angle-left\"></i></span>',
                                '<span class=\"tg-btnroundsmallnext\"><i class=\"fa fa-angle-right\"></i></span>',
                            ],
                        });
                    });";
                wp_add_inline_script('listingo_callbacks', $script, 'after');
            }
            echo ob_get_clean();
        }

    }

    new SC_VC_Skin_SP_Timeline();
}
