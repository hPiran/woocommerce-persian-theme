/**
 * WC Persian — AJAX Mini-Cart Sidebar
 *
 * Vanilla JS with proper event delegation.
 * Listens for WooCommerce cart fragment updates, syncs the header badge,
 * and manages the slide-in / slide-out mini-cart panel.
 *
 * IDs and classes match header.php markup:
 *   - #miniCart       → the sidebar panel
 *   - #miniCartOverlay → the backdrop overlay
 *   - #miniCartClose  → the close button
 *   - .cart-contents  → the header cart icon (also #cartToggle)
 *   - .active         → CSS class for open state (matches style.css)
 *
 * @package WC_Persian
 */

(function () {
	'use strict';

	/* ---------------------------------------------------------------
	 *  DOM References (resolved once on load)
	 * -------------------------------------------------------------- */
	var miniCart        = document.getElementById('miniCart');
	var miniCartOverlay = document.getElementById('miniCartOverlay');
	var miniCartClose   = document.getElementById('miniCartClose');
	var cartIcon        = document.querySelector('.cart-contents, #cartToggle, .header-cart-icon');
	var body            = document.body;

	/* ---------------------------------------------------------------
	 *  Helpers
	 * -------------------------------------------------------------- */

	/**
	 * Open the mini-cart sidebar and update ARIA attributes.
	 */
	function openMiniCart() {
		if (!miniCart) {
			return;
		}
		miniCart.classList.add('active');
		miniCart.setAttribute('aria-hidden', 'false');
		if (miniCartOverlay) {
			miniCartOverlay.classList.add('active');
		}
		body.classList.add('mini-cart-open');

		// Trap focus inside the panel (basic: focus the close button).
		if (miniCartClose) {
			setTimeout(function () { miniCartClose.focus(); }, 100);
		}
	}

	/**
	 * Close the mini-cart sidebar.
	 */
	function closeMiniCart() {
		if (!miniCart) {
			return;
		}
		miniCart.classList.remove('active');
		miniCart.setAttribute('aria-hidden', 'true');
		if (miniCartOverlay) {
			miniCartOverlay.classList.remove('active');
		}
		body.classList.remove('mini-cart-open');

		// Return focus to the cart icon.
		if (cartIcon) {
			cartIcon.focus();
		}
	}

	/**
	 * Update the cart count badge across all elements that match
	 * the incoming fragment selector.
	 *
	 * WooCommerce sends the updated HTML via the 'added_to_cart'
	 * and 'removed_from_cart' events as well as the fragments
	 * jQuery event.  Because WooCommerce still fires a jQuery event
	 * for fragments, we listen on document for it.
	 *
	 * @param {Object} fragments  Map of selector → new HTML content.
	 * @param {string} cart_hash  Cart hash string.
	 */
	function updateCartBadges(fragments) {
		if (!fragments || typeof fragments !== 'object') {
			return;
		}

		Object.keys(fragments).forEach(function (selector) {
			// Update cart count badges.
			if (selector === '.cart-count') {
				var badges = document.querySelectorAll('.cart-count');
				var newHtml = fragments[selector];

				// Parse count from the incoming HTML.
				var temp = document.createElement('div');
				temp.innerHTML = newHtml;
				var newBadge = temp.querySelector('.cart-count');

				var count   = newBadge ? parseInt(newBadge.textContent.trim(), 10) || 0 : 0;
				var isEmpty = count === 0;

				badges.forEach(function (badge) {
					badge.textContent = newBadge ? newBadge.textContent.trim() : count;

					if (isEmpty) {
						badge.classList.add('cart-empty');
					} else {
						badge.classList.remove('cart-empty');
					}
				});
			}

			// Replace the mini-cart widget content.
			if (selector === 'div.widget_shopping_cart_content') {
				var containers = document.querySelectorAll(selector);
				containers.forEach(function (container) {
					container.innerHTML = fragments[selector];
				});
			}
		});
	}

	/* ---------------------------------------------------------------
	 *  Event Listeners
	 * -------------------------------------------------------------- */

	// Open mini-cart when the header cart icon/button is clicked.
	if (cartIcon) {
		cartIcon.addEventListener('click', function (e) {
			e.preventDefault();
			e.stopPropagation();
			openMiniCart();
		});
	}

	// Close mini-cart on the × button.
	if (miniCartClose) {
		miniCartClose.addEventListener('click', function () {
			closeMiniCart();
		});
	}

	// Close mini-cart when the overlay is clicked.
	if (miniCartOverlay) {
		miniCartOverlay.addEventListener('click', function () {
			closeMiniCart();
		});
	}

	// Close mini-cart on Escape key.
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && miniCart && miniCart.classList.contains('active')) {
			closeMiniCart();
		}
	});

	/* ---------------------------------------------------------------
	 *  WooCommerce Cart Fragment Updates
	 * --------------------------------------------------------------
	 * WooCommerce uses jQuery to trigger a 'added_to_cart' event on
	 * the document body with the fragments payload.  Because this
	 * theme loads vanilla JS, we need to bridge that jQuery event.
	 */
	function listenForFragments() {
		// Approach 1 — jQuery event (WooCommerce's native mechanism).
		if (typeof jQuery !== 'undefined') {
			jQuery(document.body).on('added_to_cart removed_from_cart', function (event, fragments) {
				if (fragments) {
					updateCartBadges(fragments);
				}
			});
		}

		// Approach 2 — vanilla fallback: observe the cart widget for DOM mutations.
		var widgetContainer = document.querySelector('div.widget_shopping_cart_content');
		if (widgetContainer && typeof MutationObserver !== 'undefined') {
			var observer = new MutationObserver(function (mutations) {
				var changed = false;
				mutations.forEach(function (mutation) {
					if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
						changed = true;
					}
				});

				if (changed) {
					var countEls = widgetContainer.querySelectorAll('.count, .quantity');
					if (countEls.length) {
						var count = parseInt(countEls[0].textContent.trim(), 10) || 0;
						var badges = document.querySelectorAll('.cart-count');
						badges.forEach(function (badge) {
							badge.textContent = count;
							if (count === 0) {
								badge.classList.add('cart-empty');
							} else {
								badge.classList.remove('cart-empty');
							}
						});
					}
				}
			});

			observer.observe(widgetContainer, { childList: true, subtree: true });
		}
	}

	/* ---------------------------------------------------------------
	 *  Bootstrap
	 * -------------------------------------------------------------- */
	document.addEventListener('DOMContentLoaded', function () {
		listenForFragments();

		// Set initial ARIA state.
		if (miniCart) {
			miniCart.setAttribute('aria-hidden', 'true');
		}
	});

})();
