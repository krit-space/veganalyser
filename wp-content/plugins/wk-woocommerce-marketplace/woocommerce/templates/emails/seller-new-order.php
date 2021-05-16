<?php

/**
 * Seller new order email
 * @author Webkul
 * @version 4.7.1
 */

 if ( ! defined( 'ABSPATH' ) ) {
	 exit;
 }

 $order = new WC_Order( $data[0]->get_order_id() );

 foreach ( $data as $key => $value ) {
	 $product_id = $value->get_product_id();
	 $variable_id = $value->get_variation_id();
	 $product_total_price = $value->get_data()['total'];
	 $qty = $value->get_data()['quantity'];
	 $post = get_post( $product_id );

	 $order_detail_by_order_id[$product_id][] = array( 'product_name' => $value['name'], 'qty'=>$qty, 'variable_id' => $variable_id, 'product_total_price' => $product_total_price );
 }

 $total_payment = 0;

 $shipping_method = $order->get_shipping_method();

 $payment_method = $order->get_payment_method_title();

 $result = ' <tr>
			 <td class="alert alert-warning" id="body_content_inner" >' . __( 'You have received an order from ', 'marketplace' ) . '<strong>' . $order->get_formatted_billing_full_name() . '</strong>.' . __( ' The order is as follows:', 'marketplace' ) . '
				<h3>' . __( 'Order', 'marketplace' ) . ' #' . $order->get_ID() . ' (' . $order->get_date_created()->format( 'F j, Y' ) . ')</h3>
				<hr><table class="order-details" id="body_content_inner" style="width:100%"><tr><td class="th">' . __( 'Product', 'marketplace' ) . '</td><td class="th">' . __( 'Quantity', 'marketplace' ) . '</td><td class="th">' . __( 'Price', 'marketplace' ) . '</td></tr><tr>';

				foreach ( $order_detail_by_order_id as $product_id => $details ) {
					for ( $i = 0; $i < count( $details ); $i++ ) {
						$total_payment = floatval( $total_payment ) + floatval( $details[$i]['product_total_price'] ) + floatval( $order->get_total_shipping() );
						if($details[$i]['variable_id']==0){
							$result .= '<tr class="order_item alt-table-row">
								<td class="product-name">
									<a href="">' . $details[$i]['product_name'] . '</a>
								</td>
								<td>' . $details[$i]['qty'] . '</td>
								<td class="product-total">
									' . wc_price( $details[$i]['product_total_price'], array( 'currency' => $order->get_currency() ) ) . '
								</td>
							</tr>';
						} else {
							$product = new WC_Product( $product_id );
							$attribute = $product->get_attributes();

							$attribute_name = '';
							foreach ( $attribute as $key => $value ) {
								$attribute_name = $value['name'];
							}
							$variation = new WC_Product_Variation( $details[$i]['variable_id'] );
							$aaa = $variation->get_variation_attributes();

							$attribute_prop = strtoupper( $aaa['attribute_'.strtolower( $attribute_name )] );
							$result .= '<tr class="order_item alt-table-row">
								<td class="product-name">
									<a href="">' . $details[$i]['product_name'] . '</a>
									<b>' . $attribute_name . ' : ' . '</b>
									' . $attribute_prop . '
								</td>
								<td>' . $details[$i]['qty'] . '</td>
								<td class="product-total">
									' . wc_price( $details[$i]['product_total_price'], array( 'currency' => $order->get_currency() ) ) . '
								</td>
							</tr>';
						}
					}
				}

			if ( ! empty( $shipping_method ) ) :
					$result .= '<tr>
						<th scope="row" colspan="2">' . __( 'Shipping', 'marketplace' ) . ' : </th>
						<td>' . wc_price( ( $order->get_total_shipping() ? $order->get_total_shipping() : 0 ), array( 'currency' => $order->get_currency() ) ) . '</td>
					</tr>';
			endif;

			if ( ! empty( $payment_method ) ) :
					$result .= '<tr>
						<th scope="row" colspan="2">' . __( 'Payment Method', 'marketplace' ) . ' : </th>
						<td>' . $payment_method . '</td>
					</tr>';
			endif;

			$result .= '<tr>
				<th scope="row" colspan="2">' . __( 'Total', 'marketplace' ) . ' : </th>
				<td>' . wc_price( $total_payment, array( 'currency' => $order->get_currency() ) ) . '</td>
			</tr>';

			$result .= '</tr></table><hr>';

			if ( $order->get_customer_note() ) {
				$fields['customer_note'] = array(
					'label' => __( 'Note', 'marketplace' ),
					'value' => wptexturize( $order->get_customer_note() ),
				);
			}

			if ( $order->get_billing_email() ) {
				$fields['billing_email'] = array(
					'label' => __( 'Email address', 'marketplace' ),
					'value' => wptexturize( $order->get_billing_email() ),
				);
			}

			if ( $order->get_billing_phone() ) {
				$fields['billing_phone'] = array(
					'label' => __( 'Phone', 'marketplace' ),
					'value' => wptexturize( $order->get_billing_phone() ),
				);
			}

			if ( ! empty( $fields ) ) :
				$result .= '<h2>' . __( 'Customer details', 'marketplace' ) . '</h2><ul>';
				foreach ( $fields as $field ) :
						$result .= '<li><p><strong>' . wp_kses_post( $field['label'] ) .' :</strong> <span class="text">' . wp_kses_post( $field['value'] ) . '</span></p></li>';
				endforeach;
				$result .= '</ul>';
			endif;

			$text_align = is_rtl() ? 'right' : 'left';

			$result .= '<table id="addresses" style="width:100%">
				<tr>
					<td class="td" valign="top" width="49%">
						<h3>' . __( 'Billing address', 'marketplace' ) . '</h3>

						<p class="text">' . $order->get_formatted_billing_address() . '</p>
					</td>';

			if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && ( $shipping = $order->get_formatted_shipping_address() ) ) :
				$result .= '<td class="td" valign="top" width="49%">
					<h3>' . __( 'Shipping address', 'marketplace' ) . '</h3>

					<p class="text">' . $shipping . '</p>
				</td>';
			endif;

			$result .= '</tr></table><table>';

			$result .= '</td>
			</tr>
			<tr>
			 <td></td><td></td>
			</tr></table>';

return $result;
