<?php
/**
 * This file handles single transaction detail view template.
 *
 * @package Woocommerce Marketplace
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$order_ids = array();
$ord_id    = maybe_unserialize( $order_id );

?>
<div class="woocommerce-account">
	<?php apply_filters( 'mp_get_wc_account_menu', 'marketplace' ); ?>
	<div class="wk-transaction-view woocommerce-MyAccount-content">
		<div class="wk-mp-transaction-info-box">
				<div>
					<h3>
						<?php echo esc_html__( 'Transaction Id', 'marketplace' ); ?> - <?php echo esc_html( $transaction_id ); ?>
					</h3>
						<div class="box">
							<div class="box-title">
									<h3><?php echo esc_html__( 'Information', 'marketplace' ); ?></h3>
							</div>
							<fieldset>
								<div class="box-content">
										<div class="wk_row">
											<span class="label"><?php echo esc_html__( 'Date', 'marketplace' ); ?> : </span>
											<span class="value"><?php echo date( 'F j, Y', strtotime( $transaction_date ) ); ?></span>
										</div>
										<div class="wk_row">
											<span class="label"><?php echo esc_html__( 'Amount', 'marketplace' ); ?> : </span>
											<span class="value"><span class="price"><?php echo wc_price( $amount ); ?></span></span>
										</div>
										<div class="wk_row">
											<span class="label"><?php echo esc_html__( 'Type', 'marketplace' ); ?> : </span>
											<span class="value"><?php echo esc_html( $type ); ?></span>
										</div>
										<div class="wk_row">
											<span class="label"><?php echo esc_html__( 'Method', 'marketplace' ); ?> : </span>
											<span class="value"><?php echo esc_html( $method ); ?></span>
										</div>
								</div>
							</fieldset>
						</div>
				</div>
		</div>
		<div class="transaction-details">
			<div class="table-wrapper">
				<h3 class="table-caption">
					<?php echo esc_html__( 'Detail', 'marketplace' ); ?>
				</h3>
				<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
					<thead>
						<tr>
							<?php foreach ( $columns as $column_id => $column_name ) : ?>
								<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
							<?php endforeach; ?>
						</tr>
					</thead>

					<tbody>
						<?php
						global $commission;
						$current_user  = wp_get_current_user();
						$role_name     = $current_user->roles;
						if ( ! in_array( 'wk_marketplace_seller', $role_name, true ) ) {
							$seller_id  = $_GET['sid'];
						}else {
							$seller_id = get_current_user_id();
						}

						$order      = wc_get_order( $ord_id );
						$item_count = $order->get_items();

						$sel_info   = $commission->get_seller_order_info( $ord_id, $seller_id );
						$product_name = '';

						foreach ( $sel_info['pro_info'] as $pro_nme ) {
							if ( $product_name != '' ){
								$product_name = $product_name . ' +<br>';
							}
							$product_name = $product_name . $pro_nme['title'];
						}
						$quantity          = $sel_info['total_qty'];
						$line_total        = $sel_info['pro_total'] + $sel_info['ship_data'];
						$commission_amount = $sel_info['total_comision'];
						$subtotal          = $sel_info['total_sel_amt'] + $sel_info['ship_data'];
						?>
						<tr>
							<td>
								<?php echo esc_html_x( '#', 'hash before order number', 'marketplace' ) . intval( $order->get_order_number() ); ?>
							</td>
							<td>
								<?php echo ( $product_name ); ?>
							</td>
							<td>
								<?php echo esc_html( $quantity ); ?>
							</td>
							<td>
								<?php echo wc_price( $line_total ); ?>
							</td>
							<td>
								<?php echo wc_price( $commission_amount ); ?>
							</td>
							<td>
								<?php echo wc_price( $subtotal ); ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div
