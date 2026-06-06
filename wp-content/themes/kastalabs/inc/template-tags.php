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
function kasta_site_logo( string $variant = 'dark' ): string {
	if ( has_custom_logo() ) {
		return get_custom_logo();
	}

	$suffix   = 'dark' === $variant ? 'logo-horizontal' : 'logo-horizontal-light';
	$logo_path = KASTA_THEME_PATH . '/assets/' . $suffix . '.svg';
	$logo_url  = KASTA_THEME_URI . '/assets/' . $suffix . '.svg';
	$site_name = esc_html( get_bloginfo( 'name' ) );

	if ( file_exists( $logo_path ) ) {
		return sprintf(
			'<a href="%s" class="site-logo" aria-label="%s">%s</a>',
			esc_url( home_url( '/' ) ),
			esc_attr( $site_name . ' — ' . __( 'Beranda', 'kastalabs' ) ),
			file_get_contents( $logo_path )
		);
	}

	return sprintf(
		'<a href="%s" class="site-logo type-h4">%s</a>',
		esc_url( home_url( '/' ) ),
		$site_name
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

	if ( in_array( $key, array( 'hero_primary_url', 'portfolio_cta_url' ), true ) && '/work/' === $url ) {
		$url = '/portfolio/';
	}

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

	echo '<ul class="type-body-sm flex items-center gap-8">';
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
 * Fallback mobile navigation with larger tap targets.
 */
function kastalabs_mobile_nav_fallback(): void {
	$items = array(
		__( 'Home', 'kastalabs' )      => home_url( '/' ),
		__( 'About', 'kastalabs' )     => home_url( '/about/' ),
		__( 'Services', 'kastalabs' )  => home_url( '/services/' ),
		__( 'Portfolio', 'kastalabs' ) => get_post_type_archive_link( 'portfolio' ) ?: home_url( '/portfolio/' ),
		__( 'Insights', 'kastalabs' )  => get_post_type_archive_link( 'insight' ) ?: home_url( '/insights/' ),
		__( 'Contact', 'kastalabs' )   => home_url( '/contact/' ),
	);

	echo '<ul class="site-mobile-menu__list">';
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

	echo '<ul class="type-body-sm flex flex-col gap-2">';
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
 * Fallback footer navigation — services column.
 */
function kasta_footer_services_fallback(): void {
	$items = array(
		__( 'Branding', 'kastalabs' )           => home_url( '/services/branding/' ),
		__( 'UI/UX Design', 'kastalabs' )       => home_url( '/services/ui-ux-design/' ),
		__( 'Web Development', 'kastalabs' )    => home_url( '/services/web-development/' ),
		__( 'Custom Software', 'kastalabs' )    => home_url( '/services/custom-software/' ),
	);

	echo '<ul class="type-body-sm flex flex-col gap-2">';
	foreach ( $items as $label => $url ) {
		printf(
			'<li><a href="%s">%s</a></li>',
			esc_url( $url ),
			esc_html( $label )
		);
	}
	echo '</ul>';
}
