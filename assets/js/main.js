/**
 * WC Persian — Main Theme JavaScript
 *
 * Vanilla JS — zero jQuery dependency.
 * Handles: mobile menu, sticky header, quantity buttons,
 * scroll-to-top button, and mobile search toggle.
 *
 * @package WC_Persian
 */

(function () {
	'use strict';

	/* ---------------------------------------------------------------
	 *  Mobile Menu Toggle
	 * --------------------------------------------------------------
	 * Toggles the primary navigation on small screens via a hamburger
	 * button. Adds/removes .menu-open on the <body> for overlay styling.
	 */
	function initMobileMenu() {
		var toggle  = document.querySelector('.menu-toggle');
		var nav     = document.querySelector('.primary-navigation');
		var body    = document.body;

		if (!toggle || !nav) {
			return;
		}

		toggle.addEventListener('click', function (e) {
			e.preventDefault();
			var isOpen = nav.classList.toggle('is-open');
			toggle.classList.toggle('is-active', isOpen);
			body.classList.toggle('menu-open', isOpen);
			toggle.setAttribute('aria-expanded', isOpen);
		});

		// Close menu when clicking a nav link (useful for one-page sections).
		var navLinks = nav.querySelectorAll('a');
		navLinks.forEach(function (link) {
			link.addEventListener('click', function () {
				nav.classList.remove('is-open');
				toggle.classList.remove('is-active');
				body.classList.remove('menu-open');
				toggle.setAttribute('aria-expanded', 'false');
			});
		});

		// Close menu on Escape key.
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && nav.classList.contains('is-open')) {
				nav.classList.remove('is-open');
				toggle.classList.remove('is-active');
				body.classList.remove('menu-open');
				toggle.setAttribute('aria-expanded', 'false');
				toggle.focus();
			}
		});
	}

	/* ---------------------------------------------------------------
	 *  Sticky Header
	 * --------------------------------------------------------------
	 * After scrolling past 100 px the header receives .sticky-header
	 * for a fixed + shadow effect. The threshold is configurable via
	 * the data-sticky-threshold attribute on the header element.
	 */
	function initStickyHeader() {
		var header    = document.querySelector('.site-header');
		var threshold = header
			? parseInt(header.dataset.stickyThreshold, 10) || 100
			: 100;

		if (!header) {
			return;
		}

		var ticking = false;

		function onScroll() {
			if (!ticking) {
				requestAnimationFrame(function () {
					if (window.scrollY > threshold) {
						header.classList.add('sticky-header');
						header.classList.add('is-sticky');
					} else {
						header.classList.remove('sticky-header');
						header.classList.remove('is-sticky');
					}
					ticking = false;
				});
				ticking = true;
			}
		}

		window.addEventListener('scroll', onScroll, { passive: true });
		// Run once on load in case the page is already scrolled.
		onScroll();
	}

	/* ---------------------------------------------------------------
	 *  Product Quantity Buttons
	 * --------------------------------------------------------------
	 * Adds ±1 increment / decrement buttons to WooCommerce quantity
	 * inputs found on the cart page and single-product pages.
	 */
	function initQuantityButtons() {
		var inputs = document.querySelectorAll(
			'.quantity input[type="number"], .woocommerce .quantity input.qty'
		);

		inputs.forEach(function (input) {
			var wrapper = input.closest('.quantity');
			if (!wrapper) {
				return;
			}

			var min     = parseFloat(input.min) || 0;
			var max     = parseFloat(input.max) || Infinity;
			var step    = parseFloat(input.step) || 1;

			// Decrement button.
			var btnMinus = document.createElement('button');
			btnMinus.type          = 'button';
			btnMinus.className     = 'qty-btn qty-minus';
			btnMinus.textContent   = '−';
			btnMinus.setAttribute('aria-label', 'کاهش تعداد');

			// Increment button.
			var btnPlus = document.createElement('button');
			btnPlus.type          = 'button';
			btnPlus.className     = 'qty-btn qty-plus';
			btnPlus.textContent   = '+';
			btnPlus.setAttribute('aria-label', 'افزایش تعداد');

			btnMinus.addEventListener('click', function () {
				var val = parseFloat(input.value) || 0;
				var newVal = Math.max(min, val - step);
				input.value = newVal;
				input.dispatchEvent(new Event('change', { bubbles: true }));
			});

			btnPlus.addEventListener('click', function () {
				var val = parseFloat(input.value) || 0;
				var newVal = Math.min(max, val + step);
				input.value = newVal;
				input.dispatchEvent(new Event('change', { bubbles: true }));
			});

			wrapper.insertBefore(btnMinus, input);
			wrapper.appendChild(btnPlus);
		});
	}

	/* ---------------------------------------------------------------
	 *  Scroll-to-Top Button
	 * --------------------------------------------------------------
	 * A floating button that fades in after the user scrolls 300 px
	 * and smoothly scrolls back to the top when clicked.
	 */
	function initScrollToTop() {
		// Create the button if it doesn't exist in the markup.
		var btn = document.getElementById('scroll-to-top');
		if (!btn) {
			btn = document.createElement('button');
			btn.id          = 'scroll-to-top';
			btn.className   = 'scroll-to-top';
			btn.setAttribute('aria-label', 'بازگشت به بالا');
			btn.innerHTML   = '&#8593;';  // ↑
			document.body.appendChild(btn);
		}

		var showThreshold = 300;
		var ticking       = false;

		function onScroll() {
			if (!ticking) {
				requestAnimationFrame(function () {
					if (window.scrollY > showThreshold) {
						btn.classList.add('is-visible');
					} else {
						btn.classList.remove('is-visible');
					}
					ticking = false;
				});
				ticking = true;
			}
		}

		window.addEventListener('scroll', onScroll, { passive: true });

		btn.addEventListener('click', function () {
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});
	}

	/* ---------------------------------------------------------------
	 *  Mobile Search Toggle
	 * --------------------------------------------------------------
	 * Toggles the search form visibility on mobile viewports.
	 */
	function initMobileSearch() {
		var toggle = document.querySelector('.header-search-toggle');
		var form   = document.querySelector('.header-search-form');

		if (!toggle || !form) {
			return;
		}

		toggle.addEventListener('click', function (e) {
			e.preventDefault();
			var isOpen = form.classList.toggle('is-open');
			toggle.classList.toggle('is-active', isOpen);
			toggle.setAttribute('aria-expanded', isOpen);

			// Focus the search input when opening.
			if (isOpen) {
				var input = form.querySelector('input[type="search"]');
				if (input) {
					input.focus();
				}
			}
		});

		// Close search when pressing Escape.
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && form.classList.contains('is-open')) {
				form.classList.remove('is-open');
				toggle.classList.remove('is-active');
				toggle.setAttribute('aria-expanded', 'false');
				toggle.focus();
			}
		});
	}

	/* ---------------------------------------------------------------
	 *  Bootstrap — run everything once the DOM is ready.
	 * -------------------------------------------------------------- */
	document.addEventListener('DOMContentLoaded', function () {
		initMobileMenu();
		initStickyHeader();
		initQuantityButtons();
		initScrollToTop();
		initMobileSearch();
	});

})();
