<?php
/**
 * Theme Customizer — stats, contact info, socials, contact-form shortcode.
 *
 * @package SysEze
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'customize_register', function ( $wp_customize ) {

	// =================== STATS ===================
	$wp_customize->add_section( 'syseze_stats', array(
		'title'    => __( 'SysEze — Stats', 'syseze' ),
		'priority' => 30,
	) );
	$stats = array(
		'years'      => array( '6+',  __( 'Years in business label', 'syseze' ) ),
		'projects'   => array( '100+', __( 'Projects delivered', 'syseze' ) ),
		'industries' => array( '12+', __( 'Industries served', 'syseze' ) ),
		'retention'  => array( '95%', __( 'Client retention', 'syseze' ) ),
	);
	foreach ( $stats as $key => $cfg ) {
		$wp_customize->add_setting( "syseze_stat_{$key}", array(
			'default'           => $cfg[0],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "syseze_stat_{$key}", array(
			'label'   => $cfg[1],
			'section' => 'syseze_stats',
			'type'    => 'text',
		) );
	}

	// =================== CONTACT INFO ===================
	$wp_customize->add_section( 'syseze_contact', array(
		'title'    => __( 'SysEze — Contact Info', 'syseze' ),
		'priority' => 31,
	) );
	$contact = array(
		'address' => array( "No 32, Keshava Krupa,\n3rd Cross, Anekal Road,\nChandapura, Bangalore — 560099", __( 'Address (use line breaks)', 'syseze' ), 'textarea' ),
		'phone'   => array( '+91 9019435799', __( 'Phone number', 'syseze' ), 'text' ),
		'email'   => array( 'hello@syseze.com', __( 'Email', 'syseze' ), 'text' ),
		'hours'   => array( "Mon – Fri: 9:00 AM – 7:00 PM IST\nSaturday: 10:00 AM – 2:00 PM IST\nSunday: Closed", __( 'Hours', 'syseze' ), 'textarea' ),
	);
	foreach ( $contact as $key => $cfg ) {
		$wp_customize->add_setting( "syseze_contact_{$key}", array(
			'default'           => $cfg[0],
			'sanitize_callback' => $cfg[2] === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field',
		) );
		$wp_customize->add_control( "syseze_contact_{$key}", array(
			'label'   => $cfg[1],
			'section' => 'syseze_contact',
			'type'    => $cfg[2],
		) );
	}

	// =================== SOCIAL LINKS ===================
	$wp_customize->add_section( 'syseze_social', array(
		'title'    => __( 'SysEze — Social Links', 'syseze' ),
		'priority' => 32,
	) );
	$social = array(
		'linkedin'  => array( 'https://www.linkedin.com/company/syseze', 'LinkedIn URL' ),
		'facebook'  => array( 'https://www.facebook.com/syseze',          'Facebook URL' ),
		'twitter'   => array( 'https://x.com/syseze',                      'X (Twitter) URL' ),
		'instagram' => array( 'https://www.instagram.com/syseze',          'Instagram URL' ),
	);
	foreach ( $social as $key => $cfg ) {
		$wp_customize->add_setting( "syseze_social_{$key}", array(
			'default'           => $cfg[0],
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( "syseze_social_{$key}", array(
			'label'   => $cfg[1],
			'section' => 'syseze_social',
			'type'    => 'url',
		) );
	}

	// =================== CONTACT FORM SHORTCODE ===================
	$wp_customize->add_section( 'syseze_forms', array(
		'title'    => __( 'SysEze — Contact Form', 'syseze' ),
		'priority' => 33,
	) );
	$wp_customize->add_setting( 'syseze_cf7_shortcode', array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'syseze_cf7_shortcode', array(
		'label'       => __( 'Contact form shortcode', 'syseze' ),
		'description' => __( 'Paste your Contact Form 7 (or WPForms / Fluent Forms) shortcode here, e.g. [contact-form-7 id="123"]. Leave empty to use the built-in static form.', 'syseze' ),
		'section'     => 'syseze_forms',
		'type'        => 'textarea',
	) );

	// =================== FOOTER ===================
	$wp_customize->add_section( 'syseze_footer', array(
		'title'    => __( 'SysEze — Footer', 'syseze' ),
		'priority' => 34,
	) );
	$wp_customize->add_setting( 'syseze_footer_tagline', array(
		'default'           => 'IT infrastructure, cloud, and cybersecurity solutions for businesses ready to scale.',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'syseze_footer_tagline', array(
		'label'   => __( 'Footer tagline', 'syseze' ),
		'section' => 'syseze_footer',
		'type'    => 'textarea',
	) );
	$wp_customize->add_setting( 'syseze_footer_copyright', array(
		'default'           => '© ' . date( 'Y' ) . ' SysEze Tech Pvt Ltd. All rights reserved.',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'syseze_footer_copyright', array(
		'label'   => __( 'Copyright line', 'syseze' ),
		'section' => 'syseze_footer',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'syseze_footer_credit', array(
		'default'           => 'Designed by Syseze.com',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'syseze_footer_credit', array(
		'label'   => __( 'Credit line', 'syseze' ),
		'section' => 'syseze_footer',
		'type'    => 'text',
	) );
} );
