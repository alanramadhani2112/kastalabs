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
		'title' => __( 'Branding Design', 'kastalabs' ),
		'body'  => __( 'Membangun identitas visual yang tidak hanya terlihat menarik, tetapi juga mampu memperkuat positioning dan komunikasi brand secara konsisten.', 'kastalabs' ),
	),
	array(
		'title' => __( 'UI/UX Design', 'kastalabs' ),
		'body'  => __( 'Mengembangkan pengalaman digital yang intuitif, nyaman digunakan, dan dirancang berdasarkan kebutuhan pengguna serta tujuan bisnis.', 'kastalabs' ),
	),
	array(
		'title' => __( 'Web Development', 'kastalabs' ),
		'body'  => __( 'Membangun website modern dengan performa optimal, struktur yang scalable, dan pengalaman visual yang profesional.', 'kastalabs' ),
	),
	array(
		'title' => __( 'Custom Software Development', 'kastalabs' ),
		'body'  => __( 'Mengembangkan software dan sistem digital custom yang membantu bisnis bekerja lebih efisien, terorganisir, dan siap berkembang.', 'kastalabs' ),
	),
);
?>

<main id="main" role="main" data-page="services">
	<section class="container-x pt-28 pb-16 md:pt-40 md:pb-24">
		<div class="max-w-5xl" data-reveal>
			<?php kasta_eyebrow( __( 'Services', 'kastalabs' ) ); ?>
			<h1 class="font-display font-extrabold text-5xl md:text-8xl lg:text-9xl tracking-tight leading-[0.9] mt-6">
				<?php esc_html_e( 'Digital services designed with clarity and purpose.', 'kastalabs' ); ?>
			</h1>
			<p class="text-muted text-lg md:text-xl mt-8 max-w-3xl leading-relaxed">
				<?php esc_html_e( 'Kami membantu bisnis membangun identitas, pengalaman, dan sistem digital yang lebih modern, efektif, dan scalable.', 'kastalabs' ); ?>
			</p>
		</div>
	</section>

	<section class="container-x pb-24 md:pb-32">
		<div class="grid gap-6 md:grid-cols-2">
			<?php if ( $services->have_posts() ) : ?>
				<?php
				while ( $services->have_posts() ) :
					$services->the_post();
					$overview = (string) get_post_meta( get_the_ID(), 'overview', true );
					?>
					<article class="rounded-lg border border-hairline bg-bg p-8 shadow-[0_18px_40px_rgb(0_12_26_/_0.04)]" data-reveal>
						<p class="eyebrow"><?php echo esc_html( sprintf( '%02d', $services->current_post + 1 ) ); ?></p>
						<h2 class="mt-10 text-3xl font-bold leading-tight"><?php the_title(); ?></h2>
						<p class="mt-5 text-muted leading-relaxed">
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
					<article class="rounded-lg border border-hairline bg-bg p-8 shadow-[0_18px_40px_rgb(0_12_26_/_0.04)]" data-reveal data-reveal-delay="<?php echo esc_attr( (string) ( $index * 0.08 ) ); ?>">
						<p class="eyebrow"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></p>
						<h2 class="mt-10 text-3xl font-bold leading-tight"><?php echo esc_html( $service['title'] ); ?></h2>
						<p class="mt-5 text-muted leading-relaxed"><?php echo esc_html( $service['body'] ); ?></p>
					</article>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</section>

	<?php get_template_part( 'template-parts/sections/cta-banner' ); ?>
</main>

<?php get_footer();
