<?php
/**
 * Home hero section.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$hero_eyebrow         = kasta_site_option( 'hero_eyebrow', __( 'Studio kreatif berbasis di Indonesia', 'kastalabs' ) );
$hero_heading         = kasta_site_option( 'hero_heading', __( 'Brand yang tajam. Website yang bekerja.', 'kastalabs' ) );
$hero_body            = kasta_site_option( 'hero_body', __( 'Kastalabs membantu founder, tim marketing, dan brand owner menyusun identitas visual, website, dan sistem konten yang jelas, menarik, dan siap dipakai.', 'kastalabs' ) );
$hero_primary_label   = kasta_site_option( 'hero_primary_label', __( 'Mulai proyek', 'kastalabs' ) );
$hero_primary_url     = kasta_site_url_option( 'hero_primary_url', '/contact/' );
$hero_secondary_label = kasta_site_option( 'hero_secondary_label', __( 'Lihat portfolio', 'kastalabs' ) );
$hero_secondary_url   = kasta_site_url_option( 'hero_secondary_url', '/portfolio/' );
?>

<section class="relative min-h-[86vh] flex items-center overflow-hidden border-b border-hairline bg-bg" data-hero>
	<!-- Parallax depth layers -->
	<div class="absolute inset-0 pointer-events-none" data-hero-bg aria-hidden="true">
		<div class="absolute inset-x-0 top-0 h-px bg-hairline" data-hero-layer="0.3"></div>
		<div class="absolute right-0 top-0 h-full w-1/3 bg-surface/60" data-hero-layer="0.4"></div>
		<div class="absolute inset-0 opacity-[0.04]" style="background-image: linear-gradient(var(--color-fg) 1px, transparent 1px), linear-gradient(90deg, var(--color-fg) 1px, transparent 1px); background-size: 56px 56px;" data-hero-layer="0.7"></div>
	</div>

	<div class="container-x py-28 md:py-36 lg:py-40 relative z-10">
		<div data-hero-eyebrow>
			<?php kasta_eyebrow( $hero_eyebrow ); ?>
		</div>

		<h1
			class="font-display font-extrabold tracking-tight leading-[0.92] mt-8 text-5xl md:text-7xl lg:text-[5.5rem] xl:text-[6.5rem] max-w-[16ch]"
			data-hero-headline
		>
			<?php echo esc_html( $hero_heading ); ?>
		</h1>

		<p
			class="text-lg md:text-xl text-muted mt-8 max-w-2xl leading-relaxed"
			data-hero-subtitle
		>
			<?php echo esc_html( $hero_body ); ?>
		</p>

		<div class="mt-12 flex flex-wrap gap-4" data-hero-ctas>
			<a
				href="<?php echo esc_url( $hero_primary_url ); ?>"
				class="btn-primary"
				data-magnetic
			>
				<?php echo esc_html( $hero_primary_label ); ?>
			</a>
			<a
				href="<?php echo esc_url( $hero_secondary_url ); ?>"
				class="btn-ghost"
				data-magnetic
			>
				<?php echo esc_html( $hero_secondary_label ); ?>
			</a>
		</div>
	</div>

	<!-- Scroll indicator -->
	<div class="absolute bottom-8 left-1/2 -translate-x-1/2 hidden flex-col items-center gap-2 text-muted z-10 md:flex">
		<span class="text-xs font-mono uppercase tracking-widest"><?php esc_html_e( 'Scroll', 'kastalabs' ); ?></span>
		<div class="w-px h-16 relative overflow-hidden">
			<div class="absolute inset-0 bg-primary-500 animate-[scrollDown_2s_ease-in-out_infinite]"></div>
		</div>
	</div>
</section>
