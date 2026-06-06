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
	<link rel="icon" type="image/svg+xml" href="<?php echo esc_url( KASTA_THEME_URI . '/assets/favicon.svg' ); ?>" />
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( KASTA_THEME_URI . '/assets/favicon.png' ); ?>" />
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
?>
