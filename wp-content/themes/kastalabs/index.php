<?php
/**
 * Fallback template. Dipakai bila template lebih spesifik tidak ditemukan.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" class="container mx-auto px-6 py-24" role="main">
	<header class="mb-12">
		<p class="text-xs uppercase tracking-[0.18em] text-muted font-mono"><?php esc_html_e( 'Index', 'kastalabs' ); ?></p>
		<h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mt-4"><?php single_post_title(); ?></h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="grid gap-12">
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="border-b border-white/10 pb-12">
					<h2 class="text-2xl md:text-3xl font-bold mb-3">
						<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
					</h2>
					<div class="text-muted prose prose-invert max-w-none">
						<?php the_excerpt(); ?>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination( array( 'class' => 'mt-16' ) ); ?>
	<?php else : ?>
		<p class="text-muted"><?php esc_html_e( 'Belum ada konten.', 'kastalabs' ); ?></p>
	<?php endif; ?>
</main>

<?php get_footer();