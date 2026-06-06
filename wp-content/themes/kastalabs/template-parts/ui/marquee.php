<?php
/**
 * Marquee / infinite ticker component.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type array  $items      Array of text items.
 *     @type int    $speed      Pixels per second (default: 40).
 *     @type bool   $pause_hover Pause on hover (default: true).
 *     @type string $separator  Divider between items (default: dot).
 *     @type string $class      Additional CSS classes.
 *     @type string $aria_label Section aria label.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'items'       => array(),
		'speed'       => 40,
		'pause_hover' => true,
		'separator'   => 'dot',
		'class'       => '',
		'aria_label'  => __( 'Kapabilitas Kastalabs', 'kastalabs' ),
	)
);

if ( empty( $args['items'] ) ) {
	return;
}

$pause_attr = $args['pause_hover'] ? ' data-marquee-pause-hover' : '';

$sep_html = '';
if ( 'dot' === $args['separator'] ) {
	$sep_html = '<span class="inline-block h-1.5 w-1.5 rounded-full bg-primary-500" aria-hidden="true"></span>';
} elseif ( 'slash' === $args['separator'] ) {
	$sep_html = '<span class="text-primary-500" aria-hidden="true">/</span>';
}
?>
<section class="py-10 bg-bg overflow-hidden<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>" aria-label="<?php echo esc_attr( $args['aria_label'] ); ?>">
	<div data-marquee data-marquee-speed="<?php echo esc_attr( (string) $args['speed'] ); ?>"<?php echo $pause_attr; // phpcs:ignore ?>>
		<div data-marquee-track class="flex items-center gap-12">
			<?php foreach ( $args['items'] as $item ) : ?>
				<span class="type-label text-muted whitespace-nowrap flex items-center gap-12">
					<?php echo esc_html( $item ); ?>
					<?php if ( $sep_html ) : ?>
						<?php echo $sep_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — static HTML ?>
					<?php endif; ?>
				</span>
			<?php endforeach; ?>
		</div>
	</div>
</section>
