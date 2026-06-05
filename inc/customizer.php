<?php
/**
 * Customizer options for the Persian WooCommerce theme.
 *
 * Registers all theme-customizable settings via the WordPress Customizer API.
 * Every setting lives under a dedicated section with Persian-language labels.
 *
 * @package WC_Persian
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Customizer settings, controls, and sections.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function wc_persian_customize_register( $wp_customize ) {

	/* ------------------------------------------------------------------
	 *  Colors Section
	 * --------------------------------------------------------------- */
	$wp_customize->add_section(
		'wc_persian_colors',
		array(
			'title'    => esc_html__( 'رنگ‌ها', 'wc-persian' ),
			'priority' => 30,
		)
	);

	// Primary Color — default #1a73e8
	$wp_customize->add_setting(
		'primary_color',
		array(
			'default'           => '#1a73e8',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'primary_color',
			array(
				'label'   => esc_html__( 'رنگ اصلی', 'wc-persian' ),
				'section' => 'wc_persian_colors',
			)
		)
	);

	// Secondary / CTA Color — default #f57c00
	$wp_customize->add_setting(
		'secondary_color',
		array(
			'default'           => '#f57c00',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'secondary_color',
			array(
				'label'   => esc_html__( 'رنگ دکمه‌ها', 'wc-persian' ),
				'section' => 'wc_persian_colors',
			)
		)
	);

	// Text Color — inherits from WP if empty
	$wp_customize->add_setting(
		'text_color',
		array(
			'default'           => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'text_color',
			array(
				'label'   => esc_html__( 'رنگ متن', 'wc-persian' ),
				'section' => 'wc_persian_colors',
			)
		)
	);

	// Background Color
	$wp_customize->add_setting(
		'background_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'background_color',
			array(
				'label'   => esc_html__( 'رنگ پس‌زمینه', 'wc-persian' ),
				'section' => 'wc_persian_colors',
			)
		)
	);

	/* ------------------------------------------------------------------
	 *  Header Options Section
	 * --------------------------------------------------------------- */
	$wp_customize->add_section(
		'wc_persian_header',
		array(
			'title'    => esc_html__( 'تنظیمات سربرگ', 'wc-persian' ),
			'priority' => 35,
		)
	);

	// Sticky Header
	$wp_customize->add_setting(
		'sticky_header',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);
	$wp_customize->add_control(
		'sticky_header',
		array(
			'label'   => esc_html__( 'سربرگ چسبان', 'wc-persian' ),
			'section' => 'wc_persian_header',
			'type'    => 'checkbox',
		)
	);

	// Show Search Bar
	$wp_customize->add_setting(
		'show_search_bar',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);
	$wp_customize->add_control(
		'show_search_bar',
		array(
			'label'   => esc_html__( 'نمایش نوار جستجو', 'wc-persian' ),
			'section' => 'wc_persian_header',
			'type'    => 'checkbox',
		)
	);

	// Show Cart Icon
	$wp_customize->add_setting(
		'show_cart_icon',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);
	$wp_customize->add_control(
		'show_cart_icon',
		array(
			'label'   => esc_html__( 'نمایش آیکون سبد خرید', 'wc-persian' ),
			'section' => 'wc_persian_header',
			'type'    => 'checkbox',
		)
	);

	/* ------------------------------------------------------------------
	 *  Footer Section
	 * --------------------------------------------------------------- */
	$wp_customize->add_section(
		'wc_persian_footer',
		array(
			'title'    => esc_html__( 'تنظیمات پاورقی', 'wc-persian' ),
			'priority' => 40,
		)
	);

	// Copyright Text
	$wp_customize->add_setting(
		'footer_copyright',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		'footer_copyright',
		array(
			'label'       => esc_html__( 'متن کپی‌رایت', 'wc-persian' ),
			'section'     => 'wc_persian_footer',
			'type'        => 'textarea',
			'description' => esc_html__( 'متنی که در پایین سایت نمایش داده می‌شود. خالی بگذارید برای نمایش پیش‌فرض.', 'wc-persian' ),
		)
	);

	// Phone Number
	$wp_customize->add_setting(
		'footer_phone',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'footer_phone',
		array(
			'label'   => esc_html__( 'شماره تلفن', 'wc-persian' ),
			'section' => 'wc_persian_footer',
			'type'    => 'text',
		)
	);

	// Email Address
	$wp_customize->add_setting(
		'footer_email',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'footer_email',
		array(
			'label'   => esc_html__( 'ایمیل', 'wc-persian' ),
			'section' => 'wc_persian_footer',
			'type'    => 'email',
		)
	);

	// Physical Address
	$wp_customize->add_setting(
		'footer_address',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'footer_address',
		array(
			'label'   => esc_html__( 'آدرس', 'wc-persian' ),
			'section' => 'wc_persian_footer',
			'type'    => 'textarea',
		)
	);
}
add_action( 'customize_register', 'wc_persian_customize_register' );

/**
 * Output inline CSS from Customizer color settings so that
 * the live preview updates without a full page reload.
 */
function wc_persian_customizer_css() {
	$primary      = get_theme_mod( 'primary_color', '#1a73e8' );
	$secondary    = get_theme_mod( 'secondary_color', '#f57c00' );
	$text_color   = get_theme_mod( 'text_color', '#333333' );
	$bg_color     = get_theme_mod( 'background_color', '#ffffff' );
	$sticky       = get_theme_mod( 'sticky_header', true );
	$show_search  = get_theme_mod( 'show_search_bar', true );
	$show_cart    = get_theme_mod( 'show_cart_icon', true );

	$css = ":root{" .
		"--wc-persian-primary:{$primary};" .
		"--wc-persian-secondary:{$secondary};" .
		"--wc-persian-text:{$text_color};" .
		"--wc-persian-bg:{$bg_color};" .
		"}";

	$css .= "body{color:{$text_color};background-color:{$bg_color};}";
	$css .= "a,.button,.wp-block-button__link{color:{$primary};}";
	$css .= ".button,.wp-block-button__link,.btn-primary{background-color:{$secondary};color:#fff;}";
	$css .= ".site-header{background-color:{$bg_color};}";
	$css .= ".sticky-header{background-color:{$bg_color};box-shadow:0 2px 8px rgba(0,0,0,0.08);}";

	// Hide elements when their toggles are off.
	if ( ! $sticky ) {
		$css .= '.site-header.is-sticky{position:relative!important;top:auto!important;}';
	}
	if ( ! $show_search ) {
		$css .= '.header-search{display:none!important;}';
	}
	if ( ! $show_cart ) {
		$css .= '.header-cart{display:none!important;}';
	}

	wp_add_inline_style( 'wc-persian-style', $css );
}
add_action( 'wp_enqueue_scripts', 'wc_persian_customizer_css', 20 );

/**
 * Bind Customizer controls to live preview JavaScript (postMessage transport).
 */
function wc_persian_customizer_preview_js() {
	wp_enqueue_script(
		'wc-persian-customizer',
		get_template_directory_uri() . '/assets/js/customizer.js',
		array( 'customize-preview' ),
		filemtime( get_template_directory() . '/assets/js/customizer.js' ),
		true
	);
}
add_action( 'customize_preview_init', 'wc_persian_customizer_preview_js' );
