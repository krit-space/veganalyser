<?php

global $wpdb, $woocommerce;

$table_name = $wpdb->prefix . 'mporders';

$order = new WC_Order( $order_id );

$items = $order->get_items();

// for calculation for advance commission.
if ( class_exists( 'wk_advanced_commission' ) && ( 1 == get_option( 'advanced_commission_enabled' ) ) ) {

	$mp_comision = new Process_Commission();

} else {

	$mp_comision = new MP_Commission();

}

foreach ( $items as $key => $item ) {

	$item_id = $item->get_id();

	$assigned_seller = wc_get_order_item_meta( $item_id, 'assigned_seller', true );

	$installation_charges = wc_get_order_item_meta( $item_id, 'installation_charges', true );

	if ( isset( $item['variation_id'] ) && $item['variation_id'] ) {

		$product_id = $item['variation_id'];

		$commission_data = $mp_comision->calculate_product_commission( $item['variation_id'], $item['quantity'], $item['line_total'], $assigned_seller );

		if ( ! empty( $assigned_seller ) ) {
			$product_price = $wpdb->get_var( $wpdb->prepare( "SELECT price FROM {$wpdb->prefix}spc_assigned_variable_products WHERE product_id=%d AND user_id=%d", $product_id, $assigned_seller ) );
		}
	} else {

		$product_id = $item['product_id'];

		$commission_data = $mp_comision->calculate_product_commission( $item['product_id'], $item['quantity'], $item['line_total'], $assigned_seller );

		if ( ! empty( $assigned_seller ) ) {
			$product_price = $wpdb->get_var( $wpdb->prepare( "SELECT price FROM {$wpdb->prefix}spc_assigned_products WHERE product_id=%d AND user_id=%d", $product_id, $assigned_seller ) );
		}
	}

	if ( empty( $assigned_seller ) ) {
		$product_price = wc_get_price_excluding_tax( wc_get_product( $product_id ) );
	}

	$seller_id = $commission_data['seller_id'];

	$amount = (float) $item['line_total'];

	$product_qty = $item['quantity'];

	$discount_applied = number_format( (float) ( ( $product_qty * $product_price ) - $amount ), 2, '.', '' );

	$admin_amount = $commission_data['admin_commission'];

	$seller_amount = $commission_data['seller_amount'];

	$comm_applied = $commission_data['commission_applied'];

	$comm_type = $commission_data['commission_type'];

	if ( ! empty( $installation_charges ) ) {
		$amount        = (float) $item['line_total'] + (float) $installation_charges;
		$seller_amount = $commission_data['seller_amount'] + (float) $installation_charges;
	}

	$data = array(

		'order_id'           => $order_id,

		'product_id'         => $product_id,

		'seller_id'          => $seller_id,

		'amount'             => number_format( (float) $amount, 2, '.', '' ),

		'admin_amount'       => number_format( (float) $admin_amount, 2, '.', '' ),

		'seller_amount'      => number_format( (float) $seller_amount, 2, '.', '' ),

		'quantity'           => $product_qty,

		'commission_applied' => number_format( (float) $comm_applied, 2, '.', '' ),

		'discount_applied'   => $discount_applied,

		'commission_type'    => $comm_type,

	);

	$wpdb->insert( "{$wpdb->prefix}mporders", $data );
}

// shipping calculation.
$ship_sess = WC()->session->get( 'shipping_sess_cost' );

$ship_sess = apply_filters( 'wk_mp_modify_shipping_session', $ship_sess, $item );

WC()->session->__unset( 'shipping_sess_cost' );

$ship_cost = 0;

if ( ! empty( $ship_sess ) ) {

	foreach ( $ship_sess as $sel_id => $sel_detail ) {

		$shiping_cost = $sel_detail['cost'];

		if ( wc_prices_include_tax() ) {

			$tax_rate = WC_Tax::get_rates( $product->get_tax_class() );

			$shiping_cost = ( $shiping_cost / ( ( $tax_rate[1]['rate'] / 100 ) + 1 ) );
		}

		$shiping_cost = number_format( (float) $shiping_cost, 2, '.', '' );

		$ship_cost = $ship_cost + $shiping_cost;

		$push_arr = array(

			'shipping_method_id' => $sel_detail['title'],

			'shipping_cost'      => $shiping_cost,

		);

		foreach ( $push_arr as $key => $value ) {

			$wpdb->insert( $wpdb->prefix . 'mporders_meta', array(

				'seller_id'  => $sel_id,

				'order_id'   => $order_id,

				'meta_key'   => $key,

				'meta_value' => $value,

			) );
		}
	}
}

$coupon_detail = WC()->cart->get_coupons();

if ( $coupon_detail ) {

	foreach ( $coupon_detail as $key => $value ) {

		$coupon_code = $key;

		$coupon_cost = $value->amount;

		$coupon_post_obj = get_page_by_title( $coupon_code, OBJECT, 'shop_coupon' );

		$coupon_create = $coupon_post_obj->post_author;

		$wpdb->insert( $wpdb->prefix . 'mporders_meta', array(

			'seller_id'  => $coupon_create,

			'order_id'   => $order_id,

			'meta_key'   => 'discount_code',

			'meta_value' => $coupon_code,

		) );
	}
}
$mkt_comision = new MP_Commission();
$mkt_comision->update_seller_order_info( $order_id );
