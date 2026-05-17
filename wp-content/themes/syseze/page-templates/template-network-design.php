<?php
/**
 * Template Name: Service — Network Design
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
		<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><a href="<?php echo esc_url( syseze_page_url( 'services' ) ); ?>">Services</a><span class="sep">/</span>Network Design</div>
		<span class="eyebrow reveal">NETWORK DESIGN</span>
		<h1 class="reveal delay-1">Networks that just work.<br/><span class="gradient-text">Year after year.</span></h1>
		<p class="lead reveal delay-2">Designed once, built right, supported reliably. We architect networks that grow with your business — not against it.</p>
		<div class="hero-ctas reveal delay-3" style="justify-content:center;">
			<a href="<?php echo esc_url( syseze_page_url( 'contact' ) ); ?>" class="btn btn-primary">Design My Network <?php echo $arrow; ?></a>
		</div>
	</div>
</section>

<section class="stats-section">
	<div class="container">
		<div class="stats stats-3">
			<div class="stat reveal"><div class="stat-num">300+</div><div class="stat-label">Networks designed</div></div>
			<div class="stat reveal delay-1"><div class="stat-num">6</div><div class="stat-label">Vendor partnerships</div></div>
			<div class="stat reveal delay-2"><div class="stat-num">99.9%</div><div class="stat-label">Network uptime delivered</div></div>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">What you get</span>
			<h2>Capabilities, end to end</h2>
			<p>Everything we'll bring to the engagement — no gaps to plug with a second vendor.</p>
		</div>
		<div class="cap-grid">
			<div class="cap reveal">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><circle cx="4" cy="4" r="2"/><circle cx="20" cy="4" r="2"/><circle cx="4" cy="20" r="2"/><circle cx="20" cy="20" r="2"/><line x1="6" y1="6" x2="10" y2="10"/><line x1="18" y1="6" x2="14" y2="10"/><line x1="6" y1="18" x2="10" y2="14"/><line x1="18" y1="18" x2="14" y2="14"/></svg></div>
				<h3>Network Architecture</h3>
				<p>Topology, segmentation, redundancy, and capacity planning, done right.</p>
			</div>
			<div class="cap reveal delay-1">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg></div>
				<h3>LAN, WAN & SD-WAN</h3>
				<p>From single offices to multi-site deployments with intelligent routing.</p>
			</div>
			<div class="cap reveal delay-2">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg></div>
				<h3>Wireless Network Design</h3>
				<p>Surveyed, planned, and tuned for real-world coverage.</p>
			</div>
			<div class="cap reveal">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
				<h3>Network Security</h3>
				<p>Firewalls, VLANs, NAC, and zero-trust principles built in.</p>
			</div>
			<div class="cap reveal delay-1">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
				<h3>Performance Optimization</h3>
				<p>Audit existing networks for bottlenecks, latency, and waste.</p>
			</div>
			<div class="cap reveal delay-2">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
				<h3>Network Monitoring</h3>
				<p>24/7 visibility into health, traffic, and threats.</p>
			</div>
		</div>
	</div>
</section>

<section class="section" style="background:linear-gradient(180deg, transparent, rgba(17,24,39,0.4) 50%, transparent);">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">Our approach</span>
			<h2>A clear, 4-step path</h2>
		</div>
		<div class="timeline">
			<div class="step reveal"><div class="ring">01</div><h3>Survey</h3><p>Site walk-through, traffic analysis, and current-state diagram.</p></div>
			<div class="step reveal delay-1"><div class="ring">02</div><h3>Design</h3><p>Network architecture with redundancy, security, and growth modeled in.</p></div>
			<div class="step reveal delay-2"><div class="ring">03</div><h3>Deploy</h3><p>Phased rollout with minimum disruption to operations.</p></div>
			<div class="step reveal delay-3"><div class="ring">04</div><h3>Monitor</h3><p>Ongoing performance tracking and proactive issue resolution.</p></div>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">Tools of the trade</span>
			<h2>Vendors we work with</h2>
		</div>
		<div class="tech-strip reveal delay-1">
			<span class="tech-chip"><span class="dot"></span>Cisco</span>
			<span class="tech-chip"><span class="dot"></span>Fortinet</span>
			<span class="tech-chip"><span class="dot"></span>Aruba</span>
			<span class="tech-chip"><span class="dot"></span>Juniper</span>
			<span class="tech-chip"><span class="dot"></span>MikroTik</span>
			<span class="tech-chip"><span class="dot"></span>Ubiquiti</span>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="callout reveal">
			<p><strong>Networks are the silent foundation.</strong> When they work, no one notices. When they don’t, everything stops. A well-designed network pays back its cost many times over in uptime, security, and avoided crisis calls.</p>
		</div>
	</div>
</section>

<section class="section" style="background:linear-gradient(180deg, transparent, rgba(17,24,39,0.4) 50%, transparent);">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">FAQ</span>
			<h2>Questions we hear a lot</h2>
		</div>
		<div class="faq">
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>Do you only work with specific vendors?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>No — we design vendor-agnostic and recommend based on your needs, budget, and existing investments.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>Can you redesign an existing network without major downtime?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Yes. Most upgrades are planned in phases with cutovers during off-hours.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>Do you handle wireless surveys?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Yes — we use professional survey tools to plan coverage, capacity, and interference mitigation.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>What about multi-site setups?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>We design and deploy multi-site networks regularly, including SD-WAN deployments for geographically distributed offices.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>Do you provide ongoing support after deployment?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Yes — most clients keep us on for monitoring and managed support.</p></div>
			</div>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">Explore more</span>
			<h2>Related services</h2>
		</div>
		<div class="related-services">
			<a class="related-card reveal" href="<?php echo esc_url( syseze_page_url( 'cyber-security' ) ); ?>">
				<div class="rc-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
				<h4>Cyber Security</h4>
				<p>Harden the network we build — firewalls, segmentation, and threat monitoring.</p>
				<span class="rc-arrow">Learn more →</span>
			</a>
			<a class="related-card reveal delay-1" href="<?php echo esc_url( syseze_page_url( 'business-support' ) ); ?>">
				<div class="rc-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg></div>
				<h4>Business Support</h4>
				<p>24/7 network monitoring and managed support after deployment.</p>
				<span class="rc-arrow">Learn more →</span>
			</a>
			<a class="related-card reveal delay-2" href="<?php echo esc_url( syseze_page_url( 'migration-services' ) ); ?>">
				<div class="rc-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/><polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/></svg></div>
				<h4>Migration Services</h4>
				<p>Move your infrastructure to a new network without downtime.</p>
				<span class="rc-arrow">Learn more →</span>
			</a>
		</div>
	</div>
</section>

<?php syseze_cta_banner( "Build a network you can stop worrying about.", "Start with a network assessment. We'll review your topology, traffic, and gaps in a single working session.", "Book a Network Assessment" ); ?>

<?php get_footer(); ?>
