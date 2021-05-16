<?php

/*
Plugin Name: Remove Category Word From Title
Description: This plugin allows the admin to hide the word 'Category' from all the page titles.
Version: 1.0.0
Author: Ausaf Malik
Author URI: http://www.onlinewebguru.com/ausaf-developer/
License: GPLv2+
Text Domain: remove-category-word-from-title
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//Constants used in the plugin
define( 'RCFT_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'RCFT_PLUGIN_URL', plugin_dir_url(__FILE__) );

//Include needed files on init
add_action( 'init', 'include_rcft_file' );
function include_rcft_file() {
	$include_rcft_file = 'inc/rcft-functions.php';
	include $include_rcft_file;
}

?>