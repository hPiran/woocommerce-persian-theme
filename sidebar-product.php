<?php
/**
 * Product Sidebar Template
 *
 * @package WooPersian_Store
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<aside id="secondary" class="widget-area sidebar">

    <!-- Search Widget -->
    <div class="widget">
        <h3 class="widget-title"><?php esc_html_e( 'جستجو در محصولات', 'woo-persian-store' ); ?></h3>
        <?php get_search_form(); ?>
    </div>

    <!-- Categories Widget -->
    <div class="widget">
        <h3 class="widget-title"><?php esc_html_e( 'دسته‌بندی‌ها', 'woo-persian-store' ); ?></h3>
        <ul>
            <?php
            $product_categories = get_terms( array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'parent'     => 0,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ) );

            if ( ! is_wp_error( $product_categories ) && ! empty( $product_categories ) ) :
                $current_cat = get_queried_object_id();
                foreach ( $product_categories as $cat ) :
            ?>
                <li>
                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" <?php echo ( $current_cat === $cat->term_id ) ? 'style="color:#1a73e8;font-weight:600;"' : ''; ?>>
                        <span><?php echo esc_html( $cat->name ); ?></span>
                        <span>(<?php echo esc_html( woopersian_persian_numerals( $cat->count ) ); ?>)</span>
                    </a>
                    <?php
                    $sub_cats = get_terms( array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => true,
                        'parent'     => $cat->term_id,
                    ) );
                    if ( ! is_wp_error( $sub_cats ) && ! empty( $sub_cats ) ) :
                    ?>
                    <ul style="padding-right:15px;margin-top:5px;">
                        <?php foreach ( $sub_cats as $sub_cat ) : ?>
                            <li>
                                <a href="<?php echo esc_url( get_term_link( $sub_cat ) ); ?>" <?php echo ( $current_cat === $sub_cat->term_id ) ? 'style="color:#1a73e8;font-weight:600;"' : ''; ?>>
                                    <span><?php echo esc_html( $sub_cat->name ); ?></span>
                                    <span>(<?php echo esc_html( woopersian_persian_numerals( $sub_cat->count ) ); ?>)</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </li>
            <?php
                endforeach;
            else :
            ?>
                <li><?php esc_html_e( 'دسته‌بندی‌ای وجود ندارد.', 'woo-persian-store' ); ?></li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Price Filter Widget -->
    <div class="widget">
        <h3 class="widget-title"><?php esc_html_e( 'فیلتر قیمت', 'woo-persian-store' ); ?></h3>
        <div class="price-filter">
            <form method="get" action="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
                <div style="margin-bottom:12px;">
                    <label for="min_price"><?php esc_html_e( 'حداقل قیمت (تومان):', 'woo-persian-store' ); ?></label>
                    <input type="number" id="min_price" name="min_price" placeholder="<?php esc_attr_e( 'از', 'woo-persian-store' ); ?>" min="0"
                        value="<?php echo isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : ''; ?>"
                        style="width:100%;padding:10px;border:1px solid #e0e0e0;border-radius:8px;margin-top:5px;direction:rtl;">
                </div>
                <div style="margin-bottom:15px;">
                    <label for="max_price"><?php esc_html_e( 'حداکثر قیمت (تومان):', 'woo-persian-store' ); ?></label>
                    <input type="number" id="max_price" name="max_price" placeholder="<?php esc_attr_e( 'تا', 'woo-persian-store' ); ?>" min="0"
                        value="<?php echo isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : ''; ?>"
                        style="width:100%;padding:10px;border:1px solid #e0e0e0;border-radius:8px;margin-top:5px;direction:rtl;">
                </div>
                <button type="submit" class="btn btn-primary btn-sm" style="width:100%;">
                    <?php esc_html_e( 'اعمال فیلتر', 'woo-persian-store' ); ?>
                </button>
            </form>
        </div>
    </div>

    <!-- Popular Tags Widget -->
    <div class="widget">
        <h3 class="widget-title"><?php esc_html_e( 'برچسب‌های محبوب', 'woo-persian-store' ); ?></h3>
        <div class="tag-cloud" style="display:flex;flex-wrap:wrap;gap:8px;">
            <?php
            $product_tags = get_terms( array(
                'taxonomy'   => 'product_tag',
                'hide_empty' => true,
                'number'     => 15,
                'orderby'    => 'count',
                'order'      => 'DESC',
            ) );

            if ( ! is_wp_error( $product_tags ) && ! empty( $product_tags ) ) :
                foreach ( $product_tags as $tag ) :
            ?>
                <a href="<?php echo esc_url( get_term_link( $tag ) ); ?>"
                   style="display:inline-block;padding:5px 12px;background:#f5f5f5;border-radius:20px;font-size:0.8rem;color:#616161;transition:all 0.3s ease;">
                    <?php echo esc_html( $tag->name ); ?>
                </a>
            <?php endforeach; else : ?>
                <span class="text-muted"><?php esc_html_e( 'برچسبی وجود ندارد.', 'woo-persian-store' ); ?></span>
            <?php endif; ?>
        </div>
    </div>

    <!-- On Sale Widget -->
    <div class="widget">
        <h3 class="widget-title"><?php esc_html_e( 'محصولات تخفیف‌دار', 'woo-persian-store' ); ?></h3>
        <?php
        $sale_args = array(
            'post_type'      => 'product',
            'posts_per_page' => 5,
            'meta_query'     => array(
                array(
                    'key'     => '_sale_price',
                    'value'   => 0,
                    'compare' => '>',
                    'type'    => 'NUMERIC',
                ),
            ),
            'orderby'        => 'rand',
        );
        $sale_products = new WP_Query( $sale_args );

        if ( $sale_products->have_posts() ) :
            while ( $sale_products->have_posts() ) : $sale_products->the_post();
                $sale_product = wc_get_product( get_the_ID() );
        ?>
            <div style="display:flex;gap:12px;padding:12px 0;border-bottom:1px solid #f5f5f5;">
                <a href="<?php the_permalink(); ?>" style="flex-shrink:0;">
                    <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail( 'thumbnail' );
                    } else {
                        echo '<img src="' . esc_url( WOOPERSIAN_URI . '/assets/images/placeholder.png' ) . '" alt="" width="60" height="60" style="object-fit:cover;border-radius:8px;">';
                    }
                    ?>
                </a>
                <div>
                    <a href="<?php the_permalink(); ?>" style="font-size:0.85rem;font-weight:600;color:#212121;display:block;margin-bottom:5px;">
                        <?php the_title(); ?>
                    </a>
                    <span style="font-size:0.85rem;font-weight:700;color:#1a73e8;">
                        <?php echo $sale_product->get_price_html(); ?>
                    </span>
                </div>
            </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
        ?>
            <p class="text-muted" style="font-size:0.85rem;"><?php esc_html_e( 'در حال حاضر محصول تخفیف‌داری وجود ندارد.', 'woo-persian-store' ); ?></p>
        <?php endif; ?>
    </div>

    <?php dynamic_sidebar( 'shop-sidebar' ); ?>

</aside>
