<?php
/**
 * Services section.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$services_heading   = kasta_site_option( 'services_heading', __( 'Layanan digital yang terhubung dari strategi sampai eksekusi.', 'kastalabs' ) );
$services_body      = kasta_site_option( 'services_body', __( 'Pilih titik mulai yang paling relevan. Setiap layanan bisa berdiri sendiri atau disusun menjadi satu sistem digital yang utuh.', 'kastalabs' ) );
$services_cta_label = kasta_site_option( 'services_cta_label', __( 'Lihat semua layanan', 'kastalabs' ) );
$services_cta_url   = kasta_site_url_option( 'services_cta_url', '/services/' );
$service_pills      = array_filter(
	array(
		kasta_site_option( 'services_pill_one', __( 'Branding', 'kastalabs' ) ),
		kasta_site_option( 'services_pill_two', __( 'Experience design', 'kastalabs' ) ),
		kasta_site_option( 'services_pill_three', __( 'Engineering', 'kastalabs' ) ),
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
		'icon'  => 'sparkles',
		'title' => __( 'Branding Design', 'kastalabs' ),
		'desc'  => __( 'Membangun identitas visual yang memperkuat positioning dan komunikasi brand secara konsisten — dari logo, palet warna, tipografi, sampai pedoman brand yang bisa dipakai tim internal.', 'kastalabs' ),
	),
	array(
		'icon'  => 'eye',
		'title' => __( 'UI/UX Design', 'kastalabs' ),
		'desc'  => __( 'Merancang pengalaman digital yang intuitif dan terasa natural — didasarkan pada riset pengguna, bukan sekadar asumsi estetika.', 'kastalabs' ),
	),
	array(
		'icon'  => 'code-bracket',
		'title' => __( 'Web Development', 'kastalabs' ),
		'desc'  => __( 'Mengembangkan website yang cepat, scalable, dan dikelola dengan mudah — menggunakan teknologi modern tanpa kehilangan fokus pada konten dan SEO.', 'kastalabs' ),
	),
	array(
		'icon'  => 'puzzle-piece',
		'title' => __( 'Custom Software Development', 'kastalabs' ),
		'desc'  => __( 'Membangun sistem digital custom yang sesuai dengan cara kerja bisnis Anda — bukan memaksa bisnis menyesuaikan dengan software yang kaku.', 'kastalabs' ),
	),
);

$service_icons = array(
	'branding-design'             => 'sparkles',
	'ui-ux-design'                => 'eye',
	'web-development'             => 'code-bracket',
	'custom-software-development' => 'puzzle-piece',
);
?>

<section class="py-28 md:py-36 bg-bg" data-services>
	<div class="container-x">
		<?php
		get_template_part(
			'template-parts/ui/heading',
			null,
			array(
				'eyebrow' => kasta_site_option( 'services_eyebrow', __( 'Yang kami kerjakan', 'kastalabs' ) ),
				'title'   => $services_heading,
				'body'    => $services_body,
			)
		);
		?>

		<?php if ( $service_pills ) : ?>
			<div class="mt-6 flex flex-wrap justify-center gap-3" aria-label="<?php esc_attr_e( 'Kategori layanan', 'kastalabs' ); ?>">
				<?php foreach ( $service_pills as $pill ) : ?>
					<?php get_template_part( 'template-parts/ui/badge', null, array( 'label' => $pill, 'variant' => 'pill' ) ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 mt-10">
			<?php if ( $services_query->have_posts() ) : ?>
				<?php
				while ( $services_query->have_posts() ) :
					$services_query->the_post();
					$slug     = get_post_field( 'post_name', get_the_ID() );
					$icon     = $service_icons[ $slug ] ?? 'sparkles';
					get_template_part(
						'template-parts/cards/service-card',
						null,
						array(
							'icon'     => $icon,
							'title'    => get_the_title(),
							'body'     => (string) get_post_meta( get_the_ID(), 'overview', true ) ?: get_the_excerpt(),
							'is_solid' => 3 === $services_query->current_post,
						)
					);
				endwhile;
				wp_reset_postdata();
				?>
			<?php else : ?>
				<?php foreach ( $fallback_services as $index => $service ) : ?>
					<?php
					get_template_part(
						'template-parts/cards/service-card',
						null,
						array(
							'icon'     => $service['icon'],
							'title'    => $service['title'],
							'body'     => $service['desc'],
							'is_solid' => 3 === $index,
						)
					);
					?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<div class="mt-10 text-center">
			<?php
			get_template_part(
				'template-parts/ui/button',
				null,
				array(
					'label'   => $services_cta_label,
					'url'     => $services_cta_url,
					'variant' => 'ghost',
					'icon'    => 'arrow-right',
				)
			);
			?>
		</div>
	</div>
</section>
