<?php
/**
 * Large landing page statement.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="py-28 md:py-36 bg-surface" data-statement>
	<div class="container-x">
		<div class="grid gap-10 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)] lg:items-center">
			<?php
			get_template_part(
				'template-parts/ui/heading',
				null,
				array(
					'eyebrow'    => __( 'Yang kami percaya', 'kastalabs' ),
					'title'      => __( 'Kami memilih kerja yang dekat, teliti, dan cukup berani untuk meninggalkan kesan.', 'kastalabs' ),
					'class'      => 'zoom-section-heading',
				)
			);
			?>
			<div class="grid gap-4" data-reveal data-reveal-delay="0.1">
				<?php
				get_template_part(
					'template-parts/ui/card',
					null,
					array(
						'eyebrow' => __( '01 / Strategy', 'kastalabs' ),
						'body'    => __( 'Kami mendengarkan dan membaca konteks. Tidak ada solusi yang sama untuk dua masalah yang berbeda.', 'kastalabs' ),
						'variant' => 'default',
						'padding' => 'p-5',
						'class'   => 'bg-bg',
					)
				);

				get_template_part(
					'template-parts/ui/card',
					null,
					array(
						'eyebrow' => __( '02 / Craft', 'kastalabs' ),
						'body'    => __( 'Detail dijaga — dari tipografi, layout, sampai interaksi yang terasa pas.', 'kastalabs' ),
						'variant' => 'default',
						'padding' => 'p-5',
						'class'   => 'bg-bg',
					)
				);

				get_template_part(
					'template-parts/ui/card',
					null,
					array(
						'eyebrow' => __( '03 / Ship', 'kastalabs' ),
						'body'    => __( 'Desain tidak berhenti di mockup. Kami pastikan semuanya berjalan di dunia nyata.', 'kastalabs' ),
						'variant' => 'solid',
						'padding' => 'p-5',
					)
				);
				?>
			</div>
		</div>
	</div>
</section>
