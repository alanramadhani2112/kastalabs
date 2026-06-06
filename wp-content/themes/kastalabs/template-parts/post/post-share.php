<?php
/**
 * Social share buttons.
 *
 * Tombol share ke platform sosial media.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $url          URL to share (default: current permalink).
 *     @type string $title        Title to share (default: post title).
 *     @type array  $platforms    Array of platform keys: 'twitter', 'linkedin', 'facebook', 'whatsapp', 'telegram', 'email'.
 *     @type bool   $show_label   Show platform label? (default: false).
 *     @type string $class        Additional CSS classes.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'url'        => get_permalink(),
		'title'      => get_the_title(),
		'platforms'  => array( 'twitter', 'linkedin', 'whatsapp' ),
		'show_label' => false,
		'class'      => '',
	)
);

$encoded_url   = rawurlencode( $args['url'] );
$encoded_title = rawurlencode( $args['title'] );

$platforms = array(
	'twitter'   => array(
		'url'   => 'https://x.com/intent/post?url=' . $encoded_url . '&text=' . $encoded_title,
		'label' => 'X / Twitter',
		'icon'  => 'chat-bubble-left',
	),
	'linkedin'  => array(
		'url'   => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $encoded_url,
		'label' => 'LinkedIn',
		'icon'  => 'briefcase',
	),
	'facebook'  => array(
		'url'   => 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_url,
		'label' => 'Facebook',
		'icon'  => 'user-group',
	),
	'whatsapp'  => array(
		'url'   => 'https://wa.me/?text=' . $encoded_title . '%20' . $encoded_url,
		'label' => 'WhatsApp',
		'icon'  => 'chat-bubble-bottom-center-text',
	),
	'telegram'  => array(
		'url'   => 'https://t.me/share/url?url=' . $encoded_url . '&text=' . $encoded_title,
		'label' => 'Telegram',
		'icon'  => 'paper-airplane',
	),
	'email'     => array(
		'url'   => 'mailto:?subject=' . $encoded_title . '&body=' . $encoded_url,
		'label' => 'Email',
		'icon'  => 'envelope',
	),
);
?>
<div class="post-share flex items-center gap-3<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>">
	<span class="type-label text-muted mr-1"><?php esc_html_e( 'Share', 'kastalabs' ); ?></span>
	<?php foreach ( $args['platforms'] as $key ) : ?>
		<?php if ( ! isset( $platforms[ $key ] ) ) continue; ?>
		<?php $p = $platforms[ $key ]; ?>
		<a
			href="<?php echo esc_url( $p['url'] ); ?>"
			class="grid h-9 w-9 place-items-center rounded-full bg-surface text-muted hover:bg-primary-100 hover:text-primary-600 transition-colors"
			target="_blank"
			rel="noopener noreferrer"
			aria-label="<?php echo esc_attr( sprintf( __( 'Share via %s', 'kastalabs' ), $p['label'] ) ); ?>"
		>
			<?php kasta_icon( $p['icon'], array( 'class' => 'w-4 h-4' ) ); ?>
			<?php if ( $args['show_label'] ) : ?>
				<span class="sr-only"><?php echo esc_html( $p['label'] ); ?></span>
			<?php endif; ?>
		</a>
	<?php endforeach; ?>
</div>
