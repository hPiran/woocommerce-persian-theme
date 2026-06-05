<?php
/**
 * Single Product Template
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
            <?php
            $terms = get_the_terms( get_the_ID(), 'product_cat' );
            if ( $terms && ! is_wp_error( $terms ) ) :
                $cat_link = get_term_link( $terms[0] );
                ?>
                <a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $terms[0]->name ); ?></a>
                <span class="separator">›</span>
            <?php endif; ?>
            <span><?php the_title(); ?></span>
        </div>

        <?php while ( have_posts() ) : the_post(); ?>

            <div class="single-product-wrapper">
                <!-- Product Gallery -->
                <div class="product-gallery">
                    <div class="product-gallery-main">
                        <?php
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail( 'product-large' );
                        } else {
                            echo '<img src="' . esc_url( WOOPERSIAN_URI . '/assets/images/placeholder.png' ) . '" alt="' . esc_attr__( 'بدون تصویر', 'woo-persian-store' ) . '">';
                        }
                        ?>
                    </div>
                    <?php
                    $attachment_ids = $product->get_gallery_image_ids();
                    if ( ! empty( $attachment_ids ) ) :
                    ?>
                    <div class="product-gallery-thumbs">
                        <?php
                        $main_thumb = get_post_thumbnail_id( get_the_ID() );
                        echo '<img src="' . esc_url( wp_get_attachment_image_url( $main_thumb, 'product-gallery-thumb' ) ) . '" class="active" alt="' . esc_attr__( 'تصویر محصول', 'woo-persian-store' ) . '">';
                        foreach ( $attachment_ids as $attachment_id ) :
                            echo '<img src="' . esc_url( wp_get_attachment_image_url( $attachment_id, 'product-gallery-thumb' ) ) . '" alt="' . esc_attr__( 'تصویر محصول', 'woo-persian-store' ) . '">';
                        endforeach;
                        ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Product Summary -->
                <div class="product-summary">
                    <?php woopersian_product_badges(); ?>

                    <h1 class="product-title"><?php the_title(); ?></h1>

                    <div class="product-meta">
                        <span class="product-sku">
                            <?php if ( $product->get_sku() ) : ?>
                                <?php printf( esc_html__( 'کد محصول: %s', 'woo-persian-store' ), esc_html( woopersian_persian_numerals( $product->get_sku() ) ) ); ?>
                            <?php endif; ?>
                        </span>
                        <span class="meta-divider">|</span>
                        <span class="product-rating">
                            <?php woopersian_product_star_rating(); ?>
                            <?php printf( esc_html__( '(%s نظر)', 'woo-persian-store' ), woopersian_persian_numerals( $product->get_review_count() ) ); ?>
                        </span>
                    </div>

                    <?php if ( $product->is_on_sale() ) : ?>
                        <?php
                        $regular_price = (float) $product->get_regular_price();
                        $sale_price    = (float) $product->get_sale_price();
                        if ( $regular_price > 0 && $sale_price > 0 ) {
                            $discount = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
                        }
                        ?>
                        <div class="sale-banner" style="background:#fff3e0;padding:10px 15px;border-radius:8px;margin-bottom:15px;display:flex;align-items:center;gap:10px;">
                            <span style="color:#f57c00;font-weight:700;font-size:0.9rem;">
                                <?php printf( esc_html__( '!%s%% تخفیف', 'woo-persian-store' ), woopersian_persian_numerals( $discount ) ); ?>
                            </span>
                            <span style="color:#616161;font-size:0.85rem;">
                                <?php esc_html_e( 'قیمت قبل:', 'woo-persian-store' ); ?>
                                <del><?php echo wc_price( $regular_price ); ?></del>
                            </span>
                        </div>
                    <?php endif; ?>

                    <div class="price">
                        <?php woocommerce_template_single_price(); ?>
                    </div>

                    <?php woocommerce_template_single_excerpt(); ?>

                    <?php if ( $product->is_in_stock() ) : ?>
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:15px;">
                            <span style="width:10px;height:10px;border-radius:50%;background:#2e7d32;display:inline-block;"></span>
                            <span style="font-size:0.9rem;color:#2e7d32;font-weight:600;"><?php esc_html_e( 'موجود در انبار', 'woo-persian-store' ); ?></span>
                        </div>
                    <?php else : ?>
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:15px;">
                            <span style="width:10px;height:10px;border-radius:50%;background:#c62828;display:inline-block;"></span>
                            <span style="font-size:0.9rem;color:#c62828;font-weight:600;"><?php esc_html_e( 'ناموجود', 'woo-persian-store' ); ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="quantity-wrapper">
                        <button type="button" class="qty-btn qty-minus">−</button>
                        <input type="number" class="quantity-input" name="quantity" value="<?php echo esc_attr( apply_filters( 'woocommerce_quantity_input_min', 1, $product ) ); ?>" min="<?php echo esc_attr( apply_filters( 'woocommerce_quantity_input_min', 1, $product ) ); ?>" max="<?php echo esc_attr( apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ) ); ?>">
                        <button type="button" class="qty-btn qty-plus">+</button>
                    </div>

                    <?php woocommerce_template_single_add_to_cart(); ?>

                    <!-- Extra Info -->
                    <div class="product-extra-info" style="margin-top:25px;padding-top:20px;border-top:1px solid #e0e0e0;display:grid;grid-template-columns:1fr 1fr;gap:15px;">
                        <div style="display:flex;align-items:center;gap:10px;font-size:0.85rem;color:#616161;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            <span><?php esc_html_e( 'ارسال سریع', 'woo-persian-store' ); ?></span>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;font-size:0.85rem;color:#616161;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <span><?php esc_html_e( 'ضمانت اصالت', 'woo-persian-store' ); ?></span>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;font-size:0.85rem;color:#616161;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                            <span><?php esc_html_e( 'بازگشت ۷ روزه', 'woo-persian-store' ); ?></span>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;font-size:0.85rem;color:#616161;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            <span><?php esc_html_e( 'پرداخت امن', 'woo-persian-store' ); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Tabs -->
            <div class="product-tabs mt-40">
                <div class="tabs">
                    <button class="tab active" data-tab="description"><?php esc_html_e( 'توضیحات', 'woo-persian-store' ); ?></button>
                    <?php if ( $product->get_attributes() ) : ?>
                        <button class="tab" data-tab="attributes"><?php esc_html_e( 'مشخصات فنی', 'woo-persian-store' ); ?></button>
                    <?php endif; ?>
                    <button class="tab" data-tab="reviews">
                        <?php printf( esc_html__( 'نظرات (%s)', 'woo-persian-store' ), woopersian_persian_numerals( $product->get_review_count() ) ); ?>
                    </button>
                </div>

                <div class="tab-content" id="tab-description">
                    <?php the_content(); ?>
                </div>

                <?php if ( $product->get_attributes() ) : ?>
                <div class="tab-content" id="tab-attributes" style="display:none;">
                    <table class="shop_attributes" style="width:100%;border-collapse:collapse;">
                        <?php foreach ( $product->get_attributes() as $attribute ) :
                            $values = $attribute->is_taxonomy() ? wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'names' ) ) : $attribute->get_options();
                        ?>
                        <tr style="border-bottom:1px solid #e0e0e0;">
                            <th style="padding:12px;text-align:right;width:35%;font-weight:600;"><?php echo esc_html( wc_attribute_label( $attribute->get_name() ) ); ?></th>
                            <td style="padding:12px;"><?php echo esc_html( implode( '، ', $values ) ); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>

                <div class="tab-content" id="tab-reviews" style="display:none;">
                    <?php comments_template(); ?>
                </div>
            </div>

            <!-- Related Products -->
            <?php
            $related_products = wc_get_related_products( $product->get_id(), 4 );
            if ( $related_products ) :
            ?>
            <section class="related-products mt-40">
                <div class="section-header">
                    <h2 class="section-title"><?php esc_html_e( 'محصولات مرتبط', 'woo-persian-store' ); ?></h2>
                </div>
                <div class="products-grid">
                    <?php foreach ( $related_products as $related_product ) :
                        $post = get_post( $related_product );
                        setup_postdata( $post );
                        wc_get_template_part( 'content', 'product' );
                    endforeach;
                    wp_reset_postdata();
                    ?>
                </div>
            </section>
            <?php endif; ?>

        <?php endwhile; ?>

    </main>
</div>

<?php get_footer(); ?>
