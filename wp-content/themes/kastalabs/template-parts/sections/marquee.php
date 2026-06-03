<?php
/**
 * Brand marquee / ticker section.
 *
 * Infinite scrolling ticker with brand capabilities or client names.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$items = array(
	__( 'Brand Strategy', 'kastalabs' ),
	__( 'Visual Identity', 'kastalabs' ),
	__( 'Website Design', 'kastalabs' ),
	__( 'WordPress Development', 'kastalabs' ),
	__( 'Content System', 'kastalabs' ),
	__( 'Motion Direction', 'kastalabs' ),
	__( 'Creative Direction', 'kastalabs' ),
	__( 'SEO Foundation', 'kastalabs' ),
);
?>

<section class="py-12 border-y border-white/8 overflow-hidden" aria-label="<?php esc_attr_e( 'Kapabilitas KastaLabs', 'kastalabs' ); ?>">
	<div data-marquee data-marquee-speed="40" data-marquee-pause-hover>
		<div data-marquee-track class="flex items-center gap-12">
			<?php foreach ( $items as $item ) : ?>
				<span class="text-2xl md:text-3xl lg:text-4xl font-display font-bold text-fg/20 whitespace-nowrap flex items-center gap-12">
					<?php echo esc_html( $item ); ?>
					<span class="inline-block w-2 h-2 rounded-full bg-primary-500" aria-hidden="true"></span>
				</span>
			<?php endforeach; ?>
		</div>
	</div>
</section>
