<?php
/**
 * Primary desktop navigation.
 *
 * Reusable desktop menu. Fallback ke kastalabs_primary_nav_fallback() jika menu belum di-set.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $theme_location Menu location (default: 'primary').
 *     @type string $menu_class     CSS class for ul element.
 *     @type string $fallback_cb    Fallback callback function name.
 *     @type string $class          Additional CSS on nav wrapper.
 *     @type bool   $hidden_mobile  Hide on mobile with md:hidden? (default: true).
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'theme_location' => 'primary',
		'menu_class'     => 'type-body-sm flex items-center gap-8',
		'fallback_cb'    => 'kastalabs_primary_nav_fallback',
		'class'          => '',
		'hidden_mobile'  => true,
	)
);

$nav_class  = 'site-nav';
$nav_class .= $args['hidden_mobile'] ? ' hidden md:block' : '';
if ( $args['class'] ) {
	$nav_class .= ' ' . $args['class'];
}
?>
<nav class="<?php echo esc_attr( $nav_class ); ?>" aria-label="<?php esc_attr_e( 'Primary navigation', 'kastalabs' ); ?>">
	<?php
	wp_nav_menu(
		array(
			'theme_location' => $args['theme_location'],
			'container'      => false,
			'menu_class'     => $args['menu_class'],
			'fallback_cb'    => $args['fallback_cb'],
			'depth'          => 1,
		)
	);
	?>
</nav>
