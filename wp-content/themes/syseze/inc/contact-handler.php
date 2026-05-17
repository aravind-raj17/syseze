<?php
/**
 * Contact form AJAX handler — sends submissions to hello@syseze.com.
 *
 * @package SysEze
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_ajax_nopriv_syseze_contact', 'syseze_handle_contact_form' );
add_action( 'wp_ajax_syseze_contact',        'syseze_handle_contact_form' );

function syseze_handle_contact_form() {
	if ( ! check_ajax_referer( 'syseze_contact_nonce', 'nonce', false ) ) {
		wp_send_json_error( 'Security check failed.', 403 );
	}

	$name    = sanitize_text_field( wp_unslash( $_POST['name']    ?? '' ) );
	$email   = sanitize_email(      wp_unslash( $_POST['email']   ?? '' ) );
	$company = sanitize_text_field( wp_unslash( $_POST['company'] ?? '' ) );
	$phone   = sanitize_text_field( wp_unslash( $_POST['phone']   ?? '' ) );
	$service = sanitize_text_field( wp_unslash( $_POST['service'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_send_json_error( 'Please fill in your name, email, and message.' );
	}

	$to      = 'hello@syseze.com';
	$subject = "New enquiry from {$name} via syseze.com";

	$body  = "Name:    {$name}\n";
	$body .= "Email:   {$email}\n";
	if ( $company ) $body .= "Company: {$company}\n";
	if ( $phone )   $body .= "Phone:   {$phone}\n";
	if ( $service ) $body .= "Service: {$service}\n";
	$body .= "\nMessage:\n{$message}";

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		"Reply-To: {$name} <{$email}>",
	);

	$sent = wp_mail( $to, $subject, $body, $headers );

	if ( $sent ) {
		wp_send_json_success( "Thanks {$name}! We've received your message and will reply within one business day." );
	} else {
		wp_send_json_error( 'Something went wrong. Please email us directly at hello@syseze.com.' );
	}
}
