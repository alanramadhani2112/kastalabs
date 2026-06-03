<?php
/**
 * Testimonials section.
 *
 * @package KastaLabs
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

<section class="py-24 md:py-32" data-testimonials>
	<div class="container-x">
		<div class="mb-14 max-w-3xl" data-reveal>
			<?php kasta_eyebrow( __( 'Kata klien', 'kastalabs' ) ); ?>
			<h2 class="mt-4 text-3xl md:text-5xl font-bold leading-tight">
				<?php esc_html_e( 'Cerita dari kolaborasi yang berjalan serius.', 'kastalabs' ); ?>
			</h2>
		</div>

		<div class="grid gap-5 md:grid-cols-3">
			<?php foreach ( $testimonials as $index => $item ) : ?>
				<article class="border border-white/10 bg-surface/70 p-6" data-reveal data-reveal-delay="<?php echo esc_attr( (string) ( $index * 0.08 ) ); ?>">
					<p class="text-primary-400 font-mono text-xs">★★★★★</p>
					<blockquote class="mt-8 text-lg font-semibold leading-snug">
						&ldquo;<?php echo esc_html( $item['quote'] ); ?>&rdquo;
					</blockquote>
					<div class="mt-8 border-t border-white/10 pt-5">
						<p class="font-semibold"><?php echo esc_html( $item['name'] ); ?></p>
						<p class="text-sm text-muted"><?php echo esc_html( $item['role'] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
