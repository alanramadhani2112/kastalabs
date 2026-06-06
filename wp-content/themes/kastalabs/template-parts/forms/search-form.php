<?php
/**
 * WordPress search form.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $placeholder Search placeholder.
 *     @type string $class       Additional CSS classes on form.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'placeholder' => __( 'Search…', 'kastalabs' ),
		'class'       => '',
	)
);
?>
<form
	role="search"
	method="get"
	class="search-form flex<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>"
	action="<?php echo esc_url( home_url( '/' ) ); ?>"
>
	<label class="sr-only" for="search-input"><?php esc_html_e( 'Search for:', 'kastalabs' ); ?></label>
	<input
		id="search-input"
		class="form-control flex-1 rounded-r-none"
		type="search"
		name="s"
		placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"
		value="<?php echo get_search_query(); ?>"
	>
	<button class="btn-primary rounded-l-none" type="submit">
		<?php kasta_icon( 'magnifying-glass', array( 'class' => 'w-4 h-4' ) ); ?>
		<span class="sr-only"><?php esc_html_e( 'Search', 'kastalabs' ); ?></span>
	</button>
</form>
