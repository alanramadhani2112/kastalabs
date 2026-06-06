<?php
/**
 * Alert / status message component.
 *
 * Variants: success, error, warning, info.
 * Dipakai di contact form dan form feedback lainnya.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $message  Alert text.
 *     @type string $variant  'success' | 'error' | 'warning' | 'info' (default: 'info').
 *     @type string $class    Additional CSS classes.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'message' => '',
		'variant' => 'info',
		'class'   => '',
	)
);

if ( ! $args['message'] ) {
	return;
}

$variant_map = array(
	'success' => 'border-primary-500/30 bg-surface text-primary-700',
	'error'   => 'border-red-400/40 bg-red-50 text-red-700',
	'warning' => 'border-amber-400/40 bg-amber-50 text-amber-700',
	'info'    => 'border-blue-400/40 bg-blue-50 text-blue-700',
);

$class  = $variant_map[ $args['variant'] ] ?? $variant_map['info'];
$class .= ' rounded-lg border p-4';
if ( $args['class'] ) {
	$class .= ' ' . $args['class'];
}
?>
<p class="<?php echo esc_attr( $class ); ?>">
	<?php echo esc_html( $args['message'] ); ?>
</p>
