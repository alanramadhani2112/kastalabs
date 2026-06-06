<?php
/**
 * SEO JSON-LD structured data.
 *
 * Menghasilkan schema.org JSON-LD untuk halaman.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $type     Schema type: 'WebSite' | 'Organization' | 'Article' (default: 'Organization').
 *     @type array  $overrides Array of overrides untuk schema properties.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'type'      => 'Organization',
		'overrides' => array(),
	)
);

$schema = array(
	'@context' => 'https://schema.org',
);

if ( 'Organization' === $args['type'] ) {
	$schema['@type']       = 'Organization';
	$schema['name']        = get_bloginfo( 'name' );
	$schema['url']         = home_url( '/' );
	$schema['description'] = get_bloginfo( 'description' );

	$logo_id = get_theme_mod( 'custom_logo' );
	if ( $logo_id ) {
		$logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
		if ( $logo_url ) {
			$schema['logo'] = $logo_url;
		}
	}

	if ( function_exists( 'kasta_contact_email' ) ) {
		$schema['email'] = kasta_contact_email();
	}

	$social = array_filter(
		array(
			kasta_site_url_option( 'instagram_url' ),
			kasta_site_url_option( 'linkedin_url' ),
			kasta_site_url_option( 'behance_url' ),
		)
	);
	if ( $social ) {
		$schema['sameAs'] = array_values( $social );
	}
} elseif ( 'Article' === $args['type'] && is_singular() ) {
	$schema['@type']            = 'Article';
	$schema['headline']         = get_the_title();
	$schema['url']              = get_permalink();
	$schema['datePublished']    = get_the_date( 'c' );
	$schema['dateModified']     = get_the_modified_date( 'c' );
	$schema['author']           = array(
		'@type' => 'Person',
		'name'  => get_the_author_meta( 'display_name', get_post_field( 'post_author' ) ),
	);

	if ( has_post_thumbnail() ) {
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
		if ( $thumb ) {
			$schema['image'] = $thumb[0];
		}
	}
} elseif ( 'WebSite' === $args['type'] ) {
	$schema['@type']      = 'WebSite';
	$schema['name']       = get_bloginfo( 'name' );
	$schema['url']        = home_url( '/' );
	$schema['description'] = get_bloginfo( 'description' );
}

// Apply overrides
if ( $args['overrides'] ) {
	$schema = array_merge( $schema, $args['overrides'] );
}

echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
