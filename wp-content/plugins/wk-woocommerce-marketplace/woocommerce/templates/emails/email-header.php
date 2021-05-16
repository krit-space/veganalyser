<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $current_email;

global $wpdb;

$heading = '';

$sql = "SELECT option_value FROM {$wpdb->prefix}options WHERE option_name = '$tableName'";

$results = $wpdb->get_results( $sql );

if ( ! empty( $results ) ) :
	$heading = maybe_unserialize( $results[0]->option_value )['heading'];
	$heading = ucwords( $heading );
endif;

if( empty( $heading ) )
	$heading = 'Welcome to ' . get_option( 'blogname' );

$result = '<!DOCTYPE html>
						<html>
							<head>
								<meta http-equiv="Content-Type" content="text/html;" />
								<title>' . get_bloginfo( 'name', 'display' ) . '</title>
							</head>
							<body ' . (is_rtl() ? "rightmargin" : "leftmargin") . ' ="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
						  <div id="content">
						   <table cellspacing="0" class="body-wrap" id="template_container">
							 <thead>
						    <tr>
					           <td><h1>' . $heading . '</h1></td>
						    </tr></thead>';
