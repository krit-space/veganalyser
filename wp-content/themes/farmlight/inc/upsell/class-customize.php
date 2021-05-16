<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */

require get_template_directory() . '/inc/upsell/section-pro.php';

final class farmlight_Customize {

	// Returns the instance.
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	// Constructor method.
	private function __construct() {}

	// Sets up initial actions.
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	// Sets up the customizer sections.
	public function sections( $manager ) {

		// Load custom sections.

		// Register custom section types.
		$manager->register_section_type( 'farmlight_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new farmlight_Customize_Section_Pro(
				$manager,
				'farmlight',
				array(
					'title'    => esc_html__( 'FarmPro', 'farmlight' ),
					'pro_text' => esc_html__( 'Upgrade to Pro', 'farmlight' ),
					'pro_url'  => esc_url( 'https://customizablethemes.com/product/farmpro' )
				)
			)
		);
	}

	// Loads theme customizer CSS.
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'farmlight-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/upsell/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'farmlight-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/upsell/customize-controls.css' );
	}
}

// Doing this customizer thang!
farmlight_Customize::get_instance();

if ( ! function_exists( 'farmlight_customize_register' ) ) :
	/**
	 * Add postMessage support for site title and description for the Theme Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function farmlight_customize_register( $wp_customize ) {

		/**
		 * Add Footer Section
		 */
		$wp_customize->add_section(
			'farmlight_footer_section',
			array(
				'title'       => __( 'Footer', 'farmlight' ),
				'capability'  => 'edit_theme_options',
			)
		);
		
		// Add Footer Copyright Text
		$wp_customize->add_setting(
			'farmlight_footer_copyright',
			array(
			    'default'           => '',
			    'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'farmlight_footer_copyright',
	        array(
	            'label'          => __( 'Copyright Text', 'farmlight' ),
	            'section'        => 'farmlight_footer_section',
	            'settings'       => 'farmlight_footer_copyright',
	            'type'           => 'text',
	            )
	        )
		);
	}
endif; // farmlight_customize_register
add_action( 'customize_register', 'farmlight_customize_register' );
