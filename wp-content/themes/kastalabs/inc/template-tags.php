<?php
/**
 * Template tags / helper.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

/**
 * Cetak eyebrow label kecil di atas headline.
 */
function kasta_eyebrow( string $text ): void {
	printf(
		'<span class="eyebrow">%s</span>',
		esc_html( $text )
	);
}

/**
 * Site logo: kembalikan `<img>` markup atau text fallback.
 */
function kasta_site_logo(): string {
	if ( has_custom_logo() ) {
		return get_custom_logo();
	}
	return sprintf(
		'<a href="%s" class="font-display font-extrabold tracking-tight text-xl">%s</a>',
		esc_url( home_url( '/' ) ),
		esc_html( get_bloginfo( 'name' ) )
	);
}

/**
 * Return a site option from Kastalabs Core with a theme-safe fallback.
 */
function kasta_site_option( string $key, string $fallback = '' ): string {
	if ( function_exists( 'kastalabs_get_option' ) ) {
		return kastalabs_get_option( $key, $fallback );
	}

	return $fallback;
}

/**
 * Convert a possibly relative site option URL into an absolute frontend URL.
 */
function kasta_site_url_option( string $key, string $fallback = '' ): string {
	$url = kasta_site_option( $key, $fallback );

	if ( '' === $url ) {
		return '';
	}

	if ( str_starts_with( $url, '/' ) ) {
		return home_url( $url );
	}

	return $url;
}

/**
 * Return configured contact email.
 */
function kasta_contact_email(): string {
	return kasta_site_option( 'contact_email', 'hello@kastalabs.com' );
}

/**
 * Reading time post (menit), berdasarkan rata-rata 220 wpm.
 */
function kasta_reading_time( ?int $post_id = null ): int {
	$post_id = $post_id ?: get_the_ID();
	if ( ! $post_id ) {
		return 0;
	}
	$content = (string) get_post_field( 'post_content', $post_id );
	$words   = str_word_count( wp_strip_all_tags( $content ) );
	return max( 1, (int) ceil( $words / 220 ) );
}

/**
 * Fallback primary navigation matching the final PRD IA.
 *
 * Used when no WordPress menu has been assigned yet.
 */
function kastalabs_primary_nav_fallback(): void {
	$items = array(
		__( 'Home', 'kastalabs' )      => home_url( '/' ),
		__( 'About', 'kastalabs' )     => home_url( '/about/' ),
		__( 'Services', 'kastalabs' )  => home_url( '/services/' ),
		__( 'Portfolio', 'kastalabs' ) => get_post_type_archive_link( 'portfolio' ) ?: home_url( '/portfolio/' ),
		__( 'Insights', 'kastalabs' )  => get_post_type_archive_link( 'insight' ) ?: home_url( '/insights/' ),
		__( 'Contact', 'kastalabs' )   => home_url( '/contact/' ),
	);

	echo '<ul class="flex items-center gap-8 text-sm font-medium">';
	foreach ( $items as $label => $url ) {
		printf(
			'<li><a href="%s">%s</a></li>',
			esc_url( $url ),
			esc_html( $label )
		);
	}
	echo '</ul>';
}

/**
 * Fallback footer navigation.
 */
function kasta_footer_nav_fallback(): void {
	$items = array(
		__( 'Home', 'kastalabs' )      => home_url( '/' ),
		__( 'About', 'kastalabs' )     => home_url( '/about/' ),
		__( 'Services', 'kastalabs' )  => home_url( '/services/' ),
		__( 'Portfolio', 'kastalabs' ) => get_post_type_archive_link( 'portfolio' ) ?: home_url( '/portfolio/' ),
		__( 'Insights', 'kastalabs' )  => get_post_type_archive_link( 'insight' ) ?: home_url( '/insights/' ),
		__( 'Contact', 'kastalabs' )   => home_url( '/contact/' ),
	);

	echo '<ul class="flex flex-col gap-2 text-sm">';
	foreach ( $items as $label => $url ) {
		printf(
			'<li><a href="%s">%s</a></li>',
			esc_url( $url ),
			esc_html( $label )
		);
	}
	echo '</ul>';
}
