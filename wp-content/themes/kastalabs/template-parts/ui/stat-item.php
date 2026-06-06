<?php
/**
 * Stat / metric counter component.
 *
 * Digunakan di: about-teaser stats, hero metrics, page stats.
 * Pola: nilai besar + label kecil, dengan border-left accent.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $value      Stat value (e.g., "50+").
 *     @type string $label      Stat label (e.g., "Proyek selesai").
 *     @type string $variant    'accent' | 'simple' (default: 'accent').
 *     @type string $class      Additional CSS classes.
 *     @type bool   $data_reveal Wrap with data-reveal.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'value'       => '',
		'label'       => '',
		'variant'     => 'accent',
		'class'       => '',
		'data_reveal' => false,
	)
);

$class = '';
if ( 'accent' === $args['variant'] ) {
	$class = 'border-l border-primary-500/25 pl-4';
}
if ( $args['class'] ) {
	$class .= ' ' . $args['class'];
}

$reveal = $args['data_reveal'] ? ' data-reveal' : '';
?>
<div class="<?php echo esc_attr( trim( $class ) ); ?>"<?php echo $reveal; // phpcs:ignore ?>>
	<span class="type-h2 text-primary-600"><?php echo esc_html( $args['value'] ); ?></span>
	<span class="type-body-sm block text-muted mt-1"><?php echo esc_html( $args['label'] ); ?></span>
</div>
