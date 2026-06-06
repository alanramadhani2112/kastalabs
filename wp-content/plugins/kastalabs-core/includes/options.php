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
		'hero_eyebrow'        => 'Studio digital strategis',
		'hero_heading'        => 'Brand yang bergerak lebih tajam, dimulai dari sini.',
		'hero_body'           => 'Kami membantu bisnis menyusun strategi, identitas visual, dan sistem digital yang bukan hanya terlihat baik — tapi bekerja secara nyata.',
		'hero_primary_label'  => 'Lihat portfolio',
		'hero_primary_url'    => '/portfolio/',
		'hero_secondary_label' => 'Ceritakan proyek Anda',
		'hero_secondary_url'  => '/contact/',
		'services_eyebrow'    => 'Yang kami kerjakan',
		'services_heading'    => 'Layanan digital yang terhubung dari strategi sampai eksekusi.',
		'services_body'       => 'Pilih titik mulai yang paling relevan. Setiap layanan bisa berdiri sendiri atau disusun menjadi satu sistem digital yang utuh.',
		'services_pill_one'   => 'Branding',
		'services_pill_two'   => 'Experience design',
		'services_pill_three' => 'Engineering',
		'services_cta_label'  => 'Lihat semua layanan',
		'services_cta_url'    => '/services/',
		'portfolio_eyebrow'   => 'Portfolio pilihan',
		'portfolio_heading'   => 'Project yang kami bangun dengan strategi dan niat.',
		'portfolio_body'      => 'Beberapa contoh bagaimana strategi, visual, dan teknologi disusun menjadi pengalaman digital yang berkesan.',
		'portfolio_cta_label' => 'Lihat semua project',
		'portfolio_cta_url'   => '/portfolio/',
		'cta_eyebrow'         => 'Siap bergerak lebih tajam?',
		'cta_heading'         => 'Mulai dengan percakapan.',
		'cta_body'            => 'Ceritakan proyek Anda — kami dengarkan, lalu kami beri pandangan jujur tentang apa yang bisa dilakukan.',
		'cta_primary_label'   => 'Mulai percakapan',
		'cta_primary_url'     => '/contact/',
		'contact_email'       => 'hello@kastalabs.com',
		'whatsapp_url'        => '',
		'company_location'    => 'Indonesia',
		'footer_copy'         => get_bloginfo( 'description' ),
		'instagram_url'       => '',
		'linkedin_url'        => '',
		'behance_url'         => '',
		'seo_title'           => '',
		'seo_description'     => '',
		'og_image_url'        => '',
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

		if ( str_contains( $key, 'body' ) || 'footer_copy' === $key || 'seo_description' === $key ) {
			$output[ $key ] = sanitize_textarea_field( (string) $value );
			continue;
		}

		$output[ $key ] = sanitize_text_field( (string) $value );
	}

	return wp_parse_args( $output, $defaults );
}
