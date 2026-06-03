<?php
/**
 * SEO additions that remain useful with or without a full SEO plugin.
 *
 * Full title/OG/breadcrumb control can still be handled by Rank Math or Yoast.
 *
 * @package Kastalabs
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return a concise page description.
 */
function kasta_seo_description(): string {
	if ( is_singular() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post ) {
			$description = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( wp_strip_all_tags( (string) $post->post_content ), 30 );
			if ( '' !== trim( $description ) ) {
				return trim( $description );
			}
		}
	}

	if ( is_post_type_archive( 'portfolio' ) ) {
		return __( 'Portfolio Kastalabs: project digital, brand, website, dan sistem pengalaman yang dibangun dengan strategi dan intensi.', 'kastalabs' );
	}

	if ( is_post_type_archive( 'insight' ) ) {
		return __( 'Insights Kastalabs seputar desain, teknologi, strategi digital, dan proses kreatif.', 'kastalabs' );
	}

	return get_bloginfo( 'description' );
}

add_action(
	'wp_head',
	function (): void {
		if ( is_admin() ) {
			return;
		}

		$description = kasta_seo_description();
		if ( '' === $description ) {
			return;
		}

		printf(
			"\n<meta name=\"description\" content=\"%s\">\n",
			esc_attr( $description )
		);
	},
	4
);

add_action(
	'wp_head',
	function (): void {
		if ( is_admin() ) {
			return;
		}

		$logo_id  = (int) get_theme_mod( 'custom_logo' );
		$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
		$email    = function_exists( 'kasta_contact_email' ) ? kasta_contact_email() : '';
		$same_as  = array_filter(
			array(
				function_exists( 'kasta_site_url_option' ) ? kasta_site_url_option( 'instagram_url' ) : '',
				function_exists( 'kasta_site_url_option' ) ? kasta_site_url_option( 'linkedin_url' ) : '',
				function_exists( 'kasta_site_url_option' ) ? kasta_site_url_option( 'behance_url' ) : '',
			)
		);

		$organization = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Organization',
			'name'        => get_bloginfo( 'name' ),
			'url'         => home_url( '/' ),
			'description' => get_bloginfo( 'description' ),
		);

		if ( $logo_url ) {
			$organization['logo'] = $logo_url;
		}
		if ( is_email( $email ) ) {
			$organization['email'] = $email;
		}
		if ( $same_as ) {
			$organization['sameAs'] = array_values( $same_as );
		}

		$website = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'WebSite',
			'name'        => get_bloginfo( 'name' ),
			'url'         => home_url( '/' ),
			'description' => get_bloginfo( 'description' ),
			'potentialAction' => array(
				'@type'       => 'SearchAction',
				'target'      => home_url( '/?s={search_term_string}' ),
				'query-input' => 'required name=search_term_string',
			),
		);

		printf(
			"\n<script type=\"application/ld+json\">%s</script>\n",
			wp_json_encode( $organization, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
		);
		printf(
			"\n<script type=\"application/ld+json\">%s</script>\n",
			wp_json_encode( $website, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
		);
	},
	28
);

add_action(
	'wp_head',
	function (): void {
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

add_action(
	'wp_head',
	function (): void {
		if ( ! is_singular( array( 'insight', 'post' ) ) ) {
			return;
		}

		$post = get_queried_object();
		if ( ! $post instanceof WP_Post ) {
			return;
		}

		$cover = get_the_post_thumbnail_url( $post, 'kasta-cover' );
		$data  = array(
			'@context'      => 'https://schema.org',
			'@type'         => 'Article',
			'headline'      => get_the_title( $post ),
			'description'   => kasta_seo_description(),
			'url'           => get_permalink( $post ),
			'datePublished' => get_the_date( 'c', $post ),
			'dateModified'  => get_the_modified_date( 'c', $post ),
			'author'        => array(
				'@type' => 'Person',
				'name'  => get_the_author_meta( 'display_name', (int) $post->post_author ),
			),
			'publisher'     => array(
				'@type' => 'Organization',
				'name'  => get_bloginfo( 'name' ),
				'url'   => home_url( '/' ),
			),
		);

		if ( $cover ) {
			$data['image'] = $cover;
		}

		printf(
			"\n<script type=\"application/ld+json\">%s</script>\n",
			wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
		);
	},
	31
);

add_action(
	'wp_head',
	function (): void {
		$analytics_id = function_exists( 'kasta_site_option' ) ? kasta_site_option( 'analytics_id' ) : '';
		if ( '' === $analytics_id || ! str_starts_with( $analytics_id, 'G-' ) ) {
			return;
		}

		?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $analytics_id ); ?>"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', '<?php echo esc_js( $analytics_id ); ?>');
		</script>
		<?php
	},
	40
);
