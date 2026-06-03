<?php
/**
 * Insight post type.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'kastalabs_register_insight_post_type' );

/**
 * Register Insight CPT.
 */
function kastalabs_register_insight_post_type(): void {
	register_post_type(
		'insight',
		array(
			'labels'              => array(
				'name'                  => __( 'Insights', 'kastalabs' ),
				'singular_name'         => __( 'Insight', 'kastalabs' ),
				'menu_name'             => __( 'Insights', 'kastalabs' ),
				'add_new_item'          => __( 'Add New Insight', 'kastalabs' ),
				'edit_item'             => __( 'Edit Insight', 'kastalabs' ),
				'new_item'              => __( 'New Insight', 'kastalabs' ),
				'view_item'             => __( 'View Insight', 'kastalabs' ),
				'search_items'          => __( 'Search Insights', 'kastalabs' ),
				'not_found'             => __( 'No insights found', 'kastalabs' ),
				'featured_image'        => __( 'Insight Cover', 'kastalabs' ),
				'set_featured_image'    => __( 'Set insight cover', 'kastalabs' ),
				'remove_featured_image' => __( 'Remove insight cover', 'kastalabs' ),
				'use_featured_image'    => __( 'Use as insight cover', 'kastalabs' ),
			),
			'public'              => true,
			'show_in_rest'        => true,
			'has_archive'         => 'insights',
			'menu_position'       => 7,
			'menu_icon'           => 'dashicons-welcome-write-blog',
			'rewrite'             => array(
				'slug'       => 'insights',
				'with_front' => false,
				'feeds'      => true,
			),
			'supports'            => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'author',
				'revisions',
				'custom-fields',
			),
			'exclude_from_search' => false,
		)
	);
}
