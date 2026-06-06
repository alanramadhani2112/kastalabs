<?php
/**
 * Open Graph / Twitter Card meta tags.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $title       OG title (default: post title or site name).
 *     @type string $description OG description (default: post excerpt or site description).
 *     @type string $image       OG image URL.
 *     @type string $type        OG type: 'website' | 'article' (default: 'website').
 *     @type string $twitter_handle Twitter @username.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'title'          => '',
		'description'    => '',
		'image'          => '',
		'type'           => 'website',
		'twitter_handle' => '',
	)
);

// Auto-detect values
if ( ! $args['title'] && is_singular() ) {
	$args['title'] = get_the_title();
}
if ( ! $args['title'] ) {
	$args['title'] = get_bloginfo( 'name' );
}

if ( ! $args['description'] && is_singular() ) {
	$args['description'] = has_excerpt() ? get_the_excerpt() : '';
}
if ( ! $args['description'] ) {
	$args['description'] = get_bloginfo( 'description' );
}

if ( ! $args['image'] && is_singular() && has_post_thumbnail() ) {
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
	if ( $thumb ) {
		$args['image'] = $thumb[0];
	}
}

$lines = array();

$lines[] = '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
$lines[] = '<meta property="og:title" content="' . esc_attr( $args['title'] ) . '">';
$lines[] = '<meta property="og:description" content="' . esc_attr( $args['description'] ) . '">';
$lines[] = '<meta property="og:url" content="' . esc_url( ( is_singular() ? get_permalink() : home_url( '/' ) ) ) . '">';
$lines[] = '<meta property="og:type" content="' . esc_attr( $args['type'] ) . '">';

if ( $args['image'] ) {
	$lines[] = '<meta property="og:image" content="' . esc_url( $args['image'] ) . '">';
}

// Twitter Card
$twitter_card = $args['image'] ? 'summary_large_image' : 'summary';
$lines[]      = '<meta name="twitter:card" content="' . esc_attr( $twitter_card ) . '">';

if ( $args['twitter_handle'] ) {
	$lines[] = '<meta name="twitter:site" content="' . esc_attr( $args['twitter_handle'] ) . '">';
}

echo implode( "\n", $lines ) . "\n";
