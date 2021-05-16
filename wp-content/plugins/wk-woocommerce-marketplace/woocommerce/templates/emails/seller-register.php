<?php
/**
 * Customer new account email
 * @author Webkul
 * @version     4.7.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$loginurl=get_option('admin_email');
$welcome=sprintf( __("Welcome to ") . get_option( 'blogname' ) . '!' ) . "\r\n\n";
$msg= __('Someone asked query from following account:','marketplace') . "\r\n\r\n";
$username=__('Email :','marketplace');
$username_mail=$data['email'];
$admin = __( 'Message : ', 'marketplace' );
$admin_message = $data['ask'];
$reference=__('Subject : ','marketplace');
$reference_message = $data['subject'];
$thnksmsg=__('Thanks for choosing Marketplace.','marketplace');


	$result = ' <tr>
					 <td class="alert alert-warning" >

					<p>'  __( 'Thanks for creating an account on %1$s. Your username is %2$s', 'woocommerce' ), esc_html( $blogname ), '<strong>' . esc_html( $user_login ) . '</strong>' ).'</p>';

						if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated ) : ?>

						<p> __( 'Your password has been automatically generated: %s', 'woocommerce' ), '<strong>' . esc_html( $user_pass ) . '</strong>' ); ?></p>

					<?php endif; ?>

						<p><?php printf( __( 'You can access your account area to view your orders and change your password here: %s.', 'woocommerce' ), make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) ); ?></p>

					 </td>
				</tr>

			</table>

		 </div>

	  </td>

	</tr>

	<?php
		 return $result;
