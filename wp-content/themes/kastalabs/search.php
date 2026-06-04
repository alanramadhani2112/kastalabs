<?php
/**
 * Search results template.
 *
 * @package Kastalabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" class="container-x py-24" role="main">
	<header class="mb-12">
		<p class="eyebrow"><?php esc_html_e( 'Search', 'kastalabs' ); ?></p>
		<h1 class="type-h1 mt-4 max-w-3xl">
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
				<article class="border-b border-hairline pb-8">
					<h2 class="type-h4">
						<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
					</h2>
					<p class="type-body text-muted mt-3 measure-copy"><?php the_excerpt(); ?></p>
				</article>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination( array( 'class' => 'mt-12' ) ); ?>
	<?php else : ?>
		<p class="text-muted"><?php esc_html_e( 'Tidak ditemukan hasil.', 'kastalabs' ); ?></p>
	<?php endif; ?>
</main>

<?php get_footer();
