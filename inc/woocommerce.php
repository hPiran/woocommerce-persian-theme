<?php
/**
 * Custom WooCommerce functions for the Persian theme.
 *
 * Extends WooCommerce with RTL/Persian-friendly features: product badges,
 * AJAX mini-cart, Persian price formatting, and shop loop defaults.
 *
 * @package WC_Persian
 */

defined( 'ABSPATH' ) || exit;

/**
 * Convert Western Arabic numerals (0-9) to Persian numerals (۰-۹).
 *
 * @param string $value String containing digits.
 * @return string Digits replaced with Persian equivalents.
 */
function wc_persian_convert_numerals( $value ) {
	$western = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
	$persian = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
	return str_replace( $western, $persian, (string) $value );
}

/**
 * Format product prices with Persian numerals and the تومان (Toman) suffix.
 *
 * Hooks into `woocommerce_get_price_html` so every price across the shop
 * is automatically displayed in Persian format.
 *
 * @param string      $price    Formatted price HTML from WooCommerce.
 * @param WC_Product  $product  Product object.
 * @return string Modified price HTML.
 */
function wc_persian_price_format( $price, $product ) {
	// Remove any existing "تومان" the user may have set in WC currency settings
	// to avoid duplication, then re-append it.
	$price = str_replace( array( 'تومان', 'Toman', 'toman', 'TOMAN' ), '', $price );
	$price = trim( $price );

	// Convert digits to Persian.
	$price = wc_persian_convert_numerals( $price );

	$suffix = ' <span class="price-suffix">' . esc_html__( 'تومان', 'wc-persian' ) . '</span>';

	// Append the Toman label before the closing </span> if one exists,
	// otherwise tack it onto the end.
	$price = preg_replace( '#</(span|bdi)>$#', $suffix . '</$1>', $price );
	if ( strpos( $price, 'price-suffix' ) === false ) {
		$price .= $suffix;
	}

	return $price;
}
add_filter( 'woocommerce_get_price_html', 'wc_persian_price_format', 10, 2 );

/**
 * Replace the default WooCommerce sale flash badge with a Persian version.
 *
 * @param string     $html   Default sale badge HTML.
 * @param WC_Product $post   Product object (named $post for historical reasons).
 * @param WC_Product $product Product object.
 * @return string Custom badge HTML.
 */
function wc_persian_sale_flash( $html, $post, $product ) {
	if ( ! $product->is_on_sale() ) {
		return '';
	}

	if ( $product->is_type( 'variable' ) ) {
		$percentages = array();

		foreach ( $product->get_children() as $child_id ) {
			$child = wc_get_product( $child_id );
			if ( $child && $child->is_on_sale() ) {
				$regular = (float) $child->get_regular_price();
				$sale    = (float) $child->get_sale_price();
				if ( $regular > 0 ) {
					$percentages[] = round( ( ( $regular - $sale ) / $regular ) * 100 );
				}
			}
		}

		if ( ! empty( $percentages ) ) {
			$max_percent = max( $percentages );
			$label       = sprintf(
				/* translators: %s: discount percentage */
				esc_html__( 'حراج! %s%%', 'wc-persian' ),
				wc_persian_convert_numerals( $max_percent )
			);
		} else {
			$label = esc_html__( 'حراج!', 'wc-persian' );
		}
	} else {
		$regular = (float) $product->get_regular_price();
		$sale    = (float) $product->get_sale_price();
		$percent = ( $regular > 0 ) ? round( ( ( $regular - $sale ) / $regular ) * 100 ) : 0;

		$label = $percent > 0
			? sprintf( esc_html__( 'حراج! %s%%', 'wc-persian' ), wc_persian_convert_numerals( $percent ) )
			: esc_html__( 'حراج!', 'wc-persian' );
	}

	return '<span class="onsale badge-sale">' . $label . '</span>';
}
add_filter( 'woocommerce_sale_flash', 'wc_persian_sale_flash', 10, 3 );

/**
 * Display product badges: sale, new, and featured.
 *
 * Hooked into `woocommerce_before_shop_loop_item_title` at priority 10 so
 * badges appear overlaid on the product image.
 */
