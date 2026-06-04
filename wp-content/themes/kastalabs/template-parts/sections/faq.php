<?php
/**
 * FAQ section.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$faqs = array(
	array(
		'q' => __( 'Kastalabs cocok untuk proyek seperti apa?', 'kastalabs' ),
		'a' => __( 'Kami cocok untuk brand yang membutuhkan identitas visual, website, struktur konten, atau pengalaman digital yang lebih jelas dan siap dieksekusi.', 'kastalabs' ),
	),
	array(
		'q' => __( 'Apakah bisa hanya membuat website tanpa branding?', 'kastalabs' ),
		'a' => __( 'Bisa. Namun kami tetap akan membaca dasar brand, pesan, dan struktur konten agar websitenya tidak sekadar menjadi halaman yang rapi.', 'kastalabs' ),
	),
	array(
		'q' => __( 'Apakah desain dan development dikerjakan dalam satu paket?', 'kastalabs' ),
		'a' => __( 'Bisa. Untuk WordPress custom, kami dapat menangani desain interface, slicing theme, struktur konten, dan optimasi dasar.', 'kastalabs' ),
	),
	array(
		'q' => __( 'Berapa lama durasi proyek?', 'kastalabs' ),
		'a' => __( 'Tergantung scope. Website kecil biasanya 3-5 minggu. Identitas brand dan website lengkap bisa 6-10 minggu.', 'kastalabs' ),
	),
);
?>

<section class="py-24 md:py-32 bg-surface/55" data-faq>
	<div class="container-x">
		<div class="grid gap-10 lg:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)]">
			<div data-reveal>
				<?php kasta_eyebrow( __( 'FAQ', 'kastalabs' ) ); ?>
				<h2 class="type-h2 mt-4">
					<?php esc_html_e( 'Pertanyaan yang sering muncul.', 'kastalabs' ); ?>
				</h2>
			</div>

			<div class="grid gap-3" data-reveal data-reveal-delay="0.1">
				<?php foreach ( $faqs as $index => $faq ) : ?>
					<details class="group rounded-lg border border-hairline bg-bg p-5" <?php echo 0 === $index ? 'open' : ''; ?>>
						<summary class="type-h4 cursor-pointer list-none marker:hidden">
							<?php echo esc_html( $faq['q'] ); ?>
						</summary>
						<p class="type-body mt-4 text-muted">
							<?php echo esc_html( $faq['a'] ); ?>
						</p>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
