<?php
/**
 * Horizontal divider / section separator.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $variant 'hairline' | 'subtle' | 'strong' (default: 'hairline').
 *     @type string $class   Additional CSS classes.
 *     @type string $label   Optional text in the middle (e.g., "ATAU").
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'variant' => 'hairline',
		'class'   => '',
		'label'   => '',
	)
);

$variant_map = array(
	'hairline' => 'border-hairline',
	'subtle'   => 'border-surface',
	'strong'   => 'border-muted',
);

$class  = $variant_map[ $args['variant'] ] ?? 'border-hairline';
$class .= ' border-t';
if ( $args['class'] ) {
	$class .= ' ' . $args['class'];
}

if ( $args['label'] ) : ?>
	<div class="flex items-center gap-4">
		<hr class="<?php echo esc_attr( $class ); ?> flex-1 border-0 border-t">
		<span class="type-label text-muted flex-none"><?php echo esc_html( $args['label'] ); ?></span>
		<hr class="<?php echo esc_attr( $class ); ?> flex-1 border-0 border-t">
	</div>
<?php else : ?>
	<hr class="<?php echo esc_attr( $class ); ?> border-0">
<?php endif; ?>
