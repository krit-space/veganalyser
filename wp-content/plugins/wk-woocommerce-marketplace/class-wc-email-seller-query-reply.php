<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WC_Email_Seller_Query_Reply' ) ) :

	/**
	 * Reply to seller regarding query Email.
	 */
	class WC_Email_Seller_Query_Reply extends WC_Email {

		function get_options() {
			global $wpdb;
			$templates   = __( 'Templates not found', 'marketplace' );
			$sql         = "SELECT title FROM {$wpdb->prefix}emailTemplate  WHERE status='publish'";
			$results     = $wpdb->get_results( $sql );
			$types['-1'] = __( 'Select Template', 'marketplace' );
			if ( $results ) {
				foreach ( $results as $key => $value ) {

				$types[ $value->title ] = __( $value->title, 'marketplace' );

				}
				return $types;
			} else {
				return $templates;
			}
		}

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->id            = 'query_reply';
			$this->title         = __( 'Reply to Seller Regarding Query', 'marketplace' );
			$this->description   = __( 'Query emails are sent to chosen recipient(s) ', 'marketplace' );
			$this->heading       = __( 'Admin Reply Regarding Query', 'marketplace' );
			$this->subject       = '[' . get_option( 'blogname' ) . '] ' . __( 'New Query Reply', 'marketplace' );
			$this->template_html = 'replytoseller.php';
			$this->footer        = __( 'Thanks for choosing marketplace.', 'marketplace' );

			// Call parent constructor.
			parent::__construct();

			// Other settings.
			$this->recipient = $this->get_option( 'recipient', get_option( 'admin_email' ) );
		}

		/**
		 * Get content html.
		 *
		 * @access public
		 * @return string
		 */
		public function get_content_html() {
			return wc_get_template_html( $this->template_html, array(
				'order'         => $this->object,
				'email_heading' => $this->get_heading(),
				'sent_to_admin' => true,
				'plain_text'    => false,
				'email'         => $this,
			) );
		}

		/**
		 * Get content plain.
		 *
		 * @access public
		 * @return string
		 */
		public function get_content_plain() {
			return wc_get_template_html( $this->template_plain, array(
				'order'         => $this->object,
				'email_heading' => $this->get_heading(),
				'sent_to_admin' => true,
				'plain_text'    => true,
				'email'         => $this,
			) );
		}

		/**
		 * Initialise settings form fields.
		 */
		public function init_form_fields() {
			$this->form_fields = array(
				'enabled'        => array(
					'title'   => __( 'Enable/Disable', 'marketplace' ),
					'type'    => 'checkbox',
					'label'   => __( 'Enable this email notification', 'marketplace' ),
					'default' => '',
				),
				'subject'        => array(
					'title'       => __( 'Subject', 'marketplace' ),
					'type'        => 'text',
					'description' => sprintf( __( 'This controls the email subject line. Leave blank to use the default subject:', 'marketplace' ) . '<code>%s</code>', $this->subject ),
					'placeholder' => '',
					'default'     => $this->subject,
					'desc_tip'    => true,
				),
				'heading'        => array(
					'title'       => __( 'Email Heading', 'marketplace' ),
					'type'        => 'text',
					'description' => sprintf( __( 'This controls the main heading contained within the email notification. Leave blank to use the default heading:', 'marketplace' ) . '<code>%s</code>', $this->heading ),
					'placeholder' => '',
					'default'     => $this->heading,
					'desc_tip'    => true,
				),
				'email_template' => array(
					'title'       => __( 'Email template', 'marketplace' ),
					'type'        => 'select',
					'description' => __( 'Choose which format of email to send.', 'marketplace' ),
					'default'     => 'default',
					'class'       => 'email_type wc-enhanced-select',
					'options'     => $this->get_options(),
					'desc_tip'    => true,

				),
				'footer'         => array(
					'title'       => __( 'Email Footer', 'marketplace' ),
					'type'        => 'text',
					'description' => sprintf( __( 'This controls the main Footer contained within the email notification. Leave blank to use the default heading: ', 'marketplace' ) . '<code>%s</code>', $this->footer ),
					'placeholder' => '',
					'default'     => $this->footer,
					'desc_tip'    => true,
				),
			);
		}
	}

endif;

return new WC_Email_Seller_Query_Reply();
