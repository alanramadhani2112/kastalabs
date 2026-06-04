<?php
/**
 * Inquiry post type.
 *
 * Stores contact form submissions inside WordPress admin.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'kastalabs_register_inquiry_post_type' );
add_filter( 'manage_kasta_inquiry_posts_columns', 'kastalabs_inquiry_admin_columns' );
add_action( 'manage_kasta_inquiry_posts_custom_column', 'kastalabs_render_inquiry_admin_column', 10, 2 );

/**
 * Register private Inquiry CPT for contact submissions.
 */
function kastalabs_register_inquiry_post_type(): void {
	register_post_type(
		'kasta_inquiry',
		array(
			'labels'              => array(
				'name'          => __( 'Inquiries', 'kastalabs' ),
				'singular_name' => __( 'Inquiry', 'kastalabs' ),
				'menu_name'     => __( 'Inquiries', 'kastalabs' ),
				'edit_item'     => __( 'View Inquiry', 'kastalabs' ),
				'search_items'  => __( 'Search Inquiries', 'kastalabs' ),
				'not_found'     => __( 'No inquiries found', 'kastalabs' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => false,
			'menu_position'       => 8,
			'menu_icon'           => 'dashicons-email-alt2',
			'supports'            => array( 'title', 'editor', 'custom-fields' ),
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
		)
	);
}

/**
 * Customize Inquiry list table columns.
 */
function kastalabs_inquiry_admin_columns( array $columns ): array {
	return array(
		'cb'           => $columns['cb'] ?? '<input type="checkbox" />',
		'title'        => __( 'Inquiry', 'kastalabs' ),
		'inquiry_name' => __( 'Name', 'kastalabs' ),
		'email'        => __( 'Email', 'kastalabs' ),
		'project_type' => __( 'Project Type', 'kastalabs' ),
		'email_status' => __( 'Email Status', 'kastalabs' ),
		'date'         => $columns['date'] ?? __( 'Date', 'kastalabs' ),
	);
}

/**
 * Render Inquiry list table custom column values.
 */
function kastalabs_render_inquiry_admin_column( string $column, int $post_id ): void {
	$value = match ( $column ) {
		'inquiry_name' => get_post_meta( $post_id, 'inquiry_name', true ),
		'email'        => get_post_meta( $post_id, 'email', true ),
		'project_type' => get_post_meta( $post_id, 'project_type', true ),
		'email_status' => get_post_meta( $post_id, 'email_status', true ),
		default        => '',
	};

	if ( 'email' === $column && $value ) {
		printf(
			'<a href="%s">%s</a>',
			esc_url( 'mailto:' . $value ),
			esc_html( $value )
		);
		return;
	}

	echo esc_html( $value ?: '-' );
}
