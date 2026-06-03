<?php
/**
 * Taxonomies untuk CPT 'work'.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		register_taxonomy(
			'work_category',
			array( 'work' ),
			array(
				'labels'            => array(
					'name'          => __( 'Work Categories', 'kastalabs' ),
					'singular_name' => __( 'Work Category', 'kastalabs' ),
					'menu_name'     => __( 'Categories', 'kastalabs' ),
					'all_items'     => __( 'All Categories', 'kastalabs' ),
					'edit_item'     => __( 'Edit Category', 'kastalabs' ),
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
					'name'          => __( 'Work Tags', 'kastalabs' ),
					'singular_name' => __( 'Work Tag', 'kastalabs' ),
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
);