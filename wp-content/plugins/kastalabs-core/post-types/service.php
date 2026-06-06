<?php
/**
 * Service post type.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'kastalabs_register_service_post_type' );
add_filter( 'manage_service_posts_columns', 'kastalabs_service_admin_columns' );
add_action( 'manage_service_posts_custom_column', 'kastalabs_render_service_admin_column', 10, 2 );
add_filter( 'manage_edit-service_sortable_columns', 'kastalabs_service_sortable_columns' );
add_action( 'restrict_manage_posts', 'kastalabs_render_service_cta_filter' );
add_action( 'pre_get_posts', 'kastalabs_filter_service_admin_query' );

/**
 * Register Service CPT.
 */
function kastalabs_register_service_post_type(): void {
	register_post_type(
		'service',
		array(
			'labels'        => array(
				'name'          => __( 'Services', 'kastalabs' ),
				'singular_name' => __( 'Service', 'kastalabs' ),
				'menu_name'     => __( 'Services', 'kastalabs' ),
				'add_new_item'  => __( 'Add New Service', 'kastalabs' ),
				'edit_item'     => __( 'Edit Service', 'kastalabs' ),
				'new_item'      => __( 'New Service', 'kastalabs' ),
				'view_item'     => __( 'View Service', 'kastalabs' ),
				'search_items'  => __( 'Search Services', 'kastalabs' ),
				'not_found'     => __( 'No services found', 'kastalabs' ),
			),
			'public'        => true,
			'show_in_rest'  => true,
			'has_archive'   => false,
			'menu_position' => 6,
			'menu_icon'     => 'dashicons-admin-tools',
			'rewrite'       => array(
				'slug'       => 'services',
				'with_front' => false,
				'feeds'      => false,
			),
			'supports'      => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'revisions',
				'custom-fields',
				'page-attributes',
			),
		)
	);
}

/**
 * Customize Service list table columns for content review.
 */
function kastalabs_service_admin_columns( array $columns ): array {
	$new_columns = array(
		'cb'               => $columns['cb'] ?? '<input type="checkbox" />',
		'title'            => __( 'Service', 'kastalabs' ),
		'service_order'    => __( 'Order', 'kastalabs' ),
		'service_icon'     => __( 'Icon', 'kastalabs' ),
		'service_overview' => __( 'Overview', 'kastalabs' ),
		'service_cta'      => __( 'CTA', 'kastalabs' ),
	);

	foreach ( $columns as $key => $label ) {
		if ( in_array( $key, array( 'cb', 'title', 'date' ), true ) ) {
			continue;
		}

		$new_columns[ $key ] = $label;
	}

	$new_columns['date'] = $columns['date'] ?? __( 'Date', 'kastalabs' );

	return $new_columns;
}

/**
 * Render Service list table custom column values.
 */
function kastalabs_render_service_admin_column( string $column, int $post_id ): void {
	$value = match ( $column ) {
		'service_order'    => (string) get_post_field( 'menu_order', $post_id ),
		'service_icon'     => get_post_meta( $post_id, 'icon_label', true ),
		'service_overview' => get_post_meta( $post_id, 'overview', true ),
		'service_cta'      => get_post_meta( $post_id, 'cta_label', true ),
		default            => '',
	};

	if ( 'service_cta' === $column ) {
		$cta_url = (string) get_post_meta( $post_id, 'cta_url', true );
		if ( '' !== trim( (string) $value ) && '' !== trim( $cta_url ) ) {
			printf(
				'<a href="%s">%s</a>',
				esc_url( $cta_url ),
				esc_html( (string) $value )
			);
			return;
		}
	}

	if ( 'service_overview' === $column && '' !== trim( (string) $value ) ) {
		$value = wp_trim_words( wp_strip_all_tags( (string) $value ), 16 );
	}

	echo esc_html( '' !== trim( (string) $value ) ? (string) $value : '-' );
}

/**
 * Mark useful Service columns as sortable.
 */
function kastalabs_service_sortable_columns( array $columns ): array {
	$columns['service_order'] = 'menu_order';
	$columns['service_icon']  = 'service_icon';

	return $columns;
}

/**
 * Render a CTA completeness filter on the Service admin list table.
 */
function kastalabs_render_service_cta_filter( string $post_type ): void {
	if ( 'service' !== $post_type ) {
		return;
	}

	$current = isset( $_GET['service_cta_state'] ) ? sanitize_key( wp_unslash( $_GET['service_cta_state'] ) ) : '';
	?>
	<label class="screen-reader-text" for="kastalabs_service_cta_filter">
		<?php esc_html_e( 'Filter by service CTA state', 'kastalabs' ); ?>
	</label>
	<select id="kastalabs_service_cta_filter" name="service_cta_state">
		<option value=""><?php esc_html_e( 'All CTA states', 'kastalabs' ); ?></option>
		<option value="complete" <?php selected( $current, 'complete' ); ?>><?php esc_html_e( 'CTA complete', 'kastalabs' ); ?></option>
		<option value="missing" <?php selected( $current, 'missing' ); ?>><?php esc_html_e( 'CTA missing', 'kastalabs' ); ?></option>
	</select>
	<?php
}

/**
 * Apply Service admin filtering and sorting.
 */
function kastalabs_filter_service_admin_query( WP_Query $query ): void {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( 'service' !== $query->get( 'post_type' ) ) {
		return;
	}

	$cta_state = isset( $_GET['service_cta_state'] ) ? sanitize_key( wp_unslash( $_GET['service_cta_state'] ) ) : '';
	if ( 'complete' === $cta_state ) {
		$query->set(
			'meta_query',
			array(
				array(
					'key'     => 'cta_url',
					'value'   => '',
					'compare' => '!=',
				),
			)
		);
	}

	if ( 'missing' === $cta_state ) {
		$query->set(
			'meta_query',
			array(
				'relation' => 'OR',
				array(
					'key'     => 'cta_url',
					'value'   => '',
					'compare' => '=',
				),
				array(
					'key'     => 'cta_url',
					'compare' => 'NOT EXISTS',
				),
			)
		);
	}

	if ( 'service_icon' === $query->get( 'orderby' ) ) {
		$query->set( 'meta_key', 'icon_label' );
		$query->set( 'orderby', 'meta_value' );
	}
}
