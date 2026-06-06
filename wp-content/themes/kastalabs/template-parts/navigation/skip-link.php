<?php
/**
 * Skip to content link.
 *
 * Accessibility helper: link pertama di halaman untuk skip ke main content.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $target Target element selector (default: '#main').
 *     @type string $label  Link text.
 *     @type string $class  Additional CSS classes.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'target' => '#main',
		'label'  => __( 'Lewati ke konten', 'kastalabs' ),
		'class'  => '',
	)
);
?>
<a
	class="skip-link<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>"
	href="<?php echo esc_attr( $args['target'] ); ?>"
>
	<?php echo esc_html( $args['label'] ); ?>
</a>
