<?php
/**
 * Asset enqueueing.
 *
 * @package SysEze
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_enqueue_scripts', function () {
	// Google fonts — preconnect handled by WP automatically when enqueued as a stylesheet.
	wp_enqueue_style(
		'syseze-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&family=JetBrains+Mono:wght@400;500&display=swap',
		array(),
		null
	);

	// Main stylesheet (the WP-required style.css is just the theme header).
	wp_enqueue_style( 'syseze-base', get_template_directory_uri() . '/assets/css/styles.css', array( 'syseze-fonts' ), SYSEZE_VERSION );
	wp_enqueue_style( 'syseze-pages', get_template_directory_uri() . '/assets/css/pages.css', array( 'syseze-base' ), SYSEZE_VERSION );

	// Theme file itself (so child themes / WP know about it).
	wp_enqueue_style( 'syseze-theme', get_stylesheet_uri(), array( 'syseze-base' ), SYSEZE_VERSION );

	// Main JS.
	wp_enqueue_script( 'syseze-main', get_template_directory_uri() . '/assets/js/main.js', array(), SYSEZE_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
} );
