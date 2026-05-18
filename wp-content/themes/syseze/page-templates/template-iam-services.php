<?php
/**
 * Template Name: Service — IAM Services
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
		<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><a href="<?php echo esc_url( syseze_page_url( 'services' ) ); ?>">Services</a><span class="sep">/</span>IAM Services</div>
		<span class="eyebrow reveal">IAM SERVICES</span>
		<h1 class="reveal delay-1">Identity is the new perimeter.<br/><span class="gradient-text">Control who gets in.</span></h1>
		<p class="lead reveal delay-2">End-to-end identity and access management — from Zero Trust architecture to day-to-day user lifecycle. Built so the right people have access, and everyone else doesn't.</p>
		<div class="hero-ctas reveal delay-3" style="justify-content:center;">
			<a href="<?php echo esc_url( syseze_page_url( 'contact' ) ); ?>" class="btn btn-primary">Talk to an IAM Expert <?php echo $arrow; ?></a>
		</div>
	</div>
</section>

<section class="stats-section">
	<div class="container">
		<div class="stats stats-3">
			<div class="stat reveal"><div class="stat-num">Zero Trust</div><div class="stat-label">Architecture standard</div></div>
			<div class="stat reveal delay-1"><div class="stat-num">80%</div><div class="stat-label">Of breaches involve identity</div></div>
			<div class="stat reveal delay-2"><div class="stat-num">24/7</div><div class="stat-label">Identity threat monitoring</div></div>
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
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
				<h3>Single Sign-On (SSO)</h3>
				<p>One login, every app. Reduce password fatigue and eliminate standing credentials.</p>
			</div>
			<div class="cap reveal delay-1">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg></div>
				<h3>MFA & Passwordless</h3>
				<p>Enforce multi-factor authentication and move toward passwordless where possible.</p>
			</div>
			<div class="cap reveal delay-2">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
				<h3>User Lifecycle Management</h3>
				<p>Automated provisioning and de-provisioning across all systems when people join or leave.</p>
			</div>
			<div class="cap reveal">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg></div>
				<h3>Privileged Access Management</h3>
				<p>Vault, rotate, and audit every privileged credential. No more shared admin passwords.</p>
			</div>
			<div class="cap reveal delay-1">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg></div>
				<h3>Role-Based Access Control</h3>
				<p>Least-privilege access by design. Users get exactly what they need — nothing more.</p>
			</div>
			<div class="cap reveal delay-2">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
				<h3>Identity Governance & Auditing</h3>
				<p>Access reviews, certification campaigns, and audit-ready logs for every identity event.</p>
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
			<div class="step reveal"><div class="ring">01</div><h3>Assess</h3><p>Map every identity, role, and access path in your environment.</p></div>
			<div class="step reveal delay-1"><div class="ring">02</div><h3>Design</h3><p>Architect a Zero Trust identity model that fits your stack and scale.</p></div>
			<div class="step reveal delay-2"><div class="ring">03</div><h3>Deploy</h3><p>Roll out SSO, MFA, PAM, and lifecycle automation with minimal disruption.</p></div>
			<div class="step reveal delay-3"><div class="ring">04</div><h3>Govern</h3><p>Continuous access reviews, anomaly detection, and audit reporting.</p></div>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">NetIQ IAM Solutions</span>
			<h2>Deep expertise in the NetIQ stack</h2>
			<p>We design, deploy, and support the full NetIQ identity suite — NAM, IDM, IG, and eDirectory — across complex enterprise environments.</p>
		</div>
		<div class="netiq-grid">

			<div class="netiq-card reveal">
				<span class="netiq-badge">NAM</span>
				<h3>NetIQ Access Manager</h3>
				<p>Enterprise web SSO and federation platform that secures access to web applications across on-prem and cloud environments.</p>
				<ul class="netiq-features">
					<li>SAML 2.0, OAuth 2.0 &amp; OpenID Connect federation</li>
					<li>Web application firewall and reverse proxy</li>
					<li>Policy-based access control per application</li>
					<li>Risk-based step-up authentication</li>
					<li>Integration with Active Directory, eDirectory &amp; LDAP</li>
				</ul>
			</div>

			<div class="netiq-card reveal delay-1">
				<span class="netiq-badge">IDM</span>
				<h3>NetIQ Identity Manager</h3>
				<p>Driver-based identity provisioning engine that synchronises user data and automates the full joiner-mover-leaver lifecycle across all connected systems.</p>
				<ul class="netiq-features">
					<li>200+ out-of-the-box connectors (AD, SAP, JDBC, LDAP, REST)</li>
					<li>Automated provisioning and de-provisioning workflows</li>
					<li>Role-based entitlement assignment</li>
					<li>Password sync and self-service reset across directories</li>
					<li>Real-time bidirectional data synchronisation</li>
				</ul>
			</div>

			<div class="netiq-card reveal">
				<span class="netiq-badge">IG</span>
				<h3>NetIQ Identity Governance</h3>
				<p>Access governance platform for continuous visibility into who has access to what — and whether they should still have it.</p>
				<ul class="netiq-features">
					<li>Periodic access certification and review campaigns</li>
					<li>Separation of duties (SoD) conflict detection</li>
					<li>Role mining and role lifecycle management</li>
					<li>Risk scoring for entitlements and identities</li>
					<li>Audit-ready reports for ISO 27001, SOX &amp; GDPR</li>
				</ul>
			</div>

			<div class="netiq-card reveal delay-1">
				<span class="netiq-badge">eDirectory</span>
				<h3>NetIQ eDirectory</h3>
				<p>High-performance, X.500-compliant LDAP directory service — the backbone of the NetIQ identity stack and a standalone enterprise directory in its own right.</p>
				<ul class="netiq-features">
					<li>Cross-platform: Linux, Windows, Solaris</li>
					<li>Multi-master replication with sub-second convergence</li>
					<li>Fine-grained ACLs and attribute-level security</li>
					<li>Native integration with IDM, NAM &amp; IG</li>
					<li>Scales to hundreds of millions of objects</li>
				</ul>
			</div>

		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">Tools of the trade</span>
			<h2>Platforms we work with</h2>
		</div>
		<div class="tech-strip reveal delay-1">
			<span class="tech-chip"><span class="dot"></span>NetIQ NAM</span>
			<span class="tech-chip"><span class="dot"></span>NetIQ IDM</span>
			<span class="tech-chip"><span class="dot"></span>NetIQ IG</span>
			<span class="tech-chip"><span class="dot"></span>eDirectory</span>
			<span class="tech-chip"><span class="dot"></span>Microsoft Entra ID</span>
			<span class="tech-chip"><span class="dot"></span>Okta</span>
			<span class="tech-chip"><span class="dot"></span>CyberArk</span>
			<span class="tech-chip"><span class="dot"></span>SailPoint</span>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="callout reveal">
			<p><strong>80% of data breaches involve compromised credentials.</strong> Attackers don't break in — they log in. A strong identity perimeter means that even if a password is stolen, the blast radius is contained. IAM isn't overhead — it's your most cost-effective security investment.</p>
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
				<button class="faq-q" aria-expanded="false"><span>What is IAM and why do we need it?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>IAM controls who can access what in your organisation. Without it, you have no reliable way to enforce least-privilege, track access events, or de-provision users who leave — all of which are top audit failures and breach vectors.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>We already use Microsoft Entra ID — do we still need this?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Having the platform is only the start. Most Entra ID deployments we audit have misconfigured Conditional Access, unused MFA policies, and stale privileged accounts. We close those gaps and get you to a mature posture.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>How long does an IAM rollout take?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>A focused MFA and SSO rollout can be done in 2–4 weeks. Full PAM and identity governance is typically 6–12 weeks depending on environment complexity.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>Can you integrate with our existing HR system?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Yes — we connect identity platforms to HR systems like Darwinbox, SAP SuccessFactors, and Workday so joiner/mover/leaver workflows are fully automated.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>Is PAM only for large enterprises?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>No. Any organisation with admin accounts — which is every organisation — benefits from PAM. We right-size the solution to your team and budget.</p></div>
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
				<p>Pair strong identity with endpoint protection, threat monitoring, and incident response.</p>
				<span class="rc-arrow">Learn more →</span>
			</a>
			<a class="related-card reveal delay-1" href="<?php echo esc_url( syseze_page_url( 'cloud-services' ) ); ?>">
				<div class="rc-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg></div>
				<h4>Cloud Services</h4>
				<p>Secure cloud environments start with proper IAM — right roles, right access, right controls.</p>
				<span class="rc-arrow">Learn more →</span>
			</a>
			<a class="related-card reveal delay-2" href="<?php echo esc_url( syseze_page_url( 'it-consulting' ) ); ?>">
				<div class="rc-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg></div>
				<h4>IT Consulting</h4>
				<p>Strategic identity roadmaps aligned to your compliance requirements and growth plans.</p>
				<span class="rc-arrow">Learn more →</span>
			</a>
		</div>
	</div>
</section>

<?php syseze_cta_banner( "Your identity perimeter needs to be stronger than your firewall.", "Start with an identity assessment. We'll map every access path, surface the risks, and give you a prioritised remediation plan.", "Contact Us" ); ?>

<?php get_footer(); ?>
