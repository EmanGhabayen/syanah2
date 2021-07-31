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

$db_withdrawal = listingo_get_withdrawal_settings($url_identity);
?>
<div id="tg-content" class="tg-content">
    <div class="tg-joblisting tg-dashboardmanagejobs">
        <div class="tg-dashboardhead">
            <div class="tg-dashboardtitle">
                <h2><?php esc_html_e('Earning Settings', 'listingo'); ?></h2>
            </div>
        </div>
        <div class="withdraw-settings">
        	<form class="payment_mods">
				<div class="payment-withdrawal-data">
					<div class="tg-basicinformationbox withdrawal_paypal">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
								<div class="form-group">
									<h4><?php esc_html_e('PayPal Account', 'listingo'); ?></h4>
									<p><?php esc_html_e('Please add your PayPal Account email address to get payments from appointments.', 'listingo'); ?>&nbsp;<a  target="_blank" href="https://www.paypal.com/signup"><?php esc_html_e('Create PayPal Account', 'listingo'); ?></a></p>
									
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