<?php
/**
 * Template Name: Services Overview
 *
 * @package SysEze
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
$arrow = syseze_arrow();
?>

<section class="page-hero">
	<?php syseze_orbs(); ?>
	<div class="container" style="position:relative;z-index:2;">
		<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span>Services</div>
		<span class="eyebrow reveal">What we do</span>
		<h1 class="reveal delay-1">End-to-end IT services.<br/><span class="gradient-text">One trusted partner.</span></h1>
		<p class="lead reveal delay-2">From cloud architecture to 24/7 support, every service is built around one goal: making your technology a quiet, reliable foundation for everything else.</p>
		<div class="hero-ctas reveal delay-3" style="justify-content:center;">
			<a href="<?php echo esc_url( syseze_page_url( 'contact' ) ); ?>" class="btn btn-primary">Contact Us</a>
			<a href="<?php echo esc_url( syseze_page_url( 'contact' ) ); ?>" class="btn btn-ghost">Talk to an Expert</a>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">Our services</span>
			<h2>Six practices. One accountable team.</h2>
		</div>
		<div class="card-grid">
			<?php
			$svcs = array(
				array( 'cloud-services', 'Cloud Services', 'Multi-cloud strategy, migration, and management across AWS, Azure, and GCP — built for cost, scale, and resilience.', '<path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/>' ),
				array( 'it-consulting', 'IT Consulting', 'Strategic technology roadmaps that align your infrastructure with where your business is actually going.', '<path d="M12 2 2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>' ),
				array( 'migration-services', 'Migration Services', 'Move workloads, data, and entire environments with zero downtime and zero drama.', '<polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/><polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/><line x1="4" y1="4" x2="9" y2="9"/>' ),
				array( 'network-design', 'Network Design', 'Resilient, secure, and high-performance network architecture — designed once, built to last.', '<circle cx="12" cy="12" r="3"/><circle cx="4" cy="4" r="2"/><circle cx="20" cy="4" r="2"/><circle cx="4" cy="20" r="2"/><circle cx="20" cy="20" r="2"/><line x1="6" y1="6" x2="10" y2="10"/><line x1="18" y1="6" x2="14" y2="10"/><line x1="6" y1="18" x2="10" y2="14"/><line x1="18" y1="18" x2="14" y2="14"/>' ),
				array( 'cyber-security', 'Cyber Security', 'Threat detection, compliance, and response programs that protect what matters — before it gets exploited.', '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>' ),
				array( 'business-support', 'Business Support', 'Managed IT support on a pay-as-you-go model — senior engineers on standby, real fixes in real time.', '<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>' ),
			);
			foreach ( $svcs as $i => $svc ) {
				$delay = $i ? ' delay-' . $i : '';
				printf(
					'<a class="card reveal%s" href="%s"><div class="card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">%s</svg></div><h3>%s</h3><p>%s</p><span class="btn-link">Explore %s</span></a>',
					$delay, esc_url( syseze_page_url( $svc[0] ) ), $svc[3], esc_html( $svc[1] ), esc_html( $svc[2] ), $arrow
				);
			}
			?>
		</div>
	</div>
</section>

<section class="section" style="background:linear-gradient(180deg, transparent, rgba(17,24,39,0.4) 50%, transparent);">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">How we engage</span>
			<h2>From audit to ongoing support — one continuous loop</h2>
		</div>
		<div class="timeline">
			<div class="step reveal"><div class="ring">01</div><h3>Discover</h3><p>We audit your current environment, understand your goals, and identify gaps.</p></div>
			<div class="step reveal delay-1"><div class="ring">02</div><h3>Design</h3><p>We architect a tailored solution — sized to your business, not ours.</p></div>
			<div class="step reveal delay-2"><div class="ring">03</div><h3>Deploy</h3><p>We implement with discipline, communication, and zero unplanned downtime.</p></div>
			<div class="step reveal delay-3"><div class="ring">04</div><h3>Support</h3><p>We stay engaged with ongoing monitoring, optimization, and support.</p></div>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">Industries</span>
			<h2>Industries we serve</h2>
			<p>The systems differ. The principles don't. We've delivered work across these sectors.</p>
		</div>
		<div class="industries">
			<?php
			$industries = array(
				array( 'Healthcare',         '<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>' ),
				array( 'Manufacturing',      '<rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="8" cy="12" r="2"/><circle cx="16" cy="12" r="2"/>' ),
				array( 'Retail &amp; E-commerce', '<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/>' ),
				array( 'Financial Services', '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>' ),
				array( 'Education',          '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 4 3 6 3s6-1 6-3v-5"/>' ),
				array( 'Logistics',          '<rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>' ),
			);
			foreach ( $industries as $i => $ind ) {
				$delay = $i ? ' delay-' . $i : '';
				printf( '<div class="industry reveal%s"><div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">%s</svg></div><div class="name">%s</div></div>',
					$delay, $ind[1], $ind[0] );
			}
			?>
		</div>
	</div>
</section>

<?php syseze_cta_banner( 'Not sure which service you need?', 'That\'s exactly what our free audit is for. We\'ll listen, look at your setup, and tell you what we\'d actually do.', 'Contact Us' ); ?>

<?php get_footer(); ?>
