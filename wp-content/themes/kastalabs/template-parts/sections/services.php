<?php
/**
 * Services section — 6 cards with staggered reveal + 3D tilt.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$services = array(
	array(
		'icon'  => '01',
		'title' => __( 'Brand Strategy', 'kastalabs' ),
		'desc'  => __( 'Menentukan posisi, audiens, pesan utama, dan arah komunikasi sebelum desain bergerak terlalu jauh.', 'kastalabs' ),
	),
	array(
		'icon'  => '02',
		'title' => __( 'Visual Identity', 'kastalabs' ),
		'desc'  => __( 'Logo, sistem warna, tipografi, layout, dan panduan visual yang membuat brand konsisten.', 'kastalabs' ),
	),
	array(
		'icon'  => '03',
		'title' => __( 'Website Design', 'kastalabs' ),
		'desc'  => __( 'Desain website yang mengutamakan cerita, konversi, aksesibilitas, dan pengalaman pengguna.', 'kastalabs' ),
	),
	array(
		'icon'  => '04',
		'title' => __( 'WordPress Development', 'kastalabs' ),
		'desc'  => __( 'Theme custom, struktur konten, performa, SEO dasar, dan admin experience yang mudah dikelola.', 'kastalabs' ),
	),
	array(
		'icon'  => '05',
		'title' => __( 'Content System', 'kastalabs' ),
		'desc'  => __( 'Struktur halaman, copywriting, komponen konten, dan pola editorial supaya pesan mudah dikembangkan.', 'kastalabs' ),
	),
	array(
		'icon'  => '06',
		'title' => __( 'Motion Direction', 'kastalabs' ),
		'desc'  => __( 'Interaksi dan animasi yang mendukung narasi, bukan sekadar dekorasi.', 'kastalabs' ),
	),
);
?>

<section class="py-24 md:py-32" data-services>
	<div class="container-x">
		<div class="mb-16" data-reveal>
			<?php kasta_eyebrow( __( 'Layanan', 'kastalabs' ) ); ?>
			<h2 class="text-3xl md:text-5xl font-bold mt-4 max-w-lg">
				<?php esc_html_e( 'Yang kami bantu bangun.', 'kastalabs' ); ?>
			</h2>
		</div>

		<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
			<?php foreach ( $services as $service ) : ?>
				<article
					class="group relative p-8 rounded-2xl border border-white/8 bg-surface hover:border-primary-500/30 transition-colors duration-300"
					data-service-card
					data-cursor="grow"
				>
					<span class="font-mono text-sm text-primary-500 font-bold"><?php echo esc_html( $service['icon'] ); ?></span>
					<h3 class="text-xl font-bold mt-4 mb-3 group-hover:text-primary-400 transition-colors">
						<?php echo esc_html( $service['title'] ); ?>
					</h3>
					<p class="text-muted text-sm leading-relaxed">
						<?php echo esc_html( $service['desc'] ); ?>
					</p>
					<div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none" aria-hidden="true"></div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
