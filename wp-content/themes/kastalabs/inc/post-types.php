<?php
/**
 * Custom post types: 'work' (portfolio).
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		register_post_type(
			'work',
			array(
				'labels'              => array(
					'name'                  => __( 'Work', 'kastalabs' ),
					'singular_name'         => __( 'Case Study', 'kastalabs' ),
					'menu_name'             => __( 'Work', 'kastalabs' ),
					'add_new'               => __( 'Add New', 'kastalabs' ),
					'add_new_item'          => __( 'Add New Case Study', 'kastalabs' ),
					'edit_item'             => __( 'Edit Case Study', 'kastalabs' ),
					'new_item'              => __( 'New Case Study', 'kastalabs' ),
					'view_item'             => __( 'View Case Study', 'kastalabs' ),
					'search_items'          => __( 'Search Work', 'kastalabs' ),
					'not_found'             => __( 'No case studies found', 'kastalabs' ),
					'not_found_in_trash'    => __( 'No case studies in trash', 'kastalabs' ),
					'featured_image'        => __( 'Cover Image', 'kastalabs' ),
					'set_featured_image'    => __( 'Set cover image', 'kastalabs' ),
					'remove_featured_image' => __( 'Remove cover image', 'kastalabs' ),
					'use_featured_image'    => __( 'Use as cover image', 'kastalabs' ),
				),
				'public'              => true,
				'show_in_rest'        => true,
				'has_archive'         => 'work',
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-portfolio',
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
);