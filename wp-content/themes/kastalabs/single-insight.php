<?php
/**
 * Single insight template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" role="main" data-page="insight-single">
	<div class="reading-progress" data-reading-progress aria-hidden="true"></div>

	<?php while ( have_posts() ) : the_post(); ?>
		<article data-reading-article>
			<header class="zoom-page-hero py-28 md:py-36">
				<div class="container-x">
				<?php get_template_part( 'template-parts/ui/breadcrumb' ); ?>
				<div class="zoom-page-hero__content max-w-4xl mt-10">
					<p class="eyebrow">
						<?php echo esc_html( get_the_date() ); ?> / <?php echo esc_html( kasta_reading_time() ); ?> <?php esc_html_e( 'menit baca', 'kastalabs' ); ?>
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
				<div class="grid gap-12 lg:grid-cols-[16rem_minmax(0,44rem)]">
					<aside class="lg:sticky lg:top-28 self-start">
						<a class="eyebrow inline-flex hover:text-primary-600" href="<?php echo esc_url( get_post_type_archive_link( 'insight' ) ); ?>">
							<?php esc_html_e( 'Kembali ke insights', 'kastalabs' ); ?>
						</a>

						<div class="mt-10 space-y-6">
							<?php
							get_template_part(
								'template-parts/post/post-author',
								null,
								array( 'variant' => 'compact' )
							);
							?>

							<?php
							get_template_part(
								'template-parts/post/post-share',
								null,
								array(
									'platforms' => array( 'twitter', 'linkedin', 'whatsapp', 'telegram' ),
								)
							);
							?>
						</div>
					</aside>

					<div class="prose">
						<?php the_content(); ?>
					</div>
				</div>

				<div class="grid gap-12 lg:grid-cols-[16rem_minmax(0,44rem)] mt-12">
					<div></div>
					<div>
						<?php
						get_template_part(
							'template-parts/post/post-tags',
							null,
							array( 'taxonomy' => 'insight_tag' )
						);
						?>
					</div>
				</div>
			</section>

			<?php
			$related = new WP_Query(
				array(
					'post_type'      => 'insight',
					'posts_per_page' => 3,
					'post__not_in'   => array( get_the_ID() ),
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			);
			if ( $related->have_posts() ) :
				?>
				<section class="container-x py-12 md:py-20">
					<h2 class="type-h3 text-center"><?php esc_html_e( 'Insight lainnya', 'kastalabs' ); ?></h2>
					<div class="mt-10 grid gap-6 md:grid-cols-3">
						<?php
						while ( $related->have_posts() ) :
							$related->the_post();
							get_template_part( 'template-parts/cards/insight-card' );
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</section>
			<?php endif; ?>
		</article>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
