<?php
/**
 * Single insight template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" role="main" data-page="blog-single">
	<div class="reading-progress" data-reading-progress aria-hidden="true"></div>

	<?php while ( have_posts() ) : the_post(); ?>
		<article data-reading-article>
			<header class="zoom-page-hero py-24 md:py-32">
				<div class="container-x">
				<div class="zoom-page-hero__content max-w-4xl" data-reveal>
					<p class="eyebrow">
						<?php echo esc_html( get_the_date() ); ?> / <?php echo esc_html( kasta_reading_time() ); ?> <?php esc_html_e( 'menit baca', 'kastalabs' ); ?>
					</p>
					<h1 class="type-h1 mt-6">
						<?php the_title(); ?>
					</h1>
					<?php if ( has_excerpt() ) : ?>
						<p class="type-body-lg measure-copy text-muted mt-8">
							<?php echo esc_html( get_the_excerpt() ); ?>
						</p>
					<?php endif; ?>
				</div>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="container-x" data-reveal data-reveal-delay="0.1">
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
				<div class="grid gap-12 lg:grid-cols-[16rem_minmax(0,44rem)]">
					<aside class="lg:sticky lg:top-28 self-start" data-reveal>
						<a class="eyebrow inline-flex hover:text-primary-600" href="<?php echo esc_url( get_post_type_archive_link( 'insight' ) ); ?>">
							<?php esc_html_e( 'Back to insights', 'kastalabs' ); ?>
						</a>
					</aside>

					<div class="prose" data-reveal data-reveal-delay="0.15">
						<?php the_content(); ?>
					</div>
				</div>
			</section>
		</article>
	<?php endwhile; ?>
</main>

<?php get_footer();
