<?php
/**
* Sets sections for Bloguten_Customizer
*
* @since  Bloguten 1.0.0
* @param  array $sections
* @return array Merged array
*/
function Bloguten_Customizer_Sections( $sections ){

	$bloguten_sections = array(
		# Section for Font panel
		'font_family' => array(
			'title' => esc_html__( 'Font Family', 'bloguten' ),
			'panel' => 'fonts'
		),
		'font_size' => array(
			'title' => esc_html__( 'Font Size', 'bloguten' ),
			'panel' => 'fonts'
		),

		# Section for Theme Options panel
		'header_options' => array(
			'title' => esc_html__( 'Header Options', 'bloguten' ),
			'panel' => 'theme_options'
		),
		'footer_options' => array(
			'title' => esc_html__( 'Footer Options', 'bloguten' ),
			'panel' => 'theme_options'
		),
		'layout_options' => array(
			'title' => esc_html__( 'Layout Options', 'bloguten' ),
			'panel' => 'theme_options'
		),
		'archive_options' => array(
			'title' => esc_html__( 'Archive Page Options', 'bloguten' ),
			'panel' => 'theme_options'
		),
		'single_options' => array(
			'title' => esc_html__( 'Single Page Options', 'bloguten' ),
			'panel' => 'theme_options'
		),
		'page_options' => array(
			'title' => esc_html__( 'Page Options', 'bloguten' ),
			'panel' => 'theme_options'
		),
		'general_options' => array(
			'title' => esc_html__( 'General Options', 'bloguten' ),
			'panel' => 'theme_options'
		)
	);

	return array_merge( $bloguten_sections, $sections );
}
add_filter( 'Bloguten_Customizer_Sections', 'Bloguten_Customizer_Sections' );