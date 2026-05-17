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
				<div class="image-placeholder reveal delay-1">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
					<span class="lbl"><?php esc_html_e( 'Set a Featured Image to replace', 'syseze' ); ?></span>
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
			<h2><?php esc_html_e( 'Six years. A lot of work behind us.', 'syseze' ); ?></h2>
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

<!-- Team — dynamic, falls back to placeholders -->
<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow"><?php esc_html_e( 'The team', 'syseze' ); ?></span>
			<h2><?php esc_html_e( 'The people behind SysEze', 'syseze' ); ?></h2>
			<p><?php esc_html_e( 'A lean team of senior engineers, consultants, and support specialists — handpicked for both depth and discipline.', 'syseze' ); ?></p>
		</div>
		<div class="team-grid">
			<?php
			$team = new WP_Query( array( 'post_type' => 'team', 'posts_per_page' => 6, 'orderby' => 'menu_order date', 'order' => 'ASC' ) );
			if ( $team->have_posts() ) :
				$i = 0;
				while ( $team->have_posts() ) : $team->the_post();
					$role = get_post_meta( get_the_ID(), '_syseze_role', true );
					$parts = preg_split( '/\s+/', trim( get_the_title() ) );
					$initials = ''; foreach ( $parts as $p ) { $initials .= strtoupper( substr( $p, 0, 1 ) ); }
					$initials = substr( $initials, 0, 2 );
					$delay = $i ? ' delay-' . ( $i % 3 ) : '';
					?>
					<div class="team-card reveal<?php echo esc_attr( $delay ); ?>">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="team-avatar" style="background:transparent; overflow:hidden;"><?php the_post_thumbnail( 'thumbnail', array( 'style' => 'width:100%;height:100%;object-fit:cover;border-radius:50%;' ) ); ?></div>
						<?php else : ?>
							<div class="team-avatar"><?php echo esc_html( $initials ); ?></div>
						<?php endif; ?>
						<h3><?php the_title(); ?></h3>
						<?php if ( $role ) : ?><div class="role"><?php echo esc_html( $role ); ?></div><?php endif; ?>
						<p><?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?></p>
					</div>
				<?php $i++; endwhile; wp_reset_postdata();
			else :
				$ph = array(
					array( 'AR', 'Aravind Raj R', 'Founder & Principal Engineer', 'Twelve years across infrastructure, cloud, and security. Believes in fewer meetings and clearer diagrams.' ),
					array( 'PS', 'Priya Suresh',  'Head of Cloud Practice',       'AWS & Azure certified. Has led migrations for healthcare, fintech, and logistics clients across South India.' ),
					array( 'VK', 'Vikram K.',     'Security & Compliance Lead',   'ISO 27001 lead auditor. Spends most days thinking about how to break things — so attackers can\'t.' ),
				);
				foreach ( $ph as $i => $p ) {
					$delay = $i ? ' delay-' . $i : '';
					printf( '<div class="team-card reveal%s"><div class="team-avatar">%s</div><h3>%s</h3><div class="role">%s</div><p>%s</p></div>',
						$delay, esc_html( $p[0] ), esc_html( $p[1] ), esc_html( $p[2] ), esc_html( $p[3] ) );
				}
			endif;
			?>
		</div>
	</div>
</section>

<?php syseze_cta_banner( 'Ready to work with a team that gets it?', 'Book a free IT audit — no strings, no sales pressure. Just a clear look at where you are and what\'s possible.', 'Book a Free IT Audit' ); ?>

<?php get_footer(); ?>
