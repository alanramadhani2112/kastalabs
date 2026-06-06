<?php
/**
 * Portfolio post type.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'kastalabs_register_portfolio_post_type' );
add_filter( 'manage_portfolio_posts_columns', 'kastalabs_portfolio_admin_columns' );
add_action( 'manage_portfolio_posts_custom_column', 'kastalabs_render_portfolio_admin_column', 10, 2 );
add_filter( 'manage_edit-portfolio_sortable_columns', 'kastalabs_portfolio_sortable_columns' );
add_action( 'restrict_manage_posts', 'kastalabs_render_portfolio_featured_filter' );
add_action( 'pre_get_posts', 'kastalabs_filter_portfolio_admin_query' );

/**
 * Register Portfolio CPT.
 */
function kastalabs_register_portfolio_post_type(): void {
	register_post_type(
		'portfolio',
		array(
			'labels'              => array(
				'name'                  => __( 'Portfolio', 'kastalabs' ),
				'singular_name'         => __( 'Portfolio Project', 'kastalabs' ),
				'menu_name'             => __( 'Portfolio', 'kastalabs' ),
				'add_new_item'          => __( 'Add New Portfolio Project', 'kastalabs' ),
				'edit_item'             => __( 'Edit Portfolio Project', 'kastalabs' ),
				'new_item'              => __( 'New Portfolio Project', 'kastalabs' ),
				'view_item'             => __( 'View Portfolio Project', 'kastalabs' ),
				'search_items'          => __( 'Search Portfolio', 'kastalabs' ),
				'not_found'             => __( 'No portfolio projects found', 'kastalabs' ),
				'featured_image'        => __( 'Project Cover', 'kastalabs' ),
				'set_featured_image'    => __( 'Set project cover', 'kastalabs' ),
				'remove_featured_image' => __( 'Remove project cover', 'kastalabs' ),
				'use_featured_image'    => __( 'Use as project cover', 'kastalabs' ),
			),
			'public'              => true,
			'show_in_rest'        => true,
			'has_archive'         => 'portfolio',
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-portfolio',
			'rewrite'             => array(
				'slug'       => 'portfolio',
				'with_front' => false,
				'feeds'      => false,
			),
			'supports'            => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'revisions',
				'custom-fields',
				'page-attributes',
			),
			'exclude_from_search' => false,
		)
	);
}

/**
 * Customize Portfolio list table columns for faster CMS review.
 */
function kastalabs_portfolio_admin_columns( array $columns ): array {
	$new_columns = array(
		'cb'                 => $columns['cb'] ?? '<input type="checkbox" />',
		'title'              => __( 'Project', 'kastalabs' ),
		'portfolio_client'   => __( 'Client', 'kastalabs' ),
		'portfolio_year'     => __( 'Year', 'kastalabs' ),
		'portfolio_scope'    => __( 'Scope', 'kastalabs' ),
		'portfolio_featured' => __( 'Featured', 'kastalabs' ),
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
 * Render Portfolio list table custom column values.
 */
function kastalabs_render_portfolio_admin_column( string $column, int $post_id ): void {
	$value = match ( $column ) {
		'portfolio_client'   => get_post_meta( $post_id, 'client_name', true ),
		'portfolio_year'     => get_post_meta( $post_id, 'project_year', true ),
		'portfolio_scope'    => get_post_meta( $post_id, 'scope', true ),
		'portfolio_featured' => get_post_meta( $post_id, 'is_featured', true ) ? __( 'Yes', 'kastalabs' ) : __( 'No', 'kastalabs' ),
		default              => '',
	};

	echo esc_html( $value ?: '-' );
}

/**
 * Mark useful Portfolio columns as sortable.
 */
function kastalabs_portfolio_sortable_columns( array $columns ): array {
	$columns['portfolio_year']     = 'portfolio_year';
	$columns['portfolio_featured'] = 'portfolio_featured';

	return $columns;
}

/**
 * Render a Featured filter on the Portfolio admin list table.
 */
function kastalabs_render_portfolio_featured_filter( string $post_type ): void {
	if ( 'portfolio' !== $post_type ) {
		return;
	}

	$current = isset( $_GET['portfolio_featured'] ) ? sanitize_key( wp_unslash( $_GET['portfolio_featured'] ) ) : '';
	?>
	<label class="screen-reader-text" for="kastalabs_portfolio_featured_filter">
		<?php esc_html_e( 'Filter by featured status', 'kastalabs' ); ?>
	</label>
	<select id="kastalabs_portfolio_featured_filter" name="portfolio_featured">
		<option value=""><?php esc_html_e( 'All featured states', 'kastalabs' ); ?></option>
		<option value="1" <?php selected( $current, '1' ); ?>><?php esc_html_e( 'Featured only', 'kastalabs' ); ?></option>
		<option value="0" <?php selected( $current, '0' ); ?>><?php esc_html_e( 'Not featured', 'kastalabs' ); ?></option>
	</select>
	<?php
}

/**
 * Apply Portfolio admin filtering and sorting.
 */
function kastalabs_filter_portfolio_admin_query( WP_Query $query ): void {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	$post_type = $query->get( 'post_type' );
	if ( 'portfolio' !== $post_type ) {
		return;
	}

	$featured = isset( $_GET['portfolio_featured'] ) ? sanitize_key( wp_unslash( $_GET['portfolio_featured'] ) ) : '';
	if ( '1' === $featured ) {
		$meta_query   = (array) $query->get( 'meta_query' );
		$meta_query[] = array(
			'key'     => 'is_featured',
			'value'   => '1',
			'compare' => '=',
		);
		$query->set( 'meta_query', $meta_query );
	}

	if ( '0' === $featured ) {
		$meta_query   = (array) $query->get( 'meta_query' );
		$meta_query[] = array(
			'relation' => 'OR',
			array(
				'key'     => 'is_featured',
				'value'   => '1',
				'compare' => '!=',
			),
			array(
				'key'     => 'is_featured',
				'compare' => 'NOT EXISTS',
			),
		);
		$query->set( 'meta_query', $meta_query );
	}

	$orderby = $query->get( 'orderby' );
	if ( 'portfolio_year' === $orderby ) {
		$query->set( 'meta_key', 'project_year' );
		$query->set( 'orderby', 'meta_value_num' );
	}

	if ( 'portfolio_featured' === $orderby ) {
		$query->set( 'meta_key', 'is_featured' );
		$query->set( 'orderby', 'meta_value_num' );
	}
}
