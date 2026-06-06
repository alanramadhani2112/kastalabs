<?php
/**
 * Numbered process/value card component.
 *
 * Dipakai di process.php (4 steps) dan page-about.php (3 values).
 * Pola: nomor → judul → body.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $number       Number label (e.g., "01").
 *     @type string $title        Card title.
 *     @type string $body         Card body.
 *     @type string $variant      'default' | 'soft' | 'solid' (default: 'default').
 *     @type string $class        Additional CSS classes.
 *     @type string $padding      Padding override (default: 'p-7').
 *     @type bool   $data_reveal  Wrap with data-reveal attribute.
 *     @type string $reveal_delay data-reveal-delay value.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'number'       => '',
		'title'        => '',
		'body'         => '',
		'variant'      => 'default',
		'class'        => '',
		'padding'      => 'p-7',
		'data_reveal'  => true,
		'reveal_delay' => '0',
	)
);

$variant_map = array(
	'default' => 'zoom-card',
	'soft'    => 'zoom-card zoom-card--soft',
	'solid'   => 'zoom-card zoom-card--solid',
);

$card_class = ( $variant_map[ $args['variant'] ] ?? 'zoom-card' );
$card_class .= ' ' . $args['padding'];

if ( $args['class'] ) {
	$card_class .= ' ' . $args['class'];
}

$reveal_attrs = '';
if ( $args['data_reveal'] ) {
	$reveal_attrs = ' data-reveal';
	if ( $args['reveal_delay'] ) {
		$reveal_attrs .= ' data-reveal-delay="' . esc_attr( $args['reveal_delay'] ) . '"';
	}
}
?>

<article class="<?php echo esc_attr( $card_class ); ?>"<?php echo $reveal_attrs; // phpcs:ignore ?>>
	<?php if ( $args['number'] ) : ?>
		<p class="type-label text-primary-600"><?php echo esc_html( $args['number'] ); ?></p>
	<?php endif; ?>

	<?php if ( $args['title'] ) : ?>
		<h3 class="type-h4<?php echo $args['number'] ? ' mt-10' : ''; ?>"><?php echo esc_html( $args['title'] ); ?></h3>
	<?php endif; ?>

	<?php if ( $args['body'] ) : ?>
		<p class="type-body mt-4 text-muted"><?php echo esc_html( $args['body'] ); ?></p>
	<?php endif; ?>
</article>
