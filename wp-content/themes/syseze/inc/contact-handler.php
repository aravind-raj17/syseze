<?php
/**
 * Contact form AJAX handler — sends via Microsoft Graph API.
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

	$subject = "New enquiry from {$name} via syseze.com";

	$body  = "Name:    {$name}\n";
	$body .= "Email:   {$email}\n";
	if ( $company ) $body .= "Company: {$company}\n";
	if ( $phone )   $body .= "Phone:   {$phone}\n";
	if ( $service ) $body .= "Service: {$service}\n";
	$body .= "\nMessage:\n{$message}";

	$sent = syseze_graph_send_mail( $subject, $body, $name, $email );

	if ( $sent ) {
		wp_send_json_success( "Thanks {$name}! We've received your message and will reply within one business day." );
	} else {
		wp_send_json_error( 'Something went wrong. Please email us directly at hello@syseze.com.' );
	}
}

function syseze_graph_send_mail( $subject, $body, $reply_to_name, $reply_to_email ) {
	$tenant_id     = defined( 'SYSEZE_MS_TENANT_ID' )     ? SYSEZE_MS_TENANT_ID     : '';
	$client_id     = defined( 'SYSEZE_MS_CLIENT_ID' )     ? SYSEZE_MS_CLIENT_ID     : '';
	$client_secret = defined( 'SYSEZE_MS_CLIENT_SECRET' ) ? SYSEZE_MS_CLIENT_SECRET : '';

	if ( ! $tenant_id || ! $client_id || ! $client_secret ) return false;
	$from_email    = 'hello@syseze.com';
	$to_email      = 'hello@syseze.com';

	// Step 1: get access token.
	$token_res = wp_remote_post(
		"https://login.microsoftonline.com/{$tenant_id}/oauth2/v2.0/token",
		array(
			'timeout' => 20,
			'body'    => array(
				'grant_type'    => 'client_credentials',
				'client_id'     => $client_id,
				'client_secret' => $client_secret,
				'scope'         => 'https://graph.microsoft.com/.default',
			),
		)
	);

	if ( is_wp_error( $token_res ) ) return false;

	$token_data   = json_decode( wp_remote_retrieve_body( $token_res ), true );
	$access_token = $token_data['access_token'] ?? '';

	if ( ! $access_token ) return false;

	// Step 2: send email via Graph API.
	$payload = array(
		'message' => array(
			'subject' => $subject,
			'body'    => array(
				'contentType' => 'Text',
				'content'     => $body,
			),
			'toRecipients' => array(
				array( 'emailAddress' => array( 'address' => $to_email ) ),
			),
			'replyTo' => array(
				array( 'emailAddress' => array( 'name' => $reply_to_name, 'address' => $reply_to_email ) ),
			),
		),
	);

	$send_res = wp_remote_post(
		"https://graph.microsoft.com/v1.0/users/{$from_email}/sendMail",
		array(
			'timeout' => 20,
			'headers' => array(
				'Authorization' => "Bearer {$access_token}",
				'Content-Type'  => 'application/json',
			),
			'body' => wp_json_encode( $payload ),
		)
	);

	if ( is_wp_error( $send_res ) ) return false;

	return wp_remote_retrieve_response_code( $send_res ) === 202;
}
