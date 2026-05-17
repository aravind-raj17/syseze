<?php
/**
 * Single Portfolio (case study).
 *
 * @package SysEze
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
$arrow = syseze_arrow();
?>

<section class="page-hero" style="padding-bottom:40px;">
	<?php syseze_orbs(); ?>
	<div class="container" style="position:relative;z-index:2;">
		<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><a href="<?php echo esc_url( syseze_page_url( 'portfolio' ) ); ?>">Portfolio</a><span class="sep">/</span><?php the_title(); ?></div>
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				$industry = get_post_meta( get_the_ID(), '_syseze_industry', true );
				$year     = get_post_meta( get_the_ID(), '_syseze_year', true );
				$meta = trim( $industry . ( $industry && $year ? ' · ' : '' ) . $year );
				$terms = get_the_terms( get_the_ID(), 'portfolio_category' );
				$cat_name = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
		?>
		<?php if ( $cat_name ) : ?><span class="eyebrow reveal"><?php echo esc_html( $cat_name ); ?></span><?php endif; ?>
		<h1 class="reveal delay-1"><?php the_title(); ?></h1>
		<?php if ( $meta ) : ?><p class="lead reveal delay-2"><?php echo esc_html( $meta ); ?></p><?php endif; ?>
	</div>
</section>

<section class="section-tight">
	<div class="container" style="max-width:920px;">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="reveal" style="border-radius:var(--radius-lg);overflow:hidden;margin-bottom:48px;border:1px solid var(--border);">
				<?php the_post_thumbnail( 'syseze-featured', array( 'style' => 'width:100%;height:auto;display:block;' ) ); ?>
			</div>
		<?php endif; ?>

		<article class="reveal post-content" style="color:var(--text); font-size:1.05rem; line-height:1.8;">
			<?php the_content(); ?>
		</article>
	</div>
</section>
<?php endwhile; endif; ?>

<?php syseze_cta_banner( 'Want a similar outcome for your business?', 'Start with a free audit — we\'ll map your current state and the highest-impact moves in 30 minutes.', 'Book a Free IT Audit' ); ?>

<style>
.post-content h2, .post-content h3 { color: var(--text); margin: 1.8em 0 0.6em; }
.post-content p { color: var(--text-muted); margin-bottom: 1.4em; }
.post-content a { color: var(--accent-cyan); text-decoration: underline; }
.post-content ul, .post-content ol { color: var(--text-muted); padding-left: 24px; margin-bottom: 1.4em; }
.post-content li { margin-bottom: 8px; }
</style>

<?php get_footer(); ?>
