<?php
/**
 * Home Hero section — ENHANCED.
 *
 * Pinned full-viewport hero with:
 * - Multi-layer parallax depth
 * - Split-text headline with perspective
 * - Text scramble eyebrow
 * - Magnetic CTA buttons
 * - Animated scroll indicator
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="relative min-h-screen flex items-center overflow-hidden" data-hero>
	<!-- Parallax depth layers -->
	<div class="absolute inset-0 pointer-events-none" data-hero-bg aria-hidden="true">
		<!-- Layer 0: deep background gradient -->
		<div class="absolute inset-0 bg-gradient-to-b from-primary-950/50 via-bg to-bg" data-hero-layer="0.3"></div>

		<!-- Layer 1: large ambient glow -->
		<div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[900px] h-[900px] rounded-full bg-primary-500/8 blur-[150px]" data-hero-layer="0.6"></div>

		<!-- Layer 2: secondary glow -->
		<div class="absolute bottom-1/4 right-1/4 w-[500px] h-[500px] rounded-full bg-primary-700/6 blur-[100px]" data-hero-layer="0.9"></div>

		<!-- Layer 3: accent dot grid (subtle) -->
		<div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, var(--color-fg) 1px, transparent 1px); background-size: 40px 40px;" data-hero-layer="1.2"></div>

		<!-- Layer 4: floating geometric shapes -->
		<div class="absolute top-[15%] right-[10%] w-24 h-24 border border-primary-500/20 rounded-full" data-hero-layer="1.5"></div>
		<div class="absolute bottom-[20%] left-[8%] w-16 h-16 border border-white/10 rotate-45" data-hero-layer="1.8"></div>
		<div class="absolute top-[60%] right-[25%] w-3 h-3 bg-primary-400/40 rounded-full" data-hero-layer="2.0"></div>
	</div>

	<div class="container-x py-32 md:py-40 lg:py-48 relative z-10">
		<div data-hero-eyebrow>
			<?php kasta_eyebrow( __( 'Studio kreatif berbasis di Indonesia', 'kastalabs' ) ); ?>
		</div>

		<h1
			class="font-display font-extrabold tracking-tight leading-[0.92] mt-8 text-5xl md:text-7xl lg:text-[5.5rem] xl:text-[6.5rem] max-w-[16ch]"
			data-hero-headline
		>
			<?php esc_html_e( 'Brand yang tajam. Website yang bekerja.', 'kastalabs' ); ?>
		</h1>

		<p
			class="text-lg md:text-xl text-muted mt-8 max-w-2xl leading-relaxed"
			data-hero-subtitle
		>
			<?php esc_html_e( 'KastaLabs membantu founder, tim marketing, dan brand owner menyusun identitas visual, website, dan sistem konten yang jelas, menarik, dan siap dipakai.', 'kastalabs' ); ?>
		</p>

		<div class="mt-12 flex flex-wrap gap-4" data-hero-ctas>
			<a
				href="<?php echo esc_url( home_url( '/contact' ) ); ?>"
				class="btn-primary"
				data-magnetic
				data-cursor="grow"
			>
				<?php esc_html_e( 'Mulai proyek', 'kastalabs' ); ?>
			</a>
			<a
				href="<?php echo esc_url( home_url( '/work' ) ); ?>"
				class="btn-ghost"
				data-magnetic
				data-cursor="grow"
			>
				<?php esc_html_e( 'Lihat karya', 'kastalabs' ); ?>
			</a>
		</div>
	</div>

	<!-- Scroll indicator -->
	<div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-muted z-10">
		<span class="text-xs font-mono uppercase tracking-widest"><?php esc_html_e( 'Scroll', 'kastalabs' ); ?></span>
		<div class="w-px h-16 relative overflow-hidden">
			<div class="absolute inset-0 bg-gradient-to-b from-white/60 to-transparent animate-[scrollDown_2s_ease-in-out_infinite]"></div>
		</div>
	</div>
</section>
