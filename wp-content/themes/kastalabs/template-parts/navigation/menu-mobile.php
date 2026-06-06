<?php
/**
 * Mobile navigation (drawer menu).
 *
 * Dipakai dalam header after toggle click.
 * Hidden by default with md:hidden + hidden attribute.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $theme_location Menu location (default: 'primary').
 *     @type string $fallback_cb    Fallback callback.
 *     @type string $cta_label      CTA button label.
 *     @type string $cta_url        CTA button URL.
 *     @type string $class          Additional CSS classes.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'theme_location' => 'primary',
		'fallback_cb'    => 'kastalabs_mobile_nav_fallback',
		'cta_label'      => '',
		'cta_url'        => '',
		'class'          => '',
	)
);
?>
<div class="site-mobile-menu md:hidden<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>" id="mobile-menu" data-mobile-menu hidden>
	<div class="container-x pb-6">
		<nav class="zoom-card bg-bg p-5" aria-label="<?php esc_attr_e( 'Mobile navigation', 'kastalabs' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => $args['theme_location'],
					'container'      => false,
					'menu_class'     => 'site-mobile-menu__list',
					'fallback_cb'    => $args['fallback_cb'],
					'depth'          => 1,
				)
			);
			?>
			<?php if ( $args['cta_label'] && $args['cta_url'] ) : ?>
				<?php
				get_template_part(
					'template-parts/ui/button',
					null,
					array(
						'label'   => $args['cta_label'],
						'url'     => $args['cta_url'],
						'variant' => 'primary',
						'class'   => 'mt-5 w-full justify-center',
					)
				);
				?>
			<?php endif; ?>
		</nav>
	</div>
</div>
