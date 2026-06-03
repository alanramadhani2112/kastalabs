<?php
/**
 * Header template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'min-h-screen bg-bg text-fg font-body' ); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main"><?php esc_html_e( 'Lewati ke konten', 'kastalabs' ); ?></a>

<header class="site-header border-b border-white/10" role="banner">
	<div class="container-x flex items-center justify-between py-6">
		<div class="site-branding">
			<?php echo kasta_site_logo(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- output sudah aman dari helper. ?>
		</div>

		<nav class="site-nav hidden md:block" aria-label="<?php esc_attr_e( 'Primary', 'kastalabs' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'flex items-center gap-8 text-sm font-medium',
					'fallback_cb'    => '__return_empty_string',
					'depth'          => 1,
				)
			);
			?>
		</nav>

		<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn-primary text-sm">
			<?php esc_html_e( 'Mulai proyek', 'kastalabs' ); ?>
		</a>
	</div>
</header>