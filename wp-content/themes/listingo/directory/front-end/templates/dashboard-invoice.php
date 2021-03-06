<?php
/**
 *
 * The template part for displaying the dashboard Invoices.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */

global $current_user, $wp_roles,$userdata,$post,$paged,$woocommerce;
$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);
$current_page = $paged;

if (class_exists('WooCommerce')) {
	$customer_orders = wc_get_orders( apply_filters( 'woocommerce_my_account_my_orders_query', 
										array( 'customer' => $current_user->ID, 
											  'page' => $current_page, 
											  'paginate' => true,
											  'limit' => 100,
											 ) 
									   ) 
									);
	if ( !empty(  $customer_orders->orders ) ) {?>
		<div class="tg-dashboardbox spinvoices">
			<div class="tg-dashboardtitle">
				<h2><?php _e( 'Your Orders', 'listingo' ); ?></h2>
			</div>			
			<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
				<thead>
					<tr>
						<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) {?>
							<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
						<?php }?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $customer_orders->orders as $customer_order ){
						$order      = wc_get_order( $customer_order );
						$item_count = $order->get_item_count();
						?>
						<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order">
							<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) {?>
								<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
									<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) {?>
										<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

									<?php }elseif ( 'order-number' === $column_id ) {?>
										<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
											<?php echo _x( '#', 'hash before order number', 'listingo' ) . $order->get_order_number(); ?>
										</a>

									<?php }elseif ( 'order-date' === $column_id ) {?>
										<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>

									<?php }elseif ( 'order-status' === $column_id ) {?>
										<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
									<?php }elseif ( 'order-total' === $column_id ) {?>
										<?php
											/* translators: 1: formatted order total 2: total order items */
											printf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'listingo' ), $order->get_formatted_order_total(), $item_count );
										?>

									<?php }elseif ( 'order-actions' === $column_id ) {?>
										<?php
										$actions = wc_get_account_orders_actions( $order );

										if ( ! empty( $actions ) ) {
											foreach ( $actions as $key => $action ) {
												echo '<a target="_blank" href="' . esc_url( $action['url'] ) . '" class="sp-yayment-action woocommerce-button button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
											}
										}
										?>
									<?php }?>
								</td>
							<?php }?>
						</tr>
					<?php }?>
				</tbody>
			</table>

			<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

			<?php if ( 1 < $customer_orders->max_num_pages ) {?>
				<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
					<?php if ( 1 !== $current_page ) {?>
						<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'listingo' ); ?></a>
					<?php }?>

					<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) {?>
						<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'listingo' ); ?></a>
					<?php }?>
				</div>
			<?php }?>
		</div>
		<?php }else {?>
			<div class="tg-dashboardbox spinvoices">
				<div class="tg-dashboardtitle">
					<h2><?php esc_html_e( 'Your Orders', 'listingo' ); ?></h2>
				</div>		
				<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
					<?php esc_html_e( 'No order has been made yet.', 'listingo' ); ?>
				</div>
			</div>
		<?php }?>
<?php } else{
	Listingo_Prepare_Notification::listingo_warning(esc_html__('Sorry!', 'listingo'), esc_html__('WooCoomerce should be installed for payments. Please contact to administrator', 'listingo'));		
}