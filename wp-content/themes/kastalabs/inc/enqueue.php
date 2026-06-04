<?php
/**
 * Enqueue: stylesheet + JS module dari Vite manifest.
 *
 * @package Kastalabs
 */

defined( 'ABSPATH' ) || exit;

/**
 * Read Vite manifest sekali per request.
 *
 * @return array<string, mixed>
 */
function kasta_vite_manifest(): array {
	static $manifest = null;
	if ( null !== $manifest ) {
		return $manifest;
	}

	$manifest_path = KASTA_THEME_PATH . '/dist/.vite/manifest.json';
	// Vite < 5 menulis ke /dist/manifest.json. Kita support keduanya.
	if ( ! file_exists( $manifest_path ) ) {
		$alt = KASTA_THEME_PATH . '/dist/manifest.json';
		if ( file_exists( $alt ) ) {
			$manifest_path = $alt;
		}
	}

	if ( ! file_exists( $manifest_path ) ) {
		$manifest = array();
		return $manifest;
	}

	$raw      = file_get_contents( $manifest_path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local file, not remote.
	$manifest = $raw ? (array) json_decode( $raw, true ) : array();
	return $manifest;
}

/**
 * Get URL untuk asset entry tertentu (file utama, bukan CSS).
 */
function kasta_vite_asset( string $entry ): ?string {
	$manifest = kasta_vite_manifest();
	if ( empty( $manifest[ $entry ] ) ) {
		return null;
	}
	return KASTA_THEME_URI . '/dist/' . ltrim( $manifest[ $entry ]['file'], '/' );
}

/**
 * Get list of CSS files yang diasosiasikan dengan entry JS.
 *
 * @return array<int, string>
 */
function kasta_vite_css( string $entry ): array {
	$manifest = kasta_vite_manifest();
	if ( empty( $manifest[ $entry ]['css'] ) ) {
		return array();
	}
	return array_map(
		fn( string $css ): string => KASTA_THEME_URI . '/dist/' . ltrim( $css, '/' ),
		(array) $manifest[ $entry ]['css']
	);
}

/**
 * Enqueue main bundle.
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		// Dev mode: inject Vite client + entry directly dari dev server.
		if ( KASTA_VITE_DEV ) {
			add_action(
				'wp_head',
				function () {
					echo "<script type=\"module\" src=\"http://localhost:5173/@vite/client\"></script>\n";
					echo "<script type=\"module\" src=\"http://localhost:5173/src/js/app.js\"></script>\n";
				},
				5
			);
			return;
		}

		// Prod: enqueue dari manifest.
		$entry = 'src/js/app.js';
		$js    = kasta_vite_asset( $entry );
		$css   = kasta_vite_css( $entry );

		foreach ( $css as $i => $href ) {
			wp_enqueue_style(
				'kasta-app-' . $i,
				$href,
				array(),
				KASTA_VERSION
			);
		}

		if ( $js ) {
			wp_enqueue_script_module(
				'kasta-app',
				$js,
				array(),
				KASTA_VERSION
			);
		}
	}
);

/**
 * Preload the main built stylesheet early when a manifest is available.
 */
add_action(
	'wp_head',
	function (): void {
		if ( KASTA_VITE_DEV ) {
			return;
		}

		foreach ( kasta_vite_css( 'src/js/app.js' ) as $href ) {
			printf(
				"<link rel=\"preload\" href=\"%s\" as=\"style\">\n",
				esc_url( $href )
			);
		}
	},
	1
);
