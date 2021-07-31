<?php
/**
 *
 * The template part for displaying the dashboard earnings
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();
global $current_user,
 $wp_roles,
 $wpdb,
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

//Filters
$earning_year = '';
if (!empty($_GET['earning_year'])) {
    $earning_year = esc_attr( $_GET['earning_year']);
}

$earning_month = '';
if (!empty($_GET['earning_month'])) {
    $earning_month =  esc_attr( $_GET['earning_month']);
}

$table = $wpdb->prefix . 'sp_withdrawal_history';

if( !empty( $earning_year ) && !empty( $earning_month ) ){
	$db_query = $wpdb->get_results(
					$wpdb->prepare(
							"SELECT * FROM $table WHERE $table.user_id = %d AND $table.year = %s AND $table.month = %s ORDER BY $table.id DESC", $url_identity,$earning_year,$earning_month
					), ARRAY_A);
} else if( !empty( $earning_year ) && empty( $earning_month ) ){
	$db_query = $wpdb->get_results(
					$wpdb->prepare(
							"SELECT * FROM $table WHERE $table.user_id = %d AND $table.year = %s ORDER BY $table.id DESC", $url_identity,$earning_year
					), ARRAY_A);
} else if( empty( $earning_year ) && !empty( $earning_month ) ){
	$db_query = $wpdb->get_results(
					$wpdb->prepare(
							"SELECT * FROM $table WHERE $table.user_id = %d AND $table.month = %s ORDER BY $table.id DESC", $url_identity,$earning_month
					), ARRAY_A);
} else{
	$db_query = $wpdb->get_results(
					$wpdb->prepare(
							"SELECT * FROM $table WHERE $table.user_id = %d ORDER BY $table.id DESC", $url_identity
					), ARRAY_A);
}

?>
<div id="tg-content" class="tg-content">
    <div class="tg-joblisting tg-dashboardmanagejobs">
        <div class="tg-dashboardhead">
            <div class="tg-dashboardtitle">
                <h2><?php esc_html_e('Withdrawal History', 'listingo'); ?></h2>
            </div>
            <div class="tg-btnaddservices">
                <a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'statement', $url_identity, '', 'withdrawals'); ?>"><?php esc_html_e('Withdrawal settings', 'listingo'); ?></a>
            </div>
        </div>
        <div class="sp-filters tg-haslayout">
        	<div class="tg-sortfilters">
				<form method="get" class="tg-themeform sp-appointment-form-search">
					<input type="hidden" name="ref" value="<?php echo isset($_GET['ref']) ? $_GET['ref'] : ''; ?>">
					<input type="hidden" name="mode" value="<?php echo isset($_GET['mode']) ? $_GET['mode'] : ''; ?>">
					<input type="hidden" name="identity" value="<?php echo isset($_GET['identity']) ? $_GET['identity'] : ''; ?>">
					<div class="tg-sortfilter tg-sortby">
						<?php do_action('listingo_get_sortby_year');?>
					</div>
					<div class="tg-sortfilter tg-sortby">
						<?php do_action('listingo_get_sortby_month');?>
					</div>
				</form>
			</div>
		</div>
        <div class="tg-dashboardservices sp-withdrawal-wrap">
        	<table class="tg-tablejoblidting job-listing-wrap fw-ext-article-listing">
                <tbody>
					<?php 
					if( !empty( $db_query ) ){
						$counter = 1;
						foreach( $db_query as $key => $value ){
							$counter++;
							$amount				= esc_attr( $value['amount']);
							$currency_symbol	= esc_attr( $value['currency_symbol']);
							$payment_method		= esc_attr( $value['payment_method']);
							$date_processed		= esc_attr( $value['processed_date']);
							$user_id			= esc_attr( $value['user_id']);
						?>
						<tr>
							<td>
								<figure class="tg-companylogo"><span><?php echo esc_attr( $currency_symbol.$amount ); ?></span></figure>
								<div class="tg-contentbox"> 
									<div class="tg-title"><h3><?php echo esc_attr( $payment_method ); ?></h3></div>
									<span><?php esc_html_e('Date Processed', 'listingo'); ?>:&nbsp;<?php echo date(get_option('date_format'), strtotime($date_processed)); ?></span> 
								</div>
							</td>
						</tr>
					<?php }}else{?>
						<?php Listingo_Prepare_Notification::listingo_warning(esc_html__('Oops!', 'listingo'), esc_html__('You didn\'t have transaction history.', 'listingo')); ?>
					<?php }?>
				</tbody>
            </table>
		</div>
    </div>
</div>
<?php
$script = "jQuery(document).ready(function () {
        jQuery(document).on('change', '.sp-sortby', function (event) {
            jQuery('.sp-appointment-form-search').submit();
        });
    });";
wp_add_inline_script('listingo_callbacks', $script, 'after')
?>