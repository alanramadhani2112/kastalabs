<?php
/**
 * Front page (home).
 *
 * Company profile homepage.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" role="main" data-page="home">

	<?php get_template_part( 'template-parts/hero/home' ); ?>

	<?php get_template_part( 'template-parts/sections/marquee' ); ?>

	<?php get_template_part( 'template-parts/sections/services' ); ?>

	<?php get_template_part( 'template-parts/sections/statement' ); ?>

	<?php get_template_part( 'template-parts/sections/work-grid' ); ?>

	<?php get_template_part( 'template-parts/sections/about-teaser' ); ?>

	<?php get_template_part( 'template-parts/sections/process' ); ?>

	<?php get_template_part( 'template-parts/sections/testimonials' ); ?>

	<?php get_template_part( 'template-parts/sections/faq' ); ?>

	<?php get_template_part( 'template-parts/sections/cta-banner' ); ?>

</main>

<?php get_footer();
