<?php
/**
 * Badge / pill / tag component.
 *
 * Digunakan di: hero pills, page hero pills, services pills, filter tags.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $label      Badge text.
 *     @type string $variant    'default' | 'outline' | 'solid' | 'pill' (default: 'pill').
 *     @type string $size       'sm' | 'md' | 'lg' (default: 'md').
 *     @type string $color      'primary' | 'navy' | 'white' | 'muted' (default: 'primary').
 *     @type string $class      Additional CSS classes.
 *     @type string $tag        HTML tag: 'span' | 'button' | 'a' (default: 'span').
 *     @type string $href       URL if tag is 'a'.
 *     @type string $aria_label Accessibility label.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'label'      => '',
		'variant'    => 'pill',
		'size'       => 'md',
		'color'      => 'primary',
		'class'      => '',
		'tag'        => 'span',
		'href'       => '',
		'aria_label' => '',
	)
);

$variant_map = array(
	'default' => 'zoom-badge',
	'outline' => 'zoom-badge zoom-badge--outline',
	'solid'   => 'zoom-badge zoom-badge--solid',
	'pill'    => 'zoom-pill',
);

$size_map = array(
	'sm' => 'type-caption',
	'md' => 'type-label',
	'lg' => 'type-body-sm',
);

$color_map = array(
	'primary' => 'text-primary-600',
	'navy'    => 'text-navy',
	'white'   => 'text-white',
	'muted'   => 'text-muted',
);

$class  = $variant_map[ $args['variant'] ] ?? 'zoom-pill';
$class .= ' ' . ( $size_map[ $args['size'] ] ?? 'type-label' );
if ( 'pill' !== $args['variant'] ) {
	$class .= ' ' . ( $color_map[ $args['color'] ] ?? 'text-primary-600' );
}
if ( $args['class'] ) {
	$class .= ' ' . $args['class'];
}

$aria = $args['aria_label'] ? ' aria-label="' . esc_attr( $args['aria_label'] ) . '"' : '';

if ( 'a' === $args['tag'] && $args['href'] ) {
	printf(
		'<a href="%s" class="%s"%s>%s</a>',
		esc_url( $args['href'] ),
		esc_attr( $class ),
		$aria, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		esc_html( $args['label'] )
	);
} elseif ( 'button' === $args['tag'] ) {
	printf(
		'<button class="%s"%s>%s</button>',
		esc_attr( $class ),
		$aria, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		esc_html( $args['label'] )
	);
} else {
	printf(
		'<span class="%s"%s>%s</span>',
		esc_attr( $class ),
		$aria, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		esc_html( $args['label'] )
	);
}
