<?php
/**
 * Search Form Template
 *
 * @package WooPersian_Store
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="search" class="search-field"
        placeholder="<?php esc_attr_e( 'جستجو برای محصولات...', 'woo-persian-store' ); ?>"
        value="<?php echo get_search_query(); ?>"
        name="s"
        title="<?php esc_attr_e( 'جستجو', 'woo-persian-store' ); ?>"
        aria-label="<?php esc_attr_e( 'جستجو', 'woo-persian-store' ); ?>">
    <input type="hidden" name="post_type" value="product">
    <button type="submit" class="search-submit" aria-label="<?php esc_attr_e( 'جستجو', 'woo-persian-store' ); ?>">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
    </button>
</form>
