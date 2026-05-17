<?php
/**
 * Main index fallback. WordPress requires this file.
 * Used when no more specific template matches.
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
		<?php if ( is_archive() ) : ?>
			<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><?php echo esc_html( get_the_archive_title() ); ?></div>
		<?php endif; ?>
		<h1 class="reveal delay-1"><?php
			if ( is_archive() ) {
				the_archive_title();
			} elseif ( is_search() ) {
				/* translators: %s search query */
				printf( esc_html__( 'Search: %s', 'syseze' ), '<span class="gradient-text">' . esc_html( get_search_query() ) . '</span>' );
			} else {
				bloginfo( 'name' );
			}
		?></h1>
		<?php if ( is_archive() && get_the_archive_description() ) : ?>
			<p class="lead reveal delay-2"><?php echo wp_kses_post( get_the_archive_description() ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="portfolio-grid">
				<?php $i = 0; while ( have_posts() ) : the_post(); $delay = $i % 3 ? ' delay-' . ( $i % 3 ) : ''; ?>
					<article class="portfolio-card reveal<?php echo esc_attr( $delay ); ?>">
						<div class="portfolio-thumb">
							<span class="tag"><?php echo esc_html( get_post_type() === 'post' ? get_the_date() : get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'syseze-card', array( 'style' => 'width:100%;height:100%;object-fit:cover;position:absolute;inset:0;' ) ); ?>
							<?php else : ?>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
							<?php endif; ?>
						</div>
						<div class="portfolio-body">
							<h3><?php the_title(); ?></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '…' ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="btn-link">Read more <?php echo $arrow; ?></a>
						</div>
					</article>
				<?php $i++; endwhile; ?>
			</div>

			<nav class="filter-bar" style="margin-top:40px;justify-content:center;">
				<?php
				$pag = paginate_links( array( 'type' => 'array', 'prev_text' => '←', 'next_text' => '→' ) );
				if ( $pag ) { foreach ( $pag as $link ) { echo $link; } }
				?>
			</nav>
		<?php else : ?>
			<div class="section-head reveal">
				<h2>Nothing here.</h2>
				<p>Try the search, or head back to the <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:var(--accent-cyan);text-decoration:underline;">homepage</a>.</p>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
