<?php
/**
 * Bloguten functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @since Bloguten 1.0.0
 */

/**
 * Bloguten works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

function bloguten_scripts(){
	
	$style = array(
		'handler'  => 'bloguten-style',
		'style'    => get_stylesheet_uri(),
		'absolute' => true,
	);

	$kf_icons =  array(
		'handler' => 'kfi-icons',
		'style'   => 'kf-icons/css/style.css',
		'version' => '1.0.0'
	);

	$bootstrap_rtl = '';
	if ( is_rtl() ) {
		$bootstrap_rtl = array(
			'handler' => 'bootstrap-rtl',
			'style'   => 'bootstrap/css/rtl/bootstrap.min.css',
			'version' => '4.1.3'
		);
	}

	# Enqueue Vendor's Script & Style
	$scripts = array(
		array(
			'handler'  => 'bloguten-google-fonts',
			'style'    => esc_url( 'https://fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700,800,900|Playfair+Display:400,400italic,700,900'),
			'absolute' => true
		),
		array(
			'handler' => 'bootstrap',
			'style'   => 'bootstrap/css/bootstrap.min.css',
			'script'  => 'bootstrap/js/bootstrap.min.js', 
			'version' => '4.1.3'
		),
		$bootstrap_rtl,
		$kf_icons,
		array(
			'handler' => 'kfi-icons',
			'style'   => 'kf-icons/css/style.css',
			'version' => '1.0.0'
		),
		array(
			'handler' => 'owlcarousel',
			'style'   => 'OwlCarousel2-2.2.1/assets/owl.carousel.min.css',
			'script'  => 'OwlCarousel2-2.2.1/owl.carousel.min.js',
			'version' => '2.2.1'
		),
		array(
			'handler' => 'owlcarousel-theme',
			'style'   => 'OwlCarousel2-2.2.1/assets/owl.theme.default.min.css',
			'version' => '2.2.1'
		),
		array(
			'handler' => 'colorbox',
			'style'   => 'colorbox/css/colorbox.min.css',
			'script'  => 'colorbox/js/jquery.colorbox-min.js',
			'version' => '1.6.4'
		),
		array(
			'handler'  => 'bloguten-blocks',
			'style'    => get_theme_file_uri( '/assets/css/blocks.min.css' ),
			'absolute' => true,
		),
		array(
			'handler'    => 'bloguten-script',
			'script'     => get_theme_file_uri( '/assets/js/main.min.js' ),
			'absolute'   => true,
			'prefix'     => '',
			'dependency' => array( 'jquery', 'masonry' )
		),
		array(
			'handler'  => 'bloguten-skip-link-focus-fix',
			'script'   => get_theme_file_uri( '/assets/js/skip-link-focus-fix.min.js' ),
			'absolute' => true,
		),
		$style
	);

	bloguten_enqueue( apply_filters( 'bloguten_scripts_styles', $scripts ) );

	$locale = apply_filters( 'bloguten_localize_var', array(
		'is_admin_bar_showing'       => is_admin_bar_showing() ? true : false,
		'enable_scroll_top'          => bloguten_get_option( 'enable_scroll_top' ) ? 1 : 0,
		'is_rtl'                     => is_rtl(),
		'search_placeholder'         => esc_html__( 'hit enter for search.', 'bloguten' ),
		'search_default_placeholder' => esc_html__( 'search...', 'bloguten' ),
		'home_slider' => array(
			'autoplay' => bloguten_get_option( 'slider_autoplay' ),
			'timeout'  => absint( bloguten_get_option( 'slider_timeout' ) ) * 1000,
		),
	));

	wp_localize_script( 'bloguten-script', 'BLOGUTEN', $locale );

	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bloguten_scripts' );

/**
* Enqueue editor styles for Gutenberg
* 
* @since Bloguten 1.0.0
*/

function bloguten_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'bloguten-block-editor-style', get_theme_file_uri( '/assets/css/editor-blocks.min.css' ) );
	// Google Font
	wp_enqueue_style( 'bloguten-google-font', 'https://fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700,700i', false );
}
add_action( 'enqueue_block_editor_assets', 'bloguten_block_editor_styles' );

/**
* Adds a submit button in search form
* 
* @since Bloguten 1.0.0
* @param string $form
* @return string
*/
function bloguten_modify_search_form( $form ){
	return str_replace( '</form>', '<button type="submit" class="search-button"><span class="kfi kfi-search"></span></button></form>', $form );
}
add_filter( 'get_search_form', 'bloguten_modify_search_form' );

