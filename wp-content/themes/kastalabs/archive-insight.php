<?php
/**
 * Insights archive template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" role="main" data-page="insights">
	<header class="zoom-page-hero py-24 md:py-32" data-reveal>
		<div class="container-x">
		<div class="zoom-page-hero__content">
		<?php kasta_eyebrow( __( 'Insights', 'kastalabs' ) ); ?>
		<h1 class="type-display-lg mt-4">
			<?php esc_html_e( 'Thoughts, insights, and digital perspectives.', 'kastalabs' ); ?>
		</h1>
		<p class="type-body-lg measure-copy text-muted mt-8">
			<?php esc_html_e( 'Berbagai insight, pemikiran, dan eksplorasi mengenai desain, teknologi, strategi digital, serta proses kreatif di balik Kastalabs.', 'kastalabs' ); ?>
		</p>
		</div>
		</div>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="container-x grid gap-6 py-24 md:grid-cols-2 lg:grid-cols-3">
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="zoom-card overflow-hidden" data-reveal>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="block aspect-[4/3] overflow-hidden bg-surface">
							<?php the_post_thumbnail( 'kasta-thumb', array( 'class' => 'w-full h-full object-cover' ) ); ?>
						</a>
					<?php endif; ?>
					<div class="p-6">
						<p class="eyebrow"><?php echo esc_html( get_the_date() ); ?></p>
						<h2 class="type-h4 mt-2">
							<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
						</h2>
					</div>
				</article>
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
