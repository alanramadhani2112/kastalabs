<?php
/**
 * Responsive post thumbnail.
 *
 * Menampilkan featured image dengan srcset.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type int    $post_id    Post ID.
 *     @type string $size       WordPress image size (default: 'large').
 *     @type string $class      Additional CSS classes on img.
 *     @type string $wrapper_class Wrapper classes.
 *     @type string $aspect     Aspect ratio (e.g., '4/3', '16/9'). Empty = no constraint.
 *     @type bool   $link       Wrap in permalink? (default: false).
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'post_id'      => 0,
		'size'         => 'large',
		'class'        => 'w-full h-full object-cover',
		'wrapper_class' => '',
		'aspect'       => '',
		'link'         => false,
	)
);

$post_id = $args['post_id'] ? (int) $args['post_id'] : get_the_ID();
if ( ! $post_id || ! has_post_thumbnail( $post_id ) ) {
	return;
}

$img = get_the_post_thumbnail(
	$post_id,
	$args['size'],
	array(
		'class'   => $args['class'],
		'loading' => 'lazy',
	)
);

if ( ! $img ) {
	return;
}

$wrapper_class = '';
if ( $args['aspect'] ) {
	$wrapper_class = 'aspect-[' . $args['aspect'] . '] overflow-hidden';
}
if ( $args['wrapper_class'] ) {
	$wrapper_class .= ' ' . $args['wrapper_class'];
}

if ( $args['link'] ) {
	$img = sprintf( '<a href="%s" class="block %s">%s</a>', esc_url( get_permalink( $post_id ) ), esc_attr( $wrapper_class ), $img );
} elseif ( $wrapper_class ) {
	$img = sprintf( '<div class="%s">%s</div>', esc_attr( $wrapper_class ), $img );
}

echo $img; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — img already escaped by WP
