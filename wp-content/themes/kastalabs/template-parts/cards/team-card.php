<?php
/**
 * Team member card component.
 *
 * Dipakai di about page atau team section.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $name        Person name.
 *     @type string $role        Role/title.
 *     @type string $photo_url   Photo URL.
 *     @type string $bio         Short bio.
 *     @type array  $social      Array of { url, label } social links.
 *     @type string $variant     'default' | 'compact' (default: 'default').
 *     @type string $class       Additional CSS classes.
 *     @type bool   $data_reveal Wrap with data-reveal.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'name'        => '',
		'role'        => '',
		'photo_url'   => '',
		'bio'         => '',
		'social'      => array(),
		'variant'     => 'default',
		'class'       => '',
		'data_reveal' => false,
	)
);

$class = '';
if ( 'compact' === $args['variant'] ) {
	$class = 'flex items-center gap-4';
} else {
	$class = 'zoom-card zoom-card--soft overflow-hidden';
}
if ( $args['class'] ) {
	$class .= ' ' . $args['class'];
}

$reveal = $args['data_reveal'] ? ' data-reveal' : '';
?>
<div class="<?php echo esc_attr( trim( $class ) ); ?>"<?php echo $reveal; // phpcs:ignore ?>>
	<?php if ( $args['photo_url'] ) : ?>
		<div class="<?php echo 'compact' === $args['variant'] ? 'h-12 w-12 flex-none' : 'aspect-[4/5] overflow-hidden'; ?>">
			<img
				src="<?php echo esc_url( $args['photo_url'] ); ?>"
				alt="<?php echo esc_attr( $args['name'] ); ?>"
				class="h-full w-full object-cover"
				loading="lazy"
			>
		</div>
	<?php endif; ?>

	<?php if ( 'compact' === $args['variant'] ) : ?>
		<div>
			<h3 class="type-body-sm font-semibold"><?php echo esc_html( $args['name'] ); ?></h3>
			<p class="type-caption text-muted"><?php echo esc_html( $args['role'] ); ?></p>
		</div>
	<?php else : ?>
		<div class="p-6">
			<h3 class="type-h4"><?php echo esc_html( $args['name'] ); ?></h3>
			<p class="type-label text-primary-600 mt-1"><?php echo esc_html( $args['role'] ); ?></p>
			<?php if ( $args['bio'] ) : ?>
				<p class="type-body-sm text-muted mt-3"><?php echo esc_html( $args['bio'] ); ?></p>
			<?php endif; ?>
			<?php if ( $args['social'] ) : ?>
				<div class="mt-4 flex gap-3">
					<?php foreach ( $args['social'] as $s ) : ?>
						<?php
						get_template_part(
							'template-parts/ui/social-link',
							null,
							array(
								'url'       => $s['url'],
								'label'     => $s['label'] ?? '',
								'icon_only' => true,
								'variant'   => 'default',
							)
						);
						?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>
