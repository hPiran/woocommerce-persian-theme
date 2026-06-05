<?php
/**
 * Blog Index / Archive Template
 *
 * @package WooPersian_Store
 */

get_header();
?>

<div class="container">
    <div class="site-content">
        <div class="content-area" style="display:flex;flex-direction:column;gap:30px;">

            <!-- Archive Header -->
            <div class="archive-header">
                <?php if ( is_home() && ! is_front_page() ) : ?>
                    <h1><?php single_post_title(); ?></h1>
                <?php elseif ( is_category() ) : ?>
                    <h1><?php single_cat_title(); ?></h1>
                    <?php if ( category_description() ) : ?>
                        <div class="archive-description"><?php echo wp_kses_post( category_description() ); ?></div>
                    <?php endif; ?>
                <?php elseif ( is_tag() ) : ?>
                    <h1><?php single_tag_title(); ?></h1>
                <?php elseif ( is_author() ) : ?>
                    <h1><?php printf( esc_html__( 'نوشته‌های %s', 'woo-persian-store' ), get_the_author() ); ?></h1>
                <?php elseif ( is_archive() ) : ?>
                    <h1><?php the_archive_title(); ?></h1>
                    <?php if ( is_day() ) : ?>
                        <div class="archive-description"><?php echo esc_html( get_the_date() ); ?></div>
                    <?php elseif ( is_month() ) : ?>
                        <div class="archive-description"><?php echo esc_html( get_the_date( 'F Y' ) ); ?></div>
                    <?php endif; ?>
                <?php else : ?>
                    <h1><?php esc_html_e( 'وبلاگ', 'woo-persian-store' ); ?></h1>
                <?php endif; ?>
            </div>

            <!-- Posts Grid -->
            <?php if ( have_posts() ) : ?>
                <div class="posts-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article <?php post_class( 'post-card' ); ?>>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'blog-thumb' ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="post-content">
                                <div class="post-meta">
                                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                        <?php echo esc_html( woopersian_persian_numerals( get_the_date( 'j F Y' ) ) ); ?>
                                    </time>
                                    <span class="meta-divider">•</span>
                                    <span><?php esc_html_e( 'توسط', 'woo-persian-store' ); ?> <?php the_author(); ?></span>
                                </div>

                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>

                                <div class="post-excerpt">
                                    <?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-sm mt-20">
                                    <?php esc_html_e( 'ادامه مطلب', 'woo-persian-store' ); ?>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="woocommerce-pagination">
                    <?php
                    the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => '→',
                        'next_text' => '←',
                    ) );
                    ?>
                </div>

            <?php else : ?>
                <div class="text-center" style="padding:60px 20px;">
                    <span style="font-size:4rem;">📝</span>
                    <h3><?php esc_html_e( 'مطلبی یافت نشد', 'woo-persian-store' ); ?></h3>
                    <p><?php esc_html_e( 'در حال حاضر نوشته‌ای موجود نیست.', 'woo-persian-store' ); ?></p>
                </div>
            <?php endif; ?>

        </div><!-- .content-area -->

        <!-- Blog Sidebar -->
        <?php if ( is_active_sidebar( 'blog-sidebar' ) ) : ?>
            <aside id="secondary" class="widget-area sidebar">
                <?php dynamic_sidebar( 'blog-sidebar' ); ?>
            </aside>
        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>
