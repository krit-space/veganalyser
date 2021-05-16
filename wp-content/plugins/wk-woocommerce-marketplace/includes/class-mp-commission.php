<?php
/**
 * This file handles commission related functions.
 *
 * @package Woocommerce Marketplace
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MP_Commission' ) ) {
	/**
	 * Commision Handler.
	 */
	class MP_Commission {
		/**
		 * Base Function.
		 */
		public function __construct() {
			global $commission;

			$commission = __CLASS__;
		}

		/**
		 * Get Commission per order item.
		 *
		 * @param int $order_id Order ID.
		 * @param int $product_id Product ID.
		 * @param int $quantity Product Quantity.
		 */
		public function get_order_item_commission( $order_id, $product_id, $quantity = '' ) {
			$order = wc_get_order( $order_id );

		}

		/**
		 * Get admin commission rate.
		 *
		 * @param int $seller_id Seller ID.
		 */
		public function get_admin_rate( $seller_id ) {
			global $wpdb;
			$admin_rate = 1;

			$admin_commission = $wpdb->get_results( $wpdb->prepare( "select * from {$wpdb->prefix}mpcommision  where seller_id=%d", $seller_id ) );

			if ( $admin_commission ) {
				$admin_rate = floatval( $admin_commission[0]->commision_on_seller ) / 100;
			}
			return $admin_rate;
		}

		/**
		 * Update Seller Commission data.
		 *
		 * @param int $seller_id Seller ID.
		 * @param int $order_id Order ID.
		 */
		public function update_seller_commission( $seller_id, $order_id ) {

			global $wpdb;

			$sel_ord_data = $this->get_seller_order_info( $order_id, $seller_id );

			$sel_pay_amount = $sel_ord_data['total_sel_amt'] + $sel_ord_data['ship_data'];

			$response = $this->update( $seller_id, $sel_pay_amount );

			if ( $response['error'] == 0 ) {

				return $sel_pay_amount;
			} else {

				return false;
			}
		}

		/**
		 * Seller commision updation.
		 *
		 * @param int $seller_id Seller ID.
		 * @param int $pay_amount Admin Commission Rate.
		 */
		public function update( $seller_id, $pay_amount ) {

			$result = array(
				'error' => 1,
			);

			$seller_id = intval( $seller_id );

			if ( ! empty( $seller_id ) && ! empty( $pay_amount ) ) {

				global $wpdb;

				$seller_data = $wpdb->get_results( $wpdb->prepare( "select * from {$wpdb->prefix}mpcommision where seller_id=%d", $seller_id ) );

				if ( ! empty( $seller_data ) ) {

					$paid_ammount = $seller_data[0]->paid_amount + $pay_amount;

					$last_paid_ammount = $pay_amount;

					$res = $wpdb->update(
						"{$wpdb->prefix}mpcommision",
						array(
							'paid_amount'       => $paid_ammount,
							'last_paid_ammount' => $last_paid_ammount,
						),
						array( 'seller_id' => $seller_id ),
						array(
							'%f',
							'%f',
							'%f',
						),
						array( '%d' )
					);
					if ( $res ) {

						$result = array(
							'error' => 0,
							'msg'   => __( 'Amount Transfered Successfully.!', 'marketplace' ),
						);

					}
				}
			}

			return $result;
		}

		/**
		 * Calculate product commission.
		 *
		 * @param int $product_id product is.
		 * @param int $pro_qty product quantity.
		 * @param int $pro_price product price.
		 * @param int $assigned_seller seller field.
		 */
		public function calculate_product_commission( $product_id = '', $pro_qty = '', $pro_price = '', $assigned_seller = '' ) {

			if ( ! empty( $product_id ) && ! empty( $pro_price ) ) {

				global $wpdb;

				$product = get_post( $product_id );

				if ( empty( $assigned_seller ) ) {

					$seller_id = $product->post_author;
				} else {

					$seller_id = $assigned_seller;
				}

				$marketplace_commission = $wpdb->get_results( $wpdb->prepare( "Select commision_on_seller from {$wpdb->prefix}mpcommision where seller_id = %d", $seller_id ) );

				$product_price = $pro_price;

				if ( empty( $marketplace_commission[0]->commision_on_seller ) ) {

					if ( user_can( $seller_id, 'administrator' ) ) {

						$admin_commission = $product_price;

						$seller_amount = $product_price - $admin_commission;

						$commission_applied = 0;

						$comm_type = 'fixed';

					} else {

						if ( get_option( 'wkmpcom_minimum_com_onseller' ) ) {

							$default_commission = get_option( 'wkmpcom_minimum_com_onseller' );

						} else {

							$default_commission = 0;

						}

						$admin_commission = ( $product_price / 100 ) * $default_commission;

						$seller_amount = $product_price - $admin_commission;

						$commission_applied = ( $default_commission ) ? $default_commission : 0;

						$comm_type = 'percent';

					}
				} else {

						$admin_commission = ( $product_price / 100 ) * $marketplace_commission[0]->commision_on_seller;

						$seller_amount = $product_price - $admin_commission;

						$commission_applied = $marketplace_commission[0]->commision_on_seller;

						$comm_type = 'percent';

				}
			}

				$data = array(

					'seller_id'          => $seller_id,

					'total_amount'       => $product_price,

					'admin_commission'   => $admin_commission,

					'seller_amount'      => $product_price - $admin_commission,

					'commission_applied' => $commission_applied,

					'commission_type'    => $comm_type,

				);

				return $data;

		}

		/**
		 * Get seller ids regarding order id.
		 *
		 * @param int $order_id order id.
		 */
		public function get_sellers_in_order( $order_id = '' ) {

			global $wpdb;

			$sel_arr = array();

			$sel_id  = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT seller_id from {$wpdb->prefix}mporders where order_id = %d", $order_id ) );

			foreach ( $sel_id as $key => $value ) {

				if ( ! user_can( $value->seller_id, 'administrator' ) ) {

					$sel_arr[] = $value->seller_id;
				}
			}

			return $sel_arr;
		}

		/**
		 * Update seller data according to order id.
		 *
		 * @param int $order_id order id.
		 * @return void
		 */
		public function update_seller_order_info( $order_id ) {

			global $wpdb;

			if ( $order_id ) {

				$sellers = $this->get_sellers_in_order( $order_id );

				if ( ! empty( $sellers ) ) {

					foreach ( $sellers as $seller_id ) {

						$sel_ord_data = $this->get_seller_order_info( $order_id, $seller_id );

						$sel_amt   = 0;
						$admin_amt = 0;
						if ( ! empty( $sel_ord_data ) ) {
							$sel_amt   = $sel_ord_data['total_sel_amt'] + $sel_ord_data['ship_data'];
							$admin_amt = $sel_ord_data['total_comision'];
						}

						$sel_com_data = $wpdb->get_results( $wpdb->prepare( " SELECT * from {$wpdb->prefix}mpcommision WHERE seller_id = %d", $seller_id ) );

						if ( $sel_com_data ) {

							$sel_com_data = $sel_com_data[0];

							$admin_amount = floatval( $sel_com_data->admin_amount ) + $admin_amt;

							$seller_amount = floatval( $sel_com_data->seller_total_ammount ) + $sel_amt;

							$wpdb->get_results( $wpdb->prepare( " UPDATE {$wpdb->prefix}mpcommision set admin_amount = %f, seller_total_ammount = %f, last_com_on_total = %f WHERE seller_id = %d", $admin_amount, $seller_amount, $seller_amount, $seller_id ) );

						} else {

							$wpdb->insert( $wpdb->prefix . 'mpcommision', array(

								'seller_id'            => $seller_id,

								'admin_amount'         => $admin_amount,

								'seller_total_ammount' => $seller_amount,

								'last_com_on_total'    => $amount,

							) );
						}
					}
				}
			}
		}

		/**
		 * Returns seller data according to order id.
		 *
		 * @param int $order_id order id.
		 * @param int $seller_id seller id.
		 * @return array.
		 */
		public function get_seller_order_info( $order_id, $seller_id ) {

			global $wpdb;

			$data = false;

			$discount = array(
				'seller' => 0,
				'admin'  => 0,
			);

			$product_info        = array();
			$quantity            = 0;
			$product_total       = 0;
			$total_seller_amount = 0;
			$total_commission    = 0;
			$shipping            = 0;

			$sel_order = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}mporders WHERE seller_id = %d AND order_id = %d", $seller_id, $order_id ) );

			if ( ! empty( $sel_order ) ) {

				foreach ( $sel_order as $ord_info ) {

					if ( ! empty( $ord_info->product_id ) ) {
						$product_info[] = array(
							'id'    => $ord_info->product_id,
							'title' => get_the_title( $ord_info->product_id ),
						);
					}

					if ( ! empty( $ord_info->quantity ) ) {
						$quantity = $quantity + $ord_info->quantity;
					}

					if ( ! empty( $ord_info->amount ) ) {
						$product_total = $product_total + $ord_info->amount;
					}

					if ( ! empty( $ord_info->seller_amount ) ) {
						$total_seller_amount = $total_seller_amount + $ord_info->seller_amount;
					}

					if ( ! empty( $ord_info->admin_amount ) ) {
						$total_commission = $total_commission + $ord_info->admin_amount;
					}

					if ( ! empty( $ord_info->discount_applied ) ) {
						$discount_data = $wpdb->get_results( $wpdb->prepare( "Select * from {$wpdb->prefix}mporders_meta where seller_id = %d and order_id = %d and meta_key = 'discount_code' ", $seller_id, $ord_info->order_id ) );
						if ( ! empty( $discount_data ) ) {
							$discount['seller'] = $discount['seller'] + $ord_info->discount_applied;
						} elseif ( $ord_info->discount_applied > 0 ) {
							$discount['admin'] = $discount['admin'] + $ord_info->discount_applied;
						}
					}

					$ship_data = $wpdb->get_results( $wpdb->prepare( "Select meta_value from {$wpdb->prefix}mporders_meta where seller_id = %d and order_id = %d and meta_key = 'shipping_cost' ", $seller_id, $ord_info->order_id ) );

					if ( ! empty( $ship_data ) ) {
						$shipping = $ship_data[0]->meta_value;
					}
				}
				$data = array(
					'pro_info'       => $product_info,
					'total_qty'      => $quantity,
					'pro_total'      => $product_total,
					'total_sel_amt'  => $total_seller_amount,
					'total_comision' => $total_commission,
					'discount'       => $discount,
					'ship_data'      => $shipping,
				);
			}

			return $data;
		}
	}
}
