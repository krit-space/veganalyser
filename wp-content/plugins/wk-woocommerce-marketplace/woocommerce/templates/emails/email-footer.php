<?php

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * @var WC_Email $current_email
 */
global $current_email, $wpdb;

$results = $enable = $result_data = '';

$sql = "SELECT option_value FROM {$wpdb->prefix}options WHERE option_name = '$tableName'";

$results = $wpdb->get_results( $sql );

if ( ! empty( $results ) ) {
  $result_data = maybe_unserialize( $results[0]->option_value );
}

$thanks_msg = ( $result_data ) ? $result_data['footer'] : __( 'Thanks for choosing Marketplace.', 'marketplace' );

$result = '<tr>
					<td class="tfooter">
						<p>' . $thanks_msg . '</p>
					</td>
				</tr>
		</table></body></html>';
