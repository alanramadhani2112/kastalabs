<?php
/**
 * Social media link component.
 *
 * Single social link with optional icon. Digunakan di footer + contact sidebar + team cards.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $url       Link URL.
 *     @type string $label     Platform name (e.g., "Instagram").
 *     @type string $icon      Heroicon name. Auto-resolved dari label jika tidak di-set.
 *     @type bool   $icon_only Hanya tampilkan ikon, tanpa label (default: false).
 *     @type string $variant   'default' | 'muted' (default: 'default').
 *     @type string $class     Additional CSS classes.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'url'       => '',
		'label'     => '',
		'icon'      => '',
		'icon_only' => false,
		'variant'   => 'default',
		'class'     => '',
	)
);

if ( ! $args['url'] ) {
	return;
}

// Auto-resolve icon dari platform name
if ( ! $args['icon'] ) {
	$icon_map = array(
		'instagram' => 'camera',
		'linkedin'  => 'briefcase',
		'behance'   => 'beaker',
		'github'    => 'code-bracket',
		'twitter'   => 'chat-bubble-left',
		'facebook'  => 'user-group',
		'youtube'   => 'play',
		'dribbble'  => 'paint-brush',
		'tiktok'    => 'musical-note',
		'whatsapp'  => 'chat-bubble-bottom-center-text',
		'email'     => 'envelope',
	);
	$key      = strtolower( $args['label'] );
	$args['icon'] = $icon_map[ $key ] ?? 'link';
}

$variant_map = array(
	'default' => 'type-body-sm hover:text-primary-600 transition-colors',
	'muted'   => 'text-white/55 hover:text-white transition-colors',
);

$class  = 'inline-flex items-center gap-2';
$class .= ' ' . ( $variant_map[ $args['variant'] ] ?? $variant_map['default'] );
if ( $args['class'] ) {
	$class .= ' ' . $args['class'];
}

$aria = $args['label'] ? ' aria-label="' . esc_attr( $args['label'] ) . '"' : '';
?>
<a
	href="<?php echo esc_url( $args['url'] ); ?>"
	class="<?php echo esc_attr( $class ); ?>"
	target="_blank"
	rel="noopener noreferrer"
	<?php echo $aria; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
>
	<?php kasta_icon( $args['icon'], array( 'class' => 'w-4 h-4 flex-none' ) ); ?>
	<?php if ( ! $args['icon_only'] && $args['label'] ) : ?>
		<span><?php echo esc_html( $args['label'] ); ?></span>
	<?php endif; ?>
</a>
