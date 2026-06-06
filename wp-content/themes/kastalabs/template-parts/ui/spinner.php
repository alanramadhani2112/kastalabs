<?php
/**
 * Loading spinner indicator.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $size  'sm' | 'md' | 'lg' (default: 'md').
 *     @type string $class Additional CSS classes.
 *     @type string $label Screen reader label (default: 'Loading').
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'size'  => 'md',
		'class' => '',
		'label' => __( 'Loading…', 'kastalabs' ),
	)
);

$size_map = array(
	'sm' => 'h-4 w-4 border-2',
	'md' => 'h-8 w-8 border-[3px]',
	'lg' => 'h-12 w-12 border-4',
);

$class  = $size_map[ $args['size'] ] ?? 'h-8 w-8 border-[3px]';
$class .= ' animate-spin rounded-full border-primary-200 border-t-primary-600';
if ( $args['class'] ) {
	$class .= ' ' . $args['class'];
}
?>
<div class="<?php echo esc_attr( $class ); ?>" role="status">
	<span class="sr-only"><?php echo esc_html( $args['label'] ); ?></span>
</div>
