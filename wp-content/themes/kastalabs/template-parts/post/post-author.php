<?php
/**
 * Post author box.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type int    $post_id    Post ID (auto-detects).
 *     @type string $variant    'default' | 'compact' (default: 'default').
 *     @type string $class      Additional CSS classes.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'post_id' => 0,
		'variant' => 'default',
		'class'   => '',
	)
);

$post_id   = $args['post_id'] ? (int) $args['post_id'] : get_the_ID();
$author_id = get_post_field( 'post_author', $post_id );
if ( ! $author_id ) {
	return;
}

$author_name = get_the_author_meta( 'display_name', $author_id );
$author_bio  = get_the_author_meta( 'description', $author_id );
$avatar      = get_avatar( $author_id, 64, '', '', array( 'class' => 'rounded-full' ) );
$author_url  = get_author_posts_url( $author_id );

$class = 'zoom-card zoom-card--soft';
if ( 'compact' === $args['variant'] ) {
	$class .= ' p-4';
} else {
	$class .= ' p-6';
}
if ( $args['class'] ) {
	$class .= ' ' . $args['class'];
}
?>
<div class="<?php echo esc_attr( $class ); ?>">
	<div class="flex items-start gap-4<?php echo 'compact' === $args['variant'] ? '' : ' md:items-center'; ?>">
		<a href="<?php echo esc_url( $author_url ); ?>" class="flex-none">
			<?php echo $avatar; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — WP-generated safe HTML ?>
		</a>
		<div>
			<a href="<?php echo esc_url( $author_url ); ?>" class="type-body-sm font-semibold hover:text-primary-600 transition-colors">
				<?php echo esc_html( $author_name ); ?>
			</a>
			<?php if ( $author_bio && 'compact' !== $args['variant'] ) : ?>
				<p class="type-body-sm text-muted mt-1"><?php echo esc_html( $author_bio ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>
