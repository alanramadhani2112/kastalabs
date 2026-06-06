<?php
/**
 * Post tags list.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type int    $post_id     Post ID (auto-detects).
 *     @type string $taxonomy    Taxonomy to query (default: 'post_tag').
 *     @type string $before      HTML before tags.
 *     @type string $separator   Separator between tags.
 *     @type string $after       HTML after tags.
 *     @type string $class       Additional CSS classes on wrapper.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'post_id'   => 0,
		'taxonomy'  => 'post_tag',
		'before'    => '<span class="type-label text-muted mr-2">' . __( 'Tags:', 'kastalabs' ) . '</span>',
		'separator' => ' ',
		'after'     => '',
		'class'     => '',
	)
);

$post_id = $args['post_id'] ? (int) $args['post_id'] : get_the_ID();
if ( ! $post_id ) {
	return;
}

$tags = get_the_terms( $post_id, $args['taxonomy'] );
if ( ! $tags || is_wp_error( $tags ) ) {
	return;
}

$links = array();
foreach ( $tags as $tag ) {
	$links[] = sprintf(
		'<a href="%s" class="zoom-pill type-label text-muted hover:text-primary-600 transition-colors">%s</a>',
		esc_url( get_term_link( $tag ) ),
		esc_html( $tag->name )
	);
}
?>
<div class="post-tags mt-8 flex flex-wrap items-center gap-2<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>">
	<?php echo $args['before']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — static HTML ?>
	<?php echo implode( $args['separator'], $links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — links already escaped ?>
	<?php echo $args['after']; // phpcs:ignore ?>
</div>
