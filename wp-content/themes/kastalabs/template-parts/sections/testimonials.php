<?php
/**
 * Testimonials section.
 *
 * Placeholder section — akan diisi dengan testimonial asli saat tersedia.
 *
 * @package Kastalabs
 */

defined( 'ABSPATH' ) || exit;

$testimonials = array(
	array(
		'quote' => __( 'KastaLabs membantu kami melihat brand dengan lebih jernih. Prosesnya rapi, output-nya mudah dipakai, dan detailnya terasa dijaga.', 'kastalabs' ),
		'name'  => __( 'Client Name', 'kastalabs' ),
		'role'  => __( 'Founder', 'kastalabs' ),
	),
	array(
		'quote' => __( 'Yang paling terasa adalah cara mereka menerjemahkan kebutuhan bisnis menjadi sistem visual dan website yang praktis.', 'kastalabs' ),
		'name'  => __( 'Client Name', 'kastalabs' ),
		'role'  => __( 'Marketing Lead', 'kastalabs' ),
	),
	array(
		'quote' => __( 'Bukan hanya desain yang bagus, tetapi struktur yang membuat tim kami lebih mudah bergerak setelah proyek selesai.', 'kastalabs' ),
		'name'  => __( 'Client Name', 'kastalabs' ),
		'role'  => __( 'Product Lead', 'kastalabs' ),
	),
);
?>

<!-- optional: testimonial asli akan menggantikan placeholder di bawah -->
<section class="py-24 md:py-32 bg-surface" data-testimonials>
	<div class="container-x">
		<?php
		get_template_part(
			'template-parts/ui/heading',
			null,
			array(
				'eyebrow' => kasta_site_option( 'testimonials_eyebrow', __( 'Kata klien', 'kastalabs' ) ),
				'title'   => kasta_site_option( 'testimonials_heading', __( 'Cerita dari kolaborasi yang berjalan serius.', 'kastalabs' ) ),
			)
		);
		?>

		<div class="grid gap-8 md:grid-cols-3 mt-12">
			<?php foreach ( $testimonials as $index => $t ) : ?>
				<?php
				get_template_part(
					'template-parts/cards/testimonial-card',
					null,
					array(
						'quote'        => $t['quote'],
						'name'         => $t['name'],
						'role'         => $t['role'],
						'data_reveal'  => true,
						'reveal_delay' => (string) ( $index * 0.08 ),
					)
				);
				?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
