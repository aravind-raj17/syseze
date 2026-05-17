<?php
/**
 * Search results.
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
		<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span>Search</div>
		<span class="eyebrow reveal">Search results</span>
		<h1 class="reveal delay-1">Results for <span class="gradient-text">"<?php echo esc_html( get_search_query() ); ?>"</span></h1>
	</div>
</section>

<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="portfolio-grid">
				<?php $i = 0; while ( have_posts() ) : the_post(); $delay = $i % 3 ? ' delay-' . ( $i % 3 ) : ''; ?>
					<article class="portfolio-card reveal<?php echo esc_attr( $delay ); ?>">
						<div class="portfolio-thumb">
							<span class="tag"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
						</div>
						<div class="portfolio-body">
							<h3><?php the_title(); ?></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '…' ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="btn-link">Read <?php echo $arrow; ?></a>
						</div>
					</article>
				<?php $i++; endwhile; ?>
			</div>
		<?php else : ?>
			<div class="section-head reveal">
				<h2>No matches</h2>
				<p>Try different keywords, or browse our <a href="<?php echo esc_url( syseze_page_url( 'services' ) ); ?>" style="color:var(--accent-cyan);text-decoration:underline;">services</a> and <a href="<?php echo esc_url( syseze_page_url( 'portfolio' ) ); ?>" style="color:var(--accent-cyan);text-decoration:underline;">portfolio</a>.</p>
				<form role="search" method="get" style="max-width:480px;margin:32px auto 0;" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<div class="field"><input type="search" name="s" placeholder="Search again…" value="<?php echo esc_attr( get_search_query() ); ?>" /></div>
				</form>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
