<?php
/**
 * Single Post Template
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
            <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'وبلاگ', 'woo-persian-store' ); ?></a>
            <span class="separator">›</span>
            <?php
            $categories = get_the_category();
            if ( $categories ) {
                echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                echo '<span class="separator">›</span>';
            }
            ?>
            <span><?php the_title(); ?></span>
        </div>

        <?php while ( have_posts() ) : the_post(); ?>

            <article <?php post_class(); ?>>
                <!-- Post Header -->
                <div class="single-post-header">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div style="margin-bottom:30px;border-radius:12px;overflow:hidden;">
                            <?php the_post_thumbnail( 'large' ); ?>
                        </div>
                    <?php endif; ?>

                    <?php the_title( '<h1>', '</h1>' ); ?>

                    <div class="post-meta" style="margin-top:15px;">
                        <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-left:4px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            <?php echo esc_html( woopersian_persian_numerals( get_the_date( 'j F Y' ) ); ?>
                        </time>
                        <span class="meta-divider">•</span>
                        <span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-left:4px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <?php the_author(); ?>
                        </span>
                        <span class="meta-divider">•</span>
                        <span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-left:4px;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            <?php
                            printf(
                                esc_html( _n( '%s نظر', '%s نظر', get_comments_number(), 'woo-persian-store' ) ),
                                woopersian_persian_numerals( get_comments_number() )
                            );
                            ?>
                        </span>
                        <?php if ( has_category() ) : ?>
                            <span class="meta-divider">•</span>
                            <span><?php the_category( '، ' ); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Post Content -->
                <div class="single-post-content">
                    <?php
                    the_content();

                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . esc_html__( 'صفحات:', 'woo-persian-store' ),
                        'after'  => '</div>',
                    ) );
                    ?>
                </div>

                <!-- Tags -->
                <?php $tags_list = get_the_tag_list(); ?>
                <?php if ( $tags_list ) : ?>
                <div class="post-tags" style="margin-top:30px;padding-top:20px;border-top:1px solid #e0e0e0;">
                    <span style="font-weight:700;margin-left:10px;"><?php esc_html_e( 'برچسب‌ها:', 'woo-persian-store' ); ?></span>
                    <?php echo wp_kses_post( $tags_list ); ?>
                </div>
                <?php endif; ?>

                <!-- Post Navigation -->
                <nav class="post-navigation" aria-label="<?php esc_attr_e( 'ناوبری نوشته‌ها', 'woo-persian-store' ); ?>">
                    <div class="post-nav-next">
                        <?php
                        $prev_post = get_previous_post();
                        if ( ! empty( $prev_post ) ) :
                        ?>
                            <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="post-nav-link">
                                <span class="nav-label"><?php esc_html_e( 'نوشته قبلی', 'woo-persian-store' ); ?></span>
                                <span class="nav-title"><?php echo esc_html( $prev_post->post_title ); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="post-nav-prev">
                        <?php
                        $next_post = get_next_post();
                        if ( ! empty( $next_post ) ) :
                        ?>
                            <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="post-nav-link">
                                <span class="nav-label"><?php esc_html_e( 'نوشته بعدی', 'woo-persian-store' ); ?></span>
                                <span class="nav-title"><?php echo esc_html( $next_post->post_title ); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </nav>

                <!-- Author Box -->
                <div class="author-box" style="display:flex;gap:20px;padding:25px;background:#f5f5f5;border-radius:12px;margin-top:30px;align-items:center;">
                    <div style="flex-shrink:0;">
                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 80, '', '', array( 'style' => 'border-radius:50%;' ) ); ?>
                    </div>
                    <div>
                        <h4 style="margin-bottom:5px;"><?php the_author(); ?></h4>
                        <p style="font-size:0.9rem;color:#616161;margin-bottom:0;"><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
                    </div>
                </div>

                <!-- Comments -->
                <?php if ( comments_open() || get_comments_number() ) : ?>
                    <div class="comments-section mt-40">
                        <?php comments_template(); ?>
                    </div>
                <?php endif; ?>

            </article>

        <?php endwhile; ?>

    </main>
</div>

<?php get_footer(); ?>
