<?php
/**
 * Single case study template.
 *
 * @package Kastalabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

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
			<header class="container-x pt-28 pb-14 md:pt-40 md:pb-20">
				<div class="grid gap-12 lg:grid-cols-[minmax(0,1fr)_22rem] lg:items-end">
					<div class="max-w-5xl" data-reveal>
						<p class="eyebrow">
							<?php
							$eyebrow = trim( $client . ( $year ? ' / ' . $year : '' ) );
							echo esc_html( $eyebrow ?: __( 'Case Study', 'kastalabs' ) );
							?>
						</p>
						<h1 class="font-display font-extrabold text-5xl md:text-8xl lg:text-9xl tracking-tight leading-[0.9] mt-6">
							<?php the_title(); ?>
						</h1>
						<?php if ( has_excerpt() ) : ?>
							<p class="text-muted text-lg md:text-xl mt-8 max-w-3xl leading-relaxed">
								<?php echo esc_html( get_the_excerpt() ); ?>
							</p>
						<?php endif; ?>
					</div>

					<aside class="rounded-lg border border-hairline bg-bg p-6 shadow-[0_18px_40px_rgb(0_12_26_/_0.04)]" data-reveal data-reveal-delay="0.15" aria-label="<?php esc_attr_e( 'Project summary', 'kastalabs' ); ?>">
						<dl class="grid gap-5">
							<?php if ( $client ) : ?>
								<div>
									<dt class="eyebrow"><?php esc_html_e( 'Client', 'kastalabs' ); ?></dt>
									<dd class="mt-2 text-fg"><?php echo esc_html( $client ); ?></dd>
								</div>
							<?php endif; ?>
							<?php if ( $year ) : ?>
								<div>
									<dt class="eyebrow"><?php esc_html_e( 'Year', 'kastalabs' ); ?></dt>
									<dd class="mt-2 text-fg"><?php echo esc_html( $year ); ?></dd>
								</div>
							<?php endif; ?>
							<?php if ( $role ) : ?>
								<div>
									<dt class="eyebrow"><?php esc_html_e( 'Role', 'kastalabs' ); ?></dt>
									<dd class="mt-2 text-fg"><?php echo esc_html( $role ); ?></dd>
								</div>
							<?php endif; ?>
							<?php if ( $scope ) : ?>
								<div>
									<dt class="eyebrow"><?php esc_html_e( 'Scope', 'kastalabs' ); ?></dt>
									<dd class="mt-2 text-fg"><?php echo esc_html( $scope ); ?></dd>
								</div>
							<?php endif; ?>
						</dl>

						<?php if ( $project_url ) : ?>
							<a class="btn-primary mt-8 w-full justify-center" href="<?php echo esc_url( $project_url ); ?>" target="_blank" rel="noopener noreferrer" data-magnetic>
								<?php esc_html_e( 'Visit project', 'kastalabs' ); ?>
							</a>
						<?php endif; ?>
					</aside>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="container-x" data-reveal data-reveal-delay="0.1">
					<div class="overflow-hidden rounded-lg border border-hairline bg-surface">
						<?php the_post_thumbnail( 'kasta-cover', array( 'class' => 'w-full h-auto object-cover' ) ); ?>
					</div>
				</figure>
			<?php endif; ?>

			<section class="container-x py-16 md:py-24">
				<div class="grid gap-12 lg:grid-cols-[16rem_minmax(0,44rem)] lg:items-start">
					<aside class="lg:sticky lg:top-28" data-reveal>
						<a class="eyebrow inline-flex hover:text-primary-600" href="<?php echo esc_url( get_post_type_archive_link( 'work' ) ); ?>">
							<?php esc_html_e( 'Back to work', 'kastalabs' ); ?>
						</a>

						<?php if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) : ?>
							<div class="mt-10">
								<h2 class="eyebrow"><?php esc_html_e( 'Category', 'kastalabs' ); ?></h2>
								<div class="mt-4 flex flex-wrap gap-2">
									<?php foreach ( $categories as $category ) : ?>
										<a class="rounded-md border border-hairline px-3 py-1 text-sm text-muted hover:border-primary-500 hover:text-primary-600" href="<?php echo esc_url( get_term_link( $category ) ); ?>">
											<?php echo esc_html( $category->name ); ?>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( ! is_wp_error( $tags ) && ! empty( $tags ) ) : ?>
							<div class="mt-8">
								<h2 class="eyebrow"><?php esc_html_e( 'Tags', 'kastalabs' ); ?></h2>
								<div class="mt-4 flex flex-wrap gap-2">
									<?php foreach ( $tags as $tag ) : ?>
										<a class="rounded-md bg-surface px-3 py-1 text-sm text-muted hover:bg-primary-500 hover:text-white" href="<?php echo esc_url( get_term_link( $tag ) ); ?>">
											<?php echo esc_html( $tag->name ); ?>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
					</aside>

					<div class="prose" data-reveal data-reveal-delay="0.15">
						<?php the_content(); ?>
					</div>
				</div>
			</section>

			<nav class="container-x border-t border-hairline py-12" aria-label="<?php esc_attr_e( 'Adjacent case studies', 'kastalabs' ); ?>">
				<div class="grid gap-4 md:grid-cols-2">
					<div>
						<?php previous_post_link( '%link', '<span class="eyebrow">' . esc_html__( 'Previous', 'kastalabs' ) . '</span><span class="mt-2 block text-xl font-semibold">%title</span>' ); ?>
					</div>
					<div class="md:text-right">
						<?php next_post_link( '%link', '<span class="eyebrow">' . esc_html__( 'Next', 'kastalabs' ) . '</span><span class="mt-2 block text-xl font-semibold">%title</span>' ); ?>
					</div>
				</div>
			</nav>
		</article>
	<?php endwhile; ?>
</main>

<?php get_footer();
