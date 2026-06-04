<?php
/**
 * Search results template.
 *
 * @package Kastalabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" role="main">
	<header class="zoom-page-hero py-24 md:py-32">
		<div class="container-x">
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
		</div>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="container-x grid gap-6 py-16 md:py-24">
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="zoom-card p-6">
					<h2 class="type-h4">
						<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
					</h2>
					<p class="type-body text-muted mt-3 measure-copy"><?php the_excerpt(); ?></p>
				</article>
			<?php endwhile; ?>
		</div>
		<div class="container-x">
			<?php the_posts_pagination( array( 'class' => 'mt-12' ) ); ?>
		</div>
	<?php else : ?>
		<section class="container-x py-16">
			<p class="text-muted"><?php esc_html_e( 'Tidak ditemukan hasil.', 'kastalabs' ); ?></p>
		</section>
	<?php endif; ?>
</main>

<?php get_footer();
