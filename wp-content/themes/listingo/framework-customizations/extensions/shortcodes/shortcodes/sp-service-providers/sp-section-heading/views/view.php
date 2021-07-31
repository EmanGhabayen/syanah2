<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
?>
<div class="sp-sc-section-heading">
    <?php if (!empty($atts['section_heading']) || !empty($atts['section_description'])) { ?>
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
            <div class="tg-sectionhead">
                <?php if (!empty($atts['section_heading'])) { ?>
                    <div class="tg-sectiontitle">
                        <h2><?php echo esc_attr($atts['section_heading']); ?></h2>
                    </div>
                <?php } ?>
                <?php if (!empty($atts['section_description'])) { ?>
                    <div class="tg-description">
                        <?php echo wp_kses_post(wpautop(do_shortcode($atts['section_description']))); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>