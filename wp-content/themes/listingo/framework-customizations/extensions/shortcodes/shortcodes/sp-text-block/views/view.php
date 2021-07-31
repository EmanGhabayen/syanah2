<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$link = !empty($atts['button_link']) ? $atts['button_link'] : '#';
$target = !empty($atts['link_target']) ? $atts['link_target'] : '_self';
?>
<div class="sp-sc-text-block">
    <?php if (!empty($atts['heading']) || !empty($atts['description']) || !empty($atts['button_title'])) { ?>
        <div class="tg-textshortcode">
            <?php if (!empty($atts['heading'])) { ?>
                <div class="tg-bordertitle">
                    <h2><?php echo esc_attr($atts['heading']); ?></h2>
                </div>
            <?php } ?>
            <?php if (!empty($atts['description'])) { ?>
                <div class="tg-description">
                    <?php echo wp_kses_post(wpautop(do_shortcode($atts['description']))); ?>
                </div>
            <?php } ?>
            <?php if (!empty($atts['button_title'])) { ?>
                <a class="tg-btn" target="<?php echo esc_attr($target); ?>" href="<?php echo esc_url($link); ?>"><?php echo esc_attr($atts['button_title']); ?></a>
            <?php } ?>
        </div>
    <?php } ?>
</div>