<?php
/**
 * Header template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;
$header_cta_label = kasta_site_option( 'hero_primary_label', __( 'Mulai proyek', 'kastalabs' ) );
$header_cta_url   = kasta_site_url_option( 'hero_primary_url', '/contact/' );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="theme-color" content="#0B5CFF" />

	<!-- Favicons -->
	<link rel="icon" type="image/svg+xml" href="<?php echo esc_url( KASTA_THEME_URI . '/assets/favicon.svg' ); ?>" />
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( KASTA_THEME_URI . '/assets/favicon.png' ); ?>" />
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( KASTA_THEME_URI . '/assets/apple-touch-icon.png' ); ?>" />

	<!-- Font preload — LCP weight, fallback ke CSS @font-face jika tidak ditemukan -->
	<?php
	$font_dir = KASTA_THEME_PATH . '/dist/assets/';
	$font_uri = KASTA_THEME_URI . '/dist/assets/';
	$font_map = array(
		'600' => '',
		'700' => '',
	);
	if ( is_dir( $font_dir ) ) {
		foreach ( scandir( $font_dir ) as $f ) {
			foreach ( array_keys( $font_map ) as $w ) {
				if ( str_contains( $f, "plus-jakarta-sans-latin-{$w}-normal" ) && str_ends_with( $f, '.woff2' ) ) {
					$font_map[ $w ] = $font_uri . $f;
				}
			}
		}
	}
	foreach ( $font_map as $weight => $url ) {
		if ( $url ) {
			printf(
				'<link rel="preload" as="font" type="font/woff2" crossorigin="anonymous" href="%s">' . "\n",
				esc_url( $url )
			);
		}
	}
	?>

	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'min-h-screen bg-bg text-fg font-body' ); ?>>
<?php wp_body_open(); ?>

<?php get_template_part( 'template-parts/navigation/skip-link' ); ?>

<?php
get_template_part(
	'template-parts/layout/header',
	null,
	array(
		'cta_label' => $header_cta_label,
		'cta_url'   => $header_cta_url,
	)
);
