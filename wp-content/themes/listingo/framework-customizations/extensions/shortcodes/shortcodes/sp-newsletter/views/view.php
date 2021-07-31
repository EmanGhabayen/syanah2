<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$heading = !empty($atts['heading']) ? $atts['heading'] : '';
$form_heading = !empty($atts['form_heading']) ? $atts['form_heading'] : '';
$description = !empty($atts['description']) ? $atts['description'] : '';
$username = !empty($atts['username']) ? $atts['username'] : '';

$first_name = 'fname_disabled';
if (isset($username) && $username === 'yes') {
    $first_name = 'fname_enabled';
}
?>

<div class="sp-sc-newsletter <?php echo esc_attr($first_name); ?>">
    <div class="row">
        <?php if (!empty($heading) || !empty($description)) { ?>
            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8 pull-left">
                <?php if (!empty($heading)) { ?>
                    <div class="tg-testimonial">
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
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-left">
            <form class="tg-themeform signup-newletter">
                <?php if (!empty($form_heading)) { ?>
                    <div class="tg-testimonial">
                        <h2><?php echo esc_attr($form_heading); ?></h2>
                    </div>
                <?php } ?>
                <fieldset>
                    <?php if (isset($username) && $username === 'yes') { ?>
                        <div class="form-group">
                            <input type="text" name="fname" class="form-control" placeholder="<?php esc_attr_e('Your name', 'listingo'); ?>">
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="<?php esc_attr_e('Your email address', 'listingo'); ?>">
                    </div>
                    <button type="submit" class="tg-btn subscribe_me"><?php esc_html_e('Subscribe', 'listingo'); ?></button>
                </fieldset>
            </form>
        </div>	
    </div>
</div>