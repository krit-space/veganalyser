<?php
/**
 * FarmLight public scripts
 *
 * @package FarmLight
 * @since   FarmLight 1.0.0.
 */

if ( ! function_exists( 'farmlight_load_scripts' ) ) :
	/**
	 * the main function to load scripts in the farmlight theme
	 * if you add a new load of script, style, etc. you can use that function
	 * instead of adding a new wp_enqueue_scripts action for it.
	 */
	function farmlight_load_scripts() {

		// load main stylesheet.
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css', array( ) );
		wp_enqueue_style( 'farmlight-style', get_stylesheet_uri(), array() );
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_script( 'farmlight-utilities',
			get_template_directory_uri() . '/assets/js/utilities.js',
			array( 'jquery', ) );
	}
endif; // farmlight_load_scripts
add_action( 'wp_enqueue_scripts', 'farmlight_load_scripts' );
