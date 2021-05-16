<?php
/**
 * Customer new account email
 * @author 		Webkul
 * @version     4.7.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$loginurl = get_option( 'admin_email' );
$welcome = sprintf( __( 'Welcome to ! ', 'marketplace' ) . get_option( 'blogname' ) ) . "\r\n\n";
$msg = sprintf( __( 'New Seller registration on :', 'marketplace' ) . get_option( 'blogname' ) ) . "\n\n\r\n\r\n\n\n";
$username = __( 'Username :- ', 'marketplace' ) . $data['user_login'];
$user_mail = __( 'User Email :- ','marketplace' ) . $data['user_email'];
$thnksmsg = __( 'Thanks for choosing Marketplace.', 'marketplace' );


$result = '<tr>
				<td class="alert alert-warning" id="body_content_inner" >
					<p>Hi, ' . $loginurl . '</p>
					<h2>' . $msg . '</h2>
					<p>' . $username . '</p>
					<p>' . $user_mail . '</p>
				</td>
			</tr>';

		 return $result;
