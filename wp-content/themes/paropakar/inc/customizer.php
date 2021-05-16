<?php
/**
 * New Theme: Customizer
 *
 * @package WordPress
 * @subpackage Paropakar_Theme
 * @since 1.0
 */

/**
 * Return whether we're previewing the front page and it's a static page.
 */
function paropakar_is_static_front_page() {
	return ( is_front_page() && ! is_home() );
}

/**
 * Function ffor customizer
 *
 * @param array $wp_customize wp_customizer for class object.
 */
function paropakar_theme_customizer( $wp_customize ) {

	$wp_customize->add_panel(
		'paropakar_theme_options',
		array(
			'priority'       => 30,
			'theme_supports' => '',
			'title'          => __( 'Paropakar Theme Options', 'paropakar' ),
			'description'    => __( 'Several settings of Paropakar Theme', 'paropakar' ),
		)
	);

	/**
	 * Paropakar Header Background Image
	 */
	$wp_customize->add_setting(
		'paropakar_header_img',
		array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'paropakar_sanitize_file',
		)
	);

	$wp_customize->add_section(
		'paropakar_header_img_upload',
		array(
			'title'    => __( 'Header Background Image', 'paropakar' ),
			'priority' => 30,
			'panel'    => 'paropakar_theme_options',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'paropakar_header_img',
			array(
				'label'    => __( 'Upload Header Background Image', 'paropakar' ),
				'section'  => 'paropakar_header_img_upload',
				'settings' => 'paropakar_header_img',
			)
		)
	);

	/**
	 * Paropakar Header Image Slider
	*/

	$wp_customize->add_section(
		'paropakar_header_slider',
		array(
			'title'    => __( 'Header Slider', 'paropakar' ),
			'priority' => 30,
			'panel'    => 'paropakar_theme_options',
		)
	);

	$wp_customize->add_setting(
		'paropakar_slider_activation',
		array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'paropakar_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'paropakar_slider_activation',
		array(
			'label'    => __( 'Check to turn on image slider ( If unchecked, header background image will be shown.)', 'paropakar' ),
			'section'  => 'paropakar_header_slider',
			'settings' => 'paropakar_slider_activation',
			'type'     => 'checkbox',
		)
	);

	for ( $count = 1;  $count <= 3;$count++ ) :
		$wp_customize->add_setting(
			'paropakar_header_slider_' . $count,
			array(
				'default'           => '0',
				'transport'         => 'refresh',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'paropakar_header_slider_image_' . $count,
			array(
				'label'    => __( 'Select A Page For Slider Image', 'paropakar' ),
				'section'  => 'paropakar_header_slider',
				'settings' => 'paropakar_header_slider_' . $count,
				'type'     => 'dropdown-pages',
			)
		);
	endfor;

	/**
	 * Paropakar Services
	 */

	$wp_customize->add_section(
		'paropakar_services_section',
		array(
			'title'    => __( 'Services', 'paropakar' ),
			'priority' => 30,
			'panel'    => 'paropakar_theme_options',
		)
	);

	$wp_customize->add_setting(
		'paropakar_services_page',
		array(
			'default'           => '0',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'paropakar_services_heading',
		array(
			'type'     => 'dropdown-pages',
			'label'    => __( 'Select A Page For Service Description', 'paropakar' ),
			'section'  => 'paropakar_services_section',
			'settings' => 'paropakar_services_page',
		)
	);

	for ( $count = 1; $count <= 3; $count++ ) :
		$wp_customize->add_setting(
			'paropakar_services_setting_' . $count,
			array(
				'default'           => '0',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'paropakar_services_pages' . $count,
			array(
				'type'     => 'dropdown-pages',
				'label'    => __( 'Select A Page For Service', 'paropakar' ),
				'section'  => 'paropakar_services_section',
				'settings' => 'paropakar_services_setting_' . $count,
			)
		);
	endfor;

	/**
	 * Paropakar Donation
	 */

	$wp_customize->add_section(
		'paropakar_donation',
		array(
			'title'    => __( 'Donations', 'paropakar' ),
			'priority' => 30,
			'panel'    => 'paropakar_theme_options',
		)
	);

	$wp_customize->add_setting(
		'paropakar_donation_setting',
		array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'paropakar_donation_page',
		array(
			'label'    => __( 'Select A Page For Donation', 'paropakar' ),
			'section'  => 'paropakar_donation',
			'settings' => 'paropakar_donation_setting',
			'type'     => 'dropdown-pages',
		)
	);

	/**
	 * Paropakar Footer Options
	*/

	$wp_customize->add_section(
		'paropakar_footer',
		array(
			'title'    => __( 'Footer Options', 'paropakar' ),
			'priority' => 30,
			'panel'    => 'paropakar_theme_options',
		)
	);

	$wp_customize->add_setting(
		'paropakar_to_the_top',
		array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'paropakar_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'paropakar_to_the_top',
		array(
			'label'    => __( 'Check to turn on to the top option', 'paropakar' ),
			'section'  => 'paropakar_footer',
			'settings' => 'paropakar_to_the_top',
			'type'     => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'paropakar_show_footer_copyright',
		array(
			'transport'         => 'refresh',
			'sanitize_callback' => 'paropakar_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'paropakar_show_footer_copyright',
		array(
			'label'    => __( 'Check to show copyright link', 'paropakar' ),
			'section'  => 'paropakar_footer',
			'settings' => 'paropakar_show_footer_copyright',
			'type'     => 'checkbox',
		)
	);

	/**
	 * Paropakar Footer Client Logo Slider
	 */

	$wp_customize->add_section(
		'paropakar_client_logo',
		array(
			'title'    => __( 'Client Logo', 'paropakar' ),
			'priority' => 30,
			'panel'    => 'paropakar_theme_options',
		)
	);

	for ( $count = 1; $count <= 6; $count++ ) :
		$wp_customize->add_setting(
			'paropakar_client_logo_setting_' . $count,
			array(
				'default'           => 'select',
				'transport'         => 'refresh',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'paropakar_client_logo_' . $count,
			array(
				'label'    => __( 'Select A Page For Client Logo', 'paropakar' ),
				'section'  => 'paropakar_client_logo',
				'settings' => 'paropakar_client_logo_setting_' . $count,
				'type'     => 'dropdown-pages',
			)
		);
	endfor;

	/**
	 * Side-Bar Option Customization
	 */

	$wp_customize->add_section(
		'paropakar_sidebar_option',
		array(
			'title'    => __( 'Sidebar Option', 'paropakar' ),
			'priority' => 30,
			'panel'    => 'paropakar_theme_options',
		)
	);

	$wp_customize->add_setting(
		'paropakar_sidebar_option',
		array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'paropakar_sanitize_key',
		)
	);

	$wp_customize->add_control(
		'paropakar_sidebar_option',
		array(
			'label'    => __( 'Select Your Sidebar Option', 'paropakar' ),
			'section'  => 'paropakar_sidebar_option',
			'settings' => 'paropakar_sidebar_option',
			'type'     => 'radio',
			'choices'  => array(
				'null'  => __( 'Without Sidebar', 'paropakar' ),
				'left'  => __( 'Left Sidebar', 'paropakar' ),
				'right' => __( 'Right Sidebar', 'paropakar' ),
			),
		)
	);

	/**
	 * Paropakar Client Testimonial
	 */

	$wp_customize->add_section(
		'paropakar_client_testimonial',
		array(
			'title'    => __( 'Client Testimonial', 'paropakar' ),
			'priority' => 30,
			'panel'    => 'paropakar_theme_options',
		)
	);

	for ( $count = 1; $count <= 6; $count++ ) :
		$wp_customize->add_setting(
			'paropakar_testimonial_setting_' . $count,
			array(
				'default'           => 'select',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'paropakar_client_page_' . $count,
			array(
				'label'    => __( 'Select A Page For Client', 'paropakar' ),
				'section'  => 'paropakar_client_testimonial',
				'settings' => 'paropakar_testimonial_setting_' . $count,
				'type'     => 'dropdown-pages',
			)
		);
	endfor;
}
add_action( 'customize_register', 'paropakar_theme_customizer' );



/**
 * Bind JS handlers to instantly live-preview changes.
 */
function paropakar_customize_preview_js() {
	wp_enqueue_script( 'paropakar-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'paropakar_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function paropakar_panels_js() {
	wp_enqueue_script( 'paropakar-customize-controls', get_theme_file_uri( '/assets/js/customize-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'paropakar_panels_js' );


/**
 * Adds custom classes to the menu.
 *
 * @param array $input Classes for a element.
 * @param array $setting Classes for a element.
 * @return array
 */
function paropakar_sanitize_key( $input, $setting ) {

	$data    = sanitize_key( $input );
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return( array_key_exists( $data, $choices ) ? $data : $setting->default );
}

/**
 * Function for sanatizing database inputs
 *
 * @param array $checked Classes for a element.
 * @return array
 */
function paropakar_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}


/**
 * Function for sanatizing database inputs
 *
 * @param array $file Classes for a element.
 * @param array $setting Classes for a element.
 * @return array
 */
function paropakar_sanitize_file( $file, $setting ) {
	// allowed file types.
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'gif'          => 'image/gif',
		'png'          => 'image/png',
	);

	// check file type from file name.
	$file_ext = wp_check_filetype( $file, $mimes );

	// if file has a valid mime type return it, otherwise return default.
	return ( $file_ext['ext'] ? $file : $setting->default );
}
