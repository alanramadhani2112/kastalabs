<?php
/**
 * CTA banner section.
 *
 * Full-width call-to-action.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$cta_eyebrow       = kasta_site_option( 'cta_eyebrow', __( 'Siap memulai?', 'kastalabs' ) );
$cta_heading       = kasta_site_option( 'cta_heading', __( 'Punya brand yang perlu dibuat lebih jelas?', 'kastalabs' ) );
$cta_body          = kasta_site_option( 'cta_body', __( 'Ceritakan konteksnya. Kami akan bantu membaca kebutuhan, menyusun langkah pertama, dan melihat apakah Kastalabs cocok untuk proyek Anda.', 'kastalabs' ) );
$cta_primary_label = kasta_site_option( 'cta_primary_label', __( 'Diskusikan proyek', 'kastalabs' ) );
$cta_primary_url   = kasta_site_url_option( 'cta_primary_url', '/contact/' );
$contact_email     = kasta_contact_email();
?>

<section class="py-24 md:py-32 bg-bg" data-cta-banner>
	<div class="container-x">
		<div class="relative overflow-hidden rounded-lg border border-hairline bg-navy p-10 text-center text-white md:p-16" data-cta-panel>
			<div class="relative z-10">
				<?php kasta_eyebrow( $cta_eyebrow ); ?>

				<h2 class="type-h2 mt-6 max-w-3xl mx-auto">
					<?php echo esc_html( $cta_heading ); ?>
				</h2>

				<p class="type-body-lg text-white/70 mt-6 max-w-xl mx-auto">
					<?php echo esc_html( $cta_body ); ?>
				</p>

				<div class="mt-10 flex flex-wrap justify-center gap-4">
					<a
						href="<?php echo esc_url( $cta_primary_url ); ?>"
						class="btn-primary"
						data-magnetic
					>
						<?php echo esc_html( $cta_primary_label ); ?>
					</a>
					<a
						href="<?php echo esc_url( 'mailto:' . $contact_email ); ?>"
						class="btn-ghost border-white/25 bg-white/10 text-white hover:border-white/50 hover:bg-white/15 hover:text-white"
						data-magnetic
					>
						<?php echo esc_html( antispambot( $contact_email ) ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
