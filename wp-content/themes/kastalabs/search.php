<?php
/**
 * Search results template.
 *
 * @package Kastalabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" role="main" data-page="search">
	<header class="zoom-page-hero py-28 md:py-36">
		<div class="container-x">
		<p class="eyebrow"><?php esc_html_e( 'Pencarian', 'kastalabs' ); ?></p>
		<h1 class="type-display-lg mt-5 max-w-3xl">
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
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="hover:text-primary-600"><?php the_title(); ?></a>
					</h2>
					<p class="type-body text-muted mt-3 measure-copy"><?php echo esc_html( get_the_excerpt() ); ?></p>
				</article>
			<?php endwhile; ?>
		</div>
		<div class="container-x pb-16">
			<?php the_posts_pagination( array( 'class' => 'mt-12' ) ); ?>
		</div>
	<?php else : ?>
		<section class="container-x py-16 md:py-24 text-center">
			<?php kasta_icon( 'magnifying-glass', array( 'class' => 'w-12 h-12 text-muted mx-auto mb-6' ) ); ?>
			<p class="type-body-lg text-muted measure-copy mx-auto"><?php esc_html_e( 'Tidak ditemukan hasil untuk pencarian ini. Coba kata kunci lain.', 'kastalabs' ); ?></p>
			<div class="mt-8">
				<a href="<?php echo esc_url( home_url( '/insights/' ) ); ?>" class="btn-ghost">
					<?php esc_html_e( 'Jelajahi insights', 'kastalabs' ); ?>
				</a>
			</div>
		</section>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
