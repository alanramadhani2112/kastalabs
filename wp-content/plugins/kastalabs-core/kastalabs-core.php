<?php
/**
 * Plugin Name:       Kastalabs Core
 * Plugin URI:        https://kastalabs.com
 * Description:       Core CMS layer for Kastalabs: post types, taxonomies, meta fields, contact handling, and migration helpers.
 * Version:           0.1.0
 * Author:            Kastalabs
 * Author URI:        https://kastalabs.com
 * License:           Proprietary
 * Text Domain:       kastalabs
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'KASTALABS_CORE_VERSION' ) ) {
	define( 'KASTALABS_CORE_VERSION', '0.1.0' );
}

if ( ! defined( 'KASTALABS_CORE_PATH' ) ) {
	define( 'KASTALABS_CORE_PATH', __DIR__ );
}

require_once KASTALABS_CORE_PATH . '/includes/helpers.php';
require_once KASTALABS_CORE_PATH . '/includes/options.php';
require_once KASTALABS_CORE_PATH . '/post-types/portfolio.php';
require_once KASTALABS_CORE_PATH . '/post-types/service.php';
require_once KASTALABS_CORE_PATH . '/post-types/insight.php';
require_once KASTALABS_CORE_PATH . '/post-types/work-legacy.php';
require_once KASTALABS_CORE_PATH . '/taxonomies/portfolio.php';
require_once KASTALABS_CORE_PATH . '/taxonomies/insight.php';
require_once KASTALABS_CORE_PATH . '/includes/meta.php';
require_once KASTALABS_CORE_PATH . '/includes/contact.php';
require_once KASTALABS_CORE_PATH . '/acf/field-groups.php';
require_once KASTALABS_CORE_PATH . '/admin/settings.php';
require_once KASTALABS_CORE_PATH . '/admin/seed.php';
require_once KASTALABS_CORE_PATH . '/admin/migration.php';

register_activation_hook(
	__FILE__,
	function (): void {
		kastalabs_register_portfolio_post_type();
		kastalabs_register_service_post_type();
		kastalabs_register_insight_post_type();
		kastalabs_register_legacy_work_post_type();
		kastalabs_register_portfolio_taxonomies();
		kastalabs_register_insight_taxonomies();
		kastalabs_seed_default_options();
		kastalabs_seed_default_services();
		flush_rewrite_rules();
	}
);

register_deactivation_hook(
	__FILE__,
	function (): void {
		flush_rewrite_rules();
	}
);
