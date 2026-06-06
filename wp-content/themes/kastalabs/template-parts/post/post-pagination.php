<?php
/**
 * Post pagination (prev/next links).
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $prev_label Previous link label.
 *     @type string $next_label Next link label.
 *     @type string $class      Additional CSS classes.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'prev_label' => __( '← Sebelumnya', 'kastalabs' ),
		'next_label' => __( 'Selanjutnya →', 'kastalabs' ),
		'class'      => '',
	)
);

$prev = get_previous_post_link(
	'<span class="flex-1 text-left">%link</span>',
	$args['prev_label']
);

$next = get_next_post_link(
	'<span class="flex-1 text-right">%link</span>',
	$args['next_label']
);

if ( ! $prev && ! $next ) {
	return;
}
?>
<nav class="post-pagination mt-16 border-t border-hairline pt-8<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>" aria-label="<?php esc_attr_e( 'Post navigation', 'kastalabs' ); ?>">
	<div class="type-body-sm flex justify-between gap-6">
		<?php
		if ( $prev ) {
			echo $prev; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — already escaped by WP
		} else {
			echo '<span class="flex-1"></span>';
		}
		if ( $next ) {
			echo $next; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			echo '<span class="flex-1"></span>';
		}
		?>
	</div>
</nav>
