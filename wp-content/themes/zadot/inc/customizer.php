<?php
/**
 * zadot Theme Customizer
 *
 * @package zadot
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function zadot_customize_register( $wp_customize ) {

	global $zadotPostsPagesArray, $zadotYesNo, $zadotSliderType, $zadotServiceLayouts, $zadotAvailableCats, $zadotBusinessLayoutType;

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'zadot_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'zadot_customize_partial_blogdescription',
		) );
	}
	
	$wp_customize->add_panel( 'zadot_general', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'      => __('General Settings', 'zadot'),
		'active_callback' => '',
	) );

	$wp_customize->get_section( 'title_tagline' )->panel = 'zadot_general';
	$wp_customize->get_section( 'background_image' )->panel = 'zadot_general';
	$wp_customize->get_section( 'background_image' )->title = __('Site background', 'zadot');
	$wp_customize->get_section( 'header_image' )->panel = 'zadot_general';
	$wp_customize->get_section( 'header_image' )->title = __('Header Settings', 'zadot');
	$wp_customize->get_control( 'header_image' )->priority = 20;
	$wp_customize->get_control( 'header_image' )->active_callback = 'zadot_show_wp_header_control';	
	$wp_customize->get_section( 'static_front_page' )->panel = 'zadot_zadot_business_page';
	$wp_customize->get_section( 'static_front_page' )->title = __('Select frontpage type', 'zadot');
	$wp_customize->get_section( 'static_front_page' )->priority = 9;
	$wp_customize->remove_section('colors');
	$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
			$wp_customize, 
			'background_color', 
			array(
				'label'      => __( 'Background Color', 'zadot' ),
				'section'    => 'background_image',
				'priority'   => 9
			) ) 
	);
	//$wp_customize->remove_section('static_front_page');	
	//$wp_customize->remove_section('header_image');	

	/* Upgrade */	
	$wp_customize->add_section( 'zadot_business_upgrade', array(
		'priority'       => 8,
		'capability'     => 'edit_theme_options',
		'title'      => __('Upgrade to PRO', 'zadot'),
		'active_callback' => '',
	) );		
	$wp_customize->add_setting( 'zadot_show_sliderr',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);	
	$wp_customize->add_control( new zadot_Customize_Control_Upgrade(
		$wp_customize,
		'zadot_show_sliderr',
		array(
			'label'      => __( 'Show headerr?', 'zadot' ),
			'settings'   => 'zadot_show_sliderr',
			'priority'   => 10,
			'section'    => 'zadot_business_upgrade',
			'choices' => '',
			'input_attrs'  => 'yes',
			'active_callback' => ''			
		)
	) );
	
	/* Usage guide */	
	$wp_customize->add_section( 'zadot_business_usage', array(
		'priority'       => 9,
		'capability'     => 'edit_theme_options',
		'title'      => __('Theme Usage Guide', 'zadot'),
		'active_callback' => '',
	) );		
	$wp_customize->add_setting( 'zadot_show_sliderrr',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);	
	$wp_customize->add_control( new zadot_Customize_Control_Guide(
		$wp_customize,
		'zadot_show_sliderrr',
		array(

			'label'      => __( 'Show headerr?', 'zadot' ),
			'settings'   => 'zadot_show_sliderrr',
			'priority'   => 10,
			'section'    => 'zadot_business_usage',
			'choices' => '',
			'input_attrs'  => 'yes',
			'active_callback' => ''				
		)
	) );
	
	/* Header Section */
	$wp_customize->add_setting( 'zadot_show_slider',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'zadot_sanitize_yes_no_setting',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'zadot_show_slider',
		array(
			'label'      => __( 'Show header?', 'zadot' ),
			'settings'   => 'zadot_show_slider',
			'priority'   => 10,
			'section'    => 'header_image',
			'type'    => 'select',
			'choices' => $zadotYesNo,
		)
	) );	
	$wp_customize->add_setting( 'zadot_header_type',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'zadot_sanitize_slider_type_setting',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'zadot_header_type',
		array(
			'label'      => __( 'Header type :', 'zadot' ),
			'settings'   => 'zadot_header_type',
			'priority'   => 11,
			'section'    => 'header_image',
			'type'    => 'select',
			'choices' => $zadotSliderType,
		)
	) );
	
	$wp_customize->add_setting( 'zadot_slider_cat',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'zadot_sanitize_cat_setting',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'zadot_slider_cat',
		array(
			'label'      => __( 'Select a category for owl slider :', 'zadot' ),
			'settings'   => 'zadot_slider_cat',
			'priority'   => 20,
			'section'    => 'header_image',
			'type'    => 'select',
			'choices' => $zadotAvailableCats,
		)
	) );	
	
	
	/* Business page panel */
	$wp_customize->add_panel( 'zadot_zadot_business_page', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'      => __('Home/Front Page Settings', 'zadot'),
		'active_callback' => '',
	) );
	
	$wp_customize->add_section( 'zadot_zadot_business_page_layout_selection', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'      => __('Select FrontPage Layout', 'zadot'),
		'active_callback' => 'zadot_front_page_sections',
		'panel'  => 'zadot_zadot_business_page',
	) );
	$wp_customize->add_setting( 'zadot_zadot_business_page_layout_type',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'zadot_sanitize_layout_type',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'zadot_zadot_business_page_layout_type',
		array(
			'label'      => __( 'Layout type :', 'zadot' ),
			'settings'   => 'zadot_zadot_business_page_layout_type',
			'priority'   => 10,
			'section'    => 'zadot_zadot_business_page_layout_selection',
			'type'    => 'select',
			'choices' => $zadotBusinessLayoutType,
		)
	) );	
	
	
	$wp_customize->add_section( 'zadot_zadot_business_page_layout_four', array(
		'priority'       => 30,
		'capability'     => 'edit_theme_options',
		'title'      => __('Four settings', 'zadot'),
		'active_callback' => 'zadot_front_page_sections',
		'panel'  => 'zadot_zadot_business_page',
	) );
	$wp_customize->add_setting( 'zadot_four_welcome_post',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'zadot_sanitize_post_selection',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'zadot_six_welcome_post',
		array(
			'label'      => __( 'Welcome post :', 'zadot' ),
			'settings'   => 'zadot_four_welcome_post',
			'priority'   => 10,
			'section'    => 'zadot_zadot_business_page_layout_four',
			'type'    => 'select',
			'choices' => $zadotPostsPagesArray,
		)
	) );
	
	$wp_customize->add_setting( 'zadot_four_services_cat',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'zadot_sanitize_cat_setting',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'zadot_four_services_cat',
		array(
			'label'      => __( 'Select a category :', 'zadot' ),
			'settings'   => 'zadot_four_services_cat',
			'priority'   => 20,
			'section'    => 'zadot_zadot_business_page_layout_four',
			'type'    => 'select',
			'choices' => $zadotAvailableCats,
		)
	) );	
	
	$wp_customize->add_setting( 'zadot_four_services_num',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'zadot_four_services_num',
		array(
			'label'      => __( 'Number of posts :', 'zadot' ),
			'settings'   => 'zadot_four_services_num',
			'priority'   => 20,
			'section'    => 'zadot_zadot_business_page_layout_four',
			'type'    => 'text',
		)
	) );	
	
	$wp_customize->add_section( 'zadot_business_page_layout_wooone', array(
		'priority'       => 60,
		'capability'     => 'edit_theme_options',
		'title'      => __('Woo One settings', 'zadot'),
		'active_callback' => 'zadot_front_page_sections',
		'panel'  => 'zadot_zadot_business_page',
	) );

	$wp_customize->add_setting( 'zadot_wooone_welcome_post',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'zadot_sanitize_post_selection',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'zadot_wooone_welcome_post',
		array(
			'label'      => __( 'Welcome post :', 'zadot' ),
			'settings'   => 'zadot_wooone_welcome_post',
			'priority'   => 10,
			'section'    => 'zadot_business_page_layout_wooone',
			'type'    => 'select',
			'choices' => $zadotPostsPagesArray,
		)
	) );
	$wp_customize->add_setting( 'zadot_wooone_latest_heading',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'zadot_wooone_latest_heading',
		array(
			'label'      => __( 'Products Heading :', 'zadot' ),
			'settings'   => 'zadot_wooone_latest_heading',
			'priority'   => 20,
			'section'    => 'zadot_business_page_layout_wooone',
			'type'    => 'text',
		)
	) );
	$wp_customize->add_setting( 'zadot_wooone_latest_text',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'zadot_wooone_latest_text',
		array(
			'label'      => __( 'Products Text :', 'zadot' ),
			'settings'   => 'zadot_wooone_latest_text',
			'priority'   => 30,
			'section'    => 'zadot_business_page_layout_wooone',
			'type'    => 'text',
		)
	) );	

	$wp_customize->add_section( 'zadot_zadot_business_page_quote', array(
		'priority'       => 110,
		'capability'     => 'edit_theme_options',
		'title'      => __('Quote Settings', 'zadot'),
		'active_callback' => '',
		'panel'  => 'zadot_general',
	) );
	$wp_customize->add_setting( 'zadot_show_quote',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'zadot_sanitize_yes_no_setting',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'zadot_show_quote',
		array(
			'label'      => __( 'Show quote?', 'zadot' ),
			'settings'   => 'zadot_show_quote',
			'priority'   => 10,
			'section'    => 'zadot_zadot_business_page_quote',
			'type'    => 'select',
			'choices' => $zadotYesNo,
		)
	) );
	$wp_customize->add_setting( 'zadot_quote_post',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'zadot_sanitize_post_selection',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'zadot_quote_post',
		array(
			'label'      => __( 'Select post', 'zadot' ),
			'description' => __( 'Select a post/page you want to show in quote section', 'zadot' ),
			'settings'   => 'zadot_quote_post',
			'priority'   => 11,
			'section'    => 'zadot_zadot_business_page_quote',
			'type'    => 'select',
			'choices' => $zadotPostsPagesArray,
		)
	) );	
	
	$wp_customize->add_section( 'zadot_zadot_business_page_social', array(
		'priority'       => 120,
		'capability'     => 'edit_theme_options',
		'title'      => __('Social Settings', 'zadot'),
		'active_callback' => '',
		'panel'  => 'zadot_general',
	) );	
	$wp_customize->add_setting( 'zadot_show_social',
		array(
			'default'    => 'select',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'zadot_sanitize_yes_no_setting',
		) 
	);	
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'zadot_show_social',
		array(
			'label'      => __( 'Show social?', 'zadot' ),
			'settings'   => 'zadot_show_social',
			'priority'   => 10,
			'section'    => 'zadot_zadot_business_page_social',
			'type'    => 'select',
			'choices' => $zadotYesNo,
		)
	) );
	$wp_customize->add_setting( 'zadot_business_page_facebook',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	$wp_customize->add_control( 'zadot_business_page_facebook', array(
	  'type' => 'text',
	  'section' => 'zadot_zadot_business_page_social', // Add a default or your own section
	  'label' => __( 'Facebook', 'zadot' ),
	  'description' => __( 'Enter your facebook url.', 'zadot' ),
	) );
	$wp_customize->add_setting( 'zadot_business_page_flickr',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	$wp_customize->add_control( 'zadot_business_page_flickr', array(
	  'type' => 'text',
	  'section' => 'zadot_zadot_business_page_social', // Add a default or your own section
	  'label' => __( 'Flickr', 'zadot' ),
	  'description' => __( 'Enter your flickr url.', 'zadot' ),
	) );
	$wp_customize->add_setting( 'zadot_business_page_gplus',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	$wp_customize->add_control( 'zadot_business_page_gplus', array(
	  'type' => 'text',
	  'section' => 'zadot_zadot_business_page_social', // Add a default or your own section
	  'label' => __( 'Gplus', 'zadot' ),
	  'description' => __( 'Enter your gplus url.', 'zadot' ),
	) );
	$wp_customize->add_setting( 'zadot_business_page_linkedin',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	$wp_customize->add_control( 'zadot_business_page_linkedin', array(
	  'type' => 'text',
	  'section' => 'zadot_zadot_business_page_social', // Add a default or your own section
	  'label' => __( 'Linkedin', 'zadot' ),
	  'description' => __( 'Enter your linkedin url.', 'zadot' ),
	) );
	$wp_customize->add_setting( 'zadot_business_page_reddit',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	$wp_customize->add_control( 'zadot_business_page_reddit', array(
	  'type' => 'text',
	  'section' => 'zadot_zadot_business_page_social', // Add a default or your own section
	  'label' => __( 'Reddit', 'zadot' ),
	  'description' => __( 'Enter your reddit url.', 'zadot' ),
	) );
	$wp_customize->add_setting( 'zadot_business_page_stumble',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	$wp_customize->add_control( 'zadot_business_page_stumble', array(
	  'type' => 'text',
	  'section' => 'zadot_zadot_business_page_social', // Add a default or your own section
	  'label' => __( 'Stumble', 'zadot' ),
	  'description' => __( 'Enter your stumble url.', 'zadot' ),
	) );
	$wp_customize->add_setting( 'zadot_business_page_twitter',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);
	$wp_customize->add_control( 'zadot_business_page_twitter', array(
	  'type' => 'text',
	  'section' => 'zadot_zadot_business_page_social', // Add a default or your own section
	  'label' => __( 'Twitter', 'zadot' ),
	  'description' => __( 'Enter your twitter url.', 'zadot' ),
	) );	
	
}
add_action( 'customize_register', 'zadot_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function zadot_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function zadot_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function zadot_customize_preview_js() {
	wp_enqueue_script( 'zadot-customizer', esc_url( get_template_directory_uri() ) . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'zadot_customize_preview_js' );

require get_template_directory() . '/inc/variables.php';

function zadot_sanitize_yes_no_setting( $value ){
	global $zadotYesNo;
    if ( ! array_key_exists( $value, $zadotYesNo ) ){
        $value = 'select';
	}
    return $value;	
}

function zadot_sanitize_post_selection( $value ){
	global $zadotPostsPagesArray;
    if ( ! array_key_exists( $value, $zadotPostsPagesArray ) ){
        $value = 'select';
	}
    return $value;	
}

function zadot_front_page_sections(){
	
	$value = false;
	
	if( 'page' == get_option( 'show_on_front' ) ){
		$value = true;
	}
	
	return $value;
	
}

function zadot_show_wp_header_control(){
	
	$value = false;
	
	if( 'header' == get_theme_mod( 'header_type' ) ){
		$value = true;
	}
	
	return $value;
	
}

function zadot_show_header_one_control(){
	
	$value = false;
	
	if( 'header-one' == get_theme_mod( 'header_type' ) ){
		$value = true;
	}
	
	return $value;
	
}

function zadot_sanitize_slider_type_setting( $value ){

	global $zadotSliderType;
    if ( ! array_key_exists( $value, $zadotSliderType ) ){
        $value = 'select';
	}
    return $value;	
	
}

function zadot_sanitize_cat_setting( $value ){
	
	global $zadotAvailableCats;
	
	if( ! array_key_exists( $value, $zadotAvailableCats ) ){
		
		$value = 'select';
		
	}
	return $value;
	
}

function zadot_sanitize_layout_type( $value ){
	
	global $zadotBusinessLayoutType;
	
	if( ! array_key_exists( $value, $zadotBusinessLayoutType ) ){
		
		$value = 'select';
		
	}
	return $value;
	
}

add_action( 'customize_register', 'zadot_load_customize_classes', 0 );
function zadot_load_customize_classes( $wp_customize ) {
	
	class zadot_Customize_Control_Upgrade extends WP_Customize_Control {

		public $type = 'zadot-upgrade';
		
		public function enqueue() {

		}

		public function to_json() {
			
			parent::to_json();

			$this->json['link']    = $this->get_link();
			$this->json['value']   = $this->value();
			$this->json['id']      = $this->id;
			//$this->json['default'] = $this->default;
			
		}	
		
		public function render_content() {}
		
		public function content_template() { ?>

			<div id="zadot-upgrade-container" class="zadot-upgrade-container">

				<ul>
					<li>More sliders</li>
					<li>More layouts</li>
					<li>Color customization</li>
					<li>Font customization</li>
				</ul>

				<p>
					<a href="https://www.themealley.com/business/">Upgrade</a>
				</p>
									
			</div><!-- .zadot-upgrade-container -->
			
		<?php }	
		
	}
	
	class zadot_Customize_Control_Guide extends WP_Customize_Control {

		public $type = 'zadot-guide';
		
		public function enqueue() {

		}

		public function to_json() {
			
			parent::to_json();

			$this->json['link']    = $this->get_link();
			$this->json['value']   = $this->value();
			$this->json['id']      = $this->id;
			//$this->json['default'] = $this->default;
			
		}	
		
		public function render_content() {}
		
		public function content_template() { ?>

			<div id="zadot-upgrade-container" class="zadot-upgrade-container">

				<ol>
					<li>Select 'A static page' for "your homepage displays" in 'select frontpage type' section of 'Home/Front Page settings' tab.</li>
					<li>Enter details for various section like header, welcome, services, quote, social sections.</li>
				</ol>
									
			</div><!-- .zadot-upgrade-container -->
			
		<?php }	
		
	}	

	$wp_customize->register_control_type( 'zadot_Customize_Control_Upgrade' );
	$wp_customize->register_control_type( 'zadot_Customize_Control_Guide' );
	
	
}