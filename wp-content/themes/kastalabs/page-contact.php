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
	<?php
	get_template_part(
		'template-parts/hero/page-hero',
		null,
		array(
			'eyebrow' => __( 'Hubungi kami', 'kastalabs' ),
			'heading' => __( 'Ceritakan proyek yang ingin Anda bangun.', 'kastalabs' ),
			'pills'   => array(
				__( 'Inquiry proyek', 'kastalabs' ),
				__( 'Siap remote', 'kastalabs' ),
				__( 'Berbasis di Indonesia', 'kastalabs' ),
			),
		)
	);
	?>

	<section class="container-x py-24 md:py-32">
		<div class="grid gap-12 lg:grid-cols-[minmax(0,1fr)_22rem]">
			<?php get_template_part( 'template-parts/forms/contact-form', null, array( 'status' => $status ) ); ?>

			<aside class="zoom-card zoom-card--soft p-6 lg:sticky lg:top-28 self-start" data-reveal data-reveal-delay="0.12">
				<h2 class="eyebrow"><?php esc_html_e( 'Informasi kontak', 'kastalabs' ); ?></h2>
				<a class="type-h4 mt-4 block hover:text-primary-600" href="<?php echo esc_url( 'mailto:' . $contact_email ); ?>"><?php echo esc_html( antispambot( $contact_email ) ); ?></a>
				<?php if ( $whatsapp_url ) : ?>
					<a class="type-button mt-3 inline-flex text-primary-600 hover:text-primary-700" href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Chat via WhatsApp', 'kastalabs' ); ?>
					</a>
				<?php endif; ?>
				<div class="mt-8 space-y-3 text-muted">
					<p class="type-body-sm">
						<span class="block type-label text-foreground"><?php esc_html_e( 'Lokasi', 'kastalabs' ); ?></span>
						<?php echo esc_html( $company_location ); ?>
					</p>
					<p class="type-body-sm">
						<span class="block type-label text-foreground"><?php esc_html_e( 'Respon', 'kastalabs' ); ?></span>
						<?php esc_html_e( 'Kami membalas dalam 1–2 hari kerja.', 'kastalabs' ); ?>
					</p>
				</div>
			</aside>
		</div>
	</section>
</main>

<?php get_footer();
