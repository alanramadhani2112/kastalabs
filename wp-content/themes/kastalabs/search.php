<?php
/**
 * Search results template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" class="container-x py-24" role="main">
	<header class="mb-12">
		<p class="eyebrow"><?php esc_html_e( 'Search', 'kastalabs' ); ?></p>
		<h1 class="font-display font-bold text-4xl md:text-6xl mt-4 max-w-3xl">
			<?php
			printf(
				/* translators: %s: search query */
				esc_html__( 'Hasil untuk "%s"', 'kastalabs' ),
				'<em class="text-primary not-italic">' . esc_html( get_search_query() ) . '</em>' // phpcs:ignore WordPress.Security.EscapeOutput
			);
			?>
		</h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="grid gap-8">
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="border-b border-white/10 pb-8">
					<h2 class="text-2xl font-semibold">
						<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
					</h2>
					<p class="text-muted mt-3 max-w-prose"><?php the_excerpt(); ?></p>
				</article>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination( array( 'class' => 'mt-12' ) ); ?>
	<?php else : ?>
		<p class="text-muted"><?php esc_html_e( 'Tidak ditemukan hasil.', 'kastalabs' ); ?></p>
	<?php endif; ?>
</main>

<?php get_footer();