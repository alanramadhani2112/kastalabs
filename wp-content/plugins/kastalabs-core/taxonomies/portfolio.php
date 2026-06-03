<?php
/**
 * Portfolio taxonomies.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'kastalabs_register_portfolio_taxonomies' );

/**
 * Register Portfolio and legacy Work taxonomies.
 */
function kastalabs_register_portfolio_taxonomies(): void {
	register_taxonomy(
		'portfolio_category',
		array( 'portfolio' ),
		array(
			'labels'            => array(
				'name'          => __( 'Portfolio Categories', 'kastalabs' ),
				'singular_name' => __( 'Portfolio Category', 'kastalabs' ),
				'menu_name'     => __( 'Categories', 'kastalabs' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array(
				'slug'       => 'portfolio/category',
				'with_front' => false,
			),
		)
	);

	register_taxonomy(
		'portfolio_tag',
		array( 'portfolio' ),
		array(
			'labels'            => array(
				'name'          => __( 'Portfolio Tags', 'kastalabs' ),
				'singular_name' => __( 'Portfolio Tag', 'kastalabs' ),
				'menu_name'     => __( 'Tags', 'kastalabs' ),
			),
			'public'            => true,
			'hierarchical'      => false,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array(
				'slug'       => 'portfolio/tag',
				'with_front' => false,
			),
		)
	);

	register_taxonomy(
		'work_category',
		array( 'work' ),
		array(
			'labels'            => array(
				'name'          => __( 'Legacy Work Categories', 'kastalabs' ),
				'singular_name' => __( 'Legacy Work Category', 'kastalabs' ),
				'menu_name'     => __( 'Categories', 'kastalabs' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array(
				'slug'       => 'work/category',
				'with_front' => false,
			),
		)
	);

	register_taxonomy(
		'work_tag',
		array( 'work' ),
		array(
			'labels'            => array(
				'name'          => __( 'Legacy Work Tags', 'kastalabs' ),
				'singular_name' => __( 'Legacy Work Tag', 'kastalabs' ),
				'menu_name'     => __( 'Tags', 'kastalabs' ),
			),
			'public'            => true,
			'hierarchical'      => false,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array(
				'slug'       => 'work/tag',
				'with_front' => false,
			),
		)
	);
}
