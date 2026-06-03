<?php
/**
 * Lightweight contact form handler.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_post_kasta_contact', 'kasta_handle_contact_form' );
add_action( 'admin_post_nopriv_kasta_contact', 'kasta_handle_contact_form' );

/**
 * Process contact page submissions.
 */
function kasta_handle_contact_form(): void {
	$redirect = wp_get_referer() ?: home_url( '/contact/' );

	if ( ! isset( $_POST['kasta_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kasta_contact_nonce'] ) ), 'kasta_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'contact_status', 'error', $redirect ) );
		exit;
	}

	$honeypot = isset( $_POST['website'] ) ? sanitize_text_field( wp_unslash( $_POST['website'] ) ) : '';
	if ( '' !== $honeypot ) {
		wp_safe_redirect( add_query_arg( 'contact_status', 'sent', $redirect ) );
		exit;
	}

	$name         = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email        = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$company      = isset( $_POST['company'] ) ? sanitize_text_field( wp_unslash( $_POST['company'] ) ) : '';
	$budget       = isset( $_POST['budget'] ) ? sanitize_text_field( wp_unslash( $_POST['budget'] ) ) : '';
	$project_type = isset( $_POST['project_type'] ) ? sanitize_text_field( wp_unslash( $_POST['project_type'] ) ) : '';
	$message      = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) || '' === $message ) {
		wp_safe_redirect( add_query_arg( 'contact_status', 'error', $redirect ) );
		exit;
	}

	$to      = get_option( 'admin_email' );
	$subject = sprintf(
		/* translators: %s: sender name. */
		__( 'New KastaLabs project inquiry from %s', 'kastalabs' ),
		$name
	);
	$body    = implode(
		"\n\n",
		array(
			'Name: ' . $name,
			'Email: ' . $email,
			'Company: ' . ( $company ?: '-' ),
			'Budget: ' . ( $budget ?: '-' ),
			'Project type: ' . ( $project_type ?: '-' ),
			"Message:\n" . $message,
		)
	);
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'contact_status', $sent ? 'sent' : 'error', $redirect ) );
	exit;
}
