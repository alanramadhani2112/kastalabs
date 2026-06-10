<?php
/**
 * Seed helpers for initial CMS content.
 *
 * @package KastalabsCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add the four core Service posts when the site has no services yet.
 */
function kastalabs_seed_default_services(): int {
	$existing = get_posts(
		array(
			'post_type'      => 'service',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( $existing ) {
		return 0;
	}

	$services = array(
		array(
			'title'           => 'Branding Design',
			'slug'            => 'branding-design',
			'overview'        => 'Membangun identitas visual yang kuat, konsisten, dan mampu memperjelas posisi brand di mata audiens.',
			'benefits'        => 'Brand terasa lebih profesional, mudah dikenali, dan memiliki sistem visual yang siap digunakan lintas media.',
			'workflow'        => 'Discovery, brand direction, visual identity exploration, design system, dan final brand assets.',
			'expected_impact' => 'Komunikasi brand menjadi lebih jelas, konsisten, dan mudah dikembangkan.',
			'inclusions'      => "Logo & identity system\nBrand guidelines\nVisual language\nCollateral design",
		),
		array(
			'title'           => 'UI/UX Design',
			'slug'            => 'ui-ux-design',
			'overview'        => 'Merancang pengalaman digital yang intuitif, human-centered, dan selaras dengan tujuan bisnis.',
			'benefits'        => 'Pengguna lebih mudah memahami alur, menemukan informasi, dan mengambil tindakan penting.',
			'workflow'        => 'Research, information architecture, wireframe, interface design, prototype, dan design handoff.',
			'expected_impact' => 'Produk digital terasa lebih nyaman digunakan dan lebih siap untuk dikembangkan.',
			'inclusions'      => "User flow\nWireframe\nPrototype\nDesign system\nInteraction design",
		),
		array(
			'title'           => 'Web Development',
			'slug'            => 'web-development',
			'overview'        => 'Membangun website modern yang cepat, terstruktur, mudah dikelola, dan siap berkembang bersama bisnis.',
			'benefits'        => 'Website menjadi lebih kredibel, performatif, dan mudah diperbarui oleh tim internal.',
			'workflow'        => 'Technical planning, frontend development, CMS integration, QA, optimization, dan launch support.',
			'expected_impact' => 'Website dapat menjadi kanal utama untuk membangun kepercayaan dan menghasilkan konversi.',
			'inclusions'      => "Custom WordPress\nCompany profile\nLanding page\nCMS setup\nPerformance basics",
		),
		array(
			'title'           => 'Custom Software Development',
			'slug'            => 'custom-software-development',
			'overview'        => 'Mengembangkan sistem digital custom untuk membantu proses kerja bisnis menjadi lebih efisien dan terukur.',
			'benefits'        => 'Operasional lebih rapi, data lebih mudah dikelola, dan proses manual dapat dikurangi.',
			'workflow'        => 'Requirement mapping, system architecture, development, testing, deployment, dan iteration.',
			'expected_impact' => 'Bisnis memiliki sistem yang lebih sesuai dengan proses internal dan target pertumbuhan.',
			'inclusions'      => "Web apps\nInternal tools\nAPI integration\nAutomation",
		),
	);

	$count = 0;
	$contact_url = kastalabs_default_contact_url();

	foreach ( $services as $index => $service ) {
		$post_id = wp_insert_post(
			array(
				'post_type'    => 'service',
				'post_status'  => 'publish',
				'post_title'   => $service['title'],
				'post_name'    => $service['slug'],
				'post_excerpt' => $service['overview'],
				'post_content' => $service['overview'],
				'menu_order'   => $index + 1,
			)
		);

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		update_post_meta( $post_id, 'overview', $service['overview'] );
		update_post_meta( $post_id, 'benefits', $service['benefits'] );
		update_post_meta( $post_id, 'workflow', $service['workflow'] );
		update_post_meta( $post_id, 'expected_impact', $service['expected_impact'] );
		update_post_meta( $post_id, 'inclusions', $service['inclusions'] ?? '' );
		update_post_meta( $post_id, 'cta_label', __( 'Ceritakan proyek Anda', 'kastalabs' ) );
		update_post_meta( $post_id, 'cta_url', $contact_url );
		update_post_meta( $post_id, 'icon_label', sprintf( '%02d', $index + 1 ) );

		$count++;
	}

	return $count;
}

/**
 * Add missing starter Portfolio posts without overwriting existing content.
 */
function kastalabs_seed_default_portfolio(): int {
	$projects = array(
		array(
			'title'        => 'Kasta Identity System',
			'slug'         => 'kasta-identity-system',
			'client'       => 'Kastalabs',
			'year'         => 2026,
			'role'         => 'Brand Strategy, Visual Identity',
			'scope'        => 'Brand direction, identity system, digital guidelines',
			'category'     => 'Brand Identity',
			'tags'         => array( 'Strategy', 'Visual System', 'Guidelines' ),
			'excerpt'      => 'Sistem identitas visual untuk memperjelas karakter brand, arah komunikasi, dan konsistensi aset digital.',
			'context'      => 'Kastalabs sebagai studio baru membutuhkan sistem identitas yang bisa langsung dipakai di website, proposal, dan media sosial tanpa harus merancang ulang setiap kali.',
			'challenge'    => 'Brand membutuhkan bahasa visual yang lebih jelas agar dapat digunakan lintas website, presentasi, dan komunikasi sosial tanpa kehilangan karakter.',
			'approach'     => 'Kami memulai dari positioning dan audiens, lalu membangun prinsip visual, palet warna, sistem tipografi, dan komponen grafis yang bisa diterapkan konsisten.',
			'solution'     => 'Kastalabs menyusun direction, prinsip visual, sistem warna, tipografi, komponen grafis, dan aturan penggunaan yang mudah diterapkan tim.',
			'results'      => 'Brand memiliki fondasi visual yang lebih konsisten, mudah dikembangkan, dan siap dipakai untuk kebutuhan digital maupun komunikasi bisnis.',
			'technologies' => 'Brand system, design direction, documentation',
		),
		array(
			'title'        => 'Founder Growth Website',
			'slug'         => 'founder-growth-website',
			'client'       => 'Growth Studio',
			'year'         => 2026,
			'role'         => 'UX Design, WordPress Development',
			'scope'        => 'Landing page, CMS architecture, conversion flow',
			'category'     => 'Web Development',
			'tags'         => array( 'WordPress', 'Landing Page', 'CMS' ),
			'excerpt'      => 'Landing page berbasis WordPress untuk membantu founder menjelaskan layanan, kredibilitas, dan alur inquiry dengan lebih ringkas.',
			'context'      => 'Growth Studio sedang tumbuh dan membutuhkan website yang mudah diperbarui sendiri oleh tim marketing tanpa bantuan developer.',
			'challenge'    => 'Website lama terlalu generik dan sulit dikelola, sehingga tim marketing tidak punya ruang yang cukup untuk menyesuaikan pesan.',
			'approach'     => 'Kami merancang struktur halaman modular, menyiapkan komponen konten yang bisa di-edit sendiri, dan menghubungkan CTA ke alur inquiry.',
			'solution'     => 'Kami membangun struktur halaman yang lebih fokus, komponen konten yang editable, dan CTA yang tersambung ke alur inquiry.',
			'results'      => 'Konten utama lebih mudah diperbarui dan pengunjung dapat memahami penawaran, bukti kerja, serta langkah kontak dengan lebih cepat.',
			'technologies' => 'WordPress, Tailwind CSS, Vite',
		),
		array(
			'title'        => 'Ops Dashboard Experience',
			'slug'         => 'ops-dashboard-experience',
			'client'       => 'Operational Team',
			'year'         => 2026,
			'role'         => 'Product Design, Interface System',
			'scope'        => 'Information architecture, dashboard UI, component system',
			'category'     => 'UI/UX Design',
			'tags'         => array( 'Dashboard', 'Product Design', 'Design System' ),
			'excerpt'      => 'Perancangan dashboard operasional yang membantu tim membaca status, prioritas, dan tindakan penting secara cepat.',
			'context'      => 'Tim operasional perusahaan teknologi membutuhkan antarmuka yang menyatukan berbagai metrik ke dalam satu tampilan yang mudah dipindai.',
			'challenge'    => 'Data operasional tersebar di banyak tampilan dan membuat tim sulit menentukan prioritas harian.',
			'approach'     => 'Kami melakukan riset alur kerja tim, menyusun ulang hierarki informasi, dan merancang pola scanning berbasis prioritas.',
			'solution'     => 'Kami menyusun ulang hierarki informasi, merancang pola scanning, dan membangun komponen interface yang konsisten.',
			'results'      => 'Alur pemantauan menjadi lebih ringkas, status penting lebih mudah ditemukan, dan interface siap diterjemahkan ke development.',
			'technologies' => 'UX research, interface design, component system',
		),
		array(
			'title'        => 'Content Operating Kit',
			'slug'         => 'content-operating-kit',
			'client'       => 'Marketing Team',
			'year'         => 2026,
			'role'         => 'Content System, CMS Planning',
			'scope'        => 'Content model, editorial workflow, reusable page modules',
			'category'     => 'Content System',
			'tags'         => array( 'Content Model', 'Editorial', 'Workflow' ),
			'excerpt'      => 'Sistem konten untuk membantu tim menyusun halaman, insight, dan aset komunikasi tanpa bergantung pada developer setiap saat.',
			'context'      => 'Tim marketing memiliki volume materi komunikasi yang tinggi tetapi tidak punya model konten yang memungkinkan mereka bergerak cepat.',
			'challenge'    => 'Tim memiliki banyak materi komunikasi, tetapi belum memiliki model konten dan workflow editorial yang terstruktur.',
			'approach'     => 'Kami memetakan jenis konten, merancang field CMS yang sesuai, dan menyusun workflow editorial dari draft hingga publikasi.',
			'solution'     => 'Kami membuat struktur konten, field CMS, pola review, dan template komunikasi yang bisa dipakai berulang.',
			'results'      => 'Tim dapat mengelola konten lebih mandiri, menjaga konsistensi pesan, dan mempercepat publikasi materi baru.',
			'technologies' => 'CMS strategy, content modeling, editorial workflow',
		),
	);

	$count = 0;

	foreach ( $projects as $index => $project ) {
		$existing = get_page_by_path( $project['slug'], OBJECT, 'portfolio' );
		if ( $existing instanceof WP_Post ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'    => 'portfolio',
				'post_status'  => 'publish',
				'post_title'   => $project['title'],
				'post_name'    => $project['slug'],
				'post_excerpt' => $project['excerpt'],
				'post_content' => kastalabs_build_portfolio_content( $project ),
				'menu_order'   => $index + 1,
			)
		);

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		update_post_meta( $post_id, 'client_name', $project['client'] );
		update_post_meta( $post_id, 'project_year', $project['year'] );
		update_post_meta( $post_id, 'role', $project['role'] );
		update_post_meta( $post_id, 'scope', $project['scope'] );
		update_post_meta( $post_id, 'context', $project['context'] );
		update_post_meta( $post_id, 'challenge', $project['challenge'] );
		update_post_meta( $post_id, 'approach', $project['approach'] );
		update_post_meta( $post_id, 'solution', $project['solution'] );
		update_post_meta( $post_id, 'results', $project['results'] );
		update_post_meta( $post_id, 'technologies', $project['technologies'] );
		update_post_meta( $post_id, 'is_featured', true );

		wp_set_object_terms( $post_id, $project['category'], 'portfolio_category' );
		wp_set_object_terms( $post_id, $project['tags'], 'portfolio_tag' );

		$count++;
	}

	return $count;
}

/**
 * Add missing starter Insight posts without overwriting existing content.
 */
function kastalabs_seed_default_insights(): int {
	$insights = array(
		array(
			'title'    => 'Mengapa brand kecil tetap membutuhkan sistem visual',
			'slug'     => 'mengapa-brand-kecil-membutuhkan-sistem-visual',
			'category' => 'Brand Strategy',
			'tags'     => array( 'Branding', 'Visual System', 'Growth' ),
			'excerpt'  => 'Sistem visual bukan hanya untuk perusahaan besar. Brand yang sedang bertumbuh justru membutuhkan fondasi yang konsisten sejak awal.',
			'body'     => array(
				'Brand yang sedang bertumbuh biasanya bergerak cepat. Materi presentasi, landing page, konten sosial, dan proposal sering dibuat oleh orang yang berbeda dengan waktu yang sempit.',
				'Tanpa sistem visual, setiap aset mudah terasa seperti dibuat dari nol. Warna berubah, tipografi tidak konsisten, dan pesan utama kehilangan arah.',
				'Sistem visual membantu tim mengambil keputusan lebih cepat. Bukan untuk membatasi kreativitas, tetapi memberi fondasi agar setiap materi terasa berasal dari brand yang sama.',
			),
		),
		array(
			'title'    => 'Website yang baik dimulai dari struktur pesan',
			'slug'     => 'website-yang-baik-dimulai-dari-struktur-pesan',
			'category' => 'Web Strategy',
			'tags'     => array( 'Website', 'Copywriting', 'UX' ),
			'excerpt'  => 'Desain visual akan lebih kuat ketika website memiliki urutan pesan yang jelas, bukan sekadar kumpulan section yang terlihat menarik.',
			'body'     => array(
				'Sebelum membahas layout, warna, atau animasi, website perlu menjawab pertanyaan yang lebih dasar: siapa yang dibantu, masalah apa yang diselesaikan, dan kenapa pengunjung perlu percaya.',
				'Struktur pesan yang baik membuat setiap section memiliki peran. Hero menarik perhatian, layanan memperjelas penawaran, portfolio membangun bukti, dan CTA memberi arah berikutnya.',
				'Ketika pesan sudah rapi, desain dapat bekerja lebih tenang. Visual tidak perlu menutupi kebingungan konten, tetapi memperkuat alur keputusan pengunjung.',
			),
		),
		array(
			'title'    => 'CMS seharusnya membantu tim bergerak lebih cepat',
			'slug'     => 'cms-seharusnya-membantu-tim-bergerak-lebih-cepat',
			'category' => 'CMS',
			'tags'     => array( 'CMS', 'Content Model', 'Workflow' ),
			'excerpt'  => 'CMS yang baik bukan hanya tempat menulis konten, tetapi alat kerja yang membuat tim lebih mandiri dan konsisten.',
			'body'     => array(
				'Banyak website terlihat selesai dari sisi visual, tetapi sulit dipelihara karena kontennya tidak punya struktur editing yang jelas.',
				'CMS perlu dirancang sesuai cara tim bekerja. Field yang terlalu bebas membuat konten mudah berantakan, sementara field yang terlalu kaku membuat tim sulit beradaptasi.',
				'Kuncinya adalah memberi struktur pada bagian yang berulang, sambil tetap menyediakan ruang editorial untuk konteks, cerita, dan pembaruan yang lebih fleksibel.',
			),
		),
	);

	$count = 0;

	foreach ( $insights as $index => $insight ) {
		$existing = get_page_by_path( $insight['slug'], OBJECT, 'insight' );
		if ( $existing instanceof WP_Post ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'    => 'insight',
				'post_status'  => 'publish',
				'post_title'   => $insight['title'],
				'post_name'    => $insight['slug'],
				'post_excerpt' => $insight['excerpt'],
				'post_content' => kastalabs_build_insight_content( $insight['body'] ),
				'post_date'    => wp_date( 'Y-m-d H:i:s', strtotime( '-' . $index . ' days', current_time( 'timestamp' ) ) ),
			)
		);

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		update_post_meta( $post_id, 'seo_title', $insight['title'] );
		update_post_meta( $post_id, 'seo_description', $insight['excerpt'] );

		wp_set_object_terms( $post_id, $insight['category'], 'insight_category' );
		wp_set_object_terms( $post_id, $insight['tags'], 'insight_tag' );

		$count++;
	}

	return $count;
}

