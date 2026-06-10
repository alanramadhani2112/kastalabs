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
				<?php
				get_template_part(
					'template-parts/ui/heading',
					null,
					array(
						'eyebrow' => kasta_site_option( 'about_teaser_eyebrow', __( 'Siapa kami', 'kastalabs' ) ),
						'title'   => kasta_site_option( 'about_teaser_heading', __( 'Studio kecil yang bekerja seperti tim besar — fokus, disiplin, dan tidak berisik.', 'kastalabs' ) ),
						'class'   => '',
					)
				);
				?>
			</div>

			<div class="md:col-span-5 md:col-start-8">
				<p class="type-body text-muted mb-8" data-reveal>
					<?php esc_html_e( 'Kami percaya ukuran tidak menentukan kualitas. Dengan tim yang ramping, kami bisa bergerak cepat, menjaga komunikasi tetap langsung, dan memastikan setiap detail tidak luput. Tidak ada birokrasi. Tidak ada perantara. Hanya Anda dan orang yang mengerjakan.', 'kastalabs' ); ?>
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
				<?php
				get_template_part(
					'template-parts/ui/button',
					null,
					array(
						'label'    => __( 'Kenali kami lebih dekat', 'kastalabs' ),
						'url'      => home_url( '/about/' ),
						'variant'  => 'ghost',
						'class'    => 'mt-8',
						'magnetic' => true,
					)
				);
				?>
			</div>
		</div>
	</div>
</section>
