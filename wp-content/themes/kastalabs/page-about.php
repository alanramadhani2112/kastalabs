<?php
/**
 * About page template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" role="main" data-page="about">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		get_template_part(
			'template-parts/hero/page-hero',
			null,
			array(
				'eyebrow' => __( 'About Kastalabs', 'kastalabs' ),
				'heading' => __( 'Studio kecil untuk brand yang ingin bergerak lebih tajam.', 'kastalabs' ),
				'body'    => __( 'Kami percaya ukuran tidak menentukan kualitas. Dengan tim yang ramping, kami bisa bergerak cepat, menjaga komunikasi tetap langsung, dan memastikan setiap detail tidak luput.', 'kastalabs' ),
				'pills'   => array(
					__( 'Strategi dulu', 'kastalabs' ),
					__( 'Sistem visual', 'kastalabs' ),
					__( 'Siap diluncurkan', 'kastalabs' ),
				),
			)
		);
		?>

		<section class="container-x py-16">
			<div class="grid gap-10 md:grid-cols-[1fr_1.4fr] md:items-start">
				<div>
					<?php kasta_eyebrow( __( 'Posisi kami', 'kastalabs' ) ); ?>
				</div>
				<div class="prose">
					<?php if ( trim( get_the_content() ) ) : ?>
						<?php the_content(); ?>
					<?php else : ?>
						<p><?php esc_html_e( 'Kastalabs dibangun untuk kerja yang fokus. Kami memilih tetap ramping supaya bisa dekat dengan konteks klien, menjaga kualitas, dan bergerak tanpa birokrasi yang tidak perlu.', 'kastalabs' ); ?></p>
						<p><?php esc_html_e( 'Kami tidak mencoba menjadi semua untuk semua orang. Setiap project kami dekati dengan perhatian penuh — dari strategi, desain, sampai eksekusi — karena hanya dengan cara itu hasil yang tajam bisa lahir.', 'kastalabs' ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<section class="container-x py-20 md:py-28">
			<?php
			get_template_part(
				'template-parts/ui/heading',
				null,
				array(
					'eyebrow' => __( 'Prinsip kami', 'kastalabs' ),
					'title'   => __( 'Tiga hal yang kami jaga di setiap project.', 'kastalabs' ),
				)
			);
			?>
			<div class="grid gap-8 md:grid-cols-3 mt-10">
				<?php
				$values = array(
					array(
						'title' => __( 'Strategic first', 'kastalabs' ),
						'body'  => __( 'Kami mulai dari posisi, audiens, dan keputusan yang perlu dibuat sebelum bentuk visual dipilih. Desain yang indah tanpa strategi hanya dekorasi.', 'kastalabs' ),
					),
					array(
						'title' => __( 'Craft that holds', 'kastalabs' ),
						'body'  => __( 'Detail tipografi, layout, gerak, dan sistem komponen dijaga supaya brand terasa konsisten — bukan hanya saat pertama dilihat, tapi saat dipakai bertahun-tahun.', 'kastalabs' ),
					),
					array(
						'title' => __( 'Built to ship', 'kastalabs' ),
						'body'  => __( 'Desain tidak berhenti di mockup. Kami memikirkan implementasi, performa, SEO, dan cara tim Anda mengelola konten setelah kami selesai.', 'kastalabs' ),
					),
				);
				foreach ( $values as $index => $value ) :
					get_template_part(
						'template-parts/cards/process-card',
						null,
						array(
							'number'       => sprintf( '%02d', $index + 1 ),
							'title'        => $value['title'],
							'body'         => $value['body'],
							'variant'      => 'soft',
							'padding'      => 'p-6',
						)
					);
				endforeach;
				?>
			</div>
		</section>

		<section class="container-x pb-20 md:pb-28">
			<div class="grid gap-10 md:grid-cols-[1fr_1.4fr]">
				<?php
				get_template_part(
					'template-parts/ui/heading',
					null,
					array(
						'eyebrow' => __( 'Yang membedakan', 'kastalabs' ),
						'title'   => __( 'Tidak ada template. Tidak ada resep ajaib. Yang ada: mendengarkan dengan serius.', 'kastalabs' ),
					)
				);
				?>
				<div class="grid gap-4">
					<?php
					$differentiators = array(
						array(
							'title' => __( 'Tim langsung yang mengerjakan', 'kastalabs' ),
							'body'  => __( 'Anda bicara dengan orang yang mendesain dan menulis kode, bukan perantara.', 'kastalabs' ),
						),
						array(
							'title' => __( 'Dokumentasi yang kami seriusi', 'kastalabs' ),
							'body'  => __( 'Setiap project kami bekali dengan panduan brand, dokumentasi teknis, atau sistem yang bisa tim Anda gunakan mandiri.', 'kastalabs' ),
						),
						array(
							'title' => __( 'Kejujuran di awal', 'kastalabs' ),
							'body'  => __( 'Jika ada permintaan yang kami rasa tidak tepat, kami sampaikan — beserta alasannya.', 'kastalabs' ),
						),
					);
					foreach ( $differentiators as $item ) :
						get_template_part(
							'template-parts/ui/card',
							null,
							array(
								'title'   => $item['title'],
								'body'    => $item['body'],
								'variant' => 'soft',
								'padding' => 'p-5',
							)
						);
					endforeach;
					?>
				</div>
			</div>
		</section>
	<?php endwhile; ?>

	<?php get_template_part( 'template-parts/sections/cta-banner' ); ?>
</main>

<?php get_footer();
