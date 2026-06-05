/**
 * WC Persian — Customizer Live Preview
 *
 * Handles live preview updates for Customizer settings
 * using the WordPress customize-preview JS API.
 *
 * @package WC_Persian
 */

( function( $ ) {
	'use strict';

	// Primary Color
	wp.customize( 'primary_color', function( value ) {
		value.bind( function( newVal ) {
			document.documentElement.style.setProperty( '--wc-persian-primary', newVal );
			$( 'a, .button, .btn-primary' ).css( 'color', newVal );
			$( '.btn-primary, .btn-primary:hover' ).css( 'background-color', newVal );
		} );
	} );

	// Secondary / CTA Color
	wp.customize( 'secondary_color', function( value ) {
		value.bind( function( newVal ) {
			document.documentElement.style.setProperty( '--wc-persian-secondary', newVal );
			$( '.btn-cta' ).css( 'background-color', newVal );
		} );
	} );

	// Text Color
	wp.customize( 'text_color', function( value ) {
		value.bind( function( newVal ) {
			document.documentElement.style.setProperty( '--wc-persian-text', newVal );
			$( 'body' ).css( 'color', newVal );
		} );
	} );

	// Background Color
	wp.customize( 'background_color', function( value ) {
		value.bind( function( newVal ) {
			document.documentElement.style.setProperty( '--wc-persian-bg', newVal );
			$( 'body' ).css( 'background-color', newVal );
		} );
	} );

} )( jQuery );
