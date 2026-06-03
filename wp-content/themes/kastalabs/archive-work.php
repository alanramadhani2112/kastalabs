<?php
/**
 * Archive (index) untuk CPT 'work'.
 * Filterable masonry grid with GSAP stagger animations.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" class="work-archive" role="main" data-page="work-archive">

	<!-- Hero Section -->
	<section class="container-x pt-32 pb-20 md:pt-44 md:pb-28" data-work-hero>
		<div class="max-w-5xl">
			<p class="eyebrow" data-reveal><?php esc_html_e( 'Portfolio', 'kastalabs' ); ?></p>
			<h1 class="font-display font-extrabold text-5xl md:text-8xl lg:text-9xl tracking-tight leading-[0.9] mt-6" data-reveal data-reveal-delay="0.1">
				<?php esc_html_e( 'Selected work', 'kastalabs' ); ?>
			</h1>
			<p class="text-muted text-lg md:text-xl mt-8 max-w-2xl leading-relaxed" data-reveal data-reveal-delay="0.2">
				<?php esc_html_e( 'Koleksi proyek terpilih yang menunjukkan pendekatan kami dalam branding, desain digital, dan pengembangan web.', 'kastalabs' ); ?>
			</p>
		</div>
	</section>

	<!-- Filter Chips -->
	<?php
	$categories = get_terms(
		array(
			'taxonomy'   => 'work_category',
			'hide_empty' => true,
		)
	);
	?>
	<?php if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) : ?>
		<section class="container-x pb-12" data-work-filters>
			<div class="flex flex-wrap gap-3" role="tablist" aria-label="<?php esc_attr_e( 'Filter projects', 'kastalabs' ); ?>">
				<button
					class="filter-chip is-active"
					data-filter="*"
					role="tab"
					aria-selected="true"
				>
					<?php esc_html_e( 'Semua', 'kastalabs' ); ?>
				</button>
				<?php foreach ( $categories as $cat ) : ?>
					<button
						class="filter-chip"
						data-filter="<?php echo esc_attr( $cat->slug ); ?>"
						role="tab"
						aria-selected="false"
					>
						<?php echo esc_html( $cat->name ); ?>
						<span class="filter-chip-count"><?php echo esc_html( $cat->count ); ?></span>
					</button>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Work Grid -->
	<?php if ( have_posts() ) : ?>
		<section class="container-x pb-32" data-work-grid-archive>
			<div class="work-masonry" data-work-masonry>
				<?php
				$index = 0;
				while ( have_posts() ) :
					the_post();
					$client     = (string) get_post_meta( get_the_ID(), 'client_name', true );
					$year       = (string) get_post_meta( get_the_ID(), 'project_year', true );
					$terms      = get_the_terms( get_the_ID(), 'work_category' );
					$term_slugs = '';
					$term_names = array();
					if ( $terms && ! is_wp_error( $terms ) ) {
						$term_slugs = implode( ' ', wp_list_pluck( $terms, 'slug' ) );
						$term_names = wp_list_pluck( $terms, 'name' );
					}
					// Alternate sizes: large (span 2 cols) every 3rd item
					$is_large = ( 0 === $index % 3 );
					$size_class = $is_large ? 'work-card--large' : 'work-card--regular';
					?>
					<article
						class="work-card <?php echo esc_attr( $size_class ); ?>"
						data-work-card
						data-category="<?php echo esc_attr( $term_slugs ); ?>"
						data-index="<?php echo esc_attr( $index ); ?>"
					>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="work-card__link" data-cursor="grow">
							<div class="work-card__media">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( $is_large ? 'kasta-cover' : 'kasta-card', array( 'class' => 'work-card__img' ) ); ?>
								<?php else : ?>
									<div class="work-card__placeholder">
										<span class="font-mono text-xs text-muted"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
									</div>
								<?php endif; ?>
								<div class="work-card__overlay"></div>
							</div>
							<div class="work-card__content">
								<div class="work-card__meta">
									<?php if ( $client ) : ?>
										<span class="eyebrow"><?php echo esc_html( $client ); ?></span>
									<?php endif; ?>
									<?php if ( $year ) : ?>
										<span class="eyebrow"><?php echo esc_html( $year ); ?></span>
									<?php endif; ?>
								</div>
								<h2 class="work-card__title"><?php the_title(); ?></h2>
								<?php if ( ! empty( $term_names ) ) : ?>
									<div class="work-card__tags">
										<?php foreach ( $term_names as $name ) : ?>
											<span class="work-card__tag"><?php echo esc_html( $name ); ?></span>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
							</div>
						</a>
					</article>
					<?php
					$index++;
				endwhile;
				?>
			</div>

			<?php
			the_posts_pagination(
				array(
					'class'     => 'work-pagination mt-20',
					'prev_text' => '&larr; ' . __( 'Sebelumnya', 'kastalabs' ),
					'next_text' => __( 'Selanjutnya', 'kastalabs' ) . ' &rarr;',
				)
			);
			?>
		</section>
	<?php else : ?>
		<section class="container-x pb-32">
			<div class="text-center py-20">
				<p class="text-muted text-lg"><?php esc_html_e( 'Belum ada karya yang dipublikasi.', 'kastalabs' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary mt-8">
					<?php esc_html_e( 'Kembali ke beranda', 'kastalabs' ); ?>
				</a>
			</div>
		</section>
	<?php endif; ?>

</main>

<?php get_footer();
