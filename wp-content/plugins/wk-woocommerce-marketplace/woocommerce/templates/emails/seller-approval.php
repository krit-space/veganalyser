<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$loginurl = $data;
$welcome = sprintf( __( 'Welcome to ', 'marketplace' ) . get_option( 'blogname' ) . '!' ) . "\r\n\n";
$msg = __( 'Your account has been approved by admin ', 'marketplace' ) . "\n\n\r\n\r\n\n\n";
$admin = get_option( 'admin_email' );
$reference = __( 'If you have any problems, please contact me at -', 'marketplace' ) . "\r\n\r\n";
$thnksmsg = __( 'Thanks for choosing Marketplace.', 'marketplace' );

  $result = ' <tr>
				<td class="alert alert-warning" id="body_content_inner" >
					<p>Hi, ' . $loginurl . '</p>
					<h3>' . $welcome . '<h3>
					<p>' . $msg . '.</p>
					<p>' . $reference . '</p>
					<h3><a href="mailto:' . $admin . '">' . $admin . '</a></h3>
					<p>' . $thnksmsg . '</p>
				</td>
			</tr>';

	return $result;
