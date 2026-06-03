<?php
/**
 * Footer template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$footer_copy = kasta_site_option( 'footer_copy', get_bloginfo( 'description' ) );
$social_links = array_filter(
	array(
		'Instagram' => kasta_site_url_option( 'instagram_url' ),
		'LinkedIn'  => kasta_site_url_option( 'linkedin_url' ),
		'Behance'   => kasta_site_url_option( 'behance_url' ),
	)
);
?>

<footer class="site-footer border-t border-hairline mt-24" role="contentinfo">
	<div class="container-x py-16 grid gap-12 md:grid-cols-4">
		<div class="md:col-span-2">
			<?php echo kasta_site_logo(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<p class="text-muted mt-4 max-w-md text-sm leading-relaxed">
				<?php echo esc_html( $footer_copy ); ?>
			</p>
		</div>

		<nav aria-label="<?php esc_attr_e( 'Footer', 'kastalabs' ); ?>">
			<h2 class="eyebrow mb-4"><?php esc_html_e( 'Navigation', 'kastalabs' ); ?></h2>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'flex flex-col gap-2 text-sm',
					'fallback_cb'    => 'kasta_footer_nav_fallback',
					'depth'          => 1,
				)
			);
			?>
		</nav>

		<nav aria-label="<?php esc_attr_e( 'Social', 'kastalabs' ); ?>">
			<h2 class="eyebrow mb-4"><?php esc_html_e( 'Connect', 'kastalabs' ); ?></h2>
			<?php if ( has_nav_menu( 'social' ) ) : ?>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'social',
						'container'      => false,
						'menu_class'     => 'flex flex-col gap-2 text-sm',
						'fallback_cb'    => '__return_empty_string',
						'depth'          => 1,
					)
				);
				?>
			<?php elseif ( $social_links ) : ?>
				<ul class="flex flex-col gap-2 text-sm">
					<?php foreach ( $social_links as $label => $url ) : ?>
						<li><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $label ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</nav>
	</div>

	<div class="container-x flex items-center justify-between text-xs text-muted py-6 border-t border-hairline">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
		<p class="font-mono"><?php esc_html_e( 'kasta.theme v', 'kastalabs' ); ?><?php echo esc_html( KASTA_VERSION ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
