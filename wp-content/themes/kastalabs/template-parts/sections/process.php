<?php
/**
 * Process section.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$steps = array(
	array(
		'title' => __( 'Discover', 'kastalabs' ),
		'body'  => __( 'Kami membaca konteks, tujuan bisnis, audiens, dan batasan proyek. Output awalnya adalah arah yang jelas.', 'kastalabs' ),
	),
	array(
		'title' => __( 'Design', 'kastalabs' ),
		'body'  => __( 'Kami menerjemahkan arah menjadi identitas, layout, komponen, dan pengalaman yang bisa diuji.', 'kastalabs' ),
	),
	array(
		'title' => __( 'Ship', 'kastalabs' ),
		'body'  => __( 'Kami merapikan implementasi, konten, performa, dan detail akhir sampai siap digunakan.', 'kastalabs' ),
	),
);
?>

<section class="py-24 md:py-32 bg-bg" data-process>
	<div class="container-x">
		<div class="mb-14 max-w-3xl" data-reveal>
			<?php kasta_eyebrow( __( 'Proses', 'kastalabs' ) ); ?>
			<h2 class="type-h2 mt-4">
				<?php esc_html_e( 'Tiga langkah agar ide tidak berhenti sebagai ide.', 'kastalabs' ); ?>
			</h2>
		</div>

		<div class="grid gap-6 lg:grid-cols-3">
			<?php foreach ( $steps as $index => $step ) : ?>
				<article class="rounded-lg border border-hairline bg-bg p-7 shadow-[0_18px_40px_rgb(0_12_26_/_0.04)]" data-reveal data-reveal-delay="<?php echo esc_attr( (string) ( $index * 0.08 ) ); ?>">
					<p class="type-label text-primary-600"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></p>
					<h3 class="type-h4 mt-10"><?php echo esc_html( $step['title'] ); ?></h3>
					<p class="type-body mt-4 text-muted"><?php echo esc_html( $step['body'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
