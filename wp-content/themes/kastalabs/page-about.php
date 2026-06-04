<?php
/**
 * About page template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" role="main" data-page="about">
	<?php while ( have_posts() ) : the_post(); ?>
		<section class="zoom-page-hero py-24 md:py-32">
			<div class="container-x">
			<div class="zoom-page-hero__content" data-reveal>
				<?php kasta_eyebrow( __( 'About Kastalabs', 'kastalabs' ) ); ?>
				<h1 class="type-display-lg mt-6">
					<?php esc_html_e( 'Studio kecil untuk brand yang ingin bergerak lebih tajam.', 'kastalabs' ); ?>
				</h1>
			</div>
			<div class="zoom-page-hero__meta mt-10" data-reveal data-reveal-delay="0.1">
				<span class="zoom-meta-pill type-label"><?php esc_html_e( 'Strategy first', 'kastalabs' ); ?></span>
				<span class="zoom-meta-pill type-label"><?php esc_html_e( 'Visual systems', 'kastalabs' ); ?></span>
				<span class="zoom-meta-pill type-label"><?php esc_html_e( 'Built to ship', 'kastalabs' ); ?></span>
			</div>
			</div>
		</section>

		<section class="container-x py-16">
			<div class="grid gap-10 md:grid-cols-[1fr_1.4fr] md:items-start">
				<div data-reveal>
					<p class="eyebrow"><?php esc_html_e( 'Our posture', 'kastalabs' ); ?></p>
				</div>
				<div class="prose" data-reveal data-reveal-delay="0.1">
					<?php if ( trim( get_the_content() ) ) : ?>
						<?php the_content(); ?>
					<?php else : ?>
						<p><?php esc_html_e( 'Kastalabs membantu bisnis menyusun ekspresi brand, sistem visual, dan pengalaman digital yang bisa dipakai sehari-hari. Kami memilih kerja yang dekat, teliti, dan cukup berani untuk meninggalkan kesan.', 'kastalabs' ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<section class="container-x py-20 md:py-28">
			<div class="grid gap-8 md:grid-cols-3">
				<?php
				$values = array(
					array(
						'title' => __( 'Strategic first', 'kastalabs' ),
						'body'  => __( 'Kami mulai dari posisi, audiens, dan keputusan yang perlu dibuat sebelum bentuk visual dipilih.', 'kastalabs' ),
					),
					array(
						'title' => __( 'Craft that holds', 'kastalabs' ),
						'body'  => __( 'Detail tipografi, layout, gerak, dan sistem komponen dijaga supaya brand terasa konsisten.', 'kastalabs' ),
					),
					array(
						'title' => __( 'Built to ship', 'kastalabs' ),
						'body'  => __( 'Desain tidak berhenti di mockup. Kami memikirkan implementasi, performa, SEO, dan cara tim mengelola konten.', 'kastalabs' ),
					),
				);
				foreach ( $values as $index => $value ) :
					?>
					<article class="zoom-card zoom-card--soft p-6" data-reveal data-reveal-delay="<?php echo esc_attr( (string) ( $index * 0.08 ) ); ?>">
						<p class="type-label text-primary-600"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></p>
						<h2 class="type-h4 mt-8"><?php echo esc_html( $value['title'] ); ?></h2>
						<p class="type-body mt-4 text-muted"><?php echo esc_html( $value['body'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="container-x pb-20 md:pb-28">
			<div class="grid gap-10 md:grid-cols-[1fr_1.4fr]">
				<div data-reveal>
					<?php kasta_eyebrow( __( 'Capabilities', 'kastalabs' ) ); ?>
				</div>
				<div class="grid gap-4 sm:grid-cols-2" data-reveal data-reveal-delay="0.1">
					<?php
					$capabilities = array(
						__( 'Brand strategy', 'kastalabs' ),
						__( 'Identity system', 'kastalabs' ),
						__( 'Website design', 'kastalabs' ),
						__( 'WordPress development', 'kastalabs' ),
						__( 'Motion direction', 'kastalabs' ),
						__( 'Content structure', 'kastalabs' ),
					);
					foreach ( $capabilities as $capability ) :
						?>
						<p class="zoom-card bg-bg p-5 type-h4"><?php echo esc_html( $capability ); ?></p>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endwhile; ?>

	<?php get_template_part( 'template-parts/sections/cta-banner' ); ?>
</main>

<?php get_footer();
