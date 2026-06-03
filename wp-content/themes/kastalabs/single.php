<?php
/**
 * Single blog post template.
 *
 * @package Kastalabs
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="main" role="main" data-page="blog-single">
	<div class="reading-progress" data-reading-progress aria-hidden="true"></div>

	<?php while ( have_posts() ) : the_post(); ?>
		<article data-reading-article>
			<header class="container-x pt-28 pb-14 md:pt-40 md:pb-20">
				<div class="grid gap-10 lg:grid-cols-[minmax(0,1fr)_18rem] lg:items-end">
					<div class="max-w-4xl" data-reveal>
						<p class="eyebrow">
							<?php echo esc_html( get_the_date() ); ?> / <?php echo esc_html( kasta_reading_time() ); ?> <?php esc_html_e( 'menit baca', 'kastalabs' ); ?>
						</p>
						<h1 class="font-display font-extrabold text-5xl md:text-7xl lg:text-8xl tracking-tight leading-[0.92] mt-6">
							<?php the_title(); ?>
						</h1>
						<?php if ( has_excerpt() ) : ?>
							<p class="text-muted text-lg md:text-xl mt-8 max-w-3xl leading-relaxed">
								<?php echo esc_html( get_the_excerpt() ); ?>
							</p>
						<?php endif; ?>
					</div>

					<aside class="border-l border-hairline pl-6 text-sm text-muted" data-reveal data-reveal-delay="0.15">
						<p class="eyebrow mb-3"><?php esc_html_e( 'Written by', 'kastalabs' ); ?></p>
						<p class="text-fg font-semibold"><?php echo esc_html( get_the_author() ); ?></p>
						<?php
						$categories = get_the_category();
						if ( ! empty( $categories ) ) :
							?>
							<div class="mt-8">
								<p class="eyebrow mb-3"><?php esc_html_e( 'Filed under', 'kastalabs' ); ?></p>
								<div class="flex flex-wrap gap-2">
									<?php foreach ( $categories as $category ) : ?>
										<a class="rounded-md border border-hairline px-3 py-1 hover:border-primary-500 hover:text-primary-600" href="<?php echo esc_url( get_category_link( $category ) ); ?>">
											<?php echo esc_html( $category->name ); ?>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
					</aside>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="container-x" data-reveal data-reveal-delay="0.1">
					<div class="overflow-hidden rounded-lg border border-hairline bg-surface">
						<?php the_post_thumbnail( 'kasta-cover', array( 'class' => 'w-full h-auto object-cover' ) ); ?>
					</div>
				</figure>
			<?php endif; ?>

			<section class="container-x py-16 md:py-24">
				<div class="grid gap-12 lg:grid-cols-[16rem_minmax(0,44rem)]">
					<aside class="lg:sticky lg:top-28 self-start" data-reveal>
						<a class="eyebrow inline-flex hover:text-primary-600" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">
							<?php esc_html_e( 'Back to journal', 'kastalabs' ); ?>
						</a>
						<?php
						$tags = get_the_tags();
						if ( $tags ) :
							?>
							<div class="mt-10">
								<h2 class="eyebrow"><?php esc_html_e( 'Topics', 'kastalabs' ); ?></h2>
								<div class="mt-4 flex flex-wrap gap-2">
									<?php foreach ( $tags as $tag ) : ?>
										<a class="rounded-md bg-surface px-3 py-1 text-sm text-muted hover:bg-primary-500 hover:text-white" href="<?php echo esc_url( get_tag_link( $tag ) ); ?>">
											<?php echo esc_html( $tag->name ); ?>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
					</aside>

					<div class="prose" data-reveal data-reveal-delay="0.15">
						<?php the_content(); ?>
					</div>
				</div>
			</section>

			<nav class="container-x border-t border-hairline py-12" aria-label="<?php esc_attr_e( 'Adjacent posts', 'kastalabs' ); ?>">
				<div class="grid gap-4 md:grid-cols-2">
					<div>
						<?php previous_post_link( '%link', '<span class="eyebrow">' . esc_html__( 'Previous', 'kastalabs' ) . '</span><span class="mt-2 block text-xl font-semibold">%title</span>' ); ?>
					</div>
					<div class="md:text-right">
						<?php next_post_link( '%link', '<span class="eyebrow">' . esc_html__( 'Next', 'kastalabs' ) . '</span><span class="mt-2 block text-xl font-semibold">%title</span>' ); ?>
					</div>
				</div>
			</nav>
		</article>
	<?php endwhile; ?>
</main>

<?php get_footer();
