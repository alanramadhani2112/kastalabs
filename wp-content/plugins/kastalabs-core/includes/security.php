<?php
/**
 * Lightweight security headers.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'send_headers', 'kastalabs_send_security_headers' );
add_action( 'init', 'kastalabs_harden_public_wordpress_surface' );
add_filter( 'wp_headers', 'kastalabs_filter_public_headers' );
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', 'kastalabs_disable_xmlrpc_pingback_methods' );
add_filter( 'rest_endpoints', 'kastalabs_filter_public_rest_endpoints' );

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

/**
 * Remove public metadata and pingback discovery that are not needed for this site.
 */
function kastalabs_harden_public_wordpress_surface(): void {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	remove_action( 'template_redirect', 'rest_output_link_header', 11 );
}

/**
 * Remove headers that reveal unused XML-RPC/pingback surfaces.
 */
function kastalabs_filter_public_headers( array $headers ): array {
	unset( $headers['X-Pingback'] );

	return $headers;
}

/**
 * Disable XML-RPC pingback methods even if another plugin re-enables XML-RPC.
 */
function kastalabs_disable_xmlrpc_pingback_methods( array $methods ): array {
	unset( $methods['pingback.ping'], $methods['pingback.extensions.getPingbacks'] );

	return $methods;
}

/**
 * Hide public REST user enumeration endpoints for anonymous visitors.
 */
function kastalabs_filter_public_rest_endpoints( array $endpoints ): array {
	if ( is_user_logged_in() ) {
		return $endpoints;
	}

	unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );

	return $endpoints;
}
