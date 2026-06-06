<?php
/**
 * Footer navigation link list.
 *
 * Reusable footer menu column with heading + link list.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $title          Column heading.
 *     @type string $theme_location Menu location.
 *     @type string $fallback_cb    Fallback callback.
 *     @type string $class          Additional CSS classes.
 *     @type string $heading_class  Additional heading classes.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'title'          => __( 'Navigation', 'kastalabs' ),
		'theme_location' => 'footer',
		'fallback_cb'    => 'kasta_footer_nav_fallback',
		'class'          => '',
		'heading_class'  => 'text-white/55',
	)
);
?>
<nav class="<?php echo esc_attr( trim( $args['class'] ) ); ?>" aria-label="<?php echo esc_attr( $args['title'] ); ?>">
	<p class="type-label mb-4 <?php echo esc_attr( $args['heading_class'] ); ?>"><?php echo esc_html( $args['title'] ); ?></p>
	<?php
	wp_nav_menu(
		array(
			'theme_location' => $args['theme_location'],
			'container'      => false,
			'menu_class'     => 'type-body-sm flex flex-col gap-2',
			'fallback_cb'    => $args['fallback_cb'],
			'depth'          => 1,
		)
	);
	?>
</nav>
