<?php
/**
 * Footer template.
 *
 * @package KastaLabs
 */

defined( 'ABSPATH' ) || exit;

$footer_copy = kasta_site_option(
	'footer_copy',
	sprintf(
		/* translators: %s: site name */
		__( '%s adalah studio digital strategis yang membantu brand bergerak lebih tajam — dari strategi, identitas visual, sampai sistem digital.', 'kastalabs' ),
		get_bloginfo( 'name' )
	)
);

$address = kasta_site_option(
	'footer_address',
	'Jakarta Selatan, Indonesia — Sepenuhnya remote'
);

$social_links = array_filter(
	array(
		array(
			'url'   => kasta_site_url_option( 'instagram_url' ),
			'label' => 'Instagram',
			'icon'  => 'camera',
		),
		array(
			'url'   => kasta_site_url_option( 'linkedin_url' ),
			'label' => 'LinkedIn',
			'icon'  => 'briefcase',
		),
		array(
			'url'   => kasta_site_url_option( 'behance_url' ),
			'label' => 'Behance',
			'icon'  => 'beaker',
		),
		array(
			'url'   => kasta_site_url_option( 'email_url', 'mailto:' . kasta_contact_email() ),
			'label' => 'Email',
			'icon'  => 'envelope',
		),
	),
	fn( $l ) => ! empty( $l['url'] )
);

get_template_part(
	'template-parts/layout/footer',
	null,
	array(
		'footer_copy'  => $footer_copy,
		'address'      => $address,
		'social_links' => array_values( $social_links ),
	)
);
?>

<?php wp_footer(); ?>
</body>
</html>
