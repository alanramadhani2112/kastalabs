<?php
/**
 * Contact form handling.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_post_kasta_contact', 'kastalabs_handle_contact_form' );
add_action( 'admin_post_nopriv_kasta_contact', 'kastalabs_handle_contact_form' );

/**
 * Process contact page submissions.
 */
function kastalabs_handle_contact_form(): void {
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

	if ( ! kastalabs_contact_rate_limit_allows_request() ) {
		wp_safe_redirect( add_query_arg( 'contact_status', 'error', $redirect ) );
		exit;
	}

	$inquiry = kastalabs_sanitize_contact_payload( $_POST );

	if ( '' === $inquiry['name'] || ! is_email( $inquiry['email'] ) || '' === $inquiry['message'] ) {
		wp_safe_redirect( add_query_arg( 'contact_status', 'error', $redirect ) );
		exit;
	}

	$inquiry_id = kastalabs_store_contact_inquiry( $inquiry, $redirect );
	$to      = kastalabs_get_option( 'contact_email', get_option( 'admin_email' ) );
	$subject = sprintf(
		/* translators: %s: sender name. */
		__( 'New Kastalabs project inquiry from %s', 'kastalabs' ),
		$inquiry['name']
	);
	$body    = implode(
		"\n\n",
		array(
			'Name: ' . $inquiry['name'],
			'Email: ' . $inquiry['email'],
			'Company: ' . ( $inquiry['company'] ?: '-' ),
			'Budget: ' . ( $inquiry['budget'] ?: '-' ),
			'Project type: ' . ( $inquiry['project_type'] ?: '-' ),
			"Message:\n" . $inquiry['message'],
		)
	);
	$headers = array( 'Reply-To: ' . $inquiry['name'] . ' <' . $inquiry['email'] . '>' );
	$sent    = wp_mail( $to, $subject, $body, $headers );

	if ( $inquiry_id ) {
		update_post_meta( $inquiry_id, 'email_status', $sent ? 'sent' : 'failed' );
	}

	wp_safe_redirect( add_query_arg( 'contact_status', ( $sent || $inquiry_id ) ? 'sent' : 'error', $redirect ) );
	exit;
}

/**
 * Sanitize the contact form payload.
 *
 * @param array<string,mixed> $payload Raw request payload.
 * @return array{name:string,email:string,company:string,budget:string,project_type:string,message:string}
 */
function kastalabs_sanitize_contact_payload( array $payload ): array {
	return array(
		'name'         => isset( $payload['name'] ) ? sanitize_text_field( wp_unslash( $payload['name'] ) ) : '',
		'email'        => isset( $payload['email'] ) ? sanitize_email( wp_unslash( $payload['email'] ) ) : '',
		'company'      => isset( $payload['company'] ) ? sanitize_text_field( wp_unslash( $payload['company'] ) ) : '',
		'budget'       => isset( $payload['budget'] ) ? sanitize_text_field( wp_unslash( $payload['budget'] ) ) : '',
		'project_type' => isset( $payload['project_type'] ) ? sanitize_text_field( wp_unslash( $payload['project_type'] ) ) : '',
		'message'      => isset( $payload['message'] ) ? sanitize_textarea_field( wp_unslash( $payload['message'] ) ) : '',
	);
}

/**
 * Store a sanitized contact inquiry in WordPress admin.
 *
 * @param array{name:string,email:string,company:string,budget:string,project_type:string,message:string} $inquiry Sanitized inquiry payload.
 */
function kastalabs_store_contact_inquiry( array $inquiry, string $source_url = '' ): int {
	$title = sprintf(
		/* translators: 1: sender name, 2: submission date. */
		__( '%1$s - %2$s', 'kastalabs' ),
		$inquiry['name'],
		wp_date( 'Y-m-d H:i' )
	);

	$post_id = wp_insert_post(
		array(
			'post_type'    => 'kasta_inquiry',
			'post_status'  => 'private',
			'post_title'   => $title,
			'post_content' => $inquiry['message'],
			'meta_input'   => array(
				'inquiry_name'   => $inquiry['name'],
				'email'          => $inquiry['email'],
				'company'        => $inquiry['company'],
				'budget'         => $inquiry['budget'],
				'project_type'   => $inquiry['project_type'],
				'inquiry_status' => 'new',
				'email_status'   => 'pending',
				'source_url'     => esc_url_raw( $source_url ),
				'user_ip_hash'   => kastalabs_contact_ip_hash(),
				'user_agent'     => kastalabs_contact_user_agent(),
			),
		)
	);

	if ( is_wp_error( $post_id ) || ! $post_id ) {
		return 0;
	}

	return (int) $post_id;
}

/**
 * Lightweight IP-based contact submission throttle.
 */
function kastalabs_contact_rate_limit_allows_request(): bool {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	if ( '' === $ip ) {
		return true;
	}

	$key      = 'kastalabs_contact_' . md5( $ip );
	$attempts = (int) get_transient( $key );

	if ( $attempts >= 5 ) {
		return false;
	}

	set_transient( $key, $attempts + 1, HOUR_IN_SECONDS );
	return true;
}

/**
 * Return a privacy-friendlier hash for the submitter IP.
 */
function kastalabs_contact_ip_hash(): string {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';

	return '' !== $ip ? hash_hmac( 'sha256', $ip, wp_salt( 'nonce' ) ) : '';
}

/**
 * Return a sanitized user agent for debugging failed deliveries.
 */
function kastalabs_contact_user_agent(): string {
	$user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';

	return substr( $user_agent, 0, 255 );
}
