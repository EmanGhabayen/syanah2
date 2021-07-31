<?php
/**
 *
 * The template part for displaying the dashboard services.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();
global $current_user, $wp_roles, $userdata, $post;
$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (isset($_GET['identity']) && !empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$profile_services 	= get_user_meta($user_identity, 'profile_services', true);
$provider_category	= listingo_get_provider_category($current_user->ID);
$currencies 		  = listingo_get_current_currency();
$currency_symbol 	  = !empty( $currencies['symbol'] ) ? $currencies['symbol'] : '$';

?>
<div class="tg-dashboard tg-dashboardmanageservices">
    <div class="tg-dashboardhead">
        <div class="tg-dashboardtitle">
            <h2><?php esc_html_e('Manage Services', 'listingo'); ?><?php do_action('listingo_get_tooltip','section','services');?></h2>
        </div>
        <button class="tg-btnaddservices add-services">+&nbsp;<?php esc_html_e('Add New Service', 'listingo'); ?></button>
    </div>
    <form class="tg-themeform tg-formaddservices">
        <div class="tg-dashboardservices sp-services-wrap">
            <?php if (!empty($profile_services)) { ?>
                <?php
                $count = 0;
                foreach ($profile_services as $key => $service) {
                    $service_title = !empty($service['title']) ? $service['title'] : '';
                    $appointment = !empty($service['appointment']) ? $service['appointment'] : '';
                    $price = !empty($service['price']) ? $service['price'] : '';
                    $description = !empty($service['description']) ? $service['description'] : '';
                    $freeservice = !empty($service['freeservice']) ? $service['freeservice'] : '';

                    if (isset($service['type']) && $service['type'] === 'hour') {
                        $type = esc_html__('Hour', 'listingo');
                    } else if (isset($service['type']) && $service['type'] === 'visit') {
                        $type = esc_html__('Visit', 'listingo');
                    } else {
                        $type = esc_html__('Visit', 'listingo');
                    }

                    $free_checked = '';
                    if (!empty($freeservice) && $freeservice === 'on') {
                        $free_checked = 'checked';
                    }

                    $app_checked = '';
                    if (!empty($appointment) && $appointment === 'on') {
                        $app_checked = 'checked';
                    }
                    ?>
                    <div class="tg-dashboardservice service-item-<?php echo intval($count); ?>">
                        <?php if (!empty($service_title) || !empty($appointment)) { ?>
                            <div class="tg-servicetitle">
                                <h2>
                                    <a class="sp-service-title" href="javascript:;">
                                        <?php echo esc_attr($service_title); ?>
                                    </a>
                                    <?php if (!empty($appointment) && $appointment === 'on') { ?>
                                        <span class="service_appoint"><?php esc_html_e('(In Appointment)', 'listingo'); ?></span>
                                    <?php } ?>
                                </h2>
                            </div>
                        <?php } ?>

                        <div class="tg-btntimeedit">
                            <?php if (!empty($price) || !empty($type) || !empty($freeservice)) { ?>
                                <span class="sp-price-wrapper">
                                    <?php
                                    if (!empty($freeservice) && $freeservice === 'on') {
                                        esc_html_e('Free', 'listingo');
                                    } else {
                                        ?>
                                        <span class="sp-price-val"><?php echo listingo_format_price($price);?></span>
                                        <span class="sp-price-type"><?php echo esc_attr($type); ?></span>
                                    <?php } ?>
                                </span>
                            <?php } ?>
                            <button type="button" class="tg-btnedite edit_service"><i class="lnr lnr-pencil"></i></button>
                            <button type="button" class="tg-btndel delete-service"><i class="lnr lnr-trash"></i></button>
                        </div>
                        <div class="sp-services-edit-collapse tg-haslayout elm-display-none">
                            <fieldset>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                                    <div class="form-group">
                                        <input type="text" value="<?php echo esc_attr($service_title); ?>" name="services[<?php echo esc_attr($key); ?>][title]" class="form-control sp-service-title-input" placeholder="<?php esc_html_e('Service Title', 'listingo'); ?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                                    <div class="form-group">
                                        <input type="text" value="<?php echo esc_attr($price); ?>" name="services[<?php echo esc_attr($key); ?>][price]" class="form-control sp-service-price-input" placeholder="<?php esc_html_e('Service Price (Add price without currency symbol.)', 'listingo'); ?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                                    <div class="form-group">
                                        <span class="tg-select">
                                            <select class="sp-service-price-type" name="services[<?php echo esc_attr($key); ?>][type]">
                                                <option value=""><?php esc_html_e('Choose Price Type', 'listingo'); ?></option>
                                                <option data-key="<?php esc_html_e('Hour', 'listingo'); ?>" <?php echo!empty($service['type']) && $service['type'] === 'hour' ? 'selected' : ''; ?> value="hour"><?php esc_html_e('Hour', 'listingo'); ?></option>
                                                <option data-key="<?php esc_html_e('Visit', 'listingo'); ?>" <?php echo!empty($service['type']) && $service['type'] === 'visit' ? 'selected' : ''; ?> value="visit"><?php esc_html_e('Visit', 'listingo'); ?></option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                                    <div class="form-group">
                                        <textarea name="services[<?php echo esc_attr($key); ?>][description]" placeholder="<?php esc_html_e('Description', 'listingo'); ?>"><?php echo esc_attr($description); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12 pull-left">
                                    <?php
										if (apply_filters('listingo_is_setting_enabled', $current_user->ID, 'subscription_appointments') === true 
											&& 	apply_filters('listingo_do_check_user_type', $current_user->ID) === true
											&& apply_filters('listingo_is_feature_allowed', $provider_category, 'appointments') === true
										) {
									?>
                                    <div class="tg-checkbox">
                                        <input <?php echo esc_attr($app_checked); ?> type="checkbox" name="services[<?php echo esc_attr($key); ?>][appointment]" id="appointment-<?php echo esc_attr($key); ?>" class="appointment">
                                        <label for="appointment-<?php echo esc_attr($key); ?>"><?php esc_html_e('Add This Service in Appointment List', 'listingo'); ?></label>
                                    </div>
                                    <?php }?>
                                    <div class="tg-checkbox">
                                        <input <?php echo esc_attr($free_checked); ?> type="checkbox" name="services[<?php echo  esc_attr($key); ?>][freeservice]" id="freeservice-<?php echo esc_attr($key); ?>" class="freeservice">
                                        <label for="freeservice-<?php echo esc_attr($key); ?>"><?php esc_html_e('This is a Free Service', 'listingo'); ?></label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <?php
                    $count++;
                }
                ?>
            <?php } ?>
        </div>
        <?php wp_nonce_field('sp_services_settings_nonce', 'services-settings-update'); ?>
    </form>
    <div id="tg-updateall" class="tg-updateall">
        <div class="tg-holder">
            <span class="tg-note"><?php esc_html_e('Click update now to update the latest added details.', 'listingo'); ?></span>
            <a class="tg-btn update-services-dashboard" href="javascript:;"><?php esc_html_e('Update Now', 'listingo'); ?></a>
        </div>
    </div>
</div>
<script type="text/template" id="tmpl-load-services">
    <div class="tg-dashboardservice service-item-{{data}}">
    <div class="tg-servicetitle">
    <h2><a class="sp-service-title" href="javascript:void;"><?php esc_html_e('Managing Service Title', 'listingo'); ?></a><span class="service_appoint"></span></h2>
    </div>
    <div class="tg-btntimeedit">
    <span class="sp-price-wrapper">
    <span class="sp-price-val"><?php echo listingo_format_price(0);?></span>
    <span class="sp-price-type"></span>
    </span>
    <button type="button" class="tg-btnedite edit_service"><i class="lnr lnr-pencil"></i></button>
    <button type="button" class="tg-btndel delete-service"><i class="lnr lnr-trash"></i></button>
    </div>
    <div class="sp-services-edit-collapse tg-haslayout">
    <fieldset>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
    <div class="form-group">
    <input type="text" name="services[{{data}}][title]" class="form-control sp-service-title-input" placeholder="<?php esc_html_e('Service Title', 'listingo'); ?>">
    </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
    <div class="form-group">
    <input type="text" name="services[{{data}}][price]" class="form-control sp-service-price-input" placeholder="<?php esc_html_e('Service Price (Add price without currency symbol.)', 'listingo'); ?>">
    </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
    <div class="form-group">
    <span class="tg-select">
    <select class="sp-service-price-type" name="services[{{data}}][type]">
    <option value=""><?php esc_html_e('Choose Price Type', 'listingo'); ?></option>
    <option data-key="<?php esc_html_e('Hour', 'listingo'); ?>" value="hour"><?php esc_html_e('Hour', 'listingo'); ?></option>
    <option data-key="<?php esc_html_e('Visit', 'listingo'); ?>" value="visit"><?php esc_html_e('Visit', 'listingo'); ?></option>
    </select>
    </span>
    </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
    <div class="form-group">
    <textarea name="services[{{data}}][description]" placeholder="<?php esc_html_e('Description', 'listingo'); ?>"></textarea>
    </div>
    </div>
	<?php
		if (apply_filters('listingo_is_setting_enabled', $current_user->ID, 'subscription_appointments') === true 
			&& 	apply_filters('listingo_do_check_user_type', $current_user->ID) === true
			&& apply_filters('listingo_is_feature_allowed', $provider_category, 'appointments') === true
		) {
	?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
		<div class="tg-checkbox">
		<input type="checkbox" checked name="services[{{data}}][appointment]" id="appointment-{{data}}" class="appointment">
		<label for="appointment-{{data}}"><?php esc_html_e('Add This Service in Appointment List', 'listingo'); ?></label>
		</div>
		</div>
	<?php }?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
    <div class="tg-checkbox">
    <input type="checkbox" name="services[{{data}}][freeservice]" id="freeservice-{{data}}" class="freeservice">
    <label for="freeservice-{{data}}"><?php esc_html_e('This is a Free Service', 'listingo'); ?></label>
    </div>
	</div>
    </div>
    </fieldset>
    </div>
    </div>
</script>