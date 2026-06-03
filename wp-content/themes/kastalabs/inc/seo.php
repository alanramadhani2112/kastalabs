<?php
/**
 * SEO additions yang tidak tercover oleh plugin SEO (Rank Math/Yoast).
 *
 * Saat ini fokus: JSON-LD CreativeWork untuk single 'work'.
 * Title / OG / breadcrumb dipasrahkan ke plugin SEO yang dipilih.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'wp_head',
	function () {
		if ( ! is_singular( array( 'portfolio', 'work' ) ) ) {
			return;
		}

		$post = get_queried_object();
		if ( ! $post instanceof WP_Post ) {
			return;
		}

		$cover  = get_the_post_thumbnail_url( $post, 'kasta-cover' );
		$client = (string) get_post_meta( $post->ID, 'client_name', true );
		$url    = (string) get_post_meta( $post->ID, 'project_url', true );

		$data = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'CreativeWork',
			'name'        => get_the_title( $post ),
			'url'         => get_permalink( $post ),
			'dateCreated' => get_the_date( 'c', $post ),
			'creator'     => array(
				'@type' => 'Organization',
				'name'  => get_bloginfo( 'name' ),
				'url'   => home_url( '/' ),
			),
		);

		if ( $cover ) {
			$data['image'] = $cover;
		}
		if ( $client ) {
			$data['producer'] = array(
				'@type' => 'Organization',
				'name'  => $client,
			);
		}
		if ( $url ) {
			$data['workExample'] = array(
				'@type' => 'WebPage',
				'url'   => $url,
			);
		}

		printf(
			"\n<script type=\"application/ld+json\">%s</script>\n",
			wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
		);
	},
	30
);
