<?php
/**
 * Feature split section — alternating image + text layout.
 *
 * Inspired by Zoom.com product pages.
 *
 * Usage:
 *   get_template_part( 'template-parts/sections/feature-split', null, array(
 *       'eyebrow'      => '...',
 *       'heading'      => '...',
 *       'body'         => '...',
 *       'image_url'    => 'https://...',
 *       'image_alt'    => '...',
 *       'cta_label'    => '...',
 *       'cta_url'      => '...',
 *       'reverse'      => false,
 *       'bg'           => 'bg-bg',
 *       'image_border' => true,
 *       'image_radius' => '0.75rem',
 *   ) );
 *
 * @package KastaLabs
 * @param array $args
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'eyebrow'       => '',
		'heading'       => '',
		'body'          => '',
		'image_url'     => '',
		'image_alt'     => '',
		'cta_label'     => '',
		'cta_url'       => '',
		'reverse'       => false,
		'bg'            => 'bg-bg',
		'image_border'  => true,
		'image_radius'  => '0.75rem',
	)
);

$grid_class = $args['reverse'] ? 'lg:grid-cols-[minmax(0,1.05fr)_minmax(0,0.95fr)]' : 'lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)]';
$img_border = $args['image_border'] ? 'border border-[rgb(11_92_255_/_0.12)]' : '';
$img_radius = $args['image_radius'] ? 'rounded-[--img-radius]' : '';
?>

<section class="py-24 md:py-32 <?php echo esc_attr( $args['bg'] ); ?>" data-feature-split>
	<div class="container-x">
		<div class="grid gap-12 lg:gap-16 items-center <?php echo esc_attr( $grid_class ); ?>">
			<?php if ( $args['reverse'] ) : ?>
				<?php
				// Text column (right when not reversed, left when reversed)
				?>
				<div class="<?php echo $args['reverse'] ? 'lg:order-2' : ''; ?>">
					<?php if ( $args['eyebrow'] ) : ?>
						<?php kasta_eyebrow( $args['eyebrow'] ); ?>
					<?php endif; ?>

					<?php if ( $args['heading'] ) : ?>
						<h2 class="type-display-lg mt-5 max-w-[14ch]">
							<?php echo esc_html( $args['heading'] ); ?>
						</h2>
					<?php endif; ?>

					<?php if ( $args['body'] ) : ?>
						<p class="type-body-lg measure-copy text-muted mt-7">
							<?php echo esc_html( $args['body'] ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $args['cta_label'] && $args['cta_url'] ) : ?>
						<div class="mt-8">
							<?php
							get_template_part(
								'template-parts/ui/button',
								null,
								array(
									'label'   => $args['cta_label'],
									'url'     => $args['cta_url'],
									'variant' => 'primary',
								)
							);
							?>
						</div>
					<?php endif; ?>
				</div>

				<?php
				// Image column
				?>
				<div class="<?php echo $args['reverse'] ? 'lg:order-1' : ''; ?>">
					<?php if ( $args['image_url'] ) : ?>
						<div class="relative overflow-hidden <?php echo esc_attr( $img_border . ' ' . $img_radius ); ?>" style="--img-radius: <?php echo esc_attr( $args['image_radius'] ); ?>">
							<img
								src="<?php echo esc_url( $args['image_url'] ); ?>"
								alt="<?php echo esc_attr( $args['image_alt'] ); ?>"
								class="w-full h-auto"
								loading="lazy"
							>
							<div class="absolute inset-0 bg-gradient-to-tr from-[rgb(11_92_255_/_0.06)] to-transparent pointer-events-none"></div>
						</div>
					<?php else : ?>
						<div class="aspect-[4/3] rounded-[--img-radius] bg-surface border border-dashed border-[rgb(11_92_255_/_0.18)] flex items-center justify-center" style="--img-radius: <?php echo esc_attr( $args['image_radius'] ); ?>">
							<span class="text-muted type-body-sm"><?php esc_html_e( 'Image placeholder', 'kastalabs' ); ?></span>
						</div>
					<?php endif; ?>
				</div>

			<?php else : ?>
				<?php
				// Image column (left when not reversed)
				?>
				<div>
					<?php if ( $args['image_url'] ) : ?>
						<div class="relative overflow-hidden <?php echo esc_attr( $img_border . ' ' . $img_radius ); ?>" style="--img-radius: <?php echo esc_attr( $args['image_radius'] ); ?>">
							<img
								src="<?php echo esc_url( $args['image_url'] ); ?>"
								alt="<?php echo esc_attr( $args['image_alt'] ); ?>"
								class="w-full h-auto"
								loading="lazy"
							>
							<div class="absolute inset-0 bg-gradient-to-tr from-[rgb(11_92_255_/_0.06)] to-transparent pointer-events-none"></div>
						</div>
					<?php else : ?>
						<div class="aspect-[4/3] rounded-[--img-radius] bg-surface border border-dashed border-[rgb(11_92_255_/_0.18)] flex items-center justify-center" style="--img-radius: <?php echo esc_attr( $args['image_radius'] ); ?>">
							<span class="text-muted type-body-sm"><?php esc_html_e( 'Image placeholder', 'kastalabs' ); ?></span>
						</div>
					<?php endif; ?>
				</div>

				<?php
				// Text column
				?>
				<div>
					<?php if ( $args['eyebrow'] ) : ?>
						<?php kasta_eyebrow( $args['eyebrow'] ); ?>
					<?php endif; ?>

					<?php if ( $args['heading'] ) : ?>
						<h2 class="type-display-lg mt-5 max-w-[14ch]">
							<?php echo esc_html( $args['heading'] ); ?>
						</h2>
					<?php endif; ?>

					<?php if ( $args['body'] ) : ?>
						<p class="type-body-lg measure-copy text-muted mt-7">
							<?php echo esc_html( $args['body'] ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $args['cta_label'] && $args['cta_url'] ) : ?>
						<div class="mt-8">
							<?php
							get_template_part(
								'template-parts/ui/button',
								null,
								array(
									'label'   => $args['cta_label'],
									'url'     => $args['cta_url'],
									'variant' => 'primary',
								)
							);
							?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
