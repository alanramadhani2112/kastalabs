<?php
/**
 * Services page template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header();

$services = new WP_Query(
	array(
		'post_type'      => 'service',
		'posts_per_page' => -1,
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
		'body'  => __( 'Membangun identitas visual yang tidak hanya terlihat menarik, tetapi juga mampu memperkuat positioning dan komunikasi brand secara konsisten — dari logo, palet warna, tipografi, sampai pedoman brand yang bisa dipakai tim internal.', 'kastalabs' ),
	),
	array(
		'icon'  => 'eye',
		'title' => __( 'UI/UX Design', 'kastalabs' ),
		'body'  => __( 'Merancang pengalaman digital yang intuitif dan terasa natural — didasarkan pada riset pengguna, bukan sekadar asumsi estetika.', 'kastalabs' ),
	),
	array(
		'icon'  => 'code-bracket',
		'title' => __( 'Web Development', 'kastalabs' ),
		'body'  => __( 'Mengembangkan website yang cepat, scalable, dan dikelola dengan mudah — menggunakan teknologi modern tanpa kehilangan fokus pada konten dan SEO.', 'kastalabs' ),
	),
	array(
		'icon'  => 'puzzle-piece',
		'title' => __( 'Custom Software Development', 'kastalabs' ),
		'body'  => __( 'Membangun sistem digital custom yang sesuai dengan cara kerja bisnis Anda — bukan memaksa bisnis menyesuaikan dengan software yang kaku.', 'kastalabs' ),
	),
);

$service_icons = array(
	'branding-design'             => 'sparkles',
	'ui-ux-design'                => 'eye',
	'web-development'             => 'code-bracket',
	'custom-software-development' => 'puzzle-piece',
);
?>

<main id="main" role="main" data-page="services">
	<?php
	get_template_part(
		'template-parts/hero/page-hero',
		null,
		array(
			'eyebrow' => __( 'Layanan kami', 'kastalabs' ),
			'heading' => __( 'Layanan digital yang dirancang dengan kejelasan dan tujuan.', 'kastalabs' ),
			'body'    => __( 'Dari strategi brand sampai software custom — setiap layanan kami bangun dengan pendekatan yang sama: teliti, strategis, dan siap dipakai.', 'kastalabs' ),
			'pills'   => array(
				__( 'Brand', 'kastalabs' ),
				__( 'Experience', 'kastalabs' ),
				__( 'Engineering', 'kastalabs' ),
			),
		)
	);
	?>

	<section class="container-x py-24 md:py-32">
		<div class="grid gap-6 md:grid-cols-2">
			<?php if ( $services->have_posts() ) : ?>
				<?php
				while ( $services->have_posts() ) :
					$services->the_post();
					$overview = (string) get_post_meta( get_the_ID(), 'overview', true );
					$is_solid = 3 === $services->current_post;
					?>
					<article class="zoom-card <?php echo esc_attr( $is_solid ? 'zoom-card--solid' : 'zoom-card--soft' ); ?> p-8" data-reveal>
						<div class="w-10 h-10 flex items-center justify-center rounded-lg mb-6 <?php echo $is_solid ? 'bg-white/10 text-white' : 'bg-primary-500/10 text-primary-600'; ?>">
							<?php
							$slug = get_post_field( 'post_name', get_the_ID() );
							$icon = $service_icons[ $slug ] ?? 'sparkles';
							kasta_icon( $icon, array( 'class' => 'w-5 h-5' ) );
							?>
						</div>
						<h2 class="type-h3 mt-2"><?php the_title(); ?></h2>
						<p class="type-body mt-5 text-muted">
							<?php echo esc_html( $overview ?: get_the_excerpt() ); ?>
						</p>
						<?php if ( trim( get_the_content() ) ) : ?>
							<div class="prose mt-8">
								<?php the_content(); ?>
							</div>
						<?php endif; ?>
					</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ( $fallback_services as $index => $service ) : ?>
					<?php $is_solid = 3 === $index; ?>
					<article class="zoom-card <?php echo esc_attr( $is_solid ? 'zoom-card--solid' : 'zoom-card--soft' ); ?> p-8" data-reveal data-reveal-delay="<?php echo esc_attr( (string) ( $index * 0.08 ) ); ?>">
						<div class="w-10 h-10 flex items-center justify-center rounded-lg mb-6 <?php echo $is_solid ? 'bg-white/10 text-white' : 'bg-primary-500/10 text-primary-600'; ?>">
							<?php kasta_icon( $service['icon'], array( 'class' => 'w-5 h-5' ) ); ?>
						</div>
						<h2 class="type-h3 mt-2"><?php echo esc_html( $service['title'] ); ?></h2>
						<p class="type-body mt-5 text-muted"><?php echo esc_html( $service['body'] ); ?></p>
					</article>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</section>

	<?php get_template_part( 'template-parts/sections/cta-banner' ); ?>
</main>

<?php get_footer();
