<?php
/**
 * 404 template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" class="container-x py-32 md:py-48" role="main">
	<p class="eyebrow"><?php esc_html_e( 'Error 404', 'kastalabs' ); ?></p>
	<h1 class="type-display-lg mt-6">
		<?php esc_html_e( 'Halaman tidak ditemukan.', 'kastalabs' ); ?>
	</h1>
	<p class="type-body-lg measure-copy mt-8 text-muted">
		<?php esc_html_e( 'URL yang kamu buka mungkin sudah dipindah atau tidak pernah ada. Coba telusuri konten lain.', 'kastalabs' ); ?>
	</p>
	<div class="mt-10 flex flex-wrap gap-4">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary">
			<?php esc_html_e( 'Kembali ke beranda', 'kastalabs' ); ?>
		</a>
		<a href="<?php echo esc_url( home_url( '/portfolio/' ) ); ?>" class="btn-ghost">
			<?php esc_html_e( 'Lihat portfolio', 'kastalabs' ); ?>
		</a>
	</div>
</main>

<?php get_footer();
