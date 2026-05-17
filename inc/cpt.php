<?php
/**
 * Custom post types & taxonomies.
 *
 * - portfolio   (case studies) — with "portfolio_category" taxonomy
 * - team        (team members)
 * - testimonial (homepage quotes)
 *
 * @package SysEze
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'init', function () {

	// Portfolio.
	register_post_type( 'portfolio', array(
		'labels' => array(
			'name'               => __( 'Portfolio', 'syseze' ),
			'singular_name'      => __( 'Case Study', 'syseze' ),
			'menu_name'          => __( 'Portfolio', 'syseze' ),
			'add_new_item'       => __( 'Add New Case Study', 'syseze' ),
			'edit_item'          => __( 'Edit Case Study', 'syseze' ),
			'new_item'           => __( 'New Case Study', 'syseze' ),
			'view_item'          => __( 'View Case Study', 'syseze' ),
			'search_items'       => __( 'Search Case Studies', 'syseze' ),
		),
		'public'        => true,
		'has_archive'   => 'portfolio',
		'menu_icon'     => 'dashicons-portfolio',
		'menu_position' => 20,
		'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		'rewrite'       => array( 'slug' => 'case-study' ),
		'show_in_rest'  => true,
	) );

	register_taxonomy( 'portfolio_category', 'portfolio', array(
		'labels' => array(
			'name'          => __( 'Categories', 'syseze' ),
			'singular_name' => __( 'Category', 'syseze' ),
		),
		'hierarchical' => true,
		'rewrite'      => array( 'slug' => 'case-category' ),
		'show_in_rest' => true,
	) );

	// Team.
	register_post_type( 'team', array(
		'labels' => array(
			'name'          => __( 'Team', 'syseze' ),
			'singular_name' => __( 'Team Member', 'syseze' ),
			'add_new_item'  => __( 'Add Team Member', 'syseze' ),
		),
		'public'        => false,
		'show_ui'       => true,
		'show_in_menu'  => true,
		'menu_icon'     => 'dashicons-groups',
		'menu_position' => 21,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		'show_in_rest'  => true,
	) );

	// Testimonial.
	register_post_type( 'testimonial', array(
		'labels' => array(
			'name'          => __( 'Testimonials', 'syseze' ),
			'singular_name' => __( 'Testimonial', 'syseze' ),
			'add_new_item'  => __( 'Add Testimonial', 'syseze' ),
		),
		'public'        => false,
		'show_ui'       => true,
		'show_in_menu'  => true,
		'menu_icon'     => 'dashicons-format-quote',
		'menu_position' => 22,
		'supports'      => array( 'title', 'editor', 'page-attributes' ),
		'show_in_rest'  => true,
	) );
} );

/**
 * Team — custom meta: role.
 * Testimonial — custom meta: author_role, author_company.
 */
add_action( 'add_meta_boxes', function () {
	add_meta_box( 'syseze_team_meta', __( 'Team Member Details', 'syseze' ), 'syseze_render_team_meta_box', 'team', 'side' );
	add_meta_box( 'syseze_testimonial_meta', __( 'Author Details', 'syseze' ), 'syseze_render_testimonial_meta_box', 'testimonial', 'side' );
	add_meta_box( 'syseze_portfolio_meta', __( 'Case Study Details', 'syseze' ), 'syseze_render_portfolio_meta_box', 'portfolio', 'side' );
} );

function syseze_render_team_meta_box( $post ) {
	wp_nonce_field( 'syseze_team_meta', 'syseze_team_meta_nonce' );
	$role = get_post_meta( $post->ID, '_syseze_role', true );
	echo '<p><label for="syseze_role"><strong>' . esc_html__( 'Role / title', 'syseze' ) . '</strong></label>';
	echo '<input type="text" id="syseze_role" name="syseze_role" value="' . esc_attr( $role ) . '" style="width:100%;" /></p>';
}

function syseze_render_testimonial_meta_box( $post ) {
	wp_nonce_field( 'syseze_testimonial_meta', 'syseze_testimonial_meta_nonce' );
	$role    = get_post_meta( $post->ID, '_syseze_author_role', true );
	$company = get_post_meta( $post->ID, '_syseze_author_company', true );
	echo '<p><label><strong>' . esc_html__( 'Role', 'syseze' ) . '</strong></label>';
	echo '<input type="text" name="syseze_author_role" value="' . esc_attr( $role ) . '" style="width:100%;" /></p>';
	echo '<p><label><strong>' . esc_html__( 'Company', 'syseze' ) . '</strong></label>';
	echo '<input type="text" name="syseze_author_company" value="' . esc_attr( $company ) . '" style="width:100%;" /></p>';
	echo '<p class="description">' . esc_html__( 'The post title is the quote source name. The post content is the quote text itself.', 'syseze' ) . '</p>';
}

function syseze_render_portfolio_meta_box( $post ) {
	wp_nonce_field( 'syseze_portfolio_meta', 'syseze_portfolio_meta_nonce' );
	$industry = get_post_meta( $post->ID, '_syseze_industry', true );
	$year     = get_post_meta( $post->ID, '_syseze_year', true );
	echo '<p><label><strong>' . esc_html__( 'Industry', 'syseze' ) . '</strong></label>';
	echo '<input type="text" name="syseze_industry" value="' . esc_attr( $industry ) . '" placeholder="Healthcare" style="width:100%;" /></p>';
	echo '<p><label><strong>' . esc_html__( 'Year', 'syseze' ) . '</strong></label>';
	echo '<input type="text" name="syseze_year" value="' . esc_attr( $year ) . '" placeholder="2024" style="width:100%;" /></p>';
}

add_action( 'save_post', function ( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }

	$fields = array(
		'team' => array(
			'_nonce'    => array( 'syseze_team_meta_nonce', 'syseze_team_meta' ),
			'_syseze_role' => 'syseze_role',
		),
		'testimonial' => array(
			'_nonce'                  => array( 'syseze_testimonial_meta_nonce', 'syseze_testimonial_meta' ),
			'_syseze_author_role'     => 'syseze_author_role',
			'_syseze_author_company'  => 'syseze_author_company',
		),
		'portfolio' => array(
			'_nonce'             => array( 'syseze_portfolio_meta_nonce', 'syseze_portfolio_meta' ),
			'_syseze_industry'   => 'syseze_industry',
			'_syseze_year'       => 'syseze_year',
		),
	);

	$type = get_post_type( $post_id );
	if ( empty( $fields[ $type ] ) ) { return; }

	$cfg = $fields[ $type ];
	list( $nonce_name, $nonce_action ) = $cfg['_nonce'];
	if ( empty( $_POST[ $nonce_name ] ) || ! wp_verify_nonce( $_POST[ $nonce_name ], $nonce_action ) ) { return; }

	unset( $cfg['_nonce'] );
	foreach ( $cfg as $meta_key => $form_key ) {
		if ( isset( $_POST[ $form_key ] ) ) {
			update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $form_key ] ) ) );
		}
	}
} );
