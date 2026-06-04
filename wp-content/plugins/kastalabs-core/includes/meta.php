<?php
/**
 * Structured post meta fields.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'kastalabs_register_structured_meta' );

/**
 * Register REST-exposed meta for structured CMS content.
 */
function kastalabs_register_structured_meta(): void {
	$portfolio_fields = array(
		'client_name'    => 'string',
		'project_year'   => 'integer',
		'project_url'    => 'url',
		'role'           => 'string',
		'scope'          => 'string',
		'challenge'      => 'textarea',
		'solution'       => 'textarea',
		'results'        => 'textarea',
		'technologies'   => 'string',
		'is_featured'    => 'boolean',
		'cover_video'    => 'url',
	);

	kastalabs_register_meta_fields( 'portfolio', $portfolio_fields );
	kastalabs_register_meta_fields( 'work', $portfolio_fields );

	kastalabs_register_meta_fields(
		'service',
		array(
			'overview'        => 'textarea',
			'benefits'        => 'textarea',
			'workflow'        => 'textarea',
			'expected_impact' => 'textarea',
			'cta_label'       => 'string',
			'cta_url'         => 'url',
			'icon_label'      => 'string',
		)
	);

	kastalabs_register_meta_fields(
		'insight',
		array(
			'seo_title'       => 'string',
			'seo_description' => 'textarea',
		)
	);

	kastalabs_register_meta_fields(
		'kasta_inquiry',
		array(
			'inquiry_name'   => 'string',
			'email'          => 'string',
			'company'        => 'string',
			'budget'         => 'string',
			'project_type'   => 'string',
			'inquiry_status' => 'string',
			'email_status'   => 'string',
			'source_url'     => 'url',
			'user_ip_hash'   => 'string',
			'user_agent'     => 'string',
		)
	);
}
