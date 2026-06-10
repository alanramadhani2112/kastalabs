<?php
/**
 * Single portfolio template — case study detail.
 *
 * Structure: context → challenge → approach → solution → results → gallery.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$client      = (string) get_post_meta( get_the_ID(), 'client_name', true );
	$year        = (string) get_post_meta( get_the_ID(), 'project_year', true );
	$role        = (string) get_post_meta( get_the_ID(), 'role', true );
	$scope       = (string) get_post_meta( get_the_ID(), 'scope', true );
	$project_url = (string) get_post_meta( get_the_ID(), 'project_url', true );
	$categories  = get_the_terms( get_the_ID(), 'portfolio_category' );
	$tags        = get_the_terms( get_the_ID(), 'portfolio_tag' );
	?>

	<main id="main" role="main" data-page="portfolio-single">
		<article class="overflow-hidden">
			<?php /* ---------- Case Study Hero ---------- */ ?>
			<header class="zoom-page-hero py-24 md:py-32">
				<div class="container-x grid gap-12 lg:grid-cols-[minmax(0,1fr)_22rem] lg:items-end">
					<div class="max-w-5xl">
						<p class="eyebrow">
							<?php
							$eyebrow_parts = array_filter( array( $client, $year ) );
							echo esc_html( implode( ' / ', $eyebrow_parts ) ?: __( 'Portfolio Project', 'kastalabs' ) );
							?>
						</p>
						<h1 class="type-display-lg mt-6">
							<?php the_title(); ?>
						</h1>
						<?php if ( has_excerpt() ) : ?>
							<p class="type-body-lg measure-copy text-muted mt-8">
								<?php echo esc_html( get_the_excerpt() ); ?>
							</p>
						<?php endif; ?>
					</div>

					<aside class="zoom-card bg-bg p-6">
						<ul class="grid gap-5 list-none p-0 m-0">
							<?php foreach ( array( __( 'Client', 'kastalabs' ) => $client, __( 'Year', 'kastalabs' ) => $year, __( 'Role', 'kastalabs' ) => $role, __( 'Scope', 'kastalabs' ) => $scope ) as $label => $value ) : ?>
								<?php if ( $value ) : ?>
									<li>
										<p class="eyebrow"><?php echo esc_html( $label ); ?></p>
										<p class="mt-2 text-fg"><?php echo esc_html( $value ); ?></p>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
						<?php if ( $project_url ) : ?>
							<a class="btn-primary mt-8 w-full justify-center" href="<?php echo esc_url( $project_url ); ?>" target="_blank" rel="noopener noreferrer">
								<?php esc_html_e( 'Visit project', 'kastalabs' ); ?>
							</a>
						<?php endif; ?>
					</aside>
				</div>
			</header>

			<?php /* ---------- Cover image ---------- */ ?>
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="container-x">
					<div class="zoom-card overflow-hidden bg-surface">
						<?php
						the_post_thumbnail(
							'kasta-cover',
							array(
								'class'         => 'w-full h-auto object-cover',
								'loading'       => 'eager',
								'fetchpriority' => 'high',
							)
						);
						?>
					</div>
				</figure>
			<?php endif; ?>

			<?php /* ---------- Body — structured case study ---------- */ ?>
			<section class="container-x py-16 md:py-24">
				<?php
				$sections = array(
					__( 'Konteks', 'kastalabs' )    => (string) get_post_meta( get_the_ID(), 'context', true ),
					__( 'Tantangan', 'kastalabs' )  => (string) get_post_meta( get_the_ID(), 'challenge', true ),
					__( 'Pendekatan', 'kastalabs' ) => (string) get_post_meta( get_the_ID(), 'approach', true ),
					__( 'Solusi', 'kastalabs' )     => (string) get_post_meta( get_the_ID(), 'solution', true ),
					__( 'Hasil', 'kastalabs' )      => (string) get_post_meta( get_the_ID(), 'results', true ),
				);

				$has_structured = false;
				foreach ( $sections as $s ) {
					if ( '' !== trim( $s ) ) { $has_structured = true; break; }
				}
				?>

				<?php if ( $has_structured ) : ?>
					<div class="grid gap-12 lg:grid-cols-[16rem_minmax(0,44rem)] lg:items-start">
						<aside class="lg:sticky lg:top-28">
							<a class="eyebrow inline-flex hover:text-primary-600 transition-colors" href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>">
								&larr; <?php esc_html_e( 'Kembali ke portfolio', 'kastalabs' ); ?>
							</a>

							<nav class="mt-10" aria-label="<?php esc_attr_e( 'Case study sections', 'kastalabs' ); ?>">
								<ul class="grid gap-2">
									<?php foreach ( $sections as $label => $content ) : ?>
										<?php if ( '' !== trim( $content ) ) : ?>
											<li>
												<a class="type-body-sm block rounded-lg px-3 py-2 text-muted hover:text-fg hover:bg-surface transition-colors" href="<?php echo esc_attr( '#' . sanitize_title( $label ) ); ?>">
													<?php echo esc_html( $label ); ?>
												</a>
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							</nav>

							<?php if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) : ?>
								<div class="zoom-card zoom-card--soft mt-10 p-5">
									<p class="eyebrow"><?php esc_html_e( 'Category', 'kastalabs' ); ?></p>
									<div class="mt-4 flex flex-wrap gap-2">
										<?php foreach ( $categories as $category ) : ?>
											<a class="type-body-sm rounded-md border border-hairline px-3 py-1 text-muted hover:border-primary-500 hover:text-primary-600 transition-colors" href="<?php echo esc_url( get_term_link( $category ) ); ?>">
												<?php echo esc_html( $category->name ); ?>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( ! is_wp_error( $tags ) && ! empty( $tags ) ) : ?>
								<div class="zoom-card mt-8 p-5">
									<p class="eyebrow"><?php esc_html_e( 'Tags', 'kastalabs' ); ?></p>
									<div class="mt-4 flex flex-wrap gap-2">
										<?php foreach ( $tags as $tag ) : ?>
											<a class="type-body-sm rounded-md bg-surface px-3 py-1 text-muted hover:bg-primary-500 hover:text-white transition-colors" href="<?php echo esc_url( get_term_link( $tag ) ); ?>">
												<?php echo esc_html( $tag->name ); ?>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>
						</aside>

						<div class="prose max-w-none" data-reveal>
							<?php foreach ( $sections as $label => $content ) : ?>
								<?php if ( '' !== trim( $content ) ) : ?>
									<section id="<?php echo esc_attr( sanitize_title( $label ) ); ?>">
										<h2><?php echo esc_html( $label ); ?></h2>
										<?php echo wp_kses_post( wpautop( $content ) ); ?>
									</section>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
				<?php else : ?>
					<div class="grid gap-12 lg:grid-cols-[16rem_minmax(0,44rem)] lg:items-start">
						<aside class="lg:sticky lg:top-28">
							<a class="eyebrow inline-flex hover:text-primary-600 transition-colors" href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>">
								&larr; <?php esc_html_e( 'Kembali ke portfolio', 'kastalabs' ); ?>
							</a>

							<?php if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) : ?>
								<div class="zoom-card zoom-card--soft mt-10 p-5">
									<p class="eyebrow"><?php esc_html_e( 'Category', 'kastalabs' ); ?></p>
									<div class="mt-4 flex flex-wrap gap-2">
										<?php foreach ( $categories as $category ) : ?>
											<a class="type-body-sm rounded-md border border-hairline px-3 py-1 text-muted hover:border-primary-500 hover:text-primary-600 transition-colors" href="<?php echo esc_url( get_term_link( $category ) ); ?>">
												<?php echo esc_html( $category->name ); ?>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( ! is_wp_error( $tags ) && ! empty( $tags ) ) : ?>
								<div class="zoom-card mt-8 p-5">
									<p class="eyebrow"><?php esc_html_e( 'Tags', 'kastalabs' ); ?></p>
									<div class="mt-4 flex flex-wrap gap-2">
										<?php foreach ( $tags as $tag ) : ?>
											<a class="type-body-sm rounded-md bg-surface px-3 py-1 text-muted hover:bg-primary-500 hover:text-white transition-colors" href="<?php echo esc_url( get_term_link( $tag ) ); ?>">
												<?php echo esc_html( $tag->name ); ?>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>
						</aside>

						<div class="prose" data-reveal>
							<?php if ( trim( get_the_content() ) ) : ?>
								<?php the_content(); ?>
							<?php else : ?>
								<p><?php esc_html_e( 'Detail case study sedang disiapkan. Konten lengkap — mencakup konteks, tantangan, pendekatan, solusi, dan hasil — akan ditambahkan segera.', 'kastalabs' ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</section>

			<?php /* ---------- CTA ---------- */ ?>
			<section class="container-x pb-24 md:pb-32">
				<div class="zoom-card zoom-card--solid p-10 md:p-14 text-center" data-reveal>
					<h2 class="type-h2"><?php esc_html_e( 'Ingin membangun project dengan pendekatan seperti ini?', 'kastalabs' ); ?></h2>
					<p class="type-body mt-4 max-w-lg mx-auto">
						<?php esc_html_e( 'Ceritakan proyek Anda. Kami dengarkan konteksnya, lalu bantu petakan langkah yang paling masuk akal.', 'kastalabs' ); ?>
					</p>
					<div class="mt-8">
						<?php
						get_template_part(
							'template-parts/ui/button',
							null,
							array(
								'label'    => __( 'Mulai percakapan', 'kastalabs' ),
								'url'      => home_url( '/contact/' ),
								'variant'  => 'primary',
								'magnetic' => true,
							)
						);
						?>
					</div>
				</div>
			</section>
		</article>
	</main>

<?php endwhile; ?>

<?php get_footer();
