<?php

/**
 * Query Answered email
 * @author Webkul
 * @version 4.7.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wpdb;
if ( $data ) {

	$query_id = $data['q_id'];
	$adm_msg  = $data['adm_msg'];
	$query    = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}mpseller_asktoadmin where id = %d", $query_id ) );

	if ( $query ) {
		$q_data = $query[0];
		$welcome           = sprintf( __( 'Welcome to ' ) . get_option( 'blogname' ) . '!' ) . "\r\n\n";
		$msg               = __( 'We received your query about: ', 'marketplace' ) . "\r\n\r\n";
		$admin             = __( 'Message : ', 'marketplace' );
		$admin_message     = $q_data->message;
		$reference         = __( 'Subject : ', 'marketplace' );
		$reference_message = $q_data->subject;
		$adm_ans           = __( 'Answer : ', 'marketplace' );
		$closing_msg       = __( 'Please, do contact us if you have additional queries. Thanks again!', 'marketplace' );

		$result = '
		<tr>
			<td class="alert alert-warning" id="body_content_inner" >
				<p>Hi,</p>
				<h2><strong>' . $welcome . '</strong><h2>
				<p>' . $msg . '</p>
				<p><strong>' . $reference . '</strong>' . $reference_message . '</p>
				<p><strong>' . $admin . '</strong>' . $admin_message . '</p>
				<p><strong>' . $adm_ans . '</strong><br>' . $adm_msg . '</p>
				<p>' . $closing_msg . '</p>
			</td>
		</tr>';
	}
}

return $result;
