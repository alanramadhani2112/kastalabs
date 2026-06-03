<?php
/**
 * Shared helpers for Kastalabs Core.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return sanitizer callback for a registered meta field type.
 */
function kastalabs_meta_sanitizer( string $type ): callable {
	return match ( $type ) {
		'integer' => 'absint',
		'boolean' => static fn( mixed $value ): bool => (bool) $value,
		'url'     => 'esc_url_raw',
		'textarea' => 'sanitize_textarea_field',
		default   => 'sanitize_text_field',
	};
}

/**
 * Register a group of REST-exposed single post meta fields.
 *
 * @param string               $post_type Post type key.
 * @param array<string,string> $fields    Meta key => type.
 */
function kastalabs_register_meta_fields( string $post_type, array $fields ): void {
	foreach ( $fields as $key => $type ) {
		$schema_type = match ( $type ) {
			'integer' => 'integer',
			'boolean' => 'boolean',
			default   => 'string',
		};

		register_post_meta(
			$post_type,
			$key,
			array(
				'type'              => $schema_type,
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => kastalabs_meta_sanitizer( $type ),
				'auth_callback'     => static fn(): bool => current_user_can( 'edit_posts' ),
			)
		);
	}
}
