<?php
/**
 * Breadcrumb navigation.
 *
 * SEO-friendly breadcrumb trail. Mendukung Yoast SEO, Rank Math, atau fallback sederhana.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $class    Additional CSS classes.
 *     @type string $home_label Label for home link.
 *     @type string $separator Separator character or icon name.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'class'      => '',
		'home_label' => __( 'Home', 'kastalabs' ),
		'separator'  => 'chevron-right',
	)
);

// Gunakan Yoast / Rank Math breadcrumb kalau tersedia
if ( function_exists( 'yoast_breadcrumb' ) ) {
	yoast_breadcrumb( '<nav class="' . esc_attr( 'breadcrumb py-4 ' . $args['class'] ) . '" aria-label="Breadcrumb">', '</nav>' );
	return;
}

if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
	echo '<nav class="' . esc_attr( 'breadcrumb py-4 ' . $args['class'] ) . '" aria-label="Breadcrumb">';
	rank_math_the_breadcrumbs();
	echo '</nav>';
	return;
}

// Fallback sederhana
$items   = array();
$items[] = array(
	'url'   => home_url( '/' ),
	'label' => $args['home_label'],
);

if ( is_singular() ) {
	$post_type = get_post_type();
	if ( 'post' !== $post_type ) {
		$obj = get_post_type_object( $post_type );
		if ( $obj && $obj->has_archive ) {
			$items[] = array(
				'url'   => get_post_type_archive_link( $post_type ),
				'label' => $obj->labels->name,
			);
		}
	}
	$items[] = array(
		'url'   => '',
		'label' => get_the_title(),
	);
} elseif ( is_post_type_archive() ) {
	$obj = get_queried_object();
	if ( $obj ) {
		$items[] = array(
			'url'   => '',
			'label' => $obj->labels->name,
		);
	}
} elseif ( is_archive() || is_search() ) {
	$items[] = array(
		'url'   => '',
		'label' => get_the_archive_title(),
	);
}
?>
<nav class="breadcrumb type-body-sm py-4 text-muted<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>" aria-label="<?php esc_attr_e( 'Breadcrumb', 'kastalabs' ); ?>">
	<ol class="flex flex-wrap items-center gap-2">
		<?php foreach ( $items as $i => $item ) : ?>
			<?php if ( $i > 0 ) : ?>
				<li class="flex-none text-muted/50" aria-hidden="true">
					<?php kasta_icon( $args['separator'], array( 'class' => 'w-3.5 h-3.5' ) ); ?>
				</li>
			<?php endif; ?>
			<li>
				<?php if ( $item['url'] ) : ?>
					<a href="<?php echo esc_url( $item['url'] ); ?>" class="hover:text-primary-600 transition-colors"><?php echo esc_html( $item['label'] ); ?></a>
				<?php else : ?>
					<span class="text-fg"><?php echo esc_html( $item['label'] ); ?></span>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ol>
</nav>
