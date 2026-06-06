<?php
/**
 * Section wrapper component.
 *
 * Standard section container: padding + background + container-x.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $bg         Background: 'bg' | 'surface' | 'navy' | 'none' (default: 'bg').
 *     @type string $padding    Padding classes (default: 'py-24 md:py-32').
 *     @type string $class      Additional CSS classes on section.
 *     @type string $data_attr  Data attribute name (e.g., 'work-grid') — adds data-{name}.
 *     @type string $id         HTML id attribute.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'bg'        => 'bg',
		'padding'   => 'py-24 md:py-32',
		'class'     => '',
		'data_attr' => '',
		'id'        => '',
	)
);

$bg_map = array(
	'bg'      => 'bg-bg',
	'surface' => 'bg-surface',
	'navy'    => 'bg-navy text-white',
	'none'    => '',
);

$class  = $args['padding'];
$class .= ' ' . ( $bg_map[ $args['bg'] ] ?? 'bg-bg' );
if ( $args['class'] ) {
	$class .= ' ' . $args['class'];
}

$data_attr_html = $args['data_attr'] ? ' data-' . esc_attr( $args['data_attr'] ) : '';
$id_attr        = $args['id'] ? ' id="' . esc_attr( $args['id'] ) . '"' : '';
?>
<section class="<?php echo esc_attr( trim( $class ) ); ?>"<?php echo $id_attr . $data_attr_html; // phpcs:ignore ?>>
	<div class="container-x">
		<?php
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $args['content'] ?? '';
		?>
	</div>
</section>
