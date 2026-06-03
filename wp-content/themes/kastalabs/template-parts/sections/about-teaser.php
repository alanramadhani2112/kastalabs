<?php
/**
 * About teaser section.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="py-24 md:py-36 border-y border-hairline bg-bg" data-about-teaser>
	<div class="container-x">
		<div class="grid gap-12 md:grid-cols-12 items-center">
			<div class="md:col-span-7">
				<?php kasta_eyebrow( __( 'Tentang KastaLabs', 'kastalabs' ) ); ?>
				<h2
					class="text-3xl md:text-4xl lg:text-5xl font-bold leading-snug mt-6"
					data-about-heading
				>
					<?php esc_html_e( 'Studio kecil dengan perhatian besar pada detail.', 'kastalabs' ); ?>
				</h2>
			</div>

			<div class="md:col-span-5 md:col-start-8">
				<p class="text-muted leading-relaxed mb-8" data-reveal>
					<?php esc_html_e( 'Kami percaya brand yang kuat lahir dari keputusan kecil yang konsisten: kata yang dipilih, grid yang dijaga, interaksi yang terasa pas, dan sistem yang membuat tim bisa bergerak lebih cepat.', 'kastalabs' ); ?>
				</p>
				<div class="grid grid-cols-3 gap-4" data-reveal data-reveal-delay="0.1">
					<div>
						<span class="text-3xl md:text-4xl font-bold text-primary-600" data-counter="50" data-counter-suffix="+">0</span>
						<span class="block text-sm text-muted mt-1"><?php esc_html_e( 'Proyek selesai', 'kastalabs' ); ?></span>
					</div>
					<div>
						<span class="text-3xl md:text-4xl font-bold text-primary-600" data-counter="5" data-counter-suffix="+">0</span>
						<span class="block text-sm text-muted mt-1"><?php esc_html_e( 'Tahun pengalaman', 'kastalabs' ); ?></span>
					</div>
					<div>
						<span class="text-3xl md:text-4xl font-bold text-primary-600" data-counter="30" data-counter-suffix="+">0</span>
						<span class="block text-sm text-muted mt-1"><?php esc_html_e( 'Klien puas', 'kastalabs' ); ?></span>
					</div>
				</div>
				<a
					href="<?php echo esc_url( home_url( '/about' ) ); ?>"
					class="btn-ghost text-sm mt-8 inline-flex"
					data-magnetic
					data-reveal
					data-reveal-delay="0.2"
				>
					<?php esc_html_e( 'Kenali KastaLabs', 'kastalabs' ); ?>
				</a>
			</div>
		</div>
	</div>
</section>
