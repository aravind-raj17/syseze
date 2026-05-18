<?php
/**
 * Blog index — used by WordPress when a page is set as Posts Page
 * under Settings > Reading. Mirrors template-blog.php layout.
 *
 * @package SysEze
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
$arrow = syseze_arrow();

$paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
$q = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => 7,
	'paged'          => $paged,
) );
?>

<section class="page-hero">
	<?php syseze_orbs(); ?>
	<div class="container" style="position:relative;z-index:2;">
		<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span>Blog</div>
		<span class="eyebrow reveal">Insights &amp; updates</span>
		<h1 class="reveal delay-1">Field notes from the<br/><span class="gradient-text">SysEze engineering team.</span></h1>
		<p class="lead reveal delay-2">Practical writing on cloud, security, networking and IT strategy — written by the engineers actually doing the work.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<?php if ( $q->have_posts() ) : $first = true; $grid_open = false; ?>
			<?php while ( $q->have_posts() ) : $q->the_post();
				$cats     = get_the_category();
				$cat_name = ! empty( $cats ) ? $cats[0]->name : 'Article';
				if ( $first ) : ?>
					<article class="blog-featured reveal">
						<div>
							<span class="feat-tag">Featured · <?php echo esc_html( $cat_name ); ?></span>
							<div class="meta" style="font-family:var(--font-mono);font-size:11px;letter-spacing:0.14em;text-transform:uppercase;color:var(--text-dim);margin-bottom:10px;"><?php echo esc_html( get_the_date() ); ?></div>
							<h3><?php the_title(); ?></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 32, '…' ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="btn-link">Read the full piece <?php echo $arrow; ?></a>
						</div>
						<div class="thumb" style="overflow:hidden;">
							<?php
							$_cover = get_post_meta( get_the_ID(), '_syseze_cover_url', true );
							if ( has_post_thumbnail() ) :
								the_post_thumbnail( 'syseze-featured', array( 'style' => 'width:100%;height:100%;object-fit:cover;border-radius:var(--radius);' ) );
							elseif ( $_cover ) : ?>
								<img src="<?php echo esc_url( $_cover ); ?>" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:var(--radius);" />
							<?php else : ?>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>
							<?php endif; ?>
						</div>
					</article>
				<?php else :
					if ( ! $grid_open ) { echo '<div class="blog-grid">'; $grid_open = true; $i = 0; }
					$delay = $i % 3 ? ' delay-' . ( $i % 3 ) : '';
					?>
					<article class="portfolio-card reveal<?php echo esc_attr( $delay ); ?>">
						<div class="portfolio-thumb">
							<span class="tag"><?php echo esc_html( $cat_name ); ?></span>
							<?php
							$_cover = get_post_meta( get_the_ID(), '_syseze_cover_url', true );
							if ( has_post_thumbnail() ) :
								the_post_thumbnail( 'syseze-card', array( 'style' => 'width:100%;height:100%;object-fit:cover;position:absolute;inset:0;' ) );
							elseif ( $_cover ) : ?>
								<img src="<?php echo esc_url( $_cover ); ?>" alt="" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;" />
							<?php else : ?>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
							<?php endif; ?>
						</div>
						<div class="portfolio-body">
							<div class="meta"><?php echo esc_html( get_the_date() ); ?></div>
							<h3><?php the_title(); ?></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24, '…' ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="btn-link">Read more <?php echo $arrow; ?></a>
						</div>
					</article>
				<?php $i++; endif; $first = false; endwhile; ?>
			<?php if ( $grid_open ) { echo '</div>'; } ?>

			<?php
			$big        = 999999999;
			$pagination = paginate_links( array(
				'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'  => '?paged=%#%',
				'current' => $paged,
				'total'   => $q->max_num_pages,
				'type'    => 'array',
			) );
			if ( $pagination ) :
				echo '<nav class="filter-bar" style="margin-top:40px;justify-content:center;">';
				foreach ( $pagination as $link ) { echo $link; }
				echo '</nav>';
			endif;
			wp_reset_postdata();
			?>
		<?php else : ?>
			<div class="section-head reveal">
				<h2>No posts yet</h2>
				<p>Check back soon — articles are on the way.</p>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php syseze_cta_banner( 'Want this in your inbox?', 'Occasional, no-fluff writing on cloud, security, and IT strategy. One email a month, max.', 'Get in touch' ); ?>

<?php get_footer(); ?>
