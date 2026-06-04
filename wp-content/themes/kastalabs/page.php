<?php
/**
 * Generic single page template (fallback).
 *
 * @package Kastalabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" role="main">
	<?php while ( have_posts() ) : the_post(); ?>
		<article>
			<header class="zoom-page-hero py-24 md:py-32" data-reveal>
				<div class="container-x">
				<h1 class="type-h1 max-w-3xl">
					<?php the_title(); ?>
				</h1>
				</div>
			</header>
			<div class="container-x prose py-16 md:py-24" data-reveal data-reveal-delay="0.1">
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</main>

<?php get_footer();
