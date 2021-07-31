<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$heading = !empty($atts['service_heading']) ? $atts['service_heading'] : '';
$description = !empty($atts['service_description']) ? $atts['service_description'] : '';
$services_list = !empty($atts['service_list']) ? $atts['service_list'] : array();
?>

<div class="sp-sc-services-v2">
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
    <?php if (!empty($services_list)) { ?>
        <div class="tg-servicesfacilities">
            <?php
            foreach ($services_list as $key => $service) {
                $service_icon = $service['service_icon'];
                $service_color = $service['service_color'];
                $service_title = !empty($service['service_title']) ? $service['service_title'] : '';
                $service_desc = !empty($service['service_desc']) ? $service['service_desc'] : '';
                $service_link = !empty($service['service_link']) ? $service['service_link'] : '';
                $target = !empty($service['link_target']) ? $service['link_target'] : '_self';

                $thumb_meta = array();
                if (!empty($service_icon) && $service_icon['type'] === 'custom-upload') {
                    $thumb_meta = listingo_get_image_metadata($service_icon['attachment-id']);
                }
                $image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : '';
                $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;
                ?>
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 pull-left">
                    <div class="tg-servicefacility">
                        <span class="tg-servicefacilityicon" style="background: <?php echo!empty($service_color) ? esc_attr($service_color) : '#ccc'; ?>;">
                            <?php
                            if (isset($service_icon['type']) && $service_icon['type'] === 'icon-font') {
                                do_action('enqueue_unyson_icon_css');
                                if (!empty($service_icon['icon-class'])) {
                                    ?>
                                    <i class="<?php echo esc_attr($service_icon['icon-class']); ?>"></i>
                                    <?php
                                }
                            } else if (isset($service_icon['type']) && $service_icon['type'] === 'custom-upload') {
                                if (!empty($service_icon['url'])) {
                                    ?>
                                    <em><img src="<?php echo esc_url($service_icon['url']); ?>" alt="<?php echo esc_attr($image_alt); ?>"></em>
                                    <?php
                                }
                            }
                            ?>
                        </span>
                        <?php if (!empty($service_title)) { ?>
                            <div class="tg-title">
                                <h3>
                                    <?php if (empty($service_link)) { ?>
                                        <?php echo esc_attr($service_title); ?>
                                    <?php } else { ?>
                                        <a href="<?php echo esc_url($service_link); ?>" target="<?php echo esc_attr($target); ?>">
                                            <?php echo esc_attr($service_title); ?>
                                        </a>
                                    <?php } ?>
                                </h3>
                            </div>
                        <?php } ?>
                        <?php if (!empty($service_desc)) { ?>
                            <div class="tg-description">
                                <?php echo wp_kses_post(wpautop(do_shortcode($service_desc))); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    <?php } ?>
</div>
