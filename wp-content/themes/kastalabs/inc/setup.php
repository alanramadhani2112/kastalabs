<?php
/**
 * Theme setup: theme support, nav menus, image sizes.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	function () {
		// Title tag dikelola WordPress.
		add_theme_support( 'title-tag' );

		// Featured image.
		add_theme_support( 'post-thumbnails' );

		// HTML5 markup.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

		// Block editor support.
		add_theme_support( 'editor-styles' );
		add_editor_style( 'dist/editor.css' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'wp-block-styles' );

		// Custom logo.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 80,
				'width'       => 240,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		// Internationalization.
		load_theme_textdomain( 'kastalabs', __DIR__ . '/../languages' );

		// Nav menus.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Navigation', 'kastalabs' ),
				'footer'  => __( 'Footer Navigation', 'kastalabs' ),
				'social'  => __( 'Social Links', 'kastalabs' ),
			)
		);

		// Image sizes.
		add_image_size( 'kasta-cover', 1920, 1080, true );
		add_image_size( 'kasta-card', 960, 720, true );
		add_image_size( 'kasta-thumb', 480, 360, true );
	}
);

/**
 * Body class kustom — terutama data-page selector untuk JS lazy-load.
 */
add_filter(
	'body_class',
	function ( $classes ) {
		// (kept minimal at M1; halaman-spesifik class ditambahkan di M2)
		return $classes;
	}
);

/**
 * Flush rewrite rules saat theme di-activate (CPT baru perlu rewrite refresh).
 */
add_action(
	'after_switch_theme',
	function () {
		flush_rewrite_rules();
	}
);