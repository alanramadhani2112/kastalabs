<?php
/**
 * Portfolio archive template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main" class="work-archive" role="main" data-page="portfolio-archive">
	<section class="zoom-page-hero py-24 md:py-32">
		<div class="container-x">
			<div class="zoom-page-hero__content">
				<p class="eyebrow"><?php esc_html_e( 'Portfolio', 'kastalabs' ); ?></p>
				<h1 class="type-display-lg mt-6">
					<?php esc_html_e( 'Project pilihan yang kami bangun dengan strategi dan niat.', 'kastalabs' ); ?>
				</h1>
				<p class="type-body-lg measure-copy text-muted mt-8">
					<?php esc_html_e( 'Setiap project punya konteks dan tantangan berbeda. Karena itu pendekatan kami selalu dimulai dari memahami, bukan langsung mendesain.', 'kastalabs' ); ?>
				</p>
			</div>
		</div>
	</section>

	<?php
	$categories = get_terms(
		array(
			'taxonomy'   => 'portfolio_category',
			'hide_empty' => true,
		)
	);
	?>

	<?php if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) : ?>
		<section class="container-x py-12" data-work-filters>
			<div class="flex flex-wrap gap-3" role="tablist" aria-label="<?php esc_attr_e( 'Filter projects', 'kastalabs' ); ?>">
				<button class="filter-chip is-active" data-filter="*" role="tab" aria-selected="true">
					<?php esc_html_e( 'Semua', 'kastalabs' ); ?>
				</button>
				<?php foreach ( $categories as $category ) : ?>
					<button class="filter-chip" data-filter="<?php echo esc_attr( $category->slug ); ?>" role="tab" aria-selected="false">
						<?php echo esc_html( $category->name ); ?>
						<span class="filter-chip-count"><?php echo esc_html( $category->count ); ?></span>
					</button>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<section class="container-x pb-32">
			<div class="work-masonry" data-work-masonry>
				<?php
				$index = 0;
				while ( have_posts() ) :
					the_post();

					$terms      = get_the_terms( get_the_ID(), 'portfolio_category' );
					$term_slugs = '';
					$term_names = array();
					if ( $terms && ! is_wp_error( $terms ) ) {
						$term_slugs = implode( ' ', wp_list_pluck( $terms, 'slug' ) );
						$term_names = wp_list_pluck( $terms, 'name' );
					}

					get_template_part(
						'template-parts/cards/work-card',
						null,
						array(
							'variant'    => 'archive',
							'post_id'    => get_the_ID(),
							'client'     => (string) get_post_meta( get_the_ID(), 'client_name', true ),
							'year'       => (string) get_post_meta( get_the_ID(), 'project_year', true ),
							'terms'      => $term_names,
							'term_slugs' => $term_slugs,
							'index'      => $index,
						)
					);

					$index++;
				endwhile;
				?>
			</div>

			<?php the_posts_pagination( array( 'class' => 'work-pagination mt-20' ) ); ?>
		</section>
	<?php else : ?>
		<section class="container-x pb-32">
			<div class="zoom-card zoom-card--soft p-8">
				<h2 class="type-h4"><?php esc_html_e( 'Portfolio sedang disiapkan.', 'kastalabs' ); ?></h2>
				<p class="type-body text-muted mt-3"><?php esc_html_e( 'Project pilihan akan muncul di sini setelah konten final dimuat.', 'kastalabs' ); ?></p>
			</div>
		</section>
	<?php endif; ?>
</main>

<?php
get_footer();
