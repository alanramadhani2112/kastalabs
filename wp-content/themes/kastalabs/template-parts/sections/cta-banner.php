<?php
/**
 * CTA banner section.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$contact_email = kasta_contact_email();
?>

<section class="py-28 md:py-36 bg-bg" data-cta-banner>
	<div class="container-x">
		<div class="zoom-card relative overflow-hidden bg-navy p-10 text-center text-white md:p-16" data-cta-panel>
			<div class="relative z-10">
				<?php
				get_template_part(
					'template-parts/ui/heading',
					null,
					array(
						'eyebrow' => kasta_site_option( 'cta_eyebrow', __( 'Siap bergerak lebih tajam?', 'kastalabs' ) ),
						'title'   => kasta_site_option( 'cta_heading', __( 'Mulai dengan percakapan.', 'kastalabs' ) ),
						'body'    => kasta_site_option( 'cta_body', __( 'Ceritakan proyek Anda — kami dengarkan, lalu kami beri pandangan jujur tentang apa yang bisa dilakukan.', 'kastalabs' ) ),
						'class'   => 'zoom-section-heading !text-white',
					)
				);
				?>

				<div class="mt-10 flex flex-wrap justify-center gap-4">
					<?php
					get_template_part(
						'template-parts/ui/button',
						null,
						array(
							'label'    => kasta_site_option( 'cta_primary_label', __( 'Mulai percakapan', 'kastalabs' ) ),
							'url'      => kasta_site_url_option( 'cta_primary_url', '/contact/' ),
							'variant'  => 'primary',
							'magnetic' => true,
						)
					);
					get_template_part(
						'template-parts/ui/button',
						null,
						array(
							'label'    => antispambot( $contact_email ),
							'url'      => 'mailto:' . $contact_email,
							'variant'  => 'ghost',
							'class'    => 'border-white/25 bg-white/10 text-white hover:border-white/50 hover:bg-white/15 hover:text-white',
							'magnetic' => true,
						)
					);
					?>
				</div>
			</div>
		</div>
	</div>
</section>
