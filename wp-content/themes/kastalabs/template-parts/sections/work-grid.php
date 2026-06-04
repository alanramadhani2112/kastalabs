<?php
/**
 * Featured portfolio grid section.
 *
 * Displays portfolio items with a calm editorial card treatment.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$portfolio_eyebrow   = kasta_site_option( 'portfolio_eyebrow', __( 'Selected Work', 'kastalabs' ) );
$portfolio_heading   = kasta_site_option( 'portfolio_heading', __( 'Karya yang dibuat untuk meninggalkan kesan.', 'kastalabs' ) );
$portfolio_body      = kasta_site_option( 'portfolio_body', __( 'Beberapa contoh bagaimana strategi, visual, dan teknologi disusun menjadi pengalaman digital yang lebih mudah dipercaya.', 'kastalabs' ) );
$portfolio_cta_label = kasta_site_option( 'portfolio_cta_label', __( 'Lihat semua portfolio', 'kastalabs' ) );
$portfolio_cta_url   = kasta_site_url_option( 'portfolio_cta_url', get_post_type_archive_link( 'portfolio' ) ?: '/portfolio/' );

$portfolio_query = new WP_Query(
	array(
		'post_type'      => 'portfolio',
		'posts_per_page' => 4,
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);

// Fallback placeholders if no work posts yet.
$placeholders = array(
	array( 'title' => 'Project Alpha', 'cat' => 'Branding' ),
	array( 'title' => 'Project Beta', 'cat' => 'Web Development' ),
	array( 'title' => 'Project Gamma', 'cat' => 'UI/UX Design' ),
	array( 'title' => 'Project Delta', 'cat' => 'Motion Design' ),
);
?>

<section class="py-24 md:py-32 bg-bg" data-work-grid>
	<div class="container-x">
		<div class="zoom-section-heading mb-14">
			<div data-reveal>
				<?php kasta_eyebrow( $portfolio_eyebrow ); ?>
				<h2 class="type-h2 mt-4">
					<?php echo esc_html( $portfolio_heading ); ?>
				</h2>
				<p class="type-body mt-5 text-muted">
					<?php echo esc_html( $portfolio_body ); ?>
				</p>
			</div>
		</div>

		<div class="mb-10 hidden justify-center md:flex">
			<a
				href="<?php echo esc_url( $portfolio_cta_url ); ?>"
				class="btn-ghost"
				data-magnetic
			>
				<?php echo esc_html( $portfolio_cta_label ); ?>
			</a>
		</div>

		<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
			<?php if ( $portfolio_query->have_posts() ) : ?>
				<?php while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post(); ?>
					<article class="zoom-card group overflow-hidden" data-work-item>
						<a href="<?php the_permalink(); ?>" class="block text-inherit">
							<div class="aspect-[4/3] overflow-hidden bg-surface" data-work-media>
								<?php if ( has_post_thumbnail() ) : ?>
									<?php
									the_post_thumbnail(
										'large',
										array(
											'class'   => 'w-full h-full object-cover scale-105 transition-transform duration-700 group-hover:scale-110',
											'loading' => 'lazy',
										)
									);
									?>
								<?php else : ?>
									<div class="flex h-full w-full items-center justify-center bg-surface">
										<span class="type-label text-muted"><?php esc_html_e( 'Portfolio', 'kastalabs' ); ?></span>
									</div>
								<?php endif; ?>
							</div>
							<div class="p-6">
							<?php
							$categories = get_the_terms( get_the_ID(), 'portfolio_category' );
							if ( $categories && ! is_wp_error( $categories ) ) :
							?>
								<span class="eyebrow text-primary-600 mb-2 block">
									<?php echo esc_html( $categories[0]->name ); ?>
								</span>
							<?php endif; ?>
							<h3 class="type-h4 group-hover:text-primary-600 transition-colors">
								<?php the_title(); ?>
							</h3>
							<?php if ( has_excerpt() ) : ?>
								<p class="type-body-sm mt-4 text-muted"><?php echo esc_html( get_the_excerpt() ); ?></p>
							<?php endif; ?>
							</div>
						</a>
					</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ( $placeholders as $ph ) : ?>
					<article class="zoom-card overflow-hidden" data-work-item>
						<div class="flex aspect-[4/3] w-full items-center justify-center bg-surface" data-work-media>
							<span class="type-label text-muted"><?php echo esc_html( $ph['cat'] ); ?></span>
						</div>
						<div class="p-6">
							<span class="eyebrow text-primary-600 mb-2 block"><?php echo esc_html( $ph['cat'] ); ?></span>
							<h3 class="type-h4"><?php echo esc_html( $ph['title'] ); ?></h3>
						</div>
					</article>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<div class="mt-10 text-center md:hidden">
			<a
				href="<?php echo esc_url( $portfolio_cta_url ); ?>"
				class="btn-ghost"
				data-magnetic
			>
				<?php echo esc_html( $portfolio_cta_label ); ?>
			</a>
		</div>
	</div>
</section>
