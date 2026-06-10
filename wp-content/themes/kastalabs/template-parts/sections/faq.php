<?php
/**
 * FAQ section.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$faqs = array(
	array(
		'q' => __( 'Berapa lama pengerjaan satu project?', 'kastalabs' ),
		'a' => __( 'Tergantung cakupan. Website company profile biasanya 3–6 minggu, branding identity 4–8 minggu, software custom bisa 8–16 minggu. Kami akan beri estimasi detail setelah mendengar kebutuhan Anda.', 'kastalabs' ),
	),
	array(
		'q' => __( 'Apakah Kastalabs menerima project jarak jauh?', 'kastalabs' ),
		'a' => __( 'Ya. Sebagian besar klien kami bekerja secara remote. Kami menggunakan alat kolaborasi standar (Figma, Notion, Slack/Discord, Loom) dan jadwal check-in rutin.', 'kastalabs' ),
	),
	array(
		'q' => __( 'Apakah bisa revisi?', 'kastalabs' ),
		'a' => __( 'Setiap paket sudah termasuk sesi revisi yang disepakati di awal. Kami mendorong feedback terstruktur agar proses tetap efisien.', 'kastalabs' ),
	),
	array(
		'q' => __( 'Apakah ada garansi setelah project selesai?', 'kastalabs' ),
		'a' => __( 'Kami berikan masa dukungan pasca-rilis (biasanya 2–4 minggu) untuk bug fixing dan penyesuaian minor. Untuk maintenance jangka panjang, kami sediakan opsi retainer.', 'kastalabs' ),
	),
);
?>

<section class="py-24 md:py-32 bg-bg" data-faq>
	<div class="container-x">
		<div class="mx-auto max-w-4xl">
			<?php
			get_template_part(
				'template-parts/ui/heading',
				null,
				array(
					'eyebrow' => __( 'FAQ', 'kastalabs' ),
					'title'   => __( 'Hal yang sering ditanyakan.', 'kastalabs' ),
				)
			);
			?>

			<div class="grid gap-0 divide-y divide-hairline mt-10" data-reveal data-reveal-delay="0.1">
				<?php foreach ( $faqs as $index => $faq ) : ?>
					<?php
					get_template_part(
						'template-parts/ui/faq-item',
						null,
						array(
							'question' => $faq['q'],
							'answer'   => $faq['a'],
							'open'     => false,
							'index'    => $index,
						)
					);
					?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
