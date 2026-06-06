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
	__( 'Branding Design', 'kastalabs' ),
	__( 'UI/UX Design', 'kastalabs' ),
	__( 'Web Development', 'kastalabs' ),
	__( 'Custom Software', 'kastalabs' ),
	__( 'Strategy', 'kastalabs' ),
	__( 'Visual Systems', 'kastalabs' ),
	__( 'Digital Products', 'kastalabs' ),
	__( 'Motion Direction', 'kastalabs' ),
);
?>

<section class="py-10 bg-bg overflow-hidden" aria-label="<?php esc_attr_e( 'Kapabilitas Kastalabs', 'kastalabs' ); ?>">
	<div class="marquee-track hover:[animation-play-state:paused]" style="--marquee-speed: 40s;">
		<div class="marquee-content flex items-center gap-12">
			<?php foreach ( $items as $item ) : ?>
				<span class="type-label text-muted whitespace-nowrap flex items-center gap-12">
					<?php echo esc_html( $item ); ?>
					<span class="inline-block h-1.5 w-1.5 rounded-full bg-primary-500" aria-hidden="true"></span>
				</span>
			<?php endforeach; ?>
			<?php foreach ( $items as $item ) : ?>
				<span class="type-label text-muted whitespace-nowrap flex items-center gap-12" aria-hidden="true">
					<?php echo esc_html( $item ); ?>
					<span class="inline-block h-1.5 w-1.5 rounded-full bg-primary-500"></span>
				</span>
			<?php endforeach; ?>
		</div>
	</div>
</section>
