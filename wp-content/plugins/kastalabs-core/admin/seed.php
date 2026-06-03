<?php
/**
 * Seed helpers for initial CMS content.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add the four core Service posts when the site has no services yet.
 */
function kastalabs_seed_default_services(): int {
	$existing = get_posts(
		array(
			'post_type'      => 'service',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( $existing ) {
		return 0;
	}

	$services = array(
		array(
			'title'           => 'Branding Design',
			'slug'            => 'branding-design',
			'overview'        => 'Membangun identitas visual yang kuat, konsisten, dan mampu memperjelas posisi brand di mata audiens.',
			'benefits'        => 'Brand terasa lebih profesional, mudah dikenali, dan memiliki sistem visual yang siap digunakan lintas media.',
			'workflow'        => 'Discovery, brand direction, visual identity exploration, design system, dan final brand assets.',
			'expected_impact' => 'Komunikasi brand menjadi lebih jelas, konsisten, dan mudah dikembangkan.',
		),
		array(
			'title'           => 'UI/UX Design',
			'slug'            => 'ui-ux-design',
			'overview'        => 'Merancang pengalaman digital yang intuitif, human-centered, dan selaras dengan tujuan bisnis.',
			'benefits'        => 'Pengguna lebih mudah memahami alur, menemukan informasi, dan mengambil tindakan penting.',
			'workflow'        => 'Research, information architecture, wireframe, interface design, prototype, dan design handoff.',
			'expected_impact' => 'Produk digital terasa lebih nyaman digunakan dan lebih siap untuk dikembangkan.',
		),
		array(
			'title'           => 'Web Development',
			'slug'            => 'web-development',
			'overview'        => 'Membangun website modern yang cepat, terstruktur, mudah dikelola, dan siap berkembang bersama bisnis.',
			'benefits'        => 'Website menjadi lebih kredibel, performatif, dan mudah diperbarui oleh tim internal.',
			'workflow'        => 'Technical planning, frontend development, CMS integration, QA, optimization, dan launch support.',
			'expected_impact' => 'Website dapat menjadi kanal utama untuk membangun kepercayaan dan menghasilkan konversi.',
		),
		array(
			'title'           => 'Custom Software Development',
			'slug'            => 'custom-software-development',
			'overview'        => 'Mengembangkan sistem digital custom untuk membantu proses kerja bisnis menjadi lebih efisien dan terukur.',
			'benefits'        => 'Operasional lebih rapi, data lebih mudah dikelola, dan proses manual dapat dikurangi.',
			'workflow'        => 'Requirement mapping, system architecture, development, testing, deployment, dan iteration.',
			'expected_impact' => 'Bisnis memiliki sistem yang lebih sesuai dengan proses internal dan target pertumbuhan.',
		),
	);

	$count = 0;
	$contact_url = kastalabs_default_contact_url();

	foreach ( $services as $index => $service ) {
		$post_id = wp_insert_post(
			array(
				'post_type'    => 'service',
				'post_status'  => 'publish',
				'post_title'   => $service['title'],
				'post_name'    => $service['slug'],
				'post_excerpt' => $service['overview'],
				'post_content' => $service['overview'],
				'menu_order'   => $index + 1,
			)
		);

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		update_post_meta( $post_id, 'overview', $service['overview'] );
		update_post_meta( $post_id, 'benefits', $service['benefits'] );
		update_post_meta( $post_id, 'workflow', $service['workflow'] );
		update_post_meta( $post_id, 'expected_impact', $service['expected_impact'] );
		update_post_meta( $post_id, 'cta_label', 'Discuss this service' );
		update_post_meta( $post_id, 'cta_url', $contact_url );
		update_post_meta( $post_id, 'icon_label', sprintf( '%02d', $index + 1 ) );

		$count++;
	}

	return $count;
}

/**
 * Return a safe Contact URL for seeded service CTA fields.
 */
function kastalabs_default_contact_url(): string {
	$url   = home_url( '/contact/' );
	$parts = wp_parse_url( $url );

	if ( empty( $parts['host'] ) ) {
		return '/contact/';
	}

	return $url;
}
