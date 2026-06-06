<?php
/**
 * Insight / blog card component.
 *
 * Digunakan di archive-insight.php dan berpotensi di home (insight terbaru).
 *
 * @package KastaLabs
 * @param array $args {
 *     @type int    $post_id      WP_Post ID.
 *     @type string $permalink    Card link URL.
 *     @type string $title        Card title.
 *     @type string $date         Display date.
 *     @type string $class        Additional CSS classes.
 *     @type bool   $data_reveal  Wrap with data-reveal attribute.
 *     @type string $reveal_delay data-reveal-delay value.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'post_id'      => 0,
		'permalink'    => '',
		'title'        => '',
		'date'         => '',
		'class'        => '',
		'data_reveal'  => false,
		'reveal_delay' => '',
	)
);

$post_id = (int) $args['post_id'];
if ( ! $post_id ) {
	$maybe_id = get_the_ID();
	if ( $maybe_id ) {
		$post_id = $maybe_id;
	}
}
if ( $post_id ) {
	if ( ! $args['permalink'] ) {
		$args['permalink'] = get_permalink( $post_id );
	}
	if ( ! $args['title'] ) {
		$args['title'] = get_the_title( $post_id );
	}
	if ( ! $args['date'] ) {
		$args['date'] = get_the_date( '', $post_id );
	}
}

$card_class = 'zoom-card overflow-hidden';
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

<article class="<?php echo esc_attr( $card_class ); ?>"<?php echo $reveal_attrs; // phpcs:ignore ?>>
	<?php if ( $post_id && has_post_thumbnail( $post_id ) ) : ?>
		<a href="<?php echo esc_url( $args['permalink'] ); ?>" class="block aspect-[4/3] overflow-hidden bg-surface">
			<?php echo get_the_post_thumbnail( $post_id, 'kasta-thumb', array( 'class' => 'w-full h-full object-cover' ) ); // phpcs:ignore ?>
		</a>
	<?php endif; ?>
	<div class="p-6">
		<?php if ( $args['date'] ) : ?>
			<p class="eyebrow"><?php echo esc_html( $args['date'] ); ?></p>
		<?php endif; ?>
		<h2 class="type-h4 mt-2">
			<a href="<?php echo esc_url( $args['permalink'] ); ?>"><?php echo esc_html( $args['title'] ); ?></a>
		</h2>
	</div>
</article>
