<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$heading = !empty($atts['history_heading']) ? $atts['history_heading'] : '';
$description = !empty($atts['history_desc']) ? $atts['history_desc'] : '';
$timeline_tabs = !empty($atts['timeline_tabs']) ? $atts['timeline_tabs'] : array();
$flag = sp_unique_increment();
?>

<div class="sp-sc-timeline">
    <?php if (!empty($heading) || !empty($description)) { ?>
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
            <?php if (!empty($heading)) { ?>
                <div class="tg-sectiontitle">
                    <h2><?php echo esc_attr($heading); ?></h2>
                </div>
            <?php } ?>
            <?php if (!empty($description)) { ?>
                <div class="tg-description">
                    <?php echo wp_kses_post(wpautop(do_shortcode($description))); ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <?php if (!empty($timeline_tabs)) { ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-push-1">
            <div class="tg-timeline">
                <ul class="tg-timelinenav" role="tablist">
                    <?php
                    $tab_nav_count = 1;
                    foreach ($timeline_tabs as $key => $tab) {
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
                    foreach ($timeline_tabs as $key => $inner_tab) {
                        extract($inner_tab);
                        $content_active = $tab_content_count === 1 ? 'active' : '';
                        $timeline_link = !empty($timeline_btn_link) ? $timeline_btn_link : '#';
                        $timeline_target = !empty($timeline_btn_target) ? $timeline_btn_target : '_self';

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
                                            <?php if (!empty($timeline_btn_text)) { ?>
                                                <a class="tg-btn" target="<?php echo esc_attr($timeline_target); ?>" href="<?php echo esc_url($timeline_link); ?>"><?php echo esc_attr($timeline_btn_text); ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($timeline_gallery)) { ?>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 tg-verticalmiddle">

                                        <div class="tg-oneslideslidershortcode tg-timeline-<?php echo esc_attr($flag); ?> owl-carousel">
                                            <?php
                                            foreach ($timeline_gallery as $key => $gallery) {

                                                $thumb_meta = array();
                                                if (!empty($gallery['attachment_id'])) {
                                                    $thumb_meta = listingo_get_image_metadata($gallery['attachment_id']);
                                                }
                                                $image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : '';
                                                $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;
                                                if (!empty($gallery['url'])) {
                                                    ?>
                                                    <figure class="item">
                                                        <img src="<?php echo esc_url($gallery['url']); ?>" alt="<?php echo esc_attr($image_alt); ?>">
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
    <?php } ?>
</div>
<?php
$script = "jQuery(document).ready(function () {
        var _tg_oneslideslidershortcode = jQuery('.tg-timeline-" . esc_js($flag) . "');
        _tg_oneslideslidershortcode.owlCarousel({
            loop: true,
            margin: 0,
            nav: true,
			rtl: ".listingo_owl_rtl_check().",
            items: 1,
            navText: [
                '<span class=\"tg-btnroundsmallprev\"><i class=\"fa fa-angle-left\"></i></span>',
                '<span class=\"tg-btnroundsmallnext\"><i class=\"fa fa-angle-right\"></i></span>',
            ],
        });
    });";
wp_add_inline_script('listingo_callbacks', $script, 'after')
?>