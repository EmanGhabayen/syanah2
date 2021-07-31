<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$partners = !empty($atts['partners']) ? $atts['partners'] : array();
?>

<div class="sp-sc-partners">
    <?php if (!empty($atts['partner_heading']) || !empty($atts['partner_description'])) { ?>
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
            <?php if (!empty($atts['partner_heading'])) { ?>
                <div class="tg-sectiontitle">
                    <h2><?php echo esc_attr($atts['partner_heading']); ?></h2>
                </div>
            <?php } ?>
            <?php if (!empty($atts['partner_description'])) { ?>
                <div class="tg-description">
                    <?php echo wp_kses_post(wpautop(do_shortcode($atts['partner_description']))); ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <?php if (!empty($partners)) { ?>
        <div class="tg-brands">
            <?php
            foreach ($partners as $key => $brands) {
                extract($brands);

                $name = !empty($partner_name) ? $partner_name : esc_html__('Brand Logo', 'listingo');
                $link = !empty($partner_link) ? $partner_link : '#';
                $target = !empty($link_target) ? $link_target : '_self';
                if (!empty($partner_logo['url'])) {
                    ?>
                    <div class="tg-brand">
                        <figure>
                            <a href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>">
                                <img src="<?php echo esc_url($partner_logo['url']); ?>" alt="<?php echo esc_attr($name); ?>">
                            </a>
                        </figure>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    <?php } ?>
</div>
