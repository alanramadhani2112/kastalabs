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
add_action( 'restrict_manage_posts', 'kastalabs_render_inquiry_status_filter' );
add_filter( 'parse_query', 'kastalabs_filter_inquiries_by_status' );
add_filter( 'bulk_actions-edit-kasta_inquiry', 'kastalabs_register_inquiry_bulk_actions' );
add_filter( 'handle_bulk_actions-edit-kasta_inquiry', 'kastalabs_handle_inquiry_bulk_actions', 10, 3 );
add_action( 'admin_notices', 'kastalabs_render_inquiry_bulk_action_notice' );
add_action( 'add_meta_boxes_kasta_inquiry', 'kastalabs_register_inquiry_meta_boxes' );
add_action( 'save_post_kasta_inquiry', 'kastalabs_save_inquiry_status_meta_box' );

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
		'email_status'   => get_post_meta( $post_id, 'email_status', true ),
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
 * Return a safe label for one Inquiry status.
 */
function kastalabs_get_inquiry_status_label( string $status ): string {
	$statuses = kastalabs_inquiry_statuses();

	return $statuses[ $status ] ?? $statuses['new'];
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
}

/**
 * Render wp-admin list table filter for Inquiry status.
 */
function kastalabs_render_inquiry_status_filter( string $post_type ): void {
	if ( 'kasta_inquiry' !== $post_type ) {
		return;
	}

	$current = isset( $_GET['inquiry_status'] ) ? sanitize_key( wp_unslash( $_GET['inquiry_status'] ) ) : '';
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

	$status = isset( $_GET['inquiry_status'] ) ? sanitize_key( wp_unslash( $_GET['inquiry_status'] ) ) : '';
	if ( '' === $status || ! array_key_exists( $status, kastalabs_inquiry_statuses() ) ) {
		return;
	}

	$query->set(
		'meta_query',
		array(
			array(
				'key'   => 'inquiry_status',
				'value' => $status,
			),
		)
	);
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
