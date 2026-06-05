<?php
/**
 * WooPersian Store Theme Functions
 *
 * @package WooPersian_Store
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'WOOPERSIAN_VERSION', '1.0.0' );
define( 'WOOPERSIAN_DIR', get_template_directory() );
define( 'WOOPERSIAN_URI', get_template_directory_uri() );

/**
 * Force RTL / Persian locale
 */
add_filter( 'locale', function() {
    return 'fa_IR';
} );

/**
 * Ensure front-page.php is used for the static front page
 */
add_filter( 'template_include', function( $template ) {
    if ( is_front_page() && locate_template( 'front-page.php' ) ) {
        return locate_template( 'front-page.php' );
    }
    return $template;
}, 99 );

/**
 * Theme Setup
 */
function woopersian_setup() {
    // Load text domain for Persian translation
    load_theme_textdomain( 'woo-persian-store', WOOPERSIAN_DIR . '/languages' );

    // Add title tag support
    add_theme_support( 'title-tag' );

    // Post thumbnails
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'product-card', 400, 400, true );
    add_image_size( 'product-large', 800, 800, true );
    add_image_size( 'product-gallery-thumb', 120, 120, true );
    add_image_size( 'blog-thumb', 600, 400, true );
    add_image_size( 'hero-slide', 1200, 500, true );
    add_image_size( 'category-thumb', 300, 300, true );

    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Custom background
    add_theme_support( 'custom-background', array(
        'default-color' => 'ffffff',
    ) );

    // Wide alignment
    add_theme_support( 'align-wide' );

    // WooCommerce support
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // Register nav menus
    register_nav_menus( array(
        'primary'   => esc_html__( 'منوی اصلی', 'woo-persian-store' ),
        'footer'    => esc_html__( 'منوی فوتر', 'woo-persian-store' ),
        'category'  => esc_html__( 'منوی دسته‌بندی', 'woo-persian-store' ),
    ) );

    // Set content width
    if ( ! isset( $content_width ) ) {
        $content_width = 1200;
    }
}
add_action( 'after_setup_theme', 'woopersian_setup' );

/**
 * Enqueue Styles and Scripts
 */
function woopersian_scripts() {
    // Vazirmatn font
    wp_enqueue_style(
        'vazirmatn-font',
        'https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css',
        array(),
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'woopersian-style',
        get_stylesheet_uri(),
        array(),
        WOOPERSIAN_VERSION
    );

    // RTL stylesheet
    if ( is_rtl() ) {
        wp_enqueue_style(
            'woopersian-rtl',
            WOOPERSIAN_URI . '/rtl.css',
            array( 'woopersian-style' ),
            WOOPERSIAN_VERSION
        );
    }

    // Main JS
    wp_enqueue_script(
        'woopersian-main',
        WOOPERSIAN_URI . '/assets/js/main.js',
        array(),
        WOOPERSIAN_VERSION,
        true
    );

    // Mini cart AJAX JS
    if ( class_exists( 'WooCommerce' ) ) {
        wp_enqueue_script(
            'woopersian-mini-cart',
            WOOPERSIAN_URI . '/assets/js/mini-cart.js',
            array( 'jquery' ),
            WOOPERSIAN_VERSION,
            true
        );
    }

    // Pass data to JS
    wp_localize_script( 'woopersian-main', 'woopersianData', array(
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'nonce'     => wp_create_nonce( 'woopersian_nonce' ),
        'isRtl'     => is_rtl() ? 'true' : 'false',
        'homeUrl'   => home_url( '/' ),
    ) );

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'woopersian_scripts' );

/**
 * Register Widget Areas
 */
