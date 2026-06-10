<?php
/**
 * Client logo bar section — horizontal logo strip.
 *
 * Inspired by Zoom.com "Trusted by millions" section.
 *
 * Usage:
 *   get_template_part( 'template-parts/sections/client-logos', null, array(
 *       'eyebrow'  => '...',
 *       'logos'    => array( array('url' => '...', 'alt' => '...') ),
 *   ) );
 *
 * @package KastaLabs
 * @param array $args
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'eyebrow' => __( 'Dipercaya oleh', 'kastalabs' ),
		'logos'   => array(),
	)
);

if ( empty( $args['logos'] ) ) {
	// Fallback: text-based capability strip saat logo klien belum tersedia.
	$capabilities = array(
		__( 'Brand Strategy', 'kastalabs' ),
		__( 'Visual Design', 'kastalabs' ),
		__( 'Web Systems', 'kastalabs' ),
		__( 'Digital Products', 'kastalabs' ),
	);
	?>
	<section class="py-12 md:py-16 bg-surface border-y border-[rgb(0_12_26_/_0.06)]" data-client-logos>
		<div class="container-x">
			<?php if ( $args['eyebrow'] ) : ?>
				<p class="type-label text-center mb-8"><?php echo esc_html( $args['eyebrow'] ); ?></p>
			<?php endif; ?>
			<div class="flex flex-wrap items-center justify-center gap-x-8 gap-y-3 opacity-60">
				<?php foreach ( $capabilities as $index => $cap ) : ?>
					<span class="type-label whitespace-nowrap"><?php echo esc_html( $cap ); ?></span>
					<?php if ( $index < count( $capabilities ) - 1 ) : ?>
						<span class="inline-block h-1.5 w-1.5 rounded-full bg-primary-500" aria-hidden="true"></span>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	return;
}
?>

<section class="py-16 md:py-20 bg-surface border-y border-[rgb(0_12_26_/_0.06)]" data-client-logos>
	<div class="container-x">
		<?php if ( $args['eyebrow'] ) : ?>
			<p class="type-label text-center mb-10"><?php echo esc_html( $args['eyebrow'] ); ?></p>
		<?php endif; ?>

		<div class="flex flex-wrap items-center justify-center gap-x-12 gap-y-8 opacity-60">
			<?php foreach ( $args['logos'] as $logo ) : ?>
				<div class="h-8 md:h-10 flex items-center">
					<?php if ( ! empty( $logo['url'] ) ) : ?>
						<img
							src="<?php echo esc_url( $logo['url'] ); ?>"
							alt="<?php echo esc_attr( $logo['alt'] ?? '' ); ?>"
							class="max-h-full w-auto grayscale hover:grayscale-0 transition-[filter] duration-300"
							loading="lazy"
						>
					<?php else : ?>
						<span class="text-muted type-label"><?php echo esc_html( $logo['alt'] ?? __( 'Logo', 'kastalabs' ) ); ?></span>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
