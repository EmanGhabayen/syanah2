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

//Filters
$earning_year = '';
if (!empty($_GET['earning_year'])) {
    $earning_year = esc_attr( $_GET['earning_year']);
}

$earning_month = '';
if (!empty($_GET['earning_month'])) {
    $earning_month =  esc_attr( $_GET['earning_month']);
}

$dir_profile_page = '';
if (function_exists('fw_get_db_settings_option')) {
    $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
}

$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';


$table = $wpdb->prefix . 'sp_earnings';
if( !empty( $earning_year ) && !empty( $earning_month ) ){
	$earnings_query = $wpdb->get_results(
					$wpdb->prepare(
							"SELECT * FROM $table WHERE $table.user_id = %d AND $table.year = %s AND $table.month = %s ORDER BY $table.id DESC", $url_identity,$earning_year,$earning_month
					), ARRAY_A);
} else if( !empty( $earning_year ) && empty( $earning_month ) ){
	$earnings_query = $wpdb->get_results(
					$wpdb->prepare(
							"SELECT * FROM $table WHERE $table.user_id = %d AND $table.year = %s ORDER BY $table.id DESC", $url_identity,$earning_year
					), ARRAY_A);
} else if( empty( $earning_year ) && !empty( $earning_month ) ){
	$earnings_query = $wpdb->get_results(
					$wpdb->prepare(
							"SELECT * FROM $table WHERE $table.user_id = %d AND $table.month = %s ORDER BY $table.id DESC", $url_identity,$earning_month
					), ARRAY_A);
} else{
	$earnings_query = $wpdb->get_results(
					$wpdb->prepare(
							"SELECT * FROM $table WHERE $table.user_id = %d ORDER BY $table.id DESC", $url_identity
					), ARRAY_A);
}
?>
<div id="tg-content" class="tg-content">
    <div class="tg-joblisting tg-dashboardmanagejobs">
        <div class="tg-dashboardhead">
            <div class="tg-dashboardtitle">
                <h2><?php esc_html_e('Earnings', 'listingo'); ?></h2>
            </div>
        </div>
        <div class="sp-filters tg-haslayout">
        	<div class="tg-sortfilters">
				<form method="get" class="tg-themeform sp-appointment-form-search">
					<input type="hidden" name="ref" value="<?php echo isset($_GET['ref']) ? $_GET['ref'] : ''; ?>">
					<input type="hidden" name="mode" value="<?php echo isset($_GET['mode']) ? $_GET['mode'] : ''; ?>">
					<input type="hidden" name="identity" value="<?php echo isset($_GET['identity']) ? $_GET['identity'] : ''; ?>">
					<div class="tg-sortfilter tg-sortby">
						<?php do_action('listingo_get_sortby_year','yes');?>
					</div>
					<div class="tg-sortfilter tg-sortby">
						<?php do_action('listingo_get_sortby_month');?>
					</div>
				</form>
			</div>
		</div>
        <div class="tg-dashboardservices sp-earning-wrap">
			<div class="tg-dashboardservice sp-earning-head">
				<div class="tg-servicetitle">
					<span class="service_appoint"><?php esc_html_e('Appointment Date','listingo'); ?></span>
				</div>
				<div class="tg-btntimeedit">
					<span class="sp-price-wrapper"><?php esc_html_e('Amount/Action','listingo'); ?></span>
				</div>
			</div>
        	<?php 
			if( !empty( $earnings_query ) ){
				$counter = 1;
				foreach( $earnings_query as $key => $value ){
					$counter++;
					$order_id			= intval( $value['order_id']);
					$appointment_id		= intval( $value['appointment_id']);
					$order 				= wc_get_order( $order_id );
					if( !empty( $order ) ){
						$currency_code 		= $order->get_currency();
						$currency_symbol 	= get_woocommerce_currency_symbol( $currency_code );
					
						$apt_data			= get_post_meta($appointment_id,'cus_appointment_data',true);
						$order_detail		= apply_filters('listingo_get_booking_meta', $apt_data);		

					?>
					<div class="tg-dashboardservice">
						<div class="tg-servicetitle">
							<span class="service_appoint"><?php echo date(get_option('date_format'), strtotime($value['appointment_date'])); ?></span>
						</div>

						<div class="tg-btntimeedit">
							<span class="sp-price-wrapper">
								<?php echo esc_attr( $currency_symbol.$value['amount'] ); ?>
							</span>
							<a class="tg-btnedite" data-toggle="modal" data-target=".tg-approvemodal-<?php echo esc_attr($counter); ?>"><i class="lnr lnr-eye"></i></a>
						</div>
						<?php if( !empty( $order_detail ) ){?>
						<div class="modal fade tg-appointmentapprovemodal tg-approvemodal-<?php echo esc_attr($counter); ?>" tabindex="-1">
							<div class="modal-dialog tg-modaldialog" role="document">
								<div class="modal-content tg-modalcontent">
									<div class="tg-modalhead">
										<h2><?php esc_html_e('Appointment detail', 'listingo'); ?></h2>
									</div>
									<div class="tg-modalbody">

										<ul class="tg-invoicedetail">
											<?php foreach( $order_detail as $d_key => $item ){?>
												<li>
													<span class="style-lable"><?php echo listingo_get_package_features($d_key);?></span> 
													<span class="style-name"><?php echo esc_attr( $item );?></span> 
												</li>
											<?php } ?>

										</ul>
									</div>
								</div>
							</div>
						</div>
						<!--Appointment Approve Model End-->
						<?php }?>
					</div>
				<?php }}}else{?>
				<?php Listingo_Prepare_Notification::listingo_warning(esc_html__('Oops!', 'listingo'), esc_html__('You didn\'t earn anything yet.', 'listingo')); ?>
			<?php }?>
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