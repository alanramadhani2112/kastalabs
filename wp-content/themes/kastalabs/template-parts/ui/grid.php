<?php
/**
 * Grid layout component.
 *
 * Responsive grid wrapper. Untuk dipakai di dalam section
 * ketika butuh grid layout yang bisa dikonfigurasi tanpa menulis ulang class.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $cols     Tailwind grid-cols classes (default: 'md:grid-cols-2 lg:grid-cols-3').
 *     @type string $gap      Gap class (default: 'gap-6').
 *     @type string $class    Additional CSS classes.
 *     @type bool   $data_reveal Wrap with data-reveal.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'cols'        => 'md:grid-cols-2 lg:grid-cols-3',
		'gap'         => 'gap-6',
		'class'       => '',
		'data_reveal' => false,
	)
);

$class  = 'grid ' . $args['gap'] . ' ' . $args['cols'];
if ( $args['class'] ) {
	$class .= ' ' . $args['class'];
}

$reveal = $args['data_reveal'] ? ' data-reveal' : '';
?>
<div class="<?php echo esc_attr( $class ); ?>"<?php echo $reveal; // phpcs:ignore ?>>
	<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $args['content'] ?? '';
	?>
</div>
