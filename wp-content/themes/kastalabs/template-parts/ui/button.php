<?php
/**
 * Button component.
 *
 * Variants: primary, secondary, ghost.
 * Opsional: icon sebelum/sesudah label.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $label       Button text.
 *     @type string $url         Button URL.
 *     @type string $variant     'primary' | 'secondary' | 'ghost' (default: 'primary').
 *     @type string $icon        Heroicon name (optional, ditaruh sebelum label).
 *     @type string $icon_after  Heroicon name (optional, ditaruh setelah label).
 *     @type string $class       Additional CSS classes.
 *     @type string $aria_label  aria-label attribute (defaults to label).
 *     @type string $target      Link target (_blank, etc).
 *     @type bool   $magnetic    Tambah data-magnetic attribute for hover effect.
 *     @type string $tag         'a' | 'button' (default: 'a').
 *     @type string $type        Button type: 'submit' | 'button' | 'reset' (default: 'submit' if tag=button).
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'label'      => '',
		'url'        => '#',
		'variant'    => 'primary',
		'icon'       => '',
		'icon_after' => '',
		'class'      => '',
		'aria_label' => '',
		'target'     => '',
		'magnetic'   => false,
		'tag'        => 'a',
		'type'       => 'submit',
	)
);

$variant_class = array(
	'primary'   => 'btn-primary',
	'secondary' => 'btn-secondary',
	'ghost'     => 'btn-ghost',
);

$btn_class = $variant_class[ $args['variant'] ] ?? 'btn-primary';
if ( $args['class'] ) {
	$btn_class .= ' ' . $args['class'];
}

$aria_label = $args['aria_label'] ?: $args['label'];

$target_attr = '';
if ( $args['target'] ) {
	$target_attr = ' target="' . esc_attr( $args['target'] ) . '" rel="noopener noreferrer"';
}

$magnetic_attr = $args['magnetic'] ? ' data-magnetic' : '';
$is_button      = 'button' === $args['tag'];

if ( $is_button ) :
	?>
<button
	type="<?php echo esc_attr( $args['type'] ); ?>"
	class="<?php echo esc_attr( $btn_class ); ?>"
	aria-label="<?php echo esc_attr( $aria_label ); ?>"
	<?php echo $magnetic_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
>
<?php else : ?>
<a
	href="<?php echo esc_url( $args['url'] ); ?>"
	class="<?php echo esc_attr( $btn_class ); ?>"
	aria-label="<?php echo esc_attr( $aria_label ); ?>"
	<?php echo $target_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php echo $magnetic_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
>
<?php endif; ?>
	<?php if ( $args['icon'] ) : ?>
		<?php kasta_icon( $args['icon'], array( 'class' => 'w-4 h-4' ) ); ?>
		<span class="ml-2"><?php echo esc_html( $args['label'] ); ?></span>
	<?php elseif ( $args['icon_after'] ) : ?>
		<span class="mr-2"><?php echo esc_html( $args['label'] ); ?></span>
		<?php kasta_icon( $args['icon_after'], array( 'class' => 'w-4 h-4' ) ); ?>
	<?php else : ?>
		<?php echo esc_html( $args['label'] ); ?>
	<?php endif; ?>
<?php if ( $is_button ) : ?>
</button>
<?php else : ?>
</a>
<?php endif; ?>
