<?php
/**
 * Home hero section.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$hero_eyebrow         = kasta_site_option( 'hero_eyebrow', __( 'Studio digital strategis', 'kastalabs' ) );
$hero_heading         = kasta_site_option( 'hero_heading', __( 'Brand yang bergerak lebih tajam, dimulai dari sini.', 'kastalabs' ) );
$hero_body            = kasta_site_option( 'hero_body', __( 'Kami membantu bisnis menyusun strategi, identitas visual, dan sistem digital yang bukan hanya terlihat baik — tapi bekerja secara nyata.', 'kastalabs' ) );
$hero_primary_label   = kasta_site_option( 'hero_primary_label', __( 'Lihat portfolio', 'kastalabs' ) );
$hero_primary_url     = kasta_site_url_option( 'hero_primary_url', '/portfolio/' );
$hero_secondary_label = kasta_site_option( 'hero_secondary_label', __( 'Ceritakan proyek Anda', 'kastalabs' ) );
$hero_secondary_url   = kasta_site_url_option( 'hero_secondary_url', '/contact/' );
$hero_metrics         = array(
	array(
		'value' => __( '4', 'kastalabs' ),
		'label' => __( 'Layanan inti', 'kastalabs' ),
	),
	array(
		'value' => __( '50+', 'kastalabs' ),
		'label' => __( 'Proyek selesai', 'kastalabs' ),
	),
	array(
		'value' => __( '3-6', 'kastalabs' ),
		'label' => __( 'Minggu peluncuran', 'kastalabs' ),
	),
);
?>

<section class="zoom-hero relative overflow-hidden" data-hero>
	<div data-hero-bg></div>
	<div class="container-x py-24 md:py-32 lg:py-40 relative z-10">
		<div class="zoom-hero__grid">
			<div>
				<div data-hero-eyebrow>
					<?php kasta_eyebrow( $hero_eyebrow ); ?>
				</div>

				<h1
					class="type-display-xl mt-6 max-w-[14ch]"
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
					<?php
					get_template_part(
						'template-parts/ui/button',
						null,
						array(
							'label'    => $hero_primary_label,
							'url'      => $hero_primary_url,
							'variant'  => 'primary',
							'magnetic' => true,
						)
					);
					get_template_part(
						'template-parts/ui/button',
						null,
						array(
							'label'    => $hero_secondary_label,
							'url'      => $hero_secondary_url,
							'variant'  => 'ghost',
							'magnetic' => true,
						)
					);
					?>
				</div>

				<div class="zoom-pill-row mt-10" aria-label="<?php esc_attr_e( 'Kapabilitas utama', 'kastalabs' ); ?>">
					<?php
					$hero_pills = array(
						__( 'Brand strategy', 'kastalabs' ),
						__( 'Visual design', 'kastalabs' ),
						__( 'Web systems', 'kastalabs' ),
						__( 'Digital products', 'kastalabs' ),
					);
					foreach ( $hero_pills as $pill ) :
						get_template_part(
							'template-parts/ui/badge',
							null,
							array( 'label' => $pill )
						);
					endforeach;
					?>
				</div>

				<div class="zoom-hero__metrics" aria-label="<?php esc_attr_e( 'Kastalabs delivery highlights', 'kastalabs' ); ?>">
					<?php foreach ( $hero_metrics as $metric ) : ?>
						<div>
							<strong><?php echo esc_html( $metric['value'] ); ?></strong>
							<span><?php echo esc_html( $metric['label'] ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="zoom-hero__panel" aria-label="<?php esc_attr_e( 'Kastalabs project workspace preview', 'kastalabs' ); ?>">
				<div class="zoom-capture-card">
					<div class="flex items-center gap-3 mb-4">
						<div class="grid h-9 w-9 place-items-center rounded-lg bg-primary-500/10 text-primary-600">
							<?php kasta_icon( 'sparkles', array( 'class' => 'w-5 h-5' ) ); ?>
						</div>
						<div>
							<p class="type-label"><?php esc_html_e( 'Latest project', 'kastalabs' ); ?></p>
							<p class="type-h4 mt-0.5">Sajiwa Rebrand</p>
						</div>
					</div>
					<div class="grid grid-cols-2 gap-3">
						<div class="rounded-lg border border-primary-500/15 bg-surface p-4">
							<p class="type-body-sm font-semibold"><?php esc_html_e( 'Brand strategy', 'kastalabs' ); ?></p>
							<div class="mt-2 h-1.5 w-3/4 rounded-full bg-primary-500/25"></div>
							<div class="mt-1 h-1.5 w-1/2 rounded-full bg-primary-500/15"></div>
						</div>
						<div class="rounded-lg border border-primary-500/15 bg-white p-4">
							<p class="type-body-sm font-semibold"><?php esc_html_e( 'UI Design', 'kastalabs' ); ?></p>
							<div class="mt-2 grid grid-cols-3 gap-1">
								<span class="block h-3 rounded bg-primary-500/20"></span>
								<span class="block h-3 rounded bg-primary-500/30"></span>
								<span class="block h-3 rounded bg-primary-500/15"></span>
							</div>
						</div>
					</div>
					<div class="mt-3 flex gap-2">
						<span class="zoom-meta-pill"><?php esc_html_e( 'Visual identity', 'kastalabs' ); ?></span>
						<span class="zoom-meta-pill"><?php esc_html_e( 'Web system', 'kastalabs' ); ?></span>
					</div>
				</div>
				<div class="zoom-window" aria-hidden="true">
					<div class="zoom-window__bar">
						<span class="zoom-window__dot"></span>
						<span class="zoom-window__dot" style="background:#74D6C5"></span>
						<span class="zoom-window__dot" style="background:#FFC75A"></span>
						<span class="zoom-window__title">sajiwa.id — v2.0</span>
					</div>
					<div class="zoom-window__body">
						<div class="zoom-window__layout grid grid-cols-[2rem_1fr] gap-3 p-5">
							<div class="flex flex-col gap-2">
								<?php kasta_icon( 'home', array( 'class' => 'w-5 h-5 text-primary-500/60' ) ); ?>
								<span class="block h-1 w-4 rounded-full bg-primary-500/30"></span>
								<span class="block h-1 w-4 rounded-full bg-primary-500/20"></span>
								<span class="block h-1 w-4 rounded-full bg-primary-500/20"></span>
							</div>
							<div>
								<div class="flex gap-2 mb-4">
									<span class="block h-2 w-24 rounded-full bg-primary-500/25"></span>
									<span class="block h-2 w-16 rounded-full bg-primary-500/15"></span>
								</div>
								<div class="grid grid-cols-2 gap-3">
									<div class="rounded-lg bg-white p-3 shadow-sm border border-hairline">
										<span class="block h-2 w-12 rounded-full bg-primary-500/25 mb-2"></span>
										<span class="block h-1.5 w-full rounded-full bg-primary-500/10 mb-1"></span>
										<span class="block h-1.5 w-3/4 rounded-full bg-primary-500/10"></span>
									</div>
									<div class="rounded-lg bg-white p-3 shadow-sm border border-hairline">
										<span class="block h-2 w-12 rounded-full bg-primary-500/25 mb-2"></span>
										<span class="block h-1.5 w-full rounded-full bg-primary-500/10 mb-1"></span>
										<span class="block h-1.5 w-2/3 rounded-full bg-primary-500/10"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
