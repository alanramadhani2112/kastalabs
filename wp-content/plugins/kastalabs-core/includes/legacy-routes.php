<?php
/**
 * Legacy route controls.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'template_redirect', 'kastalabs_maybe_redirect_legacy_work_routes', 8 );

/**
 * Redirect legacy Work routes only when explicitly enabled and safely mapped.
 */
function kastalabs_maybe_redirect_legacy_work_routes(): void {
	if ( is_admin() || '1' !== kastalabs_get_option( 'legacy_work_redirect_enabled', '0' ) ) {
		return;
	}

	if ( is_post_type_archive( 'work' ) && kastalabs_legacy_work_redirect_is_safe() ) {
		wp_safe_redirect( get_post_type_archive_link( 'portfolio' ) ?: home_url( '/portfolio/' ), 301 );
		exit;
	}

	if ( is_singular( 'work' ) ) {
		$post = get_queried_object();
		if ( ! $post instanceof WP_Post ) {
			return;
		}

		$portfolio_id = function_exists( 'kastalabs_get_migrated_portfolio_id' )
			? kastalabs_get_migrated_portfolio_id( (int) $post->ID )
			: 0;

		if ( ! $portfolio_id ) {
			return;
		}

		wp_safe_redirect( get_permalink( $portfolio_id ), 301 );
		exit;
	}
}

/**
 * Return whether legacy Work archive can safely redirect to Portfolio.
 */
function kastalabs_legacy_work_redirect_is_safe(): bool {
	if ( ! function_exists( 'kastalabs_get_work_migration_status' ) ) {
		return false;
	}

	$status = kastalabs_get_work_migration_status();

	return empty( $status['pending'] );
}
