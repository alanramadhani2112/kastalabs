<?php
/**
 * Inquiry post type.
 *
 * Stores contact form submissions inside WordPress admin.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'kastalabs_register_inquiry_post_type' );
add_filter( 'manage_kasta_inquiry_posts_columns', 'kastalabs_inquiry_admin_columns' );
add_action( 'manage_kasta_inquiry_posts_custom_column', 'kastalabs_render_inquiry_admin_column', 10, 2 );
add_filter( 'manage_edit-kasta_inquiry_sortable_columns', 'kastalabs_inquiry_sortable_columns' );
add_action( 'restrict_manage_posts', 'kastalabs_render_inquiry_status_filter' );
add_filter( 'parse_query', 'kastalabs_filter_inquiries_by_status' );
add_filter( 'bulk_actions-edit-kasta_inquiry', 'kastalabs_register_inquiry_bulk_actions' );
add_filter( 'handle_bulk_actions-edit-kasta_inquiry', 'kastalabs_handle_inquiry_bulk_actions', 10, 3 );
add_action( 'admin_notices', 'kastalabs_render_inquiry_bulk_action_notice' );
add_action( 'add_meta_boxes_kasta_inquiry', 'kastalabs_register_inquiry_meta_boxes' );
add_action( 'save_post_kasta_inquiry', 'kastalabs_save_inquiry_status_meta_box' );
add_action( 'admin_post_kastalabs_export_inquiries', 'kastalabs_export_inquiries_csv' );

/**
 * Register private Inquiry CPT for contact submissions.
 */
