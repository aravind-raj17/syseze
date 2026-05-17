<?php
/**
 * Template Name: Portfolio
 *
 * Pulls case studies from the `portfolio` CPT, filterable by `portfolio_category`.
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
		<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span>Portfolio</div>
		<span class="eyebrow reveal">Selected work</span>
		<h1 class="reveal delay-1">Real engagements.<br/><span class="gradient-text">Real outcomes.</span></h1>
		<p class="lead reveal delay-2">A snapshot of the work we've shipped — anonymised where required, real numbers where we can share them.</p>
	</div>
</section>

<section class="section">
	<div class="container">

		<?php
		$cats = get_terms( array( 'taxonomy' => 'portfolio_category', 'hide_empty' => true ) );
		if ( ! is_wp_error( $cats ) && ! empty( $cats ) ) :
		?>
			<div class="filter-bar reveal">
				<button class="filter-btn active" data-filter="all">All work</button>
				<?php foreach ( $cats as $cat ) : ?>
					<button class="filter-btn" data-filter="<?php echo esc_attr( $cat->slug ); ?>"><?php echo esc_html( $cat->name ); ?></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="portfolio-grid">
			<?php
			$cases = new WP_Query( array( 'post_type' => 'portfolio', 'posts_per_page' => 24 ) );
			if ( $cases->have_posts() ) :
				$i = 0;
				while ( $cases->have_posts() ) : $cases->the_post();
					$terms = wp_get_post_terms( get_the_ID(), 'portfolio_category', array( 'fields' => 'slugs' ) );
					$cat_slug = implode( ' ', $terms );
					$cat_label = '';
					$first_term = ! empty( $terms ) ? get_term_by( 'slug', $terms[0], 'portfolio_category' ) : null;
					if ( $first_term ) { $cat_label = $first_term->name; }
					$industry = get_post_meta( get_the_ID(), '_syseze_industry', true );
					$year     = get_post_meta( get_the_ID(), '_syseze_year', true );
					$meta = trim( $industry . ( $industry && $year ? ' · ' : '' ) . $year );
					$delay = $i % 3 ? ' delay-' . ( $i % 3 ) : '';
					?>
					<article class="portfolio-card reveal<?php echo esc_attr( $delay ); ?>" data-category="<?php echo esc_attr( $cat_slug ); ?>">
						<div class="portfolio-thumb">
							<?php if ( $cat_label ) : ?><span class="tag"><?php echo esc_html( $cat_label ); ?></span><?php endif; ?>
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'syseze-card', array( 'style' => 'width:100%;height:100%;object-fit:cover;position:absolute;inset:0;' ) ); ?>
							<?php else : ?>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
							<?php endif; ?>
						</div>
						<div class="portfolio-body">
							<?php if ( $meta ) : ?><div class="meta"><?php echo esc_html( $meta ); ?></div><?php endif; ?>
							<h3><?php the_title(); ?></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28, '…' ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="btn-link">Read case study <?php echo $arrow; ?></a>
						</div>
					</article>
				<?php $i++; endwhile; wp_reset_postdata();
			else :
				/* Placeholders — visible until you publish Portfolio entries in WP admin. */
				$placeholders = array(
					array( 'cloud',    'Cloud',    'Healthcare · 2024', 'Multi-region AWS migration for a hospital network', 'Migrated 40+ workloads to AWS across two regions with zero downtime, cutting infra spend by 32% in the first quarter.' ),
					array( 'security', 'Security', 'Fintech · 2024',    'ISO 27001 readiness in 90 days', 'Stood up a complete ISMS — controls, policies, evidence — and walked a 60-person fintech through their first audit cleanly.' ),
					array( 'network',  'Network',  'Manufacturing · 2023', 'SD-WAN rollout across 7 plant sites', 'Replaced ageing MPLS with SD-WAN — better resilience, half the cost, and a 4x improvement in inter-site throughput.' ),
					array( 'cloud',    'Cloud',    'E-commerce · 2024', 'Black Friday-ready autoscaling on Azure', 'Re-architected a monolith for elastic scaling. Held up to 11x peak traffic with no human intervention.' ),
					array( 'migration','Migration','Education · 2023',  'Google Workspace migration for 4,200 users', 'Migrated 4,200 mailboxes across 11 campuses over four weekends. Zero data loss, zero rollbacks.' ),
					array( 'support',  'Support',  'Logistics · 2024',  '24/7 managed IT for an asset-heavy fleet', 'Replaced an unresponsive MSP. SLA-backed support across 3 hubs and 2 warehouses, half the previous monthly spend.' ),
				);
				foreach ( $placeholders as $i => $p ) {
					$delay = $i % 3 ? ' delay-' . ( $i % 3 ) : '';
					printf(
						'<article class="portfolio-card reveal%s" data-category="%s"><div class="portfolio-thumb"><span class="tag">%s</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg></div><div class="portfolio-body"><div class="meta">%s</div><h3>%s</h3><p>%s</p><a href="#" class="btn-link">Read case study %s</a></div></article>',
						$delay, esc_attr( $p[0] ), esc_html( $p[1] ), esc_html( $p[2] ), esc_html( $p[3] ), esc_html( $p[4] ), $arrow
					);
				}
			endif;
			?>
		</div>
	</div>
</section>

<?php syseze_cta_banner( 'Like what you see? Let\'s build the next one with you.', 'Start with a free audit — we\'ll surface the highest-impact moves for your business in 30 minutes.', 'Contact Us' ); ?>

<?php get_footer(); ?>
