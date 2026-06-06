<?php
/**
 * Header layout component — navigation + branding + CTA.
 *
 * Extract dari header.php. Bisa dipakai ulang untuk halaman dengan header berbeda.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $cta_label CTA button label.
 *     @type string $cta_url   CTA button URL.
 *     @type string $class     Additional CSS classes on header element.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'cta_label' => __( 'Mulai proyek', 'kastalabs' ),
		'cta_url'   => '/contact/',
		'class'     => '',
	)
);
?>
<header class="site-header border-b border-hairline bg-bg/95 backdrop-blur-sm<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>" role="banner" data-site-header>
	<div class="container-x flex items-center justify-between py-6">
		<div class="site-branding">
			<?php echo kasta_site_logo(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>

		<nav class="hidden md:flex items-center gap-1" aria-label="<?php esc_attr_e( 'Primary navigation', 'kastalabs' ); ?>">
			<a href="/" class="nav-link"><?php esc_html_e( 'Home', 'kastalabs' ); ?></a>
			<a href="/about/" class="nav-link"><?php esc_html_e( 'About', 'kastalabs' ); ?></a>

			<button
				class="nav-link mega-toggle"
				data-mega-toggle="services"
				aria-expanded="false"
			>
				<?php esc_html_e( 'Services', 'kastalabs' ); ?>
				<?php kasta_icon( 'chevron-down', array( 'class' => 'w-4 h-4 mega-chevron' ) ); ?>
			</button>

			<button
				class="nav-link mega-toggle"
				data-mega-toggle="portfolio"
				aria-expanded="false"
			>
				<?php esc_html_e( 'Portfolio', 'kastalabs' ); ?>
				<?php kasta_icon( 'chevron-down', array( 'class' => 'w-4 h-4 mega-chevron' ) ); ?>
			</button>

			<a href="/insights/" class="nav-link"><?php esc_html_e( 'Insights', 'kastalabs' ); ?></a>
			<a href="/contact/" class="nav-link"><?php esc_html_e( 'Contact', 'kastalabs' ); ?></a>
		</nav>

		<div class="hidden items-center gap-3 md:flex">
			<?php
			get_template_part(
				'template-parts/ui/button',
				null,
				array(
					'label'   => $args['cta_label'],
					'url'     => $args['cta_url'],
					'variant' => 'primary',
				)
			);
			?>
		</div>

		<button class="site-menu-toggle md:hidden" type="button" aria-controls="mobile-menu" aria-expanded="false" data-menu-toggle>
			<span class="sr-only"><?php esc_html_e( 'Buka menu navigasi', 'kastalabs' ); ?></span>
			<span class="menu-toggle-icon-open" aria-hidden="true"><?php kasta_icon( 'bars-3', array( 'class' => 'w-5 h-5' ) ); ?></span>
			<span class="menu-toggle-icon-close hidden" aria-hidden="true"><?php kasta_icon( 'x-mark', array( 'class' => 'w-5 h-5' ) ); ?></span>
		</button>
	</div>

	<?php
	// Mega menu panels
	get_template_part(
		'template-parts/navigation/mega-menu',
		null,
		array(
			'id'      => 'services',
			'columns' => array(
				array(
					'icon'  => 'sparkles',
					'title' => __( 'Branding', 'kastalabs' ),
					'desc'  => __( 'Strategi brand, identitas visual, dan pedoman brand yang konsisten.', 'kastalabs' ),
					'url'   => '/services/',
				),
				array(
					'icon'  => 'eye',
					'title' => __( 'UI/UX Design', 'kastalabs' ),
					'desc'  => __( 'Riset pengguna, wireframe, prototyping, dan visual design.', 'kastalabs' ),
					'url'   => '/services/',
				),
				array(
					'icon'  => 'code-bracket',
					'title' => __( 'Web Development', 'kastalabs' ),
					'desc'  => __( 'Frontend & backend yang scalable, cepat, dan mudah dikelola.', 'kastalabs' ),
					'url'   => '/services/',
				),
				array(
					'icon'  => 'puzzle-piece',
					'title' => __( 'Custom Software', 'kastalabs' ),
					'desc'  => __( 'Sistem digital custom yang sesuai dengan cara kerja tim Anda.', 'kastalabs' ),
					'url'   => '/services/',
				),
			),
		)
	);

	get_template_part(
		'template-parts/navigation/mega-menu',
		null,
		array(
			'id'      => 'portfolio',
			'columns' => array(
				array(
					'icon'  => 'sparkles',
					'title' => __( 'Branding', 'kastalabs' ),
					'desc'  => __( 'Identitas visual & sistem brand.', 'kastalabs' ),
					'url'   => '/portfolio/?category=branding',
				),
				array(
					'icon'  => 'eye',
					'title' => __( 'UI/UX', 'kastalabs' ),
					'desc'  => __( 'Desain antarmuka & pengalaman pengguna.', 'kastalabs' ),
					'url'   => '/portfolio/?category=ui-ux',
				),
				array(
					'icon'  => 'code-bracket',
					'title' => __( 'Web Dev', 'kastalabs' ),
					'desc'  => __( 'Website, web app, dan sistem custom.', 'kastalabs' ),
					'url'   => '/portfolio/?category=web-dev',
				),
				array(
					'icon'  => 'puzzle-piece',
					'title' => __( 'Custom Software', 'kastalabs' ),
					'desc'  => __( 'Aplikasi khusus untuk kebutuhan spesifik.', 'kastalabs' ),
					'url'   => '/portfolio/?category=custom-software',
				),
			),
		)
	);
	?>

	<?php
	get_template_part(
		'template-parts/navigation/menu-mobile',
		null,
		array(
			'cta_label' => $args['cta_label'],
			'cta_url'   => $args['cta_url'],
		)
	);
	?>
</header>
