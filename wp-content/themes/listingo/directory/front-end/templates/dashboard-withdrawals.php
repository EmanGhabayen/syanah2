<?php
/**
 *
 * The template part for displaying the dashboard withdrawals
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();
global $current_user,
 $wp_roles,
 $userdata,
 $paged;

$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (!empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$dir_profile_page = '';
if (function_exists('fw_get_db_settings_option')) {
    $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
}
$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
$db_withdrawal = listingo_get_withdrawal_settings($url_identity);

$price_symbol = '$';
if (class_exists('WooCommerce')) {
	$price_symbol	 = get_woocommerce_currency_symbol();
}

$bk_settings	 = listingo_get_booking_settings();
?>
<div id="tg-content" class="tg-content">
    <div class="tg-joblisting tg-dashboardmanagejobs">
        <div class="tg-dashboardhead">
            <div class="tg-dashboardtitle">
                <h2><?php esc_html_e('Withdrawal Settings', 'listingo'); ?></h2>
            </div>
            <div class="tg-btnaddservices">
                <a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'statement', $url_identity, '', 'history'); ?>"><?php esc_html_e('View withdrawal history', 'listingo'); ?></a>
            </div>
        </div>
        <div class="withdraw-settings">
        	<form class="payment_mods">
        		<ul class="payment-withdrawal-options">
				  <li class="payment-withdrawal">
					<div class="withdrawal-wrap">
					  <input class="service-paypal" <?php checked( $db_withdrawal['type'], 'paypal', true ); ?>  id="withdrawal_paypal" data-service="<?php esc_html_e('PayPal', 'listingo'); ?>" data-minimum="50.0" type="radio" value="paypal" name="withdrawal_account[type]">
					  <label for="withdrawal_paypal" data-key="withdrawal_paypal">
						<div class="withdrawal_title"><img src="<?php echo get_template_directory_uri();?>/images/withdrawal/paypal.png" /></div>
						<?php if( !empty( $bk_settings['minamount'] ) ){?>
							<div class="withdrawal_body">
							  <small class="withdrawal_min"><?php esc_html_e('Minimum', 'listingo'); ?>&nbsp;<?php echo esc_attr($price_symbol.$bk_settings['minamount']);?></small>
							</div>
						<?php }?>
					  </label>
					</div>
				  </li>
				 </ul>
				<div class="payment-withdrawal-data">
					<div class="tg-basicinformationbox withdrawal_paypal">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
								<div class="form-group">
									<h4><?php esc_html_e('PayPal Account', 'listingo'); ?></h4>
									<p><?php esc_html_e('Please add your PayPal Account email address to withdrawal your all earnings.', 'listingo'); ?>&nbsp;<a  target="_blank" href="https://www.paypal.com/signup"><?php esc_html_e('Create PayPal Account', 'listingo'); ?></a></p>
									
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
								<div class="form-group">
									<input type="text" class="form-control" name="withdrawal_account[paypal]" value="<?php echo esc_attr( $db_withdrawal['paypal'] );?>" placeholder="<?php esc_html_e('PayPal Account Email', 'listingo'); ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
       			<div id="tg-updateall" class="tg-updateall">
                    <div class="tg-holder">
                        <?php wp_nonce_field('sp_withdrawal_nonce', 'withdrawal-update'); ?>
                        <span class="tg-note"><?php esc_html_e('Click update now to update the latest added details.', 'listingo'); ?></span>
                        <a class="tg-btn update-withdrawal" href="javascript:;"><?php esc_html_e('Update Now', 'listingo'); ?></a>
                    </div>
                </div>
        	</form>
        </div>
    </div>
</div>