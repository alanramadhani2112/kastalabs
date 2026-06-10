<?php
/**
 * Process section.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$steps = array(
	array(
		'title' => __( 'Listen & Learn', 'kastalabs' ),
		'body'  => __( 'Kami mulai dengan mendengarkan. Memahami bisnis Anda, audiens Anda, dan masalah yang ingin Anda selesaikan — sebelum satu pixel pun dibuat.', 'kastalabs' ),
	),
	array(
		'title' => __( 'Strategize', 'kastalabs' ),
		'body'  => __( 'Dari riset, kami susun arah yang jelas: positioning, arsitektur konten, dan keputusan desain yang punya alasan di baliknya.', 'kastalabs' ),
	),
	array(
		'title' => __( 'Design & Build', 'kastalabs' ),
		'body'  => __( 'Desain dan pengembangan berjalan paralel dengan review berkala. Tidak ada kejutan di akhir karena Anda melihat progres dari awal.', 'kastalabs' ),
	),
	array(
		'title' => __( 'Launch & Grow', 'kastalabs' ),
		'body'  => __( 'Setelah rilis, kami pastikan semuanya berjalan. Dan jika Anda butuh iterasi berikutnya, kami sudah siap.', 'kastalabs' ),
	),
);
?>

<section class="py-24 md:py-32 bg-surface" data-process>
	<div class="container-x">
		<?php
		get_template_part(
			'template-parts/ui/heading',
			null,
			array(
				'eyebrow' => __( 'Bagaimana kami bekerja', 'kastalabs' ),
				'title'   => __( 'Proses yang terstruktur, bukan formula yang kaku.', 'kastalabs' ),
			)
		);
		?>

		<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 mt-14">
			<?php foreach ( $steps as $index => $step ) : ?>
				<?php
				get_template_part(
					'template-parts/cards/process-card',
					null,
					array(
						'number'       => sprintf( '%02d', $index + 1 ),
						'title'        => $step['title'],
						'body'         => $step['body'],
						'variant'      => 'default',
						'class'        => 'bg-bg',
						'data_reveal'  => true,
						'reveal_delay' => (string) ( $index * 0.08 ),
					)
				);
				?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
