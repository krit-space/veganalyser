<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$loginurl = get_option( 'admin_email' );
$welcome = sprintf( __( 'Welcome to  ' ) . get_option( 'blogname' ) . '!' ) . "\r\n\n";
$msg = __( 'Someone asked query from following account:', 'marketplace' ) . "\r\n\r\n";
$username = __( 'Email : ', 'marketplace' );
$username_mail = $data['email'];
$admin = __( 'Message : ', 'marketplace' );
$admin_message = $data['ask'];
$reference = __( 'Subject : ','marketplace' );
$reference_message = $data['subject'];

$result = '
			<tr>
				<td class="alert alert-warning" id="body_content_inner" >
					<p>Hi, ' . $loginurl . '</p>
					<h2> <strong>' . $welcome . '</strong><h2>
					<p>' . $msg . '</p>
					<p><strong>' . $username . '</strong>' . $username_mail . '</p>
					<p><strong>' . $reference . '</strong>' . $reference_message . '</p>
					<p><strong>' . $admin . '</strong>' . $admin_message . '</p>
				</td>
			</tr>';

		return $result;