function kastalabs_register_inquiry_post_type(): void {
	register_post_type(
		'kasta_inquiry',
		array(
			'labels'              => array(
				'name'          => __( 'Inquiries', 'kastalabs' ),
				'singular_name' => __( 'Inquiry', 'kastalabs' ),
				'menu_name'     => __( 'Inquiries', 'kastalabs' ),
				'edit_item'     => __( 'View Inquiry', 'kastalabs' ),
				'search_items'  => __( 'Search Inquiries', 'kastalabs' ),
				'not_found'     => __( 'No inquiries found', 'kastalabs' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => false,
			'menu_position'       => 8,
			'menu_icon'           => 'dashicons-email-alt2',
			'supports'            => array( 'title', 'editor', 'custom-fields' ),
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
		)
	);
}

/**
 * Customize Inquiry list table columns.
 */
function kastalabs_inquiry_admin_columns( array $columns ): array {
	return array(
		'cb'             => $columns['cb'] ?? '<input type="checkbox" />',
		'title'          => __( 'Inquiry', 'kastalabs' ),
		'inquiry_name'   => __( 'Name', 'kastalabs' ),
		'email'          => __( 'Email', 'kastalabs' ),
		'project_type'   => __( 'Project Type', 'kastalabs' ),
		'inquiry_status' => __( 'Lead Status', 'kastalabs' ),
		'follow_up_date' => __( 'Follow Up', 'kastalabs' ),
		'email_status'   => __( 'Email Status', 'kastalabs' ),
		'date'           => $columns['date'] ?? __( 'Date', 'kastalabs' ),
	);
}

/**
 * Render Inquiry list table custom column values.
 */
function kastalabs_render_inquiry_admin_column( string $column, int $post_id ): void {
	$value = match ( $column ) {
		'inquiry_name'   => get_post_meta( $post_id, 'inquiry_name', true ),
		'email'          => get_post_meta( $post_id, 'email', true ),
		'project_type'   => get_post_meta( $post_id, 'project_type', true ),
		'inquiry_status' => kastalabs_get_inquiry_status_label( (string) get_post_meta( $post_id, 'inquiry_status', true ) ),
		'follow_up_date' => kastalabs_format_inquiry_follow_up_date( (string) get_post_meta( $post_id, 'follow_up_date', true ) ),
		'email_status'   => kastalabs_get_inquiry_email_status_label( (string) get_post_meta( $post_id, 'email_status', true ) ),
		default          => '',
	};

	if ( 'email' === $column && $value ) {
		printf(
			'<a href="%s">%s</a>',
			esc_url( 'mailto:' . $value ),
			esc_html( $value )
		);
		return;
	}

	echo esc_html( $value ?: '-' );
}

/**
 * Mark useful Inquiry columns as sortable.
 */
function kastalabs_inquiry_sortable_columns( array $columns ): array {
	$columns['inquiry_status'] = 'inquiry_status';
	$columns['follow_up_date'] = 'follow_up_date';
	$columns['email_status']   = 'email_status';

	return $columns;
}

/**
 * Return allowed lead statuses for Inquiry records.
 *
 * @return array<string,string>
 */
function kastalabs_inquiry_statuses(): array {
	return array(
		'new'       => __( 'New', 'kastalabs' ),
		'contacted' => __( 'Contacted', 'kastalabs' ),
		'qualified' => __( 'Qualified', 'kastalabs' ),
		'closed'    => __( 'Closed', 'kastalabs' ),
	);
}

/**
 * Return known email delivery states for Inquiry records.
 *
 * @return array<string,string>
 */
function kastalabs_inquiry_email_statuses(): array {
	return array(
		'pending' => __( 'Pending', 'kastalabs' ),
		'sent'    => __( 'Sent', 'kastalabs' ),
		'failed'  => __( 'Failed', 'kastalabs' ),
	);
}

/**
 * Return a safe label for one Inquiry email delivery state.
 */
function kastalabs_get_inquiry_email_status_label( string $status ): string {
	$statuses = kastalabs_inquiry_email_statuses();

	return $statuses[ $status ] ?? $statuses['pending'];
}

/**
 * Return a safe label for one Inquiry status.
 */
function kastalabs_get_inquiry_status_label( string $status ): string {
	$statuses = kastalabs_inquiry_statuses();

	return $statuses[ $status ] ?? $statuses['new'];
}

/**
 * Sanitize an Inquiry follow-up date in YYYY-MM-DD format.
 */
function kastalabs_sanitize_inquiry_follow_up_date( string $date ): string {
	$date = trim( $date );

	if ( '' === $date || ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) ) {
		return '';
	}

	$parts = array_map( 'absint', explode( '-', $date ) );

	return checkdate( $parts[1], $parts[2], $parts[0] ) ? $date : '';
}

/**
 * Format an Inquiry follow-up date for admin display.
 */
function kastalabs_format_inquiry_follow_up_date( string $date ): string {
	$date = kastalabs_sanitize_inquiry_follow_up_date( $date );

	if ( '' === $date ) {
		return '';
	}

	return wp_date( get_option( 'date_format' ), strtotime( $date . ' 00:00:00' ) );
}

/**
 * Register admin meta boxes for Inquiry details.
 */
function kastalabs_register_inquiry_meta_boxes(): void {
	add_meta_box(
		'kastalabs_inquiry_details',
		__( 'Inquiry Details', 'kastalabs' ),
		'kastalabs_render_inquiry_details_meta_box',
		'kasta_inquiry',
		'normal',
		'high'
	);
}

/**
 * Render readable Inquiry details and lead status control.
 */
function kastalabs_render_inquiry_details_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'kastalabs_save_inquiry_details', 'kastalabs_inquiry_details_nonce' );

	$current_status = (string) get_post_meta( $post->ID, 'inquiry_status', true );
	$follow_up_date = kastalabs_sanitize_inquiry_follow_up_date( (string) get_post_meta( $post->ID, 'follow_up_date', true ) );
	$internal_notes = (string) get_post_meta( $post->ID, 'internal_notes', true );
	$fields         = array(
		__( 'Name', 'kastalabs' )         => get_post_meta( $post->ID, 'inquiry_name', true ),
		__( 'Email', 'kastalabs' )        => get_post_meta( $post->ID, 'email', true ),
		__( 'Company', 'kastalabs' )      => get_post_meta( $post->ID, 'company', true ),
		__( 'Budget', 'kastalabs' )       => get_post_meta( $post->ID, 'budget', true ),
		__( 'Project Type', 'kastalabs' ) => get_post_meta( $post->ID, 'project_type', true ),
		__( 'Email Status', 'kastalabs' ) => get_post_meta( $post->ID, 'email_status', true ),
		__( 'Source URL', 'kastalabs' )   => get_post_meta( $post->ID, 'source_url', true ),
	);
	?>
	<p>
		<label for="kastalabs_inquiry_status"><strong><?php esc_html_e( 'Lead Status', 'kastalabs' ); ?></strong></label>
	</p>
	<select id="kastalabs_inquiry_status" name="kastalabs_inquiry_status">
		<?php foreach ( kastalabs_inquiry_statuses() as $value => $label ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $current_status ?: 'new', $value ); ?>>
				<?php echo esc_html( $label ); ?>
			</option>
		<?php endforeach; ?>
	</select>

	<p style="margin-top: 1rem;">
		<label for="kastalabs_follow_up_date"><strong><?php esc_html_e( 'Follow Up Date', 'kastalabs' ); ?></strong></label>
	</p>
	<input
		type="date"
		id="kastalabs_follow_up_date"
		name="kastalabs_follow_up_date"
		value="<?php echo esc_attr( $follow_up_date ); ?>"
	/>

	<p style="margin-top: 1rem;">
		<label for="kastalabs_internal_notes"><strong><?php esc_html_e( 'Internal Notes', 'kastalabs' ); ?></strong></label>
	</p>
	<textarea
		id="kastalabs_internal_notes"
		name="kastalabs_internal_notes"
		rows="5"
		class="large-text"
	><?php echo esc_textarea( $internal_notes ); ?></textarea>

	<table class="widefat striped" style="margin-top: 1rem;">
		<tbody>
			<?php foreach ( $fields as $label => $value ) : ?>
				<tr>
					<th scope="row" style="width: 180px;"><?php echo esc_html( $label ); ?></th>
					<td><?php echo esc_html( (string) ( $value ?: '-' ) ); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php
}

