<?php
/**
 * Legacy Work post type.
 *
 * Kept temporarily so existing /work/ routes and dummy content do not break
 * while the project migrates to the final Portfolio content model.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'kastalabs_register_legacy_work_post_type' );

/**
 * Register legacy Work CPT.
 */
function kastalabs_register_legacy_work_post_type(): void {
	register_post_type(
		'work',
		array(
			'labels'              => array(
				'name'                  => __( 'Work (Legacy)', 'kastalabs' ),
				'singular_name'         => __( 'Legacy Case Study', 'kastalabs' ),
				'menu_name'             => __( 'Work (Legacy)', 'kastalabs' ),
				'add_new_item'          => __( 'Add New Legacy Case Study', 'kastalabs' ),
				'edit_item'             => __( 'Edit Legacy Case Study', 'kastalabs' ),
				'view_item'             => __( 'View Legacy Case Study', 'kastalabs' ),
				'search_items'          => __( 'Search Legacy Work', 'kastalabs' ),
				'not_found'             => __( 'No legacy case studies found', 'kastalabs' ),
				'featured_image'        => __( 'Cover Image', 'kastalabs' ),
				'set_featured_image'    => __( 'Set cover image', 'kastalabs' ),
				'remove_featured_image' => __( 'Remove cover image', 'kastalabs' ),
				'use_featured_image'    => __( 'Use as cover image', 'kastalabs' ),
			),
			'public'              => true,
			'show_in_rest'        => true,
			'has_archive'         => 'work',
			'menu_position'       => 25,
			'menu_icon'           => 'dashicons-migrate',
			'rewrite'             => array(
				'slug'       => 'work',
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
