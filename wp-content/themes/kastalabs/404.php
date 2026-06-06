<?php
/**
 * 404 template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" class="container-x py-28 md:py-36" role="main" data-page="404">
	<p class="eyebrow"><?php esc_html_e( 'Error 404', 'kastalabs' ); ?></p>
	<h1 class="type-display-lg mt-6">
		<?php esc_html_e( 'Halaman tidak ditemukan.', 'kastalabs' ); ?>
	</h1>
	<p class="type-body-lg measure-copy mt-8 text-muted">
		<?php esc_html_e( 'URL yang kamu buka mungkin sudah dipindah atau tidak pernah ada. Coba telusuri konten lain.', 'kastalabs' ); ?>
	</p>
	<div class="mt-10 flex flex-wrap gap-4">
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
		?>
		<?php
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
</main>

<?php get_footer(); ?>
