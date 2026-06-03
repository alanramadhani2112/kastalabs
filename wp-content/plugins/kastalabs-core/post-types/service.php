<?php
/**
 * Service post type.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'kastalabs_register_service_post_type' );

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
