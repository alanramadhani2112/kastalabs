<?php
/**
 * Testimonial card component.
 *
 * Dipakai di testimonial section atau single work page.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $quote       Testimonial quote text.
 *     @type string $name        Person name.
 *     @type string $role        Person role/company.
 *     @type string $avatar_url  Optional avatar image URL.
 *     @type string $variant     'default' | 'card' (default: 'default').
 *     @type string $class       Additional CSS classes.
 *     @type bool   $data_reveal Wrap with data-reveal.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'quote'       => '',
		'name'        => '',
		'role'        => '',
		'avatar_url'  => '',
		'variant'     => 'default',
		'class'       => '',
		'data_reveal' => false,
	)
);

$class = '';
if ( 'card' === $args['variant'] ) {
	$class = 'zoom-card zoom-card--soft p-6';
}
if ( $args['class'] ) {
	$class .= ' ' . $args['class'];
}

$reveal = $args['data_reveal'] ? ' data-reveal' : '';
?>
<blockquote class="<?php echo esc_attr( trim( $class ) ); ?>"<?php echo $reveal; // phpcs:ignore ?>>
	<div class="flex items-start gap-2 mb-4 text-primary-300" aria-hidden="true">
		<svg class="h-6 w-6 flex-none" fill="currentColor" viewBox="0 0 24 24"><path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311C9.591 11.69 11 13.264 11 15c0 1.933-1.567 3.5-3.5 3.5-1.301 0-2.398-.709-2.917-1.679ZM14.583 17.321C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311C19.591 11.69 21 13.264 21 15c0 1.933-1.567 3.5-3.5 3.5-1.301 0-2.398-.709-2.917-1.679Z"/></svg>
	</div>

	<p class="type-body text-fg">
		<?php echo esc_html( $args['quote'] ); ?>
	</p>

	<footer class="mt-5 flex items-center gap-3">
		<?php if ( $args['avatar_url'] ) : ?>
			<img
				src="<?php echo esc_url( $args['avatar_url'] ); ?>"
				alt=""
				class="h-10 w-10 rounded-full object-cover"
				loading="lazy"
			>
		<?php endif; ?>
		<div>
			<cite class="type-body-sm not-italic font-semibold block"><?php echo esc_html( $args['name'] ); ?></cite>
			<?php if ( $args['role'] ) : ?>
				<span class="type-caption text-muted"><?php echo esc_html( $args['role'] ); ?></span>
			<?php endif; ?>
		</div>
	</footer>
</blockquote>
