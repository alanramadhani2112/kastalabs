<?php
/**
 * Site-wide content options.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return default editable site options.
 */
function kastalabs_default_options(): array {
	return array(
		'hero_eyebrow'        => 'Studio kreatif berbasis di Indonesia',
		'hero_heading'        => 'Brand yang tajam. Website yang bekerja.',
		'hero_body'           => 'Kastalabs membantu founder, tim marketing, dan brand owner menyusun identitas visual, website, dan sistem konten yang jelas, menarik, dan siap dipakai.',
		'hero_primary_label'  => 'Mulai proyek',
		'hero_primary_url'    => '/contact/',
		'hero_secondary_label' => 'Lihat portfolio',
		'hero_secondary_url'  => '/portfolio/',
		'cta_eyebrow'         => 'Siap memulai?',
		'cta_heading'         => 'Punya brand yang perlu dibuat lebih jelas?',
		'cta_body'            => 'Ceritakan konteksnya. Kami akan bantu membaca kebutuhan, menyusun langkah pertama, dan melihat apakah Kastalabs cocok untuk proyek Anda.',
		'cta_primary_label'   => 'Diskusikan proyek',
		'cta_primary_url'     => '/contact/',
		'contact_email'       => 'hello@kastalabs.com',
		'whatsapp_url'        => '',
		'company_location'    => 'Indonesia',
		'footer_copy'         => get_bloginfo( 'description' ),
		'instagram_url'       => '',
		'linkedin_url'        => '',
		'behance_url'         => '',
		'analytics_id'        => '',
	);
}

/**
 * Seed options on activation without overwriting existing admin edits.
 */
function kastalabs_seed_default_options(): void {
	if ( false === get_option( 'kastalabs_options', false ) ) {
		add_option( 'kastalabs_options', kastalabs_default_options() );
	}
}

/**
 * Return merged options.
 */
function kastalabs_get_options(): array {
	$options = get_option( 'kastalabs_options', array() );

	if ( ! is_array( $options ) ) {
		$options = array();
	}

	return wp_parse_args( $options, kastalabs_default_options() );
}

/**
 * Return one site option with fallback.
 */
function kastalabs_get_option( string $key, string $fallback = '' ): string {
	$options = kastalabs_get_options();
	$value   = isset( $options[ $key ] ) ? (string) $options[ $key ] : '';

	return '' !== $value ? $value : $fallback;
}

/**
 * Sanitize site options before saving.
 */
function kastalabs_sanitize_options( mixed $input ): array {
	$input    = is_array( $input ) ? $input : array();
	$defaults = kastalabs_default_options();
	$output   = array();

	foreach ( $defaults as $key => $default ) {
		$value = isset( $input[ $key ] ) ? wp_unslash( $input[ $key ] ) : '';

		if ( str_ends_with( $key, '_url' ) || 'whatsapp_url' === $key ) {
			$output[ $key ] = esc_url_raw( (string) $value );
			continue;
		}

		if ( 'contact_email' === $key ) {
			$output[ $key ] = sanitize_email( (string) $value );
			continue;
		}

		if ( 'analytics_id' === $key ) {
			$output[ $key ] = preg_replace( '/[^A-Za-z0-9_-]/', '', (string) $value );
			continue;
		}

		if ( str_contains( $key, 'body' ) || 'footer_copy' === $key ) {
			$output[ $key ] = sanitize_textarea_field( (string) $value );
			continue;
		}

		$output[ $key ] = sanitize_text_field( (string) $value );
	}

	return wp_parse_args( $output, $defaults );
}
