<?php
/**
 * Section heading component.
 *
 * Pola paling umum di semua section: eyebrow + title + optional body + optional CTA.
 * Mengurangi duplikasi ~10+ section.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $eyebrow       Eyebrow text.
 *     @type string $title         Heading text.
 *     @type string $body          Optional body/description.
 *     @type string $cta_label     Optional CTA button label.
 *     @type string $cta_url       Optional CTA button URL.
 *     @type string $cta_icon      Optional CTA button icon (Heroicon name).
 *     @type string $class         Additional classes on wrapper.
 *     @type bool   $data_reveal   Wrap with data-reveal attribute.
 *     @type string $reveal_delay  data-reveal-delay value.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'eyebrow'      => '',
		'title'        => '',
		'body'         => '',
		'cta_label'    => '',
		'cta_url'      => '',
		'cta_icon'     => 'arrow-right',
		'class'        => 'zoom-section-heading',
		'data_reveal'  => true,
		'reveal_delay' => '',
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

<div class="<?php echo esc_attr( $args['class'] ); ?>"<?php echo $reveal_attrs; // phpcs:ignore ?>>
	<?php if ( $args['eyebrow'] ) : ?>
		<?php kasta_eyebrow( $args['eyebrow'] ); ?>
	<?php endif; ?>

	<?php if ( $args['title'] ) : ?>
		<h2 class="type-h2 mt-4">
			<?php echo esc_html( $args['title'] ); ?>
		</h2>
	<?php endif; ?>

	<?php if ( $args['body'] ) : ?>
		<p class="type-body mt-5 text-muted">
			<?php echo esc_html( $args['body'] ); ?>
		</p>
	<?php endif; ?>

	<?php if ( $args['cta_label'] && $args['cta_url'] ) : ?>
		<div class="mt-6">
			<?php
			get_template_part(
				'template-parts/ui/button',
				null,
				array(
					'label'   => $args['cta_label'],
					'url'     => $args['cta_url'],
					'variant' => 'ghost',
					'icon'    => $args['cta_icon'],
					'class'   => 'inline-flex',
				)
			);
			?>
		</div>
	<?php endif; ?>
</div>
