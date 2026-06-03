<?php
/**
 * Footer template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;
?>

<footer class="site-footer border-t border-white/10 mt-24" role="contentinfo">
	<div class="container-x py-16 grid gap-12 md:grid-cols-4">
		<div class="md:col-span-2">
			<?php echo kasta_site_logo(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<p class="text-muted mt-4 max-w-md text-sm leading-relaxed">
				<?php echo esc_html( get_bloginfo( 'description' ) ); ?>
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
					'fallback_cb'    => '__return_empty_string',
					'depth'          => 1,
				)
			);
			?>
		</nav>

		<nav aria-label="<?php esc_attr_e( 'Social', 'kastalabs' ); ?>">
			<h2 class="eyebrow mb-4"><?php esc_html_e( 'Connect', 'kastalabs' ); ?></h2>
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
		</nav>
	</div>

	<div class="container-x flex items-center justify-between text-xs text-muted py-6 border-t border-white/5">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
		<p class="font-mono"><?php esc_html_e( 'kasta.theme v', 'kastalabs' ); ?><?php echo esc_html( KASTA_VERSION ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>