<?php
/**
 * Work / portfolio card component.
 *
 * Dua varian:
 *   - 'grid':    zoom-card style (work-grid section di home).
 *   - 'archive': work-card style (archive-work masonry).
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $variant         'grid' | 'archive' (default: 'grid').
 *     @type int    $post_id         WP_Post ID. Kalau di-set, ambil data dari post.
 *     @type string $title           Card title (override post_title).
 *     @type string $category        Category label (override taxonomy).
 *     @type string $excerpt         Card excerpt (override post_excerpt).
 *     @type string $permalink       Card link URL.
 *     @type string $client          Client name (archive variant).
 *     @type string $year            Project year (archive variant).
 *     @type array  $terms           Array of term names (archive variant).
 *     @type string $term_slugs      Space-separated term slugs (archive filter).
 *     @type int    $index           Card index (archive variant, for sizing).
 *     @type string $placeholder     Teks placeholder kalau tidak ada thumbnail.
 *     @type string $class           Additional CSS classes.
 *     @type bool   $data_reveal     Wrap with data-reveal attribute.
 *     @type string $reveal_delay    data-reveal-delay value.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'variant'     => 'grid',
		'post_id'     => 0,
		'title'       => '',
		'category'    => '',
		'excerpt'     => '',
		'permalink'   => '',
		'client'      => '',
		'year'        => '',
		'terms'       => array(),
		'term_slugs'  => '',
		'index'       => 0,
		'placeholder' => __( 'Portfolio', 'kastalabs' ),
		'class'       => '',
		'data_reveal'   => true,
		'reveal_delay' => '0',
	)
);

// Resolve dari post — auto-detect from global $post when post_id not passed
$post_id = (int) $args['post_id'];
if ( ! $post_id ) {
	$maybe_id = get_the_ID();
	if ( $maybe_id ) {
		$post_id = $maybe_id;
	}
}
if ( $post_id && ! $args['title'] ) {
	$post_type = get_post_type( $post_id );
	$taxonomy  = 'portfolio' === $post_type ? 'portfolio_category' : 'work_category';

	$args['title']     = get_the_title( $post_id );
	$args['permalink'] = get_permalink( $post_id );
	$args['excerpt']   = has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : '';

	if ( ! $args['category'] ) {
		$cats = get_the_terms( $post_id, $taxonomy );
		if ( $cats && ! is_wp_error( $cats ) ) {
			$args['category'] = $cats[0]->name;
		}
	}
}

$thumbnail = '';
if ( $post_id && has_post_thumbnail( $post_id ) ) {
	$thumbnail = get_the_post_thumbnail(
		$post_id,
		'large',
		array(
			'class'   => 'w-full h-full object-cover scale-105 transition-transform duration-700 group-hover:scale-110',
			'loading' => 'lazy',
		)
	);
}

/* --------------------------------------------------------------------------
 * Grid variant — zoom-card with 4/3 thumb
 * -------------------------------------------------------------------------- */
if ( 'grid' === $args['variant'] ) :
	$card_class = 'zoom-card group overflow-hidden';
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

	<article class="<?php echo esc_attr( $card_class ); ?>" data-work-item data-work-card data-category="<?php echo esc_attr( $args['term_slugs'] ); ?>"<?php echo $reveal_attrs; // phpcs:ignore ?>>
		<a href="<?php echo esc_url( $args['permalink'] ); ?>" class="block text-inherit">
			<div class="aspect-[4/3] overflow-hidden bg-surface" data-work-media>
				<?php if ( $thumbnail ) : ?>
					<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php else : ?>
					<div class="flex h-full w-full items-center justify-center bg-surface">
						<span class="type-label text-muted"><?php echo esc_html( $args['placeholder'] ); ?></span>
					</div>
				<?php endif; ?>
			</div>
			<div class="p-6">
				<?php if ( $args['category'] ) : ?>
					<span class="eyebrow text-primary-600 mb-2 block"><?php echo esc_html( $args['category'] ); ?></span>
				<?php endif; ?>
				<h3 class="type-h4 group-hover:text-primary-600 transition-colors">
					<?php echo esc_html( $args['title'] ); ?>
				</h3>
				<?php if ( $args['excerpt'] ) : ?>
					<p class="type-body-sm mt-4 text-muted"><?php echo esc_html( $args['excerpt'] ); ?></p>
				<?php endif; ?>
			</div>
		</a>
	</article>

	<?php
	return;
endif;

/* --------------------------------------------------------------------------
 * Archive variant — work-card with masonry layout
 * -------------------------------------------------------------------------- */
$is_large    = ( 0 === $args['index'] % 3 );
$size_class  = $is_large ? 'work-card--large' : 'work-card--regular';
$image_size  = $is_large ? 'kasta-cover' : 'kasta-card';
$card_class  = 'work-card ' . $size_class;
if ( $args['class'] ) {
	$card_class .= ' ' . $args['class'];
}
?>

<article
	class="<?php echo esc_attr( $card_class ); ?>"
	data-work-card
	data-category="<?php echo esc_attr( $args['term_slugs'] ); ?>"
	data-index="<?php echo esc_attr( $args['index'] ); ?>"
>
	<a href="<?php echo esc_url( $args['permalink'] ); ?>" class="work-card__link" data-cursor="grow">
		<div class="work-card__media">
			<?php if ( $post_id && has_post_thumbnail( $post_id ) ) : ?>
				<?php echo get_the_post_thumbnail( $post_id, $image_size, array( 'class' => 'work-card__img' ) ); // phpcs:ignore ?>
			<?php else : ?>
				<div class="work-card__placeholder">
					<span class="type-label text-muted"><?php echo esc_html( sprintf( '%02d', $args['index'] + 1 ) ); ?></span>
				</div>
			<?php endif; ?>
			<div class="work-card__overlay"></div>
		</div>
		<div class="work-card__content">
			<div class="work-card__meta">
				<?php if ( $args['client'] ) : ?>
					<span class="eyebrow"><?php echo esc_html( $args['client'] ); ?></span>
				<?php endif; ?>
				<?php if ( $args['year'] ) : ?>
					<span class="eyebrow"><?php echo esc_html( $args['year'] ); ?></span>
				<?php endif; ?>
			</div>
			<h2 class="work-card__title"><?php echo esc_html( $args['title'] ); ?></h2>
			<?php if ( ! empty( $args['terms'] ) ) : ?>
				<div class="work-card__tags">
					<?php foreach ( $args['terms'] as $term_name ) : ?>
						<span class="work-card__tag"><?php echo esc_html( $term_name ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</a>
</article>
