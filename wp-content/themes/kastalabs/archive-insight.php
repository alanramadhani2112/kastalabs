<?php
/**
 * Insights archive template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" role="main" data-page="insights">
	<?php
	get_template_part(
		'template-parts/hero/page-hero',
		null,
		array(
			'eyebrow' => __( 'Insights', 'kastalabs' ),
			'heading' => __( 'Pemikiran, insight, dan sudut pandang digital.', 'kastalabs' ),
			'body'    => __( 'Eksplorasi tentang desain, teknologi, strategi digital, dan proses kreatif di balik Kastalabs.', 'kastalabs' ),
		)
	);
	?>

	<?php if ( have_posts() ) : ?>
		<section class="container-x py-24 md:py-32">
			<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
				<?php
				$index = 0;
				while ( have_posts() ) :
					the_post();
					get_template_part(
						'template-parts/cards/insight-card',
						null,
						array(
							'data_reveal'  => true,
							'reveal_delay' => (string) ( $index * 0.06 ),
						)
					);
					$index++;
				endwhile;
				?>
			</div>

			<?php the_posts_pagination( array( 'class' => 'pagination mt-16' ) ); ?>
		</section>
	<?php else : ?>
		<section class="container-x py-24 md:py-32">
			<div class="zoom-card zoom-card--soft p-8 md:p-12 text-center" data-reveal>
				<h2 class="type-h3"><?php esc_html_e( 'Insight sedang disiapkan.', 'kastalabs' ); ?></h2>
				<p class="type-body text-muted mt-4 max-w-lg mx-auto">
					<?php esc_html_e( 'Artikel pertama akan muncul setelah editorial awal selesai. Sementara itu, kunjungi portfolio atau hubungi kami untuk diskusi project.', 'kastalabs' ); ?>
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
