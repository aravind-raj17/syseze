<?php
/**
 * Template Name: Service — IT Consulting
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
		<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><a href="<?php echo esc_url( syseze_page_url( 'services' ) ); ?>">Services</a><span class="sep">/</span>IT Consulting</div>
		<span class="eyebrow reveal">IT CONSULTING</span>
		<h1 class="reveal delay-1">Strategy first.<br/><span class="gradient-text">Tools second.</span></h1>
		<p class="lead reveal delay-2">Most IT problems aren’t tooling problems — they’re strategy problems. We help you choose the right direction before you spend the first rupee on hardware or software.</p>
		<div class="hero-ctas reveal delay-3" style="justify-content:center;">
			<a href="<?php echo esc_url( syseze_page_url( 'contact' ) ); ?>" class="btn btn-primary">Book a Consultation <?php echo $arrow; ?></a>
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
				<h3>Technology Roadmaps</h3>
				<p>A clear 12–36 month plan tied to your business goals, not vendor trends.</p>
			</div>
			<div class="cap reveal delay-1">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
				<h3>Infrastructure Assessment</h3>
				<p>An honest audit of what’s working, what’s wasting money, and what’s about to break.</p>
			</div>
			<div class="cap reveal delay-2">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/></svg></div>
				<h3>Digital Transformation</h3>
				<p>Pragmatic, phased plans — not buzzwords.</p>
			</div>
			<div class="cap reveal">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
				<h3>Vendor Selection</h3>
				<p>We help you pick the right vendors and negotiate the right terms.</p>
			</div>
			<div class="cap reveal delay-1">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
				<h3>IT Budget Optimization</h3>
				<p>Real cost reduction, not just spreadsheet cuts.</p>
			</div>
			<div class="cap reveal delay-2">
				<div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg></div>
				<h3>Compliance Advisory</h3>
				<p>Practical guidance on ISO 27001, SOC 2, and industry-specific frameworks.</p>
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
			<div class="step reveal"><div class="ring">01</div><h3>Listen</h3><p>We start by understanding your business, not your tech stack.</p></div>
			<div class="step reveal delay-1"><div class="ring">02</div><h3>Assess</h3><p>We benchmark your current state against where you want to go.</p></div>
			<div class="step reveal delay-2"><div class="ring">03</div><h3>Recommend</h3><p>Clear, prioritized recommendations with cost and risk laid out.</p></div>
			<div class="step reveal delay-3"><div class="ring">04</div><h3>Execute or Hand Off</h3><p>We can implement, or hand the plan to your internal team.</p></div>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">Tools of the trade</span>
			<h2>Frameworks we work with</h2>
		</div>
		<div class="tech-strip reveal delay-1">
			<span class="tech-chip"><span class="dot"></span>ITIL</span>
			<span class="tech-chip"><span class="dot"></span>COBIT</span>
			<span class="tech-chip"><span class="dot"></span>TOGAF</span>
			<span class="tech-chip"><span class="dot"></span>ISO 27001</span>
			<span class="tech-chip"><span class="dot"></span>NIST CSF</span>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="callout reveal">
			<p><strong>The biggest IT mistakes are strategic, not technical.</strong> A wrong vendor choice, an over-engineered solution, or a missed compliance gap can cost ten times more than getting it right upfront. We help you get it right upfront.</p>
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
				<button class="faq-q" aria-expanded="false"><span>Are you tied to any specific vendor?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>No. We’re entirely vendor-agnostic, which means our recommendations are based on what fits you — not what pays us a commission.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>How long does a typical consulting engagement run?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Anywhere from a 2-week assessment to a 6-month transformation program. We scope every engagement upfront.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>Will you work alongside our internal IT team?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Absolutely. We often work as an extension of in-house teams, especially during transitions.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>Do you provide written deliverables?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>Yes — every engagement produces clear, written deliverables: assessment reports, roadmaps, architecture diagrams, and recommendation documents.</p></div>
			</div>
			<div class="faq-item reveal">
				<button class="faq-q" aria-expanded="false"><span>Can you help us if we’re not sure what we need?</span><span class="plus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 19 12"/></svg></span></button>
				<div class="faq-a"><p>That’s often the best time to bring us in. The first conversation is free.</p></div>
			</div>
		</div>
	</div>
</section>

<?php syseze_cta_banner( 'Make your next IT decision with confidence.', 'A 30-minute strategy call. No deck, no pitch — just a real conversation about your situation.', 'Book a Free Strategy Call' ); ?>

<?php get_footer(); ?>