function woopersian_widgets_init() {
    // Shop sidebar
    register_sidebar( array(
        'name'          => esc_html__( 'سایدبار فروشگاه', 'woo-persian-store' ),
        'id'            => 'shop-sidebar',
        'description'   => esc_html__( 'نوار کناری صفحه فروشگاه', 'woo-persian-store' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    // Blog sidebar
    register_sidebar( array(
        'name'          => esc_html__( 'سایدبار وبلاگ', 'woo-persian-store' ),
        'id'            => 'blog-sidebar',
        'description'   => esc_html__( 'نوار کناری صفحه وبلاگ', 'woo-persian-store' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    // Footer widget areas (4 columns)
    for ( $i = 1; $i <= 4; $i++ ) {
        register_sidebar( array(
            'name'          => sprintf( esc_html__( 'فوتر - ستون %d', 'woo-persian-store' ), $i ),
            'id'            => 'footer-' . $i,
            'description'   => sprintf( esc_html__( 'ناحیه ابزارک ستون %d فوتر', 'woo-persian-store' ), $i ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );
    }
}
add_action( 'widgets_init', 'woopersian_widgets_init' );

/**
 * WooCommerce Setup
 */
function woopersian_woocommerce_setup() {
    // Remove default WC wrapper
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

    // Add custom wrapper
    add_action( 'woocommerce_before_main_content', 'woopersian_wc_wrapper_start', 10 );
    add_action( 'woocommerce_after_main_content', 'woopersian_wc_wrapper_end', 10 );

    // Custom product columns
    add_filter( 'loop_shop_columns', 'woopersian_loop_columns' );
    add_filter( 'loop_shop_per_page', 'woopersian_products_per_page' );

    // Remove WC default breadcrumb (optional)
    // remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
}

function woopersian_wc_wrapper_start() {
    echo '<div class="container"><main id="primary" class="content-area">';
}

function woopersian_wc_wrapper_end() {
    echo '</main>';
    if ( woopersian_has_shop_sidebar() ) {
        get_sidebar( 'product' );
    }
    echo '</div><!-- .container -->';
}

function woopersian_loop_columns() {
    return 4;
}

function woopersian_products_per_page() {
    return 12;
}

add_action( 'after_setup_theme', 'woopersian_woocommerce_setup' );

/**
 * Persian Numerals Helper
 * Converts English/Arabic numerals to Persian numerals
 *
 * @param string|int $number The number to convert.
 * @return string Number with Persian numerals.
 */
function woopersian_persian_numerals( $number ) {
    $persian_digits = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
    $arabic_digits  = array( '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' );
    $english_digits = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );

    $number = str_replace( $arabic_digits, $persian_digits, (string) $number );
    $number = str_replace( $english_digits, $persian_digits, $number );

    return $number;
}

/**
 * Persian Price Format
 * Format price with Persian numerals and toman suffix
 *
 * @param float|int  $price      Price value.
 * @param bool       $with_toman Whether to append تومان suffix.
 * @return string Formatted price.
 */
function woopersian_persian_price( $price, $with_toman = true ) {
    $formatted = number_format( (float) $price, 0, '.', ',' );
    $formatted = woopersian_persian_numerals( $formatted );

    if ( $with_toman ) {
        $formatted .= ' ' . esc_html__( 'تومان', 'woo-persian-store' );
    }

    return $formatted;
}

/**
 * Fallback Menu
 */
function woopersian_fallback_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'صفحه اصلی', 'woo-persian-store' ) . '</a></li>';
    echo '<li><a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '">' . esc_html__( 'فروشگاه', 'woo-persian-store' ) . '</a></li>';
    echo '</ul>';
}

/**
 * Product Badges (sale, new, featured)
 */
function woopersian_product_badges() {
    global $product;
    if ( ! $product ) {
        return;
    }

    $badges = array();

    if ( $product->is_featured() ) {
        $badges[] = '<span class="badge badge-featured">' . esc_html__( 'ویژه!', 'woo-persian-store' ) . '</span>';
    }

    $created = get_the_date( 'U', $product->get_id() );
    if ( $created && ( time() - $created ) < 30 * DAY_IN_SECONDS ) {
        $badges[] = '<span class="badge badge-new">' . esc_html__( 'جدید!', 'woo-persian-store' ) . '</span>';
    }

    if ( ! empty( $badges ) ) {
        echo '<div class="product-badges">' . implode( '', $badges ) . '</div>';
    }
}

/**
 * Product Star Rating
 */
function woopersian_product_star_rating() {
    global $product;
    if ( ! $product ) {
        return;
    }

    $rating = $product->get_average_rating();
    $count  = $product->get_review_count();

    if ( $rating > 0 ) {
        $html  = '<div class="star-rating" title="' . esc_attr( $rating ) . '">';
        $html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%">';
        $html .= esc_html__( 'امتیاز', 'woo-persian-store' ) . ' ' . woopersian_persian_numerals( number_format( $rating, 1 ) );
        $html .= '</span></div>';
        echo $html;
    }
}

/**
 * Determine whether the shop sidebar should be displayed.
 */
function woopersian_has_shop_sidebar() {
    // Never show sidebar on single product pages
    if ( is_product() ) {
        return false;
    }
    // Show sidebar if the widget area has active widgets
    return is_active_sidebar( 'shop-sidebar' );
}

/**
 * Add body classes
 */
function woopersian_body_classes( $classes ) {
    $classes[] = 'woopersian';
    $classes[] = 'rtl';

    // Sidebar visibility class
    if ( woopersian_has_shop_sidebar() && ( is_shop() || is_product_category() || is_product_tag() ) ) {
        $classes[] = 'has-sidebar';
    } else {
        $classes[] = 'no-sidebar';
    }

    if ( is_active_sidebar( 'blog-sidebar' ) && ( is_home() || ( is_archive() && ! is_shop() ) ) ) {
        $classes[] = 'has-sidebar';
    }

    if ( class_exists( 'WooCommerce' ) ) {
        $classes[] = 'woocommerce-active';
        if ( is_shop() || is_product_category() || is_product_tag() ) {
            $classes[] = 'columns-' . woopersian_loop_columns();
        }
    }

    return $classes;
}
add_filter( 'body_class', 'woopersian_body_classes' );

/**
 * Custom Walker for Nav Menu (Persian support)
 */
class WooPersian_Nav_Walker extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $output .= '<li' . $class_names . '>';

        $attributes  = '';
        ! empty( $item->attr_title ) and $attributes .= ' title="'  . esc_attr( $item->attr_title ) . '"';
        ! empty( $item->target )     and $attributes .= ' target="' . esc_attr( $item->target )     . '"';
        ! empty( $item->xfn )        and $attributes .= ' rel="'    . esc_attr( $item->xfn )        . '"';
        ! empty( $item->url )        and $attributes .= ' href="'   . esc_attr( $item->url )        . '"';

        $link_before = isset( $args->link_before ) ? $args->link_before : '';
        $link_after  = isset( $args->link_after )  ? $args->link_after  : '';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

/**
 * Include additional files
 */
require_once WOOPERSIAN_DIR . '/inc/customizer.php';
require_once WOOPERSIAN_DIR . '/inc/woocommerce.php';

/**
 * WooCommerce template override check
 */
function woopersian_wc_template_path( $template, $template_name, $template_path ) {
    $theme_template = WOOPERSIAN_DIR . '/woocommerce/' . $template_name;
    if ( file_exists( $theme_template ) ) {
        $template = $theme_template;
    }
    return $template;
}
add_filter( 'woocommerce_get_template', 'woopersian_wc_template_path', 10, 3 );

/**
 * Disable emoji scripts for performance
 */
function woopersian_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'woopersian_disable_emojis' );

/**
 * Mini-cart WooCommerce Cart Fragments
 * Ensures AJAX cart updates refresh the mini-cart sidebar and count badge.
 */
function woopersian_cart_fragments( $fragments ) {
    // Cart count badge fragment
    ob_start();
    $count = WC()->cart->get_cart_contents_count();
    echo '<span class="cart-count' . ( 0 === $count ? ' cart-empty' : '' ) . '">';
    echo esc_html( woopersian_persian_numerals( $count ) );
    echo '</span>';
    $fragments['.cart-count'] = ob_get_clean();

    // Mini-cart content fragment
    ob_start();
    woocommerce_mini_cart();
    $fragments['div.widget_shopping_cart_content'] = ob_get_clean();

    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'woopersian_cart_fragments' );

/**
 * Ensure WooCommerce outputs semantic <ul> for product loops
 */
function woopersian_product_loop_start_args( $args ) {
    if ( isset( $args['before'] ) ) {
        $args['before'] = '<ul class="products">';
    }
    return $args;
}
