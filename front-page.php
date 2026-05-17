<?php
/**
 * Front page (homepage).
 *
 * @package SysEze
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$arrow = syseze_arrow();
?>

<!-- HERO -->
<section class="hero">
	<?php syseze_orbs(); ?>
	<div class="container hero-inner">
		<div class="hero-copy">
			<span class="eyebrow reveal"><?php esc_html_e( 'IT Infrastructure · Cloud · Security', 'syseze' ); ?></span>
			<h1 class="reveal delay-1"><?php esc_html_e( 'Empowering Systems.', 'syseze' ); ?><br/><span class="gradient-text"><?php esc_html_e( 'Simplifying Success.', 'syseze' ); ?></span></h1>
			<p class="lead reveal delay-2"><?php esc_html_e( 'End-to-end IT infrastructure, cloud, and cybersecurity solutions for businesses ready to scale.', 'syseze' ); ?></p>
			<div class="hero-ctas reveal delay-3">
				<a href="<?php echo esc_url( syseze_page_url( 'contact' ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Book a Free IT Audit', 'syseze' ); ?> <?php echo $arrow; // phpcs:ignore ?></a>
				<a href="<?php echo esc_url( syseze_page_url( 'services' ) ); ?>" class="btn btn-ghost"><?php esc_html_e( 'Explore Services', 'syseze' ); ?></a>
			</div>
		</div>

		<div class="hero-visual reveal delay-2">
			<div class="terminal" role="img" aria-label="<?php esc_attr_e( 'Terminal preview showing an IT audit run', 'syseze' ); ?>">
				<div class="terminal-bar">
					<span class="dot r"></span><span class="dot y"></span><span class="dot g"></span>
					<span class="title">~/syseze — audit</span>
				</div>
				<div class="terminal-body">
					<div><span class="prompt">$</span> syseze audit --target production</div>
					<div class="comment"># scanning infrastructure...</div>
					<div><span class="ok">✓</span> Cloud posture <span class="key">AWS</span> · <span class="key">Azure</span> · <span class="key">GCP</span></div>
					<div><span class="ok">✓</span> Network topology mapped <span class="comment">// 247 endpoints</span></div>
					<div><span class="ok">✓</span> Backup &amp; DR validated</div>
					<div><span class="warn">!</span> 3 high-impact security gaps <span class="comment">// remediation plan ready</span></div>
					<div><span class="ok">✓</span> Cost optimization: <span class="str">"₹4.2L / yr"</span> recoverable</div>
					<div class="comment"># audit complete in 38s</div>
					<div><span class="prompt">$</span> <span class="cursor"></span></div>
				</div>
			</div>
			<div class="hero-badge b1" aria-hidden="true">
				<span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
				<span><strong>99.9% uptime</strong><span>across managed clients</span></span>
			</div>
			<div class="hero-badge b2" aria-hidden="true">
				<span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="13 17 18 12 13 7"/><polyline points="6 17 11 12 6 7"/></svg></span>
				<span><strong>&lt; 15 min response</strong><span>SLA-backed</span></span>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="trust reveal delay-4">
			<div class="trust-label"><?php esc_html_e( 'Trusted by businesses across India', 'syseze' ); ?></div>
			<div class="trust-logos">
				<!--
				  Drop real logos as PNGs at: wp-content/themes/syseze/assets/images/clients/{slug}.png
				  (transparent bg, ~200px tall). If a file is missing, the text wordmark stays visible.
				-->
				<?php
				$clients = array(
					array( 'cmart-solutions',  'CMart Solutions',  'https://cmartsolutions.com/' ),
					array( 'natural-remedies', 'Natural Remedies', 'https://www.naturalremedy.com/' ),
					array( 'silicon-patterns', 'Silicon Patterns', 'https://siliconpatterns.com/' ),
					array( 'justo-global',     'Justo Global',     'https://justoglobal.com/' ),
					array( 'cynlr',            'CynLr',            'https://www.cynlr.com/' ),
				);
				foreach ( $clients as $c ) {
					$img_url = get_template_directory_uri() . '/assets/images/clients/' . $c[0] . '.png';
					printf(
						'<a class="tl" href="%1$s" target="_blank" rel="noopener" aria-label="%2$s"><img src="%3$s" alt="%2$s" onerror="this.style.display=\'none\'; this.nextElementSibling.style.display=\'inline-flex\';" /><span class="tl-text" style="display:none;"><span class="mark"></span>%2$s</span></a>',
						esc_url( $c[2] ),
						esc_attr( $c[1] ),
						esc_url( $img_url )
					);
				}
				?>
			</div>
		</div>
	</div>
</section>

<!-- STATS -->
<section class="stats-section">
	<div class="container">
		<div class="stats">
			<?php
			$stats = array(
				array( syseze_mod( 'syseze_stat_years',      '6+' ),  __( 'Years in business', 'syseze' ) ),
				array( syseze_mod( 'syseze_stat_projects',   '100+' ), __( 'Projects delivered', 'syseze' ) ),
				array( syseze_mod( 'syseze_stat_industries', '12+' ), __( 'Industries served', 'syseze' ) ),
				array( syseze_mod( 'syseze_stat_retention',  '95%' ), __( 'Client retention', 'syseze' ) ),
			);
			foreach ( $stats as $i => $s ) {
				printf(
					'<div class="stat reveal%s"><div class="stat-num">%s</div><div class="stat-label">%s</div></div>',
					$i ? ' delay-' . $i : '',
					esc_html( $s[0] ),
					esc_html( $s[1] )
				);
			}
			?>
		</div>
	</div>
</section>

<!-- SERVICES GRID -->
<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow"><?php esc_html_e( 'What we do', 'syseze' ); ?></span>
			<h2><?php esc_html_e( 'Services that scale with you', 'syseze' ); ?></h2>
			<p><?php esc_html_e( 'Six tightly-scoped practices, one accountable partner. From a single cloud workload to a full-stack transformation, we meet you where you are.', 'syseze' ); ?></p>
		</div>

		<div class="card-grid">
			<?php
			$svcs = array(
				array( 'cloud-services',      'Cloud Services',     'Seamless multi-cloud integration across AWS, Azure and GCP — provisioned, secured, and optimized for cost.', '<path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/>' ),
				array( 'it-consulting',       'IT Consulting',      'Strategic technology roadmaps that align infrastructure investment with where the business is actually heading.', '<path d="M12 2 2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>' ),
				array( 'migration-services',  'Migration Services', 'Zero-downtime moves between data centres, clouds, or hybrid setups — planned, rehearsed, and reversible.', '<polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/><polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/><line x1="4" y1="4" x2="9" y2="9"/>' ),
				array( 'network-design',      'Network Design',     'Future-proof network architecture — segmented, observable, and ready for the bandwidth you\'ll need next year.', '<circle cx="12" cy="12" r="3"/><circle cx="4" cy="4" r="2"/><circle cx="20" cy="4" r="2"/><circle cx="4" cy="20" r="2"/><circle cx="20" cy="20" r="2"/><line x1="6" y1="6" x2="10" y2="10"/><line x1="18" y1="6" x2="14" y2="10"/><line x1="6" y1="18" x2="10" y2="14"/><line x1="18" y1="18" x2="14" y2="14"/>' ),
				array( 'cyber-security',      'Cyber Security',     'End-to-end threat protection, compliance hardening, and incident response — without the enterprise overhead.', '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>' ),
				array( 'business-support',    'Business Support',   '24/7 managed IT support on a pay-as-you-go model. Real engineers, real fixes, no bloated retainers.', '<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>' ),
			);
			foreach ( $svcs as $i => $svc ) {
				$delay = $i ? ' delay-' . $i : '';
				printf(
					'<a class="card reveal%s" href="%s"><div class="card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">%s</svg></div><h3>%s</h3><p>%s</p><span class="btn-link">Learn more %s</span></a>',
					$delay,
					esc_url( syseze_page_url( $svc[0] ) ),
					$svc[3], // SVG paths.
					esc_html( $svc[1] ),
					esc_html( $svc[2] ),
					$arrow
				);
			}
			?>
		</div>
	</div>
</section>

<!-- WHY -->
<section class="section" style="background: linear-gradient(180deg, transparent, rgba(17,24,39,0.4) 50%, transparent);">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow"><?php esc_html_e( 'Why SysEze', 'syseze' ); ?></span>
			<h2><?php esc_html_e( 'Why businesses choose SysEze', 'syseze' ); ?></h2>
			<p><?php esc_html_e( 'Big-firm capability without the big-firm bill. Here\'s what changes the day we start working together.', 'syseze' ); ?></p>
		</div>
		<div class="feature-row">
			<div class="feature reveal"><span class="num">01 · Economics</span><h3>Cost-optimized support</h3><p>Lower your IT support overhead without sacrificing quality. We rightsize licenses, rewire workflows, and pass the savings on — usually within the first quarter.</p></div>
			<div class="feature reveal delay-1"><span class="num">02 · Flexibility</span><h3>Pay-as-you-go model</h3><p>Only pay for what you use. No bloated retainers, no shelfware. Scale support up during a launch and back down again the next month — no renegotiation needed.</p></div>
			<div class="feature reveal delay-2"><span class="num">03 · Velocity</span><h3>Rapid response team</h3><p>Engineers on standby with a 15-minute SLA. When something breaks, you reach a human who knows your stack — not a ticket queue in a different timezone.</p></div>
		</div>
	</div>
</section>

<!-- PROCESS -->
<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow"><?php esc_html_e( 'How we engage', 'syseze' ); ?></span>
			<h2><?php esc_html_e( 'A process built for outcomes, not invoices', 'syseze' ); ?></h2>
			<p><?php esc_html_e( 'Four steps from first conversation to long-term partnership. No surprise scope, no theatre.', 'syseze' ); ?></p>
		</div>
		<div class="timeline">
			<?php
			$steps = array(
				array( 'Discover', 'We audit your current infrastructure end-to-end and surface the gaps and quick wins.' ),
				array( 'Design',   'We architect the right solution for your stack, your team, and your budget reality.' ),
				array( 'Deploy',   'We implement in tested phases with zero disruption to the business that\'s still running.' ),
				array( 'Support',  'We stay with you for the long run — monitoring, tuning, and growing the system as you do.' ),
			);
			foreach ( $steps as $i => $st ) {
				$delay = $i ? ' delay-' . $i : '';
				printf(
					'<div class="step reveal%s"><div class="ring">%02d</div><h3>%s</h3><p>%s</p></div>',
					$delay,
					$i + 1,
					esc_html( $st[0] ),
					esc_html( $st[1] )
				);
			}
			?>
		</div>
	</div>
</section>

<!-- TESTIMONIALS — dynamic, falls back to placeholders if no testimonials posted -->
<section class="section" style="background: linear-gradient(180deg, transparent, rgba(17,24,39,0.4) 50%, transparent);">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow"><?php esc_html_e( 'What clients say', 'syseze' ); ?></span>
			<h2><?php esc_html_e( 'Trusted with the things that can\'t go down', 'syseze' ); ?></h2>
		</div>
		<div class="testimonials">
			<?php
			$ts = new WP_Query( array(
				'post_type'      => 'testimonial',
				'posts_per_page' => 3,
				'orderby'        => 'menu_order date',
				'order'          => 'ASC',
			) );
			if ( $ts->have_posts() ) :
				$idx = 0;
				while ( $ts->have_posts() ) : $ts->the_post();
					$role    = get_post_meta( get_the_ID(), '_syseze_author_role', true );
					$company = get_post_meta( get_the_ID(), '_syseze_author_company', true );
					$initials = '';
					$parts    = preg_split( '/\s+/', trim( get_the_title() ) );
					foreach ( $parts as $p ) { $initials .= strtoupper( substr( $p, 0, 1 ) ); }
					$initials = substr( $initials, 0, 2 );
					$delay = $idx ? ' delay-' . $idx : '';
					?>
					<div class="quote-card reveal<?php echo esc_attr( $delay ); ?>">
						<div class="mark">"</div>
						<blockquote><?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?></blockquote>
						<div class="author">
							<div class="avatar"><?php echo esc_html( $initials ); ?></div>
							<div><strong><?php the_title(); ?></strong><span><?php echo esc_html( trim( $role . ( $role && $company ? ', ' : '' ) . $company ) ); ?></span></div>
						</div>
					</div>
				<?php
				$idx++;
				endwhile;
				wp_reset_postdata();
			else :
				$placeholders = array(
					array( 'RM', 'Ramya Menon',  'CTO, Helix Health',  'SysEze moved our entire production stack to AWS over two weekends without a single customer-facing incident. We\'ve never had that kind of partner before.' ),
					array( 'AK', 'Arjun Kapoor', 'COO, Vexel Retail',  'The pay-as-you-go support model is exactly what a growing company needs. We get senior engineers on call without paying for a full-time team we don\'t need yet.' ),
					array( 'SN', 'Sneha Nair',   'Head of IT, Avani Finance', 'They found ₹6 lakhs of recoverable cloud spend in our first audit and re-architected our backups so we can actually trust them.' ),
				);
				foreach ( $placeholders as $i => $p ) {
					$delay = $i ? ' delay-' . $i : '';
					printf(
						'<div class="quote-card reveal%s"><div class="mark">"</div><blockquote>%s</blockquote><div class="author"><div class="avatar">%s</div><div><strong>%s</strong><span>%s</span></div></div></div>',
						$delay,
						esc_html( $p[3] ),
						esc_html( $p[0] ),
						esc_html( $p[1] ),
						esc_html( $p[2] )
					);
				}
			endif;
			?>
		</div>
	</div>
</section>

<!-- FINAL CTA -->
<?php syseze_cta_banner( 'Ready to elevate your business?', 'Start with a free, no-obligation IT audit. We\'ll map your current state, surface the highest-impact improvements, and give you a written plan you can act on with or without us.', 'Book a Free IT Audit' ); ?>

<?php get_footer(); ?>
