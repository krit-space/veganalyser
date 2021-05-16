<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MP_ATAEMAIL' ) ) :

	/**
	 * Ask to admin Email.
	 */
	class MP_ATAEMAIL extends WC_Email {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->id            = 'new_query';
			$this->title         = __( 'Ask To Admin', 'marketplace' );
			$this->description   = __( 'Query emails are sent to chosen recipient(s) ', 'marketplace' );
			$this->heading       = __( 'Ask to admin', 'marketplace' );
			$this->subject       = '[' . get_option( 'blogname' ) . ']' . __( ' New Query', 'marketplace' );
			$this->template_html = 'asktoadmin.php';
			$this->footer        = __( 'Thanks for choosing marketplace.', 'marketplace' );

			// Call parent constructor.
			parent::__construct();

			// Other settings.
			$this->recipient = $this->get_option( 'recipient', get_option( 'admin_email' ) );
		}

		public function get_options() {

			global $wpdb;

			$templates   = __( 'Templates not found', 'marketplace' );

			$sql = "SELECT title FROM {$wpdb->prefix}emailTemplate  WHERE status='publish'";

			$results = $wpdb->get_results( $sql );

			$types['-1'] = __( 'Select Template', 'marketplace' );

			if ( $results ) {
				foreach ( $results as $key => $value ) {
					$types[ $value->title ] = $value->title;
				}
				return $types;
			} else {
				return $templates;
			}
		}

		/**
		 * Trigger.
		 *
		 * @param int $order_id order id.
		 */
		public function trigger( $order_id ) {
			if ( $order_id ) {
				$this->object                     = wc_get_order( $order_id );
				$this->find['register-date']      = '{register_date}';
				$this->find['register-number']    = '{register_number}';
				$this->replace['register-date']   = date_i18n( wc_date_format(), strtotime( $this->object->order_date ) );
				$this->replace['register-number'] = $this->object->get_order_number();
			}

			if ( ! $this->is_enabled() || ! $this->get_recipient() ) {
				return;
			}

			$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
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
				'recipient'      => array(
					'title'       => __( 'Recipient(s)', 'marketplace' ),
					'type'        => 'text',
					'description' => sprintf( __( 'Enter recipients (comma separated) for this email. Defaults to ', 'marketplace' ) . '<code>%s</code>.', esc_attr( get_option( 'admin_email' ) ) ),
					'placeholder' => '',
					'default'     => $this->recipient,
					'desc_tip'    => true,
				),
				'subject'        => array(
					'title'       => __( 'Subject', 'marketplace' ),
					'type'        => 'text',
					'description' => sprintf( __( 'This controls the email subject line. Leave blank to use the default subject: ', 'marketplace' ) . '<code>%s</code>.', $this->subject ),
					'placeholder' => '',
					'default'     => $this->subject,
					'desc_tip'    => true,
				),
				'heading'        => array(
					'title'       => __( 'Email Heading', 'marketplace' ),
					'type'        => 'text',
					'description' => sprintf( __( 'This controls the main heading contained within the email notification. Leave blank to use the default heading: ', 'marketplace' ) . '<code>%s</code>.', $this->heading ),
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
					'description' => sprintf( __( 'This controls the main Footer contained within the email notification. Leave blank to use the default heading: ', 'marketplace' ) . '<code>%s</code>.', $this->footer ),
					'placeholder' => '',
					'default'     => $this->footer,
					'desc_tip'    => true,
				),
			);
		}
	}

endif;

return new MP_ATAEMAIL();
