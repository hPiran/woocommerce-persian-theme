<?php
/**
 * WooCommerce Archive Product Template
 *
 * Uses standard WooCommerce hooks for wrapper and loop output.
 * The wrapper open/close hooks handle the container, main, and sidebar layout.
 *
 * @package WooPersian_Store
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

/**
 * woocommerce_before_main_content
 *
 * Fires woopersian_wc_wrapper_start() which outputs:
 * <div class="container"><main id="primary" class="content-area">
 *
 * Also fires woocommerce_breadcrumb() at priority 20 if not removed.
 */
do_action( 'woocommerce_before_main_content' );

if ( woocommerce_products_will_display() ) :

    /**
     * woocommerce_before_shop_loop
     *
 * Fires result count and catalog ordering.
     */
    do_action( 'woocommerce_before_shop_loop' );

    ?>

    <!-- Archive Header -->
    <div class="archive-header mb-20">
        <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
            <h1 class="archive-title"><?php woocommerce_page_title(); ?></h1>
        <?php endif; ?>
        <?php do_action( 'woocommerce_archive_description' ); ?>
    </div>

    <!-- Toolbar -->
    <div class="shop-toolbar" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:25px;flex-wrap:wrap;gap:15px;">
        <?php woocommerce_result_count(); ?>

        <form class="woocommerce-ordering" method="get">
            <?php woocommerce_catalog_ordering(); ?>
        </form>

        <!-- Layout Toggle -->
        <div class="layout-toggle">
            <button class="layout-btn active" data-layout="grid" aria-label="<?php esc_attr_e( 'نمایش شبکه‌ای', 'woo-persian-store' ); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect></svg>
            </button>
            <button class="layout-btn" data-layout="list" aria-label="<?php esc_attr_e( 'نمایش لیستی', 'woo-persian-store' ); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
            </button>
        </div>
    </div>

    <?php
    woocommerce_product_loop_start();

    if ( wc_get_loop_prop( 'total' ) ) :
        while ( have_posts() ) :
            the_post();
            /**
             * Hook: woocommerce_shop_loop
             */
            do_action( 'woocommerce_shop_loop' );
            wc_get_template_part( 'content', 'product' );
        endwhile;
    endif;

    woocommerce_product_loop_end();

    /**
     * woocommerce_after_shop_loop
     *
     * Fires pagination.
     */
    do_action( 'woocommerce_after_shop_loop' );

else :

    /**
     * woocommerce_no_products_found
     *
     * Hook for when no products match the query.
     */
    do_action( 'woocommerce_no_products_found' );

    ?>
    <div class="no-products-found text-center" style="padding:60px 20px;">
        <span style="font-size:4rem;">🔍</span>
        <h3><?php esc_html_e( 'محصولی یافت نشد', 'woo-persian-store' ); ?></h3>
        <p><?php esc_html_e( 'متأسفانه محصولی با مشخصات مورد نظر شما پیدا نشد. لطفاً فیلترهای خود را تغییر دهید.', 'woo-persian-store' ); ?></p>
        <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary mt-20">
            <?php esc_html_e( 'بازگشت به فروشگاه', 'woo-persian-store' ); ?>
        </a>
    </div>

    <?php do_action( 'woocommerce_after_shop_loop' ); ?>

<?php endif; ?>

<?php
/**
 * woocommerce_after_main_content
 *
 * Fires woopersian_wc_wrapper_end() which outputs:
 * </main> {sidebar if active} </div><!-- .container -->
 */
do_action( 'woocommerce_after_main_content' );

get_footer();
