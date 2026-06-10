<?php
/**
 * Featured work grid section.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$portfolio_heading   = kasta_site_option( 'portfolio_heading', __( 'Project yang kami bangun dengan strategi dan niat.', 'kastalabs' ) );
$portfolio_body      = kasta_site_option( 'portfolio_body', __( 'Beberapa contoh bagaimana strategi, visual, dan teknologi disusun menjadi pengalaman digital yang berkesan.', 'kastalabs' ) );
$portfolio_cta_label = kasta_site_option( 'portfolio_cta_label', __( 'Lihat semua project', 'kastalabs' ) );
$portfolio_cta_url   = kasta_site_url_option( 'portfolio_cta_url', get_post_type_archive_link( 'portfolio' ) ?: '/portfolio/' );

$portfolio_query = new WP_Query(
	array(
		'post_type'      => 'portfolio',
		'posts_per_page' => 4,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'meta_query'     => array(
			array(
				'key'     => 'is_featured',
				'value'   => '1',
				'compare' => '=',
			),
		),
	)
);

// Fallback: if no featured posts, show recent
if ( ! $portfolio_query->have_posts() ) {
	$portfolio_query = new WP_Query(
		array(
			'post_type'      => 'portfolio',
			'posts_per_page' => 4,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);
}

$placeholders = array(
	array( 'title' => __( 'Brand Identity System', 'kastalabs' ), 'cat' => __( 'Branding', 'kastalabs' ) ),
	array( 'title' => __( 'E-Commerce Platform', 'kastalabs' ), 'cat' => __( 'Web Development', 'kastalabs' ) ),
	array( 'title' => __( 'SaaS Dashboard', 'kastalabs' ), 'cat' => __( 'UI/UX Design', 'kastalabs' ) ),
	array( 'title' => __( 'Mobile App Design', 'kastalabs' ), 'cat' => __( 'Custom Software', 'kastalabs' ) ),
);
?>

<section class="py-24 md:py-32 bg-bg" data-work-grid>
	<div class="container-x">
		<?php
		get_template_part(
			'template-parts/ui/heading',
			null,
			array(
				'eyebrow' => kasta_site_option( 'portfolio_eyebrow', __( 'Portfolio pilihan', 'kastalabs' ) ),
				'title'   => $portfolio_heading,
				'body'    => $portfolio_body,
			)
		);
		?>

		<div class="mb-10 hidden justify-center md:flex mt-10">
			<?php
			get_template_part(
				'template-parts/ui/button',
				null,
				array(
					'label'   => $portfolio_cta_label,
					'url'     => $portfolio_cta_url,
					'variant' => 'ghost',
				)
			);
			?>
		</div>

		<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
			<?php if ( $portfolio_query->have_posts() ) : ?>
				<?php while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post(); ?>
					<?php get_template_part( 'template-parts/cards/work-card', null, array( 'variant' => 'grid' ) ); ?>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ( $placeholders as $ph ) : ?>
					<article class="zoom-card overflow-hidden" data-work-item>
						<div class="flex aspect-[4/3] w-full items-center justify-center bg-surface" data-work-media>
							<span class="type-label text-muted"><?php echo esc_html( $ph['cat'] ); ?></span>
						</div>
						<div class="p-6">
							<span class="eyebrow text-primary-600 mb-2 block"><?php echo esc_html( $ph['cat'] ); ?></span>
							<h3 class="type-h4"><?php echo esc_html( $ph['title'] ); ?></h3>
						</div>
					</article>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<div class="mt-10 text-center md:hidden">
			<?php
			get_template_part(
				'template-parts/ui/button',
				null,
				array(
					'label'   => $portfolio_cta_label,
					'url'     => $portfolio_cta_url,
					'variant' => 'ghost',
				)
			);
			?>
		</div>
	</div>
</section>
