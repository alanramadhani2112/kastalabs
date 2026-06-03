<?php
/**
 * Lightweight security headers.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'send_headers', 'kastalabs_send_security_headers' );

/**
 * Send safe baseline headers that should not interfere with WordPress admin.
 */
function kastalabs_send_security_headers(): void {
	if ( is_admin() || headers_sent() ) {
		return;
	}

	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	header( 'Permissions-Policy: camera=(), microphone=(), geolocation=()' );
}
