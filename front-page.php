<?php
/**
 * Front Page Template
 *
 * @package WooPersian_Store
 */

get_header();
?>

<div class="front-page">
    <div class="container">

        <!-- Hero Slider -->
        <section class="hero-slider" id="heroSlider">
            <div class="hero-slide">
                <div class="hero-slide-content">
                    <span class="hero-slide-tag"><?php esc_html_e( 'فروش ویژه', 'woo-persian-store' ); ?></span>
                    <h2 class="hero-slide-title"><?php esc_html_e( 'تا ۵۰٪ تخفیف روی تمام محصولات', 'woo-persian-store' ); ?></h2>
                    <p class="hero-slide-desc"><?php esc_html_e( 'فرصت را از دست ندهید! بهترین محصولات با تخفیف‌های استثنایی و ارسال رایگان برای سفارش‌های بالای ۵۰۰ هزار تومان.', 'woo-persian-store' ); ?></p>
                    <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-cta btn-lg">
                        <?php esc_html_e( 'همین حالا خرید کنید', 'woo-persian-store' ); ?>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </a>
                </div>
            </div>
            <div class="hero-slider-nav">
                <button class="hero-slider-dot active" aria-label="<?php esc_attr_e( 'اسلاید ۱', 'woo-persian-store' ); ?>"></button>
                <button class="hero-slider-dot" aria-label="<?php esc_attr_e( 'اسلاید ۲', 'woo-persian-store' ); ?>"></button>
                <button class="hero-slider-dot" aria-label="<?php esc_attr_e( 'اسلاید ۳', 'woo-persian-store' ); ?>"></button>
            </div>
        </section>

        <!-- Trust Badges -->
        <section class="trust-badges">
            <div class="trust-badge">
                <span class="badge-icon">🚚</span>
                <h5 class="badge-title"><?php esc_html_e( 'ارسال رایگان', 'woo-persian-store' ); ?></h5>
                <p class="badge-desc"><?php esc_html_e( 'برای سفارش‌های بالای ۵۰۰ هزار تومان', 'woo-persian-store' ); ?></p>
            </div>
            <div class="trust-badge">
                <span class="badge-icon">🔒</span>
                <h5 class="badge-title"><?php esc_html_e( 'پرداخت امن', 'woo-persian-store' ); ?></h5>
                <p class="badge-desc"><?php esc_html_e( 'درگاه پرداخت معتبر بانکی', 'woo-persian-store' ); ?></p>
            </div>
            <div class="trust-badge">
                <span class="badge-icon">↩️</span>
                <h5 class="badge-title"><?php esc_html_e( 'ضمانت بازگشت', 'woo-persian-store' ); ?></h5>
                <p class="badge-desc"><?php esc_html_e( '۷ روز ضمانت بازگشت کالا', 'woo-persian-store' ); ?></p>
            </div>
            <div class="trust-badge">
                <span class="badge-icon">🎧</span>
                <h5 class="badge-title"><?php esc_html_e( 'پشتیبانی ۲۴/۷', 'woo-persian-store' ); ?></h5>
                <p class="badge-desc"><?php esc_html_e( 'پاسخگویی در تمام ساعات شبانه‌روز', 'woo-persian-store' ); ?></p>
            </div>
        </section>

        <!-- Featured Categories -->
        <section class="featured-categories mt-40">
            <div class="section-header">
                <h2 class="section-title"><?php esc_html_e( 'دسته‌بندی‌های محبوب', 'woo-persian-store' ); ?></h2>
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="section-link">
                    <?php esc_html_e( 'مشاهده همه', 'woo-persian-store' ); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </a>
            </div>
            <div class="categories-grid">
                <?php
                $featured_cats = get_terms( array(
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => true,
                    'number'     => 6,
                    'orderby'    => 'count',
                    'order'      => 'DESC',
                ) );

                $cat_icons = array( '👕', '📱', '🏠', '💄', '👟', '🎮' );
                $cat_index = 0;

                if ( ! is_wp_error( $featured_cats ) && ! empty( $featured_cats ) ) :
                    foreach ( $featured_cats as $cat ) :
                        $cat_thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                        $cat_count = $cat->count;
                        $icon = isset( $cat_icons[ $cat_index % count( $cat_icons ) ] ) ? $cat_icons[ $cat_index % count( $cat_icons ) ] : '📦';
                        $cat_index++;
                ?>
                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="category-card">
                        <div class="cat-icon"><?php echo esc_html( $icon ); ?></div>
                        <h4 class="cat-name"><?php echo esc_html( $cat->name ); ?></h4>
                        <span class="cat-count"><?php echo esc_html( woopersian_persian_numerals( $cat_count ) ); ?> <?php esc_html_e( 'محصول', 'woo-persian-store' ); ?></span>
                    </a>
                <?php
                    endforeach;
                else :
                ?>
                    <a href="#" class="category-card">
                        <div class="cat-icon">👕</div>
                        <h4 class="cat-name"><?php esc_html_e( 'پوشاک', 'woo-persian-store' ); ?></h4>
                        <span class="cat-count"><?php esc_html_e( 'محصولات', 'woo-persian-store' ); ?></span>
                    </a>
                    <a href="#" class="category-card">
                        <div class="cat-icon">📱</div>
                        <h4 class="cat-name"><?php esc_html_e( 'دیجیتال', 'woo-persian-store' ); ?></h4>
                        <span class="cat-count"><?php esc_html_e( 'محصولات', 'woo-persian-store' ); ?></span>
                    </a>
                    <a href="#" class="category-card">
                        <div class="cat-icon">🏠</div>
                        <h4 class="cat-name"><?php esc_html_e( 'خانه و آشپزخانه', 'woo-persian-store' ); ?></h4>
                        <span class="cat-count"><?php esc_html_e( 'محصولات', 'woo-persian-store' ); ?></span>
                    </a>
                    <a href="#" class="category-card">
                        <div class="cat-icon">💄</div>
                        <h4 class="cat-name"><?php esc_html_e( 'زیبایی و سلامت', 'woo-persian-store' ); ?></h4>
                        <span class="cat-count"><?php esc_html_e( 'محصولات', 'woo-persian-store' ); ?></span>
                    </a>
                    <a href="#" class="category-card">
                        <div class="cat-icon">👟</div>
                        <h4 class="cat-name"><?php esc_html_e( 'کیف و کفش', 'woo-persian-store' ); ?></h4>
                        <span class="cat-count"><?php esc_html_e( 'محصولات', 'woo-persian-store' ); ?></span>
                    </a>
                    <a href="#" class="category-card">
                        <div class="cat-icon">🎮</div>
                        <h4 class="cat-name"><?php esc_html_e( 'ورزش و سرگرمی', 'woo-persian-store' ); ?></h4>
                        <span class="cat-count"><?php esc_html_e( 'محصولات', 'woo-persian-store' ); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </section>

        <!-- New Products -->
        <section class="new-products mt-40">
            <div class="section-header">
                <h2 class="section-title"><?php esc_html_e( 'جدیدترین محصولات', 'woo-persian-store' ); ?></h2>
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="section-link">
                    <?php esc_html_e( 'مشاهده همه', 'woo-persian-store' ); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </a>
            </div>
            <div class="products-grid">
                <?php
                $new_products = new WP_Query( array(
                    'post_type'      => 'product',
                    'posts_per_page' => 8,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ) );

                if ( $new_products->have_posts() ) :
                    while ( $new_products->have_posts() ) : $new_products->the_post();
                        wc_get_template_part( 'content', 'product' );
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <p class="text-center text-muted" style="grid-column: 1 / -1;"><?php esc_html_e( 'محصولی یافت نشد.', 'woo-persian-store' ); ?></p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Special Deals Banners -->
        <section class="special-deals">
            <div class="deals-banner">
                <div class="deal-card">
                    <div class="deal-card-content">
                        <h3><?php esc_html_e( 'حراج بزرگ تابستانه', 'woo-persian-store' ); ?></h3>
                        <p><?php esc_html_e( 'تا ۷۰٪ تخفیف روی محصولات منتخب. فرصت محدود!', 'woo-persian-store' ); ?></p>
                        <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn"><?php esc_html_e( 'خرید کنید', 'woo-persian-store' ); ?></a>
                    </div>
                </div>
                <div class="deal-card">
                    <div class="deal-card-content">
                        <h3><?php esc_html_e( 'محصولات نو برند', 'woo-persian-store' ); ?></h3>
                        <p><?php esc_html_e( 'جدیدترین محصولات برندهای معتبر با گارانتی اصالت کالا', 'woo-persian-store' ); ?></p>
                        <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn"><?php esc_html_e( 'مشاهده کنید', 'woo-persian-store' ); ?></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sale Products -->
        <section class="sale-products mt-40">
            <div class="section-header">
                <h2 class="section-title"><?php esc_html_e( 'محصولات تخفیف‌دار', 'woo-persian-store' ); ?></h2>
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="section-link">
                    <?php esc_html_e( 'مشاهده همه', 'woo-persian-store' ); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </a>
            </div>
            <div class="products-grid">
                <?php
                $sale_products = new WP_Query( array(
                    'post_type'      => 'product',
                    'posts_per_page' => 4,
                    'meta_query'     => array(
                        'relation' => 'OR',
                        array(
                            'key'     => '_sale_price',
                            'value'   => 0,
                            'compare' => '>',
                            'type'    => 'NUMERIC',
                        ),
                    ),
                ) );

                if ( $sale_products->have_posts() ) :
                    while ( $sale_products->have_posts() ) : $sale_products->the_post();
                        wc_get_template_part( 'content', 'product' );
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <p class="text-center text-muted" style="grid-column: 1 / -1;"><?php esc_html_e( 'در حال حاضر محصول تخفیف‌داری موجود نیست.', 'woo-persian-store' ); ?></p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="featured-products mt-40 mb-40">
            <div class="section-header">
                <h2 class="section-title"><?php esc_html_e( 'محصولات ویژه', 'woo-persian-store' ); ?></h2>
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="section-link">
                    <?php esc_html_e( 'مشاهده همه', 'woo-persian-store' ); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </a>
            </div>
            <div class="products-grid">
                <?php
                $featured_products = new WP_Query( array(
                    'post_type'      => 'product',
                    'posts_per_page' => 8,
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'product_visibility',
                            'field'    => 'name',
                            'terms'    => 'featured',
                        ),
                    ),
                ) );

                if ( $featured_products->have_posts() ) :
                    while ( $featured_products->have_posts() ) : $featured_products->the_post();
                        wc_get_template_part( 'content', 'product' );
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <p class="text-center text-muted" style="grid-column: 1 / -1;"><?php esc_html_e( 'محصول ویژه‌ای وجود ندارد.', 'woo-persian-store' ); ?></p>
                <?php endif; ?>
            </div>
        </section>

    </div><!-- .container -->
</div><!-- .front-page -->

<?php get_footer(); ?>
