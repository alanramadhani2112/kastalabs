<?php
/**
 * Mega menu dropdown — full-width dropdown panel.
 *
 * Digunakan untuk Services dan Portfolio sub-menu.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $id      Unique ID for this dropdown (required).
 *     @type string $title   Dropdown title / eyebrow.
 *     @type array  $columns Array of column arrays, each with { icon, title, desc, url }.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'id'      => '',
		'title'   => '',
		'columns' => array(),
	)
);
?>
<div
	class="mega-panel"
	id="mega-<?php echo esc_attr( $args['id'] ); ?>"
	data-mega-panel
	data-mega-trigger="mega-trigger-<?php echo esc_attr( $args['id'] ); ?>"
	role="region"
	aria-hidden="true"
	hidden
>
	<div class="container-x">
		<div class="zoom-card bg-bg p-10">
			<div class="grid gap-8 md:grid-cols-<?php echo min( count( $args['columns'] ), 4 ); ?>">
				<?php foreach ( $args['columns'] as $col ) : ?>
					<a
						href="<?php echo esc_url( $col['url'] ?? '#' ); ?>"
						class="group block rounded-xl p-5 -mx-2 transition-colors hover:bg-surface"
					>
						<?php if ( ! empty( $col['icon'] ) ) : ?>
							<div class="mb-4 grid h-10 w-10 place-items-center rounded-lg bg-primary-500/10 text-primary-600">
								<?php kasta_icon( $col['icon'], array( 'class' => 'w-5 h-5' ) ); ?>
							</div>
						<?php endif; ?>
						<p class="type-h4 group-hover:text-primary-600 transition-colors">
							<?php echo esc_html( $col['title'] ?? '' ); ?>
						</p>
						<?php if ( ! empty( $col['desc'] ) ) : ?>
							<p class="type-body-sm text-muted mt-2">
								<?php echo esc_html( $col['desc'] ); ?>
							</p>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
