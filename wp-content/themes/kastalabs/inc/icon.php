<?php
/**
 * Heroicons integration — Tailwind Labs.
 *
 * SVG files vendored in assets/icons/heroicons/.
 * To add more icons, download from:
 *   https://github.com/tailwindlabs/heroicons/tree/main/optimized
 *
 * Usage in templates:
 *   kasta_icon( 'arrow-right' );
 *   kasta_icon( 'check', [ 'class' => 'w-5 h-5 text-primary' ] );
 *   kasta_icon( 'bars-3', [ 'aria-label' => 'Buka menu' ] );
 *   kasta_icon( 'shield-check', [ 'variant' => 'solid' ] );
 *   kasta_icon( 'check', [ 'variant' => 'mini' ] );         // 20×20 solid
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

/**
 * Output an inline Heroicon SVG.
 *
 * @param string $name Icon file name without extension, e.g. 'arrow-right'.
 * @param array  $atts {
 *     @type string $class      CSS classes.
 *     @type string $variant    'outline' (default), 'solid', or 'mini' (20px solid).
 *     @type string $aria-label When set, role="img". Otherwise aria-hidden="true".
 *     @type string $role       Override ARIA role.
 *     @type int    $size       Width/height in px (default: 24). Ignored for mini (20px).
 * }
 */
function kasta_icon( string $name, array $atts = [] ): void {
	echo kasta_get_icon( $name, $atts ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Return an inline Heroicon SVG.
 *
 * @param string $name Icon name without extension.
 * @param array  $atts See kasta_icon().
 * @return string Inline SVG markup, or empty string if icon not found.
 */
function kasta_get_icon( string $name, array $atts = [] ): string {
	static $cache = [];

	$defaults = [
		'class'      => '',
		'variant'    => 'outline',
		'aria-label' => '',
		'role'       => '',
		'size'       => 24,
	];

	$atts   = array_merge( $defaults, $atts );
	$size   = (int) $atts['size'];

	// --- Resolve file path based on variant --------------------------------
	$variant_map = [
		'outline' => '24/outline',
		'solid'   => '24/solid',
		'mini'    => '20/solid',
	];

	$variant_dir = $variant_map[ $atts['variant'] ] ?? '24/outline';
	$file        = KASTA_THEME_PATH . "/assets/icons/heroicons/{$variant_dir}/{$name}.svg";

	// Mini icons are fixed 20×20.
	if ( 'mini' === $atts['variant'] ) {
		$size = 20;
	}

	// --- Read & cache ------------------------------------------------------
	if ( ! isset( $cache[ $name . ':' . $atts['variant'] ] ) ) {
		if ( ! is_readable( $file ) ) {
			$cache[ $name . ':' . $atts['variant'] ] = ''; // negative cache.
			return '';
		}

		$svg = file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$cache[ $name . ':' . $atts['variant'] ] = ( false !== $svg ) ? $svg : '';
	}

	$svg = $cache[ $name . ':' . $atts['variant'] ];
	if ( '' === $svg ) {
		return '';
	}

	// --- Mutate SVG attributes ---------------------------------------------
	// Strip XML declaration if present.
	$svg = str_replace( '<?xml version="1.0" encoding="UTF-8"?>', '', $svg );

	// Remove fixed width/height (heroicons don't have them, but belt-and-suspenders).
	$svg = preg_replace( '/\s(width|height)="\d+"/', '', $svg );

	// Insert inline size.
	$svg = preg_replace(
		'/<svg\s/',
		'<svg width="' . $size . '" height="' . $size . '" ',
		$svg,
		1
	);

	// Remove heroicons' own aria-hidden (we add our own below).
	$svg = str_replace( ' aria-hidden="true"', '', $svg );
	$svg = str_replace( ' data-slot="icon"', '', $svg );

	// Accessibility.
	if ( '' !== $atts['aria-label'] ) {
		$svg = preg_replace(
			'/<svg\s/',
			'<svg role="img" aria-label="' . esc_attr( $atts['aria-label'] ) . '" ',
			$svg,
			1
		);
	} else {
		$svg = preg_replace(
			'/<svg\s/',
			'<svg aria-hidden="true" ',
			$svg,
			1
		);
	}

	// Explicit role override.
	if ( '' !== $atts['role'] ) {
		$svg = preg_replace(
			'/role="[^"]*"/',
			'role="' . esc_attr( $atts['role'] ) . '"',
			$svg,
			1
		);
	}

	// Merge CSS classes.
	if ( '' !== $atts['class'] ) {
		$svg = preg_replace(
			'/<svg\s/',
			'<svg class="' . esc_attr( $atts['class'] ) . '" ',
			$svg,
			1
		);
	}

	return $svg;
}
