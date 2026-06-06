<?php
/**
 * Empty state placeholder.
 *
 * Dipakai ketika loop tidak mengembalikan hasil.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $message  Empty state message.
 *     @type string $icon     Heroicon name (optional).
 *     @type string $class    Additional CSS classes.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'message' => __( 'Belum ada konten.', 'kastalabs' ),
		'icon'    => '',
		'class'   => '',
	)
);
?>
<div class="zoom-card zoom-card--soft p-10 text-center<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>">
	<?php if ( $args['icon'] ) : ?>
		<div class="mb-4 text-muted">
			<?php kasta_icon( $args['icon'], array( 'class' => 'mx-auto h-10 w-10' ) ); ?>
		</div>
	<?php endif; ?>
	<p class="type-body text-muted"><?php echo esc_html( $args['message'] ); ?></p>
</div>
