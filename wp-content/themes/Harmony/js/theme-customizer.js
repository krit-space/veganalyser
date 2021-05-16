/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	wp.customize( 'et_harmony[link_color]', function( value ) {
		value.bind( function( to ) {
			var style_id = '#et_link_color',
				$style_content = "<style id='et_link_color'>\
									a { color: " + to + "; }\
								</style>";

			if ( $( style_id ).length ) {
				$( style_id ).replaceWith( $style_content );
			} else {
				$( 'head' ).append( $style_content );
			}
		} );
	} );

	wp.customize( 'et_harmony[font_color]', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css( 'color', to );
		} );
	} );

	wp.customize( 'et_harmony[logo_color]', function( value ) {
		value.bind( function( to ) {
			$( '#main-header h1, #main-header h2' ).css( 'color', to );
		} );
	} );
} )( jQuery );