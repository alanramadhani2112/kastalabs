<?php
/**
 * Insights archive template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" role="main" data-page="insights">
	<?php
	get_template_part(
		'template-parts/hero/page-hero',
		null,
		array(
			'eyebrow' => __( 'Insights', 'kastalabs' ),
			'heading' => __( 'Pemikiran, insight, dan sudut pandang digital.', 'kastalabs' ),
			'body'    => __( 'Eksplorasi tentang desain, teknologi, strategi digital, dan proses kreatif di balik Kastalabs.', 'kastalabs' ),
		)
	);
	?>

	<?php if ( have_posts() ) : ?>
		<div class="container-x grid gap-6 py-24 md:grid-cols-2 lg:grid-cols-3">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/cards/insight-card' ); ?>
			<?php endwhile; ?>
		</div>
		<div class="container-x">
			<?php the_posts_pagination( array( 'class' => 'mt-16' ) ); ?>
		</div>
	<?php else : ?>
		<section class="container-x py-24">
			<p class="text-muted"><?php esc_html_e( 'Belum ada insight.', 'kastalabs' ); ?></p>
		</section>
	<?php endif; ?>
</main>

<?php get_footer();
