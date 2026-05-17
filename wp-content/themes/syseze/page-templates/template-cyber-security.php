<?php
/**
 * Template Name: Service — Cyber Security
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
		<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><a href="<?php echo esc_url( syseze_page_url( 'services' ) ); ?>">Services</a><span class="sep">/</span>Cyber Security</div>
		<span class="eyebrow reveal">CYBER SECURITY</span>
		<h1 class="reveal delay-1">Stop threats<br/><span class="gradient-text">before they stop you.</span></h1>
		<p class="lead reveal delay-2">End-to-end security — from prevention to detection to response. Built around real threats, not checkboxes.</p>
		<div class="hero-ctas reveal delay-3" style="justify-content:center;">
			<a href="<?php echo esc_url( syseze_page_url( 'contact' ) ); ?>" class="btn btn-primary">Get a Security Audit <?php echo $arrow; ?></a>
		</div>
	</div>
</section>

<section class="stats-section">
	<div class="container">
		<div class="stats stats-3">
			<div class="stat reveal"><div class="stat-num">500+</div><div class="stat-label">Threats neutralized</div></div>
			<div class="stat reveal delay-1"><div class="stat-num">&lt; 1 hr</div><div class="stat-label">Incident response SLA</div></div>
			<div class="stat reveal delay-2"><div class="stat-num">ISO</div><div class="stat-label">27001 aligned practice</div></div>
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
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
				<h3>Security Assessments</h3>
				<p>Vulnerability scans, penetration tests, and compliance gap analysis.</p>
			</div>
			<div class="cap reveal delay-1">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
				<h3>Endpoint & Network Security</h3>
				<p>Firewalls, EDR, IDS/IPS, and segmentation done properly.</p>
			</div>
			<div class="cap reveal delay-2">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
				<h3>Email & Identity Security</h3>
				<p>Phishing protection, MFA rollouts, and identity governance.</p>
			</div>
			<div class="cap reveal">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg></div>
				<h3>Compliance & Governance</h3>
				<p>ISO 27001, GDPR, HIPAA, PCI-DSS — practical paths to audit-ready.</p>
			</div>
			<div class="cap reveal delay-1">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
				<h3>Incident Response</h3>
				<p>A documented playbook, ready before you need it.</p>
			</div>
			<div class="cap reveal delay-2">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
				<h3>Awareness Training</h3>
				<p>Because most breaches start with a click.</p>
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
			<div class="step reveal"><div class="ring">01</div><h3>Assess</h3><p>Map your assets, threats, and current defenses.</p></div>
			<div class="step reveal delay-1"><div class="ring">02</div><h3>Harden</h3><p>Close the high-impact gaps first.</p></div>
			<div class="step reveal delay-2"><div class="ring">03</div><h3>Monitor</h3><p>Detect threats in real time, 24/7.</p></div>
			<div class="step reveal delay-3"><div class="ring">04</div><h3>Respond</h3><p>When something happens, you have a plan — not a panic.</p></div>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">Tools of the trade</span>
			<h2>Tools & frameworks</h2>
		</div>
		<div class="tech-strip reveal delay-1">
			<span class="tech-chip"><span class="dot"></span>Fortinet</span>
			<span class="tech-chip"><span class="dot"></span>Sophos</span>
			<span class="tech-chip"><span class="dot"></span>CrowdStrike</span>
			<span class="tech-chip"><span class="dot"></span>Microsoft Defender</span>
			<span class="tech-chip"><span class="dot"></span>ISO 27001</span>
			<span class="tech-chip"><span class="dot"></span>NIST CSF</span>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="callout reveal">
			<p><strong>Cyber attacks aren’t a question of “if” — they’re a question of “when.”</strong> Most breaches succeed not because attackers are sophisticated, but because defenses are inconsistent. We help you build security that’s actually consistent.</p>
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
				<button class="faq-q" aria-expanded="false"><span>We’re a small business — do we really need this?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Yes. Small businesses are targeted more often, not less — because attackers know smaller teams have fewer defenses.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>How is a security audit different from a vulnerability scan?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Scans find known issues. Audits evaluate your overall posture — including processes, policies, and people. You need both.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>Do you handle compliance certifications?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>We prepare you for them. The certification itself is done by an accredited third-party auditor — we ensure you pass.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>What happens if we’re already in the middle of an incident?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Call us immediately. We have an incident response team and can engage within hours.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>How often should we do a security review?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>At minimum, annually. For most businesses, a quarterly check-in is more appropriate.</p></div>
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
			<a class="related-card reveal" href="<?php echo esc_url( syseze_page_url( ‘network-design’ ) ); ?>">
				<div class="rc-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><circle cx="4" cy="4" r="2"/><circle cx="20" cy="4" r="2"/><circle cx="4" cy="20" r="2"/><circle cx="20" cy="20" r="2"/><line x1="6" y1="6" x2="10" y2="10"/><line x1="18" y1="6" x2="14" y2="10"/><line x1="6" y1="18" x2="10" y2="14"/><line x1="18" y1="18" x2="14" y2="14"/></svg></div>
				<h4>Network Design</h4>
				<p>Segmented, zero-trust network architecture that shrinks your attack surface.</p>
				<span class="rc-arrow">Learn more →</span>
			</a>
			<a class="related-card reveal delay-1" href="<?php echo esc_url( syseze_page_url( ‘it-consulting’ ) ); ?>">
				<div class="rc-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg></div>
				<h4>IT Consulting</h4>
				<p>Security-led technology roadmaps that keep compliance front and center.</p>
				<span class="rc-arrow">Learn more →</span>
			</a>
			<a class="related-card reveal delay-2" href="<?php echo esc_url( syseze_page_url( ‘cloud-services’ ) ); ?>">
				<div class="rc-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg></div>
				<h4>Cloud Services</h4>
				<p>Secure cloud environments with proper IAM, encryption, and monitoring.</p>
				<span class="rc-arrow">Learn more →</span>
			</a>
		</div>
	</div>
</section>

<?php syseze_cta_banner( "Don't wait for an incident to take security seriously.", "A free security audit will surface your highest-impact gaps in 30 minutes.", "Book a Free Security Audit" ); ?>

<?php get_footer(); ?>
