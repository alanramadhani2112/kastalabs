<?php
/**
 * Services section.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$services_eyebrow   = kasta_site_option( 'services_eyebrow', __( 'Layanan', 'kastalabs' ) );
$services_heading   = kasta_site_option( 'services_heading', __( 'Services built around clarity, creativity, and systems thinking.', 'kastalabs' ) );
$services_body      = kasta_site_option( 'services_body', __( 'Pilih titik mulai yang paling relevan. Setiap layanan bisa berdiri sendiri atau disusun menjadi satu sistem digital yang utuh.', 'kastalabs' ) );
$services_cta_label = kasta_site_option( 'services_cta_label', __( 'View All Services', 'kastalabs' ) );
$services_cta_url   = kasta_site_url_option( 'services_cta_url', '/services/' );
$service_pills      = array_filter(
	array(
		kasta_site_option( 'services_pill_one', __( 'Branding', 'kastalabs' ) ),
		kasta_site_option( 'services_pill_two', __( 'Product experience', 'kastalabs' ) ),
		kasta_site_option( 'services_pill_three', __( 'Web systems', 'kastalabs' ) ),
	)
);

$services_query = new WP_Query(
	array(
		'post_type'      => 'service',
		'posts_per_page' => 4,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		),
	)
);

$fallback_services = array(
	array(
		'icon'  => '01',
		'title' => __( 'Branding Design', 'kastalabs' ),
		'desc'  => __( 'Membangun identitas visual dan sistem brand yang kuat, konsisten, dan mampu merepresentasikan karakter bisnis secara strategis.', 'kastalabs' ),
	),
	array(
		'icon'  => '02',
		'title' => __( 'UI/UX Design', 'kastalabs' ),
		'desc'  => __( 'Merancang pengalaman digital yang intuitif, human-centered, dan dirancang berdasarkan perilaku serta kebutuhan pengguna.', 'kastalabs' ),
	),
	array(
		'icon'  => '03',
		'title' => __( 'Web Development', 'kastalabs' ),
		'desc'  => __( 'Mengembangkan website modern yang cepat, scalable, dan dibangun untuk memperkuat kredibilitas serta performa digital bisnis Anda.', 'kastalabs' ),
	),
	array(
		'icon'  => '04',
		'title' => __( 'Custom Software Development', 'kastalabs' ),
		'desc'  => __( 'Membangun sistem digital dan software custom yang membantu operasional berjalan lebih efisien, terstruktur, dan scalable.', 'kastalabs' ),
	),
);
?>

<section class="py-24 md:py-32 bg-bg" data-services>
	<div class="container-x">
		<div class="zoom-section-heading mb-8" data-reveal>
			<?php kasta_eyebrow( $services_eyebrow ); ?>
			<h2 class="type-h2 mt-4">
				<?php echo esc_html( $services_heading ); ?>
			</h2>
			<p class="type-body mt-5 text-muted">
				<?php echo esc_html( $services_body ); ?>
			</p>
		</div>

		<?php if ( $service_pills ) : ?>
			<div class="zoom-pill-row mb-10 justify-center" aria-label="<?php esc_attr_e( 'Service categories', 'kastalabs' ); ?>">
				<?php foreach ( $service_pills as $service_pill ) : ?>
					<span class="zoom-pill type-label"><?php echo esc_html( $service_pill ); ?></span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
			<?php if ( $services_query->have_posts() ) : ?>
				<?php
				while ( $services_query->have_posts() ) :
					$services_query->the_post();
					$overview = (string) get_post_meta( get_the_ID(), 'overview', true );
					?>
					<article
						class="zoom-card <?php echo esc_attr( 3 === $services_query->current_post ? 'zoom-card--solid' : 'zoom-card--soft' ); ?> group relative min-h-72 p-7 transition-transform duration-300 hover:-translate-y-1"
						data-service-card
					>
						<span class="type-label text-primary-600"><?php echo esc_html( sprintf( '%02d', $services_query->current_post + 1 ) ); ?></span>
						<h3 class="type-h4 mt-10 mb-3 group-hover:text-primary-600 transition-colors">
							<?php the_title(); ?>
						</h3>
						<p class="type-body-sm text-muted">
							<?php echo esc_html( $overview ?: get_the_excerpt() ); ?>
						</p>
					</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ( $fallback_services as $index => $service ) : ?>
				<article
					class="zoom-card <?php echo esc_attr( 3 === $index ? 'zoom-card--solid' : 'zoom-card--soft' ); ?> group relative min-h-72 p-7 transition-transform duration-300 hover:-translate-y-1"
					data-service-card
				>
					<span class="type-label text-primary-600"><?php echo esc_html( $service['icon'] ); ?></span>
					<h3 class="type-h4 mt-10 mb-3 group-hover:text-primary-600 transition-colors">
						<?php echo esc_html( $service['title'] ); ?>
					</h3>
					<p class="type-body-sm text-muted">
						<?php echo esc_html( $service['desc'] ); ?>
					</p>
				</article>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<div class="mt-10 text-center">
			<a href="<?php echo esc_url( $services_cta_url ); ?>" class="btn-ghost" data-magnetic>
				<?php echo esc_html( $services_cta_label ); ?>
			</a>
		</div>
	</div>
</section>
