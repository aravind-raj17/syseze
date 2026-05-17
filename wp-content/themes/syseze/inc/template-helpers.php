<?php
/**
 * Template helpers — small reusable PHP snippets.
 *
 * @package SysEze
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Render a value from the Customizer with fallback.
 */
function syseze_mod( $key, $default = '' ) {
	return get_theme_mod( $key, $default );
}

/**
 * Get the SysEze logo URL. Uses the custom-logo if set, else the bundled PNG.
 */
function syseze_logo_url() {
	$custom_id = get_theme_mod( 'custom_logo' );
	if ( $custom_id ) {
		$img = wp_get_attachment_image_src( $custom_id, 'full' );
		if ( $img ) { return $img[0]; }
	}
	return get_template_directory_uri() . '/assets/images/logo.png';
}

/**
 * Reusable orbs + grid background markup.
 */
function syseze_orbs() {
	echo '<div class="orbs" aria-hidden="true"><div class="orb o1"></div><div class="orb o2"></div><div class="orb o3"></div></div>';
	echo '<div class="grid-overlay" aria-hidden="true"></div>';
}

/**
 * Reusable arrow SVG.
 */
function syseze_arrow() {
	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>';
}

/**
 * CTA banner (used on most pages).
 */
function syseze_cta_banner( $heading = 'Ready to elevate your business?', $sub = 'Start with a free, no-obligation IT audit.', $btn = 'Contact Us' ) {
	$contact_url = esc_url( syseze_page_url( 'contact' ) );
	?>
	<section class="section">
		<div class="container">
			<div class="cta-banner reveal">
				<span class="eyebrow" style="justify-content:center;"><?php esc_html_e( 'Ready when you are', 'syseze' ); ?></span>
				<h2><?php echo esc_html( $heading ); ?></h2>
				<p><?php echo esc_html( $sub ); ?></p>
				<a href="<?php echo $contact_url; ?>" class="btn btn-primary"><?php echo esc_html( $btn ); ?> <?php echo syseze_arrow(); // phpcs:ignore ?></a>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Get URL for a known page by slug. Falls back to the home URL.
 */
function syseze_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	if ( $page ) { return get_permalink( $page->ID ); }
	return home_url( '/' . $slug . '/' );
}

/**
 * Render socials block (used in footer + contact info).
 */
function syseze_render_socials() {
	$links = array(
		'linkedin'  => array( 'syseze_social_linkedin', '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5C4.98 4.88 3.87 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM.22 8h4.56v14H.22V8zm7.4 0h4.37v1.92h.06c.61-1.16 2.1-2.38 4.32-2.38 4.62 0 5.47 3.04 5.47 7v7.46h-4.56v-6.62c0-1.58-.03-3.61-2.2-3.61-2.2 0-2.54 1.72-2.54 3.5V22H7.62V8z"/></svg>' ),
		'facebook'  => array( 'syseze_social_facebook', '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M22.68 0H1.32C.59 0 0 .59 0 1.32v21.36C0 23.4.59 24 1.32 24h11.5v-9.29H9.69v-3.62h3.13V8.41c0-3.1 1.89-4.79 4.66-4.79 1.32 0 2.46.1 2.79.14v3.24h-1.92c-1.5 0-1.8.71-1.8 1.76v2.31h3.59l-.47 3.62h-3.12V24h6.12c.73 0 1.32-.59 1.32-1.32V1.32C24 .59 23.4 0 22.68 0z"/></svg>' ),
		'twitter'   => array( 'syseze_social_twitter',  '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>' ),
		'instagram' => array( 'syseze_social_instagram','<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>' ),
	);
	$labels = array( 'linkedin' => 'LinkedIn', 'facebook' => 'Facebook', 'twitter' => 'X (Twitter)', 'instagram' => 'Instagram' );
	echo '<div class="socials">';
	foreach ( $links as $k => $cfg ) {
		$url = esc_url( syseze_mod( $cfg[0] ) );
		if ( ! $url ) { continue; }
		printf(
			'<a href="%s" aria-label="%s" rel="noopener" target="_blank">%s</a>',
			$url,
			esc_attr( $labels[ $k ] ),
			$cfg[1] // SVG markup — known safe.
		);
	}
	echo '</div>';
}
