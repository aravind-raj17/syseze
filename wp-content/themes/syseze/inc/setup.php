<?php
/**
 * Theme setup: features, menus, image sizes.
 *
 * @package SysEze
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'syseze', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'syseze' ),
		'footer_services' => __( 'Footer — Services', 'syseze' ),
		'footer_company'  => __( 'Footer — Company', 'syseze' ),
	) );

	add_image_size( 'syseze-card', 800, 500, true );
	add_image_size( 'syseze-featured', 1200, 700, true );
} );

// Pingback header (good practice).
add_action( 'wp_head', function () {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '">';
	}
} );

// Body class helper.
add_filter( 'body_class', function ( $classes ) {
	$classes[] = 'syseze-body';
	return $classes;
} );
