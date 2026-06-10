<?php
/**
 * Local ACF field groups for structured CMS editing.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'acf/init', 'kastalabs_register_acf_field_groups' );

/**
 * Register local ACF field groups when ACF is available.
 */
function kastalabs_register_acf_field_groups(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_kastalabs_portfolio_details',
			'title'    => __( 'Portfolio Details', 'kastalabs' ),
			'fields'   => array(
				kastalabs_acf_text_field( 'client_name', __( 'Client Name', 'kastalabs' ) ),
				kastalabs_acf_number_field( 'project_year', __( 'Project Year', 'kastalabs' ) ),
				kastalabs_acf_url_field( 'project_url', __( 'Project URL', 'kastalabs' ) ),
				kastalabs_acf_text_field( 'role', __( 'Role', 'kastalabs' ) ),
				kastalabs_acf_textarea_field( 'scope', __( 'Scope', 'kastalabs' ) ),
				kastalabs_acf_textarea_field( 'context', __( 'Context', 'kastalabs' ) ),
				kastalabs_acf_textarea_field( 'challenge', __( 'Challenge', 'kastalabs' ) ),
				kastalabs_acf_textarea_field( 'approach', __( 'Approach', 'kastalabs' ) ),
				kastalabs_acf_textarea_field( 'solution', __( 'Solution', 'kastalabs' ) ),
				kastalabs_acf_textarea_field( 'results', __( 'Results', 'kastalabs' ) ),
				kastalabs_acf_text_field( 'technologies', __( 'Technologies', 'kastalabs' ) ),
				array(
					'key'           => 'field_kastalabs_is_featured',
					'label'         => __( 'Featured Project', 'kastalabs' ),
					'name'          => 'is_featured',
					'type'          => 'true_false',
					'ui'            => 1,
					'default_value' => 0,
				),
				kastalabs_acf_url_field( 'cover_video', __( 'Cover Video URL', 'kastalabs' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'portfolio',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_kastalabs_service_details',
			'title'    => __( 'Service Details', 'kastalabs' ),
			'fields'   => array(
				kastalabs_acf_textarea_field( 'overview', __( 'Overview', 'kastalabs' ) ),
				kastalabs_acf_textarea_field( 'inclusions', __( 'Inclusions (one per line)', 'kastalabs' ) ),
				kastalabs_acf_textarea_field( 'benefits', __( 'Benefits', 'kastalabs' ) ),
				kastalabs_acf_textarea_field( 'workflow', __( 'Workflow', 'kastalabs' ) ),
				kastalabs_acf_textarea_field( 'expected_impact', __( 'Expected Impact', 'kastalabs' ) ),
				kastalabs_acf_text_field( 'cta_label', __( 'CTA Label', 'kastalabs' ) ),
				kastalabs_acf_url_field( 'cta_url', __( 'CTA URL', 'kastalabs' ) ),
				kastalabs_acf_text_field( 'icon_label', __( 'Icon / Index Label', 'kastalabs' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'service',
					),
				),
			),
		)
	);

	$seo_locations = array();
	foreach ( array( 'page', 'post', 'portfolio', 'service', 'insight' ) as $post_type ) {
		$seo_locations[] = array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => $post_type,
			),
		);
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_kastalabs_seo',
			'title'    => __( 'SEO', 'kastalabs' ),
			'fields'   => array(
				kastalabs_acf_text_field( 'seo_title', __( 'SEO Title', 'kastalabs' ) ),
				kastalabs_acf_textarea_field( 'seo_description', __( 'SEO Description', 'kastalabs' ) ),
			),
			'location' => $seo_locations,
		)
	);
}

/**
 * Build a reusable ACF text field definition.
 */
function kastalabs_acf_text_field( string $name, string $label ): array {
	return array(
		'key'   => 'field_kastalabs_' . $name,
		'label' => $label,
		'name'  => $name,
		'type'  => 'text',
	);
}

/**
 * Build a reusable ACF textarea field definition.
 */
function kastalabs_acf_textarea_field( string $name, string $label ): array {
	return array(
		'key'  => 'field_kastalabs_' . $name,
		'label' => $label,
		'name' => $name,
		'type' => 'textarea',
		'rows' => 4,
	);
}

/**
 * Build a reusable ACF URL field definition.
 */
function kastalabs_acf_url_field( string $name, string $label ): array {
	return array(
		'key'   => 'field_kastalabs_' . $name,
		'label' => $label,
		'name'  => $name,
		'type'  => 'url',
	);
}

/**
 * Build a reusable ACF number field definition.
 */
function kastalabs_acf_number_field( string $name, string $label ): array {
	return array(
		'key'   => 'field_kastalabs_' . $name,
		'label' => $label,
		'name'  => $name,
		'type'  => 'number',
	);
}
