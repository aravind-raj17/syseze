<?php
/**
 * Template Name: Service — Cloud Services
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
		<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><a href="<?php echo esc_url( syseze_page_url( 'services' ) ); ?>">Services</a><span class="sep">/</span>Cloud Services</div>
		<span class="eyebrow reveal">CLOUD SERVICES</span>
		<h1 class="reveal delay-1">Cloud, done right.<br/><span class="gradient-text">Sized to your business.</span></h1>
		<p class="lead reveal delay-2">From first migration to multi-cloud optimization — we help you adopt cloud the way it should work: cost-controlled, secure, and built to scale.</p>
		<div class="hero-ctas reveal delay-3" style="justify-content:center;">
			<a href="<?php echo esc_url( syseze_page_url( 'contact' ) ); ?>" class="btn btn-primary">Talk to a Cloud Expert <?php echo $arrow; ?></a>
		</div>
	</div>
</section>

<section class="stats-section">
	<div class="container">
		<div class="stats stats-3">
			<div class="stat reveal"><div class="stat-num">50+</div><div class="stat-label">Cloud deployments</div></div>
			<div class="stat reveal delay-1"><div class="stat-num">40%</div><div class="stat-label">Avg. cost reduction</div></div>
			<div class="stat reveal delay-2"><div class="stat-num">99.9%</div><div class="stat-label">Uptime SLA</div></div>
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
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg></div>
				<h3>Cloud Strategy & Assessment</h3>
				<p>Clarity on which workloads belong where (and what to leave alone).</p>
			</div>
			<div class="cap reveal delay-1">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/></svg></div>
				<h3>Migration & Modernization</h3>
				<p>Lift-and-shift, refactor, or rebuild — your call, our execution.</p>
			</div>
			<div class="cap reveal delay-2">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg></div>
				<h3>Multi-Cloud Architecture</h3>
				<p>AWS, Azure, GCP — designed to work together, not against each other.</p>
			</div>
			<div class="cap reveal">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
				<h3>Cost Optimization</h3>
				<p>Real savings through right-sizing, reserved capacity, and waste elimination.</p>
			</div>
			<div class="cap reveal delay-1">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
				<h3>Cloud Security & Compliance</h3>
				<p>IAM, encryption, monitoring, and audit-ready posture from day one.</p>
			</div>
			<div class="cap reveal delay-2">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/></svg></div>
				<h3>24/7 Cloud Operations</h3>
				<p>Monitoring, patching, scaling, and support that never sleeps.</p>
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
			<div class="step reveal"><div class="ring">01</div><h3>Audit</h3><p>We map your current workloads, costs, and constraints.</p></div>
			<div class="step reveal delay-1"><div class="ring">02</div><h3>Architect</h3><p>We design the target state, with cost and risk modeled upfront.</p></div>
			<div class="step reveal delay-2"><div class="ring">03</div><h3>Migrate</h3><p>We execute in phases, with rollback plans and zero data loss.</p></div>
			<div class="step reveal delay-3"><div class="ring">04</div><h3>Optimize</h3><p>We keep tuning long after the migration is done.</p></div>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">Tools of the trade</span>
			<h2>Technologies & platforms</h2>
		</div>
		<div class="tech-strip reveal delay-1">
			<span class="tech-chip"><span class="dot"></span>AWS</span>
			<span class="tech-chip"><span class="dot"></span>Microsoft Azure</span>
			<span class="tech-chip"><span class="dot"></span>Google Cloud</span>
			<span class="tech-chip"><span class="dot"></span>Kubernetes</span>
			<span class="tech-chip"><span class="dot"></span>Terraform</span>
			<span class="tech-chip"><span class="dot"></span>Docker</span>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="callout reveal">
			<p><strong>Cloud isn’t a destination — it’s a discipline.</strong> Done well, it gives you speed, resilience, and predictable cost. Done poorly, it gives you a bigger invoice and the same problems. We help you stay on the right side of that line.</p>
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
				<button class="faq-q" aria-expanded="false"><span>Will my workloads have downtime during migration?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>For most workloads, no. We design migrations in phases with cutover windows scheduled around your business, and we run parallel environments during critical transitions.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>How much will cloud actually cost us?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>We model it upfront. Before any migration, you’ll see projected monthly costs broken down by service, with reserved-capacity and optimization scenarios.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>Do you lock us into one cloud provider?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>No. We’re vendor-agnostic. If a multi-cloud approach serves you better, that’s what we’ll recommend.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>What about security in the cloud?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Security is baked into the architecture from day one — IAM, encryption at rest and in transit, network segmentation, logging, and compliance controls aligned to your industry.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>Do you support hybrid environments?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Yes. Many of our clients run hybrid setups (some workloads on-prem, others in the cloud). We design and support both.</p></div>
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
			<a class="related-card reveal" href="<?php echo esc_url( syseze_page_url( ‘migration-services’ ) ); ?>">
				<div class="rc-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/><polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/></svg></div>
				<h4>Migration Services</h4>
				<p>Zero-downtime moves to the cloud, planned and validated at every step.</p>
				<span class="rc-arrow">Learn more →</span>
			</a>
			<a class="related-card reveal delay-1" href="<?php echo esc_url( syseze_page_url( ‘cyber-security’ ) ); ?>">
				<div class="rc-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
				<h4>Cyber Security</h4>
				<p>Secure your cloud environment against modern threats and compliance gaps.</p>
				<span class="rc-arrow">Learn more →</span>
			</a>
			<a class="related-card reveal delay-2" href="<?php echo esc_url( syseze_page_url( ‘it-consulting’ ) ); ?>">
				<div class="rc-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg></div>
				<h4>IT Consulting</h4>
				<p>Strategic roadmaps that align your cloud investment with business goals.</p>
				<span class="rc-arrow">Learn more →</span>
			</a>
		</div>
	</div>
</section>

<?php syseze_cta_banner( "Ready to move to the cloud — or get more out of the one you're already on?", "A free audit will surface your biggest cost and risk gaps in 30 minutes.", "Book a Free Cloud Audit" ); ?>

<?php get_footer(); ?>
