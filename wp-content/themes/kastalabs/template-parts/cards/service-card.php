<?php
/**
 * Service card component.
 *
 * Digunakan di services section (home) dan archive services.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $icon          Heroicon name (default: 'sparkles').
 *     @type string $title         Card title.
 *     @type string $body          Card description.
 *     @type bool   $is_solid      Use solid variant (default: false).
 *     @type string $class         Additional CSS classes.
 *     @type bool   $data_reveal   Wrap with data-reveal attribute (default: false).
 *     @type string $reveal_delay  data-reveal-delay value.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'icon'        => 'sparkles',
		'title'       => '',
		'body'        => '',
		'is_solid'    => false,
		'class'       => '',
		'data_reveal'   => true,
		'reveal_delay' => '0',
	)
);

$card_class  = 'zoom-card group relative min-h-72 p-7 transition-transform duration-300 hover:-translate-y-1';
$card_class .= $args['is_solid'] ? ' zoom-card--solid' : ' zoom-card--soft';
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

<article class="<?php echo esc_attr( $card_class ); ?>" data-service-card data-tilt<?php echo $reveal_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<span class="text-primary-600">
		<?php kasta_icon( $args['icon'], array( 'class' => 'w-6 h-6' ) ); ?>
	</span>
	<h3 class="type-h4 mt-10 mb-3 group-hover:text-primary-600 transition-colors">
		<?php echo esc_html( $args['title'] ); ?>
	</h3>
	<p class="type-body-sm text-muted">
		<?php echo esc_html( $args['body'] ); ?>
	</p>
</article>
