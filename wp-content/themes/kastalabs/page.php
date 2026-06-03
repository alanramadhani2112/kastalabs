<?php
/**
 * Generic single page template (fallback).
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" class="container-x py-24" role="main">
	<?php while ( have_posts() ) : the_post(); ?>
		<article>
			<header class="mb-12 max-w-3xl" data-reveal>
				<h1 class="font-display font-extrabold text-4xl md:text-7xl tracking-tight leading-tight">
					<?php the_title(); ?>
				</h1>
			</header>
			<div class="prose prose-invert max-w-none" data-reveal data-reveal-delay="0.1">
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</main>

<?php get_footer();