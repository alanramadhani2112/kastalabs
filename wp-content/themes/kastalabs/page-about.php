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
		<section class="container-x pt-28 pb-16 md:pt-40 md:pb-24">
			<div class="max-w-5xl" data-reveal>
				<?php kasta_eyebrow( __( 'About KastaLabs', 'kastalabs' ) ); ?>
				<h1 class="font-display font-extrabold text-5xl md:text-8xl lg:text-9xl tracking-tight leading-[0.9] mt-6">
					<?php esc_html_e( 'Studio kecil untuk brand yang ingin bergerak lebih tajam.', 'kastalabs' ); ?>
				</h1>
			</div>
		</section>

		<section class="container-x py-16 border-y border-hairline">
			<div class="grid gap-10 md:grid-cols-[1fr_1.4fr] md:items-start">
				<div data-reveal>
					<p class="eyebrow"><?php esc_html_e( 'Our posture', 'kastalabs' ); ?></p>
				</div>
				<div class="prose" data-reveal data-reveal-delay="0.1">
					<?php if ( trim( get_the_content() ) ) : ?>
						<?php the_content(); ?>
					<?php else : ?>
						<p><?php esc_html_e( 'KastaLabs membantu bisnis menyusun ekspresi brand, sistem visual, dan pengalaman digital yang bisa dipakai sehari-hari. Kami memilih kerja yang dekat, teliti, dan cukup berani untuk meninggalkan kesan.', 'kastalabs' ); ?></p>
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
					<article class="rounded-lg border border-hairline bg-bg p-6 shadow-[0_18px_40px_rgb(0_12_26_/_0.04)]" data-reveal data-reveal-delay="<?php echo esc_attr( (string) ( $index * 0.08 ) ); ?>">
						<p class="font-mono text-sm text-primary-600"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></p>
						<h2 class="mt-8 text-2xl font-bold leading-tight"><?php echo esc_html( $value['title'] ); ?></h2>
						<p class="mt-4 text-muted leading-relaxed"><?php echo esc_html( $value['body'] ); ?></p>
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
						<p class="border-b border-hairline py-4 text-xl font-semibold"><?php echo esc_html( $capability ); ?></p>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endwhile; ?>

	<?php get_template_part( 'template-parts/sections/cta-banner' ); ?>
</main>

<?php get_footer();
