<?php
/**
* Load widget components
*
* @since Bloguten 1.0.0
*/
require_once get_parent_theme_file_path( '/modules/widgets/class-base-widget.php' );
require_once get_parent_theme_file_path( '/modules/widgets/author.php' );
/**
 * Register widgets
 *
 * @since Bloguten 1.0.0
 */
/**
* Load all the widgets
* @since Bloguten 1.0.0
*/
function bloguten_register_widget() {

	$widgets = array(
		'Bloguten_Author_Widget',
	);

	foreach ( $widgets as $key => $value) {
    	register_widget( $value );
	}
}
add_action( 'widgets_init', 'bloguten_register_widget' );

