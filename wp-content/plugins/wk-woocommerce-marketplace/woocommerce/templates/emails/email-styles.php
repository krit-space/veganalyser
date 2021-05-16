<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

// !important; is a gmail hack to prevent styles being stripped if it doesn't like something.

global $wpdb;

$sql = "SELECT option_value FROM {$wpdb->prefix}options WHERE option_name = '$option'";

$results = $wpdb->get_results( $sql );

$res = '';

if ( $results ) {
	$res = maybe_unserialize( $results[0]->option_value )['email_template'];
}

if ( $option == 'preview_marketplace_mail' ) {
	$id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT );
	$sql = $wpdb->prepare("SELECT title FROM {$wpdb->prefix}emailTemplate WHERE id = '%s'", $id);

	$results = $wpdb->get_results( $sql );

	if ( $results) {
		$res = $results[0]->title;
	}
}

if ( $res && ( $res == NULL || $res != '-1') ) {
	$query = "SELECT * FROM {$wpdb->prefix}emailTemplate WHERE title='$res' and status = 'publish'";
	$result = $wpdb->get_results($query);

	 if ( $result ) {
		 $result = $result[0];
		 $backgroundcolor = $result->backgroundcolor;
		 $base = $result->basecolor;
		 $textcolor = $result->textcolor;
		 $body = $result->bodycolor;
		 $width_page = '600px';
		 if( $backgroundcolor == $textcolor ) {
			 $txt = 'white';
		 }

		 // Load colours
		 $bg              = $backgroundcolor;
		 $body            = $body;
		 $base            = $base;
		 $base_text       = wc_light_or_dark( $base, '#202020', '#ffffff' );
		 $text            = $textcolor;

		 $bg_darker_10    = wc_hex_darker( $bg, 10 );
		 $body_darker_10  = wc_hex_darker( $body, 10 );
		 $base_lighter_20 = wc_hex_lighter( $base, 20 );
		 $base_lighter_40 = wc_hex_lighter( $base, 40 );
		 $text_lighter_20 = wc_hex_lighter( $text, 20 );
	 } else {
		 $base = '#8a8a8a';
		 $text = '#3c3c3c';
		 $body = '#ffffff';
		 $base_text       = wc_light_or_dark( $base, '#202020', '#ffffff' );
		 $base_lighter_20 = wc_hex_lighter( $base, 20 );
	 	 $backgroundcolor ='#f7f7f7';
	 	 $bg_darker_10    = wc_hex_darker( '#999', 10 );
		 $text_lighter_20 = wc_hex_lighter( $text, 20 );
	 	 $width_page = '600px';
	 }

} else {
	$base = '#8a8a8a';
	$text = '#3c3c3c';
	$body = '#ffffff';
	$base_text       = wc_light_or_dark( $base, '#202020', '#ffffff' );
	$base_lighter_20 = wc_hex_lighter( $base, 20 );
	$backgroundcolor ='#f7f7f7';
	$bg_darker_10    = wc_hex_darker( '#999', 10 );
	$text_lighter_20 = wc_hex_lighter( $text, 20 );
	$width_page = '600px';
}

ob_start();

?>

#content {
	background-color: <?php echo esc_attr( $backgroundcolor ); ?>;
	margin: 0;
	padding: 70px 0 70px 0;
	-webkit-text-size-adjust: none !important;
	width: 100%;
}

#template_container {
	box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important;
	background-color: <?php echo esc_attr( $body ); ?>;
	border: 1px solid <?php echo esc_attr( $bg_darker_10 ); ?>;
	border-radius: 3px !important;
	margin: auto;
	width: <?php echo $width_page; ?>;
}

#template_container thead {
	background-color: <?php echo esc_attr( $base ); ?>;
	border-radius: 3px 3px 0 0 !important;
	color: <?php echo esc_attr( $base_text ); ?>;
	border-bottom: 0;
	font-weight: bold;
	line-height: 100%;
	vertical-align: middle;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}

#template_container thead h1,
#template_container thead h1 a {
	color: <?php echo esc_attr( $base_text ); ?>;
}

#template_container thead td, #template_container td#body_content_inner {
	padding: 36px 48px;
	display: block;
}

#content table td.th {
	font-weight: 600;
}

#content table.order-details, #content table#addresses {
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

#content table.order-details, #content table#addresses h3 {
	font-weight: bold;
	margin-bottom: 5px;
}

#content table.order-details td, #content table#addresses td {
	display: table-cell !important;
	width: auto;
	padding: 8px 0;
}

#content table th {
	background-color:<?php echo $backgroundcolor; ?>;
	padding:0px;
}

#body_content_inner p {
	margin: 0 0 16px;
}

#body_content_inner, #body_content_inner span, #addresses p {
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 14px;
	line-height: 150%;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

td.tfooter {
	color: <?php echo esc_attr( $base ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 14px;
	text-align: center;
	padding: 0 48px 48px 48px;
}

.td {
	color: <?php echo esc_attr( $base ); ?>;
}

.text {
	color: <?php echo esc_attr( $base ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}

.link {
	color: <?php echo esc_attr( $base ); ?>;
}

h1 {
	color: <?php echo esc_attr( $base ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 30px;
	font-weight: 300;
	line-height: 150%;
	margin: 0;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
	text-shadow: 0 1px 0 <?php echo esc_attr( $base_lighter_20 ); ?>;
	-webkit-font-smoothing: antialiased;
}

h2 {
	color: <?php echo esc_attr( $base ); ?>;
	display: block;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 18px;
	font-weight: bold;
	line-height: 130%;
	margin: 16px 0 8px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

h3 {
	color: <?php echo esc_attr( $base ); ?>;
	display: block;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 16px;
	font-weight: bold;
	line-height: 130%;
	margin: 16px 0 8px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

a {
	color: <?php echo esc_attr( $base ); ?>;
	font-weight: normal;
	text-decoration: underline;
}

img {
	border: none;
	display: inline;
	font-size: 14px;
	height: auto;
	line-height: 100%;
	outline: none;
	text-decoration: none;
	text-transform: capitalize;
}

<?php
 $email_css = ob_get_clean();
 return $email_css;
