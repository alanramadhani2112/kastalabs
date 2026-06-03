<?php
/**
 * KastaLabs theme bootstrap.
 *
 * Setiap concern di-load dari /inc supaya file ini tetap tipis.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'KASTA_VERSION' ) ) {
	define( 'KASTA_VERSION', '0.1.0' );
}
if ( ! defined( 'KASTA_THEME_PATH' ) ) {
	define( 'KASTA_THEME_PATH', __DIR__ );
}
if ( ! defined( 'KASTA_THEME_URI' ) ) {
	define( 'KASTA_THEME_URI', get_template_directory_uri() );
}
if ( ! defined( 'KASTA_VITE_DEV' ) ) {
	// Bisa di-set di wp-config.php untuk pakai Vite dev server. Default: off.
	define( 'KASTA_VITE_DEV', false );
}

require_once __DIR__ . '/inc/setup.php';
require_once __DIR__ . '/inc/enqueue.php';
require_once __DIR__ . '/inc/post-types.php';
require_once __DIR__ . '/inc/taxonomies.php';
require_once __DIR__ . '/inc/meta.php';
require_once __DIR__ . '/inc/seo.php';
require_once __DIR__ . '/inc/contact.php';
require_once __DIR__ . '/inc/template-tags.php';
