<?php
/**
 * Featured work grid section.
 *
 * Displays featured portfolio items with scroll-driven parallax images.
 * Falls back to placeholder if no work posts exist.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$work_query = new WP_Query(
	array(
		'post_type'      => 'work',
		'posts_per_page' => 4,
		'meta_key'       => '_kasta_is_featured',
		'meta_value'     => '1',
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);

// Fallback placeholders if no work posts yet.
$placeholders = array(
	array( 'title' => 'Project Alpha', 'cat' => 'Branding' ),
	array( 'title' => 'Project Beta', 'cat' => 'Web Development' ),
	array( 'title' => 'Project Gamma', 'cat' => 'UI/UX Design' ),
	array( 'title' => 'Project Delta', 'cat' => 'Motion Design' ),
);
?>

<section class="py-24 md:py-32" data-work-grid>
	<div class="container-x">
		<div class="flex items-end justify-between mb-16">
			<div data-reveal>
				<?php kasta_eyebrow( __( 'Selected Work', 'kastalabs' ) ); ?>
				<h2 class="text-3xl md:text-5xl font-bold mt-4">
					<?php esc_html_e( 'Karya yang dibuat untuk meninggalkan kesan.', 'kastalabs' ); ?>
				</h2>
			</div>
			<a
				href="<?php echo esc_url( get_post_type_archive_link( 'work' ) ); ?>"
				class="btn-ghost text-sm hidden md:inline-flex"
				data-magnetic
				data-cursor="grow"
			>
				<?php esc_html_e( 'Lihat semua karya', 'kastalabs' ); ?>
			</a>
		</div>

		<div class="grid gap-8 md:grid-cols-2">
			<?php if ( $work_query->have_posts() ) : ?>
				<?php while ( $work_query->have_posts() ) : $work_query->the_post(); ?>
					<article class="group relative rounded-2xl overflow-hidden aspect-[4/3] bg-surface" data-work-item data-cursor="grow">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'large', array(
								'class' => 'w-full h-full object-cover scale-105',
								'loading' => 'lazy',
							) ); ?>
						<?php else : ?>
							<div class="w-full h-full bg-gradient-to-br from-primary-900/30 to-surface"></div>
						<?php endif; ?>

						<div class="absolute inset-0 bg-gradient-to-t from-bg/90 via-bg/20 to-transparent"></div>

						<div class="absolute bottom-0 left-0 right-0 p-8">
							<?php
							$categories = get_the_terms( get_the_ID(), 'work_category' );
							if ( $categories && ! is_wp_error( $categories ) ) :
							?>
								<span class="eyebrow text-primary-400 mb-2 block">
									<?php echo esc_html( $categories[0]->name ); ?>
								</span>
							<?php endif; ?>
							<h3 class="text-xl md:text-2xl font-bold group-hover:text-primary-400 transition-colors">
								<?php the_title(); ?>
							</h3>
						</div>

						<a href="<?php the_permalink(); ?>" class="absolute inset-0" aria-label="<?php the_title_attribute(); ?>">
							<span class="sr-only"><?php the_title(); ?></span>
						</a>
					</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ( $placeholders as $ph ) : ?>
					<article class="group relative rounded-2xl overflow-hidden aspect-[4/3] bg-surface border border-white/8" data-work-item data-cursor="grow">
						<div class="w-full h-full bg-gradient-to-br from-primary-900/20 to-surface flex items-center justify-center">
							<span class="font-mono text-sm text-muted"><?php echo esc_html( $ph['cat'] ); ?></span>
						</div>

						<div class="absolute inset-0 bg-gradient-to-t from-bg/90 via-bg/20 to-transparent"></div>

						<div class="absolute bottom-0 left-0 right-0 p-8">
							<span class="eyebrow text-primary-400 mb-2 block"><?php echo esc_html( $ph['cat'] ); ?></span>
							<h3 class="text-xl md:text-2xl font-bold"><?php echo esc_html( $ph['title'] ); ?></h3>
						</div>
					</article>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<div class="mt-10 text-center md:hidden">
			<a
				href="<?php echo esc_url( get_post_type_archive_link( 'work' ) ); ?>"
				class="btn-ghost text-sm"
				data-magnetic
			>
				<?php esc_html_e( 'Lihat semua karya', 'kastalabs' ); ?>
			</a>
		</div>
	</div>
</section>
