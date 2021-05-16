<?php
/**
* Generates default options for customizer.
*
* @since  Bloguten 1.0.0
* @access public
* @param  array $options 
* @return array
*/
	
function Bloguten_Default_Options( $options ){

	$defaults = array(
		# Site Identity
		'site_title'         	         => esc_html__( 'Bloguten', 'bloguten' ),
		'site_tagline'       	         => esc_html__( 'Blogging should be fun', 'bloguten' ),
		'site_identity_options'          => 'site_identity_show_all',

		# Color
		'site_title_color'   	         => '#1a1a1a',
		'site_tagline_color' 	         => '#4d4d4d',
		'site_body_text_color'   	     => '#6e6e6e',
		'site_primary_color' 	         => '#FC4544',
		'site_hover_color' 	             => '#484788',

		# Theme options
		# Header
		'header_layout'                  => 'header_one',
		'disable_search_icon'            => false,
		'disable_hamburger_menu_icon'    => false,
		'disable_fixed_header'           => false,

		# Footer
		'footer_layout'                  => 'footer_one',
		'disable_footer_widget'          => false,
		'footer_text'                    => bloguten_get_footer_text(),

		# Layout
		'site_layout'			         => 'site_layout_full',
		'archive_layout'			     => 'right',
		'archive_post_layout'            => 'grid',
		'single_layout'			         => 'right',
		'page_layout'			         => 'none',

		# Archive
		// Slider
		'slider_type'    	 			 => 'box',
		'slider_layout'    	 			 => 'slider_layout_one',
		'slider_overlay_opacity'    	 => 3,
		'slider_content_alignment'    	 => 'center',
		'disable_slider_control'     	 => false,
		'slider_timeout'     	         => 5,
		'slider_autoplay'    	         => false,
		'slider_button_text'    	     => esc_html__( 'Learn More', 'bloguten' ),
		'slider_posts_number'    	     => 3,
		'disable_slider'    	         => false,

		'archive_page_title'			 => esc_html__( 'Welcome to Bloguten', 'bloguten' ),
		'disable_archive_cat_link'       => false,
		'disable_archive_date'           => false,
		'disable_archive_author'         => false,
		'disable_archive_comment_link'   => false,
		'excerpt_length'                 => 0,
		'disable_pagination'             => false,

		# Single
		'disable_single_date'            => false,
		'disable_single_post_format'     => false,
		'disable_single_tag_links'       => false,
		'disable_single_cat_links'       => false,
		'disable_single_author'          => false,
		'disable_single_title_tag'       => false,
		'single_post_nav_prev'           => esc_html__( 'Previous Reading', 'bloguten' ),
		'single_post_nav_next'           => esc_html__( 'Next Reading', 'bloguten' ),

		# Page
		'disable_front_page_title'       => true,
		'disable_page_feature_image'     => false,

		# General
		'site_loader_options'            => 'site_loader_one',
		'disable_site_loader'            => false,
		'enable_scroll_top'              => true,
		'page_header_layout'             => 'header_layout_one',
		'breadcrumb_separator_layout'    => 'separator_layout_one',
		'enable_breadcrumb_home_icon'    => true,
		'disable_bradcrumb'              => false,
		'enable_instagram'               => true,
	);

	return array_merge( $options, $defaults );
}
add_filter( 'Bloguten_Customizer_Defaults', 'Bloguten_Default_Options' );

if( !function_exists( 'bloguten_get_footer_text' ) ):
/**
* Generate Default footer text
*
* @return string
* @since Bloguten 1.0.0
*/

function bloguten_get_footer_text(){
	$text = esc_html__( 'Copyright &copy;', 'bloguten' );
							
	return $text;
}
endif;