<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package zadot
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function zadot_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'zadot_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function zadot_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'zadot_pingback_header' );

if ( ! function_exists( 'zadot_pagination' ) ) :
    function zadot_pagination( $paged = '', $max_page = '' )
    {
        $big = 999999999; // need an unlikely integer
        if( ! $paged )
            $paged = get_query_var('paged');
        if( ! $max_page )
            $max_page = $wp_query->max_num_pages;

        echo wp_kses(paginate_links( array(
            'base'       => str_replace($big, '%#%', esc_url(get_pagenum_link( $big ))),
            'format'     => '?paged=%#%',
            'current'    => max( 1, $paged ),
            'total'      => $max_page,
            'mid_size'   => 1,
            'prev_text'  => __('Previous', 'zadot'),
            'next_text'  => __('Next', 'zadot'),
            'type'       => 'list'
        ) ));
    }
endif;