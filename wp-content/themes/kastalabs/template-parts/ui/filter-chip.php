<?php
/**
 * Filter chip component (toggle button untuk filter taxonomy).
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $label       Chip label.
 *     @type string $filter      Filter slug value (data-filter attribute).
 *     @type int    $count       Optional count badge.
 *     @type bool   $is_active   Whether initially active (default: false).
 *     @type string $class       Additional CSS classes.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'label'     => '',
		'filter'    => '*',
		'count'     => 0,
		'is_active' => false,
		'class'     => '',
	)
);

$class  = 'filter-chip';
$class .= $args['is_active'] ? ' is-active' : '';
if ( $args['class'] ) {
	$class .= ' ' . $args['class'];
}

$aria_selected = $args['is_active'] ? 'true' : 'false';
?>
<button
	class="<?php echo esc_attr( $class ); ?>"
	data-filter="<?php echo esc_attr( $args['filter'] ); ?>"
	role="tab"
	aria-selected="<?php echo esc_attr( $aria_selected ); ?>"
>
	<?php echo esc_html( $args['label'] ); ?>
	<?php if ( $args['count'] > 0 ) : ?>
		<span class="filter-chip-count"><?php echo esc_html( (string) $args['count'] ); ?></span>
	<?php endif; ?>
</button>
