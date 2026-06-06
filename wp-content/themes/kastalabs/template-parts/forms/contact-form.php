<?php
/**
 * Contact form component.
 *
 * Extract dari page-contact.php. Bisa dipakai ulang di page lain.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $action     Form action URL.
 *     @type string $nonce_action Nonce action name.
 *     @type string $nonce_name   Nonce field name.
 *     @type string $status       Status query param value.
 *     @type string $class        Additional CSS classes on form.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'action'       => admin_url( 'admin-post.php' ),
		'nonce_action' => 'kasta_contact',
		'nonce_name'   => 'kasta_contact_nonce',
		'status'       => '',
		'class'        => '',
	)
);

$status = $args['status'];
?>
<form class="contact-form zoom-card<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>" action="<?php echo esc_url( $args['action'] ); ?>" method="post" data-reveal>
	<input type="hidden" name="action" value="kasta_contact">
	<?php wp_nonce_field( $args['nonce_action'], $args['nonce_name'] ); ?>

	<div class="hidden" aria-hidden="true">
		<label for="website-hp"><?php esc_html_e( 'Website', 'kastalabs' ); ?></label>
		<input id="website-hp" name="website" type="text" tabindex="-1" autocomplete="off">
	</div>

	<?php if ( 'sent' === $status ) : ?>
		<?php
		get_template_part(
			'template-parts/ui/alert',
			null,
			array(
				'message' => __( 'Inquiry berhasil dikirim. Kami akan menghubungi Anda secepatnya.', 'kastalabs' ),
				'variant' => 'success',
				'class'   => 'mb-6',
			)
		);
		?>
	<?php elseif ( 'error' === $status ) : ?>
		<?php
		get_template_part(
			'template-parts/ui/alert',
			null,
			array(
				'message' => __( 'Inquiry belum bisa dikirim. Periksa kembali data Anda atau hubungi kami langsung lewat email.', 'kastalabs' ),
				'variant' => 'error',
				'class'   => 'mb-6',
			)
		);
		?>
	<?php endif; ?>

	<div class="grid gap-5 md:grid-cols-2">
		<?php
		get_template_part(
			'template-parts/ui/form-field',
			null,
			array(
				'label'        => __( 'Nama', 'kastalabs' ),
				'name'         => 'name',
				'type'         => 'text',
				'autocomplete' => 'name',
				'required'     => true,
			)
		);
		get_template_part(
			'template-parts/ui/form-field',
			null,
			array(
				'label'        => __( 'Email', 'kastalabs' ),
				'name'         => 'email',
				'type'         => 'email',
				'autocomplete' => 'email',
				'required'     => true,
			)
		);
		get_template_part(
			'template-parts/ui/form-field',
			null,
			array(
				'label'        => __( 'Perusahaan', 'kastalabs' ),
				'name'         => 'company',
				'type'         => 'text',
				'autocomplete' => 'organization',
			)
		);
		get_template_part(
			'template-parts/ui/form-field',
			null,
			array(
				'label'   => __( 'Estimasi budget', 'kastalabs' ),
				'name'    => 'budget',
				'type'    => 'select',
				'options' => array(
					''           => __( 'Pilih rentang', 'kastalabs' ),
					'< 25 juta'  => __( '< 25 juta', 'kastalabs' ),
					'25-75 juta' => __( '25-75 juta', 'kastalabs' ),
					'75-150 juta' => __( '75-150 juta', 'kastalabs' ),
					'150 juta+'  => __( '150 juta+', 'kastalabs' ),
				),
			)
		);
		?>
	</div>

	<?php
	get_template_part(
		'template-parts/ui/form-field',
		null,
		array(
			'label'   => __( 'Jenis project', 'kastalabs' ),
			'name'    => 'project_type',
			'type'    => 'select',
			'class'   => 'mt-5',
			'options' => array(
				''                => __( 'Pilih jenis', 'kastalabs' ),
				'Brand identity'  => __( 'Brand identity', 'kastalabs' ),
				'Website'         => __( 'Website', 'kastalabs' ),
				'UI/UX Design'    => __( 'UI/UX Design', 'kastalabs' ),
				'Custom software' => __( 'Custom software', 'kastalabs' ),
			),
		)
	);
	get_template_part(
		'template-parts/ui/form-field',
		null,
		array(
			'label'       => __( 'Pesan', 'kastalabs' ),
			'name'        => 'message',
			'type'        => 'textarea',
			'placeholder' => __( 'Jelaskan tentang bisnis Anda, tantangan yang dihadapi, dan apa yang Anda harapkan dari kami.', 'kastalabs' ),
			'required'    => true,
			'class'       => 'mt-5',
		)
	);
	?>

	<?php
	get_template_part(
		'template-parts/ui/button',
		null,
		array(
			'label'    => __( 'Kirim inquiry', 'kastalabs' ),
			'variant'  => 'primary',
			'class'    => 'mt-8',
			'magnetic' => true,
			'tag'      => 'button',
			'type'     => 'submit',
		)
	);
	?>
</form>