/**
 * Build block-ready portfolio content from starter project data.
 */
function kastalabs_build_portfolio_content( array $project ): string {
	$sections = array(
		'Konteks'     => $project['context'] ?? '',
		'Tantangan'   => $project['challenge'],
		'Pendekatan'  => $project['approach'] ?? '',
		'Solusi'      => $project['solution'],
		'Hasil'       => $project['results'],
	);

	$content = '';
	foreach ( $sections as $heading => $body ) {
		if ( '' === trim( (string) $body ) ) {
			continue;
		}
		$content .= '<!-- wp:heading {"level":2} --><h2>' . esc_html( $heading ) . '</h2><!-- /wp:heading -->';
		$content .= '<!-- wp:paragraph --><p>' . esc_html( $body ) . '</p><!-- /wp:paragraph -->';
	}

	return $content;
}

/**
 * Build block-ready article content from starter paragraphs.
 */
function kastalabs_build_insight_content( array $paragraphs ): string {
	$content = '';
	foreach ( $paragraphs as $paragraph ) {
		$content .= '<!-- wp:paragraph --><p>' . esc_html( $paragraph ) . '</p><!-- /wp:paragraph -->';
	}

	return $content;
}

/**
 * Return a safe Contact URL for seeded service CTA fields.
 */
function kastalabs_default_contact_url(): string {
	$url   = home_url( '/contact/' );
	$parts = wp_parse_url( $url );

	if ( empty( $parts['host'] ) ) {
		return '/contact/';
	}

	return $url;
}
