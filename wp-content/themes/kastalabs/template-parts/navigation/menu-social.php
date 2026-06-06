<?php
/**
 * Social media links list.
 *
 * Dipakai di footer + contact sidebar.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type array  $links      Array of { url, label } objects.
 *     @type string $heading    Column heading.
 *     @type string $variant    'default' | 'muted' | 'icon-only' (default: 'default').
 *     @type string $class      Additional CSS classes.
 *     @type string $heading_class Additional heading classes.
 *     @type string $gap        Gap between links (default: 'gap-2').
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'links'         => array(),
		'heading'       => __( 'Connect', 'kastalabs' ),
		'variant'       => 'default',
		'class'         => '',
		'heading_class' => 'text-white/55',
		'gap'           => 'gap-2',
	)
);

if ( empty( $args['links'] ) ) {
	return;
}
?>
<nav class="<?php echo esc_attr( trim( $args['class'] ) ); ?>" aria-label="<?php echo esc_attr( $args['heading'] ); ?>">
	<?php if ( $args['heading'] ) : ?>
		<p class="type-label mb-4 <?php echo esc_attr( $args['heading_class'] ); ?>"><?php echo esc_html( $args['heading'] ); ?></p>
	<?php endif; ?>
	<ul class="type-body-sm flex flex-col <?php echo esc_attr( $args['gap'] ); ?>">
		<?php foreach ( $args['links'] as $link ) : ?>
			<li>
				<?php
				get_template_part(
					'template-parts/ui/social-link',
					null,
					array(
						'url'       => $link['url'] ?? '',
						'label'     => $link['label'] ?? '',
						'variant'   => 'muted' === $args['variant'] ? 'muted' : 'default',
						'icon'      => $link['icon'] ?? '',
						'icon_only' => 'icon-only' === $args['variant'],
					)
				);
				?>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
