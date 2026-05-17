<?php
/**
 * Archive — Portfolio (post type archive at /portfolio/).
 * Falls back to this if the user doesn't assign the "Portfolio" page template.
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
			<?php if ( have_posts() ) : $i = 0; while ( have_posts() ) : the_post();
				$terms = wp_get_post_terms( get_the_ID(), 'portfolio_category', array( 'fields' => 'slugs' ) );
				$cat_slug = implode( ' ', $terms );
				$first_term = ! empty( $terms ) ? get_term_by( 'slug', $terms[0], 'portfolio_category' ) : null;
				$cat_label  = $first_term ? $first_term->name : '';
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
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 26, '…' ) ); ?></p>
						<a href="<?php the_permalink(); ?>" class="btn-link">Read case study <?php echo $arrow; ?></a>
					</div>
				</article>
			<?php $i++; endwhile; else: ?>
				<p class="lead" style="grid-column: 1 / -1; text-align:center;">No case studies published yet.</p>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php syseze_cta_banner(); ?>

<?php get_footer(); ?>