/**
 * Save lead status from the Inquiry details meta box.
 */
function kastalabs_save_inquiry_status_meta_box( int $post_id ): void {
	if ( ! isset( $_POST['kastalabs_inquiry_details_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kastalabs_inquiry_details_nonce'] ) ), 'kastalabs_save_inquiry_details' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$status = isset( $_POST['kastalabs_inquiry_status'] ) ? sanitize_key( wp_unslash( $_POST['kastalabs_inquiry_status'] ) ) : '';
	if ( ! array_key_exists( $status, kastalabs_inquiry_statuses() ) ) {
		return;
	}

	update_post_meta( $post_id, 'inquiry_status', $status );

	$follow_up_date = isset( $_POST['kastalabs_follow_up_date'] ) ? kastalabs_sanitize_inquiry_follow_up_date( sanitize_text_field( wp_unslash( $_POST['kastalabs_follow_up_date'] ) ) ) : '';
	if ( '' === $follow_up_date ) {
		delete_post_meta( $post_id, 'follow_up_date' );
	} else {
		update_post_meta( $post_id, 'follow_up_date', $follow_up_date );
	}

	$internal_notes = isset( $_POST['kastalabs_internal_notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['kastalabs_internal_notes'] ) ) : '';
	if ( '' === $internal_notes ) {
		delete_post_meta( $post_id, 'internal_notes' );
	} else {
		update_post_meta( $post_id, 'internal_notes', $internal_notes );
	}
}

/**
 * Render wp-admin list table filter for Inquiry status.
 */
function kastalabs_render_inquiry_status_filter( string $post_type ): void {
	if ( 'kasta_inquiry' !== $post_type ) {
		return;
	}

	$current       = isset( $_GET['inquiry_status'] ) ? sanitize_key( wp_unslash( $_GET['inquiry_status'] ) ) : '';
	$email_status  = isset( $_GET['email_status'] ) ? sanitize_key( wp_unslash( $_GET['email_status'] ) ) : '';
	$follow_up     = isset( $_GET['follow_up'] ) ? sanitize_key( wp_unslash( $_GET['follow_up'] ) ) : '';
	$export_url = wp_nonce_url(
		add_query_arg(
			array_filter(
				array(
					'action'         => 'kastalabs_export_inquiries',
					'inquiry_status' => $current,
					'email_status'   => $email_status,
					'follow_up'      => $follow_up,
				),
				static fn( string $value ): bool => '' !== $value
			),
			admin_url( 'admin-post.php' )
		),
		'kastalabs_export_inquiries'
	);
	?>
	<label class="screen-reader-text" for="kastalabs_inquiry_status_filter">
		<?php esc_html_e( 'Filter by inquiry status', 'kastalabs' ); ?>
	</label>
	<select id="kastalabs_inquiry_status_filter" name="inquiry_status">
		<option value=""><?php esc_html_e( 'All lead statuses', 'kastalabs' ); ?></option>
		<?php foreach ( kastalabs_inquiry_statuses() as $value => $label ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $current, $value ); ?>>
				<?php echo esc_html( $label ); ?>
			</option>
		<?php endforeach; ?>
	</select>
	<label class="screen-reader-text" for="kastalabs_email_status_filter">
		<?php esc_html_e( 'Filter by email status', 'kastalabs' ); ?>
	</label>
	<select id="kastalabs_email_status_filter" name="email_status">
		<option value=""><?php esc_html_e( 'All email statuses', 'kastalabs' ); ?></option>
		<?php foreach ( kastalabs_inquiry_email_statuses() as $value => $label ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $email_status, $value ); ?>>
				<?php echo esc_html( $label ); ?>
			</option>
		<?php endforeach; ?>
	</select>
	<label class="screen-reader-text" for="kastalabs_follow_up_filter">
		<?php esc_html_e( 'Filter by follow-up state', 'kastalabs' ); ?>
	</label>
	<select id="kastalabs_follow_up_filter" name="follow_up">
		<option value=""><?php esc_html_e( 'All follow-up states', 'kastalabs' ); ?></option>
		<option value="due" <?php selected( $follow_up, 'due' ); ?>><?php esc_html_e( 'Due today or earlier', 'kastalabs' ); ?></option>
		<option value="upcoming" <?php selected( $follow_up, 'upcoming' ); ?>><?php esc_html_e( 'Upcoming', 'kastalabs' ); ?></option>
		<option value="none" <?php selected( $follow_up, 'none' ); ?>><?php esc_html_e( 'No follow-up date', 'kastalabs' ); ?></option>
	</select>
	<a class="button" href="<?php echo esc_url( $export_url ); ?>">
		<?php esc_html_e( 'Export CSV', 'kastalabs' ); ?>
	</a>
	<?php
}

/**
 * Apply wp-admin list table Inquiry status filter.
 */
function kastalabs_filter_inquiries_by_status( WP_Query $query ): void {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	$post_type = $query->get( 'post_type' );
	if ( 'kasta_inquiry' !== $post_type ) {
		return;
	}

	$meta_query = array();

	$status = isset( $_GET['inquiry_status'] ) ? sanitize_key( wp_unslash( $_GET['inquiry_status'] ) ) : '';
	if ( '' !== $status && array_key_exists( $status, kastalabs_inquiry_statuses() ) ) {
		$meta_query[] = array(
			'key'   => 'inquiry_status',
			'value' => $status,
		);
	}

	$email_status = isset( $_GET['email_status'] ) ? sanitize_key( wp_unslash( $_GET['email_status'] ) ) : '';
	if ( '' !== $email_status && array_key_exists( $email_status, kastalabs_inquiry_email_statuses() ) ) {
		$meta_query[] = array(
			'key'   => 'email_status',
			'value' => $email_status,
		);
	}

	$follow_up = isset( $_GET['follow_up'] ) ? sanitize_key( wp_unslash( $_GET['follow_up'] ) ) : '';
	if ( 'due' === $follow_up ) {
		$meta_query[] = array(
			'key'     => 'follow_up_date',
			'value'   => wp_date( 'Y-m-d' ),
			'compare' => '<=',
			'type'    => 'DATE',
		);
	} elseif ( 'upcoming' === $follow_up ) {
		$meta_query[] = array(
			'key'     => 'follow_up_date',
			'value'   => wp_date( 'Y-m-d' ),
			'compare' => '>',
			'type'    => 'DATE',
		);
	} elseif ( 'none' === $follow_up ) {
		$meta_query[] = array(
			'relation' => 'OR',
			array(
				'key'     => 'follow_up_date',
				'value'   => '',
				'compare' => '=',
			),
			array(
				'key'     => 'follow_up_date',
				'compare' => 'NOT EXISTS',
			),
		);
	}

	if ( $meta_query ) {
		$query->set( 'meta_query', $meta_query );
	}

	$orderby = $query->get( 'orderby' );
	if ( in_array( $orderby, array( 'inquiry_status', 'follow_up_date', 'email_status' ), true ) ) {
		$query->set( 'meta_key', $orderby );
		$query->set( 'orderby', 'follow_up_date' === $orderby ? 'meta_value' : 'meta_value' );
	}
}

/**
 * Register bulk actions for lead status updates.
 */
function kastalabs_register_inquiry_bulk_actions( array $actions ): array {
	foreach ( kastalabs_inquiry_statuses() as $status => $label ) {
		$actions[ 'kastalabs_mark_' . $status ] = sprintf(
			/* translators: %s: lead status label. */
			__( 'Mark as %s', 'kastalabs' ),
			$label
		);
	}

	return $actions;
}

/**
 * Handle lead status bulk actions.
 *
 * @param string $redirect_url Redirect URL.
 * @param string $action       Bulk action key.
 * @param int[]  $post_ids     Selected post IDs.
 */
function kastalabs_handle_inquiry_bulk_actions( string $redirect_url, string $action, array $post_ids ): string {
	if ( ! str_starts_with( $action, 'kastalabs_mark_' ) ) {
		return $redirect_url;
	}

	$status = substr( $action, strlen( 'kastalabs_mark_' ) );
	if ( ! array_key_exists( $status, kastalabs_inquiry_statuses() ) ) {
		return $redirect_url;
	}

	$updated = 0;
	foreach ( $post_ids as $post_id ) {
		if ( 'kasta_inquiry' !== get_post_type( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
			continue;
		}

		update_post_meta( $post_id, 'inquiry_status', $status );
		$updated++;
	}

	return add_query_arg(
		array(
			'kastalabs_inquiry_updated' => $updated,
			'kastalabs_inquiry_status'  => $status,
		),
		$redirect_url
	);
}

/**
 * Show a notice after Inquiry bulk status updates.
 */
function kastalabs_render_inquiry_bulk_action_notice(): void {
	if ( empty( $_GET['kastalabs_inquiry_updated'] ) || empty( $_GET['kastalabs_inquiry_status'] ) ) {
		return;
	}

	$count  = absint( $_GET['kastalabs_inquiry_updated'] );
	$status = sanitize_key( wp_unslash( $_GET['kastalabs_inquiry_status'] ) );
	if ( ! $count || ! array_key_exists( $status, kastalabs_inquiry_statuses() ) ) {
		return;
	}

	printf(
		'<div class="notice notice-success is-dismissible"><p>%s</p></div>',
		esc_html(
			sprintf(
				/* translators: 1: number of inquiries, 2: lead status label. */
				_n( '%1$d inquiry marked as %2$s.', '%1$d inquiries marked as %2$s.', $count, 'kastalabs' ),
				$count,
				kastalabs_get_inquiry_status_label( $status )
			)
		)
	);
}

/**
 * Export Inquiry records as CSV for backend lead operations.
 */
function kastalabs_export_inquiries_csv(): void {
	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_die( esc_html__( 'You do not have permission to export inquiries.', 'kastalabs' ) );
	}

	check_admin_referer( 'kastalabs_export_inquiries' );

	$status = isset( $_GET['inquiry_status'] ) ? sanitize_key( wp_unslash( $_GET['inquiry_status'] ) ) : '';
	if ( '' !== $status && ! array_key_exists( $status, kastalabs_inquiry_statuses() ) ) {
		$status = '';
	}
	$email_status = isset( $_GET['email_status'] ) ? sanitize_key( wp_unslash( $_GET['email_status'] ) ) : '';
	if ( '' !== $email_status && ! array_key_exists( $email_status, kastalabs_inquiry_email_statuses() ) ) {
		$email_status = '';
	}
	$follow_up = isset( $_GET['follow_up'] ) ? sanitize_key( wp_unslash( $_GET['follow_up'] ) ) : '';
	if ( ! in_array( $follow_up, array( 'due', 'upcoming', 'none' ), true ) ) {
		$follow_up = '';
	}

	$filename = 'kastalabs-inquiries-' . wp_date( 'Y-m-d-His' ) . '.csv';
	nocache_headers();
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=' . $filename );

	$output = fopen( 'php://output', 'w' );
	if ( false === $output ) {
		exit;
	}

	fputcsv(
		$output,
		array(
			'Submitted At',
			'Name',
			'Email',
			'Company',
			'Budget',
			'Project Type',
			'Lead Status',
			'Follow Up Date',
			'Internal Notes',
			'Email Status',
			'Source URL',
			'Message',
		)
	);

	foreach ( kastalabs_get_inquiries_for_export( $status, $email_status, $follow_up ) as $post ) {
		fputcsv(
			$output,
			array(
				get_date_from_gmt( $post->post_date_gmt, 'Y-m-d H:i:s' ),
				(string) get_post_meta( $post->ID, 'inquiry_name', true ),
				(string) get_post_meta( $post->ID, 'email', true ),
				(string) get_post_meta( $post->ID, 'company', true ),
				(string) get_post_meta( $post->ID, 'budget', true ),
				(string) get_post_meta( $post->ID, 'project_type', true ),
				kastalabs_get_inquiry_status_label( (string) get_post_meta( $post->ID, 'inquiry_status', true ) ),
				(string) get_post_meta( $post->ID, 'follow_up_date', true ),
				(string) get_post_meta( $post->ID, 'internal_notes', true ),
				kastalabs_get_inquiry_email_status_label( (string) get_post_meta( $post->ID, 'email_status', true ) ),
				(string) get_post_meta( $post->ID, 'source_url', true ),
				wp_strip_all_tags( $post->post_content ),
			)
		);
	}

	fclose( $output );
	exit;
}

/**
 * Return private Inquiry posts for CSV export.
 *
 * @return WP_Post[]
 */
function kastalabs_get_inquiries_for_export( string $status = '', string $email_status = '', string $follow_up = '' ): array {
	$args = array(
		'post_type'      => 'kasta_inquiry',
		'post_status'    => 'private',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$meta_query = array();
	if ( '' !== $status && array_key_exists( $status, kastalabs_inquiry_statuses() ) ) {
		$meta_query[] = array(
			'key'   => 'inquiry_status',
			'value' => $status,
		);
	}
	if ( '' !== $email_status && array_key_exists( $email_status, kastalabs_inquiry_email_statuses() ) ) {
		$meta_query[] = array(
			'key'   => 'email_status',
			'value' => $email_status,
		);
	}
	if ( 'due' === $follow_up ) {
		$meta_query[] = array(
			'key'     => 'follow_up_date',
			'value'   => wp_date( 'Y-m-d' ),
			'compare' => '<=',
			'type'    => 'DATE',
		);
	} elseif ( 'upcoming' === $follow_up ) {
		$meta_query[] = array(
			'key'     => 'follow_up_date',
			'value'   => wp_date( 'Y-m-d' ),
			'compare' => '>',
			'type'    => 'DATE',
		);
	} elseif ( 'none' === $follow_up ) {
		$meta_query[] = array(
			'relation' => 'OR',
			array(
				'key'     => 'follow_up_date',
				'value'   => '',
				'compare' => '=',
			),
			array(
				'key'     => 'follow_up_date',
				'compare' => 'NOT EXISTS',
			),
		);
	}

	if ( $meta_query ) {
		$args['meta_query'] = $meta_query;
	}

	return get_posts( $args );
}
