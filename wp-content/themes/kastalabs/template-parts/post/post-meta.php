<?php
/**
 * Post metadata component.
 *
 * Menampilkan date, reading time, categories.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type int    $post_id      Post ID (auto-detects from loop).
 *     @type bool   $show_date    Show publish date (default: true).
 *     @type bool   $show_reading  Show reading time (default: true).
 *     @type bool   $show_cats    Show categories (default: false).
 *     @type string $variant      'default' | 'compact' (default: 'default').
 *     @type string $class        Additional CSS classes.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'post_id'      => 0,
		'show_date'    => true,
		'show_reading' => true,
		'show_cats'    => false,
		'variant'      => 'default',
		'class'        => '',
	)
);

$post_id = $args['post_id'] ? (int) $args['post_id'] : get_the_ID();
if ( ! $post_id ) {
	return;
}

$date_html    = '';
$reading_html = '';
$cats_html    = '';

if ( $args['show_date'] ) {
	$date_html = sprintf(
		'<time datetime="%s" class="whitespace-nowrap">%s</time>',
		esc_attr( get_the_date( 'c', $post_id ) ),
		esc_html( get_the_date( '', $post_id ) )
	);
}

if ( $args['show_reading'] ) {
	$minutes = (int) ceil( str_word_count( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ?: '' ) ) / 220 );
	$minutes = max( 1, $minutes );
	// translators: %d = number of minutes
	$reading_html = sprintf( esc_html__( '%d menit baca', 'kastalabs' ), $minutes );
}

if ( $args['show_cats'] ) {
	$terms = get_the_terms( $post_id, 'category' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		$names = array_map( fn( $t ) => $t->name, $terms );
		$cats_html = esc_html( implode( ', ', $names ) );
	}
}

$separator = 'compact' === $args['variant'] ? ' · ' : ' / ';
$parts     = array_filter( array( $date_html, $reading_html, $cats_html ) );
if ( ! $parts ) {
	return;
}

$class = 'compact' === $args['variant'] ? 'type-caption text-muted' : 'type-body-sm text-muted';
if ( $args['class'] ) {
	$class .= ' ' . $args['class'];
}
?>
<div class="<?php echo esc_attr( $class ); ?>">
	<?php echo implode( ' <span class="text-muted/40">' . esc_html( $separator ) . '</span> ', $parts ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — parts already escaped ?>
</div>
