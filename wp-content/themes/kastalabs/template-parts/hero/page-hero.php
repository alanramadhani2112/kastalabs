<?php
/**
 * Generic inner page hero component.
 *
 * Pola yang sama di 5 halaman: page-about, page-services, page-contact,
 * archive-work, archive-insight.
 *
 * Layout: eyebrow + h1 + optional body + optional pills.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $eyebrow      Eyebrow text.
 *     @type string $heading      H1 text.
 *     @type string $body         Optional subtitle.
 *     @type array  $pills        Array of pill labels (optional).
 *     @type string $class        Additional CSS classes on section.
 *     @type bool   $data_reveal  Wrap content with data-reveal (default: true).
 *     @type string $reveal_delay Main content reveal delay.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'eyebrow'      => '',
		'heading'      => '',
		'body'         => '',
		'pills'        => array(),
		'class'        => '',
		'data_reveal'  => true,
		'reveal_delay' => '',
		'breadcrumb'   => true,
	)
);

$reveal_attrs = '';
if ( $args['data_reveal'] ) {
	$reveal_attrs = ' data-reveal';
	if ( $args['reveal_delay'] ) {
		$reveal_attrs .= ' data-reveal-delay="' . esc_attr( $args['reveal_delay'] ) . '"';
	}
}
?>
<section class="zoom-page-hero py-28 md:py-36<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>">
	<div class="container-x">
		<?php if ( $args['breadcrumb'] ) : ?>
			<?php get_template_part( 'template-parts/ui/breadcrumb' ); ?>
		<?php endif; ?>

		<div class="zoom-page-hero__content mt-10"<?php echo $reveal_attrs; // phpcs:ignore ?>>
			<?php if ( $args['eyebrow'] ) : ?>
				<?php kasta_eyebrow( $args['eyebrow'] ); ?>
			<?php endif; ?>

			<?php if ( $args['heading'] ) : ?>
				<h1 class="type-display-lg mt-6">
					<?php echo esc_html( $args['heading'] ); ?>
				</h1>
			<?php endif; ?>

			<?php if ( $args['body'] ) : ?>
				<p class="type-body-lg measure-copy text-muted mt-8">
					<?php echo esc_html( $args['body'] ); ?>
				</p>
			<?php endif; ?>
		</div>

		<?php if ( $args['pills'] ) : ?>
			<div class="zoom-page-hero__meta mt-10" data-reveal data-reveal-delay="0.1">
				<?php foreach ( $args['pills'] as $pill ) : ?>
					<?php
					get_template_part(
						'template-parts/ui/badge',
						null,
						array(
							'label'   => $pill,
							'variant' => 'pill',
							'size'    => 'md',
						)
					);
					?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
