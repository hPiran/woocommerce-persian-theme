<?php
/**
 * WooCommerce Archive Product Template
 *
 * @package WooPersian_Store
 */

get_header();
?>

<div class="container">
    <main id="primary" class="content-area">

        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'صفحه اصلی', 'woo-persian-store' ); ?></a>
            <span class="separator">›</span>
            <?php if ( is_product_category() ) : ?>
                <?php
                $current_cat = get_queried_object();
                if ( $current_cat->parent ) :
                    $parent_cat = get_term( $current_cat->parent, 'product_cat' );
                    ?>
                    <a href="<?php echo esc_url( get_term_link( $parent_cat ) ); ?>"><?php echo esc_html( $parent_cat->name ); ?></a>
                    <span class="separator">›</span>
                <?php endif; ?>
                <span><?php echo esc_html( $current_cat->name ); ?></span>
            <?php elseif ( is_product_tag() ) : ?>
                <?php esc_html_e( 'برچسب: ', 'woo-persian-store' ); ?>
                <span><?php single_tag_title(); ?></span>
            <?php elseif ( is_search() ) : ?>
                <?php esc_html_e( 'نتایج جستجو برای: ', 'woo-persian-store' ); ?>
                <span>"<?php echo esc_html( get_search_query() ); ?>"</span>
            <?php else : ?>
                <span><?php esc_html_e( 'فروشگاه', 'woo-persian-store' ); ?></span>
            <?php endif; ?>
        </div>

        <!-- Archive Header -->
        <div class="archive-header mb-20">
            <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                <h1 class="archive-title">
                    <?php if ( is_product_category() || is_product_tag() ) :
                        single_term_title();
                    elseif ( is_search() :
                        printf( esc_html__( 'نتایج جستجو: "%s"', 'woo-persian-store' ), esc_html( get_search_query() ) );
                    else :
                        esc_html_e( 'فروشگاه', 'woo-persian-store' );
                    endif; ?>
                </h1>
            <?php endif; ?>

            <?php if ( is_product_category() && ! empty( term_description() ) ) : ?>
                <div class="archive-description">
                    <?php echo wp_kses_post( term_description() ); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Toolbar -->
        <div class="shop-toolbar" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:25px;flex-wrap:wrap;gap:15px;">
            <?php if ( ! woocommerce_products_will_display() ) : ?>
                <div class="woocommerce-result-count">
                    <?php woocommerce_result_count(); ?>
                </div>
            <?php endif; ?>

            <form class="woocommerce-ordering" method="get">
                <select name="orderby" class="orderby" aria-label="<?php esc_attr_e( 'مرتب‌سازی', 'woo-persian-store' ); ?>">
                    <?php foreach ( $catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
                        'menu_order' => esc_html__( 'پیش‌فرض', 'woo-persian-store' ),
                        'popularity' => esc_html__( 'محبوب‌ترین', 'woo-persian-store' ),
                        'rating'     => esc_html__( 'بالاترین امتیاز', 'woo-persian-store' ),
                        'date'       => esc_html__( 'جدیدترین', 'woo-persian-store' ),
                        'price'      => esc_html__( 'ارزان‌ترین', 'woo-persian-store' ),
                        'price-desc' => esc_html__( 'گران‌ترین', 'woo-persian-store' ),
                    ) ) as $id => $name ) : ?>
                        <option value="<?php echo esc_attr( $id ); ?>" <?php selected( woocommerce_get_loop_ordering_args()['orderby'], $id ); ?>>
                            <?php echo esc_html( $name ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
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

        <!-- Products -->
        <?php if ( woocommerce_product_loop() ) : ?>

            <?php do_action( 'woocommerce_before_shop_loop' ); ?>

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

                    <li <?php wc_product_class( 'product-card', $product ); ?>>
                        <div class="product-image">
                            <?php
                            woopersian_product_badges();
                            ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                if ( has_post_thumbnail() ) {
                                    the_post_thumbnail( 'product-card' );
                                } else {
                                    echo '<img src="' . esc_url( WOOPERSIAN_URI . '/assets/images/placeholder.png' ) . '" alt="' . esc_attr__( 'بدون تصویر', 'woo-persian-store' ) . '">';
                                }
                                ?>
                            </a>
                            <div class="product-actions">
                                <button class="product-action-btn" title="<?php esc_attr_e( 'افزودن به علاقه‌مندی‌ها', 'woo-persian-store' ); ?>">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                </button>
                                <button class="product-action-btn" title="<?php esc_attr_e( 'مشاهده سریع', 'woo-persian-store' ); ?>">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </button>
                                <button class="product-action-btn" title="<?php esc_attr_e( 'مقایسه', 'woo-persian-store' ); ?>">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <?php
                            $terms = get_the_terms( get_the_ID(), 'product_cat' );
                            if ( $terms && ! is_wp_error( $terms ) ) {
                                echo '<span class="product-category">' . esc_html( $terms[0]->name ) . '</span>';
                            }
                            ?>
                            <h3 class="product-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="product-rating">
                                <?php woopersian_product_star_rating(); ?>
                                <span class="rating-count">(<?php echo esc_html( woopersian_persian_numerals( $product->get_review_count() ) ); ?>)</span>
                            </div>
                            <div class="product-price">
                                <?php woocommerce_template_loop_price(); ?>
                            </div>
                            <?php woocommerce_template_loop_add_to_cart(); ?>
                        </div>
                    </li>

                <?php endwhile; ?>
            <?php endif; ?>

            <?php woocommerce_product_loop_end(); ?>

            <?php do_action( 'woocommerce_after_shop_loop' ); ?>

        <?php else : ?>

            <?php do_action( 'woocommerce_no_products_found' ); ?>
            <div class="no-products-found text-center" style="padding:60px 20px;">
                <span style="font-size:4rem;">🔍</span>
                <h3><?php esc_html_e( 'محصولی یافت نشد', 'woo-persian-store' ); ?></h3>
                <p><?php esc_html_e( 'متأسفانه محصولی با مشخصات مورد نظر شما پیدا نشد. لطفاً فیلترهای خود را تغییر دهید.', 'woo-persian-store' ); ?></p>
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary mt-20">
                    <?php esc_html_e( 'بازگشت به فروشگاه', 'woo-persian-store' ); ?>
                </a>
            </div>

        <?php endif; ?>

    </main>

    <!-- Sidebar -->
    <?php get_sidebar( 'product' ); ?>

</div>

<?php get_footer(); ?>
