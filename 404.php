<?php
/**
 * 404 Error Page Template
 *
 * @package WooPersian_Store
 */

get_header();
?>

<div class="container">
    <main id="primary" class="content-area">
        <div class="error-404">
            <div class="error-code">۴۰۴</div>
            <h1 class="error-title"><?php esc_html_e( 'صفحه مورد نظر یافت نشد!', 'woo-persian-store' ); ?></h1>
            <p class="error-desc"><?php esc_html_e( 'متأسفانه صفحه‌ای که دنبال آن هستید وجود ندارد، حذف شده یا تغییر آدرس داده است.', 'woo-persian-store' ); ?></p>

            <?php get_search_form(); ?>

            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary mt-20">
                <?php esc_html_e( 'بازگشت به صفحه اصلی', 'woo-persian-store' ); ?>
            </a>

            <div class="mt-40">
                <h4 style="margin-bottom:15px;"><?php esc_html_e( 'صفحات مفید:', 'woo-persian-store' ); ?></h4>
                <div style="display:flex;flex-wrap:wrap;gap:10px;justify-content:center;">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-outline btn-sm"><?php esc_html_e( 'صفحه اصلی', 'woo-persian-store' ); ?></a>
                    <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-outline btn-sm"><?php esc_html_e( 'فروشگاه', 'woo-persian-store' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-outline btn-sm"><?php esc_html_e( 'تماس با ما', 'woo-persian-store' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="btn btn-outline btn-sm"><?php esc_html_e( 'وبلاگ', 'woo-persian-store' ); ?></a>
                </div>
            </div>
        </div>
    </main>
</div>

<?php get_footer(); ?>
