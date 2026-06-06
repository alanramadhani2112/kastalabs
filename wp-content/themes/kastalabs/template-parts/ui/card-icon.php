<?php
/**
 * Card with icon component.
 *
 * Generalisasi dari service-card: card dengan icon di atas, title, body.
 * Bisa dipakai untuk service, feature, atau value card.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $icon         Heroicon name.
 *     @type string $title        Card title.
 *     @type string $body         Card body.
 *     @type string $variant      'default' | 'soft' | 'solid' (default: 'soft').
 *     @type string $class        Additional CSS classes.
 *     @type string $icon_class   Additional classes for icon wrapper.
 *     @type bool   $data_reveal  Wrap with data-reveal attribute.
 *     @type string $reveal_delay data-reveal-delay value.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'icon'         => 'sparkles',
		'title'        => '',
		'body'         => '',
		'variant'      => 'soft',
		'class'        => '',
		'icon_class'   => '',
		'data_reveal'  => false,
		'reveal_delay' => '',
	)
);

$variant_map = array(
	'default' => 'zoom-card',
	'soft'    => 'zoom-card zoom-card--soft',
	'solid'   => 'zoom-card zoom-card--solid',
);

$card_class  = ( $variant_map[ $args['variant'] ] ?? 'zoom-card' );
$card_class .= ' group relative min-h-72 p-7 transition-transform duration-300 hover:-translate-y-1';

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

<article class="<?php echo esc_attr( $card_class ); ?>" data-service-card<?php echo $reveal_attrs; // phpcs:ignore ?>>
	<span class="text-primary-600 <?php echo esc_attr( $args['icon_class'] ); ?>">
		<?php kasta_icon( $args['icon'], array( 'class' => 'w-6 h-6' ) ); ?>
	</span>
	<h3 class="type-h4 mt-10 mb-3 group-hover:text-primary-600 transition-colors">
		<?php echo esc_html( $args['title'] ); ?>
	</h3>
	<p class="type-body-sm text-muted">
		<?php echo esc_html( $args['body'] ); ?>
	</p>
</article>
