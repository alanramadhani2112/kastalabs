<?php
/**
 * Footer layout component.
 *
 * Extract dari footer.php. Digunakan dengan parameter untuk kustomisasi.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $footer_copy   Footer description text.
 *     @type array  $social_links  Array of { url, label }.
 *     @type string $class         Additional CSS classes.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'footer_copy'  => get_bloginfo( 'description' ),
		'address'      => '',
		'social_links' => array(),
		'class'        => '',
	)
);
?>
<footer class="site-footer mt-24 bg-navy text-white<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>" role="contentinfo">
	<div class="container-x py-16 grid gap-12 md:grid-cols-[1.5fr_1fr_1fr_1fr]">
		<div>
			<?php echo kasta_site_logo( 'light' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<p class="type-body-sm mt-5 max-w-sm text-white/85">
				<?php echo esc_html( $args['footer_copy'] ); ?>
			</p>
			<?php if ( $args['address'] ) : ?>
				<p class="type-body-sm mt-4 flex items-start gap-2 text-white/60">
					<?php kasta_icon( 'map-pin', array( 'class' => 'w-4 h-4 mt-0.5 flex-none' ) ); ?>
					<?php echo esc_html( $args['address'] ); ?>
				</p>
			<?php endif; ?>

			<div class="mt-8">
				<p class="type-label mb-3 text-white/50"><?php esc_html_e( 'Dapatkan update dari kami', 'kastalabs' ); ?></p>
				<?php get_template_part( 'template-parts/forms/newsletter-form' ); ?>
			</div>
		</div>

		<?php
		get_template_part(
			'template-parts/navigation/menu-footer',
			null,
			array(
				'title' => __( 'Sitemap', 'kastalabs' ),
			)
		);
		?>

		<?php
		get_template_part(
			'template-parts/navigation/menu-footer',
			null,
			array(
				'title'         => __( 'Layanan', 'kastalabs' ),
				'theme_location' => 'footer-services',
				'fallback_cb'    => 'kasta_footer_services_fallback',
			)
		);
		?>

		<?php
		get_template_part(
			'template-parts/navigation/menu-social',
			null,
			array(
				'links'   => $args['social_links'],
				'heading' => __( 'Koneksi', 'kastalabs' ),
				'variant' => 'muted',
			)
		);
		?>
	</div>

	<div class="container-x flex items-center justify-between border-t border-white/10 py-6 text-white/45 type-body-sm">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'kastalabs' ); ?></p>
	</div>
</footer>
