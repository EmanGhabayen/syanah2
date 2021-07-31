<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$contact_form = !empty($atts['contact_form'][0]) ? $atts['contact_form'][0] : '';
?>
<div class="sp-sc-contact-form">
    <?php if (!empty($atts['contact_heading']) || !empty($atts['contact_description'])) { ?>
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
            <?php if (!empty($atts['contact_heading'])) { ?>
                <div class="tg-sectiontitle">
                    <h2><?php echo esc_attr($atts['contact_heading']); ?></h2>
                </div>
            <?php } ?>
            <?php if (!empty($atts['contact_description'])) { ?>
                <div class="tg-description">
                    <?php echo wp_kses_post(wpautop(do_shortcode($atts['contact_description']))); ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <?php if (!empty($contact_form)) { ?>
        <div class="tg-contactusarea contact_wrap">
            <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-10 col-lg-push-1">
                <div class="form-refinesearch tg-haslayout tg-themeform contact_form">
                    <fieldset>
                        <?php echo do_shortcode('[contact-form-7 id="' . $contact_form . '"]'); ?>
                    </fieldset>
                </div>
            </div>
        </div>
    <?php } ?>
</div>