<?php
/**
 * CTA banner section.
 *
 * Full-width call-to-action with scale-in animation.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="py-24 md:py-32" data-cta-banner>
	<div class="container-x">
		<div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-primary-900 via-primary-800 to-primary-950 p-12 md:p-20 text-center">
			<!-- Decorative elements -->
			<div class="absolute top-0 right-0 w-[300px] h-[300px] rounded-full bg-primary-500/20 blur-[80px] -translate-y-1/2 translate-x-1/2" aria-hidden="true"></div>
			<div class="absolute bottom-0 left-0 w-[200px] h-[200px] rounded-full bg-primary-400/10 blur-[60px] translate-y-1/2 -translate-x-1/2" aria-hidden="true"></div>

			<div class="relative z-10">
				<?php kasta_eyebrow( __( 'Siap memulai?', 'kastalabs' ) ); ?>

				<h2 class="text-3xl md:text-5xl lg:text-6xl font-bold mt-6 max-w-3xl mx-auto leading-tight">
					<?php esc_html_e( 'Punya brand yang perlu dibuat lebih jelas?', 'kastalabs' ); ?>
				</h2>

				<p class="text-lg text-primary-100/70 mt-6 max-w-xl mx-auto">
					<?php esc_html_e( 'Ceritakan konteksnya. Kami akan bantu membaca kebutuhan, menyusun langkah pertama, dan melihat apakah KastaLabs cocok untuk proyek Anda.', 'kastalabs' ); ?>
				</p>

				<div class="mt-10 flex flex-wrap justify-center gap-4">
					<a
						href="<?php echo esc_url( home_url( '/contact' ) ); ?>"
						class="btn-primary"
						data-magnetic
						data-cursor="grow"
					>
						<?php esc_html_e( 'Diskusikan proyek', 'kastalabs' ); ?>
					</a>
					<a
						href="mailto:hello@kastalabs.com"
						class="btn-ghost border-white/20 hover:border-white/40"
						data-magnetic
						data-cursor="grow"
					>
						<?php esc_html_e( 'hello@kastalabs.com', 'kastalabs' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
