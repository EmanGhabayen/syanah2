<?php
/**
 *
 * Author Services Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * Get User Queried Object Data
 */
$author_profile = $wp_query->get_queried_object();

/**
 * Get The Dashboard Services
 */
$list_services = array();
if (!empty($author_profile->profile_services)) {
    $list_services = $author_profile->profile_services;
}

$appointment_currency = get_user_meta($author_profile->ID, 'appointment_currency', true);
$currencies 		  = listingo_get_current_currency();
$currency_symbol 	  = !empty( $currencies['symbol'] ) ? $currencies['symbol'] : '$';

$flag = sp_unique_increment();

if (!empty($list_services)) { ?>
    <div class="tg-companyfeaturebox tg-services" id="section-services">
        <div class="tg-companyfeaturetitle">
            <h3><?php esc_html_e('Services', 'listingo'); ?></h3>
        </div>

        <div id="tg-accordion" class="tg-accordion tg-services-<?php echo esc_attr($flag); ?>">
            <?php
            foreach ($list_services as $key => $service) {
                $title = !empty($service['title']) ? $service['title'] : '';
                $price = !empty($service['price']) ? $service['price'] : '';
                $price_type = !empty($service['type']) ? $service['type'] : '';
                $description = !empty($service['description']) ? $service['description'] : '';
                $appointment = !empty($service['appointment']) ? $service['appointment'] : '';
                $freeservice = !empty($service['freeservice']) ? $service['freeservice'] : '';
                ?>
                <div class="tg-service tg-panel">
                    <div class="tg-accordionheading tg-active">
                        <?php
                        if (!empty($title) ||
                                !empty($price) ||
                                !empty($price_type) ||
                                !empty($appointment) ||
                                !empty($freeservice)) {
                            ?>
                            <h4>
                                <?php if (!empty($title) || !empty($appointment)) { ?>
                                    <span><?php echo esc_attr($title); ?></span>
                                    <?php if (!empty($appointment) && $appointment === 'on') { ?>
                                        <span class="service_appoint"><?php esc_html_e('(In Appointment)', 'listingo'); ?></span>
                                    <?php } ?>
                                <?php } ?>
                                <?php if (!empty($price) || !empty($price_type) || !empty($freeservice)) { ?>
                                    <span class="sp-price-wrapper">
                                        <?php
                                        if (!empty($freeservice) && $freeservice === 'on') {
                                            esc_html_e('Free', 'listingo');
                                        } else {
                                            if (!empty($price)) {
                                                ?>
                                                <span class="sp-price-val"><?php echo listingo_format_price($price);?></span>
                                                <?php
                                            }
                                            if (!empty($price_type)) {
												$type	= esc_html__('Visit', 'listingo');
												
												if( $price_type === 'hour' ){
													$type	= esc_html__('Hour', 'listingo');
												} else if( $price_type === 'visit' ){
													$type	= esc_html__('Visit', 'listingo');
												}
												
                                                ?>
                                                <span class="sp-price-type"><?php echo esc_attr($type); ?></span>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </span>
                                <?php } ?>
                            </h4>
                        <?php } ?>
                    </div>
                    <div class="tg-panelcontent">
                        <?php if (!empty($description)) { ?>
                            <div class="tg-description">
                                <?php echo wp_kses_post(wpautop(do_shortcode($description))); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>