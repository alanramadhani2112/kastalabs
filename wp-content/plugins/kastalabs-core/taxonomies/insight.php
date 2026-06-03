<?php
/**
 * Insight taxonomies.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'kastalabs_register_insight_taxonomies' );

/**
 * Register Insight taxonomies.
 */
function kastalabs_register_insight_taxonomies(): void {
	register_taxonomy(
		'insight_category',
		array( 'insight' ),
		array(
			'labels'            => array(
				'name'          => __( 'Insight Categories', 'kastalabs' ),
				'singular_name' => __( 'Insight Category', 'kastalabs' ),
				'menu_name'     => __( 'Categories', 'kastalabs' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array(
				'slug'       => 'insights/category',
				'with_front' => false,
			),
		)
	);

	register_taxonomy(
		'insight_tag',
		array( 'insight' ),
		array(
			'labels'            => array(
				'name'          => __( 'Insight Tags', 'kastalabs' ),
				'singular_name' => __( 'Insight Tag', 'kastalabs' ),
				'menu_name'     => __( 'Tags', 'kastalabs' ),
			),
			'public'            => true,
			'hierarchical'      => false,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array(
				'slug'       => 'insights/tag',
				'with_front' => false,
			),
		)
	);
}