/**
* Modify some markup for comment section
*
* @since Bloguten 1.0.0
* @param array $defaults
* @return array $defaults
*/
function bloguten_modify_comment_form_defaults( $defaults ){

	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$defaults[ 'logged_in_as' ] = '<p class="logged-in-as">' . sprintf(
          /* translators: 1: edit user link, 2: accessibility text, 3: user name, 4: logout URL */
          __( '<a href="%1$s" aria-label="%2$s">Logged in as %3$s</a> <a href="%4$s">Log out?</a>', 'bloguten' ),
          get_edit_user_link(),
          /* translators: %s: user name */
          esc_attr( sprintf( __( 'Logged in as %s. Edit your profile.', 'bloguten' ), $user_identity ) ),
          $user_identity,
          wp_logout_url( apply_filters( 'the_permalink', get_permalink( get_the_ID() ) ) )
      ) . '</p>';
	return $defaults;
}
add_filter( 'comment_form_defaults', 'bloguten_modify_comment_form_defaults',99 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 *
 * @since Bloguten 1.0.0
 * @return void
 */
function bloguten_pingback_header(){
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'bloguten_pingback_header' );

/**
* Add a class in body when previewing customizer
*
* @since Bloguten 1.0.0
* @param array $class
* @return array $class
*/
function bloguten_body_class_modification( $class ){
	if( is_customize_preview() ){
		$class[] = 'keon-customizer-preview';
	}
	
	if( is_404() || ! have_posts() ){
 		$class[] = 'content-none-page';
	}

	if( bloguten_get_option( 'site_layout' ) == 'site_layout_full' ){

		$class[] = 'site-layout-full';
	}else if( bloguten_get_option( 'site_layout' ) == 'site_layout_box' ){

		$class[] = 'site-layout-box';
	}

	return $class;
}
add_filter( 'body_class', 'bloguten_body_class_modification' );

if( ! function_exists( 'bloguten_get_ids' ) ):
/**
* Fetches setting from customizer and converts it to an array
*
* @uses bloguten_explode_string_to_int()
* @return array | false
* @since Bloguten 1.0.0
*/
function bloguten_get_ids( $setting ){

    $str = bloguten_get_option( $setting );
    if( empty( $str ) )
    	return;

    return bloguten_explode_string_to_int( $str );

}
endif;

if( ! function_exists( 'bloguten_inner_banner' ) ):
/**
* Includes the template for inner banner
*
* @return void
* @since Bloguten 1.0.0
*/
function bloguten_inner_banner(){

	$description = false;

	if( is_archive() ){

		# For all the archive Pages.
		$title       = get_the_archive_title();
		$description = get_the_archive_description();
	}else if( !is_front_page() && is_home() ){

		# For Blog Pages.
		$title = single_post_title( '', false );
	}else if( is_search() ){

		# For search Page.
		$title = esc_html__( 'Search Results for: ', 'bloguten' ) . get_search_query();
	}else if( is_front_page() && is_home() ){
		# If Latest posts page
		
		$title = bloguten_get_option( 'archive_page_title' );
	}else{

		# For all the single Pages.
		$title = get_the_title();
	}

	$args = array(
		'title'       => $title,
		'description' => $description
	);

	/**
	 * Check WordPress 5.5 or later.
	 */
	if ( version_compare( $GLOBALS['wp_version'], '5.5', '<' ) ) {
		set_query_var( 'args', $args );
		get_template_part( 'template-parts/inner', 'banner' );
	}else {
		get_template_part( 'template-parts/inner', 'banner', $args );
	}

}
endif;

if( !function_exists( 'bloguten_get_icon_by_post_format' ) ):
/**
* Gives a css class for post format icon
*
* @return string
* @since Bloguten 1.0.0
*/
function bloguten_get_icon_by_post_format(){
	$icons = array(
		'standard' => 'kfi-pushpin-alt',
		'sticky'   => 'kfi-pushpin-alt',
		'aside'    => 'kfi-documents-alt',
		'image'    => 'kfi-image',
		'video'    => 'kfi-arrow-triangle-right-alt2',
		'quote'    => 'kfi-quotations-alt2',
		'link'     => 'kfi-link-alt',
		'gallery'  => 'kfi-images',
		'status'   => 'kfi-comment-alt',
		'audio'    => 'kfi-volume-high-alt',
		'chat'     => 'kfi-chat-alt',
	);

	$format = get_post_format();
	if( empty( $format ) ){
		$format = 'standard';
	}

	return apply_filters( 'bloguten_post_format_icon', $icons[ $format ] );
}
endif;

if( !function_exists( 'bloguten_has_sidebar' ) ):

/**
* Check whether the page has sidebar or not.
*
* @see https://codex.wordpress.org/Conditional_Tags
* @since Bloguten 1.0.0
* @return bool Whether the page has sidebar or not.
*/
function bloguten_has_sidebar(){

	if( is_page() || is_search() || is_single() ){
		return false;
	}

	return true;
}
endif;

/**
* Check whether the sidebar is active or not.
*
* @see https://codex.wordpress.org/Conditional_Tags
* @since Bloguten 1.0.0
* @return bool whether the sidebar is active or not.
*/
function bloguten_is_active_footer_sidebar(){

	for( $i = 1; $i <= 4; $i++ ){
		if ( is_active_sidebar( 'bloguten-footer-sidebar-'.$i ) ) : 
			return true;
		endif;
	}
	return false;
}

if( !function_exists( 'bloguten_is_search' ) ):
/**
* Conditional function for search page / jet pack supported
* @since Bloguten 1.0.0
* @return Bool 
*/

function bloguten_is_search(){

	if( ( is_search() || ( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'infinite_scroll'  && isset( $_POST[ 'query_args' ][ 's' ] ))) ){
		return true;
	}

	return false;
}
endif;

function bloguten_post_class_modification( $classes ){

	# Add no thumbnail class when its search page
	if( bloguten_is_search() && ( 'post' !== get_post_type() && !has_post_thumbnail() ) ){
		$classes[] = 'no-thumbnail';
	}
	return $classes;
}
add_filter( 'post_class', 'bloguten_post_class_modification' );

require_once get_parent_theme_file_path( '/inc/setup.php' );
require_once get_parent_theme_file_path( '/inc/template-tags.php' );
require_once get_parent_theme_file_path( '/modules/loader.php' );
require_once get_parent_theme_file_path( '/trt-customize-pro/doc-link/class-customize.php' );
require_once get_parent_theme_file_path( '/modules/tgm-plugin-activation/loader.php' );
require_once get_parent_theme_file_path( '/theme-info/theme-info.php' );

/**
* Change menu, front page display as in demo after completing demo import
* @link https://wordpress.org/plugins/one-click-demo-import/
* @since Bloguten 1.0.0
* @return null
*/
function bloguten_ocdi_after_import_setup() {

    // Assign menus to their locations.
    $primary_menu   = get_term_by('name', 'Primary Menu', 'nav_menu');
    $secondary_menu = get_term_by('name', 'Secondary Menu', 'nav_menu');
    $social_menu    = get_term_by('name', 'Social Menu', 'nav_menu');
    $footer_menu    = get_term_by('name', 'Footer Menu', 'nav_menu');
    set_theme_mod( 'nav_menu_locations' , array( 
          'primary'    => $primary_menu->term_id,
          'secondary'  => $secondary_menu->term_id,
          'social'     => $social_menu->term_id,
          'footer'     => $footer_menu->term_id
         ) 
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Front' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'bloguten_ocdi_after_import_setup' );

/**
* Disable branding of One Click Demo Import
* @link https://wordpress.org/plugins/one-click-demo-import/
* @since Bloguten 1.0.0
* @return Bool
*/
function bloguten_ocdi_branding(){
	return true;
}
add_filter( 'pt-ocdi/disable_pt_branding', 'bloguten_ocdi_branding' );

/**
* Change number or products per row to 3
* @since Bloguten 1.0.0
*/

add_filter('loop_shop_columns', 'loop_columns');
	if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}

/**
* Allow skype protocols for social menu
* @since Bloguten 1.0.0
*/

function ss_allow_skype_protocol( $protocols ){
    $protocols[] = 'skype';
    return $protocols;
}
add_filter( 'kses_allowed_protocols' , 'ss_allow_skype_protocol' );

/**
* Add a wrapper div to Woocommerce product
* @since Bloguten 1.0.0
*/

function bloguten_before_shop_loop_item(){
	echo '<div class="product-inner">';
}

add_action( 'woocommerce_before_shop_loop_item', 'bloguten_before_shop_loop_item', 9 );

function bloguten_after_shop_loop_item(){
	echo '</div>';
}

add_action( 'woocommerce_after_shop_loop_item', 'bloguten_after_shop_loop_item', 11 );

/**
 * To remove kfi-icon from breadcrumb.
 *
 * @param array $items Breadcrumb items.
 * @param array $args Breadcrumb args.
 *
 * @since Bloguten 1.0.0
 * @return array
 */

function bloguten_breadcrumb_items( $items, $args ) {
	end($items);   
	$key = key($items);
	$last_item = $items[$key];
	$last_item = explode( '|', $last_item );
	$last_item = isset( $last_item[0] ) ? $last_item[0] : '';
	$items[ $key ] = $last_item;
	return $items;
}
add_filter( 'breadcrumb_trail_items', 'bloguten_breadcrumb_items', 10, 2 );

/**
 * To disable archive prefix title.
 * @since Bloguten 1.0.0
 */

function bloguten_modify_archive_title( $title ) {
	if( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
    } elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>' ;
    } elseif ( is_year() ) {
        $title = get_the_date( _x( 'Y', 'yearly archives date format', 'bloguten' ) );
    } elseif ( is_month() ) {
        $title = get_the_date( _x( 'F Y', 'monthly archives date format', 'bloguten' ) );
    } elseif ( is_day() ) {
        $title = get_the_date( _x( 'F j, Y', 'daily archives date format', 'bloguten' ) );
     } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }

	return $title;
}

add_filter( 'get_the_archive_title', 'bloguten_modify_archive_title' );

// temporary exceprt function
function wpdocs_custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

