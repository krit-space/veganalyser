<?php
/**
* Sets the panels and returns to Bloguten_Customizer
*
* @since  Bloguten 1.0.0
* @param  array An array of the panels
* @return array
*/
function Bloguten_Customizer_Panels( $panels ){

	$panels = array(
		'fonts' => array(
			'title' => esc_html__( 'Fonts', 'bloguten' ),
			'priority' => 60
		),
		'theme_options' => array(
			'title' => esc_html__( 'Theme Options', 'bloguten' ),
			'priority' => 100
		)
	);

	return $panels;	
}
add_filter( 'Bloguten_Customizer_Panels', 'Bloguten_Customizer_Panels' );