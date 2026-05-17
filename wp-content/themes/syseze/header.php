<?php
/**
 * Header — nav + open <main>.
 *
 * @package SysEze
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$is_services_page = is_page( array( 'services', 'cloud-services', 'it-consulting', 'migration-services', 'network-design', 'cyber-security', 'business-support' ) );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="profile" href="https://gmpg.org/xfn/11">
<link rel="icon" type="image/png" href="<?php echo esc_url( syseze_logo_url() ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) { wp_body_open(); } ?>

<header class="nav" role="banner">
	<div class="nav-inner">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand" aria-label="<?php bloginfo( 'name' ); ?> — home">
			<img src="<?php echo esc_url( syseze_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
		</a>

		<nav aria-label="<?php esc_attr_e( 'Primary', 'syseze' ); ?>">
			<ul class="nav-links">
				<li><a class="<?php echo is_page( 'about' ) ? 'active' : ''; ?>" href="<?php echo esc_url( syseze_page_url( 'about' ) ); ?>"><?php esc_html_e( 'About', 'syseze' ); ?></a></li>

				<li class="nav-item">
					<a class="<?php echo $is_services_page ? 'active' : ''; ?>" href="<?php echo esc_url( syseze_page_url( 'services' ) ); ?>">
						<?php esc_html_e( 'Services', 'syseze' ); ?>
						<svg class="caret" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</a>
					<div class="dropdown" role="menu">
						<a href="<?php echo esc_url( syseze_page_url( 'cloud-services' ) ); ?>"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg></span><span><span class="label">Cloud Services</span><span class="desc">Multi-cloud architecture &amp; ops</span></span></a>
						<a href="<?php echo esc_url( syseze_page_url( 'it-consulting' ) ); ?>"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg></span><span><span class="label">IT Consulting</span><span class="desc">Strategy &amp; technology roadmaps</span></span></a>
						<a href="<?php echo esc_url( syseze_page_url( 'migration-services' ) ); ?>"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/><polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/><line x1="4" y1="4" x2="9" y2="9"/></svg></span><span><span class="label">Migration Services</span><span class="desc">Zero-downtime infra moves</span></span></a>
						<a href="<?php echo esc_url( syseze_page_url( 'network-design' ) ); ?>"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><circle cx="4" cy="4" r="2"/><circle cx="20" cy="4" r="2"/><circle cx="4" cy="20" r="2"/><circle cx="20" cy="20" r="2"/><line x1="6" y1="6" x2="10" y2="10"/><line x1="18" y1="6" x2="14" y2="10"/><line x1="6" y1="18" x2="10" y2="14"/><line x1="18" y1="18" x2="14" y2="14"/></svg></span><span><span class="label">Network Design</span><span class="desc">Resilient, scalable topology</span></span></a>
						<a href="<?php echo esc_url( syseze_page_url( 'cyber-security' ) ); ?>"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></span><span><span class="label">Cyber Security</span><span class="desc">Threat protection &amp; compliance</span></span></a>
						<a href="<?php echo esc_url( syseze_page_url( 'business-support' ) ); ?>"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg></span><span><span class="label">Business Support</span><span class="desc">24/7 managed IT, pay-as-you-go</span></span></a>
					</div>
				</li>

				<li><a class="<?php echo is_page( 'portfolio' ) || is_singular( 'portfolio' ) || is_post_type_archive( 'portfolio' ) ? 'active' : ''; ?>" href="<?php echo esc_url( syseze_page_url( 'portfolio' ) ); ?>"><?php esc_html_e( 'Portfolio', 'syseze' ); ?></a></li>
				<li><a class="<?php echo ( is_home() || is_singular( 'post' ) || is_category() || is_tag() ) ? 'active' : ''; ?>" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'syseze' ); ?></a></li>
				<li><a class="<?php echo is_page( 'contact' ) ? 'active' : ''; ?>" href="<?php echo esc_url( syseze_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact', 'syseze' ); ?></a></li>
			</ul>
		</nav>

		<button class="hamburger" aria-label="<?php esc_attr_e( 'Open menu', 'syseze' ); ?>" aria-controls="mobile-menu">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
		</button>
	</div>
</header>

<div class="mobile-menu" id="mobile-menu">
	<div class="mobile-menu-panel">
		<a href="<?php echo esc_url( syseze_page_url( 'about' ) ); ?>"><?php esc_html_e( 'About', 'syseze' ); ?></a>
		<a href="<?php echo esc_url( syseze_page_url( 'services' ) ); ?>"><?php esc_html_e( 'Services', 'syseze' ); ?></a>
		<div class="mobile-sub">
			<a href="<?php echo esc_url( syseze_page_url( 'cloud-services' ) ); ?>">— Cloud Services</a>
			<a href="<?php echo esc_url( syseze_page_url( 'it-consulting' ) ); ?>">— IT Consulting</a>
			<a href="<?php echo esc_url( syseze_page_url( 'migration-services' ) ); ?>">— Migration Services</a>
			<a href="<?php echo esc_url( syseze_page_url( 'network-design' ) ); ?>">— Network Design</a>
			<a href="<?php echo esc_url( syseze_page_url( 'cyber-security' ) ); ?>">— Cyber Security</a>
			<a href="<?php echo esc_url( syseze_page_url( 'business-support' ) ); ?>">— Business Support</a>
		</div>
		<a href="<?php echo esc_url( syseze_page_url( 'portfolio' ) ); ?>"><?php esc_html_e( 'Portfolio', 'syseze' ); ?></a>
		<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'syseze' ); ?></a>
		<a href="<?php echo esc_url( syseze_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact', 'syseze' ); ?></a>
		<a href="<?php echo esc_url( syseze_page_url( 'contact' ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Contact Us', 'syseze' ); ?></a>
	</div>
</div>

<main id="primary">
