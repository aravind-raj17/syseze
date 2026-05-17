<?php
/**
 * Template Name: Service — Business Support
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
		<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><a href="<?php echo esc_url( syseze_page_url( 'services' ) ); ?>">Services</a><span class="sep">/</span>Business Support</div>
		<span class="eyebrow reveal">BUSINESS SUPPORT</span>
		<h1 class="reveal delay-1">Senior engineers, on demand.<br/><span class="gradient-text">Pay only for what you use.</span></h1>
		<p class="lead reveal delay-2">Managed IT support without the bloated retainers. Real engineers, real response times, and a pricing model that respects your budget.</p>
		<div class="hero-ctas reveal delay-3" style="justify-content:center;">
			<a href="<?php echo esc_url( syseze_page_url( 'contact' ) ); ?>" class="btn btn-primary">Talk to Support <?php echo $arrow; ?></a>
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
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
				<h3>Pay-As-You-Go Support</h3>
				<p>No long retainers. Pay only for the hours and tickets you actually use.</p>
			</div>
			<div class="cap reveal delay-1">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
				<h3>24/7 Helpdesk</h3>
				<p>Critical issues get critical attention, around the clock.</p>
			</div>
			<div class="cap reveal delay-2">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg></div>
				<h3>Remote & On-Site Support</h3>
				<p>Most issues solved remotely; on-site engineers when needed.</p>
			</div>
			<div class="cap reveal">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
				<h3>Proactive Monitoring</h3>
				<p>We catch issues before they become outages.</p>
			</div>
			<div class="cap reveal delay-1">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg></div>
				<h3>Patch & Update Management</h3>
				<p>Operating systems, applications, and firmware kept current.</p>
			</div>
			<div class="cap reveal delay-2">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
				<h3>Dedicated Account Manager</h3>
				<p>One point of contact who knows your environment.</p>
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
			<div class="step reveal"><div class="ring">01</div><h3>Onboard</h3><p>We map your environment, users, and critical systems.</p></div>
			<div class="step reveal delay-1"><div class="ring">02</div><h3>Stabilize</h3><p>We fix the chronic, recurring issues first.</p></div>
			<div class="step reveal delay-2"><div class="ring">03</div><h3>Monitor</h3><p>Continuous visibility so we catch problems early.</p></div>
			<div class="step reveal delay-3"><div class="ring">04</div><h3>Respond</h3><p>Clear SLAs, real escalation paths, and engineers who solve — not just log.</p></div>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">Tools of the trade</span>
			<h2>Tools we use</h2>
		</div>
		<div class="tech-strip reveal delay-1">
			<span class="tech-chip"><span class="dot"></span>Microsoft Intune</span>
			<span class="tech-chip"><span class="dot"></span>Datto RMM</span>
			<span class="tech-chip"><span class="dot"></span>ConnectWise</span>
			<span class="tech-chip"><span class="dot"></span>TeamViewer</span>
			<span class="tech-chip"><span class="dot"></span>Zendesk</span>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="callout reveal">
			<p><strong>Most IT support is reactive and overpriced.</strong> Tickets pile up, response times slip, and you pay a flat retainer regardless of what you actually use. Our model flips that — you get senior engineers on demand, billed only for real work done.</p>
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
				<button class="faq-q" aria-expanded="false"><span>How does pay-as-you-go pricing actually work?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>You pay for ticket volume or engineer hours used, with a small base monthly fee for monitoring. No long-term commitments.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>What are your response times?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Critical issues: under 1 hour. High priority: under 4 hours. Standard: same business day.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>Do you provide on-site support?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Yes, across Bangalore and select cities. Most issues are handled remotely first.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>Do you support our existing tools and systems?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Almost certainly. We support Windows, macOS, Linux, all major cloud platforms, and most business applications.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>Can we scale support up or down month to month?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Yes — that’s the whole point of the model. You scale with your business, not against a fixed contract.</p></div>
			</div>
		</div>
	</div>
</section>

<?php syseze_cta_banner( 'Get the support your business actually deserves.', 'Talk to our team. We’ll scope a model that fits your real volume — not a worst-case retainer.', 'Talk to Our Support Team' ); ?>

<?php get_footer(); ?>
