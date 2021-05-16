<?php
/**
 * Adding admin side menus file.
 *
 * @package wk-woocommerce-marketplace/includes/admin/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add Admin side menus.
 */
function menu_backend() {
	$hook = add_menu_page( __( 'Marketplace', 'marketplace' ), __( 'Marketplace', 'marketplace' ), 'manage_marketplace', 'products', 'product_layout', WK_MARKETPLACE . 'assets/images/MP.png', 55 );

	add_submenu_page( 'products', __( 'Product List', 'marketplace' ), __( 'Product List', 'marketplace' ), 'manage_marketplace_products', 'products', 'product_layout' );

	add_submenu_page( 'products', __( 'Seller List', 'marketplace' ), __( 'Seller List', 'marketplace' ), 'manage_marketplace_seller', 'sellers', 'seller_layout' );

	add_submenu_page( 'products', __( 'Commissions', 'marketplace' ), __( 'Commissions', 'marketplace' ), 'manage_marketplace_commision', 'Commissions', 'commision_layout' );

	$hook_1 = add_submenu_page( 'products', __( 'Email Templates', 'marketplace' ), __( 'Email Templates', 'marketplace' ), 'manage_marketplace', 'class-email-templates', 'mp_email_templates' );

	add_submenu_page( 'products', __( 'Notification', 'marketplace' ), __( 'Notification', 'marketplace' ), 'manage_marketplace', 'mp-notification', 'mp_notification_tab' );

	add_submenu_page( 'products', __( 'Feedback', 'marketplace' ), __( 'Manage Feedback', 'marketplace' ), 'manage_marketplace', 'mp-feedback', 'mp_feedback_tab' );

	add_submenu_page( 'products', __( 'Seller Queries', 'marketplace' ), __( 'Seller Queries', 'marketplace' ), 'manage_marketplace', 'mp-seller-query', 'mp_seller_query_tab' );

	add_submenu_page( 'products', __( 'Settings', 'marketplace' ), __( 'Settings', 'marketplace' ), 'manage_marketplace_setting', 'Settings', 'settings_layout' );

	add_submenu_page( 'products', __( 'Extensions', 'marketplace' ), __( 'Extensions', 'marketplace' ), 'manage_marketplace_setting', 'mp-extensions', 'extension_layout' );

	add_action( 'load-' . $hook, 'mp_add_product_screen_options' );

	add_action( 'load-' . $hook_1, 'mp_add_screen_options' );
}

/**
 * Add screen options for product list page.
 */
function mp_add_product_screen_options() {
	$options = 'per_page';

	$args = array(
		'label'   => 'Product Per Page',
		'default' => 20,
		'option'  => 'product_per_page',
	);
	add_screen_option( $options, $args );
}

/**
 * Add screen options.
 */
function mp_add_screen_options() {
	$options = 'per_page';

	$args = array(
		'label'   => 'Template Per Page',
		'default' => 20,
		'option'  => 'template_per_page',
	);
	add_screen_option( $options, $args );
}

/**
 * Register settings.
 */
function marketplace_mp_login_reg_function() {
	register_setting( 'marketplace-settings-group', 'wkfb_mp_key_app_ID' );

	register_setting( 'marketplace-settings-group', 'wkfb_mp_app_secret_key' );

	register_setting( 'marketplace-settings-group', 'wkmpcom_minimum_com_onseller' );

	register_setting( 'marketplace-settings-group', 'wkmpseller_ammount_to_pay' );

	register_setting( 'marketplace-settings-group', 'wkmp_seller_menu_tile' );

	register_setting( 'marketplace-settings-group', 'wkmp_seller_page_title' );

	add_option( 'wkmp_seller_page_title', 'Seller', '', 'yes' );

	register_setting( 'marketplace-settings-group', 'wkmp_auto_approve_seller' );

	register_setting( 'marketplace-settings-group', 'wkmp_enable_seller_seperate_dashboard' );

	register_setting( 'marketplace-settings-group', 'wkmp_show_seller_seperate_form' );

	// assets settings.
	register_setting( 'marketplace-assets-settings-group', 'wkmp_show_seller_email' );

	register_setting( 'marketplace-assets-settings-group', 'wkmp_show_seller_contact' );

	register_setting( 'marketplace-assets-settings-group', 'wkmp_show_seller_address' );

	register_setting( 'marketplace-assets-settings-group', 'wkmp_show_seller_social_links' );

	// products setting for seller.
	register_setting( 'marketplace-products-settings-group', 'wkmp_seller_allow_publish' );

	register_setting( 'marketplace-products-settings-group', 'wkmp_seller_allowed_product_types' );

	register_setting( 'marketplace-products-settings-group', 'wkmp_seller_allowed_categories' );
}

