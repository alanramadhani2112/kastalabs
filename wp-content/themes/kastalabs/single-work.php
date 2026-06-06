<?php
/**
 * Legacy Work single template.
 *
 * Kept temporarily while `/work/` routes remain available during migration to
 * the final Portfolio content model.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main" role="main" data-page="work-single">
	<?php
	while ( have_posts() ) :
		the_post();

		$client      = (string) get_post_meta( get_the_ID(), 'client_name', true );
		$year        = (string) get_post_meta( get_the_ID(), 'project_year', true );
		$role        = (string) get_post_meta( get_the_ID(), 'role', true );
		$scope       = (string) get_post_meta( get_the_ID(), 'scope', true );
		$project_url = (string) get_post_meta( get_the_ID(), 'project_url', true );
		$categories  = get_the_terms( get_the_ID(), 'work_category' );
		$tags        = get_the_terms( get_the_ID(), 'work_tag' );
		?>

		<article class="overflow-hidden">
			<header class="zoom-page-hero py-24 md:py-32">
				<div class="container-x grid gap-12 lg:grid-cols-[minmax(0,1fr)_22rem] lg:items-end">
					<div class="max-w-5xl">
						<p class="eyebrow">
							<?php
							$eyebrow = trim( $client . ( $year ? ' / ' . $year : '' ) );
							echo esc_html( $eyebrow ?: __( 'Legacy Work', 'kastalabs' ) );
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
						<dl class="grid gap-5">
							<?php foreach ( array( 'Klien' => $client, 'Tahun' => $year, 'Peran' => $role, 'Lingkup' => $scope ) as $label => $value ) : ?>
								<?php if ( $value ) : ?>
									<div>
										<dt class="eyebrow"><?php echo esc_html( $label ); ?></dt>
										<dd class="mt-2 text-fg"><?php echo esc_html( $value ); ?></dd>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						</dl>

						<?php if ( $project_url ) : ?>
							<a class="btn-primary mt-8 w-full justify-center" href="<?php echo esc_url( $project_url ); ?>" target="_blank" rel="noopener noreferrer">
								<?php esc_html_e( 'Lihat proyek', 'kastalabs' ); ?>
							</a>
						<?php endif; ?>
					</aside>
				</div>
			</header>

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

			<section class="container-x py-16 md:py-24">
				<div class="grid gap-12 lg:grid-cols-[16rem_minmax(0,44rem)] lg:items-start">
					<aside class="lg:sticky lg:top-28">
						<a class="eyebrow inline-flex hover:text-primary-600" href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ?: home_url( '/portfolio/' ) ); ?>">
							<?php esc_html_e( 'Kembali ke portfolio', 'kastalabs' ); ?>
						</a>

						<?php if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) : ?>
							<div class="zoom-card zoom-card--soft mt-10 p-5">
								<p class="eyebrow"><?php esc_html_e( 'Kategori', 'kastalabs' ); ?></p>
								<div class="mt-4 flex flex-wrap gap-2">
									<?php foreach ( $categories as $category ) : ?>
										<a class="type-body-sm rounded-md border border-hairline px-3 py-1 text-muted hover:border-primary-500 hover:text-primary-600" href="<?php echo esc_url( get_term_link( $category ) ); ?>">
											<?php echo esc_html( $category->name ); ?>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( ! is_wp_error( $tags ) && ! empty( $tags ) ) : ?>
							<div class="zoom-card mt-8 p-5">
								<p class="eyebrow"><?php esc_html_e( 'Tag', 'kastalabs' ); ?></p>
								<div class="mt-4 flex flex-wrap gap-2">
									<?php foreach ( $tags as $tag ) : ?>
										<a class="type-body-sm rounded-md bg-surface px-3 py-1 text-muted hover:bg-primary-500 hover:text-white" href="<?php echo esc_url( get_term_link( $tag ) ); ?>">
											<?php echo esc_html( $tag->name ); ?>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
					</aside>

					<div class="prose">
						<?php the_content(); ?>
					</div>
				</div>
			</section>
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();
