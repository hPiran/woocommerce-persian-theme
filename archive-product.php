<?php
/**
 * WooCommerce Archive Product Template
 *
 * @package WooPersian_Store
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header( 'shop' );
?>

<?php do_action( 'woocommerce_before_main_content' ); ?>

<?php if ( woocommerce_products_will_display() ) : ?>

    <?php do_action( 'woocommerce_before_shop_loop' ); ?>

    <div class="container">
        <div class="site-content">
            <main id="primary" class="content-area">

                <!-- Breadcrumb -->
                <div class="breadcrumb">
                    <?php woocommerce_breadcrumb(); ?>
                </div>

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

                <?php woocommerce_product_loop_start(); ?>

                <?php if ( wc_get_loop_prop( 'total' ) ) : ?>
                    <?php while ( have_posts() ) : ?>
                        <?php the_post(); ?>
                        <?php
                        /**
                         * Hook: woocommerce_shop_loop
                         */
                        do_action( 'woocommerce_shop_loop' );
                        ?>
                        <?php wc_get_template_part( 'content', 'product' ); ?>
                    <?php endwhile; ?>
                <?php endif; ?>

                <?php woocommerce_product_loop_end(); ?>

                <?php do_action( 'woocommerce_after_shop_loop' ); ?>

            </main>

            <?php get_sidebar( 'product' ); ?>

        </div>
    </div>

<?php else : ?>

    <div class="container">
        <div class="site-content">
            <main id="primary" class="content-area">

                <?php do_action( 'woocommerce_before_shop_loop' ); ?>

                <div class="no-products-found text-center" style="padding:60px 20px;">
                    <span style="font-size:4rem;">🔍</span>
                    <h3><?php esc_html_e( 'محصولی یافت نشد', 'woo-persian-store' ); ?></h3>
                    <p><?php esc_html_e( 'متأسفانه محصولی با مشخصات مورد نظر شما پیدا نشد. لطفاً فیلترهای خود را تغییر دهید.', 'woo-persian-store' ); ?></p>
                    <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary mt-20">
                        <?php esc_html_e( 'بازگشت به فروشگاه', 'woo-persian-store' ); ?>
                    </a>
                </div>

                <?php do_action( 'woocommerce_after_shop_loop' ); ?>

            </main>
        </div>
    </div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer( 'shop' ); ?>
