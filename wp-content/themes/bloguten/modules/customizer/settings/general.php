<?php
/**
* Sets settings for general fields
*
* @since  Bloguten 1.0.0
* @param  array $settings
* @return array Merged array
*/

function Bloguten_Customizer_General_Settings( $settings ){

	$general = array(
		# Site Identity
		'site_identity_options' => array(
			'label'    => esc_html__( 'Site Identity Extra Options', 'bloguten' ),
			'section'  => 'title_tagline',
			'priority' => 50,
			'type'     => 'radio',
			'choices'  => array(
				'site_identity_hide_all'     => esc_html__( 'Hide All', 'bloguten' ),
				'site_identity_show_all'     => esc_html__( 'Show All', 'bloguten' ),
				'site_identity_title_only'   => esc_html__( 'Title Only', 'bloguten' ),
				'site_identity_tagline_only' => esc_html__( 'Tagline Only', 'bloguten' ),
				'site_identity_logo_title'   => esc_html__( 'Logo + Title', 'bloguten' ),
				'site_identity_logo_tagline' => esc_html__( 'Logo + Tagline', 'bloguten' ),
			),
		),
		
		# Color
		'site_title_color' => array(
			'label'     => esc_html__( 'Site Title', 'bloguten' ),
			'section'   => 'colors',
			'type'      => 'colors',
		),
		'site_tagline_color' => array(
			'label'     => esc_html__( 'Site Tagline', 'bloguten' ),
			'section'   => 'colors',
			'type'      => 'colors',
		),
		'site_body_text_color' => array(
			'label'     => esc_html__( 'Body Text', 'bloguten' ),
			'section'   => 'colors',
			'type'      => 'colors',
		),
		'site_primary_color' => array(
			'label'     => esc_html__( 'Primary', 'bloguten' ),
			'section'   => 'colors',
			'type'      => 'colors',
		),
		'site_hover_color' => array(
			'label'     => esc_html__( 'Hover', 'bloguten' ),
			'section'   => 'colors',
			'type'      => 'colors',
		),

		# Theme Options
		# Header
		'header_layout' => array(
			'label'     => esc_html__( 'Select Header Layout', 'bloguten' ),
			'section'   => 'header_options',
			'type'      => 'select',
			'choices'   => array(
				'header_one'   => esc_html__( 'Header Layout One', 'bloguten' ),
			),
		),
		'disable_search_icon' => array(
			'label'     => esc_html__( 'Disable Header Search Icon', 'bloguten' ),
			'section'   => 'header_options',
			'type'      => 'checkbox',
		),
		'disable_hamburger_menu_icon' => array(
			'label'       => esc_html__( 'Disable Hamburger Menu Icon', 'bloguten' ),
			'description' => esc_html__( 'It will disable the icon from desktop view', 'bloguten' ),
			'section'     => 'header_options',
			'type'        => 'checkbox',
		),
		'disable_fixed_header' => array(
			'label'     => esc_html__( 'Disable Fixed Header', 'bloguten' ),
			'section'   => 'header_options',
			'type'      => 'checkbox',
		),

		# Footer
		// Instagram
		'insta_shortcode' => array(
			'label'       => esc_html__( 'Instagram Shortcode', 'bloguten' ),
			'section'     => 'footer_options',
			'type'        => 'text',
		),
		'enable_instagram' => array(
			'label'   => esc_html__( 'Enable Instagram', 'bloguten' ),
			'section' => 'footer_options',
			'type'    => 'checkbox',
		),
		'footer_layout' => array(
			'label'     => esc_html__( 'Select Footer Layout', 'bloguten' ),
			'section'   => 'footer_options',
			'type'      => 'select',
			'choices'   => array(
				'footer_one'   => esc_html__( 'Footer Layout One', 'bloguten' ),
			),
		),
		// Widgets
		'disable_footer_widget' => array(
			'label'   => esc_html__( 'Disable Footer Widget Area', 'bloguten' ),
			'section' => 'footer_options',
			'type'    => 'checkbox',
		),
		// Copyright
		'footer_text' =>  array(
			'label'   => esc_html__( 'Footer Text', 'bloguten' ),
			'section' => 'footer_options',
			'type'    => 'textarea',
		),

		# Layout
		'site_layout' => array(
			'label'   => esc_html__( 'Site Layout', 'bloguten' ),
			'section' => 'layout_options',
			'type'    => 'radio-image',
			'choices' => array(
				'site_layout_full' => array(
					'label' => esc_html__( 'Full Width', 'bloguten' ),
					'url'   => '/assets/images/placeholder/full-width.png'
				),
				'site_layout_box' => array(
					'label' => esc_html__( 'Box Width', 'bloguten' ),
					'url'   => '/assets/images/placeholder/box-layout.png'
				)
			),
		),
		'archive_layout' => array(
			'label'     => esc_html__( 'Archive Page Layout', 'bloguten' ),
			'section'   => 'layout_options',
			'type'      => 'radio-image',
			'choices'   => array(
				'right' => array(
					'label' => esc_html__( 'Right Sidebar', 'bloguten' ),
					'url'   => '/assets/images/placeholder/right-sidebar.png'
				),
				'left' => array(
					'label' => esc_html__( 'Left Sidebar', 'bloguten' ),
					'url'   => '/assets/images/placeholder/left-sidebar.png'
				),
				'none' => array(
					'label' => esc_html__( 'No Sidebar', 'bloguten' ),
					'url'   => '/assets/images/placeholder/no-sidebar.png'
				)
			),
		),
		'archive_post_layout' => array(
			'label'     => esc_html__( 'Archive Post Layout', 'bloguten' ),
			'section'   => 'layout_options',
			'type'      => 'radio-image',
			'choices'   => array(
				'grid' => array(
					'label' => esc_html__( 'Grid', 'bloguten' ),
					'url'   => '/assets/images/placeholder/grid-layout.png'
				),
				'list' => array(
					'label' => esc_html__( 'List', 'bloguten' ),
					'url'   => '/assets/images/placeholder/list-layout.png'
				),
				'simple' => array(
					'label' => esc_html__( 'Simple', 'bloguten' ),
					'url'   => '/assets/images/placeholder/single-layout.png'
				)
			),
		),
		'single_layout' => array(
			'label'     => esc_html__( 'Single Page Layout', 'bloguten' ),
			'section'   => 'layout_options',
			'type'      => 'radio-image',
			'choices'   => array(
				'right' => array(
					'label' => esc_html__( 'Right Sidebar', 'bloguten' ),
					'url'   => '/assets/images/placeholder/right-sidebar.png'
				),
				'left' => array(
					'label' => esc_html__( 'Left Sidebar', 'bloguten' ),
					'url'   => '/assets/images/placeholder/left-sidebar.png'
				),
				'none' => array(
					'label' => esc_html__( 'No Sidebar', 'bloguten' ),
					'url'   => '/assets/images/placeholder/no-sidebar.png'
				)
			),
		),
		'page_layout' => array(
			'label'     => esc_html__( 'Pages Layout', 'bloguten' ),
			'section'   => 'layout_options',
			'type'      => 'radio-image',
			'choices'   => array(
				'none' => array(
					'label' => esc_html__( 'No Sidebar', 'bloguten' ),
					'url'   => '/assets/images/placeholder/no-sidebar.png'
				),
				'left' => array(
					'label' => esc_html__( 'Left Sidebar', 'bloguten' ),
					'url'   => '/assets/images/placeholder/left-sidebar.png'
				),
				'right' => array(
					'label' => esc_html__( 'Right Sidebar', 'bloguten' ),
					'url'   => '/assets/images/placeholder/right-sidebar.png'
				)
			),
		),

		# Archive
		// Slider
		'slider_category' => array(
			'label'   => esc_html__( 'Choose Slider Category', 'bloguten' ),
			'description' => esc_html__( 'Recent posts will show if any, category is not chosen.', 'bloguten' ),
			'section' => 'archive_options',
			'type'    => 'dropdown-categories',
		),
		'slider_type' => array(
			'label' => esc_html__( 'Slider Type', 'bloguten' ),
			'section' => 'archive_options',
			'type'    => 'select',
			'choices' => array(
				'box'  => esc_html__( 'Box', 'bloguten' ),
			),
		),
		'slider_layout' => array(
			'label' => esc_html__( 'Slider Layout', 'bloguten' ),
			'section' => 'archive_options',
			'type'    => 'select',
			'choices' => array(
				'slider_layout_one'   => esc_html__( 'Slider Layout One', 'bloguten' ),
			),
		),
		'slider_overlay_opacity' => array(
			'label'       => esc_html__( 'Slider Overlay Opacity', 'bloguten' ),
			'description' => esc_html__( '1 equals to 10%', 'bloguten' ),
			'section'     => 'archive_options',
			'type'        => 'number',
			'input_attrs' => array(
				'min' => 1,
				'max' => 9,
				'style' => 'width: 70px;'
			),
		),
		'slider_content_alignment' => array(
			'label'   => esc_html__( 'Slider Content Alignment', 'bloguten' ),
			'section' => 'archive_options',
			'type'    => 'select',
			'choices' => array(
				'center' => esc_html__( 'Center', 'bloguten' ),
			),
		),
		'disable_slider_control' => array(
			'label'     => esc_html__( 'Disable Slider Control', 'bloguten' ),
			'section'   => 'archive_options',
			'type'      => 'checkbox'
		),
		'slider_autoplay' => array(
			'label'   => esc_html__( 'Slider Auto Play', 'bloguten' ),
			'section' => 'archive_options',
			'type'    => 'checkbox',
		),
		'slider_timeout' => array(
			'label'    => esc_html__( 'Slider Auto Play Timeout ( in sec )', 'bloguten' ),
			'section'  => 'archive_options',
			'type'     => 'number',
			'input_attrs' => array(
				'min' => 3,
				'max' => 60,
				'style' => 'width: 70px;'
			)
		),
		'slider_button_text' => array(
			'label'   => esc_html__( 'Slider Button Text', 'bloguten' ),
			'section' => 'archive_options',
			'type'    => 'text',
		),
		'slider_posts_number' => array(
			'label'       => esc_html__( 'Slider Post View Number', 'bloguten' ),
			'description' => esc_html__( 'Total number of posts to show', 'bloguten' ),
			'section'     => 'archive_options',
			'type'        => 'number',
			'input_attrs' => array(
				'min' => 1,
				'max' => 3,
				'style' => 'width: 70px;'
			),
		),
		'disable_slider' => array(
			'label'   => esc_html__( 'Disable Slider Section', 'bloguten' ),
			'section' => 'archive_options',
			'type'    => 'checkbox',
		),

		'archive_page_title' => array(
			'label'   => esc_html__( 'Blog Page Title', 'bloguten' ),
			'description' => esc_html__( 'This title will appear when the slider is disabled.', 'bloguten' ),
			'section' => 'archive_options',
			'type'    => 'text',
		),
		'disable_archive_cat_link' => array(
			'label'    => esc_html__( 'Disable Category link', 'bloguten' ),
			'section'  => 'archive_options',
			'type'     => 'checkbox',
		),
		'disable_archive_date' => array(
			'label'    => esc_html__( 'Disable Post Date', 'bloguten' ),
			'section'  => 'archive_options',
			'type'     => 'checkbox',
		),
		'disable_archive_author' => array(
			'label'    => esc_html__( 'Disable Author', 'bloguten' ),
			'section'  => 'archive_options',
			'type'     => 'checkbox',
		),
		'disable_archive_comment_link' => array(
			'label'    => esc_html__( 'Disable Comment link', 'bloguten' ),
			'section'  => 'archive_options',
			'type'     => 'checkbox',
		),
		'excerpt_length' => array(
			'label'       => esc_html__( 'Excerpt Length', 'bloguten' ),
			'description' => esc_html__( 'in words', 'bloguten' ),
			'section'     => 'archive_options',
			'type'        => 'number',
			'input_attrs' => array(
				'min' => 1,
				'max' => 200,
				'style' => 'width: 70px;'
			),
		),
  		'disable_pagination' => array(
  			'label'   => esc_html__( 'Disable Pagination', 'bloguten' ),
  			'section' => 'archive_options',
  			'type'    => 'checkbox'
  		),

		# Single
		'disable_single_date' => array(
			'label'    => esc_html__( 'Disable Post Date', 'bloguten' ),
			'section'  => 'single_options',
			'type'     => 'checkbox',
		),
		'disable_single_feature_image' => array(
			'label'   => esc_html__( 'Disable Feauture Image', 'bloguten' ),
			'section' => 'single_options',
			'type'    => 'checkbox'
		),
		'disable_single_post_format' => array(
			'label'    => esc_html__( 'Disable Post Format', 'bloguten' ),
			'section'  => 'single_options',
			'type'     => 'checkbox',
		),
		'disable_single_tag_links' => array(
			'label'    => esc_html__( 'Disable Tag links', 'bloguten' ),
			'section'  => 'single_options',
			'type'     => 'checkbox',
		),
		'disable_single_cat_links' => array(
			'label'    => esc_html__( 'Disable Category links', 'bloguten' ),
			'section'  => 'single_options',
			'type'     => 'checkbox',
		),
		'disable_single_author' => array(
			'label'    => esc_html__( 'Disable Author detail', 'bloguten' ),
			'section'  => 'single_options',
			'type'     => 'checkbox',
		),
		'single_post_nav_prev' => array(
			'label'   => esc_html__( 'Previous Reading Text', 'bloguten' ),
			'description' => esc_html__( 'Post Navigation Previous Reading Text', 'bloguten' ),
			'section' => 'single_options',
			'type'    => 'text',
		),
		'single_post_nav_next' => array(
			'label'   => esc_html__( 'Next Reading Text', 'bloguten' ),
			'description' => esc_html__( 'Post Navigation Next Reading Text', 'bloguten' ),
			'section' => 'single_options',
			'type'    => 'text',
		),

		# Page
		'disable_page_feature_image' => array(
			'label'   => esc_html( 'Disable Page Feature Image' ),
			'section' => 'page_options',
			'type'    => 'checkbox',
		),

		# General
		// Site Loader
		'site_loader_options' => array(
			'label'   => esc_html__( 'Site Loader Options', 'bloguten' ),
			'section' => 'general_options',
			'type'    => 'select',
			'choices' => array(
				'site_loader_one'   => esc_html__( 'Site Loader One', 'bloguten' ),
			),
		),
		'disable_site_loader' => array(
			'label'   => esc_html__( 'Disable Site Loader', 'bloguten' ),
			'section' => 'general_options',
			'type'    => 'checkbox',
		),
		// Site layout box shadow
		'disable_site_layout_shadow' => array(
			'label'       => esc_html__( 'Disable Site layout Shadow', 'bloguten' ),
			'description' => esc_html__( 'It will effect on Box & Frame site layout options', 'bloguten' ),
			'section'     => 'general_options',
			'type'        => 'checkbox'
		),

		// Scroll Top
		'enable_scroll_top' => array(
			'label'     => esc_html__( 'Enable Scroll Top', 'bloguten' ),
			'section'   => 'general_options',
			'type'      => 'checkbox',
		),

		// Page Header Layout
		'page_header_layout' => array(
			'label'    => esc_html__( 'Page Header Title Layouts', 'bloguten' ),
			'section'  => 'general_options',
			'type'     => 'radio-image',
			'choices'  => array(
				'header_layout_one' => array(
					'label' => esc_html__( 'Layout One', 'bloguten' ),
					'url'   => '/assets/images/placeholder/noimage-breadcrumb.png'
				),
			), 
		),

		// Breadcrumb
		'breadcrumb_separator_layout' => array(
			'label'   => esc_html__( 'Breadcrumb Separator Layouts', 'bloguten' ),
			'section' => 'general_options',
			'type'    => 'select',
			'choices' => array(
				'separator_layout_one'   => esc_html__( 'Separator Layout One', 'bloguten' ),
				'separator_layout_two'   => esc_html__( 'Separator Layout Two', 'bloguten' ),
				'separator_layout_three' => esc_html__( 'Separator Layout Three', 'bloguten' ),
			),
		),
		'enable_breadcrumb_home_icon' => array(
			'label'   => esc_html__( 'Enable Breadcrumb Home Icon', 'bloguten' ),
			'section' => 'general_options',
			'type'    => 'checkbox'
		),
		'disable_bradcrumb' => array(
			'label'   => esc_html__( 'Disable Breadcrumb', 'bloguten' ),
			'section' => 'general_options',
			'type'    => 'checkbox'
		),
	);

	return array_merge( $settings, $general );
}
add_filter( 'Bloguten_Customizer_Fields', 'Bloguten_Customizer_General_Settings' );