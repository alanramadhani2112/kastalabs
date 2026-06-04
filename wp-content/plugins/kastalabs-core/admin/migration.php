<?php
/**
 * Migration helpers for legacy Work content.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', 'kastalabs_register_migration_page' );

/**
 * Register migration utility under Tools.
 */
function kastalabs_register_migration_page(): void {
	add_management_page(
		__( 'Kastalabs Migration', 'kastalabs' ),
		__( 'Kastalabs Migration', 'kastalabs' ),
		'manage_options',
		'kastalabs-migration',
		'kastalabs_render_migration_page'
	);
}

/**
 * Render migration utility.
 */
function kastalabs_render_migration_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$message = '';
	if ( isset( $_POST['kastalabs_migrate_work'] ) && check_admin_referer( 'kastalabs_migrate_work' ) ) {
		$count   = kastalabs_migrate_work_to_portfolio();
		$message = sprintf(
			/* translators: %d: migrated count. */
			_n( '%d legacy work item migrated.', '%d legacy work items migrated.', $count, 'kastalabs' ),
			$count
		);
	}

	if ( isset( $_POST['kastalabs_seed_services'] ) && check_admin_referer( 'kastalabs_seed_services' ) ) {
		$count   = kastalabs_seed_default_services();
		$message = $count
			? sprintf(
				/* translators: %d: seeded count. */
				_n( '%d default service created.', '%d default services created.', $count, 'kastalabs' ),
				$count
			)
			: __( 'Default services were skipped because Service content already exists.', 'kastalabs' );
	}

	if ( isset( $_POST['kastalabs_seed_portfolio'] ) && check_admin_referer( 'kastalabs_seed_portfolio' ) ) {
		$count   = kastalabs_seed_default_portfolio();
		$message = $count
			? sprintf(
				/* translators: %d: seeded count. */
				_n( '%d starter portfolio project created.', '%d starter portfolio projects created.', $count, 'kastalabs' ),
				$count
			)
			: __( 'Starter portfolio content was skipped because all starter projects already exist.', 'kastalabs' );
	}

	if ( isset( $_POST['kastalabs_seed_insights'] ) && check_admin_referer( 'kastalabs_seed_insights' ) ) {
		$count   = kastalabs_seed_default_insights();
		$message = $count
			? sprintf(
				/* translators: %d: seeded count. */
				_n( '%d starter insight created.', '%d starter insights created.', $count, 'kastalabs' ),
				$count
			)
			: __( 'Starter insights were skipped because all starter articles already exist.', 'kastalabs' );
	}

	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Kastalabs Migration', 'kastalabs' ); ?></h1>
		<?php if ( $message ) : ?>
			<div class="notice notice-success"><p><?php echo esc_html( $message ); ?></p></div>
		<?php endif; ?>
		<h2><?php esc_html_e( 'Legacy Work Migration', 'kastalabs' ); ?></h2>
		<p><?php esc_html_e( 'Use this utility to copy legacy Work posts into the new Portfolio post type. Existing migrated items are skipped.', 'kastalabs' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'kastalabs_migrate_work' ); ?>
			<?php submit_button( __( 'Migrate Work to Portfolio', 'kastalabs' ), 'primary', 'kastalabs_migrate_work' ); ?>
		</form>

		<hr>

		<h2><?php esc_html_e( 'Default Service Content', 'kastalabs' ); ?></h2>
		<p><?php esc_html_e( 'Create the four core services from the current PRD when the Services content model is empty.', 'kastalabs' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'kastalabs_seed_services' ); ?>
			<?php submit_button( __( 'Seed Default Services', 'kastalabs' ), 'secondary', 'kastalabs_seed_services' ); ?>
		</form>

		<hr>

		<h2><?php esc_html_e( 'Starter Portfolio Content', 'kastalabs' ); ?></h2>
		<p><?php esc_html_e( 'Create missing starter portfolio projects without overwriting existing Portfolio content.', 'kastalabs' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'kastalabs_seed_portfolio' ); ?>
			<?php submit_button( __( 'Seed Starter Portfolio', 'kastalabs' ), 'secondary', 'kastalabs_seed_portfolio' ); ?>
		</form>

		<hr>

		<h2><?php esc_html_e( 'Starter Insight Content', 'kastalabs' ); ?></h2>
		<p><?php esc_html_e( 'Create missing starter insight articles without overwriting existing Insight content.', 'kastalabs' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'kastalabs_seed_insights' ); ?>
			<?php submit_button( __( 'Seed Starter Insights', 'kastalabs' ), 'secondary', 'kastalabs_seed_insights' ); ?>
		</form>
	</div>
	<?php
}

/**
 * Copy legacy work posts into portfolio posts.
 */
function kastalabs_migrate_work_to_portfolio(): int {
	$legacy_posts = get_posts(
		array(
			'post_type'      => 'work',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);

	$count = 0;
	foreach ( $legacy_posts as $legacy_id ) {
		$existing = get_posts(
			array(
				'post_type'      => 'portfolio',
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'meta_key'       => '_kastalabs_legacy_work_id',
				'meta_value'     => (string) $legacy_id,
				'fields'         => 'ids',
			)
		);

		if ( $existing ) {
			continue;
		}

		$legacy = get_post( $legacy_id );
		if ( ! $legacy instanceof WP_Post ) {
			continue;
		}

		$new_id = wp_insert_post(
			array(
				'post_type'    => 'portfolio',
				'post_status'  => $legacy->post_status,
				'post_title'   => $legacy->post_title,
				'post_name'    => $legacy->post_name,
				'post_content' => $legacy->post_content,
				'post_excerpt' => $legacy->post_excerpt,
				'post_author'  => $legacy->post_author,
				'menu_order'   => $legacy->menu_order,
			)
		);

		if ( is_wp_error( $new_id ) || ! $new_id ) {
			continue;
		}

		update_post_meta( $new_id, '_kastalabs_legacy_work_id', $legacy_id );

		$thumbnail_id = get_post_thumbnail_id( $legacy_id );
		if ( $thumbnail_id ) {
			set_post_thumbnail( $new_id, $thumbnail_id );
		}

		foreach ( get_post_meta( $legacy_id ) as $meta_key => $values ) {
			if ( str_starts_with( $meta_key, '_' ) && '_kasta_is_featured' !== $meta_key ) {
				continue;
			}
			foreach ( $values as $value ) {
				add_post_meta( $new_id, $meta_key, maybe_unserialize( $value ) );
			}
		}

		$category_names = wp_get_object_terms( $legacy_id, 'work_category', array( 'fields' => 'names' ) );
		if ( ! is_wp_error( $category_names ) && $category_names ) {
			wp_set_object_terms( $new_id, $category_names, 'portfolio_category' );
		}

		$tag_names = wp_get_object_terms( $legacy_id, 'work_tag', array( 'fields' => 'names' ) );
		if ( ! is_wp_error( $tag_names ) && $tag_names ) {
			wp_set_object_terms( $new_id, $tag_names, 'portfolio_tag' );
		}

		$count++;
	}

	return $count;
}
