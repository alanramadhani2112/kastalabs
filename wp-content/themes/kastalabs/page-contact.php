<?php
/**
 * Contact page template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$status = isset( $_GET['contact_status'] ) ? sanitize_key( wp_unslash( $_GET['contact_status'] ) ) : '';
$contact_email    = kasta_contact_email();
$company_location = kasta_site_option( 'company_location', __( 'Indonesia', 'kastalabs' ) );
$whatsapp_url     = kasta_site_url_option( 'whatsapp_url' );

get_header(); ?>

<main id="main" role="main" data-page="contact">
	<section class="container-x pt-28 pb-16 md:pt-40 md:pb-24">
		<div class="max-w-5xl" data-reveal>
			<?php kasta_eyebrow( __( 'Contact', 'kastalabs' ) ); ?>
			<h1 class="font-display font-extrabold text-5xl md:text-8xl lg:text-9xl tracking-tight leading-[0.9] mt-6">
				<?php esc_html_e( 'Ceritakan proyek yang ingin Anda bangun.', 'kastalabs' ); ?>
			</h1>
		</div>
	</section>

	<section class="container-x pb-24 md:pb-32">
		<div class="grid gap-12 lg:grid-cols-[minmax(0,1fr)_22rem]">
			<form class="contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" data-reveal>
				<input type="hidden" name="action" value="kasta_contact">
				<?php wp_nonce_field( 'kasta_contact', 'kasta_contact_nonce' ); ?>

				<div class="hidden" aria-hidden="true">
					<label for="website"><?php esc_html_e( 'Website', 'kastalabs' ); ?></label>
					<input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
				</div>

				<?php if ( 'sent' === $status ) : ?>
					<p class="mb-6 rounded-lg border border-primary-500/30 bg-surface p-4 text-primary-700">
						<?php esc_html_e( 'Pesan terkirim. Kami akan membalas secepatnya.', 'kastalabs' ); ?>
					</p>
				<?php elseif ( 'error' === $status ) : ?>
					<p class="mb-6 rounded-lg border border-red-400/40 bg-red-50 p-4 text-red-700">
						<?php esc_html_e( 'Pesan belum terkirim. Periksa nama, email, dan pesan Anda.', 'kastalabs' ); ?>
					</p>
				<?php endif; ?>

				<div class="grid gap-5 md:grid-cols-2">
					<label class="form-field">
						<span><?php esc_html_e( 'Name', 'kastalabs' ); ?></span>
						<input class="form-control" name="name" type="text" autocomplete="name" required>
					</label>
					<label class="form-field">
						<span><?php esc_html_e( 'Email', 'kastalabs' ); ?></span>
						<input class="form-control" name="email" type="email" autocomplete="email" required>
					</label>
					<label class="form-field">
						<span><?php esc_html_e( 'Company', 'kastalabs' ); ?></span>
						<input class="form-control" name="company" type="text" autocomplete="organization">
					</label>
					<label class="form-field">
						<span><?php esc_html_e( 'Budget range', 'kastalabs' ); ?></span>
						<select class="form-control" name="budget">
							<option value=""><?php esc_html_e( 'Select range', 'kastalabs' ); ?></option>
							<option value="< 25 juta"><?php esc_html_e( '< 25 juta', 'kastalabs' ); ?></option>
							<option value="25-75 juta"><?php esc_html_e( '25-75 juta', 'kastalabs' ); ?></option>
							<option value="75-150 juta"><?php esc_html_e( '75-150 juta', 'kastalabs' ); ?></option>
							<option value="150 juta+"><?php esc_html_e( '150 juta+', 'kastalabs' ); ?></option>
						</select>
					</label>
				</div>

				<label class="form-field mt-5">
					<span><?php esc_html_e( 'Project type', 'kastalabs' ); ?></span>
					<select class="form-control" name="project_type">
						<option value=""><?php esc_html_e( 'Select type', 'kastalabs' ); ?></option>
						<option value="Brand identity"><?php esc_html_e( 'Brand identity', 'kastalabs' ); ?></option>
						<option value="Website"><?php esc_html_e( 'Website', 'kastalabs' ); ?></option>
						<option value="Content system"><?php esc_html_e( 'Content system', 'kastalabs' ); ?></option>
						<option value="Retainer"><?php esc_html_e( 'Retainer', 'kastalabs' ); ?></option>
					</select>
				</label>

				<label class="form-field mt-5">
					<span><?php esc_html_e( 'Message', 'kastalabs' ); ?></span>
					<textarea class="form-control min-h-48" name="message" required></textarea>
				</label>

				<button class="btn-primary mt-8" type="submit" data-magnetic>
					<?php esc_html_e( 'Send inquiry', 'kastalabs' ); ?>
				</button>
			</form>

			<aside class="rounded-lg border border-hairline bg-surface p-6 lg:sticky lg:top-28 self-start" data-reveal data-reveal-delay="0.12">
				<h2 class="eyebrow"><?php esc_html_e( 'Direct line', 'kastalabs' ); ?></h2>
				<a class="mt-4 block text-2xl font-bold hover:text-primary-600" href="<?php echo esc_url( 'mailto:' . $contact_email ); ?>"><?php echo esc_html( antispambot( $contact_email ) ); ?></a>
				<?php if ( $whatsapp_url ) : ?>
					<a class="mt-3 inline-flex text-sm font-semibold text-primary-600 hover:text-primary-700" href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Chat via WhatsApp', 'kastalabs' ); ?>
					</a>
				<?php endif; ?>
				<p class="mt-8 text-muted leading-relaxed">
					<?php
					printf(
						/* translators: %s: company location. */
						esc_html__( 'Berbasis di %s. Terbuka untuk kerja jarak jauh dengan brand, founder, dan tim produk.', 'kastalabs' ),
						esc_html( $company_location )
					);
					?>
				</p>
			</aside>
		</div>
	</section>
</main>

<?php get_footer();
