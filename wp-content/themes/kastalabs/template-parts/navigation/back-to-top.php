<?php
/**
 * Back to top button.
 *
 * Fixed button yang muncul setelah scroll tertentu.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $label   Button label / ARIA label.
 *     @type string $class   Additional CSS classes.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'label' => __( 'Kembali ke atas', 'kastalabs' ),
		'class' => '',
	)
);
?>
<button
	class="back-to-top<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>"
	aria-label="<?php echo esc_attr( $args['label'] ); ?>"
	type="button"
	data-back-to-top
>
	<?php kasta_icon( 'chevron-up', array( 'class' => 'w-5 h-5' ) ); ?>
</button>
