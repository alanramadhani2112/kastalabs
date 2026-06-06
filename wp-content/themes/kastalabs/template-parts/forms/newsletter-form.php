<?php
/**
 * Newsletter signup form placeholder.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $placeholder Email input placeholder.
 *     @type string $cta_label   Submit button label.
 *     @type string $class       Additional CSS classes.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'placeholder' => __( 'Alamat email Anda', 'kastalabs' ),
		'cta_label'   => __( 'Subscribe', 'kastalabs' ),
		'class'       => '',
	)
);
?>
<form class="newsletter-form flex gap-3<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>" method="post">
	<label class="sr-only" for="nl-email"><?php esc_html_e( 'Email', 'kastalabs' ); ?></label>
	<input
		id="nl-email"
		class="form-control flex-1"
		name="email"
		type="email"
		placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"
		required
	>
	<button class="btn-primary flex-none" type="submit">
		<?php echo esc_html( $args['cta_label'] ); ?>
	</button>
</form>
