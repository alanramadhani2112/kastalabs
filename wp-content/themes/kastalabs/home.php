<?php
/**
 * Blog index template.
 *
 * @package Kastalabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" role="main" data-page="blog">
	<header class="zoom-page-hero py-24 md:py-32">
		<div class="container-x">
			<div class="zoom-page-hero__content" data-reveal>
				<p class="eyebrow"><?php esc_html_e( 'Journal', 'kastalabs' ); ?></p>
				<h1 class="type-display-lg mt-6">
					<?php esc_html_e( 'Tulisan tentang brand, web, dan eksekusi kreatif.', 'kastalabs' ); ?>
				</h1>
				<p class="type-body-lg measure-copy text-muted mt-8">
					<?php esc_html_e( 'Catatan dari proses kami: keputusan desain, struktur konten, WordPress, motion, SEO, dan cara membuat brand terasa lebih jelas.', 'kastalabs' ); ?>
				</p>
			</div>
		</div>
	</header>

	<?php if ( have_posts() ) : ?>
		<section class="container-x py-24 md:py-32">
			<div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
				<?php
				$index = 0;
				while ( have_posts() ) :
					the_post();
					?>
					<article class="zoom-card overflow-hidden" data-reveal data-reveal-delay="<?php echo esc_attr( (string) ( $index * 0.06 ) ); ?>">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php echo esc_url( get_permalink() ); ?>" class="block aspect-[4/3] overflow-hidden bg-surface">
								<?php the_post_thumbnail( 'kasta-thumb', array( 'class' => 'w-full h-full object-cover transition-transform duration-700 hover:scale-105' ) ); ?>
							</a>
						<?php endif; ?>
						<div class="p-6">
							<p class="eyebrow">
								<?php echo esc_html( get_the_date() ); ?>
								<span aria-hidden="true"> · </span>
								<?php echo esc_html( kasta_reading_time() ); ?> <?php esc_html_e( 'menit baca', 'kastalabs' ); ?>
							</p>
							<h2 class="type-h4 mt-2">
								<a href="<?php echo esc_url( get_permalink() ); ?>" class="hover:text-primary-600 transition-colors">
									<?php the_title(); ?>
								</a>
							</h2>
							<?php if ( has_excerpt() ) : ?>
								<p class="type-body-sm text-muted mt-3 line-clamp-2">
									<?php echo esc_html( get_the_excerpt() ); ?>
								</p>
							<?php endif; ?>
						</div>
					</article>
					<?php
					$index++;
				endwhile;
				?>
			</div>

			<?php the_posts_pagination( array( 'class' => 'pagination mt-16' ) ); ?>
		</section>
	<?php else : ?>
		<section class="container-x py-24 md:py-32">
			<div class="zoom-card zoom-card--soft p-8 md:p-12 text-center" data-reveal>
				<h2 class="type-h3"><?php esc_html_e( 'Belum ada tulisan.', 'kastalabs' ); ?></h2>
				<p class="type-body text-muted mt-4">
					<?php esc_html_e( 'Artikel pertama sedang disiapkan. Kunjungi portfolio atau hubungi kami untuk diskusi project.', 'kastalabs' ); ?>
				</p>
				<div class="mt-8 flex flex-wrap justify-center gap-4">
					<?php
					get_template_part(
						'template-parts/ui/button',
						null,
						array(
							'label'   => __( 'Lihat portfolio', 'kastalabs' ),
							'url'     => get_post_type_archive_link( 'portfolio' ) ?: home_url( '/portfolio/' ),
							'variant' => 'primary',
						)
					);
					get_template_part(
						'template-parts/ui/button',
						null,
						array(
							'label'   => __( 'Mulai percakapan', 'kastalabs' ),
							'url'     => home_url( '/contact/' ),
							'variant' => 'ghost',
						)
					);
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>
</main>

<?php get_footer();
