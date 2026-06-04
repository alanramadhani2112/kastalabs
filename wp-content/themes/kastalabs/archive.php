<?php
/**
 * Generic archive fallback (category, tag, author, date, etc.).
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" class="container-x py-24" role="main">
	<header class="mb-12 max-w-3xl" data-reveal>
		<?php kasta_eyebrow( get_the_archive_title() ); ?>
		<h1 class="type-h1 mt-4">
			<?php the_archive_description(); ?>
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
					<h2 class="type-h4"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h2>
				</article>
			<?php endwhile; ?>
		</div>
	<?php else : ?>
		<p class="text-muted"><?php esc_html_e( 'Tidak ada konten.', 'kastalabs' ); ?></p>
	<?php endif; ?>
</main>

<?php get_footer();