function wc_persian_product_badges() {
	global $product;

	if ( ! $product ) {
		return;
	}

	echo '<div class="product-badges">';

	// Featured badge.
	if ( $product->is_featured() ) {
		echo '<span class="badge badge-featured">' . esc_html__( 'ویژه!', 'wc-persian' ) . '</span>';
	}

	// New badge — products created within the last 30 days.
	$created = get_the_date( 'U', $product->get_id() );
	if ( $created && ( time() - $created ) < 30 * DAY_IN_SECONDS ) {
		echo '<span class="badge badge-new">' . esc_html__( 'جدید!', 'wc-persian' ) . '</span>';
	}

	// Sale badge is handled by wc_persian_sale_flash hooked into woocommerce_sale_flash,
	// so we skip it here to avoid duplication.

	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop_item_title', 'wc_persian_product_badges', 10 );

/**
 * Output the AJAX mini-cart sidebar markup.
 *
 * Uses the `woocommerce_before_shop_loop_item_title` hook is NOT appropriate here;
 * this is typically called directly in header templates.
 */
function wc_persian_mini_cart() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	?>
	<div id="mini-cart-overlay" class="mini-cart-overlay"></div>
	<div id="mini-cart" class="mini-cart" aria-label="<?php esc_attr_e( 'سبد خرید', 'wc-persian' ); ?>">
		<div class="mini-cart-header">
			<h3><?php esc_html_e( 'سبد خرید', 'wc-persian' ); ?></h3>
			<button id="mini-cart-close" class="mini-cart-close" aria-label="<?php esc_attr_e( 'بستن', 'wc-persian' ); ?>">
				&times;
			</button>
		</div>
		<div class="mini-cart-content">
			<div class="widget_shopping_cart_content">
				<?php woocommerce_mini_cart(); ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Display the cart item count badge inside the header.
 *
 * Reads from the WooCommerce cart and shows a count that updates via
 * the Cart Fragments AJAX mechanism.
 */
function wc_persian_cart_count() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;

	$html = '<a href="' . esc_url( wc_get_cart_url() ) . '" class="header-cart-icon cart-contents" title="' . esc_attr__( 'سبد خرید', 'wc-persian' ) . '">';
	$html .= '<svg class="cart-icon-svg" viewBox="0 0 24 24" width="24" height="24"><path fill="currentColor" d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM7.16 14.26l.04-.12.96-1.74h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1 1 0 0020.04 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7.42c-.14 0-.25-.11-.25-.25z"/></svg>';
	$html .= '<span class="cart-count' . ( 0 === $count ? ' cart-empty' : '') . '">' . esc_html( wc_persian_convert_numerals( $count ) ) . '</span>';
	$html .= '</a>';

	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Register the mini-cart as a WooCommerce cart fragment so its content
 * updates without a full page reload.
 *
 * @param array $fragments Existing cart fragments.
 * @return array Updated fragments.
 */
function wc_persian_cart_fragment( $fragments ) {
	ob_start();
	echo '<span class="cart-count';
	echo ( WC()->cart->get_cart_contents_count() === 0 ) ? ' cart-empty' : '';
	echo '">';
	echo esc_html( wc_persian_convert_numerals( WC()->cart->get_cart_contents_count() ) );
	echo '</span>';
	$fragments['.cart-count'] = ob_get_clean();

	ob_start();
	woocommerce_mini_cart();
	$fragments['div.widget_shopping_cart_content'] = ob_get_clean();

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'wc_persian_cart_fragment' );

/**
 * Set the default number of product columns on shop archive pages.
 *
 * @return int Number of columns.
 */
function wc_persian_product_columns() {
	return 4;
}
add_filter( 'loop_shop_columns', 'wc_persian_product_columns' );

/**
 * Set the number of products displayed per page on the shop archive.
 *
 * @return int Products per page.
 */
function wc_persian_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'wc_persian_products_per_page' );

/**
 * Ensure the body has the correct WooCommerce template classes for column support.
 *
 * @param array $classes Existing body classes.
 * @return array Updated body classes.
 */
function wc_persian_body_classes( $classes ) {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return $classes;
	}

	// WooCommerce columns class for archive pages.
	if ( is_shop() || is_product_category() || is_product_tag() ) {
		$classes[] = 'columns-' . wc_persian_product_columns();
	}

	// Mini-cart body class helper (toggled by JS).
	if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) {
		$classes[] = 'has-cart-items';
	} else {
		$classes[] = 'cart-empty';
	}

	return $classes;
}
add_filter( 'body_class', 'wc_persian_body_classes' );
