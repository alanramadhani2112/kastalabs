<?php
/**
 * Blog index template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" class="container-x py-24" role="main" data-page="blog">
	<header class="mb-16 max-w-3xl" data-reveal>
		<?php kasta_eyebrow( __( 'Jurnal', 'kastalabs' ) ); ?>
		<h1 class="type-display-lg mt-4">
			<?php esc_html_e( 'Tulisan & catatan.', 'kastalabs' ); ?>
		</h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="grid gap-12 md:grid-cols-2 lg:grid-cols-3">
			<?php while ( have_posts() ) : the_post(); ?>
				<article data-reveal>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="block aspect-[4/3] overflow-hidden bg-surface mb-4">
							<?php the_post_thumbnail( 'kasta-thumb', array( 'class' => 'w-full h-full object-cover' ) ); ?>
						</a>
					<?php endif; ?>
					<p class="eyebrow"><?php echo esc_html( get_the_date() ); ?></p>
					<h2 class="type-h4 mt-2">
						<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
					</h2>
				</article>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination( array( 'class' => 'mt-16' ) ); ?>
	<?php else : ?>
		<p class="text-muted"><?php esc_html_e( 'Belum ada tulisan.', 'kastalabs' ); ?></p>
	<?php endif; ?>
</main>

<?php get_footer();
