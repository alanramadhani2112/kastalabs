<?php
/**
 * Single service template.
 *
 * Uses feature-split layout with service content.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" role="main" data-page="service-single">

	<?php
	while ( have_posts() ) :
		the_post();

		$service_icon = get_post_meta( get_the_ID(), 'service_icon', true ) ?: 'sparkles';
		$cta_label    = get_post_meta( get_the_ID(), 'service_cta_label', true ) ?: __( 'Ceritakan proyek Anda', 'kastalabs' );
		$cta_url      = get_post_meta( get_the_ID(), 'service_cta_url', true ) ?: '/contact/';
		$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
		$image_url    = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'large' ) : '';
		$image_alt    = $thumbnail_id ? get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) : '';
		?>

		<article>
			<?php
			// Hero header
			get_template_part(
				'template-parts/hero/page-hero',
				null,
				array(
					'eyebrow' => get_post_meta( get_the_ID(), 'service_eyebrow', true ) ?: __( 'Layanan', 'kastalabs' ),
					'heading' => get_the_title(),
					'body'    => has_excerpt() ? get_the_excerpt() : '',
					'pills'   => array_filter( array( get_post_meta( get_the_ID(), 'service_tagline', true ) ) ),
				)
			);
			?>

			<?php
			// Feature split — main content
			get_template_part(
				'template-parts/sections/feature-split',
				null,
				array(
					'heading'      => get_post_meta( get_the_ID(), 'service_feature_heading', true ) ?: __( 'Bagaimana kami bekerja', 'kastalabs' ),
					'body'         => get_the_content() ?: __( 'Deskripsi layanan akan ditampilkan di sini.', 'kastalabs' ),
					'image_url'    => $image_url,
					'image_alt'    => $image_alt ?: get_the_title(),
					'cta_label'    => $cta_label,
					'cta_url'      => $cta_url,
					'reverse'      => get_post_meta( get_the_ID(), 'service_feature_reverse', true ) ? true : false,
					'bg'           => 'bg-bg',
					'image_border' => true,
				)
			);
			?>

			<?php get_template_part( 'template-parts/sections/cta-banner' ); ?>
		</article>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
