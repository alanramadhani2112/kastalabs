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
 * Return the best available sitemap URL while the SEO plugin decision is open.
 */
function kasta_sitemap_url(): string {
	return home_url( '/wp-sitemap.xml' );
}

add_action(
	'template_redirect',
	function (): void {
		if ( is_admin() ) {
			return;
		}

		$request_path = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ) : '';
		if ( 'sitemap.xml' !== trim( $request_path, '/' ) ) {
			return;
		}

		wp_safe_redirect( kasta_sitemap_url(), 301 );
		exit;
	}
);

add_filter(
	'robots_txt',
	function ( string $output, bool $public ): string {
		unset( $public );

		$lines = preg_split( '/\r\n|\r|\n/', trim( $output ) );
		$lines = is_array( $lines ) ? array_filter( $lines ) : array();

		$has_user_agent = false;
		foreach ( $lines as $line ) {
			if ( str_starts_with( strtolower( trim( $line ) ), 'user-agent:' ) ) {
				$has_user_agent = true;
				break;
			}
		}

		if ( ! $has_user_agent ) {
			array_unshift( $lines, 'User-agent: *' );
		}

		$required = array(
			'Disallow: /wp-admin/',
			'Allow: /wp-admin/admin-ajax.php',
			'Sitemap: ' . kasta_sitemap_url(),
		);

		foreach ( $required as $line ) {
			if ( ! in_array( $line, $lines, true ) ) {
				$lines[] = $line;
			}
		}

		return implode( "\n", $lines ) . "\n";
	},
	10,
	2
);

/**
 * Return configured default SEO title.
 */
function kasta_seo_title(): string {
	if ( is_singular() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post ) {
			$title = (string) get_post_meta( $post->ID, 'seo_title', true );
			if ( '' !== trim( $title ) ) {
				return trim( $title );
			}
		}
	}

	if ( function_exists( 'kasta_site_option' ) ) {
		$title = kasta_site_option( 'seo_title' );
		if ( '' !== trim( $title ) ) {
			return trim( $title );
		}
	}

	return wp_get_document_title();
}

add_filter(
	'document_title_parts',
	function ( array $title ): array {
		if ( is_admin() ) {
			return $title;
		}

		if ( is_singular() ) {
			$post = get_queried_object();
			if ( $post instanceof WP_Post ) {
				$seo_title = (string) get_post_meta( $post->ID, 'seo_title', true );
				if ( '' !== trim( $seo_title ) ) {
					$title['title'] = trim( $seo_title );
					return $title;
				}
			}
		}

		if ( is_front_page() && function_exists( 'kasta_site_option' ) ) {
			$seo_title = kasta_site_option( 'seo_title' );
			if ( '' !== trim( $seo_title ) ) {
				$title['title'] = trim( $seo_title );
			}
		}

		return $title;
	}
);

/**
 * Return a concise page description.
 */
function kasta_seo_description(): string {
	if ( is_singular() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post ) {
			$meta_description = (string) get_post_meta( $post->ID, 'seo_description', true );
			if ( '' !== trim( $meta_description ) ) {
				return trim( $meta_description );
			}

			$description = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( wp_strip_all_tags( (string) $post->post_content ), 30 );
			if ( '' !== trim( $description ) ) {
				return trim( $description );
			}
		}
	}

	if ( is_post_type_archive( 'work' ) ) {
		return __( 'Portfolio Kastalabs: project digital, brand, website, dan sistem pengalaman yang dibangun dengan strategi dan intensi.', 'kastalabs' );
	}

	if ( is_post_type_archive( 'insight' ) ) {
		return __( 'Insights Kastalabs seputar desain, teknologi, strategi digital, dan proses kreatif.', 'kastalabs' );
	}

	if ( function_exists( 'kasta_site_option' ) ) {
		$description = kasta_site_option( 'seo_description' );
		if ( '' !== trim( $description ) ) {
			return trim( $description );
		}
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

		$title       = kasta_seo_title();
		$description = kasta_seo_description();
		$image       = '';

		if ( is_singular() ) {
			$post = get_queried_object();
			if ( $post instanceof WP_Post ) {
				$image = (string) get_the_post_thumbnail_url( $post, 'kasta-cover' );
			}
		}

		if ( '' === $image && function_exists( 'kasta_site_url_option' ) ) {
			$image = kasta_site_url_option( 'og_image_url' );
		}

		$url = is_singular() ? get_permalink() : home_url( '/' );
		if ( ! is_front_page() && ! is_home() && isset( $GLOBALS['wp']->request ) && '' !== $GLOBALS['wp']->request ) {
			$url = home_url( '/' . trim( (string) $GLOBALS['wp']->request, '/' ) . '/' );
		}

		$tags = array(
			'og:title'       => $title,
			'og:description' => $description,
			'og:url'         => $url,
			'og:site_name'   => get_bloginfo( 'name' ),
			'og:type'        => is_singular( array( 'post', 'insight' ) ) ? 'article' : 'website',
			'twitter:card'        => $image ? 'summary_large_image' : 'summary',
			'twitter:title'       => $title,
			'twitter:description' => $description,
		);

		if ( $image ) {
			$tags['og:image']      = $image;
			$tags['twitter:image'] = $image;
		}

		foreach ( $tags as $property => $content ) {
			if ( '' === trim( (string) $content ) ) {
				continue;
			}

			$attribute = str_starts_with( $property, 'twitter:' ) ? 'name' : 'property';
			printf(
				"\n<meta %s=\"%s\" content=\"%s\">",
				esc_attr( $attribute ),
				esc_attr( $property ),
				esc_attr( $content )
			);
		}
		echo "\n";
	},
	5
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
		if ( ! is_singular( array( 'work' ) ) ) {
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

/**
 * Filter document title — ganti blog description dengan tagline yang lebih deskriptif.
 */
add_filter(
	'pre_get_document_title',
	function ( string $title ): string {
		// Homepage: gunakan tagline yang lebih baik
		if ( is_front_page() ) {
			return get_bloginfo( 'name' ) . ' — ' . __( 'Studio Digital Strategis', 'kastalabs' );
		}

		return $title;
	},
	20
);
