<?php
/**
 * Large landing page statement.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="py-24 md:py-32 bg-surface" data-statement>
	<div class="container-x">
		<div class="grid gap-10 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)] lg:items-center">
			<div data-reveal>
				<?php kasta_eyebrow( __( 'Satu sistem digital', 'kastalabs' ) ); ?>
				<h2 class="type-h2 mt-4">
					<?php esc_html_e( 'Percakapan brand tidak berhenti di logo. Ia berlanjut ke website, konten, dan cara tim bekerja.', 'kastalabs' ); ?>
				</h2>
			</div>
			<div class="grid gap-4" data-reveal data-reveal-delay="0.1">
				<div class="zoom-card bg-bg p-5">
					<p class="type-label text-primary-600"><?php esc_html_e( '01 / Direction', 'kastalabs' ); ?></p>
					<p class="type-body mt-2 text-muted"><?php esc_html_e( 'Memetakan posisi, audience, pesan utama, dan struktur komunikasi.', 'kastalabs' ); ?></p>
				</div>
				<div class="zoom-card bg-bg p-5">
					<p class="type-label text-primary-600"><?php esc_html_e( '02 / Experience', 'kastalabs' ); ?></p>
					<p class="type-body mt-2 text-muted"><?php esc_html_e( 'Mengubah arah menjadi interface, alur, dan sistem konten yang jelas.', 'kastalabs' ); ?></p>
				</div>
				<div class="zoom-card zoom-card--solid p-5">
					<p class="type-label"><?php esc_html_e( '03 / Launch', 'kastalabs' ); ?></p>
					<p class="type-body mt-2 text-white/75"><?php esc_html_e( 'Merapikan detail implementasi agar website siap digunakan dan dikembangkan.', 'kastalabs' ); ?></p>
				</div>
			</div>
		</div>
	</div>
</section>
