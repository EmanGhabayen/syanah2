<?php
if (!defined('FW'))
    die('Forbidden');
$section_heading = !empty($atts['section_heading']) ? $atts['section_heading'] : '';
$section_sub_heading = !empty($atts['section_subheading']) ? $atts['section_subheading'] : '';
?>
<div class="sp-sc-section-heading-v2">
    <?php if (!empty($section_heading) || !empty($section_sub_heading)) { ?>
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
            <div class="tg-sectionheadvtwo">
                <div class="tg-sectiontitle">
                    <?php if (!empty($section_sub_heading)) { ?>
                        <span><?php echo esc_attr($section_sub_heading); ?></span>
                    <?php } ?>
                    <?php if (!empty($section_heading)) { ?>
                        <h2><?php echo esc_attr($section_heading); ?></h2>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>