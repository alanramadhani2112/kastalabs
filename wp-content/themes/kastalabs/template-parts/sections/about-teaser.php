<?php
/**
 * About teaser section.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="py-24 md:py-32 bg-bg" data-about-teaser>
	<div class="container-x">
		<div class="zoom-card zoom-card--soft grid gap-12 p-8 md:grid-cols-12 md:items-center md:p-12">
			<div class="md:col-span-7">
				<?php kasta_eyebrow( __( 'Tentang Kastalabs', 'kastalabs' ) ); ?>
				<h2
					class="type-h2 mt-6"
					data-about-heading
				>
					<?php esc_html_e( 'Studio kecil dengan perhatian besar pada detail.', 'kastalabs' ); ?>
				</h2>
			</div>

			<div class="md:col-span-5 md:col-start-8">
				<p class="type-body text-muted mb-8" data-reveal>
					<?php esc_html_e( 'Kami percaya brand yang kuat lahir dari keputusan kecil yang konsisten: kata yang dipilih, grid yang dijaga, interaksi yang terasa pas, dan sistem yang membuat tim bisa bergerak lebih cepat.', 'kastalabs' ); ?>
				</p>
				<div class="grid grid-cols-3 gap-4" data-reveal data-reveal-delay="0.1">
					<div class="border-l border-primary-500/25 pl-4">
						<span class="type-h2 text-primary-600" data-counter="50" data-counter-suffix="+">0</span>
						<span class="type-body-sm block text-muted mt-1"><?php esc_html_e( 'Proyek selesai', 'kastalabs' ); ?></span>
					</div>
					<div class="border-l border-primary-500/25 pl-4">
						<span class="type-h2 text-primary-600" data-counter="5" data-counter-suffix="+">0</span>
						<span class="type-body-sm block text-muted mt-1"><?php esc_html_e( 'Tahun pengalaman', 'kastalabs' ); ?></span>
					</div>
					<div class="border-l border-primary-500/25 pl-4">
						<span class="type-h2 text-primary-600" data-counter="30" data-counter-suffix="+">0</span>
						<span class="type-body-sm block text-muted mt-1"><?php esc_html_e( 'Klien puas', 'kastalabs' ); ?></span>
					</div>
				</div>
				<a
					href="<?php echo esc_url( home_url( '/about' ) ); ?>"
					class="btn-ghost mt-8 inline-flex"
					data-magnetic
					data-reveal
					data-reveal-delay="0.2"
				>
					<?php esc_html_e( 'Kenali Kastalabs', 'kastalabs' ); ?>
				</a>
			</div>
		</div>
	</div>
</section>
