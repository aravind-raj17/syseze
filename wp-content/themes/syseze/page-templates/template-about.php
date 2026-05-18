<?php
/**
 * Template Name: About
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
		<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'syseze' ); ?></a><span class="sep">/</span><?php esc_html_e( 'About', 'syseze' ); ?></div>
		<span class="eyebrow reveal"><?php esc_html_e( 'About SysEze', 'syseze' ); ?></span>
		<h1 class="reveal delay-1"><?php esc_html_e( 'Built to simplify your IT.', 'syseze' ); ?><br/><span class="gradient-text"><?php esc_html_e( 'Engineered to scale your business.', 'syseze' ); ?></span></h1>
		<p class="lead reveal delay-2"><?php esc_html_e( 'Since 2019, we\'ve been the trusted IT infrastructure partner for businesses across India — turning complex technology into clean, reliable systems that just work.', 'syseze' ); ?></p>
		<div class="hero-ctas reveal delay-3" style="justify-content:center;">
			<a href="<?php echo esc_url( syseze_page_url( 'contact' ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Talk to our team', 'syseze' ); ?></a>
			<a href="<?php echo esc_url( syseze_page_url( 'services' ) ); ?>" class="btn btn-ghost"><?php esc_html_e( 'View our services', 'syseze' ); ?></a>
		</div>
	</div>
</section>

<!-- Our Story -->
<section class="section">
	<div class="container">
		<div class="two-col">
			<div class="reveal">
				<span class="eyebrow"><?php esc_html_e( 'Our Story', 'syseze' ); ?></span>
				<h2><?php esc_html_e( 'From a small team to a trusted IT partner', 'syseze' ); ?></h2>
				<p><?php esc_html_e( 'SysEze began in 2019 as PC Services.in, a small team obsessed with one thing: making IT genuinely easy for the businesses we served. As our clients grew, so did the complexity of their challenges — and so did we.', 'syseze' ); ?></p>
				<p><?php esc_html_e( 'Today, as SysEze Tech Pvt Ltd, we deliver end-to-end IT infrastructure solutions to businesses of every size. From startups setting up their first cloud environment to established enterprises modernizing decades-old systems, we bring the same principle to every engagement: clear thinking, careful execution, and honest support.', 'syseze' ); ?></p>
				<p><?php esc_html_e( "We don't believe in bloated retainers or one-size-fits-all packages. We believe in solving the right problem, the right way, the first time.", 'syseze' ); ?></p>
			</div>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="reveal delay-1" style="border-radius:var(--radius-lg); overflow:hidden;">
					<?php the_post_thumbnail( 'syseze-featured' ); ?>
				</div>
			<?php else : ?>
				<div class="about-illustration reveal delay-1" aria-hidden="true">
					<svg viewBox="0 0 480 380" fill="none" xmlns="http://www.w3.org/2000/svg">
						<!-- Grid dots -->
						<defs>
							<pattern id="dots" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
								<circle cx="2" cy="2" r="1.5" fill="rgba(99,102,241,0.18)"/>
							</pattern>
							<radialGradient id="glow1" cx="50%" cy="50%" r="50%">
								<stop offset="0%" stop-color="#06b6d4" stop-opacity="0.15"/>
								<stop offset="100%" stop-color="#06b6d4" stop-opacity="0"/>
							</radialGradient>
							<radialGradient id="glow2" cx="50%" cy="50%" r="50%">
								<stop offset="0%" stop-color="#8b5cf6" stop-opacity="0.12"/>
								<stop offset="100%" stop-color="#8b5cf6" stop-opacity="0"/>
							</radialGradient>
						</defs>
						<rect width="480" height="380" fill="url(#dots)"/>
						<!-- Glow blobs -->
						<ellipse cx="160" cy="180" rx="140" ry="120" fill="url(#glow2)"/>
						<ellipse cx="340" cy="200" rx="120" ry="100" fill="url(#glow1)"/>
						<!-- Connection lines -->
						<line x1="240" y1="80" x2="120" y2="180" stroke="rgba(99,102,241,0.3)" stroke-width="1.5" stroke-dasharray="4 4"/>
						<line x1="240" y1="80" x2="360" y2="160" stroke="rgba(6,182,212,0.3)" stroke-width="1.5" stroke-dasharray="4 4"/>
						<line x1="120" y1="180" x2="100" y2="290" stroke="rgba(99,102,241,0.25)" stroke-width="1.5" stroke-dasharray="4 4"/>
						<line x1="360" y1="160" x2="380" y2="280" stroke="rgba(6,182,212,0.25)" stroke-width="1.5" stroke-dasharray="4 4"/>
						<line x1="120" y1="180" x2="240" y2="260" stroke="rgba(139,92,246,0.2)" stroke-width="1.5" stroke-dasharray="4 4"/>
						<line x1="360" y1="160" x2="240" y2="260" stroke="rgba(139,92,246,0.2)" stroke-width="1.5" stroke-dasharray="4 4"/>
						<line x1="100" y1="290" x2="240" y2="260" stroke="rgba(6,182,212,0.2)" stroke-width="1.5" stroke-dasharray="4 4"/>
						<line x1="380" y1="280" x2="240" y2="260" stroke="rgba(99,102,241,0.2)" stroke-width="1.5" stroke-dasharray="4 4"/>
						<!-- Central node — cloud -->
						<circle cx="240" cy="80" r="36" fill="rgba(15,23,42,0.9)" stroke="rgba(6,182,212,0.6)" stroke-width="1.5"/>
						<path d="M224 86h-4a8 8 0 0 1 0-16 7.9 7.9 0 0 1 15.3-2A6 6 0 1 1 256 74v1h-32z" fill="none" stroke="#06b6d4" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
						<!-- Left node — shield -->
						<circle cx="120" cy="180" r="30" fill="rgba(15,23,42,0.9)" stroke="rgba(139,92,246,0.6)" stroke-width="1.5"/>
						<path d="M120 166l-10 4v8c0 6 4.5 11 10 13 5.5-2 10-7 10-13v-8l-10-4z" fill="none" stroke="#8b5cf6" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
						<!-- Right node — network -->
						<circle cx="360" cy="160" r="30" fill="rgba(15,23,42,0.9)" stroke="rgba(6,182,212,0.5)" stroke-width="1.5"/>
						<circle cx="360" cy="156" r="3" fill="#06b6d4"/>
						<circle cx="350" cy="166" r="2.5" fill="#06b6d4" opacity="0.7"/>
						<circle cx="370" cy="166" r="2.5" fill="#06b6d4" opacity="0.7"/>
						<circle cx="345" cy="158" r="2" fill="#06b6d4" opacity="0.5"/>
						<circle cx="375" cy="158" r="2" fill="#06b6d4" opacity="0.5"/>
						<line x1="360" y1="156" x2="350" y2="166" stroke="#06b6d4" stroke-width="1.2" opacity="0.6"/>
						<line x1="360" y1="156" x2="370" y2="166" stroke="#06b6d4" stroke-width="1.2" opacity="0.6"/>
						<line x1="360" y1="156" x2="345" y2="158" stroke="#06b6d4" stroke-width="1.2" opacity="0.4"/>
						<line x1="360" y1="156" x2="375" y2="158" stroke="#06b6d4" stroke-width="1.2" opacity="0.4"/>
						<!-- Bottom-left node — server -->
						<circle cx="100" cy="290" r="28" fill="rgba(15,23,42,0.9)" stroke="rgba(99,102,241,0.5)" stroke-width="1.5"/>
						<rect x="88" y="280" width="24" height="7" rx="1.5" fill="none" stroke="#6366f1" stroke-width="1.5"/>
						<rect x="88" y="290" width="24" height="7" rx="1.5" fill="none" stroke="#6366f1" stroke-width="1.5"/>
						<circle cx="108" cy="283.5" r="1.5" fill="#6366f1"/>
						<circle cx="108" cy="293.5" r="1.5" fill="#6366f1"/>
						<!-- Bottom-right node — lock -->
						<circle cx="380" cy="280" r="28" fill="rgba(15,23,42,0.9)" stroke="rgba(6,182,212,0.5)" stroke-width="1.5"/>
						<rect x="371" y="279" width="18" height="13" rx="2" fill="none" stroke="#06b6d4" stroke-width="1.5"/>
						<path d="M374 279v-4a6 6 0 0 1 12 0v4" fill="none" stroke="#06b6d4" stroke-width="1.5" stroke-linecap="round"/>
						<circle cx="380" cy="286" r="2" fill="#06b6d4"/>
						<!-- Centre bottom node — identity -->
						<circle cx="240" cy="260" r="32" fill="rgba(15,23,42,0.95)" stroke="rgba(139,92,246,0.7)" stroke-width="2"/>
						<circle cx="240" cy="252" r="6" fill="none" stroke="#8b5cf6" stroke-width="1.8"/>
						<path d="M226 270a14 14 0 0 1 28 0" fill="none" stroke="#8b5cf6" stroke-width="1.8" stroke-linecap="round"/>
						<!-- Floating particles -->
						<circle cx="190" cy="120" r="2.5" fill="#06b6d4" opacity="0.5"/>
						<circle cx="310" cy="110" r="2" fill="#8b5cf6" opacity="0.4"/>
						<circle cx="160" cy="240" r="2" fill="#6366f1" opacity="0.5"/>
						<circle cx="420" cy="220" r="2.5" fill="#06b6d4" opacity="0.4"/>
						<circle cx="60" cy="200" r="2" fill="#8b5cf6" opacity="0.4"/>
						<circle cx="290" cy="320" r="2" fill="#6366f1" opacity="0.4"/>
						<!-- Labels -->
						<text x="240" y="130" text-anchor="middle" fill="rgba(6,182,212,0.7)" font-size="9" font-family="monospace" letter-spacing="1">CLOUD</text>
						<text x="78" y="222" text-anchor="middle" fill="rgba(139,92,246,0.7)" font-size="9" font-family="monospace" letter-spacing="1">SECURITY</text>
						<text x="362" y="204" text-anchor="middle" fill="rgba(6,182,212,0.7)" font-size="9" font-family="monospace" letter-spacing="1">NETWORK</text>
						<text x="100" y="334" text-anchor="middle" fill="rgba(99,102,241,0.7)" font-size="9" font-family="monospace" letter-spacing="1">INFRA</text>
						<text x="380" y="324" text-anchor="middle" fill="rgba(6,182,212,0.7)" font-size="9" font-family="monospace" letter-spacing="1">ACCESS</text>
						<text x="240" y="308" text-anchor="middle" fill="rgba(139,92,246,0.8)" font-size="9" font-family="monospace" letter-spacing="1">IDENTITY</text>
					</svg>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Mission / Vision / Values -->
<section class="section" style="background:linear-gradient(180deg, transparent, rgba(17,24,39,0.4) 50%, transparent);">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow"><?php esc_html_e( 'What we stand for', 'syseze' ); ?></span>
			<h2><?php esc_html_e( 'Mission. Vision. Values.', 'syseze' ); ?></h2>
			<p><?php esc_html_e( 'Three short statements we hold ourselves to. Everything we ship runs through these.', 'syseze' ); ?></p>
		</div>
		<div class="card-grid">
			<div class="card reveal">
				<div class="card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg></div>
				<h3>Our Mission</h3>
				<p>To empower every business with reliable, cost-effective, and secure IT infrastructure — so technology becomes a growth engine, not a roadblock.</p>
			</div>
			<div class="card reveal delay-1">
				<div class="card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
				<h3>Our Vision</h3>
				<p>To be India's most trusted IT partner — known not for the size of our team, but for the quality of our thinking and the outcomes we deliver.</p>
			</div>
			<div class="card reveal delay-2">
				<div class="card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg></div>
				<h3>Our Values</h3>
				<p>Transparency in pricing. Precision in execution. Partnership over transaction. And a relentless commitment to making complex things simple.</p>
			</div>
		</div>
	</div>
</section>

<!-- What sets us apart -->
<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow"><?php esc_html_e( 'The difference', 'syseze' ); ?></span>
			<h2><?php esc_html_e( 'What sets SysEze apart', 'syseze' ); ?></h2>
		</div>
		<div class="feature-row-4">
			<div class="feature reveal"><span class="num">01</span><h3>Pay-as-you-go model</h3><p>Only pay for the support you use. No bloated retainers, no surprise invoices.</p></div>
			<div class="feature reveal delay-1"><span class="num">02</span><h3>Response times that matter</h3><p>Critical issues get critical attention. Our SLAs are real, not marketing copy.</p></div>
			<div class="feature reveal delay-2"><span class="num">03</span><h3>Vendor-agnostic advice</h3><p>We recommend what's right for you, not what pays us the highest margin.</p></div>
			<div class="feature reveal delay-3"><span class="num">04</span><h3>Senior engineers</h3><p>When you call, you reach someone who can actually solve your problem — not a script-reader.</p></div>
		</div>
	</div>
</section>

<!-- Stats (Customizer) -->
<section class="stats-section">
	<div class="container">
		<div class="section-head reveal" style="margin-bottom:40px;">
			<h2><?php printf( esc_html__( '%s years in business. A lot of work behind us.', 'syseze' ), esc_html( syseze_mod( 'syseze_stat_years', '6+' ) ) ); ?></h2>
		</div>
		<div class="stats">
			<?php
			$stats = array(
				array( syseze_mod( 'syseze_stat_years',      '6+' ),  __( 'Years in business', 'syseze' ) ),
				array( syseze_mod( 'syseze_stat_projects',   '100+' ), __( 'Projects delivered', 'syseze' ) ),
				array( syseze_mod( 'syseze_stat_industries', '12+' ), __( 'Industries served', 'syseze' ) ),
				array( syseze_mod( 'syseze_stat_retention',  '95%' ), __( 'Client retention', 'syseze' ) ),
			);
			foreach ( $stats as $i => $s ) {
				printf( '<div class="stat reveal%s"><div class="stat-num">%s</div><div class="stat-label">%s</div></div>',
					$i ? ' delay-' . $i : '', esc_html( $s[0] ), esc_html( $s[1] ) );
			}
			?>
		</div>
	</div>
</section>

<?php syseze_cta_banner( 'Ready to work with a team that gets it?', 'Book a free IT audit — no strings, no sales pressure. Just a clear look at where you are and what\'s possible.', 'Contact Us' ); ?>

<?php get_footer(); ?>
