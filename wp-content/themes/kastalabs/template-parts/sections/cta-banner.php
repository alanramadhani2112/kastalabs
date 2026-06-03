<?php
/**
 * CTA banner section.
 *
 * Full-width call-to-action.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="py-24 md:py-32 bg-bg" data-cta-banner>
	<div class="container-x">
		<div class="relative overflow-hidden rounded-lg border border-hairline bg-navy p-10 text-center text-white md:p-16" data-cta-panel>
			<div class="relative z-10">
				<?php kasta_eyebrow( __( 'Siap memulai?', 'kastalabs' ) ); ?>

				<h2 class="text-3xl md:text-5xl lg:text-6xl font-bold mt-6 max-w-3xl mx-auto leading-tight">
					<?php esc_html_e( 'Punya brand yang perlu dibuat lebih jelas?', 'kastalabs' ); ?>
				</h2>

				<p class="text-lg text-white/70 mt-6 max-w-xl mx-auto">
					<?php esc_html_e( 'Ceritakan konteksnya. Kami akan bantu membaca kebutuhan, menyusun langkah pertama, dan melihat apakah KastaLabs cocok untuk proyek Anda.', 'kastalabs' ); ?>
				</p>

				<div class="mt-10 flex flex-wrap justify-center gap-4">
					<a
						href="<?php echo esc_url( home_url( '/contact' ) ); ?>"
						class="btn-primary"
						data-magnetic
					>
						<?php esc_html_e( 'Diskusikan proyek', 'kastalabs' ); ?>
					</a>
					<a
						href="mailto:hello@kastalabs.com"
						class="btn-ghost border-white/25 bg-white/10 text-white hover:border-white/50 hover:bg-white/15 hover:text-white"
						data-magnetic
					>
						<?php esc_html_e( 'hello@kastalabs.com', 'kastalabs' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
