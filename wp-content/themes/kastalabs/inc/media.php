<?php
/**
 * Media performance helpers.
 *
 * Keeps image uploads and rendered image attributes aligned with the
 * production performance workflow.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

/**
 * Keep oversized uploads within the largest theme display size.
 */
add_filter(
	'big_image_size_threshold',
	static function (): int {
		return 1920;
	}
);

/**
 * Prefer lighter generated image files while preserving good visual quality.
 */
add_filter( 'jpeg_quality', 'kasta_image_editor_quality' );
add_filter( 'wp_editor_set_quality', 'kasta_image_editor_quality' );

/**
 * Return the compression quality used by WordPress image editors.
 */
function kasta_image_editor_quality(): int {
	return 82;
}

/**
 * Explicitly allow modern upload formats used by the production asset workflow.
 */
add_filter(
	'upload_mimes',
	static function ( array $mimes ): array {
		$mimes['webp'] = 'image/webp';
		$mimes['avif'] = 'image/avif';

		return $mimes;
	}
);

/**
 * Add consistent performance attributes to images rendered through WordPress.
 */
add_filter(
	'wp_get_attachment_image_attributes',
	static function ( array $attr, WP_Post $attachment, string|array $size ): array {
		unset( $attachment );

		if ( empty( $attr['decoding'] ) ) {
			$attr['decoding'] = 'async';
		}

		if ( empty( $attr['loading'] ) && empty( $attr['fetchpriority'] ) ) {
			$attr['loading'] = 'lazy';
		}

		if ( empty( $attr['sizes'] ) ) {
			$attr['sizes'] = kasta_image_sizes_attribute( $size );
		}

		return $attr;
	},
	10,
	3
);

/**
 * Return a responsive `sizes` value for known theme image sizes.
 */
function kasta_image_sizes_attribute( string|array $size ): string {
	if ( is_array( $size ) ) {
		$width = isset( $size[0] ) ? absint( $size[0] ) : 0;

		return $width ? '(max-width: 768px) 100vw, ' . $width . 'px' : '100vw';
	}

	return match ( $size ) {
		'kasta-cover', 'large', 'full' => '(max-width: 1024px) 100vw, 1200px',
		'kasta-card'                  => '(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 480px',
		'kasta-thumb', 'medium'        => '(max-width: 768px) 100vw, 360px',
		default                       => '(max-width: 768px) 100vw, 720px',
	};
}
