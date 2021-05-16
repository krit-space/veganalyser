<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$loginurl = explode( '-', $data );
$user = $loginurl[0];
$product = $loginurl[1];
$_product = wc_get_product( $product );
$product_name = $_product->get_name();
$user_name = get_user_meta( $user, 'first_name', true );
$welcome = sprintf( __( 'Vendor', 'marketplace' ) . '%s' . __( 'has requested to publish "', 'marketplace' ) . '<strong>%s</strong>' . __( '" product !', 'marketplace' ), $user_name, $product_name, get_option( 'blogname' ) ) . "\r\n\n";
$msg = __( 'Please review the request', 'marketplace') . "\n\n\r\n\r\n\n\n";
$review_here = sprintf( admin_url( 'post.php?post=%s&action=edit' ), $product );
$admin = get_option( 'admin_email' );

  $result = ' <tr>
				<td class="alert alert-warning" id="body_content_inner" >
					<p>Hi, ' . $admin . '</p>
					<h3>' . $welcome . '<h3>
					<p>' . $msg . ' <a href=' . $review_here . '>Here</a></p>
				</td>
			</tr>';

	return $result;
