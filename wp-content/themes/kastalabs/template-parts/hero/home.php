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

<section class="zoom-hero relative overflow-hidden" data-hero>
	<div class="container-x py-24 md:py-32 lg:py-36 relative z-10">
		<div class="zoom-hero__grid">
			<div>
				<div data-hero-eyebrow>
					<?php kasta_eyebrow( $hero_eyebrow ); ?>
				</div>

				<h1
					class="type-display-xl mt-6 max-w-[11ch]"
					data-hero-headline
				>
					<?php echo esc_html( $hero_heading ); ?>
				</h1>

				<p
					class="type-body-lg measure-copy mt-7"
					data-hero-subtitle
				>
					<?php echo esc_html( $hero_body ); ?>
				</p>

				<div class="mt-9 flex flex-wrap gap-3" data-hero-ctas>
					<a
						href="<?php echo esc_url( $hero_primary_url ); ?>"
						class="btn-primary"
						data-magnetic
					>
						<?php echo esc_html( $hero_primary_label ); ?>
					</a>
					<a
						href="<?php echo esc_url( $hero_secondary_url ); ?>"
						class="btn-ghost border-white/25 bg-white/10 text-white hover:border-white/45 hover:bg-white/15 hover:text-white"
						data-magnetic
					>
						<?php echo esc_html( $hero_secondary_label ); ?>
					</a>
				</div>

				<div class="zoom-pill-row mt-10" aria-label="<?php esc_attr_e( 'Kapabilitas utama', 'kastalabs' ); ?>">
					<span class="zoom-pill type-label"><?php esc_html_e( 'Brand system', 'kastalabs' ); ?></span>
					<span class="zoom-pill type-label"><?php esc_html_e( 'Website', 'kastalabs' ); ?></span>
					<span class="zoom-pill type-label"><?php esc_html_e( 'Content flow', 'kastalabs' ); ?></span>
				</div>
			</div>

			<div class="zoom-hero__panel" data-reveal data-reveal-delay="0.12" aria-label="<?php esc_attr_e( 'Kastalabs project workspace preview', 'kastalabs' ); ?>">
				<div class="zoom-hero__media"></div>
				<div class="zoom-capture-card">
					<p class="type-label"><?php esc_html_e( 'Kastalabs workspace', 'kastalabs' ); ?></p>
					<p class="type-h4 mt-3"><?php esc_html_e( 'Capture the brand direction, then ship the website.', 'kastalabs' ); ?></p>
				</div>
				<div class="zoom-window" aria-hidden="true">
					<div class="zoom-window__bar">
						<span class="zoom-window__dot"></span>
						<span class="zoom-window__dot" style="background:#74D6C5"></span>
						<span class="zoom-window__dot" style="background:#FFC75A"></span>
					</div>
					<div class="zoom-window__body">
						<div class="zoom-window__row">
							<span class="zoom-window__avatar"></span>
							<span class="zoom-window__line"></span>
						</div>
						<div class="zoom-window__row">
							<span class="zoom-window__avatar" style="background:linear-gradient(135deg,#FFC75A,#FF7B7B)"></span>
							<span class="zoom-window__line"></span>
						</div>
						<div class="zoom-window__row">
							<span class="zoom-window__avatar" style="background:linear-gradient(135deg,#9B8CFF,#0B5CFF)"></span>
							<span class="zoom-window__line"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
