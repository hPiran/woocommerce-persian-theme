<?php
/**
 * Header Template
 *
 * @package WooPersian_Store
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl" lang="fa">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'رفتن به محتوا', 'woo-persian-store' ); ?></a>

    <!-- Header Top Bar -->
    <div class="header-top">
        <div class="container">
            <div class="header-top-info">
                <span><?php esc_html_e( 'پشتیبانی ۲۴ ساعته:', 'woo-persian-store' ); ?></span>
                <a href="tel:02112345678" dir="ltr"><?php echo esc_html( woopersian_persian_numerals( '021-12345678' ) ); ?></a>
            </div>
            <div class="header-top-links">
                <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'track-order' ) ) ); ?>"><?php esc_html_e( 'پیگیری سفارش', 'woo-persian-store' ); ?></a>
                <span class="top-divider">|</span>
                <?php if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/wp-login.php' ) ); ?>"><?php esc_html_e( 'حساب کاربری من', 'woo-persian-store' ); ?></a>
                <?php else : ?>
                    <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url() ); ?>"><?php esc_html_e( 'ورود / ثبت‌نام', 'woo-persian-store' ); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Header Main -->
    <header class="site-header" id="masthead">
        <div class="header-main">
            <div class="container">
                <!-- Logo -->
                <div class="site-logo">
                    <?php if ( has_custom_logo() ) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link">
                            <span class="site-title"><?php bloginfo( 'name' ); ?></span>
                            <?php $description = get_bloginfo( 'description', 'display' ); ?>
                            <?php if ( $description ) : ?>
                                <span class="site-description"><?php echo esc_html( $description ); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Search -->
                <div class="header-search">
                    <?php get_search_form(); ?>
                </div>

                <!-- Actions -->
                <div class="header-actions">
                    <!-- User Account -->
                    <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url() ); ?>" class="header-action-btn" title="<?php esc_attr_e( 'حساب کاربری', 'woo-persian-store' ); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </a>

                    <!-- Cart -->
                    <a href="#" class="header-action-btn cart-contents" id="cartToggle" title="<?php esc_attr_e( 'سبد خرید', 'woo-persian-store' ); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        <span class="cart-count"><?php echo esc_html( woopersian_persian_numerals( WC()->cart->get_cart_contents_count() ) ); ?></span>
                    </a>

                    <!-- Mobile Menu Toggle -->
                    <button class="menu-toggle" aria-label="<?php esc_attr_e( 'منوی موبایل', 'woo-persian-store' ); ?>">
                        <div class="hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <nav class="main-navigation" id="site-navigation" role="navigation" aria-label="<?php esc_attr_e( 'منوی اصلی', 'woo-persian-store' ); ?>">
            <div class="container">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'nav-menu',
                    'menu_id'        => 'primary-menu',
                    'fallback_cb'    => 'woopersian_fallback_menu',
                    'depth'          => 3,
                ) );
                ?>
            </div>
        </nav>
    </header>

    <!-- Mini Cart Sidebar -->
    <div class="mini-cart-overlay" id="miniCartOverlay"></div>
    <div class="mini-cart" id="miniCart" aria-hidden="true">
        <div class="mini-cart-header">
            <h3><?php esc_html_e( 'سبد خرید', 'woo-persian-store' ); ?></h3>
            <button class="mini-cart-close" id="miniCartClose" aria-label="<?php esc_attr_e( 'بستن سبد خرید', 'woo-persian-store' ); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div class="mini-cart-body">
            <div class="widget_shopping_cart_content">
                <?php if ( class_exists( 'WooCommerce' ) ) { woocommerce_mini_cart(); } ?>
            </div>
        </div>
    </div>

    <div id="content" class="site-content">