/**
 * Product template.
 */
function product_layout() {
	add_filter( 'admin_footer_text', 'wk_mp_admin_footer_text' );
	require_once 'product.php';
}

/**
 * Seller tabs template.
 */
function seller_layout() {
	add_filter( 'admin_footer_text', 'wk_mp_admin_footer_text' );
	if ( isset( $_GET['action'] ) && isset( $_GET['sid'] ) && ! empty( $_GET['sid'] ) && $_GET['action'] == 'set' ) {
		require_once 'setcommision.php';
	} else {
		require_once 'sellerlist.php';
	}
}

/**
 * Commission tab layout.
 */
function commision_layout() {
	add_filter( 'admin_footer_text', 'wk_mp_admin_footer_text' );

	require_once 'commision.php';
}

/**
 * Settings tab template.
 */
function settings_layout() {
	add_filter( 'admin_footer_text', 'wk_mp_admin_footer_text' );
	require_once 'class-mp-admin-settings.php';
}

/**
 * Extension tab template.
 */
function extension_layout() {
	add_filter( 'admin_footer_text', 'wk_mp_admin_footer_text' );
	require_once 'class-mp-extensions.php';
}

/**
 * Email Templates Settings tab.
 */
function mp_email_templates() {
	if ( $_GET['page'] == 'class-email-templates' && isset( $_GET['action']) && $_GET['action'] == 'add' ) {
		require_once 'class-add-email-template.php';
	} elseif ( $_GET['page'] == 'class-email-templates' && isset( $_GET['preview_marketplace_mail'] ) && $_GET['preview_marketplace_mail'] == 'true' && isset( $_GET['id'] ) && ! empty( $_GET['id'] ) ) {
		apply_filters( 'woocommerce_mail_template_preview_mp', 'preview_marketplace_mail' );
	} else {
		require_once 'class-email-templates.php';
	}
	add_filter( 'admin_footer_text', 'wk_mp_admin_footer_text' );
}

/**
 * Notifictaion tab.
 */
function mp_notification_tab() {
	require_once 'class-mp-notifications.php';
	add_filter( 'admin_footer_text', 'wk_mp_admin_footer_text' );
}
/**
 * Admin footer text.
 *
 * @param string $text text for adin footer.
 */
function wk_mp_admin_footer_text( $text ) {
	return sprintf( __( 'If you like <strong>Marketplace</strong> please leave us a <a href="https://codecanyon.net/item/wordpress-woocommerce-marketplace-plugin/reviews/19214408" target="_blank" class="wc-rating-link" data-rated="Thanks :)">★★★★★</a> rating. A huge thanks in advance!', 'marketplace' ) );
}

/**
 * Add link to admin bar.
 *
 * @param boolean $admin_bar admin bar value.
 */
function mp_add_toolbar_items( $admin_bar ) {
	global $current_user;

	if ( in_array( 'administrator', $current_user->roles, true ) ) {
		require_once 'mp-notifications-bar.php';
	}
	if ( in_array( 'wk_marketplace_seller', $current_user->roles, true ) && get_option( 'wkmp_enable_seller_seperate_dashboard' ) ) {
		$admin_bar->add_menu( array(
			'id'    => 'mp-notification',
			'title' => __( 'Seller dashboard', 'marketplace' ),
			'meta'  => array(
				'title' => __( 'Seller dashboard', 'marketplace' ),
			),
		));
		$nonce = wp_create_nonce( 'ajaxnonce' );
		$admin_bar->add_menu( array(
			'parent' => 'mp-notification',
			'id'     => 'mp-seperate-seller-dashboard',
			'title'  => __( 'Default Seller Dashboard', 'marketplace' ),
			'href'   => '?_wp_nonce=' . $nonce,
		) );
	}
}

/**
 * Marketplace feedback tab.
 */
function mp_feedback_tab() {
	require_once WK_MARKETPLACE_DIR . 'includes/templates/admin/account/seller/review.php';
}

/**
 * Seller query tab.
 */
function mp_seller_query_tab() {
	add_filter( 'admin_footer_text', 'wk_mp_admin_footer_text' );

	require_once 'class-mp-seller-query.php';
}
