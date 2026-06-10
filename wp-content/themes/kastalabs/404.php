<?php
/**
 * 404 template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" class="container-x py-28 md:py-36" role="main" data-page="404">
	<div class="max-w-2xl mx-auto text-center">
		<p class="eyebrow"><?php esc_html_e( '404', 'kastalabs' ); ?></p>
		<h1 class="type-display-lg mt-6">
			<?php esc_html_e( 'Halaman tidak ditemukan.', 'kastalabs' ); ?>
		</h1>
		<p class="type-body-lg mt-8 text-muted">
			<?php esc_html_e( 'URL yang kamu buka mungkin sudah dipindah atau tidak pernah ada. Coba telusuri konten lain atau kembali ke beranda.', 'kastalabs' ); ?>
		</p>

		<div class="mt-8 max-w-xs mx-auto">
			<?php get_template_part( 'template-parts/forms/search-form' ); ?>
		</div>

		<div class="mt-10 flex flex-wrap justify-center gap-4">
			<?php
			get_template_part(
				'template-parts/ui/button',
				null,
				array(
					'label'   => __( 'Kembali ke beranda', 'kastalabs' ),
					'url'     => home_url( '/' ),
					'variant' => 'primary',
				)
			);
			get_template_part(
				'template-parts/ui/button',
				null,
				array(
					'label'   => __( 'Lihat portfolio', 'kastalabs' ),
					'url'     => get_post_type_archive_link( 'portfolio' ) ?: home_url( '/portfolio/' ),
					'variant' => 'ghost',
				)
			);
			?>
		</div>

		<nav class="mt-14" aria-label="<?php esc_attr_e( 'Navigasi alternatif', 'kastalabs' ); ?>">
			<ul class="flex flex-wrap justify-center gap-x-6 gap-y-2">
				<li><a href="/about/" class="type-body-sm text-muted hover:text-primary-600 transition-colors"><?php esc_html_e( 'About', 'kastalabs' ); ?></a></li>
				<li><a href="/services/" class="type-body-sm text-muted hover:text-primary-600 transition-colors"><?php esc_html_e( 'Services', 'kastalabs' ); ?></a></li>
				<li><a href="/insights/" class="type-body-sm text-muted hover:text-primary-600 transition-colors"><?php esc_html_e( 'Insights', 'kastalabs' ); ?></a></li>
				<li><a href="/contact/" class="type-body-sm text-muted hover:text-primary-600 transition-colors"><?php esc_html_e( 'Contact', 'kastalabs' ); ?></a></li>
			</ul>
		</nav>
	</div>
</main>

<?php get_footer();
