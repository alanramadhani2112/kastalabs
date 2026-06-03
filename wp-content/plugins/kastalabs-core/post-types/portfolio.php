<?php
/**
 * Portfolio post type.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'kastalabs_register_portfolio_post_type' );

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
