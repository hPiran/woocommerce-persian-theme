/**
 * WC Persian — Main Theme JavaScript
 *
 * Vanilla JS — zero jQuery dependency.
 * Handles: mobile menu, sticky header, quantity buttons,
 * scroll-to-top button, mobile search toggle, and mini-cart fallback.
 *
 * @package WC_Persian
 */

(function () {
	'use strict';

	/* ---------------------------------------------------------------
	 *  Mobile Menu Toggle
	 * -------------------------------------------------------------- */
	function initMobileMenu() {
		var toggle = document.querySelector('.menu-toggle');
		var nav    = document.getElementById('site-navigation');
		var body   = document.body;

		if (!toggle || !nav) {
			return;
		}

		toggle.addEventListener('click', function (e) {
			e.preventDefault();
			var isOpen = nav.classList.toggle('active');
			toggle.classList.toggle('active', isOpen);
			body.classList.toggle('menu-open', isOpen);
			toggle.setAttribute('aria-expanded', String(isOpen));

			// Toggle the nav-menu inside the navigation.
			var navMenu = nav.querySelector('.nav-menu');
			if (navMenu) {
				navMenu.classList.toggle('active', isOpen);
			}
		});

		// Close menu when clicking a nav link.
		var navLinks = nav.querySelectorAll('.nav-menu a');
		navLinks.forEach(function (link) {
			link.addEventListener('click', function () {
				nav.classList.remove('active');
				toggle.classList.remove('active');
				body.classList.remove('menu-open');
				toggle.setAttribute('aria-expanded', 'false');
				var navMenu = nav.querySelector('.nav-menu');
				if (navMenu) {
					navMenu.classList.remove('active');
				}
			});
		});

		// Close menu on Escape key.
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && nav.classList.contains('active')) {
				nav.classList.remove('active');
				toggle.classList.remove('active');
				body.classList.remove('menu-open');
				toggle.setAttribute('aria-expanded', 'false');
				toggle.focus();
			}
		});
	}

	/* ---------------------------------------------------------------
	 *  Sticky Header
	 * -------------------------------------------------------------- */
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
						header.classList.add('scrolled');
					} else {
						header.classList.remove('scrolled');
					}
					ticking = false;
				});
				ticking = true;
			}
		}

		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
	}

	/* ---------------------------------------------------------------
	 *  Product Quantity Buttons
	 * -------------------------------------------------------------- */
	function initQuantityButtons() {
		var inputs = document.querySelectorAll(
			'.quantity input[type="number"], .woocommerce .quantity input.qty'
		);

		inputs.forEach(function (input) {
			var wrapper = input.closest('.quantity');
			if (!wrapper) {
				return;
			}

			// Skip if buttons already exist.
			if (wrapper.querySelector('.qty-minus')) {
				return;
			}

			var min  = parseFloat(input.min) || 0;
			var max  = parseFloat(input.max) || Infinity;
			var step = parseFloat(input.step) || 1;

			var btnMinus = document.createElement('button');
			btnMinus.type        = 'button';
			btnMinus.className   = 'qty-btn qty-minus';
			btnMinus.textContent = '−';
			btnMinus.setAttribute('aria-label', 'کاهش تعداد');

			var btnPlus = document.createElement('button');
			btnPlus.type        = 'button';
			btnPlus.className   = 'qty-btn qty-plus';
			btnPlus.textContent = '+';
			btnPlus.setAttribute('aria-label', 'افزایش تعداد');

			btnMinus.addEventListener('click', function () {
				var val    = parseFloat(input.value) || 0;
				var newVal = Math.max(min, val - step);
				input.value = newVal;
				input.dispatchEvent(new Event('change', { bubbles: true }));
			});

			btnPlus.addEventListener('click', function () {
				var val    = parseFloat(input.value) || 0;
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
	 * -------------------------------------------------------------- */
	function initScrollToTop() {
		var btn = document.getElementById('scroll-to-top');
		if (!btn) {
			btn = document.createElement('button');
			btn.id        = 'scroll-to-top';
			btn.className = 'scroll-to-top';
			btn.setAttribute('aria-label', 'بازگشت به بالا');
			btn.innerHTML  = '&#8593;';
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
	 *  Mini-Cart Toggle (fallback / direct binding)
	 * --------------------------------------------------------------
	 * Provides a direct event listener on the #cartToggle button
	 * as a safety net if mini-cart.js hasn't loaded or was blocked.
	 */
	function initMiniCartFallback() {
		var cartToggle = document.getElementById('cartToggle');
		var miniCart   = document.getElementById('miniCart');
		var overlay    = document.getElementById('miniCartOverlay');
		var closeBtn   = document.getElementById('miniCartClose');

		if (!cartToggle || !miniCart) {
			return;
		}

		cartToggle.addEventListener('click', function (e) {
			e.preventDefault();
			e.stopPropagation();
			miniCart.classList.add('active');
			miniCart.setAttribute('aria-hidden', 'false');
			if (overlay) {
				overlay.classList.add('active');
			}
		});

		if (closeBtn) {
			closeBtn.addEventListener('click', function () {
				miniCart.classList.remove('active');
				miniCart.setAttribute('aria-hidden', 'true');
				if (overlay) {
					overlay.classList.remove('active');
				}
			});
		}

		if (overlay) {
			overlay.addEventListener('click', function () {
				miniCart.classList.remove('active');
				miniCart.setAttribute('aria-hidden', 'true');
				overlay.classList.remove('active');
			});
		}

		// Close on Escape.
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && miniCart.classList.contains('active')) {
				miniCart.classList.remove('active');
				miniCart.setAttribute('aria-hidden', 'true');
				if (overlay) {
					overlay.classList.remove('active');
				}
			}
		});
	}

	/* ---------------------------------------------------------------
	 *  Layout Toggle (Grid / List)
	 * -------------------------------------------------------------- */
	function initLayoutToggle() {
		var layoutBtns = document.querySelectorAll('.layout-btn');
		var productsUl = document.querySelector('ul.products');
		if (!layoutBtns.length || !productsUl) {
			return;
		}

		layoutBtns.forEach(function (btn) {
			btn.addEventListener('click', function () {
				layoutBtns.forEach(function (b) { b.classList.remove('active'); });
				btn.classList.add('active');

				var layout = btn.getAttribute('data-layout');
				if (layout === 'list') {
					productsUl.classList.add('list-view');
				} else {
					productsUl.classList.remove('list-view');
				}
			});
		});
	}

	/* ---------------------------------------------------------------
	 *  Bootstrap
	 * -------------------------------------------------------------- */
	document.addEventListener('DOMContentLoaded', function () {
		initMobileMenu();
		initStickyHeader();
		initQuantityButtons();
		initScrollToTop();
		initMiniCartFallback();
		initLayoutToggle();
	});

})();
