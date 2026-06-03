<?php
/**
 * Custom post meta untuk CPT 'work'. Diekspose ke REST agar block editor
 * bisa membaca/menulis lewat custom block panel.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		$fields = array(
			'client_name'  => 'string',
			'project_year' => 'integer',
			'project_url'  => 'string',
			'role'         => 'string',
			'scope'        => 'string',
			'is_featured'  => 'boolean',
			'cover_video'  => 'string',
		);

		foreach ( $fields as $key => $type ) {
			register_post_meta(
				'work',
				$key,
				array(
					'type'              => $type,
					'single'            => true,
					'show_in_rest'      => true,
					'sanitize_callback' => kasta_meta_sanitizer( $type ),
					'auth_callback'     => static fn(): bool => current_user_can( 'edit_posts' ),
				)
			);
		}
	}
);

/**
 * Get sanitizer callback untuk type tertentu.
 */
function kasta_meta_sanitizer( string $type ): callable {
	return match ( $type ) {
		'integer' => 'absint',
		'boolean' => static fn( $v ): bool => (bool) $v,
		default   => 'sanitize_text_field',
	};
}