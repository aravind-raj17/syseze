<?php
/**
 * SEO — meta tags, Open Graph, Twitter Card, JSON-LD structured data.
 *
 * Covers: title tags, meta descriptions, canonical URLs, OG/TC tags,
 * Organization schema, Service schema, BlogPosting schema, Breadcrumbs.
 *
 * @package SysEze
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ═══════════════════════════════════════════════════════════
   1. PAGE DATA — titles, descriptions, keywords per page
   ═══════════════════════════════════════════════════════════ */

function syseze_seo_page_data() {
	return [
		'home' => [
			'title' => 'SysEze Tech | IAM, Cloud & Managed IT Services India',
			'desc'  => 'SysEze Tech delivers Identity & Access Management, cloud migration, cyber security and managed IT services for enterprises across India and globally. NetIQ specialists.',
		],
		'about' => [
			'title' => 'About SysEze | Enterprise IT Specialists India',
			'desc'  => 'SysEze is a lean team of senior engineers delivering IAM, cloud migration and cyber security solutions for enterprises across India and globally.',
		],
		'services' => [
			'title' => 'IT Services | IAM, Cloud, Security & Managed IT | SysEze India',
			'desc'  => 'Seven enterprise IT practices under one roof — IAM, cloud services, IT consulting, migration, network design, cyber security and managed business support.',
		],
		'iam-services' => [
			'title' => 'IAM Services India | NetIQ Implementation Specialists | SysEze',
			'desc'  => 'Expert Identity & Access Management services in India. NetIQ Access Manager, Identity Manager, Identity Governance and eDirectory implementation by certified engineers.',
		],
		'cloud-services' => [
			'title' => 'Cloud Services India | Multi-Cloud Architecture & Migration | SysEze',
			'desc'  => 'Multi-cloud architecture, migration and managed operations for Indian enterprises. AWS, Azure and hybrid cloud solutions delivered by experienced engineers.',
		],
		'it-consulting' => [
			'title' => 'IT Consulting India | Technology Strategy & Roadmaps | SysEze',
			'desc'  => 'Strategic IT consulting for enterprise digital transformation. SysEze delivers technology assessments, architecture roadmaps and hands-on implementation.',
		],
		'migration-services' => [
			'title' => 'Infrastructure Migration Services India | Zero-Downtime Moves | SysEze',
			'desc'  => 'Zero-downtime infrastructure and cloud migration for enterprises. SysEze has migrated thousands of workloads with proven wave-based methodology.',
		],
		'network-design' => [
			'title' => 'Network Design & Architecture India | Enterprise Networking | SysEze',
			'desc'  => 'Resilient, scalable enterprise network design and implementation. SysEze architects high-performance networks built for security and growth.',
		],
		'cyber-security' => [
			'title' => 'Cyber Security Services India | Threat Protection & Compliance | SysEze',
			'desc'  => 'Enterprise cyber security — Zero Trust implementation, threat protection, compliance and incident response. SysEze protects critical business infrastructure.',
		],
		'business-support' => [
			'title' => 'Managed IT Support India | 24/7 Business IT Services | SysEze',
			'desc'  => '24/7 managed IT support for Indian enterprises. Pay-as-you-go business IT services that keep your operations running and your team productive.',
		],
		'contact' => [
			'title' => 'Contact SysEze | IAM & Managed IT Services India',
			'desc'  => 'Get in touch with SysEze Tech for IAM, cloud, cyber security and managed IT services. Serving enterprises across India and globally.',
		],
		'blog' => [
			'title' => 'Blog | Engineering Insights from SysEze',
			'desc'  => 'Field notes from the SysEze engineering team. Practical writing on cloud, security, identity management and IT strategy — by engineers doing the work.',
		],
		'portfolio' => [
			'title' => 'Portfolio | SysEze Client Work & Case Studies',
			'desc'  => 'Selected client work from SysEze — IAM implementations, cloud migrations, network projects and security engagements across industries.',
		],
	];
}

/* ═══════════════════════════════════════════════════════════
   2. HELPERS
   ═══════════════════════════════════════════════════════════ */

function syseze_get_current_slug() {
	if ( is_front_page() ) return 'home';
	if ( is_home() )       return 'blog';
	if ( is_page() )       return get_post_field( 'post_name', get_queried_object_id() );
	return '';
}

function syseze_meta_description() {
	if ( is_singular( 'post' ) ) {
		$exc = get_the_excerpt();
		return $exc ? wp_strip_all_tags( $exc ) : '';
	}
	$data = syseze_seo_page_data();
	$slug = syseze_get_current_slug();
	return isset( $data[ $slug ] ) ? $data[ $slug ]['desc'] : get_bloginfo( 'description' );
}

function syseze_og_image() {
	if ( is_singular( 'post' ) ) {
		$cover = get_post_meta( get_the_ID(), '_syseze_cover_url', true );
		if ( $cover ) return $cover;
	}
	return get_template_directory_uri() . '/assets/images/og-default.jpg';
}

