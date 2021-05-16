<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$loginurl = $data['user_login'];
$welcome = sprintf( __( 'Welcome to ') . get_option( 'blogname' ) . '!' ) . "\r\n\n";
$msg = __( 'Your account has been created awaiting for admin approval.', 'marketplace' ) . "\n\n\r\n\r\n\n\n";
$username = __( 'User :- ', 'marketplace' ) . $data['user_email'];
$password = __('User Password :- ', 'marketplace' ) . $data['user_pass'];
$admin = get_option( 'admin_email' );
$reference = __( 'If you have any problems, please contact me at:-', 'marketplace' ) . "\r\n\r\n";

  $result = '<tr>
				<td class="alert alert-warning" id="body_content_inner" >
					<p>Hi, ' . $loginurl . '</p>
					<h2> <strong>'.$welcome.'</strong><h2>
					<p>'.$msg.'</p>
					<p>'.$username.'</p>
					<p>'.$password.'</p>
					<h3>'.$reference.'</h3>
					<h3><a href="mailto:' . $admin . '">' . $admin . '</a></h3>
				</td>
			</tr>';

		 return $result;
