<?php
/**
 * Single service template.
 *
 * @package Kastalabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" role="main" data-page="service-single">

	<?php
	while ( have_posts() ) :
		the_post();

		$slug         = get_post_field( 'post_name', get_the_ID() );
		$icon_map     = array(
			'branding-design'             => 'sparkles',
			'ui-ux-design'                => 'eye',
			'web-development'             => 'code-bracket',
			'custom-software-development' => 'puzzle-piece',
		);
		$service_icon = $icon_map[ $slug ] ?? 'sparkles';
		$cta_label    = get_post_meta( get_the_ID(), 'cta_label', true ) ?: __( 'Ceritakan proyek Anda', 'kastalabs' );
		$cta_url      = get_post_meta( get_the_ID(), 'cta_url', true ) ?: home_url( '/contact/' );
		$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
		$image_url    = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'large' ) : '';
		$image_alt    = $thumbnail_id ? get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) : '';
		$overview     = (string) get_post_meta( get_the_ID(), 'overview', true );
		$inclusions   = (string) get_post_meta( get_the_ID(), 'inclusions', true );
		$inclusions_list = $inclusions ? array_filter( array_map( 'trim', explode( "\n", $inclusions ) ) ) : array();
		?>

		<article>
			<?php
			get_template_part(
				'template-parts/hero/page-hero',
				null,
				array(
					'eyebrow' => __( 'Layanan', 'kastalabs' ),
					'heading' => get_the_title(),
					'body'    => $overview ?: ( has_excerpt() ? get_the_excerpt() : '' ),
					'pills'   => array(
						get_post_meta( get_the_ID(), 'icon_label', true ) ?: get_the_title(),
					),
				)
			);
			?>

			<?php if ( trim( get_the_content() ) || $inclusions_list ) : ?>
				<section class="container-x py-24 md:py-32">
					<div class="grid gap-12 lg:grid-cols-[minmax(0,1fr)_22rem] lg:items-start">
						<div class="prose max-w-none" data-reveal>
							<?php if ( trim( get_the_content() ) ) : ?>
								<?php the_content(); ?>
							<?php endif; ?>
						</div>

						<aside class="lg:sticky lg:top-28" data-reveal data-reveal-delay="0.1">
							<?php if ( $inclusions_list ) : ?>
								<div class="zoom-card zoom-card--soft p-6">
									<h2 class="eyebrow"><?php esc_html_e( 'Yang termasuk', 'kastalabs' ); ?></h2>
									<ul class="mt-5 grid gap-3">
										<?php foreach ( $inclusions_list as $item ) : ?>
											<li class="type-body-sm flex items-start gap-2.5 text-muted">
												<?php kasta_icon( 'check', array( 'class' => 'w-4 h-4 mt-0.5 text-primary-500 flex-none', 'variant' => 'mini' ) ); ?>
												<?php echo esc_html( $item ); ?>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>

							<?php if ( $cta_label && $cta_url ) : ?>
								<div class="mt-6">
									<?php
									get_template_part(
										'template-parts/ui/button',
										null,
										array(
											'label'    => $cta_label,
											'url'      => $cta_url,
											'variant'  => 'primary',
											'magnetic' => true,
											'class'    => 'w-full justify-center',
										)
									);
									?>
								</div>
							<?php endif; ?>
						</aside>
					</div>
				</section>
			<?php endif; ?>

			<?php get_template_part( 'template-parts/sections/cta-banner' ); ?>
		</article>

	<?php endwhile; ?>

</main>

<?php get_footer();