function syseze_canonical_url() {
	if ( is_singular() ) return get_permalink();
	if ( is_front_page() ) return home_url( '/' );
	if ( is_home() ) {
		$pid = get_option( 'page_for_posts' );
		return $pid ? get_permalink( $pid ) : home_url( '/blog/' );
	}
	if ( is_page() ) return get_permalink();
	return '';
}

/* ═══════════════════════════════════════════════════════════
   3. TITLE TAG FILTER
   ═══════════════════════════════════════════════════════════ */

add_filter( 'pre_get_document_title', function ( $title ) {
	if ( is_singular( 'post' ) ) {
		return get_the_title() . ' | SysEze Blog';
	}
	$data = syseze_seo_page_data();
	$slug = syseze_get_current_slug();
	return isset( $data[ $slug ] ) ? $data[ $slug ]['title'] : $title;
}, 20 );

/* ═══════════════════════════════════════════════════════════
   4. HEAD OUTPUT — meta, canonical, OG, Twitter Card
   ═══════════════════════════════════════════════════════════ */

add_action( 'wp_head', function () {
	$desc      = syseze_meta_description();
	$canonical = syseze_canonical_url();
	$og_image  = syseze_og_image();
	$og_title  = wp_get_document_title();
	$og_type   = is_singular( 'post' ) ? 'article' : 'website';
	$site_name = 'SysEze Tech';

	echo "\n<!-- SysEze SEO -->\n";

	if ( $desc ) {
		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	}

	if ( $canonical ) {
		echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";
	}

	/* Open Graph */
	echo '<meta property="og:type"        content="' . esc_attr( $og_type ) . '">' . "\n";
	echo '<meta property="og:site_name"   content="' . esc_attr( $site_name ) . '">' . "\n";
	echo '<meta property="og:title"       content="' . esc_attr( $og_title ) . '">' . "\n";
	if ( $desc ) {
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	if ( $canonical ) {
		echo '<meta property="og:url"         content="' . esc_url( $canonical ) . '">' . "\n";
	}
	echo '<meta property="og:image"       content="' . esc_url( $og_image ) . '">' . "\n";
	echo '<meta property="og:image:width" content="1200">' . "\n";
	echo '<meta property="og:image:height" content="630">' . "\n";
	echo '<meta property="og:locale"      content="en_IN">' . "\n";

	/* Twitter Card */
	echo '<meta name="twitter:card"        content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title"       content="' . esc_attr( $og_title ) . '">' . "\n";
	if ( $desc ) {
		echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	echo '<meta name="twitter:image"       content="' . esc_url( $og_image ) . '">' . "\n";

	echo "<!-- /SysEze SEO -->\n\n";

}, 2 );

/* ═══════════════════════════════════════════════════════════
   5. JSON-LD STRUCTURED DATA
   ═══════════════════════════════════════════════════════════ */

add_action( 'wp_head', function () {

	$site_url = home_url( '/' );
	$logo_url = get_template_directory_uri() . '/assets/images/og-default.jpg';

	/* ── Organization (every page) ── */
	$org = [
		'@context'    => 'https://schema.org',
		'@type'       => 'Organization',
		'@id'         => $site_url . '#organization',
		'name'        => 'SysEze Tech Pvt Ltd',
		'url'         => $site_url,
		'logo'        => [
			'@type' => 'ImageObject',
			'url'   => esc_url( syseze_logo_url() ),
		],
		'description' => 'Enterprise IT services company specialising in Identity & Access Management, cloud migration, cyber security and managed IT support across India and globally.',
		'areaServed'  => [ 'India', 'Global' ],
		'contactPoint' => [
			'@type'       => 'ContactPoint',
			'email'       => 'hello@syseze.com',
			'contactType' => 'customer service',
			'areaServed'  => 'IN',
		],
	];

	$schemas = [ $org ];

	/* ── WebSite (homepage only) ── */
	if ( is_front_page() ) {
		$schemas[] = [
			'@context'        => 'https://schema.org',
			'@type'           => 'WebSite',
			'url'             => $site_url,
			'name'            => 'SysEze Tech',
			'potentialAction' => [
				'@type'       => 'SearchAction',
				'target'      => $site_url . '?s={search_term_string}',
				'query-input' => 'required name=search_term_string',
			],
		];
	}

	/* ── Service pages ── */
	$service_map = [
		'iam-services' => [
			'name'        => 'Identity & Access Management (IAM) Services',
			'description' => 'NetIQ IAM implementation — Access Manager, Identity Manager, Identity Governance and eDirectory. Delivered by certified engineers in India.',
			'keywords'    => 'IAM services India, NetIQ implementation, identity access management, NetIQ Access Manager, NetIQ Identity Manager',
		],
		'cloud-services' => [
			'name'        => 'Cloud Services',
			'description' => 'Multi-cloud architecture, migration and managed cloud operations for enterprises. AWS, Azure, and hybrid cloud.',
			'keywords'    => 'cloud services India, cloud migration, multi-cloud architecture, managed cloud operations',
		],
		'it-consulting' => [
			'name'        => 'IT Consulting',
			'description' => 'Enterprise IT strategy, technology roadmaps and hands-on implementation consulting.',
			'keywords'    => 'IT consulting India, technology strategy, digital transformation, IT roadmap',
		],
		'migration-services' => [
			'name'        => 'Infrastructure Migration Services',
			'description' => 'Zero-downtime infrastructure and cloud migration using proven wave-based methodology.',
			'keywords'    => 'infrastructure migration India, cloud migration services, VM migration, zero downtime migration',
		],
		'network-design' => [
			'name'        => 'Network Design & Architecture',
			'description' => 'Resilient enterprise network design, topology planning and implementation.',
			'keywords'    => 'network design India, enterprise networking, network architecture, LAN WAN design',
		],
		'cyber-security' => [
			'name'        => 'Cyber Security Services',
			'description' => 'Zero Trust implementation, threat protection, compliance and incident response for enterprises.',
			'keywords'    => 'cyber security India, Zero Trust security, threat protection, security compliance',
		],
		'business-support' => [
			'name'        => 'Managed IT Business Support',
			'description' => '24/7 managed IT support and pay-as-you-go business IT services for enterprises.',
			'keywords'    => 'managed IT support India, 24/7 IT support, business IT services, managed services',
		],
	];

	if ( is_page() ) {
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		if ( isset( $service_map[ $slug ] ) ) {
			$svc = $service_map[ $slug ];
			$schemas[] = [
				'@context'    => 'https://schema.org',
				'@type'       => 'Service',
				'name'        => $svc['name'],
				'description' => $svc['description'],
				'provider'    => [ '@id' => $site_url . '#organization' ],
				'areaServed'  => [ 'India', 'Global' ],
				'url'         => get_permalink(),
			];
		}
	}

	/* ── BlogPosting (single post) ── */
	if ( is_singular( 'post' ) ) {
		global $post;
		$cover  = get_post_meta( $post->ID, '_syseze_cover_url', true );
		$cats   = get_the_category( $post->ID );
		$schemas[] = [
			'@context'         => 'https://schema.org',
			'@type'            => 'BlogPosting',
			'headline'         => get_the_title( $post->ID ),
			'description'      => wp_strip_all_tags( get_the_excerpt() ),
			'datePublished'    => get_the_date( 'c', $post->ID ),
			'dateModified'     => get_the_modified_date( 'c', $post->ID ),
			'author'           => [
				'@type' => 'Person',
				'name'  => get_the_author_meta( 'display_name', $post->post_author ),
			],
			'publisher'        => [ '@id' => $site_url . '#organization' ],
			'url'              => get_permalink( $post->ID ),
			'image'            => $cover ? esc_url( $cover ) : $logo_url,
			'articleSection'   => ! empty( $cats ) ? $cats[0]->name : 'Technology',
			'inLanguage'       => 'en',
		];
	}

	/* ── Breadcrumb (non-home pages) ── */
	if ( ! is_front_page() ) {
		$items   = [];
		$items[] = [
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => 'Home',
			'item'     => $site_url,
		];

		if ( is_singular( 'post' ) ) {
			$blog_pid = get_option( 'page_for_posts' );
			$items[]  = [
				'@type'    => 'ListItem',
				'position' => 2,
				'name'     => 'Blog',
				'item'     => $blog_pid ? get_permalink( $blog_pid ) : $site_url . 'blog/',
			];
			$items[] = [
				'@type'    => 'ListItem',
				'position' => 3,
				'name'     => get_the_title(),
				'item'     => get_permalink(),
			];
		} elseif ( is_page() ) {
			$items[] = [
				'@type'    => 'ListItem',
				'position' => 2,
				'name'     => get_the_title(),
				'item'     => get_permalink(),
			];
		}

		if ( count( $items ) > 1 ) {
			$schemas[] = [
				'@context'        => 'https://schema.org',
				'@type'           => 'BreadcrumbList',
				'itemListElement' => $items,
			];
		}
	}

	/* ── output ── */
	foreach ( $schemas as $schema ) {
		echo '<script type="application/ld+json">' . "\n";
		echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
		echo "\n" . '</script>' . "\n";
	}

}, 5 );

/* ═══════════════════════════════════════════════════════════
   6. ROBOTS — noindex on search/404
   ═══════════════════════════════════════════════════════════ */

add_action( 'wp_head', function () {
	if ( is_search() || is_404() ) {
		echo '<meta name="robots" content="noindex, follow">' . "\n";
	}
}, 1 );
