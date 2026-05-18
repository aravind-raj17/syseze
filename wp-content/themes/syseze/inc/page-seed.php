<?php
/**
 * Auto-create all required theme pages on first WordPress load.
 * Skips pages whose slugs already exist.
 *
 * @package SysEze
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function syseze_seed_pages() {
	if ( get_option( 'syseze_pages_seeded_v1' ) ) {
		return;
	}

	$pages = array(
		array(
			'title'    => 'Services',
			'slug'     => 'services',
			'template' => 'page-templates/template-services.php',
		),
		array(
			'title'    => 'Cloud Services',
			'slug'     => 'cloud-services',
			'template' => 'page-templates/template-cloud-services.php',
		),
		array(
			'title'    => 'IT Consulting',
			'slug'     => 'it-consulting',
			'template' => 'page-templates/template-it-consulting.php',
		),
		array(
			'title'    => 'Migration Services',
			'slug'     => 'migration-services',
			'template' => 'page-templates/template-migration-services.php',
		),
		array(
			'title'    => 'Network Design',
			'slug'     => 'network-design',
			'template' => 'page-templates/template-network-design.php',
		),
		array(
			'title'    => 'Cyber Security',
			'slug'     => 'cyber-security',
			'template' => 'page-templates/template-cyber-security.php',
		),
		array(
			'title'    => 'Business Support',
			'slug'     => 'business-support',
			'template' => 'page-templates/template-business-support.php',
		),
		array(
			'title'    => 'IAM Services',
			'slug'     => 'iam-services',
			'template' => 'page-templates/template-iam-services.php',
		),
		array(
			'title'    => 'About',
			'slug'     => 'about',
			'template' => 'page-templates/template-about.php',
		),
		array(
			'title'    => 'Contact',
			'slug'     => 'contact',
			'template' => 'page-templates/template-contact.php',
		),
		array(
			'title'    => 'Portfolio',
			'slug'     => 'portfolio',
			'template' => 'page-templates/template-portfolio.php',
		),
	);

	foreach ( $pages as $p ) {
		if ( get_page_by_path( $p['slug'] ) ) {
			continue;
		}
		$id = wp_insert_post( array(
			'post_title'  => $p['title'],
			'post_name'   => $p['slug'],
			'post_status' => 'publish',
			'post_type'   => 'page',
		) );
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_wp_page_template', $p['template'] );
		}
	}

	update_option( 'syseze_pages_seeded_v1', '1' );
}
add_action( 'init', 'syseze_seed_pages', 98 );
