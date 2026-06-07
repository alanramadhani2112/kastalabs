<?php
/**
 * Admin settings for editable site content.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', 'kastalabs_register_settings_page' );
add_action( 'admin_init', 'kastalabs_register_settings' );

/**
 * Register settings page.
 */
function kastalabs_register_settings_page(): void {
	add_options_page(
		__( 'Kastalabs Settings', 'kastalabs' ),
		__( 'Kastalabs Settings', 'kastalabs' ),
		'manage_options',
		'kastalabs-settings',
		'kastalabs_render_settings_page'
	);
}

/**
 * Register options storage.
 */
function kastalabs_register_settings(): void {
	register_setting(
		'kastalabs_settings',
		'kastalabs_options',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'kastalabs_sanitize_options',
			'default'           => kastalabs_default_options(),
		)
	);
}

/**
 * Render settings page.
 */
function kastalabs_render_settings_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$options = kastalabs_get_options();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Kastalabs Settings', 'kastalabs' ); ?></h1>
		<p><?php esc_html_e( 'Manage global website copy, calls to action, and contact details used by the theme.', 'kastalabs' ); ?></p>

		<form method="post" action="options.php">
			<?php settings_fields( 'kastalabs_settings' ); ?>

			<h2><?php esc_html_e( 'Homepage Hero', 'kastalabs' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php kastalabs_render_text_field( $options, 'hero_eyebrow', __( 'Eyebrow', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'hero_heading', __( 'Heading', 'kastalabs' ) ); ?>
				<?php kastalabs_render_textarea_field( $options, 'hero_body', __( 'Body', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'hero_primary_label', __( 'Primary Button Label', 'kastalabs' ) ); ?>
				<?php kastalabs_render_url_field( $options, 'hero_primary_url', __( 'Primary Button URL', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'hero_secondary_label', __( 'Secondary Button Label', 'kastalabs' ) ); ?>
				<?php kastalabs_render_url_field( $options, 'hero_secondary_url', __( 'Secondary Button URL', 'kastalabs' ) ); ?>
			</table>

			<h2><?php esc_html_e( 'Homepage Services Section', 'kastalabs' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php kastalabs_render_text_field( $options, 'services_eyebrow', __( 'Eyebrow', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'services_heading', __( 'Heading', 'kastalabs' ) ); ?>
				<?php kastalabs_render_textarea_field( $options, 'services_body', __( 'Body', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'services_pill_one', __( 'Pill One', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'services_pill_two', __( 'Pill Two', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'services_pill_three', __( 'Pill Three', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'services_cta_label', __( 'Button Label', 'kastalabs' ) ); ?>
				<?php kastalabs_render_url_field( $options, 'services_cta_url', __( 'Button URL', 'kastalabs' ) ); ?>
			</table>

			<h2><?php esc_html_e( 'Homepage Portfolio Section', 'kastalabs' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php kastalabs_render_text_field( $options, 'portfolio_eyebrow', __( 'Eyebrow', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'portfolio_heading', __( 'Heading', 'kastalabs' ) ); ?>
				<?php kastalabs_render_textarea_field( $options, 'portfolio_body', __( 'Body', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'portfolio_cta_label', __( 'Button Label', 'kastalabs' ) ); ?>
				<?php kastalabs_render_url_field( $options, 'portfolio_cta_url', __( 'Button URL', 'kastalabs' ) ); ?>
			</table>

			<h2><?php esc_html_e( 'Global CTA', 'kastalabs' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php kastalabs_render_text_field( $options, 'cta_eyebrow', __( 'Eyebrow', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'cta_heading', __( 'Heading', 'kastalabs' ) ); ?>
				<?php kastalabs_render_textarea_field( $options, 'cta_body', __( 'Body', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'cta_primary_label', __( 'Primary Button Label', 'kastalabs' ) ); ?>
				<?php kastalabs_render_url_field( $options, 'cta_primary_url', __( 'Primary Button URL', 'kastalabs' ) ); ?>
			</table>

			<h2><?php esc_html_e( 'Contact And Footer', 'kastalabs' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php kastalabs_render_email_field( $options, 'contact_email', __( 'Email', 'kastalabs' ) ); ?>
				<?php kastalabs_render_url_field( $options, 'whatsapp_url', __( 'WhatsApp URL', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'company_location', __( 'Location', 'kastalabs' ) ); ?>
				<?php kastalabs_render_textarea_field( $options, 'footer_copy', __( 'Footer Copy', 'kastalabs' ) ); ?>
				<?php kastalabs_render_url_field( $options, 'instagram_url', __( 'Instagram URL', 'kastalabs' ) ); ?>
				<?php kastalabs_render_url_field( $options, 'linkedin_url', __( 'LinkedIn URL', 'kastalabs' ) ); ?>
				<?php kastalabs_render_url_field( $options, 'behance_url', __( 'Behance URL', 'kastalabs' ) ); ?>
			</table>

			<h2><?php esc_html_e( 'SEO Defaults', 'kastalabs' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php kastalabs_render_text_field( $options, 'seo_title', __( 'Default SEO Title', 'kastalabs' ) ); ?>
				<?php kastalabs_render_textarea_field( $options, 'seo_description', __( 'Default Meta Description', 'kastalabs' ) ); ?>
				<?php kastalabs_render_url_field( $options, 'og_image_url', __( 'Default OG Image URL', 'kastalabs' ) ); ?>
			</table>

			<h2><?php esc_html_e( 'SEO Main Routes', 'kastalabs' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php kastalabs_render_text_field( $options, 'seo_home_title', __( 'Home SEO Title', 'kastalabs' ) ); ?>
				<?php kastalabs_render_textarea_field( $options, 'seo_home_description', __( 'Home Meta Description', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'seo_about_title', __( 'About SEO Title', 'kastalabs' ) ); ?>
				<?php kastalabs_render_textarea_field( $options, 'seo_about_description', __( 'About Meta Description', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'seo_services_title', __( 'Services SEO Title', 'kastalabs' ) ); ?>
				<?php kastalabs_render_textarea_field( $options, 'seo_services_description', __( 'Services Meta Description', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'seo_portfolio_title', __( 'Portfolio SEO Title', 'kastalabs' ) ); ?>
				<?php kastalabs_render_textarea_field( $options, 'seo_portfolio_description', __( 'Portfolio Meta Description', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'seo_insights_title', __( 'Insights SEO Title', 'kastalabs' ) ); ?>
				<?php kastalabs_render_textarea_field( $options, 'seo_insights_description', __( 'Insights Meta Description', 'kastalabs' ) ); ?>
				<?php kastalabs_render_text_field( $options, 'seo_contact_title', __( 'Contact SEO Title', 'kastalabs' ) ); ?>
				<?php kastalabs_render_textarea_field( $options, 'seo_contact_description', __( 'Contact Meta Description', 'kastalabs' ) ); ?>
			</table>

			<h2><?php esc_html_e( 'Analytics', 'kastalabs' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php kastalabs_render_text_field( $options, 'analytics_id', __( 'Google Analytics Measurement ID', 'kastalabs' ) ); ?>
			</table>

			<h2><?php esc_html_e( 'Legacy Routes', 'kastalabs' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				kastalabs_render_checkbox_field(
					$options,
					'legacy_work_redirect_enabled',
					__( 'Redirect legacy Work routes', 'kastalabs' ),
					__( 'Redirect /work/ to /portfolio/ only after migration has no pending legacy items. Single Work URLs redirect only when a migrated Portfolio match exists.', 'kastalabs' )
				);
				?>
			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * Render a text input row.
 */
function kastalabs_render_text_field( array $options, string $key, string $label ): void {
	kastalabs_render_input_field( $options, $key, $label, 'text' );
}

/**
 * Render a URL input row.
 */
function kastalabs_render_url_field( array $options, string $key, string $label ): void {
	kastalabs_render_input_field( $options, $key, $label, 'url' );
}

/**
 * Render an email input row.
 */
function kastalabs_render_email_field( array $options, string $key, string $label ): void {
	kastalabs_render_input_field( $options, $key, $label, 'email' );
}

/**
 * Render a checkbox row.
 */
function kastalabs_render_checkbox_field( array $options, string $key, string $label, string $description = '' ): void {
	?>
	<tr>
		<th scope="row"><?php echo esc_html( $label ); ?></th>
		<td>
			<label for="kastalabs_<?php echo esc_attr( $key ); ?>">
				<input
					id="kastalabs_<?php echo esc_attr( $key ); ?>"
					type="checkbox"
					name="kastalabs_options[<?php echo esc_attr( $key ); ?>]"
					value="1"
					<?php checked( $options[ $key ] ?? '', '1' ); ?>
				>
				<?php echo esc_html( $description ); ?>
			</label>
		</td>
	</tr>
	<?php
}

/**
 * Render an input row.
 */
function kastalabs_render_input_field( array $options, string $key, string $label, string $type ): void {
	?>
	<tr>
		<th scope="row"><label for="kastalabs_<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
		<td>
			<input
				id="kastalabs_<?php echo esc_attr( $key ); ?>"
				class="regular-text"
				type="<?php echo esc_attr( $type ); ?>"
				name="kastalabs_options[<?php echo esc_attr( $key ); ?>]"
				value="<?php echo esc_attr( $options[ $key ] ?? '' ); ?>"
			>
		</td>
	</tr>
	<?php
}

/**
 * Render a textarea row.
 */
function kastalabs_render_textarea_field( array $options, string $key, string $label ): void {
	?>
	<tr>
		<th scope="row"><label for="kastalabs_<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
		<td>
			<textarea
				id="kastalabs_<?php echo esc_attr( $key ); ?>"
				class="large-text"
				rows="4"
				name="kastalabs_options[<?php echo esc_attr( $key ); ?>]"
			><?php echo esc_textarea( $options[ $key ] ?? '' ); ?></textarea>
		</td>
	</tr>
	<?php
}
