<?php
/**
 * Page wrapper with optional sidebar.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $layout     'full' | 'sidebar-right' | 'sidebar-left' (default: 'full').
 *     @type string $class      Additional CSS classes on wrapper.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'layout' => 'full',
		'class'  => '',
	)
);

$grid_class = '';
if ( 'sidebar-right' === $args['layout'] ) {
	$grid_class = 'grid gap-12 lg:grid-cols-[minmax(0,1fr)_22rem]';
} elseif ( 'sidebar-left' === $args['layout'] ) {
	$grid_class = 'grid gap-12 lg:grid-cols-[22rem_minmax(0,1fr)]';
}

if ( $args['class'] ) {
	$grid_class .= ' ' . $args['class'];
}
?>
<div class="container-x py-24 md:py-32<?php echo $grid_class ? ' ' . esc_attr( trim( $grid_class ) ) : ''; ?>">
	<?php if ( 'sidebar-left' === $args['layout'] ) : ?>
		<aside class="self-start" data-sidebar></aside>
	<?php endif; ?>

	<div class="min-w-0" data-main-content></div>

	<?php if ( 'sidebar-right' === $args['layout'] ) : ?>
		<aside class="self-start" data-sidebar></aside>
	<?php endif; ?>
</div>
